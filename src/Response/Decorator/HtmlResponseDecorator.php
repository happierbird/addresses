<?php
namespace CoolBlue\Response\Decorator;


class HtmlResponseDecorator extends ResponseDecorator
{
    public function output()
    {
        $data = $this->response->getData();

        $template = '<b>Name: </b><span>%s</span><br><b>Phone: </b><span>%s</span><br><b>Address: </b><span>%s</span><br>';
        $output = sprintf($template, $data['entityName'], $data['entityPhone'], $data['entityPhysicalAddress']);

        $this->response->setContent($output);
        $this->response->setContentType('text/html');

        parent::output();
    }
}