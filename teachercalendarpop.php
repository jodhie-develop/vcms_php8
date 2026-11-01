<?php
include __DIR__ . "/conndb.php";
include __DIR__ . "/profiledata.php";
//include ("atas.php");
auth_require_login();
$q = in_str('q', 1, 'get');
if($q==''){$q='t';}
$tampilan = in_str('tampilan', 30, 'get');
$kode_teacher = in_str('nm_teacher', 45, 'get');
$posisi = $_SESSION['posisi'];
$list_nm_teacher = '';
$nm_teacher_dipilih = '';

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
$query_nm_teacher = "SELECT kd_teacher, nm_teacher FROM ves_data.vip_teacher_name where aktif = 1 order by nm_teacher";
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
$query_event = "SELECT e.id,   e.mulai_tm, e.selesai_tm, f.nm_teacher, e.kelas, e.center, e.room, e.keterangan,e.nm_teacher,e.catatan,e.status_kelas FROM ves_data.vip_teacher_schedule e,ves_data.vip_teacher_name f where e.nm_teacher = f.kd_teacher and  e.st_cl <> '1' ";
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
              window.open('detail_event.php','Popup','height=300,width=600');
 window.open('detail_order.php','Popup','height=300,width=800');	
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
						$st_kelas  = $row_event[10];	
							
							

				 ?>	{
					start: <?php echo js($mulai_tm) ?>,
					end : <?php echo js($selesai_tm) ?>,

					<?php if($q == 't')
			{?>
			title: <?php echo js($nm_teacher . '-(' . $kelas . ')') ?>,
				<?php 
				if ($st_kelas == 1)
					{ ?>
					color:'#5983E5',					
					<?php }
				elseif ($st_kelas == 0)
					{ ?>
					color: '#000000',										
					<?php }
				elseif ($st_kelas == 50 or $st_kelas == 60 or $st_kelas == 70 or $st_kelas == 80 or $st_kelas == 90  )
					{ ?>
					color: '#F7F7F7',										
					<?php }
			 	elseif ($st_kelas == 55 or $st_kelas == 66 or $st_kelas == 77 or $st_kelas == 88 or $st_kelas == 99  )
					{ ?>
					color: '#FFE500',										
					<?php }	
			 	elseif ($st_kelas == 51 or $st_kelas == 61 or $st_kelas == 71 or $st_kelas == 81 or $st_kelas == 91  )
					{ ?>
					color: '#0CCB21',										
					<?php }				 
				elseif ($st_kelas == 52 or $st_kelas == 62 or $st_kelas == 72 or $st_kelas == 82 or $st_kelas == 92  )
					{ ?>
					color: '#000000',										
					<?php }
			 	elseif ($st_kelas == 22 or $st_kelas == 33 or $st_kelas == 44  or $st_kelas == 66 or $st_kelas == 77  )
					{ ?>
					color: '#000000',																			
				<?php } ?>
		<?php } 
							else 
								{?>
					title: <?php echo js($ruang . ' - ' . $kelas . ' ') ?>,
				<?php
				if ($st_kelas == 1)
					{ ?>
					color:'#5983E5',					
					<?php }
				elseif ($st_kelas == 0)
					{ ?>
					color: '#000000',										
					<?php }
				elseif ($st_kelas == 50 or $st_kelas == 60 or $st_kelas == 70 or $st_kelas == 80 or $st_kelas == 90  )
					{ ?>
					color: '#F7F7F7',										
					<?php }
			 	elseif ($st_kelas == 55 or $st_kelas == 66 or $st_kelas == 77 or $st_kelas == 88 or $st_kelas == 99  )
					{ ?>
					color: '#FFE500',										
					<?php }	
			 	elseif ($st_kelas == 51 or $st_kelas == 61 or $st_kelas == 71 or $st_kelas == 81 or $st_kelas == 91  )
					{ ?>
					color: '#0CCB21',										
					<?php }				 
				elseif ($st_kelas == 52 or $st_kelas == 62 or $st_kelas == 72 or $st_kelas == 82 or $st_kelas == 92  )
					{ ?>
					color: '#000000',										
					<?php }
			 	elseif ($st_kelas == 22 or $st_kelas == 33 or $st_kelas == 44  or $st_kelas == 66 or $st_kelas == 77  )
					{ ?>
					color: '#000000',																			
				<?php } ?>
					
								<?php }?>
					pic :'namama',
					<?php if ($st_kelas == 1){ ?>
        url: '',							
				
						<?php }else{ ?>
                 url: '',									
						<?php } ?> 
									
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
       	        <div class="form-group">
       	          <select class="form-control" name="tampilan" onChange="this.form.submit()" >
       	            <option>Teachers Calendar</option>
       	            <option>Rooms Calendar</option>
       	            <option selected><?php echo e($tampilan) ?></option>
   	              </select>
   	            </div>
        </div>
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
                  <select class="form-control" name="nm_teacher" onChange="this.form.submit()">
                    <option>--ALL--</option>
                    <option value= ><?php echo $list_nm_teacher; /* sudah di-escape saat dibangun */ ?>
                    <option selected><?php echo e($nm_teacher_dipilih) ?></option>
                  </select>
          </div>
        </div>
        
</div>
 <div class="row">
   <table width="580" border="1">
     <tbody>
       <tr>
         <td width="138" rowspan="2" bgcolor="#F7F7F7" class="arrow" scope="row">Color Note :</td>
         <td width="138" bgcolor="#5983E5" class="arrow" scope="row" align="center">Class Running</td>
         <td width="138" bgcolor="#0CCB21" class="arrow" scope="row" align="center">Tutorial/LC Visit</td>
         <td width="138" bgcolor="#FFE500" class="arrow" scope="row" align="center">Teacher Schedule</td>
         </tr>
         <tr>
         <td width="138" bgcolor="#F7F7F7" class="arrow" scope="row" align="center">Meeting Requested</td>
         <td colspan="2" align="center" bgcolor="#000000" class="arrow" scope="row"><font color="#DF0F0F">Reject Request/Cancel Class</font></td>
         </tr>
 
     </tbody>
   </table>
 </div>
   <div class='col-md-12' align="center">
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
