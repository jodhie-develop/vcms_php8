<?php
require_once __DIR__ . "/_lib/bootstrap.php"; csrf_guard_get(); auth_require_login(); 
include __DIR__ . "/conndb.php";
include __DIR__ . "/profiledata.php";
$nama_lengkap = 	$_SESSION['nama_lengkap']; 
//include __DIR__ . "/atas.php";
$no_leaving = in_val('nl', 'any');
$kd_invoice = in_val('kdin', 'any');
$nmr = in_val('nmr', 'any');

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


$query_payment= q_set($__p_query_payment, "SELECT no FROM fin_comm where kd_invoice = ? and no_leaving = ? ", [(string) ($kd_invoice), (string) ($no_leaving)]);
$resource_payment = db_query_soft($query_payment, $__p_query_payment ?? []);
$keluar_payment = db_num_rows($resource_payment);	
if(num(db_num_rows($resource_payment)) > 0)
	{
	echo "<script type=\"text/javascript\">\n";
	echo "alert('Anda tidak diperkenankan menghapus Invoice ini');\n";
	echo "window.close();\n";				
	echo "</script>";
	}
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


  <!-- Left side column. contains the logo and sidebar -->
  

  <!-- Content Wrapper. Contains page content -->
  <div class="wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>Invoice Delete</h1>
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
<div class="box-header with-border"><strong>Are you sure to delete </strong>
  <input type="text" name="no_leaving" id="textfield5" value="<?php echo e($no_leaving) ?>" hidden="hidden" >
  <input type="text" name="kd_invoice" id="textfield6" value="<?php echo e($kd_invoice) ?>"  hidden="hidden" >
  <input type="text" name="nmr" id="textfield4" value="<?php echo e($nmr) ?>"  hidden="hidden" >
<input type="submit" name="Submit" value="YES" />
</div>
<div class="box-body"></div>
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
$nmr = in_val('nmr', 'any');
$hari_ini = "$tahun-$bulan-$hari";	
$no_leaving= in_val('nl', 'any');
$kd_invoice= in_val('kd_invoice', 'any');	
$kd_biodata= in_val('kd_biodata', 'any');	

$query_hapus = q_set($__p_query_hapus, "delete FROM ves_data.fin_invoice where no = ? ", [(string) ($nmr)]); 
$resource_simpan= db_query_or_die('errro_simpan1', $query_hapus, $__p_query_hapus ?? []);

$query_simpan_hapus = q_set($__p_query_simpan_hapus, "insert into ves_data.log_hapus_data (pic, keterangan, dt_entry) values (? ,? ,? )", [(string) ($nama_lengkap), "hapus kode invoice : " . (string) ($kd_invoice) . " student nomor " . (string) ($no_leaving), (string) ($hari_ini)]); 
$resource_simpan_hapus= db_query_or_die('errro_simpan2', $query_simpan_hapus, $__p_query_simpan_hapus ?? []);
echo "<script type=\"text/javascript\">\n";
echo "alert('Delete by " . e($nama_lengkap) . "');\n";
echo "window.close();\n";				
echo "</script>";
}


?>
