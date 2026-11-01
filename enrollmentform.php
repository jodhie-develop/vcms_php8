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
 <?php // include __DIR__ . "/left.php";	 ?>
 <?php //====================== ?>
  <!-- Content Wrapper. Contains page content -->
 <form method=get action=leaving.php> 
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
<table width="900" border="0" bgcolor="#FFFFFF" align="center">
  <tr>
    <td colspan="2" rowspan="3" align="center"><img src="pelem/vista-logo.png" width="124" height="68" /></td>
    <td colspan="2" rowspan="2" align="center"><strong>VISTA ENROLLMENT FORM<br />
    </strong></td>
    <td colspan="2" align="center">&nbsp;</td>
    <td align="right">&nbsp;</td>
    <td width="162">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2" align="right">Consultant : <strong><?php echo e($pic) ?></strong></td>
    <td align="right">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2" align="center"><strong><?php echo e($branch_nm) ?></strong></td>
    <td colspan="2" align="right">Enroll Date : <strong><?php echo e($tgl_enroll) ?></strong></td>
    <td align="right">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td height="9" colspan="8" align="center"><hr width="875"></td>
  </tr>
  <tr>
    <td width="2" height="40">&nbsp;</td>
    <td width="111" valign="bottom">Full Name    </td>
    <td width="100">&nbsp;</td>
    <td>&nbsp;</td>
    <td valign="bottom">Gender</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td height="21">&nbsp;</td>
    <td colspan="3"><strong><?php echo  e($nama) ?> <?php echo  e($middle_name) ?> <?php echo  e($family_name) ?></strong></td>
    <td><strong><?php echo  e($gender) ?></strong></td>
    <td>&nbsp;</td>
    <td width="2">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td height="41">&nbsp;</td>
    <td colspan="2" valign="bottom">Date Of Birth </td>
    <td width="241" valign="bottom">Phone</td>
    <td width="149" valign="bottom">Handphone</td>
    <td width="33">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="2"><strong><?php echo  e($dob_lengkap) ?></strong></td>
    <td><strong><?php echo  e($hm_ph) ?></strong></td>
    <td><strong><?php echo  e($hp) ?></strong></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td height="40">&nbsp;</td>
    <td colspan="2" valign="bottom">Email</td>
    <td valign="bottom">Address</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="2"><strong><?php echo  e($e_mail) ?></strong></td>
    <td colspan="3"><strong><?php echo  e($address) ?> <?php echo  e($city) ?> <?php echo  e($nationality) ?></strong></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td height="40">&nbsp;</td>
    <td colspan="2" valign="bottom">Education</td>
    <td colspan="5" valign="bottom">Current/Previous School </td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="2"><strong><?php echo  e($level_school) ?></strong></td>
    <td colspan="5"><strong><?php echo  e($org_school) ?> <?php echo  e($grade) ?></strong></td>
  </tr>
  <tr>
    <td height="37">&nbsp;</td>
    <td colspan="2" valign="bottom">Father's Name </td>
    <td valign="bottom">Father's Phone</td>
    <td colspan="2" valign="bottom">Company Name </td>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="2"><strong><?php echo  e($parent_nm) ?></strong></td>
    <td><strong><?php echo  e($hp_parent) ?></strong></td>
    <td colspan="2">&nbsp;</td>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="2">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="5"><table width="689" border="0">
      <tr class="bg-gray-active">
        <td colspan="6"  align="center" class="attachment-text"><strong><span class="style2">OVERSEAS STUDY PROGRAM </span></strong></td>
        </tr>
      <tr class="bg-gray-active">
        <td width="104" align="center"><strong><span class="style2">School Name </span></strong></td>
        <td  width="108" align="center"><strong><span class="style2">Program Study </span></strong></td>
        <td  width="106" align="center"><strong><span class="style2">Country</span></strong></td>
        <td  width="79" align="center"><strong><span class="style2">Major</span></strong></td>
        <td width="114" align="center"><strong><span class="style2">Intake Date </span></strong></td>
        <td  width="152" align="center"><strong><span class="style2">Proffesional Fee </span></strong></td>
        </tr>
      <?php 
		$query_enroll = q_set($__p_query_enroll, "SELECT sch_dest, prg_dest, country_dest, major_dest, date_format(intake_date,'%d %b %Y'), prof_fee FROM ves_inc.tb_enrolled where kd_biodata = ? ", [(string) ($kode_student)]);
		$result_twi=db_query_or_die("Wah error nih! 1", $query_enroll, $__p_query_enroll ?? []);
		$no_urut_week ="1";	  
			while ($r_dtli = db_fetch($result_twi))
				{ ?>
      
      <tr class="style32">
        <td><strong><?php echo e($r_dtli[0]); ?></strong></td>
        <td><strong><?php echo e($r_dtli[1]); ?></strong></td>
        <td><strong><?php echo e($r_dtli[2]); ?></strong></td>
        <td><strong><?php echo e($r_dtli[3]); ?></strong></td>
        <td><strong><?php echo e($r_dtli[4]); ?></strong></td>
        <td align="right"><strong><?php echo e(buatrp($r_dtli[5])); ?></strong></td>
        </tr><?php } ?>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        </tr>
      <tr>
        <td colspan="6"><div align="center"><span class="style2"><strong>RULES &amp; REGULATIONS REGARDING PROFESSIONAL FEE</strong></span></div></td>
        </tr>
      <tr>
        <td colspan="6"><ol><li> Professional fee is the amount of money paid according to those stated on professional fee details.</li>
          <li>The Professional fee is non-refundable, including when there is cancellation of application from the applicant for any reason and at any time.</li>
          <li>In the case a US Visa is rejected, we will refund 50% of the first school's professional fee, provided the applicant has been interviewed twice.</li>
          <li>The professional fee paid is valid only for the particular schools agreed at the time of payment. If there is an addition or change of schools later on, there will be additional charge.</li>
          </ol>		  </td>
        </tr>
      <tr class="badge">
        <td colspan="6" bgcolor="#400000"><span class="style2"><strong>RULES &amp; REGULATIONS REGARDING OTHER FEES</strong></span></td>
        </tr>
      <tr>
        <td colspan="6"><ol>
          <li>Professional fee also includes translation service by Vista, document sending (max 3 times) by international courier.</li>
          <li>Professional fee does not include any fee required by the SCHOOL (application fee, deposits, housing, etc.).</li>
          <li>Professional fee does not include Visa Fee, tickets, Fiscal and airport taxes.</li>
          <li>Visa Fee is officially charged by the Embassy and is substitute to change at any time without prior notice.</li>
          <li>Professional fee does not include administrative fees charged by other parties, such as sworn translator, notary public, bank, local school, etc.</li>
          <li>Professional fee does not include PORTFOLIO SHIPPING HANDLING charged by the courier.</li>
          <li>In the case of refund, administration charge of 10% fee will occur</li>
          </ol>        </td>
        </tr>
      <tr>
        <td colspan="6">&nbsp;</td>
        </tr>
      <tr>
        <td colspan="3">Source Data :</td>
        <td>&nbsp;</td>
        <td colspan="2" align="center">Signature of Applicant/Guardian </td>
        </tr>
      <tr>
        <td colspan="3"><strong><?php echo  e($event_type) ?></strong> <strong><?php echo  e($event_type_dtl) ?></strong></td>
        <td>&nbsp;</td>
        <td colspan="2">&nbsp;</td>
        </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td colspan="2" align="center"><strong><?php echo  e($nama) ?> <?php echo  e($middle_name) ?> <?php echo  e($family_name) ?></strong></td>
        </tr>
    </table>    </td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
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
