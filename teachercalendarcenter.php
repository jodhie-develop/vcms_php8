<?php
include __DIR__ . "/conndb.php";
include __DIR__ . "/profiledata.php";
//include ("atas.php");
auth_require_login();
$tampilan = in_str('tampilan', 30, 'get');
$kode_teacher = in_str('nm_teacher', 45, 'get');
$posisi = $_SESSION['posisi'];
$list_nm_teacher = '';
$nm_teacher_dipilih = '';

$center = in_str('center', 45, 'get');
if ($center==""){$center = "--ALL--";}


$hari=date("d");
$bulan=date("m");
$tahun=date("Y");
$hari_ini = "$tahun-$bulan-$hari";
$date_start = in_date('date_start', "2016-07-01", 'get');
$date_end = in_date('date_end', $hari_ini, 'get');

$query_nm_teacher = "SELECT kd_teacher, nm_teacher FROM ves_data.vip_teacher_name order by nm_teacher";
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
$kd_area = $_SESSION['kd_area'] ?? null;
$level_posisi = $_SESSION['level_posisi'] ;
$query_teacher = "SELECT kd_teacher, nm_teacher,kd_branch FROM ves_data.vip_teacher_name where kd_teacher = ?";

$resource_teacher = db_query($query_teacher, [$kode_teacher]);

if ($resource_teacher)
	{
	while ($row_teacher = $resource_teacher->fetch())
		{
		$nm_teacher_dipilih = $row_teacher['1'];
		}
	}
$params_event = [];
if ($center=='--ALL--')
	{
	$pilihcabang = "";
	}
elseif ($center == 'JAKARTA')
	{
	$pilihcabang = " and center  like '%Jkt'";
	}
elseif ($center == 'SURABAYA')
	{
	$pilihcabang = " and center  like '%Sby'";
	}
else
	{
	$pilihcabang = " and center = ?";
	$params_event[] = $center;
	}

if ($kode_teacher=='--ALL--')
	{
	$pilihteacher = "";
	}
elseif ($kode_teacher == '')
	{
	$pilihteacher = "";
	}
else
	{
	$pilihteacher = " and e.nm_teacher = ?";
	$params_event[] = $kode_teacher;
	}

$query_event = "SELECT e.id,   e.mulai_tm, e.selesai_tm, f.nm_teacher, e.kelas, e.center, e.room, e.keterangan,e.nm_teacher,e.catatan FROM ves_data.vip_teacher_schedule e,ves_data.vip_teacher_name f where e.nm_teacher = f.kd_teacher and  e.st_cl <> '1' and e.status_kelas <> 0 ";
$query_groupby = " group by e.kelas, e.mulai_tm, f.nm_teacher";
$query_event =  "$query_event$pilihcabang$pilihteacher$query_groupby"  ;

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
function mypopup()
{
              window.open("detail_event.php","Popup","height=300,width=600");
 window.open("detail_order.php","Popup","height=300,width=800");	
}
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

$resource_event = db_query($query_event, $params_event);
					{
					while ($row_event = $resource_event->fetch(PDO::FETCH_NUM))
						{
						$kd = $row_event[0];							
						$mulai_tm  = $row_event[1]; 
						$selesai_tm  = $row_event[2];	
						$nm_teacher  = $row_event[8];	
						$kelas  = $row_event[4];	
						$cabang  = $row_event[5];	
						$ruang  = $row_event[6];	
						$keterangan  = $row_event[7];	
						$catatan  = $row_event[9];	
							

				 ?>	{
					start: <?php echo js($mulai_tm) ?>,
					end : <?php echo js($selesai_tm) ?>,

					title: <?php echo js($nm_teacher . '-(' . $kelas . ')') ?>,
					              <?php if ($catatan =='Booking'){ ?>
                color: '#ff9f89',					
						<?php }else{ ?>
                color: '#5983E5',										
						<?php } ?> 

						
					pic :'namama',
									
					},		
<?php						}
					}
?>


				],
			eventClick: function(event)
				{
				if (event.url) 
					{
					window.open(event.url, "popup", "MsgWindow");
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
          <div class="form-group">Center :
            <input type="text" class="form-control"  placeholder="Enter ..." name="center" value="<?php echo e($center) ?>" readonly>
          </div>
        </div>
        <div class="col-md-2">
                <div class="form-group">
                  <select class="form-control" name="nm_teacher" onChange="this.form.submit()">
                    <option>--ALL--</option>
                    <option value= ><?php echo $list_nm_teacher; /* sudah di-escape saat dibangun */ ?>
                    <option selected><?php echo e($nm_teacher_dipilih) ?></option>
                  </select>
          </div>
        </div>
</div>
	<div id='calendar'></div>
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
