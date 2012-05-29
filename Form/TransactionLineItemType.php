<?php

namespace Clamidity\AuthNetBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class TransactionLineItemType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('itemId', 'text', array(
                'required' => true
            ))
            ->add('name', 'text', array(
                'required' => true
            ))
            ->add('description', 'textarea', array(
                'required' => false
            ))
            ->add('quantity', 'integer', array(
                'required' => true
            ))
            ->add('unitPrice', 'money', array(
                'required' => true,
                'currency' => 'USD'
            ))
            ->add('taxable', 'checkbox', array(
                'label' => 'Taxable?',
                'required' => false
            ))
        ;
    }

    public function getName() {
        return 'clamidity_authnet_tansaction_lineitemtype';
    }
}