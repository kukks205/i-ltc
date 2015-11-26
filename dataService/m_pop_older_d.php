<?php
include 'includes/conf.ini.php';
include 'includes/DBConn.php';
$row = $db->prepare("select p.hospcode,p.hospname,
p.amp,p.pop_all ,p.pop_old,
p.pop_o1,p.pop_o2,p.pop_o3,p.pop_o4,
p.wf,p.alone,p.last_calc,p.ampname
from ltc_pop_older_d as p
where amp='".$_REQUEST['cupcode']."'
union
select p.hospcode,'รวม',p.amp,
sum(p.pop_all) as a ,sum(p.pop_old) as b,
sum(p.pop_o1) as c,sum(p.pop_o2) as d,
sum(p.pop_o3) as e,sum(p.pop_o4) as f,
sum(p.wf) as g,sum(p.alone) as h,p.last_calc,p.ampname
from ltc_pop_older_d as p
where amp='".$_REQUEST['cupcode']."'");

$row->execute(); //execute the query  
$obj = $row->fetchAll(PDO::FETCH_ASSOC);
$json_data = [];
foreach ($obj as $k) {
    array_push($json_data, $k);
}

$txt = json_encode($json_data);

print_r('{"records":' . $txt . '}');
?>

