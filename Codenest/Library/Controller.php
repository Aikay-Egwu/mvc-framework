<?php
namespace Codenest\Library ;

use Codenest\Library\View as View;

//use Lib\Session ;

/**
 *
 */
class Controller
{
    protected $data ;
    protected $model ;
    protected $params ;
    protected $route ;

/**
 * [__construct description]
 * @param array $data [description]
 */
    public function __construct($data = array())
    {
        $this->data = $data ;
        $this->params = App::getRouter()->getParams();
        $this->route = App::getRouter()->getRoute();
    }

/**
     * Gets the value of data.
     *
     * @return mixed
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * Gets the value of model.
     *
     * @return mixed
     */
    public function getModel()
    {
        return $this->model;
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

    protected function route()
    {
        $view_object = new View($this->data, null);
        $content = $view_object->render();
        $layout_path = VIEWS_PATH.DS.$this->route.'.php';
        //echo $layout_path ;
        $layout_view_object = new View(compact('content'), $layout_path);
        //echo "<pre>";
        //var_dump($layout_view_object);
        //echo "</pre>";
        echo $layout_view_object->render();
    }
}
