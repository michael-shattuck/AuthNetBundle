<?php

namespace Ms2474\AuthNetBundle\AuthorizeNet\Shared\DataType;

use Ms2474\AuthNetBundle\AuthorizeNet\Shared\DataType\AuthorizeNetAddress;
use Ms2474\AuthNetBundle\AuthorizeNet\Shared\DataType\AuthorizeNetPayment;

/**
 * A class that contains all fields for a CIM Payment Profile.
 *
 * @package    AuthorizeNet
 * @subpackage AuthorizeNetCIM
 */
class AuthorizeNetPaymentProfile
{
    
    public $customerType;
    public $billTo;
    public $payment;
    public $customerPaymentProfileId;
    
    public function __construct()
    {
        $this->billTo = new AuthorizeNetAddress;
        $this->payment = new AuthorizeNetPayment;
    }

}