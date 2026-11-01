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

$kd_cbg = '15';

$pilihan_sc = in_val('pilihan_sc', 'get');
if ($pilihan_sc ==''){$pilihan_sc = 'My Leads';}
elseif ($kd_cbg == '--ALL--'){$kd_cbg = 0;}
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
elseif ($kd_cbg == 'National'){$kd_cbg = 100;}
elseif ($kd_cbg == 'PIK'){$kd_cbg = 11;}
elseif ($kd_cbg == 'Serpong'){$kd_cbg = 12;}
elseif ($kd_cbg == 'CA'){$kd_cbg = 15;}
elseif ($kd_cbg == 'Medan'){$kd_cbg = 14;}

if (num($kd_cbg) ==0){$cabang = 'CA';}
elseif ($kd_cbg ==''){$cabang = 'CA';}
elseif (num($kd_cbg) ==1){$cabang = 'East Sby';$db_cabang ='billing.';}
elseif (num($kd_cbg) ==2){$cabang = 'West Sby';$db_cabang ='billing_west.';}
elseif (num($kd_cbg) ==3){$cabang = 'Denpasar';$db_cabang ='billing_bali.';}
elseif (num($kd_cbg) ==4){$cabang = 'South Jkt';$db_cabang ='billing_jkt_02.';}
elseif (num($kd_cbg) ==5){$cabang = 'North Jkt';$db_cabang ='billing_new_gs.';}
elseif (num($kd_cbg) ==6){$cabang = 'West Jkt';$db_cabang ='billing_m2.';}
elseif (num($kd_cbg) ==7){$cabang = 'Bandung';$db_cabang ='billing_new_bdg.';}
elseif (num($kd_cbg) ==8){$cabang = 'Malang TBI';$db_cabang ='billing_malang.';}
elseif (num($kd_cbg) ==9){$cabang = 'Bandung TBI';}
elseif (num($kd_cbg) ==10){$cabang = 'Bali TBI';}
elseif (num($kd_cbg) ==100){$cabang = 'National';}
elseif (num($kd_cbg) ==11){$cabang = 'PIK';}
elseif (num($kd_cbg) ==12){$cabang = 'Serpong';}
elseif (num($kd_cbg) ==15){$cabang = 'CA';}
elseif (num($kd_cbg) ==14){$cabang = 'Medan';}

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
 <form method=get action=ca_receipt.php> 
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
   <section class="content-header">
     <h1>CA Income Summary<br>
     </h1>
     <?php 

	$query = q_set($__p_query, "SELECT date_format(min(a.dt_payment),'%b %d, %Y'), date_format(min(a.dt_cetak),'%b %d, %Y'), a.id_receipt, a.kd_biodata, b.kd_program,a.kd_branch,amount, jns_Payment,a.pay_mtd,a.kd_billing,a.no,\r
case when jns_Payment = 'Down Payment' then amount end as DP,\r
case when jns_Payment = 'Registration' then amount end as RF,\r
case when jns_Payment = 'Installment 1' then amount end as i1,\r
case when jns_Payment = 'Installment 2' then amount end as i2,\r
case when jns_Payment = 'Installment 3' then amount end as i3,\r
case when jns_Payment = 'Full Payment' then amount end as fp ,a.dt_cetak,sc  FROM vip_billing_payment a left join vip_billing b on a.kd_biodata = b.kd_biodata and a.kd_billing = b.kd_billing where a.id_receipt <> '' and a.kd_branch = ?\r
\tand dt_payment between ? and ? group by id_receipt order by id_receipt desc", [(string) ($kd_cbg), (string) ($date_start), (string) ($date_end)]);	
	   
$total_rp = 0;
$no_urut = 1;
$result=db_query_or_die("Wah error nih11", $query, $__p_query ?? []);
$num_rows = db_num_rows($result);?>
     <table width="40%"  class="table table-bordered table-striped" id="example222">
       <tbody>
         <tr>
           <th width="11%" scope="row">Center</th>
           <td width="89%"><select name="kd_cbg"  onChange="this.form.submit()"   class="style33" id="select">

             <option value="15">CA</option>			   
			   
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
                  <th width="2%">No</th>
                  <th width="7%">Effective Date</th>
                  <th width="7%"> Receipt Date</th>
                  <th width="27%">Receipt Number</th>
                  <th width="27%">Student Name</th>
                  <th width="12%">Program</th>
                  <th width="14%">Payment Metodh</th>
                  <th width="14%">Discount</th>
                  <th width="14%">Voucher</th>
                  <th width="10%">DP</th>
                  <th width="10%">RF</th>
                  <th width="10%">Inst 1</th>
                  <th width="10%">Inst 2</th>
                  <th width="10%">Inst 3</th>
                  <th width="10%">Full Payment</th>
                  <th width="10%">SC - Branch</th>
                  </tr>
                </thead>
                <tbody>

				  <?php 
					if ($result) 
						{ 
						while ($r = db_fetch($result))
							{
//							$query_nama = "SELECT concat_ws(' ',nama, middle_name) from ves_inc.tb_biodata where kd_biodata = '$r[3]' and kd_branch = '$r[5]'";
							$query_discount = q_set($__p_query_discount, "SELECT discount,tf,net_tf,voucher,level_program from ves_data.vip_billing where kd_billing = ? ", [(string) ($r[9])]);

							$result_discount=db_query_or_die("Wah error nih1", $query_discount, $__p_query_discount ?? []);	
							while ($r_discount = db_fetch($result_discount))
							{ $nm_discount = $r_discount[0];
							 $tf_asli = $r_discount[1];
							 $tf_nett = $r_discount[2];
							  $nm_voucher = $r_discount[3];
							 $tf_selisih = num($tf_asli) - num($tf_nett);
							// $bsr_discount = ($tf_selisih/$tf_asli)*100;
							 $jenis_program = $r_discount[4];
							}
							
							$query_nama = q_set($__p_query_nama, "SELECT nama_lengkap from ves_data.vip_student_data where kd_biodata = ? and kd_branch = ? ", [(string) ($r[3]), (string) ($r[5])]);
								
							$result_nama=db_query_or_die("Wah error nih1", $query_nama, $__p_query_nama ?? []);	
							while ($r_nama = db_fetch($result_nama))
								{ $nama_student = $r_nama[0];}
							$query_program = q_set($__p_query_program, "SELECT concat_ws(' ', type_program, nm_program), level_program, buku FROM ves_data.vip_mst_code_prg  where kd_program =  ? group by kd_program", [(string) ($r[4])]);

							$result_program=db_query_or_die("Wah error nih1", $query_program, $__p_query_program ?? []);	
							while ($r_program = db_fetch($result_program))
								{ $nama_program = $r_program[0];//$jenis_program = $r_program[1];
								}
							$sc = $r[18];
if ($sc =='Britney Sherleen Poogoh') {$cbg_sc ='West Sby';}
elseif ($sc =='Jeanny Merilla Theda Lukito') {$cbg_sc ='Denpasar';}
elseif ($sc =='Levinia Aldora Susmono') {$cbg_sc ='West Jkt';}
elseif ($sc =='Indah Nur Atika Sari') {$cbg_sc ='Denpasar';}
elseif ($sc =='Simon') {$cbg_sc ='West Jkt';}
elseif ($sc =='sabrina marcela') {$cbg_sc ='East Sby';}
elseif ($sc =='sabrina marchella') {$cbg_sc ='East Sby';}
elseif ($sc =='Cornelia Nathalie') {$cbg_sc ='East Sby';}
elseif ($sc =='Arsyi Aisyah') {$cbg_sc ='East Sby';}
elseif ($sc =='Stevanus Yustiawan') {$cbg_sc ='West Jkt';}
elseif ($sc =='Event') {$cbg_sc ='East Sby';}



	
				?>                
                <tr>
                  <td><?php echo e($no_urut) ; ?></td>
                  <td><?php echo e($r[0]) ; ?></td>
                  <td><?php echo e($r[1]) ; ?></td>
                  <td><a href="vipbookreceiptprint.php" 
target="popup" 
onclick="window.open('printable/vipreceiptprint.php?no=<?php echo e(u($r[10])); ?>','popup','width=1000,height=800'); return false;"><?php echo e($r[2]) ; ?></a></td>
                  <td><?php echo e($nama_student) ; ?></td>
                  <td><?php echo e($nama_program) ; ?> - <?php echo e($jenis_program) ; ?></td>
                  <td><?php echo e($r[8]) ; ?></td>
                  <td><?php echo e($nm_discount) ; ?></td>
                  <td><?php echo e($nm_voucher) ; ?></td>
                  <td><?php echo number_format(num($r[11]),0,".",".") ; ?></td>
                  <td><?php echo number_format(num($r[12]),0,".",".") ; ?></td>
                  <td><?php echo number_format(num($r[13]),0,".",".") ; ?></td>
                  <td><?php echo number_format(num($r[14]),0,".",".") ; ?></td>
                  <td><?php echo number_format(num($r[15]),0,".",".") ; ?></td>
                  <td><?php echo number_format(num($r[16]),0,".",".") ; ?></td>
                  <td><?php echo e($sc) ; ?> - <?php echo e($cbg_sc); ?></td>
                  </tr>
                <?php $total_rp = num($total_rp) + num($r[6]); $no_urut = num($no_urut) + 1; $r[6] =''; } } ?>
            
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
          </div><a href="rpt_vip_inc.php?kd_cbg=<?php echo e(u($kd_cbg))?>&date_start=<?php echo e(u($date_start)) ?>&date_end=<?php echo e(u($date_end))?>" target="_blank" class="btn btn-default"><i class="fa fa-print"></i> Print</a><a href="ca_receiptxl.php?kd_cbg=<?php echo e(u($kd_cbg))?>&date_start=<?php echo e(u($date_start)) ?>&date_end=<?php echo e(u($date_end))?>" target="_blank" class="btn btn-default"><i class="fa fa-print"></i>Excel</a>
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
