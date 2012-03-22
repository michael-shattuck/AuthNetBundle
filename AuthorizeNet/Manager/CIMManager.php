<?php

namespace Ms2474\AuthNetBundle\AuthorizeNet\Manager;

use Ms2474\AuthNetBundle\AuthorizeNet\API\CIM\AuthorizeNetCIM;
use Ms2474\AuthNetBundle\AuthorizeNet\AuthorizeNetManager;
use Ms2474\AuthNetBundle\AuthorizeNet\Shared\DataType;

/**
 * @author Michael Shattuck <ms2474@gmail.com>
 */
class CIMManager
{
    protected $cimObject;

    public function __construct(AuthorizeNetCIM $cimObject)
    {
        $this->cimObject = $cimObject;
    }

    public function addAddress(DataType\AuthorizeNetCustomer $customerProfile, array $customerAddressArray, AuthorizeNetManager $manager) {
        $address = $manager->newAddress();

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

        $customerProfile->shipToList[] = $address;

        return $customerProfile;
    }

    public function addPaymentProfileIndividual(DataType\AuthorizeNetCustomer $customerProfile, array $customerPaymentProfileArray, AuthorizeNetManager $manager) {
        $paymentProfile = $manager->newPaymentProfile();

        $paymentProfile->customerType = "individual";
        $paymentProfile->payment->creditCard->cardNumber = $customerPaymentProfileArray['cardnumber'];
        $paymentProfile->payment->creditCard->expirationDate = $customerPaymentProfileArray['expirationyear'].'-'.$customerPaymentProfileArray['expirationmonth'];

        $customerProfile->paymentProfiles[] = $paymentProfile;

        return $customerProfile;
    }

    public function postCustomerProfile(DataType\AuthorizeNetCustomer $customerProfile)
    {
        $response = $this->cimObject->createCustomerProfile($customerProfile);
        $customerProfileId = $response->getCustomerProfileId();

        /**
                * @todo Setup response and error handling 
                */
        return $customerProfileId;
    }
}