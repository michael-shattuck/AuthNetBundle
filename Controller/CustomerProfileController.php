<?php

namespace Clamidity\AuthNetBundle\Controller;

use Symfony\Component\DependencyInjection\ContainerAware;
use Clamidity\AuthNetBundle\Entity\CustomerProfile;
use Clamidity\AuthNetBundle\Form\CustomerProfileIndividualType;
use Clamidity\AuthNetBundle\Form\CustomerProfileTransactionType;
use Clamidity\AuthNetBundle\Form\ShippingAddressType;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Clamidity\AuthNetBundle\Event\CustomerAddressEvent;
use Clamidity\AuthNetBundle\Event\CustomerPaymentProfileEvent;

class CustomerProfileController extends ContainerAware
{
    protected $CIMManager;
    protected $authNetManager;

    public function indexAction()
    {
        $profileIdArray = $this->container->get('doctrine')->getRepository("ClamidityAuthNetBundle:CustomerProfile")->findAll();

        return $this->container->get('templating')->renderResponse(
            'ClamidityAuthNetBundle:CustomerProfile:index.html.twig', array(
                'ids' => $profileIdArray,
            )
        );
    }

    public function newIndividualAction()
    {
        $form = $this->container->get('form.factory')->create(new CustomerProfileIndividualType());

        return $this->container->get('templating')->renderResponse(
            'ClamidityAuthNetBundle:CustomerProfile:newIndividual.html.twig', array(
                'form' => $form->createView(),
            )
        );
    }

    public function postIndividualAction()
    {
        $request = $this->getRequest();
        $errors = null;

        $form = $this->getFormFactory()->create(new CustomerProfileIndividualType());
        $form->bindRequest($request);

        if ($form->isValid()) {
            $customerProfileArray = $request->get('clamidity_authnetbundle_customerprofileindividualtype');
            
            $customerProfile = $this->getCustomerProfileObject();
            $customerProfile->description = $customerProfileArray['customerdescription'];
            $customerProfile->email = $customerProfileArray['email'];
            $customerProfile->merchantCustomerId = time(); /** @todo: add support for merchant customer id*/

            $CIMManager = $this->getCIMManager();
            $customerProfileId = $CIMManager->postCustomerProfile($customerProfile);

            if ($customerProfileId) {
                $customerProfileEntity = new CustomerProfile();
                $customerProfileEntity->setProfileId($customerProfileId);

                $em = $this->getEntityManager();
                $em->persist($customerProfileEntity);
                $em->flush();

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
                    $uri = $this->container->get('router')->generate(
                        'clamidity_authnet_customerprofile_addshippingaddress',
                        array(
                            'id' => $customerProfileEntity->getId()
                        )
                    );

                    return new RedirectResponse($uri);
                }
            }

            $uri = $this->container->get('router')->generate(
                'clamidity_authnet_customerprofile_index'
            );

            return new RedirectResponse($uri);
        }

        if ($form->hasErrors() > 0) {
            $errors = $form->getErrors();
        }

        return $this->container->get('templating')->renderResponse(
            'ClamidityAuthNetBundle:CustomerProfile:newIndividual.html.twig', array(
                'form' => $form->createView(),
                'errors' => $errors,
            )
        );
    }

    public function addShippingAddressAction($id)
    {
        $form = $this->getFormFactory()->create(new ShippingAddressType);

        return $this->container->get('templating')->renderResponse(
            'ClamidityAuthNetBundle:CustomerProfile:addShippingAddress.html.twig', array(
                'form' => $form->createView(),
                'profileID' => $id
            )
        );
        
    }

    public function postShippingAddressAction($id)
    {
        $request = $this->getRequest();
        $errors = null;

        $form = $this->getFormFactory()->create(new ShippingAddressType);
        $form->bindRequest($request);

        if ($form->isValid()) {
            $addressArray = $request->get('clamidity_authnetbundle_customerprofileaddresstype');
            $customerProfile = $this->container->get('doctrine')->getRepository("ClamidityAuthNetBundle:CustomerProfile")->find($id);
            $this->addShippingAddress($customerProfile, $addressArray);

            $uri = $this->container->get('router')->generate(
                'clamidity_authnet_customerprofile_index'
            );

            return new RedirectResponse($uri);
        }

        if ($form->hasErrors() > 0) {
            $errors = $form->getErrors();
        }

        return $this->container->get('templating')->renderResponse(
            'ClamidityAuthNetBundle:CustomerProfile:addShippingAddress.html.twig', array(
                'form' => $form->createView(),
                'profileID' => $id,
                'errors' => $errors
            )
        );
    }

    public function newTransactionAction($id)
    {
        $customerProfile = $this->container->get('doctrine')->getRepository('ClamidityAuthNetBundle:CustomerProfile')->find($id);
        $form = $this->container->get('form.factory')->create(new CustomerProfileTransactionType($id));

        return $this->container->get('templating')->renderResponse(
            'ClamidityAuthNetBundle:CustomerProfile:newTransaction.html.twig', array(
                'customerProfile' => $customerProfile,
                'form' => $form->createView()
            )
        );
    }

    private function addShippingAddress(CustomerProfile $customerProfile, array $addressArray)
    {
        $addressId = $this->getCIMManager()->addAddress($customerProfile->getProfileId(), $addressArray);
        $this->container->get('event_dispatcher')->dispatch(
            'clamidity_authnet.customer.add_address', 
            new CustomerAddressEvent($customerProfile, $addressId, $addressArray['address'])
        );
    }

    private function addCardPaymentProfile(CustomerProfile $customerProfile, array $paymentProfileArray)
    {
        $paymentProfileId = $this->getCIMManager()->addPaymentProfileIndividual($customerProfile->getProfileId(), $paymentProfileArray);
        $cardNumber = 'XXXXXXXXXX'.substr($paymentProfileArray['cardnumber'], -4);
        $this->container->get('event_dispatcher')->dispatch(
            'clamidity_authnet.customer.add_paymentprofile',
            new CustomerPaymentProfileEvent($customerProfile, $paymentProfileId, $cardNumber)
        );
    }

    private function deleteCustomerProfileAction()
    {
        
    }

    private function updateCustomerProfile()
    {
        
    }

    private function updatePaymentProfile()
    {
        
    }

    private function postTransaction()
    {
        $this->getCIMManager()->createNewTransaction($amount, $customerProfileId, $lineItems, $paymentProfileId, $customerAddressId);
    }
    
    private function voidTransaction()
    {
        
    }

    private function deleteShippingAddress()
    {
        
    }

    private function getCustomerProfile()
    {
        
    }
    
    private function getAuthorizeNetManager()
    {
        if ($this->authNetManager) {
            return $this->authNetManager;
        }

        return $this->container->get('authorize_net.manager');
    }

    private function getCIMManager()
    {
        if ($this->CIMManager) {
            return $this->CIMManager;
        } else if ($this->authNetManager) {
            return $this->authNetManager->getCIMManager();
        }

        return $this->container->get('authorize_net.manager')->getCIMManager();        
    }

    private function getRequest()
    {
        return $this->container->get('request');
    }

    private function getFormFactory()
    {
        return $this->container->get('form.factory');
    }

    private function getCustomerProfileObject()
    {
        $customerProfile = $this->getAuthorizeNetManager()->newCustomer();
        return $customerProfile;
    }

    private function getEntityManager()
    {
        return $this->container->get('doctrine')->getEntityManager();
    }
}