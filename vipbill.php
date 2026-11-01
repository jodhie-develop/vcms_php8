<?php
include __DIR__ . "/conndb.php";
include __DIR__ . "/profiledata.php";
// Form dikirim POST + token CSRF (dulu GET, termasuk tombol Save yang menulis billing);
// link dari halaman lain tetap GET karena in_*() membaca POST lalu GET.
// Kolom harga per cabang memakai kol_harga() dari _lib/app.php.
// Variabel yang di versi lama bisa dipakai sebelum diisi (PHP 5: kosong).
$kode_program = $discount_tf = $discount_rf = $discount_cashback = $dp_ins = $ttl_invoiced = '';
$harga_private = $book_status = $enroll_date = $student_name = $address = $city = '';
$reg_fee_net = $totalinvoice = $outstanding = $tf_nett = $pesan = '';
$nomor = null;
$nol = '';
include __DIR__ . "/atas.php";
include __DIR__ . "/left.php";

$nama_lengkap = $_SESSION['nama_lengkap']; 
$kdcbg = $_SESSION['kd_branch']; 
$kdb = in_str('kdb', 45);
$st = in_str('st', 3);
$hari=date("d");
$bulan=date("m");
$bulanan=date("M");
$private_hours = in_str('private_hours', 10);
$type_class = in_str('type_class', 45);
$nm_program = in_str('nm_program', 100);
$nm_level = in_str('nm_level', 100);
$material_fee = in_str('material_fee', 20);
$reg_fee = in_str('reg_fee', 20);
$ca_event_fee = in_str('ca_event_fee', 20);
$sc = in_str('sc', 100);
$material_book = in_str('material_book', 45);
if ($material_book =='') {$material_book ='No';}
$book_title = in_str('book_title', 100);
if ($book_title =='') {$book_title ='No Book';}
$nik = in_str('nik', 45);

if ($nik == '')
{
$query_nik = "SELECT nik FROM ves_data.tb_nik  where kd_biodata = ?";	
$resource_nik = db_query($query_nik, [$kdb]);
$keluar_nik = $resource_nik->rowCount();
if($resource_nik->rowCount() > 0)
	{
	while ($row_nik  =  $resource_nik->fetch(PDO::FETCH_NUM))
		{
		$nik = $row_nik[0];
		}
	}
}

$idb = in_str('idb', 45);
if ($type_class != 'WORKSHOPS')
	{
	if($nm_program !="" and $nm_level !="")
		{
		$query_kode_program = "SELECT kd_program FROM ves_data.vip_mst_code_prg where nm_program = ? and level_program = ? and type_program = ? and aktif = 1";			
		$resource_kode_program = db_query($query_kode_program, [$nm_program, $nm_level, $type_class]);
		while ($row_kode_program=  $resource_kode_program->fetch(PDO::FETCH_NUM))
			{
			$kode_program =   $row_kode_program[0];
			}   
		}		
	}
else
	{
	$nm_level = '';
	$query_kode_program = "SELECT kd_program FROM ves_data.vip_mst_code_prg where nm_program = ? and type_program = ?  and aktif = 1";			
	$resource_kode_program = db_query($query_kode_program, [$nm_program, $type_class]);
	while ($row_kode_program=  $resource_kode_program->fetch(PDO::FETCH_NUM))
		{
		$kode_program =   $row_kode_program[0];
		}   
	}		

//==get price
$tf = '0';
$query_price = "SELECT " . kol_harga($kdcbg) . " FROM ves_data.vip_mst_price where kd_program = ? and level_program = ?";
$resource_price = db_query($query_price, [$kode_program, $nm_level]);
while ($row_price=  $resource_price->fetch(PDO::FETCH_NUM))
	{
	$tf =   $row_price[0];
	} 

$private_pax = in_str('private_pax', 10);
$nm_promo = in_str('nm_promo', 100);
if($nm_promo !='')
	{
	$query_promo = "SELECT tf, rf, cashback FROM ves_data.vip_mst_promo where nm_promo = ? and (kd_branch = ? or kd_branch = '0')";
	$resource_promo = db_query($query_promo, [$nm_promo, $kdcbg]);
	while ($row_promo=  $resource_promo->fetch(PDO::FETCH_NUM))
		{
		$discount_tf =   $row_promo[0];
		$discount_rf =   $row_promo[1];
		$discount_cashback =   $row_promo[2];
		}		
	}

$voucher = in_str('voucher', 20);
//=====
$tahun=date("Y");
$tgl_hari_ini =  "$tahun-$bulan-$hari";
//get data stu
$query_student = "SELECT t.kd_biodata, t.nama, t.middle_name, t.family_name, t.address, t.city FROM ves_inc.tb_biodata t where t.kd_biodata = ?";
$resource_student= db_query($query_student, [$kdb]);
$keluar_student= $resource_student->rowCount();
if($resource_student->rowCount() > 0)
	{
	while ($row_student=  $resource_student->fetch(PDO::FETCH_NUM))
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

if (num($tf) != 0)
{
if($tf !="")
	{
	$tf_nett = num($tf) - num($voucher);	
	$tf_nett = num($tf_nett) - (num($tf_nett) * (num($discount_tf)/100));	

	}
if($tf_nett =='') {$tf_nett = in_str('tf_nett', 20);}
}
else
{
$tf_nett = '0';	
}
//==========setting cara bayar
$type_pay = in_str('type_pay', 45);
$old_student = in_str('old_student', 10);

if($type_pay =='Registration' and $old_student !='Yes')
	{
	if ($nama_lengkap =='Debora Mboeik')
	{	$query_payment = "SELECT fa FROM ves_data.vip_mst_price where kd_program = ?";}
	else
	{
	$query_payment = "SELECT " . kol_harga($kdcbg) . " FROM ves_data.vip_mst_price where kd_program = ?";
	}
		$resource_payment = db_query($query_payment, [$type_pay]);
	while ($row_payment=  $resource_payment->fetch(PDO::FETCH_NUM))
		{

		$reg_fee = 	  $row_payment[0];	
		//if ($nm_program == 'CA'){$reg_fee == '200000';}
		}
	if($nama_lengkap =='Debora Mboeik'){$reg_fee ='300000';}
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
	$query_dp_ins = "SELECT sum(amount)  FROM ves_data.vip_billing_payment where  (jns_payment = 'Down Payment' or jns_payment like 'Installment%') and kd_billing = ?"; 
	$resource_dp_ins = db_query($query_dp_ins, [$idb]);
	while ($row_dp_ins=  $resource_dp_ins->fetch(PDO::FETCH_NUM))
		{
		$dp_ins =   $row_dp_ins[0];	
		}
	$amount = num($tf_nett) - num($dp_ins);		
	}
else
	{
	$amount='0';	
	}

$book_title = in_str('book_title', 100);
$old_student = in_str('old_student', 10);
if($st==1)
	{	
	$query_ambil_billing = "SELECT
	b.type_program, b.nm_program, b.level_program, a.kd_program,
	a.material, a.tf, a.voucher, a.discount,a.old_student , a.net_tf,a.kd_billing,a.material_cost,a.old_student,a.kd_biodata,a.sc,a.private_pax, a.private_hours,reg_fee,book_title,book_status	  FROM ves_data.vip_billing a
	left join ves_data.vip_mst_code_prg b on a.kd_program = b.kd_program and a.level_program = b.level_program  where a.kd_billing = ? ";

	$resource_ambil_billing = db_query($query_ambil_billing, [$idb]);
	while ($row_ambil_billing=  $resource_ambil_billing->fetch(PDO::FETCH_NUM))
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
	$query_promo = "SELECT tf, rf, cashback FROM ves_data.vip_mst_promo where nm_promo = ? and  (kd_branch = ? or kd_branch = '0')";
	$resource_promo = db_query($query_promo, [$nm_promo, $kdcbg]);
	while ($row_promo=  $resource_promo->fetch(PDO::FETCH_NUM))
		{
		$discount_tf =   $row_promo[0];
		$discount_rf =   $row_promo[1];
		$discount_cashback =   $row_promo[2];
		}		
	}



if ($material_book !='No')
	{
	$query_material = "SELECT " . kol_harga($kdcbg) . " FROM ves_data.vip_mst_price where kd_program = ?";
	$resource_material = db_query($query_material, [$material_book]);
	while ($row_material=  $resource_material->fetch(PDO::FETCH_NUM))
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
	$query_registration = "SELECT " . kol_harga($kdcbg) . " FROM ves_data.vip_mst_price where kd_program = 'Registration'";
	$resource_registration = db_query($query_registration);
	while ($row_registration=  $resource_registration->fetch(PDO::FETCH_NUM))
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
$query_invoiced = "SELECT  sum(amount) as ttl FROM ves_data.vip_billing_payment where kd_billing  = ? group by kd_billing";
$resource_invoiced = db_query($query_invoiced, [$idb]);
while ($row_invoiced=  $resource_invoiced->fetch(PDO::FETCH_NUM))
	{
	$ttl_invoiced = $row_invoiced[0];	
	}


//================
if($type_class == 'PRI')
{
//==== harga private
	if($kode_program =='FLSC')
		{
		if ($nm_level =='Preparation' and $private_pax == '1' and $private_hours =='12'){$tf = '8800000';}
		elseif ($nm_level =='Portofolio builder ' and $private_pax == 1 and $private_hours ==12){$tf = '8800000';}

		}
elseif ($kdcbg =='1' or $kdcbg=='2' or $kdcbg=='4' or $kdcbg=='5' or $kdcbg=='6')
	{
	if ($kode_program=='PFIEP' and  $private_hours =='15' and $private_pax == '1'){$tf = '9000000';}		
	elseif ($private_pax == '1'){$harga_private = '385000';}	
	elseif ($private_pax == '2'){$harga_private = '225000';}	
	elseif ($private_pax == '3'){$harga_private = '162500';}	
	elseif ($private_pax == '4'){$harga_private = '162500';}		
	elseif ($private_pax == '5'){$harga_private = '162500';}		
	

	}
elseif ($kdcbg == '8')
	{
	if ($private_pax == '1'){$harga_private = '500000';}	
	if ($private_pax == '2'){$harga_private = '7000000';}	
	if ($private_pax == '3'){$harga_private = '5000000';}	
	if ($private_pax == '4'){$harga_private = '5000000';}		
	}
else
	{
	if ($private_pax == '1' and $private_hours =='20'){$harga_private = '380000';}	
	elseif ($private_pax == '1' and $private_hours =='10'){$harga_private = '385000';}	
	
	if ($private_pax == '2'){$harga_private = '225000';}	
	if ($private_pax == '3'){$harga_private = '162500';}	
	if ($private_pax == '4'){$harga_private = '162500';}		
	if ($private_pax == '5'){$harga_private = '162500';}		
	
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


if ($kdcbg == '8' and $type_class =='PRI' and  	$private_pax == 1 and ($private_hours == 30 or $private_hours == 40  ) ){$tf = '10000000';}	
elseif ($kdcbg == '8' and $type_class =='PRI' and 	 $private_hours == 30 and $private_pax == 2 ){$tf = '4900000';}	
elseif ($kdcbg == '8' and $type_class =='PRI' and 	 $private_hours == 30 and $private_pax == 3  ){$tf = '3600000';}	
//====
elseif ($kdcbg <> '8' and $type_class =='PRI' and $nm_program <> 'ESP' and	$private_pax == 1 and $private_hours == 30 ){$tf = '13500000';}	
elseif ($kdcbg <> '8' and $type_class =='PRI'  and $nm_program <> 'ESP' and 	 ($private_hours == 30 or $private_hours == 20) and ($private_pax == 2 ) ){$tf = '8500000';}	
elseif ($type_class =='PRI'  and $kode_program == 'IIFP' and ($private_pax == 3 or $private_pax == 4   ) ){ $tf = '6300000';}		
elseif ($kdcbg <> '8' and $type_class =='PRI'  and $nm_program <> 'ESP' and 	 ($private_hours == 30 or $private_hours == 20) and ($private_pax == 3 ) ){$tf = '6500000';}	
	
	
//==sdp
if ($kdcbg <> '8' and $type_class =='PRI' and $nm_program == 'ESP' and	$private_pax == 1 and $private_hours == 20 ){$tf = '8500000';}	
if ($kdcbg <> '8' and $type_class =='PRI' and $nm_program == 'ESP' and	$private_pax == 1 and $private_hours == 10 ){$tf = '4500000';}	
if ($kdcbg == '1' and $type_class =='PRI' and $nm_program == 'TOEFL' and $kode_program== 'TPWAP' and	$private_hours == 12 ){$tf = '3120000';}
if ($type_class =='PRI'  and $nm_program == 'IIFP' and ($private_pax == 3 or $private_pax == 4   ) ){ $tf = '6300000';}	
if($type_class == 'PRI' and ($nm_program =='GE' or $nm_program =='AE' or $nm_program =='BE' or $nm_program =='CO' ))
{
if ($kdcbg =='1' or $kdcbg=='2' or $kdcbg=='4' or $kdcbg=='5' or $kdcbg=='6')
	{
	if ($private_pax == '1'){$harga_private = '375000';}	
	elseif ($private_pax == '2'){$harga_private = '225000';}	
	elseif ($private_pax == '3'){$harga_private = '162500';}	
	elseif ($private_pax == '4'){$harga_private = '162500';}	
	elseif ($private_pax == '5'){$harga_private = '162500';}		

	}
$tf = (num($harga_private) * num($private_hours));		
}
$tf = (num($harga_private) * num($private_hours));	
if($type_class == 'PRI' and ($nm_program =='GE' or $nm_program =='AE' or $nm_program =='BE' or $nm_program =='CO' ) and $kdcbg =='8')
{
if ($kdcbg =='1' or $kdcbg=='2' or $kdcbg=='4' or $kdcbg=='5' or $kdcbg=='6' )
	{
	if ($kode_program=='PFIEP' and  $private_hours =='15' and $private_pax == '1'){$tf = '9000000';}		
	elseif ($private_pax == '1'){$harga_private = '385000';}	
	elseif ($private_pax == '2'){$harga_private = '225000';}	
	elseif ($private_pax == '3'){$harga_private = '162500';}	
	elseif ($private_pax == '4'){$harga_private = '162500';}	
	elseif ($private_pax == '5'){$harga_private = '162500';}		

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
if ($kdcbg == '3' and $type_class =='PRI' and ($nm_program == 'ESP' or $nm_program == 'GE') and	$private_pax == 1 and $private_hours == 30 ){$tf = '13500000';}	
elseif ($kdcbg == '8' and $type_class =='PRI' and	$private_pax == 1 and $private_hours == 40 ){$tf = '9000000';}	
elseif ($kdcbg == '8' and $type_class =='PRI' and	$private_pax == 2 and $private_hours == 40 ){$tf = '7000000';}		
elseif ($kdcbg == '8' and $type_class =='PRI' and	$private_pax == 3 and $private_hours == 40 ){$tf = '5000000';}		
elseif ($kdcbg == '8' and $type_class =='PRI' and	$private_pax == 4 and $private_hours == 40 ){$tf = '5000000';}	
elseif ($kdcbg != '8' and $type_class =='PRI' and	$private_pax == 1 and $private_hours == 40 ){$tf = '15000000';}		
elseif ($kdcbg != '8' and $type_class =='PRI' and $kode_program=='IETTPP' and $private_pax == 1 and $private_hours == 30 ){$tf = '11700000';}
elseif ($kdcbg != '8' and $type_class =='PRI' and $kode_program=='IETTPP' and $private_pax == 1 and $private_hours == 20 ){$tf = '7700000';}
elseif ($kdcbg != '8' and $type_class =='PRI' and $kode_program=='IETTPP' and $private_pax == 1 and $private_hours == 10 ){$tf = '3900000';}
elseif ($type_class =='PRI' and $kode_program=='FTP' and $nm_level =='GRE' and $private_pax == 1 and $private_hours == 14 ){$tf = '6900000';}	
elseif ($type_class =='PRI' and $kode_program=='FTP' and $nm_level =='GRE' and $private_pax == 1 and $private_hours == 10 ){$tf = '5500000';}	
	
elseif ($type_class =='PRI' and $kode_program=='FTP' and $private_pax == 1 and $private_hours == 16 ){$tf = '5000000';}	
elseif ($type_class =='PRI' and $kode_program=='FTP' and $private_pax == 1 and $private_hours == 10 ){$tf = '4000000';}		
elseif ($type_class =='PRI' and $kode_program=='FTP' and $private_pax == 1 and $private_hours == 7.5 ){$tf = '3500000';}	
elseif ($type_class =='PRI' and $kode_program=='FTP' and $private_pax == 1 and $private_hours == 6 ){$tf = '3000000';}		
elseif ($kdcbg != '8' and $type_class =='PRI' and $kode_program=='FTP' and $private_pax == 1 and $private_hours == 20 and $nm_level == 'SAT' ){$tf = '10800000';}
elseif ($kdcbg != '8' and $type_class =='PRI' and $kode_program=='FTP' and $private_pax == 1 and $private_hours == 40 and $nm_level == 'SAT' ){$tf = '18800000';}
elseif ($kdcbg != '8' and $type_class =='PRI' and $kode_program=='FTP' and $private_pax == 2 and $private_hours == 20 and $nm_level == 'SAT' ){$tf = '12800000';}
	
elseif ($kdcbg != '8' and $type_class =='PRI' and $kode_program=='FTP' and $private_pax == 1 and $private_hours == 20){$tf = '8000000';}	
	
elseif ($kdcbg == '8' and $type_class =='PRI' and $kode_program=='FTP' and $private_pax == 1 and $private_hours == 10 ){$tf = '3850000';}
elseif ($kdcbg == '8' and $type_class =='PRI' and $kode_program=='FTP' and $private_pax == 1 and $private_hours == 20 ){$tf = '5800000';}	
elseif ($type_class =='PRI' and $kode_program=='FTP' and $private_pax == 3 and $private_hours == 15 ){$tf = '3500000';}		
elseif ($kdcbg == '8' and $type_class =='PRI' and $kode_program=='FDST-AP' and $private_pax == 1 and $private_hours == 40 ){$tf = '10000000';}	

if ($kode_program=='VIPUV' and $private_pax == 1 and $private_hours == 4 ){$tf = '2000000';}		
if($type_class =='PRI')
	
	{	
	if($kode_program =='FLSC')
		{
		if ($nm_level =='Preparation' and $private_pax == 1 and $private_hours ==12){$tf == '8800000';}
		elseif ($nm_level =='Portofolio builder ' and $private_pax == 1 and $private_hours ==12){$tf == '8800000';}

		}
	elseif($kdcbg == 10)
		{
		if($private_pax == 4 and $private_hours == 40){$tf =6300000;}
		elseif($private_pax == 3 and $private_hours == 40){$tf =6300000;}
		elseif($private_pax == 2 and $private_hours == 40){$tf =9000000;}
		elseif($private_pax == 1 and $private_hours == 40){$tf =15000000;}			
		}	
elseif ($kdcbg == 14)	
	{
		if($private_pax == 1 and $private_hours == 46){$tf = 11500000;}
		elseif($private_pax == 2 and $private_hours == 44){$tf = 7000000;}
		elseif($private_pax >= 3 and $private_hours == 42){$tf = 5000000;}
	
		elseif($private_pax == 1 and $nm_level =='Check Point Regist' and num($private_hours) == 0){$tf =200000;}
		elseif($private_pax == 1 and $nm_level =='Check Point Regist' and num($private_hours) == 0){$tf =200000;}
		elseif($private_pax == 1 and $nm_level =='Check Point' and $private_hours == 8){$tf =600000;}	
	}
else		
		{
			 if ($nm_program=='SAT')
		 {
			 if($private_pax == 1 and $private_hours == 30 ){$tf = '18800000';}
			 elseif($private_pax == 1 and $private_hours == 10 ){$tf = '5000000';}
			 elseif($private_pax == 1 and $private_hours == 4 ){$tf = '2000000';}	
			 elseif($private_pax == 1 and $private_hours == 6 ){$tf = '3000000';}	
				 
		 }
		elseif ($kode_program =='CAP')
		{
		if($private_pax >= 1 and $private_pax <= 1  and $private_hours == 12){$tf =5700000;}
		elseif($private_pax >= 1 and $private_pax <= 1  and $private_hours == 18){$tf =8300000;}
			
		}
		elseif ($kode_program =='VIPCTP')
		{
		if($private_pax == 1 and $nm_level =='Check Point' and $private_hours == 8){$tf =600000;}
		elseif($private_pax == 1 and $nm_level =='Check Point Regist' and num($private_hours) == 0){$tf =200000;}
			
		}		
		elseif ($kode_program =='IETTPP')
		{
		if( $private_pax == 1  and $private_hours == 10){$tf =5000000;}
		elseif($private_pax >= 1 and $private_pax <= 1  and $private_hours == 18){$tf =8300000;}
		}
		elseif ($nm_program=='TITPP')
		 {
			 if($private_pax == 1 and $private_hours == 40 ){$tf = '15000000';}
			 elseif($private_pax == 1 and $private_hours == 10 ){$tf = '';}
			 elseif($private_pax == 1 and $private_hours == 4 ){$tf = '';}			 
		 }
//			elseif ($kode_program=='VIPSC1P' or $kode_program=='VIPSC2P' or $kode_program=='VIPSC3P' or $kode_program=='VIPSC4P'  ){	$tf = '5000000'; }
			elseif ($kode_program=='VIPSC1P' ){	$tf = '5800000'; }

					elseif ($kode_program=='VIPSC5P' and $private_pax ==3 and $private_hours == 15) {	$tf = '3500000'; }

				elseif ($kode_program=='VIPSC5P') {	$tf = '3500000'; }
			elseif ($kode_program=='CSMPP' and $private_pax == 1 and $private_hours == 39 ){$tf = '13800000';}		
			elseif ($kode_program=='CSMPP' and $private_pax == 1 and $private_hours == 21 ){$tf = '5800000';}		
			elseif ($kode_program=='CSMPP' and $private_pax == 2 and $private_hours == 21 ){$tf = '4500000';}		

		}
		if ($type_class =='PRI' and $kode_program=='LCT'  and $nm_level =='TOP UP 10H - add Service'){$tf = '4500000';}		
	
			elseif ($nm_program=='Young Achiever' and $private_hours =='23'){$tf = '15000000';}		

			elseif ($type_class =='PRI' and $kode_program=='CAWCP' and $nm_level == 'WSC' and $private_hours =='12'){$tf = '6000000';}		
			elseif ($type_class =='PRI' and $kode_program=='CAWCP' and $nm_level == 'WSC' and $private_hours =='18'){$tf = '8500000';}		
	
		elseif ($type_class =='PRI' and $kode_program=='VIPEP'){$tf = '7600000';}		
		elseif ($type_class =='PRI' and $kode_program=='IETOP'){$tf = '300000';}		
		elseif ($type_class =='PRI' and $kode_program=='IIFPadd'){$tf = '2500000';}		
		elseif ($type_class =='PRI' and $kode_program=='CUERP'){$tf = '3500000';}		
			elseif ($type_class =='PRI' and $kode_program=='TOTP' and $private_pax == '1' and $private_hours =='2'){$tf = '300000';}	
			elseif ($type_class =='PRI' and $kode_program=='TITO' ){$tf = '300000';}	
				elseif ($type_class =='PRI' and $kode_program=='FLSC' and $private_pax == '1' and $private_hours == '12' ){$tf = '8800000';}	
					elseif ($type_class =='PRI' and $kode_program=='ISP' and $private_pax == '3' and $private_hours == '20' ){$tf = '6500000';}	
		elseif ($kode_program=='SATP' and  $private_hours =='8' and $private_pax == '1'){$tf = '3720000';}	
		elseif ($kode_program=='SATP' and  $private_hours =='40' and $private_pax == '1'){$tf = '18800000';}		
	
		elseif ($kode_program=='PFIEP' and  $private_hours =='30' and $private_pax == '1'){$tf = '9000000';}	
if ($nm_program =='CA')
	{
	if ($kode_program=='CAPWP' and $nm_level =='WSC-PWAANATION' and $private_hours =='12'){$tf = '5700000';}	
	
	elseif ($kode_program=='CAPWP' and $nm_level =='WSC-PWAANATION' and $private_hours =='18'){$tf = '8300000';}
	elseif ($nm_level =='WSC-CCA BALI' and $private_hours =='12'){$tf = '1200000';}	

	elseif ($nm_level =='WSC' and $private_hours =='12'){$tf = '6000000';}	
	elseif ($nm_level =='WSC' and $private_hours =='18'){$tf = '8500000';}		
	elseif ($kode_program=='CAYNP' and $nm_level =='AYIMUN' and $private_hours =='12'){$tf = '5700000';}		
	elseif ($kode_program=='CAYNP' and $nm_level =='AYIMUN' and $private_hours =='18'){$tf = '8300000';}		
	elseif ($kode_program=='CADSP' and $nm_level =='DEBATS' and $private_hours =='12'){$tf = '5700000';}	
	elseif ($kode_program=='CADSP' and $nm_level =='DEBATS' and $private_hours =='18'){$tf = '8300000';}	
	elseif ($kode_program=='CAMDP' and $nm_level =='MUN - DIPLOMAT' and $private_hours=='12'){$tf = '5700000';}
	elseif ($nm_level =='MUN' and $private_hours=='12'){$tf = '6000000';}	
	elseif ($nm_level =='MUN' and $private_hours=='18'){$tf = '8500000';}	

	elseif ($kode_program=='CAMDP' and $nm_level =='MUN - DIPLOMAT' and $private_hours=='18'){$tf = '8300000';}
	elseif ($kode_program=='CAGCP'  and $private_hours=='6'){$tf = '2600000';}		
	elseif ($kode_program=='CAGCP'  and $private_hours=='12'){$tf = '5700000';}	
	elseif ($kode_program=='CAGCP'  and $private_hours=='18'){$tf = '8300000';}	
	elseif ($kode_program=='CAGRP'  and $private_hours=='6'){$tf = '2600000';}	
	elseif ($kode_program=='CAGRP'  and $private_hours=='7.5'){$tf = '3562500';}	
	
	elseif ($kode_program=='CAGRP'  and $private_hours=='12'){$tf = '6000000';}	
	elseif ($kode_program=='CAGRP'  and $private_hours=='18'){$tf = '8500000';}	
	
	elseif ($kode_program=='CAMP' and $nm_level =='MUN' and $private_hours =='15' and $private_pax == '2'){$tf = '4000000';}	
	elseif ($kode_program=='CAMP' and $nm_level =='MUN' and $private_hours =='4' and $private_pax =='1'){$tf = '2800000';}	
	elseif ($kode_program=='CAMP' and $nm_level =='MUN' and $private_hours =='6'){$tf = '2880000';}	
	elseif ($kode_program=='CAMP' and $nm_level =='MUN' and $private_hours =='18'){$tf = '8500000';}	
	elseif ($kode_program=='CAMP' and $nm_level =='MUN' and $private_hours =='12'){$tf = '6000000';}	
	elseif ($kode_program=='CAMP' and $nm_level =='MUN' and $private_hours =='3'){$tf = '1425000';}	
	
	
	elseif ($kode_program=='CAIBRFP' and  $private_hours =='2.5' and $private_pax == '1'){$tf = '1600000';}		
	elseif ($kode_program=='CAIBRFP' and  $private_hours =='18' and $private_pax == '1'){$tf = '8300000';}		
	elseif ($kode_program=='CAEvWSC'){$tf = '3500000';}		
	elseif ($kode_program=='CAWSCTOC' and $private_hours == '9'){$tf = '4500000';}		
	elseif ($kode_program=='CAWSCTOC' and $private_hours == '12'){$tf = '6000000';}		
	elseif ($kode_program=='CAWSCTOC' and $private_hours == '3'){$tf = '1500000';}			
	elseif ($kode_program=='CACSP' and $private_hours == '3' and $private_pax == '1'){$tf = '1500000';}		
	
	
	
	}
elseif ($nm_program =='Fellows Academy')
	{
	    if ($type_class == 'PRI' and $nm_level =='Stage 1: Foundation' and $private_pax =='1'){$tf = '8800000'; $kode_program = 'FA-1FP'; }	
	elseif ($type_class == 'PRI' and $nm_level =='Stage 1: Foundation' and ($private_pax =='2' or $private_pax =='3' or $private_hours =='4')){$tf = '5000000'; $kode_program = 'FA-1FSP'; }	
	elseif ($type_class == 'PRI' and $nm_level =='Stage 2: Application' and $private_pax =='1'){$tf = '8800000'; $kode_program = 'FA-2AP'; }	
	elseif ($type_class == 'PRI' and $nm_level =='Stage 2: Application' and ($private_pax =='2' or $private_pax =='3' or $private_hours =='4')){$tf = '5000000'; $kode_program = 'FA-2ASP'; }	
	elseif ($type_class == 'PRI' and $nm_level =='Stage 2: Fast Track' and $private_pax =='1'){$tf = '5000000'; $kode_program = 'FA-2FTP'; }	
	elseif ($type_class == 'PRI' and $nm_level =='Stage 2: Fast Track' and ($private_pax =='2' or $private_pax =='3' or $private_pax =='4')){$tf = '5000000'; $kode_program = 'FA-2FTSP'; }	
	
	}
$tf_nett = num($tf) -  (num($tf) * (num($discount_tf)/100)) - num($voucher);
	}
	
$tf_nett = num($tf) -  (num($tf) * (num($discount_tf)/100)) - num($voucher);
	
}
if ($kd_cbg ==7)
	{if(($private_pax ==3 or $private_pax ==4 or $private_pax ==5) and $private_hours == 30) {$tf = '5400000';}}
//$tf_nett = ($tf - $voucher)-  (($tf - $voucher) * ($discount_tf/100));
$tf_nett = num($tf) -  (num($tf) * (num($discount_tf)/100)) - num($discount_cashback) - num($voucher);
 	if($nama_lengkap =='Debora Mboeik')
	{
	$reg_fee ='300000';
}
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
      <input type="text" ang="en-150"   name="reg_fee" 
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
      <input name="address"  class="form-control"  type="text" size="90" value="<?php echo e($address . " " . $city) ?>" />
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
<?php if ($nama_lengkap =='Debora Mboeik'){?>
								        <option>FELLOWS ACADEMY</option>	
<?php } else {?>				
			        <option>REG</option>
			        <option>PRI</option>
			        <option>WORKSHOP</option>
				        <option>CLINIC</option>	
				        <option>EVENT</option>		
				        <option>VPRO</option>	
				        <option>CA CoT</option>	
				        <option>GLBRD</option>	
				        <option>FELLOWS ACADEMY</option>	
<?php }?>				
			        <option selected><?php echo e($type_class) ?></option>
            </select>
          </div>
	    </div>
  <div class="col-md-3">
    <div class="form-group">
      <label>Program</label>
      <select class="form-control" name="nm_program"  onChange="this.form.submit()">
        <?php
									$query_nm_program = "SELECT distinct nm_program FROM ves_data.vip_mst_code_prg WHERE type_program = ? and aktif = 1";
								$resource_nm_program = db_query($query_nm_program, [$type_class]);
								while ($row_nm_program=  $resource_nm_program->fetch(PDO::FETCH_NUM))
									{
							  		echo '<option value="'.e($row_nm_program[0]).'">'.e($row_nm_program[0]).'</option>';
							  		}      ?>
        <option selected><?php echo e($nm_program) ?></option>
      </select>
    </div>
  </div>
  <div class="col-md-3">
    <div class="form-group">
      <label>Level</label>
      <select class="form-control" name="nm_level"  onChange="this.form.submit()">
        <?php
								$query_level = "SELECT level_program FROM vip_mst_code_prg where nm_program = ? and  type_program = ? and aktif = 1";
								$resource_level = db_query($query_level, [$nm_program, $type_class]);
								while ($row_level=  $resource_level->fetch(PDO::FETCH_NUM))
									{
							  		echo '<option value="'.e($row_level[0]).'">'.e($row_level[0]).'</option>';
							  		}      ?>
        <option selected><?php echo e($nm_level) ?></option>
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
								$query_exam = "SELECT distinct exam, case when exam = 'Y' then 'Exam' when exam = 'N' then 'Non Exam' when exam <> 'Y' and exam <> 'N' then 'Material Handout'   end FROM vip_mst_code_prg where nm_program = ?";
								$resource_exam = db_query($query_exam, [$nm_program]);
								while ($row_exam=  $resource_exam->fetch(PDO::FETCH_NUM))
									{
							  		echo '<option value="'.e($row_exam[1]).'">'.e($row_exam[1]).'</option>';
							  		}      ?>
							  		<option>No</option>       
        <option selected="selected">          <?php echo e($material_book) ?>          </option>
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
        <option value= "5">5</option>   
		  
        <?php } else {?>             
                <option value= "1">1</option>
<?php }?>
        <option selected="selected">
          <?php echo e($private_pax) ?>
          </option>
      </select>
    </div>
  </div>
  <div class="col-md-2">
    <div class="form-group">
      <label>Private -  Hours</label>
      <select name="private_hours" id="private_hours" class="form-control"   onChange="this.form.submit()">
       <?php 
		if($nm_program == 'Fellows Academy')
			{?>
				<option value= "12">12</option>
			<?php }
		elseif ($kdcbg == 8) 
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
	elseif
		($kdcbg == 14) 
		{?>
				  <option value= "0">0</option>
			<option value= "7.5">7.5</option>	
		  <option value= "8">8</option>		  
				  <option value= "42">42</option>
		  <option value= "44">44</option>
		  <option value= "46">46</option>	
		<?php }
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
			elseif ($nm_program == 'VIPCTP')
			{ ?>
			<option value= "8">8</option>
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
			<option value= "6">6</option>		  		  
			<option value= "7.5">7.5</option>		  
			<option value= "10">10</option>
			<option value= "14">14</option>
		  
			<option value= "15">15</option>
			<option value= "16">16</option>
		  
		  
			<option value= "20">20</option>
	<?php   } 	
			 	elseif ($kode_program == 'VIPUV')
			{ ?>
			<option value= "4">4</option>
	<?php   } 	
			 	elseif ($kode_program == 'VIPEP')
			{ ?>
			<option value= "12">12</option>
	<?php   } 	
			 	elseif ($nm_program == 'CA')
			{ ?>
		  
			<option value= "2.5">2.5</option>
			<option value= "3">3</option>
		  
			<option value= "4">4</option>
		  
			<option value= "6">6</option>
			<option value= "7.5">7.5</option>
		  
			<option value= "8">8</option>	
			<option value= "9">9</option>	
		  
		  
			<option value= "12">12</option>		
			<option value= "15">15</option>		
			
		  
			<option value= "18">18</option>
	<?php   } 	
			 	elseif ($kode_program == 'IETOP')
			{ ?>
			<option value= "2">2</option>
	<?php   } 					
			 elseif ($kode_program == 'VIPSC1P' or $kode_program == 'VIPSC2P'  )
			{ ?>
			<option value= "15">15</option>
	<?php   }
			 elseif ($kode_program == 'VIPSC3P')
			{ ?>
			<option value= "12">12</option>
	<?php   } 
			 elseif ($kode_program == 'VIPSC4P')
			{ ?>
			<option value= "9">9</option>
	<?php   } 
			 elseif ($kode_program == 'VIPSC5P')
			{ ?>
			<option value= "9">9</option>
			<option value= "15">15</option>		  
	<?php   } 						
			else 
			{ ?>
			<option value= "0">0</option>
			<option value= "2">2</option>
			<option value= "4">4</option>		  
			<option value= "6">6</option>		  
		  
			<option value= "8">8</option>		  
			<option value= "10">10</option>
			<option value= "12">12</option>
			<option value= "15">15</option>

		  <option value= "16">16</option>
			<option value= "18">18</option>
		  
			<option value= "20">20</option>
			<option value= "21">21</option>


			<option value= "23">23</option>

			<option value= "24">24</option>
		  
			<option value= "30">30</option>		  
			<option value= "36">36</option>
			<option value= "39">39</option>
		  <option value= "40">40</option>
		  <option value= "42">42</option>
		  <option value= "44">44</option>
		  <option value= "46">46</option>		  
		<?php } 
		}?>        
       <option selected="selected"><?php echo e($private_hours) ?>
          </option>
      </select>
    </div>
  </div>
 <?php }//==== ?> 
	  <div class="col-md-3">
			    <div class="form-group">
			      <label>Tuition Fee</label>
			      <input type="text" name="tf_display"  class="form-control" value = "<?php echo number_format((float) $tf,0,".",".")  ?>"
			      <?php if ($type_class != 'WORKSHOP' and $type_class != 'GLBRD')
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
	        <option>140000</option>	
			  
	        <option>150000</option>	
	        <option>200000</option>				  
	        <option>250000</option>	
			  
	        <option>300000</option>	
	        <option>400000</option>	
	        <option>500000</option>	
	        <option>650000</option>	

			  
	        <option>700000</option>		

			<option>725000</option>		
	        <option>1000000</option>	
			  
	        <option>1030000</option>	

	        <option>1205000</option>			  
	        <option>1350000</option>

	        <option>1400000</option>
	        <option>1700000</option>
	        <option>1690000</option>			  
	        <option>2700000</option>	

			  
	        <option>3000000</option>
	        <option>3100000</option>
			  
	        <option>3134000</option>	
			  
	        <option>2193750</option>	
	        <option>2774975</option>	
			  
	        <option>3700000</option>	
	        <option>3864000</option>	
			  
			  
			  
<?php }	
else {?>
			  	        <option>20000</option>	
	        <option>30000</option>
	        <option>40000</option>
			  
	        <option>50000</option>

	        <option>50000</option>
	        <option>60000</option>
	        <option>100000</option>
	        <option>130000</option>
			  
	        <option>140000</option>
	        <option>160000</option>
	        <option>150000</option>	        
	        <option>200000</option>
	        <option>240000</option>				  
	        <option>245000</option>			  
	        <option>250000</option>
	        <option>275000</option>

	        <option>300000</option>	
	        <option>350000</option>	
	        <option>380000</option>	
			  
	        <option>400000</option>	
	        <option>450000</option>	 			  
	        <option>500000</option>	 
	        <option>550000</option>	 
	        <option>600000</option>	 			  
	        <option>700000</option>	
	        <option>725000</option>	
				        
	        <option>750000</option>	
	        <option>830000</option>		        	        
			  
	        <option>800000</option>		        	        
	        <option>1000000</option>	
	        <option>1070000</option>			  
	        <option>1250000</option>
	        <option>1300000</option>			  
	        <option>1400000</option>
	        <option>1500000</option>
			  
	        <option>2050000</option>
	        <option>2800000</option>
	        <option>3000000</option>			  
	        <option>4600000</option>
			  
	        <option>6000000</option>			  
	        <option>7500000</option>			  
			  
<?php } ?>	        
	        <option selected><?php echo e($voucher) ?></option>
	        </select>
	    </div>
	    </div>
	  <div class="col-md-3">
	    <div class="form-group">
          <label>Discount / Promo / Cash Back</label>
          <select class="form-control" name="nm_promo"  onChange="this.form.submit()">
            <?php
								$query_discount = "SELECT nm_promo FROM ves_data.vip_mst_promo where  (kd_branch = ? or kd_branch = '0') group by nm_promo";
								$resource_discount = db_query($query_discount, [$kdcbg]);
								while ($row_discount=  $resource_discount->fetch(PDO::FETCH_NUM))
									{
							  		echo '<option value="'.e($row_discount[0]).'">'.e($row_discount[0]).'</option>';
							  		}      ?>
            <option selected><?php echo e($nm_promo) ?></option>
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
	          <?php echo e($old_student) ?>
	          </option>
	        </select>
	      <input type="hidden" ang="en-150" class="form-control"  placeholder="Enter ..." name="reg_fee2" 
                 	      value="<?php echo e($reg_fee) ?>">
	      </div>
	    </div>
	  <div class="col-md-3">
	    <div class="form-group">
<label> Tuition Fee (Netto)</label>
          <input type="text" name="tf_nett_display"  class="form-control" value = "<?php echo number_format((float) $tf_nett,0,".",".")  ?>"readonly/>
        </div>
  </div>
	  <div class="col-md-4">
	    <div class="form-group">
	      <label>Material Book Title</label>
	      <select class="form-control" name="book_title"   onChange="this.form.submit()">

	        <option selected>No Book</option>
	        </select>
	      </div>
	</div>
<?php if($kd_cbg == '15'){?>	
	  <div class="col-md-3">
	    <div class="form-group">
	      <label>Event Fee</label>
	      (CA Only)
	      <input type="text" name="ca_event_fee"  class="form-control" value = "<?php echo e($ca_event_fee) ?>"/>
	      </div>
	    </div>
<?php 	 } ?>
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
            <td align=center class="style24"><?php echo number_format((float) $reg_fee_net,0,".",".")  ?></td>
            <td align=center class="style24"><?php echo number_format((float) $material_fee,0,".",".")  ?></td>
            <td align=center class="style24"><?php echo number_format((float) $tf,0,".",".")  ?></td>
            <td align=center class="style24"><?php echo e($nm_promo) ?><br>              
              <?php echo e($discount_tf) ?> %</td>
            <td align=center class="style24"><?php echo number_format((float) $voucher,0,".",".")  ?></td>
            <td align=center class="style24"><?php echo number_format((float) $tf_nett,0,".",".")  ?></td>
            <td height="14" align=center class="style24"><strong><?php echo number_format((float) $totalinvoice,0,".",".")  ?></strong></td>
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
$query_invoice = "SELECT jns_payment, amount, a.status, dt_payment,no,kd_unik FROM ves_data.vip_billing_payment a left join ves_data.tb_banking b on a.no = b.id_transaksi  where kd_billing = ?";
$resource_invoice = db_query($query_invoice, [$idb]);
$keluar_invoice = $resource_invoice->rowCount();	
if($resource_invoice->rowCount() > 0)

					if($resource_invoice->rowCount() > 0)
	{
	while ($row_invoice  =  $resource_invoice->fetch(PDO::FETCH_NUM))
		{

		
?>	
                  <tr>
                    <td width="17%" align=center class="style24"><?php echo e($row_invoice[0]) ?></td>
                    <td width="21%" align=center class="style24"><?php echo number_format((float) $row_invoice[1],0,".",".")  ?></td>
                    <td width="26%" align=center class="style24"><?php echo number_format(num($row_invoice[1]) + num($row_invoice[5]),0,".",".")  ?> <em>(Please Ignore)</em></td>
                    <td width="12%" align=center class="style24"><?php echo e($row_invoice[2]) ?></td>
                    <td width="12%" align=left class="style24"><?php echo e($row_invoice[3]) ?></td>
                    <td width="10%" height="14" align=left class="style24">
                    <?php 
					if ($row_invoice[2] == 'unpaid')
						{ ?>
                    <a href="vipbill_del.php?no=<?php echo e(u($row_invoice[4])) ?>" target="popup" 
                    onclick="window.open('vipbill_del.php?no=<?php echo e(u($row_invoice[4])) ?>','popup','width=1000,height=800'); return false;">Delete</a></td>
                    <?php } else { ?>
					Print<td width="2%"></td>
                    <?php }?>
                  </tr>
  <?php 
$nomor = num($nomor) + 1;}} 

 ?>
                <tfoot>
                </tfoot>
                
              </table>	
    </div>
    <div class="col-md-2">
    	<div class="form-group">
    		<label>Outstanding :</label>
    	    <input type="text" ang="en-150" class="form-control"  placeholder="Enter ..." name="outstanding" 
                 	      value="<?php echo number_format((float) $outstanding,0,".",".") ?>" readonly>
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
		          <option selected="selected"><?php echo e($type_pay) ?></option>
	            </select>
	          </div>
	        </div>
		    <div class="col-md-6">
		      <div class="form-group">
		        <label>Amount</label><input type="text" name="amount"  class="form-control" value = "<?php echo e($amount) ?>"/>
	          </div>
	        </div>
	    		    <div class="col-md-6">
		      <div class="form-group">
		        <label>SC Name</label>
		        <select class="form-control" name="sc">
	          <option>Event</option>
		          <?php
	$query_sc = "SELECT distinct nama_detail from ves_data.tb_user where  (posisi = 'CM' or posisi = 'SC' or posisi = 'AC' or posisi = 'Admission') and kd_branch = ? and nama_detail is not null and aktif = 'Y'  order by nama_detail ";
$resource_sc = db_query($query_sc, [$kdcbg]);
$keluar_sc= $resource_sc->rowCount();
if($resource_sc->rowCount() > 0)
	{
	while ($row_sc=  $resource_sc->fetch(PDO::FETCH_NUM))
		{
		echo '<option value="'.e($row_sc[0]).'">'.e($row_sc[0]).'</option>';		

		}
	}
     ?>
		          <option selected><?php echo e($sc) ?></option>
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
<script>
// Dropdown hitung ulang (onChange="this.form.submit()") dikirim di latar belakang lalu hanya isi
// form yang diganti dengan hasil server - halaman tidak dimuat ulang, posisi scroll & fokus tetap.
// Perhitungan tetap di PHP (request POST yang sama). Tombol Save/Print/Exit tetap submit biasa.
// Bila gagal (jaringan/browser lama), kembali ke cara lama: submit penuh.
(function () {
	var form = document.getElementById('myform');
	if (!form || !window.fetch || !window.DOMParser || !window.FormData) { return; }
	var nativeSubmit = HTMLFormElement.prototype.submit;
	var busy = false, pending = false;
	function fieldByName(name) {
		var el = name ? form.elements[name] : null;
		return el && !el.tagName && el.length ? el[0] : el;
	}
	form.submit = function () {
		if (busy) { pending = true; return; }
		busy = true;
		var activeName = document.activeElement && document.activeElement.name;
		var y = window.pageYOffset;
		form.style.opacity = '0.6';
		form.style.pointerEvents = 'none';
		fetch(window.location.href, { method: 'POST', body: new FormData(form), credentials: 'same-origin' })
			.then(function (r) { if (!r.ok) { throw new Error('HTTP ' + r.status); } return r.text(); })
			.then(function (html) {
				if (pending) { return; }   // pilihan berubah lagi selama menunggu: kirim ulang dengan nilai terbaru
				var baru = new DOMParser().parseFromString(html, 'text/html').getElementById('myform');
				if (!baru) { throw new Error('form tidak ditemukan di respons'); }
				form.innerHTML = baru.innerHTML;
				window.scrollTo(0, y);
				var el = fieldByName(activeName);
				if (el && el.focus) { el.focus({ preventScroll: true }); }
			})
			.catch(function () { nativeSubmit.call(form); })
			.finally(function () {
				form.style.opacity = '';
				form.style.pointerEvents = '';
				busy = false;
				if (pending) { pending = false; form.submit(); }
			});
	};
})();
</script>
</body>
</html>
<?php 
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['Save'])) 
	{
	$saat_ini = date('Y-m-d H:i:s');
		
	$bisa = 1;	$branch = $_SESSION['branch'];	$kdb = in_str('kdb', 45);$kdcbg = $_SESSION['kd_branch'];	$idb = in_str('idb', 45);		
		
	$hari=date("d");$bulan=date("m");$tahun=date("Y");
	$hari_ini = "$tahun-$bulan-$hari";			
		
	if($bulan =='01'){$bln_rom="I";}if($bulan =='02'){$bln_rom="II";}	if($bulan =='03'){$bln_rom="III";}	if($bulan =='04'){$bln_rom="IV";}
	if($bulan =='05'){$bln_rom="V";}	if($bulan =='06'){$bln_rom="VI";}	if($bulan =='07'){$bln_rom="VII";}	if($bulan =='08'){$bln_rom="VIII";}
	if($bulan =='09'){$bln_rom="IX";}	if($bulan =='10'){$bln_rom="X";}	if($bulan =='11'){$bln_rom="XI";}	if($bulan =='12'){$bln_rom="XII";}
	$nik = in_str('nik', 45);
	$kode_program = in_str('kode_program', 45);	$nm_program = in_str('nm_program', 100);	$nm_level = in_str('nm_level', 100);	$material_book = in_str('material_book', 45);$material_fee = in_str('material_fee', 20);
	$nm_promo = in_str('nm_promo', 100);	$old_student = in_str('old_student', 10);$reg_fee = in_str('reg_fee', 20);	$sc = in_str('sc', 100);	$book_title = in_str('book_title', 100);	$book_title = in_str('book_title', 100);
	if ($type_class ==''){$bisa = 0;$pesan ="type class must be filled";}
	if ($kode_program ==''){$bisa = 0;$pesan ="wrong program/level";}		
	if ($nm_program ==''){$bisa = 0;$pesan ="program must be filled";}
	if ($nm_level ==''){$bisa = 0;$pesan ="level must be filled";}if ($material_book ==''){$bisa = 0;$pesan ="material book must be filled";}
	if ($nm_promo ==''){$bisa = 0;$pesan ="promo must be filled";}if ($old_student ==''){$bisa = 0;$pesan ="old or new student must be choosen";}	
	$type_pay = in_str('type_pay', 45);//if ($type_pay ==''){$bisa = 0;$pesan ="Type of Payment must be choosen";}		
	if ($sc ==''){$bisa = 0;$pesan ="Consultant Name must be choosen";}
	if ($book_title ==''){$bisa = 0;$pesan ="Book Title must be choosen";}
		
	$tf = in_str('tf', 20);	$voucher = in_str('voucher', 20);$discount_tf = in_str('discount_tf', 20);$tf_nett = in_str('tf_nett', 20);	
	$nama_lengkap = $_SESSION['nama_lengkap']; 	$amount = in_str('amount', 20); 	$private_pax = in_str('private_pax', 10);$private_hours = in_str('private_hours', 10);
	//if ($amount == 0 ){$bisa = 0;$pesan ="Amount must be not zero";}
	if($bisa == 1)
		{
		if ($idb !='')
			{
			$query_check_billing = "SELECT jns_payment FROM ves_data.vip_billing_payment where  jns_payment = ? and kd_billing = ?";
			$resource_check_billing = db_query($query_check_billing, [$type_pay, $idb]);
			if($resource_check_billing->rowCount() > 0)
				{
				$st = 1;
				echo "<script type=\"text/javascript\">\n";
				echo "alert('Same Payment Type Already Submited');\n";			
				echo "</script>";
					die;
				}
			else
				{
			
				$query_update_billing = "update ves_data.vip_billing set kd_program = ? ,tf = ?,discount= ?,net_tf= ?,pic= ?,sc= ?,material= ?,old_student= ?,voucher= ?,material_cost= ?,reg_fee= ?,promo_persen = ?,level_program = ?,private_pax = ?,
private_hours  = ?,book_title = ?,event_fee = ? where  kd_biodata = ? and kd_billing = ? "; 
				$resource_update_billing = db_query($query_update_billing, [$kode_program, $tf, $nm_promo, $tf_nett, $nama_lengkap, $sc, $material_book, $old_student, $voucher, $material_fee, $reg_fee, $discount_tf, $nm_level, $private_pax, $private_hours, $book_title, $ca_event_fee, $kdb, $idb]);
				$query_simpan_payment = "insert into ves_data.vip_billing_payment (kd_billing, kd_biodata, kd_branch, jns_payment, amount, dt_entry, pic, status) 
				values 
				(?,?,?,?,?,?,?,'unpaid')";
				$resource_simpan_payment = db_query($query_simpan_payment, [$idb, $kdb, $kdcbg, $type_pay, $amount, $tgl_hari_ini, $nama_lengkap]);	
				$st = 1;
//==mulai buat kode unik					
				$query_last_id = "SELECT no FROM vip_billing_payment where kd_billing = ? and kd_biodata = ? and  kd_branch = ? and  jns_payment = ? and  amount = ? and  dt_entry = ? and  pic = ? and  status = 'unpaid'";

				$resource_last_id = db_query($query_last_id, [$idb, $kdb, $kdcbg, $type_pay, $amount, $tgl_hari_ini, $nama_lengkap]);
				while ($row_last_id=  $resource_last_id->fetch(PDO::FETCH_NUM))
					{
					$id_transaksi =$row_last_id[0]; 
					}
				$x = 0;
				while($x <= 100)
				{
				$kd_unik= rand(5,100);
				$query_unik = "select kd_unik from ves_data.tb_banking WHERE kd_unik= ? and status = 0";
				$resource_unik = db_query($query_unik, [$kd_unik]);
				if($resource_unik->rowCount() == 0)
					{
					$query_insert_kd = "insert into ves_data.tb_banking (jns_transaksi, id_transaksi, kd_unik, status, dt_entry,nominal ) values (1,?,?,'0',?,?)";
					$resource = db_query($query_insert_kd, [$id_transaksi, $kd_unik, $saat_ini, $amount]);
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
			$query_last_billing = "SELECT kd_billing FROM ves_data.vip_billing where  kd_branch = ? order by no desc limit 1";
			$resource_last_billing = db_query($query_last_billing, [$kdcbg]);
			if($resource_last_billing->rowCount() > 0)
				{
				while ($row_last_billing=  $resource_last_billing->fetch(PDO::FETCH_NUM))
					{
					$kd_billing = $row_last_billing[0];
					$ambilangka =  substr($kd_billing,0,-4);
					#ketemu angka awal(angka sebelumnya) + dengan 1
					$nextangka = num($ambilangka) + 1;
					#menhitung jumlah karakter
					$digit=strlen($nextangka);
					if(!$kd_billing){ $nol='000'; }elseif($digit==1){ $nol='000'; }	elseif($digit==2){ $nol='00'; }	elseif($digit==3)
					{ $nol='0'; }	
					if ($kd_cbg ==19){
					$nomor_baru = $nol.$nextangka."/FA/".$kdcbg."/".$bln_rom."-".$tahun;	
						
					}
					else
					{
					$nomor_baru = $nol.$nextangka."/VIP/0".$kdcbg."/".$bln_rom."-".$tahun;	
					}}
				}
			else
				{
				if ($kd_cbg ==19){
									$nomor_baru =  "0001/FA/".$kdcbg."/".$tahun;

						
					}else
				{				$nomor_baru =  "0001/VIP/0".$kdcbg."/".$tahun;
}
				}
			$idb = $nomor_baru;
			$query_simpan_billing = "insert into ves_data.vip_billing (kd_billing,kd_branch,kd_biodata,kd_program,tf,discount,net_tf,dt_entry,pic,sc,material,old_student,voucher,material_cost,reg_fee,promo_persen,level_program,private_pax,private_hours,event_fee) 
			values (?,?,?,?,?,? ,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
			$resource_simpan_billing = db_query($query_simpan_billing, [$idb, $kdcbg, $kdb, $kode_program, $tf, $nm_promo, $tf_nett, $tgl_hari_ini, $nama_lengkap, $sc, $material_book, $old_student, $voucher, $material_fee, $reg_fee, $discount_tf, $nm_level, $private_pax, $private_hours, $ca_event_fee]);
			$query_cek_student_data = "select kd_biodata from ves_data.vip_student_data where kd_biodata = ? and kd_branch = ?";
			$resource_cek_student_data = db_query($query_cek_student_data, [$kdb, $kdcbg]);
			if($resource_cek_student_data->rowCount() == 0)
				{
				$length = 6;    
				$kodekey =  substr(str_shuffle('0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ'),1,$length);
				$query_key = "SELECT idkey FROM ves_data.vip_student_data where idkey = ?";
				$resource_key= db_query($query_key, [$kodekey]);
				if($resource_key->rowCount() > 0)
					{
					return $kodekey;
					}
				else
					{
					$query_vip_nama = "insert into  ves_data.vip_student_data (kd_branch, nama_lengkap, kd_biodata,idkey)values (?,?,?,?)";
					$resource_vip_nama = db_query($query_vip_nama, [$kdcbg, $student_name, $kdb, $kodekey]);						
					}					
				}
			
				
			if ($material_fee != 'No')
				{
				$query_simpan_payment = "insert into ves_data.vip_billing_payment (kd_billing, kd_biodata, kd_branch, jns_payment, amount, dt_entry, pic, status) 
				values 
				(?,?,?,'Material',?,?,?,'unpaid')";
				$resource_simpan_payment = db_query($query_simpan_payment, [$idb, $kdb, $kdcbg, $material_fee, $tgl_hari_ini, $nama_lengkap]);	
				$st = 1;
//==mulai buat kode unik					
				$query_last_id = "SELECT no FROM vip_billing_payment where kd_billing = ? and kd_biodata = ? and  kd_branch = ? and  jns_payment = 'Material' and  amount = ? and  dt_entry = ? and  pic = ? and  status = 'unpaid'";

				$resource_last_id = db_query($query_last_id, [$idb, $kdb, $kdcbg, $material_fee, $tgl_hari_ini, $nama_lengkap]);
				while ($row_last_id=  $resource_last_id->fetch(PDO::FETCH_NUM))
					{
					$id_transaksi =$row_last_id[0]; 
					}
				$x = 0;
				while($x <= 100)
				{
				$kd_unik= rand(5,100);
				$query_unik = "select kd_unik from ves_data.tb_banking WHERE kd_unik= ? and status = 0";
				$resource_unik = db_query($query_unik, [$kd_unik]);
				if($resource_unik->rowCount() == 0)
					{
					$query_insert_kd = "insert into ves_data.tb_banking (jns_transaksi, id_transaksi, kd_unik, status, dt_entry,nominal ) values (1,?,?,'0',?,?)";
					$resource = db_query($query_insert_kd, [$id_transaksi, $kd_unik, $saat_ini, $amount]);
					$akhir_id = db_insert_id();
					break;	
					}
					$x++;
				}					
//==selesai buat kode unik							
				}
			if ($old_student == 'No')
				{
				$query_simpan_payment = "insert into ves_data.vip_billing_payment (kd_billing, kd_biodata, kd_branch, jns_payment, amount, dt_entry, pic, status) 
				values 
				(?,?,?,'Registration',?,?,?,'unpaid')";
				$resource_simpan_payment = db_query($query_simpan_payment, [$idb, $kdb, $kdcbg, $reg_fee, $tgl_hari_ini, $nama_lengkap]);	
				$st = 1;
//==mulai buat kode unik					
				$query_last_id = "SELECT no FROM vip_billing_payment where kd_billing = ? and kd_biodata = ? and  kd_branch = ? and  jns_payment = 'Registration' and  amount = ? and  dt_entry = ? and  pic = ? and  status = 'unpaid'";

				$resource_last_id = db_query($query_last_id, [$idb, $kdb, $kdcbg, $reg_fee, $tgl_hari_ini, $nama_lengkap]);
				while ($row_last_id=  $resource_last_id->fetch(PDO::FETCH_NUM))
					{
					$id_transaksi =$row_last_id[0]; 
					}
				$x = 0;
				while($x <= 100)
				{
				$kd_unik= rand(5,100);
				$query_unik = "select kd_unik from ves_data.tb_banking WHERE kd_unik= ? and status = 0";
				$resource_unik = db_query($query_unik, [$kd_unik]);
				if($resource_unik->rowCount() == 0)
					{
					$query_insert_kd = "insert into ves_data.tb_banking (jns_transaksi, id_transaksi, kd_unik, status, dt_entry,nominal ) values (1,?,?,'0',?,?)";
					$resource = db_query($query_insert_kd, [$id_transaksi, $kd_unik, $saat_ini, $amount]);
					$akhir_id = db_insert_id();
					break;	
					}
					$x++;
				}					
//==selesai buat kode unik						
				}	
			if (num($amount) != 0 and $type_pay != '')
				{
				$query_simpan_payment = "insert into ves_data.vip_billing_payment (kd_billing, kd_biodata, kd_branch, jns_payment, amount, dt_entry, pic, status) 
				values 
				(?,?,?,?,?,?,?,'unpaid')";
				$resource_simpan_payment = db_query($query_simpan_payment, [$idb, $kdb, $kdcbg, $type_pay, $amount, $tgl_hari_ini, $nama_lengkap]);	
				$st = 1;
//==mulai buat kode unik					
				$query_last_id = "SELECT no FROM vip_billing_payment where kd_billing = ? and kd_biodata = ? and  kd_branch = ? and  jns_payment = ? and  amount = ? and  dt_entry = ? and  pic = ? and  status = 'unpaid'";

				$resource_last_id = db_query($query_last_id, [$idb, $kdb, $kdcbg, $type_pay, $amount, $tgl_hari_ini, $nama_lengkap]);
				while ($row_last_id=  $resource_last_id->fetch(PDO::FETCH_NUM))
					{
					$id_transaksi =$row_last_id[0]; 
					}
				$x = 0;
				while($x <= 100)
				{
				$kd_unik= rand(5,100);
				$query_unik = "select kd_unik from ves_data.tb_banking WHERE kd_unik= ? and status = 0";
				$resource_unik = db_query($query_unik, [$kd_unik]);
				if($resource_unik->rowCount() == 0)
					{
					$query_insert_kd = "insert into ves_data.tb_banking (jns_transaksi, id_transaksi, kd_unik, status, dt_entry,nominal ) values (1,?,?,'0',?,?)";
					$resource = db_query($query_insert_kd, [$id_transaksi, $kd_unik, $saat_ini, $amount]);
					$akhir_id = db_insert_id();
					break;	
					}
					$x++;
				}					
//==selesai buat kode unik							
				}							
			}	
$query_nik = "SELECT nik FROM ves_data.tb_nik  where kd_biodata = ?";	
	$resource_nik = db_query($query_nik, [$kdb]);
	$keluar_nik = $resource_nik->rowCount();
	if($resource_nik->rowCount() > 0)
		{
		while ($row_nik  =  $resource_nik->fetch(PDO::FETCH_NUM))
			{
			$update_nik = "update ves_data.tb_nik set nik = ? where kd_biodata = ?";
			$resource_update_nik = db_query($update_nik, [$nik, $kdb]);			
			}
		}	
	else
		{
			$update_nik = "insert into ves_data.tb_nik (nik,kd_biodata) values (?,?)";
			$resource_update_nik = db_query($update_nik, [$nik, $kdb]);			
		
		}
	
		
		echo "<script type=\"text/javascript\">\n";
		echo "alert('VIP Billing Submitted');\n";
		echo 'window.location = (' . js('vipbill.php?idb=' . u($idb) . '&kdb=' . u($kdb) . '&st=' . u($st)) . ");\n";				
		echo "</script>";
		}
	else
		{
		echo "<script type=\"text/javascript\">\n";
		echo 'alert(' . js($pesan) . ");\n";
		echo "</script>";
		}
	}
if (in_raw('Print') !== null) 
	{
	if ($idb !='')
		{

			echo "<script type=\"text/javascript\">\n";
			echo 'window.open(' . js('vipbillprint.php?idb=' . u($idb) . '&kdb=' . u($kdb)) . ",'width=560,height=340,toolbar=0,menubar=0,location=0');\n";				
			echo "</script>";		

		}
	}
?>