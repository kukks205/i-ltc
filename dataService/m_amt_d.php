<?php
include 'includes/conf.ini.php';
include 'includes/DBConn.php';
$row = $db->prepare("SELECT
amt.hospcode AS hospcode,
concat(hospcode.hosptype,hospcode.`name`) AS hospname,
Amphur.Amphur_name,
amt.num_old AS old,
amt.num_screen AS screen,
amt.abnormal AS ab,
amt.normal AS nor,
amt.last_calc
FROM
ltc_amt_screen_summary AS amt
INNER JOIN hospcode ON hospcode.hospcode = amt.hospcode
INNER JOIN Amphur ON Amphur.Amphur = amt.amp
where amt.amp ='".$_REQUEST['cupcode']."'
union
SELECT
'0' AS hospcode,
'รวม' AS hospname,
Amphur.Amphur_name,
Sum(amt.num_old) AS old,
Sum(amt.num_screen) AS screen,
Sum(amt.abnormal) AS ab,
Sum(amt.normal) AS nor,
amt.last_calc
FROM
ltc_amt_screen_summary AS amt
INNER JOIN hospcode ON hospcode.hospcode = amt.hospcode
INNER JOIN Amphur ON Amphur.Amphur = amt.amp
where amt.amp ='".$_REQUEST['cupcode']."'");




$row->execute(); //execute the query  
$obj = $row->fetchAll(PDO::FETCH_ASSOC);
$json_data = [];
foreach ($obj as $k) {
    array_push($json_data, $k);
}

$txt = json_encode($json_data);

print_r('{"records":' . $txt . '}');
?>

