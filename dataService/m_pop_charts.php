<?php
//header("content-type: application/json"); 

include 'includes/conf.ini.php';
include 'includes/DBConn.php';
$row = $db->prepare("select p.ampname as name,sum(p.pop_old) as y,p.amp as drilldown 
    from ltc_pop_older_d as p group by p.amp");

$row->execute(); //execute the query  
$data = $row->fetchAll(PDO::FETCH_ASSOC);
$array = [];
foreach ($data as $r) {
    array_push($array, $r);
}

echo json_encode($array); 

?>