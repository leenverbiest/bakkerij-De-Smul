<?php
/**
 * Created by PhpStorm.
 * User: Leen
 * Date: 8/02/2017
 * Time: 9:07
 */
class View{
    protected $data;
    protected $path;


    protected static function getDefaultViewPath(){
        $router=App::getRouter();
        if(!$router){
            return false;
        }
        $controller_dir=$router->getController(); //directory in views for the specified controller f.e. 'pages'
        $twig_name=$router->getMethodPrefix().$router->getAction().'.twig'; //naam van het twig-bestand
        return VIEWS_PATH.DS.$controller_dir.DS.$twig_name; //f.e. the folder views and subfolder 'controller'
    }


    /**
     * View constructor.
     * @param $data
     * @param $path
     */
    public function __construct($data=array(), $path=null)
    {
        if(!$path){
            //$path=DEFAULT PATH...
            $path=self::getDefaultViewPath();
        }
        if (!file_exists($path)){
            throw new Exception('Twig file is not found in path: '.$path);
        }
        //print $path; print'<br/>';
        $this->path = $path;
        $this->data = $data;
    }

    public function render(){
        $data=$this->data;

        ob_start(); //zet outputbuffering aan
        include ($this->path);
        $content=ob_get_clean();

        return $content;

    }



}