<?php

namespace Clamidity\AuthNetBundle\AuthorizeNet\Manager;

use Clamidity\AuthNetBundle\AuthorizeNet\API\CIM\AuthorizeNetCIM;
use Clamidity\AuthNetBundle\AuthorizeNet\AuthorizeNetManager;
use Clamidity\AuthNetBundle\AuthorizeNet\Shared\DataType;
use Clamidity\AuthNetBundle\AuthorizeNet\Result\AuthorizeNetResultHandler;

/**
 * @author Michael Shattuck <clamidity@gmail.com>
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

        return $response->getCustomerAddressId();
    }

    public function addPaymentProfileIndividual($customerProfileId, array $customerPaymentProfileArray) {
        $paymentProfile = $this->manager->newPaymentProfile();

        $paymentProfile->customerType = "individual";
        $paymentProfile->payment->creditCard->cardNumber = $customerPaymentProfileArray['cardnumber'];
        $paymentProfile->payment->creditCard->expirationDate = $customerPaymentProfileArray['expirationyear'].'-'.$customerPaymentProfileArray['expirationmonth'];

        $response = $this->cimObject->createCustomerPaymentProfile($customerProfileId, $paymentProfile);

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
            $lineItem->taxable     = $lineItemArray['taxable'];

            $transaction->lineItems[] = $lineItem;
        }

        $response = $this->getCIMObject()->createCustomerProfileTransaction("AuthCapture", $transaction);
        $transactionResponse = $response->getTransactionResponse();
        return $transactionResponse->transaction_id;
    }
}