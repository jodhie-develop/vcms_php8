<?php
require_once __DIR__ . "/_lib/bootstrap.php"; csrf_guard_get(); auth_require_login(); 
include __DIR__ . "/conndb.php";
include __DIR__ . "/profiledata.php";
$kd_staff = 		$_SESSION['kd_staff'];			
$nama_lengkap = 		$_SESSION['nama_lengkap'];

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
<link rel="stylesheet" type="text/css" href="dist/css/bootstrap-clockpicker.min.css">    

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
   <style>

function fScroll(val)
{
        var hidScroll = document.getElementById('hidScroll');
        hidScroll.value = val.scrollTop;
}

// function moves scroll position to saved value
function fScrollMove(what)
{
        var hidScroll = document.getElementById('hidScroll');
        document.getElementById(what).scrollTop = hidScroll.value;
}
.style92 {color: #FFFFFF; font-weight: bold; font-size: 13px; font-family: Calibri; }
</style>
    <script language="JavaScript">
function readCookie(name){
return(document.cookie.match('(^|; )'+name+'=([^;]*)')||0)[2]
}

</script><body onScroll="document.cookie='ypos=' + window.pageYOffset" onLoad="window.scrollTo(0,readCookie('ypos'))">
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

  <!-- Left side column. contains the logo and sidebar -->
  

  <!-- Content Wrapper. Contains page content -->
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>Scheduler Form</h1>
    </section>
 <form method="post"><?php echo csrf_field(); ?> 
    <!-- Main content -->

        <!-- left column -->
        <!--/.col (left) -->
        <!-- right column -->
<form role="form" method="post"><?php echo csrf_field(); ?>

    <div class="col-md-12">
		  	<div class="box box-warning">
		  		<div class="box-header with-border"></div>
           	  <div class="box-body">
           	    <div class="col-md-4">
           	      <div class="form-group">
           	        <label>Staff  Name</label>
           	        <input type="text" class="form-control"  placeholder="Enter ..." name="student_name" value="<?php echo e($nama_lengkap) ?>" readonly>
       	          </div>
       	        </div>
           	    <div class="col-md-3">
           	      <div class="form-group">
           	        <label>Center</label>
           	        <select class="form-control" name="center">
           	                       <option value="1">East Sby</option>
            
              <option value="1">East Sby</option>
              <option value="2">West Sby</option>
              <option value="3">Bali</option>
              <option value="4">South Jkt</option>
              <option value="5">North Jkt</option>
              <option value="6">West Jkt</option>
              <option value="7">Bandung</option>
              <option value="8">Malang</option>
       	            </select>
       	          </div>
       	        </div>
           	    <span class="form-group">
       	        <input type="text" name="kd_biodata"value="<?php echo e($kd_biodata) ?>" hidden>
       	        </span><span class="form-group">
       	        <input type="text" name="id"value="<?php echo e($id) ?>" hidden>
       	        </span><span class="form-group">
       	        <input type="text" name="kdcl"value="<?php echo e($kd_class) ?>" hidden>
       	        </span><span class="form-group">
       	        <input type="text" name="kdprg"value="<?php echo e($kd_program) ?>" hidden>
       	        </span><span class="form-group">
       	        <input type="text" name="t"value="<?php echo e($t) ?>" hidden>
       	        </span></div> 
			</div>
<div class="box box-warning">
<div class="box-header with-border"><strong>Class Period</strong></div>
<div class="box-body">
<div class="col-md-2">
               	      <div class="form-group">
                 	      <label>Date</label>
                 	      <input type="DATE" class="form-control"   placeholder="Enter ..." name="tanggalpilih" value="<?php echo e($tanggalpilih) ?>">
  </div>
</div>

  <div class="col-md-2">

    <div class="form-group">
      <label>Time Start</label>
      <input type="TIME" class="form-control"   placeholder="Enter ..." name="jam_mulai" value="<?php echo e($jam_mulai) ?>">
    </div>
</div>
  <div class="col-md-2">
    <div class="form-group">
      <label>Time End</label>
      <input type="TIME" class="form-control"   placeholder="Enter ..." name="jam_selesai" value="<?php echo e($jam_selesai) ?>">
    </div>
</div>
  <div class="col-md-2">
    <div class="form-group">
      <label>Activities</label>
      <select class="form-control"  name="groupaktifitas" required >
        <option>School Visit</option>
        <option>Marketing Event</option>
        <option>Internal Meeting</option>
        <option>Center Event</option>
        <option>Other</option>
        <option selected><?php echo  e($groupaktifitas) ?></option>
      </select>
    </div>
  </div>
  <div class="col-md-12">
    <div class="form-group">
      <label>Remark</label>
	<textarea class="textarea" placeholder="Place some text here" style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;" name="remark" required><?php echo  e($coverage) ?></textarea>
    </div>
</div>


<div class="col-md-6">
    <div class="form-group">
<input type="submit" name="Submit" value="Submit"  class="btn btn-primary active"/>
    </div>
</div>

</form>
		</div>
</body>
<script type="text/javascript" src="dist/js/bootstrap-clockpicker.min.js"></script>
</html>
<?php
if (($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['Submit']))) 
{
$center = in_val('center', 'any');
$tanggalpilih = in_val('tanggalpilih', 'any');
$jam_mulai = in_val('jam_mulai', 'any');
$jam_selesai = in_val('jam_selesai', 'any');
$groupaktifitas = in_val('groupaktifitas', 'any');
$remark = in_val('remark', 'any');
$hari=date("d");
$bulan=date("m");
$tahun=date("Y");
$hari_ini = "$tahun-$bulan-$hari";	
if($tanggalpilih ==''  or $jam_mulai =='' or $jam_selesai == '' or  $center =='' or $remark =='' or $groupaktifitas =='') 
	{
	echo "<script type=\"text/javascript\">\n";
	echo "alert('Semua data wajib terisi');\n";	
	echo "</script>";
	die;
	}
$jm_mulai = strtotime($jam_mulai);$jm_selesai = strtotime($jam_selesai);
if($jm_mulai >= $jm_selesai)	
	{
	echo "<script type=\"text/javascript\">\n";echo "alert('Periode Waktu salah');\n";	echo "</script>";die;
	}

	
$query_simpan_1 = q_set($__p_query_simpan_1, "insert into ves_data.activities (pic,cabang,jam_mulai,jam_selesai,kategori,aktivitas,dt_entry) \r
values (? ,? ,? ,? ,? ,? ,? )", [(string) ($kd_staff), (string) ($center), (string) ($tanggalpilih) . " " . (string) ($jam_mulai) . ":01", (string) ($tanggalpilih) . " " . (string) ($jam_selesai) . ":00", (string) ($groupaktifitas), (string) ($remark), (string) ($hari_ini)]);

$resource_simpan_1= db_query_or_die('errro_simpan1', $query_simpan_1, $__p_query_simpan_1 ?? []);		
echo "<script type=\"text/javascript\">\n";
echo "alert('New Scheduled has been set by " . e($nama_lengkap) . "');\n";
echo "window.opener.location.reload(true);\n";								
echo "window.close();\n";				
echo "</script>";	
	}
//selesai cek jadwal====================================	

?>
