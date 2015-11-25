<?php
              
                include 'conf.ini.php';
                try{
                //connect ฐานข้อมูล 
                $db = new PDO("mysql:host=$hostname;port=$port;dbname=$dbname;", $username, $password,array(
                PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES $charset",));
                }
                catch (Exception $e){
                echo 'error:'.$e->getMessage();
                }
?>                