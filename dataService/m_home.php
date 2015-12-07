<?php
include 'includes/conf.ini.php';
include 'includes/DBConn.php';
$row = $db->prepare("select p.ampname as name,p.amp,
sum(p.pop_all) as pop_all,
sum(p.pop_old) as pop_old,
sum(p.pop_o1) as num_o1 ,
sum(p.pop_o2) as num_o2,
sum(p.pop_o3) as num_o3,
sum(p.pop_o4) as num_o4,
sum(p.wf) as num_wf,
sum(p.alone) as num_alone,
p.last_calc
from ltc_pop_older_d AS p
group by p.amp
union
select
'รวม' as name,'' as amp,
sum(p.pop_all) as pop_all,
sum(p.pop_old) as pop_old,
sum(p.pop_o1) as num_o1 ,
sum(p.pop_o2) as num_o2,
sum(p.pop_o3) as num_o3,
sum(p.pop_o4) as num_o4,
sum(p.wf) as num_wf,
sum(p.alone) as num_alone,
p.last_calc
from
ltc_pop_older_d AS p");

$row->execute(); //execute the query  
$obj = $row->fetchAll(PDO::FETCH_ASSOC);
$json_data = [];
foreach ($obj as $k) {
    array_push($json_data, $k);
}

$txt = json_encode($json_data);

print_r('{"records":' . $txt . '}');
?>

