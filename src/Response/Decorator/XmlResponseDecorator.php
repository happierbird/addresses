<?php
namespace CoolBlue\Response\Decorator;


class XmlResponseDecorator extends ResponseDecorator
{
    public function output()
    {
        $data = $this->response->getData();

        $template = '<?xml version="1.0" encoding="UTF-8"?><person><name>%s</name><phone>%s</phone><address>%s</address></person>';
        $output = sprintf($template, $data['entityName'], $data['entityPhone'], $data['entityPhysicalAddress']);

        $this->response->setContent($output);
        $this->response->setContentType('text/xml');

        parent::output();
    }
}