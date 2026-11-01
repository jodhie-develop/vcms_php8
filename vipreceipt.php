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

$query_ambil_billing = q_set($__p_query_ambil_billing, "SELECT v.kd_biodata, t.nama, t.middle_name, t.family_name, a.nm_program, a.level_program, a.type_program, v.tf, v.discount, v.promo_persen, v.voucher, v.net_tf, v.material_cost, v.reg_fee, v.pic FROM ves_data.vip_billing v\r
left join ves_inc.tb_biodata t on v.kd_biodata = t.kd_biodata\r
left join ves_data.vip_mst_code_prg a on v.kd_program = a.kd_program where v.kd_billing = ? ", [(string) ($idb)]);
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

		} 
if ($nm_promo == 'Regular')
	{$discount_nominal = '0';}
else
	{$discount_nominal = num($tf) - num((num($tf) * num((num($promo_persen)/100))));}

//===get payment
$query_get_payment = q_set($__p_query_get_payment, "SELECT jns_payment, amount, dt_payment, status, id_receipt \r
FROM ves_data.vip_billing_payment where kd_billing = ? and kd_biodata = ? ", [(string) ($idb), (string) ($kdb)]);

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
//====
$query_ttl_payment = q_set($__p_query_ttl_payment, "SELECT sum(amount) as total \r
FROM ves_data.vip_billing_payment where kd_billing = ? and kd_biodata = ? and id_receipt <> ''", [(string) ($idb), (string) ($kdb)]);

$resource_ttl_payment = db_query_or_die('errro_3', $query_ttl_payment, $__p_query_ttl_payment ?? []);
while ($row_ttl_payment=  db_fetch($resource_ttl_payment, PDO::FETCH_NUM))
	{
	$ttl_payment = $row_ttl_payment['0'];
	}
//==total terbayar
$kurang = num($net_tf) - num($ttl_payment);
//
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>AdminLTE 2 | General Form Elements</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="css/font-awesome/css/font-awesome.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="css/ionicons/css/ionicons.min.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="plugins/datatables/dataTables.bootstrap.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"></link>
    <script src="http://code.jquery.com/jquery-3.1.1.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/js/bootstrap-datepicker.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/css/bootstrap-datepicker.css"></link>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/7.0.0/normalize.min.css">
  <!-- Load paper.css for happy printing -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/paper-css/0.3.0/paper.css">
  <!-- Set page size here: A5, A4 or A3 -->
  <!-- Set also "landscape" if you need -->
  <style>@page { size: A4 }</style>    
  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
</head>
<body onload="window.print();">
<body class="A5.landscape">

  <!-- Left side column. contains the logo and sidebar -->
  
<?php   //   include __DIR__ . "/left.php";	 ?>

<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->

   <!-- Main content -->
<section class="content">

  <input type="text" ang="en-150"  name="kdcbg" 
                 	      value="<?php echo e($kdcbg) ?>" hidden="hidden">
 <div class="col-md-12">
      <table width="100%" class="table table-borderless" id="example">
        <tbody>
          <tr>
            <td height="14" colspan="2" align=Left class="style24"><br></td>
            <td height="14" colspan="6" align=center class="style24"><h5>VIP Receipt<br>
              <small><strong>Invoice Number : </strong><?php echo e($idb) ?></small></h5></td>
            <td height="14" align=Left class="style24">&nbsp;</td>
          </tr>
          <tr>
            <td colspan="2" align=Left class="style24"><small>
              <label>Student Name </label>
            </small></td>
            <td colspan="2" align=left class="style24"><small><?php echo e($nama) ?> <?php echo e($middle_name) ?> <?php echo e($family_name) ?></small></td>
            <td height="14" colspan="4" align=left class="style24"><small>
              <label>ID</label>
              <?php echo e($kdb) ?></small><br></td>
            <td></td>
          </tr>
          <tr>
            <td colspan="2" align=left class="style24"><span class="form-group"> <small>
              <label>Program</label>
            </small> </span></td>
            <td colspan="2" align=left class="style24"><small><?php echo e($nm_program) ?> <?php echo e($level_program) ?> <?php echo e($type_program) ?></small></td>
            <td height="14" colspan="4" align=left class="style24"><small>
              <label>Class Information :</label>
            </small> <br></td>
            <td></td>
          </tr>
          <tr>
            <td colspan="3" align="center"><span class="form-group"><small>Tuition Fee<br>
              <?php echo number_format(num($tf),0,".",".")?><br>
              </small> </span>
            <td width="22%" align=center class="style24"><small>Net Tuition Fee</small><small><br>
              <?php echo number_format(num($net_tf),0,".",".")?><small><br></td>
            <td width="18%" align=center class="style24"><span class="form-group"><small>Discount <br>
              <?php echo e($discount) ?> (<?php echo e($promo_persen)?>%)</small></span></td>
            <td colspan="2" align=center class="style24"><small>Voucher<br>
              <?php echo number_format(num($voucher),0,".",".")?></small><br></td>
            <td width="10%" align=center class="style24"><small>Registration<br>
              <small><?php echo number_format(num($reg_fee),0,".",".")?></small></td>
            <td width="12%" align=center class="style24"><small>Material Cost<small><br>
              <?php echo number_format(num($material_cost),0,".",".")?></small></td>
            <td width="3%" height="14" align=left class="style24"><small><br>
            </small>            
          </tr>
          <tr>
            <td colspan="4" align=center class="style24"><small><strong>Total Amount :</strong> Rp. </small><small><?php echo number_format(num($net_tf),0,".",".")?></small></td>
            <td height="14" colspan="2" align=left class="style24">&nbsp;</td>
            <td height="14" colspan="3" align=left class="style24"><small>
            <label>Outstanding : </label>
Rp. <?php echo number_format(num($kurang),0,".",".")?></small></td>
            <td></td>
          </tr>
          <tr>
            <td colspan="3" align=center class="style24"><small>
              <label>Registration</label>
              <br>
              <?php echo number_format(num($reg_fee),0,".",".")?> <br>
              <?php echo e($reg_status) ?> <?php echo e($reg_id_receipt)   ?><br>
              <label>Down Payment</label>
              <br>
              <?php echo number_format(num($dp_amount),0,".",".")?><br>
              <?php echo e($dp_status) ?> <?php echo e($dp_id_receipt)   ?></small></td>
            <td align=center class="style24"><small>
            <label>Material Cost</label>
            <br>
            <?php echo number_format(num($material_cost),0,".",".")?> <br>
            <?php echo e($material_status) ?> <?php echo e($material_id_receipt)   ?><br>
            <label>Installment 1</label>
            <br>
            <?php echo number_format(num($is1_amount),0,".",".")?><br>
            <?php echo e($is1_status) ?> <?php echo e($is1_id_receipt)   ?></small></td>
            <td height="14" colspan="3" align=center class="style24"><small>
              <label>Full Payment</label>
              <br>
              <?php echo number_format(num($full_amount),0,".",".")?><br>
              <?php echo e($full_status) ?> <?php echo e($full_id_receipt)   ?><br>
              <label>Installment 2</label>
              <br>
              <?php echo number_format(num($is2_amount),0,".",".")?><br>
              <?php echo e($is2_status) ?> <?php echo e($is2_id_receipt)   ?></small></td>
            <td height="14" colspan="2" align=center class="style24"><small>
              <label>Installment 3</label>
              <br>
              <?php echo number_format(num($is3_amount),0,".",".")?><br>
              <?php echo e($is3_status) ?> <?php echo e($is3_id_receipt)   ?></small></td>
            <td></td>
          </tr>
          <tr>
            <td width="5%" align=left class="style24">&nbsp;</td>
            <td colspan="3" align=left class="style24"><small>
              <label> Consultant</label>
              <br>
              <?php echo e($nama_lengkap) ?></small></td>
            <td colspan="2" align=left class="style24">&nbsp;</td>
            <td height="14" colspan="3" align=left class="style24"><small>
              <label> Student</label>
              <br>
              <?php echo e($nama) ?> <?php echo e($middle_name) ?> <?php echo e($family_name) ?></small></td>
            <td></td>
          </tr>
          <tr>
            <td align=left class="style24">&nbsp;</td>
            <td colspan="3" align=left class="style24">&nbsp;</td>
            <td colspan="2" align=left class="style24">&nbsp;</td>
            <td height="14" colspan="3" align=right class="style24"><small>Student's Page</small></td>
          </tr>
        <tfoot>
        </tfoot>
      </table>
 </div>

  <input type="text" ang="en-150" name="kdb" 
                 	      value="<?php echo e($kdb) ?>" hidden="hidden">
<input type="text" ang="en-150"   name="enroll_date" 
                 	      value="<?php echo e($enroll_date) ?>" hidden="hidden">

  <input type="text" ang="en-150"   name="st" hidden="hidden" 
                 	      value="<?php echo e($st) ?>" >

  <input type="text" ang="en-150"   name="idb" hidden="hidden" 
                 	      value="<?php echo e($idb) ?>" >

  <input type="text" ang="en-150"  name="kdcbg2" 
                 	      value="<?php echo e($kdcbg) ?>" hidden="hidden">
</body>
</html>
<?php 
if (isset($_GET['Save'])) 
	{
	
	}
?>