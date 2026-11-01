<?php
include __DIR__ . "/conndb.php";
include __DIR__ . "/profiledata.php";
include __DIR__ . "/atas.php";
include __DIR__ . "/left.php";
// Variabel yang dipakai tampilan tetapi tidak selalu diisi (versi lama: kosong).
$kdprg = $nmprg = $kdcl = '';
$adascore = $adascore_mid = $adascore_final = '';
$tgl_tutor = $tgl_la = $tgl_lc = $tgl_ext = '';
$hari=date("d");
$bulan=date("m");
$tahun=date("Y");
$hari_ini = "$tahun-$bulan-$hari";
$date_start = in_date('date_start', '', 'get');
$date_end = in_date('date_end', '', 'get');
if ($date_start ==''){$date_start = "2025-01-01";}
if ($date_end ==''){$date_end = $hari_ini;}


$kd_cbg = in_str('kd_cbg', 20, 'get');

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

if (num($kd_cbg) == 0){$cabang = '--ALL--';}
if ($kd_cbg ==''){$cabang = '--ALL--';}

if ($kd_cbg ==1){$cabang = 'East Sby';}
if ($kd_cbg ==2){$cabang = 'West Sby';}
if ($kd_cbg ==3){$cabang = 'Denpasar';}
if ($kd_cbg ==4){$cabang = 'South Jkt';}
if ($kd_cbg ==5){$cabang = 'North Jkt';}
if ($kd_cbg ==6){$cabang = 'West Jkt';}
if ($kd_cbg ==7){$cabang = 'Bandung';}
if ($kd_cbg ==8){$cabang = 'Malang TBI';}
if ($kd_cbg ==9){$cabang = 'Bandung TBI';}
if ($kd_cbg ==10){$cabang = 'Bali TBI';}
$nama_lengkap = $_SESSION['nama_lengkap'];
$nama_depan = $_SESSION['nama_depan'];
$posisi = $_SESSION['posisi']; 
$kd_staff = $_SESSION['kd_staff'] ;





$pilihan_sc = in_str('pilihan_sc', 45, 'get');
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
   <section class="content-header">
      <h1>VE New Order<br>
      </h1>

    </section>
    	                <!-- Main content -->
    <!-- Content Header (Page header) -->
    <section class="content-header">
            <div class="form-group">
          <a href="teachercalendarpop.php?kd_cbg=<?php echo e(u($kd_cbg)) ?>" 
target="popup" 
onClick="window.open('teachercalendarpop.php?kd_cbg=<?php echo e(u($kd_cbg)) ?>','popup','width=1000,height=850,left=700px'); return false;" class="btn btn-primary" role="button"><i class="glyphicon glyphicon-calendar" aria-hidden="true"></i>
View Academic Calendar </a>         

          <a href="vip_order_list.php?kd_cbg=<?php echo e(u($kd_cbg)) ?>" 
class="btn btn-primary" role="button"><i class="glyphicon glyphicon-calendar" aria-hidden="true"></i>
          Order List</a>         
          </div>
      <div class="row">
        <div class="col-xs-12">
          <!-- /.box -->
<div class="box box-warning">          
	<div class="box-body">
	  <div class="col-md-12">

		<div class="form-group">
	      <p>
	        <input type="text" name="kdprg" id="textfield" hidden value="<?php echo e($kdprg) ?>" ></input>
	        <input type="text" name="nmprg" id="textfield2"hidden value="<?php echo e($nmprg) ?>" >
	      </p>
	      <p>&nbsp;</p>
		      <table width="100%" class="table table-bordered table-striped" id="example1">
		        <thead>
	      <tr>
	        <td width=12% height="14" align=center >Student Name</td>
	        <td width="6%" align=center >Class Code</td>
	        <td width="6%" align=center >Placement Score</td>
	        <td width="6%" align=center >Attendance</td>
	        <td width="11%" align=center >Mid Test Score</td>
	        <td width="10%" align=center >Final Test Score</td>
	        <td width="7%" align=center >Tutorial</td>
	        <td width="6%" align=center >Late Attendance</td>
	        <td width="11%" align=center >LC Visit</td>
	        <td width="14%" align=center >Test Extension</td>
	        </tr>
        </thead>
	    <?php 
//===jika ada billing
//$query_billing = "SELECT a.kd_billing,b.nm_program, b.level_program, b.type_program, sum(net_tf+reg_fee+material_cost) as invoiced,a.dt_entry,c.nama, c.middle_name, c.family_name,a.kd_biodata FROM ves_data.vip_billing a left join ves_data.vip_mst_code_prg b on a.kd_program = b.kd_program left join ves_inc.tb_biodata c on a.kd_biodata = c.kd_biodata where a.kd_branch = '$kd_cbg' and a.dt_entry between '$date_start' and '$date_end' group by a.kd_billing order by a.kd_billing" ;
//						   echo $query_billing;
						   
//$resource_billing = mysql_query($query_billing);
//$keluar_billing = $resource_billing->rowCount();
					   ?>
	    <tbody>
	      <?php	

//$query_billing = "SELECT a.kd_billing,b.nm_program, b.level_program, b.type_program, sum(net_tf+reg_fee+material_cost) as invoiced,a.dt_entry,c.nama_lengkap,a.kd_biodata,a.net_tf, a.reg_fee, a.material_cost,a.kd_class,a.no 
//FROM ves_data.vip_billing a left join ves_data.vip_mst_code_prg b on a.kd_program = b.kd_program 
//left join ves_data.vip_student_data c on a.kd_biodata = c.kd_biodata 
//where a.kd_branch = '$kd_cbg'    group by a.kd_billing order by a.dt_entry desc limit 200" ;
if ($nama_lengkap == 'Debora Mboeik')
	{
$query_billing = "SELECT a.kd_billing,b.nm_program, b.level_program, b.type_program, sum(net_tf+reg_fee+material_cost) as invoiced,a.dt_entry,c.nama_lengkap,a.kd_biodata,a.net_tf, a.reg_fee, a.material_cost,a.kd_class,a.no 
FROM ves_data.vip_billing a left join ves_data.vip_mst_code_prg b on a.kd_program = b.kd_program 
left join ves_data.vip_student_data c on a.kd_biodata = c.kd_biodata 
where a.kd_program like 'FA-%'    group by a.kd_billing order by a.dt_entry desc limit 300";
$params_billing = [];	
	}
else
	{
$query_billing = "SELECT a.kd_billing,b.nm_program, b.level_program, b.type_program, sum(net_tf+reg_fee+material_cost) as invoiced,a.dt_entry,c.nama_lengkap,a.kd_biodata,a.net_tf, a.reg_fee, a.material_cost,a.kd_class,a.no 
FROM ves_data.vip_billing a left join ves_data.vip_mst_code_prg b on a.kd_program = b.kd_program 
left join ves_data.vip_student_data c on a.kd_biodata = c.kd_biodata 
where a.kd_branch = ?    group by a.kd_billing order by a.dt_entry desc limit 100";
$params_billing = [(string) $kd_cbg];	
}



	
$resource_billing = db_query($query_billing, $params_billing);
$keluar_billing = $resource_billing->rowCount();				
if($resource_billing->rowCount() > 0)
	{
	while ($row_billing  =  $resource_billing->fetch(PDO::FETCH_NUM))
		{

		$query_score = "SELECT t.L,t.other, t.S, t.R, t.W,  t.total,t.no FROM ves_inc.tb_acd_history t where t.kd_biodata =  ? order by test_date desc limit 1";
		$resource_score = db_query($query_score, [$row_billing[7]]);
		$keluar_score = $resource_score->rowCount();	
		if($resource_score->rowCount() > 0)
			{
			while ($row_score  =  $resource_score->fetch(PDO::FETCH_NUM))	
				{
				$l = $row_score[0];	
				$st = $row_score[1];	
				$sp = $row_score[2];	
				$r = $row_score[3];	
				$w = $row_score[4];						
				$ttl = $row_score[5];
				$nomor_pt = $row_score[6];						
				$adascore = 1;
				}
			}
		$query_score_mid = "SELECT t.L,t.other, t.S, t.R, t.W,  t.total,t.no FROM ves_data.vip_class_score_profile t where t.kd_biodata =  ? and class_code = ? and jns_test = '2' order by test_date desc limit 1";
		$resource_score_mid = db_query($query_score_mid, [$row_billing[7], $row_billing[11]]);
		$keluar_score_mid = $resource_score_mid->rowCount();	
		if($resource_score_mid->rowCount() > 0)
			{
			while ($row_score_mid  =  $resource_score_mid->fetch(PDO::FETCH_NUM))	
				{
				$l_mid = $row_score_mid[0];	
				$st_mid = $row_score_mid[1];	
				$sp_mid = $row_score_mid[2];	
				$r_mid = $row_score_mid[3];	
				$w_mid = $row_score_mid[4];						
				$ttl_mid = $row_score_mid[5];
				$nomor_mid = $row_score_mid[6];	
				$adascore_mid = 1;
				}
			}
		$query_score_final = "SELECT t.L,t.other, t.S, t.R, t.W,  t.total,t.no FROM ves_data.vip_class_score_profile t where t.kd_biodata =  ? and class_code = ? and jns_test = '3' order by test_date desc limit 1";
		$resource_score_final = db_query($query_score_final, [$row_billing[7], $row_billing[11]]);
		$keluar_score_final = $resource_score_final->rowCount();	
		if($resource_score_final->rowCount() > 0)
			{
			while ($row_score_final  =  $resource_score_final->fetch(PDO::FETCH_NUM))	
				{
				$l_final = $row_score_final[0];	
				$st_final = $row_score_final[1];	
				$sp_final = $row_score_final[2];	
				$r_final = $row_score_final[3];	
				$w_final = $row_score_final[4];						
				$ttl_final = $row_score_final[5];
				$nomor_final = $row_score_final[6];						
				$adascore_final = 1;
				}
			}
		$tgl_tutor = '';	
		$query_tutor = "SELECT date_format(mulai_tm,'%d-%m-%y') FROM ves_data.vip_teacher_schedule where kd_biodata = ? and status_kelas = '50'";

		$resource_tutor = db_query($query_tutor, [$row_billing[7]]);
		$keluar_tutor = $resource_tutor->rowCount();	
		if($resource_tutor->rowCount() > 0)
			{
			while ($row_tutor  =  $resource_tutor->fetch(PDO::FETCH_NUM))	
				{
				if ($tgl_tutor <> ''){$tgl_tutor = "$tgl_tutor<br> $row_tutor[0]";}
				else {$tgl_tutor = $row_tutor[0];}
				}
			}
		$query_tutor = "SELECT date_format(mulai_tm,'%d-%m-%y') FROM ves_data.vip_teacher_schedule where kd_biodata = ? and status_kelas = '60'";
		$resource_tutor = db_query($query_tutor, [$row_billing[7]]);
		$keluar_tutor = $resource_tutor->rowCount();	
		if($resource_tutor->rowCount() > 0)
			{
			while ($row_tutor  =  $resource_tutor->fetch(PDO::FETCH_NUM))	
				{
				if ($tgl_la <> ''){$tgl_la = "$tgl_la<br> $row_tutor[0]";}
				else {$tgl_la = $row_tutor[0];}
				}
			}
		$query_tutor = "SELECT date_format(mulai_tm,'%d-%m-%y') FROM ves_data.vip_teacher_schedule where kd_biodata = ? and status_kelas = '70'";
		$resource_tutor = db_query($query_tutor, [$row_billing[7]]);
		$keluar_tutor = $resource_tutor->rowCount();	
		if($resource_tutor->rowCount() > 0)
			{
			while ($row_tutor  =  $resource_tutor->fetch(PDO::FETCH_NUM))	
				{
				if ($tgl_lc <> ''){$tgl_lc = "$tgl_lc<br> $row_tutor[0]";}
				else {$tgl_lc = $row_tutor[0];}
				}
			}			
			$query_tutor = "SELECT date_format(mulai_tm,'%d-%m-%y') FROM ves_data.vip_teacher_schedule where kd_biodata = ? and status_kelas = '90'";
		$resource_tutor = db_query($query_tutor, [$row_billing[7]]);
		$keluar_tutor = $resource_tutor->rowCount();	
		if($resource_tutor->rowCount() > 0)
			{
			while ($row_tutor  =  $resource_tutor->fetch(PDO::FETCH_NUM))	
				{
				if ($tgl_ext <> ''){$tgl_ext = "$tgl_ext<br> $row_tutor[0]";}
				else {$tgl_ext = $row_tutor[0];}
				}
			}		
			
			
	?>
	      <tr>
	        <td height="14" align=left class="style24"><?php echo e($row_billing[6]) ?><br>
	          <?php echo e($row_billing[11]) ?> <br></td>
	        <td align=center class="style24">&nbsp;</td>
	        <td align=center class="style24"><?php  if ($adascore == 1){?>
				Last Score : 
	          <p>L: <?php echo e($l) ?> St: <?php echo e($st) ?> <br>
	            Sp: <?php echo e($sp) ?> R: <?php echo e($r) ?> W: <?php echo e($w) ?> <br>
	            TTL: <?php echo e($ttl) ?></p>
	          <p>
				    <p><a href="entryact.php?id=<?php echo e(u($row_billing[12])) ?>&t=80">Speaking Test Book</a>
	            <?php } else {?>     <p>
<a href="entryact.php?id=<?php echo e(u($row_billing[12])) ?>&t=80">				
				Speaking Test Book</a> <?php } ?> 
	            </p></td>
	        <td align=center class="style24">&nbsp;</td>
	        <td align=center class="style24"><?php  if ($adascore_mid == 1){?>
	          <p>L: <?php echo e($l_mid) ?> St: <?php echo e($st_mid) ?> <br>
	            Sp: <?php echo e($sp_mid) ?>                R: <?php echo e($r_mid) ?> W: <?php echo e($w_mid) ?> <br>
	            TTL: <?php echo e($ttl_mid) ?></p>
	          <p>
	            <?php } ?></td>
	        <td align=center class="style24"><?php  if ($adascore_final == 1 ){?>
	          <p>L: <?php echo e($l_final) ?> St: <?php echo e($st_final) ?> <br>
	            Sp: <?php echo e($sp_final) ?> R: <?php echo e($r_final) ?> W: <?php echo e($w_final) ?> <br>
	            TTL: <?php echo e($ttl_final) ?></p>
	          <?php } ?>
	            </td>
	        <td align=center class="style24"><p><?php echo $tgl_tutor ?></p>
	      <?php if($row_billing[11] !=''){?>    <p><a href="entryact.php?id=<?php echo e(u($row_billing[12])) ?>&t=50">Book</a></p><?php } ?></td>
	        <td align=center class="style24"><p><?php echo $tgl_la ?></p>
	         <?php if($row_billing[11] !=''){?>     <p><a href="entryact.php?id=<?php echo e(u($row_billing[12])) ?>&t=60">Book</a></p><?php } ?></td>
	        <td align=center class="style24"><p><?php echo $tgl_lc ?></p>
	         <?php if($row_billing[11] !=''){?>     <p><a href="entryact.php?id=<?php echo e(u($row_billing[12])) ?>&t=70">Book</a></p><?php } ?></td>
	        <td align=center class="style24"><p><?php echo $tgl_ext ?></p>
             <?php if($row_billing[11] !=''){?>     <p><a href="entryact.php?id=<?php echo e(u($row_billing[12])) ?>&t=90">Book</a></p><?php } ?></td>
	        </tr>
	      <?php $l = '';$st = '';$sp = '';$r = '';$w = '';$ttl = ''; $adascore = '';$l_mid = '';$st_mid = '';$sp_mid = '';$r_mid = '';
			$w_mid = '';$ttl_mid = ''; $adascore_mid = '';$l_final = '';$st_final = '';$sp_final = '';$r_final = '';$w_final = '';$ttl_final = ''; $adascore_final = '';;		$tgl_tutor = '';$tgl_lc='';}} ?>
        </tbody>
	    <tfoot>
        </tfoot>
    </table>
		</div>	
	  </div>
<a href= "vip_student_list.php?kdcl=<?php echo e(u($kdcl)) ?>&nmprg=<?php echo e(u($nmprg)) ?>&kd_cbg=<?php echo e(u($kd_cbg)) ?>">Add Student</a>
	</div></div>
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
      <!-- Stats tab content -->
      <div class="tab-pane" id="control-sidebar-stats-tab">Stats Tab Content</div>
      <!-- /.tab-pane -->
      <!-- Settings tab content -->
      <div class="tab-pane" id="control-sidebar-settings-tab">
        <form method="post">
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
<?php 
if (in_raw('Search', 'get') !== null) 
	{
			echo "<script type=\"text/javascript\">\n";
			echo "window.loleftcation = ('prestuvip.php');\n";				
			echo "</script>";
	}
?>
	