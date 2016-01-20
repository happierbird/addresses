<?php
namespace CoolBlue\Response\Decorator;

use CoolBlue\Response\Response;

class ResponseDecoratorFactory
{
    public static function getDecoratorInstance(Response $response)
    {
        $responseData = $response->getData();
        if (!empty($responseData)) {
            $format = $response->getFormat();
            switch ($format) {
                case 'html':
                    $decorator = new HtmlResponseDecorator($response);
                    break;
                case 'json':
                    $decorator = new JsonResponseDecorator($response);
                    break;
                case 'xml':
                    $decorator = new XmlResponseDecorator($response);
                    break;
                default:
                    $decorator = new JsonResponseDecorator($response);
                    break;
            }

            return $decorator;
        }

        return null;
    }
}