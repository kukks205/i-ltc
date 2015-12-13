<?php
include 'includes/conf.ini.php';
include 'includes/DBConn.php';
$row = $db->prepare("select hospname,ampname,pop_old as old,
screen as sc,non_risk as nr,risk as r,
9q_mild as m,9q_moder as mo,9q_seve as se,last_calc
FROM
ltc_depression_summary as d
where d.amp='".$_REQUEST['cupcode']."'
union 
select 'รวม',ampname,sum(pop_old) as old,
sum(screen) as sc,sum(non_risk) as nr,sum(risk) as r,
sum(9q_mild) as m,sum(9q_moder) as mo,sum(9q_seve) as se,last_calc
FROM
ltc_depression_summary as d
where  d.amp='".$_REQUEST['cupcode']."'");

$row->execute(); //execute the query  
$obj = $row->fetchAll(PDO::FETCH_ASSOC);
$json_data = [];
foreach ($obj as $k) {
    array_push($json_data, $k);
}

$txt = json_encode($json_data);

print_r('{"records":' . $txt . '}');
?>

