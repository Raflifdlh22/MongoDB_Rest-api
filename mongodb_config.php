<?php

class DbManager
{

    //data Base Configuration
    private $dbhost = "localhost";
    private $dbport = "27017";
    public $conn;

    // get the database connection MongoDB
    function __Construct()
    {
        // Connecting To MongoDB
        try {
            $this->conn = new MongoDB\Driver\Manager('mongodb://' . $this->dbhost . ':' . $this->dbport);
        } catch (MongoDBDriverExceptionException $e) {
            echo $e->getMessage();
            echo nl2br("n");
        }
    }

    // get the database connection MySQL
    function getConnection()
    {
        return $this->conn;
    }
}
