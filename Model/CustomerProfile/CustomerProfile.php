<?php

namespace Clamidity\AuthNetBundle\Model\CustomerProfile;

use Doctrine\Common\Collections\ArrayCollection;
use Clamidity\AuthNetBundle\Model\PaymentProfile\PaymentProfileInterface;
use Clamidity\AuthNetBundle\Model\ShippingAddress\ShippingAddressInterface;
use Clamidity\AuthNetBundle\Model\Transaction\TransactionInterface;

/**
 * @author Michael Shattuck <ms2474@gmail.com>
 */
 abstract class CustomerProfile implements CustomerProfileInterface
{
    /**
     * @var integer $id
     */
    protected $id;

    /**
     * @var string $profileId
     */
    protected $profileId;

    /**
     * @var datetime $created_at
     */
    protected $created_at;

    /**
     * @var datetime $modified_at
     */
    protected $modified_at;

    /**
     * @var type AuthorizeNetPaymentProfile
     */
    protected $paymentProfiles;

    /**
     * @var type AuthorizeNetAddress
     */
    protected $shippingAddresses;

    /**
     * @var type AuthorizeNetTransaction
     */
    protected $transactions;

    public function __construct()
    {
        $this->created_at = new \DateTime();
        $this->modified_at = new \DateTime();
        $this->paymentProfiles = new ArrayCollection();
        $this->shippingAddresses = new ArrayCollection();
        $this->transactions = new ArrayCollection();
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
     * @param string $profileId
     * @return AuthNetProfile
     */
    public function setProfileId($profileId)
    {
        $this->profileId = $profileId;
        return $this;
    }

    /**
     * Get ProfileId
     *
     * @return string 
     */
    public function getProfileId()
    {
        return $this->profileId;
    }

    /**
     * Set created_at
     *
     * @param datetime $createdAt
     * @return AuthNetProfile
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
     * @return AuthNetProfile
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

    public function addPaymentProfile(PaymentProfileInterface $paymentProfile)
    {
        $this->paymentProfiles[] = $paymentProfile;
    }

    public function getPaymentProfiles()
    {
        return $this->paymentProfiles;
    }

    public function addShippingAddress(ShippingAddressInterface $address)
    {
        $this->shippingAddresses[] = $address;
    }

    public function getShippingAddresses()
    {
        return $this->shippingAddresses;
    }

    public function addTransaction(TransactionInterface $transaction)
    {
        $this->transactions[] = $transaction;
    }

    public function getTransactions()
    {
        return $this->transactions;
    }
}