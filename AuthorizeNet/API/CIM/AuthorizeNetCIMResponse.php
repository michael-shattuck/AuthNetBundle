<?php

namespace Ms2474\AuthNetBundle\AuthorizeNet\API\CIM;

use Ms2474\AuthNetBundle\AuthorizeNet\Shared\AuthorizeNetXMLResponse;

/**
 * A class to parse a response from the CIM XML API.
 *
 * @package    AuthorizeNet
 * @subpackage AuthorizeNetCIM
 */
class AuthorizeNetCIMResponse extends AuthorizeNetXMLResponse
{
    /**
     * @return AuthorizeNetAIM_Response
     */
    public function getTransactionResponse()
    {
        return new AuthorizeNetAIM_Response($this->_getElementContents("directResponse"), ",", "", array());
    }
    
    /**
     * @return array Array of AuthorizeNetAIM_Response objects for each payment profile.
     */
    public function getValidationResponses()
    {
        $responses = (array)$this->xml->validationDirectResponseList;
        $return = array();
        foreach ((array)$responses["string"] as $response) {
            $return[] = new AuthorizeNetAIM_Response($response, ",", "", array());
        }
        return $return;
    }
    
    /**
     * @return AuthorizeNetAIM_Response
     */
    public function getValidationResponse()
    {
        return new AuthorizeNetAIM_Response($this->_getElementContents("validationDirectResponse"), ",", "", array());
    }
    
    /**
     * @return array
     */
    public function getCustomerProfileIds()
    {
        $ids = (array)$this->xml->ids;
        return $ids["numericString"];
    }
    
    /**
     * @return array
     */
    public function getCustomerPaymentProfileIds()
    {
        $ids = (array)$this->xml->customerPaymentProfileIdList;
        return $ids["numericString"];
    }
    
    /**
     * @return array
     */
    public function getCustomerShippingAddressIds()
    {
        $ids = (array)$this->xml->customerShippingAddressIdList;
        return $ids["numericString"];
    }
    
    /**
     * @return string
     */
    public function getCustomerAddressId()
    {
        return $this->_getElementContents("customerAddressId");
    }
    
    /**
     * @return string
     */
    public function getCustomerProfileId()
    {
        return $this->_getElementContents("customerProfileId");
    }
    
    /**
     * @return string
     */
    public function getPaymentProfileId()
    {
        return $this->_getElementContents("customerPaymentProfileId");
    }

}