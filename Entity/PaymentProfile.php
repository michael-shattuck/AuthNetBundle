<?php

namespace Clamidity\AuthNetBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Clamidity\AuthNetBundle\Entity\PaymentProfile
 *
 * @ORM\Table(name="clamidity_paymentprofile")
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 */
class PaymentProfile
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
     * @var string $paymentProfileId
     *
     * @ORM\Column(name="paymentProfileId", type="integer", length=50)
     */
    protected $paymentProfileId;

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
     * @ORM\ManyToOne(targetEntity="\Clamidity\AuthNetBundle\Entity\CustomerProfile", inversedBy="paymentProfiles")
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
     * Set ProfileId
     *
     * @param string $paymentProfileId
     * @return PaymentProfile
     */
    public function setPaymemtProfileId($paymentProfileId)
    {
        $this->paymentProfileId = $paymentProfileId;
        return $this;
    }

    /**
     * Get ProfileId
     *
     * @return string 
     */
    public function getPaymemtProfileId()
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
    public function setCustomer($customer)
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

    /**
     * @ORM\PreUpdate
     */
    public function doStuffOnPreUpdate()
    {
        $this->modified_at = new \DateTime();
    }
}