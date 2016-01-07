<?php
//header("content-type: application/json"); 

include 'includes/conf.ini.php';
include 'includes/DBConn.php';
$row = $db->prepare("select p.ampname as name,p.amp as drilldown,sum(p.pop_all) as p_all,
sum(p.pop_old) as p_old from ltc_pop_older_d as p group by p.amp");

$row->execute(); //execute the query  
$data = $row->fetchAll(PDO::FETCH_ASSOC);
$array = [];
foreach ($data as $r) {
    array_push($array, $r);
}

echo json_encode($array); 

?>