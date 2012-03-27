<?php

namespace Clamidity\AuthNetBundle\AuthorizeNet\Result;

use Clamidity\AuthNetBundle\AuthorizeNet\Result\AuthorizeNetException;
use Symfony\Component\DependencyInjection\ContainerAware;
use Clamidity\AuthNetBundle\AuthorizeNet\Result\AuthorizeNetLogWriter;

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
        if ($response) {
            $result = strip_tags($response->xml->messages->resultCode->asXML());
        } else {
            throw new AuthorizeNetException('Error: Invalid operation');
        }

        if (!$result || $result == 'Error') {
            if (!$this->debugMode) {
                throw new AuthorizeNetException($response->xml->messages->message->code.': '.$response->xml->messages->message->text);
            } else {
                $logObject = new AuthorizeNetLogWriter();
                $logObject->writeException($response->xml->messages->message->code.': '.$response->xml->messages->message->text.'\n');
            }

            return false;
        }

        return true;
    }

}