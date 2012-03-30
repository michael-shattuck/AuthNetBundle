<?php

namespace Clamidity\AuthNetBundle\Entity;

use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Clamidity\AuthNetBundle\Model\CustomerProfile\AbstractCustomerProfileManager;
use Clamidity\AuthNetBundle\Model\CustomerProfile\CustomerProfileInterface;
use Clamidity\AuthNetBundle\Event\CustomerAddressEvent;
use Clamidity\AuthNetBundle\Event\CustomerPaymentProfileEvent;
use Clamidity\AuthNetBundle\Event\CustomerTransactionEvent;

class CustomerProfileManager extends AbstractCustomerProfileManager
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

    protected function doSaveCustomerProfile(CustomerProfileInterface $customerProfile)
    {
        $this->em->persist($customerProfile);
        $this->em->flush();
    }

    protected function doRemoveCustomerProfile(CustomerProfileInterface $customerProfile)
    {
        $transactions = $customerProfile->getTransactions();
        $paymentProfiles = $customerProfile->getPaymentProfiles();
        $shippingAddresses = $customerProfile->getShippingAddresses();

        foreach ($transactions as $transaction) {
            $this->em->remove($transaction);
            $this->em->flush();
        }

        foreach ($paymentProfiles as $paymentProfile) {
            $this->em->remove($paymentProfile);
            $this->em->flush();
        }

        foreach ($shippingAddresses as $shippingAddress) {
            $this->em->remove($shippingAddress);
            $this->em->flush();
        }

        $this->em->remove($customerProfile);
        $this->em->flush();
    }

    public function getClass()
    {
        return $this->class;
    }

    public function addCardPaymentProfile(CustomerProfileInterface $customerProfile, $paymentProfileId, $cardNumber)
    {
        $this->dispatcher->dispatch(
            'clamidity_authnet.customer.add_paymentprofile',
            new CustomerPaymentProfileEvent($customerProfile, $paymentProfileId, $cardNumber)
        );
    }

    public function addShippingAddress(CustomerProfileInterface $customerProfile, $addressId, $address)
    {
        $this->dispatcher->dispatch(
            'clamidity_authnet.customer.add_address', 
            new CustomerAddressEvent($customerProfile, $addressId, $address)
        );
    }

    public function addTransaction($customerProfile, $transactionId, $amount)
    {
        $this->dispatcher->dispatch(
            'clamidity_authnet.customer.add_transaction', 
            new CustomerTransactionEvent($customerProfile, $transactionId, $amount)
        );
    }
}