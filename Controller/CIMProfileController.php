<?php

namespace Ms2474\AuthNetBundle\Controller;

use Symfony\Component\DependencyInjection\ContainerAware;
use Ms2474\AuthNetBundle\Entity\CIMProfile;
use Ms2474\AuthNetBundle\Form\CIM\CIMProfileIndividualType;

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

        $form = $this->getFormFactory()->create(new CIMProfileIndividualType());
        $form->bindRequest($request);

        if ($form->isValid()) {
            echo "success";
        } else {
            $errors = $form->hasErrors();
            var_dump($errors);
        }
        
        die;
        return;
    }

    private function getRequest()
    {
        return $this->container->get('request');
    }

    private function getFormFactory()
    {
        return $this->container->get('form.factory');
    }
}