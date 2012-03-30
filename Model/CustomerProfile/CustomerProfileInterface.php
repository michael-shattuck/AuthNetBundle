<?php

namespace Clamidity\AuthNetBundle\Model\CustomerProfile;

use Clamidity\AuthNetBundle\Model\PaymentProfile\PaymentProfileInterface;
use Clamidity\AuthNetBundle\Model\ShippingAddress\ShippingAddressInterface;
use Clamidity\AuthNetBundle\Model\Transaction\TransactionInterface;

/**
 * @author Michael Shattuck <ms2474@gmail.com>
 */
 interface CustomerProfileInterface
{
    /**
     * Get id
     *
     * @return integer 
     */
    public function getId();

    /**
     * Set ProfileId
     *
     * @param string $profileId
     * @return AuthNetProfile
     */
    public function setProfileId($profileId);

    /**
     * Get ProfileId
     *
     * @return string 
     */
    public function getProfileId();

    /**
     * Set created_at
     *
     * @param datetime $createdAt
     * @return AuthNetProfile
     */
    public function setCreatedAt($createdAt);

    /**
     * Get created_at
     *
     * @return datetime 
     */
    public function getCreatedAt();

    /**
     * Set modified_at
     *
     * @param datetime $modifiedAt
     * @return AuthNetProfile
     */
    public function setModifiedAt($modifiedAt);

    /**
     * Get modified_at
     *
     * @return datetime 
     */
    public function getModifiedAt();

    public function addPaymentProfile(PaymentProfileInterface $paymentProfile);

    public function getPaymentProfiles();

    public function addShippingAddress(ShippingAddressInterface $address);

    public function getShippingAddresses();

    public function addTransaction(TransactionInterface $transaction);

    public function getTransactions();
}