<?php
namespace CoolBlue\Controller;

use CoolBlue\Services\ConfigurationReader;


class BaseController
{
    const HTTP_STATUS_OK = 200;
    const HTTP_STATUS_CREATED = 201;
    const HTTP_STATUS_NO_CONTENT = 204;
    const HTTP_STATUS_BAD_REQUEST = 400;

    protected $config = null;

    public function __construct() {
        $this->config = ConfigurationReader::readFromJsonFile(__DIR__ . '/../../Resources/Config/api-config.json');
    }
}
