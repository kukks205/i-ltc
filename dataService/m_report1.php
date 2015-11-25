<?php
include 'includes/conf.ini.php';
include 'includes/DBConn.php';

$row = $db->prepare("select 
report1.id,
report1.name,
report1.cc,
report1.tt,
round(((report1.cc*100)/report1.tt),2) as pp,
DATE_FORMAT(now(),'%d/%m/%Y %H:%i:%s') as last_calc,
DATE_FORMAT(CURDATE(),'%Y%m%d') as file
from (select '1' as id,'ประชากรทั้งหมด' as 'name',
count(distinct p.cid) as cc,
'' as tt 
from person as p 
where p.person_discharge_id='9' and p.house_regist_type_id in (1,3)
union
select '2' as id, 'ผู้สูงอายุทั้งหมด' as 'name',
count(distinct p.cid) as cc,
(select count(distinct p.cid) as cc
from person as p 
where p.person_discharge_id='9' and p.house_regist_type_id in (1,3)) as tt 
from person as p 
where p.person_discharge_id='9' and p.age_y>59 and p.house_regist_type_id in (1,3)
union
select '3' as id, 'อายุอยู่ในช่วง 60-69 ปี' as 'name',
count(distinct p.cid) as cc,
(select count(distinct p.cid) as cc 
from person as p 
where p.person_discharge_id='9' and p.age_y>59 and p.house_regist_type_id in (1,3)) as tt 
from person as p 
where p.person_discharge_id='9' and p.age_y between '60' and '69' and p.house_regist_type_id in (1,3)
union
select '4' as id, 'อายุอยู่ในช่วง 70-79 ปี' as 'name',
count(distinct p.cid) as cc,
(select count(distinct p.cid) as cc 
from person as p 
where p.person_discharge_id='9' and p.age_y>59 and p.house_regist_type_id in (1,3)) as tt 
from person as p 
where p.person_discharge_id='9' and p.age_y between '70' and '79' and p.house_regist_type_id in (1,3)
union
select '5' as id, 'อายุอยู่ในช่วง 80-89 ปี' as 'name',
count(distinct p.cid) as cc,
(select count(distinct p.cid) as cc 
from person as p 
where p.person_discharge_id='9' and p.age_y>59 and p.house_regist_type_id in (1,3)) as tt 
from person as p 
where p.person_discharge_id='9' and p.age_y between '80' and '89' and p.house_regist_type_id in (1,3)
union
select '6' as id, 'อายุอยู่ในช่วง 90+ ปี' as 'name',
count(distinct p.cid) as cc,
(select count(distinct p.cid) as cc 
from person as p 
where p.person_discharge_id='9' and p.age_y>59 and p.house_regist_type_id in (1,3)) as tt 
from person as p 
where p.person_discharge_id='9' and p.age_y >89 and p.house_regist_type_id in (1,3)
union
select '7' as id, 'ผู้สูงอายุที่ขึ้นทะเบียนทั้งหมด' as 'name',
count(distinct p.cid) as cc,
(select count(distinct p.cid) as cc 
from person as p 
where p.person_discharge_id='9' and p.age_y>59 and p.house_regist_type_id in (1,3)) as tt 
from person_senile as ps,
person as p 
where p.person_id=ps.person_id and p.hospcode=ps.hospcode
and p.person_discharge_id='9' and p.house_regist_type_id in (1,3)
union
select '8' as id, 'อาศัยอยู่คนเดียว(ไม่มีผู้ดูแล)' as 'name',
count(distinct p.cid) as cc,
(select count(distinct p.cid) as cc 
from person as p 
where p.person_discharge_id='9' and p.age_y>59 and p.house_regist_type_id in (1,3)) as tt 
from person_senile as ps,
person as p 
where ps.person_senile_helper_type_id=0 and p.person_id=ps.person_id and p.hospcode=ps.hospcode
and p.person_discharge_id='9' and p.house_regist_type_id in (1,3)
union
select '9' as id, 'อาศัยอยู่กับครอบครัว' as 'name',
count(distinct p.cid) as cc,
(select count(distinct p.cid) as cc 
from person as p 
where p.person_discharge_id='9' and p.age_y>59 and p.house_regist_type_id in (1,3)) as tt 
from person_senile as ps,
person as p 
where ps.person_senile_helper_type_id=2 and p.person_id=ps.person_id and p.hospcode=ps.hospcode
and p.person_discharge_id='9' and p.house_regist_type_id in (1,3)
union
select '10' as id, 'มีเพื่อนบ้านคอยดูแล' as 'name',
count(distinct p.cid) as cc,
(select count(distinct p.cid) as cc 
from person as p 
where p.person_discharge_id='9' and p.age_y>59 and p.house_regist_type_id in (1,3)) as tt 
from person_senile as ps,
person as p 
where ps.person_senile_helper_type_id=3 and p.person_id=ps.person_id and p.hospcode=ps.hospcode
and p.person_discharge_id='9' and p.house_regist_type_id in (1,3)
union
select '11' as id, 'ได้รับการคัดกรอง ADL' as 'name',
count(distinct p.cid) as cc,
(select count(distinct p.cid) as cc 
from person as p 
where p.person_discharge_id='9' and p.age_y>59 and p.house_regist_type_id in (1,3)) as tt 
from
hhc_person_adl_screen as adl,
person as p
where p.person_id=adl.person_id and p.hospcode=adl.hospcode 
and p.person_discharge_id='9' and p.house_regist_type_id in (1,3) 
union
select '12' as id, 'ติดสังคม(เตียง 1)' as 'name',
count(distinct p.cid) as cc,
(select count(distinct p.cid) as cc from
hhc_person_adl_screen as adl,
person as p
where p.person_id=adl.person_id and p.hospcode=adl.hospcode 
and p.person_discharge_id='9' and p.house_regist_type_id in (1,3) ) as tt 
from person_senile as ps,
person as p ,
hhc_person_adl_screen as adl
where ps.person_senile_self_type_id=1 and p.person_id=ps.person_id and p.hospcode=ps.hospcode 
and p.person_id=adl.person_id and p.hospcode=adl.hospcode 
and p.person_discharge_id='9' and p.house_regist_type_id in (1,3)
union
select '13' as id, 'ติดบ้าน (เตียง 2)' as 'name',
count(distinct p.cid) as cc,
(select count(distinct p.cid) as cc from
hhc_person_adl_screen as adl,
person as p
where p.person_id=adl.person_id and p.hospcode=adl.hospcode 
and p.person_discharge_id='9' and p.house_regist_type_id in (1,3) ) as tt 
from person_senile as ps,
person as p ,
hhc_person_adl_screen as adl
where ps.person_senile_self_type_id=2 and p.person_id=ps.person_id and p.hospcode=ps.hospcode 
and p.person_id=adl.person_id and p.hospcode=adl.hospcode 
and p.person_discharge_id='9' and p.house_regist_type_id in (1,3)
union
select '14' as id, 'ติิดเตียง (เตียง3)' as 'name',
count(distinct p.cid) as cc,
(select count(distinct p.cid) as cc from
hhc_person_adl_screen as adl,
person as p
where p.person_id=adl.person_id and p.hospcode=adl.hospcode 
and p.person_discharge_id='9' and p.house_regist_type_id in (1,3) ) as tt 
from person_senile as ps,
person as p ,
hhc_person_adl_screen as adl
where ps.person_senile_self_type_id=3 and p.person_id=ps.person_id and p.hospcode=ps.hospcode 
and p.person_id=adl.person_id and p.hospcode=adl.hospcode 
and p.person_discharge_id='9' and p.house_regist_type_id in (1,3)
union
select '15' as id,
'ไม่มีความเสี่ยงต่อการหกล้ม' as 'name',
count(distinct p.cid) as cc,
(select count(distinct p.cid) as cc from
hhc_person_adl_screen as adl,
person as p
where p.person_id=adl.person_id and p.hospcode=adl.hospcode 
and p.person_discharge_id='9' and p.house_regist_type_id in (1,3) ) as tt 
from
hhc_person_adl_screen as adl,
person as p
where p.person_id=adl.person_id and p.hospcode=adl.hospcode 
and p.person_discharge_id='9' and p.house_regist_type_id in (1,3) 
and adl.mobility>2 and adl.transfer>2 and adl.stairs>1
union
select '16' as id,
'มีความเสี่ยงต่อการหกล้ม' as 'name',
count(distinct p.cid) as cc,
(select count(distinct p.cid) as cc from
hhc_person_adl_screen as adl,
person as p
where p.person_id=adl.person_id and p.hospcode=adl.hospcode 
and p.person_discharge_id='9' and p.house_regist_type_id in (1,3) ) as tt 
from
hhc_person_adl_screen as adl,
person as p
where p.person_id=adl.person_id and p.hospcode=adl.hospcode 
and p.person_discharge_id='9' and p.house_regist_type_id in (1,3) 
and (adl.mobility<3 or adl.transfer<3 or adl.stairs<2)
union
select '17' as id,
'มีปัญหาการกลั้นปัสสาวะ' as 'name',
count(distinct p.cid) as cc,
(select count(distinct p.cid) as cc from
hhc_person_adl_screen as adl,
person as p
where p.person_id=adl.person_id and p.hospcode=adl.hospcode 
and p.person_discharge_id='9' and p.house_regist_type_id in (1,3) ) as tt 
from
hhc_person_adl_screen as adl,
person as p
where p.person_id=adl.person_id and p.hospcode=adl.hospcode 
and p.person_discharge_id='9' and p.house_regist_type_id in (1,3) 
and adl.bladder<2
union
select '18' as id,
'ไม่มีปัญหาการกลั้นปัสสาวะ' as 'name',
count(distinct p.cid) as cc,
(select count(distinct p.cid) as cc from
hhc_person_adl_screen as adl,
person as p
where p.person_id=adl.person_id and p.hospcode=adl.hospcode 
and p.person_discharge_id='9' and p.house_regist_type_id in (1,3) ) as tt 
from
hhc_person_adl_screen as adl,
person as p
where p.person_id=adl.person_id and p.hospcode=adl.hospcode 
and p.person_discharge_id='9' and p.house_regist_type_id in (1,3) 
and adl.bladder>1
union 
select '19' as id,
'ได้รับการคัดกรองข้อเข่าเสื่อม' as 'name',
count(distinct p.cid) as cc,
(select count(distinct p.cid) as cc 
from person as p 
where p.person_discharge_id='9' and p.age_y>59 and p.house_regist_type_id in (1,3)) as tt 
from
person as p,
hhc_oxford_knee_score_screen as oks
where p.person_id=oks.person_id and p.hospcode=oks.hospcode
and p.person_discharge_id='9' and p.house_regist_type_id in (1,3)
union 
select '20' as id,
'ไม่พบความผิดปกติของข้อเข่า' as 'name',
count(distinct p.cid) as cc,
(select count(distinct p.cid) as cc
from
person as p,
hhc_oxford_knee_score_screen as oks
where p.person_id=oks.person_id and p.hospcode=oks.hospcode
and p.person_discharge_id='9' and p.house_regist_type_id in (1,3)) as tt 
from
person as p,
hhc_oxford_knee_score_screen as oks
where p.person_id=oks.person_id and p.hospcode=oks.hospcode
and p.person_discharge_id='9' and p.house_regist_type_id in (1,3) and oks.total_point>39
union 
select '21' as id,
'มีภาวะข้อเข่าเสื่อม' as 'name',
count(distinct p.cid) as cc,
(select count(distinct p.cid) as cc
from
person as p,
hhc_oxford_knee_score_screen as oks
where p.person_id=oks.person_id and p.hospcode=oks.hospcode
and p.person_discharge_id='9' and p.house_regist_type_id in (1,3)) as tt 
from
person as p,
hhc_oxford_knee_score_screen as oks
where p.person_id=oks.person_id and p.hospcode=oks.hospcode
and p.person_discharge_id='9' and p.house_regist_type_id in (1,3) and oks.total_point<40) as report1");

$row->execute(); //execute the query  
$obj = $row->fetchAll(PDO::FETCH_ASSOC);
$json_data = [];

foreach ($obj as $k) {
    array_push($json_data, $k);
}

$myfile = fopen("json/report1.json", "w") or die("Unable to open file!");
$myfile2 = fopen("json/report2.json", "w") or die("Unable to open file!");
$txt = json_encode($json_data);
fwrite($myfile, '{"records":' . $txt . '}');
fwrite($myfile2, $txt);
fclose($myfile);
print_r('{"records":' . $txt . '}');


?>

