<?php

namespace Clamidity\AuthNetBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class ShippingAddressType extends AbstractType

{
    protected $class;

    public function __construct($dataClass)
    {
        $this->class = $dataClass;
    }

    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('firstname', 'text', array(
                'required' => true
            ))
            ->add('lastname', 'text', array(
                'required' => true
            ))
            ->add('phonenumber', 'text', array(
                'required' => true
            ))
            ->add('faxnumber', 'text', array(
                'required' => false
            ))
            ->add('company', 'text', array(
                'required' => false
            ))
            ->add('address', 'text', array(
                'required' => true
            ))
            ->add('city', 'text', array(
                'required' => true
            ))
            ->add('state', 'text', array(
                'required' => true
            ))
            ->add('zip', 'text', array(
                'required' => true
            ))
            ->add('country', 'text', array(
                'required' => true
            ))
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
        return 'clamidity_authnetbundle_customerprofileaddresstype';
    }
}
