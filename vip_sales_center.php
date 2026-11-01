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
if ($date_start ==''){$date_start = "2024-01-01";}
if ($date_end ==''){$date_end = $hari_ini;}
$date_start =='2024-01-01';
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
if ($kd_cbg == 'PIK'){$kd_cbg = 11;}
if ($kd_cbg == 'Serpong'){$kd_cbg = 12;}
if ($kd_cbg == 'HO'){$kd_cbg = 00;}
if ($kd_cbg == 'Medan'){$kd_cbg = 14;}
if ($kd_cbg == 'CA'){$kd_cbg = 15;}
if ($kd_cbg == 'Tangerang'){$kd_cbg = 16;}

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
if (num($kd_cbg) ==11){$cabang = 'PIK';}
if (num($kd_cbg) ==12){$cabang = 'Serpong';}
if (num($kd_cbg) ==00){$cabang = 'HO';}
if (num($kd_cbg) ==14){$cabang = 'Medan';}
if (num($kd_cbg) ==15){$cabang = 'CA';}
if (num($kd_cbg) ==16){$cabang = 'Tangerang';}

$nama_lengkap = $_SESSION['nama_lengkap'];
if($nama_lengkap =='Debora Mboeik'){num($kd_cbg) ==19;$cabang = 'FELLOWS ACADEMY';}
$nama_depan = $_SESSION['nama_depan'];
$kelompok = $_SESSION['kelompok'];
$kd_area = $_SESSION['kode_area'] ;
if (($kelompok !='ACC' and $kelompok != 'HO') or ($nama_lengkap != 'lucky anggriani') or ($nama_lengkap != 'Michael Lee')  ) {$kd_cbg = $_SESSION['kd_branch'];}
$posisi = $_SESSION['posisi']; 
$kd_staff = $_SESSION['kd_staff'] ;
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
 <form method=get action=vip_sales_center.php> 
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>VIP Sales Student
        <br>
      </h1>
      <table width="453" border="0">
        <tbody>
          <tr>
            <td><small>
              <label for="date3">Center :</label>
            </small></td>
            <td>:
              <select name="kd_cbg"  onChange="this.form.submit()"   class="style33" id="select">
<?php 	if($nama_lengkap =='Michael Lee') { ?>	
                <option value="0">--CHOOSE--</option>				  
				                  <option value="1">East Sby</option>
                <option value="2">West Sby</option>
<?PHP } elseif ($nama_lengkap == 'Debora Mboeik'){?>				  
                <option value="19">FELLOWS ACADEMY</option>
<?php }else { ?>				  
                <option value="0">--CHOOSE--</option>
                <option value="1">East Sby</option>
                <option value="2">West Sby</option>
                <option value="3">Denpasar</option>
                <option value="8">Malang</option>
                <option value="101">East Area</option>
                <option value="4">South Jkt</option>
                <option value="5">North Jkt</option>
                <option value="11">PIK</option>		
                <option value="12">Serpong</option>				  
                <option value="6">West Jkt</option>
                <option value="7">Bandung</option>
                <option value="14">Medan</option>
                <option value="15">CA</option>					  
                <option value="102">West Area</option>
                <option value="100">National</option>
                <option value="00">HO</option>
                <option value="15">Tangerang</option>
<?php } ?>				  
                <option selected="selected"><?php echo e($cabang) ?></option>
              </select></td>
          </tr>
          <tr>
			  <td width="148"><small>
              <label for="date5"> Billing Date Period :</label>
              </small></td>
            <td width="289"><small>
              <label for="date2">:</label>
            <input type="date" format="dd/MM/yyyy" name="date_start" id="date2" value="<?php echo e($date_start) ; ?>" onChange="this.form.submit()">
To </small><small>
<input type="date" name="date_end" id="date2" value="<?php echo e($date_end) ; ?>" onChange="this.form.submit()" >
</small></td>
          </tr>
        </tbody>
      </table>
    
                     <div class="form-group">
          <a href="teachercalendarpop.php?kd_cbg=<?php echo e(u($kd_cbg)) ?>" 
target="popup" 
onClick="window.open('teachercalendarpop.php?kd_cbg=<?php echo e(u($kd_cbg)) ?>','popup','width=1000,height=850,left=700px'); return false;" class="btn btn-primary" role="button"><i class="glyphicon glyphicon-calendar" aria-hidden="true"></i>
View Academic Calendar </a>         
          </div>
    </section><!-- Main content -->
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
		  <label>Billing Statement List</label>
		</div>				
	  </div>
	  <div class="col-md-12">
	    <div class="form-group">
	      	      <table width="100%" class="table table-bordered table-striped" id="example1">
	        <thead>
	          <tr>
	            <td width=2% align=center >No</td>
	            <td width=26% align=center >ID Billing</td>
	            <td width=12% height="14" align=center >Student Name</td>
	            <td width="14%" align=center >Program</td>
	            <td width="11%" align=center >Invoiced</td>
	            <td width="11%" align=center >Paid</td>
	            <td width="13%" align=center >Class Status</td>
              </tr>
            </thead>
		<?php 
//===jika ada billing
//$query_billing = "SELECT a.kd_billing,b.nm_program, b.level_program, b.type_program, sum(net_tf+reg_fee+material_cost) as invoiced,a.dt_entry,c.nama, c.middle_name, c.family_name,a.kd_biodata FROM ves_data.vip_billing a left join ves_data.vip_mst_code_prg b on a.kd_program = b.kd_program left join ves_inc.tb_biodata c on a.kd_biodata = c.kd_biodata where a.kd_branch = '$kd_cbg' and a.dt_entry between '$date_start' and '$date_end' group by a.kd_billing order by a.kd_billing" ;
//						   /* echo $query_billing (debug SQL versi lama) dihapus */
						   
//$resource_billing = mysql_query($query_billing);
//$keluar_billing = db_num_rows($resource_billing);
					   ?>
	        <tbody>
          <?php	
//$query_billing = "SELECT a.kd_billing,b.nm_program, a.level_program, b.type_program, sum(net_tf+reg_fee+material_cost) as invoiced,a.dt_entry,c.nama, c.middle_name, c.family_name,a.kd_biodata,a.net_tf, a.reg_fee, a.material_cost FROM ves_data.vip_billing a left join ves_data.vip_mst_code_prg b on a.kd_program = b.kd_program left join ves_inc.tb_biodata c on a.kd_biodata = c.kd_biodata where a.kd_branch = '$kd_cbg' and a.dt_entry between '$date_start' and '$date_end' group by a.kd_billing order by a.no desc" ;
if ($nama_lengkap == 'Debora Mboeik')	{
$query_billing = q_set($__p_query_billing, "SELECT a.kd_billing,b.nm_program, a.level_program, b.type_program, sum(net_tf+reg_fee+material_cost) as invoiced,a.dt_entry,c.nama_lengkap,a.kd_biodata,a.net_tf, a.reg_fee, a.material_cost,a.kd_class,a.kd_program,a.kd_branch FROM ves_data.vip_billing a left join ves_data.vip_mst_code_prg b on a.kd_program = b.kd_program left join ves_data.vip_student_data c on a.kd_biodata = c.kd_biodata and a.kd_branch = c.kd_branch where   a.dt_entry between ? and ?  and b.kd_program like 'FA-%' group by a.kd_billing order by a.no desc", [(string) ($date_start), (string) ($date_end)]);		
}else {
$query_billing = q_set($__p_query_billing, "SELECT a.kd_billing,b.nm_program, a.level_program, b.type_program, sum(net_tf+reg_fee+material_cost) as invoiced,a.dt_entry,c.nama_lengkap,a.kd_biodata,a.net_tf, a.reg_fee, a.material_cost,a.kd_class,a.kd_program,a.kd_branch FROM ves_data.vip_billing a left join ves_data.vip_mst_code_prg b on a.kd_program = b.kd_program left join ves_data.vip_student_data c on a.kd_biodata = c.kd_biodata and a.kd_branch = c.kd_branch where   a.dt_entry between ? and ?  and a.kd_branch = ? group by a.kd_billing order by a.no desc", [(string) ($date_start), (string) ($date_end), (string) ($kd_cbg)]);	
}
$no_urut = 1;		
$resource_billing = db_query_soft($query_billing, $__p_query_billing ?? []);
$keluar_billing = db_num_rows($resource_billing);				
if(num(db_num_rows($resource_billing)) > 0)
	{
	while ($row_billing  =  db_fetch($resource_billing, PDO::FETCH_NUM))
		{

		$query_bayar = q_set($__p_query_bayar, "SELECT sum(amount) as ttl ,remark FROM ves_data.vip_billing_payment where kd_billing = ? and id_receipt <> ''", [(string) ($row_billing[0])]);
		$resource_bayar = db_query_soft($query_bayar, $__p_query_bayar ?? []);
		$keluar_bayar = db_num_rows($resource_bayar);	
		if(num(db_num_rows($resource_bayar)) > 0)
			{
			while ($row_bayar  =  db_fetch($resource_bayar, PDO::FETCH_NUM))	
				{
				$mbayar = $row_bayar[0];
				$data_nik = $row_bayar[1];
				}
			}	
	?>
	          <tr>
	            <td align=center class="style24"><?php echo e($no_urut) ?></td>
	            <td align=center class="style24">
	            <?php //==== admin  
				if($posisi =="Admin" or $nama_lengkap == 'laura natalia' or $nama_lengkap == 'Rachma Maristika'     or $nama_lengkap == 'Kurnia')
				{
				?>
	            <a href="vipbillreceipt.php?idb=<?php echo e(u($row_billing[0]))  ?>&kdb=<?php echo e(u($row_billing[7])) ?>&st=1">
	            
	            <?php } else { //non admin ?>
	           	<a href="vipbill.php?idb=<?php echo e(u($row_billing[0]))  ?>&kdb=<?php echo e(u($row_billing[7])) ?>&st=1">
	            <?php } ?>
	            <?php echo e($row_billing[0]) ?></a> - <?php echo e($row_billing[5]) ?></td>
	            <td height="14" align=left class="style24"><a href="prestuvip.php?browser=<?php echo e(u($row_billing[7])) ?>&st=1"><?php echo e($row_billing[6]) ?><br>
	            </a><?php echo e($data_nik) ?></td>
	            <td align=center class="style24"><?php echo e($row_billing[1]) ?> <?php echo e($row_billing[2]) ?> - <?php echo e($row_billing[3]) ?></td>
	            <td align=center class="style24"><?php echo  number_format(num((num($row_billing[8])+num($row_billing[9])+num($row_billing[10]))),0,".",".")  ?></td>
	            <td align=center class="style24"><?php echo  number_format(num($mbayar),0,".",".") ?></td>
	            <td align=center class="style24"><a href="vip_class_student_list.php?kdcl=<?php echo e(u($row_billing[11])) ?>&kdprg=<?php echo e(u($row_billing[12])) ?>&kd_cbg=<?php echo e(u($row_billing[13]))?>" target="_blank"><?php echo e($row_billing[11]) ?></a></td>
              </tr>
              <?php $no_urut = num($no_urut) +1; }} ?>
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
      <!-- /.row --><!-- /.content -->
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
<?php 
if (isset($_GET['Search'])) 
	{
			echo "<script type=\"text/javascript\">\n";
			echo "window.location = ('prestuvip.php');\n";				
			echo "</script>";
	}
?>
