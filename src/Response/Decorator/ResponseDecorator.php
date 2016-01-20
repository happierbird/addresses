<?php
namespace CoolBlue\Response\Decorator;

use CoolBlue\Response\Response;


class ResponseDecorator extends AbstractResponseDecorator
{
    protected $response = null;

    public function __construct(Response $response)
    {
        $this->response = $response;
    }

    protected function getResponse()
    {
        return $this->response;
    }

    public function output()
    {
        $this->getResponse()->output();
    }
}