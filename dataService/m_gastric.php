<?php
include 'includes/conf.ini.php';
include 'includes/DBConn.php';
$row = $db->prepare("select
g.amp,a.Amphur_name as name,
sum(g.pop_all) as pop_old,
sum(g.num_screen) as t0,
(sum(g.num_screen)-sum(g.num_blader)) as t1,
sum(g.num_blader) as t2,
sum(g.num_mobi) as t3,
sum(g.num_t1) as at1,
sum(g.num_t2) as at2,
sum(g.num_t3) as at3,
g.last_calc
from
ltc_gastric_screen_summary as g,
Amphur as a 
where a.Amphur=g.amp
group by g.amp
union 
select
'0' as amp,'รวม' as name,
sum(g.pop_all) as pop_old,
sum(g.num_screen) as t0,
(sum(g.num_screen)-sum(g.num_blader)) as t1,
sum(g.num_blader) as t2,
sum(g.num_mobi) as t3,
sum(g.num_t1) as at1,
sum(g.num_t2) as at2,
sum(g.num_t3) as at3,
g.last_calc
from
ltc_gastric_screen_summary as g,
Amphur as a 
where a.Amphur=g.amp");

$row->execute(); //execute the query  
$obj = $row->fetchAll(PDO::FETCH_ASSOC);
$json_data = [];
foreach ($obj as $k) {
    array_push($json_data, $k);
}

$txt = json_encode($json_data);

print_r('{"records":' . $txt . '}');
?>

