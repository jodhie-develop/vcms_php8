<?php
include __DIR__ . "/conndb.php";
include __DIR__ . "/profiledata.php";
//include ("atas.php");
auth_require_login();
$q = in_str('q', 1, 'get');
if($q==''){$q='t';}
$tampilan = in_str('tampilan', 30, 'get');
$nm_teacher = in_str('nm_teacher', 45, 'get');
$posisi = $_SESSION['posisi'];
$list_nm_teacher = '';
$namateacher = $namateacher_lengkap = '';
$kd = ''; // tidak pernah diisi di versi lama (url detail_free_hour.php?id= selalu kosong)

$center = in_str('center', 45, 'get');
if ($center==""){$center = "--ALL--";}

if ($tampilan==""){$tampilan = "Teachers Calendar";}
if ($tampilan == "Teachers Calendar") 
	{$q='t';}
else
	{$q='r';}

$hari=date("d");
$bulan=date("m");
$tahun=date("Y");
$hari_ini = "$tahun-$bulan-$hari";
$date_start = in_date('date_start', "2021-01-01", 'get');
$date_end = in_date('date_end', $hari_ini, 'get');

$kd_cbg = in_str('kd_cbg', 3, 'get');

if ($kd_cbg ==1){$center = 'East Sby';}
if ($kd_cbg ==2){$center = 'West Sby';}
if ($kd_cbg ==3){$center = 'Denpasar';}
if ($kd_cbg ==4){$center = 'South Jkt';}
if ($kd_cbg ==5){$center = 'North Jkt';}
if ($kd_cbg ==6){$center = 'West Jkt';}
if ($kd_cbg ==7){$center = 'Bandung';}
if ($kd_cbg ==8){$center = 'Malang TBI';}
if ($kd_cbg ==9){$center = 'Bandung TBI';}
if ($kd_cbg ==10){$center = 'Bali TBI';}
if ($kd_cbg ==100){$center = 'ONLINE';}
$query_nm_teacher = "SELECT kd_teacher, nm_teacher FROM ves_data.vip_teacher_name where status =1 order by nm_teacher";
$resource_nm_teacher = db_query($query_nm_teacher);
	{
	while ($row_nm_teacher = $resource_nm_teacher->fetch(PDO::FETCH_NUM))
		{
		$kd_teacher_list= $row_nm_teacher[0];
		$nm_teacher_list= $row_nm_teacher[1];
		$list_nm_teacher.="<OPTION VALUE=\"".e($kd_teacher_list)."\">".e($nm_teacher_list);
		}
	}

$nama_lengkap = $_SESSION['nama_lengkap'];
$nama_depan = $_SESSION['nama_depan'];
$kd_cbg = $_SESSION['kd_branch'];
$posisi = $_SESSION['posisi'];
$kd_staff = $_SESSION['kd_staff'] ;
$level_posisi = $_SESSION['level_posisi'] ;
// Filter cabang ($pilihcabang) dan $pilihact versi lama tidak dipakai di query, tidak dibawa.

$params_event = [];
if ($nm_teacher=='--ALL--')
	{
	$pilihteacher = "";
	}
elseif ($nm_teacher == '')
	{
	$pilihteacher = "";
	}
else
	{
	$pilihteacher = " and kd_emp = ? ";
	$params_event[] = $nm_teacher;
	$query_nm_teacher = "SELECT e.nm_emp, e.kd_emp FROM emp_time_work e where kd_emp = ? ";
	$resource_nm_teacher = db_query($query_nm_teacher, [$nm_teacher]);
		{
		while ($row_nm_teacher = $resource_nm_teacher->fetch(PDO::FETCH_NUM))
			{
			$namateacher= $row_nm_teacher[0];
			$namateacher_lengkap= $row_nm_teacher[0];			
			}
		}
}
$query_event = "SELECT kd_emp, kerja_mulai, kerja_selesai,date_format(kerja_mulai,'%Y-%m-%d'),date_format(kerja_mulai,'%Y-%m-%d'),date_format(kerja_mulai,'%H:%i'),date_format(kerja_selesai,'%H:%i')  FROM ves_data.emp_time_work where status = 1 and kerja_mulai > '2021-07-01' ".$pilihteacher."order by kd_emp  ";

?>
<!DOCTYPE html>
<html>
<head>
  <meta http-equiv="refresh" content="500" />
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>AdminLTE 2 | Data Tables</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.6 -->

  <!-- Theme style -->
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
<link href='agenda/fullcalendar.min.css' rel='stylesheet' />
<link href='agenda/fullcalendar.print.min.css' rel='stylesheet' media='print' />
<script src='agenda/lib/moment.min.js'></script>
<script src='agenda/lib/jquery.min.js'></script>
<script src='agenda/fullcalendar.min.js'></script>
<script type="text/javascript">

	</script>
  <script>

	$(document).ready(function() {
		
		$('#calendar').fullCalendar({
			
			header: {
				left: 'prev,next today',
				center: 'title',
				right: 'month,age	ndaWeek,agendaDay,listWeek'
			},
			
			
				 timeFormat: 'HH:mm',
			contenthight:600,
			navLinks: true, // can click day/week names to navigate views
			editable: false,
			eventLimit: true, // allow "more" link when too many events
			events: 
				[
<?php
// Satu event slot kosong untuk fullcalendar (nilai di-escape sebagai literal JS).
$free_event = function ($start, $end, $title) use ($kd) {
	echo "\t\t\t\t\t\t{\n";
	echo "\t\t\t\t\t\tstart: " . js($start) . ",\n";
	echo "\t\t\t\t\t\tend : " . js($end) . ",\n";
	echo "\t\t\t\t\t\ttitle: " . js($title) . ",\n";
	echo "\t\t\t\t\t\tcolor:'#5983E5',\n";
	echo "\t\t\t\t\t\tpic :'namama',\n";
	echo "\t\t\t\t\t\turl: " . js('detail_free_hour.php?id=' . u($kd)) . ",\n";
	echo "\t\t\t\t\t\t},\n";
};

$resource_event = db_query($query_event, $params_event);
while ($row_event = $resource_event->fetch(PDO::FETCH_NUM))
	{
	$kode_emp = $row_event[0];
	$mulai_tm  = $row_event[1];
	$selesai_tm  = $row_event[2];
	$jam_mulai = $row_event[5];
	$jam_selesai = $row_event[6];
	$tanggalan = $row_event[3];
	// Dulu "mulai_tm like 'YYYY-MM-DD%'": sama dengan rentang 1 hari, tetapi rentang bisa memakai
	// index (nm_teacher, mulai_tm) - lihat usulan/index_performa2_up.sql.
	$jadwal_hari_ini = [$kode_emp, $tanggalan, $tanggalan];
	$jml_meeting = (int) db_value("select count(*) from ves_data.vip_teacher_schedule where nm_teacher = ? and mulai_tm >= ? and mulai_tm < DATE_ADD(?, INTERVAL 1 DAY) and status_kelas <> 0", $jadwal_hari_ini);

	if ($jml_meeting >= 1)
		{
		// slot sebelum meeting pertama
		$mulai_tm_pertama = db_value("select date_format(mulai_tm,'%H:%i') from ves_data.vip_teacher_schedule where nm_teacher = ? and mulai_tm >= ? and mulai_tm < DATE_ADD(?, INTERVAL 1 DAY) and status_kelas <> 0 order by mulai_tm limit 1", $jadwal_hari_ini);
		if ($mulai_tm_pertama !== null)
			{
			$free_event($mulai_tm, $selesai_tm, "to $mulai_tm_pertama - $kode_emp");
			}
		}
	if ($jml_meeting >= 2)
		{
		// celah >= 30 menit di antara meeting
		$query_kosong = "SELECT CAST(AvailStartTime AS CHAR(10000) CHARACTER SET utf8) as availstarttime, AvailEndTime,mid(CAST(AvailStartTime AS CHAR(10000) CHARACTER SET utf8),12,5) as availstarttime, mid(AvailEndTime,12,5) FROM (SELECT @lastselesai_tm as AvailStartTime, mulai_tm as AvailEndTime, @lastselesai_tm := selesai_tm FROM (SELECT mulai_tm, selesai_tm FROM vip_teacher_schedule WHERE nm_teacher = ? AND selesai_tm >= ? AND mulai_tm < ? and status_kelas <> 0  ORDER BY mulai_tm) e JOIN (SELECT @lastselesai_tm := NULL) init) x WHERE AvailEndTime > DATE_ADD(AvailStartTime, INTERVAL 30 MINUTE)";
		$resource_kosong = db_query($query_kosong, [$kode_emp, $mulai_tm, $selesai_tm]);
		while ($row_kosong = $resource_kosong->fetch(PDO::FETCH_NUM))
			{
			$free_event($row_kosong[0], $row_kosong[1], "to $row_kosong[3] - $kode_emp");
			}
		// slot setelah meeting terakhir
		$row_terakhir = db_row("select mulai_tm, selesai_tm from ves_data.vip_teacher_schedule where nm_teacher = ? and mulai_tm >= ? and mulai_tm < DATE_ADD(?, INTERVAL 1 DAY) and status_kelas <> 0 order by mulai_tm desc limit 1", $jadwal_hari_ini, PDO::FETCH_NUM);
		if ($row_terakhir !== null)
			{
			$free_event($row_terakhir[1], $selesai_tm, "to $jam_selesai - $kode_emp");
			}
		}
	if ($jml_meeting == 0)
		{
		$free_event($mulai_tm, $selesai_tm, "to $jam_selesai - $kode_emp");
		}
	}
?>


				],
			eventClick: function(event)
				{
				if (event.url) 
					{
					window.open(event.url, "popup", "width=500,height=500,toolbar=0");
					return false;
					}
				}
		});
	});
</script>
<style>

	body {
		margin: 40px 10px;
		padding: 0;
		font-family: "Lucida Grande",Helvetica,Arial,Verdana,sans-serif;
		font-size: 16px;
	}

	#calendar {
		max-width: 1200px;
		margin: 0 auto;
	}

</style>
  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
</head>
<?php //========================== left nav ?>
 <?php //   include ("left.php");	 ?>
 <?php //====================== ?>
  <!-- Content Wrapper. Contains page content -->
<form role="form">
 <div class="box-header with-border">
  <div class='col-md-12' align="center">
<div class="row">
        <div class="col-md-2">
          <div class="form-group">
<a href="dashboard.php" class="btn btn-primary" role="button">< Back To Menu</a>         
          </div>
        </div>
        <div class="col-md-2">
          <div class="form-group"> <a href="teachercalendar.php" class="btn btn-primary" role="button">Teaching</a> </div>
        </div>	
</div>	  
<div class="row">
        <div class="col-md-2">
       	        <div class="form-group">
					Teacher/Room
       	          <select class="form-control" name="tampilan" onChange="this.form.submit()" >
       	            <option>Free Teachers</option>
       	            <option>Free Rooms</option>
       	            <option selected><?php echo e($tampilan) ?></option>
   	              </select>
   	            </div>
        </div>
        <div class="col-md-2">
			Teacher Name
                <div class="form-group">
                  <select class="form-control" name="nm_teacher" onChange="this.form.submit()">
                    <option>--ALL--</option>
                    <option value= ><?php echo $list_nm_teacher; /* sudah di-escape saat dibangun */ ?>
                    <option selected><?php echo e($namateacher) ?></option>
                  </select>
          </div>
        </div>
	<div class="col-md-6">
         
            <h4><strong>TEACHER'S AVAILABILITY TIME SLOT</strong></h4>
            <h5><?php echo e($namateacher_lengkap) ?></h5>
	</div>
</div>
 <div class="row"><br>
 </div>
 <div class="row">
 	  <div class="col-12">

	<div id='calendar'></div>
	  </div>	
    </div>


	</div>
	</form>

<!-- ./wrapper -->
<!-- jQuery 2.2.3 -->

<!-- page script -->
<script>
$(document).ready(function(){
    $('[data-toggle="popover"]').popover();   
});
	
</script>
</body>
</html>
