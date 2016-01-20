<?php
namespace CoolBlue\Response\Decorator;


class JsonResponseDecorator extends ResponseDecorator
{
    public function output()
    {
        $data = $this->response->getData();
        $this->response->setContent(json_encode($data));
        $this->response->setContentType('application/json');

        parent::output();
    }
}