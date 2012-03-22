<?php

namespace Ms2474\AuthNetBundle\Form\CIM;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class CIMPaymentProfileType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('cardnumber', 'number', array(
                'required' => true
            ))
            ->add('expirationdate', 'date', array(
                'required' => true,
                'input' => 'string',
                'widget' => 'choice',
                'pattern' => '{{ year }} - {{ month }}',
                'format' => 'yyyy-MM'
            ))
        ;
    }

    public function getName()
    {
        return 'ms2474_authnetbundle_cimpaymentprofiletype';
    }
}
