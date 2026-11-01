<?php
require_once __DIR__ . "/_lib/bootstrap.php"; csrf_guard_get(); auth_require_login(); 
include __DIR__ . "/conndb.php";
include __DIR__ . "/profiledata.php";
include __DIR__ . "/atas.php";
include __DIR__ . "/left.php";
$ada='';
$hari=date("d");
$bulan=date("m");
$tahun=date("Y");
$hari_ini = "$tahun-$bulan-$hari";
$date_start = in_val('date_start', 'post');
$date_end = in_val('date_end', 'post');
if ($date_start ==''){$date_start = "$tahun-$bulan-01";}
if ($date_end ==''){$date_end = $hari_ini;}

$nm_center = in_val('nm_center', 'post');


$nm_sc = in_val('nm_sc', 'post');
$kelompok = $_SESSION['kelompok'];
$posisi = $_SESSION['posisi']; 
$kd_staff = $_SESSION['kd_staff'] ;
$nama_lengkap = $_SESSION['nama_lengkap'];
if($nm_center == 'East Sby'){$kd_center = 1;}
elseif($nm_center == 'West Sby'){$kd_center = 2;}
elseif($nm_center == 'Denpasar'){$kd_center = 3;}
elseif($nm_center == 'Malang'){$kd_center = 8;}
elseif($nm_center == 'South Jkt'){$kd_center = 4;}
elseif($nm_center == 'North Jkt'){$kd_center = 5;}
elseif($nm_center == 'West Jkt'){$kd_center = 6;}
elseif($nm_center == 'Bandung'){$kd_center = 7;}
elseif($nm_center == 'PIK'){$kd_center = 11;}
elseif($nm_center == 'Serpong'){$kd_center = 12;}
elseif($nm_center == 'All'){$kd_center = 111;}

if (num($kd_center) != 111)
	{
	$query_nm_sc = q_set($__p_query_nm_sc, "select nama_detail from ves_data.tb_user where (posisi = 'SC' or posisi = 'AC' or posisi = 'CM' or posisi = 'admission') and aktif = 'Y' and kd_branch = ?  order by nama_detail", [(string) ($kd_center)]);
	}
else
	{
	$query_nm_sc = q_set($__p_query_nm_sc, "select nama_detail from ves_data.tb_user where (posisi = 'SC' or posisi = 'AC' or posisi = 'CM' or posisi = 'admission') and aktif = 'Y' order by nama_detail");	
	}
$a = 0;
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

  <!-- Content Wrapper. Contains page content -->
 <form method=POST><?php echo csrf_field(); ?>
 
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>VOS Incentive List<br>
    </h1>
    <div class="col-md-3">
      <div class="form-group">
        <label>Center</label>
        <select class="form-control" name="nm_center"  onChange="this.form.submit()">
			
					
<?php 	if($nama_lengkap == 'Indah Nur Atika Sari'){?>
			              <option value="Denpasar">Denpasar</option>
			
<?php	}elseif($nama_lengkap == 'laura natalia'){?>
			              <option value="Malang">Malang</option>
<?php }		
elseif($nama_lengkap == 'Dian Nur Anisa'){?>
              <option value="South Jkt">South Jkt</option>
<?php }				
	elseif ($nama_lengkap == 'jimmy' or $nama_lengkap=='kimberly')
		{ ?>			
              <option value="East Sby">East Sby</option>
              <option value="West Sby">West Sby</option>
              <option value="Denpasar">Denpasar</option>
              <option value="Malang">Malang</option>
              <option value="South Jkt">South Jkt</option>
              <option value="North Jkt">North Jkt</option>
              <option value="West Jkt">West Jkt</option>
              <option value="Bandung">Bandung</option>
              <option value="PIK">PIK</option>
              <option value="Serpong">Serpong</option>
              <option value="All">All</option>				
<?php 	} elseif ($nama_lengkap == 'maria simbolon')
		{ ?>			

              <option value="Bandung">Bandung</option>			
<?php 	}  elseif ($nama_lengkap == 'Christine Tania') 
		{ ?>			

              <option value="South Jkt">South Jkt</option>
			
<?php 	}  elseif ($nama_lengkap == 'Esther') 
		{ ?>			
              <option value="South Jkt">South Jkt</option>			
              <option value="PIK">PIK</option>
              <option value="Serpong">Serpong</option>
              <option value="West Jkt">West Jkt</option>	
              <option value="All">All</option>				
<?php 	}	elseif ($nama_lengkap == 'Indrani Jiwanda') 
		{ ?>			
              <option value="Bali">Bali</option>				
<?php 	}	elseif 	($nama_lengkap =='Patricia Corinthian')
		{ ?>
              <option value="North Jkt">North Jkt</option>	
			
<?php 	}	elseif 	($nama_lengkap =='Lianna Leticia')
		{ ?>
              <option value="PIK">PIK</option>			
<?php 	}	elseif 	($nama_lengkap =='Angeline Aurelia')
		{ ?>
              <option value="West Sby">West Sby</option>			
<?php 	}	elseif 	($nama_lengkap =='Eric Dwitama')
		{ ?>
              <option value="East Sby">East Sby</option>			
<?php 	}	?>
          <option selected><?php echo  e($nm_center) ?></option>
        </select>
      </div>
    </div>
    <div class="col-md-3">
      <div class="form-group">
        <label>Staff Name</label>
        <select class="form-control" name="nm_sc"  onChange="this.form.submit()">
			              <option value="All">All</option>	
          <?php
								$resource_nm_sc = db_query_or_die('errro_7', $query_nm_sc, $__p_query_nm_sc ?? []);
								while ($row_nm_sc=  db_fetch($resource_nm_sc, PDO::FETCH_NUM))
									{
							  		echo '<option value="'.e($row_nm_sc[0]).'">'.e($row_nm_sc[0]).'</option>';
							  		}      ?>
          <option selected><?php echo  e($nm_sc) ?></option>
        </select>
      </div>
    </div>
    <div class="col-md-3">
      <div class="form-group">
        <label>Period<br>
        </label>
      </div>
      <div class="form-group"><small>
      <input type="date" format="dd/MM/yyyy" name="date_start" id="date" value="<?php echo e($date_start) ; ?>" onChange="this.form.submit()">
        </small>to <small>
        <input type="date" name="date_end" id="date3" value="<?php echo e($date_end) ; ?>" onChange="this.form.submit()" >
      </small></div>		
    </div>
  </section>
  <!-- Main content -->
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
		  <label>VOS Incentive Claim List </label>
		1</div>				
	  </div>
	  <div class="col-md-12">
	    <div class="form-group">
	      	      <table width="100%" class="table table-bordered table-striped" id="example1">
                <thead>
                <tr>
                  <th width="5%" align="center">No</th>
                  <th width="7%">Enroll Date</th>
                  <th width="19%">Student Name</th>
                  <th width="30%">Institution - PV</th>
                  <th width="10%">Admission Step</th>
                  <th width="9%">Professional Fee</th>
                  <th width="12%">Estimated <br>
                  Incentive</th>
                  <th width="8%">Incentive Status</th>
                  <th width="8%">Incentive Claim</th>
                  </tr>
                </thead>
<?php

if ($nm_center == 'All' and $nm_sc =='All')
{
	if ($nama_lengkap =='jimmy' or $nama_lengkap =='kimberly')
	{
			$query_billing = q_set($__p_query_billing, "\r
\t\t\tSELECT t.cabang, date_format(t.enroll_date,'%d/%m/%y'), t.kd_biodata, t.nama, a.grade, a.school, t.program, t.major, t.h_nh, t.p_np,final_status, last_remark, last_update, t.ori_school, t.ori_grade, a.country, t.pic, mkt_source, mkt_source_dtl, nm_event, adm_pic,enroll_date, kd_biodata,t.kd_school, t.status,t.no,t.pv_estimated, t.pv_fix FROM tb_sales_report t left join tb_master_partner a on t.kd_school = a.kd_school where t.enroll_date between ? and ? and t.kd_cabang between 1 and 12 order by enroll_date desc", [(string) ($date_start), (string) ($date_end)]);	
	}
	elseif ($nama_lengkap =='Esther')
	{
			$query_billing = q_set($__p_query_billing, "\r
\t\t\tSELECT t.cabang, date_format(t.enroll_date,'%d/%m/%y'), t.kd_biodata, t.nama, a.grade, a.school, t.program, t.major, t.h_nh, t.p_np,final_status, last_remark, last_update, t.ori_school, t.ori_grade, a.country, t.pic, mkt_source, mkt_source_dtl, nm_event, adm_pic,enroll_date, kd_biodata,t.kd_school, t.status,t.no,t.pv_estimated, t.pv_fix FROM tb_sales_report t left join tb_master_partner a on t.kd_school = a.kd_school where t.enroll_date between ? and ? and  (t.kd_cabang  = 4 or t.kd_cabang  = 6 or t.kd_cabang  = 11 or t.kd_cabang  = 12 ) order by enroll_date desc", [(string) ($date_start), (string) ($date_end)]);	
	}	elseif ($nama_lengkap =='Cynthia Viangga')
	{
			$query_billing = q_set($__p_query_billing, "SELECT t.cabang, date_format(t.enroll_date,'%d/%m/%y'), t.kd_biodata, t.nama, a.grade, a.school, t.program, t.major, t.h_nh, t.p_np,final_status, last_remark, last_update, t.ori_school, t.ori_grade, a.country, t.pic, mkt_source, mkt_source_dtl, nm_event, adm_pic,enroll_date, kd_biodata,t.kd_school, t.status,t.no,t.pv_estimated, t.pv_fix FROM tb_sales_report t left join tb_master_partner a on t.kd_school = a.kd_school where t.enroll_date between ? and ? and t.kd_cabang = 5 order by enroll_date desc", [(string) ($date_start), (string) ($date_end)]);	
	}	
	
}
elseif ($nm_center != 'All' and $nm_sc =='All')
	{

	$query_billing = q_set($__p_query_billing, "SELECT t.cabang, date_format(t.enroll_date,'%d/%m/%y'), t.kd_biodata, t.nama, a.grade, a.school, t.program, t.major, t.h_nh, t.p_np,final_status, last_remark, last_update, t.ori_school, t.ori_grade, a.country, t.pic, mkt_source, mkt_source_dtl, nm_event, adm_pic,enroll_date, kd_biodata,t.kd_school, t.status,t.no,t.pv_estimated, t.pv_fix FROM tb_sales_report t left join tb_master_partner a on t.kd_school = a.kd_school where t.enroll_date between ? and ? and t.kd_cabang = ? order by enroll_date desc", [(string) ($date_start), (string) ($date_end), (string) ($kd_center)]);	

	}
elseif ($nm_center == 'All' and $nm_sc !='All')
	{

	$query_billing = q_set($__p_query_billing, "SELECT t.cabang, date_format(t.enroll_date,'%d/%m/%y'), t.kd_biodata, t.nama, a.grade, a.school, t.program, t.major, t.h_nh, t.p_np,final_status, last_remark, last_update, t.ori_school, t.ori_grade, a.country, t.pic, mkt_source, mkt_source_dtl, nm_event, adm_pic,enroll_date, kd_biodata,t.kd_school, t.status,t.no,t.pv_estimated, t.pv_fix FROM tb_sales_report t left join tb_master_partner a on t.kd_school = a.kd_school where t.enroll_date between ? and ? and t.pic = ? order by enroll_date desc", [(string) ($date_start), (string) ($date_end), (string) ($nm_sc)]);	

	}					  
else
	{
	if ($nm_sc != 'All')
		{
		$query_billing = q_set($__p_query_billing, "SELECT t.cabang, date_format(t.enroll_date,'%d/%m/%y'), t.kd_biodata, t.nama, a.grade, a.school, t.program, t.major, t.h_nh, t.p_np,final_status, last_remark, last_update, t.ori_school, t.ori_grade, a.country, t.pic, mkt_source, mkt_source_dtl, nm_event, adm_pic,enroll_date, kd_biodata,t.kd_school, t.status,t.no,t.pv_estimated, t.pv_fix FROM tb_sales_report t left join tb_master_partner a on t.kd_school = a.kd_school where t.enroll_date between ? and ? and t.pic = ? and  t.kd_cabang = ? order by enroll_date desc", [(string) ($date_start), (string) ($date_end), (string) ($nm_sc), (string) ($kd_center)]);	
		}
	else
		{
		if ($nama_lengkap =='jimmy' or $nama_lengkap =='kimberly')
			{
			$query_billing = q_set($__p_query_billing, "\r
\t\t\tSELECT t.cabang, date_format(t.enroll_date,'%d/%m/%y'), t.kd_biodata, t.nama, a.grade, a.school, t.program, t.major, t.h_nh, t.p_np,final_status, last_remark, last_update, t.ori_school, t.ori_grade, a.country, t.pic, mkt_source, mkt_source_dtl, nm_event, adm_pic,enroll_date, kd_biodata,t.kd_school, t.status,t.no,t.pv_estimated, t.pv_fix FROM tb_sales_report t left join tb_master_partner a on t.kd_school = a.kd_school where t.enroll_date between ? and ? and  (t.kd_cabang  = 1 or t.kd_cabang  = 2 or t.kd_cabang  = 3 or t.kd_cabang  = 4 or t.kd_cabang  = 5 or t.kd_cabang  = 6 or t.kd_cabang = 7 or t.kd_cabang  = 8 or t.kd_cabang  = 11 or t.kd_cabang  = 12 )  order by enroll_date desc", [(string) ($date_start), (string) ($date_end)]);
			}		
		elseif ($nama_lengkap =='Ragel Suma Wijaya')
			{
			$query_billing = q_set($__p_query_billing, "SELECT t.cabang, date_format(t.enroll_date,'%d/%m/%y'), t.kd_biodata, t.nama, a.grade, a.school, t.program, t.major, t.h_nh, t.p_np,final_status, last_remark, last_update, t.ori_school, t.ori_grade, a.country, t.pic, mkt_source, mkt_source_dtl, nm_event, adm_pic,enroll_date, kd_biodata,t.kd_school, t.status,t.no,t.pv_estimated, t.pv_fix FROM tb_sales_report t left join tb_master_partner a on t.kd_school = a.kd_school where t.enroll_date between ? and ? and  (t.kd_cabang  = 1 or t.kd_cabang  = 3 )  order by enroll_date desc", [(string) ($date_start), (string) ($date_end)]);
			}
		elseif ($nama_lengkap =='Esther')
			{
			$query_billing = q_set($__p_query_billing, "SELECT t.cabang, date_format(t.enroll_date,'%d/%m/%y'), t.kd_biodata, t.nama, a.grade, a.school, t.program, t.major, t.h_nh, t.p_np,final_status, last_remark, last_update, t.ori_school, t.ori_grade, a.country, t.pic, mkt_source, mkt_source_dtl, nm_event, adm_pic,enroll_date, kd_biodata,t.kd_school, t.status,t.no,t.pv_estimated, t.pv_fix FROM tb_sales_report t left join tb_master_partner a on t.kd_school = a.kd_school where t.enroll_date between ? and ? and  (t.kd_cabang  = 4 or t.kd_cabang  = 6 or t.kd_cabang  = 11 or t.kd_cabang  = 12 )  order by enroll_date desc", [(string) ($date_start), (string) ($date_end)]);
			}	
		else
			{
			$query_billing = q_set($__p_query_billing, "SELECT t.cabang, date_format(t.enroll_date,'%d/%m/%y'), t.kd_biodata, t.nama, a.grade, a.school, t.program, t.major, t.h_nh, t.p_np,final_status, last_remark, last_update, t.ori_school, t.ori_grade, a.country, t.pic, mkt_source, mkt_source_dtl, nm_event, adm_pic,enroll_date, kd_biodata,t.kd_school, t.status,t.no,t.pv_estimated, t.pv_fix FROM tb_sales_report t left join tb_master_partner a on t.kd_school = a.kd_school where t.enroll_date between ? and ? and  t.kd_cabang  = ?   order by enroll_date desc", [(string) ($date_start), (string) ($date_end), (string) ($kd_center)]);
			}		
		}	
	}
					  $no_urut = 1;
	$result=db_query_or_die("Wah error nih5", $query_billing, $__p_query_billing ?? []);
					if ($result) 
						{ 
						while ($r = db_fetch($result))
							{
							$tgl_enroll = $r[21];
							$kode_biodata = $r[2];
							$country = $r[15];	
							$school = $r[5];
							$query_cek_bayar = q_set($__p_query_cek_bayar, "SELECT rp_mount, st_refund, tgl_cetak, id_prof_bill FROM ves_inc.tb_prof_bill  where id_stu =  ? and tgl_cetak between ? and ? order by no desc limit 1", [(string) ($kode_biodata), (string) ($date_start), (string) ($date_end)]);
							
							$result_cek_bayar=db_query_or_die("Wah error nih4", $query_cek_bayar, $__p_query_cek_bayar ?? []);	
							$jumlah_bayar = db_num_rows($result_cek_bayar);								
							if (num($jumlah_bayar) > 0 ) 
								{ 
								while ($r_bayar = db_fetch($result_cek_bayar))
									{
									$mount = $r_bayar[0];
									
									$st_refund = $r_bayar[1];
									$tgl_cetak = $r_bayar[2];
									$id_prof_bill = $r_bayar[3];
									$_POST['mount'.$a]= $mount;
									$_POST['st_refund'.$a]= $st_refund;
									$_POST['id_prof_bill'.$a]= $id_prof_bill;
									$_POST['tgl_cetak'.$a]= $tgl_cetak;									
									}
								}
							if ($country == 'AUSTRALIA' or $country == 'CHINA' or $country == 'Hongkong' or $country == 'INDONESIA' or $country == 'JAPAN' or $country == 'MALAYSIA' 
							or $country == 'SINGAPORE' or $country == 'SOUTH KOREA' or $country == 'TAIWAN' ) {$list = 'Eastern';$besaran = '100000';$asal_negara = 1;}
							elseif ($country == 'BELARUSIA' or $country == 'CANADA'or $country == ''or $country == 'France'or $country == 'GERMANY'or $country == 'Holland'or $country == '' or $country == ''or $country == 'IRELAND'or $country == 'ITALY' or $country == 'NETHERLAND'or $country == 'NEW ZEALAND' or $country == 'RUSIA'or $country == 'SPAIN'or $country == 'SWISS'or $country == 'UK'or $country == 'USA') {$list = 'Western';$besaran = '180000';$asal_negara = 2;}
							else {$list = 'Unknown';$besaran = '0';}
							$besaran = num($mount)/5;
							$warnafont=0;
							$bg ="";
							if (num($asal_negara) == 1 and num($mount) != 500000){$bg =" class='p-3 mb-2 bg-danger text-white' " ;}
							if (num($asal_negara) == 2 and num($mount) != 900000){$bg =" class='p-3 mb-2 bg-danger text-white' " ;}
							
							
							$final_status = $r[10];	
							$no_sales =$r[25];
							$_POST['no_sales'.$a]= $no_sales;
							$_POST['besaran'.$a]= $besaran;
							$_POST['tgl_enroll'.$a]= $tgl_enroll;
	
							$query_cek_incentive = q_set($__p_query_cek_incentive, "SELECT st_reward,nominal,no FROM vos_incentive  where kd_sales_report =  ? ", [(string) ($no_sales)]);
							$result_cek_incentive=db_query_or_die("Wah error nih5", $query_cek_incentive, $__p_query_cek_incentive ?? []);	
							$jumlah_data = db_num_rows($result_cek_incentive);								
							if (num($jumlah_data) > 0 ) 
								{ 
								while ($r_check = db_fetch($result_cek_incentive))
									{
									$no_incentive = $r_check[2];
									$status_reward  = $r_check[0];
									$nominal_reward  = $r_check[1];
									$besaran = $nominal_reward;
									if (num($status_reward) ==1){$status ='Proposed';}
									elseif (num($status_reward) ==2){$status ='Approved';}
									elseif (num($status_reward) ==3){$status ='Acknowledge';}
									elseif (num($status_reward) ==4){$status ='Accounting Check';}
									elseif (num($status_reward) ==5){$status ='Tax Check';}
									elseif (num($status_reward) ==6){$status ='To be Paid';}		
									elseif (num($status_reward) ==7){$status ='Paid';}											
									}
								
								}
							else
								{
								$status_reward  = 0;
								}

							$pv_estimated =$r[26];
							$pv_fix =$r[27];
							$query_get_last = q_set($__p_query_get_last, "SELECT update_date FROM adm_stu_progress where enroll_date = ? and kd_biodata = ? order by update_date desc limit 1", [(string) ($tgl_enroll), (string) ($kode_biodata)]);	
							$result_get_last=db_query_or_die("Wah error nih5", $query_get_last, $__p_query_get_last ?? []);	
							$jumlah_data = db_num_rows($result_get_last);								
							if (num($jumlah_data) > 0 ) 
								{ 
								while ($r_get_last = db_fetch($result_get_last))
									{
							 		$update_terakhir = 	$r_get_last[0];
									$query_get_admission = q_set($__p_query_get_admission, "SELECT dest_school, dest_program, dest_country, h_nh, p_np, bintang, final_status, remark, step, date_format(update_date,'%d/%m/%y') FROM adm_stu_progress where enroll_date = ? and kd_biodata = ? and update_date = ? order by no desc limit 1", [(string) ($tgl_enroll), (string) ($kode_biodata), (string) ($update_terakhir)]);

									$result_get_admission=db_query_or_die("Wah error nih5", $query_get_admission, $__p_query_get_admission ?? []);	
										if ($result_get_admission) 
											{ 
											while ($r_get_admission = db_fetch($result_get_admission))
												{
												$step = "Unknown Step";	
												$r[5] = $r_get_admission[0];
												$r[6] = $r_get_admission[1];
												$r[15] = $r_get_admission[2];
												$r[8] = $r_get_admission[3];

												$r[9] = $r_get_admission[4];
												$r[4] = $r_get_admission[6];
												$r[10] = $r_get_admission[6];
												$r[11] = $r_get_admission[7];
												$step = $r_get_admission[8];											
												$r[12] = $r_get_data[9];	
												}
											}
										}
									}
					
							if ($step==''){$step = "Unknown Step";}
							if (num($status_reward) >= 1 ){ $ada = 1;?>		  
	        <tbody>
                <tr>

                  <td  <?php echo e($bg) ?>><?php echo e($no_urut) ; ?></td>
                  <td <?php echo e($bg) ?>><?php echo e($r[1]) ; ?>
                  <input type="hidden" name="no_incentive_<?php echo e($a) ?>" id="no_incentive" value="<?php echo e($no_incentive) ?>"></td>
                  <td <?php echo e($bg) ?>><?php echo e($r[3]) ; ?><br>
                  <?php echo e($r[16]) ; ?></td>
                  <td <?php echo e($bg) ?>><?php echo e($r[5]) ; ?> - <?php echo e($r[6]) ; ?> - <?php echo e($r[7]) ; ?>   (<?php echo e($r[15]) ; ?>)<br>
                    <?php echo e($pv_estimated) ; ?> <br>
                    <a href="pv_upd.php?no_sales=<?php echo e(u($r[25])); ?>&src=1" target="popup" onclick="window.open('pv_upd.php?no_sales=<?php echo e(u($r[25])); ?>&src=1','popup','width=600,height=800'); return false;">
                  <div class="icon"><img src="imgs/edit.png" height="15" width="15"></i>PV</div></a></td>
                  <td <?php echo e($bg) ?>><?php echo e($step) ; ?><br>
<a href="#" target="popup" onclick="window.open('doc_view_img.php?nos=<?php echo e(u($no_sales)) ?>&spv=1','popup','width=600,height=800'); return false;">
                  <div class="icon"><img src="imgs/edit.png" height="15" width="15"></i>View Document</div></a></td>
                  <td <?php echo e($bg) ?>><?php echo e($mount) ; ?><br>
                  <?php echo e($st_refund) ; ?></td>
                  <td <?php echo e($bg) ?>>
                  	<?php echo  number_format(num(($besaran)),0,".",".")  ?>			
                  </td>
                  <td <?php echo e($bg) ?>><span class="icon">
                    <?php  echo e($status) ?>
                  <input type="hidden" name="incentive_status_<?php echo e($a) ?>" id="incentive_status" value="<?php echo e($status_reward) ?>">
                  </span></td>
                  <td <?php echo e($bg) ?>><div class="icon"><span class="style24">
                    <?php  if ( num($status_reward)==1 and $nama_lengkap !='jimmy' ){ $blmdiaprove = 1;?><input type="checkbox" name = 'app_<?php echo e($a) ?>' class="flat-red" <?php echo e($st_app) ?>>   Approved <?php } else if ( num($status_reward)==2 and ($nama_lengkap =='jimmy'  or $nama_lengkap =='kimberly') ){ $blmdiaprove = 1;?><input type="checkbox" name = 'app_<?php echo e($a) ?>' class="flat-red" <?php echo e($st_app) ?>>   Acknowledge <?php } ?>
            </div>
                  </td>
                  </tr>
             <?php $no_urut = num($no_urut) +1;$status_tampil='';							$bg ="";								$st_reward =0; $status='';$a = num($a)+1;} }?>
				<?php if ($nama_lengkap =='jimmy'  or $nama_lengkap =='kimberly'){?>
<tr>
	            <td align=center class="style24">&nbsp;</td>
	            <td align=center class="style24">&nbsp;</td>
	            <td align=center class="style24">&nbsp;</td>
	            <td height="14" align=center class="style24">&nbsp;</td>
	            <td align=center class="style24">&nbsp;</td>
	            <td align=center class="style24">&nbsp;</td>
	            <td align=center class="style24">&nbsp;</td>
	            <td align=center class="style24">&nbsp;</td>
	            <td align=center class="style24">&nbsp;</td>
	            <td align=center class="style24">&nbsp;</td>
	            <td align=center bgcolor="#A4BAF7" class="style24"><strong>				<a href="#" 
target="popup" 
onclick="window.open('os_inc_proses_all.php?noinc=all&kdcbg=<?php echo e(u($kd_center)) ?>&dt=<?php echo e(u($date_start)) ?>&de=<?php echo e(u($date_end)) ?>&nmsc=<?php echo e(u($nm_sc)) ?>','popup','width=1000,height=800'); return false;">
				Acknowledge All</a></strong></td>
              </tr>				<?php } } ?>
				    </tbody>
            <tfoot>
            </tfoot>
          </table>
        </div>
            <!-- /.box-body -->
      </div>

<br>
<?php if ($ada !='' and num($blmdiaprove)==1){?> <input type="Submit" name="Simpan" value="Simpan" class="btn btn-primary" /><?php } ?>
  
<!-- /.box -->
  </div>
        <!-- /.col -->
  </div>
      <!-- /.row --><!-- /.content -->
<?php	  
if (isset($_POST['Simpan'])) 
{


$hari=date("d");
$bulan=date("m");
$tahun=date("Y");
$thn=date("y");	
$hari_ini = "$tahun-$bulan-$hari";
	$batas = $a;
	for($a=0;$a<=$batas;$a++) 
		{
		
		$app = $_POST['app_'.$a];
		$no_incentive = $_POST['no_incentive_'.$a];

		if( empty($_POST['app_'.$a]) ){$app = 0;}else{$app = 1;}	
		if (num($app)==1)
			{

$tgl_enroll = $_POST['tgl_enroll'.$a];		
$incentive_status = $_POST['incentive_status_'.$a];				
			
	if(num($incentive_status) ==1){$incentive_status =2;}
	elseif(num($incentive_status) ==2){$incentive_status =3;}		
	$query = q_set($__p_query, "update vos_incentive set  st_reward = ? ,approved_by = ? , approved_date = ? where no = ? ", [(string) ($incentive_status), (string) ($nama_lengkap), (string) ($hari_ini) . " ", (string) ($no_incentive)]);

			$resource_data_sales = db_query_soft($query, $__p_query ?? []);

			}
		}	

				echo "<script type=\"text/javascript\">\n";
				echo "window.location = ('vos_inc_list_claim.php?date_start=" . e(u($date_end)) . "&date_end=" . e(u($date_end)) . "');\n";
				echo "</script>";
}
?>			  
	</form> 
		
<!-- /.content-wrapper --><!-- Control Sidebar -->

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

