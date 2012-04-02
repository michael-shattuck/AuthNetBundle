<?php

namespace Clamidity\AuthNetBundle\Model\PaymentProfile;

use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

interface PaymentProfileManagerInterface
{
     /**
        *  Return a new (empty) PaymentProfile entity
        * 
        *  @return PaymentProfile
        */
    function createPaymentProfile();
    
    /**
        * Persist a PaymentProfile to the database
        * 
        *  @return void
        */
    function savePaymentProfile(PaymentProfileInterface $paymentProfile);
    
    /**
     * @return PaymentProfile
     */
    function find($id);

    /**
     * @return PaymentProfile
     * @throws NotFoundHttpException if entity is not found
     */
    function findOr404($id);

    /**
     * @return \Doctrine\Common\Collections\ArrayCollection
     */
    function findAll();

    function getClass();
}