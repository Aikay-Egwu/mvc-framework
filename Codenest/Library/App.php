<?php
namespace Codenest\Library ;

use Codenest\Library\Database as Database ;

/*
use Lib\Database ;
use Lib\Router ;*/

class App
{
    protected static $router ;


/**
* Gets the value of router.
*
* @return mixed
*/
    public static function getRouter()
    {
        return self::$router;
    }

    public static function db()
    {
        return new Database ;
    }

    public static function run($uri)
    {
        //echo "running  the run function";
        self::$router = new Router($uri);
        //$controller_class = ucfirst(self::$router->getController()).'Controller';
        $controller_class = ucfirst(self::$router->getController());
        $controller_method = strtolower(self::$router->getMethodPrefix().self::$router->getAction());
    //check user
        $layout = self::$router->getRoute();
    //echo "Layout : {$layout}<br>CLass: {$controller_class}<br>Method: {$controller_method}" ;
    //exit ;
        if ($layout == 'admin' && Session::get('role') != 'admin') {
            if ($controller_class != 'LoginController') {
                Router::redirect('/admin/login');
            }
        }


    //echo $controller_method ."<br>";
    //calling routers method
       /* $ns = "Controllers\\" ;
        echo "<br>";
        echo $ns.$controller_class;
        $controls = $ns.$controller_class;
        echo "<br>";*/
        $ns = "Codenest\\Controllers\\" ;
        $controls = $ns.$controller_class ;
        $controller_object = new $controls();
    //echo "<br>Controller class {$controller_class} <br>" ;
    //echo "<br>Controller method {$controller_method} <br>" ;
        if (method_exists($controller_object, $controller_method)) {
            $result = $controller_object->$controller_method();
    //controllers acton may return a view path
    //$view_path = $controller_object->$controller_method();
    //$view_object = new View($controller_object->getData(), $result);
    //$content = $view_object->render() ;
        } else {
            throw new \Exception('Method '.$controller_method .' of '. $controller_class . ' does not exist') ;
        }

//$layout = self::$router->getRoute() ;
//$layout_path = VIEWS_PATH.DS.$layout.'.php';
//$layout_view_object = new View(compact('content'), $layout_path);
//echo $layout_view_object->render();
    }
}
