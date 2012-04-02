<?php

namespace Clamidity\AuthNetBundle\Entity;

use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Clamidity\AuthNetBundle\Model\ShippingAddress\AbstractShippingAddressManager;
use Clamidity\AuthNetBundle\Model\ShippingAddress\ShippingAddressInterface;

class ShippingAddressManager extends AbstractShippingAddressManager
{
    protected $em;
    protected $repo;
    protected $class;

    public function __construct(EventDispatcherInterface $dispatcher, EntityManager $em, $class)
    {
        parent::__construct($dispatcher);

        $this->em = $em;
        $this->repo = $em->getRepository($class);
        $this->class = $class;
    }
    
    public function find($id)
    {
        return $this->repo->find($id);
    }

    public function findOr404($id)
    {
        $item = $this->find($id);
        if (null === $item) {
            throw new NotFoundHttpException();
        }

        return $item;
    }
    
    public function findAll()
    {
        return $this->repo->findBy(array());
    }

    protected function doSaveShippingAddress(ShippingAddressInterface $shippingAddress)
    {
        $this->em->persist($shippingAddress);
        $this->em->flush();
    }

    protected function doRemoveShippingAddress(ShippingAddressInterface $shippingAddress)
    {
        $this->em->remove($shippingAddress);
        $this->em->flush();
    }

    public function getClass()
    {
        return $this->class;
    }
}