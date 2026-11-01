<?php
require_once __DIR__ . "/_lib/bootstrap.php"; auth_require_login(); 
include __DIR__ . "/conndb.php";
include __DIR__ . "/profiledata.php";
//include __DIR__ . "/atas.php";
$center = in_val('center', 'get');
if($center == 'East Sby') {$kd_cbg = 1;}
elseif($center == 'West Sby') {$kd_cbg = 2;}
elseif($center == 'Denpasar') {$kd_cbg = 3;}
elseif($center == 'South Jkt') {$kd_cbg = 4;}
elseif($center == 'North Jkt') {$kd_cbg = 5;}
elseif($center == 'West Jkt') {$kd_cbg = 6;}
elseif($center == 'Bandung') {$kd_cbg = 7;}
elseif($center == 'Malang') {$kd_cbg = 8;}

if ($center=='--ALL--' or $center==''  )
	{
	$pilihcabang = "";
	}
elseif ($center == 'JAKARTA')
	{
	$pilihcabang = q_set($__p_pilihcabang, " where (cabang = '4' or cabang = '5' or cabang = '6')");
	}
elseif ($center == 'SURABAYA')
	{
	$pilihcabang = q_set($__p_pilihcabang, " where (cabang = '1' or cabang = '2')");
	}
else
	{
	$pilihcabang = q_set($__p_pilihcabang, " where cabang = ? ", [(string) ($kd_cbg)]);
	}

$query_event = q_set($__p_query_event, "SELECT a.jam_mulai, a.jam_selesai, a.kategori, a.aktivitas, a.cabang, a.pic, a.dt_entry,a.id FROM ves_data.activities a " . $pilihcabang, [...($__p_pilihcabang ?? [])]);
//$query_groupby = " group by e.kelas, e.mulai_tm, f.nm_teacher";
//$query_event =  "$query_event$pilihcabang$pilihteacher$pilihact$query_groupby"  ;

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
			contenthight:1000,
			navLinks: true, // can click day/week names to navigate views
			editable: false,
			eventLimit: true, // allow "more" link when too many events
			events: 
				[
<?php

$resource_event= db_query_or_die('errro_visitor1', $query_event, $__p_query_event ?? []);
$keluar_event= db_num_rows($resource_event);
				if(num(db_num_rows($resource_event)) > 0)
					{
					while ($row_event=  db_fetch($resource_event, PDO::FETCH_NUM))
						{
						
						$mulai_tm  = $row_event[0]; 
						$selesai_tm  = $row_event[1];	
						$kategori  = $row_event[2];	
						$aktivitas  = $row_event[3];	
						$cabang  = $row_event[4];	
						$pic  = $row_event[5];	
						$dt_entry  = $row_event[6];
						$id  = $row_event[7];
							
						$period = "$mulai_tm $selesai_tm";
				 ?>	{
					start: '<?php echo e($mulai_tm); ?>',
					end :'<?php echo e($selesai_tm);?>',
	
			title: '<?php echo e($kategori)?>',
				<?php 
				if ($kategori == "Internal Meeting")
					{ ?>
					color:'#5983E5',					
					<?php }
				elseif ($kategori == "School Visit")
					{ ?>
					color: '#FF0505',										
					<?php }
				elseif ($kategori == "Marketing Event")
					{ ?>
					color: '#B811DD',										
					<?php }
			 	else{ ?>
					color: '#B811DD',										
					<?php }	?>

					pic :'namama',
					
               url: 'working_detail.php?no=<?php echo e(u($id)) ?>',						
				
					},		
<?php						}
					}
?>


				],
			eventClick: function(event)
				{
				if (event.url) 
					{
					window.open(event.url, "popup", "width=500,height=800,toolbar=0");
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
 <?php //   include __DIR__ . "/left.php";	 ?>
 <?php //====================== ?>
  <!-- Content Wrapper. Contains page content -->
<form role="form">
 <div class="box-header with-border">
  <div class='col-md-12' align="center">
<div class="row">
  <div class="col-md-2">
        <div class="form-group">
            <select class="form-control" name="center" onChange="this.form.submit()">
              <option>--ALL--</option>
              <option>JAKARTA</option>
              <option>SURABAYA</option>
              <option>East Sby</option>
              <option>West Sby</option>
              <option>Bali</option>
              <option>South Jkt</option>
              <option>North Jkt</option>
              <option>West Jkt</option>
              <option>Bandung</option>
              <option>Malang</option>
              <option selected><?php echo e($center) ?></option>
            </select>
          </div>
        </div>
  <div class="col-md-2">
        <div class="form-group">
<a href="dashboard.php" class="btn btn-primary" role="button"><< Back To Menu</a>         
          </div>
        </div>
        <div class="col-md-2">
          <div class="form-group"> <a href="activites_new.php" target="popup" 
onclick="window.open('activites_new.php','popup','width=600,height=900'); return false;" class="btn btn-primary" role="button">Aktivitas Baru</a> </div>
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
