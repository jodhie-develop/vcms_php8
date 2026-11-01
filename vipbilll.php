<?php
require_once __DIR__ . "/_lib/bootstrap.php"; csrf_guard_get(); auth_require_login(); 
include __DIR__ . "/conndb.php";
include __DIR__ . "/profiledata.php";
include __DIR__ . "/atas.php";
include __DIR__ . "/left.php";

$nama_lengkap = $_SESSION['nama_lengkap']; 
$kdcbg = $_SESSION['kd_branch']; 
$kdb = in_val('kdb', 'any');
$st = in_val('st', 'any');
$hari=date("d");
$bulan=date("m");
$bulanan=date("M");
$private_hours = in_val('private_hours', 'any');
$type_class = in_val('type_class', 'any');
$nm_program = in_val('nm_program', 'any');
$nm_level = in_val('nm_level', 'any');
$material_fee = in_val('material_fee', 'any');
$reg_fee = in_val('reg_fee', 'any');
$sc = in_val('sc', 'any');
$material_book = in_val('material_book', 'any');
if ($material_book =='') {$material_book ='No';}
$book_title = in_val('book_title', 'any');
if ($book_title =='') {$book_title ='No Book';}
$nik = in_val('nik', 'any');

if ($nik == '')
{
$query_nik = q_set($__p_query_nik, "SELECT nik FROM ves_data.tb_nik  where kd_biodata = ? ", [(string) ($kdb)]);	
$resource_nik = db_query_soft($query_nik, $__p_query_nik ?? []);
$keluar_nik = db_num_rows($resource_nik);
if(num(db_num_rows($resource_nik)) > 0)
	{
	while ($row_nik  =  db_fetch($resource_nik, PDO::FETCH_NUM))
		{
		$nik = $row_nik[0];
		}
	}
}

$idb = in_val('idb', 'any');
if ($type_class != 'WORKSHOPS')
	{
	if($nm_program !="" and $nm_level !="")
		{
		$query_kode_program = q_set($__p_query_kode_program, "SELECT kd_program FROM ves_data.vip_mst_code_prg where nm_program = ? and level_program = ? and type_program = ? and aktif = 1", [(string) ($nm_program), (string) ($nm_level), (string) ($type_class)]);			
		$resource_kode_program = db_query_or_die('errro_1', $query_kode_program, $__p_query_kode_program ?? []);
		while ($row_kode_program=  db_fetch($resource_kode_program, PDO::FETCH_NUM))
			{
			$kode_program =   $row_kode_program[0];
			}   
		}		
	}
else
	{
	$nm_level = '';
	$query_kode_program = q_set($__p_query_kode_program, "SELECT kd_program FROM ves_data.vip_mst_code_prg where nm_program = ? and type_program = ?  and aktif = 1", [(string) ($nm_program), (string) ($type_class)]);			
	$resource_kode_program = db_query_or_die('errro_2', $query_kode_program, $__p_query_kode_program ?? []);
	while ($row_kode_program=  db_fetch($resource_kode_program, PDO::FETCH_NUM))
		{
		$kode_program =   $row_kode_program[0];
		}   
	}		

//==get price
$tf = '0';
$query_price = q_set($__p_query_price, "SELECT " . kol_harga($kdcbg) . " FROM ves_data.vip_mst_price where kd_program = ? and level_program = ? ", [(string) ($kode_program), (string) ($nm_level)]);
$resource_price = db_query_or_die('errro_31', $query_price, $__p_query_price ?? []);
while ($row_price=  db_fetch($resource_price, PDO::FETCH_NUM))
	{
	$tf =   $row_price[0];
	} 

$private_pax = in_val('private_pax', 'any');
$nm_promo = in_val('nm_promo', 'any');
if($nm_promo !='')
	{
	$query_promo = q_set($__p_query_promo, "SELECT tf, rf, cashback FROM ves_data.vip_mst_promo where nm_promo = ? and (kd_branch = ? or kd_branch = '0')", [(string) ($nm_promo), (string) ($kdcbg)]);
	$resource_promo = db_query_or_die('errro_4', $query_promo, $__p_query_promo ?? []);
	while ($row_promo=  db_fetch($resource_promo, PDO::FETCH_NUM))
		{
		$discount_tf =   $row_promo[0];
		$discount_rf =   $row_promo[1];
		$discount_cashback =   $row_promo[2];
		}		
	}

$voucher = in_val('voucher', 'any');
//=====
$tahun=date("Y");
$tgl_hari_ini =  "$tahun-$bulan-$hari";
//get data stu
$query_student = q_set($__p_query_student, "SELECT t.kd_biodata, t.nama, t.middle_name, t.family_name, t.address, t.city FROM ves_inc.tb_biodata t where t.kd_biodata = ? ", [(string) ($kdb)]);
$resource_student= db_query_or_die('errro_8', $query_student, $__p_query_student ?? []);
$keluar_student= db_num_rows($resource_student);
if(num(db_num_rows($resource_student)) > 0)
	{
	while ($row_student=  db_fetch($resource_student, PDO::FETCH_NUM))
		{
		$kd_biodata= $row_student[0];				
		$nama= $row_student[1];		
		$middle_name = $row_student[2];
		$family_name = $row_student[3];
		$address = $row_student[4];
		$city = $row_student[5];
			
		$student_name ="$nama $middle_name $family_name";
		
		}
	}

//=============


//load SC

if (num($tf) !=0)
{
if($tf !="")
	{
	$tf_nett = num($tf) - num($voucher);	
	$tf_nett = num($tf_nett) - num((num($tf_nett) * num((num($discount_tf)/100))));	

	}
if($tf_nett =='') {$tf_nett = in_val('tf_nett', 'any');}
}
else
{
$tf_nett = '0';	
}
//==========setting cara bayar
$type_pay = in_val('type_pay', 'any');
$old_student = in_val('old_student', 'any');

if($type_pay =='Registration' and $old_student !='Yes')
	{
	$query_payment = q_set($__p_query_payment, "SELECT " . kol_harga($kdcbg) . " FROM ves_data.vip_mst_price where kd_program = ? ", [(string) ($type_pay)]);
	$resource_payment = db_query_or_die('errro_71', $query_payment, $__p_query_payment ?? []);
	while ($row_payment=  db_fetch($resource_payment, PDO::FETCH_NUM))
		{

		$reg_fee = 	  $row_payment[0];	
		//if ($nm_program == 'CA'){$reg_fee == '200000';}
		}
	$amount = $reg_fee;	
	}
elseif($type_pay =='Registration' and $old_student =='Yes')
	{
		$amount = '0';
	}

elseif ($type_pay =='Material')
	{
	$amount=$material_fee;		
	}
elseif ($type_pay =='Full Payment')
	{
	$amount= $tf_nett;		
	}
elseif ($type_pay =='Installment 1' or $type_pay =='Installment 2' or $type_pay =='Installment 3')
	{
//	$amount= $tf_nett;	
	$query_dp_ins = q_set($__p_query_dp_ins, "SELECT sum(amount)  FROM ves_data.vip_billing_payment where  (jns_payment = 'Down Payment' or jns_payment like 'Installment%') and kd_billing = ? ", [(string) ($idb)]); 
	$resource_dp_ins = db_query_or_die('errro_73', $query_dp_ins, $__p_query_dp_ins ?? []);
	while ($row_dp_ins=  db_fetch($resource_dp_ins, PDO::FETCH_NUM))
		{
		$dp_ins =   $row_dp_ins[0];	
		}
	$amount = num($tf_nett)-num($dp_ins);		
	}
else
	{
	$amount='0';	
	}

$book_title = in_val('book_title', 'any');
$old_student = in_val('old_student', 'any');
if(num($st)==1)
	{	
	$query_ambil_billing = q_set($__p_query_ambil_billing, "SELECT\r
\tb.type_program, b.nm_program, b.level_program, a.kd_program,\r
\ta.material, a.tf, a.voucher, a.discount,a.old_student , a.net_tf,a.kd_billing,a.material_cost,a.old_student,a.kd_biodata,a.sc,a.private_pax, a.private_hours,reg_fee,book_title,book_status\t  FROM ves_data.vip_billing a\r
\tleft join ves_data.vip_mst_code_prg b on a.kd_program = b.kd_program and a.level_program = b.level_program  where a.kd_billing = ? ", [(string) ($idb)]);

	$resource_ambil_billing = db_query_or_die('errro_75', $query_ambil_billing, $__p_query_ambil_billing ?? []);
	while ($row_ambil_billing=  db_fetch($resource_ambil_billing, PDO::FETCH_NUM))
		{
		$type_class =   $row_ambil_billing[0];
		$nm_program =   $row_ambil_billing[1];
		$nm_level =   $row_ambil_billing[2];
		$kode_program =  $row_ambil_billing[3];
		$material_book =  $row_ambil_billing[4];
		$tf =   $row_ambil_billing[5];
		$voucher =   $row_ambil_billing[6];
		$nm_promo =   $row_ambil_billing[7];
		$old_student =   $row_ambil_billing[8];
		$tf_nett 	 =   $row_ambil_billing[9];
		$idb 	 =   $row_ambil_billing[10];
		$material_fee 	 =   $row_ambil_billing[11];
		$old_student 	 =   $row_ambil_billing[12]; 
		$kdb =   $row_ambil_billing[13]; 
		$sc =   $row_ambil_billing[14]; 
		$private_pax =   $row_ambil_billing[15]; 			
		$private_hours =   $row_ambil_billing[16]; 
		$reg_fee =   $row_ambil_billing[17];
		$book_title = $row_ambil_billing[18];
		$book_status = $row_ambil_billing[19];		
		}
		}
else
{

if($nm_promo !='')
	{
	$query_promo = q_set($__p_query_promo, "SELECT tf, rf, cashback FROM ves_data.vip_mst_promo where nm_promo = ? and  (kd_branch = ? or kd_branch = '0')", [(string) ($nm_promo), (string) ($kdcbg)]);
	$resource_promo = db_query_or_die('errro_76', $query_promo, $__p_query_promo ?? []);
	while ($row_promo=  db_fetch($resource_promo, PDO::FETCH_NUM))
		{
		$discount_tf =   $row_promo[0];
		$discount_rf =   $row_promo[1];
		$discount_cashback =   $row_promo[2];
		}		
	}



if ($material_book !='No')
	{
	$query_material = q_set($__p_query_material, "SELECT " . kol_harga($kdcbg) . " FROM ves_data.vip_mst_price where kd_program = ? ", [(string) ($material_book)]);
	$resource_material = db_query_or_die('errro_718', $query_material, $__p_query_material ?? []);
	while ($row_material=  db_fetch($resource_material, PDO::FETCH_NUM))
		{
		$material_fee = $row_material[0];	
		}		
	}
else
	{
	$material_fee ='0';
	}

if ($old_student =='No')
	{
	$query_registration = q_set($__p_query_registration, "SELECT " . kol_harga($kdcbg) . " FROM ves_data.vip_mst_price where kd_program = 'Registration'");
	$resource_registration = db_query_or_die('errro_71', $query_registration, $__p_query_registration ?? []);
	while ($row_registration=  db_fetch($resource_registration, PDO::FETCH_NUM))
		{
		$reg_fee = 	  $row_registration[0];	
		}		
	}
else
	{$reg_fee = 0;}
if($nm_promo =='Free Registration')
	{
		$reg_fee = 0;
	}
//=========hitung di invoice
$query_invoiced = q_set($__p_query_invoiced, "SELECT  sum(amount) as ttl FROM ves_data.vip_billing_payment where kd_billing  = ? group by kd_billing", [(string) ($idb)]);
$resource_invoiced = db_query_or_die('errro_71', $query_invoiced, $__p_query_invoiced ?? []);
while ($row_invoiced=  db_fetch($resource_invoiced, PDO::FETCH_NUM))
	{
	$ttl_invoiced = $row_invoiced[0];	
	}


//================
if($type_class == 'PRI')
{
//==== harga private

if ($kdcbg =='1' or $kdcbg=='2' or $kdcbg=='4' or $kdcbg=='5' or $kdcbg=='6')
	{
	if ($private_pax == '1'){$harga_private = '385000';}	
	if ($private_pax == '2'){$harga_private = '260000';}	
	if ($private_pax == '3'){$harga_private = '190000';}	
	if ($private_pax == '4'){$harga_private = '160000';}	

	}
elseif ($kdcbg == '8')
	{
	if ($private_pax == '1'){$harga_private = '225000';}	
	if ($private_pax == '2'){$harga_private = '163333';}	
	if ($private_pax == '3'){$harga_private = '163333';}	
	if ($private_pax == '4'){$harga_private = '120000';}		
	}
else
	{
	if ($private_pax == '1' and $private_hours =='20'){$harga_private = '380000';}	
	elseif ($private_pax == '1' and $private_hours =='10'){$harga_private = '385000';}	
	
	if ($private_pax == '2'){$harga_private = '240000';}	
	if ($private_pax == '3'){$harga_private = '170000';}	
	if ($private_pax == '4'){$harga_private = '150000';}		
	}
	
if ($nm_program =='LC')	
	{
	if ($kdcbg == '7')
		{$harga_private = '250000';}
	elseif ($kdcbg == '8')
		{$harga_private = '100000';}
	 		
	elseif($kdcbg=='3')
		{$harga_private = '250000';}
	else
		{$harga_private = '250000';}
	}
elseif ($nm_program =='LC' and $nm_level =='Savvy 10 H - add Service')	
	{
	if ($kdcbg == '7')
		{$harga_private = '250000';}
	elseif ($kdcbg == '8')
		{$harga_private = '100000';}
	 		
	elseif($kdcbg=='3')
		{$harga_private = '250000';}
	else
		{$harga_private = '4500000';}
	}	
elseif ($nm_program =='BE' and $nm_level  == 'Placement Test CEPT')	
	{
	$harga_private = '200000';
	$private_pax = 1;
	$private_hours = 1;
	}
elseif ($nm_program =='ESP' and $nm_level  == 'SDP 10 hrs')	
	{
	$harga_private = '5000000';
	$private_pax = 1;
	$private_hours = 10;
	}
elseif ($nm_program =='ESP' and $nm_level  == 'SDP 20 hrs')	
	{
	$harga_private = '425000';
	$private_pax = 1;
	$private_hours = 20;
	}


if ($kdcbg == '8' and $type_class =='PRI' and  	num($private_pax) == 1 and (num($private_hours) == 30 or num($private_hours) == 40  ) ){$tf = '10000000';}	
elseif ($kdcbg == '8' and $type_class =='PRI' and 	 num($private_hours) == 30 and num($private_pax) == 2 ){$tf = '4900000';}	
elseif ($kdcbg == '8' and $type_class =='PRI' and 	 num($private_hours) == 30 and num($private_pax) == 3  ){$tf = '3600000';}	
//====
elseif ($kdcbg <> '8' and $type_class =='PRI' and $nm_program <> 'ESP' and	num($private_pax) == 1 and num($private_hours) == 30 ){$tf = '13500000';}	
elseif ($kdcbg <> '8' and $type_class =='PRI'  and $nm_program <> 'ESP' and 	 (num($private_hours) == 30 or num($private_hours) == 20) and (num($private_pax) == 2 ) ){$tf = '8500000';}	
elseif ($kdcbg <> '8' and $type_class =='PRI'  and $nm_program <> 'ESP' and 	 (num($private_hours) == 30 or num($private_hours) == 20) and (num($private_pax) == 3 ) ){$tf = '6500000';}	
	
	
//==sdp
if ($kdcbg <> '8' and $type_class =='PRI' and $nm_program == 'ESP' and	num($private_pax) == 1 and num($private_hours) == 20 ){$tf = '8500000';}	
if ($kdcbg <> '8' and $type_class =='PRI' and $nm_program == 'ESP' and	num($private_pax) == 1 and num($private_hours) == 10 ){$tf = '4500000';}	
if ($kdcbg == '1' and $type_class =='PRI' and $nm_program == 'TOEFL' and $kode_program== 'TPWAP' and	num($private_hours) == 12 ){$tf = '3120000';}

if($type_class == 'PRI' and ($nm_program =='GE' or $nm_program =='AE' or $nm_program =='BE' or $nm_program =='CO' ))
{
if ($kdcbg =='1' or $kdcbg=='2' or $kdcbg=='4' or $kdcbg=='5' or $kdcbg=='6')
	{
	if ($private_pax == '1'){$harga_private = '385000';}	
	if ($private_pax == '2'){$harga_private = '260000';}	
	if ($private_pax == '3'){$harga_private = '190000';}	
	if ($private_pax == '4'){$harga_private = '160000';}	

	}
$tf = (num($harga_private) * num($private_hours));		
}
$tf = (num($harga_private) * num($private_hours));	
if($type_class == 'PRI' and ($nm_program =='GE' or $nm_program =='AE' or $nm_program =='BE' or $nm_program =='CO' ) and $kdcbg =='8')
{
if ($kdcbg =='1' or $kdcbg=='2' or $kdcbg=='4' or $kdcbg=='5' or $kdcbg=='6' )
	{
	if ($private_pax == '1'){$harga_private = '385000';}	
	if ($private_pax == '2'){$harga_private = '260000';}	
	if ($private_pax == '3'){$harga_private = '190000';}	
	if ($private_pax == '4'){$harga_private = '160000';}	

	}
elseif  ($kdcbg =='8')
	{
	if ($private_pax == '1'){$harga_private = '250000';}	
	if ($private_pax == '2'){$harga_private = '180000';}	
	if ($private_pax == '3'){$harga_private = '150000';}	
	if ($private_pax == '4'){$harga_private = '120000';}	

	}

$tf = (num($harga_private) * num($private_hours));		
}
if ($kdcbg == '3' and $type_class =='PRI' and ($nm_program == 'ESP' or $nm_program == 'GE') and	num($private_pax) == 1 and num($private_hours) == 30 ){$tf = '13500000';}	
elseif ($kdcbg == '8' and $type_class =='PRI' and $nm_program == 'IELTS' and $nm_level == 'Entrant' and	num($private_pax) == 4 and num($private_hours) == 30 ){$tf = '2700000';}		
elseif ($kdcbg != '8' and $type_class =='PRI' and $kode_program=='IETTPP' and num($private_pax) == 1 and num($private_hours) == 30 ){$tf = '11700000';}
elseif ($kdcbg != '8' and $type_class =='PRI' and $kode_program=='IETTPP' and num($private_pax) == 1 and num($private_hours) == 20 ){$tf = '7700000';}
elseif ($kdcbg != '8' and $type_class =='PRI' and $kode_program=='IETTPP' and num($private_pax) == 1 and num($private_hours) == 10 ){$tf = '3900000';}	
elseif ($type_class =='PRI' and $kode_program=='FTP' and num($private_pax) == 1 and num($private_hours) == 10 ){$tf = '5000000';}	
elseif ($kdcbg != '8' and $type_class =='PRI' and $kode_program=='FTP' and num($private_pax) == 1 and num($private_hours) == 20 ){$tf = '8000000';}	
	
elseif ($kdcbg == '8' and $type_class =='PRI' and $kode_program=='FTP' and num($private_pax) == 1 and num($private_hours) == 10 ){$tf = '3850000';}	
elseif ($kdcbg == '8' and $type_class =='PRI' and $kode_program=='FDST-AP' and num($private_pax) == 1 and num($private_hours) == 40 ){$tf = '10000000';}	

if ($kode_program=='VIPUV' and num($private_pax) == 1 and num($private_hours) == 4 ){$tf = '2000000';}		
if($type_class =='PRI')
	
	{	
	if(num($kdcbg) != 8)
		{
		 if ($nm_program=='SAT')
		 {
			 if(num($private_pax) == 1 and num($private_hours) == 30 ){$tf = '15000000';}
			 elseif(num($private_pax) == 1 and num($private_hours) == 10 ){$tf = '5000000';}
		 }
		elseif ($kode_program =='CAP')
		{
		if(num($private_pax) >= 1 and num($private_pax) <= 1  and num($private_hours) == 12){$tf =5700000;}
		elseif(num($private_pax) >= 1 and num($private_pax) <= 1  and num($private_hours) == 18){$tf =8300000;}
			
		}
		elseif ($kode_program =='IETTPP')
		{
		if( num($private_pax) == 1  and num($private_hours) == 10){$tf =5000000;}
		elseif(num($private_pax) >= 1 and num($private_pax) <= 1  and num($private_hours) == 18){$tf =8300000;}
			
		}		
else		
		{
		if(num($private_pax) == 4 and num($private_hours) == 40){$tf =6300000;}
		elseif(num($private_pax) == 3 and num($private_hours) == 40){$tf =6300000;}
		elseif(num($private_pax) == 2 and num($private_hours) == 40){$tf =9000000;}
		elseif(num($private_pax) == 1 and num($private_hours) == 40){$tf =15000000;}
		}		
		}

		if ($type_class =='PRI' and $kode_program=='LCT'  and $nm_level =='TOP UP 10H - add Service'){$tf = '4500000';}		

			elseif ($type_class =='PRI' and $kode_program=='CAWCP' and $nm_level == 'WSC'){$tf = '8300000';}		
		elseif ($type_class =='PRI' and $kode_program=='VIPEP'){$tf = '7600000';}		
		elseif ($type_class =='PRI' and $kode_program=='IETOP'){$tf = '300000';}		
	
if ($nm_program =='CA')
	{
	if ($kode_program=='CAPWP' and $nm_level =='WSC-PWAANATION' and $private_hours =='12'){$tf = '5700000';}		
	elseif ($kode_program=='CAPWP' and $nm_level =='WSC-PWAANATION' and $private_hours =='18'){$tf = '8300000';}	
	elseif ($kode_program=='CAYNP' and $nm_level =='AYIMUN' and $private_hours =='12'){$tf = '5700000';}		
	elseif ($kode_program=='CAYNP' and $nm_level =='AYIMUN' and $private_hours =='18'){$tf = '8300000';}		
	elseif ($kode_program=='CADSP' and $nm_level =='DEBATS' and $private_hours =='12'){$tf = '5700000';}	
	elseif ($kode_program=='CADSP' and $nm_level =='DEBATS' and $private_hours =='18'){$tf = '8300000';}	
	elseif ($kode_program=='CAMDP' and $nm_level =='MUN - DIPLOMAT' and $private_hours=='12'){$tf = '5700000';}
	elseif ($kode_program=='CAWCP' and $nm_level =='WSC' and $private_hours=='18'){$tf = '8300000';}
	elseif ($kode_program=='CAMDP' and $nm_level =='MUN - DIPLOMAT' and $private_hours=='18'){$tf = '8300000';}	
	elseif ($kode_program=='CAGCP'  and $private_hours=='6'){$tf = '2600000';}		
	elseif ($kode_program=='CAGCP'  and $private_hours=='12'){$tf = '5700000';}	
	elseif ($kode_program=='CAGCP'  and $private_hours=='18'){$tf = '8300000';}	
	elseif ($kode_program=='CAGRP'  and $private_hours=='6'){$tf = '2600000';}		
	elseif ($kode_program=='CAGRP'  and $private_hours=='12'){$tf = '5700000';}	
	elseif ($kode_program=='CAGRP'  and $private_hours=='18'){$tf = '8300000';}	
	elseif ($kode_program=='CAWCP'  and $private_hours=='18'){$tf = '8300000';}		
	}
$tf_nett = num($tf) -  num((num($tf) * num((num($discount_tf)/100)))) - num($voucher);
	}
	
$tf_nett = num($tf) -  num((num($tf) * num((num($discount_tf)/100)))) - num($voucher);
	
}
//$tf_nett = ($tf - $voucher)-  (($tf - $voucher) * ($discount_tf/100));
$tf_nett = num($tf) -  num((num($tf) * num((num($discount_tf)/100)))) - num($discount_cashback) - num($voucher);
 
$reg_fee_net = num($reg_fee) - num($discount_rf);	
$totalinvoice = num($tf_nett) + num($material_fee) + num($reg_fee);
$outstanding = 	num($totalinvoice) - num($ttl_invoiced);
//
}

if($book_status != ''){$buku_pilihan = 1;}else{$buku_pilihan = 0;} 
$st = 0;	


?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Vista Customer System Management</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="css/font-awesome/css/font-awesome.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="css/ionicons/css/ionicons.min.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="plugins/datatables/dataTables.bootstrap.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">
	    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"></link>
    <script src="http://code.jquery.com/jquery-3.1.1.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/js/bootstrap-datepicker.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/css/bootstrap-datepicker.css"></link>
  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
  <style>

function fScroll(val)
{
        var hidScroll = document.getElementById('hidScroll');
        hidScroll.value = val.scrollTop;
}

// function moves scroll position to saved value
function fScrollMove(what)
{
        var hidScroll = document.getElementById('hidScroll');
        document.getElementById(what).scrollTop = hidScroll.value;
}
.style92 {color: #FFFFFF; font-weight: bold; font-size: 13px; font-family: Calibri; }
</style>
    <script language="JavaScript">
function readCookie(name){
return(document.cookie.match('(^|; )'+name+'=([^;]*)')||0)[2]
}

</script><body onScroll="document.cookie='ypos=' + window.pageYOffset" onLoad="window.scrollTo(0,readCookie('ypos'))">
  
</head>
<body class="hold-transition skin-blue sidebar-mini">

  <!-- Left side column. contains the logo and sidebar -->
  

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
     <div class="box box-warning">
<div class="box-body">
	<h3>VIP Billing Statement</h3>
	<h5>Invoice Number : <?php echo e($idb) ?></h5>
</div>
     </div>
    </section>
   <!-- Main content -->
<section class="content">
  <div class="row">
        <!-- left column -->

        <!--/.col (left) -->
        <!-- right column -->

<form name="myform" id="myform" method="post"><?php echo csrf_field(); ?>


    <div class="col-md-12">
<div class="box box-warning">
<div class="box-body"><span class="form-group">
  <input type="text" ang="en-150"  name="kdcbg" 
                 	      value="<?php echo e($kdcbg) ?>" hidden="hidden">
</span>
  <div class="col-md-8">
    <div class="form-group">
      <label>Student Name</label>
      <input type="text" ang="en-150" class="form-control"  placeholder="Enter ..." name="student_name" 
                 	      value="<?php echo e($student_name) ?>" readonly>
    </div>
  </div>
  <div class="col-md-3">
    <div class="form-group">
      <label>Detail</label><br>
      <a href="leadsupdate.php?kdb=<?php echo e(u($kdb)) ?>"  class="btn btn-primary btn-md"> Profile</a>
      <input type="hidden" ang="en-150"   name="material_fee" 
                 	      value="<?php echo e($material_fee) ?>" >
      <input type="hidden" ang="en-150"   name="reg_fee" 
                 	      value="<?php echo e($reg_fee) ?>" >
    </div>
  </div>
  <span class="form-group">
  <input type="hidden" ang="en-150" name="kdb" 
                 	      value="<?php echo e($kdb) ?>" >
<input type="hidden" ang="en-150"   name="enroll_date" 
                 	      value="<?php echo e($enroll_date) ?>" hidden="hidden">
  </span>
  <div class="col-md-8">
    <div class="form-group">
      <label>Address</label>
      <input name="address"  class="form-control"  type="text" size="90" value="<?php echo e($address) . " ".e($city) ?>" />
    </div>
  </div>
  <div class="col-md-3">
    <div class="form-group">
      <label>NIK</label>
      <input name="nik"  class="form-control"  type="text" size="90" value="<?php echo e($nik) ?>" />
    </div>
  </div>
  <span class="form-group">
  <input type="text" ang="en-150"   name="st" 
                 	      value="<?php echo e($st) ?>" hidden="hidden" >
  </span><span class="form-group">
  <input type="hidden" ang="en-150"   name="idb" 
                 	      value="<?php echo e($idb) ?>" >
  </span></div>
	  </div>
<div class="box box-warning">		
<div class="box-body">
  <div class="col-md-12">
    <div class="form-group">
      <label>PROGRAM INFO</label>
    </div>
  </div>
  <div class="col-md-3">
	      <div class="form-group">
			      <label>Type Class</label>
	        <select class="form-control" name="type_class"  onChange="this.form.submit()">
			        <option>REG</option>
			        <option>PRI</option>
			        <option>WORKSHOP</option>
				        <option>CLINIC</option>	
				        <option>EVENT</option>		
				        <option>VPRO</option>					
			        <option selected><?php echo  e($type_class) ?></option>
            </select>
          </div>
	    </div>
  <div class="col-md-3">
    <div class="form-group">
      <label>Program</label>
      <select class="form-control" name="nm_program"  onChange="this.form.submit()">
        <?php
									$query_nm_program = q_set($__p_query_nm_program, "SELECT distinct nm_program FROM ves_data.vip_mst_code_prg WHERE type_program = ? and aktif = 1", [(string) ($type_class)]);
								$resource_nm_program = db_query_or_die('errro_7', $query_nm_program, $__p_query_nm_program ?? []);
								while ($row_nm_program=  db_fetch($resource_nm_program, PDO::FETCH_NUM))
									{
							  		echo '<option value="'.e($row_nm_program[0]).'">'.e($row_nm_program[0]).'</option>';
							  		}      ?>
        <option selected><?php echo  e($nm_program) ?></option>
      </select>
    </div>
  </div>
  <div class="col-md-3">
    <div class="form-group">
      <label>Level</label>
      <select class="form-control" name="nm_level"  onChange="this.form.submit()">
        <?php
								$query_level = q_set($__p_query_level, "SELECT level_program FROM vip_mst_code_prg where nm_program = ? and  type_program = ? and aktif = 1", [(string) ($nm_program), (string) ($type_class)]);
								$resource_level = db_query_or_die('errro_7', $query_level, $__p_query_level ?? []);
								while ($row_level=  db_fetch($resource_level, PDO::FETCH_NUM))
									{
							  		echo '<option value="'.e($row_level[0]).'">'.e($row_level[0]).'</option>';
							  		}      ?>
        <option selected><?php echo  e($nm_level) ?></option>
      </select>
    </div>
  </div>
  <div class="col-md-3">
    <div class="form-group">
      <label>Code</label>
      <input type="text" ang="en-150" class="form-control"  placeholder="Enter ..." name="kode_program" 
                 	      value="<?php echo e($kode_program) ?>" readonly>
    </div>
  </div>
  <div class="col-md-2">
    <div class="form-group">
      <label>Material Book</label>
      <select name="material_book" id="program_clasifie3" class="form-control"   onChange="this.form.submit()">
        <?php
								$query_exam = q_set($__p_query_exam, "SELECT distinct exam, case when exam = 'Y' then 'Exam' when exam = 'N' then 'Non Exam' when exam <> 'Y' and exam <> 'N' then 'Material Handout'   end FROM vip_mst_code_prg where nm_program = ? ", [(string) ($nm_program)]);
								$resource_exam = db_query_or_die('errro_7', $query_exam, $__p_query_exam ?? []);
								while ($row_exam=  db_fetch($resource_exam, PDO::FETCH_NUM))
									{
							  		echo '<option value="'.e($row_exam[1]).'">'.e($row_exam[1]).'</option>';
							  		}      ?>
							  		<option>No</option>       
        <option selected="selected">          <?php  echo e($material_book)    ?>          </option>
      </select>
      <input type="hidden" ang="en-150" class="form-control"  placeholder="Enter ..." name="material_fee" 
                 	      value="<?php echo e($material_fee) ?>" hidden="">
    </div>
</div>
 <?php //==== 
if ($type_class == 'PRI')
{
	?>
  <div class="col-md-2">
    <div class="form-group">
      <label>Private - Pax</label>
      <select name="private_pax" id="material_book" class="form-control"   onChange="this.form.submit()">
       <?php if ($nm_program !='LC' and $nm_program !='VIP UniView'  ) {?>
        <option value= "1">1</option>
        <option value= "2">2</option>
        <option value= "3">3</option>
        <option value= "4">4</option>   
        <?php } else {?>             
                <option value= "1">1</option>
<?php }?>
        <option selected="selected">
          <?php  echo e($private_pax)    ?>
          </option>
      </select>
    </div>
  </div>
  <div class="col-md-2">
    <div class="form-group">
      <label>Private -  Hours</label>
      <select name="private_hours" id="private_hours" class="form-control"   onChange="this.form.submit()">
       <?php 
		if (num($kdcbg) == 8) 
		{ 
			if ($nm_program == 'LC' or $nm_program =='ESP')
			{ ?>
			<option value= "20">20</option>
			<option value= "18">18</option>                
			<option value= "10">10</option>
      <?php } 
			else 
			{?>
			<option value= "40">40</option>
			<option value= "30">30</option>
			<option value= "20">20</option>		  
			<option value= "15">15</option>
			<option value= "10">10</option>		  
    <?php  }
		}
		else 
		{ 
		 	if ($nm_program == 'LC' or $nm_program =='ESP')
			{ ?>
			<option value= "30">30</option>			
			<option value= "20">20</option>
			<option value= "10">10</option>
	<?php   }
			elseif ($nm_program == 'BE')
			{ ?>
			<option value= "40">40</option>
			<option value= "30">30</option>
	<?php   } 
		elseif ($kode_program == 'TPWAP')
			{ ?>
			<option value= "12">12</option>
			<option value= "30">30</option>
	<?php   } 
			 	elseif ($kode_program == 'IETTPP')
			{ ?>
			<option value= "10">10</option>
			<option value= "20">20</option>
			<option value= "30">30</option>
	<?php   } 
			 	elseif ($kode_program == 'FTP')
			{ ?>
			<option value= "10">10</option>
			<option value= "20">20</option>
	<?php   } 	
			 	elseif ($kode_program == 'VIPUV')
			{ ?>
			<option value= "4">4</option>
			<option value= "8">8</option>
		  
	<?php   } 
			 	elseif ($kode_program == 'VIPCTP')
			{ ?>

			<option value= "8">8</option>
		  
	<?php   }			
			 	elseif ($kode_program == 'VIPEP')
			{ ?>
			<option value= "12">12</option>
	<?php   } 	
			 	elseif ($nm_program == 'CA')
			{ ?>
			<option value= "6">6</option>		  
			<option value= "8">8</option>		  
		  
			<option value= "12">12</option>		  
			<option value= "18">18</option>
	<?php   } 	
			 	elseif ($kode_program == 'IETOP')
			{ ?>
			<option value= "2">2</option>
	<?php   } 					
			
			else 
			{ ?>
			<option value= "8">8</option>		  
			<option value= "10">10</option>
			<option value= "12">12</option>

		  <option value= "16">16</option>
			<option value= "18">18</option>
		  
			<option value= "20">20</option>
			<option value= "24">24</option>
		  
			<option value= "30">30</option>		  
			<option value= "36">36</option>

		  <option value= "40">40</option>
		<?php } 
		}?>        
       <option selected="selected"><?php  echo e($private_hours)    ?>
          </option>
      </select>
    </div>
  </div>
 <?php }//==== ?> 
	  <div class="col-md-3">
			    <div class="form-group">
			      <label>Tuition Fee</label>
			      <input type="text" name="tf_display"  class="form-control" value = "<?php echo number_format(num($tf),0,".",".")  ?>"
			      <?php if ($type_class != 'WORKSHOP')
					{ ?>
			       readonly
			       <?php } ?>
			       />
	      </div>
      </div>
	  <input type="hidden" name="tf" id="textfield" value="<?php echo e($tf) ?>" hidden="hidden" >
	  <div class="col-md-3">
	    <div class="form-group">
	      <label>Voucher</label>
	      <select class="form-control" name="voucher"  onChange="this.form.submit()">
			  
	        <option>0</option>
<?php if ($nm_program =='CA')
{ ?>
	        <option>100000</option>	
	        <option>250000</option>	
			  
	        <option>300000</option>	
	        <option>400000</option>	
	        <option>500000</option>	
			  
	        <option>1030000</option>	
	        <option>3000000</option>				  
<?php }	
else {?>
			  	        <option>20000</option>	
	        <option>50000</option>			  
	        <option>100000</option>
	        <option>150000</option>	        
	        <option>200000</option>
	        <option>240000</option>				  
	        <option>245000</option>			  
	        <option>250000</option>
	        <option>300000</option>	        
	        <option>400000</option>	
	        <option>450000</option>	 			  
	        <option>500000</option>	 
	        <option>550000</option>	 
	        <option>600000</option>	 			  
	        <option>700000</option>		        
	        <option>750000</option>		        
	        <option>800000</option>		        	        
	        <option>1000000</option>	
	        <option>1070000</option>			  
	        <option>1250000</option>
	        <option>1300000</option>			  
	        <option>1400000</option>			  
	        <option>2050000</option>
	        <option>2800000</option>
			  
	        <option>6000000</option>			  
<?php } ?>	        
	        <option selected><?php echo  e($voucher) ?></option>
	        </select>
	    </div>
	    </div>
	  <div class="col-md-3">
	    <div class="form-group">
          <label>Discount / Promo / Cash Back</label>
          <select class="form-control" name="nm_promo"  onChange="this.form.submit()">
            <?php
								$query_discount = q_set($__p_query_discount, "SELECT nm_promo FROM ves_data.vip_mst_promo where  (kd_branch = ? or kd_branch = '0') group by nm_promo", [(string) ($kdcbg)]);
								$resource_discount = db_query_or_die('errro_7', $query_discount, $__p_query_discount ?? []);
								while ($row_discount=  db_fetch($resource_discount, PDO::FETCH_NUM))
									{
							  		echo '<option value="'.e($row_discount[0]).'">'.e($row_discount[0]).'</option>';
							  		}      ?>
            <option selected><?php echo  e($nm_promo) ?></option>
          </select>
	    </div>
  </div>
	  <div class="col-md-3">
	    <div class="form-group">
	      <label>Old Student</label>
	      <select name="old_student" id="discount" class="form-control"  onChange="this.form.submit()" >
	        <option value= "Yes">Yes</option>
	        <option value= "No">No</option>        
	        <option selected="selected">
	          <?php  echo e($old_student) ?>
	          </option>
	        </select>
	      <input type="hidden" ang="en-150" class="form-control"  placeholder="Enter ..." name="reg_fee2" 
                 	      value="<?php echo e($reg_fee) ?>">
	      </div>
	    </div>
	  <div class="col-md-3">
	    <div class="form-group">
<label> Tuition Fee (Netto)</label>
          <input type="text" name="tf_nett_display"  class="form-control" value = "<?php echo number_format(num($tf_nett),0,".",".")  ?>"readonly/>
        </div>
  </div>
	  <div class="col-md-4">
	    <div class="form-group">
	      <label>Material Book Title</label>
	      <select class="form-control" name="book_title"   onChange="this.form.submit()">
	        <?php if (num($buku_pilihan) == 0){
							  		echo '<option>No Book</option>';						
		
								$query_book = q_set($__p_query_book, "SELECT v.buku FROM ves_data.vipbookin v where kd_branch = ? group by v.buku", [(string) ($kdcbg)]);
								$resource_book = db_query_or_die('errro_7', $query_book, $__p_query_book ?? []);
								while ($row_book=  db_fetch($resource_book, PDO::FETCH_NUM))
									{
							  		echo '<option value="'.e($row_book[0]).'">'.e($row_book[0]).'</option>';
							  		}  }    ?>
	        <option selected><?php echo  e($book_title) ?></option>
	        </select>
	      </div>
	</div>
	  <input type="hidden" name="tf_nett" id="textfield2" value="<?php echo e($tf_nett) ?>">
      <input type="hidden" name="discount_tf" id="textfield3" value="<?php echo e($discount_tf) ?>" hidden="">
</div>
	  </div><div class="box box-warning">		
<div class="box-body">
			  <div class="col-md-10">
			    <table width="100%" class="table table-bordered table-striped" id="example2">
			      <tbody>
          <tr>
            <td width="12%" align=center class="style24">Registration Fee</td>
            <td width="11%" align=center class="style24">Material Cost</td>
            <td width="20%" align=center class="style24">Tuition Fee</td>
            <td width="10%" align=center class="style24">Discount</td>
            <td width="17%" align=center class="style24">Voucher</td>
            <td width="17%" align=center class="style24">Net Tuition Fee</td>
            <td width="13%" height="14" align=left class="style24">Total Invoice</td>
          </tr>
          <tr>
            <td align=center class="style24"><?php echo number_format(num($reg_fee_net),0,".",".")  ?></td>
            <td align=center class="style24"><?php echo number_format(num($material_fee),0,".",".")  ?></td>
            <td align=center class="style24"><?php echo number_format(num($tf),0,".",".")  ?></td>
            <td align=center class="style24"><?php echo  e($nm_promo) ?><br>              
              <?php echo e($discount_tf) ?> %</td>
            <td align=center class="style24"><?php echo number_format(num($voucher),0,".",".")  ?></td>
            <td align=center class="style24"><?php echo number_format(num($tf_nett),0,".",".")  ?></td>
            <td height="14" align=center class="style24"><strong><?php echo number_format(num($totalinvoice),0,".",".")  ?></strong></td>
          </tr>

        <tfoot>
        </tfoot>
    </table>
<br>
	    </div>
    <div class="col-md-8">
                  <table width="100%" class="table table-bordered table-striped" id="example1">

                <tbody>
		<?php 
//===jika ada invoice
$query_invoice = q_set($__p_query_invoice, "SELECT jns_payment, amount, a.status, dt_payment,no,kd_unik FROM ves_data.vip_billing_payment a left join ves_data.tb_banking b on a.no = b.id_transaksi  where kd_billing = ? ", [(string) ($idb)]);
$resource_invoice = db_query_soft($query_invoice, $__p_query_invoice ?? []);
$keluar_invoice = db_num_rows($resource_invoice);	
if(num(db_num_rows($resource_invoice)) > 0)

					if(num(db_num_rows($resource_invoice)) > 0)
	{
	while ($row_invoice  =  db_fetch($resource_invoice, PDO::FETCH_NUM))
		{

		
?>	
                  <tr>
                    <td width="17%" align=center class="style24"><?php echo e($row_invoice[0]) ?></td>
                    <td width="21%" align=center class="style24"><?php echo number_format(num($row_invoice[1]),0,".",".")  ?></td>
                    <td width="26%" align=center class="style24"><?php echo number_format(num($row_invoice[1])+num($row_invoice[5]),0,".",".")  ?> <em>(Please Ignore)</em></td>
                    <td width="12%" align=center class="style24"><?php echo e($row_invoice[2]) ?></td>
                    <td width="12%" align=left class="style24"><?php echo e($row_invoice[3]) ?></td>
                    <td width="10%" height="14" align=left class="style24">
                    <?php 
					if ($row_invoice[2] == 'unpaid')
						{ ?>
                    <a href="vipbill_del.php?no=<?php echo e(u($row_invoice[4])); ?>" target="popup" 
                    onclick="window.open('vipbill_del.php?no=<?php echo e(u($row_invoice[4])); ?>','popup','width=1000,height=800'); return false;">Delete</a></td>
                    <?php } else { ?>
					Print<td width="2%"></td>
                    <?php }?>
                  </tr>
  <?php 
$nomor = num($nomor)+1;}} 

 ?>
                <tfoot>
                </tfoot>
                
              </table>	
    </div>
    <div class="col-md-2">
    	<div class="form-group">
    		<label>Outstanding :</label>
    	    <input type="text" ang="en-150" class="form-control"  placeholder="Enter ..." name="outstanding" 
                 	      value="<?php echo number_format(num($outstanding),0,".",".") ?>" readonly>
    	</div>
	</div>
</div>
		</div>
		<div class="box box-warning">
		  <div class="box-body">
		    <div class="col-md-4">
		      <div class="form-group">
		        <label>Type of Payment</label>
		        <select name="type_pay" id="program_clasifie4" class="form-control"   onChange="this.form.submit()" >
		          <option value= "Registration">Registration</option>
		          <option value= "Material">Material</option>		          
		          <option value= "Full Payment">Full Payment</option>		          		          
		          <option value= "Down Payment">Down Payment</option>
		          <option value= "Installment 1">Installment 1</option>
		          <option value= "Installment 2">Installment 2</option>
		          <option value= "Installment 3">Installment 3</option>
		          <option selected="selected"><?php  echo e($type_pay)    ?></option>
	            </select>
	          </div>
	        </div>
		    <div class="col-md-6">
		      <div class="form-group">
		        <label>Amount</label><input type="text" name="amount"  class="form-control" value = "<?php echo e($amount)  ?>"/>
	          </div>
	        </div>
	    		    <div class="col-md-6">
		      <div class="form-group">
		        <label>SC Name</label>
		        <select class="form-control" name="sc">
	          <option>Event</option>
		          <?php
	$query_sc = q_set($__p_query_sc, "SELECT distinct nama_detail from ves_data.tb_user where  (posisi = 'CM' or posisi = 'SC' or posisi = 'AC' or posisi = 'Admission') and kd_branch = ? and nama_detail is not null and aktif = 'Y'  order by nama_detail ", [(string) ($kdcbg)]);
$resource_sc = db_query_or_die('errro_0', $query_sc, $__p_query_sc ?? []);
$keluar_sc= db_num_rows($resource_sc);
if(num(db_num_rows($resource_sc)) > 0)
	{
	while ($row_sc=  db_fetch($resource_sc, PDO::FETCH_NUM))
		{
		echo '<option value="'.e($row_sc[0]).'">'.e($row_sc[0]).'</option>';		

		}
	}
     ?>
		          <option selected><?php echo  e($sc) ?></option>
	            </select>
		      </div>
	        </div>    
		    <div class="row"></div>

	      </div>
	  </div>
		<div class="box box-warning">
		  <div class="box-body">
		    <div class="row">
		      <div class="col-md-2">
		        <div class="form-group">
		          <label></label>
		          <input name="Save" type="submit" id="Save"  class="form-control"  value="Save" />
	            </div>
	          </div>
	          	        <div class="col-md-2">
	          <div class="form-group">
	       
	           <input name="Print" type="submit" id="Print"  class="form-control"  value="Print" />
              </div>
            </div></a>
            
		    
		    <div class="col-md-2">
		      <div class="form-group">
	        <a href="profile_newvip.php?kdb=<?php echo e(u($kdb)) ?>" onClick="window.open('profile_newvip.php?kdb=<?php echo e(u($kdb)) ?>')"> 
		        <input name="Save2" type="submit" id="Save3"  class="form-control"  value="Exit" /></a>
		        </div>
		      </div>
		    </div>

		  </div>
	  </div>
  </div>
<div class="box-body"></div>
<div class="box-body"></div>
</form>
</body>
</html>
<?php 
if (($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['Save']))) 
	{
	$saat_ini = date('Y-m-d H:i:s');
		
	$bisa = 1;	$branch = $_SESSION['branch'];	$kdb = in_val('kdb', 'any');$kdcbg = $_SESSION['kd_branch'];	$idb = in_val('idb', 'any');		
		
	$hari=date("d");$bulan=date("m");$tahun=date("Y");
	$hari_ini = "$tahun-$bulan-$hari";			
		
	if($bulan =='01'){$bln_rom="I";}if($bulan =='02'){$bln_rom="II";}	if($bulan =='03'){$bln_rom="III";}	if($bulan =='04'){$bln_rom="IV";}
	if($bulan =='05'){$bln_rom="V";}	if($bulan =='06'){$bln_rom="VI";}	if($bulan =='07'){$bln_rom="VII";}	if($bulan =='08'){$bln_rom="VIII";}
	if($bulan =='09'){$bln_rom="IX";}	if($bulan =='10'){$bln_rom="X";}	if($bulan =='11'){$bln_rom="XI";}	if($bulan =='12'){$bln_rom="XII";}
	$nik = in_val('nik', 'any');
	$kode_program = in_val('kode_program', 'any');	$nm_program = in_val('nm_program', 'any');	$nm_level = in_val('nm_level', 'any');	$material_book = in_val('material_book', 'any');$material_fee = in_val('material_fee', 'any');
	$nm_promo = in_val('nm_promo', 'any');	$old_student = in_val('old_student', 'any');$reg_fee = in_val('reg_fee', 'any');	$sc = in_val('sc', 'any');	$book_title = in_val('book_title', 'any');	$book_title = in_val('book_title', 'any');
	if ($type_class ==''){$bisa = 0;$pesan ="type class must be filled";}
	if ($kode_program ==''){$bisa = 0;$pesan ="wrong program/level";}		
	if ($nm_program ==''){$bisa = 0;$pesan ="program must be filled";}
	if ($nm_level ==''){$bisa = 0;$pesan ="level must be filled";}if ($material_book ==''){$bisa = 0;$pesan ="material book must be filled";}
	if ($nm_promo ==''){$bisa = 0;$pesan ="promo must be filled";}if ($old_student ==''){$bisa = 0;$pesan ="old or new student must be choosen";}	
	$type_pay = in_val('type_pay', 'any');//if ($type_pay ==''){$bisa = 0;$pesan ="Type of Payment must be choosen";}		
	if ($sc ==''){$bisa = 0;$pesan ="Consultant Name must be choosen";}
	if ($book_title ==''){$bisa = 0;$pesan ="Book Title must be choosen";}
		
	$tf = in_val('tf', 'any');	$voucher = in_val('voucher', 'any');$discount_tf = in_val('discount_tf', 'any');$tf_nett = in_val('tf_nett', 'any');	
	$nama_lengkap = $_SESSION['nama_lengkap']; 	$amount = in_val('amount', 'any'); 	$private_pax = in_val('private_pax', 'any');$private_hours = in_val('private_hours', 'any');
	//if ($amount == 0 ){$bisa = 0;$pesan ="Amount must be not zero";}
	if(num($bisa) == 1)
		{
		if ($idb !='')
			{
			$query_check_billing = q_set($__p_query_check_billing, "SELECT jns_payment FROM ves_data.vip_billing_payment where  jns_payment = ? and kd_billing = ? ", [(string) ($type_pay), (string) ($idb)]);
			$resource_check_billing = db_query_or_die('errro_last_billing', $query_check_billing, $__p_query_check_billing ?? []);
			if(num(db_num_rows($resource_check_billing)) > 0)
				{
				$st = 1;
				echo "<script type=\"text/javascript\">\n";
				echo "alert('Same Payment Type Already Submited');\n";			
				echo "</script>";
					die;
				}
			else
				{
			
				$query_update_billing= q_set($__p_query_update_billing, "update ves_data.vip_billing set kd_program = ? ,tf = ? ,discount= ? ,net_tf= ? ,pic= ? ,sc= ? ,material= ? ,old_student= ? ,voucher= ? ,material_cost= ? ,reg_fee= ? ,promo_persen = ? ,level_program = ? ,private_pax = ? ,\r
private_hours  = ? ,book_title = ? where  kd_biodata = ? and kd_billing = ? ", [(string) ($kode_program), (string) ($tf), (string) ($nm_promo), (string) ($tf_nett), (string) ($nama_lengkap), (string) ($sc), (string) ($material_book), (string) ($old_student), (string) ($voucher), (string) ($material_fee), (string) ($reg_fee), (string) ($discount_tf), (string) ($nm_level), (string) ($private_pax), (string) ($private_hours), (string) ($book_title), (string) ($kdb), (string) ($idb)]); 
				$resource_update_billing = db_query_or_die('errro_simpan', $query_update_billing, $__p_query_update_billing ?? []);
				$query_simpan_payment= q_set($__p_query_simpan_payment, "insert into ves_data.vip_billing_payment (kd_billing, kd_biodata, kd_branch, jns_payment, amount, dt_entry, pic, status) \r
\t\t\t\tvalues \r
\t\t\t\t(? ,? ,? ,? ,? ,? ,? ,'unpaid')", [(string) ($idb), (string) ($kdb), (string) ($kdcbg), (string) ($type_pay), (string) ($amount), (string) ($tgl_hari_ini), (string) ($nama_lengkap)]);
				$resource_simpan_payment = db_query_or_die('errro_simpan', $query_simpan_payment, $__p_query_simpan_payment ?? []);	
				$st = 1;
//==mulai buat kode unik					
				$query_last_id = q_set($__p_query_last_id, "SELECT no FROM vip_billing_payment where kd_billing = ? and kd_biodata = ? and  kd_branch = ? and  jns_payment = ? and  amount = ? and  dt_entry = ? and  pic = ? and  status = 'unpaid'", [(string) ($idb), (string) ($kdb), (string) ($kdcbg), (string) ($type_pay), (string) ($amount), (string) ($tgl_hari_ini), (string) ($nama_lengkap)]);

				$resource_last_id = db_query_or_die('errro_7', $query_last_id, $__p_query_last_id ?? []);
				while ($row_last_id=  db_fetch($resource_last_id, PDO::FETCH_NUM))
					{
					$id_transaksi =$row_last_id[0]; 
					}
				$x = 0;
				while(num($x) <= 100)
				{
				$kd_unik= rand(5,100);
				$query_unik = q_set($__p_query_unik, "select kd_unik from ves_data.tb_banking WHERE kd_unik= ?  and status = 0", [(string) ($kd_unik)]);
				$resource_unik = db_query_or_die('errro_last_billing', $query_unik, $__p_query_unik ?? []);
				if(num(db_num_rows($resource_unik)) == 0)
					{
					$query_insert_kd = q_set($__p_query_insert_kd, "insert into ves_data.tb_banking (jns_transaksi, id_transaksi, kd_unik, status, dt_entry,nominal ) values (1,? ,? ,'0',? ,? )", [(string) ($id_transaksi), (string) ($kd_unik), (string) ($saat_ini), (string) ($amount)]);
					$resource = db_query_or_die('errro_simpan1', $query_insert_kd, $__p_query_insert_kd ?? []);
					$akhir_id = db_insert_id();
					break;	
					}
					$x++;
				}					
//==selesai buat kode unik					
					
				}
			
			}
		else
			{
			//====membuat id billling
			$query_last_billing = q_set($__p_query_last_billing, "SELECT kd_billing FROM ves_data.vip_billing where  kd_branch = ? order by no desc limit 1", [(string) ($kdcbg)]);
			$resource_last_billing = db_query_or_die('errro_last_billing', $query_last_billing, $__p_query_last_billing ?? []);
			if(num(db_num_rows($resource_last_billing)) > 0)
				{
				while ($row_last_billing=  db_fetch($resource_last_billing, PDO::FETCH_NUM))
					{
					$kd_billing = $row_last_billing[0];
					$ambilangka =  substr($kd_billing,0,-4);
					#ketemu angka awal(angka sebelumnya) + dengan 1
					$nextangka=num($ambilangka)+1;
					#menhitung jumlah karakter
					$digit=strlen($nextangka);
					if(!$kd_billing){ $nol='000'; }elseif(num($digit)==1){ $nol='000'; }	elseif(num($digit)==2){ $nol='00'; }	elseif(num($digit)==3)
					{ $nol='0'; }	
					$nomor_baru = $nol.$nextangka."/VIP/0".$kdcbg."/".$bln_rom."-".$tahun;	
					}
				}
			else
				{
				$nomor_baru =  "0001/VIP/0".$kdcbg."/".$tahun;
				}
			$idb = $nomor_baru;
			$query_simpan_billing= q_set($__p_query_simpan_billing, "insert into ves_data.vip_billing (kd_billing,kd_branch,kd_biodata,kd_program,tf,discount,net_tf,dt_entry,pic,sc,material,old_student,voucher,material_cost,reg_fee,promo_persen,level_program,private_pax,private_hours) \r
\t\t\tvalues (? ,? ,? ,? ,? ,? ,? ,? ,? ,? ,? ,? ,? ,? ,? ,? ,? ,? ,? )", [(string) ($idb), (string) ($kdcbg), (string) ($kdb), (string) ($kode_program), (string) ($tf), (string) ($nm_promo), (string) ($tf_nett), (string) ($tgl_hari_ini), (string) ($nama_lengkap), (string) ($sc), (string) ($material_book), (string) ($old_student), (string) ($voucher), (string) ($material_fee), (string) ($reg_fee), (string) ($discount_tf), (string) ($nm_level), (string) ($private_pax), (string) ($private_hours)]);
			$resource_simpan_billing = db_query_or_die('errro_simpan', $query_simpan_billing, $__p_query_simpan_billing ?? []);
			$query_cek_student_data = q_set($__p_query_cek_student_data, "select kd_biodata from ves_data.vip_student_data where kd_biodata = ? and kd_branch = ? ", [(string) ($kdb), (string) ($kdcbg)]);
			$resource_cek_student_data = db_query_or_die('errro_last_billing', $query_cek_student_data, $__p_query_cek_student_data ?? []);
			if(num(db_num_rows($resource_cek_student_data)) == 0)
				{
				$length = 6;    
				$kodekey =  substr(str_shuffle('0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ'),1,$length);
				$query_key = q_set($__p_query_key, "SELECT idkey FROM ves_data.vip_student_data where idkey = ? ", [(string) ($kodekey)]);
				$resource_key= db_query_or_die('errro_visitor1', $query_key, $__p_query_key ?? []);
				if(num(db_num_rows($resource_key)) > 0)
					{
					return $kodekey;
					}
				else
					{
					$query_vip_nama = q_set($__p_query_vip_nama, "insert into  ves_data.vip_student_data (kd_branch, nama_lengkap, kd_biodata,idkey)values (? ,? ,? ,? )", [(string) ($kdcbg), (string) ($student_name), (string) ($kdb), (string) ($kodekey)]);
					$resource_vip_nama = db_query_or_die('errro_simpan', $query_vip_nama, $__p_query_vip_nama ?? []);						
					}					
				}
			
				
			if ($material_fee != 'No')
				{
				$query_simpan_payment= q_set($__p_query_simpan_payment, "insert into ves_data.vip_billing_payment (kd_billing, kd_biodata, kd_branch, jns_payment, amount, dt_entry, pic, status) \r
\t\t\t\tvalues \r
\t\t\t\t(? ,? ,? ,'Material',? ,? ,? ,'unpaid')", [(string) ($idb), (string) ($kdb), (string) ($kdcbg), (string) ($material_fee), (string) ($tgl_hari_ini), (string) ($nama_lengkap)]);
				$resource_simpan_payment = db_query_or_die('errro_simpan', $query_simpan_payment, $__p_query_simpan_payment ?? []);	
				$st = 1;
//==mulai buat kode unik					
				$query_last_id = q_set($__p_query_last_id, "SELECT no FROM vip_billing_payment where kd_billing = ? and kd_biodata = ? and  kd_branch = ? and  jns_payment = 'Material' and  amount = ? and  dt_entry = ? and  pic = ? and  status = 'unpaid'", [(string) ($idb), (string) ($kdb), (string) ($kdcbg), (string) ($material_fee), (string) ($tgl_hari_ini), (string) ($nama_lengkap)]);

				$resource_last_id = db_query_or_die('errro_7', $query_last_id, $__p_query_last_id ?? []);
				while ($row_last_id=  db_fetch($resource_last_id, PDO::FETCH_NUM))
					{
					$id_transaksi =$row_last_id[0]; 
					}
				$x = 0;
				while(num($x) <= 100)
				{
				$kd_unik= rand(5,100);
				$query_unik = q_set($__p_query_unik, "select kd_unik from ves_data.tb_banking WHERE kd_unik= ?  and status = 0", [(string) ($kd_unik)]);
				$resource_unik = db_query_or_die('errro_last_billing', $query_unik, $__p_query_unik ?? []);
				if(num(db_num_rows($resource_unik)) == 0)
					{
					$query_insert_kd = q_set($__p_query_insert_kd, "insert into ves_data.tb_banking (jns_transaksi, id_transaksi, kd_unik, status, dt_entry,nominal ) values (1,? ,? ,'0',? ,? )", [(string) ($id_transaksi), (string) ($kd_unik), (string) ($saat_ini), (string) ($amount)]);
					$resource = db_query_or_die('errro_simpan1', $query_insert_kd, $__p_query_insert_kd ?? []);
					$akhir_id = db_insert_id();
					break;	
					}
					$x++;
				}					
//==selesai buat kode unik							
				}
			if ($old_student == 'No')
				{
				$query_simpan_payment= q_set($__p_query_simpan_payment, "insert into ves_data.vip_billing_payment (kd_billing, kd_biodata, kd_branch, jns_payment, amount, dt_entry, pic, status) \r
\t\t\t\tvalues \r
\t\t\t\t(? ,? ,? ,'Registration',? ,? ,? ,'unpaid')", [(string) ($idb), (string) ($kdb), (string) ($kdcbg), (string) ($reg_fee), (string) ($tgl_hari_ini), (string) ($nama_lengkap)]);
				$resource_simpan_payment = db_query_or_die('errro_simpan', $query_simpan_payment, $__p_query_simpan_payment ?? []);	
				$st = 1;
//==mulai buat kode unik					
				$query_last_id = q_set($__p_query_last_id, "SELECT no FROM vip_billing_payment where kd_billing = ? and kd_biodata = ? and  kd_branch = ? and  jns_payment = 'Registration' and  amount = ? and  dt_entry = ? and  pic = ? and  status = 'unpaid'", [(string) ($idb), (string) ($kdb), (string) ($kdcbg), (string) ($reg_fee), (string) ($tgl_hari_ini), (string) ($nama_lengkap)]);

				$resource_last_id = db_query_or_die('errro_7', $query_last_id, $__p_query_last_id ?? []);
				while ($row_last_id=  db_fetch($resource_last_id, PDO::FETCH_NUM))
					{
					$id_transaksi =$row_last_id[0]; 
					}
				$x = 0;
				while(num($x) <= 100)
				{
				$kd_unik= rand(5,100);
				$query_unik = q_set($__p_query_unik, "select kd_unik from ves_data.tb_banking WHERE kd_unik= ?  and status = 0", [(string) ($kd_unik)]);
				$resource_unik = db_query_or_die('errro_last_billing', $query_unik, $__p_query_unik ?? []);
				if(num(db_num_rows($resource_unik)) == 0)
					{
					$query_insert_kd = q_set($__p_query_insert_kd, "insert into ves_data.tb_banking (jns_transaksi, id_transaksi, kd_unik, status, dt_entry,nominal ) values (1,? ,? ,'0',? ,? )", [(string) ($id_transaksi), (string) ($kd_unik), (string) ($saat_ini), (string) ($amount)]);
					$resource = db_query_or_die('errro_simpan1', $query_insert_kd, $__p_query_insert_kd ?? []);
					$akhir_id = db_insert_id();
					break;	
					}
					$x++;
				}					
//==selesai buat kode unik						
				}	
			if (num($amount) !=0 and $type_pay != '')
				{
				$query_simpan_payment= q_set($__p_query_simpan_payment, "insert into ves_data.vip_billing_payment (kd_billing, kd_biodata, kd_branch, jns_payment, amount, dt_entry, pic, status) \r
\t\t\t\tvalues \r
\t\t\t\t(? ,? ,? ,? ,? ,? ,? ,'unpaid')", [(string) ($idb), (string) ($kdb), (string) ($kdcbg), (string) ($type_pay), (string) ($amount), (string) ($tgl_hari_ini), (string) ($nama_lengkap)]);
				$resource_simpan_payment = db_query_or_die('errro_simpan', $query_simpan_payment, $__p_query_simpan_payment ?? []);	
				$st = 1;
//==mulai buat kode unik					
				$query_last_id = q_set($__p_query_last_id, "SELECT no FROM vip_billing_payment where kd_billing = ? and kd_biodata = ? and  kd_branch = ? and  jns_payment = ? and  amount = ? and  dt_entry = ? and  pic = ? and  status = 'unpaid'", [(string) ($idb), (string) ($kdb), (string) ($kdcbg), (string) ($type_pay), (string) ($amount), (string) ($tgl_hari_ini), (string) ($nama_lengkap)]);

				$resource_last_id = db_query_or_die('errro_7', $query_last_id, $__p_query_last_id ?? []);
				while ($row_last_id=  db_fetch($resource_last_id, PDO::FETCH_NUM))
					{
					$id_transaksi =$row_last_id[0]; 
					}
				$x = 0;
				while(num($x) <= 100)
				{
				$kd_unik= rand(5,100);
				$query_unik = q_set($__p_query_unik, "select kd_unik from ves_data.tb_banking WHERE kd_unik= ?  and status = 0", [(string) ($kd_unik)]);
				$resource_unik = db_query_or_die('errro_last_billing', $query_unik, $__p_query_unik ?? []);
				if(num(db_num_rows($resource_unik)) == 0)
					{
					$query_insert_kd = q_set($__p_query_insert_kd, "insert into ves_data.tb_banking (jns_transaksi, id_transaksi, kd_unik, status, dt_entry,nominal ) values (1,? ,? ,'0',? ,? )", [(string) ($id_transaksi), (string) ($kd_unik), (string) ($saat_ini), (string) ($amount)]);
					$resource = db_query_or_die('errro_simpan1', $query_insert_kd, $__p_query_insert_kd ?? []);
					$akhir_id = db_insert_id();
					break;	
					}
					$x++;
				}					
//==selesai buat kode unik							
				}							
			}	
$query_nik = q_set($__p_query_nik, "SELECT nik FROM ves_data.tb_nik  where kd_biodata = ? ", [(string) ($kdb)]);	
	$resource_nik = db_query_soft($query_nik, $__p_query_nik ?? []);
	$keluar_nik = db_num_rows($resource_nik);
	if(num(db_num_rows($resource_nik)) > 0)
		{
		while ($row_nik  =  db_fetch($resource_nik, PDO::FETCH_NUM))
			{
			$update_nik = q_set($__p_update_nik, "update ves_data.tb_nik set nik = ? where kd_biodata = ? ", [(string) ($nik), (string) ($kdb)]);
			$resource_update_nik = db_query_or_die('errro_simpan_11', $update_nik, $__p_update_nik ?? []);			
			}
		}	
	else
		{
			$update_nik = q_set($__p_update_nik, "insert into ves_data.tb_nik (nik,kd_biodata) values (? ,? )", [(string) ($nik), (string) ($kdb)]);
			$resource_update_nik = db_query_or_die('errro_simpan_12', $update_nik, $__p_update_nik ?? []);			
		
		}
	
		
		echo "<script type=\"text/javascript\">\n";
		echo "alert('VIP Billing Submitted');\n";
		echo "window.location = ('vipbill.php?idb=" . e(u($idb)) . "&kdb=" . e(u($kdb)) . "&st=" . e(u($st)) . "');\n";				
		echo "</script>";
		}
	else
		{
		echo "<script type=\"text/javascript\">\n";
		echo "alert('" . e($pesan) . "');\n";
		echo "</script>";
		}
	}
if (($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['Print']))) 
	{
	if ($idb !='')
		{

			echo "<script type=\"text/javascript\">\n";
			echo "window.open('vipbillprint.php?idb=" . e(u($idb)) . "&kdb=" . e(u($kdb)) . "','width=560,height=340,toolbar=0,menubar=0,location=0');\n";				
			echo "</script>";		

		}
	}
?>