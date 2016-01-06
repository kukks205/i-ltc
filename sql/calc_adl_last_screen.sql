BEGIN

DROP TABLE IF EXISTS ltc_adl_last_screen ;
CREATE TABLE ltc_adl_last_screen select *,DATE_FORMAT(now(),'%d/%m/%Y %H:%i:%s') as last_calc from (select a.* from 
(select 
a.person_id,a.hospcode,
max(a.adl_id) as last_screen
from
hhc_person_adl_screen as a
group by concat(a.person_id,a.hospcode)) as al
join hhc_person_adl_screen as a on a.adl_id=al.last_screen and a.hospcode=al.hospcode ) as adl;

DROP TABLE IF EXISTS ltc_gastric_screen_summary ;
CREATE TABLE ltc_gastric_screen_summary select *,DATE_FORMAT(now(),'%d/%m/%Y %H:%i:%s') as last_calc from (select hc.hospcode,
concat(h.hosptype,h.`name`) as hospname,
concat(h.chwpart,h.amppart) as amp,
pa.pop_all,
if(adl0.num_screen is null,0,adl0.num_screen) as num_screen,
if(ds.screen is null,0,ds.screen) as dscreen,
if(ds.risk is null,0,ds.risk) as dsrisk,
if(adl1.num_blader is null,0,adl1.num_blader) as num_blader,
if(adl2.num_mobi is null,0,adl2.num_mobi) as num_mobi   
from hospcode_cup as hc
join hospcode as h on h.hospcode = hc.hospcode
join (select p.hospcode,count(distinct p.cid) as pop_all from person as p where p.death<>'Y' and p.person_discharge_id='9' and p.house_regist_type_id in (1,3)
group by p.hospcode) as pa on pa.hospcode= hc.hospcode
left join (select a.hospcode,count(distinct a.person_id) as num_screen from ltc_adl_last_screen as a  group by a.hospcode ) as adl0 on hc.hospcode=adl0.hospcode
left join (select a.hospcode,count(distinct a.person_id) as num_blader from ltc_adl_last_screen as a where a.bladder<2 group by a.hospcode ) as adl1 on hc.hospcode=adl1.hospcode
left join (select a.hospcode,count(distinct a.person_id) as num_mobi from ltc_adl_last_screen as a where a.mobility<3 group by a.hospcode ) as adl2 on hc.hospcode=adl2.hospcode
left join ltc_depression_summary as ds on ds.hospcode=hc.hospcode) as gt;

END