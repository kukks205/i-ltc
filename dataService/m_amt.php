<?php
include 'includes/conf.ini.php';
include 'includes/DBConn.php';
$row = $db->prepare("select 
amt.amp,a.Amphur_name as 'name',
sum(amt.num_old) as old,sum(amt.num_screen) as screen,sum(amt.abnormal) as ab,sum(amt.normal) as nor,last_calc 
from ltc_amt_screen_summary as amt,
Amphur as a
where a.Amphur=amt.amp
group by a.Amphur
union 
select 
'0' as 'amp',
'รวม' as 'name',
sum(amt.num_old) as old,sum(amt.num_screen) as screen,sum(amt.abnormal) as ab,sum(amt.normal) as nor,last_calc  
from ltc_amt_screen_summary as amt,
Amphur as a
where a.Amphur=amt.amp");

$row->execute(); //execute the query  
$obj = $row->fetchAll(PDO::FETCH_ASSOC);
$json_data = [];
foreach ($obj as $k) {
    array_push($json_data, $k);
}

$txt = json_encode($json_data);

print_r('{"records":' . $txt . '}');
?>

