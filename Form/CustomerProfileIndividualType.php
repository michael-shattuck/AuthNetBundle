<?php

namespace Clamidity\AuthNetBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class CustomerProfileIndividualType extends AbstractType
{
    protected $class;
    protected $paymentProfileType;

    public function __construct($dataClass, $payment_profile_type)
    {
        $this->class = $dataClass;
        $this->class = $payment_profile_type;
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
            ->add('paymentprofile', $this->paymentProfileType())
        ;
    }

    public function getDefaultOptions(array $options)
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
