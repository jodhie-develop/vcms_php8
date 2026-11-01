<?php
require_once __DIR__ . "/_lib/bootstrap.php"; csrf_guard_get(); auth_require_login(); 
include __DIR__ . "/conndb.php";
include __DIR__ . "/profiledata.php";
$nama_lengkap = $_SESSION['nama_lengkap']; 
$no_urut_invoice_kdi = in_val('kdi', 'any');
if ($no_urut_invoice_kdi ==""){$no_urut_invoice_kdi = in_val('no_urut_invoice', 'any');}
//$inst_country = in_val('inst_country', 'any');
$query_fu = q_set($__p_query_fu, "select  \r
no_invoice, dt_invoice,  \r
institution_name, institution_country  \r
from ves_data.acc_invoice where no = ? ", [(string) ($no_urut_invoice_kdi)]);

$resource_fu = db_query_or_die('errro_7', $query_fu, $__p_query_fu ?? []);
while ($row_fu=  db_fetch($resource_fu, PDO::FETCH_NUM))
	{
		$inv_no = $row_fu[0];
$inv_date = $row_fu[1];
		$inst_name = $row_fu[2];
$inst_country = $row_fu[3];	
	} 

$pay_cur = in_val('pay_cur', 'any');
$pay_amount = in_val('pay_amount', 'any');
$pay_rate_rupiah = in_val('pay_rate_rupiah', 'any');
$pay_amount_rupiah = num($pay_amount) * num($pay_rate_rupiah);
$bank_charge = in_val('bank_charge', 'any');
$pay_bank = in_val('pay_bank', 'any');
$pay_rek = in_val('pay_rek', 'any');
$dt_pay = in_val('dt_pay', 'any');
$ref_num = in_val('ref_num', 'any');
$pay_remark = in_val('pay_remark', 'any');

$kd_invoice_dipilih = in_val('kd_invoice_dipilih', 'any');	

function buatrp($angka)
{
$jadi = "" . number_format(num($angka),0,',','.');
return $jadi;
}


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

<div class="wrapper">

  <!-- Left side column. contains the logo and sidebar -->
  

  <!-- Content Wrapper. Contains page content -->
  <div class="content">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>Payment Form</h1>
    </section>
<form method="post"><?php echo csrf_field(); ?> 
    <!-- Main content -->
<section class="content">
  <div class="row">
        <!-- left column -->
<?php  //     include __DIR__ . "/left.php";	 ?>
        <!--/.col (left) -->
        <!-- right column -->
<form role="form" method="post"><?php echo csrf_field(); ?>

    <div class="col-md-12">
<div class="box box-warning">
<div class="box box-warning">
  <div class="box-body">
                 	  <div class="col-md-3">
                 	    <div class="form-group">
                 	      <label>Invoice Number</label>
                 	      <input type="text" class="form-control"  placeholder="Enter ..." name="inv_no" value="<?php echo e($inv_no) ?>" readonly>
               	      </div>
               	    </div>
                 	  <div class="col-md-3">
                 	    <div class="form-group">
                 	      <label>Date Invoice</label><input type="date" class="form-control"  placeholder="Enter ..." name="inv_date" 
                 	      value="<?php echo e($inv_date) ?>" readonly></div>
               	    </div>
  </div>
<div class="box-body">
  <div class="col-md-8">
                 	    <div class="form-group">
                 	    <label>Customer Name</label>
                 	      <select class="form-control" name="inst_name"  readonly>
                 	        <?php
								$query_inst = q_set($__p_query_inst, "SELECT school FROM ves_data.tb_master_partner order by school");
								$resource_inst = db_query_or_die('errro_7', $query_inst, $__p_query_inst ?? []);
								while ($row_inst=  db_fetch($resource_inst, PDO::FETCH_NUM))
									{
							  		echo '<option value="'.e($row_inst[0]).'">'.e($row_inst[0]).'</option>';
							  		}      ?>
                 	        <option selected><?php echo  e($inst_name) ?></option>
               	        </select>
    </div>
  </div>
  <div class="col-md-4">
    <div class="form-group">
      <label>Country/City</label>
      <select class="form-control" name="inst_country" readonly >
        <?php
								$query_country = q_set($__p_query_country, "SELECT distinct country FROM ves_data.tb_master_partner where school = ? order by country", [(string) ($inst_name)]);
								$resource_country = db_query_or_die('errro_7', $query_country, $__p_query_country ?? []);
								while ($row_country=  db_fetch($resource_country, PDO::FETCH_NUM))
									{
							  		echo '<option value="'.e($row_country[0]).'">'.e($row_country[0]).'</option>';
							  		}      ?>
        <option selected><?php echo  e($inst_country) ?></option>
      </select>
    </div>
</div>
</div>
<div class="row">	  
	<div class="col-md-12">
	<div class="box-body">
	  <table width="100%" class="table table-bordered table-striped" id="example1">

                <thead>
                <tr>
      <td width=3% height="14" align=center >No</td>
      <td width="47%" align=center >Description</td>
      <td width="22%" align=center >Original Amount</td>
      <td width="15%" align=center ><a href="<?php $_SERVER['PHP_SELF']?>?by=student">Amount Rupiah</a></td>
      <td width="13%" align=center ><a href="<?php $_SERVER['PHP_SELF']?>?by=student">Bank</a></td>
      </tr>
		</thead> 
		<tbody>
<?php 
		$no_urut = 1;
	$query_dtl_inv= q_set($__p_query_dtl_inv, "SELECT a.cat_event, a.cat_dtl_event, a.description, a.add_description, a.remark,  date_format(a.dt_event,'%d %b %Y'), a.curr_invoice, a.ori_amount_invoice, a.rate_invoice, a.bank_invoice, a.remark_invoice FROM ves_data.acc_invoice a where a.no = ? ", [(string) ($no_urut_invoice_kdi)]);
 
	$resource_dtl_inv = db_query_soft($query_dtl_inv, $__p_query_dtl_inv ?? []);
	if(num(db_num_rows($resource_dtl_inv)) > 0)
		{
		
		while ($row_dtl_inv  =  db_fetch($resource_dtl_inv, PDO::FETCH_NUM))
			{
?>
  <tr>
      <td height="14" align=center class="style24"><?php echo e($no_urut); ?></td>
      <td align=left class="style24"><?php echo e($row_dtl_inv[0]); ?> <?php echo e($row_dtl_inv[1]); ?><br>
        <?php echo e($row_dtl_inv[2]); ?> <?php echo e($row_dtl_inv[3]); ?> <?php echo e($row_dtl_inv[4]); ?> <?php echo e($row_dtl_inv[5]); ?></td> 
      <td align=center class="style24"><?php echo e($row_dtl_inv[6]); ?> <?php echo e(buatrp($row_dtl_inv[7])); ?> (<?php echo e(buatrp($row_dtl_inv[8])); ?>)</td>
       <td align=center class="style24"><?php echo e(buatrp(num($row_dtl_inv[7]) * num($row_dtl_inv[8]))); ?></td>
        <td align=center class="style24"><?php echo e($row_dtl_inv[9]); ?></td>
	    </tr><?php $no_urut = num($no_urut) + 1 ; } } ?></table>
	</div>	
	</div>

	
</div>
</div>
<div class="box box-warning">
<div class="box-header with-border"><strong>Payment</strong>
  <input type="text" name="no_urut_invoice" id="textfield2" value="<?php echo e($no_urut_invoice_kdi) ?>" hidden="hidden" >
  <input type="text" name="kd_invoice_dipilih" id="textfield" value="<?php echo e($inv_no) ?>" hidden="hidden" >
</div>
<div class="box-body">
 <div class="row">
 	<div class="col-md-2">
    <div class="form-group">
      <label>Payment Currency</label>
      <select class="form-control" name="pay_cur">
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
      <label>Payment Amount</label>
      <input type="text" ang="en-150" class="form-control"  placeholder="Enter ..." name="pay_amount" 
                 	      value="<?php echo e($pay_amount)  ?>">
    </div>
  </div>
<div class="col-md-3">
  <div class="form-group">
    <label>Rupiah Rate</label>
    <input type="text" class="form-control"  placeholder="Enter ..." name="pay_rate_rupiah" 
                 	      value="<?php echo e($pay_rate_rupiah) ?>">
  </div>
</div>  
 </div>
 <div class="row">
   <div class="col-md-2">
     <div class="form-group"><br>
      <input type="submit" name="hitung" value="hitung" />
    </div>
</div>
  <div class="col-md-3">
    <div class="form-group">
      <label>Amount Rupiah</label>
      <input type="text" class="form-control"  placeholder="Enter ..." name="pay_amount_rupiah" 
                 	      value="<?php echo e($pay_amount_rupiah) ?>">
    </div>
  </div>
  <div class="col-md-3">
    <div class="form-group">
      <label>Bank Charge</label>
      <input type="text" ang="en-150" class="form-control"  placeholder="Enter ..." name="bank_charge" 
                 	      value="<?php echo e($bank_charge)  ?>">
    </div>
  </div>
 </div>
 <div class="row">
 <div class="col-md-4">
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
        <option selected><?php echo  e($inv_bank)  ?></option>
      </select>
    </div>
  </div>
  <div class="col-md-4">
    <div class="form-group">
      <label>Bank Account</label>
      <select class="form-control" name="pay_rek">
        <?php
								$query_rek = q_set($__p_query_rek, "SELECT kd_bank FROM ves_data.fin_bank_list");
								$resource_rek = db_query_or_die('errro_7', $query_rek, $__p_query_rek ?? []);
								while ($row_rek=  db_fetch($resource_rek, PDO::FETCH_NUM))
									{
							  		echo '<option value="'.e($row_rek[0]).'">'.e($row_rek[0]).'</option>';
							  		}      ?>
        <option selected><?php echo  e($pay_rek)  ?></option>
      </select>
    </div>
  </div>
 <div class="col-md-3">
    <div class="form-group">
      <label>Payment Date</label>
      <input type="date" class="form-control"  placeholder="Enter ..." name="dt_pay" 
                 	      value="<?php echo e($dt_pay) ?>">
    </div>
  </div> 
 </div> 
 <div class="row">
 <div class="col-md-4">
    <div class="form-group">
      <label>Reference Number</label>
      <input type="text" ang="en-150" class="form-control"  placeholder="Enter ..." name="ref_num" 
                 	      value="<?php echo e($ref_num)  ?>">
    </div>
  </div>
 <div class="col-md-4">
    <div class="form-group">
      <label>Remark Payment</label>
      <input type="text" ang="en-150" class="form-control"  placeholder="Enter ..." name="pay_remark" 
                 	      value="<?php echo e($pay_remark)  ?>">
    </div>
  </div> 	
 </div> 
  
  
  
  
  
  
</div>

            <input type="submit" name="Submit" value="Submit" />
</form>

</body>
<input type="submit" name="Void" value="Void" />
<input type="submit" name="Delete" value="Delete" />
</html>
<?php
if (($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['Submit']))) 
{
$hari=date("d");
$bulan=date("m");
$tahun=date("Y");
$hari_ini = "$tahun-$bulan-$hari";	
$pay_cur = in_val('pay_cur', 'any');
$pay_amount = in_val('pay_amount', 'any');
$pay_rate_rupiah = in_val('pay_rate_rupiah', 'any');
$pay_amount_rupiah = in_val('pay_amount_rupiah', 'any');
$bank_charge = in_val('bank_charge', 'any');
$pay_bank = in_val('pay_bank', 'any');
$pay_rek = in_val('pay_rek', 'any');
$dt_pay = in_val('dt_pay', 'any');
$ref_num = in_val('ref_num', 'any');
$pay_remark = in_val('pay_remark', 'any');

$no_urut_invoice_kdi = in_val('no_urut_invoice', 'any');	
$kd_invoice_dipilih = in_val('kd_invoice_dipilih', 'any');	
//===get inst code==
$query_simpan = q_set($__p_query_simpan, "insert into ves_data.acc_payment (no_urut_invoice, kd_invoice, payment_curr, payment_amount, payment_rate, bank_payment, dt_payment, payment_remark, dt_entry, pic, reff_num, bank_rekening,bank_charge) \r
values (? ,? ,? ,? ,? ,? ,? ,? ,? ,? ,? ,? ,? )", [(string) ($no_urut_invoice_kdi), (string) ($kd_invoice_dipilih), (string) ($pay_cur), (string) ($pay_amount), (string) ($pay_rate_rupiah), (string) ($pay_bank), (string) ($dt_pay), (string) ($pay_remark), (string) ($hari_ini), (string) ($nama_lengkap), (string) ($ref_num), (string) ($pay_rek), (string) ($bank_charge)]);
$resource_simpan= db_query_or_die('errro_simpan', $query_simpan, $__p_query_simpan ?? []);

$query_simpan_bank= q_set($__p_query_simpan_bank, "insert into ves_data.buku_bank( buku_rek,dt_transaksi, keterangan,debit, kode_transaksi, remark_transaksi, referensi_transaksi) values\r
(? ,? ,'Event Commision',? ,'EC','payment_remark',? )", [(string) ($pay_rek), (string) ($dt_pay), (string) ($pay_rate_rupiah), (string) ($ref_num)]);
$resource_simpan_bank= db_query_or_die('errro_simpan', $query_simpan_bank, $__p_query_simpan_bank ?? []);	
echo "<script type=\"text/javascript\">\n";
echo "alert('Payment has been submitted by " . e($nama_lengkap) . "');\n";
echo "self.opener.location.reload();\n";	
echo "window.close();\n";				
echo "</script>";
}
if (($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['hitung']))) 
{			
$pay_amount = in_val('pay_amount', 'any');
$pay_rate_rupiah = in_val('pay_rate_rupiah', 'any');
$pay_amount_rupiah = num($pay_amount) * num($pay_rate_rupiah);
}
if (($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['Void']))) 
{
$query_cek = q_set($__p_query_cek, "select no_urut_invoice from  ves_data.acc_payment where no_urut_invoice = ? ", [(string) ($no_urut_invoice_kdi)]);
$resource_cek = db_query_soft($query_cek, $__p_query_cek ?? []);
if(num(db_num_rows($resource_cek)) > 0)
	{
	echo "<script type=\"text/javascript\">\n";
	echo "alert('Invoice ini tidak bisa di void');\n";
	echo "window.close();\n";				
	echo "</script>";		
	}
else
	{
	if ($pay_remark !='')
		{
		$query_void = q_set($__p_query_void, "update ves_data.acc_invoice set ori_amount_invoice = '0',remark_invoice = ? where no =  \t? ", ["VOID - " . (string) ($pay_remark), (string) ($no_urut_invoice_kdi)]);
		$resource_void = db_query_soft($query_void, $__p_query_void ?? []);
		$query_simpan_hapus = q_set($__p_query_simpan_hapus, "insert into ves_data.log_hapus_data (pic, keterangan, dt_entry) values (? ,? ,? )", [(string) ($nama_lengkap), "Rubah kode invoice : " . (string) ($kd_invoice_dipilih) . " marketing invoice - VOID", (string) ($hari_ini)]); 
		$resource_simpan_hapus= db_query_or_die('errro_simpan2', $query_simpan_hapus, $__p_query_simpan_hapus ?? []);			
		echo "<script type=\"text/javascript\">\n";
		echo "alert('Invoice sudah di VOID');\n";
		echo "self.opener.location.reload();\n"; 			
		echo "window.close();\n";				
		echo "</script>";			
		}
	else
		{
		echo "<script type=\"text/javascript\">\n";
		echo "alert('Remark Payment Harus Diisi');\n";
		echo "</script>";			
		}
	}
}
if (($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['Delete']))) 
{	
$query_cek = q_set($__p_query_cek, "select no_urut_invoice from  ves_data.acc_payment where no_urut_invoice = ? ", [(string) ($no_urut_invoice_kdi)]);
$resource_cek = db_query_soft($query_cek, $__p_query_cek ?? []);
if(num(db_num_rows($resource_cek)) > 0)
	{
	echo "<script type=\"text/javascript\">\n";
	echo "alert('Invoice ini tidak bisa di Hapus');\n";
	echo "window.close();\n";				
	echo "</script>";		
	}
else
{		$query_void = q_set($__p_query_void, "delete from ves_data.acc_invoice where no = ? ", [(string) ($no_urut_invoice_kdi)]);
		$resource_cek = db_query_soft($query_cek, $__p_query_cek ?? []);
		$query_simpan_hapus = q_set($__p_query_simpan_hapus, "insert into ves_data.log_hapus_data (pic, keterangan, dt_entry) values (? ,? ,? )", [(string) ($nama_lengkap), "Hapus invoice : " . (string) ($kd_invoice_dipilih) . " marketing invoice", (string) ($hari_ini)]); 
		$resource_simpan_hapus= db_query_or_die('errro_simpan2', $query_simpan_hapus, $__p_query_simpan_hapus ?? []);			
		echo "<script type=\"text/javascript\">\n";
		echo "alert('Invoice sudah di Hapus');\n";
		echo "window.close();\n";				
		echo "</script>";	
}
}			
?>
