<?php
// Popup konfirmasi hapus order meeting (dari vip_order_list.php).
// Versi lama: GET tanpa login/token dan bisa menghapus jadwal apa pun lewat id.
// Sekarang: wajib login, POST + token CSRF, dan hanya order berstatus Booking/Rejected
// (sama dengan kondisi tombol Delete di vip_order_list.php) yang bisa dihapus.
include __DIR__ . "/conndb.php";
include __DIR__ . "/profiledata.php";
auth_require_login();
$hari=date("d");
$bulan=date("m");
$tahun=date("Y");
$tgl_hari_ini =  "$tahun-$bulan-$hari";
$nama_lengkap = $_SESSION['nama_lengkap'];
$st = in_str('st', 3);
$id = in_int('id', 0);

// status Booking (50,60,70,80,90) dan Rejected (52,62,72,82,92)
const STATUS_ORDER_BOLEH_HAPUS = ['50', '60', '70', '80', '90', '52', '62', '72', '82', '92'];
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
 <?php //  include ("left.php");	 ?>
 <?php //====================== ?>
<body class="hold-transition skin-blue sidebar-mini">
  <!-- Left side column. contains the logo and sidebar -->
  <!-- Content Wrapper. Contains page content -->
  <div class="content">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      Delete Confirmation <br>

      <!--/.col (left) -->
        <!-- right column -->
 <form method="post"><?php echo csrf_field(); ?>
 <span class="form-group">
 <input type="hidden" ang="en-150" class="form-control"  placeholder="Enter ..." name="id"
                 	      value="<?php echo e($id) ?>">
 </span>
 <input type="submit" name="Yes" value="Yes" />
<input type="submit" name="No" value="No" />
 </form>
</body>

</html>
<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['Yes']))
	{
	$id = in_int('id', 0, 'post');
	$jadwal = db_row("SELECT id, nm_teacher, kelas, mulai_tm, status_kelas, kd_biodata FROM ves_data.vip_teacher_schedule WHERE id = ?", [$id]);
	if ($jadwal === null || !in_array((string) $jadwal['status_kelas'], STATUS_ORDER_BOLEH_HAPUS, true))
		{
		error_log(sprintf('vip_del_conf ditolak: user %s, id %s, status %s', $_SESSION['kd_staff'], $id, $jadwal['status_kelas'] ?? '-'));
		js_alert('Hanya order berstatus Booking/Rejected yang bisa dihapus');
		exit;
		}
	db_exec("delete FROM ves_data.vip_teacher_schedule where id = ?", [$id]);
	error_log(sprintf('Order dihapus oleh %s (kd_staff %s): %s', $nama_lengkap, $_SESSION['kd_staff'], json_encode($jadwal)));
echo "<script type=\"text/javascript\">\n";
echo "if (window.opener) { window.opener.location.reload(true); }\n";
echo "window.close(); \n";
echo "</script>";
	}
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['No']))
	{
echo "<script type=\"text/javascript\">\n";
	echo "if (window.opener) { window.opener.location.reload(true); }\n";
	echo "window.close(); \n";
	echo "</script>";
	}
?>
