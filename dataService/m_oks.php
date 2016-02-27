<?php
include 'includes/conf.ini.php';
include 'includes/DBConn.php';
$row = $db->prepare("select * from (select o.amp,
a.Amphur_name as name, 
sum(o.num_old) as pop_old,
sum(o.num_screen) as sc,
sum(o.k0) as k0,
sum(o.k1) as k1,
sum(o.k2) as k2,
sum(o.k3) as k3,
max(o.last_calc) as last_calc
from ltc_oks_screen_summary as o,
Amphur as a 
where a.Amphur=o.amp
group by o.amp ) as aa
union
select '0' as amp,'รวม' as name,
sum(o.num_old) as pop_old,
sum(o.num_screen) as sc,
sum(o.k0) as k0,
sum(o.k1) as k1,
sum(o.k2) as k2,
sum(o.k3) as k3,
max(o.last_calc) as last_calc
from ltc_oks_screen_summary as o,
Amphur as a 
where a.Amphur=o.amp");

$row->execute(); //execute the query  
$obj = $row->fetchAll(PDO::FETCH_ASSOC);
$json_data = [];
foreach ($obj as $k) {
    array_push($json_data, $k);
}

$txt = json_encode($json_data);

print_r('{"records":' . $txt . '}');
?>

