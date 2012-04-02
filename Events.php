<?php

namespace Clamidity\AuthNetBundle;

/**
 * @author Michael Shattuck <ms2474@gmail.com>
 */
class Events
{
    const CUSTOMER_ADD_ADDRESS  = 'clamidity_authnet.customer.add_address';
    const CUSTOMER_ADD_PAYMENTPROFILE = 'clamidity_authnet.customer.add_paymentprofile';
    const CUSTOMER_ADD_TRANSACTION = 'clamidity_authnet.customer.add_transaction';

    const CUSTOMER_PRE_PERSIST = 'clamidity_authnet.customer.pre_persist';
    const CUSTOMER_POST_PERSIST = 'clamidity_authnet.customer.post_persist';

    const PAYMENTPROFILE_PRE_PERSIST = 'clamidity_authnet.paymentprofile.pre_persist';
    const PAYMENTPROFILE_POST_PERSIST = 'clamidity_authnet.paymentprofile.post_persist';

    const SHIPPINGADDRESS_PRE__PERSIST = 'clamidity_authnet.shippingaddress.pre_persist';
    const SHIPPINGADDRESS_POST_PERSIST = 'clamidity_authnet.shippingaddress.post_persist';

    const TRANSACTION_PRE_PERSIST = 'clamidity_authnet.transaction.pre_persist';
    const TRANSACTION_POST_PERSIST = 'clamidity_authnet.transaction.post_persist';
}