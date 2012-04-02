<?php

namespace Clamidity\AuthNetBundle\Event;

use Symfony\Component\EventDispatcher\Event;
use Clamidity\AuthNetBundle\Model\PaymentProfile\PaymentProfileInterface;

/**
 * @author Michael Shattuck <ms2474@gmail.com> 
 */
class PaymentProfileEvent extends Event
{
    protected $paymentProfile;

    public function __construct(PaymentProfileInterface $paymentProfile)
    {
        $this->paymentProfile = $paymentProfile;
    }

    public function getPaymentProfile()
    {
        return $this->paymentProfile;
    }
}
