<?php

namespace Ms2474\AuthNetBundle\AuthorizeNet\Result;

use Ms2474\AuthNetBundle\AuthorizeNet\Result\AuthorizeNetException;
use Symfony\Component\DependencyInjection\ContainerAware;
use Ms2474\AuthNetBundle\AuthorizeNet\Result\AuthorizeNetLogWriter;

/**
 * @author Michael Shattuck <ms2474@gmail.com>
 */
class AuthorizeNetResultHandler extends ContainerAware
{
    protected $debugMode;

    public function __construct()
    {
        $this->debugMode = $this->container->getParameter('authorize_net.sandbox');
    }

    public function checkResult($response)
    {
        $result = $response->xml->messages->resultCode;

        if (!$result || $result === 'Error') {
            if ($this->debugMode) {
                throw new AuthorizeNetException($response->xml->messages->message->code.': "'.$response->xml->messages->message->text.'"\n');
            } else {
                $logObject = new AuthorizeNetLogWriter();
                $logObject->writeException($response->xml->messages->message->code.': "'.$response->xml->messages->message->text.'"\n');
            }

            return false;
        }

        return true;
    }

}