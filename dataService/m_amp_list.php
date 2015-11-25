<?php
include 'includes/conf.audit.php';
include 'includes/DBConn2.php';

$sqlamp="select * from info_allpcu order by info_amppart";

$row = $db2->prepare($sqlamp);
$row->execute(); //execute the query  
$obj = $row->fetchAll(PDO::FETCH_ASSOC);
$json_data = [];

foreach ($obj as $k) {
    array_push($json_data, $k);
}
$txt = json_encode($json_data);
print_r('{"records":' . $txt . '}');


?>
