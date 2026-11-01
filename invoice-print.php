<?php
require_once __DIR__ . "/_lib/bootstrap.php"; csrf_guard_get(); auth_require_login(); 
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
$query_billing = q_set($__p_query_billing, "SELECT b.nama_lengkap, a.kd_billing, a.nama_sc, a.kelas, nm_program, type_program , private_pax, net_tf,a.nominal, st_reward  FROM ves_data.ve_incentive a\r
left join vip_billing c on a.kd_biodata = c.kd_biodata\r
left join vip_student_data b on a.kd_biodata = b.kd_biodata\r
left join vip_mst_code_prg d on c.kd_program = d.kd_program where st_reward = 3  and nama_sc = ? and  a.kd_branch = ? and start_kelas between ? and  ? group by a.no\r
", [(string) ($nmsc), (string) ($kdc), (string) ($dat), (string) ($det)]);	
$no_urut = 1;		
$resource_billing = db_query_soft($query_billing, $__p_query_billing ?? []);
$keluar_billing = db_num_rows($resource_billing);	

?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>AdminLTE 2 | Invoice</title>
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
      <div class="col-4 invoice-col">
        <address>
        </address>
      </div>
      <!-- /.col -->
      <div class="col-xs-12 table-responsive">
        <table class="table table-striped">
          <thead>
          <tr>
            <th colspan="5" align="center">VE Incentive Claim Form</th>
            </tr>
          </thead>
          <tbody>
          <tr>
            <td width="7%">&nbsp;</td>
            <td width="9%">&nbsp;</td>
            <td width="52%">&nbsp;</td>
            <td width="25%">&nbsp;</td>
            <td width="7%">&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>Staff Name</td>
            <td><strong>: <?php echo e($nmsc) ?></strong></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>Period</td>
            <td><strong> : <?php echo e($da) ?> to <?php echo e($de) ?></strong></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>PAX</td>
            <td><strong>:<?php echo e($keluar_billing) ?></strong></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          </tbody>
        </table>
      </div>
      <!-- /.col --><!-- /.col -->
    </div>
  <div class="row invoice-info">
    <div class="col-4 invoice-col">
      <address>
      </address>
    </div>
    <!-- /.col --><!-- /.col -->
    <!-- /.col -->
  </div>
  <!-- /.row -->

    <!-- Table row -->
    <div class="row">
      <div class="col-xs-12 table-responsive">
        <table class="table table-striped">
          <thead>
          <tr>
            <th width="3%">&nbsp;</th>
            <th width="5%">No</th>
            <th width="20%">Student Name</th>
            <th width="16%">Class Program</th>
            <th width="37%">Net Tuition Fee</th>
            <th width="19%">Paid</th>
            <th width="19%">Reward</th>
          </tr>
          </thead>
			
          <tbody>
<?php
	if(num(db_num_rows($resource_billing)) > 0)
	{
	while ($row_billing  =  db_fetch($resource_billing, PDO::FETCH_NUM))
		{

		$query_bayar = q_set($__p_query_bayar, "SELECT sum(amount) as ttl  FROM ves_data.vip_billing_payment where kd_billing = ? and id_receipt <> '' and \r
\t\t(jns_payment = 'Full Payment' or jns_payment = 'Installment 1' or jns_payment = 'Installment 2' or  jns_payment = 'Installment 3' )  ", [(string) ($row_billing[1])]);
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
		$jml_pax = $row_billing[8];
					$nomor_asli = $row_incentive['0'];
					$st_reward = $row_incentive['12'];
					$besar_reward = $row_incentive['4'];
						$query_update_reward = q_set($__p_query_update_reward, "update ves_data.ve_incentive set nominal = ? ,st_reward = 1 where no = ? ", [(string) ($besar_reward), (string) ($nomor_asli)]);
						$resource_update_reward = db_query_soft($query_update_reward, $__p_query_update_reward ?? []);
						
	?>
?>	
          <tr>
            <td>&nbsp;</td>
            <td><small><span class="style24"><?php echo e($no_urut) ?></span></small></td>
            <td><small><span class="style24"><?php echo e($row_billing[0]) ?><br>
            <?php echo e($row_billing[1]) ?></span></small></td>
            <td><small><span class="style24"><?php echo e($row_billing[3]) ?> <br>
            <?php echo e($row_billing[4]) ?> <?php echo e($row_billing[5]) ?> <?php echo e($row_billing[6]) ?></span></small></td>
            <td><small><span class="style24"><?php echo  number_format(num(($row_billing[7])),0,".",".")  ?></span></small></td>
            <td><small><span class="style24"><?php echo  number_format(num($mbayar),0,".",".") ?></span></small></td>
            <td><small><span class="style24"><?php echo  number_format(num($row_billing[8]),0,".",".") ?></span></small></td>
          </tr>
             <?php $no_urut = num($no_urut) +1;$status_tampil='';								$st_reward =0; }} ?>			  
          </tbody>
        </table>
      </div>
      <!-- /.col -->
  </div>
    <!-- /.row -->

    <div class="row">
      <!-- accepted payments column -->
      <div class="col-xs-6">
        Catatan : :
        <p class="text-muted well well-sm no-shadow" style="margin-top: 10px;">
          Insentive bisa diberikan jika bla bla bla.
        </p>
      </div>
      <!-- /.col -->
      <div class="col-xs-6">
        <p class="lead">&nbsp;</p>
        <div class="table-responsive">
          <table class="table">
            <tr>
              <th style="width:50%">&nbsp;</th>
              <th style="width:50%">Total Incentive:</th>
              <td><small><span class="style24"><?php echo  number_format(num($row_billing[8]),0,".",".") ?></span></small></td>
            </tr>
            <tr>
              <th>&nbsp;</th>
              <th>Tax</th>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <th>&nbsp;</th>
              <th>Potongan Lain:</th>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <th>&nbsp;</th>
              <th>Total dibayar:</th>
              <td><small><span class="style24"><?php echo  number_format(num($row_billing[8]),0,".",".") ?></span></small></td>
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
<?php
    $content = ob_get_clean();
	$namafile = "ve_inc.kimberly.pdf";
    // convert in PDF
    require_once VCMS_ROOT . '/_lib/html2pdf.php';   // spipu/html2pdf 5.x (pengganti html2pdf/ lama)
    try
    {
        $html2pdf = new HTML2PDF('P', 'A4', 'en');
 		$html2pdf->setTestTdInOnePage(false);		
        $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
        $html2pdf->Output($namafile);
    }
    catch(HTML2PDF_exception $e) {
        html2pdf_fail($e);
    }
?>