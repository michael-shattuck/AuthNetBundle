<?php

namespace Clamidity\AuthNetBundle\Model\PaymentProfile;

use Clamidity\AuthNetBundle\Model\CustomerProfile\CustomerProfileInterface;

/**
 * @author Michael Shattuck <ms2474@gmail.com>
 */
Interface PaymentProfileInterface
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
     * @param string $paymentProfileId
     * @return PaymentProfile
     */
    public function setPaymentProfileId($paymentProfileId);

    /**
     * Get ProfileId
     *
     * @return string 
     */
    public function getPaymentProfileId();

    /**
     * Set created_at
     *
     * @param datetime $createdAt
     * @return PaymentProfile
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
     * @return PaymentProfile
     */
    public function setModifiedAt($modifiedAt);

    /**
     * Get modified_at
     *
     * @return datetime 
     */
    public function getModifiedAt();

    /**
     * Set customer
     *
     * @param CustomerProfile $customer
     * @return PaymentProfile
     */
    public function setCustomer(CustomerProfileInterface $customer);

    /**
     * Get customer
     *
     * @return PaymentProfile 
     */
    public function getCustomer();

    public function setAccountNumber($accountNumber);

    public function getAccountNumber();
}