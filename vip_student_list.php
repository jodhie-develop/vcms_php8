<?php
include __DIR__ . "/conndb.php";
include __DIR__ . "/profiledata.php";
include __DIR__ . "/atas.php";
include __DIR__ . "/left.php";
// Variabel tampilan yang tidak selalu diisi (versi lama: kosong).
$mbayar = '';$adascore = '';	
$hari=date("d");
$bulan=date("m");
$tahun=date("Y");
$hari_ini = "$tahun-$bulan-$hari";
$date_start = in_date('date_start', '', 'get');
$date_end = in_date('date_end', '', 'get');
if ($date_start ==''){$date_start = "2023-01-01";}
if ($date_end ==''){$date_end = $hari_ini;}


$kd_cbg = in_str('kd_cbg', 20, 'get');
$kdcb = in_str('kdcb', 20, 'get');
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
if ($kd_cbg == 'Online'){$kd_cbg = 100;}
if ($kd_cbg == 'Online West Sby'){$kd_cbg = 104;}
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
if ($kd_cbg ==9){$cabang = 'Bandung TBI';}
if ($kd_cbg ==10){$cabang = 'Bali TBI';}
if ($kd_cbg ==100){$cabang = 'Online';}
if ($kd_cbg ==104){$cabang = 'Online West Sby';}
$nama_lengkap = $_SESSION['nama_lengkap'];
$nama_depan = $_SESSION['nama_depan'];
$kd_cbg = $_SESSION['kd_branch'];
$posisi = $_SESSION['posisi']; 
$kd_staff = $_SESSION['kd_staff'] ;
$kdcl = in_str('kdcl', 45, 'get');
$kdprg = in_str('kdprg', 45, 'get');
$nmprg = in_str('nmprg', 45, 'get');

$pilihan_sc = in_str('pilihan_sc', 45, 'get');
if ($pilihan_sc ==''){$pilihan_sc = 'All Leads';}
echo e($kdcb); // tampilan debug versi lama, kini di-escape
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

  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="row">
        <div class="col-xs-12">
          <!-- /.box -->
<div class="box box-warning">          
	<div class="box-body">
	  <div class="col-md-12">
		<div class="form-group">
		  <label>Class Code : <?php echo e($kdcl) ?></label>
		  
          <input type="text" name="kdprg" id="textfield" value="<?php echo e($kdprg) ?>" hidden></input>
		  <input type="text" name="kdcbg" id="textfield2" value="<?php echo e($kd_cbg) ?>" hidden="" >
		</div>	
		</div>
	  <table width="100%" class="table table-bordered table-striped" id="example12">
	    <thead>
	      <tr>
	        <td width=17% height="14" align=center >Student Name</td>
	        <td width="12%" align=center >Placement Score</td>
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
if ($kdcb =='100') 
{
$query_billing = "SELECT a.kd_billing,b.nm_program, b.level_program, b.type_program, sum(net_tf+reg_fee+material_cost) as invoiced,a.dt_entry,c.nama_lengkap,a.kd_biodata,a.net_tf, a.reg_fee, a.material_cost, c.idkey FROM ves_data.vip_billing a left join ves_data.vip_mst_code_prg b on a.kd_program = b.kd_program left join ves_data.vip_student_data c on a.kd_biodata = c.kd_biodata where a.kd_class = ?  group by a.kd_billing order by a.dt_entry desc";
$params_billing = [$kdcl];
}
elseif ($kdcb =='351') 
{
$query_billing = "SELECT a.kd_billing,b.nm_program, b.level_program, b.type_program, sum(net_tf+reg_fee+material_cost) as invoiced,a.dt_entry,c.nama_lengkap,a.kd_biodata,a.net_tf, a.reg_fee, a.material_cost, c.idkey FROM ves_data.vip_billing a left join ves_data.vip_mst_code_prg b on a.kd_program = b.kd_program left join ves_data.vip_student_data c on a.kd_biodata = c.kd_biodata where (a.kd_branch = ? or a.kd_branch = '00') and a.kd_class = ?  group by a.kd_billing order by a.dt_entry desc";
$params_billing = [$kdcb, $kdcl];
}			  
else
{
$query_billing = "SELECT a.kd_billing,b.nm_program, b.level_program, b.type_program, sum(net_tf+reg_fee+material_cost) as invoiced,a.dt_entry,c.nama_lengkap,a.kd_biodata,a.net_tf, a.reg_fee, a.material_cost, c.idkey FROM ves_data.vip_billing a left join ves_data.vip_mst_code_prg b on a.kd_program = b.kd_program left join ves_data.vip_student_data c on a.kd_biodata = c.kd_biodata where a.kd_branch = ? and a.kd_class = ?  group by a.kd_billing order by a.dt_entry desc";
$params_billing = [$kdcb, $kdcl];
}
	  
$resource_billing = db_query($query_billing, $params_billing);
$keluar_billing = $resource_billing->rowCount();				
if($resource_billing->rowCount() > 0)
	{
	while ($row_billing  =  $resource_billing->fetch(PDO::FETCH_NUM))
		{
$l = '';$st = '';$sp = '';$r = '';$w = '';$ttl = ''; $adascore = '';
		$query_score = "SELECT t.L,t.other, t.S, t.R, t.W,  t.total FROM ves_inc.tb_acd_history t where t.kd_biodata =  ? order by test_date desc limit 1";
		$resource_score = db_query($query_score, [$row_billing[9]]);
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
				$adascore = 1;
				}
			}	
		$query_bayar = "SELECT sum(amount) as ttl  FROM ves_data.vip_billing_payment where kd_billing = ? and id_receipt <> ''";
		$resource_bayar = db_query($query_bayar, [$row_billing[0]]);
		$keluar_bayar = $resource_bayar->rowCount();	
		if($resource_bayar->rowCount() > 0)
			{
			while ($row_bayar  =  $resource_bayar->fetch(PDO::FETCH_NUM))	
				{
				$mbayar = $row_bayar[0];	
				}
			}		
	?>
	      <tr>
	        <td height="14" align=left class="style24"><?php echo e($row_billing[6]) ?><br>
	          <?php //==== admin  
				if($posisi =="Admin")
				{
				?>
	          <a href="vipbillreceipt.php?idb=<?php echo e(u($row_billing[0])) ?>&kdb=<?php echo e(u($row_billing[7])) ?>&st=1">
	            <?php } else { //non admin ?>
	            <a href="vipbill.php?idb=<?php echo e(u($row_billing[0])) ?>&kdb=<?php echo e(u($row_billing[7])) ?>&st=1">
	            <?php } ?>
	            <?php echo e($row_billing[0]) ?></a><br>
                idkey: 
                <?php echo e($row_billing[13]) ?></td>
	        <td align=center class="style24"><?php  if ($adascore == 1){?>
	          <p>L: <?php echo e($l) ?> St: <?php echo e($st) ?> Sp: <?php echo e($sp) ?> <br>
	            R: <?php echo e($r) ?> W: <?php echo e($w) ?> TTL: <?php echo e($ttl) ?></p>
	          <p>
	            <?php }?>
	          </p></td>
          </tr>
	      <?php 				$l = '';$st = '';$sp = '';$r = '';$w = '';$ttl = ''; $adascore = '';}} ?>
        </tbody>
	    <tfoot>
        </tfoot>
      </table>
	</div></div>
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
	            <td width=17% height="14" align=center >Student Name</td>
	            <td width="20%" align=center >Program</td>
	            <td width="15%" align=center >Payment</td>
	            <td width="12%" align=center >Placement Score</td>
	            <td width="12%" align=center >Add</td>
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
if($nmprg !='LCSTBY')
	{
	if ($kdcb =='100') 
		{	
		$query_billing = "SELECT a.kd_billing, b.nm_program, b.level_program, b.type_program, sum(net_tf+reg_fee+material_cost) as invoiced,a.dt_entry,c.nama_lengkap, a.kd_billing, a.kd_billing,a.kd_biodata,a.net_tf, a.reg_fee, a.material_cost, c.idkey FROM ves_data.vip_billing a left join ves_data.vip_mst_code_prg b on a.kd_program = b.kd_program left join ves_data.vip_student_data c on a.kd_biodata = c.kd_biodata where  a.kd_class = ''  group by a.kd_billing order by a.dt_entry desc";
$params_billing = [];		}
	elseif ($kdcb =='351') 
		{	
		$query_billing = "SELECT a.kd_billing, b.nm_program, b.level_program, b.type_program, sum(net_tf+reg_fee+material_cost) as invoiced,a.dt_entry,c.nama_lengkap, a.kd_billing, a.kd_billing,a.kd_biodata,a.net_tf, a.reg_fee, a.material_cost, c.idkey FROM ves_data.vip_billing a left join ves_data.vip_mst_code_prg b on a.kd_program = b.kd_program left join ves_data.vip_student_data c on a.kd_biodata = c.kd_biodata where (a.kd_branch = '00' or a.kd_branch = '351')  and b.kd_program = ? and a.kd_class = ''  group by a.kd_billing order by a.dt_entry desc";
$params_billing = [$nmprg];	}
		else
		{
		
		//$query_billing = "SELECT a.kd_billing, b.nm_program, b.level_program, b.type_program, sum(net_tf+reg_fee+material_cost) as invoiced,a.dt_entry,c.nama_lengkap, a.kd_billing, a.kd_billing,a.kd_biodata,a.net_tf, a.reg_fee, a.material_cost, c.idkey FROM ves_data.vip_billing a left join ves_data.vip_mst_code_prg b on a.kd_program = b.kd_program left join ves_data.vip_student_data c on a.kd_biodata = c.kd_biodata where a.kd_branch = '$kdcb'  and b.kd_program = '$nmprg' and a.kd_class = ''  group by a.kd_billing order by a.dt_entry desc" ;
		$query_billing = "SELECT a.kd_billing, b.nm_program, b.level_program, b.type_program, sum(net_tf+reg_fee+material_cost) as invoiced,a.dt_entry,c.nama_lengkap, a.kd_billing, a.kd_billing,a.kd_biodata,a.net_tf, a.reg_fee, a.material_cost, c.idkey FROM ves_data.vip_billing a left join ves_data.vip_mst_code_prg b on a.kd_program = b.kd_program left join ves_data.vip_student_data c on a.kd_biodata = c.kd_biodata where  b.kd_program = ? and a.kd_class = ''  group by a.kd_billing order by a.dt_entry desc";
$params_billing = [$nmprg];			

		}	
	}
else
	{

			$query_billing = "SELECT a.kd_billing, b.nm_program, b.level_program, b.type_program, sum(net_tf+reg_fee+material_cost) as invoiced,a.dt_entry,c.nama_lengkap, a.kd_billing, a.kd_billing,a.kd_biodata,a.net_tf, a.reg_fee, a.material_cost, c.idkey FROM ves_data.vip_billing a left join ves_data.vip_mst_code_prg b on a.kd_program = b.kd_program left join ves_data.vip_student_data c on a.kd_biodata = c.kd_biodata where  a.kd_program = 'IETTPP'  group by a.kd_billing order by a.dt_entry desc";
$params_billing = [];
	
	}

$resource_billing = db_query($query_billing, $params_billing);
$keluar_billing = $resource_billing->rowCount();				
if($resource_billing->rowCount() > 0)
	{
	while ($row_billing  =  $resource_billing->fetch(PDO::FETCH_NUM))
		{

		$query_score = "SELECT t.L,t.other, t.S, t.R, t.W,  t.total FROM ves_data.vip_class_score_profile t where jns_test = 1 and t.kd_biodata =  ? order by test_date desc limit 1";

		$resource_score = db_query($query_score, [$row_billing[9]]);
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
				$adascore = 1;
				}
			}	
	?> 
	          <tr>
	            <td height="14" align=left class="style24"><?php echo e($row_billing[6]) ?><br>
	              <?php //==== admin  
				if($posisi =="Admin")
				{
				?>
                  <a href="vipbillreceipt.php?idb=<?php echo e(u($row_billing[0])) ?>&kdb=<?php echo e(u($row_billing[9])) ?>&st=1">
                  <?php } else { //non admin ?>
                  <a href="vipbill.php?idb=<?php echo e(u($row_billing[0])) ?>&kdb=<?php echo e(u($row_billing[9])) ?>&st=1">
                  <?php } ?>
                <?php echo e($row_billing[0]) ?></a><br>
                idkey: 
                <?php echo e($row_billing[13]) ?></td>
	            <td align=center class="style24"><?php echo e($row_billing[1]) ?> <?php echo e($row_billing[2]) ?> - <?php echo e($row_billing[3]) ?></td>
	            <td align=center class="style24">Invoice : <?php echo  number_format(((float) $row_billing[10] + (float) $row_billing[11] + (float) $row_billing[12]),0,".",".")  ?><br>
                Paid : <?php echo  number_format((float) $mbayar,0,".",".") ?></td>
	            <td align=center class="style24">
              <?php  if ($adascore == 1){?>
               <p>L: <?php echo e($l) ?>    St:   <?php echo e($st) ?> Sp: <?php echo e($sp) ?> <br>
	              R: <?php echo e($r) ?> W: <?php echo e($w) ?> TTL: <?php echo e($ttl) ?></p>
                <p> <?php }?>
				<?php if ($posisi !='SC'){?>	
                <a href="vip_score.php ?>" 
target="popup" 
onclick="window.open('vip_score.php?kdb=<?php echo e(u($row_billing[9])) ?>&t=1&kdcl=<?php echo e(u($kdcl)) ?>','popup','width=1000,height=800'); return false;">Add Score</a></p>
<?php } ?>				  </td>
	            <td align=center class="style24">
	            <?php  if ($adascore == 1){?>
	            <a href="vip_add.php?kdb=<?php echo e(u($row_billing[0])) ?>&kdcbg=<?php echo e(u($kd_cbg)) ?>&kdcl=<?php echo e(u($kdcl)) ?>&lvl=<?php echo e(u($row_billing[2])) ?>" 
target="popup" 
onclick="window.open('vip_add.php?kdb=<?php echo e(u($row_billing[0])) ?>&kdcbg=<?php echo e(u($kd_cbg)) ?>&lvl=<?php echo e(u($row_billing[2])) ?>&kdcl=<?php echo e(u($kdcl)) ?>','popup','width=1000,height=800'); return false;">Add</a>
	            <?php } else {?>
	            Add
	            <?php } ?>
	            </td>
              </tr>
              <?php 			$l = '';$st = '';$sp = '';$r = '';$w = '';$ttl = ''; $adascore = ''; }} ?>
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
control-sidebar -->
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
	