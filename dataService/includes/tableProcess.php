<?php

class tableProcess {

    var $conn;

    //ใช้ connect DB เพื่อใช้ใน Class
    public function __construct() {

        include 'conf.ini.php';

        $this->conn = new PDO("mysql:host=$hostname;port=$port;dbname=$dbname;", $username, $password, array(
            PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES $charset",));
    }

    function limit($request) {
        $limit = '';

        if (isset($request['start']) && $request['length'] != -1) {
            $limit = "LIMIT " . intval($request['start']) . ", " . intval($request['length']);
        }

        return $limit;
    }
    
    

    function getDataServer($request, $sql, $find, $condition) {
        
    }

    //put your code here
}
