<?php

namespace Ms2474\AuthNetBundle\Controller;

use Symfony\Component\DependencyInjection\ContainerAware;
use Ms2474\AuthNetBundle\Entity\CIMProfile;
use Ms2474\AuthNetBundle\Form\CIM\CIMProfileIndividualType;
use Symfony\Component\HttpFoundation\RedirectResponse;

class CIMProfileController extends ContainerAware
{
    public function indexAction()
    {
        
    }

    public function newIndividualAction()
    {
        $form = $this->container->get('form.factory')->create(new CIMProfileIndividualType());

        return $this->container->get('templating')->renderResponse(
            'Ms2474AuthNetBundle:CIMProfile:newIndividual.html.twig', array(
                'form' => $form->createView(),
            )
        );
    }

    public function postAction()
    {
        $request = $this->getRequest();
        $errors = null;

        $form = $this->getFormFactory()->create(new CIMProfileIndividualType());
        $form->bindRequest($request);

        if ($form->isValid()) {
            $customerProfileArray = $request->get('ms2474_authnetbundle_cimprofileindividualtype');

            $manager = $this->getAuthorizeNetManager();
            $customerProfile = $this->getCustomerProfileObject($customerProfileArray, $manager);

            $CIMManager = $manager->getCIMManager();

            if ($customerProfileArray['shippingaddress']) {
                $customerProfile = $CIMManager->addAddress($customerProfile, $customerProfileArray['shippingaddress'], $manager);
            }

            if ($customerProfileArray['paymentprofile']) {
                $customerProfile = $CIMManager->addPaymentProfileIndividual($customerProfile, $customerProfileArray['paymentprofile'], $manager);
            }

            $customerProfileId = $CIMManager->postCustomerProfile($customerProfile);

            $CIMProfile = new CIMProfile();
            $CIMProfile->setProfileId($customerProfileId);

            $em = $this->container->get('doctrine')->getEntityManager();
            $em->persist($CIMProfile);
            $em->flush();

            $uri = $this->container->get('router')->generate(
                'ms2474_authnet_cimprofile_index'
            );

            return new RedirectResponse($uri);
        }

        if ($form->hasErrors() > 0) {
            $errors = $form->getErrors();
        }

        return $this->container->get('templating')->renderResponse(
            'Ms2474AuthNetBundle:CIMProfile:newIndividual.html.twig', array(
                'form' => $form->createView(),
                'errors' => $errors,
            )
        );
    }

    private function getAuthorizeNetManager()
    {
        return $this->container->get('authorize_net.manager');
    }

    private function getRequest()
    {
        return $this->container->get('request');
    }

    private function getFormFactory()
    {
        return $this->container->get('form.factory');
    }

    private function getCustomerProfileObject(array $customerProfileArray, \Ms2474\AuthNetBundle\AuthorizeNet\AuthorizeNetManager $manager)
    {
        $customerProfile = $manager->newCustomer();
        $customerProfile->description = $customerProfileArray['customerdescription'];
        $customerProfile->email = $customerProfileArray['email'];

        /**
                * @todo Add support for user set merchant customer id
                */
        $customerProfile->merchantCustomerId = time();

        return $customerProfile;
    }
}