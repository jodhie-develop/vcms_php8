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
$date_start = in_val('date_start', 'post');
$date_end = in_val('date_end', 'post');
$_POST['date_start'] = $date_start;
$_POST['date_end'] = $date_end;
//if ($date_start ==''){$date_start = "$tahun-$bulan-01";}
//if ($date_end ==''){$date_end = $hari_ini;}
if ($date_start ==''){$date_start = in_val('date_start', 'get');}
if ($date_end ==''){$date_end = in_val('date_end', 'get');}


$kd_cbg = in_val('kd_cbg', 'post');

if ($kd_cbg == '--ALL--'){$kd_cbg = 0;}
if ($kd_cbg == 'East Sby'){$kd_cbg = 1;}
if ($kd_cbg == 'West Sby'){$kd_cbg = 2;}
if ($kd_cbg == 'Denpasar'){$kd_cbg = 3;}
if ($kd_cbg == 'South Jkt'){$kd_cbg = 4;}
if ($kd_cbg == 'North Jkt'){$kd_cbg = 5;}
if ($kd_cbg == 'West Jkt'){$kd_cbg = 6;}
if ($kd_cbg == 'Bandung'){$kd_cbg = 7;}
if ($kd_cbg == 'Malang TBI'){$kd_cbg = 8;}
if ($kd_cbg == 'Bandung TBI'){$kd_cbg = 9;}
if ($kd_cbg == 'Bali TBI'){$kd_cbg = 10;}

if (num($kd_cbg) ==0){$cabang = '--ALL--';}
if ($kd_cbg ==''){$cabang = '--ALL--';}

if (num($kd_cbg) ==1){$cabang = 'East Sby';}
if (num($kd_cbg) ==2){$cabang = 'West Sby';}
if (num($kd_cbg) ==3){$cabang = 'Denpasar';}
if (num($kd_cbg) ==4){$cabang = 'South Jkt';}
if (num($kd_cbg) ==5){$cabang = 'North Jkt';}
if (num($kd_cbg) ==6){$cabang = 'West Jkt';}
if (num($kd_cbg) ==7){$cabang = 'Bandung';}
if (num($kd_cbg) ==8){$cabang = 'Malang TBI';}
if (num($kd_cbg) ==9){$cabang = 'Bandung TBI';}
if (num($kd_cbg) ==10){$cabang = 'Bali TBI';}
$nama_lengkap = $_SESSION['nama_lengkap'];
$nama_depan = $_SESSION['nama_depan'];
$kd_cbg = $_SESSION['kd_branch'];
$posisi = $_SESSION['posisi']; 
$kd_staff = $_SESSION['kd_staff'] ;
$kd_area = $_SESSION['kode_area'] ;

$a = 0;
$pilihan_sc = in_val('pilihan_sc', 'get');
if ($pilihan_sc ==''){$pilihan_sc = 'All Leads';}


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
      <h1>VOS Sales List
        <br>
      </h1>
      <table width="844" border="0">
        <tbody>
          <tr>
			  <td width="302"><small>
              <label for="date5"> Enrolled Period :</label>
              </small></td>
            <td width="532"><small>
              <label for="date2">:</label>
            <input type="date" format="dd/MM/yyyy" name="date_start" id="date2" value="<?php echo e($date_start) ; ?>" onChange="this.form.submit()">
To </small><small>
<input type="date" name="date_end" id="date2" value="<?php echo e($date_end) ; ?>" onChange="this.form.submit()" >
</small></td>
          </tr>
          <tr>
            <td><small>
            <label for="date3"> SC Name :</label>
            </small></td>
            <td><strong>:</strong><?php echo e($nama_lengkap) ?></td>
          </tr>
        </tbody>
      </table>
                 <?php
$_POST['date_start'] = $date_start;
$_POST['date_end'] = $date_end;
					$query = q_set($__p_query, "SELECT t.cabang, date_format(t.enroll_date,'%d/%m/%y'), t.kd_biodata, t.nama, a.grade, a.school, t.program, t.major, t.h_nh, t.p_np,final_status, last_remark, last_update, t.ori_school, t.ori_grade, a.country, t.pic, mkt_source, mkt_source_dtl, nm_event, adm_pic,enroll_date, kd_biodata,t.kd_school, t.status,t.no,t.pv_estimated, t.pv_fix  FROM tb_sales_report  t left join tb_master_partner a on t.kd_school = a.kd_school  where t.enroll_date between ? and ? and t.kd_cabang <> '' and t.pic = ? order by enroll_date desc", [(string) ($date_start), (string) ($date_end), (string) ($nama_lengkap)]);

				  	$_SESSION['ngueri'] = $query; $_SESSION['ngueri__p'] = $__p_query ?? [];
					$no_urut = 1;
					$result=db_query_or_die("Wah error nih5", $query, $__p_query ?? []);
				  	$num_rows = db_num_rows($result);?>      
      <table width="200" border="0">
                   <tbody>
                     <tr>
                       <td><br>
Result : <?php echo e($num_rows) ?></td>
                       <td>


    </td>
                     </tr>
                     <tr>
                       <td>&nbsp;</td>
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
              <table width="90%" class="table table-bordered table-striped" id="example1" >
                <thead>
                <tr >
                  <th width="5%" align="center">No</th>
                  <th width="7%">Enroll Date</th>
                  <th width="19%">Student Name</th>
                  <th width="30%">Institution - PV</th>
                  <th width="10%">Admission Step</th>
                  <th width="9%">Professional Fee</th>
                  <th width="12%">Estimated <br>
                  Incentive</th>
                  <th width="8%">Incentive Status</th>
                  <th width="8%">Action</th>
                  </tr>
                </thead>
                <tbody>

				  <?php 
					if ($result) 
						{ 
						while ($r = db_fetch($result))
							{
							$tgl_enroll = $r[21];
							$kode_biodata = $r[2];
							$country = $r[15];	
							$school = $r[5];
							
							$query_cek_bayar = q_set($__p_query_cek_bayar, "SELECT rp_mount, st_refund, tgl_cetak, id_prof_bill FROM ves_inc.tb_prof_bill  where id_stu =  ? and dt_paid between ? and ? order by no desc limit 1", [(string) ($kode_biodata), (string) ($date_start), (string) ($date_end)]);
							
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
							$query_cek_dicount = q_set($__p_query_cek_dicount, "SELECT discount_name from ves_inc.tb_enrolled where kd_biodata = ? and enroll_date  = ? ", [(string) ($kode_biodata), (string) ($tgl_enroll)]);
							$result_cek_discount=db_query_or_die("Wah error nih4", $query_cek_dicount, $__p_query_cek_dicount ?? []);	
							$jumlah_data = db_num_rows($result_cek_discount);								
							if (num($jumlah_data) > 0 ) 
								{ 
								while ($r_discount = db_fetch($result_cek_discount))
									{
									$discount_name = $r_discount[0];

									$_POST['discount_name'.$a]= $discount_name;								
									}
								}		
							
							if ($country == 'AUSTRALIA' or $country == 'CHINA' or $country == 'Hongkong' or $country == 'INDONESIA' or $country == 'JAPAN' or $country == 'MALAYSIA' 
							or $country == 'SINGAPORE' or $country == 'SOUTH KOREA' or $country == 'TAIWAN' ) {$list = 'Eastern';$besaran = '100000';$asal_negara = 1;}
							elseif ($country == 'BELARUSIA' or $country == 'CANADA' or $country == ''or $country == 'France'or $country == 'GERMANY'or $country == 'Holland'or $country == '' or $country == ''or $country == 'IRELAND'or $country == 'ITALY' or $country == 'NETHERLAND'  or $country == 'NETHERLANDS'or $country == 'NEW ZEALAND' or $country == 'RUSIA'or $country == 'SPAIN'or $country == 'SWISS'or $country == 'UK'or $country == 'USA') {$list = 'Western';$besaran = '180000';$asal_negara = 2;}
							else {$list = 'Unknown';$besaran = '0';}
							//$besaran = $mount/5;

							$tgl_acuan = new DateTime('2024-08-11');
							$tgl_enrollan = new DateTime($tgl_enroll); 
							
							$query_cek_step = q_set($__p_query_cek_step, "SELECT step FROM adm_stu_progress where kd_biodata =  ? and enroll_date = ? order by no desc limit 1", [(string) ($kode_biodata), (string) ($tgl_enroll)]);
							$result_cek_step=db_query_or_die("Wah error nih5", $query_cek_step, $__p_query_cek_step ?? []);	
								while ($r_step = db_fetch($result_cek_step))
									{
									$st_step = $r_step[0];
									}
							
							
//							if($tgl_enrollan >= $tgl_acuan and ($st_step != '01 : Completing Application Requirements')) {$besaran = (($besaran*30)/100);}
							if($tgl_enrollan >= $tgl_acuan and num((intval(substr($st_step,0,2))))> 1) {$besaran =$besaran;}
							
							
							$warnafont=0;
							$bg ="";
							if (num($asal_negara) == 1 and num($mount) != 500000){$besaran = num($mount)/5; $bg =" class='p-3 mb-2 bg-danger text-white' " ;}
							elseif (num($asal_negara) == 2 and num($mount) > 900000){$besaran = 900000/5;$bg =" class='p-3 mb-2 bg-danger text-white' " ;}
							elseif (num($asal_negara) == 2 and num($mount) < 900000){$besaran = num($mount)/5;$bg =" class='p-3 mb-2 bg-danger text-white' " ;}
							  
							$final_status = $r[10];	
							$no_sales =$r[25];
							$_POST['no_sales'.$a]= $no_sales;
							$_POST['besaran'.$a]= $besaran;
							$_POST['tgl_enroll'.$a]= $tgl_enroll;
	
							$query_cek_incentive = q_set($__p_query_cek_incentive, "SELECT st_reward,nominal FROM vos_incentive  where kd_sales_report =  ? ", [(string) ($no_sales)]);
							$result_cek_incentive=db_query_or_die("Wah error nih5", $query_cek_incentive, $__p_query_cek_incentive ?? []);	
							$jumlah_data = db_num_rows($result_cek_incentive);								
							if (num($jumlah_data) > 0 ) 
								{ 
								while ($r_check = db_fetch($result_cek_incentive))
									{
									$status_reward  = $r_check[0];
									$nominal_reward  = $r_check[1];	
									$besaran  = $r_check[1];	
									
									if (num($status_reward) ==1){$status ='Proposed'; $ada = 1;}
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
												if ($kd_biodata == '221130175777675' and $enroll_date =='2022-11-30') {$besaran = '67500'; }
							if ($step==''){$step = "Unknown Step";}
							
							$langkah = intval(substr($st_step,0,2));
$query_file = q_set($__p_query_file, "SELECT a.no_sales, a.nama_file, a.dt_entry, a.pic FROM adm_doc a where no_sales = ? ", [(string) ($no_sales)]);

$resource_file = db_query_soft($query_file, $__p_query_file ?? []);
$ada_doc = db_num_rows($resource_file) ;
									?>                
                <tr>

                  <td <?php echo e($bg) ?>><?php echo e($no_urut) ; ?></td>
                  <td <?php echo e($bg) ?>><?php echo e($r[1]) ; ?></td>
                  <td <?php echo e($bg) ?>><?php echo e($r[3]) ; ?></td>
                  <td <?php echo e($bg) ?>><?php echo e($r[5]) ; ?> - <?php echo e($r[6]) ; ?> - <?php echo e($r[7]) ; ?>   (<?php echo e($r[15]) ; ?>)<br>
                    <?php echo e($pv_estimated) ; ?> <br>
                    <a href="pv_upd.php?no_sales=<?php echo e(u($r[25])); ?>&src=1" target="popup" onclick="window.open('pv_upd.php?no_sales=<?php echo e(u($r[25])); ?>&src=1','popup','width=600,height=800'); return false;">
                  <div class="icon"><img src="imgs/edit.png" height="15" width="15"></i>PV</div></a></td>
                  <td <?php echo e($bg) ?>><?php echo e($step) ; ?> <br>                    <?php echo e($update_terakhir) ?><br>
<a href="stuadmprogresspop.php?kdb=<?php echo e(u($kode_biodata)) ?>&st=1&asal=3" target="popup" onclick="window.open('stuadmprogresspop.php?kdb=<?php echo e(u($kode_biodata)) ?>&st=1&asal=3','popup','width=600,height=800'); return false;">
                  <div class="icon"><img src="imgs/edit.png" height="15" width="15"></i>Step Update</div></a>
			  <?php if(num($langkah)>1){ ?>
<a href="doc_upload_file.php?kdb=<?php echo e(u($kode_biodata)) ?>&er=<?php echo e(u($tgl_enroll)) ?> " target="popup" onclick="window.open('doc_upload_file.php?nos=<?php echo e(u($no_sales)) ?>','popup','width=600,height=800'); return false;">
                  <div class="icon"><img src="imgs/edit.png" height="15" width="15"></i>Document</div></a><?php } ?></td>
                  <td <?php echo e($bg) ?>><?php echo e($mount) ; ?><br>
                  <?php echo e($st_refund) ; ?><br>
                  <?php echo e($discount_name) ; ?></td>
                  <td <?php echo e($bg) ?>>
                  	<?php echo  number_format(num(($besaran)),0,".",".")  ?>			
                  </td>
                  <td <?php echo e($bg) ?>><span class="icon">
                    <?php  echo e($status) ?>
                  </span></td>
                  <td <?php echo e($bg) ?>><div class="icon"><span class="style24">
                    <?php if (num($pv_estimated) != 0 and $r[24] =='OK' and num($status_reward)==0 and num($mount) != 0 and $st_refund =='Non Refundable' and num($langkah) > 1 and num($ada_doc) > 0	){ $blm = 1;	?>
                  <input type="checkbox" name = 'check_<?php echo e($a) ?>' class="flat-red" <?php echo e($st_checked) ?>>                  </input>
					 Claim <?php } ?>
            </div>
                  </td>
                  </tr>
                <?php $no_urut = num($no_urut) + 1; $step =''; $nominal_reward ='';$a = num($a)+1; $status = '';} }?>
                </tbody>
                <tfoot>
                </tfoot>
              </table>
		 <?php if ($blm !=''){?> <input type="Submit" name="Submit" value="Submit" class="btn btn-primary" /><?php } ?>

               <label><a href="#" 
target="popup" 
onclick="window.open('vos_incentive_form_sc.php?nmsc=<?php echo e(u($nama_lengkap)) ?>&da=<?php echo e(u($date_start)) ?>&de=<?php echo e(u($date_end)) ?>','popup','width=1000,height=800'); return false;">	 
						<strong>Click Here to Print Claim Form</strong></a></label>></a>

            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
   </section>
    <!-- /.content -->
	</form> 

<?php	  
if (isset($_POST['Submit'])) 
{
		$url_asli="http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
$date_start = in_val('date_start', 'post');
$date_end = in_val('date_end', 'post');

$hari=date("d");
$bulan=date("m");
$tahun=date("Y");
$thn=date("y");	
$hari_ini = "$tahun-$bulan-$hari";
	$batas = $a;
	for($a=0;$a<=$batas;$a++) 
		{
		$check = $_POST['check_'.$a];

		

		if( empty($_POST['check_'.$a]) ){$check = 0;}else{$check = 1;}	
		if (num($check)==1)
			{

$tgl_enroll = $_POST['tgl_enroll'.$a];				
			$no_sales = $_POST['no_sales'.$a];
			$besaran = $_POST['besaran'.$a];			
			 $mount = $_POST['mount'.$a];
			$st_refund = $_POST['st_refund'.$a];
			$id_prof_bill = $_POST['id_prof_bill'.$a]; 
			$tgl_cetak	= $_POST['tgl_cetak'.$a];
$query_data_sales = q_set($__p_query_data_sales, "SELECT t.kd_cabang, t.enroll_date, t.kd_biodata, t.nama,t.kd_school FROM tb_sales_report  t where no =  ? ", [(string) ($no_sales)]);	
$resource_data_sales = db_query_soft($query_data_sales, $__p_query_data_sales ?? []);
if(num(db_num_rows($resource_data_sales)) > 0)
	{
	while ($row_data_sales  =  db_fetch($resource_data_sales, PDO::FETCH_NUM))
		{
		$kd_cabang = $row_data_sales[0];
		$enroll_date = $row_data_sales[1];
		$kd_biodata = $row_data_sales[2];
		$kd_school		 = $row_data_sales[4];

		}
	}			
	$query = q_set($__p_query, "insert into vos_incentive(kd_branch, nama_sc,kd_sales_report, kd_biodata, kd_school,st_reward, dt_entry, nominal, remark,pic,proff_bill, id_receipt, dt_payment, st_refund,enroll_date ) values (? ,? ,? ,? ,? ,'1',? ,? ,'',? ,? ,? ,? ,? ,? )", [(string) ($kd_cabang), (string) ($nama_lengkap), (string) ($no_sales), (string) ($kd_biodata), (string) ($kd_school), (string) ($hari_ini), (string) ($besaran), (string) ($nama_lengkap), (string) ($mount), (string) ($id_prof_bill), (string) ($tgl_cetak), (string) ($st_refund), (string) ($tgl_enroll)]);

	$resource_input = db_query_soft($query, $__p_query ?? []);	
	
			}
		}	

				echo "<script type=\"text/javascript\">\n";
				echo "window.location = ('vos_inc_list.php?date_start=" . e(u($date_start)) . "&date_end=" . e(u($date_end)) . "');\n";
				echo "</script>";
}
?>	
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
</div>
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
