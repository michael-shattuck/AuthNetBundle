<?php

namespace Clamidity\AuthNetBundle\Form\CIM;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;
use Symfony\Component\Form\FormError;
use Symfony\Component\Form\CallbackValidator;
use Symfony\Component\Form\FormInterface;

class CIMPaymentProfileType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('cardnumber', 'number', array(
                'required' => true
            ))
            ->add('expirationyear', 'integer', array(
                'required' => true,
            ))
            ->add('expirationmonth', 'integer', array(
                'required' => true,
            ))
        ;

        $builder
            ->addValidator(new CallbackValidator(function(FormInterface $form) {
                if ($form["expirationyear"]->getData() < date('Y')) {
                    $form->addError(new FormError('Invalid expiration year.'));
                }
                if ($form["expirationmonth"]->getData() < 0 || $form["expirationmonth"]->getData() > 12) {
                    $form->addError(new FormError('Invalid expiration month.'));
                }
            }))
        ;
    }

    public function getName()
    {
        return 'clamidity_authnetbundle_cimpaymentprofiletype';
    }
}
