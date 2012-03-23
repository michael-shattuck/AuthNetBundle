<?php

namespace Clamidity\AuthNetBundle\AuthorizeNet\Shared\DataType;

use Clamidity\AuthNetBundle\AuthorizeNet\Shared\DataType\AuthorizeNetCreditCard;
use Clamidity\AuthNetBundle\AuthorizeNet\Shared\DataType\AuthorizeNetBankAccount;

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
        $this->creditCard = new AuthorizeNetCreditCard();
        $this->bankAccount = new AuthorizeNetBankAccount();
    }
}