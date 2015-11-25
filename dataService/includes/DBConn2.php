<?php
              
                include 'conf.audit.php';
                try{
                //connect ฐานข้อมูล 
                $db2 = new PDO("mysql:host=$host;port=$port2;dbname=$db;", $user, $pass,array(
                PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES $char",));
                }
                catch (Exception $e){
                echo 'error:'.$e->getMessage();
                }
?>                