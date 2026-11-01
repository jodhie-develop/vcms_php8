<?php
require_once __DIR__ . "/_lib/bootstrap.php"; auth_require_login(); 
include __DIR__ . "/conndb.php";
include __DIR__ . "/profiledata.php";
include __DIR__ . "/atas.php";
include __DIR__ . "/left.php";	
$q = in_val('q', 'get');
$hari=date("d");
$bulan=date("m");
$tahun=date("Y");
$hari_ini = "$tahun-$bulan-$hari";
$date_start = in_val('date_start', 'get');
$date_end = in_val('date_end', 'get');
$periode_claim = in_val('periode_claim', 'get');


if ($date_start ==''){$date_start = "$tahun-$bulan-01";}
if ($date_end ==''){$date_end = $hari_ini;}

$kd_cbg = in_val('kd_cbg', 'get');

$pilihan_sc = in_val('pilihan_sc', 'get');
if ($pilihan_sc ==''){$pilihan_sc = 'My Leads';}

if ($kd_cbg == 'East Sby'){$kd_cbg = 1;}
elseif ($kd_cbg == 'West Sby'){$kd_cbg = 2;}
elseif ($kd_cbg == 'Denpasar'){$kd_cbg = 3;}
elseif ($kd_cbg == 'South Jkt'){$kd_cbg = 4;}
elseif ($kd_cbg == 'North Jkt'){$kd_cbg = 5;}
elseif ($kd_cbg == 'West Jkt'){$kd_cbg = 6;}
elseif ($kd_cbg == 'Bandung'){$kd_cbg = 7;}
elseif ($kd_cbg == 'Malang TBI'){$kd_cbg = 8;}
elseif ($kd_cbg == 'Bandung TBI'){$kd_cbg = 9;}
elseif ($kd_cbg == 'Bali TBI'){$kd_cbg = 10;}
elseif ($kd_cbg == 'National'){$kd_cbg = 100;}
elseif ($kd_cbg == 'PIK'){$kd_cbg = 11;}


if (num($kd_cbg) ==1){$cabang = 'East Sby';$nm_cabang = $cabang;}
elseif (num($kd_cbg) ==2){$cabang = 'West Sby';$nm_cabang = $cabang;}
elseif (num($kd_cbg) ==3){$cabang = 'Denpasar';$nm_cabang = 'Bali';}
elseif (num($kd_cbg) ==4){$cabang = 'South Jkt';$nm_cabang = 'Patal Jkt';}
elseif (num($kd_cbg) ==5){$cabang = 'North Jkt';$nm_cabang = 'Central Jkt';}
elseif (num($kd_cbg) ==6){$cabang = 'West Jkt';$nm_cabang = $cabang;}
elseif (num($kd_cbg) ==7){$cabang = 'Bandung';$nm_cabang = $cabang;}
elseif (num($kd_cbg) ==8){$cabang = 'Malang TBI';$nm_cabang = $cabang;}
elseif (num($kd_cbg) ==9){$cabang = 'Bandung TBI';$nm_cabang = $cabang;}
elseif (num($kd_cbg) ==10){$cabang = 'Bali TBI';$nm_cabang = $cabang;}
elseif (num($kd_cbg) ==100){$cabang = 'National';$nm_cabang = $cabang;}
elseif (num($kd_cbg) ==11){$cabang = 'PIK';$nm_cabang = $cabang;}
elseif (num($kd_cbg) ==14){$cabang = 'Medan';$nm_cabang = $cabang;}


$nama_lengkap = $_SESSION['nama_lengkap'];
$nama_depan = $_SESSION['nama_depan'];
//$kd_cbg = $_SESSION['kd_branch'];
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
  <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="../css/ionicons.min.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="../plugins/datatables/dataTables.bootstrap.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../dist/css/AdminLTE.min.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="../dist/css/skins/_all-skins.min.css">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
</head>

  <!-- Content Wrapper. Contains page content -->
 <form method=get action=liu_ves_pf.php> 
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
   <section class="content-header">
     <h1>VES Service Fee<br>
     </h1>
     <?php 
 if ($cabang =='--ALL--' or $cabang =='National')
	{
	$query = q_set($__p_query, "SELECT t.id_prof_bill,nm_stu, concat_ws(' ',t.country_dest, t.school_dest, t.prg_dest),  t.st_refund, t.rp_mount,t.dt_paid,t.no,\r
mkt_team, mkt_tool, csr, center_income, center_saving, ppn,t.id_stu,t.branch  FROM ves_inc.tb_prof_bill t \r
left join ves_data.vos_distribute_sf b on t.id_prof_bill = b.id_prof_bill and t.id_stu = b.kd_biodata\r
where date_format(dt_paid,'%Y-%m') = ? and (t.branch ='Bali' or t.branch ='Bandung' or t.branch ='Central Jkt' or t.branch ='East Sby' or t.branch ='Patal Jkt' or t.branch ='PIK' or t.branch ='West Jkt' or t.branch ='West Sby'  or t.branch ='South Jkt'   or t.branch ='North Jkt' )  group by t.id_prof_bill order by  t.branch ,t.dt_paid", [(string) ($periode_claim)]);		
	}
else
	{
	$query = q_set($__p_query, "SELECT t.id_prof_bill, nm_stu, concat_ws(' ',t.country_dest, t.school_dest, t.prg_dest),  t.st_refund, t.rp_mount,t.dt_paid,t.no,\r
mkt_team, mkt_tool, csr, center_income, center_saving, ppn,t.id_stu,t.branch  FROM ves_inc.tb_prof_bill t \r
left join ves_data.vos_distribute_sf b on t.id_prof_bill = b.id_prof_bill and t.id_stu = b.kd_biodata\r
where date_format(dt_paid,'%Y-%m') = ? and t.branch = ? group by t.id_prof_bill order by t.dt_paid", [(string) ($periode_claim), (string) ($nm_cabang)]);		
	}
$no_urut = 1;
/* echo $query (debug SQL versi lama) dihapus */
$result=db_query_or_die("Wah error nih11", $query, $__p_query ?? []);
$num_rows = db_num_rows($result);?>
     <table width="40%"  class="table table-bordered table-striped" id="example222">
       <tbody>
         <tr>
           <th width="11%" scope="row">Center</th>
           <td width="89%"><select name="kd_cbg"   class="style33" id="select">
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
             <option value="14">Medan</option>			   
             <option value="102">West Area</option>
             <option value="100">National</option>
             <option selected="selected"><?php echo e($cabang) ?></option>
           </select></td>
         </tr>
         <tr>
           <th scope="row">Period Date</th>
           <td><small>
             <input type="month" format="dd/MM/yyyy" name="periode_claim" id="date2" value="<?php echo e($periode_claim) ; ?>" >
           </small></td>
         </tr>
         <tr>
           <th scope="row"><input name="Display" type="submit" id="Save"  class="form-control"  value="Display" /></th>
           <td>&nbsp;</td>
         </tr>
       </tbody>
     </table>
   

   </section>


 <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <!-- /.box -->

          <div class="box">
            <!-- /.box-header -->
            <div class="box-body">
              <table width="97%" class="table table-bordered table-striped" id="example1">
                <thead>
                <tr>
                  <th width="2%">No</th>
                  <th width="13%">Receipt Number</th>
                  <th width="16%">Student Name</th>
                  <th width="21%">Destination</th>
                  <th width="10%">Refund/<br>
                  Non Refund</th>
                  <th width="12%">Amount</th>
                  <th width="16%">P/NP</th>
                  <th width="16%">Mkt Team<br>
                  (10%)</th>
                  </tr>
                </thead>
                <tbody>

				  <?php 
					if ($result) 
						{ 
						while ($r = db_fetch($result))
							{
							$st_ada = 0;
							$tot_sf = num($tot_sf) + num($r[4]);
							$mkt_team = $r[7]; $tot_mkt_team = num($tot_mkt_team) + num($mkt_team);
							$mkt_tool = $r[8]; $tot_mkt_tool = num($tot_mkt_tool) + num($mkt_tool);
							$csr = $r[9]; $tot_csr = num($tot_csr) + num($csr);
							$center_income = $r[10]; $tot_center_income = num($tot_center_income) + num($center_income);
							$center_saving = $r[11]; $tot_center_saving = num($tot_center_saving) + num($center_saving);
							$ppn = $r[12]; $tot_ppn = num($tot_ppn) + num($ppn);
							
														
							$query_hitung_pax = q_set($__p_query_hitung_pax, "select p_np from ves_data.tb_sales_report where date_format(enroll_date,'%Y-%m') = ? and prioritas = 1 and status = 'OK'  and kd_biodata = ? ", [(string) ($periode_claim), (string) ($r[13])]);
							$result_hitung_pax=db_query_or_die("Wah error nih112", $query_hitung_pax, $__p_query_hitung_pax ?? []);
							if ($result_hitung_pax) 
								{ 
								while ($r_pnp = db_fetch($result_hitung_pax))
									{
									$st_ada = 1;

									$p_np = $r_pnp[0];
									}
								}
							
								
							if(num($st_ada) ==0){$mkt_team = 0; echo e($r[13]);}
							if($p_np !='P'){$mkt_team = 0;}
							if($kd_sebelumnya ==  $r[13]) {$mkt_team = 0;}
							
							
							
							
							$query_nama = q_set($__p_query_nama, "SELECT concat_ws(' ',nama, middle_name) from ves_inc.tb_biodata where kd_biodata = ? and kd_branch = ? ", [(string) ($r[3]), (string) ($r[5])]);
							$result_nama=db_query_or_die("Wah error nih1", $query_nama, $__p_query_nama ?? []);	
							while ($r_nama = db_fetch($result_nama))
								{ $nama_student = $r_nama[0];}

				?>                
                <tr>
                  <td><?php echo e($no_urut) ; ?></td>
                  <td><?php echo e($r[0]) ; ?><br>                    <?php echo e($r[5]) ; ?></td>
                  <td><?php echo e($r[1]) ; ?><br>
<?php echo e($r[14]) ?></td>
                  <td><?php echo e($r[2]) ; ?></td>
                  <td><?php echo e($r[3]) ; ?></td>
                  <td><?php echo number_format(num($r[4]),0,".",".") ; ?></td>
                  <td><?php echo e($p_np); ?></td>
                  <td><?php echo number_format(num($mkt_team),0,".",".") ; ?></td>
                  </tr>
                <?php $no_urut = num($no_urut) + 1; $kd_sebelumnya = $r[13]; } }?>
                </tbody>
                <tfoot>
					<tr>
                  <th colspan="5" align="right"><strong>TOTAL</strong></th>
                                   <td><strong><?php echo number_format(num($tot_sf),0,".",".") ; ?></strong></td>
                  <td><strong><?php echo number_format(num($tot_ppn),0,".",".") ; ?></strong></td>
                  <td><strong><?php echo number_format(num($tot_mkt_team),0,".",".") ; ?></strong></td>
                  </tr>
                </tfoot>
              </table>
            </div>

            <!-- /.box-body -->
          </div><a href="rpt_vip_inc.php?kd_cbg=<?php echo e(u($kd_cbg))?>&date_start=<?php echo e(u($date_start)) ?>&date_end=<?php echo e(u($date_end))?>" target="_blank" class="btn btn-default"><i class="fa fa-print"></i> Print</a><a href="ves_pfxl.php?kd_cbg=<?php echo e(u($kd_cbg))?>&date_start=<?php echo e(u($date_start)) ?>&date_end=<?php echo e(u($date_end))?>" target="_blank" class="btn btn-default"><i class="fa fa-print"></i>Excel</a>
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
