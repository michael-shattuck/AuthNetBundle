<?php

namespace Ms2474\AuthNetBundle\AuthorizeNet\Shared\DataType;

/**
 * A class that contains all fields for a CIM Customer Profile.
 *
 * @package    AuthorizeNet
 * @subpackage AuthorizeNetCIM
 */
class AuthorizeNetCustomer
{
    public $merchantCustomerId;
    public $description;
    public $email;
    public $paymentProfiles = array();
    public $shipToList = array();
    public $customerProfileId;
    
}