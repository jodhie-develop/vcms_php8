<?php
require_once __DIR__ . "/_lib/bootstrap.php"; auth_require_login(); 
include __DIR__ . "/conndb.php";
include __DIR__ . "/profiledata.php";
include __DIR__ . "/atas.php";
$nama_lengkap = $_SESSION['nama_lengkap'];
$nama_depan = $_SESSION['nama_depan'];
$kd_cbg = $_SESSION['kd_branch'];
$posisi = $_SESSION['posisi']; 
$kd_staff = $_SESSION['kd_staff'] ;
$kd_area = $_SESSION['kode_area'] ;
$date_target = in_val('date_target', 'get');

$q = in_val('q', 'get');
$hari=date("d");
$bulan=date("m");
$tahun=date("Y");
$hari_ini = "$tahun-$bulan-$hari";
$date_start = in_val('date_start', 'get');
$date_end = in_val('date_end', 'get');
if ($date_start ==''){$date_start = "2018-07-01";}
if ($date_end ==''){$date_end = $hari_ini;}
//$date_start = "$tahun-$bulan-01";
$kd_cbg = in_val('kd_cbg', 'get');
if (num($kd_area) == 5){$area ="";}
elseif(num($kd_area) == 42){$area = " and (kd_branch= '4' or kd_branch= '5' or kd_branch= '6')";}
elseif(num($kd_area) == 41){$area = " and (kd_branch= '1' or kd_branch= '2' or kd_branch= '3')";}
elseif(num($kd_area) == 31){$area = " and (kd_branch= '1' or kd_branch= '2')";}
elseif(num($kd_area) == 21) {$area = " and (kd_branch= '2'or kd_branch= '8')";}
elseif(num($kd_area) == 2){$area = " and kd_branch= '$kd_cbg'";}
else {$area = " and kd_branch= '$kd_cbg'";}	
$pilihan_sc = in_val('pilihan_sc', 'get');
if ($pilihan_sc ==''){$pilihan_sc = 'My Leads';}
if ($kd_cbg == '--ALL--'){$kd_cbg = 0;}
if ($kd_cbg == 'East Sby'){$kd_cbg = 1;}
if ($kd_cbg == 'West Sby'){$kd_cbg = 2;}
if ($kd_cbg == 'Denpasar'){$kd_cbg = 3;}
if ($kd_cbg == 'South Jkt'){$kd_cbg = 4;}
if ($kd_cbg == 'North Jkt'){$kd_cbg = 5;}
if ($kd_cbg == 'West Jkt'){$kd_cbg = 6;}
if ($kd_cbg == 'Bandung'){$kd_cbg = 7;}
if ($kd_cbg == 'National'){$kd_cbg = 100;}
if ($kd_cbg == 'East Area'){$kd_cbg = 101;}
if ($kd_cbg == 'West Area'){$kd_cbg = 102;}

if (num($kd_cbg) ==0){$cabang = '--CHOOSE--';}
if ($kd_cbg ==''){$cabang = '--CHOOSE--';}
if (num($kd_cbg) ==1){$cabang = 'East Sby';}
if (num($kd_cbg) ==2){$cabang = 'West Sby';}
if (num($kd_cbg) ==3){$cabang = 'Denpasar';}
if (num($kd_cbg) ==4){$cabang = 'South Jkt';}
if (num($kd_cbg) ==5){$cabang = 'North Jkt';}
if (num($kd_cbg) ==6){$cabang = 'West Jkt';}
if (num($kd_cbg) ==7){$cabang = 'Bandung';}
if (num($kd_cbg) ==100){$cabang = 'National';}
if (num($kd_cbg) ==101){$cabang = 'East Area';}
if (num($kd_cbg) ==102){$cabang = 'West Area';}
//=================
if ($kd_cbg <> '0' and $kd_cbg <> '100' and $kd_cbg <> '101' and $kd_cbg <> '102')
{
$query_sc = q_set($__p_query_sc, "SELECT distinct nama_detail from tb_user where kd_branch = ? and (posisi = 'SC' or posisi = 'AC' or posisi= 'Admission' or posisi= 'CM') and aktif = 'Y' order by nama_detail ", [(string) ($kd_cbg)]);
}
elseif ($kd_cbg == '101')
{
$query_sc = q_set($__p_query_sc, "SELECT distinct nama_detail from tb_user where (kd_branch = '1' or kd_branch = '2' or kd_branch = '3' or kd_branch = '8') and (posisi = 'SC' or posisi = 'AC' or posisi= 'Admission' or posisi= 'CM') and aktif = 'Y' order by nama_detail ");
}
elseif ($kd_cbg == '102')
{
$query_sc = q_set($__p_query_sc, "SELECT distinct nama_detail from tb_user where (kd_branch = '4' or kd_branch = '5' or kd_branch = '6'  or kd_branch = '7') and (posisi = 'SC' or posisi = 'AC' or posisi= 'Admission' or posisi= 'CM') and aktif = 'Y' order by nama_detail ");
}
$resource_sc = db_query_or_die('errro_', $query_sc, $__p_query_sc ?? []);
$keluar_sc= db_num_rows($resource_sc);
if(num(db_num_rows($resource_sc)) > 0)
	{
	while ($row_sc=  db_fetch($resource_sc, PDO::FETCH_NUM))
		{
		$pic_list= $row_sc[0];				
		$list_sc.="<OPTION VALUE=\"" . e($pic_list) . "\">".e($pic_list);
		}
	}
//=============
//===================
$nama_lengkap = $_SESSION['nama_lengkap'];
$nama_depan = $_SESSION['nama_depan'];
$posisi = $_SESSION['posisi']; 
$kd_staff = $_SESSION['kd_staff'] ;
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
  <link rel="stylesheet" href="css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="css/ionicons.min.css">
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
 <?php   include __DIR__ . "/left.php";	 ?>
 <?php //====================== ?>
  <!-- Content Wrapper. Contains page content -->
 <form method=get action=aktifitas.php> 
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
   <section class="content-header">
     <h1>Activities Log<br>
       <table width="950" border="0">
         <tr>
           <td height="24"><small>
             <label for="date6">Center</label>
           </small></td>
           <td><small>
             <label for="date7">:</label>
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
               <option value="102">West Area</option>
               <option value="100">National</option>

               <option selected="selected"><?php echo e($cabang) ?></option>
             </select>
           </small></td>
         </tr>
         <tbody>
          <tr>
			  <td width="152"><small>
              <label for="date5"> Date Period </label>
			  </small></td>
            <td width="788"><small>
              <label for="date2">:</label>
            <input type="date" format="dd/MM/yyyy" name="date_start" id="date2" value="<?php echo e($date_start) ; ?>" onChange="this.form.submit()">
To </small><small>
<input type="date" name="date_end" id="date2" value="<?php echo e($date_end) ; ?>" onChange="this.form.submit()" >
<input type="text" name="q" id="q3" value="<?php echo e($q) ; ?>" hidden="hidden">
<input type="text" name="q2" id="q4" value="<?php echo e($search) ; ?>" hidden="hidden">
</small></td>
          </tr>
        </tbody>
      </table>
     </h1>
    </section><!-- Main content -->
    <section class="content">
      <div class="row">
       <div class="col-xs-12">
          <!-- /.box -->
                 <?php
if ($kd_cbg <> '0' and $kd_cbg <> '100' and $kd_cbg <> '101' and $kd_cbg <> '102')
{
$query_act = q_set($__p_query_act, "SELECT distinct nama_detail from tb_user where kd_branch = ? and (posisi = 'SC' or posisi = 'AC' or posisi= 'Admission' or posisi= 'CM') and aktif = 'Y' order by nama_detail ", [(string) ($kd_cbg)]);
}
elseif ($kd_cbg == '101')
{
$query_act = q_set($__p_query_act, "SELECT distinct nama_detail from tb_user where (kd_branch = '1' or kd_branch = '2' or kd_branch = '3' or kd_branch = '8') and (posisi = 'SC' or posisi = 'AC' or posisi= 'Admission' or posisi= 'CM') and aktif = 'Y' order by nama_detail ");
}
elseif ($kd_cbg == '102')
{
$query_act = q_set($__p_query_act, "SELECT distinct nama_detail from tb_user where (kd_branch = '4' or kd_branch = '5' or kd_branch = '6'  or kd_branch = '7') and (posisi = 'SC' or posisi = 'AC' or posisi= 'Admission' or posisi= 'CM') and aktif = 'Y' order by nama_detail ");
}
else
{
$query_act = q_set($__p_query_act, "SELECT distinct nama_detail from tb_user where kd_branch = ? and (posisi = 'SC' or posisi = 'AC' or posisi= 'Admission' or posisi= 'CM') and aktif = 'Y' order by nama_detail ", [(string) ($kd_cbg)]);
}

$resource_act = db_query_or_die('errro_', $query_act, $__p_query_act ?? []);
$keluar_act= db_num_rows($resource_act);
$query_leads = q_set($__p_query_leads, "SELECT count(distinct t.kd_biodata) FROM ves_inc.tb_biodata t");		   
?>            
<h4>Activities Summary</h4>
          <div class="box">
            <!-- /.box-header -->
            <div class="box-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>    
                  <th width="6%">No</th>
                  <th width="39%"> PIC</th>
                  <th width="31%">New Leads</th>
                  <th width="31%">Follow Up</th>
                  <th width="31%">VES Enroll</th>
                  <th width="31%">VIP Enroll</th>
                  <th width="31%">VIP Start Class</th>
                  </tr>
                </thead>
                <tbody>

				  <?php 
					$no_urut = 1;
					if ($resource_act) 
						{ 
						while ($r = db_fetch($resource_act))
							{
							$r_pic = $r[0];								
								
							$query_filter = q_set($__p_query_filter, " where (ves_status is null or ves_status = '') and (vip_status is null or vip_status = '') and  pic = ? and dt_entry between ? and ? ", [(string) ($r_pic), (string) ($date_start), (string) ($date_end)]);	
							$query_new = q_set($__p_query_new, $query_leads . $query_filter, [...($__p_query_leads ?? []), ...($__p_query_filter ?? [])]);
							$result_new=db_query_or_die("Wah error nih1", $query_new, $__p_query_new ?? []);
							if ($result_new) 
								{ 
								while ($r_new = db_fetch($result_new))
									{
									$r_jml_new = $r_new[0];	
									}
								}
							$query_fu_pax = q_set($__p_query_fu_pax, "SELECT count(distinct a.kd_biodata ) as pax, count(a.kd_biodata) as act FROM ves_inc.tb_progres_ves a  where a.pic = ? and date_update between ? and ? order by a.kd_biodata", [(string) ($r_pic), (string) ($date_start), (string) ($date_end)]);	

							$result_fu_pax=db_query_or_die("Wah error nih1", $query_fu_pax, $__p_query_fu_pax ?? []);
							if ($result_fu_pax) 
								{ 
								while ($r_fu_pax = db_fetch($result_fu_pax))
									{
									$r_jml_fu_pax = $r_fu_pax[0];
									$r_jml_fu_act = $r_fu_pax[1];										
									}
								}
							$query_ves_enroll = q_set($__p_query_ves_enroll, "SELECT count(distinct a.kd_biodata ) as pax FROM ves_data.tb_sales_report a  where a.pic = ? and enroll_date between ? and ? order by a.kd_biodata", [(string) ($r_pic), (string) ($date_start), (string) ($date_end)]);	

							$result_ves_enroll=db_query_or_die("Wah error nih1", $query_ves_enroll, $__p_query_ves_enroll ?? []);
							if ($result_ves_enroll) 
								{ 
								while ($r_ves_enroll = db_fetch($result_ves_enroll))
									{
									$r_ves_jml = $r_ves_enroll[0];
									}
								}									
							//$query_last_progress= "SELECT progress, status, vip_status, pic, date_update FROM ves_inc.tb_progres_ves where kd_biodata = '$r[21]' order by date_update desc limit 1";
						
							//$result_last_progress=mysql_query($query_last_progress) or die("Wah error nih455");
							//$ada_data = db_num_rows($result);
							//if ($ada_data > 0 ) 
							//	{ 
						//		while ($r_get_last = db_fetch($result_last_progress))
						//			{
						//			$r[23]= $r_get_last[0];
						//			$ves_status= $r_get_last[1];
						//			$vip_status= $r_get_last[2];										
						//			}
						//		}
				?>                
                <tr>
                  <td><?php echo e($no_urut) ; ?></td>
                  <td><?php echo e($r_pic) ; ?></td>
                  <td><?php echo e($r_jml_new) ; ?></td>
                  <td><?php echo e($r_jml_fu_pax) ; ?> pax<br>
                  <?php echo e($r_jml_fu_act) ; ?> Activities <br></td>
                  <td><?php echo e($r_ves_jml) ; ?></td>
                  <td>&nbsp;</td>
                  <td><?php echo e($r[1]) ; ?></td>
                  </tr>
                <?php $no_urut = num($no_urut) + 1; } }?>
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
      <div class="row">
       <div class="col-xs-12">
          <!-- /.box -->
                 <?php
if ($kd_cbg <> '0' and $kd_cbg <> '100' and $kd_cbg <> '101' and $kd_cbg <> '102')
{
$query_act = q_set($__p_query_act, "SELECT distinct nama_detail,no from tb_user where kd_branch = ? and (posisi = 'SC' or posisi = 'AC' or posisi= 'Admission' or posisi= 'CM') and aktif = 'Y' order by nama_detail ", [(string) ($kd_cbg)]);
}
elseif ($kd_cbg == '101')
{
$query_act = q_set($__p_query_act, "SELECT distinct nama_detail,no from tb_user where (kd_branch = '1' or kd_branch = '2' or kd_branch = '3' or kd_branch = '8') and (posisi = 'SC' or posisi = 'AC' or posisi= 'Admission' or posisi= 'CM') and aktif = 'Y' order by nama_detail ");
}
elseif ($kd_cbg == '102')
{
$query_act = q_set($__p_query_act, "SELECT distinct nama_detail,no from tb_user where (kd_branch = '4' or kd_branch = '5' or kd_branch = '6'  or kd_branch = '7') and (posisi = 'SC' or posisi = 'AC' or posisi= 'Admission' or posisi= 'CM') and aktif = 'Y' order by nama_detail ");
}
else
{
$query_act = q_set($__p_query_act, "SELECT distinct nama_detail,no from tb_user where kd_branch = ? and (posisi = 'SC' or posisi = 'AC' or posisi= 'Admission' or posisi= 'CM') and aktif = 'Y' order by nama_detail ", [(string) ($kd_cbg)]);
}

$resource_act = db_query_or_die('errro_', $query_act, $__p_query_act ?? []);
$keluar_act= db_num_rows($resource_act);		   
?>            
<h4>Enroll Potential</h4> 
Period : <small>
<input type="Month" format="dd/MM/yyyy" name="date_target" id="date" value="<?php echo e($date_target); ; ?>" onChange="this.form.submit()">
</small>
<div class="box">
            <!-- /.box-header -->
            <div class="box-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>    
                  <th width="3%">No</th>
                  <th width="23%"> PIC</th>
                  <th width="18%">VES </th>
                  <th width="18%">Leaving</th>
                  <th width="18%">VIP</th>
                  <th width="20%">Open Class</th>
                  </tr>
                </thead>
                <tbody>

				  <?php 
					$tgl_target_start = "$date_target-01";
					$tgl_target_end = "$date_target-31";
						
					$no_urut = 1;
					if ($resource_act) 
						{ 
						while ($r_pr = db_fetch($resource_act))
							{
							$r_pic = $r_pr[0];								
	
							$query_ves_enroll = q_set($__p_query_ves_enroll, "SELECT count(kd_biodata) FROM ves_data.tb_prospect where pic = ? and dt_target between  ? and ? and kelompok = 'VES' group by kd_biodata", [(string) ($r_pic), (string) ($tgl_target_start), (string) ($tgl_target_end)]);	
							
							$result_ves_enroll=db_query_or_die("Wah error nih1", $query_ves_enroll, $__p_query_ves_enroll ?? []);
							if ($result_ves_enroll) 
								{ 
								while ($r_ves_enroll= db_fetch($result_ves_enroll))
									{
									$ves_enroll = $r_ves_enroll[0];	
									}
								}

							
							$query_vip_enroll = q_set($__p_query_vip_enroll, "SELECT count(kd_biodata) FROM ves_data.tb_prospect where pic = ? and dt_target between  ? and ? and kelompok = 'VIP' group by kd_biodata", [(string) ($r_pic), (string) ($tgl_target_start), (string) ($tgl_target_end)]);	
				
							$result_vip_enroll=db_query_or_die("Wah error nih1", $query_vip_enroll, $__p_query_vip_enroll ?? []);
							if ($result_ves_enroll) 
								{ 
								while ($r_vip_enroll= db_fetch($result_vip_enroll))
									{
									$vip_enroll = $r_vip_enroll[0];	
									}
								}
					
							//$query_last_progress= "SELECT progress, status, vip_status, pic, date_update FROM ves_inc.tb_progres_ves where kd_biodata = '$r[21]' order by date_update desc limit 1";
						
							//$result_last_progress=mysql_query($query_last_progress) or die("Wah error nih455");
							//$ada_data = db_num_rows($result);
							//if ($ada_data > 0 ) 
							//	{ 
						//		while ($r_get_last = db_fetch($result_last_progress))
						//			{
						//			$r[23]= $r_get_last[0];
						//			$ves_status= $r_get_last[1];
						//			$vip_status= $r_get_last[2];										
						//			}
						//		}
				?>                
                <tr>
                  <td><?php echo e($no_urut) ; ?></td>
                  <td><?php echo e($r_pic) ; ?></td>
                  <td><a href="act_dtl.php" 
target="popup" 
onClick="window.open('act_dtl.php?kds=<?php echo e(u($r_pr[1])); ?>&klp=1&dt=<?php  echo e(u($date_target)) ?>','popup','width=600,height=850,left=700px'); return false;"><?php echo e($ves_enroll) ; ?></a></td>
                  <td><br></td>
                  <td><a href="act_dtl.php" 
target="popup" 
onClick="window.open('act_dtl.php?kds=<?php echo e(u($r_pr[1])); ?>&klp=2&dt=<?php  echo e(u($date_target)) ?>','popup','width=600,height=850,left=700px'); return false;"><?php echo e($vip_enroll) ; ?></a></td>
                  <td>&nbsp;</td>
                  </tr>
                <?php $no_urut = num($no_urut) + 1;$ves_enroll ='';$vip_enroll =''; } }?>
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
      <div class="row"><!-- /.col -->
      </div>      
      <!-- /.row -->
   </section>
    <!-- /.content -->
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
    $("#example2").DataTable();	  
    $("#example3").DataTable();	  
    $('#example4').DataTable({
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
