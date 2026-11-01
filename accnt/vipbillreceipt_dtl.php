<?php
require_once __DIR__ . "/../_lib/bootstrap.php"; csrf_guard_get(); auth_require_login(); 
ini_set("memory_limit","256M");
include __DIR__ . "/../conndb.php";
include __DIR__ . "/../profiledata.php";
$hari=date("d");
$bulan=date("m");
$tahun=date("Y");
$tgl_hari_ini =  "$tahun-$bulan-$hari";
$nama_lengkap = $_SESSION['nama_lengkap']; 
$no = in_val('id', 'any');
$kd_branch = $_SESSION['kd_branch'];

$query = q_set($__p_query, "SELECT a.no, a.kd_billing,  a.amount,b.nama_lengkap,c.book_title, a.jns_payment,a.id_receipt,a.dt_payment,a.pay_mtd  FROM ves_data.vip_billing_payment a left join ves_data.vip_student_data b  on a.kd_biodata = b.kd_biodata left join ves_data.vip_billing c on a.kd_billing = c.kd_billing  where a.no = ? ", [(string) ($no)]);

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
		$id_receipt = $row[6];
		$efektif_date = $row[7];		
		$payment_metodh = $row[8];

		$no_old = $row[0];
		$idb_old = $row[1];
		$rupiah_old = $row[2];
		$nama_old = $row[3];	
		$book_title_old = $row[4];	
		$jns_payment_old = $row[5];	
		$id_receipt_old = $row[6];
		$efektif_date_old = $row[7];		
		$payment_metodh_old = $row[8];	
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
  <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../css/font-awesome/css/font-awesome.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="../css/ionicons/css/ionicons.min.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="../plugins/datatables/dataTables.bootstrap.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../dist/css/AdminLTE.min.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="../dist/css/skins/_all-skins.min.css">
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
  <div class="col-md-3">
    <div class="form-group">
      ID Receipt : <?php echo e($id_receipt) ?>
      <input type="hidden" ang="en-150" class="form-control"  placeholder="Enter ..." name="no" 
                 	      value="<?php echo e($no) ?>">
      <input type="hidden" ang="en-150" class="form-control"  placeholder="Enter ..." name="idb" 
                 	      value="<?php echo e($idb) ?>">
    </div>
  </div>
  <div class="col-md-3">
    <div class="form-group">
      ID Billing : <?php echo e($idb) ?>
      <input type="hidden" ang="en-150" class="form-control"  placeholder="Enter ..." name="idb2" 
                 	      value="<?php echo e($idb) ?>">
    </div>
  </div>
  <div class="col-md-4">
    <div class="form-group">
      Student Name :<?php echo e($nama) ?>
    </div>
</div>
  <div class="col-md-8">
    <div class="form-group">
      <label>Amount</label>
      <input type="text" ang="en-150" class="form-control"  placeholder="Enter ..." name="rupiah" 
                 	      value="<?php echo e($rupiah) ?>">
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
			$query_book = q_set($__p_query_book, "SELECT v.buku FROM ves_data.vipbookin v where kd_branch = ? group by v.buku", [(string) ($kd_branch)]);
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
        <option selected="selected"><?php echo e($payment_metodh) ?></option>
      </select>
    </div>
</div>
  <div class="col-md-4">
    <div class="form-group">
      <label>Payment For</label>
      <select name="jns_payment" id="program_clasifie4" class="form-control" >
        <option value= "Registration">Registration</option>
        <option value= "Material">Material</option>
        <option value= "Full Payment">Full Payment</option>
        <option value= "Down Payment">Down Payment</option>
        <option value= "Installment 1">Installment 1</option>
        <option value= "Installment 2">Installment 2</option>
        <option value= "Installment 3">Installment 3</option>
        <option selected="selected">
          <?php  echo e($jns_payment)    ?>
          </option>
      </select>
    </div>
  </div>
  <div class="col-md-4">
    <div class="form-group">
      <label>Effective Date</label>
      <input type="date" ang="en-150" class="form-control"  placeholder="Enter ..." name="efektif_date" 
                 	      value="<?php echo e($efektif_date) ?>">
    </div>
  </div>
</div>    
<div class="box-body">
  <div class="col-md-8">
    <div class="form-group">
      <label>Remark Changed</label><input type="text" ang="en-150" class="form-control"  placeholder="Enter ..." name="remark" 
                 	      value="<?php echo e($remark_changed) ?>">
    </div>
  </div>
  <span class="form-group">
  <input type="hidden" ang="en-150" class="form-control"  placeholder="Enter ..." name="rupiah_old" 
                 	      value="<?php echo e($rupiah_old)  ?>">
  </span><span class="form-group">
  <input type="hidden" ang="en-150" class="form-control"  placeholder="Enter ..." name="jns_payment_old" 
                 	      value="<?php echo e($jns_payment_old) ?>">
  </span><span class="form-group">
  <input type="hidden" ang="en-150" class="form-control"  placeholder="Enter ..." name="efektif_date_old" 
                 	      value="<?php echo e($efektif_date_old)  ?>">
  </span><span class="form-group">
  <input type="hidden" ang="en-150" class="form-control"  placeholder="Enter ..." name="book_title_old" 
                 	      value="<?php echo e($book_title_old)  ?>">
  </span><span class="form-group">
  <input type="hidden" ang="en-150" class="form-control"  placeholder="Enter ..." name="payment_metodh_old" 
                 	      value="<?php echo e($payment_metodh_old) ?>">
  </span><span class="form-group">
  <input type="hidden" ang="en-150" class="form-control"  placeholder="Enter ..." name="id_receipt_old" 
                 	      value="<?php echo e($id_receipt_old) ?>">
  </span></div>
<div class="box-body"></div></form><input type="submit" name="Submit" value="Submit" />
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
	$jns_payment = in_val('jns_payment', 'any');
	$rupiah = in_val('rupiah', 'any');	
	
	
		
	$hari=date("d");$bulan=date("m");$tahun=date("Y");
	$hari_ini = "$tahun-$bulan-$hari";		
	$kd_branch = $_SESSION['kd_branch'];
	$nama_lengkap = $_SESSION['nama_lengkap']; 
	$idb = in_val('idb', 'any');
	$id_receipt_old= in_val('id_receipt_old', 'any');
$rupiah_old= in_val('rupiah_old', 'any');
$jns_payment_old= in_val('jns_payment_old', 'any');
$efektif_date_old= in_val('efektif_date_old', 'any');
$book_title_old= in_val('book_title_old', 'any');
$payment_metodh_old= in_val('payment_metodh_old', 'any');

		$query_update_receipt= q_set($__p_query_update_receipt, "update ves_data.vip_billing_payment set  jns_payment =? , amount=? ,  pay_mtd= ? ,dt_payment = ? where no = ? ", [(string) ($jns_payment), (string) ($rupiah), (string) ($payment_metodh), (string) ($efektif_date), (string) ($no)]); 

	$resource_update_payment = db_query_or_die('errro_simpan_1', $query_update_receipt, $__p_query_update_receipt ?? []);
	
		$query_simpan_payment= q_set($__p_query_simpan_payment, "insert into ves_data.vip_billing_payment_log (id_receipt,  jns_payment, amount, dt_payment, pay_mtd,pic, dt_entry,remark) \r
\t\tvalues \r
\t\t(? ,? ,? ,? ,? ,? ,? ,? )", [(string) ($id_receipt_old), (string) ($jns_payment_old), (string) ($rupiah_old), (string) ($efektif_date_old), (string) ($payment_metodh_old), (string) ($nama_lengkap), (string) ($hari_ini), (string) ($remark)]);

				$resource_simpan_payment = db_query_or_die('errro_simpan', $query_simpan_payment, $__p_query_simpan_payment ?? []);		
		$query_update_book = q_set($__p_query_update_book, "update ves_data.vip_billing set book_status = 'Booked' where kd_billing = ? ", [(string) ($idb)]);	
		$resource_update_book = db_query_or_die('errro_simpan_2', $query_update_book, $__p_query_update_book ?? []);
		$query_insert_booklog = q_set($__p_query_insert_booklog, "insert into  ves_data.vip_book_log (kd_billing, kd_branch, book_title, book_status, dt_entry, pic) values(? ,? ,? ,'Booked',? ,? )", [(string) ($idb), (string) ($kd_branch), (string) ($book_title), (string) ($tgl_hari_ini), (string) ($nama_lengkap)]);	
		$resource_insert_booklog = db_query_or_die('errro_simpan_3', $query_insert_booklog, $__p_query_insert_booklog ?? []);
		echo "<script type=\"text/javascript\">\n";
		echo "alert('VE Receipt Updated');\n";
		echo "window.opener.location.reload(true);\n";
		echo "window.close(); \n";				
		echo "</script>";

		
	}
?>