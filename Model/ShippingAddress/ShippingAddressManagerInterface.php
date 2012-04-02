<?php

namespace Clamidity\AuthNetBundle\Model\ShippingAddress;

use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

interface ShippingAddressManagerInterface
{
     /**
        *  Return a new (empty) ShippingAddress entity
        * 
        *  @return ShippingAddress
        */
    function createShippingAddress();
    
    /**
        * Persist a ShippingAddress to the database
        * 
        *  @return void
        */
    function saveShippingAddress(ShippingAddressInterface $shippingAddress);
    
    /**
     * @return ShippingAddress
     */
    function find($id);

    /**
     * @return ShippingAddress
     * @throws NotFoundHttpException if entity is not found
     */
    function findOr404($id);

    /**
     * @return \Doctrine\Common\Collections\ArrayCollection
     */
    function findAll();

    function getClass();
}