<?php

namespace Clamidity\AuthNetBundle\Model\PaymentProfile;

use Clamidity\AuthNetBundle\Model\CustomerProfile\CustomerProfileInterface;

/**
 * @author Michael Shattuck <ms2474@gmail.com>
 */
abstract class PaymentProfile implements PaymentProfileInterface
{
    /**
     * @var integer $id
     */
    protected $id;

    /**
     * @var string $paymentProfileId
     */
    protected $paymentProfileId;

    /**
     * @var datetime $created_at
     */
    protected $created_at;

    /**
     * @var datetime $modified_at
     */
    protected $modified_at;

    /**
     * @var type AuthorizeNetCustomer
     */
    protected $customer;

    /**
     * @var type  string
     */
    protected $accountNumber;

    public function __construct()
    {
        $this->created_at = new \DateTime();
        $this->modified_at = new \DateTime();
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set ProfileId
     *
     * @param string $paymentProfileId
     * @return PaymentProfile
     */
    public function setPaymentProfileId($paymentProfileId)
    {
        $this->paymentProfileId = $paymentProfileId;
        return $this;
    }

    /**
     * Get ProfileId
     *
     * @return string 
     */
    public function getPaymentProfileId()
    {
        return $this->paymentProfileId;
    }

    /**
     * Set created_at
     *
     * @param datetime $createdAt
     * @return PaymentProfile
     */
    public function setCreatedAt($createdAt)
    {
        $this->created_at = $createdAt;
        return $this;
    }

    /**
     * Get created_at
     *
     * @return datetime 
     */
    public function getCreatedAt()
    {
        return $this->created_at;
    }

    /**
     * Set modified_at
     *
     * @param datetime $modifiedAt
     * @return PaymentProfile
     */
    public function setModifiedAt($modifiedAt)
    {
        $this->modified_at = $modifiedAt;
        return $this;
    }

    /**
     * Get modified_at
     *
     * @return datetime 
     */
    public function getModifiedAt()
    {
        return $this->modified_at;
    }

    /**
     * Set customer
     *
     * @param CustomerProfile $customer
     * @return PaymentProfile
     */
    public function setCustomer(CustomerProfileInterface $customer)
    {
        $this->customer = $customer;
        $customer->addPaymentProfile($this);
        return $this;
    }

    /**
     * Get customer
     *
     * @return PaymentProfile 
     */
    public function getCustomer()
    {
        return $this->customer;
    }

    public function setAccountNumber($accountNumber)
    {
        $this->accountNumber = $accountNumber;
    }

    public function getAccountNumber()
    {
        return $this->accountNumber;
    }
}