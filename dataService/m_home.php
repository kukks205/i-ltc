<?php
include 'includes/conf.ini.php';
include 'includes/DBConn.php';


$row = $db->prepare("select * from ltc_pop_older");

$row->execute(); //execute the query  
$obj = $row->fetchAll(PDO::FETCH_ASSOC);
$json_data = [];

foreach ($obj as $k) {
    array_push($json_data, $k);
}

$myfile = fopen("json/home.json", "w") or die("Unable to open file!");
$txt = json_encode($json_data);
fwrite($myfile, '{"records":' . $txt . '}');
fclose($myfile);
print_r('{"records":' . $txt . '}');


?>

