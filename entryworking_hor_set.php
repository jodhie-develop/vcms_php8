<?php
require_once __DIR__ . "/_lib/bootstrap.php"; csrf_guard_get(); auth_require_login(); 
include __DIR__ . "/conndb.php";
include __DIR__ . "/profiledata.php";
include __DIR__ . "/atas.php";
$kd_user = $_SESSION['kd_staff'];
$center = in_val('center', 'any');
$mulai_kelas = in_val('mulai_kelas', 'any');
$selesai_kelas = in_val('selesai_kelas', 'any');
$nm_program = in_val('nm_program', 'any');
$nm_level = in_val('nm_level', 'any');
$kode_kelas = in_val('kode_kelas', 'any');
$type_class = in_val('type_class', 'any');
$kd_type_class = $type_class;
$jml_meeting = in_val('jml_meeting', 'any');
$query_nm_teacher = q_set($__p_query_nm_teacher, "SELECT kd_teacher FROM ves_data.vip_teacher_name where kd_user = ? ", [(string) ($kd_user)]);
$resource_nm_teacher = db_query_or_die('errro_7', $query_nm_teacher, $__p_query_nm_teacher ?? []);
$keluar_nm_teacher= db_num_rows($resource_nm_teacher);
if(num(db_num_rows($resource_nm_teacher)) > 0)
	{
	while ($row_nm_teacher=  db_fetch($resource_nm_teacher, PDO::FETCH_NUM))
		{
		$nm_teacher = $row_nm_teacher[0];
		}
	}

//===

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
      <h1>Monthly Working Time</h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Forms</a></li>
        <li class="active">General Elements</li>
      </ol>
    </section>
 <form method="post"><?php echo csrf_field(); ?> 
    <!-- Main content -->
<section class="content">
  <div class="row">
        <!-- left column -->
<?php       include __DIR__ . "/left.php";	 ?>
        <!--/.col (left) -->
        <!-- right column -->
<form role="form" method="post"><?php echo csrf_field(); ?>

    <div class="col-md-12">
		  	<div class="box box-warning">
		  		<div class="box-header with-border"></div>
           	  <div class="box-body">
           	    <div class="col-md-6">
           		<div class="form-group">
       		      <label>Employee Code</label>
       		      <input type="TEXT" class="form-control"  placeholder="Enter CLass Code" name="nm_teacher" value="<?php echo e($nm_teacher) ?>" required readonly>
           		</div></div>
           	    <div class="col-md-2">
           	      <div class="form-group"> <a href="slotteachercalendar.php?kd=<?php echo e(u($nm_teacher)) ?>" class="btn btn-primary" role="button">Working Schedule</a></div>
       	        </div>
           	    <span class="form-group">
       	        <input type="text" name="kode_program"value="<?php echo e($kode_program) ?>" hidden>
       	        <input type="text" name="kls_cbg"value="<?php echo e($kls_cbg) ?>" hidden>
       	        </span></div> 
			</div>
<div class="box box-warning">
<div class="box-header with-border"><strong>SETTING TIME WORKING</strong></div>
		  		<div class="box-header with-border"><strong>MONTH</strong></div>
                 	<div class="box-body">
                 	  <div class="col-md-3">
                 	    <div class="form-group">(Choose a day)
                 	      <input type="DATE" class="form-control"  placeholder="Enter CLass Code" name="bulan" value="<?php echo e($bulan) ?>" required>
                 	    </div>
						  
               	    </div>
</div>
<div class="box-header with-border"><strong>DAY</strong></div>
<div class="box-body">
  <div class="col-md-12">
    <div class="col-md-3">
      <div class="form-group">
        <label>MONDAY</label>
        <select class="form-control" name="senin_login">
          <option value="08.30 - 17.00">08.30 - 17.00</option>
          <option value="09.30 - 18.00">09.30 - 18.00</option>
          <option value="11.00 - 19.00">11.00 - 19.00</option>
          <option value="12.00 - 20.00">12.00 - 20.00</option>
          <option value="14.00 - 21.00">14.00 - 21.00</option>
          <option selected><?php echo e($senin_login) ?></option>
        </select>
      </div>
    </div>
    <div class="col-md-3">
    <div class="form-group">
      <label>TUESDAY</label>
        <select class="form-control" name="selasa_login">
          <option value="08.30 - 17.00">08.30 - 17.00</option>
          <option value="09.30 - 18.00">09.30 - 18.00</option>							  
          <option value="11.00 - 19.00">11.00 - 19.00</option>
          <option value="12.00 - 20.00">12.00 - 20.00</option>
          <option value="14.00 - 21.00">14.00 - 21.00</option>
          <option selected><?php echo e($selasa_login) ?></option>
        </select>
		
    </div>

           	                     	                 	      
  </div>
<div class="col-md-3">
  <div class="form-group">
    <label>WEDNESDAY</label>
    <select class="form-control" name="rabu_login">
      <option value="08.30 - 17.00">08.30 - 17.00</option>
      <option value="09.30 - 18.00">09.30 - 18.00</option>
      <option value="11.00 - 19.00">11.00 - 19.00</option>
      <option value="12.00 - 20.00">12.00 - 20.00</option>
      <option value="14.00 - 21.00">14.00 - 21.00</option>
      <option selected><?php echo e($rabu_login) ?></option>
    </select>
  </div>
</div>
<div class="col-md-3">
  <div class="form-group">
    <label>THURSDAY</label>
    <select class="form-control" name="kamis_login">
      <option value="08.30 - 17.00">08.30 - 17.00</option>
      <option value="09.30 - 18.00">09.30 - 18.00</option>
      <option value="11.00 - 19.00">11.00 - 19.00</option>
      <option value="12.00 - 20.00">12.00 - 20.00</option>
      <option value="14.00 - 21.00">14.00 - 21.00</option>
      <option selected><?php echo e($kamis_login) ?></option>
    </select>
  </div>
</div>
<div class="col-md-3">
  <div class="form-group">
    <label>FRIDAY</label>
    <select class="form-control" name="jumat_login">
      <option value="08.30 - 17.00">08.30 - 17.00</option>
      <option value="09.30 - 18.00">09.30 - 18.00</option>
      <option value="11.00 - 19.00">11.00 - 19.00</option>
      <option value="12.00 - 20.00">12.00 - 20.00</option>
      <option value="14.00 - 21.00">14.00 - 21.00</option>
      <option selected><?php echo e($jumat_login) ?></option>
    </select>
  </div>
</div>
  </div>
  <div class="col-md-6">
    <div class="box-header"><span class="form-group">
      <label>SATURDAY</label></span></div>
    <div class="col-md-4">
      <div class="form-group">
        <label>Login</label>
        <input type="TIME" class="form-control"  placeholder="Enter CLass Code" name="sabtu_login" value="<?php echo e($sabtu_login) ?>" required>
      </div>
    </div>
    <div class="col-md-4">
      <div class="form-group">
        <label>Logout</label>
        <input type="TIME" class="form-control"  placeholder="Enter CLass Code" name="sabtu_logout" value="<?php echo e($sabtu_logout) ?>" required>
      </div>
    </div>
  </div>
  <div class="col-md-6"></div>
</div>

            <input type="submit" name="Submit" value="Submit" />
</form>

</body>
</html>
<?php
if (($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['Submit']))) 
{

$fullurl="http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
$hari=date("d");
$bulan=date("m");
$tahun=date("Y");
$hari_ini = "$tahun-$bulan-$hari";	
$nm_teacher = in_val('nm_teacher', 'any');
$bulan = in_val('bulan', 'any');
$senin_login = in_val('senin_login', 'any');
$selasa_login = in_val('selasa_login', 'any');
$rabu_login = in_val('rabu_login', 'any');
$kamis_login = in_val('kamis_login', 'any');	
$jumat_login = in_val('jumat_login', 'any');
	
$senin_logout = in_val('senin_logout', 'any');
$sabtu_login = in_val('sabtu_login', 'any');
$sabtu_logout = in_val('sabtu_logout', 'any');
$kode_user = $_SESSION['kd_staff']; 
$nama_lengkap = $_SESSION['nama_lengkap']; 
	
$kd_bln = date("m",strtotime($bulan));
$kd_thn = date("Y",strtotime($bulan));		


$tgl_terakhir = date(date('t', strtotime($bulan)));

$awal_bln = "$kd_thn-$kd_bln-01";
$akhir_bln = "$kd_thn-$kd_bln-$tgl_terakhir";
	
$hitung_awal =  strtotime($awal_bln); 
$hitung_selesai =  strtotime($akhir_bln); 
	
$libur = 0;	

if ($senin_login == '08.30 - 17.00'){$jam_masuk_senin = '08:30';$jam_pulang_senin = '17:00';} elseif ($senin_login == '09.30 - 18.00'){$jam_masuk_senin = '09:30';$jam_pulang_senin = '18:00';}	elseif ($senin_login == '11.00 - 19.00'){$jam_masuk_senin = '11:00';$jam_pulang_senin = '19:00';}elseif ($senin_login == '12.00 - 20.00'){$jam_masuk_senin = '12:00';$jam_pulang_senin = '20:00';}	elseif ($senin_login == '14.00 - 21.00'){$jam_masuk_senin = '14:00';$jam_pulang_senin = '21:00';}
$jam_masuk_senin_str = strtotime($jam_masuk_senin);
$jam_pulang_senin_str = strtotime($jam_pulang_senin);	
	
if ($selasa_login == '08.30 - 17.00'){$jam_masuk_selasa = '08:30';$jam_pulang_selasa = '17:00';} elseif ($selasa_login == '09.30 - 18.00'){$jam_masuk_selasa = '09:30';$jam_pulang_selasa = '18:00';}	elseif ($selasa_login == '11.00 - 19.00'){$jam_masuk_selasa = '11:00';$jam_pulang_selasa = '19:00';}elseif ($selasa_login == '12.00 - 20.00'){$jam_masuk_selasa = '12:00';$jam_pulang_selasa = '20:00';}	elseif ($selasa_login == '14.00 - 21.00'){$jam_masuk_selasa = '14:00';$jam_pulang_selasa = '21:00';}
$jam_masuk_selasa_str = strtotime($jam_masuk_selasa);
$jam_pulang_selasa_str = strtotime($jam_pulang_selasa);	
	
if ($rabu_login == '08.30 - 17.00'){$jam_masuk_rabu = '08:30';$jam_pulang_rabu = '17:00';} elseif ($rabu_login == '09.30 - 18.00'){$jam_masuk_rabu = '09:30';$jam_pulang_rabu = '18:00';}	elseif ($rabu_login == '11.00 - 19.00'){$jam_masuk_rabu = '11:00';$jam_pulang_rabu = '19:00';}elseif ($rabu_login == '12.00 - 20.00'){$jam_masuk_rabu = '12:00';$jam_pulang_rabu = '20:00';}	elseif ($rabu_login == '14.00 - 21.00'){$jam_masuk_rabu = '14:00';$jam_pulang_rabu = '21:00';}
$jam_masuk_rabu_str = strtotime($jam_masuk_rabu);
$jam_pulang_rabu_str = strtotime($jam_pulang_rabu);		
	
if ($kamis_login == '08.30 - 17.00'){$jam_masuk_kamis = '08:30';$jam_pulang_kamis = '17:00';} elseif ($kamis_login == '09.30 - 18.00'){$jam_masuk_kamis = '09:30';$jam_pulang_kamis = '18:00';}	elseif ($kamis_login == '11.00 - 19.00'){$jam_masuk_kamis = '11:00';$jam_pulang_kamis = '19:00';}elseif ($kamis_login == '12.00 - 20.00'){$jam_masuk_kamis = '12:00';$jam_pulang_kamis = '20:00';}	elseif ($kamis_login == '14.00 - 21.00'){$jam_masuk_kamis = '14:00';$jam_pulang_kamis = '21:00';}
$jam_masuk_kamis_str = strtotime($jam_masuk_kamis);
$jam_pulang_kamis_str = strtotime($jam_pulang_kamis);		

if ($jumat_login == '08.30 - 17.00'){$jam_masuk_jumat = '08:30';$jam_pulang_jumat = '17:00';} elseif ($jumat_login == '09.30 - 18.00'){$jam_masuk_jumat = '09:30';$jam_pulang_jumat = '18:00';}	elseif ($jumat_login == '11.00 - 19.00'){$jam_masuk_jumat = '11:00';$jam_pulang_jumat = '19:00';}elseif ($jumat_login == '12.00 - 20.00'){$jam_masuk_jumat = '12:00';$jam_pulang_jumat = '20:00';}	elseif ($jumat_login == '14.00 - 21.00'){$jam_masuk_jumat = '14:00';$jam_pulang_jumat = '21:00';}
$jam_masuk_jumat_str = strtotime($jam_masuk_jumat);
$jam_pulang_jumat_str = strtotime($jam_pulang_jumat);		
	



$jam_masuk_sabtu_str = strtotime($jam_masuk_sabtu);
$jam_pulang_sabtu_str = strtotime($jam_pulang_sabtu);	
if ($senin_login  == '' or $selasa_login  == '' or $rabu_login  == '' or $kamis_login  == '' or $jumat_login  == '' )
	{
	echo "All Day must be set, Press Back Button on browser";die;
	}
if ($jam_masuk_sabtu_str > $jam_pulang_sabtu_str)
	{
	echo "Wrong Login / Logout on Saturday,Press Back Button on browser";die;
	}
	
$query_liburan = q_set($__p_query_liburan, "select tanggal from ves_data.emp_time_work where tanggal like  ? and kd_emp = ? ", [(string) ($kd_thn) . "-" . (string) ($kd_bln) . "%", (string) ($nm_teacher)]);
$result_liburan=db_query_or_die("Wah error nih1", $query_liburan, $__p_query_liburan ?? []);
if(num(db_num_rows($result_liburan)) > 0)
	{
	while ($row_libur=  db_fetch($result_liburan, PDO::FETCH_NUM))
	{
	echo "Time Schedule on Month choosen already exist,Press Back Button on browser";die;
	}
	}	
while (strtotime($awal_bln) <= strtotime($akhir_bln)) 
	{
	$nohari = date('w', strtotime($awal_bln));	
	$query_liburan = q_set($__p_query_liburan, "select date_off from day_off where date_off = ? ", [(string) ($awal_bln)]);
	$result_liburan=db_query_or_die("Wah error nih1", $query_liburan, $__p_query_liburan ?? []);
	if(num(db_num_rows($result_liburan)) > 0)
		{
		while ($row_libur=  db_fetch($result_liburan, PDO::FETCH_NUM))
			{
			$libur = 1;
			}
		}	
	if (num($libur) == 0)
		{
		if (num($nohari) != 0 and num($nohari) != 6)
			{
			if (num($nohari) == 1)
				{
				$query_simpan_slot = q_set($__p_query_simpan_slot, "insert into ves_data.emp_time_work (id_emp, nm_emp, kd_emp, tanggal, kerja_mulai, kerja_selesai, status)\r
\t\t\t\tvalues (? ,? ,? ,? ,? ,? ,'1')", [(string) ($kode_user), (string) ($nama_lengkap), (string) ($nm_teacher), (string) ($awal_bln), (string) ($awal_bln) . " " . (string) ($jam_masuk_senin) . ":01", (string) ($awal_bln) . " " . (string) ($jam_pulang_senin) . ":00"]);					
				}
			elseif (num($nohari) == 2)
				{
				$query_simpan_slot = q_set($__p_query_simpan_slot, "insert into ves_data.emp_time_work (id_emp, nm_emp, kd_emp, tanggal, kerja_mulai, kerja_selesai, status)\r
\t\t\t\tvalues (? ,? ,? ,? ,? ,? ,'1')", [(string) ($kode_user), (string) ($nama_lengkap), (string) ($nm_teacher), (string) ($awal_bln), (string) ($awal_bln) . " " . (string) ($jam_masuk_selasa) . ":01", (string) ($awal_bln) . " " . (string) ($jam_pulang_selasa) . ":00"]);					
				}	
			elseif (num($nohari) == 3)
				{
				$query_simpan_slot = q_set($__p_query_simpan_slot, "insert into ves_data.emp_time_work (id_emp, nm_emp, kd_emp, tanggal, kerja_mulai, kerja_selesai, status)\r
\t\t\t\tvalues (? ,? ,? ,? ,? ,? ,'1')", [(string) ($kode_user), (string) ($nama_lengkap), (string) ($nm_teacher), (string) ($awal_bln), (string) ($awal_bln) . " " . (string) ($jam_masuk_rabu) . ":01", (string) ($awal_bln) . " " . (string) ($jam_pulang_rabu) . ":00"]);					
				}	
			elseif (num($nohari) == 4)
				{
				$query_simpan_slot = q_set($__p_query_simpan_slot, "insert into ves_data.emp_time_work (id_emp, nm_emp, kd_emp, tanggal, kerja_mulai, kerja_selesai, status)\r
\t\t\t\tvalues (? ,? ,? ,? ,? ,? ,'1')", [(string) ($kode_user), (string) ($nama_lengkap), (string) ($nm_teacher), (string) ($awal_bln), (string) ($awal_bln) . " " . (string) ($jam_masuk_kamis) . ":01", (string) ($awal_bln) . " " . (string) ($jam_pulang_kamis) . ":00"]);					
				}	
			elseif (num($nohari) == 5)
				{
				$query_simpan_slot = q_set($__p_query_simpan_slot, "insert into ves_data.emp_time_work (id_emp, nm_emp, kd_emp, tanggal, kerja_mulai, kerja_selesai, status)\r
\t\t\t\tvalues (? ,? ,? ,? ,? ,? ,'1')", [(string) ($kode_user), (string) ($nama_lengkap), (string) ($nm_teacher), (string) ($awal_bln), (string) ($awal_bln) . " " . (string) ($jam_masuk_jumat) . ":01", (string) ($awal_bln) . " " . (string) ($jam_pulang_jumat) . ":00"]);					
				}				
			$resource_slot= db_query_or_die('errro_simpan4', $query_simpan_slot, $__p_query_simpan_slot ?? []);	

			}
		elseif ( num($nohari) == 6)
			{
			$query_simpan_slot = q_set($__p_query_simpan_slot, "insert into ves_data.emp_time_work (id_emp, nm_emp, kd_emp, tanggal, kerja_mulai, kerja_selesai, status)\r
\t\t\tvalues (? ,? ,? ,? ,? ,? ,'1')", [(string) ($kode_user), (string) ($nama_lengkap), (string) ($nm_teacher), (string) ($awal_bln), (string) ($awal_bln) . " " . (string) ($sabtu_login) . ":01", (string) ($awal_bln) . " " . (string) ($sabtu_logout) . ":00"]);	
			$resource_slot= db_query_or_die('errro_simpan4', $query_simpan_slot, $__p_query_simpan_slot ?? []);	
			}
		}	
	
	$libur = 0;	
	$awal_bln = date ("Y-m-d", strtotime("+1 day", strtotime($awal_bln)));	
	}
					echo "<script type=\"text/javascript\">\n";
				echo "alert('New Scheduled has been set by " . e($nama_depan) . "');\n";
				echo "window.location = ('slotteachercalendar.php?kd=" . e(u($nm_teacher)) . "');\n";				
				echo "</script>";
}
?>
