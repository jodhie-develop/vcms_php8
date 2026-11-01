<?php
require_once __DIR__ . "/_lib/bootstrap.php"; auth_require_login(); 

include __DIR__ . "/conndb.php";


$q = in_val('q', 'get');
if($q==''){$q='t';}
$tampilan = in_val('tampilan', 'get');
$kode_teacher = in_val('nm_teacher', 'get');
$posisi = $_SESSION['posisi']; 

$center = in_val('center', 'get');
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
$date_start = in_val('date_start', 'get');
$date_end = in_val('date_end', 'get');
if ($date_start ==''){$date_start = $hari_ini;}
if ($date_end ==''){$date_end = $hari_ini;}

$kd_cbg = in_val('kd_cbg', 'get');


$nama_lengkap = $_SESSION['nama_lengkap'];
$nama_depan = $_SESSION['nama_depan'];
//$kd_cbg = $_SESSION['kd_branch'];
$posisi = $_SESSION['posisi']; 
$kd_staff = $_SESSION['kd_staff'] ;
$kd_area = $_SESSION['kd_area'] ;
$level_posisi = $_SESSION['level_posisi'] ;
$kdcl = in_val('kdcl', 'get');
$nmcbg = in_val('cntr', 'get');
if ($kd_cbg == '--ALL--'){$kd_cbg = 0;}
elseif ($kd_cbg == 'East Sby'){$kd_cbg = 1;}
elseif ($kd_cbg == 'West Sby'){$kd_cbg = 2;}
elseif ($kd_cbg == 'Denpasar'){$kd_cbg = 3;}
elseif ($kd_cbg == 'South Jkt'){$kd_cbg = 4;}
elseif ($kd_cbg == 'North Jkt'){$kd_cbg = 5;}
elseif ($kd_cbg == 'West Jkt'){$kd_cbg = 6;}
elseif ($kd_cbg == 'Bandung'){$kd_cbg = 7;}
elseif ($kd_cbg == 'Malang TBI'){$kd_cbg = 8;}
elseif ($kd_cbg == 'Bandung TBI'){$kd_cbg = 9;}
elseif ($kd_cbg == 'Bali TBI'){$kd_cbg = 10;}
elseif ($kd_cbg == 'National'){$kd_cbg = 100;}
elseif ($kd_cbg == 'PIK'){$kd_cbg = 11;}
elseif ($kd_cbg == 'Serpong'){$kd_cbg = 12;}
elseif ($kd_cbg == 'CA'){$kd_cbg = 15;}

if (num($kd_cbg) ==0){$cabang = '--ALL--';}
elseif ($kd_cbg ==''){$cabang = '--ALL--';}
elseif (num($kd_cbg) ==1){$cabang = 'East Sby';$db_cabang ='billing.';}
elseif (num($kd_cbg) ==2){$cabang = 'West Sby';$db_cabang ='billing_west.';}
elseif (num($kd_cbg) ==3){$cabang = 'Denpasar';$db_cabang ='billing_bali.';}
elseif (num($kd_cbg) ==4){$cabang = 'South Jkt';$db_cabang ='billing_jkt_02.';}
elseif (num($kd_cbg) ==5){$cabang = 'North Jkt';$db_cabang ='billing_new_gs.';}
elseif (num($kd_cbg) ==6){$cabang = 'West Jkt';$db_cabang ='billing_m2.';}
elseif (num($kd_cbg) ==7){$cabang = 'Bandung';$db_cabang ='billing_new_bdg.';}
elseif (num($kd_cbg) ==8){$cabang = 'Malang TBI';$db_cabang ='billing_malang.';}
elseif (num($kd_cbg) ==9){$cabang = 'Bandung TBI';}
elseif (num($kd_cbg) ==10){$cabang = 'Bali TBI';}
elseif (num($kd_cbg) ==100){$cabang = 'National';}
elseif (num($kd_cbg) ==11){$cabang = 'PIK';}
elseif (num($kd_cbg) ==12){$cabang = 'Serpong';}
elseif (num($kd_cbg) ==15){$cabang = 'CA';}
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>VIP Academic Calendar</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
<style type="text/css">
<!--

	.style33 {
	color:#000;
	font-size:130%;
	}

</style>  

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
</head>
<body>
<?php  //  include ('left.php') ?>
<div class="wrapper">
  <!-- Main content -->
  <section class="invoice">
      <div class="row">
        <div class="col-xs-12">
        <div class="col-xs-12">
        <h3 class="page-header" align="center">Room Usage<br>
          <?php echo e($nm_program) ?>        <?php echo e($lv_program) ?><br>
          (Evaluation Version)<br>
        </h3>
 <form method=GET>  
<div class="row">
  <div class="col-md-2">
          <div class="form-group">
			  Location
            <select name="kd_cbg"  class="form-control" id="select">
		   
             <option value="0">--CHOOSE--</option>
             <option value="4">South Jkt</option>
             <option value="5">North Jkt</option>
             <option value="11">PIK</option>	
             <option value="12">Serpong</option>				   
             <option value="6">West Jkt</option>

             <option value="15">CA</option>
             <option value="1">East Sby</option>
             <option value="2">West Sby</option>
             <option value="3">Denpasar</option>
             <option value="8">Malang</option>
             <option value="101">East Area</option>
             <option value="7">Bandung</option>
             <option value="102">West Area</option>
             <option value="100">National</option>
		   
             <option selected="selected"><?php echo e($cabang) ?></option>
           </select>
          </div>
        </div>
  <div class="col-md-2">
    <div class="form-group"> Start Period
      <input type="date" format="dd/MM/yyyy" name="date_start"  class="form-control" id="date2" value="<?php echo e($date_start) ; ?>" >
    </div>
  </div>
  <div class="col-md-2">
    <div class="form-group"> End Period
      <input type="date" format="dd/MM/yyyy" name="date_end"  class="form-control" id="date" value="<?php echo e($date_end) ; ?>" >
    </div>
  </div>
  <div class="col-md-2">
    <div class="form-group">
            <label></label>
            <input name="Display" type="submit" id="Save"  class="form-control"  value="Display"  />
          </div>
      </div>
        <div class="col-md-12">
          <div class="form-group">
            <h3>ROOM CALENDAR</h3>
          </div>
        </div>
</div>
			</form>	 
        </div></div>
      <!-- /.col -->
    </div>
      <div class="row">

<?php
$query_room = q_set($__p_query_room, "select  nm_room,kd_room from vip_teacher_schedule a left join vip_room_name b on a.room  = b.kd_room and a.kd_branch = b.kd_branch\r
 where mulai_tm between ? and ? and a.kd_branch = ? and b.status = 1 and a.status_kelas <> 0 group by room", [(string) ($date_start), (string) ($date_end), (string) ($kd_cbg)]);
; 
$resource_room = db_query_soft($query_room, $__p_query_room ?? []);
			
if(num(db_num_rows($resource_room)) > 0)
	{
	while ($row_room  =  db_fetch($resource_room, PDO::FETCH_NUM))
		{
		$room = $row_room[0];	
		$kdr = $row_room[1];	
		
		$query_jampagi = q_set($__p_query_jampagi, "select\r
round(sum(TIMEDIFF(DATE_ADD(selesai_tm, interval 1 SECOND),mulai_tm))/10000)  from vip_teacher_schedule a left join vip_room_name b on a.room  = b.kd_room and a.kd_branch = b.kd_branch where mulai_tm between ? and ?\r
 and a.kd_branch = ? and  status_kelas = 1 and (date_format(mulai_tm,'%H:%s') >='09:00:00' and date_format(mulai_tm,'%H:%s') <='14:00:00' ) and nm_room = ? ", [(string) ($date_start), (string) ($date_end), (string) ($kd_cbg), (string) ($room)]);  
		$resource_jampagi = db_query_soft($query_jampagi, $__p_query_jampagi ?? []);

		if(num(db_num_rows($resource_jampagi)) > 0)
			{
			while ($row_jampagi  =  db_fetch($resource_jampagi, PDO::FETCH_NUM))
				{
				$jampagi = $row_jampagi[0];
				}
			}

		$query_jamsiang = q_set($__p_query_jamsiang, "select\r
round(sum(TIMEDIFF(DATE_ADD(selesai_tm, interval 1 SECOND),mulai_tm))/10000)  from vip_teacher_schedule a left join vip_room_name b on a.room  = b.kd_room and a.kd_branch = b.kd_branch where mulai_tm between ? and ?\r
 and a.kd_branch = ? and  status_kelas = 1 and (date_format(mulai_tm,'%H:%s') >='14:00:01' and date_format(mulai_tm,'%H:%s') <='19:00:00' ) and nm_room = ? ", [(string) ($date_start), (string) ($date_end), (string) ($kd_cbg), (string) ($room)]);  
		$resource_jamsiang = db_query_soft($query_jamsiang, $__p_query_jamsiang ?? []);

		if(num(db_num_rows($resource_jamsiang)) > 0)
			{
			while ($row_jamsiang  =  db_fetch($resource_jamsiang, PDO::FETCH_NUM))
				{
				$jamsiang = $row_jamsiang[0];
				}
			}		
		$query_jammalam = q_set($__p_query_jammalam, "select\r
round(sum(TIMEDIFF(DATE_ADD(selesai_tm, interval 1 SECOND),mulai_tm))/10000)  from vip_teacher_schedule a left join vip_room_name b on a.room  = b.kd_room and a.kd_branch = b.kd_branch where mulai_tm between ? and ?\r
 and a.kd_branch = ? and  status_kelas = 1 and (date_format(mulai_tm,'%H:%s') >='19:00:01' and date_format(mulai_tm,'%H:%s') <='22:00:00' ) and nm_room = ? ", [(string) ($date_start), (string) ($date_end), (string) ($kd_cbg), (string) ($room)]);  
		$resource_jamsmalam = db_query_soft($query_jammalam, $__p_query_jammalam ?? []);

		if(num(db_num_rows($resource_jamsmalam)) > 0)
			{
			while ($row_jammalam  =  db_fetch($resource_jamsmalam, PDO::FETCH_NUM))
				{
				$jammalam = $row_jammalam[0];
				}
			}		
?>			        <div class="col-md-2">
          <!-- Widget: user widget style 1 -->
          <div class="box box-widget widget-user-1">

            <div class="widget-user-header bg-yellow"><!-- /.widget-user-image -->
              <h3 align="center"><?php echo e($room) ?></h3>
              <h5 align="center">Capacity</h5>
            </div>
            <div class="box-footer no-padding">
              <ul class="nav nav-stacked">
                <li> <a href="roomusagedtl.php" 
target="popup" 
onclick="window.open('roomusagedtl.php?kdr=<?php echo e(u($kdr)) ?>&grp=1&sd=<?php echo e(u($date_start)) ?>&ed=<?php echo e(u($date_end)) ?>&cbg=<?php echo e(u($kd_cbg)) ?>','popup','width=800,height=1600'); return false;">09.00 - 14.00<span class="pull-right badge bg-blue"><?php echo e($jampagi) ?></span></a></li>
                <li><a href="roomusagedtl.php" 
target="popup" 
onclick="window.open('roomusagedtl.php?kdr=<?php echo e(u($kdr)) ?>&grp=2&sd=<?php echo e(u($date_start)) ?>&ed=<?php echo e(u($date_end)) ?>&cbg=<?php echo e(u($kd_cbg)) ?>','popup','width=800,height=1600'); return false;">14.01 - 19.00<span class="pull-right badge bg-aqua"><?php echo e($jamsiang) ?></span></a></li>
                <li><a href="roomusagedtl.php" 
target="popup" 
onclick="window.open('roomusagedtl.php?kdr=<?php echo e(u($kdr)) ?>&grp=3&sd=<?php echo e(u($date_start)) ?>&ed=<?php echo e(u($date_end)) ?>&cbg=<?php echo e(u($kd_cbg)) ?>','popup','width=800,height=1600'); return false;">19.01 - 22.00 <span class="pull-right badge bg-green"><?php echo e($jammalam) ?></span></a></li>
              </ul>
            </div>
          </div>
          <!-- /.widget-user -->
        </div>
<?php } }?>		  
	  </div>	  
<!-- ./wrapper -->
</body>
</html>

<script>
  $(function () {
    $("#example1").DataTable();
    $('#example2').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false
    });
  });
</script>
