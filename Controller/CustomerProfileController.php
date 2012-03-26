<?php

namespace Clamidity\AuthNetBundle\Controller;

use Symfony\Component\DependencyInjection\ContainerAware;
use Clamidity\AuthNetBundle\Entity\CustomerProfile;
use Clamidity\AuthNetBundle\Form\CustomerProfileIndividualType;
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

                $em = $this->container->get('doctrine')->getEntityManager();
                $em->persist($customerProfileEntity);
                $em->flush();

                if ($customerProfileArray['paymentprofile']) {
                    $this->addPaymentProfile($customerProfileEntity, $customerProfileArray['paymentprofile']);
                }

                if ($customerProfileArray['shippingaddress']) {
                    $this->addShippingAddress($customerProfileEntity, $customerProfileArray['shippingaddress']);
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

    private function addShippingAddress(CustomerProfile $customerProfile, array $addressArray)
    {
        $addressId = $this->getCIMManager()->addAddress($customerProfile->getProfileId(), $addressArray);
        $this->container->get('event_dispatcher')->dispatch(
            'clamidity_authnet.customer.add_address', 
            new CustomerAddressEvent($customerProfile, $addressId)
        );
    }

    private function addPaymentProfile(CustomerProfile $customerProfile, array $paymentProfileArrays)
    {
        $paymentProfileId = $this->getCIMManager()->addPaymentProfileIndividual($customerProfile->getProfileId(), $paymentProfileArrays);
        $this->container->get('event_dispatcher')->dispatch(
            'clamidity_authnet.customer.add_paymentprofile',
            new CustomerPaymentProfileEvent($customerProfile, $paymentProfileId)
        );
    }


    public function newTransactionAction()
    {
        return $this->container->get('templating')->renderResponse(
            'ClamidityAuthNetBundle:CustomerProfile:index.html.twig', array(
                'ids' => $profileIdArray,
            )
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
}