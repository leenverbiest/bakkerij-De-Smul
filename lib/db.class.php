<?php
/**
 * Created by PhpStorm.
 * User: Leen
 * Date: 9/02/2017
 * Time: 15:52
 */
class DB
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
            echo "Verbonden met database";
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
            if ($result) print 'success!';
        } catch (PDOException $e) {
            echo $e->getMessage();
        };


        if ($result) {
            return $result;
        }
        $data = array();
        foreach ($result as $rij) {
            array_push($lijst, $rij);
            return $data;
        }
    }

    public function escape($str){

    }

}