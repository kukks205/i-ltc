BEGIN

DROP TABLE IF EXISTS ltc_depression_screen ;
CREATE TABLE ltc_depression_screen  select *,DATE_FORMAT(now(),'%d/%m/%Y %H:%i:%s') as last_calc  from (select p.person_id,v.hn,v.vn,v.vstdate,
d.feel_depression_2_week,
d.feel_boring_2_week,d.depression_score,
d.suicide_score,d.no_depression,d.hospcode,p.house_regist_type_id from 
depression_screen as d,
vn_stat as v ,
person as p
where d.vn=v.vn 
and d.hospcode=v.hospcode 
and p.patient_hn=v.hn
and p.hospcode=v.hospcode
and v.age_y>59 and v.vstdate between '2015-10-01' 
and '2016-09-30' and p.death<>'Y' 
and p.person_discharge_id='9') as ds;

DROP TABLE IF EXISTS ltc_depression_summary ;
CREATE TABLE ltc_depression_summary select * from (select b.*,a.Amphur_name as ampname  from (select hc.hospcode,
concat(h.hosptype,h.`name`) as hospname,
concat(h.chwpart,h.amppart) as amp,
po.pop_old,
d1.screen,
d0.non_risk,
d2.risk,
d3.mild as 9q_mild,
d4.moder as 9q_moder,
d5.seve as 9q_seve,
DATE_FORMAT(now(),'%d/%m/%Y %H:%i:%s') as last_calc
from
hospcode_cup as hc
join hospcode as h on h.hospcode = hc.hospcode
join (select 
p.hospcode,
count(distinct p.cid) as pop_old
from
person as p
where p.death<>'Y' and p.person_discharge_id='9' and p.house_regist_type_id in (1,3)
and p.age_y>59
group by p.hospcode) AS po ON po.hospcode= hc.hospcode

left join (select 
count(distinct d.person_id) as screen ,
d.hospcode,d.last_calc 
from (select
max(vn),hospcode,person_id,feel_boring_2_week,feel_depression_2_week,depression_score,dp.last_calc
from
ltc_depression_screen AS dp where dp.house_regist_type_id in (1,3)
group by dp.hospcode,dp.person_id) as d
group by d.hospcode) as d1 on d1.hospcode=hc.hospcode

left join (select
count(distinct dp.person_id) as non_risk ,
dp.hospcode,dp.last_calc
from
(select
max(vn),hospcode,person_id,feel_boring_2_week,feel_depression_2_week,depression_score,dp.last_calc
from
ltc_depression_screen AS dp where dp.house_regist_type_id in (1,3)
group by dp.hospcode,dp.person_id) AS dp
where dp.feel_boring_2_week='N' and feel_depression_2_week='N' and dp.depression_score<7
group by dp.hospcode) as d0 on d0.hospcode=hc.hospcode

left join (select
count(distinct dp.person_id) as risk ,
dp.hospcode,dp.last_calc
from
(select
max(vn),hospcode,person_id,feel_boring_2_week,feel_depression_2_week,depression_score,dp.last_calc
from
ltc_depression_screen AS dp where dp.house_regist_type_id in (1,3)
group by dp.hospcode,dp.person_id) AS dp
where (dp.feel_boring_2_week='Y' or feel_depression_2_week='Y') and dp.depression_score>6 
group by dp.hospcode) as d2 on d2.hospcode=hc.hospcode

left join (select
count(distinct dp.person_id) as mild ,
dp.hospcode,dp.last_calc
from
(select
max(vn),hospcode,person_id,feel_boring_2_week,feel_depression_2_week,depression_score,dp.last_calc
from
ltc_depression_screen AS dp where dp.house_regist_type_id in (1,3)
group by dp.hospcode,dp.person_id) AS dp
where (dp.feel_boring_2_week='Y' or feel_depression_2_week='Y') and dp.depression_score between '7' and '12'
group by dp.hospcode) as d3 on d3.hospcode=hc.hospcode

left join (select
count(distinct dp.person_id) as moder ,
dp.hospcode,dp.last_calc
from
(select
max(vn),hospcode,person_id,feel_boring_2_week,feel_depression_2_week,depression_score,dp.last_calc
from
ltc_depression_screen AS dp where dp.house_regist_type_id in (1,3)
group by dp.hospcode,dp.person_id) AS dp
where (dp.feel_boring_2_week='Y' or feel_depression_2_week='Y') and dp.depression_score between '13' and '18'
group by dp.hospcode) as d4 on d4.hospcode=hc.hospcode

left join (select
count(distinct dp.person_id) as seve ,
dp.hospcode,dp.last_calc
from
(select
max(vn),hospcode,person_id,feel_boring_2_week,feel_depression_2_week,depression_score,dp.last_calc
from
ltc_depression_screen AS dp where dp.house_regist_type_id in (1,3)
group by dp.hospcode,dp.person_id) AS dp
where (dp.feel_boring_2_week='Y' or feel_depression_2_week='Y') and dp.depression_score >18
group by dp.hospcode) as d5 on d5.hospcode=hc.hospcode) as b
join Amphur a on b.amp=a.Amphur ) as d1; 

END