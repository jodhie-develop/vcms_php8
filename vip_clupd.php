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
  <div class="box-header with-border"><strong>New Schedule</strong></div>
  <div class="box-body">
    <div class="col-md-3">
      <div class="form-group">
        <label>Date</label>
        <input type="date" class="form-control"  placeholder="Enter ..." name="mulai_kelas_baru" value="<?php echo e($mulai_kelas_baru) ?>"  >
      </div>
    </div>
    <div class="col-md-3">
      <div class="form-group">
        <label>Teacher Name</label>
        <select class="form-control" name="nm_teacher_baru" onChange="this.form.submit()">
                  			  <?php
								$query_nm_teacher = q_set($__p_query_nm_teacher, "SELECT nm_teacher, kd_teacher FROM ves_data.vip_teacher_name order by kd_teacher");
								$resource_nm_teacher = db_query_or_die('errro_7', $query_nm_teacher, $__p_query_nm_teacher ?? []);
								while ($row_nm_teacher=  db_fetch($resource_nm_teacher, PDO::FETCH_NUM))
									{
							  		echo '<option value="'.e($row_nm_teacher[1]).'">'.e($row_nm_teacher[1]).'-'.e($row_nm_teacher[0]).'</option>';
							  		}      ?>
							  		<option selected><?php echo  e($nm_teacher_baru) ?></option>
       			  </select>
      </div>
    </div>
    <div class="col-md-2">
      <div class="form-group">
        <label>Room</label>
        <select class="form-control" name="room_baru" required>
          <?php
								$query_room = q_set($__p_query_room, "SELECT kd_room FROM ves_data.vip_room_name where kd_branch = ? ", [(string) ($kdcbg)]);
								$resource_room = db_query_or_die('errro_7', $query_room, $__p_query_room ?? []);
								while ($row_room=  db_fetch($resource_room, PDO::FETCH_NUM))
									{
							  		echo '<option value="'.e($row_room[0]).'">'.e($row_room[0]).'</option>';
							  		}      ?>
          <option selected><?php echo  e($room_baru) ?></option>
        </select>
      </div>
    </div>
    <div class="col-md-2">
      <div class="form-group">
        <label>Time Start</label>
        <select class="form-control" name="start_schedule" required>
          <option>07:00</option>
<option>07:15</option>
<option>07:30</option>
<option>07:45</option>      
<option>08:00</option>
<option>08:15</option>
<option>08:30</option>
<option>08:45</option>
<option>09:00</option>
<option>09:15</option>
<option>09:30</option>
<option>09:45</option>
<option>10:00</option>
<option>10:15</option>
<option>10:30</option>
<option>10:45</option>
<option>11:00</option>
<option>11:15</option>
<option>11:30</option>
<option>11:45</option>
<option>12:00</option>
<option>12:15</option>
<option>12:30</option>
<option>12:45</option>
<option>13:00</option>
<option>13:15</option>
<option>13:30</option>
<option>13:45</option>
<option>14:00</option>
<option>14:15</option>
<option>14:30</option>
<option>14:45</option>
<option>15:00</option>
<option>15:15</option>
<option>15:20</option>		  
<option>15:30</option>
<option>15:45</option>
<option>16:00</option>
<option>16:15</option>
<option>16:30</option>
<option>16:45</option>
<option>17:00</option>
<option>17:15</option>
<option>17:30</option>
<option>17:45</option>
<option>18:00</option>
<option>18:15</option>
<option>18:20</option>			
<option>18:30</option>
<option>18:45</option>
<option>19:00</option>
<option>19:15</option>
<option>19:30</option>
<option>19:45</option>
<option>20:00</option>
<option>20:15</option>
<option>20:30</option>
<option>20:45</option>
<option>21:00</option>
<option>21:15</option>			
<option>21:30</option>
<option>22:00</option>
<option>22:15</option>			
			
<option>22:30</option>
<option>23:00</option>
<option>23:15</option>			
			
<option>23:30</option>
<option>24:00</option>
          <option selected><?php echo e($start_schedule) ?></option>
        </select>
      </div>
    </div>
    <div class="col-md-2">
      <div class="form-group">
        <label>Time End</label>
        <select class="form-control" name="end_schedule" required>
          <option>07:00</option>
<option>07:15</option>
<option>07:30</option>
<option>07:45</option>      
<option>08:00</option>
<option>08:15</option>
<option>08:30</option>
<option>08:45</option>
<option>09:00</option>
<option>09:15</option>
<option>09:30</option>
<option>09:45</option>
<option>10:00</option>
<option>10:15</option>
<option>10:30</option>
<option>10:45</option>
<option>11:00</option>
<option>11:15</option>
<option>11:30</option>
<option>11:45</option>
<option>12:00</option>
<option>12:15</option>
<option>12:30</option>
<option>12:45</option>
<option>13:00</option>
<option>13:15</option>
<option>13:30</option>
<option>13:45</option>
<option>14:00</option>
<option>14:15</option>
<option>14:30</option>
<option>14:45</option>
<option>15:00</option>
<option>15:15</option>
<option>15:20</option>		  
<option>15:30</option>
<option>15:45</option>
<option>16:00</option>
<option>16:15</option>
<option>16:30</option>
<option>16:45</option>
<option>17:00</option>
<option>17:15</option>
<option>17:30</option>
<option>17:45</option>
<option>18:00</option>
<option>18:15</option>
<option>18:30</option>
<option>18:45</option>
<option>19:00</option>
<option>19:15</option>
<option>19:30</option>
<option>19:45</option>
<option>20:00</option>
<option>20:15</option>
<option>20:30</option>
<option>20:45</option>
<option>21:00</option>
<option>21:15</option>			
<option>21:30</option>
<option>22:00</option>
<option>22:15</option>						
<option>22:30</option>
<option>23:00</option>
<option>23:15</option>						
<option>23:30</option>
<option>24:00</option>
          <option selected><?php echo e($end_schedule) ?></option>
        </select>
      </div>
    </div>
  </div>
</div>
<div class="col-md-4">
  <div class="form-group">
    <label>Skill</label>
    <input type="text" class="form-control"  placeholder="Reason" name="skill" value="<?php echo e($skill) ?>">
    </label>
  </div>
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
<div class="col-md-4">
  <div class="form-group">
	  <label>Remark</label>
<input type="text" class="form-control"  placeholder="Reason" name="remark_schedule" value="<?php echo e($remark_schedule) ?>">
    </label>
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
$start_schedule_lama = in_val('start_schedule_lama', 'any');
$end_schedule_lama = in_val('end_schedule_lama', 'any');
$kode_program = in_val('kode_program', 'any');	
$nm_level = in_val('nm_level', 'any');
$class_metodh = in_val('class_metodh', 'any');	
$query_liburan = q_set($__p_query_liburan, "select keterangan from day_off where date_off = ? ", [(string) ($mulai_kelas_baru)]);
$result_liburan=db_query_or_die("Wah error nih1", $query_liburan, $__p_query_liburan ?? []);
if(num(db_num_rows($result_liburan)) > 0)
	{
	while ($row_libur=  db_fetch($result_liburan, PDO::FETCH_NUM))
		{
		$keterangan = $row_libur[0];
		$dihitung = 0;
		$catatan = $keterangan;
		$status_kelas = 0;	
		echo "<script type=\"text/javascript\">\n";
		echo "alert('(" . e($mulai_kelas_baru) . ") Hari Libur " . e($keterangan) . " ');\n";	
		echo "</script>";
		die;			
		}
	}	
	
	
	
if ($tgl_lama == $mulai_kelas_baru and $room_lama == $room_baru and $start_schedule_lama == $start_schedule 
	and $end_schedule_lama ==$end_schedule and $teacher_lama != $nm_teacher_baru)
	{

	$query_cek_teacher = q_set($__p_query_cek_teacher, "SELECT nm_teacher, mulai_tm, selesai_tm,room,center,kelas,date_format(mulai_tm,'%d %m %y'),date_format(mulai_tm,'%H:%i %p'), date_format(selesai_tm,'%H:%i %p')  FROM ves_data.vip_teacher_schedule WHERE kelas <> ? and (status_kelas <> 0 and status_kelas <> 52  and status_kelas <> 62 and status_kelas <> 72 and status_kelas <> 82 and status_kelas <> 92)and   (nm_teacher =? and nm_teacher <> 'SAL') and ((mulai_tm >= ? AND mulai_tm <= ? ) OR\r
\t(selesai_tm >= ? AND selesai_tm <= ? ))", [(string) ($kdcl), (string) ($nm_teacher_baru), (string) ($mulai_kelas_baru) . " " . (string) ($start_schedule) . ":01", (string) ($mulai_kelas_baru) . " " . (string) ($end_schedule) . ":00", (string) ($mulai_kelas_baru) . " " . (string) ($start_schedule) . ":01", (string) ($mulai_kelas_baru) . " " . (string) ($end_schedule) . ":00"]);

	$result_cek_teacher=db_query_or_die("Wah error nih1", $query_cek_teacher, $__p_query_cek_teacher ?? []);
	if(num(db_num_rows($result_cek_teacher)) > 0)
		{
		while ($row_cek=  db_fetch($result_cek_teacher, PDO::FETCH_NUM))
			{							
			echo "<script type=\"text/javascript\">\n";
			echo "alert('1 (" . e($mulai_kelas_baru) . ") Teacher mengajar " . e($row_cek[5]) . " - " . e($row_cek[4]) . "  ( " . e($row_cek[7]) . " - " . e($row_cek[8]) . ")');\n";	
			echo "</script>";
			die;
			}
		}
	else
		{
		$query_simpan = q_set($__p_query_simpan, "update ves_data.vip_teacher_schedule set skill = ? , mulai_tm =? , selesai_tm = ? , nm_teacher = ? , type_kelas = ? where id = ?  ", [(string) ($skill), (string) ($mulai_kelas_baru) . " " . (string) ($start_schedule) . ":01", (string) ($mulai_kelas_baru) . " " . (string) ($end_schedule) . ":00", (string) ($nm_teacher_baru), (string) ($class_metodh), (string) ($no)]);
		$resource_simpan = db_query_or_die('errro_simpan21', $query_simpan, $__p_query_simpan ?? []);		
		echo "<script type=\"text/javascript\">\n";
		echo "alert('Jadwal sudah dirubah oleh " . e($nama_lengkap) . "');\n";
		echo "window.opener.location.reload(true);\n";								
		echo "window.close();\n";				
		echo "</script>";
			
		}
	}
elseif ($tgl_lama == $mulai_kelas_baru and $room_lama != $room_baru and $start_schedule_lama == $start_schedule 
	and $end_schedule_lama ==$end_schedule and $teacher_lama == $nm_teacher_baru)
	{

	$query_cek_room = q_set($__p_query_cek_room, "SELECT nm_teacher, mulai_tm, selesai_tm,room,center,kelas,date_format(mulai_tm,'%d %m %y'),date_format(mulai_tm,'%H:%i %p'), date_format(selesai_tm,'%H:%i %p') FROM ves_data.vip_teacher_schedule WHERE kelas <> ? and (status_kelas <> 0 and status_kelas <> 52  and status_kelas <> 62 and status_kelas <> 72 and status_kelas <> 82 and status_kelas <> 92)and    kd_branch = ? and (room =?  and room <> 'OS' and room <> 'OM' ) and ((mulai_tm >= ? AND mulai_tm <= ? ) OR\r
\t(selesai_tm >= ? AND selesai_tm <= ? ))", [(string) ($kdcl), (string) ($kdcbg), (string) ($room_baru), (string) ($mulai_kelas_baru) . " " . (string) ($start_schedule) . ":01", (string) ($mulai_kelas_baru) . " " . (string) ($end_schedule) . ":00", (string) ($mulai_kelas_baru) . " " . (string) ($start_schedule) . ":01", (string) ($mulai_kelas_baru) . " " . (string) ($end_schedule) . ":00"]);
	$result_cek_room=db_query_or_die("Wah error nih1", $query_cek_room, $__p_query_cek_room ?? []);
	if(num(db_num_rows($result_cek_room)) > 0)
		{
		while ($row_room=  db_fetch($result_cek_room, PDO::FETCH_NUM))
			{							
			echo "<script type=\"text/javascript\">\n";
			echo "alert('Ruangan digunakan " . e($row_room[5]) . " - " . e($row_room[4]) . "  Time Slot " . e($row_room[2]) . " - " . e($row_room[2]) . "');\n";	
			echo "</script>";
			die;
			}
		}
	else
		{
		$query_simpan = q_set($__p_query_simpan, "update ves_data.vip_teacher_schedule set  skill = ? , mulai_tm =? , selesai_tm = ? , room = ? ,type_kelas = ? where id = ?  ", [(string) ($skill), (string) ($mulai_kelas_baru) . " " . (string) ($start_schedule) . ":01", (string) ($mulai_kelas_baru) . " " . (string) ($end_schedule) . ":00", (string) ($room_baru), (string) ($class_metodh), (string) ($no)]);
		$resource_simpan = db_query_or_die('errro_simpan1', $query_simpan, $__p_query_simpan ?? []);		
		echo "<script type=\"text/javascript\">\n";
		echo "alert('Jadwal sudah dirubah oleh " . e($nama_lengkap) . "');\n";
		echo "window.opener.location.reload(true);\n";								
		echo "window.close();\n";				
		echo "</script>";
			
		}
	}
elseif ($tgl_lama == $mulai_kelas_baru and $room_lama != $room_baru and $start_schedule_lama == $start_schedule 
	and $end_schedule_lama ==$end_schedule and $teacher_lama != $nm_teacher_baru)
	{


	$query_cek_teacher = q_set($__p_query_cek_teacher, "SELECT nm_teacher, mulai_tm, selesai_tm,room,center,kelas,date_format(mulai_tm,'%d %m %y'),date_format(mulai_tm,'%H:%i %p'), date_format(selesai_tm,'%H:%i %p')  FROM ves_data.vip_teacher_schedule WHERE kelas <> ? and (status_kelas <> 0 and status_kelas <> 52  and status_kelas <> 62 and status_kelas <> 72 and status_kelas <> 82 and status_kelas <> 92)and     nm_teacher =? and ((mulai_tm >= ? AND mulai_tm <= ? ) OR\r
\t(selesai_tm >= ? AND selesai_tm <= ? ))", [(string) ($kdcl), (string) ($nm_teacher_baru), (string) ($mulai_kelas_baru) . " " . (string) ($start_schedule) . ":01", (string) ($mulai_kelas_baru) . " " . (string) ($end_schedule) . ":00", (string) ($mulai_kelas_baru) . " " . (string) ($start_schedule) . ":01", (string) ($mulai_kelas_baru) . " " . (string) ($end_schedule) . ":00"]);

	$result_cek_teacher=db_query_or_die("Wah error nih1", $query_cek_teacher, $__p_query_cek_teacher ?? []);
	if(num(db_num_rows($result_cek_teacher)) > 0)
		{
		while ($row_cek=  db_fetch($result_cek_teacher, PDO::FETCH_NUM))
			{							
			echo "<script type=\"text/javascript\">\n";
			echo "alert('2 (" . e($mulai_kelas_baru) . ") Teacher mengajar " . e($row_cek[5]) . " - " . e($row_cek[4]) . "  ( " . e($row_cek[7]) . " - " . e($row_cek[8]) . ")');\n";	
			echo "</script>";
			die;
			}
		}
	else
		{
		$query_cek_room = q_set($__p_query_cek_room, "SELECT nm_teacher, mulai_tm, selesai_tm,room,center,kelas,date_format(mulai_tm,'%d %m %y'),date_format(mulai_tm,'%H:%i %p'), date_format(selesai_tm,'%H:%i %p') FROM ves_data.vip_teacher_schedule WHERE kelas <> ? and (status_kelas <> 0 and status_kelas <> 52  and status_kelas <> 62 and status_kelas <> 72 and status_kelas <> 82 and status_kelas <> 92)and    kd_branch = ? and (room =?  and room <> 'OS' and room <> 'OM' )  and ((mulai_tm >= ? AND mulai_tm <= ? ) OR\r
\t\t(selesai_tm >= ? AND selesai_tm <= ? ))", [(string) ($kdcl), (string) ($kdcbg), (string) ($room_baru), (string) ($mulai_kelas_baru) . " " . (string) ($start_schedule) . ":01", (string) ($mulai_kelas_baru) . " " . (string) ($end_schedule) . ":00", (string) ($mulai_kelas_baru) . " " . (string) ($start_schedule) . ":01", (string) ($mulai_kelas_baru) . " " . (string) ($end_schedule) . ":00"]);
		$result_cek_room=db_query_or_die("Wah error nih1", $query_cek_room, $__p_query_cek_room ?? []);
		if(num(db_num_rows($result_cek_room)) > 0)
			{
			while ($row_room=  db_fetch($result_cek_room, PDO::FETCH_NUM))
				{							
				echo "<script type=\"text/javascript\">\n";
				echo "alert('Ruangan digunakan " . e($row_room[5]) . " - " . e($row_room[4]) . "  Time Slot " . e($row_room[2]) . " - " . e($row_room[2]) . "');\n";	
				echo "</script>";
				die;
				}
			}
		else
			{
			$query_simpan = q_set($__p_query_simpan, "update ves_data.vip_teacher_schedule set skill = ? , mulai_tm =? , selesai_tm = ? , nm_teacher = ? ,  room = ? where id = ?  ", [(string) ($skill), (string) ($mulai_kelas_baru) . " " . (string) ($start_schedule) . ":01", (string) ($mulai_kelas_baru) . " " . (string) ($end_schedule) . ":00", (string) ($nm_teacher_baru), (string) ($room_baru), (string) ($no)]);
			$resource_simpan = db_query_or_die('errro_simpan1', $query_simpan, $__p_query_simpan ?? []);		
			echo "<script type=\"text/javascript\">\n";
			echo "alert('Jadwal sudah dirubah oleh " . e($nama_lengkap) . "');\n";
			echo "window.opener.location.reload(true);\n";								
			echo "window.close();\n";				
			echo "</script>";
			}
		}
	}
elseif ($tgl_lama == $mulai_kelas_baru and $room_lama == $room_baru and $start_schedule_lama == $start_schedule 
	and $end_schedule_lama !=$end_schedule and $teacher_lama == $nm_teacher_baru)
	{


	$query_cek_teacher = q_set($__p_query_cek_teacher, "SELECT nm_teacher, mulai_tm, selesai_tm,room,center,kelas,date_format(mulai_tm,'%d %m %y'),date_format(mulai_tm,'%H:%i %p'), date_format(selesai_tm,'%H:%i %p')  FROM ves_data.vip_teacher_schedule WHERE kelas <> ? and (status_kelas <> 0 and status_kelas <> 52  and status_kelas <> 62 and status_kelas <> 72 and status_kelas <> 82 and status_kelas <> 92)and     nm_teacher =? and ((mulai_tm >= ? AND mulai_tm <= ? ) OR\r
\t(selesai_tm >= ? AND selesai_tm <= ? ))", [(string) ($kdcl), (string) ($nm_teacher_baru), (string) ($mulai_kelas_baru) . " " . (string) ($start_schedule) . ":01", (string) ($mulai_kelas_baru) . " " . (string) ($end_schedule) . ":00", (string) ($mulai_kelas_baru) . " " . (string) ($start_schedule) . ":01", (string) ($mulai_kelas_baru) . " " . (string) ($end_schedule) . ":00"]);

	$result_cek_teacher=db_query_or_die("Wah error nih1", $query_cek_teacher, $__p_query_cek_teacher ?? []);
	if(num(db_num_rows($result_cek_teacher)) > 0)
		{
		while ($row_cek=  db_fetch($result_cek_teacher, PDO::FETCH_NUM))
			{							
			echo "<script type=\"text/javascript\">\n";
			echo "alert('2 (" . e($mulai_kelas_baru) . ") Teacher mengajar " . e($row_cek[5]) . " - " . e($row_cek[4]) . "  ( " . e($row_cek[7]) . " - " . e($row_cek[8]) . ")');\n";	
			echo "</script>";
			die;
			}
		}
	else
		{
		$query_cek_room = q_set($__p_query_cek_room, "SELECT nm_teacher, mulai_tm, selesai_tm,room,center,kelas,date_format(mulai_tm,'%d %m %y'),date_format(mulai_tm,'%H:%i %p'), date_format(selesai_tm,'%H:%i %p') FROM ves_data.vip_teacher_schedule WHERE kelas <> ? and (status_kelas <> 0 and status_kelas <> 52  and status_kelas <> 62 and status_kelas <> 72 and status_kelas <> 82 and status_kelas <> 92)and    kd_branch = ? and (room =?  and room <> 'OS' and room <> 'OM' )  and ((mulai_tm >= ? AND mulai_tm <= ? ) OR\r
\t\t(selesai_tm >= ? AND selesai_tm <= ? ))", [(string) ($kdcl), (string) ($kdcbg), (string) ($room_baru), (string) ($mulai_kelas_baru) . " " . (string) ($start_schedule) . ":01", (string) ($mulai_kelas_baru) . " " . (string) ($end_schedule) . ":00", (string) ($mulai_kelas_baru) . " " . (string) ($start_schedule) . ":01", (string) ($mulai_kelas_baru) . " " . (string) ($end_schedule) . ":00"]);
		$result_cek_room=db_query_or_die("Wah error nih1", $query_cek_room, $__p_query_cek_room ?? []);
		if(num(db_num_rows($result_cek_room)) > 0)
			{
			while ($row_room=  db_fetch($result_cek_room, PDO::FETCH_NUM))
				{							
				echo "<script type=\"text/javascript\">\n";
				echo "alert('Ruangan digunakan " . e($row_room[5]) . " - " . e($row_room[4]) . "  Time Slot " . e($row_room[2]) . " - " . e($row_room[2]) . "');\n";	
				echo "</script>";
				die;
				}
			}
		else
			{
			$query_simpan = q_set($__p_query_simpan, "update ves_data.vip_teacher_schedule set skill = ? , mulai_tm =? , selesai_tm = ? , nm_teacher = ? ,  room = ? , type_kelas = ? where id = ?  ", [(string) ($skill), (string) ($mulai_kelas_baru) . " " . (string) ($start_schedule) . ":01", (string) ($mulai_kelas_baru) . " " . (string) ($end_schedule) . ":00", (string) ($nm_teacher_baru), (string) ($room_baru), (string) ($class_metodh), (string) ($no)]);
			$resource_simpan = db_query_or_die('errro_simpan1', $query_simpan, $__p_query_simpan ?? []);		
			echo "<script type=\"text/javascript\">\n";
			echo "alert('Jadwal sudah dirubah oleh " . e($nama_lengkap) . "');\n";
			echo "window.opener.location.reload(true);\n";								
			echo "window.close();\n";				
			echo "</script>";
			}
		}
	}	
else
{

$query_cek_teacher = q_set($__p_query_cek_teacher, "SELECT nm_teacher, mulai_tm, selesai_tm,room,center,kelas,date_format(mulai_tm,'%d %m %y'),date_format(mulai_tm,'%H:%i %p'), date_format(selesai_tm,'%H:%i %p')  FROM ves_data.vip_teacher_schedule WHERE kelas <> ? and (status_kelas <> 0 and status_kelas <> 52  and status_kelas <> 62 and status_kelas <> 72 and status_kelas <> 82 and status_kelas <> 92)and     nm_teacher =? and ((mulai_tm >= ? AND mulai_tm <= ? ) OR\r
(selesai_tm >= ? AND selesai_tm <= ? ))", [(string) ($kdcl), (string) ($nm_teacher_baru), (string) ($mulai_kelas_baru) . " " . (string) ($start_schedule) . ":01", (string) ($mulai_kelas_baru) . " " . (string) ($end_schedule) . ":00", (string) ($mulai_kelas_baru) . " " . (string) ($start_schedule) . ":01", (string) ($mulai_kelas_baru) . " " . (string) ($end_schedule) . ":00"]);

$result_cek_teacher=db_query_or_die("Wah error nih1", $query_cek_teacher, $__p_query_cek_teacher ?? []);
if(num(db_num_rows($result_cek_teacher)) > 0)
	{
	while ($row_cek=  db_fetch($result_cek_teacher, PDO::FETCH_NUM))
		{							
		echo "<script type=\"text/javascript\">\n";
		echo "alert('3 (" . e($mulai_kelas_baru) . ") Teacher mengajar " . e($row_cek[5]) . " - " . e($row_cek[4]) . "  ( " . e($row_cek[7]) . " - " . e($row_cek[8]) . ")');\n";	
		echo "</script>";
		die;
		}
	}
else
	{
	$query_cek_room = q_set($__p_query_cek_room, "SELECT nm_teacher, mulai_tm, selesai_tm,room,center,kelas,date_format(mulai_tm,'%d %m %y'),date_format(mulai_tm,'%H:%i %p'), date_format(selesai_tm,'%H:%i %p') FROM ves_data.vip_teacher_schedule WHERE kelas <> ? and (status_kelas <> 0 and status_kelas <> 52  and status_kelas <> 62 and status_kelas <> 72 and status_kelas <> 82 and status_kelas <> 92)and    kd_branch = ? and (room =?  and room <> 'OS' and room <> 'OM' )  and ((mulai_tm >= ? AND mulai_tm <= ? ) OR\r
\t(selesai_tm >= ? AND selesai_tm <= ? ))", [(string) ($kdcl), (string) ($kdcbg), (string) ($room_baru), (string) ($mulai_kelas_baru) . " " . (string) ($start_schedule) . ":01", (string) ($mulai_kelas_baru) . " " . (string) ($end_schedule) . ":00", (string) ($mulai_kelas_baru) . " " . (string) ($start_schedule) . ":01", (string) ($mulai_kelas_baru) . " " . (string) ($end_schedule) . ":00"]);
	$result_cek_room=db_query_or_die("Wah error nih1", $query_cek_room, $__p_query_cek_room ?? []);
	if(num(db_num_rows($result_cek_room)) > 0)
		{
		while ($row_room=  db_fetch($result_cek_room, PDO::FETCH_NUM))
			{							
			echo "<script type=\"text/javascript\">\n";
			echo "alert('Ruangan digunakan " . e($row_room[5]) . " - " . e($row_room[4]) . "  Time Slot " . e($row_room[2]) . " - " . e($row_room[2]) . "');\n";	
			echo "</script>";
			die;
			}
		}
	else
		{
		$query_simpan = q_set($__p_query_simpan, "insert into ves_data.vip_teacher_schedule (nm_teacher, kelas, center, room, mulai_tm, selesai_tm,dt_entry, pic,kode_program,level_program,kd_branch,urutan,status_kelas, type_kelas)\r
\t\tvalues (? ,? ,? ,? ,? ,? ,? ,? ,? ,? ,? ,? ,'1',? )", [(string) ($nm_teacher_baru), (string) ($kdcl), (string) ($center), (string) ($room_baru), (string) ($mulai_kelas_baru) . " " . (string) ($start_schedule) . ":01", (string) ($mulai_kelas_baru) . " " . (string) ($end_schedule) . ":00", (string) ($hari_ini), (string) ($nama_lengkap), (string) ($kode_program), (string) ($nm_level), (string) ($kdcbg), (string) ($p), (string) ($class_metodh)]);	
			
			
			 
//		$query_simpan = "insert into ves_data.vip_teacher_schedule (nm_teacher, kelas, center, room, mulai_tm, selesai_tm,dt_entry, pic,kd_branch,status_kelas)
//		values ('$nm_teacher_baru','$kdcl','$center','$room_baru','$mulai_kelas_baru $start_schedule:01','$mulai_kelas_baru $end_schedule:00','$hari_ini','$nama_lengkap','$kdcbg','1')";	
		$resource_simpan = db_query_or_die('errro_simpan1', $query_simpan, $__p_query_simpan ?? []);		
			
		$query_update = q_set($__p_query_update, "update  ves_data.vip_teacher_schedule set status_kelas = 0,keterangan = ? ,dt_entry = ? ,pic = ? where id = ? ", [(string) ($remark_schedule), (string) ($hari_ini), (string) ($nama_lengkap), (string) ($no)]);	
		$resource_update= db_query_or_die('errro_simpan2', $query_update, $__p_query_update ?? []);	
		echo "<script type=\"text/javascript\">\n";
		echo "alert('Jadwal sudah dirubah oleh " . e($nama_lengkap) . "');\n";
		echo "window.opener.location.reload(true);\n";								
		echo "window.close();\n";				
		echo "</script>";
		}
	}
}
}
?>
