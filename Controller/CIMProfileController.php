<?php

namespace Clamidity\AuthNetBundle\Controller;

use Symfony\Component\DependencyInjection\ContainerAware;
use Clamidity\AuthNetBundle\Entity\CIMProfile;
use Clamidity\AuthNetBundle\Form\CIM\CIMProfileIndividualType;
use Symfony\Component\HttpFoundation\RedirectResponse;

class CIMProfileController extends ContainerAware
{
    protected $CIMManager;
    protected $authNetManager;

    public function indexAction()
    {
        $profileIdArray = $this->container->get('doctrine')->getRepository("ClamidityAuthNetBundle:CIMProfile")->findAll();

        return $this->container->get('templating')->renderResponse(
            'ClamidityAuthNetBundle:CIMProfile:index.html.twig', array(
                'ids' => $profileIdArray,
            )
        );
    }

    public function newIndividualAction()
    {
        $form = $this->container->get('form.factory')->create(new CIMProfileIndividualType());

        return $this->container->get('templating')->renderResponse(
            'ClamidityAuthNetBundle:CIMProfile:newIndividual.html.twig', array(
                'form' => $form->createView(),
            )
        );
    }

    public function postIndividualAction()
    {
        $request = $this->getRequest();
        $errors = null;

        $form = $this->getFormFactory()->create(new CIMProfileIndividualType());
        $form->bindRequest($request);

        if ($form->isValid()) {
            $customerProfileArray = $request->get('clamidity_authnetbundle_cimprofileindividualtype');

            $manager = $this->getAuthorizeNetManager();
            $customerProfile = $this->getCustomerProfileObject($manager);
            $customerProfile->description = $customerProfileArray['customerdescription'];
            $customerProfile->email = $customerProfileArray['email'];
            /**
                    * @todo Add support for user set merchant customer id
                    */
            $customerProfile->merchantCustomerId = time();

            $CIMManager = $manager->getCIMManager();

            if ($customerProfileArray['paymentprofile']) {
                $customerProfile = $CIMManager->addPaymentProfileIndividual($customerProfile, $customerProfileArray['paymentprofile'], $manager);
            }

            if ($customerProfileArray['shippingaddress']) {
                $customerProfile = $CIMManager->addAddress($customerProfile, $customerProfileArray['shippingaddress'], $manager);
            }

            $customerProfileId = $CIMManager->postCustomerProfile($customerProfile);

            var_dump($customerProfileId);
            if ($customerProfileId) {
                $CIMProfile = new CIMProfile();
                $CIMProfile->setProfileId($customerProfileId);

                $em = $this->container->get('doctrine')->getEntityManager();
                $em->persist($CIMProfile);
                $em->flush();
                echo "test";
            }

            $uri = $this->container->get('router')->generate(
                'clamidity_authnet_cimprofile_index'
            );

            return new RedirectResponse($uri);
        }

        if ($form->hasErrors() > 0) {
            $errors = $form->getErrors();
        }

        return $this->container->get('templating')->renderResponse(
            'ClamidityAuthNetBundle:CIMProfile:newIndividual.html.twig', array(
                'form' => $form->createView(),
                'errors' => $errors,
            )
        );
    }

    public function deleteCustomerProfileAction()
    {
        
    }

    public function updateCustomerProfile()
    {
        
    }

    public function updatePaymentProfile()
    {
        
    }

    public function newTransaction()
    {
        return $this->container->get('templating')->renderResponse(
            'ClamidityAuthNetBundle:CIMProfile:index.html.twig', array(
                'ids' => $profileIdArray,
            )
        );
    }

    public function postTransaction()
    {
        $this->getCIMManager()->createNewTransaction($amount, $customerProfileId, $lineItems, $paymentProfileId, $customerAddressId);
    }
    
    public function voidTransaction()
    {
        
    }

    public function deleteShippingAddress()
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

    private function getCustomerProfileObject(\Clamidity\AuthNetBundle\AuthorizeNet\AuthorizeNetManager $manager)
    {
        $customerProfile = $manager->newCustomer();
        return $customerProfile;
    }
}