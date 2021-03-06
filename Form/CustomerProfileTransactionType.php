<?php

namespace Clamidity\AuthNetBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormError;
use Symfony\Component\Form\CallbackValidator;
use Symfony\Component\Form\FormInterface;
use Doctrine\ORM\EntityRepository;

class CustomerProfileTransactionType extends AbstractType
{
    protected $customerId;

    public function __construct($customerId)
    {
        $this->customerId = $customerId;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $customerId = $this->customerId;
        $builder
            ->add('lineItem', new TransactionLineItemType())
            ->add('addressProfile', 'entity', array(
                'class' => 'ClamidityAuthNetBundle:ShippingAddress',
                'property' => 'address',
                'query_builder' => function(EntityRepository $er) use ($customerId) {
                    $qb = $er->createQueryBuilder('u');
                    $qb->add('select', 'u')
                       ->add('from', 'ClamidityAuthNetBundle:ShippingAddress u')
                       ->add('where', 'u.customer = :customerId')
                       ->add('orderBy', 'u.shippingAddressId ASC')
                       ->setParameter(':customerId', $customerId);
                    return $qb;
                },
            ))
            ->add('paymentProfile', 'entity', array(
                'class' => 'ClamidityAuthNetBundle:PaymentProfile',
                'property' => 'accountNumber',
                'query_builder' => function(EntityRepository $er) use ($customerId) {
                    $qb = $er->createQueryBuilder('u');
                    $qb->add('select', 'u')
                       ->add('from', 'ClamidityAuthNetBundle:PaymentProfile u')
                       ->add('where', 'u.customer = :customerId')
                       ->add('orderBy', 'u.paymentProfileId ASC')
                       ->setParameter(':customerId', $customerId);
                    return $qb;
                },
            ))
            
        ;
    }

    public function getName()
    {
        return 'clamidity_authnetbundle_cimtransactiontype';
    }
}
