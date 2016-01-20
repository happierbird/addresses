<?php
namespace CoolBlue\Services\Router;

use CoolBlue\Request\Request;
use CoolBlue\Response\Response;
use CoolBlue\Response\Decorator\ResponseDecoratorFactory;

class Router
{
    /**
     * Array with all routes available
     *
     * @var array
     */
    private $routes = array();

    /**
     * Array with matched parameters
     *
     * @var array
     */
    private $matchedParameters = array();

    /**
     * String matched controller
     *
     * @var array
     */
    private $matchedController = null;

    /**
     * String matched method name
     *
     * @var array
     */
    private $matchedMethodName = null;

    public function __construct(array $config)
    {
        if (!empty($config['routes'])) {
            $this->routes = $config['routes'];
        }
    }

    /**
     * Dispatch current request
     *
     * @var Request $request
     *
     * @throws RouteNotFoundException
     */
    public function dispatchRequest(Request $request)
    {
        if ($this->match($request->path, $request->method)) {
            $this->dispatch($request);
        } else {
            throw new RouteNotFoundException(sprintf('Unable to find the controller for path "%s".', $request->path));
        }
    }

    /**
     * Create instance, bind parameters, output response
     *
     * @var Request $request
     */
    private function dispatch(Request $request)
    {
        $instance = new $this->matchedController($request);
        $response = call_user_func_array(array($instance, $this->matchedMethodName), $this->matchedParameters);
        if ($response instanceof Response) {
            $responseDecorator = ResponseDecoratorFactory::getDecoratorInstance($response);
            if ($responseDecorator) {
                $responseDecorator->output();
            } else {
                $response->output();
            }
        }
    }

    /**
     * Match incoming request url and request method
     *
     * @param string $requestUrl
     * @param string $requestMethod
     *
     * @return bool
     */
    public function match($requestUrl, $requestMethod = 'GET')
    {
        foreach ($this->routes as $routeOptions) {
            // compare request method
            if ($requestMethod !== $routeOptions['method']) {
                continue;
            }

            $validationRegex = addcslashes($routeOptions['path'], '/.');
            if (!empty($routeOptions['requirements'])) {
                foreach ($routeOptions['requirements'] as $fieldName => $fieldRegex) {
                    $validationRegex = str_replace('{' . $fieldName . '}', $fieldRegex, $validationRegex);
                }
            }

            if (!preg_match('/^' . $validationRegex . '$/', $requestUrl, $matches)) {
                continue;
            }

            if (!empty($routeOptions['requirements'])) {
                $matchedString = array_shift($matches);
                if (count($matches) !== count($routeOptions['requirements'])) {
                    continue;
                }

                $parameters = array();
                $parameterKeys = array_keys($routeOptions['requirements']);
                foreach ($parameterKeys as $i => $key) {
                    $parameters[$key] = $matches[$i];
                }
            }

            list($controller, $method) = explode('::', $routeOptions['controller']);
            $this->setMatchedController($controller);
            $this->setMatchedMethodName($method);
            if (!empty($parameters)) {
                $this->setMatchedParameters($parameters);
            }

            return true;
        }

        return false;
    }

    public function getMatchedParameters()
    {
        return $this->matchedParameters;
    }

    public function setMatchedParameters(array $parameters)
    {
        $this->matchedParameters = $parameters;
    }

    public function getMatchedController()
    {
        return $this->matchedController;
    }

    public function setMatchedController($controller)
    {
        $this->matchedController = $controller;
    }

    public function getMatchedMethodName()
    {
        return $this->matchedMethodName;
    }

    public function setMatchedMethodName($methodName)
    {
        $this->matchedMethodName = $methodName;
    }
}

class RouteNotFoundException extends \Exception {}