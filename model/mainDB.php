<?php
class mainDB{
    private $hostname;
    private $userName;
    private $password;
    private $dBName;
    
    protected static $connection;

    public function __construct(){
        static::$connection = new mysqli('localhost','root','','ecommerce');
    }
    protected function sendQuery($query){
        echo '<br>';
        echo $query;
        echo '<br>';
        return static::$connection -> query($query);
    }
}