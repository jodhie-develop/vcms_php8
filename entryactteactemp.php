<?php
// Varian "My Agenda" untuk admin akademik (menu di left.php hanya untuk Savita):
// bisa memilih teacher. Form POST + token CSRF; kd_teacher selalu dari DB.
include __DIR__ . "/conndb.php";
include __DIR__ . "/profiledata.php";
auth_require_login();
auth_require(auth_is('kelompok', 'ACD') && auth_is('posisi', 'AS'));
include __DIR__ . "/atas.php";

include __DIR__ . "/left.php";

$hari=date("d");
$bulan=date("m");
$tahun=date("Y");
$hari_ini = "$tahun-$bulan-$hari";

$bulan_lalu = $bulan -1;
//if ($bulan_lalu =< 9) {$bulan_lalu ="0.$bulan_lalu";}
if($bulan_lalu <= 9) { $bulan_lalu ="0$bulan_lalu";}
$hari_ini_lalu = "$tahun-$bulan_lalu-$hari";
$nm_teacher = in_str('nm_teacher', 45);
if ($nm_teacher ==''){$nm_teacher= in_str('nmt', 45);}

$center = in_str('center', 45);
$kd_center = in_str('kd_cbg', 3);
$id = in_int('id', 0);
$list_nm_teacher = '';
$kd_teacher = $day_1 = $day_2 = $day_3 = $day_4 = $day_5 = $day_6 = $no_teacher = '';
$kd_biodata = $kd_class = $kd_program = '';
$bisa = 0;
$query_filter = '';



$nama_lengkap = $_SESSION['nama_lengkap'];

$query_nm_teacher = "SELECT kd_teacher, nm_teacher FROM ves_data.vip_teacher_name where status <> 0 order by nm_teacher";
$resource_nm_teacher = db_query($query_nm_teacher);
	{
	while ($row_nm_teacher = $resource_nm_teacher->fetch(PDO::FETCH_NUM))
		{
		$nm_teacher_list= $row_nm_teacher[1];
		$list_nm_teacher.="<OPTION VALUE=\"".e($nm_teacher_list)."\">".e($nm_teacher_list);
		}
	}


$kd_staff = $_SESSION['kd_staff'];
if($nama_lengkap != 'Savita Rachma Indrayani'){
$resource_nm_teacher = db_query("SELECT a.nm_teacher, a.kd_teacher,a.day_1,a.day_2,a.day_3,a.day_4,a.day_5,a.day_6,a.no FROM ves_data.vip_teacher_name a where a.kd_user = ?", [$kd_staff]);
}
else
{
$resource_nm_teacher = db_query("SELECT a.nm_teacher, a.kd_teacher,a.day_1,a.day_2,a.day_3,a.day_4,a.day_5,a.day_6,a.no FROM ves_data.vip_teacher_name a where a.nm_teacher = ?", [$nm_teacher]);
}
	{
	while ($row_nm_teacher = $resource_nm_teacher->fetch(PDO::FETCH_NUM))
		{
		$nm_teacher = $row_nm_teacher[0];
		$kd_teacher = $row_nm_teacher[1];
		$day_1 = $row_nm_teacher[2];			
		$day_2 = $row_nm_teacher[3];			
		$day_3 = $row_nm_teacher[4];			
		$day_4 = $row_nm_teacher[5];			
		$day_5 = $row_nm_teacher[6];			
		$day_6 = $row_nm_teacher[7];			
		$no_teacher = $row_nm_teacher[8];			
		}
	}

if ($kd_center == '1') {$center = 'East Sby';}
if ($kd_center == '2') {$center = 'West Sby';}
if ($kd_center == '3') {$center = 'Bali';}
if ($kd_center == '4') {$center = 'South Jkt';}
if ($kd_center == '5') {$center = 'North Jkt';}
if ($kd_center == '6') {$center = 'West Jkt';}
if ($kd_center == '7') {$center = 'Bandung';}
if ($kd_center == '8') {$center = 'Malang';}


if($center =='East Sby'){$kd_center = '1';}
if($center =='West Sby'){$kd_center = '2';}
if($center =='Bali'){$kd_center = '3';}
if($center =='South Jkt'){$kd_center = '4';}
if($center =='North Jkt'){$kd_center = '5';}
if($center =='West Jkt'){$kd_center = '6';}
if($center =='Bandung'){$kd_center = '7';}
if($center =='Malang'){$kd_center = '8';}
$query_billing = "SELECT a.kd_branch, c.nama_lengkap,a.kd_biodata,a.kd_class,a.no,a.kd_program FROM ves_data.vip_billing a left join ves_data.vip_mst_code_prg b on a.kd_program = b.kd_program left join ves_data.vip_student_data c on a.kd_biodata = c.kd_biodata where a.no = ?  group by a.kd_billing order by a.dt_entry desc" ;

$resource_billing = db_query($query_billing, [$id]);
	{
	while ($row_billing = $resource_billing->fetch(PDO::FETCH_NUM))
		{
		$kd_biodata = $row_billing[2];
		$student_name= $row_billing[1];
		$kd_center = $row_billing[0];
		$kd_class =  $row_billing[3];
		$kd_program = $row_billing[5];	
		}
	}
if ($kd_center == '1') {$center = 'East Sby';}
if ($kd_center == '2') {$center = 'West Sby';}
if ($kd_center == '3') {$center = 'Bali';}
if ($kd_center == '4') {$center = 'South Jkt';}
if ($kd_center == '5') {$center = 'North Jkt';}
if ($kd_center == '6') {$center = 'West Jkt';}
if ($kd_center == '7') {$center = 'Bandung';}
if ($kd_center == '8') {$center = 'Malang';}
$tanggalpilih = in_date('tanggalpilih', '');
$mulai = in_time('mulai');$selesai = in_time('selesai');$remark = in_str('remark', 245);$aktifitas = in_str('aktifitas', 45);



if ($kd_teacher <> '' and $mulai <> '' and $selesai <> '' and $tanggalpilih <> '')
	{
	$bisa = 0;
	$jm = strtotime("$mulai:01");$js = strtotime("$selesai:00");
	if ($jm >= $js)	
		{$bisa = 1;
		 $pesan_gagal = " Wrong Period";
		}
	$query_cek_teacher ="SELECT nm_teacher, mulai_tm, selesai_tm,room,center,kelas,date_format(mulai_tm,'%d %m %y'),date_format(mulai_tm,'%H:%i %p'), date_format(selesai_tm,'%H:%i %p') FROM ves_data.vip_teacher_schedule
WHERE nm_teacher = ? and
( status_kelas <> 0 AND status_kelas <> 52 AND status_kelas <> 62 AND status_kelas <> 72 AND status_kelas <> 92 )
and ((mulai_tm >= '2020-09-09 13:00:01' AND mulai_tm <= '2020-09-09 14:00:00') OR (selesai_tm >= '2020-09-09 13:00:01' AND selesai_tm <= '2020-09-09 14:00:00')) ";
	// Catatan: rentang tanggal 2020-09-09 memang ter-hardcode di versi lama (dibiarkan).
	$result_cek_teacher = db_query($query_cek_teacher, [$nm_teacher]);
		{
		while ($row_cek = $result_cek_teacher->fetch(PDO::FETCH_NUM))
			{
			$bisa = 1;	
			$pesan_gagal = " $row_cek[5] - $row_cek[4]  ( $row_cek[7] - $row_cek[8])";
			}
		}		
	}
if ($bisa ==1)
	{
	js_alert("Teacher mengajar $pesan_gagal)");
	$mulai = '';$selesai = '';$bisa = 0;
	}
$t = in_int('t');
if ($t == 50)
	{
	$aktifitas ='Tutorial';	
	}
elseif ($t == 60)
	{
	$aktifitas ='Tutorial';	
	}
elseif ($t == 70)
	{
	$aktifitas ='LC Visit';	
	}
elseif ($t == 80)
	{
	$aktifitas ='Speaking Placement Test';	
	}
elseif ($t == 90)
	{
	$aktifitas ='Meeting 0';	
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
   <style>

function fScroll(val)
{
        var hidScroll = document.getElementById('hidScroll');
        hidScroll.value = val.scrollTop;
}

// function moves scroll position to saved value
function fScrollMove(what)
{
        var hidScroll = document.getElementById('hidScroll');
        document.getElementById(what).scrollTop = hidScroll.value;
}
.style92 {color: #FFFFFF; font-weight: bold; font-size: 13px; font-family: Calibri; }
</style>
    <script language="JavaScript">
function readCookie(name){
return(document.cookie.match('(^|; )'+name+'=([^;]*)')||0)[2]
}

</script><body onScroll="document.cookie='ypos=' + window.pageYOffset" onLoad="window.scrollTo(0,readCookie('ypos'))">
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

  <!-- Left side column. contains the logo and sidebar -->
  

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>Teacher's Scheduler</h1></section>
 <form method="post"><?php echo csrf_field(); ?>
    <!-- Main content -->
<section class="content">
  <div class="row">
        <!-- left column -->

        <!--/.col (left) -->
        <!-- right column -->
<form role="form">
    <div class="col-md-12">
		  	<div class="box box-warning">
		  		<div class="box-header with-border"></div>
           	  <div class="box-body">
           	    <div class="col-md-4">
           	      <div class="form-group">
           	        <label>Teacher's Name</label>
					 <?php if ($nama_lengkap != 'Savita Rachma Indrayani') {?>
           	        <input type="text" class="form-control"  placeholder="Enter ..." name="nm_teacher" value="<?php echo e($nm_teacher) ?>" readonly>
					  <?php } else { ?>
					  <select class="form-control" name="nm_teacher"  onChange="this.form.submit()">
                    <option>--ALL--</option>
                    <option value= ><?php echo $list_nm_teacher; /* sudah di-escape saat dibangun */ ?>
                    <option selected><?php echo e($nm_teacher) ?></option>
                  </select>
					  <?php } ?>
					  
       	          </div>
       	        </div>
           	    <div class="col-md-3">
           		<div class="form-group">
       		      <label>Center</label>
                 		  <select class="form-control" name="center"  onChange="this.form.submit()">
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
			    </div></div>
           	    <span class="form-group">
       	        <input type="text" name="kd_biodata"value="<?php echo e($kd_biodata) ?>" hidden>
       	        </span><span class="form-group">
       	        <input type="text" name="id"value="<?php echo e($id) ?>" hidden>
       	        </span><span class="form-group">
       	        <input type="text" name="kdcl"value="<?php echo e($kd_class) ?>" hidden>
       	        </span><span class="form-group">
       	        <input type="text" name="kdprg"value="<?php echo e($kd_program) ?>" hidden>
       	        </span><span class="form-group">
       	        <input type="text" name="kd_teacher"value="<?php echo e($kd_teacher) ?>" hidden="" >
       	        </span></div> 
			</div>
<div class="box box-warning">
		  		<div class="box-header with-border"><strong>Class Period</strong></div>
<div class="box-body">
<div class="col-md-2">
          <div class="form-group">
          <a href="teachercalendarcenter.php?tampilan=1&nm_teacher=<?php echo e(u($kd_teacher)) ?>" 
target="popup" 
onClick="window.open('teachercalendarcenter.php?tampilan=1&nm_teacher=<?php echo e(u($kd_teacher)) ?>','popup','width=800,height=850,left=700px'); return false;" class="btn btn-primary" role="button"><i class="glyphicon glyphicon-calendar" aria-hidden="true"></i>
View Schedule </a>         
          </div>
</div>
<div class="col-md-3">
               	      <div class="form-group">
                 	      <label>Date</label>
                 	      <input type="DATE" class="form-control"   placeholder="Enter ..." name="tanggalpilih" value="<?php echo e($tanggalpilih) ?>">
               	      </div>
</div>
  <div class="col-md-1">
    <div class="form-group">
      <label>Time Start</label>
      <select class="form-control" name="mulai" required   onChange="this.form.submit()">
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
        <option selected><?php echo e($mulai) ?></option>
      </select>
    </div>
  </div>
<div class="col-md-1">
    <div class="form-group">
      <label>Time End</label>
      <select class="form-control" name="selesai" required   onChange="this.form.submit()">
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
        <option selected><?php echo e($selesai) ?></option>
      </select>
    </div>
  </div>
  <div class="col-md-2">
    <div class="form-group">
      <label>Activities</label>
      <select class="form-control"  name="aktifitas" required >
        <option>Training</option>
        <option>Meeting</option>
        <option>Class Observation</option>
        <option>Scoring</option>   
        <option>Speaking Test</option>            
        <option>Day Off</option>
        <option>Free class</option>
        <option>Make up Test</option>
        <option>Handle iBT</option>		  
        <option>Other</option>
        <option>LC Standby</option>	
        <option>CA OT Event</option>			  
        <option selected><?php echo e($aktifitas) ?></option>
      </select>
    </div>
</div>
  <div class="col-md-8">
    <div class="form-group">
      <label>Remark</label>
      <input type="text" class="form-control"  placeholder="Enter ..." name="remark" value="<?php echo e($remark) ?>">
    </div>
  </div>


<div class="col-md-6">
    <div class="form-group">
<input type="submit" name="Submit" value="Submit"  class="btn btn-primary active"/>
    </div>
</div>
	</div>
</form>
	</section>
	<section class="content">
	
	<div class=box-body>
               <div class="panel box box-primary">
                 <div class="box-header with-border">
                   <h4 class="box-title"> <a data-toggle="collapse" data-parent="#accordion" href="#todayact">Agenda List</a></h4>
                 </div>
    
             <div class="box-body">
             
<?php
$query = "SELECT date_format(v.mulai_tm,'%d %b %y'), a.nm_teacher , date_format(v.mulai_tm,'%H:%i'), date_format(v.selesai_tm,'%H:%i'), v.kelas, v.room, v.keterangan ,v.center,v.status_kelas,v.id,v.pic,date_format(v.dt_entry,'%d %b %y'),d.nama_lengkap FROM vip_teacher_schedule v left join vip_teacher_name a on v.nm_teacher = a.kd_teacher left join tb_user c on a.nm_teacher = c.nama_detail left join vip_student_data d on v.kd_biodata = d.kd_biodata where  a.nm_teacher = ? and v.status_kelas <> 0 and v.mulai_tm >= ? ";

$query_plan = $query.$query_filter." group by v.kd_biodata, v.mulai_tm, status_kelas  order by  v.mulai_tm desc " ; 

?>
<br>
<table width="100%" class="table table-bordered table-striped" id="example1">
  <thead>
    <tr>
      <td width="14%" height="14" align=center class="style24">Teacher's Name</td>
      <td width="13%" align=center class="style24">Class</td>
      <td width="20%" align=center class="style24">Schedule</td>
      <td width="6%" align=center class="style24">Room</td>
      <td width="28%" align=center class="style24">Description</td>
      <td width="19%" align=center class="style24">Action</td>
      </tr>
	</thead>
      <tbody>
      <?php 

      $result = db_query($query_plan, [$nm_teacher, $hari_ini_lalu]);
if ($result)
	{
	while ($r = $result->fetch(PDO::FETCH_NUM))
		{

		  ?>
    <tr>
      <td height="14" align=center class="style24"><?php echo e($r[1]) ?></td>
      <td align=left class="style24"><?php echo e($r[4]) ?>
        <br>
        <?php echo e($r[7]) ?></td>
      <td align=left class="style24"><?php echo e($r[0]) ?><br>        
        <?php echo e($r[2]) ?> -  <?php echo e($r[3]) ?></td>
      <td align=center class="style24"><?php echo e($r[5]) ?>
        <br></td>
      <td align=center class="style24"><?php echo e($r[6]) ?></td>
      <td align=center class="style24">          <a href="entryactteac.php.php" 
target="popup" 
onClick="window.open('entryactteac.php','popup','width=800,height=850,left=700px'); return false;" class="btn btn-info" role="button"><i class="glyphicon glyphicon-edit" aria-hidden="true"></i>
Modify</a>
<?php if ($nama_lengkap =='Savita Rachma Indrayani'){ ?>		  
		  <a href="vip_agendadel.php?id=<?php echo e(u($r[9])) ?>" 
target="popup" 
onClick="window.open('vip_agendadel.php?id=<?php echo e(u($r[9])) ?>','popup','width=800,height=850,left=700px'); return false;" class="btn btn-danger" role="button"><i class="glyphicon glyphicon-erase" aria-hidden="true"></i> Delete
</a><?php } ?> </td>
      </tr><?php }} ?>
	</tbody>
  <tfoot>
  </tfoot>
</table>
	</a>

              </ul>
            </div>
              
               </div>
		</div>
	<div class=box-body>
               <div class="panel box box-primary">
                 <div class="box-header with-border">
                   <h4 class="box-title"> <a data-toggle="collapse" data-parent="#accordion" href="#todayact">Teacher Shift</a></h4>
                 </div>
    
             <div class="box-body">
             
<?php
$query = "SELECT date_format(v.mulai_tm,'%d %b %y'), a.nm_teacher , date_format(v.mulai_tm,'%H:%i'), date_format(v.selesai_tm,'%H:%i'), v.kelas, v.room, v.keterangan ,v.center,v.status_kelas,v.id,v.pic,date_format(v.dt_entry,'%d %b %y'),d.nama_lengkap FROM vip_teacher_schedule v left join vip_teacher_name a on v.nm_teacher = a.kd_teacher left join tb_user c on a.nm_teacher = c.nama_detail left join vip_student_data d on v.kd_biodata = d.kd_biodata where  a.nm_teacher = ? and v.status_kelas <> 0 ";
// $query_plan di bagian Teacher Shift tidak pernah dijalankan di versi lama.
			  
$query_plan = $query.$query_filter." group by v.kd_biodata, v.kelas, status_kelas order by  v.mulai_tm desc " ; 
?>
<br>
<table width="100%" class="table table-bordered table-striped" id="example2">
  <thead>
    <tr>
      <td width="11%" height="14" align=center class="style24">Teacher's Name</td>
      <td width="12%" align=center class="style24">Mon</td>
      <td width="12%" align=center class="style24">Tue</td>
      <td width="12%" align=center class="style24">Wed</td>
      <td width="12%" align=center class="style24">Thu</td>
      <td width="12%" align=center class="style24">Fri</td>
      <td width="12%" align=center class="style24">Sat</td>
      </tr>
	</thead>
      <tbody>

    <tr>
      <td height="14" align=center class="style24"><?php echo e($nm_teacher) ?></td>
      <td align=center class="style24"><a href="vip_shitupd.php?not=<?php echo e(u($no_teacher)) ?>&nod=1" 
target="popup" 
onclick="window.open('vip_shitupd.php?not=<?php echo e(u($no_teacher)) ?>&nod=1 ?>','popup','width=300,height=200'); return false;"><?php echo e($day_1) ?></a></td>
      <td align=center class="style24"><a href="vip_shitupd.php?not=<?php echo e(u($no_teacher)) ?>&nod=1" 
target="popup" 
onclick="window.open('vip_shitupd.php?not=<?php echo e(u($no_teacher)) ?>&nod=2 ?>','popup','width=300,height=200'); return false;"><?php echo e($day_2) ?></a></td>
      <td align=center class="style24"><a href="vip_shitupd.php?not=<?php echo e(u($no_teacher)) ?>&nod=1" 
target="popup" 
onclick="window.open('vip_shitupd.php?not=<?php echo e(u($no_teacher)) ?>&nod=3 ?>','popup','width=300,height=200'); return false;"><?php echo e($day_3) ?></a></td>
      <td align=center class="style24"><a href="vip_shitupd.php?not=<?php echo e(u($no_teacher)) ?>&nod=1" 
target="popup" 
onclick="window.open('vip_shitupd.php?not=<?php echo e(u($no_teacher)) ?>&nod=4 ?>','popup','width=300,height=200'); return false;"><?php echo e($day_4) ?></a></td>
      <td align=center class="style24"><a href="vip_shitupd.php?not=<?php echo e(u($no_teacher)) ?>&nod=1" 
target="popup" 
onclick="window.open('vip_shitupd.php?not=<?php echo e(u($no_teacher)) ?>&nod=5 ?>','popup','width=300,height=200'); return false;"><?php echo e($day_5) ?></a></td>
      <td align=center class="style24"><a href="vip_shitupd.php?not=<?php echo e(u($no_teacher)) ?>&nod=1" 
target="popup" 
onclick="window.open('vip_shitupd.php?not=<?php echo e(u($no_teacher)) ?>&nod=6 ?>','popup','width=300,height=200'); return false;"><?php echo e($day_6) ?></a></td>
      </tr>
	</tbody>
  <tfoot>
  </tfoot>
</table>
	</a>

              </ul>
            </div>
              
               </div>
		</div>	
	</section>
</body>
</html>
<!-- DataTables -->
<script src="plugins/datatables/jquery.dataTables.min.js"></script>
<script src="plugins/datatables/dataTables.bootstrap.min.js"></script>
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
<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['Submit']))
{
$hari=date("d");
$bulan=date("m");
$tahun=date("Y");
$hari_ini = "$tahun-$bulan-$hari";
$center = in_str('center', 45, 'post');

$tanggalpilih = in_date('tanggalpilih', '', 'post');$mulai = in_time('mulai', '', 'post');$selesai = in_time('selesai', '', 'post');$remark = in_str('remark', 245, 'post');$aktifitas = in_str('aktifitas', 45, 'post');
$status_kelas = '';
if ($aktifitas =='Training'){$status_kelas = 22;}
elseif ($aktifitas =='Meeting'){$status_kelas = 33;}
elseif ($aktifitas =='Class Observation'){$status_kelas = 44;}
elseif ($aktifitas =='Scoring'){$status_kelas = 66;}
elseif ($aktifitas =='Speaking Test'){$status_kelas = 899;}			
elseif ($aktifitas =='Day Off'){$status_kelas = 888;}			
elseif ($aktifitas =='Free class'){$status_kelas = 898;}		
elseif ($aktifitas =='Speaking Test'){$status_kelas = 897;}		
elseif ($aktifitas =='Make up Test'){$status_kelas = 896;}	
elseif ($aktifitas =='Handle iBT'){$status_kelas = 456;}		
elseif ($aktifitas =='Other'){$status_kelas = 999;}	
elseif ($aktifitas =='LC Standby'){$status_kelas = 700;}	
if($center =='East Sby'){$kd_center = '1';}
elseif($center =='West Sby'){$kd_center = '2';}
elseif($center =='Bali'){$kd_center = '3';}
elseif($center =='South Jkt'){$kd_center = '4';}
elseif($center =='North Jkt'){$kd_center = '5';}
elseif($center =='West Jkt'){$kd_center = '6';}
elseif($center =='Bandung'){$kd_center = '7';}
elseif($center =='Malang'){$kd_center = '8';}
	$t = in_int('t', null, 'post');
if ($aktifitas =='CA OT Event') {$t = '601';}
if($mulai == '' or $tanggalpilih ==''  or $selesai =='' or $nm_teacher == '' or  $center =='')
	{
	echo "<script type=\"text/javascript\">\n";
	echo "alert('Center, Teacher, Date and Time Period must be filled');\n";	
	echo "</script>";
	die;
	}
$jm_mulai = strtotime($mulai);$jm_selesai = strtotime($selesai);
if($jm_mulai >= $jm_selesai)	
	{
	echo "<script type=\"text/javascript\">\n";echo "alert('Wrong Time ');\n";	echo "</script>";die;
	}

if($center =='East Sby'){$kd_center = '1';}
if($center =='West Sby'){$kd_center = '2';}
if($center =='Bali'){$kd_center = '3';}
if($center =='South Jkt'){$kd_center = '4';}
if($center =='North Jkt'){$kd_center = '5';}
if($center =='West Jkt'){$kd_center = '6';}
if($center =='Bandung'){$kd_center = '7';}
if($center =='Malang'){$kd_center = '8';}
// $kd_teacher dari vip_teacher_name (query di atas, berdasarkan teacher yang dipilih); $kd_biodata dari id.
$bisa = 1;
//day 1
$row_cek = db_row(
	"SELECT nm_teacher, mulai_tm, selesai_tm,room,center,kelas,date_format(mulai_tm,'%d %m %y'),date_format(mulai_tm,'%H:%i %p'), date_format(selesai_tm,'%H:%i %p') FROM ves_data.vip_teacher_schedule
	 WHERE nm_teacher = ? and
	 ( status_kelas <> 0 AND status_kelas <> 52 AND status_kelas <> 62 AND status_kelas <> 72 AND status_kelas <> 92 )
	 and ((mulai_tm >= '2020-09-09 13:00:01' AND mulai_tm <= '2020-09-09 14:00:00') OR (selesai_tm >= '2020-09-09 13:00:01' AND selesai_tm <= '2020-09-09 14:00:00'))",
	[$nm_teacher],
	PDO::FETCH_NUM
);
if ($row_cek !== null)
	{
	$bisa = 0;
	js_alert("Teacher mengajar $row_cek[5] - $row_cek[4]  ( $row_cek[7] - $row_cek[8])");
	die;
	}
if ($bisa ==1)
{
db_exec(
	"insert into ves_data.vip_teacher_schedule (nm_teacher, kelas, center, mulai_tm, selesai_tm, dt_entry, pic, kd_branch, status_kelas, catatan, keterangan, kd_biodata)
	 values (?, ?, ?, ?, ?, ?, ?, ?, ?, 'Booking', ?, ?)",
	[$kd_teacher, "Self - $aktifitas", $center, "$tanggalpilih $mulai:01", "$tanggalpilih $selesai:00", $hari_ini, $nama_lengkap, (string) $kd_center, (string) $status_kelas, $remark, $kd_biodata]
);
		js_alert('New Agenda Submitted', 'entryactteac.php');
}
}
?>
