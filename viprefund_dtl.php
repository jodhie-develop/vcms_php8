<?php
require_once __DIR__ . "/_lib/bootstrap.php"; csrf_guard_get(); auth_require_login(); 
ini_set("memory_limit","256M");
include __DIR__ . "/conndb.php";
include __DIR__ . "/profiledata.php";
$hari=date("d");
$bulan=date("m");
$tahun=date("Y");
$tgl_hari_ini =  "$tahun-$bulan-$hari";
$nama_lengkap = $_SESSION['nama_lengkap']; 
$no = in_val('id', 'any');


$query = q_set($__p_query, "SELECT a.no, a.kd_billing,  a.amount,b.nama_lengkap,a.id_receipt,a.kd_biodata,a.kd_branch  FROM ves_data.vip_billing_payment a left join ves_data.vip_student_data b  on a.kd_biodata = b.kd_biodata  where a.no = ? ", [(string) ($no)]);

$resource = db_query_soft($query, $__p_query ?? []);
$keluar = db_num_rows($resource);
if(num(db_num_rows($resource)) > 0)
	{
	while ($row  =  db_fetch($resource, PDO::FETCH_NUM))
		{
		$no = $row[0];
		$idb = $row[1];
		$rupiah_lama= $row[2];
		$nama = $row[3];
		$id_rcp = $row[4];	
		$kd_biodata = $row[5];	
		$kd_cabang = $row[6];				
		}
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
<?php //========================== left nav ?>
 <?php //  include __DIR__ . "/left.php";	 ?>
 <?php //====================== ?>
<body class="hold-transition skin-blue sidebar-mini">
  <!-- Left side column. contains the logo and sidebar -->
  <!-- Content Wrapper. Contains page content -->
  <div class="content">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
      VIP Refund<br>

      <!--/.col (left) -->
        <!-- right column -->
 <form method="post"><?php echo csrf_field(); ?>
<form role="form" method="post"><?php echo csrf_field(); ?>

    <div class="col-md-12">
    <div class="box box-warning">
<div class="box-body">
  <div class="col-md-4">
    <div class="form-group">
      <label>ID RECEIPT</label><input type="hidden" ang="en-150" class="form-control"  placeholder="Enter ..." name="idb" readonly 
                 	      value="<?php echo e($idb) ?>">
      <input type="text" ang="en-150" class="form-control"  placeholder="Enter ..." name="idrcp" readonly 
                 	      value="<?php echo e($id_rcp) ?>">
      <input type="hidden" ang="en-150" class="form-control"  placeholder="Enter ..." name="kd_cabang" readonly 
                 	      value="<?php echo e($kd_cabang) ?>">
    </div>
  </div>
  <div class="col-md-4">
    <div class="form-group">
      <label>Student Name</label>
      <input type="text" ang="en-150" class="form-control"  placeholder="Enter ..." name="rupiah2"  readonly
                 	      value="<?php echo e($nama) ?>">
      <input type="hidden" ang="en-150" class="form-control"  placeholder="Enter ..." name="kd_biodata"  readonly
                 	      value="<?php echo e($kd_biodata) ?>">
    </div>
  </div>
  <span class="form-group">
  <input type="hidden" ang="en-150" class="form-control"  placeholder="Enter ..." name="no" 
                 	      value="<?php echo e($no) ?>" hidden= "hidden">
  </span></div>    
<div class="box-body">
  <div class="col-md-4">
    <div class="form-group">
      <label>Rupiah</label><input type="text" ang="en-150" class="form-control"  placeholder="Enter ..." name="rupiah" 
                 	      value="<?php echo e($rupiah_lama) ?>">
      <input type="hidden" ang="en-150" class="form-control"  placeholder="Enter ..." name="rupiah_lama" 
                 	      value="<?php echo e($rupiah_lama) ?>">
    </div>
  </div>
  <div class="col-md-4">
    <div class="form-group">
      <label>Payment Metodh</label>
      <select name="payment_metodh"  id="jns_report2" class="form-control" >
        <option value="Debit Card">Debit Card</option>
        <option value="Credit Card">Credit Card</option>
        <option value="Cash">Cash</option>
        <option value="Transfer">Transfer</option>
        <option value="Cek-Bg">Cek-Bg</option>
        <option value="Voucher">Voucher</option>
        <option selected="selected"><?php echo e($payment_metodh) ?></option>
      </select>
    </div>
  </div>
</div>    
<div class="box-body">
  <div class="col-md-8">
    <div class="form-group">
      <label>Remark</label><input type="text" ang="en-150" class="form-control"  placeholder="Enter ..." name="remark" 
                 	      value="<?php echo e($remark) ?>">
    </div>
  </div>
</div>
<div class="box-body">
  <div class="col-md-4">
      <div class="form-group">
        <label>Effective Date Refund</label>
        <input type="date" ang="en-150" class="form-control"  placeholder="Enter ..." name="efektif_date" 
                 	      value="<?php echo e($tgl_hari_ini) ?>">
      </div>
  </div>
</div></form><input type="submit" name="Submit" value="Submit" />
</body>

</html>
<?php 
if (($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['Submit']))) 
	{

	$st_simpan = 1;
	$no = in_val('no', 'any');
	$payment_metodh = in_val('payment_metodh', 'any');	
	$id_billing = in_val('idb', 'any');
	$id_receipt = in_val('idrcp', 'any');
	$kd_biodata = in_val('kd_biodata', 'any');	
	$rupiah_lama = in_val('rupiah_lama', 'any');
	$rupiah = in_val('rupiah', 'any');		
	
	if ($payment_metodh ==''){$st_simpan = 0;$gagal = "Payment method must be filled";}
	$efektif_date= in_val('efektif_date', 'any');
	$next_payment	= in_val('next_payment', 'any');

	$remark = in_val('remark', 'any');	
	$hari=date("d");
	$bulan=date("m");
	$kd_cabang = in_val('kd_cabang', 'any');
	$nama_lengkap = $_SESSION['nama_lengkap']; 		
	if($bulan =='01'){$bln_rom="I";}
	if($bulan =='02'){$bln_rom="II";}
	if($bulan =='03'){$bln_rom="III";}
	if($bulan =='04'){$bln_rom="IV";}
	if($bulan =='05'){$bln_rom="V";}
	if($bulan =='06'){$bln_rom="VI";}
	if($bulan =='07'){$bln_rom="VII";}
	if($bulan =='08'){$bln_rom="VIII";}
	if($bulan =='09'){$bln_rom="IX";}
	if($bulan =='10'){$bln_rom="X";}
	if($bulan =='11'){$bln_rom="XI";}
	if($bulan =='12'){$bln_rom="XII";}
	$tahun=date("Y");
	$thn = substr($tahun,-2);	
	$hari_ini = "$tahun-$bulan-$hari";

	if ($next_payment ==$hari_ini)	{$next_payment='';}
		//=nbuat id receipt==
	//===banding no receipt=====
		//baru//
	$query_last_receipt_baru = q_set($__p_query_last_receipt_baru, "SELECT mid(id_refund,1,4),urut_byr FROM ves_data.vip_billing_refund where  kd_branch = ? order by id_refund desc limit 1", [(string) ($kd_cabang)]);

	$resource_last_receipt_baru = db_query_or_die('errro_last_billing1', $query_last_receipt_baru, $__p_query_last_receipt_baru ?? []);
	if(num(db_num_rows($resource_last_receipt_baru)) > 0)
		{
		while ($row_last_receipt_baru=  db_fetch($resource_last_receipt_baru, PDO::FETCH_NUM))
			{
			$last_baru = $row_last_receipt_baru[0];		
			$urut_byr = $row_last_receipt_baru[1];					
			}
		}
	else
		{
		$last_baru = '0000';			
		}

	
	#ketemu angka awal(angka sebelumnya) + dengan 1
	$nextangka=num($last_baru) + 1;
	if (num($nextangka) <= 9){$nol = '000';}	elseif (num($nextangka) >= 10 and num($nextangka) <=99) {$nol = '00';}	elseif (num($nextangka) >= 100 and num($nextangka) <=999) {$nol = '0';}	elseif (num($nextangka) >= 1000 and num($nextangka) <=9999) {$nol = '';}

	$nomor_baru = $nol.$nextangka."/VE/RFD/0".$kd_cabang."/".$bln_rom."-".$thn;	
	$id_rfd = $nomor_baru;

	if (num($st_simpan)==1 )
	{	$query_update_receipt= q_set($__p_query_update_receipt, "insert into  ves_data.vip_billing_refund(kd_billing,id_receipt,kd_biodata,  kd_branch,amount,dt_refund, dt_entry,pic,id_refund,admin_receipt,pay_mtd,remark) values (? ,? ,? ,? ,? ,? ,? ,? ,? ,? ,? ,? )", [(string) ($id_billing), (string) ($id_receipt), (string) ($kd_biodata), (string) ($kd_cabang), (string) ($rupiah), (string) ($efektif_date), (string) ($tgl_hari_ini), (string) ($nama_lengkap), (string) ($id_rfd), (string) ($nama_lengkap), (string) ($payment_metodh), (string) ($remark)]); 
	$resource_update_payment = db_query_or_die('errro_simpan', $query_update_receipt, $__p_query_update_receipt ?? []);	
	echo "<script type=\"text/javascript\">\n";
	echo "alert('VE Refund Submitted');\n";
	echo "window.opener.location.reload(true);\n";
	echo "window.close(); \n";				
	echo "</script>";
	}
	else
	{
		echo "disini";
	echo "<script type=\"text/javascript\">\n";
	echo "alert('Gagal Membuat Refund atau nominal lebih besar');\n";
	echo "window.opener.location.reload(true);\n";
	echo "window.close(); \n";
	}
	}

?>