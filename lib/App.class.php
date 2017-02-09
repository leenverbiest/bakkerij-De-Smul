<?php
/**
 * Created by PhpStorm.
 * User: cyber10
 * Date: 6/02/2017
 * Time: 15:22
 */


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
            //als de methode bestaat in de controller
            $view_path=$controller_object->$controller_method(); //de methode (actie)
            $view_object=new View($controller_object->getData(),$view_path);
            print_r($view_object);
            $twig_name=$view_object->getPath();
           $data=$view_object->getData();
           $view_object->render($twig_name,$data);

        }else {
            throw new Exception('Method '.$controller_method.' of class '.$controller_class.'bestaat niet');
        }

    }
}