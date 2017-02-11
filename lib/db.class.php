<?php
/**
 * Created by PhpStorm.
 * User: Leen
 * Date: 9/02/2017
 * Time: 15:52
 */
class DBClass
{
    protected $connection;

    /**
     * DB constructor.
     * @param $connection
     */
    public function __construct($conn, $username, $password)
    {
        try {
            $this->connection = new PDO($conn, $username, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
            return $this;
        } catch (PDOException $e) {
            echo 'Kon niet verbinden met de database ' . $e->getMessage();
        }

    }

    public function query($sql)
    {
        if (!$this->connection) {
            return false;
        }
        try {
            $result = $this->connection->query($sql);
            if ($result) return $result;
        } catch (PDOException $e) {
            echo $e->getMessage();
        };
    }
    public function prepare($sql){
        if (!$this->connection){
            return false;
        }
        try{
            $result=$this->connection->prepare($sql);
            if ($result)return $result;
        }catch (PDOException $e){
            echo $e->getMessage();
        }
    }
    public function execute($sql){
        if (!$this->connection){
            return false;
        }
        try{
            $result=$this->connection->exec($sql);
            if ($result)return $result;
        }catch (PDOException $e){
            echo $e->getMessage();
        }
    }

}

