<?php
require_once __DIR__ . "/../_lib/bootstrap.php"; csrf_guard_get(); auth_require_login(); 
include __DIR__ . "/../conndb.php";
include __DIR__ . "/../profiledata.php";
 include __DIR__ . "/../atas.php";
include __DIR__ . "/left.php";	 
$hari=date("d");
$bulan=date("m");
$tahun=date("Y");
$hari_ini = "$tahun-$bulan-$hari";
$date_start = in_val('date_start', 'get');
$date_end = in_val('date_end', 'get');
if ($date_start ==''){$date_start = "2024-07-01";}
if ($date_end ==''){$date_end = $hari_ini;}
$nm_center = in_val('nm_center', 'get');
$nm_sc = in_val('nm_sc', 'get');
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
elseif($nm_center == 'Medan'){$kd_center = 14;}
if (num($kd_center) != 111)
	{
	$query_nm_sc = q_set($__p_query_nm_sc, "select nama_detail from ves_data.tb_user where (posisi = 'SC' or posisi = 'AC' or posisi = 'CM' or posisi = 'admission') and aktif = 'Y' and kd_branch = ?   group by nama_detail order by nama_detail", [(string) ($kd_center)]);
	}
else
	{
	$query_nm_sc = q_set($__p_query_nm_sc, "select nama_detail from ves_data.tb_user where (posisi = 'SC' or posisi = 'AC' or posisi = 'CM' or posisi = 'admission') and aktif = 'Y'  group by nama_detail order by nama_detail");	
	}
$url_asli="http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
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
<?php //========================== left nav ?>

 <?php //====================== ?>
  <!-- Content Wrapper. Contains page content -->

  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
	  	       <form name="form1" method="GET" action="#">
  <section class="content-header">
    <h1>VOS Incentive List<br>
    </h1>
    <div class="col-md-3">
      <div class="form-group">
        <label>Center</label>
        <select class="form-control" name="nm_center"  onChange="this.form.submit()">
			
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
      <input type="date" format="dd/MM/yyyy" name="date_start" id="date_start" value="<?php echo e($date_start)  ?>" onChange="this.form.submit()">
        </small>to <small>
        <input type="date" name="date_end" id="date_end" value="<?php echo e($date_end)  ?>" onChange="this.form.submit()" >
      </small></div>		
    </div>
  </section>
				   </form> 
	  	       <form name="form1" method="POST" action="#"><?php echo csrf_field(); ?>

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
		</div>				
	  </div>
	  <div class="col-md-12">
	    <div class="form-group">
	      	      <table width="100%" class="table table-bordered table-striped" id="example1">
	        <thead>
	          <tr>
	            <th align="center">No</th>
	            <th>Enroll Date</th>
	            <th>Student Name</th>
	            <th>Institution - PV</th>
	            <th>Admission Step</th>
	            <th>Professional Fee</th>
	            <th>Estimated <br>
	              Incentive</th>
	            <th>Incentive Status</th>
	            <td width="7%" align=center >Check</td>
	            <td width="6%" align=center >Tax</td>
	            <td width="12%" align=center >Net Incentive</td>
<?php if ($nama_lengkap == 'Diana Irna Yuliani'){?>				  
	            <td width="4%" align=center >Paid</td>
<?php } elseif ($nama_lengkap == 'lanni susanti' or $nama_lengkap == 'Kurnia'){?>				  
	            <td width="4%" align=center >To be Paid</td>
<?php } ?>				  
              </tr>
            </thead>
<?php

if ($nm_center == 'All' and $nm_sc =='All')
{

			$query_billing = q_set($__p_query_billing, "\r
SELECT t.cabang, date_format(t.enroll_date,'%d/%m/%y'), t.kd_biodata, t.nama, a.grade, a.school, t.program, t.major, t.h_nh,\r
t.p_np,final_status, last_remark, last_update, t.ori_school, t.ori_grade, a.country, t.pic, mkt_source,\r
mkt_source_dtl, nm_event, adm_pic,t.enroll_date, t.kd_biodata,t.kd_school, t.status,t.no,t.pv_estimated, t.pv_fix,v.no,v.tax_persen,v.nominal FROM vos_incentive v\r
left join tb_sales_report t on  v.kd_sales_report = t.no\r
left join tb_master_partner a on t.kd_school = a.kd_school\r
where t.enroll_date between ? and ?   and st_reward >= 3 order by t.enroll_date desc", [(string) ($date_start), (string) ($date_end)]);	
}
elseif ($nm_center != 'All' and $nm_sc =='All')
	{

	$query_billing = q_set($__p_query_billing, "SELECT t.cabang, date_format(t.enroll_date,'%d/%m/%y'), t.kd_biodata, t.nama, a.grade, a.school, t.program, t.major, t.h_nh,\r
t.p_np,final_status, last_remark, last_update, t.ori_school, t.ori_grade, a.country, t.pic, mkt_source,\r
mkt_source_dtl, nm_event, adm_pic,t.enroll_date, t.kd_biodata,t.kd_school, t.status,t.no,t.pv_estimated, t.pv_fix,v.no,v.tax_persen,v.nominal FROM vos_incentive v\r
left join tb_sales_report t on  v.kd_sales_report = t.no\r
left join tb_master_partner a on t.kd_school = a.kd_school\r
where t.enroll_date between ? and ? and t.kd_cabang= ? and st_reward >= 3 order by t.enroll_date desc", [(string) ($date_start), (string) ($date_end), (string) ($kd_center)]);	

	}
elseif ($nm_center == 'All' and $nm_sc !='All')
	{

	$query_billing = q_set($__p_query_billing, "SELECT t.cabang, date_format(t.enroll_date,'%d/%m/%y'), t.kd_biodata, t.nama, a.grade, a.school, t.program, t.major, t.h_nh,\r
t.p_np,final_status, last_remark, last_update, t.ori_school, t.ori_grade, a.country, t.pic, mkt_source,\r
mkt_source_dtl, nm_event, adm_pic,t.enroll_date, t.kd_biodata,t.kd_school, t.status,t.no,t.pv_estimated, t.pv_fix,v.no,v.tax_persen,v.nominal FROM vos_incentive v\r
left join tb_sales_report t on  v.kd_sales_report = t.no\r
left join tb_master_partner a on t.kd_school = a.kd_school\r
where t.enroll_date between ? and ? and v.nama_sc= ? and st_reward >= 3 order by t.enroll_date desc", [(string) ($date_start), (string) ($date_end), (string) ($nm_sc)]);	

	}
elseif ($nm_center != 'All' and $nm_sc !='All')
	{

	$query_billing = q_set($__p_query_billing, "SELECT t.cabang, date_format(t.enroll_date,'%d/%m/%y'), t.kd_biodata, t.nama, a.grade, a.school, t.program, t.major, t.h_nh,\r
t.p_np,final_status, last_remark, last_update, t.ori_school, t.ori_grade, a.country, t.pic, mkt_source,\r
mkt_source_dtl, nm_event, adm_pic,t.enroll_date, t.kd_biodata,t.kd_school, t.status,t.no,t.pv_estimated, t.pv_fix,v.no,v.tax_persen,v.nominal FROM vos_incentive v\r
left join tb_sales_report t on  v.kd_sales_report = t.no\r
left join tb_master_partner a on t.kd_school = a.kd_school\r
where t.enroll_date between ? and ? and t.kd_cabang= ? and v.nama_sc= ? and st_reward >= 3 order by t.enroll_date desc", [(string) ($date_start), (string) ($date_end), (string) ($kd_center), (string) ($nm_sc)]);	

	}					 
				  $no_urut = 1;
	$result=db_query_or_die("Wah error nih25", $query_billing, $__p_query_billing ?? []);
					if ($result) 
						{ 
						while ($r = db_fetch($result))
							{
							$tgl_enroll = $r[21];
							$besar_persen = $r[29];
						
							$kode_biodata = $r[2];
							$country = $r[15];	
							$school = $r[5];
							//$net_besar_reward = $r[30]-($r[30]*($besar_persen/100));
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
							elseif ($country == 'BELARUSIA' or $country == 'CANADA'or $country == ''or $country == 'France'or $country == 'GERMANY'or $country == 'Holland'or $country == '' or $country == ''or $country == 'IRELAND'or $country == 'ITALY' or $country == 'NETHERLAND'or $country == 'NEW ZEALAND' or $country == 'RUSIA'or $country == 'SPAIN'or $country == 'SWISS'or $country == 'UK'or $country == 'USA' or $country == 'SWEDEN') {$list = 'Western';$besaran = '180000';$asal_negara = 2;}
							else {$list = 'Unknown';$besaran = '0';}
							$besaran = num($mount)/5;
							if (num($asal_negara) == 1 and num($mount) != 500000){$besaran = num($mount)/5; $bg =" class='p-3 mb-2 bg-danger text-white' " ;}
							elseif (num($asal_negara) == 2 and num($mount) > 900000){$besaran = 900000/5;$bg =" class='p-3 mb-2 bg-danger text-white' " ;}
							elseif (num($asal_negara) == 2 and num($mount) < 900000){$besaran = num($mount)/5;$bg =" class='p-3 mb-2 bg-danger text-white' " ;}
							
							$final_status = $r[10];	
							$no_sales =$r[25];
							$_POST['no_sales'.$a]= $no_sales;
							$_POST['besaran'.$a]= $besaran;
							$_POST['tgl_enroll'.$a]= $tgl_enroll;
	
							$query_cek_incentive = q_set($__p_query_cek_incentive, "SELECT st_reward,nominal,no FROM vos_incentive  where kd_sales_report =  ? ", [(string) ($no_sales)]);
							$result_cek_incentive=db_query_or_die("Wah error nih35", $query_cek_incentive, $__p_query_cek_incentive ?? []);	
							$jumlah_data = db_num_rows($result_cek_incentive);								
							if (num($jumlah_data) > 0 ) 
								{ 
								while ($r_check = db_fetch($result_cek_incentive))
									{
									$no_incentive = $r_check[2];
									$status_reward  = $r_check[0];
									$nominal_reward  = $r_check[1];									
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
							$result_get_last=db_query_or_die("Wah error nih45", $query_get_last, $__p_query_get_last ?? []);	
							$jumlah_data = db_num_rows($result_get_last);								
							if (num($jumlah_data) > 0 ) 
								{ 
								while ($r_get_last = db_fetch($result_get_last))
									{
							 		$update_terakhir = 	$r_get_last[0];
									$query_get_admission = q_set($__p_query_get_admission, "SELECT dest_school, dest_program, dest_country, h_nh, p_np, bintang, final_status, remark, step, date_format(update_date,'%d/%m/%y') FROM adm_stu_progress where enroll_date = ? and kd_biodata = ? and update_date = ? order by no desc limit 1", [(string) ($tgl_enroll), (string) ($kode_biodata), (string) ($update_terakhir)]);

									$result_get_admission=db_query_or_die("Wah error nih8", $query_get_admission, $__p_query_get_admission ?? []);	
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
	            <td <?php echo e($bg) ?>><?php echo e($no_urut) ; ?></td>
                <td <?php echo e($bg) ?>><?php echo e($r[1]) ; ?>
                  <input type="hidden" name="no_incentive_<?php echo e($a) ?>" id="no_incentive" value="<?php echo e($no_incentive) ?>">
                  </td>
                  <td <?php echo e($bg) ?>><?php echo e($r[3]) ; ?><br>
                  <?php echo e($r[16]) ; ?></td>
                  <td <?php echo e($bg) ?>><?php echo e($r[5]) ; ?> - <?php echo e($r[6]) ; ?> - <?php echo e($r[7]) ; ?>   (<?php echo e($r[15]) ; ?>)<br>
                    <?php echo e($pv_estimated) ; ?> <br>
</td>
                  <td <?php echo e($bg) ?>><?php echo e($step) ; ?><br>
<a href="#" target="popup" onclick="window.open('../doc_view_img.php?nos=<?php echo e(u($no_sales)) ?>&spv=1','popup','width=600,height=800'); return false;">
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
	            <td <?php echo e($bg) ?> align=center class="style24"><?php if (($nama_lengkap == 'dewi tan' or $nama_lengkap == 'Kurnia') and num($status_reward) ==3){	?>
                  <input type="checkbox" name = 'check_<?php echo e($a) ?>' class="flat-red" <?php echo e($st_checked) ?>>
                  </input>
                  </a>
                <?php } else { echo e($row_billing[13]) ;} ?></td>
	            <td <?php echo e($bg) ?> align=center class="style24"><?php if ($nama_lengkap == 'Kurnia' and num($status_reward) ==4){	?>				
<a href="#" 
target="popup" 
onclick="window.open('vos_incentive_tax.php?noinc=<?php echo e(u($no_incentive)) ?>&jns=0','popup','width=1000,height=800'); return false;"><span class="label label-success"><span class="label label-success">Tax</span></a>	
<?php } ?></td>
	            <td <?php echo e($bg) ?> align=center class="style24"><?php echo e($besar_persen) ?> <br>	              <?php echo  number_format(num($net_besar_reward),0,".",".") ?></td>
	            <td  <?php echo e($bg) ?>align=center class="style24"><?php if (($nama_lengkap == 'lanni susanti' or $nama_lengkap == 'Kurnia')  and num($status_reward) == 5){	?>
                  <input type="checkbox" name = 'paid_<?php echo e($a) ?>' class="flat-red" <?php echo e($paid_checked) ?>>
                  </input>
                  </a>
                <?php } if ($nama_lengkap == 'Diana Irna Yuliani' and num($status_reward) == 6){	?>
                  <input type="checkbox" name = 'paid_<?php echo e($a) ?>' class="flat-red" <?php echo e($paid_checked) ?>>
                  </input>
                  </a>
                <?php } ?></td>
              </tr>
             <?php $no_urut = num($no_urut) +1;$status_tampil='';								$st_reward =0; $status='';$a = num($a)+1;} }}?>

<tr>
	            <td align=center class="style24">&nbsp;</td>
	            <td align=center class="style24">&nbsp;</td>
	            <td height="14" align=center class="style24">&nbsp;</td>
	            <td align=center class="style24">&nbsp;</td>
	            <td align=center class="style24">&nbsp;</td>
	            <td align=center class="style24">&nbsp;</td>
	            <td align=center class="style24">&nbsp;</td>
	            <td align=center class="style24">&nbsp;</td>
	            <td align=center bgcolor="#A4BAF7" class="style24"><?php if ($nama_lengkap == 'dewi tan' or $nama_lengkap == 'Kurnia') { ?>
	              <input type="Submit" name="Submit" value="Submit" class="btn btn-primary" />
                <?php } ?></td>
	            <td align=center bgcolor="#A4BAF7" class="style24">&nbsp;</td>
	            <td align=center bgcolor="#A4BAF7" class="style24">&nbsp;</td>
	            <td align=center bgcolor="#A4BAF7" class="style24"><?php if ($nama_lengkap == 'lanni susanti' or $nama_lengkap == 'Kurnia') { ?>
                  <input type="Submit" name="Paid" value="To Paid" class="btn btn-success" />
                <?php } elseif ($nama_lengkap == 'Diana Irna Yuliani') { ?>
                  <input type="Submit" name="Paid" value="Paid" class="btn btn-success" />
                <?php } ?></td>
              </tr>				
				    </tbody>
            <tfoot>
            </tfoot>
          </table>
        </div>
            <!-- /.box-body -->
      </div>
    <br>
    <div class="col-md-1">
      <div class="pad box-pane-right bg-purple-gradient">
    <div class="form-group">
		<a href="vos_incentive_form_sc.php?nmsc=<?php echo e(u($nm_sc)) ?>&da=<?php echo e(u($date_start)) ?>&de=<?php echo e(u($date_end)) ?>" target="_blank"><label>Print Form</label></a>
    </div>
  </div>
</div>				   
  
<!-- /.box -->
  </div>
        <!-- /.col -->
  </div>
      <!-- /.row --><!-- /.content -->
<?php	  
if (isset($_POST['Submit'])) 
{
		$url_asli="http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];

$hari=date("d");
$bulan=date("m");
$tahun=date("Y");
$thn=date("y");	
$hari_ini = "$tahun-$bulan-$hari";
	$batas = $a;

	for($a=0;$a<=$batas;$a++) 
		{
		
		$app = $_POST['check_'.$a];
		$no_incentive = $_POST['no_incentive_'.$a];

		if( empty($_POST['check_'.$a]) ){$app = 0;}else{$app = 1;}	
		if (num($app)==1)
			{

			$incentive_status = $_POST['incentive_status_'.$a];				
	
	if(num($incentive_status) ==3)
		{
		$incentive_status =4;
		$query = q_set($__p_query, "update vos_incentive set  st_reward = ? ,check_by = ? , check_date = ? where no = ? ", [(string) ($incentive_status), (string) ($nama_lengkap), (string) ($hari_ini) . " ", (string) ($no_incentive)]);	
		}
	elseif(num($incentive_status) ==4)
		{
		$incentive_status =5;
		$query = q_set($__p_query, "update vos_incentive set  st_reward = ? ,tax_by = ? , tax_date = ? where no = ? ", [(string) ($incentive_status), (string) ($nama_lengkap), (string) ($hari_ini) . " ", (string) ($no_incentive)]);	
		}
	elseif(num($incentive_status) ==5)
		{
		$incentive_status =6;
		$query = q_set($__p_query, "update vos_incentive set  st_reward = ? ,paid_by = ? , paid_date = ? where no = ? ", [(string) ($incentive_status), (string) ($nama_lengkap), (string) ($hari_ini) . " ", (string) ($no_incentive)]);	
		}		


			$resource_data_sales = db_query_soft($query, $__p_query ?? []);

			}
		}	

				echo "<script type=\"text/javascript\">\n";
				echo "window.location = ('" . e($url_asli) . "');\n";
				echo "</script>";
}
?>	
<?php	  
if (isset($_POST['Paid'])) 
{
		$url_asli="http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];

$hari=date("d");
$bulan=date("m");
$tahun=date("Y");
$hari_ini = "$tahun-$bulan-$hari";
	$batas = $a;
	for($a=0;$a<=$batas;$a++) 
		{
		$paid = $_POST['paid_'.$a];
		$no_incentive = $_POST['no_incentive_'.$a];
		if( empty($_POST['paid_'.$a]) ){$check_paid = 0;}else{$check_paid = 1;}	
		if (num($check_paid)==1)
			{
				$incentive_status = $_POST['incentive_status_'.$a];	
			if(num($incentive_status) ==5)
				{

				$query = q_set($__p_query, "update vos_incentive set  st_reward = '6',to_paid_by = ? , to_paid_date = ? where no = ? ", [(string) ($nama_lengkap), (string) ($hari_ini) . " ", (string) ($no_incentive)]);
				$resource_check= db_query_or_die('errro_visitor1', $query, $__p_query ?? []);
				}
			elseif(num($incentive_status) ==6)
				{


				$query = q_set($__p_query, "update vos_incentive set  st_reward = '7',paid_by = ? , paid_date = ? where no = ? ", [(string) ($nama_lengkap), (string) ($hari_ini) . " ", (string) ($no_incentive)]);
				$resource_check= db_query_or_die('errro_visitor1', $query, $__p_query ?? []);
				}			

			}
		}
				echo "<script type=\"text/javascript\">\n";
				echo "window.location = ('" . e($url_asli) . "');\n";
				echo "</script>";
}
?>		
	</form> 
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

