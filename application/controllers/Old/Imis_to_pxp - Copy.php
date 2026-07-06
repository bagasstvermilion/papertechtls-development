<?php
echo "<h2 style='color:red;'>Running iMis to PxP Data Transfer background job..</h2>";

$cm = date("Y-m");

//machining
$sql = "SELECT * from import_case uic where to_char(upload_at,'YYYY-MM') ='$cm' and LEFT(caseno,2) IN ('NA','NB','NC','NE','NF','NI') and status in ('shipping','receive','unloading')  
	and concat(containerno, shippingcode, caseno) not in (
		select concat(cont_no, shippingcode, caseno) from pxp_mch.unloading_import_case uic where status in('receive','shipping','unloading')
) limit 1";
$rs = $this->db_oka_ne->query($sql);
if ($rs->num_rows() > 0) {

	/* unloading import case */
	$sql = "INSERT into pxp_mch.unloading_import_case(plan_date, vanning_code, cont_no, caseno, status, unloading_at, unloading_by, unloading_casemark, shippingcode, upload_at, upload_by, receive_at, receive_by, caseid, containerid, impcode, receive_location) 
select '1999-09-09' as plan_date, vanningcode as vanning_code, containerno as cont_no, caseno, status, unloading_at, unloading_by, code_qr_casemark as unloading_casemark, shippingcode, upload_at, upload_by, receive_at, receive_by, caseid, containerid, impcode, idlocation from import_case ic 
where concat(containerno, shippingcode, caseno) in (
	select concat(containerno, shippingcode, caseno) from import_case uic where to_char(upload_at,'YYYY-MM') ='$cm' and LEFT(caseno,2) IN ('NA','NB','NC','NE','NF','NI') and status in ('shipping','receive','unloading')  
	and concat(containerno, shippingcode, caseno) not in (
		select concat(cont_no, shippingcode, caseno) from pxp_mch.unloading_import_case uic where status in('receive','shipping','unloading')
	)
)
on conflict do nothing;

/* shipping plan */
insert into pxp_mch.machining_shipping_plan(id, caseno, partno, rubetsu, partname, qty, containerno, fta_code, shippingcode, vanningcode, efa_mfn, status, created_at, created_by, caseid, containerid, impcode) 
select 
	ROW_NUMBER () OVER (ORDER by partid) + (select max(id) from pxp_mch.machining_shipping_plan) as id,
	a.caseno, a.partno, '00' rubetsu, a.partname, a.qty, containerno, '-' fta_code, a.shippingcode, vanningcode, '-' efa_mfn, /*'waiting'*/ status, upload_at created_at, upload_by created_by, caseid, 	containerid, impcode
from import_part a 
where concat(containerno, shippingcode, caseno) in (
	select concat(containerno, shippingcode, caseno) from import_case uic where to_char(upload_at,'YYYY-MM') ='$cm' and LEFT(caseno,2) IN ('NA','NB','NC','NE','NF','NI') and status in ('shipping','receive','unloading')  
	and concat(containerno, shippingcode, caseno) not in (
		select concat(containerno, shippingcode, caseno) from pxp_mch.machining_shipping_plan uic where status in('receive','shipping','unloading')
	) 
)	
on conflict do nothing;";
	$this->db_oka_ne->query($sql);
}


//ldt
$sql = "SELECT * from import_case uic where to_char(upload_at,'YYYY-MM') ='$cm' and LEFT(caseno,2) IN ('H1','H2','TY') and status in ('shipping','receive','unloading')  
	and concat(containerno, shippingcode, caseno) not in (
		select concat(cont_no, shippingcode, caseno) from pxp_mch.unloading_import_case uic where status in('receive','shipping','unloading')
) limit 1";
$rs = $this->db_oka_ne->query($sql);
if ($rs->num_rows() > 0) {

	/* unloading import case */
	$sql = "INSERT into pxp_ldt.unloading_import_case(plan_date, vanning_code, cont_no, caseno, status, unloading_at, unloading_by, unloading_casemark, shippingcode, upload_at, upload_by, receive_at, receive_by, caseid, containerid, impcode, receive_location) 
select '1999-09-09' as plan_date, vanningcode as vanning_code, containerno as cont_no, caseno, status, unloading_at, unloading_by, code_qr_casemark as unloading_casemark, shippingcode, upload_at, upload_by, receive_at, receive_by, caseid, containerid, impcode, idlocation from import_case ic 
where concat(containerno, shippingcode, caseno) in (
	select concat(containerno, shippingcode, caseno) from import_case uic where to_char(upload_at,'YYYY-MM') ='$cm' and LEFT(caseno,2) IN ('H1','H2','TY') and status in ('shipping','receive','unloading')  
	and concat(containerno, shippingcode, caseno) not in (
		select concat(cont_no, shippingcode, caseno) from pxp_ldt.unloading_import_case uic where status in('receive','shipping','unloading')
	)
)
on conflict do nothing;

/* shipping plan */
insert into pxp_ldt.machining_shipping_plan(id, caseno, partno, rubetsu, partname, qty, containerno, fta_code, shippingcode, vanningcode, efa_mfn, status, created_at, created_by, caseid, containerid, impcode) 
select 
	ROW_NUMBER () OVER (ORDER by partid) + (select max(id) from pxp_ldt.machining_shipping_plan) as id,
	a.caseno, a.partno, '00' rubetsu, a.partname, a.qty, containerno, '-' fta_code, a.shippingcode, vanningcode, '-' efa_mfn, /*'waiting'*/ status, upload_at created_at, upload_by created_by, caseid, 	containerid, impcode
from import_part a 
where concat(containerno, shippingcode, caseno) in (
	select concat(containerno, shippingcode, caseno) from import_case uic where to_char(upload_at,'YYYY-MM') ='$cm' and LEFT(caseno,2) IN ('H1','H2','TY') and status in ('shipping','receive','unloading')  
	and concat(containerno, shippingcode, caseno) not in (
		select concat(containerno, shippingcode, caseno) from pxp_ldt.machining_shipping_plan uic where status in('receive','shipping','unloading')
	) 
)	
on conflict do nothing;";
	$this->db_oka_ne->query($sql);
}


//assembling
$sql = "SELECT * from import_case uic where to_char(upload_at,'YYYY-MM') ='$cm' and LEFT(caseno,2) IN ('ND','NG','NH') and status in ('shipping','receive','unloading')  
	and concat(containerno, shippingcode, caseno) not in (
		select concat(cont_no, shippingcode, caseno) from pxp_asm.unloading_import_case uic where status in('receive','shipping','unloading')
) limit 1";
$rs = $this->db_oka_ne->query($sql);
if ($rs->num_rows() > 0) {

	/* unloading import case */
	$sql = "INSERT into pxp_asm.unloading_import_case(plan_date, vanning_code, cont_no, caseno, status, unloading_at, unloading_by, unloading_casemark, shippingcode, upload_at, upload_by, receive_at, receive_by, caseid, containerid, impcode, receive_location) 
select '1999-09-09' as plan_date, vanningcode as vanning_code, containerno as cont_no, caseno, status, unloading_at, unloading_by, code_qr_casemark as unloading_casemark, shippingcode, upload_at, upload_by, receive_at, receive_by, caseid, containerid, impcode, idlocation from import_case ic 
where concat(containerno, shippingcode, caseno) in (
	select concat(containerno, shippingcode, caseno) from import_case uic where to_char(upload_at,'YYYY-MM') ='$cm' and LEFT(caseno,2) IN ('ND','NG','NH') and status in ('shipping','receive','unloading')  
	and concat(containerno, shippingcode, caseno) not in (
		select concat(cont_no, shippingcode, caseno) from pxp_asm.unloading_import_case uic where status in('receive','shipping','unloading')
	)
)
on conflict do nothing;


/* shipping plan */
insert into pxp_asm.assembling_shipping_plan(id, caseno, partno, rubetsu, partname, qty, containerno, fta_code, shippingcode, vanningcode, efa_mfn, status, created_at, created_by, caseid, containerid, impcode) 
select 
	ROW_NUMBER () OVER (ORDER by partid) + (select max(id) from pxp_asm.assembling_shipping_plan) as id,
	a.caseno, a.partno, '00' rubetsu, a.partname, a.qty, containerno, '-' fta_code, a.shippingcode, vanningcode, '-' efa_mfn, /*'waiting'*/ status, upload_at created_at, upload_by created_by, caseid, 	containerid, impcode
from import_part a 
where concat(containerno, shippingcode, caseno) in (
	select concat(containerno, shippingcode, caseno) from import_case uic where to_char(upload_at,'YYYY-MM') ='$cm' and LEFT(caseno,2) IN ('ND','NG','NH') and status in ('shipping','receive','unloading')  
	and concat(containerno, shippingcode, caseno) not in (
		select concat(containerno, shippingcode, caseno) from pxp_asm.assembling_shipping_plan uic where status in('receive','shipping','unloading')
	) 
)	
on conflict do nothing;";
	$this->db_oka_ne->query($sql);
}
