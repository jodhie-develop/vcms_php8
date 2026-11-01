<?php
require_once __DIR__ . "/_lib/bootstrap.php"; csrf_guard_get(); auth_require_login(); 
include __DIR__ . "/conndb.php";
include __DIR__ . "/profiledata.php";
$no = in_val('no', 'any');
$nama_lengkap = $_SESSION['nama_lengkap'];               
$query_schedule = q_set($__p_query_schedule, "SELECT date_format(mulai_tm,'%Y-%m-%d'), date_format(mulai_tm,'%b') as jam_mulai ,date_format(selesai_tm,'%k:%i') as jam_selesai, nm_teacher, kelas, center, keterangan,dayname(mulai_tm),room,id,mulai_tm,date_format(mulai_tm,'%k:%i')  FROM ves_data.vip_teacher_schedule where id = ? ", [(string) ($no)]);

$resource_schedule= db_query_or_die('errro_visitor1', $query_schedule, $__p_query_schedule ?? []);
if ($resource_schedule) 
	{ 
		$no_urut = 1;
		while ($row_schedule = db_fetch($resource_schedule))
		{
		$nm_teacher_asli = $row_schedule[3];
		$kode_kelas = $row_schedule[4];
		$date_schedule = $row_schedule[0];
		$day_schedule = $row_schedule[7];
		$room_schedule = $row_schedule[8];
		$start_schedule = $row_schedule[11];	
		$end_schedule = $row_schedule[2];
		$center = $row_schedule[5];
		$tgl_asli = $row_schedule[10];
		if($center =='East Sby'){$kd_center = '1';}
if($center =='West Sby'){$kd_center = '2';}
if($center =='Bali'){$kd_center = '3';}
if($center =='South Jkt'){$kd_center = '4';}
if($center =='North Jkt'){$kd_center = '5';}
if($center =='West Jkt'){$kd_center = '6';}
if($center =='Bandung'){$kd_center = '7';}
if($center =='Malang'){$kd_center = '8';}	
		$nm_teacher = $nm_teacher_asli;
		}
	}

//$query_nm_teacher = "SELECT b.nm_teacher FROM ves_data.vip_teacher_schedule a left join ves_data.vip_teacher_name b on a.nm_teacher = b.kd_teacher  where kelas = '$kode_kelas' group by a.nm_teacher";
$query_nm_teacher = q_set($__p_query_nm_teacher, "SELECT b.nm_teacher FROM ves_data.vip_teacher_name b group by b.nm_teacher order by b.nm_teacher");					  
$resource_nm_teacher = db_query_or_die('errro_7', $query_nm_teacher, $__p_query_nm_teacher ?? []);
if(num(db_num_rows($resource_nm_teacher)) > 0)
{
while ($row_nm_teacher=  db_fetch($resource_nm_teacher, PDO::FETCH_NUM))
	{
	$nm_teacher = $row_nm_teacher[0];				
	$list_nm_teacher.="<OPTION VALUE=\"" . e($nm_teacher) . "\">".e($nm_teacher);		
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
           	  <div class="box-body"><div class="col-md-8">
           		<div class="form-group">
                  			<label>Teacher Name</label>
            <select name="nm_teacher" id="school_name" class="form-control" placeholder="teacher name">
            	<option><?php echo e($nm_teacher_asli) ?></option>
				<option value= ><?php echo $list_nm_teacher ?></option>
                <option selected="selected"><?php echo e($nm_teacher) ?></option>
                  </select>       			  
           		</div></div>
           	    <div class="col-md-3">
           	        <div class="form-group">
           	          <label>Class Code
           	            <input type="text" class="form-control"  placeholder="Enter CLass Code" name="kode_kelas" value="<?php echo e($kode_kelas) ?>" readonly>
           	          </label>
       	          </div>
       	        </div>
       	        <span class="form-group">
       	        <input type="text" name="id_detail"value="<?php echo e($id_detail) ?>" hidden>
       	        </span><span class="form-group">
       	        <input type="text" name="no"value="<?php echo e($no) ?>"hidden>
       	        </span><span class="form-group">
       	        <input type="text" name="tgl_asli"value="<?php echo e($tgl_asli) ?>"hidden>
       	        </span></div> 
			</div>
<div class="box box-warning">
  <div class="box-header with-border"><strong>Detail Meeting</strong></div>
  <div class="box-body">
    <div class="col-md-3">
      <div class="form-group">
        <label>Date</label>
        <input type="date" class="form-control"  placeholder="Enter ..." name="mulai_kelas" value="<?php echo e($date_schedule) ?>"  >
      </div>
    </div>
    <div class="col-md-2">
      <div class="form-group">
        <label>Room</label>
        <select class="form-control" name="room" required>
          <?php
								$query_room = q_set($__p_query_room, "SELECT kd_room FROM ves_data.vip_room_name where kd_branch = ? ", [(string) ($kd_center)]);
								$resource_room = db_query_or_die('errro_7', $query_room, $__p_query_room ?? []);
								while ($row_room=  db_fetch($resource_room, PDO::FETCH_NUM))
									{
							  		echo '<option value="'.e($row_room[0]).'">'.e($row_room[0]).'</option>';
							  		}      ?>
          <option selected><?php echo  e($room_schedule) ?></option>
        </select>
      </div>
    </div>
    <div class="col-md-2">
      <div class="form-group">
        <label>Time Start</label>
        <select class="form-control" name="start_schedule" required>
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
          <option selected><?php echo e($start_schedule) ?></option>
        </select>
      </div>
    </div>
    <div class="col-md-2">
      <div class="form-group">
        <label>Time End</label>
        <select class="form-control" name="end_schedule" required>
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
          <option selected><?php echo e($end_schedule) ?></option>
        </select>
      </div>
    </div>
  </div>
</div>
<div class="col-md-8">
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
$hari=date("d");
$bulan=date("m");
$tahun=date("Y");
$hari_ini = "$tahun-$bulan-$hari";	
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
$nama_lengkap = 	$_SESSION['nama_lengkap'];

if($center =='East Sby'){$kd_center = '1';}
if($center =='West Sby'){$kd_center = '2';}
if($center =='Bali'){$kd_center = '3';}
if($center =='South Jkt'){$kd_center = '4';}
if($center =='North Jkt'){$kd_center = '5';}
if($center =='West Jkt'){$kd_center = '6';}
if($center =='Bandung'){$kd_center = '7';}
if($center =='Malang'){$kd_center = '8';}

$query_kode_teacher = q_set($__p_query_kode_teacher, "SELECT kd_teacher FROM ves_data.vip_teacher_name where nm_teacher = ? ", [(string) ($nm_teacher)]);
$resource_kode_teacher = db_query_or_die('errro_8', $query_kode_teacher, $__p_query_kode_teacher ?? []);
while ($row_kode_teacher=  db_fetch($resource_kode_teacher, PDO::FETCH_NUM))
	{
	$kode_teacher =   $row_kode_teacher[0];
	}   	
		
$query_cek_teacher = q_set($__p_query_cek_teacher, "SELECT nm_teacher, mulai_tm, selesai_tm,room,center,kelas FROM ves_data.vip_teacher_schedule WHERE  nm_teacher =? and ((mulai_tm >= ? AND mulai_tm <= ? ) OR\r
(selesai_tm >= ? AND selesai_tm <= ? ))", [(string) ($kode_teacher), (string) ($mulai_kelas) . " " . (string) ($start_schedule) . ":01", (string) ($mulai_kelas) . " " . (string) ($end_schedule) . ":00", (string) ($mulai_kelas) . " " . (string) ($start_schedule) . ":01", (string) ($mulai_kelas) . " " . (string) ($end_schedule) . ":00"]);
$result_cek_teacher=db_query_or_die("Wah error nih1", $query_cek_teacher, $__p_query_cek_teacher ?? []);
if(num(db_num_rows($result_cek_teacher)) > 0)
	{
	while ($row_cek=  db_fetch($result_cek_teacher, PDO::FETCH_NUM))
		{							
		echo "<script type=\"text/javascript\">\n";
		echo "alert('Teacher mengajar " . e($row_cek[5]) . " - " . e($row_cek[4]) . "  jam mulai " . e($row_cek[1]) . "');\n";	
		echo "</script>";
		die;
		}
	}
else
	{
	$query_cek_room = q_set($__p_query_cek_room, "SELECT nm_teacher, mulai_tm, selesai_tm,room,center,kelas FROM ves_data.vip_teacher_schedule WHERE center = ? and room =? and ((mulai_tm >= ? AND mulai_tm <= ? ) OR\r
\t(selesai_tm >= ? AND selesai_tm <= ? ))", [(string) ($center), (string) ($room), (string) ($mulai_kelas) . " " . (string) ($start_schedule) . ":01", (string) ($mulai_kelas) . " " . (string) ($end_schedule) . ":00", (string) ($mulai_kelas) . " " . (string) ($start_schedule) . ":01", (string) ($mulai_kelas) . " " . (string) ($end_schedule) . ":00"]);
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
		$query_simpan_4 = q_set($__p_query_simpan_4, "insert into ves_data.vip_teacher_schedule (nm_teacher, kelas, center, room, mulai_tm, selesai_tm,dt_entry, pic)\r
\t\tvalues (? ,? ,? ,? ,? ,? ,? ,? )", [(string) ($kode_teacher), (string) ($kode_kelas), (string) ($center), (string) ($room), (string) ($mulai_kelas) . " " . (string) ($start_schedule) . ":00", (string) ($mulai_kelas) . " " . (string) ($end_schedule) . ":00", (string) ($hari_ini), (string) ($pic)]);	
		$resource_simpan_4= db_query_or_die('errro_simpan1', $query_simpan_4, $__p_query_simpan_4 ?? []);		
			
		$query_update = q_set($__p_query_update, "update  ves_data.vip_teacher_schedule set st_cl = '1',keterangan = ? ,mulai_tm = ? ,dt_entry = ? where id = ? ", [(string) ($remark_schedule), (string) ($tgl_asli), (string) ($hari_ini), (string) ($no)]);	
		$resource_update= db_query_or_die('errro_simpan2', $query_update, $__p_query_update ?? []);	
echo "<script type=\"text/javascript\">\n";
echo "alert('Jadwal sudah dirubah oleh " . e($nama_lengkap) . "');\n";
echo "window.opener.location.reload(true);\n";								
echo "window.close();\n";				
echo "</script>";
		}
	}


}
?>
