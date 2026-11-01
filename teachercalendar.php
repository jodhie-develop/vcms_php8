<?php
include __DIR__ . "/conndb.php";
include __DIR__ . "/profiledata.php";
//include ("atas.php");
auth_require_login();
$q = in_str('q', 1, 'get');
if($q==''){$q='t';}
$Display = in_str('Display', 20, 'get');
$bln_skrng = date("Y-m");
$tigabulan_lalu =  date('Y-m-d', strtotime('today - 90 days'));
$tampilan = in_str('tampilan', 30, 'get');
$kode_teacher = in_str('nm_teacher', 45, 'get');
$posisi = $_SESSION['posisi'];
$class_cat = in_str('class_cat', 20, 'get');
$list_nm_teacher = '';
$nm_teacher_dipilih = '';
$day_1 = $day_2 = $day_3 = $day_4 = $day_5 = $day_6 = '';

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
$date_start = in_date('date_start', "2024-07-01", 'get');
$date_end = in_date('date_end', $hari_ini, 'get');

$kd_cbg = in_str('kd_cbg', 3, 'get');

if ($kd_cbg ==1){$center = 'East Sby';}
elseif ($kd_cbg ==2){$center = 'West Sby';}
elseif ($kd_cbg ==3){$center = 'Denpasar';}
elseif ($kd_cbg ==4){$center = 'South Jkt';}
elseif ($kd_cbg ==5){$center = 'North Jkt';}
elseif ($kd_cbg ==6){$center = 'West Jkt';}
elseif ($kd_cbg ==7){$center = 'Bandung';}
elseif ($kd_cbg ==8){$center = 'Malang TBI';}
elseif ($kd_cbg ==9){$center = 'Bandung TBI';}
elseif ($kd_cbg ==10){$center = 'Bali TBI';}
elseif ($kd_cbg ==100){$center = 'ONLINE';}
$query_nm_teacher = "SELECT kd_teacher, nm_teacher FROM ves_data.vip_teacher_name where status <> 0 order by nm_teacher";

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
$query_teacher = "SELECT kd_teacher, nm_teacher,kd_branch,day_1, day_2, day_3, day_4, day_5, day_6 FROM ves_data.vip_teacher_name where kd_teacher = ?";

$rows_teacher = db_all($query_teacher, [$kode_teacher], PDO::FETCH_BOTH);
$ada = count($rows_teacher);

if ($ada >= 1)
	{
	foreach ($rows_teacher as $row_teacher)
		{
		$nm_teacher_dipilih = $row_teacher['1'];
		$kode_teacher	 = $row_teacher['0'];
		$day_1 	 = $row_teacher['3'];
		$day_2 	 = $row_teacher['4'];
		$day_3 	 = $row_teacher['5'];
		$day_4 	 = $row_teacher['6'];
		$day_5 	 = $row_teacher['7'];
		$day_6 	 = $row_teacher['8'];

		}
	}
else
	{
	$query_teacher = "SELECT kd_teacher, nm_teacher,kd_branch,day_1, day_2, day_3, day_4, day_5, day_6 FROM ves_data.vip_teacher_name where nm_teacher = ?";
	$resource_teacher = db_query($query_teacher, [$kode_teacher]);
		while ($row_teacher = $resource_teacher->fetch())
		{
		$nm_teacher_dipilih = $row_teacher['1'];
		$kode_teacher	 = $row_teacher['0'];
		$day_1 	 = $row_teacher['3'];
		$day_2 	 = $row_teacher['4'];
		$day_3 	 = $row_teacher['5'];
		$day_4 	 = $row_teacher['6'];
		$day_5 	 = $row_teacher['7'];
		$day_6 	 = $row_teacher['8'];
			
		}
	}

$params_event = [$tigabulan_lalu];
if ($center=='--ALL--')
	{
	$pilihcabang = "";
	}
elseif ($center == 'ONLINE')
	{
	$pilihcabang = " and e.kd_branch  ='100'";
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
$type_act = in_str('type_act', 20, 'get');
if ($type_act=='--ALL--' or $type_act =='')
	{
	$pilihact = " and e.status_kelas <> 0";
	}
elseif ($type_act == 'Teaching')
	{
	$pilihact = " and (e.status_kelas = 1 or e.status_kelas = 51 or e.status_kelas = 61 or e.status_kelas = 71 or e.status_kelas = 75 or e.status_kelas = 81 or e.status_kelas = 91 )";
	}
else
	{
	// Versi lama punya ")" berlebih di sini sehingga filter Non Teaching selalu error SQL; diperbaiki.
	$pilihact = "  and (e.status_kelas = 22 or e.status_kelas = 33 or e.status_kelas = 44 or e.status_kelas = 66 or e.status_kelas = 77 or e.status_kelas = 700 or e.status_kelas = 701 or e.status_kelas = 702 or e.status_kelas = 703 or e.status_kelas = 704)";

	}
$pilihclasscat = " ";
if ($class_cat=='--ALL--' or $class_cat =='')
	{
	$pilihclasscat = " ";
	}
elseif ($class_cat=='LC')
	{
	$pilihclasscat = "  and (e.status_kelas = 71 or e.status_kelas = 75)";
	}
elseif ($class_cat=='LC Standby')
	{
	$pilihclasscat = "  and (e.status_kelas = 700 or e.status_kelas = 701  or e.status_kelas = 702  or e.status_kelas = 703  or e.status_kelas = 704)";
	}

//$query_event = "SELECT e.id,   e.mulai_tm, e.selesai_tm, f.nm_teacher, e.kelas, e.center, e.room, e.keterangan,e.nm_teacher,e.catatan,e.status_kelas FROM ves_data.vip_teacher_schedule e,ves_data.vip_teacher_name f where e.nm_teacher = f.kd_teacher and  e.st_cl <> '1' and e.mulai_tm >='$tigabulan_lalu' ";
//$query_groupby = " group by e.kelas, e.mulai_tm";

$query_event = "SELECT e.id,   e.mulai_tm, e.selesai_tm, e.nm_teacher, e.kelas, e.center, e.room, e.keterangan,e.nm_teacher,e.catatan,e.status_kelas FROM ves_data.vip_teacher_schedule e where e.st_cl <> '1' and e.mulai_tm >= ? ";
$query_groupby = " group by e.kelas, e.mulai_tm";


$query_event =  "$query_event$pilihcabang$pilihteacher$pilihact$pilihclasscat$query_groupby"  ;

?>
<!DOCTYPE html>
<html>
<head>
  <meta http-equiv="refresh" content="500" />
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Academic Calendar</title>
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
					color: '#FF0505',										
					<?php }
				elseif ($st_kelas == 50 or $st_kelas == 60 or $st_kelas == 70 or $st_kelas == 80 or $st_kelas == 90  or $st_kelas == 700 )
					{ ?>
					color: '#CBBD03',										
					<?php }
			 	elseif ($st_kelas == 22 or $st_kelas == 33 or $st_kelas == 44 or $st_kelas ==  66 or $st_kelas == 77  )
					{ ?>
					color: '#B811DD',										
					<?php }	
			 	elseif ($st_kelas == 51 or $st_kelas == 61 or $st_kelas == 81 or $st_kelas == 91  )
					{ ?>
					color: '#04FF50',										
					<?php }	
			 	elseif ($st_kelas == 71  or $st_kelas == 702 )
					{ ?>
					color: '#5A556F',										
					<?php }	
		 
				elseif ($st_kelas == 52 or $st_kelas == 62 or $st_kelas == 72 or $st_kelas == 82 or $st_kelas == 92 or $st_kelas == 42  )
					{ ?>
					color: '#FF0505',										
					<?php }	
			 	elseif ($st_kelas == 456 )
					{ ?>
					color: '#2A056C',										
					<?php }?>
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
					color: '#FF0505',										
					<?php }
				elseif ($st_kelas == 50 or $st_kelas == 60 or $st_kelas == 70 or $st_kelas == 80 or $st_kelas == 90  or $st_kelas == 700   )
					{ ?>
					color: '#CBBD03',										
					<?php }
			 	elseif ($st_kelas == 22 or $st_kelas == 33 or $st_kelas == 44 or $st_kelas ==  66 or $st_kelas == 77  )
					{ ?>
					color: '#B811DD',										
					<?php }	
			 	elseif ($st_kelas == 51 or $st_kelas == 61 or $st_kelas == 81 or $st_kelas == 91  )
					{ ?>
					color: '#04FF50',										
					<?php }	
			 	elseif ($st_kelas == 71  or $st_kelas == 702 )
					{ ?>
					color: '#5A556F',										
					<?php }		
								 
				elseif ($st_kelas == 52 or $st_kelas == 62 or $st_kelas == 72 or $st_kelas == 82 or $st_kelas == 92  )
					{ ?>
					color: '#FF0505',										
					<?php }	
			 	elseif ($st_kelas == 456 )
					{ ?>
					color: '#2A056C',										
					<?php }?>
					
								<?php }?>
					pic :'namama',
					<?php if ($st_kelas == 1){ ?>
               url: <?php echo js('detail_event.php?cdl=' . u($kelas) . '&cbg=' . u($cabang)) ?>,

						<?php }else{ ?>
                url: <?php echo js('detail_order.php?id=' . u($kd)) ?>,												
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
 <form method=GET> 
 <div class="box-header with-border">
  <div class='col-md-12' align="center">
    <div class="row">
        <div class="col-md-2">
          <div class="form-group">
<a href="dashboard.php" class="btn btn-primary" role="button"><< Back To Menu</a>         
          </div>
        </div>
        <div class="col-md-2">
          <div class="form-group"> <a href="freeteachercalendar.php" class="btn btn-primary" role="button">Teacher's Available Time Slot (trial)</a> </div>
        </div>
</div>	  
<div class="row">
        <div class="col-md-2">
       	        <div class="form-group">
				Teacher/Room
       	          <select class="form-control" name="tampilan" >
       	            <option>Teachers Calendar</option>
       	            <option>Rooms Calendar</option>
       	            <option selected><?php echo e($tampilan) ?></option>
   	              </select>
   	            </div>
        </div>
        <div class="col-md-2">
          <div class="form-group">
			  Location
            <select class="form-control" name="center">
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
              <option>ONLINE</option>				
              <option selected><?php echo e($center) ?></option>
            </select>
          </div>
        </div>
        <div class="col-md-2">
                <div class="form-group">
					Teacher
                  <select class="form-control" name="nm_teacher">
                    <option>--ALL--</option>
                    <option value= ><?php echo $list_nm_teacher; /* sudah di-escape saat dibangun */ ?>
                    <option selected><?php echo e($nm_teacher_dipilih) ?></option>
                  </select>
          </div>
        </div>
        <div class="col-md-2">
          <div class="form-group">
			  Type Activities
            <select class="form-control" name="type_act">
              <option>--ALL--</option>
              <option>Teaching</option>
              <option>Non Teaching</option>
              
            </select>
          </div>
        </div>
        <div class="col-md-2">
          <div class="form-group">
			   Class Category
            <select class="form-control" name="class_cat">
              <option>--ALL--</option>
              <option>LC Standby</option>				
              <option>LC</option>
                    <option selected><?php echo e($class_cat) ?></option>				
            </select>
          </div>
        </div>
        <div class="col-md-2">
			Click Here to View the Calendar
          <div class="form-group">
            <label></label>
            <input name="Display" type="submit" id="Save"  class="form-control"  value="Display"  />
          </div>
      </div>
        <div class="col-md-12">
          <div class="form-group">
            <h3>ACADEMIC CALENDAR</h3>
          </div>
        </div>
</div>
 <div class="row">
   <table width="1031" border="1">
     <tbody>
       <tr style="color: #030303" align="center">
         <th width="124" bgcolor="#5983E5"scope="row"><strong>Class Running</strong></th>
         <td width="124" bgcolor="#FF0505"><strong>Cancel Class</strong></td>
         <td width="124" bgcolor="#CBBD03"><strong>Meeting Order</strong></td>
         <td width="124" bgcolor="#B811DD"><strong>Non Teaching</strong></td>
         <td width="124" bgcolor="#04FF50">Tutorial/Late Attendance</td>
         <td width="124" bgcolor="#5A556F" style="color:#F7F0F0"><strong>LC Visit</strong></td>
         <td width="124" bgcolor="#FF0505"><strong>Reject Order</strong></td>
       </tr>
     </tbody>
   </table>
   <br>
   <table width="900" border="1">
     <tbody>
       <tr>
         <th scope="row">Name</th>
         <td >Mon</td>
         <td >Tue</td>
         <td >Wed</td>
         <td >Thu</td>
         <td >Fri</td>
         <td >Sat</td>
       </tr>
       <tr>
<?php		   
$senin_shift = $selasa_shift = $rabu_shift = $kamis_shift = $jumat_shift = $sabtu_shift = '';
$query_shift = "SELECT date_format(tanggal, '%w') ,date_format(kerja_mulai, '%H:%i'),date_format(kerja_selesai, '%H:%i') FROM ves_data.emp_time_work where tanggal like ? and kd_emp = ? group by date_format(tanggal, '%w') order by date_format(tanggal, '%w') ";

$resource_shift = db_query($query_shift, [$bln_skrng . '%', $kode_teacher]);
		{
		while ($row_shift = $resource_shift->fetch(PDO::FETCH_NUM))
			{
			$noday = $row_shift[0];
			$periode_shift = "$row_shift[1] - $row_shift[2]" ;
			if ($noday == 1) {$senin_shift =$periode_shift; }
			elseif ($noday == 2) {$selasa_shift =$periode_shift; }
			elseif ($noday == 3) {$rabu_shift =$periode_shift; }
			elseif ($noday == 4) {$kamis_shift =$periode_shift; }
			elseif ($noday == 5) {$jumat_shift =$periode_shift; }
			elseif ($noday == 6) {$sabtu_shift =$periode_shift; }

			}	
		}
?>					
         <th scope="row"><?php echo e($nm_teacher_dipilih) ?></th>
         <td ><?php echo e($senin_shift) ?></td>
         <td ><?php echo e($selasa_shift) ?></td>
         <td ><?php echo e($rabu_shift) ?></td>
         <td ><?php echo e($kamis_shift) ?></td>
         <td ><?php echo e($jumat_shift) ?></td>
         <td ><?php echo e($sabtu_shift) ?></td>
       </tr>
     </tbody>
   </table>
 </div>
<?php if ($Display !='')	{?>  
 <div class="row">
 	  <div class="col-12">

	<div id='calendar'></div>
	  </div>	
    </div>
<?php } ?>

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
