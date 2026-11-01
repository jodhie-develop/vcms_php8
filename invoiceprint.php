<?php
require_once __DIR__ . "/_lib/bootstrap.php"; auth_require_login(); 
include __DIR__ . "/conndb.php";
include __DIR__ . "/profiledata.php";
$nama_lengkap = $_SESSION['nama_lengkap']; 
$kdcbg = $_SESSION['kd_branch']; 
$kdb = in_val('kdb', 'get');
$idb = in_val('idb', 'get');
$hari=date("d");
$bulan=date("m");
$bulanan=date("M");

$query_ambil_billing = q_set($__p_query_ambil_billing, "SELECT v.kd_biodata, t.nama, t.middle_name, t.family_name, a.nm_program, v.level_program, a.type_program, v.tf, v.discount, v.promo_persen, v.voucher, v.net_tf, v.material_cost, v.reg_fee, v.pic,t.address, t.city, t.org_school,t.hp, t.e_mail,v.kd_billing, v.dt_entry FROM ves_data.vip_billing v\r
left join ves_inc.tb_biodata t on v.kd_biodata = t.kd_biodata\r
left join ves_data.vip_mst_code_prg a on v.kd_program = a.kd_program where v.kd_billing = ? and v.kd_biodata = ? ", [(string) ($idb), (string) ($kdb)]);

$resource_ambil_billing = db_query_or_die('errro_1', $query_ambil_billing, $__p_query_ambil_billing ?? []);
while ($row_billing=  db_fetch($resource_ambil_billing, PDO::FETCH_NUM))
		{
		$kd_biodata = $row_billing['0'];
		$nama = $row_billing['1'];
		$middle_name = $row_billing['2'];
		$family_name = $row_billing['3'];
		$nm_program = $row_billing['4'];
		$level_program = $row_billing['5'];
		$type_program = $row_billing['6'];
		$tf = $row_billing['7'];
		$discount = $row_billing['8'];
		$promo_persen = $row_billing['9'];
		$voucher = $row_billing['10'];
		$net_tf = $row_billing['11'];
		$material_cost = $row_billing['12'];
		$reg_fee = $row_billing['13'];
		$pic = $row_billing['14'];
		$address = $row_billing['15'];
		$city = $row_billing['16'];
		$org_school = $row_billing['17'];
		$hp = $row_billing['18'];
		$e_mail = $row_billing['19'];
		$kd_billing = $row_billing['20'];
		$dt_entry = $row_billing['21'];	

		} 
if ($nm_promo == 'Regular')
	{$discount_nominal = '0';}
else
	{$discount_nominal = num($tf) - num((num($tf) * num((num($promo_persen)/100))));}

//===get payment
$query_get_payment = q_set($__p_query_get_payment, "SELECT jns_payment, amount, dt_payment, status, id_receipt \r
FROM ves_data.vip_billing_payment where kd_billing = ? and kd_biodata = ? ", [(string) ($idb), (string) ($kd_biodata)]);

$resource_get_payment = db_query_or_die('errro_2', $query_get_payment, $__p_query_get_payment ?? []);
while ($row_payment=  db_fetch($resource_get_payment, PDO::FETCH_NUM))
	{
	$jns_payment = $row_payment['0'];
	if ($jns_payment=='Registration')
		{	
		$reg_amount = $row_payment['1'];
		$reg_dt_payment = $row_payment['2'];
		$reg_status = $row_payment['3'];
		$reg_id_receipt = $row_payment['4'];
		}
	elseif ($jns_payment=='Material')
		{	
		$material_amount = $row_payment['1'];
		$material_dt_payment = $row_payment['2'];
		$material_status = $row_payment['3'];
		$material_id_receipt = $row_payment['4'];
		}
	elseif ($jns_payment=='Full Payment')
		{	
		$full_amount = $row_payment['1'];
		$full_dt_payment = $row_payment['2'];
		$full_status = $row_payment['3'];
		$full_id_receipt = $row_payment['4'];
		}
	elseif ($jns_payment=='Down Payment')
		{	
		$dp_amount = $row_payment['1'];
		$dp_dt_payment = $row_payment['2'];
		$dp_status = $row_payment['3'];
		$dp_id_receipt = $row_payment['4'];
		}
	elseif ($jns_payment=='Installment 1')
		{	
		$is1_amount = $row_payment['1'];
		$is1_dt_payment = $row_payment['2'];
		$is1_status = $row_payment['3'];
		$is1_id_receipt = $row_payment['4'];
		}
	elseif ($jns_payment=='Installment 2')
		{	
		$is2_amount = $row_payment['1'];
		$is2_dt_payment = $row_payment['2'];
		$is2_status = $row_payment['3'];
		$is2_id_receipt = $row_payment['4'];
		}
	elseif ($jns_payment=='Installment 3')
		{	
		$is3_amount = $row_payment['1'];
		$is3_dt_payment = $row_payment['2'];
		$is3_status = $row_payment['3'];
		$is3_id_receipt = $row_payment['4'];
		}
	} 
$ttl_must_be_paid = num($reg_fee) + num($net_tf) + num($material_cost);
//====
$query_ttl_payment = q_set($__p_query_ttl_payment, "SELECT sum(amount) as total \r
FROM ves_data.vip_billing_payment where kd_billing = ? and kd_biodata = ? and id_receipt <> ''", [(string) ($idb), (string) ($kdb)]);

$resource_ttl_payment = db_query_or_die('errro_3', $query_ttl_payment, $__p_query_ttl_payment ?? []);
while ($row_ttl_payment=  db_fetch($resource_ttl_payment, PDO::FETCH_NUM))
	{
	$ttl_payment = $row_ttl_payment['0'];
	}
//==total terbayar

$kurang = num($ttl_must_be_paid) - num($ttl_payment);
//
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Vista English Invoice</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="css/font-awesome.min.css">
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
  <section class="invoice">
    <!-- title row -->
    <div class="row">
      <div class="col-xs-12">
        <h2 class="page-header">
        <span class="style24"><img src="imgs/viplog.png" width="85" height="46" alt=""/></span></h2>
      </div>
      <!-- /.col -->
    </div>
    <!-- info row -->
    <div class="row invoice-info">
      <div class="col-sm-4 invoice-col">
        From
        <address>
          <strong>Vista English</strong><br>
        </address>
      </div>
      <!-- /.col -->
      <div class="col-sm-4 invoice-col">
         To
        <address>
          <strong><?php echo e($nama) ?> <?php echo e($middle_name) ?> <?php echo e($family_name) ?></strong><br>
          <?php echo e($address) ?> <?php echo e($city) ?><br>
          <?php echo e($org_school) ?><br>
          <?php echo e($hp) ?><br>
          Email: <?php echo e($e_mail) ?>
        </address>
      </div>
      <!-- /.col -->
      <div class="col-sm-4 invoice-col">
		  ID Number<br>
        <b><?php echo e($kd_billing) ?></b><br>
Date :<br>
        <b> <?php echo e($dt_entry) ?></b><br>

      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->

    <!-- Table row -->
    <div class="row">
      <div class="col-xs-12 table-responsive">
		  <hr>
        <table class="table table-striped">
          <thead>
          <tr>
            <th>Qty</th>
            <th>Program</th>
            <th>Level</th>
            <th>&nbsp;</th>
            <th>Tuition Fee</th>
          </tr>
          </thead>
          <tbody>
          <tr>
            <td>1</td>
            <td><small><?php echo e($nm_program) ?></small></td>
            <td><small><?php echo e($level_program) ?></small></td>
            <td>&nbsp;</td>
            <td>Rp. <span class="style24"><?php echo number_format(num($net_tf),0,".",".")?></span></td>
          </tr>
          </tbody>
        </table>
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->

    <div class="row">
      <!-- accepted payments column -->
      <!-- /.col -->
      <div class="col-xs-6">
        <p class="lead">&nbsp;</p>

        <div class="table-responsive">
          <table class="table">
            <tr>
              <th>Must be Paid :</th>
              <td><strong>Rp. <span class="style24"><?php echo number_format(num($net_tf),0,".",".")?></span></strong></td>
            </tr>
          </table>
        </div>
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->
  </section>
  <!-- /.content -->
</div>
<!-- ./wrapper -->
</body>
</html>
