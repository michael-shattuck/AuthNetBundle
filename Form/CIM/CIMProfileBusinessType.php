<?php

namespace Ms2474\AuthNetBundle\Form\CIM;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class CIMProfileBusinessType extends AbstractType
{
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
                'data' => 'business',
            ))
            ->add('shippingaddress', new CIMAddressType())
            ->add('paymentprofile', new CIMPaymentProfileType())
        ;
    }

    public function getName()
    {
        return 'ms2474_authnetbundle_cimprofilebusinesstype';
    }
}
