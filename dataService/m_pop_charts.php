<?php
//header("content-type: application/json"); 

include 'includes/conf.ini.php';
include 'includes/DBConn.php';
$row = $db->prepare("select p.ampname as `name`,
p.amp as drilldown,
Sum(p.pop_all) as p_all,
Sum(p.pop_old) as p_old,
sum(p.pop_o1) as p1,
sum(p.pop_o2) as p2,
sum(p.pop_o3) as p3,
sum(p.pop_o4) as p4
from ltc_pop_older_d as p
group by p.amp");

$row->execute(); //execute the query  
$data = $row->fetchAll(PDO::FETCH_ASSOC);
$array = [];
foreach ($data as $r) {
    array_push($array, $r);
}

echo json_encode($array); 

?>