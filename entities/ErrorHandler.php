<?php

/**
 * Created by PhpStorm.
 * User: Leen
 * Date: 11/02/2017
 * Time: 16:46
 */
class Errorhandler
{
    protected $errors=[];

    public function addErrors($error,$key=null)
    {
        if($key)
        {
            $this->errors[$key][]=$error;
        }
        else
        {
            $this->errors[]=$error;
        }
    }
    public function all($key=null)
    {
        return isset($this->errors[$key]) ? $this->errors[$key]:$this->errors;
    }

    public function hasErrors()
    {
        return count($this->all())? true:false;  //returns a BOOLEAN
    }

    public function first($key)
    {
        return isset($this->all()[$key][0])?$this->all()[$key][0]:'';
    }
}