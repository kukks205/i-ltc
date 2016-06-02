BEGIN

DROP TABLE IF EXISTS ltc_amt_lastscreen;
create table ltc_amt_lastscreen
select amt.* from
(select max(amt_id) as id,hospcode from hhc_amt_screen group by concat(hospcode,person_id)) as a, 
hhc_amt_screen as amt where a.hospcode=amt.hospcode and a.id=amt.amt_id and amt.screen_date between '2015-10-01' and '2016-09-30';

DROP TABLE IF EXISTS ltc_amt_screen_summary;
CREATE TABLE ltc_amt_screen_summary 
select * from (select hc.hospcode,
concat(h.hosptype,h.`name`) as hospname,
concat(h.chwpart,h.amppart) as amp,
(select count(distinct p.cid) as cc 
from person as p 
where p.death<>'Y' 
and p.person_discharge_id='9' 
and p.age_y>59 
and p.house_regist_type_id in (1,3)
and p.hospcode=hc.hospcode) as num_old,
(select count(distinct p.cid) as num_screen 
from ltc_amt_lastscreen as amt,
person as p 
where 
p.death<>'Y' 
and p.person_discharge_id='9' 
and p.age_y>59 
and p.house_regist_type_id in (1,3) 
and p.hospcode=amt.hospcode 
and amt.person_id=p.person_id
and amt.hospcode=hc.hospcode) as num_screen,
(select count(distinct p.cid) as num_screen 
from ltc_amt_lastscreen as amt,
person as p 
where 
p.death<>'Y' 
and p.person_discharge_id='9' 
and p.age_y>59 
and p.house_regist_type_id in (1,3) 
and p.hospcode=amt.hospcode 
and amt.person_id=p.person_id
and amt.hospcode=hc.hospcode and amt.total_score<8) as abnormal,
(select count(distinct p.cid) as num_screen 
from ltc_amt_lastscreen as amt,
person as p 
where 
p.death<>'Y' 
and p.person_discharge_id='9' 
and p.age_y>59 
and p.house_regist_type_id in (1,3) 
and p.hospcode=amt.hospcode 
and amt.person_id=p.person_id
and amt.hospcode=hc.hospcode and amt.total_score>7) as normal
from 
hospcode_cup as hc
join hospcode as h on h.hospcode = hc.hospcode
order by concat(h.chwpart,h.amppart),hc.hospcode) as amt_screen;

END