<?php
require_once __DIR__ . "/_lib/bootstrap.php"; csrf_guard_get(); auth_require_login(); 
include __DIR__ . "/conndb.php";
include __DIR__ . "/profiledata.php";
$nama_lengkap = 	$_SESSION['nama_lengkap']; 
//include __DIR__ . "/atas.php";
$no_leaving = in_val('nl', 'any');
$kd_invoice = in_val('kdin', 'any');
if ($kd_invoice ==""){$kd_invoice = in_val('kd_invoice', 'any');}
//$inst_country = in_val('inst_country', 'any');
$inv_new = in_val('inv_new', 'any');
$inv_exist = in_val('inv_exist', 'any');
$inv_date = in_val('inv_date', 'any');
$student_name = in_val('student_name', 'any');

$inst_name = in_val('inst_name', 'any');
$inst_country = in_val('inst_country', 'any');
$inst_group = in_val('inst_group', 'any');
$kd_school = in_val('kd_school', 'any');
$inv_cur = in_val('inv_cur', 'any');
$inv_amount = in_val('inv_amount', 'any');
$inv_rate_rupiah = in_val('inv_rate_rupiah', 'any');
$inv_bank = in_val('inv_bank', 'any');
$remark = in_val('remark', 'any');
$inv_remark = in_val('inv_remark', 'any');
$inst_program = in_val('inst_program', 'any');
$comm_date = in_val('comm_date', 'any');

$query_detail = q_set($__p_query_detail, "SELECT kd_biodata, nama, dest_country, dest_school, dest_program, date_format(comm_date,'%d %b %y'),kd_school FROM ves_data.adm_stu_progress where no = ? ", [(string) ($no_leaving)]);
$resource_detail = db_query_soft($query_detail, $__p_query_detail ?? []);
$keluar_detail = db_num_rows($resource_detail);	
if(num(db_num_rows($resource_detail)) > 0)
	{
	while ($row_detail  =  db_fetch($resource_detail, PDO::FETCH_NUM))
		{
		$kd_biodata = $row_detail[0];
		$student_name = $row_detail[1];
		$inst_country = $row_detail[2];
		$inst_name = $row_detail[3];
		$inst_program = $row_detail[4];
		$comm_date = $row_detail[5];
		$kd_school = $row_detail[6];			
		}
	}

//===last invoice ===
$query_last_inv= q_set($__p_query_last_inv, "SELECT distinct kd_invoice FROM fin_invoice order by dt_invoice desc,no desc limit 1");
$resource_last_inv = db_query_soft($query_last_inv, $__p_query_last_inv ?? []);
$keluar_last_inv = db_num_rows($resource_last_inv);	
if(num(db_num_rows($resource_last_inv)) > 0)
	{
	while ($row_last_inv  =  db_fetch($resource_last_inv, PDO::FETCH_NUM))
		{
		$inv_akhir = $row_last_inv[0];
		}
	}
//===================
if ($inv_exist !="") {$new_invoice = 0 ;}

function buatrp($angka)
{
$jadi = "" . number_format(num($angka),0,',','.');
return $jadi;
}

$pay_cur = in_val('pay_cur', 'any');

$pay_ori_amount = in_val('pay_ori_amount', 'any');


$pay_rate_rupiah = in_val('pay_rate_rupiah', 'any');
$pay_amount_rupiah = num($pay_ori_amount) * num($pay_rate_rupiah);
$bank_charge = in_val('bank_charge', 'any');


$pay_bank = in_val('pay_bank', 'any');


$bank_rek = in_val('bank_rek', 'any');
	
$pay_remark = in_val('pay_remark', 'any');
$dt_payment = in_val('dt_payment', 'any');	

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
  <div class="wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>Invoice Admission - Student</h1>
    </section>
    <form method="post"><?php echo csrf_field(); ?> 
    <!-- Main content -->
<section class="content">
  <div class="row">
        <!-- left column -->
        <!--/.col (left) -->
        <!-- right column -->
<form role="form" method="post"><?php echo csrf_field(); ?>

    <div class="col-md-12">
    <div class="box box-warning">
<p>
<div class="box-body">
  <table width="100%" class="table table-bordered table-striped" id="example1">

                <thead>
    <tr>
      <td width=26% height="14" align=center ><strong>Student Name </strong></td>
      <td width="74%" align=left ><strong>: <?php echo e($student_name) ?></strong></td>
      </tr>
    <tr>
      <td height="14" align=center class="style24"><strong>Institution Name </strong></td>
      <td align=left class="style24"><span class="form-group" >
        <label>: <?php echo e($inst_name) ?> ( <?php echo e($inst_program) ?> ) - <?php echo e($inst_country) ?></label>
      </span></td>
    </tr>
                </thead> 
                <tbody>

    <tr>
      <td height="14" align=center class="style24"><span class="form-group">
      <label>Commencement Date</label>
      </span></td>
      <td align=left class="style24"><strong>: <span class="form-group"><?php echo e($comm_date) ?></span></strong></td>
    </tr>

                <tfoot>
                </tfoot>
                
</table>
                <p>
                  <input type="text" name="nl" id="textfield" value="<?php echo e($no_leaving) ?>" hidden="">
                  <input type="text" name="kd_biodata" id="textfield2" value="<?php echo e($kd_biodata) ?>" hidden="">
                  <input type="text" name="kd_school" id="textfield3" value="<?php echo e($kd_school) ?>" hidden="">
  </p>
</div>
</p>
                               <p>
  <?php
$query_exist_inv = q_set($__p_query_exist_inv, "SELECT center, nama, org_curr, org_mount, rate, mount_rp, remark FROM ves_data.fin_invoice where  no_leaving = ? and kd_invoice = ? ", [(string) ($no_leaving), (string) ($kd_invoice)]);

$resource_exist_inv = db_query_soft($query_exist_inv, $__p_query_exist_inv ?? []);
$keluar_exist_inv = db_num_rows($resource_exist_inv);		  
				  ?>
<?php
if(num(db_num_rows($resource_exist_inv)) > 0)
	{
		?>      <div class="box box-warning">
  </p>
                               <div class="box-header with-border"><strong>Invoice Number : <?php echo e($kd_invoice) ?></strong></div>
<div class="box-body">         
                <table width="100%" class="table table-bordered table-striped" id="example1">

                <thead>
                <tr>
      <td width=3% rowspan="2" align=center >No</td>
      <td width="4%" rowspan="2" align=center >Center</td>
      <td height="14" colspan="4" align=center >Invoice</td>
      </tr>
    <tr>
      <td width="17%" align=center ><a href="<?php $_SERVER['PHP_SELF']?>?by=curr">Amount</a> <br></td>
      <td width="10%" align=center ><a href="<?php $_SERVER['PHP_SELF']?>?by=curr">Rate</a> <br></td>
      <td width="17%" align=center ><a href="<?php $_SERVER['PHP_SELF']?>?by=curr">IDR Amount</a> <br></td>
      <td width="5%" height=14 align=center ><a href="<?php $_SERVER['PHP_SELF']?>?by=program">Remark</a></td>
      </tr>
                </thead> <?php } ?>
                <tbody>
<?php
					if(num(db_num_rows($resource_exist_inv)) > 0)
	{$nomor = 1;
	while ($row_exist_inv  =  db_fetch($resource_exist_inv, PDO::FETCH_NUM))
		{

		
?>	
    <tr>
      <td align=center class="style24"><?php echo e($nomor) ?></td>
      <td align=center class="style24"><?php echo e($row_exist_inv[0]) ?></td>
		<td align=left class="style24"><?php echo e($row_exist_inv[2]) ?> <?php echo e(buatrp($row_exist_inv[3])) ?></td>
      <td height=14 align=left class="style24"><?php echo e(buatrp($row_exist_inv[4])) ?></td>
      <td align=left class="style24"><?php echo e(buatrp($row_exist_inv[5])) ?><br></td>
      <td height=14 align=left class="style24"><?php echo e($row_exist_inv[6]) ?></td>
      </tr>
<?php 
$nomor = num($nomor)+1;}} 

 ?>
                <tfoot>
                </tfoot>
                
</table></div>

<div class="box box-warning">
<div class="box-header with-border"><strong>Payment</strong>
  <input type="text" name="no_leaving" id="textfield5" value="<?php echo e($no_leaving) ?>" hidden="hidden">
  <input type="text" name="kd_biodata" id="textfield6" value="<?php echo e($kd_biodata) ?>" hidden="hidden">
</div>
<div class="box-body">
  <div class="col-md-4">
                 	    <div class="form-group">
                 	      <label>Original Currency</label>
                 	      <select class="form-control" name="pay_cur" required>
                  			  <?php
								$query_curr = q_set($__p_query_curr, "SELECT kd_curr FROM ves_data.fin_currency");
								$resource_curr = db_query_or_die('errro_7', $query_curr, $__p_query_curr ?? []);
								while ($row_curr=  db_fetch($resource_curr, PDO::FETCH_NUM))
									{
							  		echo '<option value="'.e($row_curr[0]).'">'.e($row_curr[0]).'</option>';
							  		}      ?>
							  		<option selected><?php echo  e($pay_cur) ?></option>
       			  </select>
    </div>
  </div>
  <div class="col-md-3">
                 	    <div class="form-group">
                 	    <label>Original Amount</label>
                 	      <input type="text" ang="en-150" class="form-control" required  placeholder="Enter ..." name="pay_ori_amount" 
                 	      value="<?php echo e($pay_ori_amount)  ?>"></div>
  </div>
  <div class="col-md-3">
    <div class="form-group">
      <label>Rupiah Rate</label>
      <input type="text" class="form-control"  placeholder="Enter ..." name="pay_rate_rupiah"  required
                 	      value="<?php echo e($pay_rate_rupiah) ?>" onkeypress="if(event.keyCode==13){ func_name(this.value);return false;}">
    </div>
  </div>
  <span class="box-header with-border">
  <input type="text" name="kd_invoice" id="textfield4" value="<?php echo e($kd_invoice) ?>" hidden="hidden">
  </span>
  <div class="col-md-3">
    <div class="form-group">
     <label>Hitung Amount Rupiah</label>
    <input type="submit" name="hitung" value="hitung" />
  </div></div>
  <div class="col-md-3">
    <div class="form-group">
      <label>Original Amount (Rupiah)</label>
      <input type="number" class="form-control"  placeholder="Enter ..." name="pay_amount_rupiah" 
                 	      value="<?php echo e($pay_amount_rupiah) ?>">
    </div>
  </div>
  <div class="col-md-3">
    <div class="form-group">
      <label>Bank Charge</label>
      <input type="number" class="form-control"  placeholder="Enter ..." name="bank_charge" 
                 	      value="<?php echo e($inv_rate_rupiah) ?>">
    </div>
  </div>
</div>
<div class="box-body">
  <div class="col-md-2">
    <div class="form-group">
      <label>Bank Payment</label>
      <select class="form-control" name="pay_bank">
                 	        <?php
								$query_bank = q_set($__p_query_bank, "SELECT nm_bank FROM ves_data.fin_bank_list");
								$resource_bank = db_query_or_die('errro_7', $query_bank, $__p_query_bank ?? []);
								while ($row_bank=  db_fetch($resource_bank, PDO::FETCH_NUM))
									{
							  		echo '<option value="'.e($row_bank[0]).'">'.e($row_bank[0]).'</option>';
							  		}      ?>
                 	        <option selected><?php echo  e($pay_bank)  ?></option>
               	        </select>
    </div>
  </div>
  <div class="col-md-2">
    <div class="form-group">
      <label>Bank Account</label>
      <select class="form-control" name="bank_rek">
        <?php
								$query_bank = q_set($__p_query_bank, "SELECT kd_bank FROM ves_data.fin_bank_list");
								$resource_bank = db_query_or_die('errro_7', $query_bank, $__p_query_bank ?? []);
								while ($row_bank=  db_fetch($resource_bank, PDO::FETCH_NUM))
									{
							  		echo '<option value="'.e($row_bank[0]).'">'.e($row_bank[0]).'</option>';
							  		}      ?>
        <option selected><?php echo  e($bank_rek)  ?></option>
      </select>
    </div>
  </div>
  <div class="col-md-3">
    <div class="form-group">
      <label>Date Payment</label>
      <input type="date" class="form-control"  placeholder="Enter ..." name="dt_payment"  
                 	      value="<?php echo e($dt_payment) ?>">
    </div>
  </div>
  <div class="col-md-10">
                 	    <div class="form-group">
                 	    <label>Remark payment</label>
    <input type="text" class="form-control"  placeholder="Enter ..." name="pay_remark" 
                 	      value="<?php echo e($pay_remark)  ?>"></div>
  </div>
</div>               	    
<div class="box-body"></div>

            <input type="submit" name="Submit" value="Submit" />
</form>

</body>
</html>
<?php
if (($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['Submit']))) 
{
$lengkap ='0';
$nama_lengkap = 	$_SESSION['nama_lengkap']; 
$hari=date("d");
$bulan=date("m");
$tahun=date("Y");
$hari_ini = "$tahun-$bulan-$hari";	
$no_leaving= in_val('nl', 'any');
$kd_invoice= in_val('kd_invoice', 'any');	
$kd_biodata= in_val('kd_biodata', 'any');	

$pay_cur = in_val('pay_cur', 'any');
if ($pay_cur==""){$lengkap ='1';}
$pay_ori_amount = in_val('pay_ori_amount', 'any');
if ($pay_ori_amount==""){$lengkap ='1'; $kurang= "Original Payment ";}

$pay_rate_rupiah = in_val('pay_rate_rupiah', 'any');
if ($pay_rate_rupiah==""){$lengkap ='1'; $kurang= "Rate ";}	
$pay_amount_rupiah = num($pay_ori_amount) * num($pay_rate_rupiah);
if ($pay_amount_rupiah==""){$lengkap ='1';$kurang= "Tombol Hitung belum di klik ";}		
$bank_charge = in_val('bank_charge', 'any');

$pay_bank = in_val('pay_bank', 'any');
if ($pay_bank==""){$lengkap ='1';$kurang= "Info Bank ";}	

$bank_rek = in_val('bank_rek', 'any');
	if ($bank_rek==""){$lengkap ='1';$kurang= "Info Rekening Bank ";}		
$pay_remark = in_val('pay_remark', 'any');
$dt_payment = in_val('dt_payment', 'any');
if ($dt_payment==""){$lengkap ='1';$kurang= "Tanggal Bayar ";}	
if($lengkap =='0')
{
$query_simpan = q_set($__p_query_simpan, "insert into ves_data.fin_comm (\r
kd_invoice, no_leaving, kd_biodata,bank_penerima, \r
org_cur_pay, org_mount_pay, rate_pay, mount_rp_pay, bank_cash, dt_payment, pic, bank_rek,remark) values \r
(? ,? ,? ,? ,\r
? ,? ,? ,? , ? ,? ,? ,? ,? )", [(string) ($kd_invoice), (string) ($no_leaving), (string) ($kd_biodata), (string) ($pay_bank), (string) ($pay_cur), (string) ($pay_ori_amount), (string) ($pay_rate_rupiah), (string) ($pay_amount_rupiah), (string) ($bank_charge), (string) ($dt_payment), (string) ($nama_lengkap), (string) ($bank_rek), (string) ($pay_remark)]);
/* echo $query_simpan (debug SQL versi lama) dihapus */
$resource_simpan= db_query_or_die('errro_simpan', $query_simpan, $__p_query_simpan ?? []);
echo "<script type=\"text/javascript\">\n";
echo "alert('Payment has been set by " . e($nama_lengkap) . "');\n";
echo "window.close();\n";				
echo "</script>";
}
else
{
echo "<script type=\"text/javascript\">\n";
echo "alert('Data " . e($kurang) . " belum terisi');\n";
echo "</script>";
}

}

if (($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['hitung']))) 
{
	$lengkap =='0';
$hari=date("d");
$bulan=date("m");
$tahun=date("Y");
	
$hari_ini = "$tahun-$bulan-$hari";	
$no_leaving= in_val('nl', 'any');
$kd_invoice= in_val('kd_invoice', 'any');	
$kd_biodata= in_val('kd_biodata', 'any');	

$pay_cur = in_val('pay_cur', 'any');
if ($pay_cur==""){$lengkap ='1';}
$pay_ori_amount = in_val('pay_ori_amount', 'any');
if ($pay_ori_amount==""){$lengkap ='1';}

$pay_rate_rupiah = in_val('pay_rate_rupiah', 'any');
$bank_charge = in_val('bank_charge', 'any');


$pay_bank = in_val('pay_bank', 'any');


$bank_rek = in_val('bank_rek', 'any');
	
$pay_remark = in_val('pay_remark', 'any');
$dt_payment = in_val('dt_payment', 'any');	
$pay_ori_amount = in_val('pay_ori_amount', 'any');
	
$pay_rate_rupiah = in_val('pay_rate_rupiah', 'any');

$kembali = $_SERVER["REQUEST_URI"];
	echo "<script type=\"text/javascript\">\n";

	echo "window.location = ('pay_leaving.php?nl=" . e(u($no_leaving)) . "&kdin=" . e(u($kd_invoice)) . "&pay_cur=" . e(u($pay_cur)) . "&pay_ori_amount=" . e(u($pay_ori_amount)) . "&pay_rate_rupiah=" . e(u($pay_rate_rupiah)) . ");\n";				
	echo "</script>";	

	;
}					
?>
