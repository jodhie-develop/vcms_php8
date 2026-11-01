<?php
require_once __DIR__ . "/_lib/bootstrap.php"; auth_require_login(); 
date_default_timezone_set('Asia/Jakarta');
include __DIR__ . "/conndb.php";
include __DIR__ . "/profiledata.php";
 
$hari=date("d");
$bulan=date("m");
$tahun=date("Y");
$hari_ini = "$tahun-$bulan-$hari";
$date_start = in_val('tgl_awal', 'get');
$date_end = in_val('tgl_akhir', 'get');

//$awal_tampil =  date_format($date_start,"d-m-Y");

$nama_lengkap = $_SESSION['nama_lengkap'];
$nama_depan = $_SESSION['nama_depan'];

$kd_cbg = $_SESSION['kd_branch'];
$posisi = $_SESSION['posisi']; 
$kd_staff = $_SESSION['kd_staff'] ;
$kd_area = $_SESSION['kode_area'] ;
$kelompok = $_SESSION['kelompok'];

$tgl_awal = in_val('tgl_awal', 'get');
$tgl_akhir = in_val('tgl_akhir', 'get');
$activities = in_val('activities', 'get');
$kelas = in_val('kelas', 'get');
$kd_cbg = $_SESSION['kd_branch'];
$nm_teacher = in_val('nm_teacher', 'get');	
$tgl_awal = in_val('tgl_awal', 'get');
$tgl_akhir = in_val('tgl_akhir', 'get');
$query_nama_teacher = q_set($__p_query_nama_teacher, "SELECT nm_teacher,com_hr FROM ves_data.vip_teacher_name where kd_teacher = ? ", [(string) ($nm_teacher)]);
 $result_nama=db_query_or_die("Wah error nih191", $query_nama_teacher, $__p_query_nama_teacher ?? []);
if ($result_nama) 
	{ 
	while ($r_nama = db_fetch($result_nama, PDO::FETCH_NUM))
		{ 
		$nama_lengkap_teacher = $r_nama[0];
		$compulsary = $r_nama[1];		
		}
	}
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?php echo e($nama_lengkap_teacher) . "-" . e($date_start) . "-" . e($date_end) ?> </title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="cdnjs/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/AdminLTE.min.css">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
</head>
<body onload="window.print();">  
<div class="content">
  <!-- Main content -->

    <!-- title row -->
    <div class="row">
      <div class="col-xs-12">
        <h2 class="page-header">
<h4>Teaching Hour Report</h4>			
        </h2>
      </div>
      <!-- /.col -->
    </div>
    <!-- info row -->
    <div class="row invoice-info">
      <div class="col-sm-4 invoice-col">
        <address>
          <strong><?php echo e($nama_lengkap_teacher) ?></strong><br>
          Period : <?php echo e($date_start) ?> to <?php echo e($date_end) ?></label>
		  <br>
        </address>
      </div>
      <div class="col-sm-4 invoice-col">
        <address>
          <strong>Compulsary Teaching Hour : <?php echo e($compulsary) ?></strong>
  </label>
  <br>
        </address>
      </div>
      <!-- /.col --><!-- /.col --><!-- /.col -->
    </div>
    <!-- /.row -->

    <!-- Table row -->
    <div class="row">
      <div class="col-xs-12 table-responsive">
        <hr>
        <table class="table table-striped">
          <thead>
          <tr>
            <th>No</th>
            <th colspan="2">Class Code</th>
            <th align=center colspan="3">Day &amp; Date</th>
            <th>Skill</th>
            <th>Duration</th>
            <th>OTB</th>
            <th colspan="2">Status</th>
            </tr>
          </thead>
          <tbody>
 <tr>
<?php
			
//mulai data klas reguler/private			
	$i=1;
$query_plan_act = q_set($__p_query_plan_act, "SELECT  v.kelas, CONCAT(date_format(v.mulai_tm,'%a, %d %b %y %H:%i' ),' - ' ,date_format(v.selesai_tm, '%H:%i' ) ), v.room,\r
 v.skill,v.mulai_tm,v.kd_branch,TIMEDIFF(date_format(selesai_tm,'%Y-%m-%d %H:%i:00'), date_format(mulai_tm,'%Y-%m-%d %H:%i:00')),v.id,\r
  v.status_kelas,TIME_FORMAT(TIMEDIFF(date_format(selesai_tm,'%Y-%m-%d %H:%i:00'), date_format(mulai_tm,'%Y-%m-%d %H:%i:00')),'%H') as durasi_jam,\r
   TIME_FORMAT(TIMEDIFF(date_format(selesai_tm,'%Y-%m-%d %H:%i:00'), date_format(mulai_tm,'%Y-%m-%d %H:%i:00')),'%i') as durasi_menit,id,\r
(case when v.kd_branch = 1 then 'East Sby'\r
when v.kd_branch = 2 then 'West Sby'\r
when v.kd_branch = 3 then 'Denpasar'\r
when v.kd_branch = 4 then 'South Jkt'\r
when v.kd_branch = 5 then 'North Jkt'\r
when v.kd_branch = 6 then 'SOHO'\r
when v.kd_branch = 7 then 'Bandung'\r
when v.kd_branch = 8 then 'Malang'\r
when v.kd_branch = 11 then 'PIK'\r
when v.kd_branch = 12 then 'Serpong'\r
when v.kd_branch = 100 then 'National'\r
end) as nm_branch, \r
(case when v.type_kelas = 'Hybrid' then 1 \r
when  v.type_kelas = 'Offline' then 2\r
when  v.type_kelas = 'Online' then 3 end ) as kd_type_kelas, v.type_kelas,v.otb\r
 FROM vip_teacher_schedule v left join vip_teacher_name a on v.nm_teacher = a.kd_teacher left join tb_user c on a.nm_teacher = c.nama_detail where v.mulai_tm between ? and ? and (status_kelas = 1 or status_kelas = 601) and v.nm_teacher = ?  group by mulai_tm order by mulai_tm  ", [(string) ($tgl_awal) . " 00:00:00", (string) ($tgl_akhir) . " 23:00:00", (string) ($nm_teacher)]);


//$query_act = "SELECT id,  date_format(v.mulai_tm,'%d %b %y'), a.nm_teacher , date_format(v.mulai_tm,'%H:%i'), date_format(v.selesai_tm,'%H:%i'), v.kelas, v.room, v.keterangan ,v.center,v.status_kelas,v.id,v.pic,date_format(v.dt_entry,'%d %b %y'),d.nama_lengkap FROM vip_teacher_schedule v left join vip_teacher_name a on v.nm_teacher = a.kd_teacher left join tb_user c on a.nm_teacher = c.nama_detail left join vip_student_data d on v.kd_biodata = d.kd_biodata" ;

//$query_plan_act = $query_act.$query_filter_act_nm_teacher.$query_filter_act_kd_branch.$query_filter_act_activities. " group by mulai_tm order by mulai_tm " ;


	$no_urut = 1;num($jmljam) == 0;$jmljamsemua = 0;
      $result_act=db_query_or_die("Wah error nih191", $query_plan_act, $__p_query_plan_act ?? []);
if ($result_act) 
	{ 
	while ($r_act = db_fetch($result_act, PDO::FETCH_NUM))
		{ 
	
		$otb = $r_act[15];$ttl_otb = num($ttl_otb)+num($otb);
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
elseif ($r_act[8]=='601'){$coord = 1; $att = 1;}			

			
if(num($att) == 1 and num($coord) ==1)
	{
	$st_jam = 'OK';
	$jmljam = num($jmljam) +  num($r_act[6]);
	$durasi_jam_dihitung =  $r_act[9];
	$durasi_menit_dihitung =  $r_act[10];

	$jmldurasi_jam_dihitung  = num($jmldurasi_jam_dihitung) + num($durasi_jam_dihitung);
	$jmldurasi_menit_dihitung  = num($jmldurasi_menit_dihitung) + num($durasi_menit_dihitung);
		if(num($r_act[13]) == 1)
			{
			$jmldurasi_jam_dihitung_hybrid  = num($jmldurasi_jam_dihitung_hybrid) + num($durasi_jam_dihitung);
			$jmldurasi_menit_dihitung_hybrid  = num($jmldurasi_menit_dihitung_hybrid) + num($durasi_menit_dihitung);
			}
		elseif(num($r_act[13]) == 2)
			{
			$jmldurasi_jam_dihitung_offline  = num($jmldurasi_jam_dihitung_offline) + num($durasi_jam_dihitung);
			$jmldurasi_menit_dihitung_offline  = num($jmldurasi_menit_dihitung_offline) + num($durasi_menit_dihitung);
			}
		elseif(num($r_act[13]) == 3)
			{
			$jmldurasi_jam_dihitung_online  = num($jmldurasi_jam_dihitung_online) + num($durasi_jam_dihitung);
			$jmldurasi_menit_dihitung_online  = num($jmldurasi_menit_dihitung_online) + num($durasi_menit_dihitung);
			}
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
	
if ($st_jam== 'OK'){		
		?>
		          
      <td height="14" align=center class="style24" style=font-size:12px><?php echo  e($no_urut);  ?></td>
      <td height="14" colspan="2" align=center class="style24"><?php echo  e($r_act[0]);  ?><br>
<?php echo e($r_act[12]) ?> - <?php echo e($r_act[14]) ?></td>
      <td colspan="3" align=center class="style24"><?php echo  e($r_act[1]);  ?></td>
      <td width="13%" align=center class="style24"><?php echo  e($r_act[3]);  ?></td>
      <td width="13%" align=center class="style24"><?php echo  e($r_act[6])  ?></td>
      <td width="13%" align=center class="style24"><?php echo  e($otb)  ?></td>
      <td width="18%" colspan="2" align=center class="style24"><?php echo  e($st_jam)  ?> </td>
<?php }?>		
    </tr>
    
    <?php $no_urut = num($no_urut) +1; $coord =0;$att=0;  }}
	$ttl_regpricounthour = $jmldurasi_jam_dihitung;
//	$ttl_regpricountmenit = $jmldurasi_menit_dihitung;  
	$ttl_regpricountmadarimenit = floor (num($jmldurasi_menit_dihitung)/60);
	$ttl_regpricountmenit = num($jmldurasi_menit_dihitung) - num((num($ttl_regpricountmadarimenit)*60));
	$ttl_regpricounthour = num($ttl_regpricounthour) + num($ttl_regpricountmadarimenit);		
// offline			  

//=====			  
			  
			  
	if(num($ttl_regpricounthour) >=1 or num($ttl_regpricountmenit) >=1){
	$ttl_regpricountmadarimenit_offline = floor (num($jmldurasi_menit_dihitung_offline)/60); 

	$jml_jam_offline_dari_online = 	floor (num($jmldurasi_menit_dihitung_offline)/60); 
	$jml_sisa_menit_offline = 	num($jmldurasi_menit_dihitung_offline) - num((num($jml_jam_offline_dari_online)*60)); 


	//echo $jmldurasi_menit_dihitung_offline;die;
	$jmldurasi_menit_dihitung_offline = $jml_sisa_menit_offline;
	$jmldurasi_jam_dihitung_offline = num($jmldurasi_jam_dihitung_offline) + num($jml_jam_offline_dari_online);

	$jml_jam_online_dari_online = floor(num($jmldurasi_menit_dihitung_online)/60);	
	$jml_sisa_menit_online = 	num($jmldurasi_menit_dihitung_online) - num((num($jml_jam_online_dari_online)*60)); 
		
	$jmldurasi_menit_dihitung_online = $jml_sisa_menit_online;
	$jmldurasi_jam_dihitung_online = num($jmldurasi_jam_dihitung_online) + num($jml_jam_online_dari_online);		
		
		
		
//$jmldurasi_jam_dihitung_online  = $jmldurasi_jam_dihitung_online + $durasi_jam_dihitung;
	
		
//$jmldurasi_jam_dihitung_online = $jmldurasi_jam_dihitung_online  + $jml_jam_online_dari_menit_online;
//$jmldurasi_menit_dihitung_online = $jmldurasi_menit_dihitung_online - ($jml_jam_online_dari_menit_online*60);
 $ttl_sum_teachingcountmenit = num($ttl_regpricountmenit)  + num($ttl_tutorcountmenit) + num($ttl_lccountmenit) + num($ttl_pt_countmenit); 

//	$ttl_sum_teachingcountmenitsaja =$ttl_sum_teachingcountmenit%60;
//	$ttl_sum_teachingcountmenitkejam = ($ttl_sum_teachingcountmenit - $ttl_sum_teachingcountmenitsaja)/60; 
//	if ($ttl_sum_teachingcountmenit ==60){$ttl_sum_teachingcountmenit =0;}
		
	

$ttl_sum_teachingcounthour = num($ttl_regpricounthour) + num($ttl_tutorcounthour) + num($ttl_lccounthour) + num($ttl_pt_counthour)+num($ttl_sum_teachingcountmenitkejam) + num($ttl_non_teachingcountmenitkejam);			  ?>
<tr>
      <td height="14" colspan="7" align=right class="style24"><strong>Total Hybrid Class Reguler/Private Count</strong></td>
      <td colspan="4" align=right class="style24"><strong><?php echo  e($jmldurasi_jam_dihitung_hybrid)  ?> Hour(s) <?php echo e($jmldurasi_menit_dihitung_hybrid) ?> Minute(s)</strong></td>
      </tr>
<tr>
      <td height="14" colspan="7" align=right class="style24"><strong>Total Offline Class Reguler/Private Count</strong></td>
      <td colspan="4" align=right class="style24"><strong><?php echo  e($jmldurasi_jam_dihitung_offline)  ?> Hour(s) <?php echo e($jmldurasi_menit_dihitung_offline) ?> Minute(s)</strong></td>
      </tr>			  
<tr>
  <td height="14" colspan="7" align=right class="style24"><strong>Total Online Class Reguler/Private Count</strong></td>
  <td colspan="4" align=right class="style24"><strong><?php echo  e($jmldurasi_jam_dihitung_online)  ?> Hour(s) <?php echo e($jmldurasi_menit_dihitung_online) ?> Minute(s)</strong></td>
  </tr>			  
<tr>
  <td height="14" colspan="7" align=right class="style24"><strong>Total Class Reguler/Private Count</strong></td>
  <td colspan="4" align=right class="style24"><strong><?php echo  e($ttl_otbcounthour)  ?> Hour(s) <?php echo e($ttl_otbcountmenit) ?> Minute(s)</strong></td>
</tr>
<tr>
      <td height="14" colspan="7" align=right class="style24"><strong>Total OTB Count</strong></td>
      <td colspan="4" align=right class="style24"><strong><?php echo  e($otb_hour)  ?> Hour(s) <?php echo e($otb_minut) ?> Minute(s)</strong></td>
      </tr>			  
<tr>
<?php }//selesai data klas reguler/private	 ?>     
      <td height="14" align=center class="style24">&nbsp;</td>
      <td width="9%" height="14" align=center class="style24">&nbsp;</td>
      <td width="12%" align=center class="style24">&nbsp;</td>
      <td width="14%" align=center class="style24">&nbsp;</td>
      <td width="11%" align=center class="style24">&nbsp;</td>
      <td width="8%" align=center class="style24">&nbsp;</td>
      <td align=center class="style24">&nbsp;</td>
      <td colspan="2" align=center class="style24">&nbsp;</td>
      <td colspan="2" align=center class="style24">&nbsp;</td>
    </tr>
    <tr>
<?php
			$jmldurasi_jam_dihitung = 0;
$jmldurasi_menit_dihitung	= 0;	
//mulai data tutorial/late attendance			
	$i=1;
$query_act = q_set($__p_query_act, "SELECT  v.kelas, CONCAT(date_format(v.mulai_tm,'%a, %d %b %y %H:%i' ),' - ' ,date_format(v.selesai_tm, '%H:%i' ) ), v.room, v.skill,v.mulai_tm,v.kd_branch,TIMEDIFF(date_format(selesai_tm,'%Y-%m-%d %H:%i:00'), date_format(mulai_tm,'%Y-%m-%d %H:%i:00')),v.id, v.status_kelas,TIME_FORMAT(TIMEDIFF(date_format(selesai_tm,'%Y-%m-%d %H:%i:00'), date_format(mulai_tm,'%Y-%m-%d %H:%i:00')),'%H') as durasi_jam,\r
TIME_FORMAT(TIMEDIFF(date_format(selesai_tm,'%Y-%m-%d %H:%i:00'), date_format(mulai_tm,'%Y-%m-%d %H:%i:00')),'%i') as durasi_menit FROM vip_teacher_schedule v left join vip_teacher_name a on v.nm_teacher = a.kd_teacher left join tb_user c on a.nm_teacher = c.nama_detail where v.mulai_tm between ? and ? and (status_kelas like '50' or status_kelas like '51' or status_kelas like '55' or status_kelas = '60' or status_kelas = '61' or status_kelas = '65'    or status_kelas = '91' or status_kelas = '40' or status_kelas = '41' or status_kelas = '45'  or status_kelas = '897'  or status_kelas = '306'  or status_kelas = '307') ", [(string) ($tgl_awal) . " 00:00:00", (string) ($tgl_akhir) . " 23:00:00"]);

	
if ($nm_teacher == '--All--')
	{ $query_filter_act_nm_teacher = "";}
else
	{	$query_filter_act_nm_teacher = q_set($__p_query_filter_act_nm_teacher, " and v.nm_teacher = ? ", [(string) ($nm_teacher)]);}

				  
$query_plan_act = q_set($__p_query_plan_act, $query_act . $query_filter_act_nm_teacher . ($query_filter_act_kd_branch ?? '') . ($query_filter_act_activities ?? '') . ($query_filter_act_kelas ?? '') . " group by mulai_tm order by mulai_tm ", [...($__p_query_act ?? []), ...($__p_query_filter_act_nm_teacher ?? [])]);


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
elseif ( num($r_act[8]) == 51 or num($r_act[8]) == 52 or num($r_act[8]) == 61  or num($r_act[8]) == 55 or num($r_act[8]) == 65 or num($r_act[8]) == 40 or num($r_act[8]) == 41 or num($r_act[8]) == 45 or num($r_act[8]) == 897 or num($r_act[8]) == 91)
{
//$query_coord = "SELECT v.kd_class, v.tgl_meeting FROM vip_tutor v where v.kd_class =  '$r_act[0]' and tgl_meeting = '$r_act[4]'";
$query_coord = q_set($__p_query_coord, "SELECT v.kd_class, v.tgl_meeting FROM vip_cosheet v where v.kd_class =  ? and tgl_meeting = ? ", [(string) ($r_act[0]), (string) ($r_act[4])]);
$result_coord=db_query_or_die("Wah error nih21", $query_coord, $__p_query_coord ?? []);			
$jml = db_num_rows($result_coord);			
if (num($jml) >= 1) 	{$coord = 1; $att = 1;}else{$coord = 0;}	
}
elseif ( num($r_act[8]) == 91 or num($r_act[8]) == 41  or num($r_act[8]) == 55 or num($r_act[8]) == 60 or num($r_act[8]) == 306 or num($r_act[8]) == 307 or num($r_act[8]) == 50)		
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
      <td height="14" colspan="2" align=center class="style24"><?php echo  e($r_act[0]);  ?><br>
<?php echo e($r_act[12]) ?></td>
      <td colspan="3" align=center class="style24"><?php echo  e($r_act[1]);  ?></td>
      <td width="13%" align=center class="style24"><?php echo  e($r_act[3]);  ?></td>
      <td width="13%" colspan="2" align=center class="style24"><?php echo  e($r_act[6])  ?></td>
      <td width="18%" colspan="2" align=center class="style24"><?php echo  e($st_jam)  ?> </td>
	
    </tr>
    
    <?php $no_urut = num($no_urut) +1; $coord =0;$att=0; }}

	$ttl_tutorcountmenit = $jmldurasi_menit_dihitung; 
	
	$ttl_tutorcountmenitsaja =num($ttl_tutorcountmenit)%60;
	$ttl_tutorcountmenitkejam = num((num($ttl_tutorcountmenit) - num($ttl_tutorcountmenitsaja)))/60;

		$ttl_tutorcountmenit =$ttl_tutorcountmenitsaja;	
		$ttl_tutorcounthour = num($jmldurasi_jam_dihitung)+num($ttl_tutorcountmenitkejam);			
	  ?>
<tr>
      <td height="14" colspan="7" align=right class="style24"><strong>Total Class Tutorial/Late Attendance/Make Up Test Hours :</strong></td>
      <td colspan="4" align=right class="style24"><strong><?php echo  e($ttl_tutorcounthour)   ?> Hour(s) <?php echo e($ttl_tutorcountmenit)  ?> Minute(s)</strong></td>
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
      <td colspan="2" align=center class="style24">&nbsp;</td>
      <td colspan="2" align=center class="style24">&nbsp;</td>
    </tr>
    <tr>
<?php
$jmldurasi_jam_dihitung = 0;
$jmldurasi_menit_dihitung	= 0;		
//mulai data lc			
	$i=1;
$query_act = q_set($__p_query_act, "SELECT  v.kelas, CONCAT(date_format(v.mulai_tm,'%a, %d %b %y %H:%i' ),' - ' ,date_format(v.selesai_tm, '%H:%i' ) ), v.room, v.skill,v.mulai_tm,v.kd_branch,TIMEDIFF(date_format(selesai_tm,'%Y-%m-%d %H:%i:00'), date_format(mulai_tm,'%Y-%m-%d %H:%i:00')),v.id, v.status_kelas,TIME_FORMAT(TIMEDIFF(date_format(selesai_tm,'%Y-%m-%d %H:%i:00'), date_format(mulai_tm,'%Y-%m-%d %H:%i:00')),'%H') as durasi_jam,\r
TIME_FORMAT(TIMEDIFF(date_format(selesai_tm,'%Y-%m-%d %H:%i:00'), date_format(mulai_tm,'%Y-%m-%d %H:%i:00')),'%i') as durasi_menit,v.keterangan FROM vip_teacher_schedule v left join vip_teacher_name a on v.nm_teacher = a.kd_teacher left join tb_user c on a.nm_teacher = c.nama_detail where v.mulai_tm between ? and ? and (status_kelas =  '70' or status_kelas =  '71' or status_kelas =  '75') ", [(string) ($tgl_awal) . " 00:00:00", (string) ($tgl_akhir) . " 23:00:00"]);


if ($nm_teacher == '--All--')
	{ $query_filter_act_nm_teacher = "";}
else
	{	$query_filter_act_nm_teacher = q_set($__p_query_filter_act_nm_teacher, " and v.nm_teacher = ? ", [(string) ($nm_teacher)]);}

				  
//$query_plan_act = $query_act.$query_filter_act_nm_teacher.$query_filter_act_kd_branch.$query_filter_act_activities. " group by mulai_tm order by mulai_tm " ;
$query_plan_act = q_set($__p_query_plan_act, $query_act . $query_filter_act_nm_teacher . ($query_filter_act_activities ?? '') . ($query_filter_act_kelas ?? '') . " group by mulai_tm order by mulai_tm ", [...($__p_query_act ?? []), ...($__p_query_filter_act_nm_teacher ?? [])]);

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
if ($st_jam =='OK'){		
		?>
		          
      <td height="14" align=center class="style24"><?php echo  e($no_urut);  ?></td>
      <td height="14" colspan="2" align=center class="style24"><?php echo  e($r_act[0]);  ?><br>
<?php echo e($r_act[12]) ?></td>
      <td colspan="3" align=center class="style24"><?php echo  e($r_act[1]);  ?></td>
      <td width="13%" align=center class="style24"><?php echo  e($r_act[11]);  ?></td>
      <td width="13%" colspan="2" align=center class="style24"><?php echo  e($r_act[6])  ?></td>
      <td width="18%" colspan="2" align=center class="style24"><?php echo  e($st_jam)  ?> </td>
<?php } ?>		
    </tr>
    
    <?php $no_urut = num($no_urut) +1; $coord =0;$att=0; }}
	$ttl_lccountmenit = $jmldurasi_menit_dihitung;		
	$ttl_lccountmenitsaja =num($ttl_lccountmenit)%60;
	$ttl_lccountmenitkejam = num((num($ttl_lccountmenit) - num($ttl_lccountmenitsaja)))/60;

		$ttl_lccountmenit =$ttl_lccountmenitsaja;	
	
	$ttl_lccounthour = num($jmldurasi_jam_dihitung)+num($ttl_lccountmenitkejam);
if(num($ttl_lccounthour) >= 1 or num($ttl_lccountmenit) >= 1){ 		
	  ?>
<tr>
      <td height="14" colspan="7" align=right class="style24"><strong>Total Teaching and LC Hours</strong></td>
      <td colspan="4" align=right class="style24"><strong><?php echo  e($ttl_lccounthour)   ?> Hour(s) <?php echo e($ttl_lccountmenit)  ?> Minute(s)</strong></td>
      </tr>
<tr>
<?php }
$jmldurasi_jam_dihitung = 0;
$jmldurasi_menit_dihitung	= 0;		
//mulai data lc			
	$i=1;
$query_act = q_set($__p_query_act, "SELECT  v.kelas, CONCAT(date_format(v.mulai_tm,'%a, %d %b %y %H:%i' ),' - ' ,date_format(v.selesai_tm, '%H:%i' ) ), v.room, v.skill,v.mulai_tm,v.kd_branch,TIMEDIFF(date_format(selesai_tm,'%Y-%m-%d %H:%i:00'), date_format(mulai_tm,'%Y-%m-%d %H:%i:00')),v.id, v.status_kelas,TIME_FORMAT(TIMEDIFF(date_format(selesai_tm,'%Y-%m-%d %H:%i:00'), date_format(mulai_tm,'%Y-%m-%d %H:%i:00')),'%H') as durasi_jam,\r
TIME_FORMAT(TIMEDIFF(date_format(selesai_tm,'%Y-%m-%d %H:%i:00'), date_format(mulai_tm,'%Y-%m-%d %H:%i:00')),'%i') as durasi_menit,v.keterangan, v.pic FROM vip_teacher_schedule v left join vip_teacher_name a on v.nm_teacher = a.kd_teacher left join tb_user c on a.nm_teacher = c.nama_detail where v.mulai_tm between ? and ? and (status_kelas =  '80' or status_kelas =  '81'  or status_kelas =  '898') ", [(string) ($tgl_awal) . " 00:00:00", (string) ($tgl_akhir) . " 23:00:00"]);


if ($nm_teacher == '--All--')
	{ $query_filter_act_nm_teacher = "";}
else
	{	$query_filter_act_nm_teacher = q_set($__p_query_filter_act_nm_teacher, " and v.nm_teacher = ? ", [(string) ($nm_teacher)]);}

				  
//$query_plan_act = $query_act.$query_filter_act_nm_teacher.$query_filter_act_kd_branch.$query_filter_act_activities. " group by mulai_tm order by mulai_tm " ;
$query_plan_act = q_set($__p_query_plan_act, $query_act . $query_filter_act_nm_teacher . ($query_filter_act_activities ?? '') . ($query_filter_act_kelas ?? '') . " group by mulai_tm order by mulai_tm ", [...($__p_query_act ?? []), ...($__p_query_filter_act_nm_teacher ?? [])]);

	$no_urut = 1;num($jmljam) == 0;$jmljamsemua = 0;
      $result_act=db_query_or_die("Wah error nih193", $query_plan_act, $__p_query_plan_act ?? []);
if ($result_act) 
	{ 
	while ($r_act = db_fetch($result_act, PDO::FETCH_NUM))
		{ 
			
//===== lc
if (num($r_act[8]) == 80 or num($r_act[8]) == 81 or num($r_act[8]) == 898  )
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
if ($st_jam =='OK'){		
		?>
		          
      <td height="14" align=center class="style24"><?php echo  e($no_urut);  ?></td>
      <td height="14" colspan="2" align=center class="style24"><?php echo  e($r_act[0]);  ?><br>
<?php echo e($r_act[12]) ?><br>
        by <?php echo e($r_act[12]); ?>  <p>&nbsp;</p></td>
      <td colspan="3" align=center class="style24"><?php echo  e($r_act[1]);  ?></td>
      <td width="13%" align=center class="style24"><?php echo  e($r_act[11]);  ?></td>
      <td width="13%" colspan="2" align=center class="style24"><?php echo  e($r_act[6])  ?></td>
      <td width="18%" colspan="2" align=center class="style24"><?php echo  e($st_jam)  ?> </td>
<?php } ?>	
    </tr>
    
    <?php $no_urut = num($no_urut) +1; $coord =0;$att=0; }}
	$ttl_pt_countmenit = $jmldurasi_menit_dihitung;	 	
	$ttl_pt_countmenitsaja =num($ttl_pt_countmenit)%60;
	$ttl_pt_countmenitkejam = num((num($ttl_pt_countmenit) - num($ttl_pt_countmenitsaja)))/60;

		$ttl_pt_countmenit =$ttl_pt_countmenitsaja;	
	
	
	$ttl_pt_counthour = num($jmldurasi_jam_dihitung)+num($ttl_pt_countmenitkejam); 
if(num($ttl_pt_counthour) >= 1 or num($ttl_pt_countmenit) >= 1){ 		
	  ?>
<tr>
      <td height="14" colspan="7" align=center class="style24"><strong>Total Placement Test Hours</strong></td>
      <td colspan="4" align=right class="style24"><strong><?php echo  e($ttl_pt_counthour)   ?> Hour(s) <?php echo e($ttl_pt_countmenit)  ?> Minute(s)</strong></td>
      </tr>
<!-- awal self scoring -->
<tr>
<?php }
		  
$jmldurasi_jam_dihitung = 0;
$jmldurasi_menit_dihitung	= 0;		
//mulai data lc			
	$i=1;
$query_act = q_set($__p_query_act, "SELECT  v.kelas, CONCAT(date_format(v.mulai_tm,'%a, %d %b %y %H:%i' ),' - ' ,date_format(v.selesai_tm, '%H:%i' ) ), v.room, v.skill,v.mulai_tm,v.kd_branch,TIMEDIFF(date_format(selesai_tm,'%Y-%m-%d %H:%i:00'), date_format(mulai_tm,'%Y-%m-%d %H:%i:00')),v.id, v.status_kelas,TIME_FORMAT(TIMEDIFF(date_format(selesai_tm,'%Y-%m-%d %H:%i:00'), date_format(mulai_tm,'%Y-%m-%d %H:%i:00')),'%H') as durasi_jam,\r
TIME_FORMAT(TIMEDIFF(date_format(selesai_tm,'%Y-%m-%d %H:%i:00'), date_format(mulai_tm,'%Y-%m-%d %H:%i:00')),'%i') as durasi_menit,v.keterangan, v.pic,v.otb FROM vip_teacher_schedule v left join vip_teacher_name a on v.nm_teacher = a.kd_teacher left join tb_user c on a.nm_teacher = c.nama_detail where v.mulai_tm between ? and ? and (status_kelas like '22' or status_kelas like '33' or status_kelas like '44'   or status_kelas = '66'   or status_kelas = '222'   or status_kelas = '888'   or status_kelas = '899'   or status_kelas = '898'   or status_kelas = '897'   or status_kelas = '896'    or status_kelas = '999'   or status_kelas = '456' \r
  or status_kelas = '301'   or status_kelas = '302'   or status_kelas = '303'   or status_kelas = '304'   or status_kelas = '305'   or status_kelas = '981'  or status_kelas = '608' )", [(string) ($tgl_awal) . " 00:00:00", (string) ($tgl_akhir) . " 23:00:00"]);


if ($nm_teacher == '--All--')
	{ $query_filter_act_nm_teacher = "";}
else
	{	$query_filter_act_nm_teacher = q_set($__p_query_filter_act_nm_teacher, " and v.nm_teacher = ? ", [(string) ($nm_teacher)]);}

				  
//$query_plan_act = $query_act.$query_filter_act_nm_teacher.$query_filter_act_kd_branch.$query_filter_act_activities. " group by mulai_tm order by mulai_tm " ;
$query_plan_act = q_set($__p_query_plan_act, $query_act . $query_filter_act_nm_teacher . ($query_filter_act_activities ?? '') . ($query_filter_act_kelas ?? '') . " group by mulai_tm order by mulai_tm ", [...($__p_query_act ?? []), ...($__p_query_filter_act_nm_teacher ?? [])]);

	$no_urut = 1;num($jmljam) == 0;$jmljamsemua = 0;
      $result_act=db_query_or_die("Wah error nih193", $query_plan_act, $__p_query_plan_act ?? []);
if ($result_act) 
	{ 
	while ($r_act = db_fetch($result_act, PDO::FETCH_NUM))
		{ 
			
//===== lc
if (num($r_act[8]) == 66  )
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
if ($st_jam =='OK'){		
		?>
		          
      <td height="14" align=center class="style24"><?php echo  e($no_urut);  ?></td>
      <td height="14" colspan="2" align=center class="style24"><?php echo  e($r_act[0]);  ?><br>
<?php echo e($r_act[12]) ?><br>
        by <?php echo e($r_act[12]); ?>  <p>&nbsp;</p></td>
      <td colspan="3" align=center class="style24"><?php echo  e($r_act[1]);  ?></td>
      <td width="13%" align=center class="style24"><?php echo  e($r_act[11]);  ?></td>
      <td width="13%" colspan="2" align=center class="style24"><?php echo  e($r_act[6])  ?></td>
      <td width="9%" align=center class="style24"><?php echo  e($r_act[13]); ?> </td>
      <td width="9%" align=center class="style24"><?php echo  e($st_jam)  ?></td>
<?php } ?>	
    </tr>
    
    <?php $no_urut = num($no_urut) +1; $coord =0;$att=0; }} 
//	$ttl_pt_countmenit = $jmldurasi_menit_dihitung;	 	
//	$ttl_pt_countmenitsaja =$ttl_pt_countmenit%60;
//	$ttl_pt_countmenitkejam = ($ttl_pt_countmenit - $ttl_pt_countmenitsaja)/60;

//		$ttl_pt_countmenit =$ttl_pt_countmenitsaja;	
	
	
//	$ttl_pt_counthour = $jmldurasi_jam_dihitung+$ttl_pt_countmenitkejam; 
if(num($ttl_pt_counthour) >= 1 or num($ttl_pt_countmenit) >= 1){ 		
	  ?>
<tr>
      <td height="14" colspan="7" align=center class="style24"><strong>Total Self Scoring Counted Hours</strong></td>
      <td colspan="4" align=right class="style24"><strong><?php echo  e($ttl_pt_counthoudr)   ?> Hour(s) <?php echo e($ttl_pt_countmenidt)  ?> Minute(s)</strong></td>
      </tr>			  
<!-- akhir self scoring-->
	  <tr>
<?php  } 
$jmldurasi_jam_dihitung = 0;
$jmldurasi_menit_dihitung	= 0;					
//mulai non teaching lc			
	$i=1;
$query_act = q_set($__p_query_act, "SELECT  v.kelas, CONCAT(date_format(v.mulai_tm,'%a, %d %b %y %H:%i' ),' - ' ,date_format(v.selesai_tm, '%H:%i' ) ), v.room, v.skill,v.mulai_tm,v.kd_branch,TIMEDIFF(date_format(selesai_tm,'%Y-%m-%d %H:%i:00'), date_format(mulai_tm,'%Y-%m-%d %H:%i:00')),v.id, v.status_kelas,TIME_FORMAT(TIMEDIFF(date_format(selesai_tm,'%Y-%m-%d %H:%i:00'), date_format(mulai_tm,'%Y-%m-%d %H:%i:00')),'%H') as durasi_jam,\r
TIME_FORMAT(TIMEDIFF(date_format(selesai_tm,'%Y-%m-%d %H:%i:00'), date_format(mulai_tm,'%Y-%m-%d %H:%i:00')),'%i') as durasi_menit,keterangan,otb FROM vip_teacher_schedule v left join vip_teacher_name a on v.nm_teacher = a.kd_teacher left join tb_user c on a.nm_teacher = c.nama_detail where v.mulai_tm between ? and ? and \r
(status_kelas like '22' or status_kelas like '33' or status_kelas like '44'   or status_kelas = '66'   or status_kelas = '222'   or status_kelas = '888'   or status_kelas = '899'   or status_kelas = '898'   or status_kelas = '897'   or status_kelas = '896'    or status_kelas = '999'   or status_kelas = '301'   or status_kelas = '302'   or status_kelas = '303'   or status_kelas = '304'   or status_kelas = '305'  or status_kelas = '981'   or status_kelas = '608') ", [(string) ($tgl_awal) . " 00:00:00", (string) ($tgl_akhir) . " 23:00:00"]);
	
if ($nm_teacher == '--All--')
	{ $query_filter_act_nm_teacher = "";}
else
	{	$query_filter_act_nm_teacher = q_set($__p_query_filter_act_nm_teacher, " and v.nm_teacher = ? ", [(string) ($nm_teacher)]);}

				  
$query_plan_act = q_set($__p_query_plan_act, $query_act . $query_filter_act_nm_teacher . ($query_filter_act_kd_branch ?? '') . ($query_filter_act_activities ?? '') . ($query_filter_act_kelas ?? '') . " group by mulai_tm order by mulai_tm ", [...($__p_query_act ?? []), ...($__p_query_filter_act_nm_teacher ?? [])]);


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
elseif ($r_act[8] == '301'   or $r_act[8] == '302'   or $r_act[8] == '303'   or $r_act[8] == '304'   or $r_act[8] == '305'  or $r_act[8] == '981'  or $r_act[8] == '608')
{
$coord = 1; $att = 1;
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
				//$jmldurasi_jam_dihitung  = $jmldurasi_jam_dihitung + $durasi_jam_dihitung;
				//$jmldurasi_menit_dihitung  = $jmldurasi_menit_dihitung + $durasi_menit_dihitung;					
				}
if ($st_jam =='OK'){		
		?>
		          
      <td height="14" align=center class="style24"><?php echo  e($no_urut);  ?></td>
      <td height="14" colspan="2" align=center class="style24"><?php echo  e($r_act[0]);  ?><br>
<?php echo e($r_act[11]) ?><br></td>
      <td colspan="3" align=center class="style24"><?php echo  e($r_act[1]);  ?></td>
      <td width="13%" align=center class="style24"><?php echo  e($r_act[11]);  ?></td>
      <td width="13%" colspan="2" align=center class="style24"><?php echo  e($r_act[6])  ?></td>
      <td width="9%" align=center class="style24"><?php echo  e($r_act[12])  ?> </td>
      <td width="9%" align=center class="style24"><?php echo  e($st_jam)  ?></td>
<?php } ?>		  
    </tr> 
    <?php $no_urut = num($no_urut) +1; $coord =0;$att=0; $ttl_angka_otb = num($ttl_angka_otb)+num($r_act[12]); }}

$ttl_non_teachingcountmenit = $jmldurasi_menit_dihitung; 
$ttl_non_teachingcountmenitsaja =num($ttl_non_teachingcountmenit)%60;

$ttl_non_teachingcountmenitkejam = num((num($ttl_non_teachingcountmenit) - num($ttl_non_teachingcountmenitsaja)))/60;
$ttl_non_teachingcountmenit =$ttl_non_teachingcountmenitsaja;		
$ttl_non_teachingcounthour = num($jmldurasi_jam_dihitung)+num($ttl_non_teachingcountmenitkejam); echo e($ttl_non_teachingcounthour); 
$ttl_sum_teachingcountmenit = num($ttl_regpricountmenit)  + num($ttl_tutorcountmenit) + num($ttl_lccountmenit) + num($ttl_pt_countmenit)   + num($ttl_non_teachingcountmenit) ; 
$ttl_sum_teachingcountmenitsaja =num($ttl_sum_teachingcountmenit)%60;
$ttl_sum_teachingcountmenitkejam = num((num($ttl_sum_teachingcountmenit) - num($ttl_sum_teachingcountmenitsaja)))/60; 
if (num($ttl_sum_teachingcountmenit) ==60){$ttl_sum_teachingcountmenit =0;}
		  
//echo "reg pri:" .$ttl_regpricounthour.'<br>' ;
//echo 'tutor hor'.$ttl_tutorcounthour .'<br>' ;;
//echo 'lchr'.$ttl_lccounthour .'<br>' ;;
//echo 'pthor'.$ttl_pt_counthour .'<br>' ;;
//echo 'teacjmntjam'.$ttl_sum_teachingcountmenitkejam.'<br>' ; ;
//echo 'teach non ham'.$ttl_non_teachingcountmenitkejam.'<br>' ;;		  
		  
$ttl_sum_teachingcounthour = num($ttl_regpricounthour) + num($ttl_tutorcounthour) + num($ttl_lccounthour) + num($ttl_non_teachingcounthour) + num($ttl_pt_counthour) + num($ttl_sum_teachingcountmenitkejam) + num($ttl_non_teachingcountmenitkejam);
	
$otb_hour = floor(num($ttl_angka_otb) / 60);
$otb_minut = num($ttl_angka_otb) - num((num($otb_hour) * 60));
$otb_minut = num($ttl_angka_otb) - num((num($otb_hour) * 60));
	  ?>
		  
    <tr>
      <td height="14" colspan="7" align=center class="style24"><strong>Total Non TeachingHours</strong></td>
      <td colspan="4" align=right class="style24"><strong><?php echo  e($ttl_non_teachingcounthour)   ?> Hour(s) <?php echo e($ttl_non_teachingcountmenit)  ?> Minute(s)</strong></td>
    </tr>
			  
<tr>
  <td height="14" colspan="7" align=left class="style24"><strong>Compulsary Teaching Hour : <?php echo e($compulsary) ?></strong></td>
  <td colspan="4" align=right class="style24">&nbsp;</td>
</tr>
<tr>
      <td height="14" colspan="7" align=right class="style24"><strong>Total Hybrid Class Reguler/Private Count</strong></td>
      <td colspan="4" align=right class="style24"><strong><?php echo  e($jmldurasi_jam_dihitung_hybrid)  ?> Hour(s) <?php echo e($jmldurasi_menit_dihitung_hybrid) ?> Minute(s)</strong></td>
      </tr>
<tr>
      <td height="14" colspan="7" align=right class="style24"><strong>Total Offline Class Reguler/Private Count</strong></td>
      <td colspan="4" align=right class="style24"><strong><?php echo  e($jmldurasi_jam_dihitung_offline)  ?> Hour(s) <?php echo e($jmldurasi_menit_dihitung_offline) ?> Minute(s)</strong></td>
      </tr>			  
<tr>
      <td height="14" colspan="7" align=right class="style24"><strong>Total Online Class Reguler/Private Count</strong></td>
      <td colspan="4" align=right class="style24"><strong><?php echo  e($jmldurasi_jam_dihitung_online)  ?> Hour(s) <?php echo e($jmldurasi_menit_dihitung_online) ?> Minute(s)</strong></td>
      </tr>				  
<tr>
  <td height="14" colspan="7" align=right class="style24"><strong>Total Teaching Hours Summary</strong></td>
  <td colspan="4" align=right class="style24"><strong><?php echo  e($ttl_sum_teachingcounthour)  ?> Hour(s) <?php echo e($ttl_sum_teachingcountmenit) ?> Minute(s)</strong></td>
  </tr>
<tr>
  <td height="14" colspan="7" align=right class="style24"><strong>Total Overtime Beyond </strong></td>
  <td colspan="4" align=right class="style24"><strong><?php echo  e($otb_hour)  ?> Hour(s) <?php echo e($otb_minut) ?> Minute(s)</strong></td>
</tr>      
          </tbody>
        </table>
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->

    <div class="row">
      <!-- accepted payments column -->
      <div class="col-xs-4">
        <p class="lead" align="center">Proposed By<br>
        :</p>
        <p class="text-muted well well-sm no-shadow" style="margin-top: 10px;" align="center"><?php echo e($nama_lengkap_teacher) ?>

			
        </p>
      </div>
      <div class="col-xs-4">
        <p class="lead" align="center">Acknowledged By<br>
          :</p>
        <p class="text-muted well well-sm no-shadow" style="margin-top: 10px;" align="center">&nbsp;</p>
      </div>
      <div class="col-xs-4">
        <p class="lead" align="center">Approved By<br>
          :</p>
        <p class="text-muted well well-sm no-shadow" style="margin-top: 10px;" align="center">&nbsp;</p>
      </div>
      <!-- /.col --><!-- /.col -->
    </div>
    <!-- /.row -->

  <!-- /.content -->
</div>
<!-- ./wrapper -->
</body>
</html>
