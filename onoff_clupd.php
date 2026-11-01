<?php
require_once __DIR__ . "/_lib/bootstrap.php"; csrf_guard_get(); auth_require_login(); 
include __DIR__ . "/conndb.php";
include __DIR__ . "/profiledata.php";
$no = in_val('no', 'any');
$query_kelas = q_set($__p_query_kelas, "SELECT kelas, kd_branch, mulai_tm, nm_teacher,date_format(selesai_tm,'%k:%i'),room,date_format(mulai_tm,'%Y-%m-%d'),urutan,date_format(mulai_tm,'%k:%i'),kode_program,level_program,skill, type_kelas FROM ves_data.vip_teacher_schedule v where id = ? ", [(string) ($no)]);
$resource_kelas= db_query_or_die('errro_visitor1', $query_kelas, $__p_query_kelas ?? []);
$keluar_kelas= db_num_rows($resource_kelas);
	if(num(db_num_rows($resource_kelas)) > 0)
		{
		while ($row_kelas =   db_fetch($resource_kelas, PDO::FETCH_NUM))
			{
			$kdcl = $row_kelas[0];
			$kdcbg = $row_kelas[1];	
			$tgl_meeting_lama = $row_kelas[6];
			$teacher_lama = $row_kelas[3];	
			$end_schedule_lama = $row_kelas[4];
			$room_lama = $row_kelas[5];	
			$tgl_lama = $row_kelas[6];
			$urutan_lama = $row_kelas[7];
			$start_schedule_lama = $row_kelas[8];	
			$tgl_lengkap_lama = $row_kelas[2];
$kode_program	 = $row_kelas[9];
	$nm_level = $row_kelas[10];
	$skill = $row_kelas[11];	
	$class_metodh = $row_kelas[12];			
			}
		}
$nama_lengkap = $_SESSION['nama_lengkap'];               
if($center =='East Sby'){$kd_center = '1';}
if($center =='West Sby'){$kd_center = '2';}
if($center =='Bali'){$kd_center = '3';}
if($center =='South Jkt'){$kd_center = '4';}
if($center =='North Jkt'){$kd_center = '5';}
if($center =='West Jkt'){$kd_center = '6';}
if($center =='Bandung'){$kd_center = '7';}
if($center =='Malang'){$kd_center = '8';}	

$mulai_kelas_baru = in_val('mulai_kelas_baru', 'any');
if($mulai_kelas_baru ==''){ $mulai_kelas_baru = $tgl_lama;}
$nm_teacher_baru = in_val('nm_teacher_baru', 'any');
if($nm_teacher_baru == ''){$nm_teacher_baru =  $teacher_lama;}
$room_baru = in_val('room_baru', 'any');
if($room_baru == ''){$room_baru = $room_lama;}
$start_schedule = in_val('start_schedule', 'any');
if ($start_schedule == ''){$start_schedule = $start_schedule_lama;}
$end_schedule = in_val('end_schedule', 'any');
if ($end_schedule == ''){$end_schedule = $end_schedule_lama;}

$remark_schedule = in_val('remark_schedule', 'any');
//$query_nm_teacher = "SELECT b.nm_teacher FROM ves_data.vip_teacher_schedule a left join ves_data.vip_teacher_name b on a.nm_teacher = b.kd_teacher  where kelas = '$kode_kelas' group by a.nm_teacher";

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

<div class="wrapper">

  <!-- Left side column. contains the logo and sidebar -->
  

  <!-- Content Wrapper. Contains page content -->
  <div class="content">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>Modify Detail Schedule</h1>
    </section>
 <form method="post"><?php echo csrf_field(); ?> 
    <!-- Main content -->
<section class="content">
  <div class="row">
<form role="form" method="post"><?php echo csrf_field(); ?>

    <div class="col-md-12">
		  	<div class="box box-warning">
		  		<div class="box-header with-border"></div>
           	  <div class="box-body">
           	    <div class="col-md-3">
           	      <div class="form-group">
           	        <label>Class Code
           	          <input type="text" class="form-control"  placeholder="Enter CLass Code" name="kode_kelas_lama" value="<?php echo e($kdcl) ?>" readonly>
       	            </label>
       	          </div>
       	        </div>
           	    <div class="col-md-4">
           	      <div class="form-group">
           	        <label>Date Meeting
           	          <input type="text" class="form-control"  placeholder="Enter CLass Code" name="tgl_meeting_lama" value="<?php echo e($tgl_meeting_lama) ?>" readonly>
       	            </label>
       	          </div>
       	        </div>
           	    <div class="col-md-2">
           	      <div class="form-group">
           	        <label>Time Start</label>
           	        <input type="text" class="form-control"  placeholder="Enter CLass Code" name="start_schedule_lama" value="<?php echo e($start_schedule_lama) ?>" readonly>
           	      </div>
       	        </div>
           	    <div class="col-md-2">
           	      <div class="form-group">
           	        <label>Time End</label>
           	        <input type="text" class="form-control"  placeholder="Enter CLass Code" name="end_schedule_lama" value="<?php echo e($end_schedule_lama) ?>" readonly>
           	      </div>
       	        </div>
           	    <div class="col-md-3">
           	      <div class="form-group">
           	        <label>Room
           	          <input type="text" class="form-control"  placeholder="Enter CLass Code" name="room_lama" value="<?php echo e($room_lama) ?>" readonly>
       	            </label>
       	          </div>
       	        </div>
           	    <div class="col-md-3">
           	      <div class="form-group">
           	        <label>Teacher
           	          <input type="text" class="form-control"  placeholder="Enter CLass Code" name="teacher_lama" value="<?php echo e($teacher_lama) ?>" readonly>
       	            </label>
       	          </div>
       	        </div>
           	    <span class="form-group">
       	        <input type="text" name="no"value="<?php echo e($no) ?>" hidden>
       	        </span><span class="form-group">
       	        <input type="text" name="no"value="<?php echo e($no) ?>" hidden="">
       	        </span><span class="form-group">
       	        <input type="text" name="tgl_lama"value="<?php echo e($tgl_lama) ?>"hidden>
       	        </span><span class="form-group">
       	        <input type="text" name="kdcbg"value="<?php echo e($kdcbg) ?>"hidden>
       	        <input type="text" name="urutan"value="<?php echo e($urutan_lama) ?>" hidden="">
       	        </span><span class="form-group">
       	        <input type="text" name="tgl_lama"value="<?php echo e($tgl_meeting_lama) ?>" hidden="">
       	        </span><span class="form-group">
       	        <input type="text" name="tgl_lengkap_lama"value="<?php echo e($tgl_lengkap_lama) ?>" hidden="">
       	        </span><span class="form-group">
       	        <input type="text" name="kode_program"value="<?php echo e($kode_program) ?>" hidden="">
       	        </span><span class="form-group">
       	        <input type="text" name="nm_level"value="<?php echo e($nm_level) ?>" hidden="">
       	        </span></div> 
			</div>
<div class="box box-warning">
  <div class="box-header with-border"><strong>New Class Metodh</strong></div>
  <div class="box-body"></div>
</div>
<div class="col-md-3">
       	          <div class="form-group">
       	            <label>Class Metodh</label>
       	            <select class="form-control" name="class_metodh">
					<option value="Offline">Offline</option>						
					<option value="Online">Online</option>
					<option value="Hybrid">Hybrid</option>						
       	              <option selected><?php echo  e($class_metodh) ?></option>
   	                </select>
   	              </div>
</div>
<div class="box-body"></div>

<input type="submit" name="Submit" value="Submit" />
</form>

</body>
</html>
<?php
if (($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['Submit']))) 
{
$fullurl="http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
if($kdcbg =='1'){$center = 'East Sby';}
if($kdcbg =='2'){$center = 'West Sby';}
if($kdcbg =='3'){$center = 'Bali';}
if($kdcbg =='4'){$center = 'South Jkt';}
if($kdcbg =='5'){$center = 'North Jkt';}
if($kdcbg =='6'){$center = 'West Jkt';}
if($kdcbg =='7'){$center = 'Bandung';}
if($kdcbg =='8'){$center = 'Malang';}		
$hari=date("d");
$bulan=date("m");
$tahun=date("Y");
$hari_ini = date("Y-m-d h:i:s");	
$nm_teacher = in_val('nm_teacher', 'any');
$kode_kelas = in_val('kode_kelas', 'any');
$no = in_val('no', 'any');
$mulai_kelas = in_val('mulai_kelas', 'any');
$room = in_val('room', 'any');
$start_schedule = in_val('start_schedule', 'any');
$end_schedule = in_val('end_schedule', 'any');
$remark_schedule = in_val('remark_schedule', 'any');
if ($remark_schedule ==''){$remark_schedule ='Changing Schedule';}	
$tgl_asli = in_val('tgl_asli', 'any');
$skill = in_val('skill', 'any');	
$nama_lengkap = 	$_SESSION['nama_lengkap'];
$mulai_kelas_baru = in_val('mulai_kelas_baru', 'any');
$nm_teacher_baru = in_val('nm_teacher_baru', 'any');
$room_baru = in_val('room_baru', 'any');
$start_schedule = in_val('start_schedule', 'any');
$end_schedule = in_val('end_schedule', 'any');
$remark_schedule = in_val('remark_schedule', 'any');
$tgl_lama = in_val('tgl_lama', 'any');
$room_lama = in_val('room_lama', 'any');
$teacher_lama = in_val('teacher_lama', 'any');
$no = in_val('no', 'any');
$class_metodh = in_val('class_metodh', 'any');	

{
$query_update = q_set($__p_query_update, "update  ves_data.vip_teacher_schedule set type_kelas = ?  where id = ? ", [(string) ($class_metodh), (string) ($no)]);	
$resource_update= db_query_or_die('errro_simpan2', $query_update, $__p_query_update ?? []);	
echo "<script type=\"text/javascript\">\n";
echo "alert('Class Metodh sudah dirubah oleh " . e($nama_lengkap) . "');\n";
echo "window.opener.location.reload(true);\n";								
echo "window.close();\n";				
echo "</script>";
}
}
?>
