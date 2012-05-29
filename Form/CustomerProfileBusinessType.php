<?php

namespace Clamidity\AuthNetBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class CustomerProfileBusinessType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
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
        return 'clamidity_authnetbundle_customerprofilebusinesstype';
    }
}
