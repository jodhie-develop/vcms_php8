<?php
require_once __DIR__ . "/_lib/bootstrap.php"; auth_require_login(); 
date_default_timezone_set('Asia/Jakarta');
include __DIR__ . "/conndb.php";
include __DIR__ . "/profiledata.php";
 include __DIR__ . "/atas.php";
$hari=date("d");
$bulan=date("m");
$tahun=date("Y");
$hari_ini = "$tahun-$bulan-$hari";
$date_start = in_val('date_start', 'get');
$date_end = in_val('date_end', 'get');
if ($date_start ==''){$date_start = "2021-01-01";}
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
		

if (num($kd_cbg) ==100){$cabang = 'Online';}
if ($kd_cbg ==''){$cabang = 'National';}
if ($kd_cbg =='111'){$cabang = 'National';}
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
if (num($kd_cbg) == 351){$cabang = 'Vpro Sby';}
if (num($kd_cbg) == 357){$cabang = 'Vpro Jkt';}
if (num($kd_cbg) == 355){$cabang = 'Vpro Dps';}
if (num($kd_cbg) == 358){$cabang = 'Vpro Mlg';}
if (num($kd_cbg) == 353){$cabang = 'Vpro Bdg';}
if (num($kd_cbg) == 111){$cabang = 'National';}	
$tgl_awal = in_val('tgl_awal', 'get');
$tgl_akhir = in_val('tgl_akhir', 'get');
$activities = in_val('activities', 'get');
$kelas = in_val('kelas', 'get');			
if ($tgl_awal == ''){$tgl_awal = $hari_ini;$tgl_akhir=$hari_ini;}
	}
$Display = in_val('Display', 'get');
$query_nama_teacher = q_set($__p_query_nama_teacher, "SELECT  a.nm_teacher,v.nm_teacher   FROM vip_teacher_schedule v left join vip_teacher_name a on v.nm_teacher = a.kd_teacher left join tb_user c on a.nm_teacher = c.nama_detail where v.mulai_tm between ? and ? and (status_kelas <> 0) and v.nm_teacher = ? group by v.nm_teacher ", [(string) ($tgl_awal) . " 00:00:00", (string) ($tgl_akhir) . " 23:00:00", (string) ($nm_teacher)]);
$result_nama_teacher=db_query_or_die("Wah error nih29", $query_nama_teacher, $__p_query_nama_teacher ?? []);
$a = 1;
if ($result_nama_teacher) 
	{ 
	while ($r_nama_teacher = db_fetch($result_nama_teacher, PDO::FETCH_NUM))
		{ 
		$nama_teacher_detail = $r_nama_teacher[0];	}}
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
 <?php	 include __DIR__ . "/left.php";	 ?>
 <?php //====================== ?>
 <div class="content-wrapper">
    <!-- Content Header (Page header) -->
   <?php if ($kelompok == 'ACD' or  $posisi =='Admin' or $posisi == 'SC'  or $posisi == 'CM'  or $posisi = 'ACCM')
$query = "SELECT date_format(v.mulai_tm,'%d %b %y'), a.nm_teacher , date_format(v.mulai_tm,'%H:%i'), date_format(v.selesai_tm,'%H:%i'), v.kelas, v.room, v.keterangan ,v.center,v.status_kelas,v.id,v.pic,date_format(v.dt_entry,'%d %b %y'),d.nama_lengkap FROM vip_teacher_schedule v left join vip_teacher_name a on v.nm_teacher = a.kd_teacher left join tb_user c on a.nm_teacher = c.nama_detail left join vip_student_data d on v.kd_biodata = d.kd_biodata where v.kd_branch = $kd_cbg" ;

//===========academic==
?>
<section class="content-header">
<h1>Teaching Hour Report <?php echo e($Display) ?></h1>
<div class="tab-content">
  <div id="act" class="tab-pane fade in active">
	<div class="panel box box-primary">
	<form name="myform" id="myform">
		<div class="box-header with-border">

		<div class="col-md-2">
		  <div class="form-group">
		    <label>Center</label>
		    <select class="form-control" name="kd_cbg" >
		      <option value="0">--CHOOSE--</option>
		      <option value="111">National</option>				
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
		      <option value="100">Online</option>
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
		    <input name="tgl_awal"  class="form-control"  type="date" value="<?php echo e($tgl_awal) ?>" />
		  </div>
		  </div>
		<div class="col-md-2">
		  <div class="form-group">
		    <label>End Period</label>
		     <input name="tgl_akhir"  class="form-control"  type="date" value="<?php echo e($tgl_akhir) ?>" />
	      </div>
		  </div>
		<div class="col-md-2">
		  <div class="form-group">
		    <label>Teacher</label>
		    <select class="form-control" name="nm_teacher">
	      <option>--All--</option>
		      <?php
if (num($kd_cbg) !=111)
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
		    <select class="form-control" name="kelas">
		      <option>--All--</option>
		      <?php
if (num($kd_cbg) !=111)
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
		  <div class="col-md-2">
	  	          
		  	       <input name="Display" type="submit" id="Display"  class="form-control"  value="Display" /> 
		  </div>
		<h4 class="box-title">		  <br>
		</h4>
		</div>
	  </form>

      <div class="box-body">
             

<br>

	</a>

        </ul>
                  <div class="box-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>No</th>
                  <th>Date &amp; Day</th>
                  <th align="center"><?php echo e($nama_teacher_detail) ?></th>
                  </tr>
					                <tr>
                  <th>&nbsp;</th>
                  <th>&nbsp;</th>
                  <th><table width="80%" border="0" cellspacing="0" cellpadding="0">
                    <tbody>
                      
                      
                      <tr>
                        <td width="20%">Time</td>
                        <td width="20%">Reguler</td>
                        <td width="20%">Support</td>
                        <td width="20%">LC</td>
                        
                      </tr>
                      
                    </tbody>
</table></th>
                  </tr>
                </thead>
                <tbody>
					
<?php
	$nomor = 1;
$query_group_hari = q_set($__p_query_group_hari, "SELECT  date_format(mulai_tm, '%W'),date_format(mulai_tm,'%d %M %y'),date_format(mulai_tm,'%Y-%m-%d')   FROM vip_teacher_schedule v left join vip_teacher_name a on v.nm_teacher = a.kd_teacher left join tb_user c on a.nm_teacher = c.nama_detail where v.mulai_tm between ? and ? and (status_kelas <> 0) and v.nm_teacher = ? group by date_format(mulai_tm,'%Y-%m-%d') ", [(string) ($tgl_awal) . " 00:00:00", (string) ($tgl_akhir) . " 23:00:00", (string) ($nm_teacher)]);

$result_group_hari=db_query_or_die("Wah error nih19", $query_group_hari, $__p_query_group_hari ?? []);
if ($result_group_hari) 
	{ 
	while ($r_group_hari = db_fetch($result_group_hari, PDO::FETCH_NUM))
		{ 
		$nama_hari_group = $r_group_hari[0];	
		$tanggal_lengkap =$r_group_hari[3];
		$tanggal_saja =$r_group_hari[2];
		$tanggal_tampil =$r_group_hari[1];		

		
?>	

                <tr>
                  <td><?php echo e($nomor) ?></td>
                  <td><?php echo e($nama_hari_group) ?><br>
<?php echo e($tanggal_tampil) ?> </td>
                  <td><table width="80%" border="0" cellspacing="0" cellpadding="0">
                    <tbody>
                      
  <?php
	
$query_list_waktu = q_set($__p_query_list_waktu, "SELECT  date_format(mulai_tm, '%W'),date_format(mulai_tm,'%H:%i'),date_format(selesai_tm,'%H:%i'),a.nm_teacher, v.kelas,status_kelas,TIME_FORMAT(TIMEDIFF(date_format(selesai_tm,'%Y-%m-%d %H:%i:01'), date_format(mulai_tm,'%Y-%m-%d %H:%i:00')),'%H') as durasi_jam    FROM vip_teacher_schedule v left join vip_teacher_name a on v.nm_teacher = a.kd_teacher left join tb_user c on a.nm_teacher = c.nama_detail where  date_format(mulai_tm,'%Y-%m-%d') =? and (status_kelas <> 0) and v.nm_teacher = ? group by mulai_tm ", [(string) ($tanggal_saja), (string) ($nm_teacher)]);

$result_list_waktu=db_query_or_die("Wah error nih39", $query_list_waktu, $__p_query_list_waktu ?? []);
if ($result_list_waktu) 
	{ 
	while ($r_list_waktu = db_fetch($result_list_waktu, PDO::FETCH_NUM))
		{ 
		$jml_durasi = $r_list_waktu[6];
		$tampil_kelas_durasi = "$r_list_waktu[4]($r_list_waktu[6])";
		$st_kelas= $r_list_waktu[5];
		$kolom_reguler = '';
		$kolom_support = '';
		$kolom_lc = '';	
		if(num($st_kelas) == 1){$kolom_reguler = $tampil_kelas_durasi;$ttl_reg = num($ttl_reg) + num($jml_durasi) ; }
		elseif(num($st_kelas) == 897){$kolom_support = $tampil_kelas_durasi;$ttl_support = num($ttl_support) + num($jml_durasi) ; }
		elseif(num($st_kelas) == 71 or num($st_kelas) == 75 ){$kolom_lc = $tampil_kelas_durasi;$ttl_lc = num($ttl_lc) + num($jml_durasi) ; }		
		
?>		  
                      <tr>
                        <td width="20%"><?php echo e($r_list_waktu[1])." - " .e($r_list_waktu[2]) ?></td>
                        <td width="20%"><?php echo e($kolom_reguler)  ?></td>
                        <td width="20%"><?php echo e($kolom_support)  ?></td>
                        <td width="20%"><?php echo e($kolom_lc)  ?></td>
                        
                      </tr>
  <?php  } } ?>	  
                      <tr>
                        <td width="20%" bgcolor="#838181"><strong>Total</strong></td>
                        <td width="20%" bgcolor="#838181" align="center"><strong><?php echo e($ttl_reg)  ?></strong></td>
                        <td width="20%" bgcolor="#838181" align="center"><strong><?php echo e($ttl_support)  ?></strong></td>
                        <td width="20%" bgcolor="#838181" align="center"><strong><?php echo e($ttl_lc)  ?></strong></td>
                        
                      </tr>
                    </tbody>
</table></td>
                  </tr>
<?php $nomor = num($nomor)+1;  }} ?>					
                </tbody>
                <tfoot>
                <tr>
                  <th></th>
<?php					
$query_comp_hr = q_set($__p_query_comp_hr, "SELECT com_hr FROM vip_teacher_name where kd_teacher = ? ", [(string) ($nm_teacher)]);
$result_comp_hr=db_query_or_die("Wah error nih49", $query_comp_hr, $__p_query_comp_hr ?? []);
if ($result_comp_hr) 
	{ 
	while ($r_comp_hr = db_fetch($result_comp_hr, PDO::FETCH_NUM))
		{ 
		$comp_hr=$r_comp_hr[0];
		}
	}
?>					
                  <th>Complamentary TH :<br>
                    <?php echo e($comp_hr) ?> Hours/Month</th>
                  <th><table width="80%" border="0" cellspacing="0" cellpadding="0">
                    <tbody>
                      <tr>
                        <td width="20%" bgcolor="#BCB5B6"> Total this Period</td>
                        <td width="20%" bgcolor="#BCB5B6" align="center"><strong><?php echo e($ttl_reg)  ?></strong></td>
                        <td width="20%" bgcolor="#BCB5B6" align="center"><strong><?php echo e($ttl_support)  ?></strong></td>
                        <td width="20%" bgcolor="#BCB5B6" align="center"><strong><?php echo e($ttl_lc)  ?></strong></td>
                      </tr>
                      <tr>
                        <td bgcolor="#BCB5B6">Month Todate</td>
<?php
$awal_bulan = substr($tgl_akhir,0,7);
$awal_tahun = substr($tgl_akhir,0,4);							
						
$query_month_todate = q_set($__p_query_month_todate, "SELECT sum(TIME_FORMAT(TIMEDIFF(date_format(selesai_tm,'%Y-%m-%d %H:%i:01'), date_format(mulai_tm,'%Y-%m-%d %H:%i:00')),'%H') ) as durasi_jam FROM vip_teacher_schedule where mulai_tm between ? and ? and nm_teacher = ? and status_kelas = 1\t", [(string) ($awal_bulan) . "-01", (string) ($tgl_akhir), (string) ($nm_teacher)]);
$result_month_todate=db_query_or_die("Wah error nih39", $query_month_todate, $__p_query_month_todate ?? []);
if ($result_month_todate) 
	{ 
	while ($r_month_todate = db_fetch($result_month_todate, PDO::FETCH_NUM))
		{ 
		$month_todate=$r_month_todate[0];
		}
	}	
$query_year_todate = q_set($__p_query_year_todate, "SELECT sum(TIME_FORMAT(TIMEDIFF(date_format(selesai_tm,'%Y-%m-%d %H:%i:01'), date_format(mulai_tm,'%Y-%m-%d %H:%i:00')),'%H') ) as durasi_jam FROM vip_teacher_schedule where mulai_tm between ? and ? and nm_teacher = ? and status_kelas = 1\t", [(string) ($awal_tahun) . "-01-01", (string) ($tgl_akhir), (string) ($nm_teacher)]);
$result_year_todate=db_query_or_die("Wah error nih39", $query_year_todate, $__p_query_year_todate ?? []);
if ($result_year_todate) 
	{ 
	while ($r_year_todate = db_fetch($result_year_todate, PDO::FETCH_NUM))
		{ 
		$year_todate=$r_year_todate[0];
		}
	}
							
$query_month_todate_sup = q_set($__p_query_month_todate_sup, "SELECT sum(TIME_FORMAT(TIMEDIFF(date_format(selesai_tm,'%Y-%m-%d %H:%i:01'), date_format(mulai_tm,'%Y-%m-%d %H:%i:00')),'%H') ) as durasi_jam FROM vip_teacher_schedule where mulai_tm between ? and ? and nm_teacher = ? and status_kelas = 897\t", [(string) ($awal_bulan) . "-01", (string) ($tgl_akhir), (string) ($nm_teacher)]);
$result_month_todate_sup=db_query_or_die("Wah error nih39", $query_month_todate_sup, $__p_query_month_todate_sup ?? []);
if ($result_month_todate_sup) 
	{ 
	while ($r_month_todate_sup = db_fetch($result_month_todate_sup, PDO::FETCH_NUM))
		{ 
		$month_todate_sup=$r_month_todate_sup[0];
		}
	}	
$query_year_todate_sup = q_set($__p_query_year_todate_sup, "SELECT sum(TIME_FORMAT(TIMEDIFF(date_format(selesai_tm,'%Y-%m-%d %H:%i:01'), date_format(mulai_tm,'%Y-%m-%d %H:%i:00')),'%H') ) as durasi_jam FROM vip_teacher_schedule where mulai_tm between ? and ? and nm_teacher = ? and status_kelas = 897\t", [(string) ($awal_tahun) . "-01-01", (string) ($tgl_akhir), (string) ($nm_teacher)]);
$result_year_todate_sup=db_query_or_die("Wah error nih39", $query_year_todate_sup, $__p_query_year_todate_sup ?? []);
if ($result_year_todate_sup) 
	{ 
	while ($r_year_todate_sup = db_fetch($result_year_todate_sup, PDO::FETCH_NUM))
		{ 
		$year_todate_sup=$r_year_todate_sup[0];
		}
	}							
$query_month_todate_lc = q_set($__p_query_month_todate_lc, "SELECT sum(TIME_FORMAT(TIMEDIFF(date_format(selesai_tm,'%Y-%m-%d %H:%i:01'), date_format(mulai_tm,'%Y-%m-%d %H:%i:00')),'%H') ) as durasi_jam FROM vip_teacher_schedule where mulai_tm between ? and ? and nm_teacher = ? and (status_kelas = 71 or status_kelas = 75)\t", [(string) ($awal_bulan) . "-01", (string) ($tgl_akhir), (string) ($nm_teacher)]);
$result_month_todate_lc=db_query_or_die("Wah error nih39", $query_month_todate_lc, $__p_query_month_todate_lc ?? []);
if ($result_month_todate_lc) 
	{ 
	while ($r_month_todate_lc = db_fetch($result_month_todate_lc, PDO::FETCH_NUM))
		{ 
		$month_todate_lc=$r_month_todate_sup[0];
		}
	}	
$query_year_todate_lc = q_set($__p_query_year_todate_lc, "SELECT sum(TIME_FORMAT(TIMEDIFF(date_format(selesai_tm,'%Y-%m-%d %H:%i:01'), date_format(mulai_tm,'%Y-%m-%d %H:%i:00')),'%H') ) as durasi_jam FROM vip_teacher_schedule where mulai_tm between ? and ? and nm_teacher = ? and (status_kelas = 71 or status_kelas = 75)\t", [(string) ($awal_tahun) . "-01-01", (string) ($tgl_akhir), (string) ($nm_teacher)]);
$result_year_todate_lc=db_query_or_die("Wah error nih39", $query_year_todate_lc, $__p_query_year_todate_lc ?? []);
if ($result_year_todate_lc) 
	{ 
	while ($r_year_todate_lc = db_fetch($result_year_todate_lc, PDO::FETCH_NUM))
		{ 
		$year_todate_lc=$r_year_todate_lc[0];
		}
	}

									
?>	
                        <td align="center" bgcolor="#BCB5B6"><?php echo e($month_todate) ?></td>
                        <td align="center" bgcolor="#BCB5B6"><?php echo e($month_todate_sup) ?></td>
                        <td align="center" bgcolor="#BCB5B6"><?php echo e($month_todate_lc) ?></td>
                      </tr>
                      <tr>
                        <td bgcolor="#BCB5B6">Year Todate</td>
                        <td align="center" bgcolor="#BCB5B6"><?php echo e($year_todate) ?></td>
                        <td align="center" bgcolor="#BCB5B6"><?php echo e($year_todate_sup) ?></td>
                        <td align="center" bgcolor="#BCB5B6"><?php echo e($year_todate_lc) ?></td>
                      </tr>
                    </tbody>
                  </table></th>
                  </tr>
                </tfoot>
              </table>
      </div></div>
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
