<?php

namespace Ms2474\AuthNetBundle\AuthorizeNet;

use Ms2474\AuthNetBundle\AuthorizeNet\Shared\DataType\AuthorizeNetAddress;
use Ms2474\AuthNetBundle\AuthorizeNet\Shared\DataType\AuthorizeNetBankAccount;
use Ms2474\AuthNetBundle\AuthorizeNet\Shared\DataType\AuthorizeNetCreditCard;
use Ms2474\AuthNetBundle\AuthorizeNet\Shared\DataType\AuthorizeNetCustomer;
use Ms2474\AuthNetBundle\AuthorizeNet\Shared\DataType\AuthorizeNetLineItem;
use Ms2474\AuthNetBundle\AuthorizeNet\Shared\DataType\AuthorizeNetPayment;
use Ms2474\AuthNetBundle\AuthorizeNet\Shared\DataType\AuthorizeNetPaymentProfile;
use Ms2474\AuthNetBundle\AuthorizeNet\Shared\DataType\AuthorizeNetTransaction;
use Ms2474\AuthNetBundle\AuthorizeNet\Shared\DataType\AuthorizeNet_Subscription;

/**
 * @author Michael Shattuck <ms2474@gmail.com>
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
        return new AuthorizeNetTransaction();
    }
}