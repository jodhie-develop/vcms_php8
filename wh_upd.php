<?php
require_once __DIR__ . "/_lib/bootstrap.php"; csrf_guard_get(); auth_require_login(); 
include __DIR__ . "/conndb.php";
include __DIR__ . "/profiledata.php";
//include __DIR__ . "/atas.php";
$dt = in_val('dt', 'any');
$tch = in_val('tch', 'any');
$id_table = in_val('id_table', 'any');
$query_nm_teacher = q_set($__p_query_nm_teacher, "SELECT e.id, e.tanggal, e.kerja_mulai, e.kerja_selesai,e.kd_emp,status FROM ves_data.emp_time_work e where tanggal = ? and kd_emp = ?  ", [(string) ($dt), (string) ($tch)]);
$resource_nm_teacher = db_query_or_die('errro_7', $query_nm_teacher, $__p_query_nm_teacher ?? []);
$keluar_nm_teacher= db_num_rows($resource_nm_teacher);
if(num(db_num_rows($resource_nm_teacher)) > 0)
	{
	while ($row_nm_teacher=  db_fetch($resource_nm_teacher, PDO::FETCH_NUM))
		{
		$id_table = $row_nm_teacher[0];
		$tanggalupd = $row_nm_teacher[1];
		$nohari = date('w', strtotime($tanggalupd));			
		$namahari = date('l', strtotime($tanggalupd));			
		$jam_mulai = $row_nm_teacher[2];
		$jam_selesai = $row_nm_teacher[3];
		$nm_teacher = $row_nm_teacher[4];
		$st_aktif = $row_nm_teacher[5];
		if (num($st_aktif) == 1) {$onleave = 'Active';}
		else  {$onleave = 'On Leave';}
		
		}
	}
$jam_mulai_saja  = date("H:i", strtotime($jam_mulai));
$jml_kali = in_val('jml_kali', 'any');
if ($jml_kali == ''){$jml_kali = 'One Time';}
if ($jam_mulai_saja == '08:30'){$senin_login ='08.30 - 17.00';}
elseif ($jam_mulai_saja == '09:30'){$senin_login ='09.30 - 18.00';}
elseif ($jam_mulai_saja == '11:00'){$senin_login ='11.00 - 19.00';}
elseif ($jam_mulai_saja == '12:00'){$senin_login ='12.00 - 20.00';}
elseif ($jam_mulai_saja == '14:00'){$senin_login ='14.00 - 21.00';}
$_GET['id_table'] = $id_table;
//===echo $id
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
<div class="content">

  <!-- Left side column. contains the logo and sidebar -->
  

  <!-- Content Wrapper. Contains page content -->
  <div class="content">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>Update Time Work</h1>
    </section>
 <form method="post"><?php echo csrf_field(); ?> 
    <!-- Main content -->
<section class="content">
  <div class="row">
        <!-- left column -->
<?php  //     include __DIR__ . "/left.php";	 ?>
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
           	    <span class="form-group"><input type="text" name="kls_cbg"value="<?php echo e($kls_cbg) ?>" hidden>
       	        </span><span class="form-group">
       	        <input type="text" name="id_table" value="<?php echo e($id_table) ?>" hidden>
       	        </span></div> 
			</div>
<div class="box box-warning">
<div class="box-header with-border"><strong>SETTING TIME WORKING</strong></div>
		  		<div class="box-header with-border"><strong>Date (<?php echo e($namahari) ?>)</strong><span class="form-group">
		  		  <input type="text" name="nohari"value="<?php echo e($nohari) ?>" hidden="hidden" >
		  		</span></div>
                 	<div class="box-body">
                 	  <div class="col-md-3">
                 	    <div class="form-group">
                 	      <input type="DATE" class="form-control"  placeholder="Enter CLass Code" name="tanggalupd" value="<?php echo e($tanggalupd) ?>" readonly>
                 	    </div>
               	    </div>
</div>
<div class="box-body">
  <div class="col-md-6">
	  
<?php if (num($nohari) != 6 ){?>	  
    <div class="col-md-6">
      <div class="form-group">
        <label>Shift</label>
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
	  
<?php }else {?>	  
	  
    <div class="col-md-4">
      <div class="form-group">
      <label>Login</label>
		  
	    <input type="time" class="form-control" value="<?php $jam_mulai = date("H:i", strtotime($jam_mulai)); echo e($jam_mulai); ?>" id="until_t" name="jam_mulai_sabtu" />

    </div>
  <div class="form-group">
    <label>Logout</label>
     <input type="time" class="form-control" value="<?php $jam_selesai = date("H:i", strtotime($jam_selesai)); echo e($jam_selesai); ?>" id="until_t" name="jam_selesai_sabtu" />
  </div>		
<?php } ?>		

           	                     	                 	      
</div>

  </div>
  <div class="col-md-6"></div>
</div>
<div class="box-body">
  <div class="col-md-6">
    <div class="col-md-4">
      <div class="form-group">
        <label>One Time / Recurring</label>
        <select class="form-control" name="jml_kali">
          <option value="One Time">One Time</option>
          <option value="Recurring">Recurring</option>
          <option selected><?php echo e($jml_kali) ?></option>
        </select>
      </div>
    </div>
  </div>
  <div class="col-md-6">
    <div class="col-md-4">
      <div class="form-group">
        <label>On Leave</label>
        <select class="form-control" name="st_aktif">
          <option value="Active">Active</option>
          <option value="On Leave">On Leave</option>
<?php if (num($nohari) ==6){?>
          <option value="Sat Off">Sat Off</option>			
<?php } ?>			
          <option selected><?php echo e($onleave) ?></option>
        </select>
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
$id_table = in_val('id_table', 'any');

$tanggalupd	= in_val('tanggalupd', 'any');
$jml_kali = in_val('jml_kali', 'any');	
$nohari = in_val('nohari', 'any');
$nm_teacher = in_val('nm_teacher', 'any');	
$senin_login = in_val('senin_login', 'any')	;
if ($senin_login == '08.30 - 17.00'){$jam_masuk_senin = '08:30';$jam_pulang_senin = '17:00';}	
elseif ($senin_login == '09.30 - 18.00'){$jam_masuk_senin = '09:30';$jam_pulang_senin = '18:00';}		
elseif ($senin_login == '11.00 - 19.00'){$jam_masuk_senin = '11:00';$jam_pulang_senin = '19:00';}		
elseif ($senin_login == '12.00 - 20.00'){$jam_masuk_senin = '12:00';$jam_pulang_senin = '20:00';}		
elseif ($senin_login == '14.00 - 21.00'){$jam_masuk_senin = '14:00';$jam_pulang_senin = '21:00';}	
	
	
$jam_mulai = in_val('jam_masuk_senin', 'any');
$jam_selesai = in_val('jam_pulang_senin', 'any');
$jam_mulai_sabtu = in_val('jam_mulai_sabtu', 'any');
$jam_selesai_sabtu = in_val('jam_selesai_sabtu', 'any');	
$st_aktif = in_val('st_aktif', 'any');
if ($st_aktif == 'Active'){$st_aktif = 1;}else{$st_aktif = 0;}

if($jml_kali == 'One Time')
	{	
	if (num($nohari) !=6)
	{
	$query_liburan = q_set($__p_query_liburan, "update ves_data.emp_time_work set kerja_mulai = ? , kerja_selesai =? , status = ?   where id = ? ", [(string) ($tanggalupd) . " " . (string) ($jam_masuk_senin) . ":01", (string) ($tanggalupd) . " " . (string) ($jam_pulang_senin) . ":00", (string) ($st_aktif), (string) ($id_table)]);
	}
	else
		{
			$query_liburan = q_set($__p_query_liburan, "update ves_data.emp_time_work set kerja_mulai = ? , kerja_selesai =? , status = ?   where id = ? ", [(string) ($tanggalupd) . " " . (string) ($jam_mulai_sabtu) . ":01", (string) ($tanggalupd) . " " . (string) ($jam_selesai_sabtu) . ":00", (string) ($st_aktif), (string) ($id_table)]);

	}
	/* echo $query_liburan (debug SQL versi lama) dihapus */
	$result_liburan=db_query_or_die("Wah error nih1", $query_liburan, $__p_query_liburan ?? []);
	echo "<script type=\"text/javascript\">\n";
echo "alert('New Scheduled has been set by " . e($nama_depan) . "');\n";
echo "window.opener.location.reload(true);\n";
echo "window.close();\n"; 
	}
elseif($jml_kali == 'Recurring' and num($st_aktif) == 1)  
	{

	
	$query_ambil_jadwal = q_set($__p_query_ambil_jadwal, "SELECT id, tanggal  FROM ves_data.emp_time_work where date_format(tanggal,'%w') = ? and tanggal >= ? and kd_emp = ? ", [(string) ($nohari), (string) ($tanggalupd), (string) ($nm_teacher)]);

	$result_ambil_jadwal =db_query_or_die("Wah error nih1", $query_ambil_jadwal, $__p_query_ambil_jadwal ?? []);
	if(num(db_num_rows($result_ambil_jadwal)) > 0)
		{
		while ($row_ambil_jadwal=  db_fetch($result_ambil_jadwal, PDO::FETCH_NUM))
			{
			$id = $row_ambil_jadwal[0];
			$baca_tanggal = $row_ambil_jadwal[1];
			if (num($nohari) != 6)
			{
			$query_rubah_jam = q_set($__p_query_rubah_jam, "update ves_data.emp_time_work set kerja_mulai = ? , kerja_selesai =? , status = ?   where id = ? ", [(string) ($baca_tanggal) . " " . (string) ($jam_masuk_senin) . ":01", (string) ($baca_tanggal) . " " . (string) ($jam_pulang_senin) . ":00", (string) ($st_aktif), (string) ($id)]);
			}
			else
			{
			$query_rubah_jam = q_set($__p_query_rubah_jam, "update ves_data.emp_time_work set kerja_mulai = ? , kerja_selesai =? , status = ?   where id = ? ", [(string) ($baca_tanggal) . " \$" . (string) ($jam_mulai_sabtu) . ":01", (string) ($baca_tanggal) . " " . (string) ($jam_selesai_sabtu) . ":00", (string) ($st_aktif), (string) ($id)]);				
			}
			$result_ubah_jam =db_query_or_die("Wah error nih1", $query_rubah_jam, $__p_query_rubah_jam ?? []);		
			}
		}
	echo "<script type=\"text/javascript\">\n";
echo "alert('New Scheduled has been set by " . e($nama_depan) . "');\n";
echo "window.opener.location.reload(true);\n";
echo "window.close();\n"; 
	}
else
	{
	echo "<script type=\"text/javascript\">\n";
	echo "alert('Reccuring Change must be On active day');\n";
	}

echo "</script>";
}
?>
