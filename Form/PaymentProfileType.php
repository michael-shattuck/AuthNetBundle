<?php

namespace Clamidity\AuthNetBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormError;
use Symfony\Component\Form\CallbackValidator;
use Symfony\Component\Form\FormInterface;

class PaymentProfileType extends AbstractType

{
    protected $class;
    protected $shippingAddressClass;

    public function __construct($dataClass, $shipping_address_class)
    {
        $this->class = $dataClass;
        $this->shippingAddressClass = $shipping_address_class;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('cardnumber', 'text', array(
                'required' => true
            ))
            ->add('expirationyear', 'number', array(
                'required' => true,
                'attr' => array('placeholder' => 'XXXX'),
            ))
            ->add('expirationmonth', 'text', array(
                'required' => true,
                'attr' => array('placeholder' => 'XX'),
            ))
            ->add('billingaddress', new ShippingAddressType($this->shippingAddressClass))
            ->add('sameAsShipping', 'checkbox', array(
                'label' => 'Use address for shipping?',
                'required' => false
            ))
        ;

        $builder
            ->addValidator(new CallbackValidator(function(FormInterface $form) {
                if (!is_numeric($form["cardnumber"]->getData()) || strlen($form["cardnumber"]->getData()) < 14 || strlen($form["cardnumber"]->getData()) > 16) {
                    $form->addError(new FormError('Invalid card number.'));
                }
                if (!is_numeric($form["expirationyear"]->getData()) || $form["expirationyear"]->getData() < date('Y')) {
                    $form->addError(new FormError('Invalid expiration year.'));
                }
                if (!is_numeric($form["expirationmonth"]->getData()) || $form["expirationmonth"]->getData() < 0 || $form["expirationmonth"]->getData() > 12) {
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
