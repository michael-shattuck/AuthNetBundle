<?php

namespace Clamidity\AuthNetBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;
use Symfony\Component\Form\FormError;
use Symfony\Component\Form\CallbackValidator;
use Symfony\Component\Form\FormInterface;

class PaymentProfileType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('cardnumber', 'text', array(
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
                if (!is_numeric($form["cardnumber"]->getData()) || strlen($form["cardnumber"]->getData()) < 14 || strlen($form["cardnumber"]->getData()) > 16) {
                    $form->addError(new FormError('Invalid card number.'));
                }
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
