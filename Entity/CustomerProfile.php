<?php

namespace Clamidity\AuthNetBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Clamidity\AuthNetBundle\Entity\AuthNetProfile
 *
 * @ORM\Table(name="clamidity_customerprofile")
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 */
class CustomerProfile
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
     * @var string $profileId
     *
     * @ORM\Column(name="profileId", type="integer", length=50)
     */
    protected $profileId;

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
     * @var type AuthorizeNetPaymentProfile
     * 
     * @ORM\OneToMany(targetEntity="\Clamidity\AuthNetBundle\Entity\PaymentProfile", mappedBy="customer")
     */
    protected $paymentProfiles;

    /**
     * @var type AuthorizeNetAddress
     * 
     * @ORM\OneToMany(targetEntity="\Clamidity\AuthNetBundle\Entity\ShippingAddress", mappedBy="customer")
     */
    protected $shippingAddresses;

    /**
     * @var type AuthorizeNetTransaction
     * 
     * @ORM\OneToMany(targetEntity="\Clamidity\AuthNetBundle\Entity\Transaction", mappedBy="customer")
     */
    protected $transactions;

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

    /**
     * @ORM\PreUpdate
     */
    public function doStuffOnPreUpdate()
    {
        $this->modified_at = new \DateTime();
    }
}