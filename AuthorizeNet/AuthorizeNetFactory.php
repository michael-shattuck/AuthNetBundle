<?php

namespace Clamidity\AuthNetBundle\AuthorizeNet;

/**
 * @author Michael Shattuck <ms2474@gmail.com>
 */
class AuthorizeNetFactory
{
    public function get($loginId, $transactionKey, $sandbox, $logFile)
    {
        $authorizeNetManager = new AuthorizeNetManager(
                $loginId, 
                $transactionKey, 
                $sandbox, 
                $logFile
        );

        return $authorizeNetManager;
    }
}