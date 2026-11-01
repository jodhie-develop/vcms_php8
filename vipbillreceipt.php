<?php
// Rincian billing + daftar tagihan (Pay/Print). Read-only; form hanya untuk hitung ulang (GET).
include __DIR__ . "/conndb.php";
include __DIR__ . "/profiledata.php";
auth_require_login();
include __DIR__ . "/left.php";
// Variabel yang di versi lama bisa dipakai sebelum diisi (PHP 5: NULL).
$kode_program = '';
$tf = $discount_tf = $discount_rf = $discount_cashback = $tf_nett = $amount = $ttl_invoiced = $ttl_refund = null;
$nik = $student_name = $address = $city = $enroll_date = $nomor = $private_pax = $private_hours = null;
$nama_lengkap = $_SESSION['nama_lengkap']; 
$kdcbg = $_SESSION['kd_branch']; 
$kdb = in_str('kdb', 45);	
$st = in_str('st', 3);
$hari=date("d");
$bulan=date("m");
$bulanan=date("M");

$type_class = in_str('type_class', 45);
$nm_program = in_str('nm_program', 100);
$nm_level = in_str('nm_level', 100);
$material_fee = in_str('material_fee', 20);
$reg_fee = in_str('reg_fee', 20);
$sc = in_str('sc', 100);


$idb = in_str('idb', 45);
if($nm_program !="" and $nm_level !="")
	{		
	$query_kode_program = "SELECT kd_program FROM ves_data.vip_mst_code_prg where nm_program = ? and level_program = ? and type_program = ?";
	$resource_kode_program = db_query($query_kode_program, [$nm_program, $nm_level, $type_class]);
	while ($row_kode_program=  $resource_kode_program->fetch(PDO::FETCH_NUM))
		{
		$kode_program =   $row_kode_program[0];
		}   
	}
//==get price
if ($kdcbg =='00')
	{
$query_price = "SELECT c1 FROM ves_data.vip_mst_price where kd_program = ?";
	}
else
	{
$query_price = "SELECT " . kol_harga($kdcbg) . " FROM ves_data.vip_mst_price where kd_program = ?";	
	}
$resource_price = db_query($query_price, [$kode_program]);
while ($row_price=  $resource_price->fetch(PDO::FETCH_NUM))
	{
	$tf =   $row_price[0];
	} 
$nm_promo = in_str('nm_promo', 100);
if($nm_promo !='')
	{
	$query_promo = "SELECT tf, rf, cashback FROM ves_data.vip_mst_promo where nm_promo = ? and kd_branch = ?";
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


if($tf !="")
	{
	$tf_nett = num($tf) -  (num($tf) * (num($discount_tf)/100)) - num($voucher);	
	}

//==========setting cara bayar
$type_pay = in_str('type_pay', 45);
$old_student = in_str('old_student', 10);

if($type_pay =='Registration' and $old_student !='Yes')
	{
	$query_payment = "SELECT " . kol_harga($kdcbg) . " FROM ves_data.vip_mst_price where kd_program = ?";

	$resource_payment = db_query($query_payment, [$type_pay]);
	while ($row_payment=  $resource_payment->fetch(PDO::FETCH_NUM))
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

$material_book = in_str('material_book', 45);
$old_student = in_str('old_student', 10);
if($st==1)
	{	
	$query_ambil_billing = "SELECT
	b.type_program, b.nm_program, a.level_program, a.kd_program,
	a.material, a.tf, a.voucher, a.discount,a.old_student , a.net_tf,a.kd_billing,a.material_cost,a.old_student,a.kd_biodata,a.sc,a.private_pax, a.private_hours	  FROM ves_data.vip_billing a
	left join ves_data.vip_mst_code_prg b on a.kd_program = b.kd_program where a.kd_billing = ?  ";
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
			
		}  	
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
if ($nm_promo =='Free Registration')	{$reg_fee = 0;}
	
$totalinvoice = num($tf_nett) + num($material_fee) + num($reg_fee);
	
//=========hitung di invoice
$query_invoiced = "SELECT  sum(amount) as ttl FROM ves_data.vip_billing_payment where kd_billing  = ? group by kd_billing";
$resource_invoiced = db_query($query_invoiced, [$idb]);
while ($row_invoiced=  $resource_invoiced->fetch(PDO::FETCH_NUM))
	{
	$ttl_invoiced = $row_invoiced[0];	
	}
$query_refund = "SELECT  sum(amount) as ttl FROM ves_data.vip_billing_refund where kd_billing  = ? group by kd_billing";
$resource_refund = db_query($query_refund, [$idb]);
while ($row_refund=  $resource_refund->fetch(PDO::FETCH_NUM))
	{
	$ttl_refund = $row_refund[0];	
	}

$outstanding = 	num($totalinvoice) - num($ttl_invoiced) + num($ttl_refund);
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
			        <option selected><?php echo e($type_class) ?></option>
            </select>
          </div>
	    </div>
  <div class="col-md-3">
    <div class="form-group">
      <label>Program</label>
      <select class="form-control" name="nm_program" readonly="readonly">
        <?php
									$query_nm_program = "SELECT distinct nm_program FROM ves_data.vip_mst_code_prg WHERE type_program = ?";
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
      <select class="form-control" name="nm_level"   readonly="readonly">
        <?php
								$query_level = "SELECT level_program FROM vip_mst_code_prg where nm_program = ? and  type_program = ? and aktif= 1";
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
  <div class="col-md-6">
			    <div class="form-group">
			      <label>Tuition Fee</label>
			      <input type="text" name="tf_display"  class="form-control" value = "<?php echo number_format((float) $tf,0,".",".")  ?>"  readonly="readonly"/>
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
            <td align=center class="style24"><?php echo number_format((float) $reg_fee,0,".",".")  ?></td>
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
$query_invoice = "SELECT jns_payment, amount, status, dt_payment,no,id_receipt,check_paid,kd_branch FROM ves_data.vip_billing_payment where kd_billing = ?";
$resource_invoice = db_query($query_invoice, [$idb]);
$keluar_invoice = $resource_invoice->rowCount();	
if($resource_invoice->rowCount() > 0)

					if($resource_invoice->rowCount() > 0)
	{
	while ($row_invoice  =  $resource_invoice->fetch(PDO::FETCH_NUM))
		{

		
?>	
                  <tr>
                    <td width="21%" align=center class="style24"><?php echo e($row_invoice[0]) ?></td>
                    <td width="37%" align=center class="style24"><?php echo number_format((float) $row_invoice[1],0,".",".")  ?></td>
                    <td width="27%" align=center class="style24"><?php echo e($row_invoice[5]) ?></td>
                    <td width="15%" align=left class="style24"><?php echo e($row_invoice[3]) ?></td>
					  <td width="15%" align=left class="style24">
					  <?php if ($row_invoice[2]=='unpaid')
						{ ?>
					  <a href="vipbillreceipt_dtl.php?nonew=<?php echo e(u($row_invoice[4])) ?>" 
target="popup" 
onclick="window.open('vipbillreceipt_dtl.php?no=<?php echo e(u($row_invoice[4])) ?>','popup','width=1000,height=800'); return false;">Pay</a><br>
                  <?php } else { ?>
                  <a href="vipreceiptprint.php?no=<?php echo e(u($row_invoice[4])) ?>" 
target="popup" 
onclick="window.open('printable/vipreceiptprint.php?no=<?php echo e(u($row_invoice[4])) ?>','popup','width=1000,height=800'); return false;">Print</a>
<?php } ?>
                   </td>
                    <td width="15%" height="14" align=left class="style24"></td>
                  </tr>
  <?php 
$nomor = num($nomor) + 1;}} 

 ?>
                <tfoot>
                </tfoot>
                
              </table>	
    </div>
    <div class="col-md-8">
    	<div class="form-group">
    		<label>Outstanding : <?php echo number_format((float) $outstanding,0,".",".")  ?></label>
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
