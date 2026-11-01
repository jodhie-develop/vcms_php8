<?php
require_once __DIR__ . "/_lib/bootstrap.php"; auth_require_login(); 
include __DIR__ . "/conndb.php";
include __DIR__ . "/profiledata.php";
 include __DIR__ . "/atas.php";
$hari=date("d");
$bulan=date("m");
$tahun=date("Y");
$hari_ini = "$tahun-$bulan-$hari";
$date_start = in_val('date_start', 'get');
$date_end = in_val('date_end', 'get');

if ($date_start ==''){$date_start = "2020-01-01";}
if ($date_end ==''){$date_end = $hari_ini;}

$nama_lengkap = $_SESSION['nama_lengkap'];
$posisi = $_SESSION['posisi']; 
$kd_staff = $_SESSION['kd_staff'] ;
$kelompok = $_SESSION['kelompok'];
if ($nama_depan == 'Ira00' or $nama_depan == 'linda00' or $nama_depan == 'hanifa07' or $nama_depan == 'resty04' or $kelompok=='ACC'){
$kd_cbg = in_val('kd_cbg', 'get');
}
else
{$kd_cbg = $_SESSION['kd_branch'];}
if ($kd_cbg == 'National'){$kd_cbg = 100;}

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
if ($kd_cbg == 'Online'){$kd_cbg = 100;}

if (num($kd_cbg) ==100){$cabang = 'Online';}
if ($kd_cbg ==''){$cabang = 'National';}

if (num($kd_cbg) ==1){$cabang = 'East Sby';}
if (num($kd_cbg) ==2){$cabang = 'West Sby';}
if (num($kd_cbg) ==3){$cabang = 'Denpasar';}
if (num($kd_cbg) ==4){$cabang = 'South Jkt';}
if (num($kd_cbg) ==5){$cabang = 'North Jkt';}
if (num($kd_cbg) ==6){$cabang = 'West Jkt';}
if (num($kd_cbg) ==7){$cabang = 'Bandung';}
if (num($kd_cbg) ==8){$cabang = 'Malang';}
if (num($kd_cbg) ==101){$cabang = 'East Area';}
if (num($kd_cbg) ==102){$cabang = 'West Area';}

$kelas_name = in_val('kelas_name', 'get');

$pilihan_sc = in_val('pilihan_sc', 'get');
if ($pilihan_sc ==''){$pilihan_sc = 'All Leads';}

if($kd_cbg ==''){$filter_cbg = " ";}
elseif($kd_cbg == '100'){$filter_cbg = " where a.kd_branch = '100' ";}

elseif ($kd_cbg == '101'){$filter_cbg = " where (a.kd_branch = '1' or a.kd_branch = '1' or a.kd_branch = '3' or a.kd_branch = '8'  )  ";}
elseif ($kd_cbg == '102'){$filter_cbg = " where (a.kd_branch = '4' or a.kd_branch = '5' or a.kd_branch = '6' or a.kd_branch = '7'  )  ";}
else {$filter_cbg = " where a.kd_branch = '$kd_cbg' ";}
if ($filter_cbg =='') {$filter_tgl = q_set($__p_filter_tgl, " where f.min_mulai\t between ? and ? ", [(string) ($date_start) . " 00:00:00", (string) ($date_end) . " 23:00:00"]);}
else {$filter_tgl = q_set($__p_filter_tgl, " and f.min_mulai between ? and ? ", [(string) ($date_start) . " 00:00:00", (string) ($date_end) . " 23:00:00"]);}
if ($kelas_name !=''){$filter_kelas = q_set($__p_filter_kelas, " and a.kelas like ?  ", ["%" . (string) ($kelas_name) . "%"]);} else {$filter_kelas ='';}
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>AdminLTE 2 | Data Tables</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="cdnjs/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="../vcms/cdnjs/ionicons.min.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="plugins/datatables/dataTables.bootstrap.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
</head>
<?php //========================== left nav ?>
 <?php  //  include __DIR__ . "/left.php";	 ?>
 <?php //====================== ?>
  <!-- Content Wrapper. Contains page content -->
 <form method=get action=vip_open_class_report_acd_ira.php> 
  <div class="wrapper">
    <!-- Content Header (Page header) -->
  <section class="content-header">
      <h1>VIP Open Class List<br>
      </h1>
    <table width="685" border="0">
        <tbody>
          <tr>
            <td><small>
            <label for="date3">Center :</label>
            </small></td>
            <td>: 
              <select name="kd_cbg"  onChange="this.form.submit()"   class="style33" id="select">
              <option value="0">--CHOOSE--</option>
              <option value="1">East Sby</option>
              <option value="2">West Sby</option>
              <option value="3">Denpasar</option>
              <option value="8">Malang</option>
              <option value="101">East Area</option>
              <option value="4">South Jkt</option>
              <option value="5">North Jkt</option>
              <option value="6">West Jkt</option>
              <option value="7">Bandung</option>
              <option value="102">All</option>
              <option value="100">Online</option>
              <option selected="selected"><?php echo e($cabang) ?></option>
            </select></td>
          </tr>
          <tr>
			  <td width="129"><small>
              <label for="date5"> Start Class Period :</label>
              </small></td>
            <td width="546"><small>
              <label for="date2">:</label>
            <input type="date"  name="date_start" id="date_start" value="<?php echo e($date_start) ; ?>" onChange="this.form.submit()">
To </small><small>
<input type="date" name="date_end" id="date_end" value="<?php echo e($date_end) ; ?>" onChange="this.form.submit()" >
</small></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>: 
              <input name="kelas_name"  class="form-control" width="5"  type="text" size="8" value="<?php echo e($kelas_name) ?>" placeholder="class code you need to find" />  
                        
            </td>
          </tr>
        </tbody>
    </table>
  </section><!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <!-- /.box -->

          <div class="box">
            <!-- /.box-header -->
            <div class="box-body">
<div class="box box-warning">
	<div class="box-body">
	  <div class="col-md-8">
		<div class="form-group">
		  <label>Class List</label>
		</div>				
	  </div>
	  <div class="col-md-12">
	    <div class="form-group">
	      <table width="100%" class="table table-bordered table-striped" id="example3">
	        <tr>
	          <td align=center >&nbsp;</td>
	          <td height="14" align=center >&nbsp;</td>
	          <td align=center >&nbsp;</td>
	          <td align=center >&nbsp;</td>
	          <td align=center >&nbsp;</td>
	          <td align=center >&nbsp;</td>
	          <td colspan="2" align=center >&nbsp;</td>
	          <td width="2%" align=center >L</td>
	          <td width="2%" align=center >Str</td>
	          <td width="2%" align=center >Sp</td>
	          <td width="2%" align=center >R</td>
	          <td width="2%" align=center >W</td>
	          <td width="4%" align=center >TTL</td>
	          <td align=center >&nbsp;</td>
	          <td align=center >&nbsp;</td>
	          <td align=center >L</td>
	          <td align=center >S</td>
	          <td align=center >R</td>
	          <td align=center >W</td>
	          <td align=center >Other</td>
	          <td align=center >TTL</td>
	          <td>L</td>
	          <td>R</td>
	          <td>Wr</td>
	          <td>Sp</td>
	          <td>Overall Score</td>
	          <td align=center >&nbsp;</td>
            </tr>
	        <thead>
	          <tr>
	            <td width=5% align=center >Branch</td>
	            <td width=8% height="14" align=center >Class</td>
	            <td width="11%" align=center >Period</td>
	            <td width=4% align=center >Hours</td>
	            <td width=4% align=center >(Days)</td>
	            <td width="9%" align=center >Name</td>
	            <td width=5% align=center >Teacher</td>
	            <td width=7% align=center >Class Att</td>
	            <td colspan="6" align=center >Placement Test</td>
	            <td width=6% align=center >LC Visit</td>
	            <td width="4%" align=center >Tutorial Record</td>
	            <td width="11%" colspan="6" align=center >Mid Test</td>
	            <td width="6%" colspan="4" align=center >Final Test</td>
	            <td width="3%" align=center >&nbsp;</td>
	            <td width="3%" align=center >&nbsp;</td>
              </tr>
            </thead>
	        <?php 
//===jika ada billing
//$query_billing = "SELECT a.kd_billing,b.nm_program, b.level_program, b.type_program, sum(net_tf+reg_fee+material_cost) as invoiced,a.dt_entry,c.nama, c.middle_name, c.family_name,a.kd_biodata FROM ves_data.vip_billing a left join ves_data.vip_mst_code_prg b on a.kd_program = b.kd_program left join ves_inc.tb_biodata c on a.kd_biodata = c.kd_biodata where a.kd_branch = '$kd_cbg' and a.dt_entry between '$date_start' and '$date_end' group by a.kd_billing order by a.kd_billing" ;
//						   echo $query_billing;
						   
//$resource_billing = mysql_query($query_billing);
//$keluar_billing = db_num_rows($resource_billing);
					   ?>
	        <tbody>
	          <?php	
	$adafile = 0;
				$urut_no = 1;
$query_open_class = q_set($__p_query_open_class, "SELECT date_format(mulai_tm, '%M'),h.minggu, e.nama_lengkap, a.kelas, b.duration_program,date_format(mulai_tm,'%b %d, %Y'),a.kd_branch,e.kd_biodata FROM ves_data.vip_teacher_schedule a\r
left join ves_data.vip_mst_code_prg b on a.kode_program = b.kd_program and a.level_program = b.level_program\r
left join ves_data.vip_billing g  on a.kelas = g.kd_class\r
left join ves_data.vip_student_data e  on g.kd_biodata = e.kd_biodata\r
left join ves_data.tb_minggu_detail h  on date_format(a.mulai_tm, '%Y-%m-%d') = date_format(h.detail, '%Y-%m-%d')\r
\r
INNER JOIN ( SELECT kelas, MIN(mulai_tm) AS min_mulai FROM vip_teacher_schedule where status_kelas = 1\r
GROUP BY kelas ) f ON a.kelas = f.kelas AND a.mulai_tm = f.min_mulai  " . $filter_tgl . " " . $filter_kelas . "  and a.status_kelas = 1  \r
 group by a.kelas, e.kd_biodata order by mulai_tm,a.kd_branch", [...($__p_filter_tgl ?? []), ...($__p_filter_kelas ?? [])]); 

$resource_open_class = db_query_soft($query_open_class, $__p_query_open_class ?? []);
$keluar_open_class = db_num_rows($resource_open_class);				
if(num(db_num_rows($resource_open_class)) > 0)
	{
	while ($row_open_class  =  db_fetch($resource_open_class, PDO::FETCH_NUM))
		{
		$kelas_baru = $row_open_class[3];
		if ($kelas_lama  != $kelas_baru){$hitungperkelas = 1;$angkakelas = num($angkakelas) + 1;}
		$query_jml_murid = q_set($__p_query_jml_murid, "SELECT count(kd_billing) as jml FROM ves_data.vip_billing where kd_class= ? and kd_branch = ? ", [(string) ($row_open_class[3]), (string) ($kd_cbg)]);
		$resource_jml_murid = db_query_soft($query_jml_murid, $__p_query_jml_murid ?? []);
		$keluar_jml_murid = db_num_rows($resource_jml_murid);				
		if(num(db_num_rows($resource_jml_murid)) > 0)
			{
			while ($row_jml_murid  =  db_fetch($resource_jml_murid, PDO::FETCH_NUM))
				{	
				$jml_murid = $row_jml_murid[0];
				}
			}
		$query_last_date = q_set($__p_query_last_date, "SELECT max(mulai_tm) as selesai,date_format(max(mulai_tm),'%b %d, %Y') FROM ves_data.vip_teacher_schedule a where a.kelas = ? ", [(string) ($kelas_baru)]);
		$resource_last_date = db_query_soft($query_last_date, $__p_query_last_date ?? []);
		$keluar_last_date = db_num_rows($resource_last_date);				
		if(num(db_num_rows($resource_last_date)) > 0)
			{
			while ($row_last_date  =  db_fetch($resource_last_date, PDO::FETCH_NUM))
				{
				$kelas_selesai = $row_last_date[1];					
				}
			}
//		$query_time_teacher = "select date_format(mulai_tm, '%a'),  date_format(mulai_tm, '%H:%i'),date_format(selesai_tm, '%H:%i'),nm_teacher 	
		$query_time_teacher = q_set($__p_query_time_teacher, "select nm_teacher from vip_teacher_schedule where kelas = ? group by  nm_teacher", [(string) ($row_open_class[3])]);
			
		$resource_time_teacher = db_query_soft($query_time_teacher, $__p_query_time_teacher ?? []);		
		if(num(db_num_rows($resource_time_teacher)) > 0)
			{
			while ($row_time_teacher  =  db_fetch($resource_time_teacher, PDO::FETCH_NUM))
				{
				//$jadwal_1= "$row_time_teacher[0] ($row_time_teacher[1]-$row_time_teacher[2]) - $row_time_teacher[3]<br>";
				$infoteacher= "$row_time_teacher[0]";
					
				//$baris_jadwal = "$baris_jadwal $jadwal_1";	
				$baris_teacher = "$baris_teacher $infoteacher";	
					
				}
			}
		$query_day_teacher = q_set($__p_query_day_teacher, "select date_format(mulai_tm,'%a') from vip_teacher_schedule where kelas = ? group by date_format(mulai_tm,'%a') order by date_format(mulai_tm, '%w')", [(string) ($row_open_class[3])]);
			
		$resource_day_teacher = db_query_soft($query_day_teacher, $__p_query_day_teacher ?? []);		
		if(num(db_num_rows($resource_day_teacher)) > 0)
			{
			while ($row_day_teacher  =  db_fetch($resource_day_teacher, PDO::FETCH_NUM))
				{
				//$jadwal_1= "$row_time_teacher[0] ($row_time_teacher[1]-$row_time_teacher[2]) - $row_time_teacher[3]<br>";
				$infoday= "$row_day_teacher[0]";
					
				//$baris_jadwal = "$baris_jadwal $jadwal_1";	
				$baris_day = "$baris_day $infoday";	
					
				}
			}
//placement test		
		$query_score = q_set($__p_query_score, "SELECT t.L,t.other, t.S, t.R, t.W,  t.total,t.no FROM ves_inc.tb_acd_history t where t.kd_biodata =  ? order by test_date desc limit 1", [(string) ($row_open_class[7])]);
		$resource_score = db_query_soft($query_score, $__p_query_score ?? []);
		$keluar_score = db_num_rows($resource_score);	
		if(num(db_num_rows($resource_score)) > 0)
			{
			while ($row_score  =  db_fetch($resource_score, PDO::FETCH_NUM))	
				{
				$l = $row_score[0];	
				$st = $row_score[1];	
				$sp = $row_score[2];	
				$r = $row_score[3];	
				$w = $row_score[4];						
				$ttl = $row_score[5];
				$nomor_pt = $row_score[6];						
				$adascore = 1;
				}
			}	

		//hitung kehadiran	
		$query_hadir = q_set($__p_query_hadir, "SELECT sum(st_attendance) FROM ves_data.vip_attendance where kd_class = ? and kd_biodata = ? group by kd_biodata", [(string) ($kelas_baru), (string) ($row_open_class[7])]);

		$resource_hadir = db_query_soft($query_hadir, $__p_query_hadir ?? []);
		$keluar_hadir = db_num_rows($resource_hadir);	
		if(num(db_num_rows($resource_hadir)) > 0)
			{
			while ($row_hadir  =  db_fetch($resource_hadir, PDO::FETCH_NUM))	
				{
				$angka_hadir = $row_hadir[0];
				}
			}
		$query_jml_meeting = q_set($__p_query_jml_meeting, "SELECT sum(status_kelas) FROM ves_data.vip_teacher_schedule where kelas = ? and status_kelas = 1", [(string) ($kelas_baru)]);

		$resource_jml_meeting = db_query_soft($query_jml_meeting, $__p_query_jml_meeting ?? []);
		$keluar_jml_meeting = db_num_rows($resource_jml_meeting);	
		if(num(db_num_rows($resource_jml_meeting)) > 0)
			{
			while ($row_jml_meeting  =  db_fetch($resource_jml_meeting, PDO::FETCH_NUM))	
				{
				$angka_jml_meeting = $row_jml_meeting[0];
				}
			}		
		$persen_hadir = num((div($angka_hadir, $angka_jml_meeting)))*100;
		
//hitung kehadiran	lc
		$query_hadir_lc = q_set($__p_query_hadir_lc, "SELECT count(mulai_tm) FROM ves_data.vip_teacher_schedule where kelas = ? and kd_biodata = ? and status_kelas='71' group by kd_biodata", [(string) ($kelas_baru) . " - LC Visit", (string) ($row_open_class[7])]);

		$resource_hadir_lc = db_query_soft($query_hadir_lc, $__p_query_hadir_lc ?? []);
		$keluar_hadir_lc = db_num_rows($resource_hadir_lc);	
		if(num(db_num_rows($resource_hadir_lc)) > 0)
			{
			while ($row_hadir_lc  =  db_fetch($resource_hadir_lc, PDO::FETCH_NUM))	
				{
				$angka_hadir_lc = $row_hadir_lc[0];
				}
			}	
//hitung kehadiran	tutorial
			$query_hadir_tutor = q_set($__p_query_hadir_tutor, "SELECT count(mulai_tm) FROM ves_data.vip_teacher_schedule where kelas = ? and kd_biodata = ? group by kd_biodata", [(string) ($kelas_baru) . " - Tutorial", (string) ($row_open_class[7])]);

		$resource_hadir_tutor = db_query_soft($query_hadir_tutor, $__p_query_hadir_tutor ?? []);
		$keluar_hadir_tutor = db_num_rows($resource_hadir_tutor);	
		if(num(db_num_rows($resource_hadir_tutor)) > 0)
			{
			while ($row_hadir_tutor  =  db_fetch($resource_hadir_tutor, PDO::FETCH_NUM))	
				{
				$angka_hadir_tutor = $row_hadir_tutor[0];
				}
			}
//mid test		
		$query_score_mid = q_set($__p_query_score_mid, "SELECT t.L,t.other, t.S, t.R, t.W,  t.total,t.no FROM ves_data.vip_class_score_profile t where t.kd_biodata =  ? and class_code = ? and jns_test = '2' order by test_date desc limit 1", [(string) ($row_open_class[7]), (string) ($kelas_baru)]);
		$resource_score_mid = db_query_soft($query_score_mid, $__p_query_score_mid ?? []);
		$keluar_score_mid = db_num_rows($resource_score_mid);	
		if(num(db_num_rows($resource_score_mid)) > 0)
			{
			while ($row_score_mid  =  db_fetch($resource_score_mid, PDO::FETCH_NUM))	
				{
				$l_mid = $row_score_mid[0];	
				$st_mid = $row_score_mid[1];	
				$sp_mid = $row_score_mid[2];	
				$r_mid = $row_score_mid[3];	
				$w_mid = $row_score_mid[4];						
				$ttl_mid = $row_score_mid[5];
				$nomor_mid = $row_score_mid[6];	
				$adascore_mid = 1;
				}
			}	
//final test
		$query_score_final = q_set($__p_query_score_final, "SELECT t.L,t.other, t.S, t.R, t.W,  t.total,t.no FROM ves_data.vip_class_score_profile t where t.kd_biodata =  ? and class_code = ? and jns_test = '3' order by test_date desc limit 1", [(string) ($row_open_class[7]), (string) ($kelas_baru)]);
		$resource_score_final = db_query_soft($query_score_final, $__p_query_score_final ?? []);
		$keluar_score_final = db_num_rows($resource_score_final);	
		if(num(db_num_rows($resource_score_final)) > 0)
			{
			while ($row_score_final  =  db_fetch($resource_score_final, PDO::FETCH_NUM))	
				{
				$l_final = $row_score_final[0];	
				$st_final = $row_score_final[1];	
				$sp_final = $row_score_final[2];	
				$r_final = $row_score_final[3];	
				$w_final = $row_score_final[4];						
				$ttl_final = $row_score_final[5];
				$nomor_final = $row_score_final[6];						
				$adascore_final = 1;
				}
			}		
			
	?>
<?php if (num($hitungperkelas) ==1){?>
	          <tr>
	            <td height="14" colspan="28" align=left bgcolor="#E9DBDB" class="style24"><strong><?php echo e($angkakelas) ?>.<?php echo  e($row_open_class[3])  ?></strong></td>
              </tr>
<?php } ?>          
	          <tr>
	            <td align=center class="style24"><?php echo  e($row_open_class[6])  ?></td>
	            <td height="14" align=center class="style24"><?php echo  e($row_open_class[3])  ?></td>
	            <td align=center class="style24"><?php echo  e($row_open_class[5])  ?> - <?php echo  e($kelas_selesai)  ?></td>
	            <td align=left class="style24"><?php echo  e($angka_jml_meeting)  ?></td>
	            <td align=left class="style24"><?php echo  e($baris_day)  ?></td>
	            <td align=left class="style24"><?php echo  e($row_open_class[2])  ?></td>
	            <td align=center class="style24"><?php echo e($baris_teacher) ?></td>
	            <td align=center class="style24"><?php echo e($angka_hadir) ?> ( <?php echo round(num($persen_hadir)) ?>% )</td>
	            <td align=center class="style24"><?php echo e(str_replace (".",",", $l)) ?></td>
	            <td align=center class="style24"><?php echo e(str_replace (".",",", $st))  ?></td>
	            <td align=center class="style24"><?php echo e(str_replace (".",",", $sp))  ?></td>
	            <td align=center class="style24"><?php echo e(str_replace (".",",", $r)) ?></td>
	            <td align=center class="style24"><?php echo e(str_replace (".",",", $w)) ?></td>
	            <td align=center class="style24"><?php echo e(str_replace (".",",", $ttl)) ?></td>
	            <td align=center class="style24"><?php echo e($angka_hadir_lc) ?></td>
	            <td align=center class="style24"><?php echo e($angka_hadir_tutor) ?></td>
	            <td align=center class="style24"><?php echo e(str_replace (".",",", $l_mid)) ?></td>
	            <td align=center class="style24"><?php echo e(str_replace (".",",", $sp_mid)) ?></td>
	            <td align=center class="style24"><?php echo e(str_replace (".",",", $r_mid)) ?></td>
	            <td align=center class="style24"><?php echo e(str_replace (".",",", $w_mid)) ?></td>
	            <td align=center class="style24"><?php echo e(str_replace (".",",", $st_mid)) ?></td>
	            <td align=center class="style24"><?php echo e(str_replace (".",",", $ttl_mid))  ?></td>
	            <td align=center class="style24"><?php echo e(str_replace (".",",", $l_final))  ?></td>
	            <td align=center class="style24"><?php echo e(str_replace (".",",", $r_final))  ?></td>
	            <td align=center class="style24"><?php echo e(str_replace (".",",", $w_final))  ?></td>
	            <td align=center class="style24"><?php echo e(str_replace (".",",", $sp_final))  ?></td>
	            <td align=center class="style24"><?php echo e(str_replace (".",",", $ttl_final))  ?></td>
	            <td align=center class="style24">&nbsp;</td>
              </tr>

	          <?php 	$adafile = 0; 				$jadwal_1= '';
				$baris_teacher = '';$baris_day=''; $kelas_lama = $kelas_baru;$hitungperkelas = num($hitungperkelas) +1; $urut_no = num($urut_no)+1;
	$l_mid = ''; 	            $l_mid = ''; $sp_mid = '';  $r_mid = '';  $w_mid = '';  $st_mid = ''; $ttl_mid = ''; $l_final = ''; $r_final = ''; $w_final = ''; $sp_final = '';   $ttl_final  = ''; $angka_hadir_tutor ='';$angka_hadir ='';$persen_hadir='';$angka_hadir_lc ='';$angka_hadir_tutor =''; $ttl ='';
		            $row_open_class[6]  ='';
	              $row_open_class[3]  ='';
	            $row_open_class[5]  ='';   $kelas_selesai ='';  
	            $angka_jml_meeting  ='';
	            $baris_day ='';   $row_open_class[2] ='';   $baris_teacher =''; $angka_hadir =''; $persen_hadir =''; $l ='';  $st ='';  $sp ='';  $r ='';  $w =''; $ttl ='';  $angka_hadir_lc =''; $angka_hadir_tutor ='';  $l_mid =''; $sp_mid ='';  $r_mid ='';  $w_mid ='';  $st_mid ='';  $ttl_mid =''; $l_final =''; $r_final ='';  $w_final ='';   $sp_final =''; $ttl_final ='';	
	}} ?>
            </tbody>
	        <tfoot>
            </tfoot>
          </table>
	    </div>
            <!-- /.box-body -->
      </div>
          <!-- /.box -->
    </div>
        <!-- /.col -->
      </div>
      <a href="vip_open_class_report_acdxl.php?kd_cbg=<?php echo e(u($kd_cbg))?>&date_start=<?php echo e(u($date_start)) ?>&date_end=<?php echo e(u($date_end))?>" target="_blank" class="btn btn-default"><i class="fa fa-print"></i>Excel</a>
      <!-- /.row --><!-- /.content -->
	</form> 
<!-- /.content-wrapper --><!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Create the tabs -->
    <ul class="nav nav-tabs nav-justified control-sidebar-tabs">
      <li><a href="#control-sidebar-home-tab" data-toggle="tab"><i class="fa fa-home"></i></a></li>
      <li><a href="#control-sidebar-settings-tab" data-toggle="tab"><i class="fa fa-gears"></i></a></li>
    </ul>
    <!-- Tab panes -->
    <div class="tab-content">
      <!-- Home tab content -->
      <div class="tab-pane" id="control-sidebar-home-tab">
        <h3 class="control-sidebar-heading">Recent Activity</h3>
        <ul class="control-sidebar-menu">
          <li>
            <a href="javascript:void(0)">
              <i class="menu-icon fa fa-birthday-cake bg-red"></i>

              <div class="menu-info">
                <h4 class="control-sidebar-subheading">Langdon's Birthday</h4>

                <p>Will be 23 on April 24th</p>
              </div>
            </a>
          </li>
          <li>
            <a href="javascript:void(0)">
              <i class="menu-icon fa fa-user bg-yellow"></i>

              <div class="menu-info">
                <h4 class="control-sidebar-subheading">Frodo Updated His Profile</h4>

                <p>New phone +1(800)555-1234</p>
              </div>
            </a>
          </li>
          <li>
            <a href="javascript:void(0)">
              <i class="menu-icon fa fa-envelope-o bg-light-blue"></i>

              <div class="menu-info">
                <h4 class="control-sidebar-subheading">Nora Joined Mailing List</h4>

                <p>nora@example.com</p>
              </div>
            </a>
          </li>
          <li>
            <a href="javascript:void(0)">
              <i class="menu-icon fa fa-file-code-o bg-green"></i>

              <div class="menu-info">
                <h4 class="control-sidebar-subheading">Cron Job 254 Executed</h4>

                <p>Execution time 5 seconds</p>
              </div>
            </a>
          </li>
        </ul>
        <!-- /.control-sidebar-menu -->

        <h3 class="control-sidebar-heading">Tasks Progress</h3>
        <ul class="control-sidebar-menu">
          <li>
            <a href="javascript:void(0)">
              <h4 class="control-sidebar-subheading">
                Custom Template Design
                <span class="label label-danger pull-right">70%</span>
              </h4>

              <div class="progress progress-xxs">
                <div class="progress-bar progress-bar-danger" style="width: 70%"></div>
              </div>
            </a>
          </li>
          <li>
            <a href="javascript:void(0)">
              <h4 class="control-sidebar-subheading">
                Update Resume
                <span class="label label-success pull-right">95%</span>
              </h4>

              <div class="progress progress-xxs">
                <div class="progress-bar progress-bar-success" style="width: 95%"></div>
              </div>
            </a>
          </li>
          <li>
            <a href="javascript:void(0)">
              <h4 class="control-sidebar-subheading">
                Laravel Integration
                <span class="label label-warning pull-right">50%</span>
              </h4>

              <div class="progress progress-xxs">
                <div class="progress-bar progress-bar-warning" style="width: 50%"></div>
              </div>
            </a>
          </li>
          <li>
            <a href="javascript:void(0)">
              <h4 class="control-sidebar-subheading">
                Back End Framework
                <span class="label label-primary pull-right">68%</span>
              </h4>

              <div class="progress progress-xxs">
                <div class="progress-bar progress-bar-primary" style="width: 68%"></div>
              </div>
            </a>
          </li>
        </ul>
        <!-- /.control-sidebar-menu -->

      </div>
      <!-- /.tab-pane -->
      <!-- Stats tab content -->
      <div class="tab-pane" id="control-sidebar-stats-tab">Stats Tab Content</div>
      <!-- /.tab-pane -->
      <!-- Settings tab content -->
      <div class="tab-pane" id="control-sidebar-settings-tab">
        <form method="post"><?php echo csrf_field(); ?>

          <h3 class="control-sidebar-heading">General Settings</h3>

          <div class="form-group">
            <label class="control-sidebar-subheading">
              Report panel usage
              <input type="checkbox" class="pull-right" checked>
            </label>

            <p>
              Some information about this general settings option
            </p>
          </div>
          <!-- /.form-group -->

          <div class="form-group">
            <label class="control-sidebar-subheading">
              Allow mail redirect
              <input type="checkbox" class="pull-right" checked>
            </label>

            <p>
              Other sets of options are available
            </p>
          </div>
          <!-- /.form-group -->

          <div class="form-group">
            <label class="control-sidebar-subheading">
              Expose author name in posts
              <input type="checkbox" class="pull-right" checked>
            </label>

            <p>
              Allow the user to show his name in blog posts
            </p>
          </div>
          <!-- /.form-group -->

          <h3 class="control-sidebar-heading">Chat Settings</h3>

          <div class="form-group">
            <label class="control-sidebar-subheading">
              Show me as online
              <input type="checkbox" class="pull-right" checked>
            </label>
          </div>
          <!-- /.form-group -->

          <div class="form-group">
            <label class="control-sidebar-subheading">
              Turn off notifications
              <input type="checkbox" class="pull-right">
            </label>
          </div>
          <!-- /.form-group -->

          <div class="form-group">
            <label class="control-sidebar-subheading">
              Delete chat history
              <a href="javascript:void(0)" class="text-red pull-right"><i class="fa fa-trash-o"></i></a>
            </label>
          </div>
          <!-- /.form-group -->
        </form>
      </div>
      <!-- /.tab-pane -->
    </div>
  </aside>
  <!-- /.control-sidebar -->
  <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>
  <!-- ./wrapper -->
<!-- jQuery 2.2.3 -->
<script src="plugins/jQuery/jquery-2.2.3.min.js"></script>
<!-- Bootstrap 3.3.6 -->
<script src="bootstrap/js/bootstrap.min.js"></script>
<!-- DataTables -->
<script src="plugins/datatables/jquery.dataTables.min.js"></script>
<script src="plugins/datatables/dataTables.bootstrap.min.js"></script>
<!-- SlimScroll -->
<script src="plugins/slimScroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="plugins/fastclick/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/app.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
<!-- page script -->
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
if (isset($_GET['Search'])) 
	{
			echo "<script type=\"text/javascript\">\n";
			echo "window.location = ('prestuvip.php');\n";				
			echo "</script>";
	}
?>
