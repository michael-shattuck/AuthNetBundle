<?php

namespace Ms2474\AuthNetBundle\AuthorizeNet\Shared\DataType;

use Ms2474\AuthNetBundle\AuthorizeNet\Shared\DataType\AuthorizeNetCreditCard;
use Ms2474\AuthNetBundle\AuthorizeNet\Shared\DataType\AuthorizeNetBankAccount;

/**
 * A class that contains all fields for a CIM Payment Type.
 *
 * @package    AuthorizeNet
 * @subpackage AuthorizeNetCIM
 */
class AuthorizeNetPayment
{
    public $creditCard;
    public $bankAccount;
    
    public function __construct()
    {
        $this->creditCard = new AuthorizeNetCreditCard;
        $this->bankAccount = new AuthorizeNetBankAccount;
    }
}