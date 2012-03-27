<?php

namespace Clamidity\AuthNetBundle\AuthorizeNet\Manager;

use Clamidity\AuthNetBundle\AuthorizeNet\API\CIM\AuthorizeNetCIM;
use Clamidity\AuthNetBundle\AuthorizeNet\AuthorizeNetManager;
use Clamidity\AuthNetBundle\AuthorizeNet\Shared\DataType;
use Clamidity\AuthNetBundle\AuthorizeNet\Result\AuthorizeNetResultHandler;

/**
 * @author Michael Shattuck <ms2474@gmail.com>
 */
class CIMManager extends AuthorizeNetResultHandler
{
    protected $cimObject;
    protected $debugMode;
    protected $manager;

    public function __construct(AuthorizeNetCIM $cimObject, $debugMode, AuthorizeNetManager $manager)
    {
        $this->cimObject = $cimObject;
        $this->debugMode = $debugMode;
        $this->manager = $manager;
    }

    public function getCIMObject()
    {
        return $this->cimObject;
    }

    public function addAddress($customerProfileId, array $customerAddressArray) {
        $address = $this->manager->newAddress();

        if (isset($customerAddressArray['firstname'])) { $address->firstName = $customerAddressArray['firstname']; }
        if (isset($customerAddressArray['lastname'])) { $address->lastName = $customerAddressArray['lastname']; }
        if (isset($customerAddressArray['company'])) { $address->company = $customerAddressArray['company']; }
        if (isset($customerAddressArray['address'])) { $address->address = $customerAddressArray['address']; }
        if (isset($customerAddressArray['city'])) { $address->city = $customerAddressArray['city']; }
        if (isset($customerAddressArray['state'])) { $address->state = $customerAddressArray['state']; }
        if (isset($customerAddressArray['zip'])) { $address->zip = $customerAddressArray['zip']; }
        if (isset($customerAddressArray['country'])) { $address->country = $customerAddressArray['country']; }
        if (isset($customerAddressArray['phonenumber'])) { $address->phoneNumber = $customerAddressArray['phonenumber']; }
        if (isset($customerAddressArray['faxnumber'])) { $address->faxNumber = $customerAddressArray['faxnumber']; }

        $response = $this->cimObject->createCustomerShippingAddress($customerProfileId, $address);

        if (!$this->checkResult($response)) {
            return false;
        }

        return $response->getCustomerAddressId();
    }

    public function addPaymentProfileIndividual($customerProfileId, array $customerPaymentProfileArray) {
        $paymentProfile = $this->manager->newPaymentProfile();

        $paymentProfile->customerType = "individual";
        $paymentProfile->payment->creditCard->cardNumber = $customerPaymentProfileArray['cardnumber'];
        $paymentProfile->payment->creditCard->expirationDate = $customerPaymentProfileArray['expirationyear'].'-'.$customerPaymentProfileArray['expirationmonth'];
        if (isset($customerPaymentProfileArray['billingaddress']['firstname'])) { $paymentProfile->billTo->firstName = $customerPaymentProfileArray['billingaddress']['firstname']; }
        if (isset($customerPaymentProfileArray['billingaddress']['lastname'])) { $paymentProfile->billTo->lastName = $customerPaymentProfileArray['billingaddress']['lastname']; }
        if (isset($customerPaymentProfileArray['billingaddress']['company'])) { $paymentProfile->billTo->company = $customerPaymentProfileArray['billingaddress']['company']; }
        if (isset($customerPaymentProfileArray['billingaddress']['address'])) { $paymentProfile->billTo->address = $customerPaymentProfileArray['billingaddress']['address']; }
        if (isset($customerPaymentProfileArray['billingaddress']['city'])) { $paymentProfile->billTo->city = $customerPaymentProfileArray['billingaddress']['city']; }
        if (isset($customerPaymentProfileArray['billingaddress']['state'])) { $paymentProfile->billTo->state = $customerPaymentProfileArray['billingaddress']['state']; }
        if (isset($customerPaymentProfileArray['billingaddress']['zip'])) { $paymentProfile->billTo->zip = $customerPaymentProfileArray['billingaddress']['zip']; }
        if (isset($customerPaymentProfileArray['billingaddress']['country'])) { $paymentProfile->billTo->country = $customerPaymentProfileArray['billingaddress']['country']; }
        if (isset($customerPaymentProfileArray['billingaddress']['phonenumber'])) { $paymentProfile->billTo->phoneNumber = $customerPaymentProfileArray['billingaddress']['phonenumber']; }
        if (isset($customerPaymentProfileArray['billingaddress']['faxnumber'])) { $paymentProfile->billTo->faxNumber = $customerPaymentProfileArray['billingaddress']['faxnumber']; }

        $response = $this->cimObject->createCustomerPaymentProfile($customerProfileId, $paymentProfile);

        if (!$this->checkResult($response)) {
            return false;
        }

        return $response->getPaymentProfileId();
    }

    public function postCustomerProfile(DataType\AuthorizeNetCustomer $customerProfile)
    {
        if ($this->debugMode) {
            $response = $this->cimObject->createCustomerProfile($customerProfile, "testMode");
            /**
                       * @todo add testMode capture
                       */
        } else {
            $response = $this->cimObject->createCustomerProfile($customerProfile);
        }

        $customerProfileId = $response->getCustomerProfileId();

        if (!$this->checkResult($response)) {
            return false;
        }

        return $customerProfileId;
    }

    public function createNewTransaction($amount, $customerProfileId, array $lineItems, $paymentProfileId, $customerAddressId)
    {
        $transaction = new DataType\AuthorizeNetTransaction();
        $transaction->amount = $amount;
        $transaction->customerProfileId = $customerProfileId;
        $transaction->customerPaymentProfileId = $paymentProfileId;
        $transaction->customerShippingAddressId = $customerAddressId;

        foreach ($lineItems as $lineItemArray) {
            $lineItem              = new DataType\AuthorizeNetLineItem();
            $lineItem->itemId      = $lineItemArray['itemId'];
            $lineItem->name        = $lineItemArray['name'];
            $lineItem->description = $lineItemArray['description'];
            $lineItem->quantity    = $lineItemArray['quantity'];
            $lineItem->unitPrice   = $lineItemArray['unitPrice'];
            if (isset($lineItemArray['taxable']) && 1 == $lineItemArray['taxable']) {
                $lineItem->taxable = true;
            }

            $transaction->lineItems[] = $lineItem;
        }

        $response = $this->getCIMObject()->createCustomerProfileTransaction("AuthCapture", $transaction);
        $transactionResponse = $response->getTransactionResponse();

        if (!$this->checkResult($response)) {
            return false;
        }

        return $transactionResponse->transaction_id;
    }

    public function deleteCustomerProfile()
    {
        $this->getCIMObject()->deleteCustomerProfile($customer_id);

        if (!$this->checkResult($response)) {
            return false;
        }

        return true;
    }
}