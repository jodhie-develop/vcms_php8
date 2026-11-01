<?php
require_once __DIR__ . "/_lib/bootstrap.php"; auth_require_login(); 
ini_set("memory_limit","256M");
include __DIR__ . "/conndb.php";
include __DIR__ . "/profiledata.php";
$hari=date("d");
$bulan=date("m");
$tahun=date("Y");
$tgl_hari_ini =  "$tahun-$bulan-$hari";
$nama_lengkap = $_SESSION['nama_lengkap']; 
$no = in_val('no', 'get');
$kd_branch = $_SESSION['kd_branch'];



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
 <form method=get><form role="form">
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
if (isset($_GET['Submit'])) 
	{
	
echo "PHP Version : ".e(phpversion())."<br>";

if(!function_exists('curl_init'))
{
    die('cURL tidak tersedia');
}	
//=====modul wa==
$nomor = "6287856520268";
$pesan = "kirim pembayaran";

$token = (string) vcms_config('fonnte_token');

$data = array(
    "target"  => $nomor,
    "message" => $pesan
);

$curl = curl_init();

curl_setopt($curl, CURLOPT_URL, "https://api.fonnte.com/send");
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_POST, true);
curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));
	
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);	

$headers = array(
    "Authorization: " . $token
);

curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

$response = curl_exec($curl);

echo "<pre>";
echo "Response : ";
var_dump($response);

echo "\nError No : ";
var_dump(curl_errno($curl));

echo "\nError Msg : ";
var_dump(curl_error($curl));

echo "\nHTTP Code : ";
var_dump(curl_getinfo($curl, CURLINFO_HTTP_CODE));
echo "</pre>";

curl_close($curl);
	
//=====================	
	
		
	}
?>