<?php
require_once __DIR__ . "/_lib/bootstrap.php"; auth_require_login(); 
include __DIR__ . "/conndb.php";
include __DIR__ . "/profiledata.php";
include __DIR__ . "/left.php";
$nama_lengkap = $_SESSION['nama_lengkap']; 
$kdcbg = $_SESSION['kd_branch']; 
$kdb = in_val('kdb', 'get');	
$st = in_val('st', 'get');
$hari=date("d");
$bulan=date("m");
$bulanan=date("M");

$type_class = in_val('type_class', 'get');
$nm_program = in_val('nm_program', 'get');
$nm_level = in_val('nm_level', 'get');
$material_fee = in_val('material_fee', 'get');
$reg_fee = in_val('reg_fee', 'get');
$sc = in_val('sc', 'get');


$idb = in_val('idb', 'get');
if($nm_program !="" and $nm_level !="")
	{		
	$query_kode_program = q_set($__p_query_kode_program, "SELECT kd_program FROM ves_data.vip_mst_code_prg where nm_program = ? and level_program = ? and type_program = ? ", [(string) ($nm_program), (string) ($nm_level), (string) ($type_class)]);
	$resource_kode_program = db_query_or_die('errro_71', $query_kode_program, $__p_query_kode_program ?? []);
	while ($row_kode_program=  db_fetch($resource_kode_program, PDO::FETCH_NUM))
		{
		$kode_program =   $row_kode_program[0];
		}   
	}
//==get price
if ($kdcbg =='00')
	{
$query_price = q_set($__p_query_price, "SELECT c1 FROM ves_data.vip_mst_price where kd_program = ? ", [(string) ($kode_program)]);
	}
else
	{
$query_price = q_set($__p_query_price, "SELECT " . kol_harga($kdcbg) . " FROM ves_data.vip_mst_price where kd_program = ? ", [(string) ($kode_program)]);	
	}
$resource_price = db_query_or_die('errro_72', $query_price, $__p_query_price ?? []);
while ($row_price=  db_fetch($resource_price, PDO::FETCH_NUM))
	{
	$tf =   $row_price[0];
	} 
$nm_promo = in_val('nm_promo', 'get');
if($nm_promo !='')
	{
	$query_promo = q_set($__p_query_promo, "SELECT tf, rf, cashback FROM ves_data.vip_mst_promo where nm_promo = ? and kd_branch = ? ", [(string) ($nm_promo), (string) ($kdcbg)]);
	$resource_promo = db_query_or_die('errro_73', $query_promo, $__p_query_promo ?? []);
	while ($row_promo=  db_fetch($resource_promo, PDO::FETCH_NUM))
		{
		$discount_tf =   $row_promo[0];
		$discount_rf =   $row_promo[1];
		$discount_cashback =   $row_promo[2];
		}		
	}
$voucher = in_val('voucher', 'get');
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

//==========setting cara bayar
$type_pay = in_val('type_pay', 'get');
$old_student = in_val('old_student', 'get');

if($type_pay =='Registration' and $old_student !='Yes')
	{
	$query_payment = q_set($__p_query_payment, "SELECT " . kol_harga($kdcbg) . " FROM ves_data.vip_mst_price where kd_program = ? ", [(string) ($type_pay)]);

	$resource_payment = db_query_or_die('errro_71', $query_payment, $__p_query_payment ?? []);
	while ($row_payment=  db_fetch($resource_payment, PDO::FETCH_NUM))
		{
		$amount =   $row_payment[0];
		//$reg_fee = 	  $row_payment[0];	
		}		
	}
elseif($type_pay =='Registration' and $old_student =='Yes')
	{
		$amount = '0';
	}
elseif ($type_pay =='Material')
	{
	$amount='300000';		
	}
elseif ($type_pay =='Full Payment')
	{
	$amount= $tf_nett;		
	}
elseif ($type_pay =='Installment 1')
	{
	$amount= $tf_nett;		
	}
else
	{
	$amount='0';	
	}

$material_book = in_val('material_book', 'get');
$old_student = in_val('old_student', 'get');
if(num($st)==1)
	{	
	$query_ambil_billing = q_set($__p_query_ambil_billing, "SELECT\r
\tb.type_program, b.nm_program, a.level_program, a.kd_program,\r
\ta.material, a.tf, a.voucher, a.discount,a.old_student , a.net_tf,a.kd_billing,a.material_cost,a.old_student,a.kd_biodata,a.sc,a.private_pax, a.private_hours\t  FROM ves_data.vip_billing a\r
\tleft join ves_data.vip_mst_code_prg b on a.kd_program = b.kd_program where a.kd_billing = ?  ", [(string) ($idb)]);
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
			
		}  	
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
if ($nm_promo =='Free Registration')	{$reg_fee = 0;}
	
$totalinvoice = num($tf_nett) + num($material_fee) + num($reg_fee);
	
//=========hitung di invoice
$query_invoiced = q_set($__p_query_invoiced, "SELECT  sum(amount) as ttl FROM ves_data.vip_billing_payment where kd_billing  = ? group by kd_billing", [(string) ($idb)]);
$resource_invoiced = db_query_or_die('errro_71', $query_invoiced, $__p_query_invoiced ?? []);
while ($row_invoiced=  db_fetch($resource_invoiced, PDO::FETCH_NUM))
	{
	$ttl_invoiced = $row_invoiced[0];	
	}
$query_refund = q_set($__p_query_refund, "SELECT  sum(amount) as ttl FROM ves_data.vip_billing_refund where kd_billing  = ? group by kd_billing", [(string) ($idb)]);
$resource_refund = db_query_or_die('errro_71', $query_refund, $__p_query_refund ?? []);
while ($row_refund=  db_fetch($resource_refund, PDO::FETCH_NUM))
	{
	$ttl_refund = $row_refund[0];	
	}

$outstanding = 	num($totalinvoice) - num($ttl_invoiced) + num($ttl_refund);
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

<form name="myform" id="myform">

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
      <input type="text" ang="en-150"   name="material_fee" 
                 	      value="<?php echo e($material_fee) ?>" hidden="hidden" >
      <input type="text" ang="en-150"   name="reg_fee" 
                 	      value="<?php echo e($reg_fee) ?>" hidden="hidden" >
    </div>
  </div>
  <span class="form-group">
  <input type="text" ang="en-150" name="kdb" 
                 	      value="<?php echo e($kdb) ?>" hidden="hidden">
<input type="text" ang="en-150"   name="enroll_date" 
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
  <input type="text" ang="en-150"   name="idb" 
                 	      value="<?php echo e($idb) ?>" hidden="hidden" >
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
	        <select class="form-control" name="type_class"  readonly="readonly">
			        <option>REG</option>
			        <option>PRI</option>
			        <option selected><?php echo  e($type_class) ?></option>
            </select>
          </div>
	    </div>
  <div class="col-md-3">
    <div class="form-group">
      <label>Program</label>
      <select class="form-control" name="nm_program" readonly="readonly">
        <?php
									$query_nm_program = q_set($__p_query_nm_program, "SELECT distinct nm_program FROM ves_data.vip_mst_code_prg WHERE type_program = ? ", [(string) ($type_class)]);
								$resource_nm_program = db_query_or_die('errro_75', $query_nm_program, $__p_query_nm_program ?? []);
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
      <select class="form-control" name="nm_level"   readonly="readonly">
        <?php
								$query_level = q_set($__p_query_level, "SELECT level_program FROM vip_mst_code_prg where nm_program = ? and  type_program = ? and aktif= 1", [(string) ($nm_program), (string) ($type_class)]);
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
  <div class="col-md-6">
			    <div class="form-group">
			      <label>Tuition Fee</label>
			      <input type="text" name="tf_display"  class="form-control" value = "<?php echo number_format(num($tf),0,".",".")  ?>"  readonly="readonly"/>
	      </div>
      </div>
	  <input type="text" name="tf" id="textfield" value="<?php echo e($tf) ?>" hidden="hidden" >
	  <input type="text" name="tf_nett" id="textfield2" value="<?php echo e($tf_nett) ?>" hidden="">
      <input type="text" name="discount_tf" id="textfield3" value="<?php echo e($discount_tf) ?>" hidden="">
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
$query_invoice = q_set($__p_query_invoice, "SELECT jns_payment, amount, status, dt_payment,no,id_receipt,check_paid,kd_branch FROM ves_data.vip_billing_payment where kd_billing = ? ", [(string) ($idb)]);
$resource_invoice = db_query_soft($query_invoice, $__p_query_invoice ?? []);
$keluar_invoice = db_num_rows($resource_invoice);	
if(num(db_num_rows($resource_invoice)) > 0)

					if(num(db_num_rows($resource_invoice)) > 0)
	{
	while ($row_invoice  =  db_fetch($resource_invoice, PDO::FETCH_NUM))
		{

		
?>	
                  <tr>
                    <td width="21%" align=center class="style24"><?php echo e($row_invoice[0]) ?></td>
                    <td width="37%" align=center class="style24"><?php echo number_format(num($row_invoice[1]),0,".",".")  ?></td>
                    <td width="27%" align=center class="style24"><?php echo e($row_invoice[5]) ?></td>
                    <td width="15%" align=left class="style24"><?php echo e($row_invoice[3]) ?></td>
					  <td width="15%" align=left class="style24">
					  <?php if ($row_invoice[2]=='unpaid')
						{ ?>
					  <a href="vipbillreceipt_dtl.php?nonew=<?php echo e(u($row_invoice[4])); ?>" 
target="popup" 
onclick="window.open('vipbillreceipt_dtl.php?no=<?php echo e(u($row_invoice[4])); ?>','popup','width=1000,height=800'); return false;">Pay</a><br>
                  <?php } else { if( $row_invoice[7] !='15') { ?>
                  <a href="vipreceiptprint.php?no=<?php echo e(u($row_invoice[4])); ?>" 
target="popup" 
onclick="window.open('printable/vipreceiptprint.php?no=<?php echo e(u($row_invoice[4])); ?>','popup','width=1000,height=800'); return false;">Print</a>
                  <?php }else { if(num($row_invoice[6])==1){?>
 <a href="vipreceiptprint.php?no=<?php echo e(u($row_invoice[4])); ?>" 
target="popup" 
onclick="window.open('printable/vipreceiptprint.php?no=<?php echo e(u($row_invoice[4])); ?>','popup','width=1000,height=800'); return false;">Print</a>						  
						  <?php  }else { echo "Waiting"; }}} ?>
                   </td>
                    <td width="15%" height="14" align=left class="style24"></td>
                  </tr>
  <?php 
$nomor = num($nomor)+1;}} 

 ?>
                <tfoot>
                </tfoot>
                
              </table>	
    </div>
    <div class="col-md-8">
    	<div class="form-group">
    		<label>Outstanding : <?php echo number_format(num($outstanding),0,".",".")  ?></label>
    	</div>
	</div>
</div>
		</div>
		<div class="box box-warning"></div>
  </div>
<div class="box-body"></div>
<div class="box-body"></div>
</form>
</body>
</html>
