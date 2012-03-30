<?php

namespace Clamidity\AuthNetBundle\Model\Transaction;

use Clamidity\AuthNetBundle\Model\CustomerProfile\CustomerProfileInterface;

/**
 * @author Michael Shattuck <ms2474@gmail.com>
 */
abstract class Transaction implements TransactionInterface
{
    /**
     * @var integer $id
     */
    protected $id;

    /**
     * @var string $transactionId
     */
    protected $transactionId;

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
     * @var string $amount
     */
    protected $amount;

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
     * Set TransactionId
     *
     * @param string $transactionId
     * @return AuthNetProfile
     */
    public function setTransactionId($transactionId)
    {
        $this->transactionId = $transactionId;
        return $this;
    }

    /**
     * Get TransactionId
     *
     * @return string 
     */
    public function getTransactionId()
    {
        return $this->transactionId;
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

    public function setCustomer(CustomerProfileInterface $customer)
    {
        $this->customer = $customer;
    }

    public function getCustomer()
    {
        return $this->customer;
    }

    public function setAmount($amount)
    {
        $this->amount = $amount;
    }

    public function getAmount()
    {
        return $this->amount;
    }
}