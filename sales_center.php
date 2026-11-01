<?php
require_once __DIR__ . "/_lib/bootstrap.php"; auth_require_login(); 
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
if ($date_start ==''){$date_start = "$tahun-$bulan-01";}
if ($date_end ==''){$date_end = $hari_ini;}


$kd_cbg = in_val('kd_cbg', 'get');

if ($kd_cbg == '--ALL--'){$kd_cbg = 0;}
elseif ($kd_cbg == 'East Sby'){$kd_cbg = 1;}
elseif ($kd_cbg == 'West Sby'){$kd_cbg = 2;}
elseif ($kd_cbg == 'Denpasar'){$kd_cbg = 3;}
elseif ($kd_cbg == 'South Jkt'){$kd_cbg = 4;}
elseif ($kd_cbg == 'North Jkt'){$kd_cbg = 5;}
elseif ($kd_cbg == 'West Jkt'){$kd_cbg = 6;}
elseif ($kd_cbg == 'Bandung'){$kd_cbg = 7;}
elseif ($kd_cbg == 'Malang TBI'){$kd_cbg = 8;}
elseif ($kd_cbg == 'Bandung TBI'){$kd_cbg = 9;}
elseif ($kd_cbg == 'Bali TBI'){$kd_cbg = 10;}

if (num($kd_cbg) ==0){$cabang = '--ALL--';}
elseif ($kd_cbg ==''){$cabang = '--ALL--';}

elseif (num($kd_cbg) ==1){$cabang = 'East Sby';}
elseif (num($kd_cbg) ==2){$cabang = 'West Sby';}
elseif (num($kd_cbg) ==3){$cabang = 'Denpasar';}
elseif (num($kd_cbg) ==4){$cabang = 'South Jkt';}
elseif (num($kd_cbg) ==5){$cabang = 'North Jkt';}
elseif (num($kd_cbg) ==6){$cabang = 'West Jkt';}
elseif (num($kd_cbg) ==7){$cabang = 'Bandung';}
elseif (num($kd_cbg) ==8){$cabang = 'Malang TBI';}
elseif (num($kd_cbg) ==9){$cabang = 'Bandung TBI';}
elseif (num($kd_cbg) ==10){$cabang = 'Bali TBI';}
$nama_lengkap = $_SESSION['nama_lengkap'];
$nama_depan = $_SESSION['nama_depan'];
if($nama_lengkap!='Levinia Aldora Susmono'){
$kd_cbg = $_SESSION['kd_branch'];}
$posisi = $_SESSION['posisi']; 
$kd_staff = $_SESSION['kd_staff'] ;
$kd_area = $_SESSION['kode_area'] ;


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
 le<form method=get action=sales_center.php> 
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>Sales Student
        <br>
      </h1>
      <table width="453" border="0">
        <tbody>
          <tr>
			  <td width="148"><small>
              <label for="date5"> Enrolled Period :</label>
              </small></td>
            <td width="289"><small>
              <label for="date2">:</label>
            <input type="date" format="dd/MM/yyyy" name="date_start" id="date2" value="<?php echo e($date_start) ; ?>" onChange="this.form.submit()">
To </small><small>
<input type="date" name="date_end" id="date2" value="<?php echo e($date_end) ; ?>" onChange="this.form.submit()" >
</small></td>
          </tr>
<?php if ($nama_lengkap =='Levinia Aldora Susmono')		{?>	
          <tr>
            <td><small>
            <label for="date3"> Center:</label>
            </small></td>
            <td><span class="form-group">
              <strong>:</strong>
<select name="kd_cbg"  onChange="this.form.submit()"   class="style33" id="select">
              <option value="0">--CHOOSE--</option>
              <option value="1">East Sby</option>
              <option value="2">West Sby</option>
              <option value="3">Denpasar</option>
              <option value="8">Malang</option>
              <option value="101">East Area</option>
              <option value="4">South Jkt</option>
              <option value="5">North Jkt</option>
              <option value="11">PIK</option>
              <option value="6">West Jkt</option>
              <option value="7">Bandung</option>
              <option value="102">West Area</option>
              <option value="100">--ALL--</option>
              <option selected="selected"><?php echo e($cabang) ?></option>
              </select>
            </span></td>
          </tr>
<?php } ?>			
        </tbody>
      </table>
                 <?php
if ($nama_lengkap == 'redes d harjono')
{
					$query = q_set($__p_query, "SELECT t.cabang, date_format(t.enroll_date,'%d/%m/%y'), t.kd_biodata, t.nama, a.grade, a.school, t.program, t.major, t.h_nh, t.p_np,final_status, last_remark, last_update, t.ori_school, t.ori_grade, a.country, t.pic, mkt_source, mkt_source_dtl, nm_event, adm_pic,enroll_date, kd_biodata,t.kd_school, t.status,t.no,t.pv_estimated, t.pv_fix  FROM tb_sales_report  t left join tb_master_partner a on t.kd_school = a.kd_school  where t.enroll_date between ? and ? and t.kd_cabang <> '' order by enroll_date desc", [(string) ($date_start), (string) ($date_end)]);	
}		
elseif ($nama_lengkap == 'Ragel Suma Wijaya')
{
					$query = q_set($__p_query, "SELECT t.cabang, date_format(t.enroll_date,'%d/%m/%y'), t.kd_biodata, t.nama, a.grade, a.school, t.program, t.major, t.h_nh, t.p_np,final_status, last_remark, last_update, t.ori_school, t.ori_grade, a.country, t.pic, mkt_source, mkt_source_dtl, nm_event, adm_pic,enroll_date, kd_biodata,t.kd_school, t.status,t.no,t.pv_estimated, t.pv_fix  FROM tb_sales_report  t left join tb_master_partner a on t.kd_school = a.kd_school  where t.enroll_date between ? and ? and (t.kd_cabang = '1'  or  t.kd_cabang = '3') order by enroll_date desc", [(string) ($date_start), (string) ($date_end)]);	
}
elseif ($nama_lengkap == 'Levinia Aldora Susmono')
{
	if($kd_cbg =='100')
		{
							$query = q_set($__p_query, "SELECT t.cabang, date_format(t.enroll_date,'%d/%m/%y'), t.kd_biodata, t.nama, a.grade, a.school, t.program, t.major, t.h_nh, t.p_np,final_status, last_remark, last_update, t.ori_school, t.ori_grade, a.country, t.pic, mkt_source, mkt_source_dtl, nm_event, adm_pic,enroll_date, kd_biodata,t.kd_school, t.status,t.no,t.pv_estimated, t.pv_fix  FROM tb_sales_report  t left join tb_master_partner a on t.kd_school = a.kd_school  where t.enroll_date between ? and ?  order by enroll_date desc", [(string) ($date_start), (string) ($date_end)]);	
		}
	else
		{
							$query = q_set($__p_query, "SELECT t.cabang, date_format(t.enroll_date,'%d/%m/%y'), t.kd_biodata, t.nama, a.grade, a.school, t.program, t.major, t.h_nh, t.p_np,final_status, last_remark, last_update, t.ori_school, t.ori_grade, a.country, t.pic, mkt_source, mkt_source_dtl, nm_event, adm_pic,enroll_date, kd_biodata,t.kd_school, t.status,t.no,t.pv_estimated, t.pv_fix  FROM tb_sales_report  t left join tb_master_partner a on t.kd_school = a.kd_school  where t.enroll_date between ? and ? and t.kd_cabang = ? order by enroll_date desc", [(string) ($date_start), (string) ($date_end), (string) ($kd_cbg)]);	
		}
	

}		
else
{
					$query = q_set($__p_query, "SELECT t.cabang, date_format(t.enroll_date,'%d/%m/%y'), t.kd_biodata, t.nama, a.grade, a.school, t.program, t.major, t.h_nh, t.p_np,final_status, last_remark, last_update, t.ori_school, t.ori_grade, a.country, t.pic, mkt_source, mkt_source_dtl, nm_event, adm_pic,enroll_date, kd_biodata,t.kd_school, t.status,t.no,t.pv_estimated, t.pv_fix FROM tb_sales_report  t left join tb_master_partner a on t.kd_school = a.kd_school  where t.enroll_date between ? and ? and t.kd_cabang = ? order by enroll_date desc", [(string) ($date_start), (string) ($date_end), (string) ($kd_cbg)]);	
}




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
    	    	<a href="sales_xl.php?q=1" target="_blank" class="btn btn-info" role="button">Export to xls</a>

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
                <tr>
                  <th width="3%" align="center">No</th>
                  <th width="5%">Enroll Date</th>
                  <th width="5%">Student Name</th>
                  <th width="17%">Institution - PV</th>
                  <th width="4%">H<br>
                  AD<br>
                  STEM<br>
                  NON<br></th>
                  <th width="4%">P/NP</th>
                  <th width="4%">Final Status</th>
                  <th width="10%">Admission Step</th>
                  <th width="10%">Remark</th>
                  <th width="3%">SC<br>
                    AC</th>
                  <th width="17%">SOURCE</th>
                  <th width="16%">STATUS<br>
                    SALES</th>
                  <th width="16%">Enrollment <br>
                  Form Print</th>
                  <th width="16%">Update</th>
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
								
							$final_status = $r[10];	
							$no_sales =$r[25];
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
									?>                
                <tr>

                  <td><?php echo e($no_urut) ; ?></td>
                  <td><?php echo e($r[1]) ; ?></td>
                  <td><?php echo e($r[3]) ; ?><br>
                  <?php echo e($r[13]) ; ?> - <?php echo e($r[14]) ; ?></td>
                  <td><?php echo e($r[5]) ; ?> - <?php echo e($r[6]) ; ?> - <?php echo e($r[7]) ; ?>   (<?php echo e($r[15]) ; ?>)<br>                    <?php echo e($r[4]) ; ?><br>
                    <?php echo e($pv_estimated) ; ?> <br>
                    <a href="pv_upd.php?no_sales=<?php echo e(u($r[25])); ?>&src=1" target="popup" onclick="window.open('pv_upd.php?no_sales=<?php echo e(u($r[25])); ?>&src=1','popup','width=600,height=800'); return false;">
                  <div class="icon"><img src="imgs/edit.png" height="15" width="15"></i>PV</div></a></td>
                  <td><?php echo e($r[8]) ; ?></td>
                  <td><?php echo e($r[9]) ; ?></td>
                  <td><?php echo e($final_status) ; ?></td>
                  <td><?php echo e($step) ; ?><br><a href="stuadmprogresspop.php?kdb=<?php echo e(u($kode_biodata)) ?>&st=1&asal=3" target="popup" onclick="window.open('stuadmprogresspop.php?kdb=<?php echo e(u($kode_biodata)) ?>&st=1&asal=3','popup','width=600,height=800'); return false;">
                  <div class="icon"><img src="imgs/edit.png" height="15" width="15"></i>Step Update</div></a></td>
                  <td><?php echo e($r[11]) ; ?><br>
                  <?php echo e($r[12]) ; ?></td>
                  <td><?php echo e($r[16]) ; ?><br>                    <?php echo e($r[11]) ; ?></td>
                  <td><?php echo e($r[17]) ; ?><br>
                  <?php echo e($r[18]) ; ?></td>
                  <td>
                  	<?php 
				  	if($r[24]=='OK'){ echo "Approved";}else{echo "Pending";}
					  ?>				
                  </td>
                  <td><a href="enrollmentformprev.php?kode_student=<?php echo e(u($r[22])); ?>&dt_e=<?php echo  e(u($r[21])) ?>" target="_blank"><div class="icon"><img src="imgs/printer.png" height="15" width="15"></i></div></a></td>
                  <td>
                  <?php 
					if($r[24]!='OK')
					{			?>
                  <a href="profile_sales.php?kdb=<?php echo e(u($r[22])) ?>&enroll_date=<?php echo e(u($r[21])); ?>&kd_school=<?php echo e(u($r[23])); ?>&nsl=<?php echo e(u($r[25])) ?>" target="_parent">
                  <div class="icon"><img src="imgs/edit.png" height="15" width="15"></i>Update</div></a>
                  <a href="profile_sales_app.php?kdb=<?php echo e(u($r[22])) ?>&enroll_date=<?php echo e(u($r[21])); ?>&kd_school=<?php echo e(u($r[23])); ?>" target="_parent"><div class="icon"><img src="imgs/appr.png" height="15" width="15"></i>App</div></a>
                  <a href="profile_sales_del.php?kdb=<?php echo e(u($r[22])) ?>&enroll_date=<?php echo e(u($r[21])); ?>&kd_school=<?php echo e(u($r[23])); ?>&no=<?php echo e(u($r[25])) ?>" target="_parent"><div class="icon"><img src="imgs/delete.png" height="15" width="15"></i>Delete</div></a><?php } ?>
                  <a href="profile.php?kdb=<?php echo e(u($r[22])) ?>&enroll_date=<?php echo e(u($r[21])); ?>&kd_school=<?php echo e(u($r[23])); ?>" target="_blank">
                  <div class="icon"><img src="imgs/profile.png" height="15" width="15"></i>Profile</div></a>
                  </td>
                  </tr>
                <?php $no_urut = num($no_urut) + 1; $step ='';} }?>
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
