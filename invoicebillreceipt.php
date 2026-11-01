<?php
require_once __DIR__ . "/_lib/bootstrap.php"; csrf_guard_get(); auth_require_login(); 
include __DIR__ . "/conndb.php";
include __DIR__ . "/profiledata.php";
include __DIR__ . "/left.php";
$test = in_val('test', 'any');
if (num($test) ==1){$payment_form = 'Test Bakat Minat';}
elseif (num($test) ==2){$payment_form = 'IELTS International Test';}
elseif (num($test) ==3){$payment_form = 'TOEFL Ibt International Test';}
elseif (num($test) ==4){$payment_form = 'NCUK';}
$st_reg = 0;$st_admin = 0;$st_tf = 0;
$nama_lengkap = $_SESSION['nama_lengkap']; 
$kdcbg = $_SESSION['kd_branch']; 
$id_billing = in_val('idb', 'any');
$payment_for = in_val('payment_for', 'any');
$registration = in_val('registration', 'any');
$reg_discount = in_val('reg_discount', 'any');
$admin_fee = in_val('admin_fee', 'any');
$admin_discount = in_val('admin_discount', 'any');
$nominal = in_val('nominal', 'any');
$nominal_discount = in_val('nominal_discount', 'any');
$remark = in_val('remark', 'any');
$judulinvoice = $payment_for;	
if ($payment_for =='Test Bakat Minat'){$nominal ='600000';}
$hari=date("d");
$bulan=date("m");
$bulanan=date("M");
$tahun=date("Y");
$tgl_hari_ini =  "$tahun-$bulan-$hari";
//get data stu
$query_billing = q_set($__p_query_billing, "SELECT t.id_billing, t.kd_biodata, t.nama_lengkap, t.keterangan,t.reg_amount, t.admin_amount , t.nominal, t.kd_branch,t.kd_biodata,additional_fee,nominal_discount  FROM ves_data.tb_invoice t where id_billing = ? ", [(string) ($id_billing)]);

$resource_billing = db_query_or_die('errro_last_billing', $query_billing, $__p_query_billing ?? []);
if(num(db_num_rows($resource_billing)) > 0)
	{
	while ($row_billing=  db_fetch($resource_billing, PDO::FETCH_NUM))
		{
		$id_billing = $row_billing[0];	
		$kd_biodata = $row_billing[1];	
	


		
		
		
		
		$nama_student = $row_billing[2];	
		$keterangan = $row_billing[3];	
		$reg_amount = $row_billing[4];if(num($reg_amount) == 0 or $reg_amount ==''){$st_reg = 1;}
		$admin_amount = $row_billing[5];if(num($admin_amount) == 0 or $admin_amount ==''){$st_admin = 1;}	
		$tf_amount = $row_billing[6]; 
		$kd_branch = $row_billing[7];
		$add_tbi = $row_billing[9];		
		$nominal_discount = $row_billing[10];$tf_amount = num($tf_amount) - num($nominal_discount);		
		
		}
	}
$query_reg = q_set($__p_query_reg, "SELECT id_invoice,pay_mtd,dt_payment,id,pic FROM ves_data.tb_invoice_paid where id_billing = ? and keterangan_dtl = 'Registration'", [(string) ($id_billing)]);
$resource_reg = db_query_or_die('errro_last_billing', $query_reg, $__p_query_reg ?? []);
if(num(db_num_rows($resource_reg)) > 0)
	{
	while ($row_reg=  db_fetch($resource_reg, PDO::FETCH_NUM))
		{
		$st_reg = 1;
		$reg_pay_mtd = $row_reg[1];
		$reg_dt_payment = $row_reg[2];
		$reg_id = $row_reg[3];	
		$reg_pic = $row_reg[4];			
		}
	}
$query_reg = q_set($__p_query_reg, "SELECT id_invoice,pay_mtd,dt_payment,id FROM ves_data.tb_invoice_paid where id_billing = ? and keterangan_dtl = 'Administration'", [(string) ($id_billing)]);
$resource_reg = db_query_or_die('errro_last_billing', $query_reg, $__p_query_reg ?? []);
if(num(db_num_rows($resource_reg)) > 0)
	{
	while ($row_reg=  db_fetch($resource_reg, PDO::FETCH_NUM))
		{
		$st_admin = 1;
		$admin_pay_mtd = $row_reg[1];
		$admin_dt_payment = $row_reg[2];
		$admin_id = $row_reg[3];			
		}
	}
//

$query_reg = q_set($__p_query_reg, "SELECT id_invoice,pay_mtd,dt_payment,id FROM ves_data.tb_invoice_paid where id_billing = ? and keterangan_dtl = 'Tuition Fee'", [(string) ($id_billing)]);

$resource_reg = db_query_or_die('errro_last_billing', $query_reg, $__p_query_reg ?? []);
if(num(db_num_rows($resource_reg)) > 0)
	{
	while ($row_reg=  db_fetch($resource_reg, PDO::FETCH_NUM))
		{
		$st_tf = 1;
		$tf_pay_mtd = $row_reg[1];
		$tf_dt_payment = $row_reg[2];
		$tf_id = $row_reg[3];			
		}
	}
//
$query_reg = q_set($__p_query_reg, "SELECT id_invoice,pay_mtd,dt_payment,id FROM ves_data.tb_invoice_paid where id_billing = ? and keterangan_dtl = 'Addtional Fee'", [(string) ($id_billing)]);

$resource_reg = db_query_or_die('errro_last_billing', $query_reg, $__p_query_reg ?? []);
if(num(db_num_rows($resource_reg)) > 0)
	{
	while ($row_reg=  db_fetch($resource_reg, PDO::FETCH_NUM))
		{
		$st_tbi_add_fee = 1;
		$add_tbi_mtd = $row_reg[1];
		$add_tbi_date = $row_reg[2];
		$add_tbi_id = $row_reg[3];		
		}
	}


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
	<h3><?php echo e($judulinvoice) ?></h3>
	<h5>Billing  Number : <?php echo e($kd_billing) ?></h5>
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
                 	      value="<?php echo e($nama_student) ?>" readonly>
    </div>
  </div>
  <div class="col-md-3">
    <div class="form-group">
      <label>Detail</label><br>
      <a href="callstudent.php?asal=1"  class="btn btn-primary btn-md"> Cari</a>
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
  </span><span class="form-group">
  <input type="text" ang="en-150"   name="id_billing" 
                 	      value="<?php echo e($id_billing) ?>" hidden="hidden" >
  </span><span class="form-group">
  <input type="text" ang="en-150"   name="payment_for" 
                 	      value="<?php echo e($keterangan) ?>">
  <input type="hidden" ang="en-150"   name="idb" 
                 	      value="<?php echo e($idb) ?>" >
  </span><span class="form-group">
  <input type="text" ang="en-150"  name="kd_biodata" 
                 	      value="<?php echo e($kd_biodata) ?>" hidden="hidden">
  </span><span class="form-group">
  <input type="text" ang="en-150"  name="reg_id" 
                 	      value="<?php echo e($reg_id) ?>" hidden="hidden">
  </span><span class="form-group">
  <input type="text" ang="en-150"  name="admin_id" 
                 	      value="<?php echo e($admin_id) ?>" hidden="hidden">
  </span><span class="form-group">
  <input type="text" ang="en-150"  name="tf_id" 
                 	      value="<?php echo e($tf_id) ?>" hidden="hidden">
  </span></div>
    </div>
<div class="box box-warning">		
<div class="box-body">
  <div class="col-md-12">
    <div class="form-group">
      <label> INFO</label>
    </div>
  </div>
  <div class="col-md-3">
    <div class="form-group">
      <label>Payment For
    : <?php echo e($keterangan) ?> </label></div>
  </div>
    <div class="col-md-12">	
  <div class="col-md-2">
    <div class="form-group">
      <label>Registration</label>
      <input type="text" name="reg_amount"  class="form-control" value = "<?php echo e($reg_amount) ?>" readonly> 
    </div>
  </div>
		
  <div class="col-md-2">
    <div class="form-group">
      <label>Payment Metodh</label>
      <select name="reg_mtd"  id="jns_report2" class="form-control" >
        <option value="Debit Card">Debit Card</option>
        <option value="Credit Card">Credit Card</option>
        <option value="Cash">Cash</option>
        <option value="Transfer">Transfer</option>
        <option value="Cek-Bg">Cek-Bg</option>
        <option value="Voucher">Voucher</option>
        <option value="Dana Cita">Dana Cita</option> 
        <option value="QRIS">QRIS</option> 		  
        <option selected="selected"><?php echo e($reg_pay_mtd) ?></option>
      </select>
    </div>
  </div>
  <div class="col-md-2">
    <div class="form-group">
      <label>Payment Date</label>
      <input type="date" name="reg_date"  class="form-control" value = "<?php echo e($reg_dt_payment) ?>" >
    </div>
  </div>
<?php if (num($st_reg) ==0){ ?>		
  <div class="col-md-2">
    <div class="form-group">
      <label>Action</label>
      <input name="paid_reg" type="submit" id="paid_reg"  class="form-control"  value="Paid" />
    </div>
</div>
<?php } else { ?>
<div class="col-md-2">
  <div class="form-group">
    <label>Action<br>
      <br>
      <br>
    </label>
    <a href="print.html"  
    onclick="window.open('cetak/invtest.php?id=<?php echo e(u($reg_id)) ?>','newwindow','width=800,height=800');return false;"> <strong>Print</strong></a> </div>
</div>
<?php } ?>		





		
	</div>
    <div class="col-md-12">	
      <div class="col-md-2">
  <div class="form-group">
      <label>Administration Fee</label>
      <input type="text" name="admin_amount"  class="form-control" value = "<?php echo e($admin_amount) ?>" readonly >
    </div>
</div>
      <div class="col-md-2">
        <div class="form-group">
          <label>Payment Metodh</label>
          <select name="admin_mtd"  id="payment_metodh" class="form-control" >
        <option value="Debit Card">Debit Card</option>
        <option value="Credit Card">Credit Card</option>
        <option value="Cash">Cash</option>
        <option value="Transfer">Transfer</option>
        <option value="Cek-Bg">Cek-Bg</option>
        <option value="Voucher">Voucher</option>
        <option value="Dana Cita">Dana Cita</option> 
        <option value="QRIS">QRIS</option> 		
            <option selected="selected"><?php echo e($admin_pay_mtd) ?></option>
          </select>
        </div>
      </div>
      <div class="col-md-2">
        <div class="form-group">
          <label>Payment Date</label>
          <input type="date" name="admin_date"  class="form-control" value = "<?php echo e($admin_dt_payment) ?>" >
        </div>
      </div>
<?php if (num($st_admin) ==0){ ?>			
      <div class="col-md-2">
        <div class="form-group">
      <label>Action</label>
          <input name="paid_admin" type="submit" id="paid_admin"  class="form-control"  value="Paid" />
        </div>
    </div>
<?php } else { ?>
<div class="col-md-2">
  <div class="form-group">
    <label>Action<br>
      <br>
      <br>
    </label>
    <a href="print.html"  
    onclick="window.open('cetak/invtest.php?id=<?php echo e(u($admin_id)) ?>','newwindow','width=800,height=800');return false;"> <strong>Print</strong></a> </div>
</div>
<?php } ?>		
    </div>
    <div class="col-md-12">		
    <div class="col-md-2">
      <div class="form-group">
      <label> Tuition Fee </label>
      <input type="text" name="tf_amount"  class="form-control" value = "<?php echo e($tf_amount) ?>" readonly>
    </div>
</div>
    <div class="col-md-2">
      <div class="form-group">
        <label>Payment Metodh</label>
        <select name="tf_mtd"  id="payment_metodh2" class="form-control" >
        <option value="Debit Card">Debit Card</option>
        <option value="Credit Card">Credit Card</option>
        <option value="Cash">Cash</option>
        <option value="Transfer">Transfer</option>
        <option value="Cek-Bg">Cek-Bg</option>
        <option value="Voucher">Voucher</option>
        <option value="Dana Cita">Dana Cita</option> 
        <option value="QRIS">QRIS</option> 		
          <option selected="selected"><?php echo e($tf_pay_mtd) ?></option>
        </select>
      </div>
    </div>
    <div class="col-md-2">
      <div class="form-group">
        <label>Payment Date</label>
        <input type="date" name="tf_date"  class="form-control" value = "<?php echo e($tf_dt_payment) ?>" >
      </div>
    </div>
<?php if (num($st_tf) == 0){?>		
    <div class="col-md-2">
      <div class="form-group">
      <label>Action</label>
        <input name="tf_paid" type="submit" id="tf_paid"  class="form-control"  value="Paid" />
      </div>
  </div>
<?php } else { ?>		
    <div class="col-md-2">
      <div class="form-group">

		  <label>Action<br>
		    <br>
<br>
		  </label>
	 		 <a href="print.html"  
    onclick="window.open('cetak/invtest.php?id=<?php echo e(u($tf_id)) ?>','newwindow','width=800,height=800');return false;"> <strong>Print</strong>		  </a>

      </div>
    </div>
<?php } ?>		
    </div>
    <div class="col-md-12">
      <div class="col-md-2">
        <div class="form-group">
          <label> TBI - Additional Fee </label>
          <input type="text" name="add_tbi_amount"  class="form-control" value = "<?php echo e($add_tbi) ?>" readonly>
        </div>
      </div>
      <div class="col-md-2">
        <div class="form-group">
          <label>Payment Metodh</label>
          <select name="add_tbi_mtd"  id="tf_mtd" class="form-control" >
        <option value="Debit Card">Debit Card</option>
        <option value="Credit Card">Credit Card</option>
        <option value="Cash">Cash</option>
        <option value="Transfer">Transfer</option>
        <option value="Cek-Bg">Cek-Bg</option>
        <option value="Voucher">Voucher</option>
        <option value="Dana Cita">Dana Cita</option> 
        <option value="QRIS">QRIS</option> 		
            <option selected="selected"><?php echo e($tf_pay_mtd) ?></option>
          </select>
        </div>
      </div>
      <div class="col-md-2">
        <div class="form-group">
          <label>Payment Date</label>
          <input type="date" name="add_tbi_date"  class="form-control" value = "<?php echo e($add_tbi_date) ?>" >
        </div>
      </div>
      <?php if (num($st_tbi_add_fee) == 0){?>
      <div class="col-md-2">
        <div class="form-group">
          <label>Action</label>
          <input name="add_tbi_paid" type="submit" id="tf_paid2"  class="form-control"  value="Paid" />
        </div>
      </div>
      <?php } else { ?>
      <div class="col-md-2">
        <div class="form-group">
          <label>Action<br>
            <br>
            <br>
          </label>
          <a href="print.html"  
    onclick="window.open('cetak/invtest.php?id=<?php echo e(u($add_tbi_id)) ?>','newwindow','width=800,height=800');return false;"> <strong>Print</strong></a> </div>
      </div>
      <?php } ?>
    </div>
  <div class="col-md-8">
    <div class="form-group">
      <label> Remark</label>
      <input type="text" name="remark"  class="form-control" value = "<?php echo e($remark) ?>"/>
    </div>
</div>
  <?php //==== 
if ($type_class == 'PRI')
{
	?>
  <?php }//==== ?>
 <input type="hidden" name="tf" id="textfield" value="<?php echo e($tf) ?>" hidden="hidden" >
 <input type="hidden" name="tf_nett" id="textfield2" value="<?php echo e($tf_nett) ?>">
      <input type="hidden" name="discount_tf" id="textfield3" value="<?php echo e($discount_tf) ?>" hidden="">
</div>
    </div>
<blockquote>&nbsp;</blockquote>
    </div>
  </div>
<div class="box-body"></div>
<div class="box-body"></div>
</form>
</body>
</html>
<?php 
if (($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['paid_reg']))) 
	{
		$hari=date("d");$bulan=date("m");$tahun=date("Y");
	$hari_ini = "$tahun-$bulan-$hari";		
	if($bulan =='01'){$bln_rom="I";}if($bulan =='02'){$bln_rom="II";}	if($bulan =='03'){$bln_rom="III";}	if($bulan =='04'){$bln_rom="IV";}
	if($bulan =='05'){$bln_rom="V";}	if($bulan =='06'){$bln_rom="VI";}	if($bulan =='07'){$bln_rom="VII";}	if($bulan =='08'){$bln_rom="VIII";}
	if($bulan =='09'){$bln_rom="IX";}	if($bulan =='10'){$bln_rom="X";}	if($bulan =='11'){$bln_rom="XI";}	if($bulan =='12'){$bln_rom="XII";}	
	$kd_biodata = in_val('kd_biodata', 'any');	
	
	$id_billing = in_val('id_billing', 'any');	
	$kdcbg = in_val('kdcbg', 'any');	
	$reg_amount = in_val('reg_amount', 'any');
	$reg_mtd = in_val('reg_mtd', 'any');
	$reg_date = in_val('reg_date', 'any');	
	$payment_for = in_val('payment_for', 'any');
	$query_last_billing = q_set($__p_query_last_billing, "SELECT id_invoice FROM ves_data.tb_invoice_paid t where kd_branch =? and (keterangan = ? or keterangan like ? ) order by id desc limit 1", [(string) ($kdcbg), (string) ($payment_for), (string) ($payment_for) . "%"]);

		$resource_last_billing = db_query_or_die('errro_last_billing', $query_last_billing, $__p_query_last_billing ?? []);
		if(num(db_num_rows($resource_last_billing)) > 0)
			{
			while ($row_last_billing=  db_fetch($resource_last_billing, PDO::FETCH_NUM))
				{
				$kd_invoice = $row_last_billing[0];
				$ambilangka =  substr($kd_invoice,0,-4);
				#ketemu angka awal(angka sebelumnya) + dengan 1
				$nextangka=num($ambilangka)+1;
				#menhitung jumlah karakter
				$digit=strlen($nextangka);
				if(!$kd_invoice){ $nol='000'; }elseif(num($digit)==1){ $nol='000'; }	elseif(num($digit)==2){ $nol='00'; }	elseif(num($digit)==3)
				{ $nol='0'; }
				if ($payment_for =='Test Bakat Minat' or $payment_for =='Test Bakat Minat Premium'  or $payment_for=='Test Penjurusan Online')
					{			
					$nomor_baru = $nol.$nextangka."/VTAL/0".$kdcbg."/".$bln_rom."-".$tahun;	
					}
				if ($payment_for =='IELTS International Test')
					{			
					$nomor_baru = $nol.$nextangka."/ILT-VIC/0".$kdcbg."/".$bln_rom."-".$tahun;	
					}
				else if ($payment_for =='TOEFL Ibt International Test')
					{			
					$nomor_baru = $nol.$nextangka."/TFL-VIC/0".$kdcbg."/".$bln_rom."-".$tahun;	
					}
				else if ($payment_for =='NCUK')
					{			
					$nomor_baru = $nol.$nextangka."/VPATH/0".$kdcbg."/".$bln_rom."-".$tahun;	
					}
				else if ($payment_for =='Password Test')
					{			
					$nomor_baru = $nol.$nextangka."/PASST/0".$kdcbg."/".$bln_rom."-".$tahun;	
					}
				else if ($payment_for =='Vistalk 2020')
					{			
					$nomor_baru = $nol.$nextangka."/EVENT/0".$kdcbg."/".$bln_rom."-".$tahun;	
					}	
				else if ($payment_for =='SAT')
					{			
					$nomor_baru = $nol.$nextangka."/SAT/0".$kdcbg."/".$bln_rom."-".$tahun;	
					}	
				else if ($payment_for =='GRE International Test')
					{			
					$nomor_baru = $nol.$nextangka."/GRE/0".$kdcbg."/".$bln_rom."-".$tahun;	
					}	
				elseif (strpos($payment_for, 'Coaching Session') !== false)
					{
					$nomor_baru = $nol.$nextangka."/CS/0".$kdcbg."/".$bln_rom."-".$tahun;
					}	
				elseif (strpos($payment_for, 'VPRO - Placement Test') !== false)
					{
					$nomor_baru = $nol.$nextangka."/VPRO/".$bln_rom."-".$tahun;
					}
				else if ($payment_for =='BIM - Application Fee')
					{			
					$nomor_baru = $nol.$nextangka."/BIM/0".$kdcbg."/".$bln_rom."-".$tahun;	
					}				
				else
					{
					$nomor_baru = $nol.$nextangka."/VOS/DEPOSIT/0".$kdcbg."/".$bln_rom."-".$tahun;
					$soa= 1;
					}					
				}
			}
		else
		{
				if ($payment_for =='Test Bakat Minat' or $payment_for =='Test Bakat Minat Premium' or $payment_for=='Test Penjurusan Online')
					{			
					$nomor_baru =  "0001/VTAL/0".$kdcbg."/".$bln_rom."-".$tahun;	
					}
				else if ($payment_for =='IELTS International Test')
					{			
					$nomor_baru =  "0001/ILT-VIC/0".$kdcbg."/".$bln_rom."-".$tahun;	
					}
				else if ($payment_for =='TOEFL Ibt International Test')
					{			
					$nomor_baru =  "0001/TFL-VIC/0".$kdcbg."/".$bln_rom."-".$tahun;	
					}
				else if ($payment_for =='NCUK')
					{			
					$nomor_baru =  "0001/VPATH/0".$kdcbg."/".$bln_rom."-".$tahun;	
					}
				else if ($payment_for =='Password Test')
					{			
					$nomor_baru = "0001/PASST/0".$kdcbg."/".$bln_rom."-".$tahun;	
					}	
				else if ($payment_for =='Vistalk 2020')
					{			
					$nomor_baru = "0001/EVENT/0".$kdcbg."/".$bln_rom."-".$tahun;	
					}	
				else if ($payment_for =='SAT')
					{			
					$nomor_baru = "0001/SAT/0".$kdcbg."/".$bln_rom."-".$tahun;	
					}	
				else if ($payment_for =='GRE International Test')
					{			
					$nomor_baru = "0001/GRE/0".$kdcbg."/".$bln_rom."-".$tahun;	
					}	
				elseif (strpos($payment_for, 'Coaching Session') !== false)
					{
					$nomor_baru = "0001/CS/0".$kdcbg."/".$bln_rom."-".$tahun;						
					}	
				elseif (strpos($payment_for, 'VPRO - Placement Test') !== false)
					{
					$nomor_baru = "0001/VPRO/".$bln_rom."-".$tahun;						
					}	
				else if ($payment_for =='BIM - Application Fee')
					{			
					$nomor_baru = "0001/SAT/0".$kdcbg."/".$bln_rom."-".$tahun;	
					}				
			
				else
					{
					$nomor_baru = "0001/VOS/DEPOSIT/0".$kdcbg."/".$bln_rom."-".$tahun;
					$soa= 1;
					}			
				}
	
	$query_simpan_payment = q_set($__p_query_simpan_payment, "insert into ves_data.tb_invoice_paid (id_billing,id_invoice,kd_biodata,kd_branch,keterangan,keterangan_dtl,nominal,pay_mtd, dt_payment,pic,dt_entry) \r
\tvalues \t(? ,? ,? ,? ,? ,'Registration',? ,? ,? ,? ,? )", [(string) ($id_billing), (string) ($nomor_baru), (string) ($kd_biodata), (string) ($kdcbg), (string) ($payment_for), (string) ($reg_amount), (string) ($reg_mtd), (string) ($reg_date), (string) ($nama_lengkap), (string) ($tgl_hari_ini)]);
	
		$resource_bayar = db_query_or_die('errro_last_billing', $query_simpan_payment, $__p_query_simpan_payment ?? []);
		echo "<script type=\"text/javascript\">\n";
		echo "alert('Payment Submitted');\n";
		echo "window.location = ('invoicebillreceipt.php?idb=" . e(u($id_billing)) . "');\n";				
		echo "</script>";
	}	
if (($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['paid_admin']))) 
	{
		$hari=date("d");$bulan=date("m");$tahun=date("Y");
	$hari_ini = "$tahun-$bulan-$hari";		
	if($bulan =='01'){$bln_rom="I";}if($bulan =='02'){$bln_rom="II";}	if($bulan =='03'){$bln_rom="III";}	if($bulan =='04'){$bln_rom="IV";}
	if($bulan =='05'){$bln_rom="V";}	if($bulan =='06'){$bln_rom="VI";}	if($bulan =='07'){$bln_rom="VII";}	if($bulan =='08'){$bln_rom="VIII";}
	if($bulan =='09'){$bln_rom="IX";}	if($bulan =='10'){$bln_rom="X";}	if($bulan =='11'){$bln_rom="XI";}	if($bulan =='12'){$bln_rom="XII";}	
	$id_billing = in_val('id_billing', 'any');
	$kd_biodata = in_val('kd_biodata', 'any');	
	$kdcbg = in_val('kdcbg', 'any');	
	$admin_amount = in_val('admin_amount', 'any');
	$admin_mtd = in_val('admin_mtd', 'any');
	$admin_date = in_val('admin_date', 'any');	
	$payment_for = in_val('payment_for', 'any');
	$query_last_billing = q_set($__p_query_last_billing, "SELECT id_invoice FROM ves_data.tb_invoice_paid t where kd_branch =? and keterangan = ? order by id desc limit 1", [(string) ($kdcbg), (string) ($payment_for)]);

		$resource_last_billing = db_query_or_die('errro_last_billing', $query_last_billing, $__p_query_last_billing ?? []);
		if(num(db_num_rows($resource_last_billing)) > 0)
			{
			while ($row_last_billing=  db_fetch($resource_last_billing, PDO::FETCH_NUM))
				{
				$kd_invoice = $row_last_billing[0];
				$ambilangka =  substr($kd_invoice,0,-4);
				#ketemu angka awal(angka sebelumnya) + dengan 1
				$nextangka=num($ambilangka)+1;
				#menhitung jumlah karakter
				$digit=strlen($nextangka);
				if(!$kd_invoice){ $nol='000'; }elseif(num($digit)==1){ $nol='000'; }	elseif(num($digit)==2){ $nol='00'; }	elseif(num($digit)==3)
				{ $nol='0'; }
				if ($payment_for =='Test Bakat Minat' or $payment_for =='Test Bakat Minat Premium' or $payment_for=='Test Penjurusan Online')
					{			
					$nomor_baru = $nol.$nextangka."/VTAL/0".$kdcbg."/".$bln_rom."-".$tahun;	
					}
				if ($payment_for =='IELTS International Test')
					{			
					$nomor_baru = $nol.$nextangka."/ILT-VIC/0".$kdcbg."/".$bln_rom."-".$tahun;	
					}
				else if ($payment_for =='TOEFL Ibt International Test')
					{			
					$nomor_baru = $nol.$nextangka."/TFL-VIC/0".$kdcbg."/".$bln_rom."-".$tahun;	
					}
				else if ($payment_for =='NCUK')
					{			
					$nomor_baru = $nol.$nextangka."/VPATH/0".$kdcbg."/".$bln_rom."-".$tahun;	
					}
				else if ($payment_for =='Password Test')
					{			
					$nomor_baru =$nol.$nextangka."/PASST/0".$kdcbg."/".$bln_rom."-".$tahun;	
					}	
				else if ($payment_for =='Vistalk 2020')
					{			
					$nomor_baru =$nol.$nextangka."/EVENT/0".$kdcbg."/".$bln_rom."-".$tahun;	
					}
				else if ($payment_for =='GRE International Test')
					{			
					$nomor_baru =$nol.$nextangka."/GRE/0".$kdcbg."/".$bln_rom."-".$tahun;	
					}				
				else
					{
					$nomor_baru = $nol.$nextangka."/VOS/DEPOSIT/0".$kdcbg."/".$bln_rom."-".$tahun;
					$soa= 1;
					}				
				}
			}
		else
		{
				if ($payment_for =='Test Bakat Minat' or $payment_for =='Test Bakat Minat Premium' or $payment_for=='Test Penjurusan Online')
					{			
					$nomor_baru =  "0001/VTAL/0".$kdcbg."/".$bln_rom."-".$tahun;	
					}
				else if ($payment_for =='IELTS International Test')
					{			
					$nomor_baru =  "0001/TFL-VIC/0".$kdcbg."/".$bln_rom."-".$tahun;	
					}
				else if ($payment_for =='TOEFL Ibt International Test')
					{			
					$nomor_baru =  "0001/TFL-VIC/0".$kdcbg."/".$bln_rom."-".$tahun;	
					}
				else if ($payment_for =='NCUK')
					{			
					$nomor_baru =  "0001/VPATH/0".$kdcbg."/".$bln_rom."-".$tahun;	
					}	
				else if ($payment_for =='Password Test')
					{			
					$nomor_baru ="0001/PASST/0".$kdcbg."/".$bln_rom."-".$tahun;	
					}	
				else if ($payment_for =='Vistalk 2020')
					{			
					$nomor_baru ="0001/EVENT/0".$kdcbg."/".$bln_rom."-".$tahun;	
					}	
				else if ($payment_for =='GRE International Test')
					{			
					$nomor_baru ="0001/GRE/0".$kdcbg."/".$bln_rom."-".$tahun;	
					}			
				}
	
	$query_simpan_payment = q_set($__p_query_simpan_payment, "insert into ves_data.tb_invoice_paid (id_billing,id_invoice,kd_biodata,kd_branch,keterangan,keterangan_dtl,nominal,pay_mtd, dt_payment,pic,dt_entry) \r
\tvalues \t(? ,? ,? ,? ,? ,'Administration',? ,? ,? ,? ,? )", [(string) ($id_billing), (string) ($nomor_baru), (string) ($kd_biodata), (string) ($kdcbg), (string) ($payment_for), (string) ($admin_amount), (string) ($admin_mtd), (string) ($admin_date), (string) ($nama_lengkap), (string) ($tgl_hari_ini)]);
	
		$resource_bayar = db_query_or_die('errro_last_billing', $query_simpan_payment, $__p_query_simpan_payment ?? []);
		echo "<script type=\"text/javascript\">\n";
		echo "alert('Payment Submitted');\n";
		echo "window.location = ('invoicebillreceipt.php?idb=" . e(u($id_billing)) . "');\n";				
		echo "</script>";
	}		

if (($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['tf_paid']))) 
	{
		$hari=date("d");$bulan=date("m");$tahun=date("Y");
	$hari_ini = "$tahun-$bulan-$hari";		
	if($bulan =='01'){$bln_rom="I";}if($bulan =='02'){$bln_rom="II";}	if($bulan =='03'){$bln_rom="III";}	if($bulan =='04'){$bln_rom="IV";}
	if($bulan =='05'){$bln_rom="V";}	if($bulan =='06'){$bln_rom="VI";}	if($bulan =='07'){$bln_rom="VII";}	if($bulan =='08'){$bln_rom="VIII";}
	if($bulan =='09'){$bln_rom="IX";}	if($bulan =='10'){$bln_rom="X";}	if($bulan =='11'){$bln_rom="XI";}	if($bulan =='12'){$bln_rom="XII";}	
	$id_billing = in_val('id_billing', 'any');
	$kd_biodata = in_val('kd_biodata', 'any');	
	$kdcbg = in_val('kdcbg', 'any');	
	$tf_amount = in_val('tf_amount', 'any');
	$tf_mtd = in_val('tf_mtd', 'any');
	$tf_date = in_val('tf_date', 'any');	
	$payment_for = in_val('payment_for', 'any');
	if ($payment_for== 'Test Bakat Minat' or $payment_for== 'Test Bakat Minat Premium'  or $payment_for== 'IELTS International Test' or $payment_for== 'TOEFL Ibt International Test' or $payment_for =='NCUK' or $payment_for =='LIUMEDIA')
		{
		$query_last_billing = q_set($__p_query_last_billing, "SELECT id_invoice FROM ves_data.tb_invoice_paid t where kd_branch =? and keterangan = ? order by id desc limit 1", [(string) ($kdcbg), (string) ($payment_for)]);
		}
elseif ((strpos($payment_for, 'TBI - ') !== false) or (strpos($payment_for, 'Program Kolaborasi') !== false))
		{
		$query_last_billing = q_set($__p_query_last_billing, "SELECT id_invoice FROM ves_data.tb_invoice_paid t where kd_branch =? and (keterangan like 'TBI - %' or keterangan like 'Program Kolaborasi%') order by id desc limit 1", [(string) ($kdcbg)]);
		}
elseif ($payment_for== 'Coaching Session')
		{
		$query_last_billing = q_set($__p_query_last_billing, "SELECT id_invoice FROM ves_data.tb_invoice_paid t where kd_branch =? and keterangan = ? order by id desc limit 1", [(string) ($kdcbg), (string) ($payment_for)]);
		}	
elseif ($payment_for== 'VPRO - Placement Test')
		{
		$query_last_billing = q_set($__p_query_last_billing, "SELECT id_invoice FROM ves_data.tb_invoice_paid t where kd_branch =? and keterangan = ? order by id desc limit 1", [(string) ($kdcbg), (string) ($payment_for)]);
		}	
elseif ( ($payment_for =='60 Menit Consult Additional')  or ($payment_for =='30 Menit Consult Additional') or ( $payment_for =='BIM - Application Fee')) 
	{
$query_last_billing = q_set($__p_query_last_billing, "SELECT id_invoice FROM ves_data.tb_invoice_paid t where kd_branch =? and keterangan = ? order by id desc limit 1", [(string) ($kdcbg), (string) ($payment_for)]);	

	}
	
	else
		{
		$query_last_billing = q_set($__p_query_last_billing, "SELECT id_invoice FROM ves_data.tb_invoice_paid t where kd_branch =? and  mid(keterangan,1,3) ='VOS' order by id desc limit 1", [(string) ($kdcbg)]);$soa= 1;
		}

		$resource_last_billing = db_query_or_die('errro_last_billing', $query_last_billing, $__p_query_last_billing ?? []);
		if(num(db_num_rows($resource_last_billing)) > 0)
			{
			while ($row_last_billing=  db_fetch($resource_last_billing, PDO::FETCH_NUM))
				{
				$kd_invoice = $row_last_billing[0];
				$ambilangka =  substr($kd_invoice,0,-4);
				#ketemu angka awal(angka sebelumnya) + dengan 1
				$nextangka=num($ambilangka)+1;
				#menhitung jumlah karakter
				$digit=strlen($nextangka);
				if(!$kd_invoice){ $nol='000'; }elseif(num($digit)==1){ $nol='000'; }	elseif(num($digit)==2){ $nol='00'; }	elseif(num($digit)==3)
				{ $nol='0'; }
				if ($payment_for =='Test Bakat Minat' or $payment_for =='Test Bakat Minat Premium' or $payment_for=='Test Penjurusan Online')
					{

					$nomor_baru = $nol.$nextangka."/VTAL/0".$kdcbg."/".$bln_rom."-".$tahun;	
					}
				elseif ((strpos($payment_for, 'TBI - ') !== false) or (strpos($payment_for, 'Program Kolaborasi') !== false))
					{			
					$nomor_baru = $nol.$nextangka."/TBI-VIC/0".$kdcbg."/".$bln_rom."-".$tahun;	
					}
				elseif ($payment_for =='IELTS International Test')
					{			
					$nomor_baru = $nol.$nextangka."/ILT-VIC/0".$kdcbg."/".$bln_rom."-".$tahun;	
					}
				elseif ($payment_for =='TOEFL Ibt International Test')
					{			
					$nomor_baru = $nol.$nextangka."/TFL-VIC/0".$kdcbg."/".$bln_rom."-".$tahun;	
					}
				elseif ($payment_for =='NCUK')
					{			
					$nomor_baru = $nol.$nextangka."/VPATH/0".$kdcbg."/".$bln_rom."-".$tahun;	
					}
				elseif ($payment_for =='LIUMEDIA')
					{			
					$nomor_baru = $nol.$nextangka."/LIUMEDIA/".$bln_rom."-".$tahun;	
					}	
				else if ($payment_for =='Password Test')
					{			
					$nomor_baru =$nol.$nextangka."/PASST/0".$kdcbg."/".$bln_rom."-".$tahun;	
					}
				else if ($payment_for =='Vistalk 2020')
					{			
					$nomor_baru =$nol.$nextangka."/EVENT/0".$kdcbg."/".$bln_rom."-".$tahun;	
					}	
				else if ($payment_for =='SAT')
					{			
					$nomor_baru =$nol.$nextangka."/SAT/0".$kdcbg."/".$bln_rom."-".$tahun;	
					}	
				else if ($payment_for =='GRE International Test')
					{			
					$nomor_baru =$nol.$nextangka."/GRE/0".$kdcbg."/".$bln_rom."-".$tahun;	
					}
				elseif (strpos($payment_for, 'Coaching Session') !== false)		
					{
					$nomor_baru = $nol.$nextangka."/CS/0".$kdcbg."/".$bln_rom."-".$tahun;
					}
				else if ($payment_for =='VPRO - Placement Test')
					{			
					$nomor_baru =$nol.$nextangka."/VPRO/".$bln_rom."-".$tahun;	
					}
				else if ($payment_for =='BIM - Application Fee')
					{			
					$nomor_baru =$nol.$nextangka."/BIM/".$bln_rom."-".$tahun;	
					}					
				elseif ( ($payment_for =='60 Menit Consult Additional')  or ($payment_for =='30 Menit Consult Additional')  or ($payment_for =='25 Menit Consult Additional')  or ($payment_for =='50 Menit Consult Additional')  or ($payment_for =='75 Menit Consult Additional')) 
					{
					$nomor_baru = $nol.$nextangka."/VADD/0".$kdcbg."/".$bln_rom."-".$tahun;	
					}					
				else
					{
					$nomor_baru = $nol.$nextangka."/VOS/DEPOSIT/0".$kdcbg."/".$bln_rom."-".$tahun;$soa= 1;
					}
				
				}
			}
		else
		{
				if ($payment_for =='Test Bakat Minat' or $payment_for =='Test Bakat Minat Premium' or $payment_for=='Test Penjurusan Online')
					{
				
					$nomor_baru =  "0001/VTAL/0".$kdcbg."/".$bln_rom."-".$tahun;	
					}
				elseif ((strpos($payment_for, 'TBI - ') !== false) or (strpos($payment_for, 'Program Kolaborasi') !== false))
					{			
					$nomor_baru = "0001/TBI-VIC/0".$kdcbg."/".$bln_rom."-".$tahun;	
					}			
				elseif ($payment_for =='IELTS International Test')
					{			
					$nomor_baru =  "0001/TFL-VIC/0".$kdcbg."/".$bln_rom."-".$tahun;	
					}
				elseif ($payment_for =='TOEFL Ibt International Test')
					{			
					$nomor_baru =  "0001/TFL-VIC/0".$kdcbg."/".$bln_rom."-".$tahun;	
					}
				elseif ($payment_for =='NCUK')
					{			
					$nomor_baru =  "0001/VPATH/0".$kdcbg."/".$bln_rom."-".$tahun;	
					}
				elseif ($payment_for =='LIUMEDIA')
					{			
					$nomor_baru =  "0001/LIUMEDIA/".$bln_rom."-".$tahun;	
					}
				else if ($payment_for =='Password Test')
					{			
					$nomor_baru ="0001/PASST/0".$kdcbg."/".$bln_rom."-".$tahun;	
					}	
				else if ($payment_for =='Vistalk 2020')
					{			
					$nomor_baru ="0001/EVENT/0".$kdcbg."/".$bln_rom."-".$tahun;	
					}
				else if ($payment_for =='SAT')
					{			
					$nomor_baru ="0001/SAT/0".$kdcbg."/".$bln_rom."-".$tahun;	
					}	
				else if ($payment_for =='GRE International Test')
					{			
					$nomor_baru ="0001/GRE/0".$kdcbg."/".$bln_rom."-".$tahun;	
					}	
				elseif (strpos($payment_for, 'Coaching Session') !== false)		
					{
					$nomor_baru ="0001/CS/0".$kdcbg."/".$bln_rom."-".$tahun;
					}	
				else if ($payment_for =='VPRO - Placement Test')
					{			
					$nomor_baru ="0001/VPRO/".$bln_rom."-".$tahun;
					}	
				elseif ( ($payment_for =='60 Menit Consult Additional')  or ($payment_for =='30 Menit Consult Additional')) 
					{

					$nomor_baru = "0001/VADD/0".$kdcbg."/".$bln_rom."-".$tahun;
					}	
				else if ($payment_for =='BIM - Application Fee')
					{			
					$nomor_baru = "0001/BIM/0".$kdcbg."/".$bln_rom."-".$tahun;	
					}			
				else
					{
					$nomor_baru = "0001/VOS/DEPOSIT/0".$kdcbg."/".$bln_rom."-".$tahun;$soa= 1;
					}			
				}
	

	if (num($soa) ==1)
		{
		$query_enroll_student = q_set($__p_query_enroll_student, "SELECT kd_biodata, no,kd_cabang,enroll_date FROM tb_sales_report where kd_biodata = ?  ", [(string) ($kd_biodata)]);
		$resource_enroll_student= db_query_or_die('errro_visitor1', $query_enroll_student, $__p_query_enroll_student ?? []);
		if(num(db_num_rows($resource_enroll_student)) > 0)
			{
			while ($row_es =   db_fetch($resource_enroll_student, PDO::FETCH_NUM))
				{
				$soa_st = 1;
				$kd_biodata = $row_es[0];
				$no = $row_es[1];$no_sales = $no;
				$id_soa = "$kd_biodata$no";					
				}
			}
		}
		if(num($soa) ==1 and num($soa_st) != 1 and $payment_for != 'Non Student - VOS Cash Deposit'  and $payment_for != '75 Menit Consult Additional'   and $payment_for != '25 Menit Consult Additional'   and $payment_for != '50 Menit Consult Additional' and $payment_for !='SAT' and $payment_for !='GRE International Test' and $payment_for !='Other Income')
			{
			echo "<script type=\"text/javascript\">\n";
			echo "alert('Anda tidak bisa membuat Cash Deposit karena Student belum enroll');\n";	

			echo "window.location = ('invoicebilllist.php?kd_cbg=" . e(u($kdcbg)) . "');\n";
						echo "</script>";
			}
	else
	{
			
	$query_simpan_payment = q_set($__p_query_simpan_payment, "insert into ves_data.tb_invoice_paid (id_billing,id_invoice,kd_biodata,kd_branch,keterangan,keterangan_dtl,nominal,pay_mtd, dt_payment,pic,dt_entry) \r
\tvalues \t(? ,? ,? ,? ,? ,'Tuition Fee',? ,? ,? ,? ,? )", [(string) ($id_billing), (string) ($nomor_baru), (string) ($kd_biodata), (string) ($kdcbg), (string) ($payment_for), (string) ($tf_amount), (string) ($tf_mtd), (string) ($tf_date), (string) ($nama_lengkap), (string) ($tgl_hari_ini)]);
	
		$resource_bayar = db_query_or_die('errro_last_billing', $query_simpan_payment, $__p_query_simpan_payment ?? []);		
		$query_insert_soa = q_set($__p_query_insert_soa, "insert into ves_data.adm_soa (kd_biodata,  keterangan, cur_debet, rp_debet, id_soa, no_ref,jns_transaksi,dt_entry,id_nomor) values (? ,? ,'Rp',? ,? ,? ,2,? ,? )", [(string) ($kd_biodata), (string) ($payment_for), (string) ($tf_amount), (string) ($id_soa), (string) ($nomor_baru), (string) ($tgl_hari_ini), (string) ($id_invoice_paid)]); 
		$resource_insert_soa = db_query_or_die('errro_last_billing', $query_insert_soa, $__p_query_insert_soa ?? []);
		}
		echo "<script type=\"text/javascript\">\n";
		echo "alert('Payment Submitted');\n";
		echo "window.location = ('invoicebillreceipt.php?idb=" . e(u($id_billing)) . "');\n";				
		echo "</script>";
}

		
if (($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_tbi_paid']))) 
	{
		$hari=date("d");$bulan=date("m");$tahun=date("Y");
	$hari_ini = "$tahun-$bulan-$hari";		
	if($bulan =='01'){$bln_rom="I";}if($bulan =='02'){$bln_rom="II";}	if($bulan =='03'){$bln_rom="III";}	if($bulan =='04'){$bln_rom="IV";}
	if($bulan =='05'){$bln_rom="V";}	if($bulan =='06'){$bln_rom="VI";}	if($bulan =='07'){$bln_rom="VII";}	if($bulan =='08'){$bln_rom="VIII";}
	if($bulan =='09'){$bln_rom="IX";}	if($bulan =='10'){$bln_rom="X";}	if($bulan =='11'){$bln_rom="XI";}	if($bulan =='12'){$bln_rom="XII";}	
	$id_billing = in_val('id_billing', 'any');
	$kd_biodata = in_val('kd_biodata', 'any');	
	$kdcbg = in_val('kdcbg', 'any');	
	$add_tbi_amount = in_val('add_tbi_amount', 'any');
	$add_tbi_mtd = in_val('add_tbi_mtd', 'any');
	$add_tbi_date = in_val('add_tbi_date', 'any');	
	$payment_for = in_val('payment_for', 'any');
	
	if ($payment_for== 'Test Bakat Minat' or $payment_for== 'Test Bakat Minat Premium'  or $payment_for== 'IELTS International Test' or $payment_for== 'TOEFL Ibt International Test' or $payment_for =='NCUK' or $payment_for =='LIUMEDIA')
		{
		$query_last_billing = q_set($__p_query_last_billing, "SELECT id_invoice FROM ves_data.tb_invoice_paid t where kd_branch =? and keterangan = ? order by id desc limit 1", [(string) ($kdcbg), (string) ($payment_for)]);
		}
elseif ((strpos($payment_for, 'TBI - ') !== false) or (strpos($payment_for, 'Program Kolaborasi') !== false))
		{
		$query_last_billing = q_set($__p_query_last_billing, "SELECT id_invoice FROM ves_data.tb_invoice_paid t where kd_branch =? and keterangan like 'TBI - %' order by id desc limit 1", [(string) ($kdcbg)]);
		}	
	else
		{
		$query_last_billing = q_set($__p_query_last_billing, "SELECT id_invoice FROM ves_data.tb_invoice_paid t where kd_branch =? and  mid(keterangan,1,3) ='VOS' order by id desc limit 1", [(string) ($kdcbg)]);$soa= 1;
		}

		$resource_last_billing = db_query_or_die('errro_last_billing', $query_last_billing, $__p_query_last_billing ?? []);
		if(num(db_num_rows($resource_last_billing)) > 0)
			{
			while ($row_last_billing=  db_fetch($resource_last_billing, PDO::FETCH_NUM))
				{
				$kd_invoice = $row_last_billing[0];
				$ambilangka =  substr($kd_invoice,0,-4);
				#ketemu angka awal(angka sebelumnya) + dengan 1
				$nextangka=num($ambilangka)+1;
				#menhitung jumlah karakter
				$digit=strlen($nextangka);
				if(!$kd_invoice){ $nol='000'; }elseif(num($digit)==1){ $nol='000'; }	elseif(num($digit)==2){ $nol='00'; }	elseif(num($digit)==3)
				{ $nol='0'; }
				if ($payment_for =='Test Bakat Minat' or $payment_for =='Test Bakat Minat Premium' or $payment_for=='Test Penjurusan Online')
					{

					$nomor_baru = $nol.$nextangka."/VTAL/0".$kdcbg."/".$bln_rom."-".$tahun;	
					}
				elseif ((strpos($payment_for, 'TBI - ') !== false) or (strpos($payment_for, 'Program Kolaborasi') !== false))
					{			
					$nomor_baru = $nol.$nextangka."/TBI-VIC/0".$kdcbg."/".$bln_rom."-".$tahun;	
					}
				elseif ($payment_for =='IELTS International Test')
					{			
					$nomor_baru = $nol.$nextangka."/ILT-VIC/0".$kdcbg."/".$bln_rom."-".$tahun;	
					}
				elseif ($payment_for =='TOEFL Ibt International Test')
					{			
					$nomor_baru = $nol.$nextangka."/TFL-VIC/0".$kdcbg."/".$bln_rom."-".$tahun;	
					}
				elseif ($payment_for =='NCUK')
					{			
					$nomor_baru = $nol.$nextangka."/VPATH/0".$kdcbg."/".$bln_rom."-".$tahun;	
					}
				elseif ($payment_for =='LIUMEDIA')
					{			
					$nomor_baru = $nol.$nextangka."/LIUMEDIA/".$bln_rom."-".$tahun;	
					}	
				else if ($payment_for =='Password Test')
					{			
					$nomor_baru =$nol.$nextangka."/PASST/0".$kdcbg."/".$bln_rom."-".$tahun;	
					}
				else if ($payment_for =='Vistalk 2020')
					{			
					$nomor_baru =$nol.$nextangka."/EVENT/0".$kdcbg."/".$bln_rom."-".$tahun;	
					}	
				else if ($payment_for =='SAT')
					{			
					$nomor_baru =$nol.$nextangka."/SAT/0".$kdcbg."/".$bln_rom."-".$tahun;	
					}	
				else if ($payment_for =='GRE International Test')
					{			
					$nomor_baru =$nol.$nextangka."/GRE/0".$kdcbg."/".$bln_rom."-".$tahun;	
					}
				else if ($payment_for =='VPRO - Placement Test')
					{			
					$nomor_baru =$nol.$nextangka."/VPRO/".$bln_rom."-".$tahun;	
					}
				elseif (($payment_for== 'Program Kolaborasi Tes Penjurusan Vista x Test Bakat Indonesia + 30 Menit Consult') or ($payment_for == 'Program Kolaborasi Tes Penjurusan Vista x Test Bakat Indonesia + 60 Menit Consult')or ($payment_for == 'Program Kolaborasi Tes Penjurusan Vista x Test Bakat Indonesia + 25 Menit Consult')) 
								{			
					$nomor_baru =$nol.$nextangka."/VTBI/".$bln_rom."-".$tahun;	
					}
				else
					{
					$nomor_baru = $nol.$nextangka."/VOS/DEPOSIT/0".$kdcbg."/".$bln_rom."-".$tahun;$soa= 1;
					}
				
				}
			}
		else
		{
				if ($payment_for =='Test Bakat Minat' or $payment_for =='Test Bakat Minat Premium' or $payment_for=='Test Penjurusan Online')
					{
				
					$nomor_baru =  "0001/VTAL/0".$kdcbg."/".$bln_rom."-".$tahun;	
					}
				elseif ((strpos($payment_for, 'TBI - ') !== false) or (strpos($payment_for, 'Program Kolaborasi') !== false))
					{			
					$nomor_baru = "0001/TBI-VIC/0".$kdcbg."/".$bln_rom."-".$tahun;	
					}			
				elseif ($payment_for =='IELTS International Test')
					{			
					$nomor_baru =  "0001/TFL-VIC/0".$kdcbg."/".$bln_rom."-".$tahun;	
					}
				elseif ($payment_for =='TOEFL Ibt International Test')
					{			
					$nomor_baru =  "0001/TFL-VIC/0".$kdcbg."/".$bln_rom."-".$tahun;	
					}
				elseif ($payment_for =='NCUK')
					{			
					$nomor_baru =  "0001/VPATH/0".$kdcbg."/".$bln_rom."-".$tahun;	
					}
				elseif ($payment_for =='LIUMEDIA')
					{			
					$nomor_baru =  "0001/LIUMEDIA/".$bln_rom."-".$tahun;	
					}
				else if ($payment_for =='Password Test')
					{			
					$nomor_baru ="0001/PASST/0".$kdcbg."/".$bln_rom."-".$tahun;	
					}	
				else if ($payment_for =='Vistalk 2020')
					{			
					$nomor_baru ="0001/EVENT/0".$kdcbg."/".$bln_rom."-".$tahun;	
					}
				else if ($payment_for =='SAT')
					{			
					$nomor_baru ="0001/SAT/0".$kdcbg."/".$bln_rom."-".$tahun;	
					}	
				else if ($payment_for =='GRE International Test')
					{			
					$nomor_baru ="0001/GRE/0".$kdcbg."/".$bln_rom."-".$tahun;	
					}
				else if ($payment_for =='VPRO - Placement Test')
					{			
					$nomor_baru ="0001/VPRO/".$bln_rom."-".$tahun;	
					}	
				elseif (($payment_for== 'Program Kolaborasi Tes Penjurusan Vista x Test Bakat Indonesia + 30 Menit Consult') or ($payment_for == 'Program Kolaborasi Tes Penjurusan Vista x Test Bakat Indonesia + 60 Menit Consult') or ($payment_for == 'Program Kolaborasi Tes Penjurusan Vista x Test Bakat Indonesia + 25 Menit Consult')) 
					{			
					$nomor_baru ="0001/VTBI/".$bln_rom."-".$tahun;	
					}				
				else
					{
					$nomor_baru = "0001/VOS/DEPOSIT/0".$kdcbg."/".$bln_rom."-".$tahun;$soa= 1;
					}			
				}
	
	$query_simpan_payment = q_set($__p_query_simpan_payment, "insert into ves_data.tb_invoice_paid (id_billing,id_invoice,kd_biodata,kd_branch,keterangan,keterangan_dtl,nominal,pay_mtd, dt_payment,pic,dt_entry) \r
\tvalues \t(? ,? ,? ,? ,'TBI - Addtional Fee','Addtional Fee',? ,? ,? ,? ,? )", [(string) ($id_billing), (string) ($nomor_baru), (string) ($kd_biodata), (string) ($kdcbg), (string) ($add_tbi_amount), (string) ($add_tbi_mtd), (string) ($add_tbi_date), (string) ($nama_lengkap), (string) ($tgl_hari_ini)]);
	
		$resource_bayar = db_query_or_die('errro_last_billing', $query_simpan_payment, $__p_query_simpan_payment ?? []);
		echo "<script type=\"text/javascript\">\n";
		echo "alert('Payment Submitted');\n";
		echo "window.location = ('invoicebillreceipt.php?idb=" . e(u($id_billing)) . "');\n";				
		echo "</script>";
	}
if (isset($_GET['reg_print'])) 
	{
	$reg_id = in_val('reg_id', 'any');
		echo "<script type=\"text/javascript\">\n";
		echo "window.location = ('cetak/invtest.php?id=" . e(u($reg_id)) . "');\n";				
		echo "</script>";
	}	
if (isset($_GET['admin_print'])) 
	{
	$admin_id = in_val('admin_id', 'any');
		echo "<script type=\"text/javascript\">\n";
		echo "window.location = ('cetak/invtest.php?id=" . e(u($admin_id)) . "');\n";				
		echo "</script>";
	}	
if (isset($_GET['tf_print'])) 
	{
	$tf_id = in_val('tf_id', 'any');
		echo "<script type=\"text/javascript\">\n";
		echo "window.open('cetak/invtest.php?id=" . e(u($tf_id)) . "','print','height=200,width=150');\n";				
		echo "</script>";
	}			
if (($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['Save']))   /* blok lama tanpa tombol pemicu: hanya POST+CSRF */) 
	{
	$saat_ini = date('Y-m-d H:i:s');
		
	$bisa = 1;	$branch = $_SESSION['branch'];	$kdb = in_val('kdb', 'any');$kdcbg = $_SESSION['kd_branch'];	$idb = in_val('idb', 'any');		

	$reg_amount = in_val('reg_amount', 'any');
	$reg_mtd = in_val('reg_mtd', 'any');
	$admin_fee = in_val('admin_fee', 'any');
	$admin_mtd = in_val('admin_mtd', 'any');
	$nominal = in_val('nominal', 'any');
	$nominal_mtd = in_val('nominal_mtd', 'any');
	
	$hari=date("d");$bulan=date("m");$tahun=date("Y");
	$hari_ini = "$tahun-$bulan-$hari";			
		
	if($bulan =='01'){$bln_rom="I";}if($bulan =='02'){$bln_rom="II";}	if($bulan =='03'){$bln_rom="III";}	if($bulan =='04'){$bln_rom="IV";}
	if($bulan =='05'){$bln_rom="V";}	if($bulan =='06'){$bln_rom="VI";}	if($bulan =='07'){$bln_rom="VII";}	if($bulan =='08'){$bln_rom="VIII";}
	if($bulan =='09'){$bln_rom="IX";}	if($bulan =='10'){$bln_rom="X";}	if($bulan =='11'){$bln_rom="XI";}	if($bulan =='12'){$bln_rom="XII";}

	
	
	
	
	
	$query_simpan_payment = q_set($__p_query_simpan_payment, "insert into ves_data.tb_invoice (insert into ves_data.tb_invoice_paid (kd_biodata,kd_branch,keterangan_dtl,nominal,pay_mtd,dt_entry,pic,id_invoice,id_billing) \r
\tvalues \r
\t(? ,? ,? ,? ,? ,? ,? ,? ,? ,'1')", [(string) ($nomor_baru), (string) ($kdb), (string) ($student_name), (string) ($kdcbg), (string) ($payment_for), (string) ($nominal), (string) ($tgl_hari_ini), (string) ($nama_lengkap), (string) ($nomor_baru)]);

	
	
	
		echo "<script type=\"text/javascript\">\n";
		echo "alert('VIP Billing Submitted');\n";
		echo "window.location = ('invoicebilllist.php?idb=" . e(u($idb)) . "&kdb=" . e(u($kdb)) . "&st=" . e(u($st)) . "');\n";				
		echo "</script>";
		}

if (isset($_GET['Print'])) 
	{
	if ($idb !='')
		{

			echo "<script type=\"text/javascript\">\n";
			echo "window.open('invoiceprint.php?kdb=" . e(u($kdb)) . "','width=560,height=340,toolbar=0,menubar=0,location=0');\n";				
			echo "</script>";		

		}
	}
if (isset($_GET['Exit'])) 
	{


			echo "<script type=\"text/javascript\">\n";
			echo "window.location('invoicebilllist.php');\n";				
			echo "</script>";		

	}					  
?>