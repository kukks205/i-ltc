BEGIN

DROP TABLE IF EXISTS ltc_pop_older_d ;
CREATE TABLE ltc_pop_older_d select * from (
select pop.*,a.Amphur_name as ampname 
from Amphur as a
join (select
hc.hospcode,
concat(h.hosptype,h.`name`) as hospname,
concat(h.chwpart,h.amppart) as amp,
pa.pop_all,po.pop_old,
o1.pop_o1,o2.pop_o2,o3.pop_o3,o4.pop_o4,
l2.wf,l1.alone,(if(adl1.t1 is null,0,adl1.t1)+if(adl2.t2 is null,0,adl2.t2)+if(adl3.t3 is null,0,adl3.t3)) as t0,
if(adl1.t1 is null,0,adl1.t1) as t1,if(adl2.t2 is null,0,adl2.t2) as t2,if(adl3.t3 is null,0,adl3.t3) as t3,
DATE_FORMAT(now(),'%d/%m/%Y %H:%i:%s') as last_calc
from
hospcode_cup AS hc
JOIN hospcode AS h ON h.hospcode = hc.hospcode

JOIN (select 
p.hospcode,
count(distinct p.cid) as pop_all
from
person as p
where p.death<>'Y' and p.person_discharge_id='9' and p.house_regist_type_id in (1,3)
group by p.hospcode) AS pa ON pa.hospcode= hc.hospcode

join (select 
p.hospcode,
count(distinct p.cid) as pop_old
from
person as p
where p.death<>'Y' and p.person_discharge_id='9' and p.house_regist_type_id in (1,3)
and p.age_y>59
group by p.hospcode) AS po ON po.hospcode= hc.hospcode

left join (select  p.hospcode,
count(distinct p.cid) as pop_o1
from
person as p
where p.death<>'Y' and p.person_discharge_id='9' 
and p.house_regist_type_id in (1,3)
and p.age_y between 60 and 69
group by p.hospcode) as o1 on hc.hospcode=o1.hospcode

left join (select  p.hospcode,
count(distinct p.cid) as pop_o2
from
person as p
where p.death<>'Y' and p.person_discharge_id='9' 
and p.house_regist_type_id in (1,3)
and p.age_y between 70 and 79
group by p.hospcode) as o2 on hc.hospcode=o2.hospcode

left join (select  p.hospcode,
count(distinct p.cid) as pop_o3
from
person as p
where p.death<>'Y' and p.person_discharge_id='9' 
and p.house_regist_type_id in (1,3)
and p.age_y between 70 and 79
group by p.hospcode) as o3 on hc.hospcode=o3.hospcode

left join (select  p.hospcode,
count(distinct p.cid) as pop_o4
from
person as p
where p.death<>'Y' and p.person_discharge_id='9' 
and p.house_regist_type_id in (1,3)
and p.age_y between 70 and 79
group by p.hospcode) as o4 on hc.hospcode=o4.hospcode

left join (select
ps.hospcode,
count(distinct p.cid) as alone
from
person_senile as ps
join person as p on p.person_id = ps.person_id and p.hospcode = ps.hospcode
where ps.person_senile_helper_type_id in (0,1) 
and p.death<>'Y' and p.person_discharge_id='9' 
and p.house_regist_type_id in (1,3)
and p.age_y>59
group by p.hospcode) as l1 on hc.hospcode=l1.hospcode

left join (select
ps.hospcode,
count(distinct p.cid) as wf
from
person_senile as ps
join person as p on p.person_id = ps.person_id and p.hospcode = ps.hospcode
where ps.person_senile_helper_type_id in (2,3) 
and p.death<>'Y' and p.person_discharge_id='9' 
and p.house_regist_type_id in (1,3)
and p.age_y>59
group by p.hospcode) as l2 on hc.hospcode=l2.hospcode

left join (select p.hospcode,count(distinct p.cid) as t1
from person AS p ,
person_senile AS ps ,
hhc_person_adl_screen as adl
where ps.person_senile_self_type_id=1 
and ps.person_id = p.person_id and p.hospcode = ps.hospcode
and adl.hospcode=p.hospcode and adl.person_id=p.person_id
group by p.hospcode) as adl1 on hc.hospcode=adl1.hospcode

left join (select p.hospcode,count(distinct p.cid) as t2
from person AS p ,
person_senile AS ps ,
hhc_person_adl_screen as adl
where ps.person_senile_self_type_id=2 
and ps.person_id = p.person_id and p.hospcode = ps.hospcode
and adl.hospcode=p.hospcode and adl.person_id=p.person_id
group by p.hospcode) as adl2 on hc.hospcode=adl2.hospcode

left join (select p.hospcode,count(distinct p.cid) as t3
from person AS p ,
person_senile AS ps ,
hhc_person_adl_screen as adl
where ps.person_senile_self_type_id=3 
and ps.person_id = p.person_id and p.hospcode = ps.hospcode
and adl.hospcode=p.hospcode and adl.person_id=p.person_id
group by p.hospcode) as adl3 on hc.hospcode=adl3.hospcode


order by h.amppart) as pop on pop.amp=a.Amphur) as o ;

END