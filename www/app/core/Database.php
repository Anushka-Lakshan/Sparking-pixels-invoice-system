<?php

class Database
{

    public static $con;
    private static $instance = null;

    public function __construct()
    {
        try {
            $string = DB_TYPE . ":" . DB_file;
            self::$con = new PDO($string);
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new Database();
        }
        return self::$instance;
    }

    //read
    public function read($query, $data = array())
    {
        $statement = self::$con->prepare($query);
        $result = $statement->execute($data);

        if ($result) {

            $data = $statement->fetchAll(PDO::FETCH_ASSOC);
            if (is_array($data)) {
                return $data;
            }
        }

        return false;
    }

    //write
    public function write($query, $data = array())
    {

        $statement = self::$con->prepare($query);
        $result = $statement->execute($data);

        if ($result) {
            return true;
        }

        return false;
    }

    public function getConnection()
    {
        return self::$con;
    }
}
