<?php
require_once __DIR__ . "/_lib/bootstrap.php"; auth_require_login(); 
date_default_timezone_set('Asia/Jakarta');
include __DIR__ . "/conndb.php";
include __DIR__ . "/profiledata.php";
 include __DIR__ . "/atas.php";
include __DIR__ . "/left.php";	 
$hari=date("d");
$bulan=date("m");
$tahun=date("Y");
$hari_ini = "$tahun-$bulan-$hari";
$date_start = in_val('date_start', 'get');
$date_end = in_val('date_end', 'get');
if ($date_start ==''){$date_start = "2023-01-01";}
if ($date_end ==''){$date_end = $hari_ini;}
$nama_lengkap = $_SESSION['nama_lengkap'];
$nama_depan = $_SESSION['nama_depan'];

$kd_cbg = $_SESSION['kd_branch'];
$posisi = $_SESSION['posisi']; 
$kd_staff = $_SESSION['kd_staff'] ;
$kd_area = $_SESSION['kode_area'] ;
$kelompok = $_SESSION['kelompok'];
if (num($kd_area) == 5){$area ="";}
elseif(num($kd_area) == 42){$area = " and (kd_branch= '4' or kd_branch= '5' or kd_branch= '6')";}
elseif(num($kd_area) == 41){$area = " and (kd_branch= '1' or kd_branch= '2' or kd_branch= '3')";}
elseif(num($kd_area) == 31){$area = " and (kd_branch= '1' or kd_branch= '2')";}
elseif(num($kd_area) == 21) {$area = " and (kd_branch= '2'or kd_branch= '8')";}
elseif(num($kd_area) == 2){$area = " and kd_branch= '$kd_cbg'";}
else {$area = " and kd_branch= '$kd_cbg'";}	
if ($kelompok == 'ACD' or $posisi =='Admin'  or $posisi == 'SC'  or $posisi == 'CM' or $posisi = 'ACCM')
	{
	if ($nama_depan == 'Ira00' or $nama_depan == 'hanifa07' or $nama_depan == 'resty04' or $nama_depan == 'linda00' or $posisi = 'ACCM')
		{
		$kd_cbg = in_val('kd_cbg', 'get');
		}
else
{

$kd_cbg = $_SESSION['kd_branch'];}
$nm_teacher = in_val('nm_teacher', 'get');			
if ($kd_cbg == 'National'){$kd_cbg = 100;}
elseif ($kd_cbg == '--All--'){$kd_cbg = 111;}	
elseif ($kd_cbg == 'East Sby'){$kd_cbg = 1;}
elseif ($kd_cbg == 'West Sby'){$kd_cbg = 2;}
elseif ($kd_cbg == 'Bali'){$kd_cbg = 3;}
elseif ($kd_cbg == 'South Jkt'){$kd_cbg = 4;}
elseif ($kd_cbg == 'North Jkt'){$kd_cbg = 5;}
elseif ($kd_cbg == 'West Jkt'){$kd_cbg = 6;}
elseif ($kd_cbg == 'Bandung'){$kd_cbg = 7;}
elseif ($kd_cbg == 'Malang'){$kd_cbg = 8;}
elseif ($kd_cbg == 'East Area'){$kd_cbg = 101;}
elseif ($kd_cbg == 'West Area'){$kd_cbg = 102;}
elseif ($kd_cbg == 'Vpro Sby'){$kd_cbg = 351;}
elseif ($kd_cbg == 'Vpro Jkt'){$kd_cbg = 357;}
elseif ($kd_cbg == 'Vpro Dps'){$kd_cbg = 355;}
elseif ($kd_cbg == 'Vpro Mlg'){$kd_cbg = 358;}	
elseif ($kd_cbg == 'Vpro Bdg'){$kd_cbg = 353;}	
	
		


if (num($kd_cbg) ==111){$cabang = '--All--';}
elseif ($kd_cbg ==''){$cabang = '--All--';}	
elseif (num($kd_cbg) ==100){$cabang = 'National';}
elseif (num($kd_cbg) ==1){$cabang = 'East Sby';}
elseif (num($kd_cbg) ==2){$cabang = 'West Sby';}
elseif (num($kd_cbg) ==3){$cabang = 'Bali';}
elseif (num($kd_cbg) ==4){$cabang = 'South Jkt';}
elseif (num($kd_cbg) ==5){$cabang = 'North Jkt';}
elseif (num($kd_cbg) ==6){$cabang = 'West Jkt';}
elseif (num($kd_cbg) ==7){$cabang = 'Bandung';}
elseif (num($kd_cbg) ==8){$cabang = 'Malang';}
elseif (num($kd_cbg) ==101){$cabang = 'East Area';}
elseif (num($kd_cbg) ==102){$cabang = 'West Area';}
elseif (num($kd_cbg) == 351){$cabang = 'Vpro Sby';}
elseif (num($kd_cbg) == 357){$cabang = 'Vpro Jkt';}
elseif (num($kd_cbg) == 355){$cabang = 'Vpro Dps';}
elseif (num($kd_cbg) == 358){$cabang = 'Vpro Mlg';}
elseif (num($kd_cbg) == 353){$cabang = 'Vpro Bdg';}

$tgl_awal = in_val('tgl_awal', 'get');
$tgl_akhir = in_val('tgl_akhir', 'get');
$activities = in_val('activities', 'get');
$kelas = in_val('kelas', 'get');			
if ($tgl_awal == ''){$tgl_awal = $hari_ini;$tgl_akhir=$hari_ini;}
	}

?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>AdminLTE 2 | Dashboard</title>
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
   <?php if ($kelompok == 'ACD' or  $posisi =='Admin' or $posisi == 'SC'  or $posisi == 'CM'  or $posisi = 'ACCM'){	

$query = "SELECT date_format(v.mulai_tm,'%d %b %y'), a.nm_teacher , date_format(v.mulai_tm,'%H:%i'), date_format(v.selesai_tm,'%H:%i'), v.kelas, v.room, v.keterangan ,v.center,v.status_kelas,v.id,v.pic,date_format(v.dt_entry,'%d %b %y'),d.nama_lengkap FROM vip_teacher_schedule v left join vip_teacher_name a on v.nm_teacher = a.kd_teacher left join tb_user c on a.nm_teacher = c.nama_detail left join vip_student_data d on v.kd_biodata = d.kd_biodata where v.kd_branch = $kd_cbg" ;

//===========academic==
?>
<section class="content-header">
<h1>Teaching Hour Report</h1>
<div class="tab-content">
  <div id="act" class="tab-pane fade in active">
	<div class="panel box box-primary">
	<form name="myform" id="myform">
		<div class="box-header with-border">

		<div class="col-md-2">
		  <div class="form-group">
		    <label>Center</label>
		    <select class="form-control" name="kd_cbg"   onChange="this.form.submit()" >
		      <option value="0">--CHOOSE--</option>
		      <option value="111">--All--</option>
				
		      <option value="100">National</option>				
		      <option value="1">East Sby</option>
		      <option value="2">West Sby</option>
		      <option value="3">Denpasar</option>
		      <option value="8">Malang</option>
		      <option value="101">East Area</option>
		      <option value="4">South Jkt</option>
		      <option value="5">North Jkt</option>
		      <option value="6">West Jkt</option>
		      <option value="7">Bandung</option>
		      <option value="102">West Area</option>
		      <option value="351">Vpro Sby</option>
		      <option value="357">Vpro Jkt</option>
		      <option value="355">Vpro Dps</option>
		      <option value="358">Vpro Mlg</option>
		      <option value="353">Vpro Bdg</option>
			      
		      
		      <option selected="selected"><?php echo e($cabang) ?></option>
		      </select>
		    </div>
		  </div>
		<div class="col-md-2">
		  <div class="form-group">
		    <label>Start Period</label>
		    <input name="tgl_awal"  class="form-control"  type="date" value="<?php echo e($tgl_awal) ?>"   onChange="this.form.submit()"/>
		  </div>
		  </div>
		<div class="col-md-2">
		  <div class="form-group">
		    <label>End Period</label>
		     <input name="tgl_akhir"  class="form-control"  type="date" value="<?php echo e($tgl_akhir) ?>"  onChange="this.form.submit()" />
	      </div>
		  </div> <?php  ?>
		<div class="col-md-2">
		  <div class="form-group">
		    <label>Teacher</label>
		    <select class="form-control" name="nm_teacher"   onChange="this.form.submit()" >
	      <option>--All--</option>
		      <?php
if ($kd_cbg != '111')
{$query_nm_teacher = q_set($__p_query_nm_teacher, "SELECT b.nm_teacher,b.kd_teacher FROM vip_teacher_schedule a left join vip_teacher_name b on a.nm_teacher = b.kd_teacher where mulai_tm between ? and ? and a.kd_branch = ? group by nm_teacher order by nm_teacher", [(string) ($tgl_awal) . " 00:00:00", (string) ($tgl_akhir) . " 23:00:00", (string) ($kd_cbg)]);
}
else
{$query_nm_teacher = q_set($__p_query_nm_teacher, "SELECT b.nm_teacher,b.kd_teacher FROM vip_teacher_schedule a left join vip_teacher_name b on a.nm_teacher = b.kd_teacher where mulai_tm between ? and ?  group by nm_teacher order by nm_teacher", [(string) ($tgl_awal) . " 00:00:00", (string) ($tgl_akhir) . " 23:00:00"]);
}
	
$resource_nm_teacher = db_query_or_die('errro_7', $query_nm_teacher, $__p_query_nm_teacher ?? []);
$keluar_nm_teacher= db_num_rows($resource_nm_teacher);
	while ($row_nm_teacher=  db_fetch($resource_nm_teacher, PDO::FETCH_NUM))
		{	
							  		echo '<option value="'.e($row_nm_teacher[1]).'">'.e($row_nm_teacher[0]).'</option>';
							  		}      ?>
              <option selected="selected"><?php echo e($nm_teacher) ?></option>							  		
	        </select>
	      </div>
		  </div>
		<div class="col-md-2">
		  <div class="form-group">
		    <label>Class</label>
		    <select class="form-control" name="kelas"   onChange="this.form.submit()" >
		      <option>--All--</option>
		      <?php
if ($kd_cbg !='111')
{$query_nm_teacher = q_set($__p_query_nm_teacher, "SELECT kelas FROM vip_teacher_schedule a  where mulai_tm between ? and ? and a.kd_branch = ? group by kelas ", [(string) ($tgl_awal) . " 00:00:00", (string) ($tgl_akhir) . " 23:00:00", (string) ($kd_cbg)]);
}
else
{$query_nm_teacher = q_set($__p_query_nm_teacher, "SELECT kelas FROM vip_teacher_schedule a  where mulai_tm between ? and ?  group by kelas ", [(string) ($tgl_awal) . " 00:00:00", (string) ($tgl_akhir) . " 23:00:00"]);
}
	
$resource_kelas = db_query_or_die('errro_7', $query_nm_teacher, $__p_query_nm_teacher ?? []);
$keluar_kelas= db_num_rows($resource_kelas);
	while ($row_kelas=  db_fetch($resource_kelas, PDO::FETCH_NUM))
		{	
							  		echo '<option value="'.e($row_kelas[0]).'">'.e($row_kelas[0]).'</option>';
							  		}      ?>
		      <option selected="selected"><?php echo e($kelas) ?></option>
		      </select>
		    </div>
		  </div>
		<h4 class="box-title">&nbsp;		  </h4>
		<div class="col-md-2"> <a href="vip_tchhourrptpdf.php?kd_cbg=<?php echo e(u($kd_cbg)) ?>&tgl_awal=<?php echo e(u($tgl_awal)) ?>&tgl_akhir=<?php echo e(u($tgl_akhir)) ?>&nm_teacher=<?php echo e(u($nm_teacher)) ?>&kelas=<?php echo e(u($kelas)) ?>" 
target="popup" 
onClick="window.open(vip_tchhourrptpdf.php?kd_cbg=<?php echo e(u($kd_cbg)) ?> &tgl_awal=<?php echo e(u($tgl_awal)) ?>&tgl_akhir=<?php echo e(u($tgl_akhir)) ?>&nm_teacher=<?php echo e(u($nm_teacher)) ?>&kelas=<?php echo e(u($kelas)) ?>','popup','width=1000,height=800'); return false;" class="btn btn-danger" role="button"><i class="glyphicon glyphicon-print" aria-hidden="true"></i> Send To PDF</a> </div>
		<h4 class="box-title"><br>
		  </h4>
<div class="col-md-2">
	          <div class="form-group">
	       
	           <input name="Print" type="submit" id="Print"  class="form-control"  value="Print" />
              </div>
            </div>			
		</div>
	  </form>

      <div class="box-body">
             

<br>
<table width="100%" class="table table-borderless table-hover" id="example2">
  <tbody>


    <tr>
      <td width="2%" height="14" align=center class="style24">No</td>
      <td height="14" align=center class="style24">Class Code</td>
      <td align=center class="style24">Day &amp; Date</td>
      <td align=center class="style24">Room</td>
      <td align=center class="style24">Skill</td>
      <td align=center class="style24">Attendance Check</td>
      <td align=center class="style24">Coordination Check</td>
      <td align=center class="style24">Duration</td>
      <td align=center class="style24">OTB - (Minutes)</td>
      <td align=center class="style24">Status</td>
    </tr>
    <tr>
<?php
			
//mulai data klas reguler/private			
	$i=1;
$query_act = q_set($__p_query_act, "SELECT  v.kelas, CONCAT(date_format(v.mulai_tm,'%a, %d %b %y %H:%i' ),' - ' ,date_format(v.selesai_tm, '%H:%i' ) ), v.room, v.skill,v.mulai_tm,v.kd_branch,TIMEDIFF(date_format(selesai_tm,'%Y-%m-%d %H:%i:00'), date_format(mulai_tm,'%Y-%m-%d %H:%i:00')),v.id, v.status_kelas,TIME_FORMAT(TIMEDIFF(date_format(selesai_tm,'%Y-%m-%d %H:%i:00'), date_format(mulai_tm,'%Y-%m-%d %H:%i:00')),'%H') as durasi_jam,\r
TIME_FORMAT(TIMEDIFF(date_format(selesai_tm,'%Y-%m-%d %H:%i:00'), date_format(mulai_tm,'%Y-%m-%d %H:%i:00')),'%i') as durasi_menit,id,otb, otb_st FROM vip_teacher_schedule v left join vip_teacher_name a on v.nm_teacher = a.kd_teacher left join tb_user c on a.nm_teacher = c.nama_detail where v.mulai_tm between ? and ? and (status_kelas = 1) ", [(string) ($tgl_awal) . " 00:00:00", (string) ($tgl_akhir) . " 23:00:00"]);

//$query_act = "SELECT id,  date_format(v.mulai_tm,'%d %b %y'), a.nm_teacher , date_format(v.mulai_tm,'%H:%i'), date_format(v.selesai_tm,'%H:%i'), v.kelas, v.room, v.keterangan ,v.center,v.status_kelas,v.id,v.pic,date_format(v.dt_entry,'%d %b %y'),d.nama_lengkap FROM vip_teacher_schedule v left join vip_teacher_name a on v.nm_teacher = a.kd_teacher left join tb_user c on a.nm_teacher = c.nama_detail left join vip_student_data d on v.kd_biodata = d.kd_biodata" ;
	
if ($nm_teacher == '--All--')
	{ $query_filter_act_nm_teacher = "";}
else
	{	$query_filter_act_nm_teacher = q_set($__p_query_filter_act_nm_teacher, " and v.nm_teacher = ? ", [(string) ($nm_teacher)]);}
	
if ($kd_cbg != '111')
{
 $query_filter_act_kd_branch = q_set($__p_query_filter_act_kd_branch, " and v.kd_branch = ? ", [(string) ($kd_cbg)]);
}
else
{
 $query_filter_act_kd_branch = q_set($__p_query_filter_act_kd_branch, " ");
	
}
if ($kelas != '--All--')
{
 $query_filter_act_kelas = q_set($__p_query_filter_act_kelas, " and v.kelas = ? ", [(string) ($kelas)]);
}
else
{
 $query_filter_act_kelas = q_set($__p_query_filter_act_kelas, " ");
	
}	
//$query_plan_act = $query_act.$query_filter_act_nm_teacher.$query_filter_act_kd_branch.$query_filter_act_activities. " group by mulai_tm order by mulai_tm " ;
$query_plan_act = q_set($__p_query_plan_act, $query_act . $query_filter_act_nm_teacher . ($query_filter_act_activities ?? '') . $query_filter_act_kelas . $query_filter_act_kd_branch . " group by mulai_tm order by mulai_tm ", [...($__p_query_act ?? []), ...($__p_query_filter_act_nm_teacher ?? []), ...($__p_query_filter_act_kelas ?? []), ...($__p_query_filter_act_kd_branch ?? [])]);

	$no_urut = 1;num($jmljam) == 0;$jmljamsemua = 0;
      $result_act=db_query_or_die("Wah error nih191", $query_plan_act, $__p_query_plan_act ?? []);
if ($result_act) 
	{ 
	while ($r_act = db_fetch($result_act, PDO::FETCH_NUM))
		{ 
			
//==attendance
//$query_att = "SELECT sum(st_attendance) FROM vip_attendance where kd_class = '$r_act[0]' and dt_meeting = '$r_act[4]'";
$query_att = q_set($__p_query_att, "SELECT kd_biodata FROM vip_attendance where kd_class = ? and dt_meeting = ? ", [(string) ($r_act[0]), (string) ($r_act[4])]);
			
$result_att=db_query_or_die("Wah error nih20", $query_att, $__p_query_att ?? []);
$diabsen = db_num_rows($result_att);
			
//if ($result_att) 
//	{ 
//	while ($r_att = db_fetch($result_att, PDO::FETCH_NUM))
//	{
	if (num($diabsen) ==0) {$att = 0;}else{$att = 1;}
//	$att = $r_att[0];if ($att >= 1){$att = 1;}else{$att = 0;}


//=====
//==materi
if (num($r_act[8]) == 1)
{
$query_coord = q_set($__p_query_coord, "SELECT v.kd_class, v.tgl_meeting, v.subject, v.coverage, v.material, v.assignment FROM vip_cosheet v where kd_class = ? and tgl_meeting = ? and  subject <> ''and coverage <> ''and v.material <> ''and v.assignment <> ''", [(string) ($r_act[0]), (string) ($r_act[4])]);

$result_coord=db_query_or_die("Wah error nih21", $query_coord, $__p_query_coord ?? []);			
$jml = db_num_rows($result_coord);			
if (num($jml) >= 1) 	{$coord = 1;}else{$coord = 0;}
}
elseif (num($r_act[8]) == 51 or num($r_act[8]) == 61  or num($r_act[8]) == 55 )
{
$query_coord = q_set($__p_query_coord, "SELECT v.kd_class, v.tgl_meeting FROM vip_tutor v where v.kd_class =  ? and tgl_meeting = ? ", [(string) ($r_act[0]), (string) ($r_act[4])]);
$result_coord=db_query_or_die("Wah error nih21", $query_coord, $__p_query_coord ?? []);			
$jml = db_num_rows($result_coord);			
if (num($jml) >= 1) 	{$coord = 1; $att = 1;}else{$coord = 0;}	
}
			

			
if(num($att) == 1 and num($coord) ==1)
	{
	$st_jam = 'OK';
	$jmljam = num($jmljam) +  num($r_act[6]);
	$durasi_jam_dihitung =  $r_act[9];
	$durasi_menit_dihitung =  $r_act[10];

	$jmldurasi_jam_dihitung  = num($jmldurasi_jam_dihitung) + num($durasi_jam_dihitung);
	$jmldurasi_menit_dihitung  = num($jmldurasi_menit_dihitung) + num($durasi_menit_dihitung);

	}
else 
	{
	$st_jam = 'Pending';
	$jmljamsemua = num($jmljamsemua) +num($r_act[6]);
	$durasi_jam_pending =  $r_act[9];
	$durasi_menit_pending =  $r_act[10];
	$jmldurasi_jam_pending  = num($jmldurasi_jam_pending) + num($durasi_jam_pending);
	$jmldurasi_menit_pending  = num($jmldurasi_menit_pending) + num($durasi_menit_pending);					
	}
		?>
		          
      <td height="14" align=center class="style24"><?php echo  e($no_urut);  ?></td>
      <td width="9%" height="14" align=center class="style24"><?php echo  e($r_act[0]);  ?></td>
      <td width="12%" align=center class="style24"><?php echo  e($r_act[1]);  ?></td>
      <td width="14%" align=center class="style24"><?php echo  e($r_act[2]);  ?></td>
      <td width="11%" align=center class="style24"><?php echo  e($r_act[3]);  ?></td>
      <td width="8%" align=center class="style24"><a href="vip_stuattt.php" 
target="popup" 
onclick="window.open('vip_stuattt.php?no=<?php echo e(u($r_act[7])) ?>','popup','width=1500,height=800'); return false;"><?php echo  e($att);  ?><a></a></td>
      <td width="13%" align=center class="style24"><a href="vip_crsh.php" 
target="popup" 
onclick="window.open('vip_crsh.php?kdcl=<?php echo e(u($r_act[0])) ?>&kdcbg=<?php echo e(u($r_act[5])) ?>&no=<?php echo e(u($r_act[7])) ?>','popup','width=1000,height=800'); return false;"><?php echo  e($coord);  ?></a></td>
      <td width="13%" align=center class="style24"><?php echo  e($r_act[6])  ?></td>
		<td width="18%" align=center class="style24"><a href="#" 
target="popup" 
onclick="window.open('vip_otbupd.php?no=<?php echo e(u($r_act[7])) ?>','popup','width=800,height=800'); return false;"><?php echo  e($r_act[12])  ?></a></td>
      <td width="18%" align=center class="style24"><?php echo  e($st_jam)  ?> </td>
    </tr>
    
    <?php $no_urut = num($no_urut) +1; $coord =0;$att=0; $ttl_angka_otb = num($ttl_angka_otb)+num($r_act[12]); }}
	$ttl_regpricounthour = $jmldurasi_jam_dihitung;
	$ttl_regpricountmenit = $jmldurasi_menit_dihitung;  
	
	  ?>
<tr>
      <td height="14" align=center class="style24">&nbsp;</td>
      <td height="14" align=center class="style24">&nbsp;</td>
      <td align=center class="style24">&nbsp;</td>
      <td align=center class="style24">&nbsp;</td>
      <td align=center class="style24"><strong>Total Class Reguler/Private Pending</strong></td>
      <td align=center class="style24"><strong><?php echo  e($jmldurasi_jam_pending)  ?> Hour(s) <?php echo e($jmldurasi_menit_pending) ?> Minute(s)</strong></td>
      <td align=center class="style24">&nbsp;</td>
      <td align=center class="style24"><strong>Total Class Reguler/Private Count</strong></td>
      <td colspan="2" align=center class="style24"><strong><?php echo  e($ttl_regpricounthour)  ?> Hour(s) <?php echo e($ttl_regpricountmenit) ?> Minute(s)</strong></td>
      </tr>
<tr>
<?php //selesai data klas reguler/private	 ?>     
      <td height="14" align=center class="style24">&nbsp;</td>
      <td height="14" align=center class="style24">&nbsp;</td>
      <td align=center class="style24">&nbsp;</td>
      <td align=center class="style24">&nbsp;</td>
      <td align=center class="style24">&nbsp;</td>
      <td align=center class="style24">&nbsp;</td>
      <td align=center class="style24">&nbsp;</td>
      <td align=center class="style24">&nbsp;</td>
      <td align=center class="style24">&nbsp;</td>
      <td align=center class="style24">&nbsp;</td>
    </tr>
    <tr>
<?php
			$jmldurasi_jam_dihitung = 0;
$jmldurasi_menit_dihitung	= 0;	
//mulai data tutorial/late attendance			
	$i=1;
$query_act = q_set($__p_query_act, "SELECT  v.kelas, CONCAT(date_format(v.mulai_tm,'%a, %d %b %y %H:%i' ),' - ' ,date_format(v.selesai_tm, '%H:%i' ) ), v.room, v.skill,v.mulai_tm,v.kd_branch,TIMEDIFF(date_format(selesai_tm,'%Y-%m-%d %H:%i:00'), date_format(mulai_tm,'%Y-%m-%d %H:%i:00')),v.id, v.status_kelas,TIME_FORMAT(TIMEDIFF(date_format(selesai_tm,'%Y-%m-%d %H:%i:00'), date_format(mulai_tm,'%Y-%m-%d %H:%i:00')),'%H') as durasi_jam,\r
TIME_FORMAT(TIMEDIFF(date_format(selesai_tm,'%Y-%m-%d %H:%i:00'), date_format(mulai_tm,'%Y-%m-%d %H:%i:00')),'%i') as durasi_menit,otb FROM vip_teacher_schedule v left join vip_teacher_name a on v.nm_teacher = a.kd_teacher left join tb_user c on a.nm_teacher = c.nama_detail where v.mulai_tm between ? and ? and (status_kelas like '50' or status_kelas like '51' or status_kelas like '55' or status_kelas = '60' or status_kelas = '61' or status_kelas = '65'    or status_kelas = '91' or status_kelas = '40' or status_kelas = '41' or status_kelas = '45'  or status_kelas = '897') ", [(string) ($tgl_awal) . " 00:00:00", (string) ($tgl_akhir) . " 23:00:00"]);

	
if ($nm_teacher == '--All--')
	{ $query_filter_act_nm_teacher = "";}
else
	{	$query_filter_act_nm_teacher = q_set($__p_query_filter_act_nm_teacher, " and v.nm_teacher = ? ", [(string) ($nm_teacher)]);}

				  
$query_plan_act = q_set($__p_query_plan_act, $query_act . $query_filter_act_nm_teacher . $query_filter_act_kd_branch . ($query_filter_act_activities ?? '') . $query_filter_act_kelas . " group by mulai_tm order by mulai_tm ", [...($__p_query_act ?? []), ...($__p_query_filter_act_nm_teacher ?? []), ...($__p_query_filter_act_kd_branch ?? []), ...($__p_query_filter_act_kelas ?? [])]);


	$no_urut = 1;num($jmljam) == 0;$jmljamsemua = 0;
      $result_act=db_query_or_die("Wah error nih192", $query_plan_act, $__p_query_plan_act ?? []);
if ($result_act) 
	{ 
	while ($r_act = db_fetch($result_act, PDO::FETCH_NUM))
		{ 
			
//==attendance
//$query_att = "SELECT sum(st_attendance) FROM vip_attendance where kd_class = '$r_act[0]' and dt_meeting = '$r_act[4]'";
$query_att = q_set($__p_query_att, "SELECT kd_biodata FROM vip_attendance where kd_class = ? and dt_meeting = ? ", [(string) ($r_act[0]), (string) ($r_act[4])]);

$result_att=db_query_or_die("Wah error nih20", $query_att, $__p_query_att ?? []);
$diabsen = db_num_rows($result_att);

	if (num($diabsen) ==0) {$att = 0;}else{$att = 1;}

if (num($r_act[8]) == 1)
	{
	$query_coord = q_set($__p_query_coord, "SELECT v.kd_class, v.tgl_meeting, v.subject, v.coverage, v.material, v.assignment FROM vip_cosheet v where kd_class = ? and tgl_meeting = ? and  subject <> ''and coverage <> ''and v.material <> ''and v.assignment <> ''", [(string) ($r_act[0]), (string) ($r_act[4])]);

	$result_coord=db_query_or_die("Wah error nih21", $query_coord, $__p_query_coord ?? []);			
	$jml = db_num_rows($result_coord);			
	if (num($jml) >= 1) 	{$coord = 1;}else{$coord = 0;}
	}
elseif (num($r_act[8]) == 50 or num($r_act[8]) == 51 or num($r_act[8]) == 52 or num($r_act[8]) == 61  or num($r_act[8]) == 55 or num($r_act[8]) == 65 or num($r_act[8]) == 40 or num($r_act[8]) == 41 or num($r_act[8]) == 45 or num($r_act[8]) == 897 or num($r_act[8]) == 91)
	{
	//$query_coord = "SELECT v.kd_class, v.tgl_meeting FROM vip_tutor v where v.kd_class =  '$r_act[0]' and tgl_meeting = '$r_act[4]'";
	$query_coord = q_set($__p_query_coord, "SELECT v.kd_class, v.tgl_meeting FROM vip_cosheet v where v.kd_class =  ? and tgl_meeting = ? ", [(string) ($r_act[0]), (string) ($r_act[4])]);

	$result_coord=db_query_or_die("Wah error nih21", $query_coord, $__p_query_coord ?? []);			
	$jml = db_num_rows($result_coord);			
	if (num($jml) >= 1) 	{$coord = 1; $att = 1;}else{$coord = 0;}	echo e($att);
	}
elseif ( num($r_act[8]) == 91 or num($r_act[8]) == 41)	
{$coord = 1; $att = 1;}
	

			
			if(num($att) == 1 and num($coord) ==1)
				{
				$st_jam = 'OK';
				$jmljam = num($jmljam) +  num($r_act[6]);
				$durasi_jam_dihitung =  $r_act[9];
				$durasi_menit_dihitung =  $r_act[10];	
				$jmldurasi_jam_dihitung  = num($jmldurasi_jam_dihitung) + num($durasi_jam_dihitung);
				$jmldurasi_menit_dihitung  = num($jmldurasi_menit_dihitung) + num($durasi_menit_dihitung);
				}
			else 
				{
				$st_jam = 'Pending';
				$jmljamsemua = num($jmljamsemua) +num($r_act[6]);
				$durasi_jam_pending =  $r_act[9];
				$durasi_menit_pending =  $r_act[10];
				$jmldurasi_jam_pending  = num($jmldurasi_jam_pending) + num($durasi_jam_pending);
				$jmldurasi_menit_pending  = num($jmldurasi_menit_pending) + num($durasi_menit_pending);					
				}
		?>
		          
      <td height="14" align=center class="style24"><?php echo  e($no_urut);  ?></td>
      <td width="9%" height="14" align=center class="style24"><?php echo  e($r_act[0]);  ?></td>
      <td width="12%" align=center class="style24"><?php echo  e($r_act[1]);  ?></td>
      <td width="14%" align=center class="style24"><?php echo  e($r_act[2]);  ?></td>
      <td width="11%" align=center class="style24"><?php echo  e($r_act[3]);  ?></td>
      <td width="8%" align=center class="style24"><a href="vip_stuattt.php" 
target="popup" 
onclick="window.open('vip_stuattt.php?no=<?php echo e(u($r_act[7])) ?>','popup','width=1500,height=800'); return false;"><?php echo  e($att);  ?><a></a></td>
      <td width="13%" align=center class="style24"><a href="vip_crsh.php" 
target="popup" 
onclick="window.open('vip_crsh.php?kdcl=<?php echo e(u($r_act[0])) ?>&kdcbg=<?php echo e(u($r_act[5])) ?>','popup','width=1000,height=800'); return false;"><?php echo  e($coord);  ?></a></td>
      <td width="13%" align=center class="style24"><?php echo  e($r_act[6])  ?></td>
      <td width="18%" align=center class="style24"><a href="#" 
target="popup" 
onclick="window.open('vip_otbupd.php?no=<?php echo e(u($r_act[7])) ?>','popup','width=800,height=800'); return false;"><?php echo  e($r_act[11])  ?></a></td>
      <td width="18%" align=center class="style24"><?php echo  e($st_jam)  ?> </td>
    </tr>
    
    <?php $no_urut = num($no_urut) +1; $coord =0;$att=0; $ttl_angka_otb = num($ttl_angka_otb)+num($r_act[11]);}}

	$ttl_tutorcountmenit = $jmldurasi_menit_dihitung; 
	
	$ttl_tutorcountmenitsaja =num($ttl_tutorcountmenit)%60;
	$ttl_tutorcountmenitkejam = num((num($ttl_tutorcountmenit) - num($ttl_tutorcountmenitsaja)))/60;

		$ttl_tutorcountmenit =$ttl_tutorcountmenitsaja;	
		$ttl_tutorcounthour = num($jmldurasi_jam_dihitung)+num($ttl_tutorcountmenitkejam);	
	  ?>
<tr>
      <td height="14" align=center class="style24">&nbsp;</td>
      <td height="14" align=center class="style24">&nbsp;</td>
      <td align=center class="style24">&nbsp;</td>
      <td align=center class="style24">&nbsp;</td>
      <td align=center class="style24">&nbsp;</td>
      <td align=center class="style24">&nbsp;</td>
      <td align=center class="style24">&nbsp;</td>
      <td align=center class="style24"><strong>Total Class Tutorial/Late Attendance/Make Up Test Hours</strong></td>
      <td colspan="2" align=center class="style24"><strong><?php echo  e($ttl_tutorcounthour)   ?> Hour(s) <?php echo e($ttl_tutorcountmenit)  ?> Minute(s)</strong></td>
      </tr>
<tr>
<?php //selesai data klas tutorial	 ?>     
      <td height="14" align=center class="style24">&nbsp;</td>
      <td height="14" align=center class="style24">&nbsp;</td>
      <td align=center class="style24">&nbsp;</td>
      <td align=center class="style24">&nbsp;</td>
      <td align=center class="style24">&nbsp;</td>
      <td align=center class="style24">&nbsp;</td>
      <td align=center class="style24">&nbsp;</td>
      <td align=center class="style24">&nbsp;</td>
      <td align=center class="style24">&nbsp;</td>
      <td align=center class="style24">&nbsp;</td>
    </tr>
    <tr>
<?php
$jmldurasi_jam_dihitung = 0;
$jmldurasi_menit_dihitung	= 0;		
//mulai data lc			
	$i=1;
$query_act = q_set($__p_query_act, "SELECT  v.kelas, CONCAT(date_format(v.mulai_tm,'%a, %d %b %y %H:%i' ),' - ' ,date_format(v.selesai_tm, '%H:%i' ) ), v.room, v.skill,v.mulai_tm,v.kd_branch,TIMEDIFF(date_format(selesai_tm,'%Y-%m-%d %H:%i:00'), date_format(mulai_tm,'%Y-%m-%d %H:%i:00')),v.id, v.status_kelas,TIME_FORMAT(TIMEDIFF(date_format(selesai_tm,'%Y-%m-%d %H:%i:00'), date_format(mulai_tm,'%Y-%m-%d %H:%i:00')),'%H') as durasi_jam,\r
TIME_FORMAT(TIMEDIFF(date_format(selesai_tm,'%Y-%m-%d %H:%i:00'), date_format(mulai_tm,'%Y-%m-%d %H:%i:00')),'%i') as durasi_menit,v.keterangan,otb FROM vip_teacher_schedule v left join vip_teacher_name a on v.nm_teacher = a.kd_teacher left join tb_user c on a.nm_teacher = c.nama_detail where v.mulai_tm between ? and ? and (status_kelas =  '70' or status_kelas =  '71' or status_kelas =  '75') ", [(string) ($tgl_awal) . " 00:00:00", (string) ($tgl_akhir) . " 23:00:00"]);


if ($nm_teacher == '--All--')
	{ $query_filter_act_nm_teacher = "";}
else
	{	$query_filter_act_nm_teacher = q_set($__p_query_filter_act_nm_teacher, " and v.nm_teacher = ? ", [(string) ($nm_teacher)]);}

				  
//$query_plan_act = $query_act.$query_filter_act_nm_teacher.$query_filter_act_kd_branch.$query_filter_act_activities. " group by mulai_tm order by mulai_tm " ;
$query_plan_act = q_set($__p_query_plan_act, $query_act . $query_filter_act_nm_teacher . ($query_filter_act_activities ?? '') . $query_filter_act_kelas . " group by mulai_tm order by mulai_tm ", [...($__p_query_act ?? []), ...($__p_query_filter_act_nm_teacher ?? []), ...($__p_query_filter_act_kelas ?? [])]);

	$no_urut = 1;num($jmljam) == 0;$jmljamsemua = 0;
      $result_act=db_query_or_die("Wah error nih193", $query_plan_act, $__p_query_plan_act ?? []);
if ($result_act) 
	{ 
	while ($r_act = db_fetch($result_act, PDO::FETCH_NUM))
		{ 
			
//===== lc
if (num($r_act[8]) == 71 or num($r_act[8]) == 70 or num($r_act[8]) == 75  )
{
$coord = 1; $att = 1;
}
else{$coord = 0; $att = 0;}

			if(num($att) == 1 and num($coord) ==1)
				{
				$st_jam = 'OK';
				$jmljam = num($jmljam) +  num($r_act[6]);
				$durasi_jam_dihitung =  $r_act[9];
				$durasi_menit_dihitung =  $r_act[10];
					
				$jmldurasi_jam_dihitung  = num($jmldurasi_jam_dihitung) + num($durasi_jam_dihitung);
				$jmldurasi_menit_dihitung  = num($jmldurasi_menit_dihitung) + num($durasi_menit_dihitung);

				}
			else 
				{
				$st_jam = 'Pending';
				$jmljamsemua = num($jmljamsemua) +num($r_act[6]);
				$durasi_jam_pending =  $r_act[9];
				$durasi_menit_pending =  $r_act[10];
				$jmldurasi_jam_pending  = num($jmldurasi_jam_pending) + num($durasi_jam_pending);
				$jmldurasi_menit_pending  = num($jmldurasi_menit_pending) + num($durasi_menit_pending);					
				}
		?>
		          
      <td height="14" align=center class="style24"><?php echo  e($no_urut);  ?></td>
      <td width="9%" height="14" align=center class="style24"><?php echo  e($r_act[0]);  ?></td>
      <td width="12%" align=center class="style24"><?php echo  e($r_act[1]);  ?>
        <p>&nbsp;</p></td>
      <td width="14%" align=center class="style24"><?php echo  e($r_act[2]);  ?></td>
      <td width="11%" align=center class="style24"><?php echo  e($r_act[11]);  ?></td>
      <td width="8%" align=center class="style24"><a href="vip_stuattt.php" 
target="popup" 
onclick="window.open('vip_stuattt.php?no=<?php echo e(u($r_act[7])) ?>','popup','width=1500,height=800'); return false;"><?php echo  e($att);  ?><a></a></td>
      <td width="13%" align=center class="style24"><a href="vip_crsh.php" 
target="popup" 
onclick="window.open('vip_crsh.php?kdcl=<?php echo e(u($r_act[0])) ?>&kdcbg=<?php echo e(u($r_act[5])) ?>','popup','width=1000,height=800'); return false;"><?php echo  e($coord);  ?></a></td>
      <td width="13%" align=center class="style24"><?php echo  e($r_act[6])  ?></td>
      <td width="18%" align=center class="style24"><a href="#" 
target="popup" 
onclick="window.open('vip_otbupd.php?no=<?php echo e(u($r_act[7])) ?>','popup','width=800,height=800'); return false;"><?php echo  e($r_act[12])  ?></a></td>
      <td width="18%" align=center class="style24"><?php echo  e($st_jam)  ?> </td>
    </tr>
    
    <?php $no_urut = num($no_urut) +1; $coord =0;$att=0;$ttl_angka_otb = num($ttl_angka_otb)+num($r_act[12]); }}
	$ttl_lccountmenit = $jmldurasi_menit_dihitung;		
	$ttl_lccountmenitsaja =num($ttl_lccountmenit)%60;
	$ttl_lccountmenitkejam = num((num($ttl_lccountmenit) - num($ttl_lccountmenitsaja)))/60;

		$ttl_lccountmenit =$ttl_lccountmenitsaja;	
	
	$ttl_lccounthour = num($jmldurasi_jam_dihitung)+num($ttl_lccountmenitkejam);
  
	  ?>
<tr>
      <td height="14" align=center class="style24">&nbsp;</td>
      <td height="14" align=center class="style24">&nbsp;</td>
      <td align=center class="style24">&nbsp;</td>
      <td align=center class="style24">&nbsp;</td>
      <td align=center class="style24">&nbsp;</td>
      <td align=center class="style24">&nbsp;</td>
      <td align=center class="style24">&nbsp;</td>
      <td align=center class="style24"><strong>Total Teaching and LC Hours</strong></td>
      <td colspan="2" align=center class="style24"><strong><?php echo  e($ttl_lccounthour)   ?> Hour(s) <?php echo e($ttl_lccountmenit)  ?> Minute(s)</strong></td>
      </tr>
<tr>
<?php
$jmldurasi_jam_dihitung = 0;
$jmldurasi_menit_dihitung	= 0;		
//mulai data lc			
	$i=1;
$query_act = q_set($__p_query_act, "SELECT  v.kelas, CONCAT(date_format(v.mulai_tm,'%a, %d %b %y %H:%i' ),' - ' ,date_format(v.selesai_tm, '%H:%i' ) ), v.room, v.skill,v.mulai_tm,v.kd_branch,TIMEDIFF(date_format(selesai_tm,'%Y-%m-%d %H:%i:00'), date_format(mulai_tm,'%Y-%m-%d %H:%i:00')),v.id, v.status_kelas,TIME_FORMAT(TIMEDIFF(date_format(selesai_tm,'%Y-%m-%d %H:%i:00'), date_format(mulai_tm,'%Y-%m-%d %H:%i:00')),'%H') as durasi_jam,\r
TIME_FORMAT(TIMEDIFF(date_format(selesai_tm,'%Y-%m-%d %H:%i:00'), date_format(mulai_tm,'%Y-%m-%d %H:%i:00')),'%i') as durasi_menit,v.keterangan, v.pic,v.otb FROM vip_teacher_schedule v left join vip_teacher_name a on v.nm_teacher = a.kd_teacher left join tb_user c on a.nm_teacher = c.nama_detail where v.mulai_tm between ? and ? and (status_kelas =  '80' or status_kelas =  '81') ", [(string) ($tgl_awal) . " 00:00:00", (string) ($tgl_akhir) . " 23:00:00"]);


if ($nm_teacher == '--All--')
	{ $query_filter_act_nm_teacher = "";}
else
	{	$query_filter_act_nm_teacher = q_set($__p_query_filter_act_nm_teacher, " and v.nm_teacher = ? ", [(string) ($nm_teacher)]);}

				  
//$query_plan_act = $query_act.$query_filter_act_nm_teacher.$query_filter_act_kd_branch.$query_filter_act_activities. " group by mulai_tm order by mulai_tm " ;
$query_plan_act = q_set($__p_query_plan_act, $query_act . $query_filter_act_nm_teacher . ($query_filter_act_activities ?? '') . $query_filter_act_kelas . " group by mulai_tm order by mulai_tm ", [...($__p_query_act ?? []), ...($__p_query_filter_act_nm_teacher ?? []), ...($__p_query_filter_act_kelas ?? [])]);

	$no_urut = 1;num($jmljam) == 0;$jmljamsemua = 0;
      $result_act=db_query_or_die("Wah error nih193", $query_plan_act, $__p_query_plan_act ?? []);
if ($result_act) 
	{ 
	while ($r_act = db_fetch($result_act, PDO::FETCH_NUM))
		{ 
			
//===== lc
if (num($r_act[8]) == 80 or num($r_act[8]) == 81   )
{
$coord = 1; $att = 1;
}
else{$coord = 0; $att = 0;}

			if(num($att) == 1 and num($coord) ==1)
				{
				$st_jam = 'OK';
				$jmljam = num($jmljam) +  num($r_act[6]);
				$durasi_jam_dihitung =  $r_act[9];
				$durasi_menit_dihitung =  $r_act[10];
					
				$jmldurasi_jam_dihitung  = num($jmldurasi_jam_dihitung) + num($durasi_jam_dihitung);
				$jmldurasi_menit_dihitung  = num($jmldurasi_menit_dihitung) + num($durasi_menit_dihitung);

				}
			else 
				{
				$st_jam = 'Pending';
				$jmljamsemua = num($jmljamsemua) +num($r_act[6]);
				$durasi_jam_pending =  $r_act[9];
				$durasi_menit_pending =  $r_act[10];
				$jmldurasi_jam_pending  = num($jmldurasi_jam_pending) + num($durasi_jam_pending);
				$jmldurasi_menit_pending  = num($jmldurasi_menit_pending) + num($durasi_menit_pending);					
				}
		?>
		          
      <td height="14" align=center class="style24"><?php echo  e($no_urut);  ?></td>
      <td width="9%" height="14" align=center class="style24"><?php echo  e($r_act[0]);  ?><br>
by <?php echo e($r_act[12]); ?></td>
      <td width="12%" align=center class="style24"><?php echo  e($r_act[1]);  ?>
        <p>&nbsp;</p></td>
      <td width="14%" align=center class="style24"><?php echo  e($r_act[2]);  ?></td>
      <td width="11%" align=center class="style24"><?php echo  e($r_act[11]);  ?></td>
      <td width="8%" align=center class="style24"><a href="vip_stuattt.php" 
target="popup" 
onclick="window.open('vip_stuattt.php?no=<?php echo e(u($r_act[7])) ?>','popup','width=1500,height=800'); return false;"><?php echo  e($att);  ?><a></a></td>
      <td width="13%" align=center class="style24"><a href="vip_crsh.php" 
target="popup" 
onclick="window.open('vip_crsh.php?kdcl=<?php echo e(u($r_act[0])) ?>&kdcbg=<?php echo e(u($r_act[5])) ?>','popup','width=1000,height=800'); return false;"><?php echo  e($coord);  ?></a></td>
      <td width="13%" align=center class="style24"><?php echo  e($r_act[6])  ?></td>
      <td width="18%" align=center class="style24"><a href="#" 
target="popup" 
onclick="window.open('vip_otbupd.php?no=<?php echo e(u($r_act[7])) ?>','popup','width=800,height=800'); return false;"><?php echo  e($r_act[13])  ?></a></td>
      <td width="18%" align=center class="style24"><?php echo  e($st_jam)  ?> </td>
    </tr>
    
    <?php $no_urut = num($no_urut) +1; $coord =0;$att=0; $ttl_angka_otb = num($ttl_angka_otb)+num($r_act[13]); }}
	$ttl_pt_countmenit = $jmldurasi_menit_dihitung;	 	
	$ttl_pt_countmenitsaja =num($ttl_pt_countmenit)%60;
	$ttl_pt_countmenitkejam = num((num($ttl_pt_countmenit) - num($ttl_pt_countmenitsaja)))/60;

		$ttl_pt_countmenit =$ttl_pt_countmenitsaja;	
	
	
	$ttl_pt_counthour = num($jmldurasi_jam_dihitung)+num($ttl_pt_countmenitkejam);
 
	  ?>
<tr>
      <td height="14" align=center class="style24">&nbsp;</td>
      <td height="14" align=center class="style24">&nbsp;</td>
      <td align=center class="style24">&nbsp;</td>
      <td align=center class="style24">&nbsp;</td>
      <td align=center class="style24">&nbsp;</td>
      <td align=center class="style24">&nbsp;</td>
      <td align=center class="style24">&nbsp;</td>
      <td align=center class="style24"><strong>Total Placement Test Hours</strong></td>
      <td colspan="2" align=center class="style24"><strong><?php echo  e($ttl_pt_counthour)   ?> Hour(s) <?php echo e($ttl_pt_countmenit)  ?> Minute(s)</strong></td>
      </tr>
	  <tr>
<?php
$jmldurasi_jam_dihitung = 0;
$jmldurasi_menit_dihitung	= 0;					
//mulai non teaching lc			
	$i=1;
$query_act = q_set($__p_query_act, "SELECT  v.kelas, CONCAT(date_format(v.mulai_tm,'%a, %d %b %y %H:%i' ),' - ' ,date_format(v.selesai_tm, '%H:%i' ) ), v.room, v.skill,v.mulai_tm,v.kd_branch,TIMEDIFF(date_format(selesai_tm,'%Y-%m-%d %H:%i:00'), date_format(mulai_tm,'%Y-%m-%d %H:%i:00')),v.id, v.status_kelas,TIME_FORMAT(TIMEDIFF(date_format(selesai_tm,'%Y-%m-%d %H:%i:00'), date_format(mulai_tm,'%Y-%m-%d %H:%i:00')),'%H') as durasi_jam,\r
TIME_FORMAT(TIMEDIFF(date_format(selesai_tm,'%Y-%m-%d %H:%i:00'), date_format(mulai_tm,'%Y-%m-%d %H:%i:00')),'%i') as durasi_menit,keterangan,otb FROM vip_teacher_schedule v left join vip_teacher_name a on v.nm_teacher = a.kd_teacher left join tb_user c on a.nm_teacher = c.nama_detail where v.mulai_tm between ? and ? and \r
(status_kelas like '22' or status_kelas like '33' or status_kelas like '44'   or status_kelas = '66'   or status_kelas = '222'   or status_kelas = '888'   or status_kelas = '899'   or status_kelas = '898'   or status_kelas = '897'   or status_kelas = '896'    or status_kelas = '999') ", [(string) ($tgl_awal) . " 00:00:00", (string) ($tgl_akhir) . " 23:00:00"]);

	
if ($nm_teacher == '--All--')
	{ $query_filter_act_nm_teacher = "";}
else
	{	$query_filter_act_nm_teacher = q_set($__p_query_filter_act_nm_teacher, " and v.nm_teacher = ? ", [(string) ($nm_teacher)]);}

				  
$query_plan_act = q_set($__p_query_plan_act, $query_act . $query_filter_act_nm_teacher . $query_filter_act_kd_branch . ($query_filter_act_activities ?? '') . $query_filter_act_kelas . " group by mulai_tm order by mulai_tm ", [...($__p_query_act ?? []), ...($__p_query_filter_act_nm_teacher ?? []), ...($__p_query_filter_act_kd_branch ?? []), ...($__p_query_filter_act_kelas ?? [])]);


	$no_urut = 1;num($jmljam) == 0;$jmljamsemua = 0;
      $result_act=db_query_or_die("Wah error nih194", $query_plan_act, $__p_query_plan_act ?? []);
if ($result_act) 
	{ 
	while ($r_act = db_fetch($result_act, PDO::FETCH_NUM))
		{ 
			
//==attendance
//$query_att = "SELECT sum(st_attendance) FROM vip_attendance where kd_class = '$r_act[0]' and dt_meeting = '$r_act[4]'";
$query_att = q_set($__p_query_att, "SELECT kd_biodata FROM vip_attendance where kd_class = ? and dt_meeting = ? ", [(string) ($r_act[0]), (string) ($r_act[4])]);
			
$result_att=db_query_or_die("Wah error nih20", $query_att, $__p_query_att ?? []);
$diabsen = db_num_rows($result_att);

	if (num($diabsen) ==0) {$att = 0;}else{$att = 1;}

if (num($r_act[8]) == 1)
{
$query_coord = q_set($__p_query_coord, "SELECT v.kd_class, v.tgl_meeting, v.subject, v.coverage, v.material, v.assignment FROM vip_cosheet v where kd_class = ? and tgl_meeting = ? and  subject <> ''and coverage <> ''and v.material <> ''and v.assignment <> ''", [(string) ($r_act[0]), (string) ($r_act[4])]);

$result_coord=db_query_or_die("Wah error nih21", $query_coord, $__p_query_coord ?? []);			
$jml = db_num_rows($result_coord);			
if (num($jml) >= 1) 	{$coord = 1;}else{$coord = 0;}
}
elseif (num($r_act[8]) == 51 or num($r_act[8]) == 61  or num($r_act[8]) == 55 )
{
$query_coord = q_set($__p_query_coord, "SELECT v.kd_class, v.tgl_meeting FROM vip_tutor v where v.kd_class =  ? and tgl_meeting = ? ", [(string) ($r_act[0]), (string) ($r_act[4])]);
$result_coord=db_query_or_die("Wah error nih21", $query_coord, $__p_query_coord ?? []);			
$jml = db_num_rows($result_coord);			
if (num($jml) >= 1) 	{$coord = 1; $att = 1;}else{$coord = 0;}	
}
	

			
			if(num($att) == 1 and num($coord) ==1)
				{
				$st_jam = 'OK';
				$jmljam = num($jmljam) +  num($r_act[6]);
				$durasi_jam_dihitung =  $r_act[9];
				$durasi_menit_dihitung =  $r_act[10];
					
				$jmldurasi_jam_dihitung  = num($jmldurasi_jam_dihitung) + num($durasi_jam_dihitung);
				$jmldurasi_menit_dihitung  = num($jmldurasi_menit_dihitung) + num($durasi_menit_dihitung);
	
				}
			else 
				{
				$st_jam = 'Pending';
				$jmljamsemua = num($jmljamsemua) +num($r_act[6]);
				$durasi_jam_pending =  $r_act[9];
				$durasi_menit_pending =  $r_act[10];
//				$jmldurasi_jam_pending  = $jmldurasi_jam_pending + $durasi_jam_pending;
//				$jmldurasi_menit_pending  = $jmldurasi_menit_pending + $durasi_menit_pending;					
				$jmldurasi_jam_dihitung  = num($jmldurasi_jam_dihitung) + num($durasi_jam_dihitung);
				$jmldurasi_menit_dihitung  = num($jmldurasi_menit_dihitung) + num($durasi_menit_dihitung);					
				}
		?>
		          
      <td height="14" align=center class="style24"><?php echo  e($no_urut);  ?></td>
      <td width="9%" height="14" align=center class="style24"><?php echo  e($r_act[0]);  ?><br>        <br></td>
      <td width="12%" align=center class="style24"><?php echo  e($r_act[1]);  ?></td>
      <td width="14%" align=center class="style24"><?php echo  e($r_act[2]);  ?></td>
      <td width="11%" align=center class="style24"><?php echo  e($r_act[11]);  ?></td>
      <td width="8%" align=center class="style24"><a href="vip_stuattt.php" 
target="popup" 
onclick="window.open('vip_stuattt.php?no=<?php echo e(u($r_act[7])) ?>','popup','width=1500,height=800'); return false;"><?php echo  e($att);  ?><a></a></td>
      <td width="13%" align=center class="style24"><a href="vip_crsh.php" 
target="popup" 
onclick="window.open('vip_crsh.php?kdcl=<?php echo e(u($r_act[0])) ?>&kdcbg=<?php echo e(u($r_act[5])) ?>','popup','width=1000,height=800'); return false;"><?php echo  e($coord);  ?></a></td>
      <td width="13%" align=center class="style24"><?php echo  e($r_act[6])  ?></td>
      <td width="18%" align=center class="style24"><a href="#" 
target="popup" 
onclick="window.open('vip_otbupd.php?no=<?php echo e(u($r_act[7])) ?>','popup','width=800,height=800'); return false;"><?php echo  e($r_act[12])  ?></a></td>
      <td width="18%" align=center class="style24"><?php echo  e($st_jam)  ?> </td>
    </tr> 
    <?php $no_urut = num($no_urut) +1; $coord =0;$att=0; $ttl_angka_otb = num($ttl_angka_otb)+num($r_act[12]); }}
		$ttl_non_teachingcountmenit = $jmldurasi_menit_dihitung; 
	$ttl_non_teachingcountmenitsaja =num($ttl_non_teachingcountmenit)%60;
	$ttl_non_teachingcountmenitkejam = num((num($ttl_non_teachingcountmenit) - num($ttl_non_teachingcountmenitsaja)))/60;

		$ttl_non_teachingcountmenit =$ttl_non_teachingcountmenitsaja;		
		$ttl_non_teachingcounthour = num($jmldurasi_jam_dihitung)+num($ttl_non_teachingcountmenitkejam);
	
	
 $ttl_sum_teachingcountmenit = num($ttl_regpricountmenit)  + num($ttl_tutorcountmenit) + num($ttl_lccountmenit) + num($ttl_pt_countmenit); 

	$ttl_sum_teachingcountmenitsaja =num($ttl_sum_teachingcountmenit)%60;
	$ttl_sum_teachingcountmenitkejam = num((num($ttl_sum_teachingcountmenit) - num($ttl_sum_teachingcountmenitsaja)))/60;

$ttl_sum_teachingcounthour = num($ttl_regpricounthour) + num($ttl_tutorcounthour) + num($ttl_lccounthour) + num($ttl_pt_counthour)+num($ttl_sum_teachingcountmenitkejam);
	
$otb_hour = floor(num($ttl_angka_otb) / 60);
$otb_minut = num($ttl_angka_otb) - num((num($otb_hour) * 60));

	  ?>

    <tr>
      <td height="14" align=center class="style24">&nbsp;</td>
      <td height="14" align=center class="style24">&nbsp;</td>
      <td align=center class="style24">&nbsp;</td>
      <td align=center class="style24">&nbsp;</td>
      <td align=center class="style24">&nbsp;</td>
      <td align=center class="style24">&nbsp;</td>
      <td align=center class="style24">&nbsp;</td>
      <td align=center class="style24"><strong>Total Non Teaching Count</strong></td>
      <td colspan="2" align=center class="style24"><strong><?php echo  e($ttl_non_teachingcounthour)  ?> Hour(s) <?php echo e($ttl_non_teachingcountmenit) ?> Minute(s)</strong></td>
      </tr>
<tr>
  <td height="14" colspan="10" align=center class="style24"><hr></td>
  </tr>
<tr>
  <td height="14" align=center class="style24">&nbsp;</td>
  <td height="14" align=center class="style24">&nbsp;</td>
  <td align=center class="style24">&nbsp;</td>
  <td align=center class="style24">&nbsp;</td>
  <td align=center class="style24">&nbsp;</td>
  <td align=center class="style24">&nbsp;</td>
  <td colspan="2" align=center class="style24"><strong>Total Overtime Beyond </strong></td>
  <td colspan="2" align=center class="style24"><strong><?php echo  e($otb_hour)  ?> Hour(s) <?php echo e($otb_minut) ?> Minute(s)</strong></td>
</tr>
<tr>
  <td height="14" align=center class="style24">&nbsp;</td>
  <td height="14" align=center class="style24">&nbsp;</td>
  <td align=center class="style24">&nbsp;</td>
  <td align=center class="style24">&nbsp;</td>
  <td align=center class="style24">&nbsp;</td>
  <td align=center class="style24">&nbsp;</td>
  <td align=center class="style24">&nbsp;</td>
  <td align=center class="style24"><strong>Total Teaching Hours Summary</strong></td>
  <td colspan="2" align=center class="style24"><strong><?php echo  e($ttl_sum_teachingcounthour)  ?> Hour(s) <?php echo e($ttl_sum_teachingcountmenit) ?> Minute(s)</strong></td>
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
<?php
if (isset($_GET['Print'])) 
	{
	if ($idb !='')
		{
		
			echo "<script type=\"text/javascript\">\n";
			echo "window.open('vip_tchhourrptpdf.php?kd_cbg=" . e(u($kd_cbg)) . "&tgl_awal=" . e(u($date_start)) . "&tgl_akhir=" . e(u($date_end)) . "&nm_teacher=" . e(u($nm_teacher)) . "&kelas=" . e(u($kelas)) . "','width=560,height=340,toolbar=0,menubar=0,location=0');\n";				
			echo "</script>";		

		}
	}
?>
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
