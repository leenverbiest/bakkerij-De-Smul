<?php
/**
 * Created by PhpStorm.
 * User: cyber10
 * Date: 6/02/2017
 * Time: 15:24
 */
class Controller
{
    protected $data;
    protected $model;
    protected $params;

    /**
     * Controller constructor.
     * @param $data
     */
    public function __construct($aTwig=array())
    {
        $this->aTwig = $aTwig;
        $this->params=App::getRouter()->getParams();
    }

    /**
     * @return mixed
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @return mixed
     */
    public function getModel()
    {
        return $this->model;
    }

    /**
     * @return mixed
     */
    public function getParams()
    {
        return $this->params;
    }


}