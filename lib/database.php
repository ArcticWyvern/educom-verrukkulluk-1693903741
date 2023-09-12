<?php 

// Aanpassen naar je eigen omgeving
define("USER", "Stan");
define("PASSWORD", "verrukkulluk");
define("DATABASE", "verrukkulluk");
define("HOST", "localhost");

class Database {

    private $connection;

    public function __construct() {
       $this->connection = mysqli_connect(HOST,                                          
                                         USER, 
                                         PASSWORD,
                                         DATABASE );
    }

    public function getConnection() {
        return($this->connection);
    }

}
