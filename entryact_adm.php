<?php
// Form dikirim lewat POST (token CSRF); link dari admission_order_new.php tetap GET (?id=..&t=980).
include __DIR__ . "/conndb.php";
include __DIR__ . "/profiledata.php";
include __DIR__ . "/atas.php";
include __DIR__ . "/left.php";


$nm_teacher = in_str('nm_teacher', 45);
if ($nm_teacher ==''){$nm_teacher= in_str('nmt', 45);}

$center = in_str('center', 45);
$kd_center = in_str('kd_cbg', 3);
$id = in_int('id', 0);
$student_name = $destination = $intake = $kd_biodata = '';
$kd_class = $kd_program = $kd_billing = $dtl_lc = '';

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
$query_billing = "SELECT nama, dest_school, dest_program, dest_country, tgl_intake, kd_branch,kd_biodata FROM adm_stu_progress where no = ? order by no desc limit 1";
// (echo $query_billing; debug di versi lama menampilkan SQL di halaman, dihapus)
$resource_billing = db_query($query_billing, [$id]);
	{
	while ($row_billing = $resource_billing->fetch(PDO::FETCH_NUM))
		{
		$student_name= $row_billing[0];
		$destination = "$row_billing[1]-$row_billing[3]";
		$intake =  $row_billing[4];
		$kd_biodata = $row_billing[6];
		
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



$t = in_int('t');
if ($t == 50)
	{
	$aktifitas ='Tutorial';	
	}
elseif ($t == 60)
	{
	$aktifitas ='Late Attendance';	
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
elseif ($t == 40)
	{
	$aktifitas ='Make Up';	
	}
elseif ($t == 980)
	{
	$aktifitas ='Interview';	
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
      <h1>Admission Interview Booking Form</h1>
    </section>
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
           	        <label>Student Name</label>
           	        <input type="text" class="form-control"  placeholder="Enter ..." name="student_name" value="<?php echo e($student_name) ?>" readonly>
       	          </div>
       	        </div>
           	    <div class="col-md-4">
           	      <div class="form-group">
           	        <label>Destination</label>
           	        <input type="text" class="form-control"  placeholder="Enter ..." name="kd_class" value="<?php echo e($destination) ?>" readonly>
       	          </div>
       	        </div>
           	    <div class="col-md-4">
           	      <div class="form-group">
           	        <label>Intake</label>
           	        <input type="text" class="form-control"  placeholder="Enter ..." name="Intake" value="<?php echo e($intake) ?>" readonly>
       	          </div>
       	        </div>
           	    <div class="col-md-4">
           		<div class="form-group">
       		      <label>Center</label>
                 		  <input type="text" class="form-control"  placeholder="Enter ..." name="center" value="<?php echo e($center) ?>" readonly>

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
       	        </span></div> 
		</div>
<div class="box box-warning"> 
<?php if ($t==70){?>	
	<div class="box-body">
	  <div class="col-md-12">
		<div class="form-group">
	      <p>
	        <label>LC RECOMMENDATION RECORD</label>
	      </p>
	      <table width="100%" class="table table-bordered table-striped" id="example12">
		        <thead>
	      <tr>
	        <td height="14" align=center >Day/Date/Teacher</td>
	        <td colspan="2" align=center >Recommendation</td>
	        <td width="14%" rowspan="2" align=center >Action</td>
	        </tr>
	      <tr>
	        <td width=9% height="14" align=center >&nbsp;</td>
	        <td width="9%" align=center >Skil</td>
	        <td width="26%" align=center >Remark</td>
	        </tr>
        </thead>
	    <?php 
//===jika ada billing
//$query_billing = "SELECT a.kd_billing,b.nm_program, b.level_program, b.type_program, sum(net_tf+reg_fee+material_cost) as invoiced,a.dt_entry,c.nama, c.middle_name, c.family_name,a.kd_biodata FROM ves_data.vip_billing a left join ves_data.vip_mst_code_prg b on a.kd_program = b.kd_program left join ves_inc.tb_biodata c on a.kd_biodata = c.kd_biodata where a.kd_branch = '$kd_cbg' and a.dt_entry between '$date_start' and '$date_end' group by a.kd_billing order by a.kd_billing" ;
//						   echo $query_billing;
						   
//$resource_billing = mysql_query($query_billing);
//$keluar_billing = mysql_num_rows($resource_billing);
					   ?>
	    <tbody>
	      <?php	
//$query_billing = "SELECT a.kd_billing,b.nm_program, b.level_program, b.type_program, sum(net_tf+reg_fee+material_cost) as invoiced,a.dt_entry,c.nama, c.middle_name, c.family_name,a.kd_biodata,a.net_tf, a.reg_fee, a.material_cost,a.kd_class FROM ves_data.vip_billing a left join ves_data.vip_mst_code_prg b on a.kd_program = b.kd_program left join ves_inc.tb_biodata c on a.kd_biodata = c.kd_biodata where a.kd_branch = '$kd_cbg' and a.kd_program = '$kdprg' and a.kd_class = '$kdcl'  group by a.kd_billing order by a.dt_entry desc" ;


$query_tanggal = "SELECT date_format(tgl_meeting, '%Y-%m-%d'),date_format(tgl_meeting, '%H:%i')  , a.nama_lengkap, l.kd_biodata, l.kd_class,  l.lc_skill_recommendation,l.lc_recommendation, nm_teacher FROM ves_data.lc_student_history l left join vip_student_data a on l.kd_biodata  = a.kd_biodata
left join vip_teacher_schedule b on l.kd_class = b.kelas and l.tgl_meeting = b.mulai_tm where l.kd_biodata = ? and l.kd_class = ? order by tgl_meeting";

$resource_tanggal = db_query($query_tanggal, [$kd_biodata, $kd_class]);
		{
		while ($row_tanggal = $resource_tanggal->fetch(PDO::FETCH_NUM))
			{
	?>
	      <tr>
	        <td height="14" align=left class="style24"><?php echo e($row_tanggal[0]) ?> / <?php echo e($row_tanggal[1]) ?> / <?php echo e($row_tanggal[7]) ?></td>
	        <td align=center class="style24"><?php echo e($row_tanggal[5]) ?></td>
	        <td align=left class="style24"><?php echo e($row_tanggal[6]) ?></td>
	        <td align=center class="style24">&nbsp;</td>
	        </tr>
	      <?php }} ?>
        </tbody>
	    <tfoot>
        </tfoot>
    </table>
		</div>	
	  </div>

	</div>
<?php } ?>		
		
		</div>
		<div class="box box-warning">
		  		<div class="box-header with-border"><strong>Class Period</strong></div>
<div class="box-body">
<div class="col-md-2">
          <div class="form-group">
          <a href="teachercalendarcenter.php?tampilan=1&center=<?php echo e(u($center)) ?>&kd_cbg=<?php echo e(u($kd_center)) ?>" 
target="popup" 
onClick="window.open('teachercalendarcenter.php?tampilan=1&center=<?php echo e(u($center)) ?>&kd_cbg=<?php echo e(u($kd_cbg)) ?>','popup','width=800,height=850,left=700px'); return false;" class="btn btn-primary" role="button"><i class="glyphicon glyphicon-calendar" aria-hidden="true"></i>
View Schedule </a>         
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
<div class="col-md-2">
    <div class="form-group">
      <label>Activities</label>
      <select class="form-control"  name="aktifitas" required readonly >
        <option>Interview</option>		  
        <option>Tutorial</option>
        <option>Late Attendance</option>
        <option>LC Visit</option>
        <option>Speaking Placement Test</option>
        <option>Meeting 0</option>
        <option>Make Up</option>		  
        <option selected><?php echo e($aktifitas) ?></option>
      </select>
    </div>
  </div>
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

           		
	<div class="col-md-12"></div>
 
							  
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
$hari=date("d");
$bulan=date("m");
$tahun=date("Y");
$hari_ini = "$tahun-$bulan-$hari";
$nm_teacher = in_str('nm_teacher', 45, 'post');
$center = in_str('center', 45, 'post');
$dtl_lc = in_str('dtl_lc', 20, 'post');

$tanggalpilih = in_date('tanggalpilih', '', 'post');$mulai = in_time('mulai', '', 'post');$selesai = in_time('selesai', '', 'post');$remark = in_str('remark', 245, 'post');$aktifitas = in_str('aktifitas', 45, 'post');
	if ($aktifitas =='LC Visit' and $dtl_lc =='') {	echo "<script type=\"text/javascript\">\n";
	echo "alert('Detail Skill must be filled');\n";	
	echo "</script>";
	die;}	
	if ($aktifitas =='LC Visit' and $remark =='') {	echo "<script type=\"text/javascript\">\n";
	echo "alert('Remark fill with teachers recommendation');\n";	
	echo "</script>";
	die;}
if($center =='East Sby'){$kd_center = '1';}
if($center =='West Sby'){$kd_center = '2';}
if($center =='Bali'){$kd_center = '3';}
if($center =='South Jkt'){$kd_center = '4';}
if($center =='North Jkt'){$kd_center = '5';}
if($center =='West Jkt'){$kd_center = '6';}
if($center =='Bandung'){$kd_center = '7';}
if($center =='Malang'){$kd_center = '8';}
// kdcl/kdprg di form ini selalu kosong (variabel tidak pernah diisi di versi lama).
$kdcl = $kd_class;
$kdprg	= $kd_program;
	$t = in_int('t', null, 'post');
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
if($center =='West Sby'){$kd_center = '2';}
if($center =='Bali'){$kd_center = '3';}
if($center =='South Jkt'){$kd_center = '4';}
if($center =='North Jkt'){$kd_center = '5';}
if($center =='West Jkt'){$kd_center = '6';}
if($center =='Bandung'){$kd_center = '7';}
if($center =='Malang'){$kd_center = '8';}
$bisa = 0;
//start cek jadwal====================================	
//$query_cek_teacher ="SELECT nm_teacher, mulai_tm, selesai_tm,room,center,kelas,date_format(mulai_tm,'%d %m %y'),date_format(mulai_tm,'%H:%i %p'), date_format(selesai_tm,'%H:%i %p')  FROM ves_data.vip_teacher_schedule WHERE  nm_teacher ='$nm_teacher' and status_kelas <> 0 and ((mulai_tm >= '$tanggalpilih $mulai:01' AND mulai_tm <= '$tanggalpilih $selesai:00') OR
//(selesai_tm >= '$tanggalpilih $mulai:01' AND selesai_tm <= '$tanggalpilih $selesai:00')) ";

//$result_cek_teacher=mysql_query($query_cek_teacher) or die("Wah error nih1");
//if(mysql_num_rows($result_cek_teacher) > 0)
//	{
//	while ($row_cek=  mysql_fetch_row($result_cek_teacher))
//		{							
//		echo "<script type=\"text/javascript\">\n";
//		echo "alert('Teacher mengajar $row_cek[5] - $row_cek[4]  ( $row_cek[7] - $row_cek[8])');\n";	
//		echo "</script>";
//		die;
//		}
//	}
//else
//	{

	//mulai cek data sama===
$awal = "$tanggalpilih $mulai:01"; $akhir = "$tanggalpilih $selesai:00";
$row_cek = db_row(
	"SELECT nm_teacher, mulai_tm, selesai_tm,room,center,kelas,date_format(mulai_tm,'%d %m %y'),date_format(mulai_tm,'%H:%i %p'), date_format(selesai_tm,'%H:%i %p') FROM ves_data.vip_teacher_schedule
	 WHERE (status_kelas <> 0 and status_kelas <> 52 and status_kelas <> 62 and status_kelas <> 72 and status_kelas <> 82 and status_kelas <> 92 and status_kelas <> 11 )
	 and nm_teacher = ? and ((mulai_tm >= ? AND mulai_tm <= ?) OR (selesai_tm >= ? AND selesai_tm <= ?))",
	[$nm_teacher, $awal, $akhir, $awal, $akhir],
	PDO::FETCH_NUM
);
				if ($row_cek !== null)
					{
					js_alert("Jadwal tidak bisa dibuat ($row_cek[6]) Teacher mengajar $row_cek[5] - $row_cek[4]  ( $row_cek[7] - $row_cek[8])");
					die;
					}
else
	{

	//selesai cek data sama===
	// Versi lama mengisi kd_biodata dengan $kd (variabel tidak ada) sehingga selalu ''; dipertahankan.
	db_exec(
		"insert into ves_data.vip_teacher_schedule (nm_teacher, kelas, center, mulai_tm, selesai_tm, dt_entry, pic, kd_branch, status_kelas, catatan, keterangan, kd_biodata, type_kelas)
		 values (?, ?, ?, ?, ?, ?, ?, ?, ?, 'Booking', ?, '', 'Interview')",
		[$nm_teacher, $kdcl, $center, $awal, $akhir, $hari_ini, $nama_lengkap, (string) $kd_center, (string) $t, $remark]
	);

	echo "<script type=\"text/javascript\">\n";
echo 'alert(' . js('New Scheduled has been set by ' . $nama_depan) . ");\n";
			echo "window.close();\n";
echo "</script>";
	}
//selesai cek jadwal====================================	

}
?>
