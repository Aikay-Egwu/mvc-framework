<?php
namespace Codenest\Library ;

class Router
{
    protected $url;
    protected $controller;
    protected $action;
    protected $params = null;
    protected $route;
    protected $method_prefix;
    protected $language;

    public function __construct($uri)
    {
        //echo "<br>Starting the router";
        $this->uri = urldecode(trim($uri, '/'));
        //get defaults
        $routes              = Config::get('routes');
        $this->route         = Config::get('default_route');
        $this->method_prefix = (isset($routes[$this->route])) ? $routes[$this->route] : '';
        $this->language      = Config::get('default_language');
        $this->controller    = Config::get('default_controller');
        $this->action        = Config::get('default_action');
        $uri_parts           = explode('?', $this->uri);
        $path                = $uri_parts[0];
        $path_parts          = explode('/', $path);
    
        if (ROOT_FOLDER != "") {
            array_shift($path_parts);
        }

        if (count($path_parts)) {
//get router or language at first element
            if (in_array(strtolower(current($path_parts)), array_keys($routes))) {
                $this->route         = strtolower(current($path_parts));
                $this->method_prefix = isset($routes[$this->route]) ? $routes[$this->route] : '';
                array_shift($path_parts);
            } elseif (in_array(strtolower(current($path_parts)), Config::get('languages'))) {
                $this->language = strtolower(current($path_parts));
                array_shift($path_parts);
            }
            //get the controller, next element of array
            if (current($path_parts)) {
                $this->controller = strtolower(current($path_parts));
                array_shift($path_parts);
            }
//get action
            if (current($path_parts)) {
                $this->action = strtolower(current($path_parts));
                array_shift($path_parts);
            }

            $this->params = $path_parts;
        }
    }

    public static function redirect($uri)
    {
        header("location: " . ROOT_FOLDER.$uri);
    }
    /**
     * Gets the value of url.
     *
     * @return mixed
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Gets the value of controller.
     *
     * @return mixed
     */
    public function getController()
    {
        return $this->controller;
    }

    /**
     * Gets the value of action.
     *
     * @return mixed
     */
    public function getAction()
    {
        return $this->action;
    }

    /**
     * Gets the value of params.
     *
     * @return mixed
     */
    public function getParams()
    {
        return $this->params;
    }

    /**
     * Gets the value of route.
     *
     * @return mixed
     */
    public function getRoute()
    {
        return $this->route;
    }

    /**
     * Gets the value of method_prefix.
     *
     * @return mixed
     */
    public function getMethodPrefix()
    {
        return $this->method_prefix;
    }

    /**
     * Gets the value of language.
     *
     * @return mixed
     */
    public function getLanguage()
    {
        return $this->language;
    }
}
