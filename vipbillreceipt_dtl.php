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
$no = in_val('no', 'any');
$kd_branch = $_SESSION['kd_branch'];

$query = q_set($__p_query, "SELECT a.no, a.kd_billing,  a.amount,b.nama_lengkap,c.book_title, a.jns_payment,a.kd_biodata  FROM ves_data.vip_billing_payment a left join ves_data.vip_student_data b  on a.kd_biodata = b.kd_biodata left join ves_data.vip_billing c on a.kd_billing = c.kd_billing  where a.no = ? ", [(string) ($no)]);
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
		$book_title = $row[4];	
		$jns_payment = $row[5];	
		$kdb = $row[6];			
		}
	}
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
      <label>ID Billing : <?php echo e($idb) ?></label>
      <input type="hidden" ang="en-150" class="form-control"  placeholder="Enter ..." name="idb" 
                 	      value="<?php echo e($idb) ?>">
    </div>
  </div>
  <div class="col-md-4">
    <div class="form-group">
      <label>Student Name :<br>
<?php echo e($nama) ?></label>
    </div>
  </div>
  <input type="hidden" name="kdb" id="textfield" value="<?php echo e($kdb) ?>">
  <div class="col-md-4">
    <div class="form-group">
      <label>Rupiah : <br>
        <?php echo e($rupiah) ?></label>
    </div>
</div>
  <span class="form-group">
  <input type="hidden" ang="en-150" class="form-control"  placeholder="Enter ..." name="no" 
                 	      value="<?php echo e($no) ?>" hidden= "hidden">
  </span></div>    
<div class="box-body">
 <?php if ($jns_payment ==  'Material'){ ?>
  <div class="col-md-5">
    <div class="form-group">
      <label>Book Title</label><select name="book_title"  id="payment_metodh" class="form-control" >
        <?php	
								$query_book = q_set($__p_query_book, "SELECT v.item FROM ves_data.mst_asset v group by v.item order by v.item");
								$resource_book = db_query_or_die('errro_7', $query_book, $__p_query_book ?? []);
								while ($row_book=  db_fetch($resource_book, PDO::FETCH_NUM))
									{
							  		echo '<option value="'.e($row_book[0]).'">'.e($row_book[0]).'</option>';
							  		}     ?>
	        <option selected><?php echo  e($book_title) ?></option>
      </select>
    </div>
  </div>
<?php } ?>  
  <div class="col-md-4">
    <div class="form-group">
      <label>Payment Metodh</label>
      <select name="payment_metodh"  id="jns_report2" class="form-control" >
        <option value="Debit Card">Debit Card</option>
        <option value="Credit Card">Credit Card</option>
        <option value="Cash">Cash</option>
        <option value="Transfer">Transfer</option>
        <option value="Dana Cita">Dana Cita</option>		  
        <option value="Cek-Bg">Cek-Bg</option>
        <option value="Voucher">Voucher</option>
        <option value="QRIS">QRIS</option>
		  
        <option selected="selected"><?php echo e($payment_metodh) ?></option>
      </select>
    </div>
</div>
</div>    
<div class="box-body">
  <div class="col-md-8">
    <div class="form-group">
      <label>NIK</label>
      <input type="text" ang="en-150" class="form-control"  placeholder="Enter ..." name="nik" 
                 	      value="<?php echo e($nik) ?>">
    </div>
  </div>
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
                 	      value="<?php echo e($tgl_hari_ini) ?>">
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
	$payment_metodh = in_val('payment_metodh', 'any');	
	if ($payment_metodh ==''){$st_simpan = 0;$gagal = "Payment method must be filled";}
	$efektif_date= in_val('efektif_date', 'any');
	$next_payment	= in_val('next_payment', 'any');
	$remark = in_val('remark', 'any');	
	$hari=date("d");
	$bulan=date("m");
	$kd_branch = $_SESSION['kd_branch'];
	$nama_lengkap = $_SESSION['nama_lengkap']; 
	$nik = in_val('nik', 'any');
	$kdb = in_val('kdb', 'any');
	
if (empty($_SESSION['nama_lengkap']) AND empty($_SESSION['kd_branch']))
{

		echo "<script type=\"text/javascript\">\n";
		echo "alert('Please Re-Login');\n";
		echo "window.opener.location.href('vip_sales_center.php');\n";
		echo "window.close(); \n";				
		echo "</script>";
	die;
 }	
	
	
	
	$idb = in_val('idb', 'any');
	if($bulan =='01'){$bln_rom="I";}
	elseif($bulan =='02'){$bln_rom="II";}
	elseif($bulan =='03'){$bln_rom="III";}
	elseif($bulan =='04'){$bln_rom="IV";}
	elseif($bulan =='05'){$bln_rom="V";}
	elseif($bulan =='06'){$bln_rom="VI";}
	elseif($bulan =='07'){$bln_rom="VII";}
	elseif($bulan =='08'){$bln_rom="VIII";}
	elseif($bulan =='09'){$bln_rom="IX";}
	elseif($bulan =='10'){$bln_rom="X";}
	elseif($bulan =='11'){$bln_rom="XI";}
	elseif($bulan =='12'){$bln_rom="XII";}
	$tahun=date("Y");
	$thn = substr($tahun,-2);	
	$hari_ini = "$tahun-$bulan-$hari";		
	if ($next_payment ==$hari_ini)	{$next_payment='';}
		//=nbuat id receipt==
	//===banding no receipt=====
		//baru//
	$query_last_receipt_baru = q_set($__p_query_last_receipt_baru, "SELECT mid(id_receipt,1,4),urut_byr FROM ves_data.vip_billing_payment where  kd_branch = ? and status = 'PAID' order by mid(id_receipt,1,4) desc limit 1", [(string) ($kd_branch)]);
	$resource_last_receipt_baru = db_query_or_die('errro_last_billing1', $query_last_receipt_baru, $__p_query_last_receipt_baru ?? []);
	if(num(db_num_rows($resource_last_receipt_baru)) > 0)
		{
		while ($row_last_receipt_baru=  db_fetch($resource_last_receipt_baru, PDO::FETCH_NUM))
			{
			$last_baru = $row_last_receipt_baru[0];		
			$urut_byr = $row_last_receipt_baru[1];					
			}
		}		
	#ketemu angka awal(angka sebelumnya) + dengan 1
	$nextangka=num($last_baru) + 1;
	if (num($last_baru) <= 9){$nol = '000';}	
	elseif (num($last_baru) <= 99){$nol = '00';}
	elseif (num($last_baru) >= 99 and num($last_baru) <=999){$nol = '0';}
	elseif (num($last_baru) >= 1000){$nol = '';}
	$nomor_baru = $nol.$nextangka."/VIP/RCP/0".$kd_branch."/".$bln_rom."-".$thn;	
	$id_rcp = $nomor_baru;
	$urut_byr_baru = num($urut_byr)+1;
	if (num($st_simpan)==1)
		{	
		$query_update_receipt= q_set($__p_query_update_receipt, "update ves_data.vip_billing_payment set  pay_mtd= ? , remark = ? , id_receipt = ? ,\r
\t\tdt_payment = ? , pic = ? , status = 'PAID',next_payment = ? ,admin_receipt = ? ,urut_byr = ? ,dt_cetak = ? where no = ? ", [(string) ($payment_metodh), (string) ($remark), (string) ($id_rcp), (string) ($efektif_date), (string) ($nama_lengkap), (string) ($next_payment), (string) ($nama_lengkap), (string) ($urut_byr_baru), (string) ($tgl_hari_ini), (string) ($no)]); 
		$resource_update_payment = db_query_or_die('errro_simpan_1', $query_update_receipt, $__p_query_update_receipt ?? []);	
		$query_update_book = q_set($__p_query_update_book, "update ves_data.vip_billing set book_status = 'Booked' where kd_billing = ? ", [(string) ($idb)]);	
		$resource_update_book = db_query_or_die('errro_simpan_2', $query_update_book, $__p_query_update_book ?? []);
		$query_insert_booklog = q_set($__p_query_insert_booklog, "insert into  ves_data.vip_book_log (kd_billing, kd_branch, book_title, book_status, dt_entry, pic) values(? ,? ,? ,'Booked',? ,? )", [(string) ($idb), (string) ($kd_branch), (string) ($book_title), (string) ($tgl_hari_ini), (string) ($nama_lengkap)]);	
		$resource_insert_booklog = db_query_or_die('errro_simpan_3', $query_insert_booklog, $__p_query_insert_booklog ?? []);
		//=====NIK
	$query_nik = q_set($__p_query_nik, "SELECT nik FROM ves_data.tb_nik  where kd_biodata = ? ", [(string) ($kdb)]);	
	$resource_nik = db_query_soft($query_nik, $__p_query_nik ?? []);
	$keluar_nik = db_num_rows($resource_nik);
	if(num(db_num_rows($resource_nik)) > 0)
		{
	$query_updnik = q_set($__p_query_updnik, "update ves_data.tb_nik set nik = ?  where kd_biodata = ? ", [(string) ($nik), (string) ($kdb)]);	
	$resource_updnik = db_query_soft($query_updnik, $__p_query_updnik ?? []);		
		}
	else
		{
	$query_insnik = q_set($__p_query_insnik, "insert into  ves_data.tb_nik (nik,kd_biodata) values (? ,? )", [(string) ($nik), (string) ($kdb)]);	
	$resource_insnik = db_query_soft($query_insnik, $__p_query_insnik ?? []);			
		}
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