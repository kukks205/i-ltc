<?php
include 'includes/conf.ini.php';
include 'includes/DBConn.php';

$row = $db->prepare("select * from ltc_report1");

$row->execute(); //execute the query  
$obj = $row->fetchAll(PDO::FETCH_ASSOC);
$json_data = [];

foreach ($obj as $k) {
    array_push($json_data, $k);
}

/*$myfile = fopen("json/report1.json", "w") or die("Unable to open file!");
$myfile2 = fopen("json/report2.json", "w") or die("Unable to open file!");*/
$txt = json_encode($json_data);
/*fwrite($myfile, '{"records":' . $txt . '}');
fwrite($myfile2, $txt);
fclose($myfile);*/
print_r('{"records":' . $txt . '}');


?>

