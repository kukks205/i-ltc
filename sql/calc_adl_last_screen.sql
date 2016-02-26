BEGIN

DROP TABLE IF EXISTS ltc_adl_lastscreen ;
CREATE TABLE ltc_adl_lastscreen 
select a.*,DATE_FORMAT(now(),'%d/%m/%Y %H:%i:%s') as last_calc from 
(select 
a.person_id,a.hospcode,
max(a.adl_id) as last_screen
from
hhc_person_adl_screen as a
group by concat(a.person_id,a.hospcode)) as al
join hhc_person_adl_screen as a on a.adl_id=al.last_screen and a.hospcode=al.hospcode
join person p on p.person_id=al.person_id and p.hospcode=al.hospcode
where p.house_regist_type_id in (1,3) and p.death<>'Y';


DROP TABLE IF EXISTS ltc_gastric_screen_summary ;
CREATE TABLE ltc_gastric_screen_summary select *,DATE_FORMAT(now(),'%d/%m/%Y %H:%i:%s') as last_calc from (select hc.hospcode,
concat(h.hosptype,h.`name`) as hospname,
concat(h.chwpart,h.amppart) as amp,
pa.pop_all,
if(adl0.num_screen is null,0,adl0.num_screen) as num_screen,
if(ds.screen is null,0,ds.screen) as dscreen,
if(ds.risk is null,0,ds.risk) as dsrisk,
if(adl1.num_blader is null,0,adl1.num_blader) as num_blader,
if(adl2.num_mobi is null,0,adl2.num_mobi) as num_mobi,
if(t1.num_t1 is null,0,t1.num_t1) as num_t1,
if(t2.num_t2 is null,0,t2.num_t2) as num_t2,
if(t3.num_t3 is null,0,t3.num_t3) as num_t3   
from hospcode_cup as hc
join hospcode as h on h.hospcode = hc.hospcode
join (select p.hospcode,count(distinct p.cid) as pop_all from person as p where p.death<>'Y' and p.person_discharge_id='9' and p.age_y>59 and p.house_regist_type_id in (1,3)
group by p.hospcode) as pa on pa.hospcode= hc.hospcode
left join (select a.hospcode,count(distinct a.person_id) as num_screen from ltc_adl_lastscreen as a  group by a.hospcode ) as adl0 on hc.hospcode=adl0.hospcode
left join (select a.hospcode,count(distinct a.person_id) as num_blader from ltc_adl_lastscreen as a where a.bladder<2 group by a.hospcode ) as adl1 on hc.hospcode=adl1.hospcode
left join (select a.hospcode,count(distinct a.person_id) as num_mobi from ltc_adl_lastscreen as a where a.mobility<3 group by a.hospcode ) as adl2 on hc.hospcode=adl2.hospcode
left join (select hospcode,count(DISTINCT person_id) as num_t1
from ltc_adl_lastscreen where (feeding+transfer+mobility+dressing+bathing+groming+toilet_use+bowels+bladder+stairs) >12 group by hospcode) as t1 on hc.hospcode=t1.hospcode
left join (select hospcode,count(DISTINCT person_id) as num_t2
from ltc_adl_lastscreen where (feeding+transfer+mobility+dressing+bathing+groming+toilet_use+bowels+bladder+stairs) between 6 and 12 group by hospcode) as t2 on hc.hospcode=t2.hospcode
left join (select hospcode,count(DISTINCT person_id) as num_t3
from ltc_adl_lastscreen where (feeding+transfer+mobility+dressing+bathing+groming+toilet_use+bowels+bladder+stairs) <6 group by hospcode) as t3 on hc.hospcode=t3.hospcode
left join ltc_depression_summary as ds on ds.hospcode=hc.hospcode) as gt;

END