<?php

include 'includes/conf.audit.php';
include 'includes/DBConn2.php';

$username=$_REQUEST['username'];
$password=$_REQUEST['password'];

$sql="select * from users where username='$username' and `password`=MD5('$password');";

$check = $db2->prepare($sql);
$check->execute();
$count = $check->rowCount();

if($count>0):
    $status='1';
else:
    $status='0';
endif;


?>
