<?php

namespace Clamidity\AuthNetBundle\Controller;

use Symfony\Component\DependencyInjection\ContainerAware;
use Clamidity\AuthNetBundle\Entities;

class AuthNetBaseController extends ContainerAware
{
    protected function getEntityManager()
    {
        return $this->container->get('doctrine')->getEntityManager();
    }

    protected function getRepository($repo)
    {
        return $this->container->get('doctrine')->getRepository(Entities::BUNDLE.':'.$repo);
    }

    protected function getAuthorizeNetManager()
    {
        if ($this->authNetManager) {
            return $this->authNetManager;
        }

        return $this->container->get('authorize_net.manager');
    }

    protected function getCIMManager()
    {
        if ($this->CIMManager) {
            return $this->CIMManager;
        } else if ($this->authNetManager) {
            return $this->authNetManager->getCIMManager();
        }

        return $this->container->get('authorize_net.manager')->getCIMManager();        
    }

    protected function getRequest()
    {
        return $this->container->get('request');
    }

    protected function getFormFactory()
    {
        return $this->container->get('form.factory');
    }

    protected function getTemplating()
    {
        return $this->container->get('templating');
    }

    protected function render($view, array $options)
    {
        return $this->getTemplating()->renderResponse($view, $options);
    }

    protected function createForm($form)
    {
        return $this->getFormFactory()->create($form);
    }

    protected function getRouter()
    {
        return $this->container->get('router');
    }

    protected function generateUrl($route, array $options = array())
    {
        return $this->getRouter()->generate($route, $options);
    }
}