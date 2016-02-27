<?php
include 'includes/conf.ini.php';
include 'includes/DBConn.php';
$row = $db->prepare("select * from (select o.hospcode,
o.hospname,
o.amp,
a.Amphur_name as ampname,
o.num_old,
o.num_screen as sc,
o.k0,
o.k1,
o.k2,
o.k3,
(select max(last_calc) from ltc_oks_screen_summary limit 1) as last_calc  
from ltc_oks_screen_summary as o
join Amphur as a on a.Amphur = o.amp
where  o.amp='".$_REQUEST['cupcode']."'
group by o.hospcode ) as aa
union
select '0',
'รวม',
'0',
a.Amphur_name as ampname,
sum(o.num_old) as pop_old,
sum(o.num_screen) as sc,
sum(o.k0) as k0,
sum(o.k1) as k1,
sum(o.k2) as k2,
sum(o.k3) as k3,
(select max(last_calc) from ltc_oks_screen_summary limit 1) as last_calc 
from ltc_oks_screen_summary as o
join Amphur as a on a.Amphur = o.amp
where o.amp='".$_REQUEST['cupcode']."'");

$row->execute(); //execute the query  
$obj = $row->fetchAll(PDO::FETCH_ASSOC);
$json_data = [];
foreach ($obj as $k) {
    array_push($json_data, $k);
}

$txt = json_encode($json_data);

print_r('{"records":' . $txt . '}');
?>

