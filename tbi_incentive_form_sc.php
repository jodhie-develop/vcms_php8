<?php
require_once __DIR__ . "/_lib/bootstrap.php"; auth_require_login(); 
ob_start();
ini_set('memory_limit', '150M'); ?>
<?php 
include __DIR__ . "/conndb.php";
$hari=date("d");
$bulan=date("m");
$tahun=date("Y");
$hari_ini = "$tahun-$bulan-$hari";
$nmsc = in_val('nmsc', 'get');
$da = in_val('da', 'get');
$de = in_val('de', 'get');
$kdc = in_val('kdc', 'get');
$dat = "$da 00:00:00";
$det = "$de 23:00:00";
$query_billing = q_set($__p_query_billing, "SELECT t.no,  t.nama_student, t.keterangan_paket, t.nominal, t.dt_entry, t.approved_by, t.approved_date, t.acknowledge_by, t.acknowledge_date, t.check_by, t.check_date, t.tax_by, t.tax_date, t.tax_persen, t.to_paid_by, t.to_paid_date, t.paid_by, t.paid_date, t.st_reward, t.dt_payment FROM tbi_incentive t where t.nama_sc = ? and st_reward >= 1 and t.dt_payment between ? and ? ", [(string) ($nmsc), (string) ($da), (string) ($de)]);	

$no_urut = 1;		
$resource_billing = db_query_soft($query_billing, $__p_query_billing ?? []);
$keluar_billing = db_num_rows($resource_billing);	

?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>ve_incentive_claim</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="cdnjs/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
</head>
<body onload="window.print();">
<div class="wrapper">
  <div class="row invoice-info">
      <!-- /.col -->
      <div class="col-xs-12 table-responsive">
        <table class="table table-striped">
          <thead>
          <tr>
            <th width="5%" align="center">&nbsp;</th>
            <th colspan="2" align="center"><small>TBI  Incentive Claim Form</small><br>
            <small>Period : <strong><?php echo e($da) ?> to <?php echo e($de) ?></strong></small> </th>
            <th width="25%" align="center">&nbsp;</th>
            <th width="8%" align="center">&nbsp;</th>
            </tr>
          </thead>
          <tbody>
          <tr><small>
            <td>&nbsp;</td>
            <td width="28%">Staff Name</td>
            <td width="34%">: <?php echo e($nmsc) ?> (<?php echo e($keluar_billing) ?> Pax)</td>
            <td>&nbsp;</td>
			  <td>&nbsp;</td></small>
          </tr>
          </tbody>
        </table>
      </div>
    <div class="col-4 invoice-col">
      <address>
      </address>
    </div>	  
      <!-- /.col --><!-- /.col -->
  </div>
  <div class="row invoice-info">

    <!-- /.col --><!-- /.col -->
    <!-- /.col -->
  </div>
  <!-- /.row -->

    <!-- Table row -->
    <div class="row">
      <div class="col-xs-12 table-responsive">
        <table class="table table-striped">
          <thead>
          <tr><small>
            <th width="3%">&nbsp;</th>
            <th width="3%">No</th>
            <th width="14%">Student Name</th>
            <th width="25%">Description</th>
            <th width="15%">Tuition Fee</th>
            <th width="16%">Incentive 
            Amount</th>
            <th width="3%">            Tax Rate</th>
            <th width="21%">Incentive 
            (After Tax)</th>
           </small> </tr>
          </thead>
			
          <tbody>
<?php
	if(num(db_num_rows($resource_billing)) > 0)
	{
	while ($row_billing  =  db_fetch($resource_billing, PDO::FETCH_NUM))
		{
		if ($row_billing[2] =='Test Bakat Minat'){$nominal ='600000';$besaran ='15000';}
		elseif ($row_billing[2] =='TBI - Test Penjurusan + 60 Menit Consult' or $row_billing[2] =='TBI - Test Penjurusan + 30 Menit Consult' or  $row_billing[2] =='TBI - Test Penjurusan'){$nominal ='1475000';$besaran ='100000';}
		elseif ($row_billing[2] =='TBI - Test Penjurusan Basic'){$nominal ='1450000';$besaran ='30000';}
		elseif ($row_billing[2] =='TBI - The Ultimate You'){$nominal ='3150000';$besaran ='80000';}
		elseif ($row_billing[2] =='TBI - Test Penjurusan Premium'){$nominal ='2150000';$besaran ='50000';}	
		elseif ($row_billing[2] =='Coaching Session'){$nominal ='750000';$besaran ='0';}	
		elseif ( $row_billing[2] =='TBI - Addtional Fee'){$besaran ='0';}	
						elseif ($keterangan =='Program Kolaborasi Tes Penjurusan Vista x Tes'){$nominal ='1475000';$besaran ='100000';}		
		
		$net_incentive = num($row_billing[3]) - num((num($row_billing[3])*num((num($row_billing[13])/100))));
	$ttl_besar_reward = num($ttl_besar_reward) +num($row_billing[3]);

					$ttl_net_incentive = num($ttl_net_incentive) + num($net_incentive);
		
//==== ttd nmsc =====nmsc
$query_ttd_nmsc = q_set($__p_query_ttd_nmsc, "SELECT ttd_file FROM ves_data.tb_user where nama_detail = ? and ttd_file <> ''", [(string) ($nm_app)]);	

	$resource_ttd_nmsc = db_query_or_die('errro_1', $query_ttd_nmsc, $__p_query_ttd_nmsc ?? []);
	if (num(db_num_rows($resource_ttd_nmsc)) > 0)
	{
	while ($row_ttd_nmsc=  db_fetch($resource_ttd_nmsc, PDO::FETCH_NUM))
		{		
		$ttd_nm_app = $row_ttd_nmsc[0];	
		}
	}	
//=========	
//==== ttd app =====nmsc
$query_ttd_nmsc = q_set($__p_query_ttd_nmsc, "SELECT ttd_file FROM ves_data.tb_user where nama_detail = ? and ttd_file <> ''", [(string) ($nmsc)]);	

	$resource_ttd_nmsc = db_query_or_die('errro_1', $query_ttd_nmsc, $__p_query_ttd_nmsc ?? []);
	if (num(db_num_rows($resource_ttd_nmsc)) > 0)
	{
	while ($row_ttd_nmsc=  db_fetch($resource_ttd_nmsc, PDO::FETCH_NUM))
		{		
		$ttd_nmsc = $row_ttd_nmsc[0];	
		}
	}	
//=========	
//==== ttd ack =====nmsc
$query_ttd_nmack = q_set($__p_query_ttd_nmack, "SELECT ttd_file FROM ves_data.tb_user where nama_detail = ? and ttd_file <> ''", [(string) ($nm_ack)]);	

	$resource_ttd_nmack = db_query_or_die('errro_1', $query_ttd_nmack, $__p_query_ttd_nmack ?? []);
	if (num(db_num_rows($resource_ttd_nmack)) > 0)
	{
	while ($row_ttd_nmack =  db_fetch($resource_ttd_nmack, PDO::FETCH_NUM))
		{		
		$ttd_nm_ack = $row_ttd_nmack[0];	
		}
	}	
//=========			
//==== ttd check =====nmsc
$query_ttd_nmcheck = q_set($__p_query_ttd_nmcheck, "SELECT ttd_file FROM ves_data.tb_user where nama_detail = ? and ttd_file <> ''", [(string) ($nm_check)]);	

	$resource_ttd_nmcheck = db_query_or_die('errro_1', $query_ttd_nmcheck, $__p_query_ttd_nmcheck ?? []);
	if (num(db_num_rows($resource_ttd_nmcheck)) > 0)
	{
	while ($row_ttd_nmcheck =  db_fetch($resource_ttd_nmcheck, PDO::FETCH_NUM))
		{		
		$ttd_nm_check = $row_ttd_nmcheck[0];	
		}
	}	
//=========		nm_tax	
	$query_ttd_nm_tax = q_set($__p_query_ttd_nm_tax, "SELECT ttd_file FROM ves_data.tb_user where nama_detail = ? and ttd_file <> ''", [(string) ($nm_tax)]);	

	$resource_ttd_nm_tax = db_query_or_die('errro_1', $query_ttd_nm_tax, $__p_query_ttd_nm_tax ?? []);
	if (num(db_num_rows($resource_ttd_nm_tax)) > 0)
	{
	while ($row_ttd_nm_tax=  db_fetch($resource_ttd_nm_tax, PDO::FETCH_NUM))
		{		
		$ttd_nm_tax = $row_ttd_nm_tax[0];	
		}
	}	
//======================
	
//==== ttd tax =====
	$query_ttd_tax = q_set($__p_query_ttd_tax, "SELECT ttd_file FROM ves_data.tb_user where nama_detail = ? and ttd_file <> ''", [(string) ($tax_by)]);	
	$resource_ttd_tax = db_query_or_die('errro_1', $query_ttd_tax, $__p_query_ttd_tax ?? []);
	if (num(db_num_rows($resource_ttd_tax)) > 0)
	{
	while ($row_ttd_tax=  db_fetch($resource_ttd_tax, PDO::FETCH_NUM))
		{		
		$ttd_tax = $row_ttd_tax[0];	
		}
	}		
//======================
	
//==== ttd paid  =====
	$query_ttd_topaid = q_set($__p_query_ttd_topaid, "SELECT ttd_file FROM ves_data.tb_user where nama_detail = ? and ttd_file <> ''", [(string) ($topaid_by)]);	
	$resource_ttd_topaid = db_query_or_die('errro_1', $query_ttd_topaid, $__p_query_ttd_topaid ?? []);
	if (num(db_num_rows($resource_ttd_topaid)) > 0)
	{
	while ($row_ttd_topaid=  db_fetch($resource_ttd_topaid, PDO::FETCH_NUM))
		{		
		$ttd_topaid = $row_ttd_topaid[0];	
		}
	}	

//======================		
		
	?>

          <tr>
            <td>&nbsp;</td>
            <td><small><span class="style24"><?php echo e($no_urut) ?></span></small></td>
            <td><small><span class="style24"><?php echo e($row_billing[1]) ?><br>
            <?php echo e($row_billing[20]) ?></td>
            <td><small><span class="style24"><?php echo e($row_billing[2]) ?></span></small></td>
            <td><small><span class="style24"><?php echo  number_format(num(($nominal)),0,".",".")  ?></span></small></td>
            <td><small><span class="style24"><?php echo  number_format(num(($row_billing[3])),0,".",".") ?></span></small></td>
            <td><small><span class="style24"><?php echo e($row_billing[13]) ?> %</span></small></td>
            <td><small><span class="style24"><?php echo  number_format(num($net_incentive),0,".",".") ?></span></small></td>
            </tr>
             <?php $no_urut = num($no_urut) +1;$status_tampil='';								$st_reward =0; }} ?>			  			  
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td colspan="2" align="right"	><strong>TOTAL Incentive (After Tax) :</strong></td>
            <td align="right"	>&nbsp;</td>
            <td><strong><?php echo  number_format(num($ttl_net_incentive),0,".",".") ?></strong></td>
            </tr>
          </tbody>
        </table>
      </div>
      <!-- /.col -->
  </div>
    <!-- /.row -->
    <div class="row">
      <!-- accepted payments column --><!-- /.col -->
      <div class="col-xs-12">
        <div class="table-responsive">
          <table class="table">
            <tr>
              <th width="10%" >&nbsp;</th>
              <th width="15%" >&nbsp;</th>
              <th width="15%" >&nbsp;</th>
              <th width="15%">&nbsp;</th>
              <th width="15%">&nbsp;</th>
              <th width="15%">&nbsp;</th>
              <th width="20%">&nbsp;</th>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <th>&nbsp;</th>
              <th><small>Proposed By</small></th>
              <th><small>Approved By</small></th>
              <th><small>Acknowledge By</small></th>
              <th><small>Check By</small></th>
              <th><small>Tax By</small></th>
              <th><small>To be Paid By</small></th>
              <td>&nbsp;</td>
            </tr>
            
            <tr>
              <th >&nbsp;</th>
              <th ><?php if ($ttd_nmsc !=''){?><img src="<?php echo e($ttd_nmsc)  ?>" width="83" height="40"><?php } ?></th>
              <th ><?php if ($ttd_nm_app !=''){?><img src="<?php echo e($$ttd_nm_app)  ?>" width="83" height="40"><?php } ?></th>
              <th><?php if ($ttd_nm_ack !=''){?><span class="qty"><img src="<?php echo e($ttd_nm_ack)  ?>" width="83" height="40"></span><?php } ?></th>
              <th><?php if ($ttd_nm_check !=''){?><span class="qty"><img src="<?php echo e($ttd_nm_check)  ?>" width="83" height="40"></span><?php } ?></th>
              <th><?php if ($ttd_nm_tax !=''){?><span class="qty"><img src="<?php echo e($ttd_nm_tax)  ?>" width="83" height="40"></span><?php } ?></th>
              <th><?php if ($ttd_topaid !=''){?><span class="qty"><img src="<?php echo e($ttd_topaid)  ?>" width="83" height="40"></span><?php } ?></th>
              <td>&nbsp;</td>
            </tr>
            
            <tr>
              <th height="22" >&nbsp;</th>
              <th ><small><?php echo e($nmsc) ?><br>
              <?php echo e($propose_date) ?></small></th>
              <th ><small><?php echo e($nm_app) ?><br>
              <?php echo e($approve_date) ?></small></th>
              <th><small><?php echo e($ttd_nm_ack) ?><br>
              <?php echo e($ack_date) ?></small></th>
              <th><small><?php echo e($nm_check)	 ?><br>
              <?php echo e($checked_date) ?></small></th>
              <th><small><?php echo e($nm_tax) ?><br>
              <?php echo e($tax_date) ?></small></th>
              <th><small><?php echo e($topaid_by) ?><br>
              <?php echo e($topaid_date) ?> </small></th>
              <td>&nbsp;</td>
            </tr>
          </table>
        </div>
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->

  <!-- /.content -->
</div>
<!-- ./wrapper -->
</body>
</html>
