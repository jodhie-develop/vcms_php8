<?php
require_once __DIR__ . "/_lib/bootstrap.php"; auth_require_login(); 

date_default_timezone_set('Asia/Jakarta');
$class_code = in_val('cdl', 'get');
$cabang = in_val('cbg', 'get');
$start_date = in_val('start_date', 'get');
$end_date = in_val('end_date', 'get');
$hari=date("d");
$bulan=date("m");
$tahun=date("Y");
$dispname = in_val('disp', 'get');
$id = in_val('no', 'get');
include __DIR__ . "/conndb.php";
$nama_lengkap = $_SESSION['nama_lengkap']; 
$kd_staff = $_SESSION['kd_staff'];
echo e($kd_staff);
$query_periode = q_set($__p_query_periode, "SELECT date_format(a.jam_mulai,'%d %b %y'),date_format(a.jam_mulai,'%H:%i'), date_format(a.jam_selesai,'%H:%i'), a.kategori, a.aktivitas, a.cabang, b.nama_detail, a.dt_entry,a.id,a.pic FROM ves_data.activities a left join tb_user b on a.pic = b.no where a.id = ? ", [(string) ($id)]);

$resource_periode = db_query_or_die('errro_7', $query_periode, $__p_query_periode ?? []);
$keluar_periode= db_num_rows($resource_periode);
if(num(db_num_rows($resource_periode)) > 0)
	{
	while ($row_periode=  db_fetch($resource_periode, PDO::FETCH_NUM))
		{
		$tgl = $row_periode[0];
		$jam_mulai = $row_periode[1];
		$jam_selesai = $row_periode[2];
		$kategori = $row_periode[3];
		$aktivitas = $row_periode[4];
		$cabang = $row_periode[5];
		$pic = $row_periode[6];
		$dt_entry = $row_periode[7];	
			
if (num($cabang) == 1){$cabang = 'East Sby';}			
elseif (num($cabang) == 2){$cabang = 'West Sby';}			
elseif (num($cabang) == 3){$cabang = 'Denpasar';}			
elseif (num($cabang) == 4){$cabang = 'South Jkt';}			
elseif (num($cabang) == 5){$cabang = 'North Jkt';}			
elseif (num($cabang) == 6){$cabang = 'West Jkt';}			
elseif (num($cabang) == 7){$cabang = 'Bandung';}			
elseif (num($cabang) == 8){$cabang = 'Malang';}			
			
		}
	}

//include __DIR__ . "/profiledata.php";
 //include __DIR__ . "/atas.php";
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
  <link rel="stylesheet" href="css/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="css/ionicons/css/ionicons.min.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="plugins/datatables/dataTables.bootstrap.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
 
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/js/bootstrap-datepicker.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/css/bootstrap-datepicker.css"></link>   

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
</head>
<body class="hold-transition skin-blue sidebar-mini">

  <!-- 

 
 side column. contains the logo and sidebar -->
  

  <!-- Content Wrapper. Contains page content -->
  <div class="wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1><?php echo e($tgl) ?></h1>
      <h3><?php echo e($jam_mulai) ?> - <?php echo e($jam_selesai) ?></h3>
      
    </section>

    <!-- Main content -->
<section class="content">
  <div class="row">

<form role="form">
 <div class="box-header with-border">
  <div class='col-md-12' align="left">
		    <label><?php echo e($cabang) ?>  - <?php echo  e($kategori) ?></label>
      	  </div></div>     	  
	  <div class="col-md-12">
	    <div class="box box-warning">
		  		<div class="box-header with-border"></div>
		<?php echo e($aktivitas) ?><br>
    by: <?php echo e($pic) ?>
	    </div>				
	  </div>
<?php if($kd_staff == $row_periode[9]){?>          
        <div class="col-md-2">
          <div class="form-group"> <a href="activites_del.php" target="popup" 
onclick="window.open('activites_del.php','popup','width=600,height=900'); return false;" class="btn btn-danger" role="button">HAPUS</a> </div>
        </div>	
<?php } ?>          
</form>


    <!-- Horizontal Form -->
          <!-- /.box -->
          <!-- general form elements disabled -->
		  
            
            <!-- /.box-header --><!-- /.box-body --><!-- /.box --><!--/.col (right) --><!-- /.row --><!-- /.content -->
  </div>
  <!-- /.content-wrapper --><!-- Control Sidebar -->
  <!-- /.control-sidebar -->
  <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->

<!-- jQuery 2.2.3 -->
<script src="plugins/jQuery/jquery-2.2.3.min.js"></script>
<!-- Bootstrap 3.3.6 -->
<script src="bootstrap/js/bootstrap.min.js"></script>
<!-- FastClick -->
<script src="plugins/fastclick/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/app.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
</body>
</html>