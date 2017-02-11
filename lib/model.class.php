<?php
/**
 * Created by PhpStorm.
 * User: Leen
 * Date: 9/02/2017
 * Time: 18:25
 */

class Model {

    protected $db;

    /**
     * Model constructor.
     * @param $db
     */
    public function __construct()
    {
        $this->db =App::$db;
    }


}