<?php
require_once __DIR__ . "/_lib/bootstrap.php"; auth_require_login(); 
date_default_timezone_set('Asia/Jakarta');
$id = in_val('id', 'get');
$st_class= in_val('st_class', 'get');
$cabang = in_val('cbg', 'get');
$start_date = in_val('start_date', 'get');
$end_date = in_val('end_date', 'get');
$nm_room = in_val('nm_room', 'get');
if($nm_room <> ''){$bsapp = 1;} else {$bsapp = 0;}
$hari=date("d");
$bulan=date("m");
$tahun=date("Y");
$dispname = in_val('disp', 'get');
$hari_ini = "$tahun-$bulan-$hari";
if ($start_date==""){$start_date = "$tahun-$bulan-01";}
if ($end_date==""){$end_date = "$tahun-$bulan-31";}
include __DIR__ . "/conndb.php";

$query_order = q_set($__p_query_order, "SELECT date_format(mulai_tm, '%W %d %b %Y') as hari,date_format(mulai_tm, '%k:%i'), date_format(selesai_tm, '%k:%i'), nm_teacher, kelas, center, catatan, keterangan,pic,dt_entry,id,kd_branch,date_format(mulai_tm, '%Y-%m-%d'),mulai_tm,kd_biodata   FROM vip_teacher_schedule where id=? ", [(string) ($id)]);	

$resource_order = db_query_or_die('errro_71', $query_order, $__p_query_order ?? []);
$keluar_order= db_num_rows($resource_order);
if(num(db_num_rows($resource_order)) > 0)
	{
	while ($row_periode=  db_fetch($resource_order, PDO::FETCH_NUM))
		{
		$hari_order = $row_periode[0];
		$jam_mulai = $row_periode[1];
		$jam_selesai =  $row_periode[2];
		$nm_teacher_dipilih =  $row_periode[3];
		$aktifitas =  $row_periode[4];
		$center=  $row_periode[5];
		$catatan= $row_periode[6];


		$pic_order =  $row_periode[8];
		$kd_center =  $row_periode[11];
		$tanggal =  $row_periode[12];
			
		}
	}


if ($nm_room <> '')
	{
	$query_cek_room = q_set($__p_query_cek_room, "SELECT nm_teacher, mulai_tm, selesai_tm,room,center,kelas FROM ves_data.vip_teacher_schedule WHERE center = ? and  room =? and mulai_tm like ? order by mulai_tm", [(string) ($center), (string) ($nm_room), (string) ($tanggal) . "%"]);
	$result_cek_room=db_query_or_die("Wah error nih1", $query_cek_room, $__p_query_cek_room ?? []);
	if(num(db_num_rows($result_cek_room)) > 0)
		{
		while ($row_room=  db_fetch($result_cek_room, PDO::FETCH_NUM))
			{
			$pengajuan_mulai = "$tanggal $jam_mulai:01";

			$pengajuan_selesai = "$tanggal $jam_selesai:00";							
			$jamkelas_mulai = $row_room[1];

			$jamkelas_selesai = $row_room[2];	
			$kelas_detail = $row_room[5];	

			if (strtotime($pengajuan_mulai) >= strtotime($jamkelas_mulai))
				{
				if ( strtotime($pengajuan_mulai) <= strtotime($jamkelas_selesai))
					{		
					echo "<script type=\"text/javascript\">\n";
					echo "alert('" . e($mulai_kelas_check) . " Ruangan digunakan " . e($kelas_detail) . " mulai " . e($jamkelas_mulai) . " sampai  " . e($jamkelas_selesai) . " ');\n";	
					echo "</script>";
					$nm_room = '';
					}
				}
			else
				{
				if (strtotime($pengajuan_selesai) >= strtotime($jamkelas_mulai))
					{
					echo "<script type=\"text/javascript\">\n";
					echo "alert('" . e($mulai_kelas_check) . " Ruangan digunakan " . e($kelas_detail) . " mulai " . e($jamkelas_mulai) . " sampai  " . e($jamkelas_selesai) . " ');\n";	
					echo "</script>";
					$nm_room = '';	
					}						
				}
				
			}
		}
	
	}
$query_event = q_set($__p_query_event, "SELECT e.id, e.mulai_tm, e.selesai_tm, f.nm_teacher, e.kelas, e.center, e.room, e.keterangan,e.nm_teacher,e.catatan\r
FROM ves_data.vip_teacher_schedule e,ves_data.vip_teacher_name f\r
where e.nm_teacher = f.kd_teacher and e.st_cl <> '1'\r
and e.status_kelas <> 0 and e.kd_branch = ? and e.mulai_tm like ? group by e.kelas, e.mulai_tm, f.nm_teacher", [(string) ($kd_center), (string) ($tanggal) . "%"]);

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

$resource_event= db_query_or_die('errro_visitor1', $query_event, $__p_query_event ?? []);
$keluar_event= db_num_rows($resource_event);
				if(num(db_num_rows($resource_event)) > 0)
					{
					while ($row_event=  db_fetch($resource_event, PDO::FETCH_NUM))
						{
						$kd = $row_event[0];							
						$mulai_tm  = $row_event[1]; 
						$selesai_tm  = $row_event[2];	
						$nm_teacher  = $row_event[8];	
						$kelas  = $row_event[4];	
						$cabang  = $row_event[5];	
						$ruang  = $row_event[6];	

						$catatan  = $row_event[9];	
							

				 ?>	{
					start: '<?php echo e($mulai_tm);?>',
					end :'<?php echo e($selesai_tm);?>',

					title: '<?php echo e($nm_teacher)?>-(<?php echo e($kelas);?>)',
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
 <?php //   include __DIR__ . "/left.php";	 ?>
 <?php //====================== ?>
  <!-- Content Wrapper. Contains page content -->
<form role="form">
 <div class="box-header with-border">
  <div class='col-md-12' align="left"></div>
<div class="row"><br>
       	      <div class="col-md-2">
       	        <div class="form-group"><label>Date : <?php echo e($hari_order) ?></label>
       	          <input type="text" name="kdt" value="<?php echo e($kd_teacher) ?>" hidden="hidden">
   	              <input type="text" name="id" value="<?php echo e($id) ?>" hidden="hidden" >
       	        </div>
   	          </div>
    </div></div>  
 <div class="col-md-12">
	    <div class="box box-warning">
		  		<div class="box-header with-border"></div>
       	<table id="example1" class="table table-bordered table-striped">
                <thead>

                <tr>
                  <th width="6%"> Teacher's </th>
                  <th width="4%">Center</th>
                  <th width="3%">Time</th>
                  <th width="16%">Activities</th>
                  <th width="29%">Description</th>
                  <th width="16%">Room</th>
                  <th width="16%">Status</th>
                  <th width="21%">Order By</th>
                  </tr>
                </thead>
                <tbody>   
                <tr>
                  <td><?php echo e($nm_teacher_dipilih) ; ?></td>
                  <td><?php echo e($center) ?></td>
                  <td><?php echo e($jam_mulai) ; ?> - <?php echo e($jam_selesai) ; ?></td>
                  <td><?php echo e($aktifitas) ; ?></td>
                  <td><?php echo e($keterangan) ; ?></td>
                  <td><span class="form-group">
                    <select class="form-control" name="nm_room" onChange="this.form.submit()">
                      <?php
								$query_room = q_set($__p_query_room, "SELECT kd_room FROM ves_data.vip_room_name where kd_branch = ? ", [(string) ($kd_center)]);
								$resource_room = db_query_or_die('errro_7', $query_room, $__p_query_room ?? []);
								while ($row_nm_room=  db_fetch($resource_room, PDO::FETCH_NUM))
									{
							  		echo '<option value="'.e($row_nm_room[0]).'">'.e($row_nm_room[0]).'</option>';
							  		}      ?>
                      <option selected><?php echo  e($nm_room) ?></option>
                    </select>
                  </span></td>
                  <td><?php echo e($catatan) ; ?><br>
                  <?php if (num($bsapp) ==1){?>
<a href="vip_dtlorderupd.php?id=<?php echo e(u($id)); ?>&st=1&nmroom=<?php echo e(u($nm_room)) ?>" target="popup" onclick="window.open('vip_dtlorderupd.php?id=<?php echo e(u($id)); ?>&st=1&nmroom=<?php echo e(u($nm_room)) ?>','popup','width=1000,height=800'); return false;"> <img src="imgs/hdr.png" width="15" height="18">
                  </a> <?php } else {?>
                  <img src="imgs/hdr.png" width="15" height="18">
                  <?php } ?>
                  <a href="vip_dtlorderupd.php?id=<?php echo e(u($id)); ?>&st=0"><img src="imgs/bls.png" width="13" height="16">
                  </a>
                  </td>
                  <td><?php echo e($pic_order) ; ?> (<?php echo e($tanggal) ; ?>)</td>
                  </tr>
                </tbody>
                <tfoot>
                </tfoot>
              </table>
		</div>	
	<div id='calendar'></div>				
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
