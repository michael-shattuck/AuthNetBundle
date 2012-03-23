<?php

namespace Ms2474\AuthNetBundle\AuthorizeNet;

use Ms2474\AuthNetBundle\AuthorizeNet\API\AIM\AuthorizeNetAIM;
use Ms2474\AuthNetBundle\AuthorizeNet\API\AIM\AuthorizeNetAIM_Response;
use Ms2474\AuthNetBundle\AuthorizeNet\API\ARB\AuthorizeNetARB;
use Ms2474\AuthNetBundle\AuthorizeNet\API\ARB\AuthorizeNetARB_Response;
use Ms2474\AuthNetBundle\AuthorizeNet\API\CIM\AuthorizeNetCIM;
use Ms2474\AuthNetBundle\AuthorizeNet\API\CIM\AuthorizeNetCIM_Response;
use Ms2474\AuthNetBundle\AuthorizeNet\API\CP\AuthorizeNetCP;
use Ms2474\AuthNetBundle\AuthorizeNet\API\CP\AuthorizeNetCP_Response;
use Ms2474\AuthNetBundle\AuthorizeNet\API\DPM\AuthorizeNetDPM;
use Ms2474\AuthNetBundle\AuthorizeNet\API\SIM\AuthorizeNetSIM;
use Ms2474\AuthNetBundle\AuthorizeNet\API\TD\AuthorizeNetTD;
use Ms2474\AuthNetBundle\AuthorizeNet\API\TD\AuthorizeNetTD_Response;

/**
 * @author Michael Shattuck <ms2474@gmail.com>
 */
class AuthorizeNetManager extends AuthorizeNetDataTypeManager
{
    protected $loginId;
    protected $transactionKey;
    protected $sandbox;
    protected $logFile;

    public function __construct($loginId, $transactionKey, $sandbox = true, $logFile = null)
    {   
        $this->loginId = $loginId;
        $this->transactionKey = $transactionKey;
        $this->sandbox = $sandbox;
        $this->logFile = $logFile;
    }

    public function getCIMManager()
    {
        return new Manager\CIMManager($this->getAuthorizeNetCIM(), $this->sandbox);
    }

    private function getAuthorizeNetCIM()
    {
        return new AuthorizeNetCIM($this->loginId, $this->transactionKey, $this->sandbox, $this->logFile);
    }
}