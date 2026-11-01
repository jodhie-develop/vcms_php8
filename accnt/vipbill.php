<?php
require_once __DIR__ . "/../_lib/bootstrap.php"; csrf_guard_get(); auth_require_login(); 
include __DIR__ . "/../conndb.php";
include __DIR__ . "/../profiledata.php";
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
$book_title = in_val('book_title', 'any');


$idb = in_val('idb', 'any');
if ($type_class != 'WORKSHOPS')
	{
	if($nm_program !="" and $nm_level !="")
		{
		$query_kode_program = q_set($__p_query_kode_program, "SELECT kd_program FROM ves_data.vip_mst_code_prg where nm_program = ? and level_program = ? and type_program = ? ", [(string) ($nm_program), (string) ($nm_level), (string) ($type_class)]);			
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
	$query_kode_program = q_set($__p_query_kode_program, "SELECT kd_program FROM ves_data.vip_mst_code_prg where nm_program = ? and type_program = ? ", [(string) ($nm_program), (string) ($type_class)]);			
	$resource_kode_program = db_query_or_die('errro_2', $query_kode_program, $__p_query_kode_program ?? []);
	while ($row_kode_program=  db_fetch($resource_kode_program, PDO::FETCH_NUM))
		{
		$kode_program =   $row_kode_program[0];
		}   
	}		



$private_pax = in_val('private_pax', 'any');
$nm_promo = in_val('nm_promo', 'any');
if($nm_promo !='')
	{
	$query_promo = q_set($__p_query_promo, "SELECT tf, rf, cashback FROM ves_data.vip_mst_promo where nm_promo = ? and kd_branch = ? ", [(string) ($nm_promo), (string) ($kdcbg)]);
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
	$tf_nett = (num($tf) - num($voucher)) ;
	$tf_nett = num($tf_nett)-  num((num($tf) * num((num($discount_tf)/100)))) - num($discount_cashback) ;	
	
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
\ta.material, a.tf, a.voucher, a.discount,a.old_student , a.net_tf,a.kd_billing,a.material_cost,a.old_student,a.kd_biodata,a.sc,a.private_pax, a.private_hours,reg_fee,book_title,book_status,kd_class\t  FROM ves_data.vip_billing a\r
\tleft join ves_data.vip_mst_code_prg b on a.kd_program = b.kd_program and a.level_program = b.level_program  where a.kd_billing = ? ", [(string) ($idb)]);
	$resource_ambil_billing = db_query_or_die('errro_75', $query_ambil_billing, $__p_query_ambil_billing ?? []);
	while ($row_ambil_billing=  db_fetch($resource_ambil_billing, PDO::FETCH_NUM))
		{
		$type_class =   $row_ambil_billing[0];
		$nm_program =   $row_ambil_billing[1];
		$nm_level =   $row_ambil_billing[2];
		$nm_level_current =   $row_ambil_billing[2];
		
		$kode_program =  $row_ambil_billing[3];
		$kode_program_current =  $row_ambil_billing[3];
		
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
		$class_code_choosen = $row_ambil_billing[20];			
		}
		}
else
{

if($nm_promo !='')
	{
	$query_promo = q_set($__p_query_promo, "SELECT tf, rf, cashback FROM ves_data.vip_mst_promo where nm_promo = ? and kd_branch = ? ", [(string) ($nm_promo), (string) ($kdcbg)]);
	$resource_promo = db_query_or_die('errro_76', $query_promo, $__p_query_promo ?? []);
	while ($row_promo=  db_fetch($resource_promo, PDO::FETCH_NUM))
		{
		$discount_tf =   $row_promo[0];
		$discount_rf =   $row_promo[1];
		$discount_cashback =   $row_promo[2];
		}		
	}


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
	if ($private_pax == '1'){$harga_private = '390000';}	
	if ($private_pax == '2'){$harga_private = '260000';}	
	if ($private_pax == '3'){$harga_private = '190000';}	
	if ($private_pax == '4'){$harga_private = '160000';}	

	}
elseif ($kdcbg == '8')
	{
	if ($private_pax == '1'){$harga_private = '293333';}	
	if ($private_pax == '2'){$harga_private = '163333';}	
	if ($private_pax == '3'){$harga_private = '163333';}	
	if ($private_pax == '4'){$harga_private = '120000';}		
	}
else
	{
	if ($private_pax == '1'){$harga_private = '370000';}	
	if ($private_pax == '2'){$harga_private = '240000';}	
	if ($private_pax == '3'){$harga_private = '170000';}	
	if ($private_pax == '4'){$harga_private = '150000';}		
	}	
if ($nm_program =='LC')	
	{
	if ($kdcbg == '7')
		{$harga_private = '150000';}
	elseif ($kdcbg == '8')
		{$harga_private = '100000';}
	 		
	elseif($kdcbg=='3')
		{$harga_private = '185000';}
	else
		{$harga_private = '200000';}
	}
elseif ($nm_program =='BE' and $nm_level  == 'Placement Test CEPT')	
	{
	$harga_private = '200000';
	$private_pax = 1;
	$private_hours = 1;
	}
elseif ($nm_program =='ESP' and $nm_level  == 'SDP 10 hrs')	
	{
	if ($kdcbg == '8')
		{
	$harga_private = '2500000';
	$private_pax = 1;
	$private_hours = 10;			
		}
	else
		{
	$harga_private = '450000';
	$private_pax = 1;
	$private_hours = 10;		
		}

	}
elseif ($nm_program =='ESP' and $nm_level  == 'SDP 20 hrs')	
	{
	$harga_private = '425000';
	$private_pax = 1;
	$private_hours = 20;
	}


//if ($kdcbg == '8' and $type_class =='PRI' and  	$private_pax == 1 and ($private_hours == 30  ) ){$tf = '8800000';}	
//if ($kdcbg == '8' and $type_class =='PRI' and 	 $private_hours == 30 and $private_pax == 2 ){$tf = '4900000';}	
//if ($kdcbg == '8' and $type_class =='PRI' and 	 $private_hours == 30 and $private_pax == 3  ){$tf = '3600000';}	
//====
if ($kdcbg <> '9' and $type_class =='PRI' and $nm_program <> 'ESP' and	num($private_pax) == 1 and num($private_hours) == 30 ){$tf = '13500000';}	
if ($kdcbg <> '9' and $type_class =='PRI'  and $nm_program <> 'ESP' and 	 (num($private_hours) == 30 or num($private_hours) == 20) and (num($private_pax) == 2 ) ){$tf = '8500000';}	
if ($kdcbg <> '9' and $type_class =='PRI'  and $nm_program <> 'ESP' and 	 (num($private_hours) == 30 or num($private_hours) == 20) and (num($private_pax) == 3 ) ){$tf = '6500000';}	
	
	
//==sdp
if ($kdcbg <> '9' and $type_class =='PRI' and $nm_program == 'ESP' and	num($private_pax) == 1 and num($private_hours) == 20 ){$tf = '8500000';}	
if ($kdcbg <> '9' and $type_class =='PRI' and $nm_program == 'ESP' and	num($private_pax) == 1 and num($private_hours) == 10 ){$tf = '4500000';}	
if ($kdcbg == '1' and $type_class =='PRI' and $nm_program == 'TOEFL' and $kode_program== 'TPWAP' and	num($private_hours) == 12 ){$tf = '3120000';}

if($type_class == 'PRI' and ($nm_program =='GE' or $nm_program =='AE' or $nm_program =='BE' or $nm_program =='CO' ))
{
if ($kdcbg =='1' or $kdcbg=='2' or $kdcbg=='4' or $kdcbg=='5' or $kdcbg=='6')
	{
	if ($private_pax == '1'){$harga_private = '390000';}	
	if ($private_pax == '2'){$harga_private = '260000';}	
	if ($private_pax == '3'){$harga_private = '190000';}	
	if ($private_pax == '4'){$harga_private = '160000';}	

	}
$tf = (num($harga_private) * num($private_hours));		
}
if($type_class == 'PRI' and ($nm_program =='GE' or $nm_program =='AE' or $nm_program =='BE' or $nm_program =='CO' ))
{
if ($kdcbg =='1' or $kdcbg=='2' or $kdcbg=='4' or $kdcbg=='5' or $kdcbg=='6' )
	{
	if ($private_pax == '1'){$harga_private = '390000';}	
	if ($private_pax == '2'){$harga_private = '260000';}	
	if ($private_pax == '3'){$harga_private = '190000';}	
	if ($private_pax == '4'){$harga_private = '160000';}	

	}
//elseif  ($kdcbg =='8')
	{
	if ($private_pax == '1'){$harga_private = '250000';}	
	if ($private_pax == '2'){$harga_private = '180000';}	
	if ($private_pax == '3'){$harga_private = '150000';}	
	if ($private_pax == '4'){$harga_private = '120000';}	

	}


$tf = (num($harga_private) * num($private_hours));		
}
if (($kode_program_current != $kode_program) and ($nm_level_current != $nm_level))
{
if ($kdcbg == '3' and $type_class =='PRI' and ($nm_program == 'ESP' or $nm_program == 'GE') and	num($private_pax) == 1 and num($private_hours) == 30 ){$tf = '13500000';}	

//if ($kdcbg == '8' and $type_class =='PRI' and $nm_program == 'IELTS' and $nm_level == 'Entrant' and	$private_pax == 4 and $private_hours == 30 ){$tf = '2700000';}		
if ($kdcbg == '2' and $nm_program == 'TOEFL' and $nm_level == 'PBT / TOEIC 12 Hours 3 Pax' ){$tf = '2000000';}	
if ($kdcbg == '2' and $nm_program == 'TOEFL' and $nm_level == 'PBT / TOEIC 12 Hours 1 Pax' ){$tf = '6000000';}		
if ( $type_class =='PRI' and	num($private_pax) == 1 and num($private_hours) == 40 ){$tf = '14500000';}	
if ( $type_class =='PRI' and	num($private_pax) == 1 and num($private_hours) == 40  ){$tf = '14500000';}	
if ( $type_class =='PRI' and	num($private_pax) == 1 and num($private_hours) == 20  ){$tf = '9000000';}		
if ( $type_class =='PRI' and	num($private_pax) == 2 and num($private_hours) == 40 ){$tf = '8500000';}	
if ( $type_class =='PRI' and	num($private_pax) == 3 and num($private_hours) == 40 ){$tf = '6500000';}	
if ( $type_class =='PRI' and	num($private_pax) == 4 and num($private_hours) == 40 ){$tf = '5500000';}	
if ( $type_class =='PRI' and $nm_program == 'NGTOEFL' and ($nm_level == 'Expert 2 Skills' or $nm_level == 'Fundies') and num($private_pax) == 1 and num($private_hours) == 20 ){$tf = '8500000';}	
if ($kdcbg == '8' and $type_class =='PRI' and	num($private_pax) == 1 and num($private_hours) == 40 ){$tf = '7500000';}
if ($kdcbg == '8' and $type_class =='PRI' and	num($private_pax) == 1 and num($private_hours) == 10 and  $nm_level  == 'SDP NGTOEFL - 10 hrs'){$tf = '2500000';}	
if ($kdcbg == '8' and $type_class =='PRI' and	num($private_pax) == 1 and num($private_hours) == 10 and  $nm_level  == 'Expert'){$tf = '2500000';}		
if ($kdcbg != '8' and $type_class =='PRI' and	num($private_pax) == 1 and num($private_hours) == 30 ){$tf = '13500000';}			
$tf_nett = (num($tf) -  num($voucher));	
$tf_nett= num($tf_nett)	-  num((num($tf_nett) * num((num($discount_tf)/100)))) - num($discount_cashback);
}
}
if($nm_program == 'MOVE'){$tf = '5000000';$tf_nett = num($tf) -  num($voucher) -  num((num($tf) * num((num($discount_tf)/100)))) - num($discount_cashback) ;}
$totalinvoice = num($tf_nett) + num($material_fee) + num($reg_fee);
$outstanding = 	num($totalinvoice) - num($ttl_invoiced);
//
}
if($book_status != ''){$buku_pilihan = 1;}else{$buku_pilihan = 0;} 
$st = 0;	
$kd_cbg = in_val('kd_cbg', 'any');
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
  <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../css/font-awesome/css/font-awesome.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="../css/ionicons/css/ionicons.min.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="../plugins/datatables/dataTables.bootstrap.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../dist/css/AdminLTE.min.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="../dist/css/skins/_all-skins.min.css">

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
 
<?php    include __DIR__ . "/left.php";	 ?>
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
                 	      value="<?php echo e($kdb) ?>" hidden="hidden">
<input type="hidden" ang="en-150"   name="enroll_date" 
                 	      value="<?php echo e($enroll_date) ?>" hidden="hidden">
  </span>
  <div class="col-md-8">
    <div class="form-group">
      <label>Address</label>
      <input name="address"  class="form-control"  type="text" size="90" value="<?php echo e($address) . " ".e($city) ?>" />
    </div>
  </div>
  <span class="form-group">
  <input type="text" ang="en-150"   name="st" 
                 	      value="<?php echo e($st) ?>" hidden="hidden" >
  <input type="text" ang="en-150"   name="kd_cbg" 
                 	      value="<?php echo e($kd_cbg) ?>" hidden="hidden" >
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
			        
			        <option selected><?php echo  e($type_class) ?></option>
            </select>
          </div>
	    </div>
  <div class="col-md-3">
    <div class="form-group">
      <label>Program</label>
      <select class="form-control" name="nm_program"  onChange="this.form.submit()">
        <?php
									$query_nm_program = q_set($__p_query_nm_program, "SELECT distinct nm_program FROM ves_data.vip_mst_code_prg WHERE type_program = ? ", [(string) ($type_class)]);
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
								$query_level = q_set($__p_query_level, "SELECT level_program FROM vip_mst_code_prg where nm_program = ? and  type_program = ? ", [(string) ($nm_program), (string) ($type_class)]);
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
							  		<option>Material Handout 300</option> 		  
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
       <?php if ($nm_program !='LC'  ) {?>
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
			<option value= "20">20</option>
			<option value= "10">10</option>		  
    <?php  }
		}
		else 
		{ 
		 	if ($nm_program == 'LC' or $nm_program =='ESP')
			{ ?>
			<option value= "40">40</option>			  
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
			<option value= "6">6</option>		  
			<option value= "12">12</option>
			<option value= "30">30</option>
	<?php   } 
elseif ($nm_program == 'NGTOEFL' and ($nm_level == 'Expert 2 Skills' or $nm_level == 'Fundies') and num($kdcbg) == 3 )
			{ ?>
			<option value= "20">20</option>	
			<option value= "40">40</option>		  
			<option value= "30">30</option>		  
	<?php   } 					
			else 
			{ ?>
			<option value= "40">40</option>		  
			<option value= "30">30</option>
			<option value= "20">20</option>		  
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
	        <option>100000</option>
	        <option>150000</option>	        
	        <option>200000</option>
	        <option>250000</option>
	        <option>300000</option>	        
	        <option>400000</option>	        
	        <option>500000</option>	        
	        <option>700000</option>		        
	        <option>750000</option>		        
	        <option>800000</option>		        	        
	        <option>1000000</option>		        
	        <option>1250000</option>		        
	        
	        <option selected><?php echo  e($voucher) ?></option>
	        </select>
	    </div>
	    </div>
	  <div class="col-md-3">
	    <div class="form-group">
          <label>Discount / Promo / Cash Back</label>
          <select class="form-control" name="nm_promo"  onChange="this.form.submit()">
            <?php
								$query_discount = q_set($__p_query_discount, "SELECT nm_promo FROM ves_data.vip_mst_promo where  kd_branch = ? ", [(string) ($kdcbg)]);
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
            <td align=center class="style24"><?php echo number_format(num($reg_fee),0,".",".")  ?></td>
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
		        <label>Class Code</label>
		        <select class="form-control" name="class_code">
		          <option>Event</option>
		          <?php
	$query_class_available = q_set($__p_query_class_available, "SELECT kelas FROM ves_data.vip_teacher_schedule where kode_program = ? and level_program = ? group by kelas order by kelas", [(string) ($kode_program), (string) ($nm_level)]);
$resource_class_available = db_query_or_die('errro_0', $query_class_available, $__p_query_class_available ?? []);
$keluar_class_available= db_num_rows($resource_class_available);
if(num(db_num_rows($resource_class_available)) > 0)
	{
	while ($row_class_available=  db_fetch($resource_class_available, PDO::FETCH_NUM))
		{
		echo '<option value="'.e($row_class_available[0]).'">'.e($row_class_available[0]).'</option>';		

		}
	}
     ?>
		          <option selected><?php echo  e($class_code_choosen) ?></option>
	            </select>
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
		        <input name="Invoicing" type="submit" id="Invoicing"  class="form-control"  value="Invoicing" />
	          </div>
		      </div>
            <div class="col-md-2">
              <div class="form-group"> <a href="profile_newvip.php?kdb=<?php echo e(u($kdb)) ?>" onClick="window.open('profile_newvip.php?kdb=<?php echo e(u($kdb)) ?>')">
                <input name="Save2" type="submit" id="Save3"  class="form-control"  value="Exit" />
              </a> </div>
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
	$kd_cbg = in_val('kd_cbg', 'any');	
	$bisa = 1;	$branch = $_SESSION['branch'];	$kdb = in_val('kdb', 'any');$kdcbg = $_SESSION['kd_branch'];	$idb = in_val('idb', 'any');		
	$class_code = in_val('class_code', 'any');
	$hari=date("d");$bulan=date("m");$tahun=date("Y");
	$hari_ini = "$tahun-$bulan-$hari";			
		
	if($bulan =='01'){$bln_rom="I";}if($bulan =='02'){$bln_rom="II";}	if($bulan =='03'){$bln_rom="III";}	if($bulan =='04'){$bln_rom="IV";}
	if($bulan =='05'){$bln_rom="V";}	if($bulan =='06'){$bln_rom="VI";}	if($bulan =='07'){$bln_rom="VII";}	if($bulan =='08'){$bln_rom="VIII";}
	if($bulan =='09'){$bln_rom="IX";}	if($bulan =='10'){$bln_rom="X";}	if($bulan =='11'){$bln_rom="XI";}	if($bulan =='12'){$bln_rom="XII";}
		
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
	$query_update_billing= q_set($__p_query_update_billing, "update ves_data.vip_billing set kd_class = ? where kd_billing = ? ", [(string) ($class_code), (string) ($idb)]); 
	$resource_update_billing = db_query_or_die('errro_simpan', $query_update_billing, $__p_query_update_billing ?? []);	
	//if ($amount == 0 ){$bisa = 0;$pesan ="Amount must be not zero";}
	
		echo "<script type=\"text/javascript\">\n";
		echo "alert('VIP Billing Submitted');\n";
		echo "window.location = ('vip_sales_center.php?kd_cbg=" . e(u($kd_cbg)) . "');\n";				
		echo "</script>";
}
if (($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['Print']))) 
	{
	$kd_cbg = in_val('kd_cbg', 'any');	
$kdb = in_val('kdb', 'any');
$idb = in_val('idb', 'any');	
			echo "<script type=\"text/javascript\">\n";
			echo "window.open('../vipbillprint.php?idb=" . e(u($idb)) . "&kdb=" . e(u($kdb)) . "','width=560,height=340,toolbar=0,menubar=0,location=0');\n";				
			echo "</script>";		

	}
?>