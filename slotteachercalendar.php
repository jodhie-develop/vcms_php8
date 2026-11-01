<?php
include __DIR__ . "/conndb.php";
include __DIR__ . "/profiledata.php";
//include ("atas.php");
auth_require_login();
// Versi lama juga menyusun daftar teacher dan filter cabang/aktivitas, tetapi
// tidak pernah dipakai; hanya kalender slot kerja (emp_time_work) yang tampil.
$q = in_str('q', 1, 'get');
if($q==''){$q='t';}
$tampilan = in_str('tampilan', 30, 'get');
$kode_teacher = in_str('kd', 45, 'get');
$posisi = $_SESSION['posisi'];

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
$date_start = in_date('date_start', "2016-07-01", 'get');
$date_end = in_date('date_end', $hari_ini, 'get');

$nama_lengkap = $_SESSION['nama_lengkap'];
$nama_depan = $_SESSION['nama_depan'];
$kd_cbg = $_SESSION['kd_branch'];
$posisi = $_SESSION['posisi'];
$kd_staff = $_SESSION['kd_staff'] ;
$level_posisi = $_SESSION['level_posisi'] ;

$query_event = "SELECT kd_emp, kerja_mulai,kerja_selesai, date_format(kerja_selesai,'%H:%i'),id,status  FROM ves_data.emp_time_work where kd_emp = ?  group by kerja_mulai ";


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

$resource_event = db_query($query_event, [$kode_teacher]);
	{
	while ($row_event = $resource_event->fetch(PDO::FETCH_NUM))
		{
		$kode_emp = $row_event[0];							
		$mulai_tm  = $row_event[1]; 
		$selesai_tm  = $row_event[2];
		$selesai_tm_jam  = $row_event[3];
		$id_table = $row_event[4];
		$status = $row_event[5];
						 ?>	
		{
		start: <?php echo js($mulai_tm) ?>,
		end : <?php echo js($selesai_tm) ?>,
		title: <?php echo js('to ' . $selesai_tm_jam) ?>,
		<?php if ($status == 1){?> color:'#5983E5', <?php }else { ?> color:'#E9191D', <?php } ?> 
		
		pic :'namama',
		url: <?php echo js('entryworking_hor_upd.php?id_table=' . u($id_table)) ?>,				
		},		
<?php			
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
<a href="dashboard.php" class="btn btn-primary" role="button"><< Back To Menu</a>         
          </div>
        </div>
      <div class="col-md-2">
          <div class="form-group"> <a href="teachercalendar.php" class="btn btn-primary" role="button">Teaching</a> </div>
        </div>
      <div class="col-md-2">
          <div class="form-group"> <a href="freeteachercalendar.php" class="btn btn-primary" role="button">Teacher's Available Time Slot (trial)</a></div>
        </div>
        <div class="col-md-2">
          <label>Teacher Code : <?php echo e($kode_teacher) ?></label>
        </div>	
</div>	  
<div class="row"></div>
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
