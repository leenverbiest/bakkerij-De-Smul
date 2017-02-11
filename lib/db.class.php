<?php
/**
 * Created by PhpStorm.
 * User: Leen
 * Date: 11/02/2017
 * Time: 22:13
 */
class DB{
    protected $connection;

    public function __construct($conn, $username, $password)
    {
        try {
            $this->connection = new PDO($conn, $username, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
            return $this;
        } catch (PDOException $e) {
            echo 'Kon niet verbinden met de database ' . $e->getMessage();
        }
    }

    /**
     * @return PDO
     */
    public function getConnection()
    {
        return $this->connection;
    }


}