<?php
include __DIR__ . "/conndb.php";
auth_require_login();
//====================
{
$kd_staff = $_SESSION['kd_staff'];
$st_quiz = null;
$resource_cek = db_query("SELECT st_quiz FROM tb_user WHERE no = ?", [$kd_staff]);
while ($row_cek = $resource_cek->fetch(PDO::FETCH_NUM))
	{
	$st_quiz = $row_cek[0];
	}

if ($st_quiz != 1)
	{

	echo "<script type=\"text/javascript\">\n";
	echo "alert('Untuk lebih meningkatkan fasilitas dan layanan vcms kedepan,mohon bantuan untuk mengisi survey singkat berikut');\n";
	echo "window.open('survey.php','popUpWindow','height=800,width=800,left=500,top=100,resizable=no,scrollbars=no,toolbar=no,menubar=no,location=no,directories=no, status=no');\n";				
	//echo "window.location='survey.php';\n";				

	echo "</script>";

 }
	
$nama_lengkap = $_SESSION['nama_lengkap'] ?? '';
$area = $_SESSION['area'] ?? '';
$kd_area = $_SESSION['kd_area'] ?? null;
$jamskrg = date("h:i:s");
$kd_staff = $_SESSION['kd_staff'];
$nama_depan = $_SESSION['nama_depan'] ?? '';
$kd_cbg = $_SESSION['kd_branch'] ?? '';
$cabang = $_SESSION['branch'] ?? '';

$hari_ini = $_SESSION['hari_ini'] ?? date('Y-m-d');
$jam_in_log = $_SESSION['jam_in_log'] ?? '';
db_exec(
	"update tb_report_user_login set tgl_out_log = ?, jam_out_log = ? where id_user_log = ? and tgl_in_log = ? and jam_in_log = ?",
	[$hari_ini, $jamskrg, $kd_staff, $hari_ini, $jam_in_log]
);

?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Vista Customer System Management</title>
  <?php echo csrf_script(); ?>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">


  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

  <header class="main-header">
    <!-- Logo -->
    <a href="index2.html" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><b>A</b>LT</span>
      <!-- logo for regular state and mobile devices --><b>V-CMS</b></a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </a>

    </nav>
</header>
 
<!-- ./wrapper -->

<!-- jQuery 2.2.3 -->
<script src="plugins/jQuery/jquery-2.2.3.min.js"></script>
<!-- Bootstrap 3.3.6 -->
<script src="bootstrap/js/bootstrap.min.js"></script>
<!-- DataTables -->
<script src="plugins/datatables/jquery.dataTables.min.js"></script>
<script src="plugins/datatables/dataTables.bootstrap.min.js"></script>
<!-- SlimScroll -->
<script src="plugins/slimScroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="plugins/fastclick/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/app.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
<!-- page script -->
<script>
  $(function () {
    $("#example1").DataTable();
    $('#example2').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false
    });
  });
</script>
</body>
</html>
<?php } ?>
