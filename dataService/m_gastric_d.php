<?php
include 'includes/conf.ini.php';
include 'includes/DBConn.php';
$row = $db->prepare("select
g.hospcode,
g.hospname,
g.amp,
a.Amphur_name as ampname,
g.pop_all as pop_old,
g.num_screen as t0,
(g.num_screen-g.num_blader) as t1,
g.num_blader as t2,
(g.num_mobi-g.num_mobi) as t3,
g.num_mobi as t4,
g.num_t1 as at1,g.num_t2 as at2,g.num_t3 as at3,
g.last_calc
from
ltc_gastric_screen_summary AS g
join Amphur as a on a.Amphur = g.amp
where g.amp='".$_REQUEST['cupcode']."'
union
select
'0',
'รวม',
'0',
a.Amphur_name as ampname,
sum(g.pop_all) as pop_old,
sum(g.num_screen) as t0,
(sum(g.num_screen)-sum(g.num_blader)) as t1,
sum(g.num_blader) as t2,
(sum(g.num_mobi)-sum(g.num_mobi)) as t3,
sum(g.num_mobi) as t4,
sum(g.num_t1) as at1,
sum(g.num_t2) as at2,
sum(g.num_t3) as at3,
g.last_calc
from
ltc_gastric_screen_summary AS g
join Amphur as a on a.Amphur = g.amp
where g.amp='".$_REQUEST['cupcode']."'");

$row->execute(); //execute the query  
$obj = $row->fetchAll(PDO::FETCH_ASSOC);
$json_data = [];
foreach ($obj as $k) {
    array_push($json_data, $k);
}

$txt = json_encode($json_data);

print_r('{"records":' . $txt . '}');
?>

