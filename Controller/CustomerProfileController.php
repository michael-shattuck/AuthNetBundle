<?php

namespace Clamidity\AuthNetBundle\Controller;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Clamidity\AuthNetBundle\Entity\CustomerProfile;
use Clamidity\AuthNetBundle\Form\CustomerProfileIndividualType;
use Clamidity\AuthNetBundle\Form\CustomerProfileTransactionType;
use Clamidity\AuthNetBundle\Form\ShippingAddressType;
use Clamidity\AuthNetBundle\Event\CustomerAddressEvent;
use Clamidity\AuthNetBundle\Event\CustomerPaymentProfileEvent;
use Clamidity\AuthNetBundle\Event\CustomerTransactionEvent;
use Clamidity\AuthNetBundle\Entities;

class CustomerProfileController extends AuthNetBaseController
{
    protected $CIMManager;
    protected $authNetManager;

    public function indexAction()
    {
        $profileIdArray = $this->getCustomerProfileManager()->findAll();

        return $this->container->get('templating')->renderResponse(
            Entities::CUSTOMER_PROFILE_CLASS.':index.html.twig', array(
                'customerProfiles' => $profileIdArray,
            )
        );
    }

    public function viewAction($id)
    {
        $customerProfile = $this->getCustomerProfileManager()->findOr404($id);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render(
            Entities::CUSTOMER_PROFILE_CLASS.':view.html.twig',
            array(
                'customerProfile' => $customerProfile,
                'deleteForm'      => $deleteForm->createView()
            )
        );
    }

    public function newIndividualAction()
    {
        $form = $this->createForm($this->container->get('clamidity_authnet.customerprofile_individual.form'));

        return $this->render(
            Entities::CUSTOMER_PROFILE_CLASS.':newIndividual.html.twig',
            array(
                'form' => $form->createView(),
            )
        );
    }

    public function postIndividualAction()
    {
        $request = $this->getRequest();

        $form = $this->createForm($this->container->get('clamidity_authnet.customerprofile_individual.form'));
        $form->bindRequest($request);

        if ($form->isValid()) {
            $customerProfileArray = $request->get('clamidity_authnetbundle_customerprofileindividualtype');
            $customerProfile = $this->getCustomerProfileObject();
            $customerProfile->description = $customerProfileArray['customerdescription'];
            $customerProfile->email = $customerProfileArray['email'];
            $customerProfile->merchantCustomerId = time(); /** @todo: add support for merchant customer id*/

            $customerProfileId = $this->getCIMManager()->postCustomerProfile($customerProfile);

            if ($customerProfileId) {
                $customerProfileEntity = $this->getCustomerProfileManager()->createCustomerProfile();
                $customerProfileEntity->setProfileId($customerProfileId);

                $this->getCustomerProfileManager()->saveCustomerProfile($customerProfileEntity);

                if ($customerProfileArray['paymentprofile']) {
                    $this->addCardPaymentProfile($customerProfileEntity, $customerProfileArray['paymentprofile']);
                }

                if (
                    $customerProfileArray['paymentprofile'] && 
                    isset($customerProfileArray['paymentprofile']['sameAsShipping']) && 
                    1 == $customerProfileArray['paymentprofile']['sameAsShipping']
                ) {
                    $this->addShippingAddress($customerProfileEntity, $customerProfileArray['paymentprofile']['billingaddress']);
                } else {
                    $uri = $this->generateUrl(
                        'clamidity_authnet_customerprofile_addshippingaddress',
                        array(
                            'id' => $customerProfileEntity->getId()
                        )
                    );

                    return new RedirectResponse($uri);
                }
            }

            $uri = $this->generateUrl('clamidity_authnet_customerprofile_index');

            return new RedirectResponse($uri);
        }

        return $this->render(
            Entities::CUSTOMER_PROFILE_CLASS.':newIndividual.html.twig',
            array(
                'form' => $form->createView(),
            )
        );
    }

    public function addShippingAddressAction($id)
    {
        $form = $this->createForm(new ShippingAddressType);

        return $this->render(
            Entities::CUSTOMER_PROFILE_CLASS.':addShippingAddress.html.twig',
            array(
                'form' => $form->createView(),
                'profileID' => $id
            )
        );
        
    }

    public function postShippingAddressAction($id)
    {
        $request = $this->getRequest();

        $form = $this->createForm(new ShippingAddressType);
        $form->bindRequest($request);

        if ($form->isValid()) {
            $addressArray = $request->get('clamidity_authnetbundle_customerprofileaddresstype');
            $customerProfile = $this->getCustomerProfileManager()->findOr404($id);
            $this->addShippingAddress($customerProfile, $addressArray);

            return new RedirectResponse($this->generateUrl('clamidity_authnet_customerprofile_index'));
        }

        return $this->render(
            Entities::CUSTOMER_PROFILE_CLASS.':addShippingAddress.html.twig', 
            array(
                'form' => $form->createView(),
                'profileID' => $id,
            )
        );
    }

    public function newTransactionAction($id)
    {
        $customerProfile = $this->getCustomerProfileManager()->findOr404($id);
        $form = $this->createForm(new CustomerProfileTransactionType($id));

        return $this->render(
            Entities::CUSTOMER_PROFILE_CLASS.':newTransaction.html.twig',
            array(
                'customerProfile' => $customerProfile,
                'form' => $form->createView()
            )
        );
    }

    public function postTransactionAction($id)
    {
        $request = $this->getRequest();

        $form = $this->createForm(new CustomerProfileTransactionType($id));
        $form->bindRequest($request);

        if ($form->isValid()) {
            $transaction = array();
            $transactionArray = $request->get('clamidity_authnetbundle_cimtransactiontype');

            $customerProfile = $this->getCustomerProfileManager()->findOr404($id);
            $lineItems = array($transactionArray['lineItem']);
            $amount = $transactionArray['lineItem']['unitPrice'] * $transactionArray['lineItem']['quantity'];

            $transaction['amount'] = $amount;
            $transaction['paymentProfileId'] = $this->getRepository('PaymentProfile')->find($transactionArray['paymentProfile'])->getPaymentProfileId();
            $transaction['shippingAddressId'] = $this->getRepository('ShippingAddress')->find($transactionArray['addressProfile'])->getShippingAddressId();
            $transaction['lineItems'] = $lineItems;

            $this->addTransaction($customerProfile, $transaction);

            $uri = $this->generateUrl(
                'clamidity_authnet_customerprofile_view',
                array(
                    'id' => $id
                )
            );

            return new RedirectResponse($uri);
        }

        return $this->render(
            Entities::CUSTOMER_PROFILE_CLASS.':newTransaction.html.twig',
            array(
                'customerProfile' => $customerProfile,
                'form' => $form->createView(),
            )
        );
    }

    public function deleteCustomerProfileAction($id)
    {
        $request = $this->getRequest();

        $form = $this->createDeleteForm($id);
        $form->bindRequest($request);

        if ($form->isValid()) {
            $customerProfile = $this->getCustomerProfileManager()->findOr404($id);
            if ($this->getCIMManager()->deleteCustomerProfile($customerProfile->getProfileId())) {
                $this->getCustomerProfileManager()->removeCustomerProfile($customerProfile);
            }
        }

        return new RedirectResponse($this->generateUrl('clamidity_authnet_customerprofile_index'));
    }

    private function addShippingAddress(CustomerProfile $customerProfile, array $addressArray)
    {
        $addressId = $this->getCIMManager()->addAddress($customerProfile->getProfileId(), $addressArray);
        $this->getCustomerProfileManager()->addShippingAddress($customerProfile, $addressId, $addressArray['address']);
    }

    private function addCardPaymentProfile(CustomerProfile $customerProfile, array $paymentProfileArray)
    {
        $paymentProfileId = $this->getCIMManager()->addPaymentProfileIndividual($customerProfile->getProfileId(), $paymentProfileArray);
        $cardNumber = 'XXXXXXXXXX'.substr($paymentProfileArray['cardnumber'], -4);
        $this->getCustomerProfileManager()->addCardPaymentProfile($customerProfile, $paymentProfileId, $cardNumber);
    }

    private function addTransaction(CustomerProfile $customerProfile, array $transaction)
    {
        $transactionId = $this->getCIMManager()->createNewTransaction(
                             $transaction['amount'], 
                             $customerProfile->getProfileId(), 
                             $transaction['lineItems'], 
                             $transaction['paymentProfileId'], 
                             $transaction['shippingAddressId']
                         );
        $this->getCustomerProfileManager()->addTransaction($customerProfile, $transactionId, $transaction['amount']);
    }

    private function updateCustomerProfile()
    {
        
    }

    private function updatePaymentProfile()
    {
        
    }

    private function updateShippingAddress()
    {
        
    }

    private function voidTransaction()
    {
        
    }

    private function removeShippingAddress()
    {
        
    }

    private function removePaymentProfile()
    {
        
    }

    private function getCustomerProfile()
    {
        
    }

    private function getCustomerProfileObject()
    {
        $customerProfile = $this->getAuthorizeNetManager()->newCustomer();
        return $customerProfile;
    }

    /**
        * @return \Clamidity\AuthNetBundle\Entity\CustomerProfileManager
        */
    protected function getCustomerProfileManager() {
        return $this->container->get('clamidity_authnet.customer.manager');
    }
}