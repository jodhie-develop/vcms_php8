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
$query_billing = q_set($__p_query_billing, "SELECT b.nama_lengkap, a.kd_billing, a.nama_sc, a.kelas, nm_program, type_program , private_pax, net_tf,a.nominal, st_reward, date_format(a.dt_entry,'%d %b %y'), approved_by,\r
acknowledge_by,check_by,date_format(check_date,'%d %b %y'), tax_by, date_format(tax_date,'%d %b %y'),tax_persen, paid_by, date_format(paid_date,'%d %b %y'),date_format(approved_date,'%d %b %y'),\r
date_format(acknowledge_date,'%d %b %y') FROM ves_data.ve_incentive a left join vip_billing c on a.kd_biodata = c.kd_biodata and  a.kelas = c.kd_class left join\r
vip_student_data b on a.kd_biodata = b.kd_biodata left join vip_mst_code_prg d on c.kd_program = d.kd_program  where st_reward >=1   and nama_sc = ? and start_kelas between ? and  ? and (nm_program <> 'CLINIC' and c.kd_program <> 'WSCLINL') and st_reward < 8 group by a.kd_billing order by approved_by", [(string) ($nmsc), (string) ($dat), (string) ($det)]);	

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

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

</head>
<body onload="window.print();">
<div class="wrapper">
  <!-- Main content -->

    <!-- title row --><!-- info row -->
  <div class="row invoice-info">
      <!-- /.col -->
      <div class="col-xs-12 table-responsive">
        <table class="table table-striped">
          <thead>
          <tr>
            <th width="4%" align="center">&nbsp;</th>
            <th colspan="2" align="center"><small>VE Incentive Claim Form</small><br>
            <small>Period : <strong><?php echo e($da) ?> to <?php echo e($de) ?></strong></small> </th>
            <th width="25%" align="center">&nbsp;</th>
            <th width="7%" align="center">&nbsp;</th>
            </tr>
          </thead>
          <tbody>
          <tr><small>
            <td>&nbsp;</td>
            <td width="9%">Staff Name</td>
            <td width="52%">: <?php echo e($nmsc) ?> (<?php echo e($keluar_billing) ?> Pax)</td>
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
            <th width="14%">Class Program</th>
            <th width="15%">Net Tuition Fee</th>
            <th width="11%">Paid TF</th>
            <th width="16%">Incentive 
            Amount</th>
            <th width="3%">            Tax Rate</th>
            <th width="21%">Incentive 
            (After Tax)</th>
           </small> </tr>
          </thead>
			
          <tbody>
<?php
	$no_sign = "e_sign/speciment/no_sign.png";
//	$no_sign = "";
				
	if(num(db_num_rows($resource_billing)) > 0)
	{
	while ($row_billing  =  db_fetch($resource_billing, PDO::FETCH_NUM))
		{
			{
			$query_sign = q_set($__p_query_sign, "SELECT ttd_file  FROM ves_data.tb_user where nama_detail  = ? ", [(string) ($nmsc)]);
			$resource_sign = db_query_soft($query_sign, $__p_query_sign ?? []);
				while ($r_sign  =  db_fetch($resource_sign, PDO::FETCH_NUM))	
					{
					$sign_sc = $r_sign[0];if ($sign_sc ==''){$sign_sc =$no_sign;}		
					}			
			}		
		$propose_date = $row_billing[10];
		$nm_app = $row_billing[11];
		if ($nm_app !='')
			{
			$query_sign = q_set($__p_query_sign, "SELECT ttd_file  FROM ves_data.tb_user where nama_detail  = ? ", [(string) ($nm_app)]);
			$resource_sign = db_query_soft($query_sign, $__p_query_sign ?? []);
				while ($r_sign  =  db_fetch($resource_sign, PDO::FETCH_NUM))	
					{
					$sign_app = $r_sign[0];if ($sign_app ==''){$sign_app =$no_sign;}	
					}			
			}
		$approve_date = $row_billing[20];
		$nm_ack = $row_billing[12];
if ($nm_ack !='')
			{
			$query_sign = q_set($__p_query_sign, "SELECT ttd_file  FROM ves_data.tb_user where nama_detail  = ? ", [(string) ($nm_ack)]);
			$resource_sign = db_query_soft($query_sign, $__p_query_sign ?? []);
				while ($r_sign  =  db_fetch($resource_sign, PDO::FETCH_NUM))	
					{
					$sign_ack = $r_sign[0];if ($sign_ack ==''){$sign_ack =$no_sign;}	
					}			
			}
		$nm_check = $row_billing[13];
if ($nm_check !='')
			{
			$query_sign = q_set($__p_query_sign, "SELECT ttd_file  FROM ves_data.tb_user where nama_detail  = ? ", [(string) ($nm_check)]);
			$resource_sign = db_query_soft($query_sign, $__p_query_sign ?? []);
				while ($r_sign  =  db_fetch($resource_sign, PDO::FETCH_NUM))	
					{
					$sign_check = $r_sign[0];if ($sign_check ==''){$sign_check =$no_sign;}	
					}			
			}
		else {$sign_check =$no_sign;}	
		$nm_tax = $row_billing[15];
if ($nm_tax !='')
			{
			$query_sign = q_set($__p_query_sign, "SELECT ttd_file  FROM ves_data.tb_user where nama_detail  = ? ", [(string) ($nm_tax)]);
			$resource_sign = db_query_soft($query_sign, $__p_query_sign ?? []);
				while ($r_sign  =  db_fetch($resource_sign, PDO::FETCH_NUM))	
					{
					$sign_tax = $r_sign[0];	if ($sign_tax ==''){$sign_tax =$no_sign;}	
					}			
			}
		else {$sign_tax =$no_sign;}		
		$nm_paid = $row_billing[18];
if ($nm_paid !='')
			{
			$query_sign = q_set($__p_query_sign, "SELECT ttd_file  FROM ves_data.tb_user where nama_detail  = ? ", [(string) ($nm_paid)]);
			$resource_sign = db_query_soft($query_sign, $__p_query_sign ?? []);
				while ($r_sign  =  db_fetch($resource_sign, PDO::FETCH_NUM))	
					{
					$sign_paid = $r_sign[0];		if ($sign_paid ==''){$sign_paid =$no_sign;}
					}			
			}
		else {$sign_paid =$no_sign;}			
		
		$ack_date = $row_billing[21];		
		$checked_date = $row_billing[14];	
		$tax_date = $row_billing[16];
		$paid_date = $row_billing[19];
		$query_bayar = q_set($__p_query_bayar, "SELECT sum(amount) as ttl  FROM ves_data.vip_billing_payment where kd_billing = ? and id_receipt <> '' and \r
\t\t(jns_payment = 'Full Payment' or jns_payment = 'Installment 1' or jns_payment = 'Installment 2' or  jns_payment = 'Installment 3'  or  jns_payment = 'Down Payment' )  ", [(string) ($row_billing[1])]);
		$resource_bayar = db_query_soft($query_bayar, $__p_query_bayar ?? []);
		$keluar_bayar = db_num_rows($resource_bayar);	
		if(num(db_num_rows($resource_bayar)) > 0)
			{
			while ($row_bayar  =  db_fetch($resource_bayar, PDO::FETCH_NUM))	
				{
				$mbayar = $row_bayar[0];	
				}
			}	
		$type_program = $row_billing[7];

		$nomor_asli = $row_incentive['0'];
		$st_reward = $row_incentive['12'];
		$besar_reward = $row_billing['8'];
	$ttl_besar_reward = num($ttl_besar_reward) + num($besar_reward);
					$net_incentive = num($besar_reward) - num((num($besar_reward) *num((num($row_billing[17])/100))));
					$ttl_net_incentive = num($ttl_net_incentive) + num($net_incentive);
	?>

          <tr>
            <td>&nbsp;</td>
            <td><small><span class="style24"><?php echo e($no_urut) ?></span></small></td>
            <td><small><span class="style24"><?php echo e($row_billing[0]) ?><br>
            <?php echo e($row_billing[1]) ?></span></small></td>
            <td><small><span class="style24"><?php echo e($row_billing[3]) ?> <br>
            <?php echo e($row_billing[4]) ?> <?php echo e($row_billing[5]) ?> <?php echo e($row_billing[6]) ?></span></small></td>
            <td><small><span class="style24"><?php echo  number_format(num(($row_billing[7])),0,".",".")  ?><br>
            </span></small></td>
            <td><small><span class="style24"><?php echo  number_format(num($mbayar),0,".",".") ?></span></small></td>
            <td><small><span class="style24"><?php echo  number_format(num(($row_billing[8])),0,".",".") ?></span></small></td>
            <td><small><span class="style24"><?php echo e($row_billing[17]) ?> %</span></small></td>
            <td><small><span class="style24"><?php echo  number_format(num($net_incentive),0,".",".") ?></span></small></td>
            </tr>
             <?php $no_urut = num($no_urut) +1;$status_tampil='';								$st_reward =0; }} ?>			  			  
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td colspan="3" align="right"	><strong>TOTAL Incentive (After Tax) :</strong></td>
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
              <th><small>Paid By</small></th>
              <td>&nbsp;</td>
            </tr>
            
            <tr>
              <th >&nbsp;</th>
              <th ><img src="<?php echo e($sign_sc) ?>" width="133" height="32" alt=""/></th>
              <th ><img src="<?php echo e($sign_app) ?>" width="133" height="32" alt=""/></th>
              <th><img src="<?php echo e($sign_ack) ?>" width="133" height="32" alt=""/></th>
              <th><img src="<?php echo e($sign_check) ?>" width="133" height="32" alt=""/></th>
              <th><img src="<?php echo e($sign_tax) ?>" width="133" height="32" alt=""/></th>
              <th><img src="<?php echo e($sign_paid) ?>" width="133" height="32" alt=""/></th>
              <td>&nbsp;</td>
            </tr>
            
            <tr>
              <th height="22" >&nbsp;</th>
              <th ><small><?php echo e($nmsc) ?><br>
              <?php echo e($propose_date) ?></small></th>
              <th ><small><?php echo e($nm_app) ?><br>
              <?php echo e($approve_date) ?></small></th>
              <th><small><?php echo e($nm_ack) ?><br>
              <?php echo e($ack_date) ?></small></th>
              <th><small><?php echo e($nm_check)	 ?><br>
              <?php echo e($checked_date) ?></small></th>
              <th><small><?php echo e($nm_tax) ?><br>
              <?php echo e($tax_date) ?></small></th>
              <th><small><?php echo e($nm_paid) ?><br>
              <?php echo e($paid_date) ?> </small></th>
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
