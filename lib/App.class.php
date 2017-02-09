<?php
/**
 * Created by PhpStorm.
 * User: cyber10
 * Date: 6/02/2017
 * Time: 15:22
 */
require_once ('twig.class.php');
class App
{
    protected static $router;

    /**
     * @return mixed
     */
    public static function getRouter()
    {
        return self::$router;
    }
    public static function run($uri)
    {
        self::$router=new Router($uri);

        $controller_class=ucfirst(self::$router->getController()).'Controller'; //de controller
        $controller_method=strtolower(self::$router->getMethodPrefix().self::$router->getAction());  //de actie

        //Calling controller's method
        $controller_object=new $controller_class(); //object van de controller
        if(method_exists($controller_object,$controller_method)){
            //Controller's action may return a view path
            $view_path=$controller_object->$controller_method();
            $view_object=new View($controller_object->getData(),$view_path);

            $content=$view_object->render();

        }else {
            throw new Exception('Method '.$controller_method.' of class '.$controller_class.'bestaat niet');
        }

        $layout=self::$router->getRoute(); //de route

        $layout_path=VIEWS_PATH.DS.$layout.'.twig';

        $layout_view_object=new View(compact('content'),$layout_path);
        print_r($layout_view_object);
    //    $layout_view_object=new View(compact('inhoud'),$layout_path);

        echo $layout_view_object->render();

    }

}