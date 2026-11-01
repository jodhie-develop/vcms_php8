<?php
// Halaman ketersediaan guru per minggu (6 hari x 13 slot jam).
include __DIR__ . "/conndb.php";
include __DIR__ . "/profiledata.php";
auth_require_login();
// Hanya ACD / Admin / SC / CM / ACCM (keputusan 2026-10-27; versi lama terbuka untuk semua
// user karena bug "$posisi = 'ACCM'" di kondisi tampilan).
auth_require(auth_is('kelompok', 'ACD') || auth_is('posisi', 'Admin', 'SC', 'CM', 'ACCM'));
include __DIR__ . "/atas.php";
include __DIR__ . "/left.php";
// Variabel tampilan diinisialisasi agar PHP 8 tidak memberi warning "undefined variable"
// (versi lama mengandalkan variabel kosong). Isi $day_* berisi markup (<spant>, <lc>)
// sehingga data dari DB di-escape saat dimasukkan, bukan saat di-echo.
for ($d = 1; $d <= 6; $d++) {
	${"judul_hari_$d"} = ${"judul_tgl_$d"} = ${"judul_tgl_lengkap_$d"} = '';
	for ($s = 1; $s <= 13; $s++) {
		${"day_{$d}_{$s}"} = ${"day_{$d}_{$s}_a"} = ${"bg_{$d}_{$s}"} = '';
	}
}
$nm_teacher_tampil = $jam_masuk = $jam_pulang = '';
$hari=date("d");
$bulan=date("m");
$tahun=date("Y");
$hari_ini = "$tahun-$bulan-$hari";
$date_start = in_str('date_start', 45, 'get');
$tgl_awal = in_date('tgl_awal', '', 'get');
$nm_teacher = in_str('nm_teacher', 45, 'get');
if ($nm_teacher !='')
	{
		echo "<script type=\"text/javascript\">\n";
		echo 'window.location = (' . js('vip_teacher_free.php?tgl_awal=' . u($tgl_awal) . '&nm_teacher=' . u($nm_teacher)) . ");\n";				
		echo "</script>";	
	}
else
{	
if ($kd_cbg == 'Online'){$kd_cbg = 100;}

if ($kd_cbg == 'East Sby'){$kd_cbg = 1;}
if ($kd_cbg == 'West Sby'){$kd_cbg = 2;}
if ($kd_cbg == 'Denpasar'){$kd_cbg = 3;}
if ($kd_cbg == 'South Jkt'){$kd_cbg = 4;}
if ($kd_cbg == 'North Jkt'){$kd_cbg = 5;}
if ($kd_cbg == 'West Jkt'){$kd_cbg = 6;}
if ($kd_cbg == 'Bandung'){$kd_cbg = 7;}
if ($kd_cbg == 'Malang'){$kd_cbg = 8;}
if ($kd_cbg == 'East Area'){$kd_cbg = 101;}
if ($kd_cbg == 'West Area'){$kd_cbg = 102;}
if ($kd_cbg == 'Vpro Sby'){$kd_cbg = 351;}
if ($kd_cbg == 'Vpro Jkt'){$kd_cbg = 357;}
if ($kd_cbg == 'Vpro Dps'){$kd_cbg = 355;}
if ($kd_cbg == 'Vpro Mlg'){$kd_cbg = 358;}	
if ($kd_cbg == 'Vpro Bdg'){$kd_cbg = 353;}	
if ($kd_cbg == 'National'){$kd_cbg = 111;}		
		

if ($kd_cbg ==100){$cabang = 'Online';}
if ($kd_cbg ==''){$cabang = 'National';}
if ($kd_cbg =='111'){$cabang = 'National';}
if ($kd_cbg ==1){$cabang = 'East Sby';}
if ($kd_cbg ==2){$cabang = 'West Sby';}
if ($kd_cbg ==3){$cabang = 'Denpasar';}
if ($kd_cbg ==4){$cabang = 'South Jkt';}
if ($kd_cbg ==5){$cabang = 'North Jkt';}
if ($kd_cbg ==6){$cabang = 'West Jkt';}
if ($kd_cbg ==7){$cabang = 'Bandung';}
if ($kd_cbg ==8){$cabang = 'Malang';}
if ($kd_cbg ==101){$cabang = 'East Area';}
if ($kd_cbg ==102){$cabang = 'West Area';}
if ($kd_cbg == 351){$cabang = 'Vpro Sby';}
if ($kd_cbg == 357){$cabang = 'Vpro Jkt';}
if ($kd_cbg == 355){$cabang = 'Vpro Dps';}
if ($kd_cbg == 358){$cabang = 'Vpro Mlg';}
if ($kd_cbg == 353){$cabang = 'Vpro Bdg';}
if ($kd_cbg == 111){$cabang = 'National';}	
$tgl_awal = in_date('tgl_awal', '', 'get');
$tgl_akhir = in_str('tgl_akhir', 45, 'get');
$activities = in_str('activities', 45, 'get');
$kelas = in_str('kelas', 45, 'get');			
$awal_mgg =$tgl_awal;

$ambilhari = date('w', strtotime($tgl_awal));
$query_nm_teacher = "SELECT  nm_teacher  FROM vip_teacher_name where kd_teacher = ? ";
$resource_nm_teacher = db_query($query_nm_teacher, [$nm_teacher]);
$keluar_nm_teacher= $resource_nm_teacher->rowCount();
	while ($row_nm_teacher=  $resource_nm_teacher->fetch(PDO::FETCH_NUM))
		{
		$nm_teacher_tampil = $row_nm_teacher[0];
		}
}
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>VE Teachers Availability</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <script type="text/javascript" src="plugins/jQuery/jquery-2.2.3.min.js"></script>  

  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="plugins/iCheck/flat/blue.css">
  <!-- Morris chart -->
  <link rel="stylesheet" href="plugins/morris/morris.css">
  <!-- jvectormap -->
  <link rel="stylesheet" href="plugins/jvectormap/jquery-jvectormap-1.2.2.css">
  <!-- Date Picker -->
  <link rel="stylesheet" href="plugins/datepicker/datepicker3.css">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="plugins/daterangepicker/daterangepicker.css">
  <!-- bootstrap wysihtml5 - text editor -->
  <link rel="stylesheet" href="plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
<style>
spann{
  background-color: #95F9A4;
}
spant{
  background-color: #FF0004;color: white;
}	
lc{
  background-color: #1061DD;
}
tutor{
  background-color: #E7A3F7;
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
 <?php //====================== ?>
 <div class="content-wrapper">
    <!-- Content Header (Page header) -->
   <?php if ($kelompok == 'ACD' or  $posisi =='Admin' or $posisi == 'SC'  or $posisi == 'CM'  or $posisi == 'ACCM'){	

// ($query versi lama tidak pernah dijalankan, tidak dibawa)

//===========academic==
?>
<section class="content-header">
<h1>Weekly All Teacher's Availabilty</h1>
<div class="tab-content">
  <div id="act" class="tab-pane fade in active">
	<div class="panel box box-primary">
	<form name="myform" id="myform">
		<div class="box-header with-border">
		  <div class="col-md-2">
		    <div class="form-group">
		    <label>Start Date</label>
		    <input name="tgl_awal"  class="form-control"  type="date" value="<?php echo e($tgl_awal) ?>"   onChange="this.form.submit()"/>
		  </div>
		  </div>
		<div class="col-md-2">
		  <div class="form-group">
		    <label>Teacher</label>
		    <select class="form-control" name="nm_teacher"   onChange="this.form.submit()" >
	      <option>--All--</option>
		      <?php
$query_nm_teacher = "SELECT  nm_teacher ,kd_teacher  FROM vip_teacher_name where status = 1 ";

	
$resource_nm_teacher = db_query($query_nm_teacher);
$keluar_nm_teacher= $resource_nm_teacher->rowCount();
	while ($row_nm_teacher=  $resource_nm_teacher->fetch(PDO::FETCH_NUM))
		{	
							  		echo '<option value="'.e($row_nm_teacher[1]).'">'.e($row_nm_teacher[0]).'</option>';
							  		}      ?>
              <option selected="selected"><?php echo e($nm_teacher) ?></option>							  		
	        </select>
	      </div>
		  </div>
		<h4 class="box-title">		  <br>
		</h4>
		</div>
		
		<h3><?php echo e($nm_teacher_tampil) ?></h3>
	  </form>

      <div class="box-body">
             

<br>
<?php
if($tgl_awal != '')
{


$jml_hari =1;		
//====mulai hari 1
$slot_1_start = "08:00:01"; $slot_1_end = "09:00:00";
$slot_2_start = "09:00:01"; $slot_2_end = "10:00:00";
$slot_3_start = "10:00:01"; $slot_3_end = "11:00:00";
$slot_4_start = "11:00:01"; $slot_4_end = "12:00:00";
$slot_5_start = "12:00:01"; $slot_5_end = "13:00:00";
$slot_6_start = "13:00:01"; $slot_6_end = "14:00:00";
$slot_7_start = "14:00:01"; $slot_7_end = "15:00:00";
$slot_8_start = "15:00:01"; $slot_8_end = "16:00:00";
$slot_9_start = "16:00:01"; $slot_9_end = "17:00:00";
$slot_10_start = "17:00:01"; $slot_10_end = "18:00:00";
$slot_11_start = "18:00:01"; $slot_11_end = "19:00:00";
$slot_12_start = "19:00:01"; $slot_12_end = "20:00:00";
$slot_13_start = "20:00:01"; $slot_13_end = "21:00:00";

while ($jml_hari <= 6) 
	{
	$no_hari  = date('w', strtotime($tgl_awal));
	$no_hari  = date('w', strtotime($tgl_awal));
	
	if ($no_hari != 0)	
		{
		$judul_hari  = date('l', strtotime($tgl_awal));
		$judul_tgl  = date('d-m-y', strtotime($tgl_awal));
		$judul_tgl_lengkap  = date('Y-m-d', strtotime($tgl_awal));
		$mulai_tm  = date('Y-m-d', strtotime($tgl_awal));		
		if($jml_hari ==1) 
			{
			$judul_hari_1 = $judul_hari;$judul_tgl_1 = $judul_tgl;				$judul_tgl_lengkap_1  = date('Y-m-d', strtotime($tgl_awal));

			$query_msk_plg ="SELECT date_format(kerja_mulai,'%T'), date_format(kerja_selesai,'%T') FROM emp_time_work where kd_emp = ? and tanggal = ? and status = 1";	

			$resource_msk_plg= db_query($query_msk_plg, [$nm_teacher, "$mulai_tm "]);
			while ($row_msk_plg=  $resource_msk_plg->fetch(PDO::FETCH_NUM))
				{	
				$jam_masuk = $row_msk_plg[0];
				$jam_pulang = $row_msk_plg[1];
		
				}

						
						
			$jml_slot =1;
			while ($jml_slot <= 13)
				{
				if($jml_slot ==1 ){$waktu_mulai = "$mulai_tm $slot_1_start";$waktu_selesai = "$mulai_tm $slot_1_end";}
				elseif($jml_slot ==2){$waktu_mulai = "$mulai_tm $slot_2_start";$waktu_selesai = "$mulai_tm $slot_2_end";}
				elseif($jml_slot ==3){$waktu_mulai = "$mulai_tm $slot_3_start";$waktu_selesai = "$mulai_tm $slot_3_end";}
				elseif($jml_slot ==4){$waktu_mulai = "$mulai_tm $slot_4_start";$waktu_selesai = "$mulai_tm $slot_4_end";}
				elseif($jml_slot ==5){$waktu_mulai = "$mulai_tm $slot_5_start";$waktu_selesai = "$mulai_tm $slot_5_end";}
				elseif($jml_slot ==6){$waktu_mulai = "$mulai_tm $slot_6_start";$waktu_selesai = "$mulai_tm $slot_6_end";}
				elseif($jml_slot ==7){$waktu_mulai = "$mulai_tm $slot_7_start";$waktu_selesai = "$mulai_tm $slot_7_end";}
				elseif($jml_slot ==8){$waktu_mulai = "$mulai_tm $slot_8_start";$waktu_selesai = "$mulai_tm $slot_8_end";}
				elseif($jml_slot ==9){$waktu_mulai = "$mulai_tm $slot_9_start";$waktu_selesai = "$mulai_tm $slot_9_end";}
				elseif($jml_slot ==10){$waktu_mulai = "$mulai_tm $slot_10_start";$waktu_selesai = "$mulai_tm $slot_10_end";}
				elseif($jml_slot ==11){$waktu_mulai = "$mulai_tm $slot_11_start";$waktu_selesai = "$mulai_tm $slot_11_end";}
				elseif($jml_slot ==12){$waktu_mulai = "$mulai_tm $slot_12_start";$waktu_selesai = "$mulai_tm $slot_12_end";}
				elseif($jml_slot ==13){$waktu_mulai = "$mulai_tm $slot_13_start";$waktu_selesai = "$mulai_tm $slot_13_end";}
					$i = 1;
					$query_slot_teacher ="SELECT nm_teacher, mulai_tm, selesai_tm,room,center,kelas,date_format(mulai_tm,'%d %m %y'),date_format(mulai_tm,'%H:%i %p'), date_format(selesai_tm,'%H:%i %p'),status_kelas  FROM emp_time_work a left join  ves_data.vip_teacher_schedule b on kd_emp = nm_teacher and a.tanggal = ? and a.status= 1 WHERE (status_kelas <> 0 and status_kelas <> 52 and status_kelas <> 62 and status_kelas <> 72 and status_kelas <>92 )   and ((mulai_tm >= ? AND mulai_tm <= ?) OR
					(selesai_tm >= ? AND selesai_tm <= ?)) and (status_kelas <> 0 and status_kelas <> 52 and status_kelas <> 62 and status_kelas <> 72 and status_kelas <>92 ) order by nm_teacher ";	
					$u= 0;
					$resource_slot_teacher= db_query($query_slot_teacher, [$mulai_tm, $waktu_mulai, $waktu_selesai, $waktu_mulai, $waktu_selesai]);
					if($resource_slot_teacher->rowCount() > 0)
						{
						while ($row_kd_teacher=  $resource_slot_teacher->fetch(PDO::FETCH_NUM))
							{
							$kdt = e($row_kd_teacher[0]);
							$stcl= $row_kd_teacher[9];
							if($stcl ==1){$kdt = " <spant> $kdt </spant> ";}	elseif($stcl ==70 or $stcl ==71 or $stcl ==75   ){$kdt = " <lc> $kdt </lc> ";}
							if($jml_slot ==1){$day_1_1 = "$day_1_1 $kdt";}	
							elseif($jml_slot ==2){$day_1_2 = "$day_1_2  $kdt";}	
							elseif($jml_slot ==3){$day_1_3 = "$day_1_3  $kdt";}	
							elseif($jml_slot ==4){$day_1_4 = "$day_1_4  $kdt";}	
							elseif($jml_slot ==5){$day_1_5 = "$day_1_5  $kdt";}	
							elseif($jml_slot ==6){$day_1_6 = "$day_1_6  $kdt";}	
							elseif($jml_slot ==7){$day_1_7 = "$day_1_7  $kdt";}	
							elseif($jml_slot ==8){$day_1_8 = "$day_1_8  $kdt";}	
							elseif($jml_slot ==9){$day_1_9 = "$day_1_9  $kdt";}	
							elseif($jml_slot ==10){$day_1_10 = "$day_1_10  $kdt";}	
							elseif($jml_slot ==11){$day_1_11 = "$day_1_11  $kdt";}	
							elseif($jml_slot ==12){$day_1_12 = "$day_1_12  $kdt";}	
							elseif($jml_slot ==13){$day_1_13 = "$day_1_13  $kdt";}

							}
						
						}

						$query_free_teacher ="SELECT a.nm_emp, a.kd_emp,a.kerja_mulai,status_kelas,b.mulai_tm FROM emp_time_work a  left join vip_teacher_schedule  b on a.kd_emp = b.nm_teacher and a.tanggal = date_format(mulai_tm,'%Y-%m-%d')   and ((mulai_tm >= ? AND mulai_tm <= ?) OR (selesai_tm >= ? AND selesai_tm <= ?))
						where date_format(a.kerja_mulai, '%Y-%m-%d') = ? and  (status_kelas is null or status_kelas = 0 or status_kelas = 52 or status_kelas = 62 or status_kelas = 72 or status_kelas = 92 )";	

						$resource_free_teacher= db_query($query_free_teacher, [$waktu_mulai, $waktu_selesai, $waktu_mulai, $waktu_selesai, "$mulai_tm "]);
						if($resource_free_teacher->rowCount() > 0)
							{
							while ($row_free_teacher=  $resource_free_teacher->fetch(PDO::FETCH_NUM))
								{
							$kdft = e($row_free_teacher[1]);						
						
							if($jml_slot ==1)   {$day_1_1_a = "$day_1_1_a  $kdft";$bg_1_1 = "bgcolor='#95F9A4'";}	
							elseif($jml_slot ==2){$day_1_2_a = "$day_1_2_a  $kdft";$bg_1_2 = "bgcolor='#95F9A4'";}	
							elseif($jml_slot ==3){$day_1_3_a = "$day_1_3_a  $kdft";$bg_1_3 = "bgcolor='#95F9A4'";}	
							elseif($jml_slot ==4){$day_1_4_a = "$day_1_4_a  $kdft";$bg_1_4 = "bgcolor='#95F9A4'";}	
							elseif($jml_slot ==5){$day_1_5_a = "$day_1_5_a  $kdft";$bg_1_5 = "bgcolor='#95F9A4'";}	
							elseif($jml_slot ==6){$day_1_6_a = "$day_1_6_a  $kdft";$bg_1_6 = "bgcolor='#95F9A4'";}	
							elseif($jml_slot ==7){$day_1_7_a = "$day_1_7_a  $kdft";$bg_1_7 = "bgcolor='#95F9A4'";}	
							elseif($jml_slot ==8){$day_1_8_a = "$day_1_8_a  $kdft";$bg_1_8 = "bgcolor='#95F9A4'";}	
							elseif($jml_slot ==9){$day_1_9_a = "$day_1_9_a  $kdft";$bg_1_9 = "bgcolor='#95F9A4'";}	
							elseif($jml_slot ==10){$day_1_10_a = "$day_1_10_a  $kdft";$bg_1_10 = "bgcolor='#95F9A4'";}	
							elseif($jml_slot ==11){$day_1_11_a = "$day_1_11_a  $kdft";$bg_1_11 = "bgcolor='#95F9A4'";}	
							elseif($jml_slot ==12){$day_1_12_a = "$day_1_12_a  $kdft";$bg_1_12 = "bgcolor='#95F9A4'";}	
							elseif($jml_slot ==13){$day_1_13_a = "$day_1_13_a  $kdft";$bg_1_13 = "bgcolor='#95F9A4'";}}							
						}
				$jml_slot = $jml_slot+1;				
				}
			}	
		elseif($jml_hari ==2) 
			{$judul_hari_2 = $judul_hari;$judul_tgl_2 = $judul_tgl;				$judul_tgl_lengkap_2  = date('Y-m-d', strtotime($tgl_awal));
			$query_msk_plg ="SELECT date_format(kerja_mulai,'%T'), date_format(kerja_selesai,'%T') FROM emp_time_work where kd_emp = ? and tanggal = ? and status = 1";	

			$resource_msk_plg= db_query($query_msk_plg, [$nm_teacher, "$mulai_tm "]);
			while ($row_msk_plg=  $resource_msk_plg->fetch(PDO::FETCH_NUM))
				{	
				$jam_masuk = $row_msk_plg[0];
				$jam_pulang = $row_msk_plg[1];
		
				}			 
		$jml_slot =1;
			while ($jml_slot <= 13)
				{
				if($jml_slot ==1){$waktu_mulai = "$mulai_tm $slot_1_start";$waktu_selesai = "$mulai_tm $slot_1_end";}
				elseif($jml_slot ==2){$waktu_mulai = "$mulai_tm $slot_2_start";$waktu_selesai = "$mulai_tm $slot_2_end";}
				elseif($jml_slot ==3){$waktu_mulai = "$mulai_tm $slot_3_start";$waktu_selesai = "$mulai_tm $slot_3_end";}
				elseif($jml_slot ==4){$waktu_mulai = "$mulai_tm $slot_4_start";$waktu_selesai = "$mulai_tm $slot_4_end";}
				elseif($jml_slot ==5){$waktu_mulai = "$mulai_tm $slot_5_start";$waktu_selesai = "$mulai_tm $slot_5_end";}
				elseif($jml_slot ==6){$waktu_mulai = "$mulai_tm $slot_6_start";$waktu_selesai = "$mulai_tm $slot_6_end";}
				elseif($jml_slot ==7){$waktu_mulai = "$mulai_tm $slot_7_start";$waktu_selesai = "$mulai_tm $slot_7_end";}
				elseif($jml_slot ==8){$waktu_mulai = "$mulai_tm $slot_8_start";$waktu_selesai = "$mulai_tm $slot_8_end";}
				elseif($jml_slot ==9){$waktu_mulai = "$mulai_tm $slot_9_start";$waktu_selesai = "$mulai_tm $slot_9_end";}
				elseif($jml_slot ==10){$waktu_mulai = "$mulai_tm $slot_10_start";$waktu_selesai = "$mulai_tm $slot_10_end";}
				elseif($jml_slot ==11){$waktu_mulai = "$mulai_tm $slot_11_start";$waktu_selesai = "$mulai_tm $slot_11_end";}
				elseif($jml_slot ==12){$waktu_mulai = "$mulai_tm $slot_12_start";$waktu_selesai = "$mulai_tm $slot_12_end";}
				elseif($jml_slot ==13){$waktu_mulai = "$mulai_tm $slot_13_start";$waktu_selesai = "$mulai_tm $slot_13_end";}

					$query_slot_teacher ="SELECT nm_teacher, mulai_tm, selesai_tm,room,center,kelas,date_format(mulai_tm,'%d %m %y'),date_format(mulai_tm,'%H:%i %p'), date_format(selesai_tm,'%H:%i %p'),status_kelas  FROM emp_time_work a left join  ves_data.vip_teacher_schedule b on kd_emp = nm_teacher and a.tanggal = ? and a.status= 1  WHERE (status_kelas <> 0 and status_kelas <> 52 and status_kelas <> 62 and status_kelas <> 72 and status_kelas <>92 )   and ((mulai_tm >= ? AND mulai_tm <= ?) OR
					(selesai_tm >= ? AND selesai_tm <= ?)) and (status_kelas <> 0 and status_kelas <> 52 and status_kelas <> 62 and status_kelas <> 72 and status_kelas <>92 ) order by nm_teacher ";	
					$u= 0;
					$resource_slot_teacher= db_query($query_slot_teacher, [$mulai_tm, $waktu_mulai, $waktu_selesai, $waktu_mulai, $waktu_selesai]);
					if($resource_slot_teacher->rowCount() > 0)
						{
						while ($row_kd_teacher=  $resource_slot_teacher->fetch(PDO::FETCH_NUM))
							{
							$kdt = e($row_kd_teacher[0]);
							$stcl= $row_kd_teacher[9];
							if($stcl ==1){$kdt = " <spant> $kdt </spant> ";}	elseif($stcl ==70 or $stcl ==71 or $stcl ==75   ){$kdt = " <lc> $kdt </lc> ";}
							if($jml_slot ==1){$day_2_1 = "$day_1_1 $kdt";}	
							elseif($jml_slot ==2){$day_2_2 = "$day_2_2  $kdt";}	
							elseif($jml_slot ==3){$day_2_3 = "$day_2_3  $kdt";}	
							elseif($jml_slot ==4){$day_2_4 = "$day_2_4  $kdt";}	
							elseif($jml_slot ==5){$day_2_5 = "$day_2_5  $kdt";}	
							elseif($jml_slot ==6){$day_2_6 = "$day_2_6  $kdt";}	
							elseif($jml_slot ==7){$day_2_7 = "$day_2_7  $kdt";}	
							elseif($jml_slot ==8){$day_2_8 = "$day_2_8  $kdt";}	
							elseif($jml_slot ==9){$day_2_9 = "$day_2_9  $kdt";}	
							elseif($jml_slot ==10){$day_2_10 = "$day_2_10  $kdt";}	
							elseif($jml_slot ==11){$day_2_11 = "$day_2_11  $kdt";}	
							elseif($jml_slot ==12){$day_2_12 = "$day_2_12  $kdt";}	
							elseif($jml_slot ==13){$day_2_13 = "$day_2_13  $kdt";}

							}
						
						}

						$query_free_teacher ="SELECT a.nm_emp, a.kd_emp,a.kerja_mulai,status_kelas,b.mulai_tm FROM emp_time_work a  left join vip_teacher_schedule  b on a.kd_emp = b.nm_teacher and a.tanggal = date_format(mulai_tm,'%Y-%m-%d')   and ((mulai_tm >= ? AND mulai_tm <= ?) OR (selesai_tm >= ? AND selesai_tm <= ?))
						where date_format(a.kerja_mulai, '%Y-%m-%d') = ? and  (status_kelas is null or status_kelas = 0 or status_kelas = 52 or status_kelas = 62 or status_kelas = 72 or status_kelas = 92 )";	

						$resource_free_teacher= db_query($query_free_teacher, [$waktu_mulai, $waktu_selesai, $waktu_mulai, $waktu_selesai, "$mulai_tm "]);
						if($resource_free_teacher->rowCount() > 0)
							{
							while ($row_free_teacher=  $resource_free_teacher->fetch(PDO::FETCH_NUM))
								{
							$kdft = e($row_free_teacher[1]);						
						
							if($jml_slot ==1)   {$day_2_1_a = "$day_2_1_a  $kdft";$bg_2_1 = "bgcolor='#95F9A4'";}	
							elseif($jml_slot ==2){$day_2_2_a = "$day_2_2_a  $kdft";$bg_2_2 = "bgcolor='#95F9A4'";}	
							elseif($jml_slot ==3){$day_2_3_a = "$day_2_3_a  $kdft";$bg_2_3 = "bgcolor='#95F9A4'";}	
							elseif($jml_slot ==4){$day_2_4_a = "$day_2_4_a  $kdft";$bg_2_4 = "bgcolor='#95F9A4'";}	
							elseif($jml_slot ==5){$day_2_5_a = "$day_2_5_a  $kdft";$bg_2_5 = "bgcolor='#95F9A4'";}	
							elseif($jml_slot ==6){$day_2_6_a = "$day_2_6_a  $kdft";$bg_2_6 = "bgcolor='#95F9A4'";}	
							elseif($jml_slot ==7){$day_2_7_a = "$day_2_7_a  $kdft";$bg_2_7 = "bgcolor='#95F9A4'";}	
							elseif($jml_slot ==8){$day_2_8_a = "$day_2_8_a  $kdft";$bg_2_8 = "bgcolor='#95F9A4'";}	
							elseif($jml_slot ==9){$day_2_9_a = "$day_2_9_a  $kdft";$bg_2_9 = "bgcolor='#95F9A4'";}	
							elseif($jml_slot ==10){$day_2_10_a = "$day_2_10_a  $kdft";$bg_2_10 = "bgcolor='#95F9A4'";}	
							elseif($jml_slot ==11){$day_2_11_a = "$day_2_11_a  $kdft";$bg_2_11 = "bgcolor='#95F9A4'";}	
							elseif($jml_slot ==12){$day_2_12_a = "$day_2_12_a  $kdft";$bg_2_12 = "bgcolor='#95F9A4'";}	
							elseif($jml_slot ==13){$day_2_13_a = "$day_2_13_a  $kdft";$bg_2_13 = "bgcolor='#95F9A4'";}}							
						}
				$jml_slot = $jml_slot+1;				
				}
				 
			}
		elseif($jml_hari ==3) 
			{
			$judul_hari_3 = $judul_hari;$judul_tgl_3 = $judul_tgl;				$judul_tgl_lengkap_3  = date('Y-m-d', strtotime($tgl_awal));
			$query_msk_plg ="SELECT date_format(kerja_mulai,'%T'), date_format(kerja_selesai,'%T') FROM emp_time_work where kd_emp = ? and tanggal = ? and status = 1";	

			$resource_msk_plg= db_query($query_msk_plg, [$nm_teacher, "$mulai_tm "]);
			while ($row_msk_plg=  $resource_msk_plg->fetch(PDO::FETCH_NUM))
				{	
				$jam_masuk = $row_msk_plg[0];
				$jam_pulang = $row_msk_plg[1];
		
				}			
					$jml_slot =1;
			while ($jml_slot <= 13)
				{
				if($jml_slot ==1 ){$waktu_mulai = "$mulai_tm $slot_1_start";$waktu_selesai = "$mulai_tm $slot_1_end";}
				elseif($jml_slot ==2){$waktu_mulai = "$mulai_tm $slot_2_start";$waktu_selesai = "$mulai_tm $slot_2_end";}
				elseif($jml_slot ==3){$waktu_mulai = "$mulai_tm $slot_3_start";$waktu_selesai = "$mulai_tm $slot_3_end";}
				elseif($jml_slot ==4){$waktu_mulai = "$mulai_tm $slot_4_start";$waktu_selesai = "$mulai_tm $slot_4_end";}
				elseif($jml_slot ==5){$waktu_mulai = "$mulai_tm $slot_5_start";$waktu_selesai = "$mulai_tm $slot_5_end";}
				elseif($jml_slot ==6){$waktu_mulai = "$mulai_tm $slot_6_start";$waktu_selesai = "$mulai_tm $slot_6_end";}
				elseif($jml_slot ==7){$waktu_mulai = "$mulai_tm $slot_7_start";$waktu_selesai = "$mulai_tm $slot_7_end";}
				elseif($jml_slot ==8){$waktu_mulai = "$mulai_tm $slot_8_start";$waktu_selesai = "$mulai_tm $slot_8_end";}
				elseif($jml_slot ==9){$waktu_mulai = "$mulai_tm $slot_9_start";$waktu_selesai = "$mulai_tm $slot_9_end";}
				elseif($jml_slot ==10){$waktu_mulai = "$mulai_tm $slot_10_start";$waktu_selesai = "$mulai_tm $slot_10_end";}
				elseif($jml_slot ==11){$waktu_mulai = "$mulai_tm $slot_11_start";$waktu_selesai = "$mulai_tm $slot_11_end";}
				elseif($jml_slot ==12){$waktu_mulai = "$mulai_tm $slot_12_start";$waktu_selesai = "$mulai_tm $slot_12_end";}
				elseif($jml_slot ==13){$waktu_mulai = "$mulai_tm $slot_13_start";$waktu_selesai = "$mulai_tm $slot_13_end";}
					$i = 1;
					$query_slot_teacher ="SELECT nm_teacher, mulai_tm, selesai_tm,room,center,kelas,date_format(mulai_tm,'%d %m %y'),date_format(mulai_tm,'%H:%i %p'), date_format(selesai_tm,'%H:%i %p'),status_kelas  FROM emp_time_work a left join  ves_data.vip_teacher_schedule b on kd_emp = nm_teacher and a.tanggal = ? and a.status= 1  WHERE (status_kelas <> 0 and status_kelas <> 52 and status_kelas <> 62 and status_kelas <> 72 and status_kelas <>92 )   and ((mulai_tm >= ? AND mulai_tm <= ?) OR
					(selesai_tm >= ? AND selesai_tm <= ?)) and (status_kelas <> 0 and status_kelas <> 52 and status_kelas <> 62 and status_kelas <> 72 and status_kelas <>92 ) order by nm_teacher ";	
					$u= 0;
					$resource_slot_teacher= db_query($query_slot_teacher, [$mulai_tm, $waktu_mulai, $waktu_selesai, $waktu_mulai, $waktu_selesai]);
					if($resource_slot_teacher->rowCount() > 0)
						{
						while ($row_kd_teacher=  $resource_slot_teacher->fetch(PDO::FETCH_NUM))
							{
							$kdt = e($row_kd_teacher[0]);
							$stcl= $row_kd_teacher[9];
							if($stcl ==1){$kdt = " <spant> $kdt </spant> ";}	elseif($stcl ==70 or $stcl ==71 or $stcl ==75   ){$kdt = " <lc> $kdt </lc> ";}
							if($jml_slot ==1){$day_3_1 = "$day_3_1 $kdt";}	
							elseif($jml_slot ==2){$day_3_2 = "$day_3_2  $kdt";}	
							elseif($jml_slot ==3){$day_3_3 = "$day_3_3  $kdt";}	
							elseif($jml_slot ==4){$day_3_4 = "$day_3_4  $kdt";}	
							elseif($jml_slot ==5){$day_3_5 = "$day_3_5  $kdt";}	
							elseif($jml_slot ==6){$day_3_6 = "$day_3_6  $kdt";}	
							elseif($jml_slot ==7){$day_3_7 = "$day_3_7  $kdt";}	
							elseif($jml_slot ==8){$day_3_8 = "$day_3_8  $kdt";}	
							elseif($jml_slot ==9){$day_3_9 = "$day_3_9  $kdt";}	
							elseif($jml_slot ==10){$day_3_10 = "$day_3_10  $kdt";}	
							elseif($jml_slot ==11){$day_3_11 = "$day_3_11  $kdt";}	
							elseif($jml_slot ==12){$day_3_12 = "$day_3_12  $kdt";}	
							elseif($jml_slot ==13){$day_3_13 = "$day_3_13  $kdt";}

							}
						
						}

						$query_free_teacher ="SELECT a.nm_emp, a.kd_emp,a.kerja_mulai,status_kelas,b.mulai_tm FROM emp_time_work a  left join vip_teacher_schedule  b on a.kd_emp = b.nm_teacher and a.tanggal = date_format(mulai_tm,'%Y-%m-%d')   and ((mulai_tm >= ? AND mulai_tm <= ?) OR (selesai_tm >= ? AND selesai_tm <= ?))
						where date_format(a.kerja_mulai, '%Y-%m-%d') = ? and  (status_kelas is null or status_kelas = 0 or status_kelas = 52 or status_kelas = 62 or status_kelas = 72 or status_kelas = 92 )";	

						$resource_free_teacher= db_query($query_free_teacher, [$waktu_mulai, $waktu_selesai, $waktu_mulai, $waktu_selesai, "$mulai_tm "]);
						if($resource_free_teacher->rowCount() > 0)
							{
							while ($row_free_teacher=  $resource_free_teacher->fetch(PDO::FETCH_NUM))
								{
							$kdft = e($row_free_teacher[1]);						
						
							if($jml_slot ==1)   {$day_3_1_a = "$day_3_1_a  $kdft";$bg_1_1 = "bgcolor='#95F9A4'";}	
							elseif($jml_slot ==2){$day_3_2_a = "$day_3_2_a  $kdft";$bg_1_2 = "bgcolor='#95F9A4'";}	
							elseif($jml_slot ==3){$day_3_3_a = "$day_3_3_a  $kdft";$bg_1_3 = "bgcolor='#95F9A4'";}	
							elseif($jml_slot ==4){$day_3_4_a = "$day_3_4_a  $kdft";$bg_1_4 = "bgcolor='#95F9A4'";}	
							elseif($jml_slot ==5){$day_3_5_a = "$day_3_5_a  $kdft";$bg_1_5 = "bgcolor='#95F9A4'";}	
							elseif($jml_slot ==6){$day_3_6_a = "$day_3_6_a  $kdft";$bg_1_6 = "bgcolor='#95F9A4'";}	
							elseif($jml_slot ==7){$day_3_7_a = "$day_3_7_a  $kdft";$bg_1_7 = "bgcolor='#95F9A4'";}	
							elseif($jml_slot ==8){$day_3_8_a = "$day_3_8_a  $kdft";$bg_1_8 = "bgcolor='#95F9A4'";}	
							elseif($jml_slot ==9){$day_3_9_a = "$day_3_9_a  $kdft";$bg_1_9 = "bgcolor='#95F9A4'";}	
							elseif($jml_slot ==10){$day_3_10_a = "$day_3_10_a  $kdft";$bg_1_10 = "bgcolor='#95F9A4'";}	
							elseif($jml_slot ==11){$day_3_11_a = "$day_3_11_a  $kdft";$bg_1_11 = "bgcolor='#95F9A4'";}	
							elseif($jml_slot ==12){$day_3_12_a = "$day_3_12_a  $kdft";$bg_1_12 = "bgcolor='#95F9A4'";}	
							elseif($jml_slot ==13){$day_3_13_a = "$day_3_13_a  $kdft";$bg_1_13 = "bgcolor='#95F9A4'";}}							
						}
				$jml_slot = $jml_slot+1;				
				}
			}
		elseif($jml_hari ==4) 
			{
			$judul_hari_4 = $judul_hari;$judul_tgl_4 = $judul_tgl;				$judul_tgl_lengkap_4  = date('Y-m-d', strtotime($tgl_awal));
			$query_msk_plg ="SELECT date_format(kerja_mulai,'%T'), date_format(kerja_selesai,'%T') FROM emp_time_work where kd_emp = ? and tanggal = ? and status = 1";	

			$resource_msk_plg= db_query($query_msk_plg, [$nm_teacher, "$mulai_tm "]);
			while ($row_msk_plg=  $resource_msk_plg->fetch(PDO::FETCH_NUM))
				{	
				$jam_masuk = $row_msk_plg[0];
				$jam_pulang = $row_msk_plg[1];
		
				}			
						$jml_slot =1;
			while ($jml_slot <= 13)
				{
				if($jml_slot ==1 ){$waktu_mulai = "$mulai_tm $slot_1_start";$waktu_selesai = "$mulai_tm $slot_1_end";}
				elseif($jml_slot ==2){$waktu_mulai = "$mulai_tm $slot_2_start";$waktu_selesai = "$mulai_tm $slot_2_end";}
				elseif($jml_slot ==3){$waktu_mulai = "$mulai_tm $slot_3_start";$waktu_selesai = "$mulai_tm $slot_3_end";}
				elseif($jml_slot ==4){$waktu_mulai = "$mulai_tm $slot_4_start";$waktu_selesai = "$mulai_tm $slot_4_end";}
				elseif($jml_slot ==5){$waktu_mulai = "$mulai_tm $slot_5_start";$waktu_selesai = "$mulai_tm $slot_5_end";}
				elseif($jml_slot ==6){$waktu_mulai = "$mulai_tm $slot_6_start";$waktu_selesai = "$mulai_tm $slot_6_end";}
				elseif($jml_slot ==7){$waktu_mulai = "$mulai_tm $slot_7_start";$waktu_selesai = "$mulai_tm $slot_7_end";}
				elseif($jml_slot ==8){$waktu_mulai = "$mulai_tm $slot_8_start";$waktu_selesai = "$mulai_tm $slot_8_end";}
				elseif($jml_slot ==9){$waktu_mulai = "$mulai_tm $slot_9_start";$waktu_selesai = "$mulai_tm $slot_9_end";}
				elseif($jml_slot ==10){$waktu_mulai = "$mulai_tm $slot_10_start";$waktu_selesai = "$mulai_tm $slot_10_end";}
				elseif($jml_slot ==11){$waktu_mulai = "$mulai_tm $slot_11_start";$waktu_selesai = "$mulai_tm $slot_11_end";}
				elseif($jml_slot ==12){$waktu_mulai = "$mulai_tm $slot_12_start";$waktu_selesai = "$mulai_tm $slot_12_end";}
				elseif($jml_slot ==13){$waktu_mulai = "$mulai_tm $slot_13_start";$waktu_selesai = "$mulai_tm $slot_13_end";}
					$i = 1;
					$query_slot_teacher ="SELECT nm_teacher, mulai_tm, selesai_tm,room,center,kelas,date_format(mulai_tm,'%d %m %y'),date_format(mulai_tm,'%H:%i %p'), date_format(selesai_tm,'%H:%i %p'),status_kelas  FROM emp_time_work a left join  ves_data.vip_teacher_schedule b on kd_emp = nm_teacher and a.tanggal = ? and a.status= 1  WHERE (status_kelas <> 0 and status_kelas <> 52 and status_kelas <> 62 and status_kelas <> 72 and status_kelas <>92 )   and ((mulai_tm >= ? AND mulai_tm <= ?) OR
					(selesai_tm >= ? AND selesai_tm <= ?)) and (status_kelas <> 0 and status_kelas <> 52 and status_kelas <> 62 and status_kelas <> 72 and status_kelas <>92 ) order by nm_teacher ";	
					$u= 0;
					$resource_slot_teacher= db_query($query_slot_teacher, [$mulai_tm, $waktu_mulai, $waktu_selesai, $waktu_mulai, $waktu_selesai]);
					if($resource_slot_teacher->rowCount() > 0)
						{
						while ($row_kd_teacher=  $resource_slot_teacher->fetch(PDO::FETCH_NUM))
							{
							$kdt = e($row_kd_teacher[0]);
							$stcl= $row_kd_teacher[9];
								if($stcl ==1){$kdt = " <spant> $kdt </spant> ";}	elseif($stcl ==70 or $stcl ==71 or $stcl ==75   ){$kdt = " <lc> $kdt </lc> ";}
							if($jml_slot ==1){$day_4_1 = "$day_4_1 $kdt";}	
							elseif($jml_slot ==2){$day_4_2 = "$day_4_2  $kdt";}	
							elseif($jml_slot ==3){$day_4_3 = "$day_4_3  $kdt";}	
							elseif($jml_slot ==4){$day_4_4 = "$day_4_4  $kdt";}	
							elseif($jml_slot ==5){$day_4_5 = "$day_4_5  $kdt";}	
							elseif($jml_slot ==6){$day_4_6 = "$day_4_6  $kdt";}	
							elseif($jml_slot ==7){$day_4_7 = "$day_4_7  $kdt";}	
							elseif($jml_slot ==8){$day_4_8 = "$day_4_8  $kdt";}	
							elseif($jml_slot ==9){$day_4_9 = "$day_4_9  $kdt";}	
							elseif($jml_slot ==10){$day_4_10 = "$day_4_10  $kdt";}	
							elseif($jml_slot ==11){$day_4_11 = "$day_4_11  $kdt";}	
							elseif($jml_slot ==12){$day_4_12 = "$day_4_12  $kdt";}	
							elseif($jml_slot ==13){$day_4_13 = "$day_4_13  $kdt";}

							}
						
						}

						$query_free_teacher ="SELECT a.nm_emp, a.kd_emp,a.kerja_mulai,status_kelas,b.mulai_tm FROM emp_time_work a  left join vip_teacher_schedule  b on a.kd_emp = b.nm_teacher and a.tanggal = date_format(mulai_tm,'%Y-%m-%d')   and ((mulai_tm >= ? AND mulai_tm <= ?) OR (selesai_tm >= ? AND selesai_tm <= ?))
						where date_format(a.kerja_mulai, '%Y-%m-%d') = ? and  (status_kelas is null or status_kelas = 0 or status_kelas = 52 or status_kelas = 62 or status_kelas = 72 or status_kelas = 92 )";	

						$resource_free_teacher= db_query($query_free_teacher, [$waktu_mulai, $waktu_selesai, $waktu_mulai, $waktu_selesai, "$mulai_tm "]);
						if($resource_free_teacher->rowCount() > 0)
							{
							while ($row_free_teacher=  $resource_free_teacher->fetch(PDO::FETCH_NUM))
								{
							$kdft = e($row_free_teacher[1]);						
						
							if($jml_slot ==1)   {$day_4_1_a = "$day_4_1_a  $kdft";$bg_1_1 = "bgcolor='#95F9A4'";}	
							elseif($jml_slot ==2){$day_4_2_a = "$day_4_2_a  $kdft";$bg_1_2 = "bgcolor='#95F9A4'";}	
							elseif($jml_slot ==3){$day_4_3_a = "$day_4_3_a  $kdft";$bg_1_3 = "bgcolor='#95F9A4'";}	
							elseif($jml_slot ==4){$day_4_4_a = "$day_4_4_a  $kdft";$bg_1_4 = "bgcolor='#95F9A4'";}	
							elseif($jml_slot ==5){$day_4_5_a = "$day_4_5_a  $kdft";$bg_1_5 = "bgcolor='#95F9A4'";}	
							elseif($jml_slot ==6){$day_4_6_a = "$day_4_6_a  $kdft";$bg_1_6 = "bgcolor='#95F9A4'";}	
							elseif($jml_slot ==7){$day_4_7_a = "$day_4_7_a  $kdft";$bg_1_7 = "bgcolor='#95F9A4'";}	
							elseif($jml_slot ==8){$day_4_8_a = "$day_4_8_a  $kdft";$bg_1_8 = "bgcolor='#95F9A4'";}	
							elseif($jml_slot ==9){$day_4_9_a = "$day_4_9_a  $kdft";$bg_1_9 = "bgcolor='#95F9A4'";}	
							elseif($jml_slot ==10){$day_4_10_a = "$day_4_10_a  $kdft";$bg_1_10 = "bgcolor='#95F9A4'";}	
							elseif($jml_slot ==11){$day_4_11_a = "$day_4_11_a  $kdft";$bg_1_11 = "bgcolor='#95F9A4'";}	
							elseif($jml_slot ==12){$day_4_12_a = "$day_4_12_a  $kdft";$bg_1_12 = "bgcolor='#95F9A4'";}	
							elseif($jml_slot ==13){$day_4_13_a = "$day_4_13_a  $kdft";$bg_1_13 = "bgcolor='#95F9A4'";}}							
						}
				$jml_slot = $jml_slot+1;				
				}
			}
		elseif($jml_hari ==5) 
			{
			$judul_hari_5 = $judul_hari;$judul_tgl_5 = $judul_tgl;				$judul_tgl_lengkap_5  = date('Y-m-d', strtotime($tgl_awal));
			$query_msk_plg ="SELECT date_format(kerja_mulai,'%T'), date_format(kerja_selesai,'%T') FROM emp_time_work where kd_emp = ? and tanggal = ? and status = 1";	

			$resource_msk_plg= db_query($query_msk_plg, [$nm_teacher, "$mulai_tm "]);
			while ($row_msk_plg=  $resource_msk_plg->fetch(PDO::FETCH_NUM))
				{	
				$jam_masuk = $row_msk_plg[0];
				$jam_pulang = $row_msk_plg[1];
		
				}			
				$jml_slot =1;
			while ($jml_slot <= 13)
				{
				if($jml_slot ==1 ){$waktu_mulai = "$mulai_tm $slot_1_start";$waktu_selesai = "$mulai_tm $slot_1_end";}
				elseif($jml_slot ==2){$waktu_mulai = "$mulai_tm $slot_2_start";$waktu_selesai = "$mulai_tm $slot_2_end";}
				elseif($jml_slot ==3){$waktu_mulai = "$mulai_tm $slot_3_start";$waktu_selesai = "$mulai_tm $slot_3_end";}
				elseif($jml_slot ==4){$waktu_mulai = "$mulai_tm $slot_4_start";$waktu_selesai = "$mulai_tm $slot_4_end";}
				elseif($jml_slot ==5){$waktu_mulai = "$mulai_tm $slot_5_start";$waktu_selesai = "$mulai_tm $slot_5_end";}
				elseif($jml_slot ==6){$waktu_mulai = "$mulai_tm $slot_6_start";$waktu_selesai = "$mulai_tm $slot_6_end";}
				elseif($jml_slot ==7){$waktu_mulai = "$mulai_tm $slot_7_start";$waktu_selesai = "$mulai_tm $slot_7_end";}
				elseif($jml_slot ==8){$waktu_mulai = "$mulai_tm $slot_8_start";$waktu_selesai = "$mulai_tm $slot_8_end";}
				elseif($jml_slot ==9){$waktu_mulai = "$mulai_tm $slot_9_start";$waktu_selesai = "$mulai_tm $slot_9_end";}
				elseif($jml_slot ==10){$waktu_mulai = "$mulai_tm $slot_10_start";$waktu_selesai = "$mulai_tm $slot_10_end";}
				elseif($jml_slot ==11){$waktu_mulai = "$mulai_tm $slot_11_start";$waktu_selesai = "$mulai_tm $slot_11_end";}
				elseif($jml_slot ==12){$waktu_mulai = "$mulai_tm $slot_12_start";$waktu_selesai = "$mulai_tm $slot_12_end";}
				elseif($jml_slot ==13){$waktu_mulai = "$mulai_tm $slot_13_start";$waktu_selesai = "$mulai_tm $slot_13_end";}
					$i = 1;
					$query_slot_teacher ="SELECT nm_teacher, mulai_tm, selesai_tm,room,center,kelas,date_format(mulai_tm,'%d %m %y'),date_format(mulai_tm,'%H:%i %p'), date_format(selesai_tm,'%H:%i %p'),status_kelas  FROM emp_time_work a left join  ves_data.vip_teacher_schedule b on kd_emp = nm_teacher and a.tanggal = ? and a.status= 1  WHERE (status_kelas <> 0 and status_kelas <> 52 and status_kelas <> 62 and status_kelas <> 72 and status_kelas <>92 )   and ((mulai_tm >= ? AND mulai_tm <= ?) OR
					(selesai_tm >= ? AND selesai_tm <= ?)) and (status_kelas <> 0 and status_kelas <> 52 and status_kelas <> 62 and status_kelas <> 72 and status_kelas <>92 ) order by nm_teacher ";	
					$u= 0;
					$resource_slot_teacher= db_query($query_slot_teacher, [$mulai_tm, $waktu_mulai, $waktu_selesai, $waktu_mulai, $waktu_selesai]);
					if($resource_slot_teacher->rowCount() > 0)
						{
						while ($row_kd_teacher=  $resource_slot_teacher->fetch(PDO::FETCH_NUM))
							{
							$kdt = e($row_kd_teacher[0]);
							$stcl= $row_kd_teacher[9];
							if($stcl ==1){$kdt = " <spant> $kdt </spant> ";}	elseif($stcl ==70 or $stcl ==71 or $stcl ==75   ){$kdt = " <lc> $kdt </lc> ";}
							if($jml_slot ==1){$day_5_1 = "$day_5_1 $kdt";}	
							elseif($jml_slot ==2){$day_5_2 = "$day_5_2  $kdt";}	
							elseif($jml_slot ==3){$day_5_3 = "$day_5_3  $kdt";}	
							elseif($jml_slot ==4){$day_5_4 = "$day_5_4  $kdt";}	
							elseif($jml_slot ==5){$day_5_5 = "$day_5_5  $kdt";}	
							elseif($jml_slot ==6){$day_5_6 = "$day_5_6  $kdt";}	
							elseif($jml_slot ==7){$day_5_7 = "$day_5_7  $kdt";}	
							elseif($jml_slot ==8){$day_5_8 = "$day_5_8  $kdt";}	
							elseif($jml_slot ==9){$day_5_9 = "$day_5_9  $kdt";}	
							elseif($jml_slot ==10){$day_5_10 = "$day_5_10  $kdt";}	
							elseif($jml_slot ==11){$day_5_11 = "$day_5_11  $kdt";}	
							elseif($jml_slot ==12){$day_5_12 = "$day_5_12  $kdt";}	
							elseif($jml_slot ==13){$day_5_13 = "$day_5_13  $kdt";}

							}
						
						}

						$query_free_teacher ="SELECT a.nm_emp, a.kd_emp,a.kerja_mulai,status_kelas,b.mulai_tm FROM emp_time_work a  left join vip_teacher_schedule  b on a.kd_emp = b.nm_teacher and a.tanggal = date_format(mulai_tm,'%Y-%m-%d')   and ((mulai_tm >= ? AND mulai_tm <= ?) OR (selesai_tm >= ? AND selesai_tm <= ?))
						where date_format(a.kerja_mulai, '%Y-%m-%d') = ? and  (status_kelas is null or status_kelas = 0 or status_kelas = 52 or status_kelas = 62 or status_kelas = 72 or status_kelas = 92 )";	

						$resource_free_teacher= db_query($query_free_teacher, [$waktu_mulai, $waktu_selesai, $waktu_mulai, $waktu_selesai, "$mulai_tm "]);
						if($resource_free_teacher->rowCount() > 0)
							{
							while ($row_free_teacher=  $resource_free_teacher->fetch(PDO::FETCH_NUM))
								{
							$kdft = e($row_free_teacher[1]);						
						
							if($jml_slot ==1)   {$day_5_1_a = "$day_5_1_a  $kdft";$bg_1_1 = "bgcolor='#95F9A4'";}	
							elseif($jml_slot ==2){$day_5_2_a = "$day_5_2_a  $kdft";$bg_1_2 = "bgcolor='#95F9A4'";}	
							elseif($jml_slot ==3){$day_5_3_a = "$day_5_3_a  $kdft";$bg_1_3 = "bgcolor='#95F9A4'";}	
							elseif($jml_slot ==4){$day_5_4_a = "$day_5_4_a  $kdft";$bg_1_4 = "bgcolor='#95F9A4'";}	
							elseif($jml_slot ==5){$day_5_5_a = "$day_5_5_a  $kdft";$bg_1_5 = "bgcolor='#95F9A4'";}	
							elseif($jml_slot ==6){$day_5_6_a = "$day_5_6_a  $kdft";$bg_1_6 = "bgcolor='#95F9A4'";}	
							elseif($jml_slot ==7){$day_5_7_a = "$day_5_7_a  $kdft";$bg_1_7 = "bgcolor='#95F9A4'";}	
							elseif($jml_slot ==8){$day_5_8_a = "$day_5_8_a  $kdft";$bg_1_8 = "bgcolor='#95F9A4'";}	
							elseif($jml_slot ==9){$day_5_9_a = "$day_5_9_a  $kdft";$bg_1_9 = "bgcolor='#95F9A4'";}	
							elseif($jml_slot ==10){$day_5_10_a = "$day_5_10_a  $kdft";$bg_1_10 = "bgcolor='#95F9A4'";}	
							elseif($jml_slot ==11){$day_5_11_a = "$day_5_11_a  $kdft";$bg_1_11 = "bgcolor='#95F9A4'";}	
							elseif($jml_slot ==12){$day_5_12_a = "$day_5_12_a  $kdft";$bg_1_12 = "bgcolor='#95F9A4'";}	
							elseif($jml_slot ==13){$day_5_13_a = "$day_5_13_a  $kdft";$bg_1_13 = "bgcolor='#95F9A4'";}}							
						}
				$jml_slot = $jml_slot+1;				
				}
			}
		elseif($jml_hari ==6) 
			{
			$judul_hari_6 = $judul_hari;$judul_tgl_6 = $judul_tgl;				$judul_tgl_lengkap_6  = date('Y-m-d', strtotime($tgl_awal));
			$query_msk_plg ="SELECT date_format(kerja_mulai,'%T'), date_format(kerja_selesai,'%T') FROM emp_time_work where kd_emp = ? and tanggal = ? and status = 1";	

			$resource_msk_plg= db_query($query_msk_plg, [$nm_teacher, "$mulai_tm "]);
			while ($row_msk_plg=  $resource_msk_plg->fetch(PDO::FETCH_NUM))
				{	
				$jam_masuk = $row_msk_plg[0];
				$jam_pulang = $row_msk_plg[1];
		
				}			
$jml_slot =1;
			while ($jml_slot <= 13)
				{
				if($jml_slot ==1 ){$waktu_mulai = "$mulai_tm $slot_1_start";$waktu_selesai = "$mulai_tm $slot_1_end";}
				elseif($jml_slot ==2){$waktu_mulai = "$mulai_tm $slot_2_start";$waktu_selesai = "$mulai_tm $slot_2_end";}
				elseif($jml_slot ==3){$waktu_mulai = "$mulai_tm $slot_3_start";$waktu_selesai = "$mulai_tm $slot_3_end";}
				elseif($jml_slot ==4){$waktu_mulai = "$mulai_tm $slot_4_start";$waktu_selesai = "$mulai_tm $slot_4_end";}
				elseif($jml_slot ==5){$waktu_mulai = "$mulai_tm $slot_5_start";$waktu_selesai = "$mulai_tm $slot_5_end";}
				elseif($jml_slot ==6){$waktu_mulai = "$mulai_tm $slot_6_start";$waktu_selesai = "$mulai_tm $slot_6_end";}
				elseif($jml_slot ==7){$waktu_mulai = "$mulai_tm $slot_7_start";$waktu_selesai = "$mulai_tm $slot_7_end";}
				elseif($jml_slot ==8){$waktu_mulai = "$mulai_tm $slot_8_start";$waktu_selesai = "$mulai_tm $slot_8_end";}
				elseif($jml_slot ==9){$waktu_mulai = "$mulai_tm $slot_9_start";$waktu_selesai = "$mulai_tm $slot_9_end";}
				elseif($jml_slot ==10){$waktu_mulai = "$mulai_tm $slot_10_start";$waktu_selesai = "$mulai_tm $slot_10_end";}
				elseif($jml_slot ==11){$waktu_mulai = "$mulai_tm $slot_11_start";$waktu_selesai = "$mulai_tm $slot_11_end";}
				elseif($jml_slot ==12){$waktu_mulai = "$mulai_tm $slot_12_start";$waktu_selesai = "$mulai_tm $slot_12_end";}
				elseif($jml_slot ==13){$waktu_mulai = "$mulai_tm $slot_13_start";$waktu_selesai = "$mulai_tm $slot_13_end";}
					$i = 1;
					$query_slot_teacher ="SELECT nm_teacher, mulai_tm, selesai_tm,room,center,kelas,date_format(mulai_tm,'%d %m %y'),date_format(mulai_tm,'%H:%i %p'), date_format(selesai_tm,'%H:%i %p'),status_kelas  FROM emp_time_work a left join  ves_data.vip_teacher_schedule b on kd_emp = nm_teacher and a.tanggal = ? and a.status= 1  WHERE (status_kelas <> 0 and status_kelas <> 52 and status_kelas <> 62 and status_kelas <> 72 and status_kelas <>92 )   and ((mulai_tm >= ? AND mulai_tm <= ?) OR
					(selesai_tm >= ? AND selesai_tm <= ?)) and (status_kelas <> 0 and status_kelas <> 52 and status_kelas <> 62 and status_kelas <> 72 and status_kelas <>92 ) order by nm_teacher ";	
					$u= 0;
					$resource_slot_teacher= db_query($query_slot_teacher, [$mulai_tm, $waktu_mulai, $waktu_selesai, $waktu_mulai, $waktu_selesai]);
					if($resource_slot_teacher->rowCount() > 0)
						{
						while ($row_kd_teacher=  $resource_slot_teacher->fetch(PDO::FETCH_NUM))
							{
							$kdt = e($row_kd_teacher[0]);
							$stcl= $row_kd_teacher[9];
							if($stcl ==1){$kdt = " <spant> $kdt </spant> ";}	elseif($stcl ==70 or $stcl ==71 or $stcl ==75   ){$kdt = " <lc> $kdt </lc> ";}
							if($jml_slot ==1){$day_6_1 = "$day_6_1 $kdt";}	
							elseif($jml_slot ==2){$day_6_2 = "$day_6_2  $kdt";}	
							elseif($jml_slot ==3){$day_6_3 = "$day_6_3  $kdt";}	
							elseif($jml_slot ==4){$day_6_4 = "$day_6_4  $kdt";}	
							elseif($jml_slot ==5){$day_6_5 = "$day_6_5  $kdt";}	
							elseif($jml_slot ==6){$day_6_6 = "$day_6_6  $kdt";}	
							elseif($jml_slot ==7){$day_6_7 = "$day_6_7  $kdt";}	
							elseif($jml_slot ==8){$day_6_8 = "$day_6_8  $kdt";}	
							elseif($jml_slot ==9){$day_6_9 = "$day_6_9  $kdt";}	
							elseif($jml_slot ==10){$day_6_10 = "$day_6_10  $kdt";}	
							elseif($jml_slot ==11){$day_6_11 = "$day_6_11  $kdt";}	
							elseif($jml_slot ==12){$day_6_12 = "$day_6_12  $kdt";}	
							elseif($jml_slot ==13){$day_6_13 = "$day_6_13  $kdt";}

							}
						
						}

						$query_free_teacher ="SELECT a.nm_emp, a.kd_emp,a.kerja_mulai,status_kelas,b.mulai_tm FROM emp_time_work a  left join vip_teacher_schedule  b on a.kd_emp = b.nm_teacher and a.tanggal = date_format(mulai_tm,'%Y-%m-%d')   and ((mulai_tm >= ? AND mulai_tm <= ?) OR (selesai_tm >= ? AND selesai_tm <= ?))
						where date_format(a.kerja_mulai, '%Y-%m-%d') = ? and  (status_kelas is null or status_kelas = 0 or status_kelas = 52 or status_kelas = 62 or status_kelas = 72 or status_kelas = 92 )";	

						$resource_free_teacher= db_query($query_free_teacher, [$waktu_mulai, $waktu_selesai, $waktu_mulai, $waktu_selesai, "$mulai_tm "]);
						if($resource_free_teacher->rowCount() > 0)
							{
							while ($row_free_teacher=  $resource_free_teacher->fetch(PDO::FETCH_NUM))

								{
							$kdft = e($row_free_teacher[1]);						
						
							if($jml_slot ==1)   {$day_6_1_a = "$day_6_1_a  $kdft";$bg_1_1 = "bgcolor='#95F9A4'";}	
							elseif($jml_slot ==2){$day_6_2_a = "$day_6_2_a  $kdft";$bg_1_2 = "bgcolor='#95F9A4'";}	
							elseif($jml_slot ==3){$day_6_3_a = "$day_6_3_a  $kdft";$bg_1_3 = "bgcolor='#95F9A4'";}	
							elseif($jml_slot ==4){$day_6_4_a = "$day_6_4_a  $kdft";$bg_1_4 = "bgcolor='#95F9A4'";}	
							elseif($jml_slot ==5){$day_6_5_a = "$day_6_5_a  $kdft";$bg_1_5 = "bgcolor='#95F9A4'";}	
							elseif($jml_slot ==6){$day_6_6_a = "$day_6_6_a  $kdft";$bg_1_6 = "bgcolor='#95F9A4'";}	
							elseif($jml_slot ==7){$day_6_7_a = "$day_6_7_a  $kdft";$bg_1_7 = "bgcolor='#95F9A4'";}	
							elseif($jml_slot ==8){$day_6_8_a = "$day_6_8_a  $kdft";$bg_1_8 = "bgcolor='#95F9A4'";}	
							elseif($jml_slot ==9){$day_6_9_a = "$day_6_9_a  $kdft";$bg_1_9 = "bgcolor='#95F9A4'";}	
							elseif($jml_slot ==10){$day_6_10_a = "$day_6_10_a  $kdft";$bg_1_10 = "bgcolor='#95F9A4'";}	
							elseif($jml_slot ==11){$day_6_11_a = "$day_6_11_a  $kdft";$bg_1_11 = "bgcolor='#95F9A4'";}	
							elseif($jml_slot ==12){$day_6_12_a = "$day_6_12_a  $kdft";$bg_1_12 = "bgcolor='#95F9A4'";}	
							elseif($jml_slot ==13){$day_6_13_a = "$day_6_13_a  $kdft";$bg_1_13 = "bgcolor='#95F9A4'";}}							
						}
				$jml_slot = $jml_slot+1;				
				}			
			}
		

		}
	$tgl_awal = date ("Y-m-d", strtotime("+1 day", strtotime($tgl_awal)));		if ($no_hari != 0)	
		{$jml_hari = $jml_hari+1;	}
	}

}
//$result_cek_teacher=mysql_query($query_cek_teacher) or die("Wah error nih1");
//if($result_cek_teacher->rowCount() > 0)
//	{
//	while ($row_cek=  $result_cek_teacher->fetch(PDO::FETCH_NUM))
//	/	{	
//	}
//}
//==selesai		
?>		
<table width="100%" class="table table-borderless table" id="example2">
  <tbody>


    <tr bgcolor="#12BCE7">
      <td width="2%" height="14" align=center class="style24"><strong>No</strong></td>
      <td height="14" align=center class="style24"><strong>Day/Date<br>
        Time Slot</strong></td>
      <td align=center class="style24"><?php echo e($judul_tgl_1) ?><strong><br>
        <?php echo e($judul_hari_1) ?></strong></td>
      <td align=center class="style24"><?php echo e($judul_tgl_2) ?><strong><br>
        <?php echo e($judul_hari_2) ?></strong></td>
      <td align=center class="style24"><?php echo e($judul_tgl_3) ?><strong><br>
        <?php echo e($judul_hari_3) ?></strong></td>
      <td align=center class="style24"><?php echo e($judul_tgl_4) ?><strong><br>
        <?php echo e($judul_hari_4) ?></strong></td>
      <td align=center class="style24"><?php echo e($judul_tgl_5) ?><strong><br>
        <?php echo e($judul_hari_5) ?></strong></td>
      <td align=center class="style24"><?php echo e($judul_tgl_6) ?><strong><br>
        <?php echo e($judul_hari_6) ?></strong></td>
      </tr>
    <tr>
   
      <td height="14" align=center class="style24"><strong>1</strong></td>
      <td width="9%" height="14" align=center class="style24"><strong>08:00 - 09:00</strong></td>
      <td width="12%"  align=center class="style24"><strong><?php echo  $day_1_1;  ?><br>
       <spann> <?php echo  $day_1_1_a;  ?> </spann>      </strong></td>
      <td width="12%" align=center class="style24"><strong><?php echo  $day_2_1;  ?><br>
       <spann><?php echo  $day_2_1_a;  ?> </spann>      </strong></td>
      <td width="12%" align=center class="style24"><strong><?php echo  $day_3_1;  ?><br>
       <spann><?php echo  $day_3_1_a;  ?> </spann>     </strong></td>
      <td width="12%"   align=center class="style24"><strong><?php echo  $day_4_1;  ?><br>
       <spann><?php echo  $day_4_1_a;  ?> </spann>       </strong></td>
      <td width="12%"   align=center class="style24"><strong><?php echo  $day_5_1;  ?><br>
       <spann><?php echo  $day_5_1_a;  ?> </spann>       </strong></td>
      <td width="12%" align=center class="style24"><strong><?php echo  $day_6_1;  ?><br>
       <spann><?php echo  $day_6_1_a;  ?> </spann>       </strong></td>
      </tr>
    <tr>
      <td height="14" align=center class="style24"><strong>2</strong></td>
      <td height="14" align=center class="style24"><strong>09:00 - 10:00</strong></td>
      <td align=center  class="style24"><strong><?php echo  $day_1_2;  ?><br>
        <spann> <?php echo  $day_1_2_a;  ?> </spann>        <br>
      </strong></td>
      <td align=center class="style24"><strong><?php echo  $day_2_2;  ?><br>
           <spann><?php echo  $day_2_2_a;  ?> </spann>         <br>
      </strong></td>
      <td align=center   class="style24"><strong><?php echo  $day_3_2;  ?><br>
        <spann><?php echo  $day_3_2_a;  ?> </spann>       </strong></td>
      <td align=center   class="style24"><strong><?php echo  $day_4_2;  ?><br>
        <spann><?php echo  $day_4_2_a;  ?> </spann>       </strong></td>
      <td align=center   class="style24"><strong><?php echo  $day_5_2;  ?><br>
        <spann><?php echo  $day_5_2_a;  ?> </spann>       </strong></td>
      <td align=center  class="style24"><strong><?php echo  $day_6_2;  ?><br>
        <spann><?php echo  $day_6_2_a;  ?> </spann>       </strong></td>
      </tr>
    <tr>
      <td height="14" align=center class="style24"><strong>3</strong></td>
      <td height="14" align=center class="style24"><strong>10:00 - 11:00</strong></td>
      <td align=center   class="style24"><strong><spant><?php echo  $day_1_3;  ?></spant><br>
         <spann> <?php echo  $day_1_3_a;  ?> </spann>     </strong></td>
      <td align=center    class="style24"><strong><?php echo  $day_2_3;  ?><br>
           <spann><?php echo  $day_2_3_a;  ?> </spann>      </strong></td>
      <td align=center    class="style24"><strong><?php echo  $day_3_3;  ?><br>
           <spann><?php echo  $day_3_3_a;  ?> </spann>      </strong></td>
      <td align=center    class="style24"><strong><?php echo  $day_4_3;  ?><br>
           <spann><?php echo  $day_4_3_a;  ?> </spann>      </strong></td>
      <td align=center    class="style24"><strong><?php echo  $day_5_3;  ?><br>
           <spann><?php echo  $day_5_3_a;  ?> </spann>      </strong></td>
      <td align=center   class="style24"><strong><?php echo  $day_6_3;  ?><br>
           <spann><?php echo  $day_6_3_a;  ?> </spann>      </strong></td>
      </tr>
    <tr>
      <td height="14" align=center class="style24"><strong>4</strong></td>
      <td height="14" align=center class="style24"><strong>11:00 - 12:00</strong></td>
      <td align=center  class="style24"><strong><?php echo  $day_1_4;  ?><br>
        <spann> <?php echo  $day_1_4_a;  ?> </spann>      <br>
      </strong></td>
      <td align=center   class="style24"><strong><?php echo  $day_2_4;  ?><br>
            <spann><?php echo  $day_2_4_a;  ?> </spann>      </strong></td>
      <td align=center    class="style24"><strong><?php echo  $day_3_4;  ?><br>
        <spann> <?php echo  $day_3_4_a;  ?> </spann>     </strong>  </td>
      <td align=center      class="style24"><strong><?php echo  $day_4_4;  ?><br>
        <spann> <?php echo  $day_4_4_a;  ?> </spann>    </strong>     </td>
      <td align=center  class="style24"><strong><?php echo  $day_5_4;  ?><br>
        <spann> <?php echo  $day_5_4_a;  ?> </spann>   </strong>      </td>
      <td align=center  class="style24"><strong><?php echo  $day_6_4;  ?><br>
        <spann> <?php echo  $day_6_4_a;  ?> </spann>   </strong>      </td>
      </tr>  
    <tr>
      <td height="14" align=center class="style24"><strong>5</strong></td>
      <td height="14" align=center class="style24"><strong>12:00 - 13:00</strong></td>
      <td align=center   class="style24"><strong><?php echo  $day_1_5;  ?><br>
        <spann> <?php echo  $day_1_5_a;  ?> </spann>     </strong></td>
      <td align=center       class="style24"><strong><?php echo  $day_2_5;  ?><br>
           <spann><?php echo  $day_2_5_a;  ?> </spann>       </strong></td>
      <td align=center       class="style24"><strong><?php echo  $day_3_5;  ?><br>
        <spann>  <?php echo  $day_3_5_a;  ?> </spann>     </strong></td>
      <td align=center       class="style24"><strong><?php echo  $day_4_5;  ?><br>
         <spann> <?php echo  $day_4_5_a;  ?> </spann>     </strong></td>
      <td align=center       class="style24"><strong><?php echo  $day_5_5;  ?><br>
        <spann>  <?php echo  $day_5_5_a;  ?> </spann>     </strong></td>
      <td align=center       class="style24"><strong><?php echo  $day_6_5;  ?><br>
         <spann> <?php echo  $day_6_5_a;  ?> </spann>     </strong></td>
      </tr> 
    <tr>
      <td height="14" align=center class="style24"><strong>6</strong></td>
      <td height="14" align=center class="style24"><strong>13:00 - 14:00</strong></td>
      <td align=center     class="style24"><strong><?php echo  $day_1_6;  ?><br>
        <spann> <?php echo  $day_1_6_a;  ?> </spann>      </strong></td>
      <td align=center  class="style24"><strong><?php echo  $day_2_6;  ?><br>
            <spann><?php echo  $day_2_6_a;  ?> </spann>       </strong></td>
      <td align=center  class="style24"><strong><?php echo  $day_3_6;  ?><br>
        <spann><?php echo  $day_3_6_a;  ?> </spann>     </strong></td>
      <td align=center  class="style24"><strong><?php echo  $day_4_6;  ?><br>
        <spann><?php echo  $day_4_6_a;  ?> </spann>      </strong></td>
      <td align=center  class="style24"><strong><?php echo  $day_5_6;  ?><br>
        <spann><?php echo  $day_5_6_a;  ?> </spann>      </strong></td>
      <td align=center  class="style24"><strong><?php echo  $day_6_6;  ?><br>
        <spann><?php echo  $day_6_6_a;  ?> </spann>     </strong></td>
      </tr> 
    <tr>
      <td height="14" align=center class="style24"><strong>7</strong></td>
      <td height="14" align=center class="style24"><strong>14:00 - 15:00</strong></td>
      <td align=center      class="style24"><strong><?php echo  $day_1_7;  ?><br>
         <spann> <?php echo  $day_1_7_a;  ?> </spann>   </strong></td>
      <td align=center class="style24"><strong><?php echo  $day_2_7;  ?><br>
        <spann><?php echo  $day_2_7_a;  ?></spann>     </strong></td>
      <td align=center class="style24"><strong><?php echo  $day_3_7;  ?><br>
         <spann><?php echo  $day_3_7_a;  ?></spann>     </strong></td>
      <td align=center      class="style24"><strong><?php echo  $day_4_7;  ?><br>
         <spann><?php echo  $day_4_7_a;  ?></spann>     </strong></td>
      <td align=center      class="style24"><strong><?php echo  $day_5_7;  ?><br>
         <spann><?php echo  $day_5_7_a;  ?></spann>     </strong></td>
      <td align=center      class="style24"><strong><?php echo  $day_6_7;  ?><br>
         <spann><?php echo  $day_6_7_a;  ?></spann>     </strong></td>
      </tr> 
    <tr>
      <td height="14" align=center class="style24"><strong>8</strong></td>
      <td height="14" align=center class="style24"><strong>15:00 - 16:00</strong></td>
      <td align=center     class="style24"><strong><?php echo  $day_1_8;  ?><br>
         <spann> <?php echo  $day_1_8_a;  ?> </spann>     </strong></td>
      <td align=center class="style24"><strong><?php echo  $day_2_8;  ?><br>
       <spann><?php echo  $day_2_8_a;  ?> </spann>     </strong></td>
      <td align=center       class="style24"><strong><?php echo  $day_3_8;  ?><br>
       <spann><?php echo  $day_3_8_a;  ?> </spann>     </strong></td>
      <td align=center class="style24"><strong><?php echo  $day_4_8;  ?><br>
       <spann><?php echo  $day_4_8_a;  ?> </spann>     </strong></td>
      <td align=center class="style24"><strong><?php echo  $day_5_8;  ?><br>
       <spann><?php echo  $day_5_8_a;  ?> </spann>     </strong></td>
      <td align=center class="style24"><strong><?php echo  $day_6_8;  ?><br>
       <spann><?php echo  $day_6_8_a;  ?> </spann>     </strong></td>
      </tr> 
    <tr>
      <td height="14" align=center class="style24"><strong>9</strong></td>
      <td height="14" align=center class="style24"><strong>16:00 - 17:00</strong></td>
      <td align=center       class="style24"><strong><?php echo  $day_1_9;  ?><br>
        <spann> <?php echo  $day_1_9_a;  ?> </spann>     </strong></td>
      <td align=center class="style24"><strong><?php echo  $day_2_9;  ?><br>
        <spann><?php echo  $day_2_9_a;  ?>  </spann>     </strong></td>
      <td align=center class="style24"><strong><?php echo  $day_3_9;  ?><br>
        <spann><?php echo  $day_3_9_a;  ?>  </spann>     </strong></td>
      <td align=center    class="style24"><strong><?php echo  $day_4_9;  ?><br>
        <spann><?php echo  $day_4_9_a;  ?>  </spann>     </strong></td>
      <td align=center    class="style24"><strong><?php echo  $day_5_9;  ?><br>
        <spann><?php echo  $day_5_9_a;  ?>  </spann>     </strong></td>
      <td align=center    class="style24"><strong><?php echo  $day_6_9;  ?><br>
        <spann><?php echo  $day_6_9_a;  ?>  </spann>     </strong></td>
      </tr> 
    <tr>
      <td height="14" align=center class="style24"><strong>10</strong></td>
      <td height="14" align=center class="style24"><strong>17:00 - 18:00</strong></td>
      <td align=center    class="style24"><strong><?php echo  $day_1_10;  ?><br>
       <spann> <?php echo  $day_1_10_a;  ?> </spann>    </strong></td>
      <td align=center    class="style24"><strong><?php echo  $day_2_10;  ?><br>
        <spann><?php echo  $day_2_10_a;  ?></spann>      </strong></td>
      <td align=center class="style24"><strong><?php echo  $day_3_10;  ?><br>
       <spann> <?php echo  $day_3_10_a;  ?> </spann>    </strong></td>
      <td align=center    class="style24"><strong><?php echo  $day_4_10;  ?><br>
       <spann> <?php echo  $day_4_10_a;  ?> </spann>    </strong></td>
      <td align=center class="style24"><strong><?php echo  $day_5_10;  ?><br>
       <spann> <?php echo  $day_5_10_a;  ?> </spann>    </strong></td>
      <td align=center    class="style24"><strong><?php echo  $day_6_10;  ?><br>
       <spann> <?php echo  $day_6_10_a;  ?> </spann>    </strong></td>
      </tr> 
    <tr>
      <td height="14" align=center class="style24"><strong>11</strong></td>
      <td height="14" align=center class="style24"><strong>18:00 - 19:00</strong></td>
      <td align=center   class="style24"><strong><?php echo  $day_1_11;  ?><br>
        <spann> <?php echo  $day_1_11_a;  ?> </spann>   </strong></td>
      <td align=center      class="style24"><strong><?php echo  $day_2_11;  ?><br>
       <spann><?php echo  $day_2_11_a;  ?></spann>       </strong></td>
      <td align=center      class="style24"><strong><?php echo  $day_3_11;  ?><br>
       <spann><?php echo  $day_3_11_a;  ?></spann>       </strong></td>
      <td align=center  class="style24"><strong><?php echo  $day_4_11;  ?><br>
       <spann><?php echo  $day_4_11_a;  ?></spann>       </strong></td>
      <td align=center      class="style24"><strong><?php echo  $day_5_11;  ?><br>
       <spann><?php echo  $day_5_11_a;  ?></spann>       </strong></td>
      <td align=center  class="style24"><strong><?php echo  $day_6_11;  ?><br>
       <spann><?php echo  $day_6_11_a;  ?></spann>       </strong></td>
      </tr> 
    <tr>
      <td height="14" align=center class="style24"><strong>12</strong></td>
      <td height="14" align=center class="style24"><strong>19:00 - 20:00</strong></td>
      <td align=center    class="style24"><strong><?php echo  $day_1_12;  ?><br>
       <spann> <?php echo  $day_1_12_a;  ?> </spann>    </strong></td>
      <td align=center   class="style24"><strong><?php echo  $day_2_12;  ?><br>
      <spann><?php echo  $day_2_12_a;  ?></spann>    </strong></td>
      <td align=center class="style24"><strong><?php echo  $day_3_12;  ?><br>
      <spann><?php echo  $day_3_12_a;  ?></spann>    </strong></td>
      <td align=center class="style24"><strong><?php echo  $day_4_12;  ?><br>
      <spann><?php echo  $day_4_12_a;  ?></spann>    </strong></td>
      <td align=center class="style24"><strong><?php echo  $day_5_12;  ?><br>
      <spann><?php echo  $day_5_12_a;  ?></spann>    </strong></td>
      <td align=center class="style24"><strong><?php echo  $day_6_12;  ?><br>
      <spann><?php echo  $day_6_12_a;  ?></spann>    </strong></td>
      </tr> 
    <tr>
      <td height="14" align=center class="style24"><strong>13</strong></td>
      <td height="14" align=center class="style24"><strong>20:00 - 21:00</strong></td>
      <td align=center   class="style24"><strong><?php echo  $day_1_13;  ?><br>
       <spann> <?php echo  $day_1_13_a;  ?> </spann>   </strong></td>
      <td align=center class="style24"><strong><?php echo  $day_2_13;  ?><br>
		  <spann><?php echo  $day_2_13_a;  ?></spann>      </strong></td>
      <td align=center     class="style24"><strong><?php echo  $day_3_13;  ?><br>
		  <spann><?php echo  $day_3_13_a;  ?></spann>      </strong></td>
      <td align=center  class="style24"><strong><?php echo  $day_4_13;  ?><br>
		  <spann><?php echo  $day_4_13_a;  ?></spann>      </strong></td>
      <td align=center      class="style24"><strong><?php echo  $day_5_13;  ?><br>
		  <spann><?php echo  $day_5_13_a;  ?></spann>      </strong></td>
      <td align=center  class="style24"><strong><?php echo  $day_6_13;  ?><br>
		  <spann><?php echo  $day_6_13_a;  ?></spann>      </strong></td>
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
           <!-- /.box-body -->
 </div>

   <?php } ?>

 </div>					
<!-- jQuery 2.2.3 -->
<script src="plugins/jQuery/jquery-2.2.3.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="cdnjs/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button);
</script>
<!-- Bootstrap 3.3.6 -->
<script src="bootstrap/js/bootstrap.min.js"></script>
<!-- Morris.js charts -->
<script src="cdnjs/raphael-min.js"></script>
<script src="plugins/morris/morris.min.js"></script>
<!-- Sparkline -->
<script src="plugins/sparkline/jquery.sparkline.min.js"></script>
<!-- jvectormap -->
<script src="plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
<script src="plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
<!-- jQuery Knob Chart -->
<script src="plugins/knob/jquery.knob.js"></script>
<!-- daterangepicker -->
<script src="cdnjs/moment.min.js"></script>
<script src="plugins/daterangepicker/daterangepicker.js"></script>
<!-- datepicker -->
<script src="plugins/datepicker/bootstrap-datepicker.js"></script>
<!-- Bootstrap WYSIHTML5 -->
<script src="plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
<!-- Slimscroll -->
<script src="plugins/slimScroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="plugins/fastclick/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/app.min.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="dist/js/pages/dashboard.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
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
</body>
</html>
