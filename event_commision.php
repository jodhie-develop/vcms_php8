<?php
require_once __DIR__ . "/_lib/bootstrap.php"; auth_require_login(); 
include __DIR__ . "/conndb.php";
include __DIR__ . "/profiledata.php";
include __DIR__ . "/atas.php";
$q = in_val('q', 'get');
$search = in_val('search', 'get');
$status_payment = in_val('status_payment', 'get');
$pilihan_center = in_val('pilihan_center', 'get');
if ($status_payment==''){$status_payment="All";}
if ($pilihan_center==''){$pilihan_center="All";}

$hari=date("d");
$bulan=date("m");
$tahun=date("Y");
$hari_ini = "$tahun-$bulan-$hari";
$date_start = in_val('date_start', 'get');
$date_end = in_val('date_end', 'get');
if ($date_start ==''){$date_start = "2016-07-01";}
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

function buatrp($angka)
{
$jadi = "" . number_format(num($angka),0,',','.');
return $jadi;
}
if ($pilihan_center=='All'){$datacabang ="";}
if ($pilihan_center=='East Sby'){$datacabang =" and c.branch = 'East Sby' ";}
if ($pilihan_center=='West Sby'){$datacabang =" and c.branch = 'West Sby' ";}
if ($pilihan_center=='Denpasar'){$datacabang =" and c.branch = 'Bali' ";}
if ($pilihan_center=='South Jkt'){$datacabang =" and c.branch = 'patal Jkt' ";}
if ($pilihan_center=='North Jkt'){$datacabang =" and c.branch = 'Central Jkt' ";}
if ($pilihan_center=='West Jkt'){$datacabang =" and c.branch = 'West Jkt' ";}
if ($pilihan_center=='Bandung'){$datacabang =" and c.branch = 'Bandung' ";}
if ($pilihan_center=='Malang TBI'){$datacabang =" and c.branch = 'Malang TBI' ";}
if ($pilihan_center=='Bali TBI'){$datacabang =" and c.branch = 'Bali TBI' ";}
if ($pilihan_center=='Bandung TBI'){$datacabang =" and c.branch = 'Bandung TBI' ";}


//==========================
 
//$query = "SELECT c.branch, c.nama, c.dest_country, c.dest_school, c.dest_program, DATE_FORMAT(c.comm_date,'%d %b %y'),a.kd_invoice,
//DATE_FORMAT(a.dt_invoice,'%d %b %y'),b.org_cur_pay, b.org_mount_pay, b.rate_pay, b.mount_rp_pay,  DATE_FORMAT(b.dt_payment,'%d %b %y'),
//(case  when  c.final_status = 'L' then 1 else 0 end )as main,
//(case  when  c.final_status <> 'L' then 1 else 0 end )as add_l,
//(case  when  a.kd_invoice <> '' and b.mount_rp_pay = '' then 1 else 0 end ) as invoicing,
//(case  when  b.mount_rp_pay <> '' then 1 else 0 end ) as paid,c.bintang FROM adm_stu_progress c
//left join fin_invoice a on c.no =  a.no_leaving
//left join fin_comm b on a.no_leaving = b.no_leaving and a.kd_invoice = b.kd_invoice
//where c.final_status like '%L%' and c.comm_date between '2015-07-01' and '2016-06-30' $urutan ";



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

	</script>
</head>
<?php //========================== left nav ?>
 <?php   include __DIR__ . "/left.php";	 ?>
 <?php //====================== ?>
  <!-- Content Wrapper. Contains page content -->
 <form method=get action=event_commision.php> 
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
   <section class="content-header">
     <h1>Marketing Invoice<br>
     </h1>
     <table width="453" border="0">
        <tbody>
          <tr>
			  <td width="148"><small>
              <label for="date5"> Entry Period :</label>
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
            <label for="date3"> Center</label>
            </small></td>
            <td><small>
            <label for="date4">:</label>
 <select name="pilihan_center"  onChange="this.form.submit()">
                <option>All</option>               
                <option>East Sby</option>
                <option>West Sby</option>
                <option>Denpasar</option>
                <option>South Jkt</option>
                <option>North Jkt</option>
                <option>West Jkt</option>
                <option>Bandung</option>
                <option>Malang TBI</option> 
                <option>Bali TBI</option> 
                <option>Bandung TBI</option>                                                            
                <option selected><?php echo e($pilihan_center) ?></option>  
			</select>
 <input type="text" name="q" id="q" value="<?php echo e($q) ; ?>" hidden="hidden">
            <input type="text" name="search" id="q2" value="<?php echo e($search) ; ?>" hidden="hidden">
            </small></td>
          </tr>
          <tr>
            <td height="24">&nbsp;</td>
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
            <div class="box-body"><table width="97%" class="table table-bordered table-striped" id="example1">
                <thead>
                <?php 
                $query = q_set($__p_query, "SELECT a.institution_name, a.institution_country, a.cat_event, a.cat_dtl_event, date_format(a.dt_event,'%d %b %Y'),\r
\t\t\t\ta.description,a.add_description, a.remark, \r
 a.no_invoice, date_format(a.dt_invoice,'%d %b %Y'),\r
a.curr_invoice, a.ori_amount_invoice, a.rate_invoice, a.bank_invoice,\r
a.remark_invoice, a.institution_code, a.dt_entry, a.pic, a.no, b.dt_payment, b.payment_curr, b.payment_amount,\r
b.payment_rate, b.bank_charge, b.payment_remark FROM ves_data.acc_invoice a left join ves_data.acc_payment b on a.no_invoice = b.kd_invoice and a.no = b.no_urut_invoice where a.dt_entry between ? and ? order by a.dt_entry", [(string) ($date_start), (string) ($date_end)]);	
					
$no_urut = 1;

$resource = db_query_soft($query, $__p_query ?? []);

$keluar = db_num_rows($resource);?>
                <tr>
                  <th width="3%">No</th>
                  <th width="5%">Partner</th>
                  <th width="9%">Activities</th>
                  <th width="5%" align="center">Description</th>
                  <th width="5%" align="center">Invoice Number</th>
                  <th width="7%">Amount Invoice<br></th>
                  <th width="6%">Amount<br></th>
                  <th width="12%">Bank Invoice</th>
                  <th width="11%">Remark Invoice/<br>
                  Progress Follow Up</th>
                  <th width="6%">Payment Date</th>
                  <th width="6%">Amount Receive<br></th>
                  <th width="5%">Amount </th>
                  <th width="5%">Bank Charge</th>
                  <th width="8%">Different</th>
                  <th width="17%">Remark</th>
                </tr>
                </thead>
                <tbody>

				  <?php 
					if ($resource) 
						{ 
						while ($r = db_fetch($resource))
							{
							$amount_rupiah = num($r[11]) * num($r[12]);
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
                  <td><?php echo e($r[0]) ; ?> <?php echo e($r[1]) ; ?></td>
                  <td><?php echo e($r[2]) ; ?> - <?php echo e($r[3]) ; ?> <br></td>
                  <td><?php echo e($r[5]) ; ?> <?php echo e($r[6]) ; ?> <?php echo e($r[7]) ; ?> <?php echo e($r[4]) ; ?></td>
					<td><a href="inv_event_payment.php?kdi=<?php echo e(u($r[18])); ?>" 
target="popup" 
onclick="window.open('inv_event_payment.php?kdi=<?php echo e(u($r[18])); ?>','popup','width=1000,height=1200'); return false;">
<?php echo e($r[8]) ; ?></a> <br>                    <?php echo e($r[9]) ; ?></td>
                  <td><?php echo e($r[10]) ; ?> <?php echo e(buatrp($r[11])) ; ?> <br>                    <?php echo e(buatrp($r[12])) ; ?></td>
                  <td><?php echo e(buatrp($amount_rupiah)) ; ?></td>
                  <td><?php echo e($r[13]) ; ?></td>
                  <td><a href="inv_event_fu.php?kdi=<?php echo e(u($r[8])); ?>" 
target="popup" 
onclick="window.open('inv_event_fu.php?kdi=<?php echo e(u($r[8])); ?>','popup','width=1000,height=1200'); return false;">
<?php echo e($r[14]) ; ?>
</a></td>
                  <td><?php echo e($r[19]) ; ?></a></td>
                  <td><?php echo e($r[20]) ; ?></a> <?php echo e(buatrp($r[21])) ; ?></a><br>
                    <?php echo e(buatrp($r[22])) ; ?> <br>
                  <td><?php echo e(buatrp(num($r[21])* num($r[22]))) ; ?></td>
                  <td><?php echo e(buatrp($r[23])) ; ?></a></td>
                  <td></a><?php echo e(buatrp(num((num($r[21]) * num($r[22]) )) - num($amount_rupiah))) ; ?></td>
                  <td></a><?php echo e($r[24]) ; ?></td>

                </tr>
                <?php $no_urut = num($no_urut) + 1; } }?>
                </tbody>
                <tfoot>
                </tfoot>
              </table><br>
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
