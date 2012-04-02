<?php

namespace Clamidity\AuthNetBundle\Entity;

use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Clamidity\AuthNetBundle\Model\Transaction\AbstractTransactionManager;
use Clamidity\AuthNetBundle\Model\Transaction\TransactionInterface;

class TransactionManager extends AbstractTransactionManager
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

    protected function doSaveTransaction(TransactionInterface $transaction)
    {
        $this->em->persist($transaction);
        $this->em->flush();
    }

    protected function doRemoveTransaction(TransactionInterface $transaction)
    {
        $this->em->remove($transaction);
        $this->em->flush();
    }

    public function getClass()
    {
        return $this->class;
    }
}