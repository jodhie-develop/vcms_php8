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
$noold = in_val('noold', 'any');
$nonew = in_val('nonew', 'any');

$idb = in_val('idb', 'any');
$kd_branch = $_SESSION['kd_branch'];

$query = q_set($__p_query, "SELECT a.no, a.kd_billing,  a.amount,concat_ws(' ',b.nama, b.middle_name, b.family_name),a.no  FROM ves_data.vip_billing_payment a left join ves_inc.tb_biodata b  on a.kd_biodata = b.kd_biodata  where a.kd_billing = ? group by a.kd_billing", [(string) ($idb)]);

$resource = db_query_soft($query, $__p_query ?? []);
$keluar = db_num_rows($resource);
if(num(db_num_rows($resource)) > 0)
	{
	while ($row  =  db_fetch($resource, PDO::FETCH_NUM))
		{
		$no = $row[0];
		$idb = $row[1];
		$rupiah= $row[2];
		$nama = $row[3];
		
		}
	}

$query_old = q_set($__p_query_old, "SELECT t.jns_pay, t.tgl_cetak, t.mount_pat, t.pay_mtd, t.note FROM billing.tb_receipt t where no = ? ", [(string) ($noold)]);

$resource_old = db_query_soft($query_old, $__p_query_old ?? []);
$keluar_old = db_num_rows($resource_old);
if(num(db_num_rows($resource_old)) > 0)
	{
	while ($row_old  =  db_fetch($resource_old, PDO::FETCH_NUM))
		{

		$rupiahlama= $row_old[2];
		$payment_metodh = $row_old[3];	
		$tgl_hari = $row_old[1];	
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
      <h1>VIP Payment<br>

      <!--/.col (left) -->
        <!-- right column -->
 <form method="post"><?php echo csrf_field(); ?>
<form role="form" method="post"><?php echo csrf_field(); ?>

    <div class="col-md-12">
    <div class="box box-warning">
<div class="box-body">
  <div class="col-md-4">
    <div class="form-group">
      <label>ID Billing</label><input type="text" ang="en-150" class="form-control"  placeholder="Enter ..." name="idb" readonly 
                 	      value="<?php echo e($idb) ?>">
    </div>
  </div>
  <div class="col-md-4">
    <div class="form-group">
      <label>Student Name</label>
      <input type="text" ang="en-150" class="form-control"  placeholder="Enter ..." name="rupiah2"  readonly
                 	      value="<?php echo e($nama) ?>">
    </div>
  </div>
  <span class="form-group">
  <input type="hidden" ang="en-150" class="form-control"  placeholder="Enter ..." name="no" 
                 	      value="<?php echo e($no) ?>" hidden= "hidden">
  </span><span class="form-group">
  <input type="text" ang="en-150" class="form-control"  placeholder="Enter ..." name="nonew" 
                 	      value="<?php echo e($nonew) ?>" hidden= "hidden">
  <input type="text" ang="en-150" class="form-control"  placeholder="Enter ..." name="noold" 
                 	      value="<?php echo e($noold) ?>" hidden= "hidden">
  </span></div>    
<div class="box-body">
  <div class="col-md-4">
    <div class="form-group">
      <label>Rupiah</label><input type="text" ang="en-150" class="form-control"  placeholder="Enter ..." name="rupiah" 
                 	      value="<?php echo e($rupiahlama) ?>" readonly>
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
        <label>Effective Date</label>
        <input type="date" ang="en-150" class="form-control"  placeholder="Enter ..." name="efektif_date" 
                 	      value="<?php echo e($tgl_hari) ?>">
      </div>
  </div>
  <div class="col-md-4">
    <div class="form-group">
      <label>Next Payment</label>
      <input type="date" ang="en-150" class="form-control"  placeholder="Enter ..." name="next_payment" 
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
	$nonew = in_val('nonew', 'any');
	$noold = in_val('noold', 'any');		
		
	$payment_metodh = in_val('payment_metodh', 'any');	
	if ($payment_metodh ==''){$st_simpan = 0;$gagal = "Payment method must be filled";}
	$efektif_date= in_val('efektif_date', 'any');
	$next_payment	= in_val('next_payment', 'any');

	$remark = in_val('remark', 'any');	
	$hari=date("d");
	$bulan=date("m");
	$kd_branch = $_SESSION['kd_branch'];
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
	$query_last_receipt = q_set($__p_query_last_receipt, "SELECT urut_byr, id_receipt FROM ves_data.vip_billing_payment where  kd_branch = ? and id_receipt <> '' order by urut_byr desc limit 1", [(string) ($kd_branch)]);

	$resource_last_receipt = db_query_or_die('errro_last_billing', $query_last_receipt, $__p_query_last_receipt ?? []);
	if(num(db_num_rows($resource_last_receipt)) > 0)
		{
		while ($row_last_receipt=  db_fetch($resource_last_receipt, PDO::FETCH_NUM))
			{
			$urut_byr = $row_last_receipt[0];
			$id_receipt  = $row_last_receipt[1];
				
			$ambilangka =  substr($id_receipt,0,-4);
			#ketemu angka awal(angka sebelumnya) + dengan 1
			$nextangka=num($ambilangka) + 1;

			#menhitung jumlah karakter
			$digit=strlen($nextangka);
			if(num($digit) == 1){ $nol='000'; }elseif(num($digit) == 2){ $nol='00'; }	elseif(num($digit)==3){ $nol='0'; }	
			$nomor_baru = $nol.$nextangka."/VIP/0".$kd_branch."/".$bln_rom."-".$thn;	
			}
		}
	else
		{
		$nomor_baru =  "0001/VIP/0".$kd_branch."/".$bln_rom."-".$thn;
		}
	$id_rcp = $nomor_baru;
	$urut_byr_baru = num($urut_byr)+1;
	if (num($st_simpan)==1)
	{	$query_update_receipt= q_set($__p_query_update_receipt, "update ves_data.vip_billing_payment set  pay_mtd= ? , remark = ? , id_receipt = ? ,\r
\tdt_payment = ? , pic = ? , status = 'PAID',next_payment = ? ,admin_receipt = ? ,urut_byr = ? ,dt_cetak = ? where no = ? ", [(string) ($payment_metodh), (string) ($remark), (string) ($id_rcp), (string) ($efektif_date), (string) ($nama_lengkap), (string) ($next_payment), (string) ($nama_lengkap), (string) ($urut_byr_baru), (string) ($efektif_date), (string) ($nonew)]); 

	$resource_update_payment = db_query_or_die('errro_simpan', $query_update_receipt, $__p_query_update_receipt ?? []);	

	$query_update_receipt= q_set($__p_query_update_receipt, "update billing.tb_receipt set  note= ? where no = ? ", ["Move " . (string) ($id_rcp), (string) ($noold)]); 

	$resource_update_payment = db_query_or_die('errro_simpan', $query_update_receipt, $__p_query_update_receipt ?? []);	 
	 
	echo "<script type=\"text/javascript\">\n";
	echo "alert('VIP Receipt Submitted');\n";
	echo "window.opener.location.reload(true);\n";
	echo "window.close(); \n";				
	echo "</script>";
	}
	else
	{
	echo "<script type=\"text/javascript\">\n";
	echo "alert('" . e($gagal) . "');\n";
	echo "</script>";		
	}
		
	}
?>