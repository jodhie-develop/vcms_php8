<?php
require_once __DIR__ . "/_lib/bootstrap.php"; csrf_guard_get(); auth_require_login(); 
include __DIR__ . "/conndb.php";
include __DIR__ . "/profiledata.php";
 include __DIR__ . "/atas.php";
include __DIR__ . "/left.php";
$hari=date("d");
$bulan=date("m");
$tahun=date("Y");
$hari_ini = "$tahun-$bulan-$hari";
$date_start = in_val('date_start', 'any');
$date_end = in_val('date_end', 'any');
$cd_cl = in_val('cd_cl', 'any');
$nama = in_val('nama', 'any');
if ($nama != '')
	{
	echo "<script type=\"text/javascript\">\n";
		echo "window.location=('vip_student_recordbasename.php?nmstu='" . e($nama) . "'');\n";				
		echo "</script>";
	}



if ($date_start ==''){$date_start = "$tahun-$bulan-01";}
if ($date_end ==''){$date_end = $hari_ini;}

$nama_lengkap = $_SESSION['nama_lengkap'];
$posisi = $_SESSION['posisi']; 
$kelompok = $_SESSION['kelompok'];
$kd_staff = $_SESSION['kd_staff'] ;
if ($progress =='ALL')
	{
	$filter_tgl = q_set($__p_filter_tgl, " where f.min_mulai between ? and ?  and a.status_kelas = 1 ", [(string) ($date_start) . " 00:00:00", (string) ($date_end) . " 23:00:00"]);
	}
else
	{
	$filter_tgl = q_set($__p_filter_tgl, " where f.min_mulai between ? and ?  and a.status_kelas = 1 ", [(string) ($date_start) . " 00:00:00", (string) ($date_end) . " 23:00:00"]);
	}

if($cd_cl != 'ALL')
	{
	$filter_kelas = q_set($__p_filter_kelas, " and a.kelas = ? ", [(string) ($cd_cl)]);	
	}
else
	{
	$filter_kelas = q_set($__p_filter_kelas, " ");	
	}
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>VE Student Record</title>
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

  <!-- Content Wrapper. Contains page content -->
 <form action=# method="post"><?php echo csrf_field(); ?>
 
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>VE Student Record<br>
    </h1>
    <table width="453" border="0">
        <tbody>
          <tr>
			  <td width="148"><small>
              <label for="date5"> Start Class Period :</label>
              </small></td>
            <td width="289"><small>
              <label for="date2">:</label>
            <input type="date"  name="date_start" id="date_start" value="<?php echo e($date_start) ; ?>" onChange="this.form.submit()">
To </small><small>
<input type="date" name="date_end" id="date_end" value="<?php echo e($date_end) ; ?>" onChange="this.form.submit()" >
</small></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td><small>
            <label for="date4">  Class Code</label>
            </small></td>
            <td><span class="form-group">
<select class="form-control" name="cd_cl"  onChange="this.form.submit()">

        <?php
							//	$query_cl_code = "SELECT distinct kd_class FROM ves_data.vip_billing a left join vip_teacher_schedule c on a.kd_class = c.kelas where c.kd_branch = '1' and c.mulai_tm between '2018-08-01' and '2018-08-30' group by a.kd_class";

								$query_cl_code = q_set($__p_query_cl_code, "SELECT a.kelas FROM ves_data.vip_teacher_schedule a  INNER JOIN ( SELECT kelas, MIN(mulai_tm) AS min_mulai FROM vip_teacher_schedule where status_kelas = 1\r
GROUP BY kelas ) f ON a.kelas = f.kelas AND a.mulai_tm = f.min_mulai   " . $filter_tgl . " group by a.kelas order by a. kelas", [...($__p_filter_tgl ?? [])]);	


								$resource_cl_code = db_query_or_die('errro_7', $query_cl_code, $__p_query_cl_code ?? []);
								while ($row_cl_code=  db_fetch($resource_cl_code, PDO::FETCH_NUM))
									{
							  		echo '<option value="'.e($row_cl_code[0]).'">'.e($row_cl_code[0]).'</option>';
							  		}      ?>
	        <option>ALL</option>	
        <option selected><?php echo  e($cd_cl) ?></option>
      </select>
            </span></td>
          </tr>
          <tr>
            <td><small>
            <label for="date3">Progress</label>
            </small></td>
            <td><span class="form-group">
              <select class="form-control" name="progress"  disabled>
                <option>Finished</option>
                <option>On Progrees</option>
                <option>Not Started</option>               
                <option>ALL</option>
                <option selected><?php echo  e($progress) ?></option>
              </select>
            </span></td>
          </tr>
          <tr>
            <td><small>
            <label for="date6">Student Name</label>
            </small></td>
            <td><span class="form-group">
              <input type="text" class="form-control"  placeholder="Enter ..." name="nama" value="<?php echo e($center) ?>" >
            </span></td>
          </tr>
          <tr>
            <td><span class="box-body">
              <input type="submit" name="Export" value="Export" />
            </span></td>
            <td>&nbsp;</td>
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
<?php if ($kd_cbg ==''){die;} ?>		
	  <div class="col-md-12">
	    <div class="form-group">
	      <table width="100%" class="table table-bordered table-striped" id="example3">
	        <thead>
	          <tr>
	            <td height="14" align=center >Teacher Name</td>
	            <td align=center >Class Code Opened</td>
	            <td align=center >Class Period</td>
	            <td align=center >Status</td>
	            <td align=center >Student</td>
	            <td align=center >Target <br>
                Score</td>
	            <td colspan="6" align=center >Placement Test Score</td>
	            <td colspan="6" align=center >Final Test</td>
	            <td colspan="3" align=center >Attendance</td>
	            <td align=center >&nbsp;</td>
              </tr>
	          <tr>
	            <td width=4% height="14" align=center >&nbsp;</td>
	            <td width=6% align=center >&nbsp;</td>
	            <td width="6%" align=center >&nbsp;</td>
	            <td width="3%" align=center >&nbsp;</td>
	            <td width="18%" align=center >&nbsp;</td>
	            <td width="5%" align=center >&nbsp;</td>
	            <td width="4%" align=center >L</td>
	            <td width="2%" align=center >R</td>
	            <td width="2%" align=center >W</td>
	            <td width="2%" align=center >Sp</td>
	            <td width="2%" align=center >St</td>
	            <td width="3%" align=center >Overall</td>
	            <td width="2%" align=center >L</td>
	            <td width="2%" align=center >R</td>
	            <td width="2%" align=center >W</td>
	            <td width="2%" align=center >Sp</td>
	            <td width="2%" align=center >St</td>
	            <td width="3%" align=center >Overall</td>
	            <td colspan="2" align=center >Class</td>
	            <td width="4%" align=center >LC</td>
	            <td width="21%" align=center >MCA</td>
              </tr>
            </thead>

	   
	          <?php	
	$adafile = 0;
if ($nama != '')
{
$query_open_class = q_set($__p_query_open_class, "SELECT a.kelas,date_format((f.min_mulai),'%d/%m/%y'), d.kd_biodata,f.min_mulai, d.kd_billing FROM ves_data.vip_teacher_schedule a left join vip_billing d on a.kelas = d.kd_class INNER JOIN ( SELECT kelas, MIN(mulai_tm) AS min_mulai FROM vip_teacher_schedule where status_kelas = 1\r
GROUP BY kelas ) f ON a.kelas = f.kelas AND a.mulai_tm = f.min_mulai   " . $filter_tgl . "  " . $filter_kelas . " and d.kd_biodata is not null group by a.kelas,d.kd_biodata order by  mulai_tm desc,kelas", [...($__p_filter_tgl ?? []), ...($__p_filter_kelas ?? [])]); 	
}
else
{
$query_open_class = q_set($__p_query_open_class, "SELECT a.kelas,date_format((f.min_mulai),'%d/%m/%y'), d.kd_biodata,f.min_mulai, d.kd_billing FROM ves_data.vip_teacher_schedule a left join vip_billing d on a.kelas = d.kd_class INNER JOIN ( SELECT kelas, MIN(mulai_tm) AS min_mulai FROM vip_teacher_schedule where status_kelas = 1\r
GROUP BY kelas ) f ON a.kelas = f.kelas AND a.mulai_tm = f.min_mulai   " . $filter_tgl . "  " . $filter_kelas . " and d.kd_biodata is not null group by a.kelas,d.kd_biodata order by  mulai_tm desc,kelas", [...($__p_filter_tgl ?? []), ...($__p_filter_kelas ?? [])]); 	
}
/* echo $query_open_class (debug SQL versi lama) dihapus */	
$resource_open_class = db_query_soft($query_open_class, $__p_query_open_class ?? []);
$keluar_open_class = db_num_rows($resource_open_class);				
if(num(db_num_rows($resource_open_class)) > 0)
	{
	while ($row_open_class  =  db_fetch($resource_open_class, PDO::FETCH_NUM))
		{
		//===selesai===
		$query_selesai = q_set($__p_query_selesai, "SELECT date_format(max(selesai_tm),'%d/%m/%y'),max(selesai_tm) FROM ves_data.vip_teacher_schedule   where kelas= ? and status_kelas = 1", [(string) ($row_open_class[0])]);

		$resource_selesai = db_query_soft($query_selesai, $__p_query_selesai ?? []);			
		if(num(db_num_rows($resource_selesai)) > 0)
			{
			while ($row_selesai  =  db_fetch($resource_selesai, PDO::FETCH_NUM))
				{	
				$tgl_selesai = $row_selesai[0];
				$tgl_terakhir = $row_selesai[1];
				
				}
			}
		//=============
		//==status kelas
		$check_hari_ini = strtotime($hari_ini);
		$check_tgl_terakhir = strtotime($tgl_terakhir);
		$check_tgl_pertama = strtotime($row_open_class[3]);
		// Compare the timestamp date 
		if ($check_hari_ini >= $check_tgl_terakhir)
			{$st_kelas = "Finished";$warna = " bgcolor='#31E41C'"; $kd_st = 2;}
		elseif (($check_hari_ini >= $check_tgl_pertama) and ($check_hari_ini < $check_tgl_terakhir) ) 
			{$st_kelas = "On Progress";$warna = " bgcolor='#EDF836'";$kd_st = 1;}
		elseif ($check_hari_ini < $check_tgl_pertama)  
			{$st_kelas = "Not Started";$warna = " ";$kd_st = 0;}		
					//===
//===jml_meeting===
		$query_selesai = q_set($__p_query_selesai, "SELECT count(distinct mulai_tm) FROM ves_data.vip_teacher_schedule   where kelas= ? and status_kelas = 1 ", [(string) ($row_open_class[0])]);

		$resource_selesai = db_query_soft($query_selesai, $__p_query_selesai ?? []);			
		if(num(db_num_rows($resource_selesai)) > 0)
			{
			while ($row_selesai  =  db_fetch($resource_selesai, PDO::FETCH_NUM))
				{	
				$jml_kelas = $row_selesai[0];
				}
			}
		//=============		
		//==teacher===
		$query_teacher = q_set($__p_query_teacher, "select nm_teacher from vip_teacher_schedule where kelas = ? group by  nm_teacher", [(string) ($row_open_class[0])]);

		$resource_time_teacher = db_query_soft($query_teacher, $__p_query_teacher ?? []);		
		if(num(db_num_rows($resource_time_teacher)) > 0)
			{
			while ($row_time_teacher  =  db_fetch($resource_time_teacher, PDO::FETCH_NUM))
				{
				$nm_teacher = "$row_time_teacher[0] ";
				$baris_teacher = "$baris_teacher $nm_teacher";	
				}
			}			
		//======
		//==nama student

		$query_jml_murid = q_set($__p_query_jml_murid, "SELECT nama_lengkap FROM ves_data.vip_student_data b  where kd_biodata= ? ", [(string) ($row_open_class[2])]);

		$resource_jml_murid = db_query_soft($query_jml_murid, $__p_query_jml_murid ?? []);
		$keluar_jml_murid = db_num_rows($resource_jml_murid);				
		if(num(db_num_rows($resource_jml_murid)) > 0)
			{
			while ($row_jml_murid  =  db_fetch($resource_jml_murid, PDO::FETCH_NUM))
				{	
				$nama_lengkap_student = $row_jml_murid[0];
				}
			}
		
		//===score target
		$query_target = q_set($__p_query_target, "SELECT target_score FROM vip_class_score_profile where kd_billing =  ? ", [(string) ($row_open_class[4])]);
		$resource_target = db_query_soft($query_target, $__p_query_target ?? []);
		if(num(db_num_rows($resource_target)) > 0)
			{
			while ($row_target  =  db_fetch($resource_target, PDO::FETCH_NUM))	
				{
				$target_score = $row_target[0];	
				}
			}		
		if (num($target_score) <=0){$target_score = 0;}
		//===score placement
		$query_score = q_set($__p_query_score, "SELECT t.L,t.other, t.S, t.R, t.W,  t.total,t.no FROM ves_data.vip_class_score_profile t where t.kd_biodata =  ? and class_code = ? and jns_test = '1' order by test_date desc limit 1", [(string) ($row_open_class[2]), (string) ($row_open_class[0])]);
		$resource_score = db_query_soft($query_score, $__p_query_score ?? []);
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
		else
			{
		$query_score = q_set($__p_query_score, "SELECT t.L,t.other, t.S, t.R, t.W,  t.total,t.no,test_date FROM ves_inc.tb_acd_history t where t.kd_biodata =  ? and t.kd_biodata <>'' order by no desc limit 1", [(string) ($row_open_class[2])]);
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
				$test_date = $row_score[7];				
				$adascore = 1;
				}
			}
			$query_simpan_score_pt = q_set($__p_query_simpan_score_pt, "insert into ves_data.vip_class_score_profile ( kd_cbg, class_code, kd_biodata,jns_test,L,S,R,W,other,remark, test_date,dt_entry,pic) values (? ,? ,? ,'1',? ,? ,? ,? ,? ,? ,? ,? ,? ) ", [(string) ($kd_branch), (string) ($kdcl), (string) ($kd_biodata), (string) ($l), (string) ($s), (string) ($r), (string) ($w), (string) ($st), (string) ($ttl), (string) ($test_date), (string) ($tgl_hari_ini), (string) ($nama_lengkap)]);	

	$resource_simpan = db_query_or_die('errro_simpan2', $query_simpan_score_pt, $__p_query_simpan_score_pt ?? []);	
			
			}

		//===score mid	
		$query_score_mid = q_set($__p_query_score_mid, "SELECT t.L,t.other, t.S, t.R, t.W,  t.total,t.no FROM ves_data.vip_class_score_profile t where t.kd_biodata =  ? and class_code = ? and jns_test = '2' order by test_date desc limit 1", [(string) ($row_billing[7]), (string) ($row_billing[11])]);
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
		$query_score_final = q_set($__p_query_score_final, "SELECT t.L,t.other, t.S, t.R, t.W,  t.total,t.no FROM ves_data.vip_class_score_profile t where t.kd_biodata =  ? and class_code = ? and jns_test = '3' order by test_date desc limit 1", [(string) ($row_open_class[2]), (string) ($row_open_class[0])]);
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
		//====================
		$query_last_date = q_set($__p_query_last_date, "SELECT max(mulai_tm) as selesai,date_format(max(mulai_tm),'%b %d, %Y') FROM ves_data.vip_teacher_schedule a where a.kelas = ? ", [(string) ($row_open_class[0])]);
		$resource_last_date = db_query_soft($query_last_date, $__p_query_last_date ?? []);
		$keluar_last_date = db_num_rows($resource_last_date);				
		if(num(db_num_rows($resource_last_date)) > 0)
			{
			while ($row_last_date  =  db_fetch($resource_last_date, PDO::FETCH_NUM))
				{
				$kelas_selesai = $row_last_date[1];					
				}
			}
		//=kehadiran
		$query_hadir = q_set($__p_query_hadir, "SELECT sum(st_attendance) FROM vip_attendance v where kd_biodata = ? and kd_class = ? ", [(string) ($row_open_class[2]), (string) ($row_open_class[0])]);
		$resource_hadir = db_query_soft($query_hadir, $__p_query_hadir ?? []);		
		if(num(db_num_rows($resource_hadir)) > 0)
			{
			while ($row_hadir  =  db_fetch($resource_hadir, PDO::FETCH_NUM))
				{
				$kehadiran= $row_hadir[0];
				}
			}	
		$presen_hadir = num((div($kehadiran, $jml_kelas)))*100;
		//==

	
	?>     <tbody>
	          <tr>
	            <td height="14" align=center class="style24" <?php echo e($warna) ?>><?php echo  e($baris_teacher)  ?></td>
				  <td align=center class="style24" <?php echo e($warna) ?>><?php echo  e($row_open_class[0])  ?></td>
	            <td align=center class="style24"<?php echo e($warna) ?>><?php echo  e($row_open_class[1])  ?>-<?php echo  e($tgl_selesai)  ?></td>
	            <td align=left class="style24" <?php echo e($warna) ?>><?php echo e($st_kelas) ?></td>
	            <td align=left class="style24" <?php echo e($warna) ?>><?php echo  e($nama_lengkap_student)  ?></td>
	            <td align=center class="style24" <?php echo e($warna) ?>><strong><?php echo e($target_score) ?></strong></td>
	            <td align=center class="style24"<?php echo e($warna) ?>><?php echo  e($l)  ?></td>
	            <td align=center class="style24"<?php echo e($warna) ?>><?php echo  e($r)  ?></td>
	            <td align=center class="style24"<?php echo e($warna) ?>><?php echo  e($w)  ?></td>
	            <td align=center class="style24"<?php echo e($warna) ?>><?php echo  e($sp)  ?></td>
	            <td align=center class="style24"<?php echo e($warna) ?>><?php echo  e($st)  ?></td>
	            <td align=center class="style24"<?php echo e($warna) ?>><?php echo  e($ttl)  ?></td>
	            <td align=center class="style24"<?php echo e($warna) ?>><?php echo  e($l_final)  ?></td>
	            <td align=center class="style24"<?php echo e($warna) ?>><?php echo  e($r_final)  ?></td>
	            <td align=center class="style24"<?php echo e($warna) ?>><?php echo  e($w_final)  ?></td>
	            <td align=center class="style24"<?php echo e($warna) ?>><?php echo  e($sp_final)  ?></td>
	            <td align=center class="style24"<?php echo e($warna) ?>><?php echo  e($st_final)  ?></td>
	            <td align=center class="style24"<?php echo e($warna) ?>><?php echo  e($ttl_final)  ?></td>
	            <td width="2%" align=center class="style24"<?php echo e($warna) ?>><?php echo  e($kehadiran)  ?>/<?php echo  e($jml_kelas)  ?></td>
	            <td width="3%" align=center class="style24"<?php echo e($warna) ?>><?php echo  round(num($presen_hadir),2)  ?> % </td>
	            <td align=center class="style24"<?php echo e($warna) ?>>&nbsp;</td>
	            <td align=center class="style24"<?php echo e($warna) ?>>&nbsp;</td>
              
	          <?php 	$adafile = 0; 				$jadwal_1= '';$target_score = '';
				$baris_jadwal = ''; 
				$nmfile ='';					
				$lokasifile = '';$baris_teacher ='';$l = '';$st = '';$sp = '';$r = '';$w = '';$ttl = ''; $adascore = '';$l_mid = '';$st_mid = '';$sp_mid = '';$r_mid = '';
			$w_mid = '';$ttl_mid = ''; $adascore_mid = '';$l_final = '';$st_final = '';$sp_final = '';$r_final = '';$w_final = '';$ttl_final = ''; $adascore_final = '';$tgl_la = '';		$tgl_tutor = '';$tgl_lc='';$tgl_ext = '';$kd_st = 4 ; $nama_lengkap_student  ='';}} ?></tr>
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

  </aside>
  <!-- /.control-sidebar -->
  <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->

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
if (($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['Export']))) 
{
echo "<script type=\"text/javascript\">\n";
		echo "window.location=('vip_student_recordxl.php?cd_cl=" . e(u($cd_cl)) . "&progress=" . e(u($progress)) . "&ds=" . e(u($date_start)) . "&de=" . e(u($date_end)) . "');\n";				
		echo "</script>";
}
						  
?>
