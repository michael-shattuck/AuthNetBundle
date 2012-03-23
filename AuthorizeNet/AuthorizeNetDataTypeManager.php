<?php

namespace Clamidity\AuthNetBundle\AuthorizeNet;

use Clamidity\AuthNetBundle\AuthorizeNet\Shared\DataType\AuthorizeNetAddress;
use Clamidity\AuthNetBundle\AuthorizeNet\Shared\DataType\AuthorizeNetBankAccount;
use Clamidity\AuthNetBundle\AuthorizeNet\Shared\DataType\AuthorizeNetCreditCard;
use Clamidity\AuthNetBundle\AuthorizeNet\Shared\DataType\AuthorizeNetCustomer;
use Clamidity\AuthNetBundle\AuthorizeNet\Shared\DataType\AuthorizeNetLineItem;
use Clamidity\AuthNetBundle\AuthorizeNet\Shared\DataType\AuthorizeNetPayment;
use Clamidity\AuthNetBundle\AuthorizeNet\Shared\DataType\AuthorizeNetPaymentProfile;
use Clamidity\AuthNetBundle\AuthorizeNet\Shared\DataType\AuthorizeNetTransaction;
use Clamidity\AuthNetBundle\AuthorizeNet\Shared\DataType\AuthorizeNet_Subscription;

/**
 * @author Michael Shattuck <clamidity@gmail.com>
 */
class AuthorizeNetDataTypeManager
{
    public function newAddress()
    {
        return new AuthorizeNetAddress();
    }

    public function newBankAccount()
    {
        return new AuthorizeNetBankAccount();
    }

    public function newCreditCard()
    {
        return new AuthorizeNetCreditCard();
    }

    public function newCustomer()
    {
        return new AuthorizeNetCustomer();
    }

    public function newLineItem()
    {
        return new AuthorizeNetLineItem();
    }

    public function newPayment()
    {
        return new AuthorizeNetPayment();
    }

    public function newPaymentProfile()
    {
        return new AuthorizeNetPaymentProfile();
    }

    public function newTransaction()
    {
        return new AuthorizeNetTransaction();
    }

    public function newSubscription()
    {
        return new AuthorizeNet_Subscription();
    }
}