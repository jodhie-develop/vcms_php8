<?php
require_once __DIR__ . "/../_lib/bootstrap.php"; csrf_guard_get(); auth_require_login(); 
include __DIR__ . "/../conndb.php";
include __DIR__ . "/../profiledata.php";
 include __DIR__ . "/../atas.php";
include __DIR__ . "/left.php";
$hari=date("d");
$bulan=date("m");
$tahun=date("Y");
$hari_ini = "$tahun-$bulan-$hari";
$date_start = in_val('st', 'get');
$date_end = in_val('en', 'get');

$url_asli="http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];

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

  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
	  	       <form name="form1" method="GET" action="#">
  <section class="content-header">
    <h1>VE Incentive List Print<br>
    </h1>
    <div class="col-md-3">
      <div class="form-group">
        <label>Period<br>
        </label>
      </div>
      <div class="form-group"><small>
      <input type="date" format="dd/MM/yyyy" name="date_start" id="date_start" value="<?php echo e($date_start)  ?>" readonly>
        </small>to <small>
        <input type="date" name="date_end" id="date_end" value="<?php echo e($date_end)  ?>" readonly >
      </small></div>		
    </div>
  </section>
				   </form> 
	  	       <form name="form1" method="POST" action="#"><?php echo csrf_field(); ?>

  <!-- Main content -->
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
		  <label>VE Incentive Claim List </label>
		</div>				
	  </div>
	  <div class="col-md-12">
	    <div class="form-group">
	      	      <table width="100%" class="table table-bordered table-striped" id="example1">
	        <thead>
	          <tr>
	            <td width=1% height="14" align=center >No</td>
	            <td width=12% align=center >Consultant Name</td>
	            <td width="10%" align=center >Pax</td>
	            <td width="10%" align=center >Net Tuition Fee</td>
	            <td width="10%" align=center >Paid</td>
	            <td width="5%" align=center >Outstanding</td>
	            <td width="11%" align=center >Incentive (Before Tax)</td>
	            <td width="9%" align=center >Incentive (After Tax)</td>
	            <td width="4%" align=center >Action</td>
              </tr>
            </thead>
<?php


	$query_billing = q_set($__p_query_billing, "sELECT a.nama_sc, a.kd_branch, a.kd_billing, sum(net_tf),sum(nominal) FROM ves_data.ve_incentive a\r
left join vip_billing b on a.kd_biodata = b.kd_biodata and a.kelas = b.kd_class\r
 where st_reward = 8 and start_kelas between ? and ? group by nama_sc, a.kd_branch", [(string) ($date_start) . " 00:00", (string) ($date_end) . " 23:00"]);

$resource_billing = db_query_soft($query_billing, $__p_query_billing ?? []);
$keluar_billing = db_num_rows($resource_billing);				
if(num(db_num_rows($resource_billing)) > 0)
	{		
	$no_urut = 1;$a = 0;
	while ($row_billing  =  db_fetch($resource_billing, PDO::FETCH_NUM))
		{
		$nama_sc = $row_billing['0'];		
		if(num($row_billing[1])==1){$nama_cabang = 'East Sby';}
		elseif(num($row_billing[1])==2){$nama_cabang = 'West Sby';}
		elseif(num($row_billing[1])==3){$nama_cabang = 'Denpasar';}
		elseif(num($row_billing[1])==4){$nama_cabang = 'South Jkt';}
		elseif(num($row_billing[1])==5){$nama_cabang = 'North Jkt';}
		elseif(num($row_billing[1])==6){$nama_cabang = 'West Jkt';}
		elseif(num($row_billing[1])==7){$nama_cabang = 'Bandung';}
		elseif(num($row_billing[1])==8){$nama_cabang = 'Malang';}
		elseif(num($row_billing[1])==11){$nama_cabang = 'PIK';}
		elseif(num($row_billing[1])==12){$nama_cabang = 'Serpong';}
		elseif(num($row_billing[1])==14){$nama_cabang = 'Medan';}		
		$no_incentive = $row_billing[10];
		$_POST['no_incentive'.$a]= $no_incentive;

	//===hitung net_tf dan bayar
$query_net = q_set($__p_query_net, "sELECT sum(amount) FROM ves_data.ve_incentive a\r
left join ves_data.vip_billing_payment c on a.kd_billing = c.kd_billing\r
where nama_sc = ? and a.kd_branch = ?  and st_reward = 8 and start_kelas between ? and ?  and id_receipt <> '' and\r
(jns_payment = 'Full Payment' or jns_payment = 'Installment 1' or jns_payment = 'Installment 2' or jns_payment = 'Installment 3' or jns_payment = 'Down Payment') ", [(string) ($nama_sc), (string) ($row_billing[1]), (string) ($date_start), (string) ($date_end)]);

	$resource_net = db_query_soft($query_net, $__p_query_net ?? []);
	if(num(db_num_rows($resource_net)) > 0)
		{
		while ($row_net  =  db_fetch($resource_net, PDO::FETCH_NUM))
			{
			$ttl_bayar = $row_net[0];
			}		
		}	
		
	//after tax
	 	
$query_net_pajak = q_set($__p_query_net_pajak, "sELECT a.nominal, tax_persen FROM ves_data.ve_incentive a where nama_sc = ? and a.kd_branch = ? and st_reward = 8 and start_kelas between  ? and ? ", [(string) ($nama_sc), (string) ($row_billing[1]), (string) ($date_start), (string) ($date_end)]);

	$resource_net_pajak = db_query_soft($query_net_pajak, $__p_query_net_pajak ?? []);
	if(num(db_num_rows($resource_net_pajak)) > 0)
		{
		while ($row_net_pajak  =  db_fetch($resource_net_pajak, PDO::FETCH_NUM))
			{
			$sblm_pajak = $row_net_pajak[0];
			$bsr_pajak = $row_net_pajak[1];
			$after_pajak = num($sblm_pajak) - num((num($sblm_pajak) * num((num($bsr_pajak)/100))));
			$ttl_after_pajak = num($ttl_after_pajak) + num($after_pajak);
			}		
		}	
	//		
		


	?>					  
	        <tbody>
          
	          <tr>
	            <td height="14" align=center class="style24"><?php echo e($no_urut) ?></td>
	            <td align=left class="style24">
	            <?php echo e($nama_sc) ?><br>
	            <?php echo e($nama_cabang) ?><br></td>
	            <td align=center class="style24"><?php echo e($row_billing[2]) ?></td>
	            <td align=center class="style24"><?php echo  number_format(num(($row_billing[3])),0,".",".")  ?></td>
	            <td align=center class="style24"><?php echo  number_format(num(($ttl_bayar)),0,".",".")  ?></td>
	            <td align=center class="style24"><?php echo  number_format(num((num($row_billing[3]) - num($ttl_bayar))),0,".",".")  ?></td>
	            <td align=center class="style24"><?php echo  number_format(num(($row_billing[4])),0,".",".") ?></td>
	            <td align=center class="style24"><?php echo  number_format(num(($ttl_after_pajak)),0,".",".") ?></td>
	            <td align=center class="style24"><a href="#" 
target="popup" 
onclick="window.open('../ve_incentive_form.php?nmsc=<?php echo e(u($nama_sc)) ?>&da=<?php echo e(u($date_start)) ?>&de=<?php echo e(u($date_end)) ?>&kdc=<?php echo e(u($row_billing[1])) ?>','popup','width=1000,height=800'); return false;">Print</a></td>
              </tr>
             <?php $no_urut = num($no_urut) +1;$a = num($a) + 1;$status_tampil='';$besar_persen='';	$ttl_after_pajak='';$bsr_pajak='';					$st_reward =0; } }?>

<tr>
	            <td height="14" align=center class="style24">&nbsp;</td>
	            <td align=center class="style24">&nbsp;</td>
	            <td align=center class="style24">&nbsp;</td>
	            <td align=center class="style24">&nbsp;</td>
	            <td align=center class="style24">&nbsp;</td>
	            <td align=center class="style24">&nbsp;</td>
	            <td align=center class="style24">&nbsp;</td>
	            <td align=center class="style24">&nbsp;</td>
	            <td align=center bgcolor="#A4BAF7" class="style24">&nbsp;</td>
              </tr>				
				    </tbody>
            <tfoot>
            </tfoot>
          </table>
        </div>
            <!-- /.box-body -->
      </div>
<div class="col-md-12">
    <div class="form-group">
      <label>Start Class Period : <?php echo e($date_start) ?> to <?php echo e($date_end) ?>
		</label>
    </div>
  </div>
<br>
	  
<div class="col-md-1">
  <div class="pad box-pane-right bg-yellow">
	<div class="form-group">
      <label>To be Claim <br>
 Rp. <?php echo  number_format(num($ttl_enable_to_claim),0,".",".") ?> 
		</label>
	 </div></div>
</div>
<div class="col-md-1">
 <div class="pad box-pane-right bg-blue">	
  <div class="form-group">
    <label>Proposed <br>
      Rp. <?php echo  number_format(num($ttl_proposed_to_claim),0,".",".") ?> </label>
  </div></div>
</div>
<div class="col-md-1">
<div class="pad box-pane-right bg-gray">		
  <div class="form-group">
    <label>Approved <br>
      Rp. <?php echo  number_format(num($ttl_claim_approved),0,".",".") ?></label>
	</div></div>
</div>
<div class="col-md-1">
  <div class="pad box-pane-right bg-teal">
    <div class="form-group">
      <label>Acknowledge <br>
        Rp. <?php echo  number_format(num($ttl_acknowledge),0,".",".") ?></label>
    </div>
  </div>
</div>
<div class="col-md-1">
  <div class="pad box-pane-right bg-red-gradient">		
  <div class="form-group">
    <label>Correction <br>
      Rp. <?php echo  number_format(num($ttl_correction),0,".",".") ?></label>
	</div></div>
</div>
<div class="col-md-1">
  <div class="pad box-pane-right bg-fuchsia-active">
    <div class="form-group">
      <label>Checked<br>
        Rp. <?php echo  number_format(num($ttl_checked),0,".",".") ?></label>
    </div>
  </div>
</div>
<div class="col-md-1">
  <div class="pad box-pane-right bg-teal-gradient">
    <div class="form-group">
      <label>Tax <br>
        Rp. <?php echo  number_format(num($ttl_tax),0,".",".") ?></label>
    </div>
  </div>
</div>
<div class="col-md-1">
  <div class="pad box-pane-right bg-green">		
  <div class="form-group">
    <label>Paid <br>
      Rp. <?php echo  number_format(num($ttl_paid),0,".",".") ?></label>
	</div></div>
</div>
<div class="col-md-1">
  <div class="pad box-pane-right bg-purple-gradient">
    <div class="form-group">
		<label>Print Form</label>
    </div>
  </div>
</div>				   
  
<!-- /.box -->
  </div>
        <!-- /.col -->
  </div>
      <!-- /.row --><!-- /.content -->
<?php	  
if (isset($_POST['Submit'])) 
{
		$url_asli="http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];

$hari=date("d");
$bulan=date("m");
$tahun=date("Y");
$thn=date("y");	
$hari_ini = "$tahun-$bulan-$hari";
	$batas = $a;
	for($a=0;$a<=$batas;$a++) 
		{
		$check = $_POST['check_'.$a];
		$no_incentive = $_POST['no_incentive'.$a];


		if( empty($_POST['check_'.$a]) ){$check = 0;}else{$check = 1;}	
		if (num($check)==1)
			{
		if(num($no_incentive) >= 0 and num($no_incentive) <= 9){$nomor_po = "000$no_incentive";$nomor_po = "$thn$bulan$nomor_po";}
		elseif(num($no_incentive) >= 10 and num($no_incentive) <= 99){$nomor_po = "00$no_incentive";$nomor_po = "$thn$bulan$nomor_po";}
		elseif(num($no_incentive) >= 100 and num($no_incentive) <= 999){$nomor_po = "0$no_incentive";$nomor_po = "$thn$bulan$nomor_po";}
		elseif(num($no_incentive) >= 1000 ){$nomor_po = "$tahun$bulan$no_incentive";}			
			$query = q_set($__p_query, "update ve_incentive set st_reward = 5,check_by = ? , check_date = ? ,nomor_po =? where no = ? ", [(string) ($nama_lengkap), (string) ($hari_ini), "2" . (string) ($nomor_po), (string) ($no_incentive)]);			
			$resource_check= db_query_or_die('errro_visitor1', $query, $__p_query ?? []);
			}
		}
				echo "<script type=\"text/javascript\">\n";
				echo "window.location = ('" . e($url_asli) . "');\n";
				echo "</script>";
}
?>	
<?php	  
if (isset($_POST['Paid'])) 
{
		$url_asli="http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];

$hari=date("d");
$bulan=date("m");
$tahun=date("Y");
$hari_ini = "$tahun-$bulan-$hari";
	$batas = $a;
	for($a=0;$a<=$batas;$a++) 
		{
		$paid = $_POST['paid_'.$a];
		$no_incentive = $_POST['no_incentive'.$a];
		if( empty($_POST['paid_'.$a]) ){$check_paid = 0;}else{$check_paid = 1;}	
		if (num($check_paid)==1)
			{
			$query = q_set($__p_query, "update ve_incentive set st_reward = 8,paid_by = ? , paid_date = ? where no = ? ", [(string) ($nama_lengkap), (string) ($hari_ini), (string) ($no_incentive)]);
			$resource_check= db_query_or_die('errro_visitor1', $query, $__p_query ?? []);
			}
		}
				echo "<script type=\"text/javascript\">\n";
				echo "window.location = ('" . e($url_asli) . "');\n";
				echo "</script>";
}
?>		
	</form> 
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

