<?php

namespace Ms2474\AuthNetBundle\AuthorizeNet\API\ARB;

use Ms2474\AuthNetBundle\AuthorizeNet\Shared\AuthorizeNetXMLResponse;

/**
 * A class to parse a response from the ARB XML API.
 *
 * @package    AuthorizeNet
 * @subpackage AuthorizeNetARB
 */
class AuthorizeNetARBResponse extends AuthorizeNetXMLResponse
{

    /**
     * @return int
     */
    public function getSubscriptionId()
    {
        return $this->_getElementContents("subscriptionId");
    }
    
    /**
     * @return string
     */
    public function getSubscriptionStatus()
    {
        return $this->_getElementContents("Status");
    }

}
