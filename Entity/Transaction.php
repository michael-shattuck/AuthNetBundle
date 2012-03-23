<?php

namespace Clamidity\AuthNetBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Clamidity\AuthNetBundle\Entity\AuthNetProfile
 *
 * @ORM\Table(name="clamidity_transaction")
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 */
class Transaction
{
    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string $transactionId
     *
     * @ORM\Column(name="transactionId", type="integer", length=50)
     */
    protected $transactionId;

    /**
     * @var datetime $created_at
     *
     * @ORM\Column(name="created_at", type="datetime")
     */
    protected $created_at;

    /**
     * @var datetime $modified_at
     *
     * @ORM\Column(name="modified_at", type="datetime")
     */
    protected $modified_at;

    /**
     * @var type AuthorizeNetCustomer
     * 
     * @ORM\ManyToOne(targetEntity="\Clamidity\AuthNetBundle\Entity\CustomerProfile", inversedBy="transactions")
     */
    protected $customer;

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

    /**
     * @ORM\PreUpdate
     */
    public function doStuffOnPreUpdate()
    {
        $this->modified_at = new \DateTime();
    }
}