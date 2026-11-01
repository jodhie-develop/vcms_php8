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
if ($date_start ==''){$date_start = "$tahun-$bulan-01";}
if ($date_end ==''){$date_end = $hari_ini;}

$kd_cbg = in_val('kd_cbg', 'get');

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
if ($kd_cbg == 'Malang TBI'){$kd_cbg = 8;}
if ($kd_cbg == 'Bandung TBI'){$kd_cbg = 9;}
if ($kd_cbg == 'Bali TBI'){$kd_cbg = 10;}
if ($kd_cbg == 'National'){$kd_cbg = 100;}
if ($kd_cbg == 'PIK'){$kd_cbg = 11;}
if ($kd_cbg == 'Serpong'){$kd_cbg = 12;}

if (num($kd_cbg) ==0){$cabang = '--ALL--';}
if ($kd_cbg ==''){$cabang = '--ALL--';}
if (num($kd_cbg) ==1){$cabang = 'East Sby';$db_cabang ='billing.';}
if (num($kd_cbg) ==2){$cabang = 'West Sby';$db_cabang ='billing_west.';}
if (num($kd_cbg) ==3){$cabang = 'Denpasar';$db_cabang ='billing_bali.';}
if (num($kd_cbg) ==4){$cabang = 'South Jkt';$db_cabang ='billing_jkt_02.';}
if (num($kd_cbg) ==5){$cabang = 'North Jkt';$db_cabang ='billing_new_gs.';}
if (num($kd_cbg) ==6){$cabang = 'West Jkt';$db_cabang ='billing_m2.';}
if (num($kd_cbg) ==7){$cabang = 'Bandung';$db_cabang ='billing_new_bdg.';}
if (num($kd_cbg) ==8){$cabang = 'Malang TBI';$db_cabang ='billing_malang.';}
if (num($kd_cbg) ==9){$cabang = 'Bandung TBI';}
if (num($kd_cbg) ==10){$cabang = 'Bali TBI';}
if (num($kd_cbg) ==100){$cabang = 'National';}

if (num($kd_cbg) == 11){$cabang = 'PIK';}
if (num($kd_cbg) == 12){$cabang = 'Serpong';}

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

  <!-- Content Wrapper. Contains page content -->
 <form method=get action=payment_refund.php> 
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
   <section class="content-header">
     <h1>Payment Refund<br>
     </h1>
     <?php 
 if ($cabang =='National')
	{
	$query = q_set($__p_query, "SELECT t.id_invoice, t.dt_payment, t.id_billing,nama_lengkap, t.keterangan,t.nominal,t.pay_mtd,t.keterangan_dtl,t.id  FROM tb_invoice_paid t left join tb_invoice a on t.id_billing = a.id_billing  where dt_payment between ? and ?  group by id_invoice order by dt_payment desc", [(string) ($date_start), (string) ($date_end)]);		
	}
else
	{
	$query = q_set($__p_query, "SELECT t.id_invoice, t.dt_payment, t.id_billing,nama_lengkap, t.keterangan,t.nominal,t.pay_mtd,t.keterangan_dtl,t.id  FROM tb_invoice_paid t left join tb_invoice a on t.id_billing = a.id_billing  where dt_payment between ? and ? and t.kd_branch = ? group by id_invoice order by dt_payment desc", [(string) ($date_start), (string) ($date_end), (string) ($kd_cbg)]);			
	}

$total_rp = 0;
$no_urut = 1;
$result=db_query_or_die("Wah error nih1", $query, $__p_query ?? []);
$num_rows = db_num_rows($result);?>
     <table width="40%"  class="table table-bordered table-striped" id="example222">
       <tbody>
         <tr>
           <th width="11%" scope="row">Center</th>
           <td width="89%"><select name="kd_cbg"  onChange="this.form.submit()"   class="style33" id="select">
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
             <option value="11">PIK</option>
             <option value="12">Serpong</option>			   
             <option value="102">West Area</option>
             <option value="100">National</option>
             <option selected="selected"><?php echo e($cabang) ?></option>
           </select></td>
         </tr>
         <tr>
           <th scope="row">Period Date</th>
           <td><small>
             <input type="date" format="dd/MM/yyyy" name="date_start" id="date2" value="<?php echo e($date_start) ; ?>" onChange="this.form.submit()">
           </small> To <small>
           <input type="date" format="dd/MM/yyyy" name="date_end" id="date" value="<?php echo e($date_end) ; ?>" onChange="this.form.submit()">
           </small></td>
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
                  <th width="3%">No</th>
                  <th width="12%">Receipt Number</th>
                  <th width="14%">Billing Number</th>
                  <th width="12%">Student Name</th>
                  <th width="16%">Description</th>
                  <th width="17%">Amount</th>
                  <th width="21%">Refund Payment</th>
                  <th width="5%">Action</th>
                  </tr>
                </thead>
                <tbody>

				  <?php 

					if ($result) 
						{ 
						while ($r = db_fetch($result))
							{
							$id_invoice = $r[0];
							$dt_payment = $r[1];
							$id_billing = $r[2];
							$nama_lengkap = $r[3];
							$keterangan = $r[4];
							$nominal = $r[5];
							$pay_mtd = $r[6]; 
							$ket = $r[7]; 							
							$id_urut_invoice = $r[8]; 								

							
							$query_total_refund = q_set($__p_query_total_refund, "SELECT sum(v.amount) FROM ves_data.vip_billing_refund  v where id_receipt = ? ", [(string) ($r[2])]);
							$result_total_refund=db_query_or_die("Wah error nih2", $query_total_refund, $__p_query_total_refund ?? []);	
							if (num(db_num_rows($result_total_refund)) > 0)
							{
							while ($r_tot_refund = db_fetch($result_total_refund))
								{ $nominal_total_refund = $r_tot_refund[0];}						}	
							$bs_refund = num($r[6])-num($nominal_total_refund);
							if(num($bs_refund) >= 1){$bs_refund =1;}else{$bs_refund = 0;}
							
				?>                
                <tr>
                  <td><?php echo e($no_urut) ; ?></td>
                  <td><?php echo e($id_invoice) ; ?><br>                    <?php echo e($dt_payment) ; ?></td>
                  <td><?php echo e($id_billing) ; ?></td>
                  <td><?php echo e($nama_lengkap) ; ?></td>
                  <td><?php echo e($keterangan) ; ?> - <?php echo e($jenis_program) ; ?></td>
                  <td><?php echo number_format(num($nominal),0,".",".") ; ?><br>                    <?php echo e($pay_mtd) ; ?></td>
                  <td>TOTAL : <?php echo number_format(num($nominal_refund),0,".",".") ; ?>
<?php $bs_refund =1;
							$query_list_refund = q_set($__p_query_list_refund, "SELECT v.amount, v.id_refund, v.no FROM ves_data.payment_refund  v where id_invoice = ? ", [(string) ($id_invoice)]);
							$result_list_refund=db_query_or_die("Wah error nih2", $query_list_refund, $__p_query_list_refund ?? []);	
							if (num(db_num_rows($result_list_refund)) > 0)
							{num($bs_refund) == 0;
							while ($r_list_refund = db_fetch($result_list_refund))
								{ $nominal_list_refund = $r_list_refund[0];$no_list_refund = $r_list_refund[1];$id_list_refund = $r_list_refund[2];						?>						  
                  <p><?php echo  number_format(num($nominal_list_refund),0,".",".") ; ?><br>
<a href="paymentrefund_dtl.php?id=<?php echo e(u($no_urut)); ?>" 
target="popup" 
onclick="window.open('printable/prt_ot_refund.php?id=<?php echo e(u($id_list_refund)); ?>','popup','width=1000,height=800'); return false;"><?php echo e($no_list_refund); ?></a></p>
<?php }}?>					  
					</td>
                  <td> 
					  <?php if (num($bs_refund) == 1){?>
<a href="paymentrefund_dtl.php?id=<?php echo e(u($id_urut_invoice)); ?>" 
target="popup" 
onclick="window.open('paymentrefund_dtl.php?id=<?php echo e(u($id_urut_invoice)); ?>','popup','width=1000,height=800'); return false;"><span class="label label-success">Refund</span></a>
<?php } ?>
					</td>
                  </tr>
                <?php $total_rp = num($total_rp) + num($r[6]); $no_urut = num($no_urut) + 1;$nominal_refund = 0;$no_refund =''; } } ?>
					          
                </tbody>
                <tfoot>
                </tfoot>
              </table>
            </div>
            <div class="box">
         	<div class="box-body">
         		<label>TOTAL INCOME : Rp. <?php echo number_format(num($total_rp),0,".",".")  ; ?></label>
         	</div>
         </div>
            <!-- /.box-body -->
          </div><a href="rpt_vip_inc.php?kd_cbg=<?php echo e(u($kd_cbg))?>&date_start=<?php echo e(u($date_start)) ?>&date_end=<?php echo e(u($date_end))?>" target="_blank" class="btn btn-default"><i class="fa fa-print"></i> Print</a><a href="vip_receiptxl.php?kd_cbg=<?php echo e(u($kd_cbg))?>&date_start=<?php echo e(u($date_start)) ?>&date_end=<?php echo e(u($date_end))?>" target="_blank" class="btn btn-default"><i class="fa fa-print"></i>Excel</a>
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
