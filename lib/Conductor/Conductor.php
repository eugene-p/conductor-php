<?php
namespace Conductor;

class Conductor
{
    const ALL = 'all';
    public function __construct($method = null)
    {
        if ($method !== null) {
            $this->setMethod($method);
        }
    }

    public function run($request)
    {
        if (!is_string($request)) {
            throw new \InvalidArgumentException("Request is expected to be a string");
        }

        $routes = $this->getRoutes();
        foreach ($routes as $route => $action)
        {
            if ($request === $route) {
                return $action();
            } 
        }

        throw new \RuntimeException('Can not find matching route.');
    }

    public function getRoutes($method = null) 
    {
        if ($method === null) {
            $method = $this->_method;
        }

        if (!is_string($method)) {
            throw new \InvalidArgumentException("Method is expected to be a string");
        }

        $method = strtolower($method);

        $routes = array();
        if (array_key_exists(self::ALL, $this->_availableRoutes)) {
            $routes = $this->_availableRoutes[self::ALL]; 
        }

        if (array_key_exists($method, $this->_availableRoutes)) {
            $routes = array_replace($routes, $this->_availableRoutes[$method]); 
        }

        return $routes;
    }

    public function addRoutes(array $routes, $method = self::ALL)
    {
        if (!is_string($method)) {
            throw new \InvalidArgumentException("Method is expected to be a string");
        }
      
        if (!array_key_exists($method, $this->_availableRoutes)) {
            $this->_availableRoutes[$method] = $routes;
        } else {
            $this->_availableRoutes[$method] = array_replace(
                $this->_availableRoutes[$method], 
                $routes
            );
        }

        return $this;
    }

    public function setMethod($method)
    {
        if (!is_string($method)) {
            throw new \InvalidArgumentException("Method is expected to be a string");
        }
   
        $this->_method = strtolower($method);
        return $this;
    }

    protected $_method;
    protected $_availableRoutes = array();
}
