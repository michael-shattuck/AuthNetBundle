<?php

namespace Clamidity\AuthNetBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class CustomerProfileIndividualType extends AbstractType
{
    protected $class;
    protected $paymentProfileClass;
    protected $shippingAddressClass;

    public function __construct($dataClass, $payment_profile_class, $shipping_address_class)
    {
        $this->class = $dataClass;
        $this->paymentProfileClass = $payment_profile_class;
        $this->shippingAddressClass = $shipping_address_class;
    }
    
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('email', 'email', array(
                'required' => true
            ))
            ->add('customerdescription', 'textarea', array(
                'required' => 'true',
            ))
            ->add('type', 'hidden', array(
                'data' => 'individual',
            ))
            ->add('paymentprofile', new PaymentProfileType($this->paymentProfileClass, $this->shippingAddressClass))
        ;
    }

    public function getDefaultOptions()
    {
        return array(
            'data_class' => $this->class,
        );
    }

    public function getName()
    {
        return 'clamidity_authnetbundle_customerprofileindividualtype';
    }
}
