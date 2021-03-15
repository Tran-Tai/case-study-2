<?php

class DB {
    static $connection = NULL;
    static function connect()
    {
        if (!isset(self::$connection)) {
            try {
                $severname = "localhost";
                $username = "root";
                $password = "P@ssword";
                $database = "covid_patients_manager";

                self::$connection = new PDO("mysql:host=$severname;dbname=$database", $username,$password);
                self::$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            }
            catch (PDOException $e) {
                echo "Connection failed: " . $e->getMessage();
            }
        }
        return self::$connection;
    }
}