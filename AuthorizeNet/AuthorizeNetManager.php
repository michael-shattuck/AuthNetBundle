<?php

namespace Clamidity\AuthNetBundle\AuthorizeNet;

use Clamidity\AuthNetBundle\AuthorizeNet\API\AIM\AuthorizeNetAIM;
use Clamidity\AuthNetBundle\AuthorizeNet\API\AIM\AuthorizeNetAIM_Response;
use Clamidity\AuthNetBundle\AuthorizeNet\API\ARB\AuthorizeNetARB;
use Clamidity\AuthNetBundle\AuthorizeNet\API\ARB\AuthorizeNetARB_Response;
use Clamidity\AuthNetBundle\AuthorizeNet\API\CIM\AuthorizeNetCIM;
use Clamidity\AuthNetBundle\AuthorizeNet\API\CIM\AuthorizeNetCIM_Response;
use Clamidity\AuthNetBundle\AuthorizeNet\API\CP\AuthorizeNetCP;
use Clamidity\AuthNetBundle\AuthorizeNet\API\CP\AuthorizeNetCP_Response;
use Clamidity\AuthNetBundle\AuthorizeNet\API\DPM\AuthorizeNetDPM;
use Clamidity\AuthNetBundle\AuthorizeNet\API\SIM\AuthorizeNetSIM;
use Clamidity\AuthNetBundle\AuthorizeNet\API\TD\AuthorizeNetTD;
use Clamidity\AuthNetBundle\AuthorizeNet\API\TD\AuthorizeNetTD_Response;

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