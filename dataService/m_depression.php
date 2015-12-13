<?php
include 'includes/conf.ini.php';
include 'includes/DBConn.php';
$row = $db->prepare("select amp,Amphur_name,sum(pop_old) as old,
sum(screen) as sc,sum(non_risk) as nr,sum(risk) as r,
sum(9q_mild) as m,sum(9q_moder) as mo,sum(9q_seve) as se,last_calc
FROM
ltc_depression_summary as d,
Amphur as a 
where a.Amphur=d.amp
group by amp
union 
select '0','รวม',sum(pop_old) as old,
sum(screen) as sc,sum(non_risk) as nr,sum(risk) as r,
sum(9q_mild) as m,sum(9q_moder) as mo,sum(9q_seve) as se,last_calc
FROM
ltc_depression_summary as d,
Amphur as a 
where a.Amphur=d.amp");

$row->execute(); //execute the query  
$obj = $row->fetchAll(PDO::FETCH_ASSOC);
$json_data = [];
foreach ($obj as $k) {
    array_push($json_data, $k);
}

$txt = json_encode($json_data);

print_r('{"records":' . $txt . '}');
?>

