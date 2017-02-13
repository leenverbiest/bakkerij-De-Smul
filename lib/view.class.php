<?php
/**
 * Created by PhpStorm.
 * User: Leen
 * Date: 8/02/2017
 * Time: 9:07
 */
require_once ('vendor/Twig/Autoloader.php');

class View{
    protected $data;
    protected $path;


    protected static function getDefaultViewPath(){
        $router=App::getRouter();
        if(!$router){
            return false;
        }
        $arrPathTwig=array();
        $controller_dir=$router->getController(); //directory in views for the specified controller f.e. 'pages'
        $twig_name=$router->getMethodPrefix().$router->getAction().'.twig'; //naam van het twig-bestand
        $fullPath=VIEWS_PATH.DS.$controller_dir.DS.$twig_name; //f.e. the folder views and subfolder 'controller'
        array_push($arrPathTwig,$twig_name,$fullPath);
        return $arrPathTwig;
//        print_r($arrPathTwig);
    }


    /**
     * View constructor.
     * @param $data
     * @param $path
     */
    public function __construct($data=array(), $path=null)
    {
        /**
         * @path:$twig_name
         */
        if(!$path){
            //$path=DEFAULT PATH...
            $path=self::getDefaultViewPath();
        }
        if (!file_exists($path[1])){
            throw new Exception('Twig file is not found in path: '.$path);
        }
        //print $path; print'<br/>';
        $this->path = $path[0];
        $this->data = $data;
    }

        public function render($twig_name,$data)
        {
            Twig_Autoloader::register();
            $loader=new Twig_Loader_Filesystem(array(ROOT.DS.'views',ROOT.DS.'views'.DS.'klant',
                                                ROOT.DS.'views'.DS.'product',ROOT.DS.'views'.DS.'admin'));
            $twig=new Twig_Environment($loader);
            $view=$twig->render($twig_name,$data);
            print $view;
        }

    /**
     * @return array
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @return bool|null|string
     */
    public function getPath()
    {
        return $this->path;
    }








}