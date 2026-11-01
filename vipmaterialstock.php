<?php
require_once __DIR__ . "/_lib/bootstrap.php"; csrf_guard_get(); auth_require_login(); 
include __DIR__ . "/conndb.php";
include __DIR__ . "/profiledata.php";
$nama_lengkap = $_SESSION['nama_lengkap']; 
$kdcbg = $_SESSION['kd_branch']; 
$kdb = in_val('kdb', 'any');
$st = in_val('st', 'any');
$hari=date("d");
$bulan=date("m");
$bulanan=date("M");

$type_class = in_val('type_class', 'any');
$nm_program = in_val('nm_program', 'any');
$nm_level = in_val('nm_level', 'any');
$material_fee = in_val('material_fee', 'any');
$reg_fee = in_val('reg_fee', 'any');
$sc = in_val('sc', 'any');
$material_book = in_val('material_book', 'any');
$idb = in_val('idb', 'any');
if ($type_class != 'WORKSHOP')
	{
	if($nm_program !="" and $nm_level !="")
		{
		$query_kode_program = q_set($__p_query_kode_program, "SELECT kd_program FROM ves_data.vip_mst_code_prg where nm_program = ? and level_program = ? and type_program = ? ", [(string) ($nm_program), (string) ($nm_level), (string) ($type_class)]);			
		$resource_kode_program = db_query_or_die('errro_71', $query_kode_program, $__p_query_kode_program ?? []);
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

	$resource_kode_program = db_query_or_die('errro_72', $query_kode_program, $__p_query_kode_program ?? []);
	while ($row_kode_program=  db_fetch($resource_kode_program, PDO::FETCH_NUM))
		{
		$kode_program =   $row_kode_program[0];
		}   
	}		

//==get price
$query_price = q_set($__p_query_price, "SELECT " . kol_harga($kdcbg) . " FROM ves_data.vip_mst_price where kd_program = ? ", [(string) ($kode_program)]);

$resource_price = db_query_or_die('errro_73', $query_price, $__p_query_price ?? []);
while ($row_price=  db_fetch($resource_price, PDO::FETCH_NUM))
	{
	$tf =   $row_price[0];
	} 
$private_hours = in_val('private_hours', 'any');
$private_pax = in_val('private_pax', 'any');
$nm_promo = in_val('nm_promo', 'any');
if($nm_promo !='')
	{
	$query_promo = q_set($__p_query_promo, "SELECT tf, rf, cashback FROM ves_data.vip_mst_promo where nm_promo = ? and kd_branch = ? ", [(string) ($nm_promo), (string) ($kdcbg)]);
	$resource_promo = db_query_or_die('errro_74', $query_promo, $__p_query_promo ?? []);
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


if($tf !="")
	{
	$tf_nett = num($tf) -  num((num($tf) * num((num($discount_tf)/100)))) - num($voucher);	
	}
if($tf_nett =='') {$tf_nett = in_val('tf_nett', 'any');}
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
	$resource_dp_ins = db_query_or_die('errro_7', $query_dp_ins, $__p_query_dp_ins ?? []);
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


$old_student = in_val('old_student', 'any');
if(num($st)==1)
	{	
	$query_ambil_billing = q_set($__p_query_ambil_billing, "SELECT\r
\tb.type_program, b.nm_program, b.level_program, a.kd_program,\r
\ta.material, a.tf, a.voucher, a.discount,a.old_student , a.net_tf,a.kd_billing,a.material_cost,a.old_student,a.kd_biodata,a.sc,a.private_pax, a.private_hours,kd_class\t  FROM ves_data.vip_billing a\r
\tleft join ves_data.vip_mst_code_prg b on a.kd_program = b.kd_program and a.level_program = b.level_program where a.kd_billing = ? ", [(string) ($idb)]);
	$resource_ambil_billing = db_query_or_die('errro_7', $query_ambil_billing, $__p_query_ambil_billing ?? []);
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
		$kd_class = $row_ambil_billing[17];	
			
		} 	
	}
$st = 0;


if ($material_book !='No')
	{
	$query_material = q_set($__p_query_material, "SELECT " . kol_harga($kdcbg) . " FROM ves_data.vip_mst_price where kd_program = ? ", [(string) ($material_book)]);
	$resource_material = db_query_or_die('errro_71', $query_material, $__p_query_material ?? []);
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

//=========hitung di invoice
$query_invoiced = q_set($__p_query_invoiced, "SELECT  sum(amount) as ttl FROM ves_data.vip_billing_payment where kd_billing  = ? group by kd_billing", [(string) ($idb)]);
$resource_invoiced = db_query_or_die('errro_71', $query_invoiced, $__p_query_invoiced ?? []);
while ($row_invoiced=  db_fetch($resource_invoiced, PDO::FETCH_NUM))
	{
	$ttl_invoiced = $row_invoiced[0];	
	}

//==== harga private

if ($kdcbg =='1' or $kdcbg=='2' or $kdcbg=='4' or $kdcbg=='5' or $kdcbg=='6')
	{
	if ($private_pax == '1'){$harga_private = '390000';}	
	if ($private_pax == '2'){$harga_private = '260000';}	
	if ($private_pax == '3'){$harga_private = '190000';}	
	if ($private_pax == '4'){$harga_private = '160000';}	

	}
else
	{
	if ($private_pax == '1'){$harga_private = '370000';}	
	if ($private_pax == '2'){$harga_private = '240000';}	
	if ($private_pax == '3'){$harga_private = '170000';}	
	if ($private_pax == '4'){$harga_private = '150000';}		
	}
//================
if($type_class == 'PRI')
{
	$tf = (num($harga_private) * num($private_hours)); 
	$tf_nett = num($tf) -  num((num($tf) * num((num($discount_tf)/100)))) - num($voucher);
}
$totalinvoice = num($tf_nett) + num($material_fee) + num($reg_fee);
$outstanding = 	num($totalinvoice) - num($ttl_invoiced);
//
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>AdminLTE 2 | General Form Elements</title>
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
</head>
<body class="hold-transition skin-blue sidebar-mini">

  <!-- Left side column. contains the logo and sidebar -->
  
<?php //    include __DIR__ . "/left.php";	 ?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
     <div class="box box-warning">
<div class="box-body">
	<h3>VIP Material Check List</h3>
	<h5>Billing Number : <?php echo e($idb) ?></h5>
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
    <div class="form-group"><br>
  
      <input type="text" ang="en-150"   name="material_fee" 
                 	      value="<?php echo e($material_fee) ?>" hidden="hidden" >
      <input type="text" ang="en-150"   name="reg_fee" 
                 	      value="<?php echo e($reg_fee) ?>" hidden="hidden" >
      <input type="text" ang="en-150"   name="kd_class" 
                 	      value="<?php echo e($kd_class) ?>" hidden="hidden" >
    </div>
  </div>
  <span class="form-group">
  <input type="text" ang="en-150" name="kdb" 
                 	      value="<?php echo e($kdb) ?>" hidden="hidden">
<input type="text" ang="en-150"   name="enroll_date" 
                 	      value="<?php echo e($enroll_date) ?>" hidden="hidden">
  </span><span class="form-group">
  <input type="text" ang="en-150"   name="st" 
                 	      value="<?php echo e($st) ?>" hidden="hidden" >
  </span><span class="form-group">
  <input type="text" ang="en-150"   name="idb"  hidden="hidden" 
                 	      value="<?php echo e($idb) ?>" >
  </span></div>
	  </div>
<div class="box box-warning">		
<div class="box-body">
  <div class="col-md-12">
    <div class="form-group">
      <label>PROGRAM TAKEN</label>
    </div>
  </div>
  <div class="col-md-3">
    <div class="form-group">
      <label>Code</label>
      <input type="text" ang="en-150" class="form-control"  placeholder="Enter ..." name="kode_program" 
                 	      value="<?php echo e($kode_program) ?>" readonly>
    </div>
  </div>
  <div class="col-md-3">
    <div class="form-group">
      <label>Program</label>
      <select class="form-control" name="nm_program"  readonly>

        <option selected><?php echo  e($nm_program) ?></option>
      </select>
    </div>
</div>
  <div class="col-md-3">
    <div class="form-group">
      <label>Level</label>
      <select class="form-control" name="nm_level"  readonly>

        <option selected><?php echo  e($nm_level) ?></option>
      </select>
    </div>
  </div>
  <?php //==== 
if ($type_class == 'PRI')
{
	?>
 <?php }//==== ?>
</div>
	  </div>
<div class="box box-warning">
  <div class="box-body">
    <div class="col-md-12">
      <div class="form-group">
        <label>MATERIAL CHECK</label>
      </div>
    </div>
    <div class="col-md-3">
      <div class="form-group">
        <label>
          <input type="checkbox" value="Notebook" name="material_1">
          Notebook</label>
      </div>
    </div>
    <div class="col-md-3">
      <div class="form-group">
        <label>
          <input type="checkbox" value="Pen" name="material_2">
          Pen</label>
      </div>
    </div>
    <div class="col-md-3">
      <div class="form-group">
        <label>
          <input type="checkbox" value="Bag" name="material_3">
          Bag</label></div>
    </div>
    <div class="col-md-3">
      <div class="form-group">
        <label>
          <input type="checkbox" value="Other" name="material_4">
          Material 4</label>
      </div>
    </div>
    <?php //==== 
if ($type_class == 'PRI')
{
	?>
    <?php }//==== ?>
    <input type="text" name="textfield" id="textfield4" value="<?php echo e($tf) ?>" hidden="hidden" >
    <div class="col-md-4">
      <div class="form-group">
        <label>Material Book Taken</label>
        <select class="form-control" name="book_title">
          <?php
									$query_book_title = q_set($__p_query_book_title, "select buku FROM ves_data.vip_mst_code_prg where nm_program = ? and level_program like ? group by buku", [(string) ($nm_program), (string) ($nm_level) . "%"]);
		  
								$resource_book_title = db_query_or_die('errro_d7', $query_book_title, $__p_query_book_title ?? []);
								while ($row_book_title=  db_fetch($resource_book_title, PDO::FETCH_NUM))
									{
							  		echo '<option value="'.e($row_book_title[0]).'">'.e($row_book_title[0]).'</option>';
							  		}      ?>
          <option selected><?php echo  e($book_title) ?></option>
        </select>
      </div>
    </div>
    <input type="hidden" name="textfield" id="textfield5" value="<?php echo e($tf_nett) ?>">
    <input type="text" name="textfield" id="textfield6" value="<?php echo e($discount_tf) ?>" hidden="">
  </div>
</div>
<div class="box box-warning">
	  <div class="box-body">
	    <div class="col-md-6">
	      <div class="form-group">
		        <label>SC Name</label>
		        <select class="form-control" name="sc">
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
          	        <?php if ($idb !='')
{?>
   	          <?php }?>
		    
		    <div class="col-md-2">
		      <div class="form-group">
	        <a href="vip_sales_center.php" onClick="window.open('vip_sales_center.php')"> 
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
		

	
	$bisa = 1;		$kdb = in_val('kdb', 'any');$kdcbg = $_SESSION['kd_branch'];	$idb = in_val('idb', 'any');		
		
	$hari=date("d");$bulan=date("m");$tahun=date("Y");
	$hari_ini = "$tahun-$bulan-$hari";			
	$material_1 = 	in_val('material_1', 'any');
	$material_2 = 	in_val('material_2', 'any');
	$material_3 = 	in_val('material_3', 'any');
	$material_4 = 	in_val('material_4', 'any');		
	$kode_program = in_val('kode_program', 'any');	
	$sc = in_val('sc', 'any');		
	$book_title = in_val('book_title', 'any');
	$kd_class = in_val('kd_class', 'any');		
	if($material_1 !='')
		{
		$query_cek = q_set($__p_query_cek, "select material from ves_data.vip_student_material where kd_billing = ? and kd_biodata = ? and material = ? ", [(string) ($idb), (string) ($kdb), (string) ($material_1)]);
		$resource_cek= db_query_or_die('errro_8', $query_cek, $__p_query_cek ?? []);
		$keluar_cek= db_num_rows($resource_cek);
		if(num(db_num_rows($resource_cek)) == 0)
			{
			$query_simpan_billing= q_set($__p_query_simpan_billing, "insert into ves_data.vip_student_material \r
\t\t\t(kd_branch, kd_billing, kd_biodata, kd_program,  material, pic, dt_received) \r
\t\t\tvalues (? ,? ,? ,? ,? ,? ,? )", [(string) ($kdcbg), (string) ($idb), (string) ($kdb), (string) ($kode_program), (string) ($material_1), (string) ($sc), (string) ($hari_ini)]);
			$resource_simpan_billing = db_query_or_die('errro_simpan1', $query_simpan_billing, $__p_query_simpan_billing ?? []);					
			}
		}
	if($material_2 !='')
		{
		$query_cek = q_set($__p_query_cek, "select material from ves_data.vip_student_material where kd_billing = ? and kd_biodata = ? and material = ? ", [(string) ($idb), (string) ($kdb), (string) ($material_2)]);
		$resource_cek= db_query_or_die('errro_8', $query_cek, $__p_query_cek ?? []);
		$keluar_cek= db_num_rows($resource_cek);
		if(num(db_num_rows($resource_cek)) == 0)
			{
			$query_simpan_billing= q_set($__p_query_simpan_billing, "insert into ves_data.vip_student_material \r
\t\t\t(kd_branch, kd_billing, kd_biodata, kd_program,  material, pic, dt_received) \r
\t\t\tvalues (? ,? ,? ,? ,? ,? ,? )", [(string) ($kdcbg), (string) ($idb), (string) ($kdb), (string) ($kode_program), (string) ($material_2), (string) ($sc), (string) ($hari_ini)]);
			$resource_simpan_billing = db_query_or_die('errro_simpan2', $query_simpan_billing, $__p_query_simpan_billing ?? []);					
			}	
		}
	if($material_3 !='')
		{
		$query_cek = q_set($__p_query_cek, "select material from ves_data.vip_student_material where kd_billing = ? and kd_biodata = ? and material = ? ", [(string) ($idb), (string) ($kdb), (string) ($material_3)]);
		$resource_cek= db_query_or_die('errro_8', $query_cek, $__p_query_cek ?? []);
		$keluar_cek= db_num_rows($resource_cek);
		if(num(db_num_rows($resource_cek)) == 0)
			{
			$query_simpan_billing= q_set($__p_query_simpan_billing, "insert into ves_data.vip_student_material \r
\t\t\t(kd_branch, kd_billing, kd_biodata, kd_program,  material, pic, dt_received) \r
\t\t\tvalues (? ,? ,? ,? ,? ,? ,? )", [(string) ($kdcbg), (string) ($idb), (string) ($kdb), (string) ($kode_program), (string) ($material_3), (string) ($sc), (string) ($hari_ini)]);
			$resource_simpan_billing = db_query_or_die('errro_simpan3', $query_simpan_billing, $__p_query_simpan_billing ?? []);					
			}
		}
	if($material_4 !='')
		{
		$query_cek = q_set($__p_query_cek, "select material from ves_data.vip_student_material where kd_billing = ? and kd_biodata = ? and material = ? ", [(string) ($idb), (string) ($kdb), (string) ($material_4)]);
		$resource_cek= db_query_or_die('errro_8', $query_cek, $__p_query_cek ?? []);
		$keluar_cek= db_num_rows($resource_cek);
		if(num(db_num_rows($resource_cek)) == 0)
			{
			$query_simpan_billing= q_set($__p_query_simpan_billing, "insert into ves_data.vip_student_material \r
\t\t\t(kd_branch, kd_billing, kd_biodata, kd_program,  material, pic, dt_received) \r
\t\t\tvalues (? ,? ,? ,? ,? ,? ,? )", [(string) ($kdcbg), (string) ($idb), (string) ($kdb), (string) ($kode_program), (string) ($material_1), (string) ($sc), (string) ($hari_ini)]);
			$resource_simpan_billing = db_query_or_die('errro_simpan1', $query_simpan_billing, $__p_query_simpan_billing ?? []);					
			}	
		}
	if($book_title !='')
		{
		$query_cek = q_set($__p_query_cek, "select material from ves_data.vip_student_material where kd_billing = ? and kd_biodata = ? and material like 'Book%' ", [(string) ($idb), (string) ($kdb)]);
		$resource_cek= db_query_or_die('errro_8', $query_cek, $__p_query_cek ?? []);
		$keluar_cek= db_num_rows($resource_cek);
		if(num(db_num_rows($resource_cek)) == 0)
			{			
			$query_simpan_billing= q_set($__p_query_simpan_billing, "insert into ves_data.vip_student_material \r
\t\t\t(kd_branch, kd_billing, kd_biodata, kd_program,  material, pic, dt_received)\r
\t\t\tvalues (? ,? ,? ,? ,? ,? ,? )", [(string) ($kdcbg), (string) ($idb), (string) ($kdb), (string) ($kode_program), "Book " . (string) ($book_title), (string) ($sc), (string) ($hari_ini)]);
			$resource_simpan_billing = db_query_or_die('errro_simpan', $query_simpan_billing, $__p_query_simpan_billing ?? []);	
			}
		}		
		echo "<script type=\"text/javascript\">\n";
		echo "alert('VIP Material  Submitted');\n";
		echo "window.location = ('vip_class_student_list.php?kdcl=" . e(u($kd_class)) . "&kdprg=" . e(u($kode_program)) . "');\n";		
		echo "</script>";
		}
	
?>