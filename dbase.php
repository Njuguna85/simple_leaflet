<?php

// New class to open, query a database
class database extends PDO{


private $host = "localhost";
private $db = "dbname";
private $username = "username";
private $password = "password";

// create a new constructor
public function __construct(){
    $dsn = "pgsql:host=$this->host; dbname=$this->db";

    try {
        // call the parent (PDO) contructor
        parent::__construct($dsn, $this->username, $this->password);
        
        if ($this->connect_error) {
            die($this->connect_error);
        }
    } catch (PDOException $e) {
        die($e->getMessage());
    }
} 

public function get_points(){
    //Develop the sql to perfom the query.
    //
    $sql = '
    SELECT 
        full_name, code, zone, longitude, latitude
    FROM 
        client_meters
    ';
    //Query for data.
    //
    $statement =  $this->query($sql);
    //Fetch the result 
    //
    return $statement->fetchAll();
    //Return the results.
    // return results;
}

}


