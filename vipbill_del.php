<?php
// Popup hapus tagihan (vip_billing_payment) dari vipbill.php.
// Versi lama: tanpa login, GET, dan "where no = $no" tanpa kutip (SQL injection: no=1 or 1=1
// menghapus semua pembayaran). Sekarang: wajib login, POST + token CSRF, id angka, dan hanya
// tagihan berstatus 'unpaid' (sama dengan kondisi link Delete di vipbill.php) yang bisa dihapus.
include __DIR__ . "/conndb.php";
include __DIR__ . "/profiledata.php";
auth_require_login();
$no = in_int('no', 0);
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
      <h1>Billing  Delete</h1>
    </section>
    <form method="post" role="form"><?php echo csrf_field(); ?>
    <!-- Main content -->
<section class="content">
  <div class="row">
        <!-- left column -->
        <!--/.col (left) -->
        <!-- right column -->
    <div class="col-md-12">
    <div class="box box-warning">
<p>
<div class="box-body">
  <p>&nbsp;</p>
</div>
</p><div class="box box-warning">
  </p>
  <div class="box-body"></div>

<div class="box box-warning">
<div class="box-header with-border"><strong>Are you sure to delete </strong>
  <input type="text" name="no" id="textfield" value="<?php echo e($no) ?>" hidden="">
  <input type="submit" name="Submit" value="YES" />
</div>
<div class="box-body"></div>
</form>

</body>
</html>
<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['Submit']))
{
$no = in_int('no', 0, 'post');
$tagihan = db_row("SELECT no, kd_billing, kd_biodata, jns_payment, amount, status FROM ves_data.vip_billing_payment WHERE no = ?", [$no]);
if ($tagihan === null || $tagihan['status'] !== 'unpaid')
	{
	error_log(sprintf('vipbill_del ditolak: user %s, no %s, status %s', $_SESSION['kd_staff'], $no, $tagihan['status'] ?? '-'));
	js_alert('Hanya tagihan berstatus unpaid yang bisa dihapus');
	exit;
	}
db_exec("delete FROM ves_data.vip_billing_payment where no = ?", [$no]);
error_log(sprintf('Tagihan dihapus oleh %s (kd_staff %s): %s', $_SESSION['nama_lengkap'], $_SESSION['kd_staff'], json_encode($tagihan)));

echo "<script type=\"text/javascript\">\n";
echo "if (window.opener) { window.opener.location.reload(true); }\n";
echo "window.close(); \n";
echo "</script>";
}


?>
