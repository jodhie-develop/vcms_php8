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

$nm_teacher = in_str('nm_teacher', 45, 'get');	
$tgl_awal = in_date('tgl_awal', '', 'get');
if ($nm_teacher == '') 
	{

		echo "<script type=\"text/javascript\">\n";
		echo 'window.location = (' . js('vip_teacher_free_all.php?tgl_awal=' . u($tgl_awal)) . ");\n";				
		echo "</script>";	
	exit;
	}
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
$nama_lengkap = $_SESSION['nama_lengkap'];
$usergroup = $_SESSION['usergroup'];
$st_upd = 0;
if ($nama_lengkap == $nm_teacher_tampil)
	{
	$st_upd = 1;
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
<h1>Weekly Teacher's Availabilty </h1>
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
              <option value="">--All--</option>
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
		
	

	  </form>
      <div class="box-body">
             

<br>
<?php
if($tgl_awal != '' and $nm_teacher !='')
{
$nm_teacher_pilih = "  nm_teacher = ? ";
 
	
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

	
	if ($no_hari != 0)	
		{
		$judul_hari  = date('l', strtotime($tgl_awal));
		$judul_tgl  = date('d-m-y', strtotime($tgl_awal));
		$judul_tgl_lengkap  = date('Y-m-d', strtotime($tgl_awal));
		$mulai_tm  = date('Y-m-d', strtotime($tgl_awal));		
		if($jml_hari ==1) 
			{
			$judul_hari_1 = $judul_hari;$judul_tgl_1 = $judul_tgl;				$judul_tgl_lengkap_1  = date('Y-m-d', strtotime($tgl_awal));
			$query_msk_plg ="SELECT date_format(kerja_mulai,'%T'), date_format(kerja_selesai,'%T'),status FROM emp_time_work where kd_emp = ? and tanggal = ? and status = 1";
			$resource_msk_plg= db_query($query_msk_plg, [$nm_teacher, "$mulai_tm "]);
			if($resource_msk_plg->rowCount() > 0)
				{	
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

					$query_slot_teacher ="SELECT nm_teacher,status_kelas,keterangan,kelas FROM ves_data.vip_teacher_schedule WHERE (status_kelas <> 0 and status_kelas <> 52 and status_kelas <> 62 and status_kelas <> 72 and status_kelas <>92 )  and    ".$nm_teacher_pilih.   " and ((mulai_tm >= ? AND mulai_tm <= ?) OR
					(selesai_tm >= ? AND selesai_tm <= ?)) and (status_kelas <> 0 and status_kelas <> 52 and status_kelas <> 62 and status_kelas <> 72 and status_kelas <>92 ) ";	

					$resource_slot_teacher= db_query($query_slot_teacher, [$nm_teacher, $waktu_mulai, $waktu_selesai, $waktu_mulai, $waktu_selesai]);
					if($resource_slot_teacher->rowCount() > 0)
					{
					while ($r_status=  $resource_slot_teacher->fetch(PDO::FETCH_NUM))
						{
						$r_st = $r_status[1];
						$r_ket = e($r_status[2]);	
						$r_kelas = e($r_status[3]);if($r_ket ==''){$_ket = $r_kelas;}
						 if($jml_slot ==1){if($r_st==1  or $r_st==11){ $day_1_1 = $r_kelas  ;$bg_1_1 = "bgcolor='#FFD7D8'";}elseif($r_st==71 or $r_st==75  or $r_st==70){$day_1_1  = "LC Visit";$bg_1_1 = "bgcolor='#C7DDFF'";}elseif($r_st==51 or $r_st==55){$day_1_1  = $r_ket;$bg_1_1 = "bgcolor='#F7FDD6'";}elseif($r_st==90 or $r_st==91){$day_1_1  = $r_ket;$bg_1_1 = "bgcolor='#FBCAFB'";}elseif($r_st==897 or $r_st==896){$day_1_1  = $r_ket;$bg_1_1 = "bgcolor='#ADFFE9'";}}	
						
						elseif($jml_slot ==2){if($r_st==1  or $r_st==11){$day_1_2 = $r_kelas  ; $bg_1_2 = "bgcolor='#FFD7D8'";}elseif($r_st==71 or $r_st==75 or $r_st==70){$day_1_2  = "LC Visit";$bg_1_2 = "bgcolor='#C7DDFF'";}elseif($r_st==51 or $r_st==55){$day_1_2  = $r_ket;$bg_1_2 = "bgcolor='#F7FDD6'";}elseif($r_st==90 or $r_st==91){$day_1_2  = $r_ket;$bg_1_2 = "bgcolor='#FBCAFB'";}elseif($r_st==897 or $r_st==896){$day_1_2  = $r_ket;$bg_1_2 = "bgcolor='#ADFFE9'";}}		
						elseif($jml_slot ==3){if($r_st==1  or $r_st==11){$day_1_3 = $r_kelas  ; $bg_1_3 = "bgcolor='#FFD7D8'";}elseif($r_st==71 or $r_st==75 or $r_st==70){$day_1_3  = "LC Visit";$bg_1_3 = "bgcolor='#C7DDFF'";}elseif($r_st==51 or $r_st==55){$day_1_3  = $r_ket;$bg_1_3 = "bgcolor='#F7FDD6'";}elseif($r_st==90 or $r_st==91){$day_1_3  = $r_ket;$bg_1_3 = "bgcolor='#FBCAFB'";}elseif($r_st==897 or $r_st==896){$day_1_3  = $r_ket;$bg_1_3 = "bgcolor='#ADFFE9'";}}	
						elseif($jml_slot ==4){if($r_st==1  or $r_st==11){ $day_1_4 = $r_kelas  ;$bg_1_4 = "bgcolor='#FFD7D8'";}elseif($r_st==71 or $r_st==75 or $r_st==70){$day_1_4  = "LC Visit";$bg_1_4 = "bgcolor='#C7DDFF'";}elseif($r_st==51 or $r_st==55){$day_1_4  = $r_ket;$bg_1_4 = "bgcolor='#F7FDD6'";}elseif($r_st==90 or $r_st==91){$day_1_4  = $r_ket;$bg_1_4 = "bgcolor='#FBCAFB'";}elseif($r_st==897 or $r_st==896){$day_1_4  = $r_ket;$bg_1_4 = "bgcolor='#ADFFE9'";}}		
						elseif($jml_slot ==5){if($r_st==1  or $r_st==11){$day_1_5 = $r_kelas  ; $bg_1_5 = "bgcolor='#FFD7D8'";}elseif($r_st==71 or $r_st==75 or $r_st==70){$day_1_5  = "LC Visit";$bg_1_5 = "bgcolor='#C7DDFF'";}elseif($r_st==51 or $r_st==55){$day_1_5  = $r_ket;$bg_1_5 = "bgcolor='#F7FDD6'";}elseif($r_st==90 or $r_st==91){$day_1_5  = $r_ket;$bg_1_5 = "bgcolor='#FBCAFB'";}elseif($r_st==897 or $r_st==896){$day_1_5  = $r_ket;$bg_1_5 = "bgcolor='#ADFFE9'";}}		
						elseif($jml_slot ==6){if($r_st==1  or $r_st==11){$day_1_6 = $r_kelas  ; $bg_1_6 = "bgcolor='#FFD7D8'";}elseif($r_st==71 or $r_st==75 or $r_st==70){$day_1_6  = "LC Visit";$bg_1_6 = "bgcolor='#C7DDFF'";}elseif($r_st==51 or $r_st==55){$day_1_6  = $r_ket;$bg_1_6 = "bgcolor='#F7FDD6'";}elseif($r_st==90 or $r_st==91){$day_1_6  = $r_ket;$bg_1_6 = "bgcolor='#FBCAFB'";}elseif($r_st==897 or $r_st==896){$day_1_6  = $r_ket;$bg_1_6 = "bgcolor='#ADFFE9'";}}	
						elseif($jml_slot ==7){if($r_st==1  or $r_st==11){$day_1_7 = $r_kelas  ; $bg_1_7 = "bgcolor='#FFD7D8'";}elseif($r_st==71 or $r_st==75 or $r_st==70){$day_1_7 = "LC Visit";$bg_1_7 = "bgcolor='#C7DDFF'";}elseif($r_st==51 or $r_st==55){$day_1_7  = $r_ket;$bg_1_7 = "bgcolor='#F7FDD6'";}elseif($r_st==90 or $r_st==91){$day_1_7  = $r_ket;$bg_1_7 = "bgcolor='#FBCAFB'";}elseif($r_st==897 or $r_st==896){$day_1_7  = $r_ket;$bg_1_7 = "bgcolor='#ADFFE9'";}}	
						elseif($jml_slot ==8){if($r_st==1  or $r_st==11){ $day_1_8 = $r_kelas  ; $bg_1_8 = "bgcolor='#FFD7D8'";}elseif($r_st==71 or $r_st==75 or $r_st==70){$day_1_8 = "LC Visit";$bg_1_8 = "bgcolor='#C7DDFF'";}elseif($r_st==51 or $r_st==55){$day_1_8  = $r_ket;$bg_1_8 = "bgcolor='#F7FDD6'";}elseif($r_st==90 or $r_st==91){$day_1_8  = $r_ket;$bg_1_8 = "bgcolor='#FBCAFB'";}elseif($r_st==897 or $r_st==896){$day_1_8  = $r_ket;$bg_1_8 = "bgcolor='#ADFFE9'";}}		
						elseif($jml_slot ==9){if($r_st==1  or $r_st==11){$day_1_9 = $r_kelas  ; $bg_1_9 = "bgcolor='#FFD7D8'";}elseif($r_st==71 or $r_st==75  or $r_st==70){$day_1_9  = "LC Visit";$bg_1_9 = "bgcolor='#C7DDFF'";}elseif($r_st==51 or $r_st==55){$day_1_9  = $r_ket;$bg_1_9 = "bgcolor='#F7FDD6'";}elseif($r_st==90 or $r_st==91){$day_1_9  = $r_ket;$bg_1_9 = "bgcolor='#FBCAFB'";}elseif($r_st==897 or $r_st==896){$day_1_9  = $r_ket;$bg_1_9 = "bgcolor='#ADFFE9'";}}	
						elseif($jml_slot ==10){if($r_st==1  or $r_st==11){ $day_1_10 = $r_kelas  ;$bg_1_10 = "bgcolor='#FFD7D8'";}elseif($r_st==71 or $r_st==75 or $r_st==70){$day_1_10  ="LC Visit";$bg_1_10 = "bgcolor='#C7DDFF'";}elseif($r_st==51 or $r_st==55){$day_1_10  = $r_ket;$bg_1_10 = "bgcolor='#F7FDD6'";}elseif($r_st==90 or $r_st==91){$day_1_10  = $r_ket;$bg_1_10 = "bgcolor='#FBCAFB'";}elseif($r_st==897 or $r_st==896){$day_1_10  = $r_ket;$bg_1_10 = "bgcolor='#ADFFE9'";}}	
						elseif($jml_slot ==11){if($r_st==1  or $r_st==11){$day_1_11 = $r_kelas  ; $bg_1_11 = "bgcolor='#FFD7D8'";}elseif($r_st==71 or $r_st==75 or $r_st==70){$day_1_11  = "LC Visit";$bg_1_11 = "bgcolor='#C7DDFF'";}elseif($r_st==51 or $r_st==55){$day_1_11  = $r_ket;$bg_1_11 = "bgcolor='#F7FDD6'";}elseif($r_st==90 or $r_st==91){$day_1_11  = $r_ket;$bg_1_11 = "bgcolor='#FBCAFB'";}elseif($r_st==897 or $r_st==896){$day_1_11  = $r_ket;$bg_1_11 = "bgcolor='#ADFFE9'";}}	
						elseif($jml_slot ==12){if($r_st==1  or $r_st==11){$day_1_12 = $r_kelas  ; $bg_1_12 = "bgcolor='#FFD7D8'";}elseif($r_st==71 or $r_st==75 or $r_st==70){$day_1_12  = "LC Visit";$bg_1_12 = "bgcolor='#C7DDFF'";}elseif($r_st==51 or $r_st==55){$day_1_12  = $r_ket;$bg_1_12 = "bgcolor='#F7FDD6'";}elseif($r_st==90 or $r_st==91){$day_1_12  = $r_ket;$bg_1_12 = "bgcolor='#FBCAFB'";}elseif($r_st==897 or $r_st==896){$day_1_12  = $r_ket;$bg_1_12 = "bgcolor='#ADFFE9'";}}
						elseif($jml_slot ==13){if($r_st==1  or $r_st==11){ $day_1_13 = $r_kelas  ;$bg_1_13 = "bgcolor='#FFD7D8'";}elseif($r_st==71 or $r_st==75 or $r_st==70){$day_1_13  ="LC Visit";$bg_1_13= "bgcolor='#C7DDFF'";}elseif($r_st==51 or $r_st==55){$day_1_13  = $r_ket;$bg_1_13 = "bgcolor='#F7FDD6'";}elseif($r_st==90 or $r_st==91){$day_1_13  = $r_ket;$bg_1_13 = "bgcolor='#FBCAFB'";}elseif($r_st==897 or $r_st==896){$day_1_13  = $r_ket;$bg_1_13 = "bgcolor='#ADFFE9'";}}		
						}

							

						}
					else
						{
							if($jml_slot ==1 and (strtotime($slot_1_start) >= strtotime($jam_masuk)))   {$day_1_1 = "Available";$bg_1_1 = "bgcolor='#D4FCDA'";}	
							elseif($jml_slot ==2 and (strtotime($slot_2_start) >= strtotime($jam_masuk))){$day_1_2 = "Available";$bg_1_2 = "bgcolor='#D4FCDA'";}	
							elseif($jml_slot ==3 and (strtotime($slot_3_start) >= strtotime($jam_masuk))){$day_1_3 = "Available";$bg_1_3 = "bgcolor='#D4FCDA'";}	
							elseif($jml_slot ==4 and (strtotime($slot_4_start) >= strtotime($jam_masuk))){$day_1_4 = "Available";$bg_1_4 = "bgcolor='#D4FCDA'";}	
							elseif($jml_slot ==5 and (strtotime($slot_5_start) >= strtotime($jam_masuk))){$day_1_5 = "Available";$bg_1_5 = "bgcolor='#D4FCDA'";}	
							elseif($jml_slot ==6 and (strtotime($slot_6_start) >= strtotime($jam_masuk))){$day_1_6 = "Available";$bg_1_6 = "bgcolor='#D4FCDA'";}	
							elseif($jml_slot ==7 and (strtotime($slot_7_start) >= strtotime($jam_masuk)) and (strtotime($slot_7_end) <= strtotime($jam_pulang)) ){$day_1_7 = "Available";$bg_1_7 = "bgcolor='#D4FCDA'";}	
							elseif($jml_slot ==8 and (strtotime($slot_8_start) >= strtotime($jam_masuk)) and (strtotime($slot_8_end) <= strtotime($jam_pulang)) ){$day_1_8 = "Available";$bg_1_8 = "bgcolor='#D4FCDA'";}	
							elseif($jml_slot ==9 and (strtotime($slot_9_start) >= strtotime($jam_masuk)) and (strtotime($slot_9_end) <= strtotime($jam_pulang)) ){$day_1_9 = "Available";$bg_1_9 = "bgcolor='#D4FCDA'";}	
							elseif($jml_slot ==10 and (strtotime($slot_10_start) >= strtotime($jam_masuk)) and (strtotime($slot_10_end) <= strtotime($jam_pulang)) ){$day_1_10 = "Available";$bg_1_10 = "bgcolor='#D4FCDA'";}	
							elseif($jml_slot ==11 and (strtotime($slot_11_start) >= strtotime($jam_masuk)) and (strtotime($slot_11_end) <= strtotime($jam_pulang)) ){$day_1_11 = "Available";$bg_1_11 = "bgcolor='#D4FCDA'";}	
							elseif($jml_slot ==12 and (strtotime($slot_12_start) >= strtotime($jam_masuk))  and (strtotime($slot_12_end) <= strtotime($jam_pulang))){$day_1_12 = "Available";$bg_1_12 = "bgcolor='#D4FCDA'";}	
							elseif($jml_slot ==13 and (strtotime($slot_13_start) >= strtotime($jam_masuk)) and (strtotime($slot_13_end) <= strtotime($jam_pulang))){$day_1_13 = "Available";$bg_1_13 = "bgcolor='#D4FCDA'";}								
						}
				$jml_slot = $jml_slot+1;				
				}
//=========end			
			}	}
		elseif($jml_hari ==2) 
			{$judul_hari_2 = $judul_hari;$judul_tgl_2 = $judul_tgl;				$judul_tgl_lengkap_2  = date('Y-m-d', strtotime($tgl_awal));
			$query_msk_plg ="SELECT date_format(kerja_mulai,'%T'), date_format(kerja_selesai,'%T') FROM emp_time_work where kd_emp = ? and tanggal = ? and status = 1";	

			$resource_msk_plg= db_query($query_msk_plg, [$nm_teacher, "$mulai_tm "]);
			if($resource_msk_plg->rowCount() > 0)
				{				 
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

					$query_slot_teacher ="SELECT nm_teacher,status_kelas,keterangan,kelas FROM ves_data.vip_teacher_schedule WHERE (status_kelas <> 0 and status_kelas <> 52 and status_kelas <> 62 and status_kelas <> 72 and status_kelas <>92 )  and    ".$nm_teacher_pilih.   " and ((mulai_tm >= ? AND mulai_tm <= ?) OR
					(selesai_tm >= ? AND selesai_tm <= ?)) and (status_kelas <> 0 and status_kelas <> 52 and status_kelas <> 62 and status_kelas <> 72 and status_kelas <>92 ) ";	

					$resource_slot_teacher= db_query($query_slot_teacher, [$nm_teacher, $waktu_mulai, $waktu_selesai, $waktu_mulai, $waktu_selesai]);
					if($resource_slot_teacher->rowCount() > 0)
					{
					while ($r_status=  $resource_slot_teacher->fetch(PDO::FETCH_NUM))
						{
						$r_st = $r_status[1];
						$r_ket = e($r_status[2]);	
						$r_kelas = e($r_status[3]);if($r_ket ==''){$_ket = $r_kelas;}
						if($jml_slot ==1){if($r_st==1  or $r_st==11){ $day_2_1 = $r_kelas  ;$bg_2_1 = "bgcolor='#FFD7D8'";}elseif($r_st==71 or $r_st==75  or $r_st==70){$day_2_1  = "LC Visit";$bg_2_1 = "bgcolor='#C7DDFF'";}elseif($r_st==51 or $r_st==55){$day_2_1  = $r_ket;$bg_2_1 = "bgcolor='#F7FDD6'";}elseif($r_st==90 or $r_st==91){$day_2_1  = $r_ket;$bg_2_1 = "bgcolor='#FBCAFB'";}elseif($r_st==897 or $r_st==896){$day_2_1  = $r_ket;$bg_2_1 = "bgcolor='#ADFFE9'";}}	
						
						elseif($jml_slot ==2){if($r_st==1  or $r_st==11){$day_2_2 = $r_kelas  ; $bg_2_2 = "bgcolor='#FFD7D8'";}elseif($r_st==71 or $r_st==75 or $r_st==70){$day_2_2  = "LC Visit";$bg_2_2 = "bgcolor='#C7DDFF'";}elseif($r_st==51 or $r_st==55){$day_2_2  = $r_ket;$bg_2_2 = "bgcolor='#F7FDD6'";}elseif($r_st==90 or $r_st==91){$day_2_2  = $r_ket;$bg_2_2 = "bgcolor='#FBCAFB'";}elseif($r_st==897 or $r_st==896){$day_2_2  = $r_ket;$bg_2_2 = "bgcolor='#ADFFE9'";}}		
						elseif($jml_slot ==3){if($r_st==1  or $r_st==11){$day_2_3 = $r_kelas  ; $bg_2_3 = "bgcolor='#FFD7D8'";}elseif($r_st==71 or $r_st==75 or $r_st==70){$day_2_3  = "LC Visit";$bg_2_3 = "bgcolor='#C7DDFF'";}elseif($r_st==51 or $r_st==55){$day_2_3  = $r_ket;$bg_2_3 = "bgcolor='#F7FDD6'";}elseif($r_st==90 or $r_st==91){$day_2_3  = $r_ket;$bg_2_3 = "bgcolor='#FBCAFB'";}elseif($r_st==897 or $r_st==896){$day_2_3  = $r_ket;$bg_2_3 = "bgcolor='#ADFFE9'";}}	
						elseif($jml_slot ==4){if($r_st==1  or $r_st==11){ $day_2_4 = $r_kelas  ;$bg_2_4 = "bgcolor='#FFD7D8'";}elseif($r_st==71 or $r_st==75 or $r_st==70){$day_2_4  = "LC Visit";$bg_2_4 = "bgcolor='#C7DDFF'";}elseif($r_st==51 or $r_st==55){$day_2_4  = $r_ket;$bg_2_4 = "bgcolor='#F7FDD6'";}elseif($r_st==90 or $r_st==91){$day_2_4  = $r_ket;$bg_2_4 = "bgcolor='#FBCAFB'";}elseif($r_st==897 or $r_st==896){$day_2_4  = $r_ket;$bg_2_4 = "bgcolor='#ADFFE9'";}}		
						elseif($jml_slot ==5){if($r_st==1  or $r_st==11){$day_2_5 = $r_kelas  ; $bg_2_5 = "bgcolor='#FFD7D8'";}elseif($r_st==71 or $r_st==75 or $r_st==70){$day_2_5  = "LC Visit";$bg_2_5 = "bgcolor='#C7DDFF'";}elseif($r_st==51 or $r_st==55){$day_2_5  = $r_ket;$bg_2_5 = "bgcolor='#F7FDD6'";}elseif($r_st==90 or $r_st==91){$day_2_5  = $r_ket;$bg_2_5 = "bgcolor='#FBCAFB'";}elseif($r_st==897 or $r_st==896){$day_2_5  = $r_ket;$bg_2_5 = "bgcolor='#ADFFE9'";}}		
						elseif($jml_slot ==6){if($r_st==1  or $r_st==11){$day_2_6 = $r_kelas  ; $bg_2_6 = "bgcolor='#FFD7D8'";}elseif($r_st==71 or $r_st==75 or $r_st==70){$day_2_6  = "LC Visit";$bg_2_6 = "bgcolor='#C7DDFF'";}elseif($r_st==51 or $r_st==55){$day_2_6  = $r_ket;$bg_2_6 = "bgcolor='#F7FDD6'";}elseif($r_st==90 or $r_st==91){$day_2_6  = $r_ket;$bg_2_6 = "bgcolor='#FBCAFB'";}elseif($r_st==897 or $r_st==896){$day_2_6  = $r_ket;$bg_2_6 = "bgcolor='#ADFFE9'";}}	
						elseif($jml_slot ==7){if($r_st==1  or $r_st==11){$day_2_7 = $r_kelas  ; $bg_2_7 = "bgcolor='#FFD7D8'";}elseif($r_st==71 or $r_st==75 or $r_st==70){$day_2_7 = "LC Visit";$bg_2_7 = "bgcolor='#C7DDFF'";}elseif($r_st==51 or $r_st==55){$day_2_7  = $r_ket;$bg_2_7 = "bgcolor='#F7FDD6'";}elseif($r_st==90 or $r_st==91){$day_2_7  = $r_ket;$bg_2_7 = "bgcolor='#FBCAFB'";}elseif($r_st==897 or $r_st==896){$day_2_7  = $r_ket;$bg_2_7 = "bgcolor='#ADFFE9'";}}	
						elseif($jml_slot ==8){if($r_st==1  or $r_st==11){ $day_2_8 = $r_kelas  ; $bg_2_8 = "bgcolor='#FFD7D8'";}elseif($r_st==71 or $r_st==75 or $r_st==70){$day_2_8 = "LC Visit";$bg_2_8 = "bgcolor='#C7DDFF'";}elseif($r_st==51 or $r_st==55){$day_2_8  = $r_ket;$bg_2_8 = "bgcolor='#F7FDD6'";}elseif($r_st==90 or $r_st==91){$day_2_8  = $r_ket;$bg_2_8 = "bgcolor='#FBCAFB'";}elseif($r_st==897 or $r_st==896){$day_2_8  = $r_ket;$bg_2_8 = "bgcolor='#ADFFE9'";}}		
						elseif($jml_slot ==9){if($r_st==1  or $r_st==11){$day_2_9 = $r_kelas  ; $bg_2_9 = "bgcolor='#FFD7D8'";}elseif($r_st==71 or $r_st==75  or $r_st==70){$day_2_9  = "LC Visit";$bg_2_9 = "bgcolor='#C7DDFF'";}elseif($r_st==51 or $r_st==55){$day_2_9  = $r_ket;$bg_2_9 = "bgcolor='#F7FDD6'";}elseif($r_st==90 or $r_st==91){$day_2_9  = $r_ket;$bg_2_9 = "bgcolor='#FBCAFB'";}elseif($r_st==897 or $r_st==896){$day_2_9  = $r_ket;$bg_2_9 = "bgcolor='#ADFFE9'";}}	
						elseif($jml_slot ==10){if($r_st==1  or $r_st==11){ $day_2_10 = $r_kelas  ;$bg_2_10 = "bgcolor='#FFD7D8'";}elseif($r_st==71 or $r_st==75 or $r_st==70){$day_2_10  ="LC Visit";$bg_2_10 = "bgcolor='#C7DDFF'";}elseif($r_st==51 or $r_st==55){$day_2_10  = $r_ket;$bg_2_10 = "bgcolor='#F7FDD6'";}elseif($r_st==90 or $r_st==91){$day_2_10  = $r_ket;$bg_2_10 = "bgcolor='#FBCAFB'";}elseif($r_st==897 or $r_st==896){$day_2_10  = $r_ket;$bg_2_10 = "bgcolor='#ADFFE9'";}}	
						elseif($jml_slot ==11){if($r_st==1  or $r_st==11){$day_2_11 = $r_kelas  ; $bg_2_11 = "bgcolor='#FFD7D8'";}elseif($r_st==71 or $r_st==75 or $r_st==70){$day_2_11  = "LC Visit";$bg_2_11 = "bgcolor='#C7DDFF'";}elseif($r_st==51 or $r_st==55){$day_2_11  = $r_ket;$bg_2_11 = "bgcolor='#F7FDD6'";}elseif($r_st==90 or $r_st==91){$day_2_11  = $r_ket;$bg_2_11 = "bgcolor='#FBCAFB'";}elseif($r_st==897 or $r_st==896){$day_2_11  = $r_ket;$bg_2_11 = "bgcolor='#ADFFE9'";}}	
						elseif($jml_slot ==12){if($r_st==1  or $r_st==11){$day_2_12 = $r_kelas  ; $bg_2_12 = "bgcolor='#FFD7D8'";}elseif($r_st==71 or $r_st==75 or $r_st==70){$day_2_12  = "LC Visit";$bg_2_12 = "bgcolor='#C7DDFF'";}elseif($r_st==51 or $r_st==55){$day_2_12  = $r_ket;$bg_2_12 = "bgcolor='#F7FDD6'";}elseif($r_st==90 or $r_st==91){$day_2_12  = $r_ket;$bg_2_12 = "bgcolor='#FBCAFB'";}elseif($r_st==897 or $r_st==896){$day_2_12  = $r_ket;$bg_2_12 = "bgcolor='#ADFFE9'";}}
						elseif($jml_slot ==13){if($r_st==1  or $r_st==11){ $day_2_13 = $r_kelas  ;$bg_2_13 = "bgcolor='#FFD7D8'";}elseif($r_st==71 or $r_st==75 or $r_st==70){$day_2_13  ="LC Visit";$bg_2_13= "bgcolor='#C7DDFF'";}elseif($r_st==51 or $r_st==55){$day_2_13  = $r_ket;$bg_2_13 = "bgcolor='#F7FDD6'";}elseif($r_st==90 or $r_st==91){$day_2_13  = $r_ket;$bg_2_13 = "bgcolor='#FBCAFB'";}elseif($r_st==897 or $r_st==896){$day_2_13  = $r_ket;$bg_2_13 = "bgcolor='#ADFFE9'";}}
		
						}

						}
					else
						{
							if($jml_slot ==1 and (strtotime($slot_1_start) >= strtotime($jam_masuk))){$day_2_1 = "Available";$bg_2_1 = "bgcolor='#D4FCDA'";}	
							elseif($jml_slot ==2 and (strtotime($slot_2_start) >= strtotime($jam_masuk))){$day_2_2 = "Available";$bg_2_2 = "bgcolor='#D4FCDA'";}	
							elseif($jml_slot ==3 and (strtotime($slot_3_start) >= strtotime($jam_masuk))){$day_2_3 = "Available";$bg_2_3 = "bgcolor='#D4FCDA'";}	
							elseif($jml_slot ==4 and (strtotime($slot_4_start) >= strtotime($jam_masuk))){$day_2_4 = "Available";$bg_2_4 = "bgcolor='#D4FCDA'";}	
							elseif($jml_slot ==5 and (strtotime($slot_5_start) >= strtotime($jam_masuk))){$day_2_5 = "Available";$bg_2_5 = "bgcolor='#D4FCDA'";}	
							elseif($jml_slot ==6 and (strtotime($slot_6_start) >= strtotime($jam_masuk))){$day_2_6 = "Available";$bg_2_6 = "bgcolor='#D4FCDA'";}	
							elseif($jml_slot ==7 and (strtotime($slot_7_start) >= strtotime($jam_masuk)) and (strtotime($slot_7_end) <= strtotime($jam_pulang)) ){$day_2_7 = "Available";$bg_2_7 = "bgcolor='#D4FCDA'";}	
							elseif($jml_slot ==8 and (strtotime($slot_8_start) >= strtotime($jam_masuk)) and (strtotime($slot_8_end) <= strtotime($jam_pulang)) ){$day_2_8 = "Available";$bg_2_8 = "bgcolor='#D4FCDA'";}	
							elseif($jml_slot ==9 and (strtotime($slot_9_start) >= strtotime($jam_masuk)) and (strtotime($slot_9_end) <= strtotime($jam_pulang)) ){$day_2_9 = "Available";$bg_2_9 = "bgcolor='#D4FCDA'";}	
							elseif($jml_slot ==10 and (strtotime($slot_10_start) >= strtotime($jam_masuk)) and (strtotime($slot_10_end) <= strtotime($jam_pulang)) ){$day_2_10 = "Available";$bg_2_10 = "bgcolor='#D4FCDA'";}	
							elseif($jml_slot ==11 and (strtotime($slot_11_start) >= strtotime($jam_masuk)) and (strtotime($slot_11_end) <= strtotime($jam_pulang)) ){$day_2_11 = "Available";$bg_2_11 = "bgcolor='#D4FCDA'";}	
							elseif($jml_slot ==12 and (strtotime($slot_12_start) >= strtotime($jam_masuk)) and (strtotime($slot_12_end) <= strtotime($jam_pulang)) ){$day_2_12 = "Available";$bg_2_12 = "bgcolor='#D4FCDA'";}	
							elseif($jml_slot ==13 and (strtotime($slot_13_start) >= strtotime($jam_masuk)) and (strtotime($slot_13_end) <= strtotime($jam_pulang)) ){$day_2_13 = "Available";$bg_2_13 = "bgcolor='#D4FCDA'";}								
						}
				$jml_slot = $jml_slot+1;				
				}
			}
			}
		elseif($jml_hari ==3) 
			{
			$judul_hari_3 = $judul_hari;$judul_tgl_3 = $judul_tgl;				$judul_tgl_lengkap_3  = date('Y-m-d', strtotime($tgl_awal));
			$query_msk_plg ="SELECT date_format(kerja_mulai,'%T'), date_format(kerja_selesai,'%T') FROM emp_time_work where kd_emp = ? and tanggal = ? and status = 1";	

			$resource_msk_plg= db_query($query_msk_plg, [$nm_teacher, "$mulai_tm "]);
			if($resource_msk_plg->rowCount() > 0)
				{				
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

	$query_slot_teacher ="SELECT nm_teacher,status_kelas,keterangan,kelas FROM ves_data.vip_teacher_schedule WHERE (status_kelas <> 0 and status_kelas <> 52 and status_kelas <> 62 and status_kelas <> 72 and status_kelas <>92 )  and    ".$nm_teacher_pilih.   " and ((mulai_tm >= ? AND mulai_tm <= ?) OR
					(selesai_tm >= ? AND selesai_tm <= ?)) and (status_kelas <> 0 and status_kelas <> 52 and status_kelas <> 62 and status_kelas <> 72 and status_kelas <>92 ) ";	

					$resource_slot_teacher= db_query($query_slot_teacher, [$nm_teacher, $waktu_mulai, $waktu_selesai, $waktu_mulai, $waktu_selesai]);
					if($resource_slot_teacher->rowCount() > 0)
					{
					while ($r_status=  $resource_slot_teacher->fetch(PDO::FETCH_NUM))
						{
						$r_st = $r_status[1];
						$r_ket = e($r_status[2]);	
						$r_kelas = e($r_status[3]);if($r_ket ==''){$_ket = $r_kelas;}
						 if($jml_slot ==1){if($r_st==1  or $r_st==11){ $day_3_1 = $r_kelas  ;$bg_3_1 = "bgcolor='#FFD7D8'";}elseif($r_st==71 or $r_st==75  or $r_st==70){$day_3_1  = "LC Visit";$bg_3_1 = "bgcolor='#C7DDFF'";}elseif($r_st==51 or $r_st==55){$day_3_1  = $r_ket;$bg_3_1 = "bgcolor='#F7FDD6'";}elseif($r_st==90 or $r_st==91){$day_3_1  = $r_ket;$bg_3_1 = "bgcolor='#FBCAFB'";}elseif($r_st==897 or $r_st==896){$day_3_1  = $r_ket;$bg_3_1 = "bgcolor='#ADFFE9'";}}	
						
						elseif($jml_slot ==2){if($r_st==1  or $r_st==11){$day_3_2 = $r_kelas  ; $bg_3_2 = "bgcolor='#FFD7D8'";}elseif($r_st==71 or $r_st==75 or $r_st==70){$day_3_2  = "LC Visit";$bg_3_2 = "bgcolor='#C7DDFF'";}elseif($r_st==51 or $r_st==55){$day_3_2  = $r_ket;$bg_3_2 = "bgcolor='#F7FDD6'";}elseif($r_st==90 or $r_st==91){$day_3_2  = $r_ket;$bg_3_2 = "bgcolor='#FBCAFB'";}elseif($r_st==897 or $r_st==896){$day_3_2  = $r_ket;$bg_3_2 = "bgcolor='#ADFFE9'";}}		
						elseif($jml_slot ==3){if($r_st==1  or $r_st==11){$day_3_3 = $r_kelas  ; $bg_3_3 = "bgcolor='#FFD7D8'";}elseif($r_st==71 or $r_st==75 or $r_st==70){$day_3_3  = "LC Visit";$bg_3_3 = "bgcolor='#C7DDFF'";}elseif($r_st==51 or $r_st==55){$day_3_3  = $r_ket;$bg_3_3 = "bgcolor='#F7FDD6'";}elseif($r_st==90 or $r_st==91){$day_3_3  = $r_ket;$bg_3_3 = "bgcolor='#FBCAFB'";}elseif($r_st==897 or $r_st==896){$day_3_3  = $r_ket;$bg_3_3 = "bgcolor='#ADFFE9'";}}	
						elseif($jml_slot ==4){if($r_st==1  or $r_st==11){ $day_3_4 = $r_kelas  ;$bg_3_4 = "bgcolor='#FFD7D8'";}elseif($r_st==71 or $r_st==75 or $r_st==70){$day_3_4  = "LC Visit";$bg_3_4 = "bgcolor='#C7DDFF'";}elseif($r_st==51 or $r_st==55){$day_3_4  = $r_ket;$bg_3_4 = "bgcolor='#F7FDD6'";}elseif($r_st==90 or $r_st==91){$day_3_4  = $r_ket;$bg_3_4 = "bgcolor='#FBCAFB'";}elseif($r_st==897 or $r_st==896){$day_3_4  = $r_ket;$bg_3_4 = "bgcolor='#ADFFE9'";}}		
						elseif($jml_slot ==5){if($r_st==1  or $r_st==11){$day_3_5 = $r_kelas  ; $bg_3_5 = "bgcolor='#FFD7D8'";}elseif($r_st==71 or $r_st==75 or $r_st==70){$day_3_5  = "LC Visit";$bg_3_5 = "bgcolor='#C7DDFF'";}elseif($r_st==51 or $r_st==55){$day_3_5  = $r_ket;$bg_3_5 = "bgcolor='#F7FDD6'";}elseif($r_st==90 or $r_st==91){$day_3_5  = $r_ket;$bg_3_5 = "bgcolor='#FBCAFB'";}elseif($r_st==897 or $r_st==896){$day_3_5  = $r_ket;$bg_3_5 = "bgcolor='#ADFFE9'";}}		
						elseif($jml_slot ==6){if($r_st==1  or $r_st==11){$day_3_6 = $r_kelas  ; $bg_3_6 = "bgcolor='#FFD7D8'";}elseif($r_st==71 or $r_st==75 or $r_st==70){$day_3_6  = "LC Visit";$bg_3_6 = "bgcolor='#C7DDFF'";}elseif($r_st==51 or $r_st==55){$day_3_6  = $r_ket;$bg_3_6 = "bgcolor='#F7FDD6'";}elseif($r_st==90 or $r_st==91){$day_3_6  = $r_ket;$bg_3_6 = "bgcolor='#FBCAFB'";}elseif($r_st==897 or $r_st==896){$day_3_6  = $r_ket;$bg_3_6 = "bgcolor='#ADFFE9'";}}	
						elseif($jml_slot ==7){if($r_st==1  or $r_st==11){$day_3_7 = $r_kelas  ; $bg_3_7 = "bgcolor='#FFD7D8'";}elseif($r_st==71 or $r_st==75 or $r_st==70){$day_3_7 = "LC Visit";$bg_3_7 = "bgcolor='#C7DDFF'";}elseif($r_st==51 or $r_st==55){$day_3_7  = $r_ket;$bg_3_7 = "bgcolor='#F7FDD6'";}elseif($r_st==90 or $r_st==91){$day_3_7  = $r_ket;$bg_3_7 = "bgcolor='#FBCAFB'";}elseif($r_st==897 or $r_st==896){$day_3_7  = $r_ket;$bg_3_7 = "bgcolor='#ADFFE9'";}}	
						elseif($jml_slot ==8){if($r_st==1  or $r_st==11){ $day_3_8 = $r_kelas  ; $bg_3_8 = "bgcolor='#FFD7D8'";}elseif($r_st==71 or $r_st==75 or $r_st==70){$day_3_8 = "LC Visit";$bg_3_8 = "bgcolor='#C7DDFF'";}elseif($r_st==51 or $r_st==55){$day_3_8  = $r_ket;$bg_3_8 = "bgcolor='#F7FDD6'";}elseif($r_st==90 or $r_st==91){$day_3_8  = $r_ket;$bg_3_8 = "bgcolor='#FBCAFB'";}elseif($r_st==897 or $r_st==896){$day_3_8  = $r_ket;$bg_3_8 = "bgcolor='#ADFFE9'";}}		
						elseif($jml_slot ==9){if($r_st==1  or $r_st==11){$day_3_9 = $r_kelas  ; $bg_3_9 = "bgcolor='#FFD7D8'";}elseif($r_st==71 or $r_st==75  or $r_st==70){$day_3_9  = "LC Visit";$bg_3_9 = "bgcolor='#C7DDFF'";}elseif($r_st==51 or $r_st==55){$day_3_9  = $r_ket;$bg_3_9 = "bgcolor='#F7FDD6'";}elseif($r_st==90 or $r_st==91){$day_3_9  = $r_ket;$bg_3_9 = "bgcolor='#FBCAFB'";}elseif($r_st==897 or $r_st==896){$day_3_9  = $r_ket;$bg_3_9 = "bgcolor='#ADFFE9'";}}	
						elseif($jml_slot ==10){if($r_st==1  or $r_st==11){ $day_3_10 = $r_kelas  ;$bg_3_10 = "bgcolor='#FFD7D8'";}elseif($r_st==71 or $r_st==75 or $r_st==70){$day_3_10  ="LC Visit";$bg_3_10 = "bgcolor='#C7DDFF'";}elseif($r_st==51 or $r_st==55){$day_3_10  = $r_ket;$bg_3_10 = "bgcolor='#F7FDD6'";}elseif($r_st==90 or $r_st==91){$day_3_10  = $r_ket;$bg_3_10 = "bgcolor='#FBCAFB'";}elseif($r_st==897 or $r_st==896){$day_3_10  = $r_ket;$bg_3_10 = "bgcolor='#ADFFE9'";}}	
						elseif($jml_slot ==11){if($r_st==1  or $r_st==11){$day_3_11 = $r_kelas  ; $bg_3_11 = "bgcolor='#FFD7D8'";}elseif($r_st==71 or $r_st==75 or $r_st==70){$day_3_11  = "LC Visit";$bg_3_11 = "bgcolor='#C7DDFF'";}elseif($r_st==51 or $r_st==55){$day_3_11  = $r_ket;$bg_3_11 = "bgcolor='#F7FDD6'";}elseif($r_st==90 or $r_st==91){$day_3_11  = $r_ket;$bg_3_11 = "bgcolor='#FBCAFB'";}elseif($r_st==897 or $r_st==896){$day_3_11  = $r_ket;$bg_3_11 = "bgcolor='#ADFFE9'";}}	
						elseif($jml_slot ==12){if($r_st==1  or $r_st==11){$day_3_12 = $r_kelas  ; $bg_3_12 = "bgcolor='#FFD7D8'";}elseif($r_st==71 or $r_st==75 or $r_st==70){$day_3_12  = "LC Visit";$bg_3_12 = "bgcolor='#C7DDFF'";}elseif($r_st==51 or $r_st==55){$day_3_12  = $r_ket;$bg_3_12 = "bgcolor='#F7FDD6'";}elseif($r_st==90 or $r_st==91){$day_3_12  = $r_ket;$bg_3_12 = "bgcolor='#FBCAFB'";}elseif($r_st==897 or $r_st==896){$day_3_12  = $r_ket;$bg_3_12 = "bgcolor='#ADFFE9'";}}
						elseif($jml_slot ==13){if($r_st==1  or $r_st==11){ $day_3_13 = $r_kelas  ;$bg_3_13 = "bgcolor='#FFD7D8'";}elseif($r_st==71 or $r_st==75 or $r_st==70){$day_3_13  ="LC Visit";$bg_3_13= "bgcolor='#C7DDFF'";}elseif($r_st==51 or $r_st==55){$day_3_13  = $r_ket;$bg_3_13 = "bgcolor='#F7FDD6'";}elseif($r_st==90 or $r_st==91){$day_3_13  = $r_ket;$bg_3_13 = "bgcolor='#FBCAFB'";}elseif($r_st==897 or $r_st==896){$day_3_13  = $r_ket;$bg_3_13 = "bgcolor='#ADFFE9'";}}		
		
						}

						}
					else
						{
							if($jml_slot ==1 and (strtotime($slot_1_start) >= strtotime($jam_masuk))){$day_3_1 = "Available";$bg_3_1 = "bgcolor='#D4FCDA'";}	
							elseif($jml_slot ==2 and (strtotime($slot_2_start) >= strtotime($jam_masuk))){$day_3_2 = "Available";$bg_3_2 = "bgcolor='#D4FCDA'";}	
							elseif($jml_slot ==3 and (strtotime($slot_3_start) >= strtotime($jam_masuk))){$day_3_3 = "Available";$bg_3_3 = "bgcolor='#D4FCDA'";}	
							elseif($jml_slot ==4 and (strtotime($slot_4_start) >= strtotime($jam_masuk))){$day_3_4 = "Available";$bg_3_4= "bgcolor='#D4FCDA'";}	
							elseif($jml_slot ==5 and (strtotime($slot_5_start) >= strtotime($jam_masuk))){$day_3_5 = "Available";$bg_3_5 = "bgcolor='#D4FCDA'";}	
							elseif($jml_slot ==6 and (strtotime($slot_6_start) >= strtotime($jam_masuk))){$day_3_6 = "Available";$bg_3_6 = "bgcolor='#D4FCDA'";}	
							elseif($jml_slot ==7 and (strtotime($slot_7_start) >= strtotime($jam_masuk)) and (strtotime($slot_7_end) <= strtotime($jam_pulang)) ){$day_3_7 = "Available";$bg_3_7 = "bgcolor='#D4FCDA'";}	
							elseif($jml_slot ==8 and (strtotime($slot_8_start) >= strtotime($jam_masuk)) and (strtotime($slot_8_end) <= strtotime($jam_pulang)) ){$day_3_8 = "Available";$bg_3_8 = "bgcolor='#D4FCDA'";}	
							elseif($jml_slot ==9 and (strtotime($slot_9_start) >= strtotime($jam_masuk)) and (strtotime($slot_9_end) <= strtotime($jam_pulang)) ){$day_3_9 = "Available";$bg_3_9 = "bgcolor='#D4FCDA'";}	
							elseif($jml_slot ==10 and (strtotime($slot_10_start) >= strtotime($jam_masuk)) and (strtotime($slot_10_end) <= strtotime($jam_pulang)) ){$day_3_10 = "Available";$bg_3_10 = "bgcolor='#D4FCDA'";}	
							elseif($jml_slot ==11 and (strtotime($slot_11_start) >= strtotime($jam_masuk)) and (strtotime($slot_11_end) <= strtotime($jam_pulang)) ){$day_3_11 = "Available";$bg_3_11 = "bgcolor='#D4FCDA'";}	
							elseif($jml_slot ==12 and (strtotime($slot_12_start) >= strtotime($jam_masuk)) and (strtotime($slot_12_end) <= strtotime($jam_pulang)) ){$day_3_12 = "Available";$bg_3_12 = "bgcolor='#D4FCDA'";}	
							elseif($jml_slot ==13 and (strtotime($slot_13_start) >= strtotime($jam_masuk)) and (strtotime($slot_13_end) <= strtotime($jam_pulang)) ){$day_3_13 = "Available";$bg_3_13 = "bgcolor='#D4FCDA'";}								
						}
				$jml_slot = $jml_slot+1;				
				}	}		
			}
		elseif($jml_hari ==4) 
			{
			$judul_hari_4 = $judul_hari;$judul_tgl_4 = $judul_tgl;				$judul_tgl_lengkap_4  = date('Y-m-d', strtotime($tgl_awal));
			$query_msk_plg ="SELECT date_format(kerja_mulai,'%T'), date_format(kerja_selesai,'%T') FROM emp_time_work where kd_emp = ? and tanggal = ? and status = 1";	

			$resource_msk_plg= db_query($query_msk_plg, [$nm_teacher, "$mulai_tm "]);
			if($resource_msk_plg->rowCount() > 0)
				{				
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

	$query_slot_teacher ="SELECT nm_teacher,status_kelas,keterangan,kelas FROM ves_data.vip_teacher_schedule WHERE (status_kelas <> 0 and status_kelas <> 52 and status_kelas <> 62 and status_kelas <> 72 and status_kelas <>92 )  and    ".$nm_teacher_pilih.   " and ((mulai_tm >= ? AND mulai_tm <= ?) OR
					(selesai_tm >= ? AND selesai_tm <= ?)) and (status_kelas <> 0 and status_kelas <> 52 and status_kelas <> 62 and status_kelas <> 72 and status_kelas <>92 ) ";	

					$resource_slot_teacher= db_query($query_slot_teacher, [$nm_teacher, $waktu_mulai, $waktu_selesai, $waktu_mulai, $waktu_selesai]);
					if($resource_slot_teacher->rowCount() > 0)
					{
					while ($r_status=  $resource_slot_teacher->fetch(PDO::FETCH_NUM))
						{
						$r_st = $r_status[1];
						$r_ket = e($r_status[2]);	
						$r_kelas = e($r_status[3]);if($r_ket ==''){$_ket = $r_kelas;}
						if($jml_slot ==1){if($r_st==1  or $r_st==11){ $day_4_1 = $r_kelas  ;$bg_4_1 = "bgcolor='#FFD7D8'";}elseif($r_st==71 or $r_st==75  or $r_st==70){$day_4_1  = "LC Visit";$bg_4_1 = "bgcolor='#C7DDFF'";}elseif($r_st==51 or $r_st==55){$day_4_1  = $r_ket;$bg_4_1 = "bgcolor='#F7FDD6'";}elseif($r_st==90 or $r_st==91){$day_4_1  = $r_ket;$bg_4_1 = "bgcolor='#FBCAFB'";}elseif($r_st==897 or $r_st==896){$day_4_1  = $r_ket;$bg_4_1 = "bgcolor='#ADFFE9'";}}	
						
						elseif($jml_slot ==2){if($r_st==1  or $r_st==11){$day_4_2 = $r_kelas  ; $bg_4_2 = "bgcolor='#FFD7D8'";}elseif($r_st==71 or $r_st==75 or $r_st==70){$day_4_2  = "LC Visit";$bg_4_2 = "bgcolor='#C7DDFF'";}elseif($r_st==51 or $r_st==55){$day_4_2  = $r_ket;$bg_4_2 = "bgcolor='#F7FDD6'";}elseif($r_st==90 or $r_st==91){$day_4_2  = $r_ket;$bg_4_2 = "bgcolor='#FBCAFB'";}elseif($r_st==897 or $r_st==896){$day_4_2  = $r_ket;$bg_4_2 = "bgcolor='#ADFFE9'";}}		
						elseif($jml_slot ==3){if($r_st==1  or $r_st==11){$day_4_3 = $r_kelas  ; $bg_4_3 = "bgcolor='#FFD7D8'";}elseif($r_st==71 or $r_st==75 or $r_st==70){$day_4_3  = "LC Visit";$bg_4_3 = "bgcolor='#C7DDFF'";}elseif($r_st==51 or $r_st==55){$day_4_3  = $r_ket;$bg_4_3 = "bgcolor='#F7FDD6'";}elseif($r_st==90 or $r_st==91){$day_4_3  = $r_ket;$bg_4_3 = "bgcolor='#FBCAFB'";}elseif($r_st==897 or $r_st==896){$day_4_3  = $r_ket;$bg_4_3 = "bgcolor='#ADFFE9'";}}	
						elseif($jml_slot ==4){if($r_st==1  or $r_st==11){ $day_4_4 = $r_kelas  ;$bg_4_4 = "bgcolor='#FFD7D8'";}elseif($r_st==71 or $r_st==75 or $r_st==70){$day_4_4  = "LC Visit";$bg_4_4 = "bgcolor='#C7DDFF'";}elseif($r_st==51 or $r_st==55){$day_4_4  = $r_ket;$bg_4_4 = "bgcolor='#F7FDD6'";}elseif($r_st==90 or $r_st==91){$day_4_4  = $r_ket;$bg_4_4 = "bgcolor='#FBCAFB'";}elseif($r_st==897 or $r_st==896){$day_4_4  = $r_ket;$bg_4_4 = "bgcolor='#ADFFE9'";}}		
						elseif($jml_slot ==5){if($r_st==1  or $r_st==11){$day_4_5 = $r_kelas  ; $bg_4_5 = "bgcolor='#FFD7D8'";}elseif($r_st==71 or $r_st==75 or $r_st==70){$day_4_5  = "LC Visit";$bg_4_5 = "bgcolor='#C7DDFF'";}elseif($r_st==51 or $r_st==55){$day_4_5  = $r_ket;$bg_4_5 = "bgcolor='#F7FDD6'";}elseif($r_st==90 or $r_st==91){$day_4_5  = $r_ket;$bg_4_5 = "bgcolor='#FBCAFB'";}elseif($r_st==897 or $r_st==896){$day_4_5  = $r_ket;$bg_4_5 = "bgcolor='#ADFFE9'";}}		
						elseif($jml_slot ==6){if($r_st==1  or $r_st==11){$day_4_6 = $r_kelas  ; $bg_4_6 = "bgcolor='#FFD7D8'";}elseif($r_st==71 or $r_st==75 or $r_st==70){$day_4_6  = "LC Visit";$bg_4_6 = "bgcolor='#C7DDFF'";}elseif($r_st==51 or $r_st==55){$day_4_6  = $r_ket;$bg_4_6 = "bgcolor='#F7FDD6'";}elseif($r_st==90 or $r_st==91){$day_4_6  = $r_ket;$bg_4_6 = "bgcolor='#FBCAFB'";}elseif($r_st==897 or $r_st==896){$day_4_6  = $r_ket;$bg_4_6 = "bgcolor='#ADFFE9'";}}	
						elseif($jml_slot ==7){if($r_st==1  or $r_st==11){$day_4_7 = $r_kelas  ; $bg_4_7 = "bgcolor='#FFD7D8'";}elseif($r_st==71 or $r_st==75 or $r_st==70){$day_4_7 = "LC Visit";$bg_4_7 = "bgcolor='#C7DDFF'";}elseif($r_st==51 or $r_st==55){$day_4_7  = $r_ket;$bg_4_7 = "bgcolor='#F7FDD6'";}elseif($r_st==90 or $r_st==91){$day_4_7  = $r_ket;$bg_4_7 = "bgcolor='#FBCAFB'";}elseif($r_st==897 or $r_st==896){$day_4_7  = $r_ket;$bg_4_7 = "bgcolor='#ADFFE9'";}}	
						elseif($jml_slot ==8){if($r_st==1  or $r_st==11){ $day_4_8 = $r_kelas  ; $bg_4_8 = "bgcolor='#FFD7D8'";}elseif($r_st==71 or $r_st==75 or $r_st==70){$day_4_8 = "LC Visit";$bg_4_8 = "bgcolor='#C7DDFF'";}elseif($r_st==51 or $r_st==55){$day_4_8  = $r_ket;$bg_4_8 = "bgcolor='#F7FDD6'";}elseif($r_st==90 or $r_st==91){$day_4_8  = $r_ket;$bg_4_8 = "bgcolor='#FBCAFB'";}elseif($r_st==897 or $r_st==896){$day_4_8  = $r_ket;$bg_4_8 = "bgcolor='#ADFFE9'";}}		
						elseif($jml_slot ==9){if($r_st==1  or $r_st==11){$day_4_9 = $r_kelas  ; $bg_4_9 = "bgcolor='#FFD7D8'";}elseif($r_st==71 or $r_st==75  or $r_st==70){$day_4_9  = "LC Visit";$bg_4_9 = "bgcolor='#C7DDFF'";}elseif($r_st==51 or $r_st==55){$day_4_9  = $r_ket;$bg_4_9 = "bgcolor='#F7FDD6'";}elseif($r_st==90 or $r_st==91){$day_4_9  = $r_ket;$bg_4_9 = "bgcolor='#FBCAFB'";}elseif($r_st==897 or $r_st==896){$day_4_9  = $r_ket;$bg_4_9 = "bgcolor='#ADFFE9'";}}	
						elseif($jml_slot ==10){if($r_st==1  or $r_st==11){ $day_4_10 = $r_kelas  ;$bg_4_10 = "bgcolor='#FFD7D8'";}elseif($r_st==71 or $r_st==75 or $r_st==70){$day_4_10  ="LC Visit";$bg_4_10 = "bgcolor='#C7DDFF'";}elseif($r_st==51 or $r_st==55){$day_4_10  = $r_ket;$bg_4_10 = "bgcolor='#F7FDD6'";}elseif($r_st==90 or $r_st==91){$day_4_10  = $r_ket;$bg_4_10 = "bgcolor='#FBCAFB'";}elseif($r_st==897 or $r_st==896){$day_4_10  = $r_ket;$bg_4_10 = "bgcolor='#ADFFE9'";}}	
						elseif($jml_slot ==11){if($r_st==1  or $r_st==11){$day_4_11 = $r_kelas  ; $bg_4_11 = "bgcolor='#FFD7D8'";}elseif($r_st==71 or $r_st==75 or $r_st==70){$day_4_11  = "LC Visit";$bg_4_11 = "bgcolor='#C7DDFF'";}elseif($r_st==51 or $r_st==55){$day_4_11  = $r_ket;$bg_4_11 = "bgcolor='#F7FDD6'";}elseif($r_st==90 or $r_st==91){$day_4_11  = $r_ket;$bg_4_11 = "bgcolor='#FBCAFB'";}elseif($r_st==897 or $r_st==896){$day_4_11  = $r_ket;$bg_4_11 = "bgcolor='#ADFFE9'";}}	
						elseif($jml_slot ==12){if($r_st==1  or $r_st==11){$day_4_12 = $r_kelas  ; $bg_4_12 = "bgcolor='#FFD7D8'";}elseif($r_st==71 or $r_st==75 or $r_st==70){$day_4_12  = "LC Visit";$bg_4_12 = "bgcolor='#C7DDFF'";}elseif($r_st==51 or $r_st==55){$day_4_12  = $r_ket;$bg_4_12 = "bgcolor='#F7FDD6'";}elseif($r_st==90 or $r_st==91){$day_4_12  = $r_ket;$bg_4_12 = "bgcolor='#FBCAFB'";}elseif($r_st==897 or $r_st==896){$day_4_12  = $r_ket;$bg_4_12 = "bgcolor='#ADFFE9'";}}
						elseif($jml_slot ==13){if($r_st==1  or $r_st==11){ $day_4_13 = $r_kelas  ;$bg_4_13 = "bgcolor='#FFD7D8'";}elseif($r_st==71 or $r_st==75 or $r_st==70){$day_4_13  ="LC Visit";$bg_4_13= "bgcolor='#C7DDFF'";}elseif($r_st==51 or $r_st==55){$day_4_13  = $r_ket;$bg_4_13 = "bgcolor='#F7FDD6'";}elseif($r_st==90 or $r_st==91){$day_4_13  = $r_ket;$bg_4_13 = "bgcolor='#FBCAFB'";}elseif($r_st==897 or $r_st==896){$day_4_13  = $r_ket;$bg_4_13 = "bgcolor='#ADFFE9'";}}		
		
						}

						}
					else
						{
							if($jml_slot ==1 and (strtotime($slot_1_start) >= strtotime($jam_masuk))){$day_4_1 = "Available";$bg_4_1 = "bgcolor='#D4FCDA'";}	
							elseif($jml_slot ==2 and (strtotime($slot_2_start) >= strtotime($jam_masuk))){$day_4_2 = "Available";$bg_4_2 = "bgcolor='#D4FCDA'";}	
							elseif($jml_slot ==3 and (strtotime($slot_3_start) >= strtotime($jam_masuk))){$day_4_3 = "Available";$bg_4_3 = "bgcolor='#D4FCDA'";}	
							elseif($jml_slot ==4 and (strtotime($slot_4_start) >= strtotime($jam_masuk))){$day_4_4 = "Available";$bg_4_4 = "bgcolor='#D4FCDA'";}	
							elseif($jml_slot ==5 and (strtotime($slot_5_start) >= strtotime($jam_masuk))){$day_4_5 = "Available";$bg_4_5 = "bgcolor='#D4FCDA'";}	
							elseif($jml_slot ==6 and (strtotime($slot_6_start) >= strtotime($jam_masuk))){$day_4_6 = "Available";$bg_4_6 = "bgcolor='#D4FCDA'";}	
							elseif($jml_slot ==7 and (strtotime($slot_7_start) >= strtotime($jam_masuk)) and (strtotime($slot_7_end) <= strtotime($jam_pulang)) ){$day_4_7 = "Available";$bg_4_7 = "bgcolor='#D4FCDA'";}	
							elseif($jml_slot ==8 and (strtotime($slot_8_start) >= strtotime($jam_masuk)) and (strtotime($slot_8_end) <= strtotime($jam_pulang)) ){$day_4_8 = "Available";$bg_4_8 = "bgcolor='#D4FCDA'";}	
							elseif($jml_slot ==9 and (strtotime($slot_9_start) >= strtotime($jam_masuk)) and (strtotime($slot_9_end) <= strtotime($jam_pulang)) ){$day_4_9 = "Available";$bg_4_9 = "bgcolor='#D4FCDA'";}	
							elseif($jml_slot ==10 and (strtotime($slot_10_start) >= strtotime($jam_masuk)) and (strtotime($slot_10_end) <= strtotime($jam_pulang)) ){$day_4_10 = "Available";$bg_4_10 = "bgcolor='#D4FCDA'";}	
							elseif($jml_slot ==11 and (strtotime($slot_11_start) >= strtotime($jam_masuk)) and (strtotime($slot_11_end) <= strtotime($jam_pulang)) ){$day_4_11 = "Available";$bg_4_11 = "bgcolor='#D4FCDA'";}	
							elseif($jml_slot ==12 and (strtotime($slot_12_start) >= strtotime($jam_masuk)) and (strtotime($slot_12_end) <= strtotime($jam_pulang)) ){$day_4_12 = "Available";$bg_4_12 = "bgcolor='#D4FCDA'";}	
							elseif($jml_slot ==13 and (strtotime($slot_13_start) >= strtotime($jam_masuk)) and (strtotime($slot_13_end) <= strtotime($jam_pulang)) ){$day_4_13 = "Available";$bg_4_13 = "bgcolor='#D4FCDA'";}								
						}
				$jml_slot = $jml_slot+1;				
				}	}		
			}
		elseif($jml_hari ==5) 
			{
			$judul_hari_5 = $judul_hari;$judul_tgl_5 = $judul_tgl;				$judul_tgl_lengkap_5  = date('Y-m-d', strtotime($tgl_awal));
			$query_msk_plg ="SELECT date_format(kerja_mulai,'%T'), date_format(kerja_selesai,'%T') FROM emp_time_work where kd_emp = ? and tanggal = ? and status = 1";	

			$resource_msk_plg= db_query($query_msk_plg, [$nm_teacher, "$mulai_tm "]);
			if($resource_msk_plg->rowCount() > 0)
				{				
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

	$query_slot_teacher ="SELECT nm_teacher,status_kelas,keterangan,kelas FROM ves_data.vip_teacher_schedule WHERE (status_kelas <> 0 and status_kelas <> 52 and status_kelas <> 62 and status_kelas <> 72 and status_kelas <>92 )  and    ".$nm_teacher_pilih.   " and ((mulai_tm >= ? AND mulai_tm <= ?) OR
					(selesai_tm >= ? AND selesai_tm <= ?)) and (status_kelas <> 0 and status_kelas <> 52 and status_kelas <> 62 and status_kelas <> 72 and status_kelas <>92 ) ";	

					$resource_slot_teacher= db_query($query_slot_teacher, [$nm_teacher, $waktu_mulai, $waktu_selesai, $waktu_mulai, $waktu_selesai]);
					if($resource_slot_teacher->rowCount() > 0)
					{
					while ($r_status=  $resource_slot_teacher->fetch(PDO::FETCH_NUM))
						{
						$r_st = $r_status[1];
						$r_ket = e($r_status[2]);	
						$r_kelas = e($r_status[3]);if($r_ket ==''){$_ket = $r_kelas;}
						if($jml_slot ==1){if($r_st==1  or $r_st==11){ $day_5_1 = $r_kelas  ;$bg_5_1 = "bgcolor='#FFD7D8'";}elseif($r_st==71 or $r_st==75  or $r_st==70){$day_5_1  = "LC Visit";$bg_5_1 = "bgcolor='#C7DDFF'";}elseif($r_st==51 or $r_st==55){$day_5_1  = $r_ket;$bg_5_1 = "bgcolor='#F7FDD6'";}elseif($r_st==90 or $r_st==91){$day_5_1  = $r_ket;$bg_5_1 = "bgcolor='#FBCAFB'";}elseif($r_st==897 or $r_st==896){$day_5_1  = $r_ket;$bg_5_1 = "bgcolor='#ADFFE9'";}}	
						
						elseif($jml_slot ==2){if($r_st==1  or $r_st==11){$day_5_2 = $r_kelas  ; $bg_5_2 = "bgcolor='#FFD7D8'";}elseif($r_st==71 or $r_st==75 or $r_st==70){$day_5_2  = "LC Visit";$bg_5_2 = "bgcolor='#C7DDFF'";}elseif($r_st==51 or $r_st==55){$day_5_2  = $r_ket;$bg_5_2 = "bgcolor='#F7FDD6'";}elseif($r_st==90 or $r_st==91){$day_5_2  = $r_ket;$bg_5_2 = "bgcolor='#FBCAFB'";}elseif($r_st==897 or $r_st==896){$day_5_2  = $r_ket;$bg_5_2 = "bgcolor='#ADFFE9'";}}		
						elseif($jml_slot ==3){if($r_st==1  or $r_st==11){$day_5_3 = $r_kelas  ; $bg_5_3 = "bgcolor='#FFD7D8'";}elseif($r_st==71 or $r_st==75 or $r_st==70){$day_5_3  = "LC Visit";$bg_5_3 = "bgcolor='#C7DDFF'";}elseif($r_st==51 or $r_st==55){$day_5_3  = $r_ket;$bg_5_3 = "bgcolor='#F7FDD6'";}elseif($r_st==90 or $r_st==91){$day_5_3  = $r_ket;$bg_5_3 = "bgcolor='#FBCAFB'";}elseif($r_st==897 or $r_st==896){$day_5_3  = $r_ket;$bg_5_3 = "bgcolor='#ADFFE9'";}}	
						elseif($jml_slot ==4){if($r_st==1  or $r_st==11){ $day_5_4 = $r_kelas  ;$bg_5_4 = "bgcolor='#FFD7D8'";}elseif($r_st==71 or $r_st==75 or $r_st==70){$day_5_4  = "LC Visit";$bg_5_4 = "bgcolor='#C7DDFF'";}elseif($r_st==51 or $r_st==55){$day_5_4  = $r_ket;$bg_5_4 = "bgcolor='#F7FDD6'";}elseif($r_st==90 or $r_st==91){$day_5_4  = $r_ket;$bg_5_4 = "bgcolor='#FBCAFB'";}elseif($r_st==897 or $r_st==896){$day_5_4  = $r_ket;$bg_5_4 = "bgcolor='#ADFFE9'";}}		
						elseif($jml_slot ==5){if($r_st==1  or $r_st==11){$day_5_5 = $r_kelas  ; $bg_5_5 = "bgcolor='#FFD7D8'";}elseif($r_st==71 or $r_st==75 or $r_st==70){$day_5_5  = "LC Visit";$bg_5_5 = "bgcolor='#C7DDFF'";}elseif($r_st==51 or $r_st==55){$day_5_5  = $r_ket;$bg_5_5 = "bgcolor='#F7FDD6'";}elseif($r_st==90 or $r_st==91){$day_5_5  = $r_ket;$bg_5_5 = "bgcolor='#FBCAFB'";}elseif($r_st==897 or $r_st==896){$day_5_5  = $r_ket;$bg_5_5 = "bgcolor='#ADFFE9'";}}		
						elseif($jml_slot ==6){if($r_st==1  or $r_st==11){$day_5_6 = $r_kelas  ; $bg_5_6 = "bgcolor='#FFD7D8'";}elseif($r_st==71 or $r_st==75 or $r_st==70){$day_5_6  = "LC Visit";$bg_5_6 = "bgcolor='#C7DDFF'";}elseif($r_st==51 or $r_st==55){$day_5_6  = $r_ket;$bg_5_6 = "bgcolor='#F7FDD6'";}elseif($r_st==90 or $r_st==91){$day_5_6  = $r_ket;$bg_5_6 = "bgcolor='#FBCAFB'";}elseif($r_st==897 or $r_st==896){$day_5_6  = $r_ket;$bg_5_6 = "bgcolor='#ADFFE9'";}}	
						elseif($jml_slot ==7){if($r_st==1  or $r_st==11){$day_5_7 = $r_kelas  ; $bg_5_7 = "bgcolor='#FFD7D8'";}elseif($r_st==71 or $r_st==75 or $r_st==70){$day_5_7 = "LC Visit";$bg_5_7 = "bgcolor='#C7DDFF'";}elseif($r_st==51 or $r_st==55){$day_5_7  = $r_ket;$bg_5_7 = "bgcolor='#F7FDD6'";}elseif($r_st==90 or $r_st==91){$day_5_7  = $r_ket;$bg_5_7 = "bgcolor='#FBCAFB'";}elseif($r_st==897 or $r_st==896){$day_5_7  = $r_ket;$bg_5_7 = "bgcolor='#ADFFE9'";}}	
						elseif($jml_slot ==8){if($r_st==1  or $r_st==11){ $day_5_8 = $r_kelas  ; $bg_5_8 = "bgcolor='#FFD7D8'";}elseif($r_st==71 or $r_st==75 or $r_st==70){$day_5_8 = "LC Visit";$bg_5_8 = "bgcolor='#C7DDFF'";}elseif($r_st==51 or $r_st==55){$day_5_8  = $r_ket;$bg_5_8 = "bgcolor='#F7FDD6'";}elseif($r_st==90 or $r_st==91){$day_5_8  = $r_ket;$bg_5_8 = "bgcolor='#FBCAFB'";}elseif($r_st==897 or $r_st==896){$day_5_8  = $r_ket;$bg_5_8 = "bgcolor='#ADFFE9'";}}		
						elseif($jml_slot ==9){if($r_st==1  or $r_st==11){$day_5_9 = $r_kelas  ; $bg_5_9 = "bgcolor='#FFD7D8'";}elseif($r_st==71 or $r_st==75  or $r_st==70){$day_5_9  = "LC Visit";$bg_5_9 = "bgcolor='#C7DDFF'";}elseif($r_st==51 or $r_st==55){$day_5_9  = $r_ket;$bg_5_9 = "bgcolor='#F7FDD6'";}elseif($r_st==90 or $r_st==91){$day_5_9  = $r_ket;$bg_5_9 = "bgcolor='#FBCAFB'";}elseif($r_st==897 or $r_st==896){$day_5_9  = $r_ket;$bg_5_9 = "bgcolor='#ADFFE9'";}}	
						elseif($jml_slot ==10){if($r_st==1  or $r_st==11){ $day_5_10 = $r_kelas  ;$bg_5_10 = "bgcolor='#FFD7D8'";}elseif($r_st==71 or $r_st==75 or $r_st==70){$day_5_10  ="LC Visit";$bg_5_10 = "bgcolor='#C7DDFF'";}elseif($r_st==51 or $r_st==55){$day_5_10  = $r_ket;$bg_5_10 = "bgcolor='#F7FDD6'";}elseif($r_st==90 or $r_st==91){$day_5_10  = $r_ket;$bg_5_10 = "bgcolor='#FBCAFB'";}elseif($r_st==897 or $r_st==896){$day_5_10  = $r_ket;$bg_5_10 = "bgcolor='#ADFFE9'";}}	
						elseif($jml_slot ==11){if($r_st==1  or $r_st==11){$day_5_11 = $r_kelas  ; $bg_5_11 = "bgcolor='#FFD7D8'";}elseif($r_st==71 or $r_st==75 or $r_st==70){$day_5_11  = "LC Visit";$bg_5_11 = "bgcolor='#C7DDFF'";}elseif($r_st==51 or $r_st==55){$day_5_11  = $r_ket;$bg_5_11 = "bgcolor='#F7FDD6'";}elseif($r_st==90 or $r_st==91){$day_5_11  = $r_ket;$bg_5_11 = "bgcolor='#FBCAFB'";}elseif($r_st==897 or $r_st==896){$day_5_11  = $r_ket;$bg_5_11 = "bgcolor='#ADFFE9'";}}	
						elseif($jml_slot ==12){if($r_st==1  or $r_st==11){$day_5_12 = $r_kelas  ; $bg_5_12 = "bgcolor='#FFD7D8'";}elseif($r_st==71 or $r_st==75 or $r_st==70){$day_5_12  = "LC Visit";$bg_5_12 = "bgcolor='#C7DDFF'";}elseif($r_st==51 or $r_st==55){$day_5_12  = $r_ket;$bg_5_12 = "bgcolor='#F7FDD6'";}elseif($r_st==90 or $r_st==91){$day_5_12  = $r_ket;$bg_5_12 = "bgcolor='#FBCAFB'";}elseif($r_st==897 or $r_st==896){$day_5_12  = $r_ket;$bg_5_12 = "bgcolor='#ADFFE9'";}}
						elseif($jml_slot ==13){if($r_st==1  or $r_st==11){ $day_5_13 = $r_kelas  ;$bg_5_13 = "bgcolor='#FFD7D8'";}elseif($r_st==71 or $r_st==75 or $r_st==70){$day_5_13  ="LC Visit";$bg_5_13= "bgcolor='#C7DDFF'";}elseif($r_st==51 or $r_st==55){$day_5_13  = $r_ket;$bg_5_13 = "bgcolor='#F7FDD6'";}elseif($r_st==90 or $r_st==91){$day_5_13  = $r_ket;$bg_5_13 = "bgcolor='#FBCAFB'";}elseif($r_st==897 or $r_st==896){$day_5_13  = $r_ket;$bg_5_13 = "bgcolor='#ADFFE9'";}}		
		
						}

						}
					else
						{
							if($jml_slot ==1 and (strtotime($slot_1_start) >= strtotime($jam_masuk))){$day_5_1 = "Available";$bg_5_1 = "bgcolor='#D4FCDA'";}	
							elseif($jml_slot ==2 and (strtotime($slot_2_start) >= strtotime($jam_masuk))){$day_5_2 = "Available";$bg_5_2 = "bgcolor='#D4FCDA'";}	
							elseif($jml_slot ==3 and (strtotime($slot_3_start) >= strtotime($jam_masuk))){$day_5_3 = "Available";$bg_5_3 = "bgcolor='#D4FCDA'";}	
							elseif($jml_slot ==4 and (strtotime($slot_4_start) >= strtotime($jam_masuk))){$day_5_4 = "Available";$bg_5_4 = "bgcolor='#D4FCDA'";}	
							elseif($jml_slot ==5 and (strtotime($slot_5_start) >= strtotime($jam_masuk))){$day_5_5 = "Available";$bg_5_5 = "bgcolor='#D4FCDA'";}	
							elseif($jml_slot ==6 and (strtotime($slot_6_start) >= strtotime($jam_masuk))){$day_5_6 = "Available";$bg_5_6 = "bgcolor='#D4FCDA'";}	
							elseif($jml_slot ==7 and (strtotime($slot_7_start) >= strtotime($jam_masuk)) and (strtotime($slot_7_end) <= strtotime($jam_pulang)) ){$day_5_7 = "Available";$bg_5_7 = "bgcolor='#D4FCDA'";}	
							elseif($jml_slot ==8 and (strtotime($slot_8_start) >= strtotime($jam_masuk)) and (strtotime($slot_8_end) <= strtotime($jam_pulang)) ){$day_5_8 = "Available";$bg_5_8 = "bgcolor='#D4FCDA'";}	
							elseif($jml_slot ==9 and (strtotime($slot_9_start) >= strtotime($jam_masuk)) and (strtotime($slot_9_end) <= strtotime($jam_pulang)) ){$day_5_9 = "Available";$bg_5_9 = "bgcolor='#D4FCDA'";}	
							elseif($jml_slot ==10 and (strtotime($slot_10_start) >= strtotime($jam_masuk)) and (strtotime($slot_10_end) <= strtotime($jam_pulang)) ){$day_5_10 = "Available";$bg_5_10 = "bgcolor='#D4FCDA'";}	
							elseif($jml_slot ==11 and (strtotime($slot_11_start) >= strtotime($jam_masuk)) and (strtotime($slot_11_end) <= strtotime($jam_pulang)) ){$day_5_11 = "Available";$bg_5_11 = "bgcolor='#D4FCDA'";}	
							elseif($jml_slot ==12 and (strtotime($slot_12_start) >= strtotime($jam_masuk)) and (strtotime($slot_12_end) <= strtotime($jam_pulang)) ){$day_5_12 = "Available";$bg_5_12 = "bgcolor='#D4FCDA'";}	
							elseif($jml_slot ==13 and (strtotime($slot_13_start) >= strtotime($jam_masuk)) and (strtotime($slot_13_end) <= strtotime($jam_pulang)) ){$day_5_13 = "Available";$bg_5_13	 = "bgcolor='#D4FCDA'";}								
						}
				$jml_slot = $jml_slot+1;				
				}		}	
			}
		elseif($jml_hari ==6) 
			{
			$judul_hari_6 = $judul_hari;$judul_tgl_6 = $judul_tgl;				$judul_tgl_lengkap_6  = date('Y-m-d', strtotime($tgl_awal));
			$query_msk_plg ="SELECT date_format(kerja_mulai,'%T'), date_format(kerja_selesai,'%T') FROM emp_time_work where kd_emp = ? and tanggal = ? and status = 1";	

			$resource_msk_plg= db_query($query_msk_plg, [$nm_teacher, "$mulai_tm "]);
			if($resource_msk_plg->rowCount() > 0)
				{				
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

	$query_slot_teacher ="SELECT nm_teacher,status_kelas,keterangan,kelas FROM ves_data.vip_teacher_schedule WHERE (status_kelas <> 0 and status_kelas <> 52 and status_kelas <> 62 and status_kelas <> 72 and status_kelas <>92 )  and    ".$nm_teacher_pilih.   " and ((mulai_tm >= ? AND mulai_tm <= ?) OR
					(selesai_tm >= ? AND selesai_tm <= ?)) and (status_kelas <> 0 and status_kelas <> 52 and status_kelas <> 62 and status_kelas <> 72 and status_kelas <>92 ) ";	

					$resource_slot_teacher= db_query($query_slot_teacher, [$nm_teacher, $waktu_mulai, $waktu_selesai, $waktu_mulai, $waktu_selesai]);
					if($resource_slot_teacher->rowCount() > 0)
					{
					while ($r_status=  $resource_slot_teacher->fetch(PDO::FETCH_NUM))
						{
						$r_st = $r_status[1];
						$r_ket = e($r_status[2]);	
						$r_kelas = e($r_status[3]);if($r_ket ==''){$_ket = $r_kelas;}
						 if($jml_slot ==1){if($r_st==1  or $r_st==11){ $day_6_1 = $r_kelas  ;$bg_6_1 = "bgcolor='#FFD7D8'";}elseif($r_st==71 or $r_st==75  or $r_st==70){$day_6_1  = "LC Visit";$bg_6_1 = "bgcolor='#C7DDFF'";}elseif($r_st==51 or $r_st==55){$day_6_1  = $r_ket;$bg_6_1 = "bgcolor='#F7FDD6'";}elseif($r_st==90 or $r_st==91){$day_6_1  = $r_ket;$bg_6_1 = "bgcolor='#FBCAFB'";}elseif($r_st==897 or $r_st==896){$day_6_1  = $r_ket;$bg_6_1 = "bgcolor='#ADFFE9'";}}	
						
						elseif($jml_slot ==2){if($r_st==1  or $r_st==11){$day_6_2 = $r_kelas  ; $bg_6_2 = "bgcolor='#FFD7D8'";}elseif($r_st==71 or $r_st==75 or $r_st==70){$day_6_2  = "LC Visit";$bg_6_2 = "bgcolor='#C7DDFF'";}elseif($r_st==51 or $r_st==55){$day_6_2  = $r_ket;$bg_6_2 = "bgcolor='#F7FDD6'";}elseif($r_st==90 or $r_st==91){$day_6_2  = $r_ket;$bg_6_2 = "bgcolor='#FBCAFB'";}elseif($r_st==897 or $r_st==896){$day_6_2  = $r_ket;$bg_6_2 = "bgcolor='#ADFFE9'";}}		
						elseif($jml_slot ==3){if($r_st==1  or $r_st==11){$day_6_3 = $r_kelas  ; $bg_6_3 = "bgcolor='#FFD7D8'";}elseif($r_st==71 or $r_st==75 or $r_st==70){$day_6_3  = "LC Visit";$bg_6_3 = "bgcolor='#C7DDFF'";}elseif($r_st==51 or $r_st==55){$day_6_3  = $r_ket;$bg_6_3 = "bgcolor='#F7FDD6'";}elseif($r_st==90 or $r_st==91){$day_6_3  = $r_ket;$bg_6_3 = "bgcolor='#FBCAFB'";}elseif($r_st==897 or $r_st==896){$day_6_3  = $r_ket;$bg_6_3 = "bgcolor='#ADFFE9'";}}	
						elseif($jml_slot ==4){if($r_st==1  or $r_st==11){ $day_6_4 = $r_kelas  ;$bg_6_4 = "bgcolor='#FFD7D8'";}elseif($r_st==71 or $r_st==75 or $r_st==70){$day_6_4  = "LC Visit";$bg_6_4 = "bgcolor='#C7DDFF'";}elseif($r_st==51 or $r_st==55){$day_6_4  = $r_ket;$bg_6_4 = "bgcolor='#F7FDD6'";}elseif($r_st==90 or $r_st==91){$day_6_4  = $r_ket;$bg_6_4 = "bgcolor='#FBCAFB'";}elseif($r_st==897 or $r_st==896){$day_6_4  = $r_ket;$bg_6_4 = "bgcolor='#ADFFE9'";}}		
						elseif($jml_slot ==5){if($r_st==1  or $r_st==11){$day_6_5 = $r_kelas  ; $bg_6_5 = "bgcolor='#FFD7D8'";}elseif($r_st==71 or $r_st==75 or $r_st==70){$day_6_5  = "LC Visit";$bg_6_5 = "bgcolor='#C7DDFF'";}elseif($r_st==51 or $r_st==55){$day_6_5  = $r_ket;$bg_6_5 = "bgcolor='#F7FDD6'";}elseif($r_st==90 or $r_st==91){$day_6_5  = $r_ket;$bg_6_5 = "bgcolor='#FBCAFB'";}elseif($r_st==897 or $r_st==896){$day_6_5  = $r_ket;$bg_6_5 = "bgcolor='#ADFFE9'";}}		
						elseif($jml_slot ==6){if($r_st==1  or $r_st==11){$day_6_6 = $r_kelas  ; $bg_6_6 = "bgcolor='#FFD7D8'";}elseif($r_st==71 or $r_st==75 or $r_st==70){$day_6_6  = "LC Visit";$bg_6_6 = "bgcolor='#C7DDFF'";}elseif($r_st==51 or $r_st==55){$day_6_6  = $r_ket;$bg_6_6 = "bgcolor='#F7FDD6'";}elseif($r_st==90 or $r_st==91){$day_6_6  = $r_ket;$bg_6_6 = "bgcolor='#FBCAFB'";}elseif($r_st==897 or $r_st==896){$day_6_6  = $r_ket;$bg_6_6 = "bgcolor='#ADFFE9'";}}	
						elseif($jml_slot ==7){if($r_st==1  or $r_st==11){$day_6_7 = $r_kelas  ; $bg_6_7 = "bgcolor='#FFD7D8'";}elseif($r_st==71 or $r_st==75 or $r_st==70){$day_6_7 = "LC Visit";$bg_6_7 = "bgcolor='#C7DDFF'";}elseif($r_st==51 or $r_st==55){$day_6_7  = $r_ket;$bg_6_7 = "bgcolor='#F7FDD6'";}elseif($r_st==90 or $r_st==91){$day_6_7  = $r_ket;$bg_6_7 = "bgcolor='#FBCAFB'";}elseif($r_st==897 or $r_st==896){$day_6_7  = $r_ket;$bg_6_7 = "bgcolor='#ADFFE9'";}}	
						elseif($jml_slot ==8){if($r_st==1  or $r_st==11){ $day_6_8 = $r_kelas  ; $bg_6_8 = "bgcolor='#FFD7D8'";}elseif($r_st==71 or $r_st==75 or $r_st==70){$day_6_8 = "LC Visit";$bg_6_8 = "bgcolor='#C7DDFF'";}elseif($r_st==51 or $r_st==55){$day_6_8  = $r_ket;$bg_6_8 = "bgcolor='#F7FDD6'";}elseif($r_st==90 or $r_st==91){$day_6_8  = $r_ket;$bg_6_8 = "bgcolor='#FBCAFB'";}elseif($r_st==897 or $r_st==896){$day_6_8  = $r_ket;$bg_6_8 = "bgcolor='#ADFFE9'";}}		
						elseif($jml_slot ==9){if($r_st==1  or $r_st==11){$day_6_9 = $r_kelas  ; $bg_6_9 = "bgcolor='#FFD7D8'";}elseif($r_st==71 or $r_st==75  or $r_st==70){$day_6_9  = "LC Visit";$bg_6_9 = "bgcolor='#C7DDFF'";}elseif($r_st==51 or $r_st==55){$day_6_9  = $r_ket;$bg_6_9 = "bgcolor='#F7FDD6'";}elseif($r_st==90 or $r_st==91){$day_6_9  = $r_ket;$bg_6_9 = "bgcolor='#FBCAFB'";}elseif($r_st==897 or $r_st==896){$day_6_9  = $r_ket;$bg_6_9 = "bgcolor='#ADFFE9'";}}	
						elseif($jml_slot ==10){if($r_st==1  or $r_st==11){ $day_6_10 = $r_kelas  ;$bg_6_10 = "bgcolor='#FFD7D8'";}elseif($r_st==71 or $r_st==75 or $r_st==70){$day_6_10  ="LC Visit";$bg_6_10 = "bgcolor='#C7DDFF'";}elseif($r_st==51 or $r_st==55){$day_6_10  = $r_ket;$bg_6_10 = "bgcolor='#F7FDD6'";}elseif($r_st==90 or $r_st==91){$day_6_10  = $r_ket;$bg_6_10 = "bgcolor='#FBCAFB'";}elseif($r_st==897 or $r_st==896){$day_6_10  = $r_ket;$bg_6_10 = "bgcolor='#ADFFE9'";}}	
						elseif($jml_slot ==11){if($r_st==1  or $r_st==11){$day_6_11 = $r_kelas  ; $bg_6_11 = "bgcolor='#FFD7D8'";}elseif($r_st==71 or $r_st==75 or $r_st==70){$day_6_11  = "LC Visit";$bg_6_11 = "bgcolor='#C7DDFF'";}elseif($r_st==51 or $r_st==55){$day_6_11  = $r_ket;$bg_6_11 = "bgcolor='#F7FDD6'";}elseif($r_st==90 or $r_st==91){$day_6_11  = $r_ket;$bg_6_11 = "bgcolor='#FBCAFB'";}elseif($r_st==897 or $r_st==896){$day_6_11  = $r_ket;$bg_6_11 = "bgcolor='#ADFFE9'";}}	
						elseif($jml_slot ==12){if($r_st==1  or $r_st==11){$day_6_12 = $r_kelas  ; $bg_6_12 = "bgcolor='#FFD7D8'";}elseif($r_st==71 or $r_st==75 or $r_st==70){$day_6_12  = "LC Visit";$bg_6_12 = "bgcolor='#C7DDFF'";}elseif($r_st==51 or $r_st==55){$day_6_12  = $r_ket;$bg_6_12 = "bgcolor='#F7FDD6'";}elseif($r_st==90 or $r_st==91){$day_6_12  = $r_ket;$bg_6_12 = "bgcolor='#FBCAFB'";}elseif($r_st==897 or $r_st==896){$day_6_12  = $r_ket;$bg_6_12 = "bgcolor='#ADFFE9'";}}
						elseif($jml_slot ==13){if($r_st==1  or $r_st==11){ $day_6_13 = $r_kelas  ;$bg_6_13 = "bgcolor='#FFD7D8'";}elseif($r_st==71 or $r_st==75 or $r_st==70){$day_6_13  ="LC Visit";$bg_6_13= "bgcolor='#C7DDFF'";}elseif($r_st==51 or $r_st==55){$day_6_13  = $r_ket;$bg_6_13 = "bgcolor='#F7FDD6'";}elseif($r_st==90 or $r_st==91){$day_6_13  = $r_ket;$bg_6_13 = "bgcolor='#FBCAFB'";}elseif($r_st==897 or $r_st==896){$day_6_13  = $r_ket;$bg_6_13 = "bgcolor='#ADFFE9'";}}		
		
						}

						}
					else
						{
							if($jml_slot ==1 and (strtotime($slot_1_start) >= strtotime($jam_masuk))){$day_6_1 = "Available";$bg_6_1 = "bgcolor='#D4FCDA'";}	
							elseif($jml_slot ==2 and (strtotime($slot_2_start) >= strtotime($jam_masuk))){$day_6_2 = "Available";$bg_6_2 = "bgcolor='#D4FCDA'";}	
							elseif($jml_slot ==3 and (strtotime($slot_3_start) >= strtotime($jam_masuk))){$day_6_3 = "Available";$bg_6_3 = "bgcolor='#D4FCDA'";}	
							elseif($jml_slot ==4 and (strtotime($slot_4_start) >= strtotime($jam_masuk))){$day_6_4 = "Available";$bg_6_4 = "bgcolor='#D4FCDA'";}	
							elseif($jml_slot ==5 and (strtotime($slot_5_start) >= strtotime($jam_masuk))){$day_6_5 = "Available";$bg_6_5 = "bgcolor='#D4FCDA'";}	
							elseif($jml_slot ==6 and (strtotime($slot_6_start) >= strtotime($jam_masuk))){$day_6_6 = "Available";$bg_6_6 = "bgcolor='#D4FCDA'";}	
							elseif($jml_slot ==7 and (strtotime($slot_7_start) >= strtotime($jam_masuk)) and (strtotime($slot_7_end) <= strtotime($jam_pulang)) ){$day_6_7 = "Available";$bg_6_7 = "bgcolor='#D4FCDA'";}	
							elseif($jml_slot ==8 and (strtotime($slot_8_start) >= strtotime($jam_masuk)) and (strtotime($slot_8_end) <= strtotime($jam_pulang)) ){$day_6_8 = "Available";$bg_6_8 = "bgcolor='#D4FCDA'";}	
							elseif($jml_slot ==9 and (strtotime($slot_9_start) >= strtotime($jam_masuk)) and (strtotime($slot_9_end) <= strtotime($jam_pulang)) ){$day_6_9 = "Available";$bg_6_9 = "bgcolor='#D4FCDA'";}	
							elseif($jml_slot ==10 and (strtotime($slot_10_start) >= strtotime($jam_masuk)) and (strtotime($slot_10_end) <= strtotime($jam_pulang)) ){$day_6_10 = "Available";$bg_6_10 = "bgcolor='#D4FCDA'";}	
							elseif($jml_slot ==11 and (strtotime($slot_11_start) >= strtotime($jam_masuk)) and (strtotime($slot_11_end) <= strtotime($jam_pulang)) ){$day_6_11 = "Available";$bg_6_11 = "bgcolor='#D4FCDA'";}	
							elseif($jml_slot ==12 and (strtotime($slot_12_start) >= strtotime($jam_masuk)) and (strtotime($slot_12_end) <= strtotime($jam_pulang)) ){$day_6_12 = "Available";$bg_6_12 = "bgcolor='#D4FCDA'";}	
							elseif($jml_slot ==13 and (strtotime($slot_13_start) >= strtotime($jam_masuk)) and (strtotime($slot_13_end) <= strtotime($jam_pulang)) ){$day_6_13 = "Available";$bg_6_13 = "bgcolor='#D4FCDA'";}								
						}
				$jml_slot = $jml_slot+1;				
				}		}				
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

<?php if ($usergroup != 'ACD'){?>
    <tr bgcolor="#12BCE7">
      <td height="14" align=center bgcolor="#FFFFFF" class="style24">&nbsp;</td>
      <td height="14" align=center bgcolor="#FFFFFF" class="style24">	<h3><?php echo e($nm_teacher_tampil) ?></h3></td>
      <td align=center bgcolor="#FDFBFF" class="style24">&nbsp;</td>
      <td align=center bgcolor="#F58BFB" class="style24"><strong>Open Class Request</strong></td>
      <td align=center bgcolor="#FDFBFF" class="style24">&nbsp;</td>
      <td align=center bgcolor="#F58BFB"class="style24"><strong>Open Class Request</strong></td>
      <td align=center bgcolor="#FDFBFF" class="style24">&nbsp;</td>
      <td align=center bgcolor="#F58BFB"class="style24"><strong>Open Class Request</strong></td>
      <td align=center bgcolor="#FDFBFF" class="style24">&nbsp;</td>
      <td align=center bgcolor="#F58BFB"class="style24"><strong>Open Class Request</strong></td>
      <td align=center bgcolor="#FDFBFF" class="style24">&nbsp;</td>
      <td align=center bgcolor="#F58BFB"class="style24"><strong>Open Class Request</strong></td>
      <td align=center bgcolor="#FDFBFF" class="style24">&nbsp;</td>
      <td align=center bgcolor="#F58BFB"class="style24"><strong>Open Class Request</strong></td>
    </tr>
<?php } ?>
	  
    <tr bgcolor="#12BCE7">
      <td width="2%" height="14" align=center class="style24"><strong>No</strong></td>
      <td height="14" align=center class="style24"><strong>Day/Date<br>
        Time Slot</strong></td>
      <td align=center bgcolor="#FDFBFF" class="style24">&nbsp;</td>
      <td align=center class="style24">
		  <?php if($st_upd ==1){?>
		  <a href="#" 
target="popup" 
onclick="window.open('wh_upd.php?dt=<?php echo e(u($judul_tgl_lengkap_1)) ?>&tch=<?php echo e(u($nm_teacher)) ?>','popup','width=1000,height=800'); return false;"><?php echo e($judul_tgl_1) ?></a><strong>
		  <?php }else { echo e($judul_tgl_1);	} ?><br>
        <?php echo e($judul_hari_1) ?></strong></td>
      <td align=center bgcolor="#FDFBFF" class="style24">&nbsp;</td>
      <td align=center class="style24"> <?php if($st_upd ==1){?><a href="#" 
target="popup" 
onclick="window.open('wh_upd.php?dt=<?php echo e(u($judul_tgl_lengkap_2)) ?>&tch=<?php echo e(u($nm_teacher)) ?>','popup','width=1000,height=800'); return false;"><?php echo e($judul_tgl_2) ?></a><strong>
		  <?php }else { echo e($judul_tgl_2);	} ?><br>
        <?php echo e($judul_hari_2) ?></strong></td>
      <td align=center bgcolor="#FDFBFF" class="style24">&nbsp;</td>
      <td align=center class="style24"><?php if($st_upd ==1){?><a href="#" 
target="popup" 
onclick="window.open('wh_upd.php?dt=<?php echo e(u($judul_tgl_lengkap_3)) ?>&tch=<?php echo e(u($nm_teacher)) ?>','popup','width=1000,height=800'); return false;"><?php echo e($judul_tgl_3) ?></a><strong>
		  <?php }else { echo e($judul_tgl_3);	} ?><br>
        <?php echo e($judul_hari_3) ?></strong></td>
      <td align=center bgcolor="#FDFBFF" class="style24">&nbsp;</td>
      <td align=center class="style24"><?php if($st_upd ==1){?><a href="#" 
target="popup" 
onclick="window.open('wh_upd.php?dt=<?php echo e(u($judul_tgl_lengkap_4)) ?>&tch=<?php echo e(u($nm_teacher)) ?>','popup','width=1000,height=800'); return false;"><?php echo e($judul_tgl_4) ?></a><strong>
		  <?php }else { echo e($judul_tgl_4);	} ?><br>
        <?php echo e($judul_hari_4) ?></strong></td>
      <td align=center bgcolor="#FDFBFF" class="style24">&nbsp;</td>
      <td align=center class="style24"><?php if($st_upd ==1){?><a href="#" 
target="popup" 
onclick="window.open('wh_upd.php?dt=<?php echo e(u($judul_tgl_lengkap_5)) ?>&tch=<?php echo e(u($nm_teacher)) ?>','popup','width=1000,height=800'); return false;"><?php echo e($judul_tgl_5) ?></a><strong>
		  <?php }else { echo e($judul_tgl_5);	} ?><br>
        <?php echo e($judul_hari_5) ?></strong></td>
      <td align=center bgcolor="#FDFBFF" class="style24">&nbsp;</td>
      <td align=center class="style24"><?php if($st_upd ==1){?><a href="#" 
target="popup" 
onclick="window.open('wh_upd.php?dt=<?php echo e(u($judul_tgl_lengkap_6)) ?>&tch=<?php echo e(u($nm_teacher)) ?>','popup','width=1000,height=800'); return false;"><?php echo e($judul_tgl_6) ?></a><strong>
		  <?php }else { echo e($judul_tgl_6);	} ?><br>
        <?php echo e($judul_hari_6) ?></strong></td>
      </tr>
    <tr>
   
      <td height="14" align=center class="style24">1</td>
      <td width="20%" height="14" align=center class="style24">08:00 - 09:00</td>
      <td width="1%" align=center bgcolor="#FDFBFF" class="style24" <?php echo $bg_2_1 ?>>&nbsp;</td>
      <td width="12%" <?php echo $bg_1_1 ?> align=center class="style24"><?php echo  $day_1_1;  ?></td>
      <td width="1%" align=center bgcolor="#FDFBFF" class="style24" <?php echo $bg_2_1 ?>>&nbsp;</td>
      <td width="12%" <?php echo $bg_2_1 ?> align=center class="style24"><?php echo  $day_2_1;  ?></td>
      <td width="1%" align=center bgcolor="#FDFBFF" class="style24" <?php echo $bg_2_1 ?>>&nbsp;</td>
      <td width="12%" <?php echo $bg_3_1 ?>  align=center class="style24"><?php echo  $day_3_1;  ?></td>
      <td width="1%" align=center bgcolor="#FDFBFF" class="style24" <?php echo $bg_2_1 ?>>&nbsp;</td>
      <td width="12%" <?php echo $bg_4_1 ?>  align=center class="style24"><?php echo  $day_4_1;  ?></td>
      <td width="1%" align=center bgcolor="#FDFBFF" class="style24" <?php echo $bg_2_1 ?>>&nbsp;</td>
      <td width="12%" <?php echo $bg_5_1 ?>  align=center class="style24"><?php echo  $day_5_1;  ?></td>
      <td width="1%" align=center bgcolor="#FDFBFF" class="style24" <?php echo $bg_2_1 ?>>&nbsp;</td>
      <td width="12%" <?php echo $bg_6_1 ?>  align=center class="style24"><?php echo  $day_6_1;  ?></td>
      </tr>
    <tr>
      <td height="14" align=center class="style24">2</td>
      <td height="14" align=center class="style24">09:00 - 10:00</td>
      <td align=center bgcolor="#FDFBFF"  class="style24"  <?php echo $bg_2_2 ?>>&nbsp;</td>
      <td align=center  <?php echo $bg_1_2 ?> class="style24"><?php echo  $day_1_2;  ?></td>
      <td align=center bgcolor="#FDFBFF"  class="style24"  <?php echo $bg_2_2 ?>>&nbsp;</td>
      <td align=center  <?php echo $bg_2_2 ?>  class="style24"><?php echo  $day_2_2;  ?></td>
      <td align=center bgcolor="#FDFBFF"  class="style24"  <?php echo $bg_2_2 ?>>&nbsp;</td>
      <td align=center   <?php echo $bg_3_2 ?> class="style24"><?php echo  $day_3_2;  ?></td>
      <td align=center bgcolor="#FDFBFF"  class="style24"  <?php echo $bg_2_2 ?>>&nbsp;</td>
      <td align=center  <?php echo $bg_4_2 ?>  class="style24"><?php echo  $day_4_2;  ?></td>
      <td align=center bgcolor="#FDFBFF"  class="style24"  <?php echo $bg_2_2 ?>>&nbsp;</td>
      <td align=center  <?php echo $bg_5_2 ?>  class="style24"><?php echo  $day_5_2;  ?></td>
      <td align=center bgcolor="#FDFBFF"  class="style24"  <?php echo $bg_2_2 ?>>&nbsp;</td>
      <td align=center  <?php echo $bg_6_2 ?>  class="style24"><?php echo  $day_6_2;  ?></td>
      </tr>
    <tr>
      <td height="14" align=center class="style24">3</td>
      <td height="14" align=center class="style24">10:00 - 11:00</td>
      <td align=center bgcolor="#FDFBFF"   class="style24"  <?php echo $bg_2_3 ?>>&nbsp;</td>
      <td align=center  <?php echo $bg_1_3 ?>  class="style24"><?php echo  $day_1_3;  ?></td>
      <td align=center bgcolor="#FDFBFF"   class="style24"  <?php echo $bg_2_3 ?>>&nbsp;</td>
      <td align=center  <?php echo $bg_2_3 ?>   class="style24"><?php echo  $day_2_3;  ?></td>
      <td align=center bgcolor="#FDFBFF"   class="style24"  <?php echo $bg_2_3 ?>>&nbsp;</td>
      <td align=center  <?php echo $bg_3_3 ?>   class="style24"><?php echo  $day_3_3;  ?></td>
      <td align=center bgcolor="#FDFBFF"   class="style24"  <?php echo $bg_2_3 ?>>&nbsp;</td>
      <td align=center  <?php echo $bg_4_3 ?>   class="style24"><?php echo  $day_4_3;  ?></td>
      <td align=center bgcolor="#FDFBFF"   class="style24"  <?php echo $bg_2_3 ?>>&nbsp;</td>
      <td align=center  <?php echo $bg_5_3 ?>   class="style24"><?php echo  $day_5_3;  ?></td>
      <td align=center bgcolor="#FDFBFF"   class="style24"  <?php echo $bg_2_3 ?>>&nbsp;</td>
      <td align=center  <?php echo $bg_6_3 ?>   class="style24"><?php echo  $day_6_3;  ?></td>
      </tr>
    <tr>
      <td height="14" align=center class="style24">4</td>
      <td height="14" align=center class="style24">11:00 - 12:00</td>
      <td align=center bgcolor="#FDFBFF"    class="style24"  <?php echo $bg_2_4 ?>>&nbsp;</td>
      <td align=center  <?php echo $bg_1_4 ?>   class="style24"><?php echo  $day_1_4;  ?></td>
      <td align=center bgcolor="#FDFBFF"    class="style24"  <?php echo $bg_2_4 ?>>&nbsp;</td>
      <td align=center  <?php echo $bg_2_4 ?>    class="style24"><?php echo  $day_2_4;  ?></td>
      <td align=center bgcolor="#FDFBFF"    class="style24"  <?php echo $bg_2_4 ?>>&nbsp;</td>
      <td align=center  <?php echo $bg_3_4 ?>    class="style24"><?php echo  $day_3_4;  ?></td>
      <td align=center bgcolor="#FDFBFF"    class="style24"  <?php echo $bg_2_4 ?>>&nbsp;</td>
      <td align=center  <?php echo $bg_4_4 ?>    class="style24"><?php echo  $day_4_4;  ?></td>
      <td align=center bgcolor="#FDFBFF"    class="style24"  <?php echo $bg_2_4 ?>>&nbsp;</td>
      <td align=center  <?php echo $bg_5_4 ?>    class="style24"><?php echo  $day_5_4;  ?></td>
      <td align=center bgcolor="#FDFBFF"    class="style24"  <?php echo $bg_2_4 ?>>&nbsp;</td>
      <td align=center  <?php echo $bg_6_4 ?>    class="style24"><?php echo  $day_6_4;  ?></td>
      </tr>  
    <tr>
      <td height="14" align=center class="style24">5</td>
      <td height="14" align=center class="style24">12:00 - 13:00</td>
      <td align=center bgcolor="#FDFBFF"     class="style24"  <?php echo $bg_2_5 ?>>&nbsp;</td>
      <td align=center  <?php echo $bg_1_5 ?>    class="style24"><?php echo  $day_1_5;  ?></td>
      <td align=center bgcolor="#FDFBFF"     class="style24"  <?php echo $bg_2_5 ?>>&nbsp;</td>
      <td align=center  <?php echo $bg_2_5 ?>     class="style24"><?php echo  $day_2_5;  ?></td>
      <td align=center bgcolor="#FDFBFF"     class="style24"  <?php echo $bg_2_5 ?>>&nbsp;</td>
      <td align=center  <?php echo $bg_3_5 ?>     class="style24"><?php echo  $day_3_5;  ?></td>
      <td align=center bgcolor="#FDFBFF"     class="style24"  <?php echo $bg_2_5 ?>>&nbsp;</td>
      <td align=center  <?php echo $bg_4_5 ?>     class="style24"><?php echo  $day_4_5;  ?></td>
      <td align=center bgcolor="#FDFBFF"     class="style24"  <?php echo $bg_2_5 ?>>&nbsp;</td>
      <td align=center  <?php echo $bg_5_5 ?>     class="style24"><?php echo  $day_5_5;  ?></td>
      <td align=center bgcolor="#FDFBFF"     class="style24"  <?php echo $bg_2_5 ?>>&nbsp;</td>
      <td align=center  <?php echo $bg_6_5 ?>     class="style24"><?php echo  $day_6_5;  ?></td>
      </tr> 
    <tr>
      <td height="14" align=center class="style24">6</td>
      <td height="14" align=center class="style24">13:00 - 14:00</td>
      <td align=center bgcolor="#FDFBFF"      class="style24"  <?php echo $bg_2_6 ?>>&nbsp;</td>
      <td align=center  <?php echo $bg_1_6 ?>     class="style24"><?php echo  $day_1_6;  ?></td>
      <td align=center bgcolor="#FDFBFF"      class="style24"  <?php echo $bg_2_6 ?>>&nbsp;</td>
      <td align=center  <?php echo $bg_2_6 ?>      class="style24"><?php echo  $day_2_6;  ?></td>
      <td align=center bgcolor="#FDFBFF"      class="style24"  <?php echo $bg_2_6 ?>>&nbsp;</td>
      <td align=center  <?php echo $bg_3_6 ?>      class="style24"><?php echo  $day_3_6;  ?></td>
      <td align=center bgcolor="#FDFBFF"      class="style24"  <?php echo $bg_2_6 ?>>&nbsp;</td>
      <td align=center  <?php echo $bg_4_6 ?>      class="style24"><?php echo  $day_4_6;  ?></td>
      <td align=center bgcolor="#FDFBFF"      class="style24"  <?php echo $bg_2_6 ?>>&nbsp;</td>
      <td align=center  <?php echo $bg_5_6 ?>      class="style24"><?php echo  $day_5_6;  ?></td>
      <td align=center bgcolor="#FDFBFF"      class="style24"  <?php echo $bg_2_6 ?>>&nbsp;</td>
      <td align=center  <?php echo $bg_6_6 ?>      class="style24"><?php echo  $day_6_6;  ?></td>
      </tr> 
    <tr>
      <td height="14" align=center class="style24">7</td>
      <td height="14" align=center class="style24">14:00 - 15:00</td>
      <td align=center bgcolor="#FDFBFF"     class="style24"  <?php echo $bg_2_7 ?>>&nbsp;</td>
      <td align=center  <?php echo $bg_1_7 ?>      class="style24"><?php echo  $day_1_7;  ?></td>
      <td align=center bgcolor="#FDFBFF"     class="style24"  <?php echo $bg_2_7 ?>>&nbsp;</td>
      <td align=center  <?php echo $bg_2_7 ?>     class="style24"><?php echo  $day_2_7;  ?></td>
      <td align=center bgcolor="#FDFBFF"     class="style24"  <?php echo $bg_2_7 ?>>&nbsp;</td>
      <td align=center  <?php echo $bg_3_7 ?>     class="style24"><?php echo  $day_3_7;  ?></td>
      <td align=center bgcolor="#FDFBFF"     class="style24"  <?php echo $bg_2_7 ?>>&nbsp;</td>
      <td align=center  <?php echo $bg_4_7 ?>     class="style24"><?php echo  $day_4_7;  ?></td>
      <td align=center bgcolor="#FDFBFF"     class="style24"  <?php echo $bg_2_7 ?>>&nbsp;</td>
      <td align=center  <?php echo $bg_5_7 ?>     class="style24"><?php echo  $day_5_7;  ?></td>
      <td align=center bgcolor="#FDFBFF"     class="style24"  <?php echo $bg_2_7 ?>>&nbsp;</td>
      <td align=center  <?php echo $bg_6_7 ?>     class="style24"><?php echo  $day_6_7;  ?></td>
      </tr> 
    <tr>
      <td height="14" align=center class="style24">8</td>
      <td height="14" align=center class="style24">15:00 - 16:00</td>
      <td align=center bgcolor="#FDFBFF"      class="style24"  <?php echo $bg_2_8 ?>>&nbsp;</td>
      <td align=center  <?php echo $bg_1_8 ?>     class="style24"><?php echo  $day_1_8;  ?></td>
      <td align=center bgcolor="#FDFBFF"      class="style24"  <?php echo $bg_2_8 ?>>&nbsp;</td>
      <td align=center  <?php echo $bg_2_8 ?>      class="style24"><?php echo  $day_2_8;  ?></td>
      <td align=center bgcolor="#FDFBFF"      class="style24"  <?php echo $bg_2_8 ?>>&nbsp;</td>
      <td align=center  <?php echo $bg_3_8 ?>      class="style24"><?php echo  $day_3_8;  ?></td>
      <td align=center bgcolor="#FDFBFF"      class="style24"  <?php echo $bg_2_8 ?>>&nbsp;</td>
      <td align=center  <?php echo $bg_4_8 ?>      class="style24"><?php echo  $day_4_8;  ?></td>
      <td align=center bgcolor="#FDFBFF"      class="style24"  <?php echo $bg_2_8 ?>>&nbsp;</td>
      <td align=center  <?php echo $bg_5_8 ?>      class="style24"><?php echo  $day_5_8;  ?></td>
      <td align=center bgcolor="#FDFBFF"      class="style24"  <?php echo $bg_2_8 ?>>&nbsp;</td>
      <td align=center  <?php echo $bg_6_8 ?>      class="style24"><?php echo  $day_6_8;  ?></td>
      </tr> 
    <tr>
      <td height="14" align=center class="style24">9</td>
      <td height="14" align=center class="style24">16:00 - 17:00</td>
      <td align=center bgcolor="#FDFBFF"   class="style24"  <?php echo $bg_2_9 ?>>&nbsp;</td>
      <td align=center  <?php echo $bg_1_9 ?>      class="style24"><?php echo  $day_1_9;  ?></td>
      <td align=center bgcolor="#FDFBFF"   class="style24"  <?php echo $bg_2_9 ?>>&nbsp;</td>
      <td align=center  <?php echo $bg_2_9 ?>   class="style24"><?php echo  $day_2_9;  ?></td>
      <td align=center bgcolor="#FDFBFF"   class="style24"  <?php echo $bg_2_9 ?>>&nbsp;</td>
      <td align=center  <?php echo $bg_3_9 ?>   class="style24"><?php echo  $day_3_9;  ?></td>
      <td align=center bgcolor="#FDFBFF"   class="style24"  <?php echo $bg_2_9 ?>>&nbsp;</td>
      <td align=center  <?php echo $bg_4_9 ?>   class="style24"><?php echo  $day_4_9;  ?></td>
      <td align=center bgcolor="#FDFBFF"   class="style24"  <?php echo $bg_2_9 ?>>&nbsp;</td>
      <td align=center  <?php echo $bg_5_9 ?>   class="style24"><?php echo  $day_5_9;  ?></td>
      <td align=center bgcolor="#FDFBFF"   class="style24"  <?php echo $bg_2_9 ?>>&nbsp;</td>
      <td align=center  <?php echo $bg_6_9 ?>   class="style24"><?php echo  $day_6_9;  ?></td>
      </tr> 
    <tr>
      <td height="14" align=center class="style24">10</td>
      <td height="14" align=center class="style24">17:00 - 18:00</td>
      <td align=center bgcolor="#FDFBFF"   class="style24"  <?php echo $bg_2_10 ?>>&nbsp;</td>
      <td align=center  <?php echo $bg_1_10 ?>   class="style24"><?php echo  $day_1_10;  ?></td>
      <td align=center bgcolor="#FDFBFF"   class="style24"  <?php echo $bg_2_10 ?>>&nbsp;</td>
      <td align=center  <?php echo $bg_2_10 ?>   class="style24"><?php echo  $day_2_10;  ?></td>
      <td align=center bgcolor="#FDFBFF"   class="style24"  <?php echo $bg_2_10 ?>>&nbsp;</td>
      <td align=center  <?php echo $bg_3_10 ?>   class="style24"><?php echo  $day_3_10;  ?></td>
      <td align=center bgcolor="#FDFBFF"   class="style24"  <?php echo $bg_2_10 ?>>&nbsp;</td>
      <td align=center  <?php echo $bg_4_10 ?>   class="style24"><?php echo  $day_4_10;  ?></td>
      <td align=center bgcolor="#FDFBFF"   class="style24"  <?php echo $bg_2_10 ?>>&nbsp;</td>
      <td align=center  <?php echo $bg_5_10 ?>   class="style24"><?php echo  $day_5_10;  ?></td>
      <td align=center bgcolor="#FDFBFF"   class="style24"  <?php echo $bg_2_10 ?>>&nbsp;</td>
      <td align=center  <?php echo $bg_6_10 ?>   class="style24"><?php echo  $day_6_10;  ?></td>
      </tr> 
    <tr>
      <td height="14" align=center class="style24">11</td>
      <td height="14" align=center class="style24">18:00 - 19:00</td>
      <td align=center bgcolor="#FDFBFF"    class="style24"  <?php echo $bg_2_11 ?>>&nbsp;</td>
      <td align=center  <?php echo $bg_1_11 ?>   class="style24"><?php echo  $day_1_11;  ?></td>
      <td align=center bgcolor="#FDFBFF"    class="style24"  <?php echo $bg_2_11 ?>>&nbsp;</td>
      <td align=center  <?php echo $bg_2_11 ?>    class="style24"><?php echo  $day_2_11;  ?></td>
      <td align=center bgcolor="#FDFBFF"    class="style24"  <?php echo $bg_2_11 ?>>&nbsp;</td>
      <td align=center  <?php echo $bg_3_11 ?>    class="style24"><?php echo  $day_3_11;  ?></td>
      <td align=center bgcolor="#FDFBFF"    class="style24"  <?php echo $bg_2_11 ?>>&nbsp;</td>
      <td align=center  <?php echo $bg_4_11 ?>    class="style24"><?php echo  $day_4_11;  ?></td>
      <td align=center bgcolor="#FDFBFF"    class="style24"  <?php echo $bg_2_11 ?>>&nbsp;</td>
      <td align=center  <?php echo $bg_5_11 ?>    class="style24"><?php echo  $day_5_11;  ?></td>
      <td align=center bgcolor="#FDFBFF"    class="style24"  <?php echo $bg_2_11 ?>>&nbsp;</td>
      <td align=center  <?php echo $bg_6_11 ?>    class="style24"><?php echo  $day_6_11;  ?></td>
      </tr> 
    <tr>
      <td height="14" align=center class="style24">12</td>
      <td height="14" align=center class="style24">19:00 - 20:00</td>
      <td align=center bgcolor="#FDFBFF"   class="style24"  <?php echo $bg_2_12 ?>>&nbsp;</td>
      <td align=center  <?php echo $bg_1_12 ?>    class="style24"><?php echo  $day_1_12;  ?></td>
      <td align=center bgcolor="#FDFBFF"   class="style24"  <?php echo $bg_2_12 ?>>&nbsp;</td>
      <td align=center  <?php echo $bg_2_12 ?>   class="style24"><?php echo  $day_2_12;  ?></td>
      <td align=center bgcolor="#FDFBFF"   class="style24"  <?php echo $bg_2_12 ?>>&nbsp;</td>
      <td align=center  <?php echo $bg_3_12 ?>   class="style24"><?php echo  $day_3_12;  ?></td>
      <td align=center bgcolor="#FDFBFF"   class="style24"  <?php echo $bg_2_12 ?>>&nbsp;</td>
      <td align=center  <?php echo $bg_4_12 ?>   class="style24"><?php echo  $day_4_12;  ?></td>
      <td align=center bgcolor="#FDFBFF"   class="style24"  <?php echo $bg_2_12 ?>>&nbsp;</td>
      <td align=center   <?php echo $bg_5_12 ?>  class="style24"><?php echo  $day_5_12;  ?></td>
      <td align=center bgcolor="#FDFBFF"   class="style24"  <?php echo $bg_2_12 ?>>&nbsp;</td>
      <td align=center  <?php echo $bg_6_12 ?>   class="style24"><?php echo  $day_6_12;  ?></td>
      </tr> 
    <tr>
      <td height="14" align=center class="style24">13</td>
      <td height="14" align=center class="style24">20:00 - 21:00</td>
      <td align=center bgcolor="#FDFBFF"    class="style24"  <?php echo $bg_2_13 ?>>&nbsp;</td>
      <td align=center  <?php echo $bg_1_13 ?>   class="style24"><?php echo  $day_1_13;  ?></td>
      <td align=center bgcolor="#FDFBFF"    class="style24"  <?php echo $bg_2_13 ?>>&nbsp;</td>
      <td align=center  <?php echo $bg_2_13 ?>    class="style24"><?php echo  $day_2_13;  ?></td>
      <td align=center bgcolor="#FDFBFF"    class="style24"  <?php echo $bg_2_13 ?>>&nbsp;</td>
      <td align=center  <?php echo $bg_3_13 ?>    class="style24"><?php echo  $day_3_13;  ?></td>
      <td align=center bgcolor="#FDFBFF"    class="style24"  <?php echo $bg_2_13 ?>>&nbsp;</td>
      <td align=center  <?php echo $bg_4_13 ?>    class="style24"><?php echo  $day_4_13;  ?></td>
      <td align=center bgcolor="#FDFBFF"    class="style24"  <?php echo $bg_2_13 ?>>&nbsp;</td>
      <td align=center  <?php echo $bg_5_13 ?>    class="style24"><?php echo  $day_5_13;  ?></td>
      <td align=center bgcolor="#FDFBFF"    class="style24"  <?php echo $bg_2_13 ?>>&nbsp;</td>
      <td align=center  <?php echo $bg_6_13 ?>    class="style24"><?php echo  $day_6_13;  ?></td>
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

 <div class="box box-primary">
   <!-- /.box-header -->
                                 <div id="booking" class="panel-collapse collapse">

									 </a><!-- /.box-body -->
   <div class="box-footer text-center"> <a href="leads.php?q=3" class="uppercase">View All Leads</a> </div>
   <!-- /.box-footer -->
 </div>
   <?php } ?>
 </div>
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
<?php
 
if (in_raw('View', 'get') !== null) 
	
{
		echo "<script type=\"text/javascript\">\n";
		echo "alert('VCMS need time to collect all the data needed, be patience');\n";
		echo 'window.location = (' . js('vip_teacher_free_all.php?tgl_awal=' . u($tgl_awal)) . ");\n";				
		echo "</script>";
}
?>