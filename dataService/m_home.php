<?php
include 'includes/conf.ini.php';
include 'includes/DBConn.php';


$row = $db->prepare("select 
a.Amphur_name as 'name',
pp.num as pop_all,
pp2.num2 as pop_old,
o1.num_o1,
o2.num_o2,
o3.num_o3,
o4.num_o4,
DATE_FORMAT(now(),'%d/%m/%Y %H:%i:%s') as last_calc,
DATE_FORMAT(CURDATE(),'%Y%m%d') as file,
a.Amphur as cupcode
from Amphur as a,
(select left(v.village_code,4) as amp,count(distinct p.cid) as num from person p
join house h on p.house_id = h.house_id and h.hospcode = p.hospcode
join village v on v.village_id = h.village_id and h.hospcode = v.hospcode
where p.death<>'Y' and p.house_regist_type_id in ('1','3')
group by left(v.village_code,4)) as pp,
(select left(v.village_code,4) as amp,count(distinct p.cid) as num2 from person p
join house h on p.house_id = h.house_id and h.hospcode = p.hospcode
join village v on v.village_id = h.village_id and h.hospcode = v.hospcode
where p.death<>'Y' and p.house_regist_type_id in ('1','3') and p.age_y > 59
group by left(v.village_code,4)) as pp2,
(select left(v.village_code,4) as amp,count(distinct p.cid) as num_o1 from person p
join house h on p.house_id = h.house_id and h.hospcode = p.hospcode
join village v on v.village_id = h.village_id and h.hospcode = v.hospcode
where p.death<>'Y' and p.house_regist_type_id in ('1','3') and p.age_y between 60 and 69
group by left(v.village_code,4)) as o1,
(select left(v.village_code,4) as amp,count(distinct p.cid) as num_o2 from person p
join house h on p.house_id = h.house_id and h.hospcode = p.hospcode
join village v on v.village_id = h.village_id and h.hospcode = v.hospcode
where p.death<>'Y' and p.house_regist_type_id in ('1','3') and p.age_y between 70 and 79
group by left(v.village_code,4)) as o2,
(select left(v.village_code,4) as amp,count(distinct p.cid) as num_o3 from person p
join house h on p.house_id = h.house_id and h.hospcode = p.hospcode
join village v on v.village_id = h.village_id and h.hospcode = v.hospcode
where p.death<>'Y' and p.house_regist_type_id in ('1','3') and p.age_y between 80 and 89
group by left(v.village_code,4)) as o3,
(select left(v.village_code,4) as amp,count(distinct p.cid) as num_o4 from person p
join house h on p.house_id = h.house_id and h.hospcode = p.hospcode
join village v on v.village_id = h.village_id and h.hospcode = v.hospcode
where p.death<>'Y' and p.house_regist_type_id in ('1','3') and p.age_y >89
group by left(v.village_code,4)) as o4
where a.Province='61' 
and pp.amp=a.Amphur 
and pp2.amp=a.Amphur
and o1.amp=a.Amphur
and o2.amp=a.Amphur
and o3.amp=a.Amphur
and o4.amp=a.Amphur

union

select 
'รวม' as 'name',
sum(pp.num) as pop_all,
sum(pp2.num2) as pop_old,
sum(o1.num_o1) as num_o1,
sum(o2.num_o2) as num_o2,
sum(o3.num_o3) as num_o3,
sum(o4.num_o4) as num_o4,
DATE_FORMAT(now(),'%d/%m/%Y %H:%i:%s') as last_calc,
DATE_FORMAT(CURDATE(),'%Y%m%d') as file,
a.Amphur as cupcode
from Amphur as a,
(select left(v.village_code,4) as amp,count(distinct p.cid) as num from person p
join house h on p.house_id = h.house_id and h.hospcode = p.hospcode
join village v on v.village_id = h.village_id and h.hospcode = v.hospcode
where p.death<>'Y' and p.house_regist_type_id in ('1','3')
group by left(v.village_code,4)) as pp,
(select left(v.village_code,4) as amp,count(distinct p.cid) as num2 from person p
join house h on p.house_id = h.house_id and h.hospcode = p.hospcode
join village v on v.village_id = h.village_id and h.hospcode = v.hospcode
where p.death<>'Y' and p.house_regist_type_id in ('1','3') and p.age_y > 59
group by left(v.village_code,4)) as pp2,
(select left(v.village_code,4) as amp,count(distinct p.cid) as num_o1 from person p
join house h on p.house_id = h.house_id and h.hospcode = p.hospcode
join village v on v.village_id = h.village_id and h.hospcode = v.hospcode
where p.death<>'Y' and p.house_regist_type_id in ('1','3') and p.age_y between 60 and 69
group by left(v.village_code,4)) as o1,
(select left(v.village_code,4) as amp,count(distinct p.cid) as num_o2 from person p
join house h on p.house_id = h.house_id and h.hospcode = p.hospcode
join village v on v.village_id = h.village_id and h.hospcode = v.hospcode
where p.death<>'Y' and p.house_regist_type_id in ('1','3') and p.age_y between 70 and 79
group by left(v.village_code,4)) as o2,
(select left(v.village_code,4) as amp,count(distinct p.cid) as num_o3 from person p
join house h on p.house_id = h.house_id and h.hospcode = p.hospcode
join village v on v.village_id = h.village_id and h.hospcode = v.hospcode
where p.death<>'Y' and p.house_regist_type_id in ('1','3') and p.age_y between 80 and 89
group by left(v.village_code,4)) as o3,
(select left(v.village_code,4) as amp,count(distinct p.cid) as num_o4 from person p
join house h on p.house_id = h.house_id and h.hospcode = p.hospcode
join village v on v.village_id = h.village_id and h.hospcode = v.hospcode
where p.death<>'Y' and p.house_regist_type_id in ('1','3') and p.age_y >89
group by left(v.village_code,4)) as o4
where a.Province='61' 
and pp.amp=a.Amphur 
and pp2.amp=a.Amphur
and o1.amp=a.Amphur
and o2.amp=a.Amphur
and o3.amp=a.Amphur
and o4.amp=a.Amphur");

$row->execute(); //execute the query  
$obj = $row->fetchAll(PDO::FETCH_ASSOC);
$json_data = [];

foreach ($obj as $k) {
    array_push($json_data, $k);
}

$myfile = fopen("json/home.json", "w") or die("Unable to open file!");
$txt = json_encode($json_data);
fwrite($myfile, '{"records":' . $txt . '}');
fclose($myfile);
print_r('{"records":' . $txt . '}');


?>

