<?php

namespace Clamidity\AuthNetBundle\Model\CustomerProfile;

use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

interface CustomerProfileManagerInterface
{
     /**
        *  Return a new (empty) CustomerProfile entity
        * 
        *  @return CustomerProfile
        */
    function createCustomerProfile();
    
    /**
        * Persist a CustomerProfile to the database
        * 
        *  @return void
        */
    function saveCustomerProfile(CustomerProfileInterface $customerProfile);
    
    /**
     * @return CustomerProfile
     */
    function find($id);

    /**
     * @return CustomerProfile
     * @throws NotFoundHttpException if entity is not found
     */
    function findOr404($id);

    /**
     * @return \Doctrine\Common\Collections\ArrayCollection
     */
    function findAll();

    function getClass();
}