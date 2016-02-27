BEGIN

DROP TABLE IF EXISTS ltc_oks_lastscreen;

create table ltc_oks_lastscreen 
select o1.*,DATE_FORMAT(now(),'%d/%m/%Y %H:%i:%s') as last_calc  
from 
hhc_oxford_knee_score_screen as o1
join (select person_id,hospcode,max(oks_id) as oksid 
from hhc_oxford_knee_score_screen 
group by concat(person_id,hospcode)) as o2 on o2.hospcode=o1.hospcode and o2.person_id=o1.person_id
join person as p on p.hospcode=o1.hospcode and p.person_id=o1.person_id
where p.house_regist_type_id in (1,3) and p.death<>'Y' and p.person_discharge_id='9' and p.age_y>59 ;

DROP TABLE IF EXISTS ltc_oks_screen_summary;
CREATE TABLE ltc_oks_screen_summary  select * from (select hc.hospcode,
concat(h.hosptype,h.`name`) as hospname,
concat(h.chwpart,h.amppart) as amp,
(select count(distinct p.cid) as cc 
from person as p 
where p.death<>'Y' 
and p.person_discharge_id='9' 
and p.age_y>59 
and p.house_regist_type_id in (1,3)
and p.hospcode=hc.hospcode) as num_old,
(select count(distinct o1.person_id) as cc 
from ltc_oks_lastscreen as o1
where o1.hospcode=hc.hospcode
group by o1.hospcode) as num_screen,
(select count(distinct o1.person_id) as cc 
from ltc_oks_lastscreen as o1
where o1.total_point >39 and o1.hospcode=hc.hospcode
group by o1.hospcode) as k0,
(select count(distinct o1.person_id) as cc 
from ltc_oks_lastscreen as o1
where o1.total_point between 30 and 39 and o1.hospcode=hc.hospcode
group by o1.hospcode) as k1,
(select count(distinct o1.person_id) as k1 
from ltc_oks_lastscreen as o1
where o1.total_point between 20 and 29 and o1.hospcode=hc.hospcode
group by o1.hospcode) as k2,
(select count(distinct o1.person_id) as k1 
from ltc_oks_lastscreen as o1
where o1.total_point <20 and o1.hospcode=hc.hospcode
group by o1.hospcode) as k3,
(select last_calc  
from ltc_oks_lastscreen as o1
where o1.hospcode=hc.hospcode
group by o1.hospcode) as last_calc 
from 
hospcode_cup as hc
join hospcode as h on h.hospcode = hc.hospcode
order by concat(h.chwpart,h.amppart),hc.hospcode) as osk;

END