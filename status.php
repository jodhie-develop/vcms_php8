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
if ($date_start ==''){$date_start = "2016-07-01";}
if ($date_end ==''){$date_end = $hari_ini;}


$kd_cbg = in_val('kd_cbg', 'get');

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
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
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
 <?php include __DIR__ . "/left.php";	 ?>
 <?php //====================== ?>
  <!-- Content Wrapper. Contains page content -->
 <form method=get action=status.php> 
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>Admission Student
        <br>
      </h1>
      <table width="453" border="0">
        <tbody>
          <tr>
			  <td width="148"><small>
              <label for="date5"> Enroll Period :</label>
              </small></td>
            <td width="289"><small>
              <label for="date2">:</label>
            <input type="date" format="dd/MM/yyyy" name="date_start" id="date2" value="<?php echo e($date_start) ; ?>" onChange="this.form.submit()">
To </small><small>
<input type="date" name="date_end" id="date2" value="<?php echo e($date_end) ; ?>" onChange="this.form.submit()" >
</small></td>
          </tr>
          <tr>
            <td height="24"><small>
            <label for="date3"> Center :</label>
            </small></td>
            <td><small>
            <label for="date4">:</label>
            <select name="kd_cbg"  onChange="this.form.submit()"   class="style33" id="select">
              <option value="0">--ALL--</option>
			<option value="1">East Sby</option>
              <option value="2">West Sby</option>
              <option value="3">Denpasar</option>
              <option value="4">South Jkt</option>
              <option value="5">North Jkt</option>
              <option value="6">West Jkt</option>
              <option value="7">Bandung</option>
              <option value="8">Malang TBI</option>
              <option value="9">Bandung TBI</option>              
              <option value="10">Bali TBI</option>                            
              <option selected="selected"><?php echo e($cabang) ?></option>
            </select></small></td>
          </tr>
        </tbody>
      </table>
      
      <table width="200" border="0">
                   <tbody>
                     <tr>
                       <td><br>
Result : <?php echo e($num_rows) ?></td>
                       <td>
    	    	<a href="leaving_xl.php?q=1" target="_blank" class="btn btn-info" role="button">Export to xls</a>

    </td>
                     </tr>
                     <tr>
                       <td>&nbsp;</td>
                       <td>&nbsp;</td>
                     </tr>
                   </tbody>
      </table>
    </section><!-- Main content -->
    
<?php //=================== 
if ($kd_cbg == '0' || $kd_cbg == '')
{
$query = q_set($__p_query, "SELECT t.cabang, date_format(t.enroll_date,'%d/%m/%y'), t.kd_biodata, t.nama, a.grade, a.school, t.program, t.major, t.h_nh, t.p_np,final_status, last_remark, last_update, t.ori_school, t.ori_grade, a.country, t.pic, mkt_source, mkt_source_dtl, nm_event, adm_pic,enroll_date FROM tb_sales_report  t left join tb_master_partner a on t.kd_school = a.kd_school  where t.enroll_date between ? and ?  and t.prioritas = '1' and t.status = 'OK'  order by enroll_date desc", [(string) ($date_start), (string) ($date_end)]);
}
else	
{
$query = q_set($__p_query, "SELECT t.cabang, date_format(t.enroll_date,'%d/%m/%y'), t.kd_biodata, t.nama, a.grade, a.school, t.program, t.major, t.h_nh, t.p_np,final_status, last_remark, last_update, t.ori_school, t.ori_grade, a.country, t.pic, mkt_source, mkt_source_dtl, nm_event, adm_pic,enroll_date FROM tb_sales_report  t left join tb_master_partner a on t.kd_school = a.kd_school  where t.enroll_date between ? and ?  and t.prioritas = '1' and t.status = 'OK' and t.kd_cabang = ? order by enroll_date desc", [(string) ($date_start), (string) ($date_end), (string) ($kd_cbg)]);			
}
$stu_enroll = 0;
$stu_adm = 0;				  
$_SESSION['ngueri'] = $query; $_SESSION['ngueri__p'] = $__p_query ?? [];
$result=db_query_or_die("Wah error nih5", $query, $__p_query ?? []);
$num_rows = db_num_rows($result);   
$jumlah_student = $num_rows;
if ($result) 
	{ 
	while ($r = db_fetch($result))
		{	
		$tgl_enroll = $r[21];
		$kode_biodata = $r[2];
		$final_status = $r[10];				
		$stu_enroll = num($stu_enroll) + 1;
		$query_get_last = q_set($__p_query_get_last, "SELECT update_date, step FROM adm_stu_progress where enroll_date = ? and kd_biodata = ? order by update_date desc limit 1", [(string) ($tgl_enroll), (string) ($kode_biodata)]);	
		$result_get_last=db_query_or_die("Wah error nih5", $query_get_last, $__p_query_get_last ?? []);	
		if ($result_get_last ) 
			{ 
			while ($r_get_last = db_fetch($result_get_last))
				{
				$update_terakhir = 	$r_get_last[0];	
				$stu_adm = num($stu_adm) + 1;
				$update_terakhir = 	$r_get_last[0];
				$query_get_admission = q_set($__p_query_get_admission, "SELECT final_status, step FROM adm_stu_progress where enroll_date = ? and kd_biodata = ? and update_date = ? order by no desc limit 1", [(string) ($tgl_enroll), (string) ($kode_biodata), (string) ($update_terakhir)]);
				$result_get_admission=db_query_or_die("Wah error nih5", $query_get_admission, $__p_query_get_admission ?? []);	
				if ($result_get_admission) 
					{
					while ($r_get_admission = db_fetch($result_get_admission))
						{
						$final_status= $r_get_admission[0];							
						$step = $r_get_admission[1];
						if (strpos($step, '1.') !== false) { $langkah_1 = num($langkah_1) + 1;} // substring2 is found in string
						elseif (strpos($step, '2.') !== false) { $langkah_2 = num($langkah_2) + 1;} // substring2 is found in string
						elseif (strpos($step, '3.') !== false) { $langkah_3 = num($langkah_3) + 1;} // substring2 is found in string
						elseif (strpos($step, '4.') !== false) { $langkah_4 = num($langkah_4) + 1;} // substring2 is found in string
						elseif (strpos($step, '5.') !== false) { $langkah_5 = num($langkah_5) + 1;} // substring2 is found in string
						elseif (strpos($step, '6.') !== false) { $langkah_6 = num($langkah_6) + 1;} // substring2 is found in string
						elseif (strpos($step, '7.') !== false) { $langkah_7 = num($langkah_7) + 1;} // substring2 is found in string
						elseif (strpos($step, '8.') !== false) { $langkah_8 = num($langkah_8) + 1;} // substring2 is found in string
						elseif (strpos($step, '9.') !== false) { $langkah_9 = num($langkah_9) + 1;} // substring2 is found in string
						elseif (strpos($step, '10.') !== false) { $langkah_10 = num($langkah_10) + 1;} // substring2 is found in string
						elseif (strpos($step, '11.') !== false) { $langkah_11 = num($langkah_11) + 1;} // substring2 is found in string
						elseif (strpos($step, '12.') !== false) { $langkah_12 = num($langkah_12) + 1;} // substring2 is found in string
						elseif (strpos($step, '13.') !== false) { $langkah_13 = num($langkah_13) + 1;} // substring2 is found in string
						elseif (strpos($step, '14.') !== false || $final_status == 'L') { $langkah_14 = num($langkah_14) + 1;} // substring2 is found in string
						else {$langkah_other = num($langkah_other) + 1;}	
						}
					}
				}
			}
			
		}
	}
	
$stu_enroll_saja = num($stu_enroll) - num($stu_adm);				  

$undefined = (num((div($stu_enroll_saja, $stu_enroll)))*100);	
$persen_langkah_1 = (num((div($langkah_1, $stu_enroll)))*100);	
$persen_langkah_2 = (num((div($langkah_2, $stu_enroll)))*100);	
$persen_langkah_3 = (num((div($langkah_3, $stu_enroll)))*100);	
$persen_langkah_4 = (num((div($langkah_4, $stu_enroll)))*100);	
$persen_langkah_5 = (num((div($langkah_5, $stu_enroll)))*100);	
$persen_langkah_6 = (num((div($langkah_6, $stu_enroll)))*100);	
$persen_langkah_7 = (num((div($langkah_7, $stu_enroll)))*100);	
$persen_langkah_8 = (num((div($langkah_8, $stu_enroll)))*100);	
$persen_langkah_9 = (num((div($langkah_9, $stu_enroll)))*100);	
$persen_langkah_10 = (num((div($langkah_10, $stu_enroll)))*100);	
$persen_langkah_11 = (num((div($langkah_11, $stu_enroll)))*100);	
$persen_langkah_12 = (num((div($langkah_12, $stu_enroll)))*100);	
$persen_langkah_13 = (num((div($langkah_13, $stu_enroll)))*100);	
$persen_langkah_14 = (num((div($langkah_14, $stu_enroll)))*100);	
$persen_langkah_other = (num((div($persen_langkah_other, $stu_enroll)))*100);	
	

	  ?>
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <!-- /.box --><div class="col-md-4">
                  <p class="text-center">
                    <strong>Admission Completion</strong>
                  </p>
              <div class="progress-group">
                    <span class="progress-text">Undefined</span>
                    <span class="progress-number"><b><?php echo e($stu_enroll_saja) ?></b>/<?php echo e($stu_enroll) ?></span>
                    <div class="progress sm">
                      <div class="progress-bar progress-bar-green" style="width: <?php echo e($undefined) ?>%"></div>
                    </div>
                  </div>
                     
                  <div class="progress-group">
                    <span class="progress-text">1. Completing documents</span>
                    <span class="progress-number"><b><?php echo e($langkah_1) ?></b>/<?php echo e($stu_enroll) ?></span>
                    <div class="progress sm">
                      <div class="progress-bar progress-bar-aqua" style="width: <?php echo e($persen_langkah_1) ?>%"></div>
                    </div>
                  </div>
                  <!-- /.progress-group -->
                  <div class="progress-group">
                    <span class="progress-text">2. Sending application</span>
                    <span class="progress-number"><b><?php echo e($langkah_2) ?></b>/<?php echo e($stu_enroll) ?></span>
                    <div class="progress sm">
                      <div class="progress-bar progress-bar-red" style="width: <?php echo e($persen_langkah_2) ?>%"></div>
                    </div>
                  </div>
                  <!-- /.progress-group -->
                  <div class="progress-group">
                    <span class="progress-text">3. Waiting for admission decision</span>
                    <span class="progress-number"><b><?php echo e($langkah_3) ?></b>/<?php echo e($stu_enroll) ?></span>
                    <div class="progress sm">
                      <div class="progress-bar progress-bar-green" style="width: <?php echo e($persen_langkah_3) ?>%"></div>
                    </div>
                  </div>
                  <!-- /.progress-group -->
                  <div class="progress-group">
                    <span class="progress-text">4. Received offer letter / conditional offer letter</span>
                    <span class="progress-number"><b><?php echo e($langkah_4) ?></b>/<?php echo e($stu_enroll) ?>		</span>
                    <div class="progress sm">
                      <div class="progress-bar progress-bar-yellow" style="width: <?php echo e($persen_langkah_4) ?>%"></div>
                    </div>
                  </div>
                  <div class="progress-group">
                    <span class="progress-text">5. Completing visa documents</span>
                    <span class="progress-number"><b><?php echo e($langkah_5) ?></b>/<?php echo e($stu_enroll) ?></span>
                    <div class="progress sm">
                      <div class="progress-bar progress-bar-blue" style="width: <?php echo e($persen_langkah_5) ?>%"></div>
                    </div>
                  </div>
                  <div class="progress-group">
                    <span class="progress-text">6. Applying student visa</span>
                    <span class="progress-number"><b><?php echo e($langkah_6) ?></b>/<?php echo e($stu_enroll) ?>		</span>
                    <div class="progress sm">
                      <div class="progress-bar progress-bar-green" style="width: <?php echo e($persen_langkah_6) ?>%"></div>
                    </div>
                  </div>
                  <div class="progress-group">
                    <span class="progress-text">7. Student visa granted</span>
                    <span class="progress-number"><b><?php echo e($langkah_7) ?></b>/<?php echo e($stu_enroll) ?>		</span>
                    <div class="progress sm">
                      <div class="progress-bar progress-bar-red" style="width: <?php echo e($persen_langkah_7) ?>%"></div>
                    </div>
                  </div>
                  <div class="progress-group">
                    <span class="progress-text">8. Completing housing application</span>
                    <span class="progress-number"><b><?php echo e($langkah_8) ?></b>/<?php echo e($stu_enroll) ?>		</span>
                    <div class="progress sm">
                      <div class="progress-bar progress-bar-green" style="width: <?php echo e($persen_langkah_8) ?>%"></div>
                    </div>
                  </div> 
                  <div class="progress-group">
                    <span class="progress-text">9. Apply housing</span>
                    <span class="progress-number"><b><?php echo e($langkah_9) ?></b>/<?php echo e($stu_enroll) ?>		</span>
                    <div class="progress sm">
                      <div class="progress-bar progress-bar-purple" style="width: <?php echo e($persen_langkah_9) ?>%"></div>
                    </div>
                  </div> 
                  <div class="progress-group">
                    <span class="progress-text">10. Housing confirmation received</span>
                    <span class="progress-number"><b><?php echo e($langkah_10) ?></b>/<?php echo e($stu_enroll) ?>		</span>
                    <div class="progress sm">
                      <div class="progress-bar progress-bar-red" style="width: <?php echo e($persen_langkah_10) ?>%"></div>
                    </div>
                  </div>
                  <div class="progress-group">
                    <span class="progress-text">11. Arrange ticketing and airport pick-up</span>
                    <span class="progress-number"><b><?php echo e($langkah_11) ?></b>/<?php echo e($stu_enroll) ?>		</span>
                    <div class="progress sm">
                      <div class="progress-bar progress-bar-purple" style="width: <?php echo e($persen_langkah_11) ?>%"></div>
                    </div>
                  </div>
                  <div class="progress-group">
                    <span class="progress-text">12. Airport pick-up confirmed</span>
                    <span class="progress-number"><b><?php echo e($langkah_12) ?></b>/<?php echo e($stu_enroll) ?>		</span>
                    <div class="progress sm">
                      <div class="progress-bar progress-bar-yellow" style="width: <?php echo e($persen_langkah_12) ?>%"></div>
                    </div>
                  </div>
                  <div class="progress-group">
                    <span class="progress-text">13. Pre-departure orientation</span>
                    <span class="progress-number"><b><?php echo e($langkah_13) ?></b>/<?php echo e($stu_enroll) ?>		</span>
                    <div class="progress sm">
                      <div class="progress-bar progress-bar-purple" style="width: <?php echo e($persen_langkah_13) ?>%"></div>
                    </div>
                  </div>                  
                   <div class="progress-group">
                    <span class="progress-text">14. Leaving</span>
                    <span class="progress-number"><b><?php echo e($langkah_14) ?></b>/<?php echo e($stu_enroll) ?>		</span>
                    <div class="progress sm">
                      <div class="progress-bar progress-bar-green" style="width: <?php echo e($persen_langkah_14) ?>%"></div>
                    </div>
                  </div>                                                                                                                                   <div class="progress-group">
                    <span class="progress-text">Cancel</span>
                    <span class="progress-number"><b><?php echo e($langkah_cancel) ?></b>/<?php echo e($stu_enroll) ?>		</span>
                    <div class="progress sm">
                      <div class="progress-bar progress-bar-red" style="width: <?php echo e($persen_langkah_cancel) ?>%"></div>
                    </div>
                  </div> 
				<div class="progress-group">
                    <span class="progress-text">Other</span>
                    <span class="progress-number"><b><?php echo e($langkah_other) ?></b>/<?php echo e($stu_enroll) ?>		</span>
                    <div class="progress sm">
                      <div class="progress-bar progress-bar-yellow" style="width: <?php echo e($persen_langkah_other) ?>%"></div>
                    </div>
                  </div>                                             
                  <!-- /.progress-group -->
                </div><!-- /.box -->
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
