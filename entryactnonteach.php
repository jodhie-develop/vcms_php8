<?php
// Form dikirim lewat POST (token CSRF); link dari halaman lain tetap memakai GET.
include __DIR__ . "/conndb.php";
include __DIR__ . "/profiledata.php";
include __DIR__ . "/atas.php";
include __DIR__ . "/left.php";

$nm_teacher = in_str('nm_teacher', 45);
$event = in_str('event', 45);
if ($nm_teacher ==''){$nm_teacher= in_str('nmt', 45);}

$center = in_str('center', 45);
$kd_center = in_str('kd_cbg', 3);
$id = in_int('id', 0);
$kd_biodata = $kd_class = $kd_program = $kd_billing = '';
$dtl_lc = '';

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
$query_billing = "SELECT a.kd_branch, c.nama_lengkap,a.kd_biodata,a.kd_class,a.no,a.kd_program,kd_billing FROM ves_data.vip_billing a left join ves_data.vip_mst_code_prg b on a.kd_program = b.kd_program left join ves_data.vip_student_data c on a.kd_biodata = c.kd_biodata where a.no = ?  group by a.kd_billing order by a.dt_entry desc" ;

$resource_billing = db_query($query_billing, [$id]);
	{
	while ($row_billing = $resource_billing->fetch(PDO::FETCH_NUM))
		{
		$kd_biodata = $row_billing[2];
		$student_name= $row_billing[1];
		$kd_center = $row_billing[0];
		$kd_class =  $row_billing[3];
		$kd_program = $row_billing[5];	
		$kd_billing = $row_billing[6];	
		
		}
	}
if ($kd_center == '1') {$center = 'East Sby';}
elseif ($kd_center == '2') {$center = 'West Sby';}
elseif ($kd_center == '3') {$center = 'Bali';}
elseif ($kd_center == '4') {$center = 'South Jkt';}
elseif ($kd_center == '5') {$center = 'North Jkt';}
elseif ($kd_center == '6') {$center = 'West Jkt';}
elseif ($kd_center == '7') {$center = 'Bandung';}
elseif ($kd_center == '8') {$center = 'Malang';}
$tanggalpilih = in_date('tanggalpilih', '');
$mulai = in_time('mulai');$selesai = in_time('selesai');$remark = in_str('remark', 245);
$aktifitas = in_str('aktifitas', 45);
if ($aktifitas == 'Placement Test')
	{
	$t =301;	
	}
elseif ($aktifitas == 'Essay Scoring')
	{
	$t =302;	
	}
elseif ($aktifitas == 'Event')
	{
	$t =303;	
	}
elseif ($aktifitas == 'Trial Class')
	{
	$t =304;	
	}
elseif ($aktifitas == 'Workshop')
	{
	$t =305;	
	}
elseif ($aktifitas == 'Training Project')
	{
	$t =306;	
	}
elseif ($aktifitas == 'Product Development Project' or $aktifitas == 'Feedback Writing' or $aktifitas == 'Tutorial' or $aktifitas == 'Mock Interview'  or $aktifitas == 'Weekly newsletter'  or $aktifitas == 'Q and A Session'  or $aktifitas == 'Monthly Webinar'   or $aktifitas == 'biweekly tracking')
	{
	$t =307;	
	}
else{
	$t =307;	
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
      <h1>Non Teaching Booking Form</h1>
    </section>
 <form method="post"><?php echo csrf_field(); ?>
    <!-- Main content -->
<section class="content">
  <div class="row">
        <!-- left column -->
        <!--/.col (left) -->
        <!-- right column -->
<form role="form">
<div class="box box-warning">
		  		<div class="box-header with-border"></div>
           	  <div class="box-body"><div class="col-md-2">
          <div class="form-group">
          <a href="teachercalendarcenter.php?tampilan=1&center=<?php echo e(u($center)) ?>&kd_cbg=<?php echo e(u($kd_center)) ?>" 
target="popup" 
onClick="window.open('teachercalendarcenter.php?tampilan=1&center=<?php echo e(u($center)) ?>&kd_cbg=<?php echo e(u($kd_cbg)) ?>','popup','width=800,height=850,left=700px'); return false;" class="btn btn-primary" role="button"><i class="glyphicon glyphicon-calendar" aria-hidden="true"></i>
View Schedule </a>         
          </div>
</div></div> 
</div>
    <div class="col-md-12">
    <div class="box box-warning">

<div class="box-body">

<div class="col-md-3">
  <div class="form-group">
    <label>Teacher Selected</label>
    <select class="form-control" name="nm_teacher" onChange="this.form.submit()">
      <?php
								$query_nm_teacher = "SELECT nm_teacher, kd_teacher FROM ves_data.vip_teacher_name order by kd_teacher";
								$resource_nm_teacher = db_query($query_nm_teacher);
								while ($row_nm_teacher = $resource_nm_teacher->fetch(PDO::FETCH_NUM))
									{
							  		echo '<option value="'.e($row_nm_teacher[1]).'">'.e($row_nm_teacher[1]).'-'.e($row_nm_teacher[0]).'</option>';
							  		}      ?>
      <option selected><?php echo e($nm_teacher) ?></option>
    </select>
  </div>
</div>
<div class="col-md-2">
  <div class="form-group">
    <label>Activities</label>
    <select class="form-control"  name="aktifitas" required onChange="this.form.submit()">
      <option>Placement Test</option>
      <option>Essay Scoring</option>
      <option>Event</option>
      <option>Trial Class</option>
      <option>Workshop</option>
      <option>CA OT Event</option>
      <option>Training Project</option>
      <option>Product Development Project</option>
      <option>Feedback Writing</option>	
      <option>Tutorial</option>	
      <option>Mock Interview</option>
      <option>Weekly newsletter</option>	
      <option>Q and A Session</option>	
      <option>Monthly Webinar</option>	
      <option>biweekly tracking</option>	
<option>Document review (1 Hour)</option>
<option>Application Package (2 Hours)</option>
<option>Mock Interview (90 minutes)</option>
<option>Readiness and Profile Review (2 Hours)</option>
<option>Progress Report and Radar (1 Hour)</option>		
		
      <option  selected><?php echo e($aktifitas) ?></option>
    </select>
  </div>
</div>
<div class="col-md-3">
               	      <div class="form-group">
                 	      <label>Date</label>
                 	      <input type="DATE" class="form-control"   placeholder="Enter ..." name="tanggalpilih" value="<?php echo e($tanggalpilih) ?>">
               	      </div>
</div>
  <div class="col-md-3">
    <div class="form-group">
      <label>Time Start</label>
      <select class="form-control" name="mulai" required>
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
  <div class="col-md-3">
    <div class="form-group">
      <label>Time End</label>
      <select class="form-control" name="selesai" required>
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
  <span class="form-group">
  <input type="text" name="kd_biodata"value="<?php echo e($kd_biodata) ?>" hidden>
</span><span class="form-group">
       	        <input type="text" name="id"value="<?php echo e($id) ?>" hidden>
       	        </span><span class="form-group">
       	        <input type="text" name="kdcl"value="<?php echo e($kd_class) ?>" hidden>
       	        </span><span class="form-group">
       	        <input type="text" name="kdprg"value="<?php echo e($kd_program) ?>" hidden>
       	        </span><span class="form-group">
       	        <input type="text" name="t"value="<?php echo e($t) ?>" hidden>
       	        <input type="text" name="kd_billing"value="<?php echo e($kd_billing) ?>" hidden>
       	        </span>	
<?php if ($t == 70){ ?>
   <div class="col-md-2">
    <div class="form-group">
      <label>Detail Skill</label>
      <select class="form-control"  name="dtl_lc" >
        <option>S</option>
        <option>R</option>
        <option>W</option>
        <option>L</option>
        <option>S and R</option>
        <option>S and WW</option>
        <option>S and L</option>
        <option>W and R</option>
        <option>W and L</option>
        <option>L and R</option>
        <option selected><?php echo e($dtl_lc) ?></option>
      </select>
    </div>
  </div>
<?php } ?>
<div class="col-md-12">
  <div class="form-group">
      <label>Event</label>
      <select class="form-control"  name="event"  required>
        <option>VIP Event</option>
        <option selected><?php echo e($event) ?></option>
      </select>
  </div>
</div>

 
							  
<div class="col-md-12">
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

</form>
</body>
</html>
<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['Submit']))
{
// kd_biodata / kdcl diambil dari vip_billing berdasarkan id (query di atas), bukan hidden field.
$hari=date("d");
$bulan=date("m");
$tahun=date("Y");
$hari_ini = "$tahun-$bulan-$hari";
$nm_teacher = in_str('nm_teacher', 45, 'post');
$center = in_str('center', 45, 'post');
$event = in_str('event', 45, 'post');
$tanggalpilih = in_date('tanggalpilih', '', 'post');$mulai = in_time('mulai', '', 'post');$selesai = in_time('selesai', '', 'post');$remark = in_str('remark', 245, 'post');$aktifitas = in_str('aktifitas', 45, 'post');

if($center =='East Sby'){$kd_center = '1';}
elseif($center =='West Sby'){$kd_center = '2';}
elseif($center =='Bali'){$kd_center = '3';}
elseif($center =='South Jkt'){$kd_center = '4';}
elseif($center =='North Jkt'){$kd_center = '5';}
elseif($center =='West Jkt'){$kd_center = '6';}
elseif($center =='Bandung'){$kd_center = '7';}
elseif($center =='Malang'){$kd_center = '8';}
$kdcl = $kd_class;
$kdprg	= $kd_program;
	$t = in_int('t', null, 'post');

if ($aktifitas =='CA OT Event') {$t = '601';}			
	
if($mulai == '' or $tanggalpilih ==''  or $selesai =='' or $nm_teacher == '' )
	{
	echo "<script type=\"text/javascript\">\n";
	echo "alert('Teacher, Date and Time Period must be filled');\n";	
	echo "</script>";
	die;
	}
$jm_mulai = strtotime($mulai);$jm_selesai = strtotime($selesai);
if($jm_mulai >= $jm_selesai)	
	{
	echo "<script type=\"text/javascript\">\n";echo "alert('Wrong Time ');\n";	echo "</script>";die;
	}

if($center =='East Sby'){$kd_center = '1';}
elseif($center =='West Sby'){$kd_center = '2';}
elseif($center =='Bali'){$kd_center = '3';}
elseif($center =='South Jkt'){$kd_center = '4';}
elseif($center =='North Jkt'){$kd_center = '5';}
elseif($center =='West Jkt'){$kd_center = '6';}
elseif($center =='Bandung'){$kd_center = '7';}
elseif($center =='Malang'){$kd_center = '8';}
$bisa = 0;
//start cek jadwal====================================
$awal = "$tanggalpilih $mulai:01"; $akhir = "$tanggalpilih $selesai:00";
$row_cek = db_row(
	"SELECT nm_teacher, mulai_tm, selesai_tm,room,center,kelas,date_format(mulai_tm,'%d %m %y'),date_format(mulai_tm,'%H:%i %p'), date_format(selesai_tm,'%H:%i %p') FROM ves_data.vip_teacher_schedule
	 WHERE nm_teacher = ? and status_kelas <> 0 and ((mulai_tm >= ? AND mulai_tm <= ?) OR (selesai_tm >= ? AND selesai_tm <= ?))",
	[$nm_teacher, $awal, $akhir, $awal, $akhir],
	PDO::FETCH_NUM
);
if ($row_cek !== null)
	{
	js_alert("Teacher not available.Existing Schedule :  $row_cek[5] - $row_cek[4]  ( $row_cek[7] - $row_cek[8])");
	die;
	}
//else
//	{

	//mulai cek data sama===
//$query_cek_jadwal = "select id,kelas from  ves_data.vip_teacher_schedule where kd_biodata = '$kd_biodata' and   mulai_tm = '$tanggalpilih $mulai:01' and selesai_tm = '$tanggalpilih $selesai:00' and  status_kelas = 1";
//$resource_cek_jadwal = mysql_query($query_cek_jadwal);	
//if(mysql_num_rows($resource_cek_jadwal) > 0)
//	{
//	while ($row_cek_jadwal=  mysql_fetch_row($resource_cek_jadwal))
//		{		
//		echo "<script type=\"text/javascript\">\n";
//		echo "alert('Student ada jadwal kelas $row_cek_jadwal[1]');\n";	
//		echo "</script>";
//		die;
//		}
//	}
else
	{

	//selesai cek data sama===
	
	db_exec(
		"insert into ves_data.vip_teacher_schedule (nm_teacher, kelas, center, mulai_tm, selesai_tm, dt_entry, pic, kd_branch, status_kelas, catatan, keterangan, kd_biodata)
		 values (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)",
		[$nm_teacher, "$kdcl - $aktifitas", $center, $awal, $akhir, $hari_ini, $nama_lengkap, (string) $kd_center, (string) $t, $event, $remark, $kd_biodata]
	);

	js_alert('New Scheduled has been set by ' . $nama_depan, 'vip_order_list.php');
	}
//selesai cek jadwal====================================	

}
?>
