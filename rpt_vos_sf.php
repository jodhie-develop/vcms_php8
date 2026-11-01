<?php
require_once __DIR__ . "/_lib/bootstrap.php"; auth_require_login();
$date_start = in_val('date_start', 'get');
$date_end = in_val('date_end', 'get');
include __DIR__ . "/conndb.php";
?>
<?php 
$q = in_val('q', 'get');
$hari=date("d");
$bulan=date("m");
$tahun=date("Y");
$hari_ini = "$tahun-$bulan-$hari";
;

if ($date_start ==''){$date_start = "$tahun-$bulan-01";}
if ($date_end ==''){$date_end = $hari_ini;}

$kd_cbg = in_val('kd_cbg', 'get');

$pilihan_sc = in_val('pilihan_sc', 'get');
if ($pilihan_sc ==''){$pilihan_sc = 'My Leads';}

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
if ($kd_cbg == 'National'){$kd_cbg = 100;}
if ($kd_cbg == 'PIK'){$kd_cbg = 11;}


if (num($kd_cbg) ==1){$cabang = 'East Sby';$nm_cabang = $cabang;}
if (num($kd_cbg) ==2){$cabang = 'West Sby';$nm_cabang = $cabang;}
if (num($kd_cbg) ==3){$cabang = 'Denpasar';$nm_cabang = 'Bali';}
if (num($kd_cbg) ==4){$cabang = 'South Jkt';$nm_cabang = 'Patal Jkt';}
if (num($kd_cbg) ==5){$cabang = 'North Jkt';$nm_cabang = 'Central Jkt';}
if (num($kd_cbg) ==6){$cabang = 'West Jkt';$nm_cabang = $cabang;}
if (num($kd_cbg) ==7){$cabang = 'Bandung';$nm_cabang = $cabang;}
if (num($kd_cbg) ==8){$cabang = 'Malang TBI';$nm_cabang = $cabang;}
if (num($kd_cbg) ==9){$cabang = 'Bandung TBI';$nm_cabang = $cabang;}
if (num($kd_cbg) ==10){$cabang = 'Bali TBI';$nm_cabang = $cabang;}
if (num($kd_cbg) ==100){$cabang = 'National';$nm_cabang = $cabang;}
if (num($kd_cbg) ==11){$cabang = 'PIK';$nm_cabang = $cabang;}



$nama_lengkap = $_SESSION['nama_lengkap'];
$nama_depan = $_SESSION['nama_depan'];
//$kd_cbg = $_SESSION['kd_branch'];
$posisi = $_SESSION['posisi']; 
$kd_staff = $_SESSION['kd_staff'] ;


 if ($cabang =='--ALL--' or $cabang =='National')
	{
	$query = q_set($__p_query, "SELECT t.id_prof_bill, concat_ws(' ',a.nama, a.middle_name,a.family_name), concat_ws(' ',t.country_dest, t.school_dest, t.prg_dest), c.status_host, c.status_part, t.st_refund, t.rp_mount,t.tgl_cetak,t.branch,t.sc_name  FROM ves_inc.tb_prof_bill t\r
left join ves_inc.tb_biodata a on t.id_stu = a.kd_biodata left join ves_inc.tb_enrolled c on t.school_dest = c.sch_dest and t.country_dest = c.country_dest\r
where tgl_cetak between ? and ? and t.branch <> '' group by t.id_prof_bill order by t.id_prof_bill desc", [(string) ($date_start), (string) ($date_end)]);		
	}
elseif ($cabang =='North Jkt')
	{
	$query = q_set($__p_query, "SELECT t.id_prof_bill, concat_ws(' ',a.nama, a.middle_name,a.family_name), concat_ws(' ',t.country_dest, t.school_dest, t.prg_dest), c.status_host, c.status_part, t.st_refund, t.rp_mount,t.tgl_cetak,t.branch,t.sc_name  FROM ves_inc.tb_prof_bill t\r
left join ves_inc.tb_biodata a on t.id_stu = a.kd_biodata left join ves_inc.tb_enrolled c on t.school_dest = c.sch_dest and t.country_dest = c.country_dest\r
where tgl_cetak between ? and ? and (t.branch = 'North Jkt' or t.branch = 'Central Jkt') group by t.id_prof_bill order by t.id_prof_bill desc", [(string) ($date_start), (string) ($date_end)]);		
	}
elseif ($cabang =='South Jkt')
	{
	$query = q_set($__p_query, "SELECT t.id_prof_bill, concat_ws(' ',a.nama, a.middle_name,a.family_name), concat_ws(' ',t.country_dest, t.school_dest, t.prg_dest), c.status_host, c.status_part, t.st_refund, t.rp_mount,t.tgl_cetak,t.branch,t.sc_name  FROM ves_inc.tb_prof_bill t\r
left join ves_inc.tb_biodata a on t.id_stu = a.kd_biodata left join ves_inc.tb_enrolled c on t.school_dest = c.sch_dest and t.country_dest = c.country_dest\r
where tgl_cetak between ? and ? and (t.branch = 'South Jkt' or t.branch = 'Patal Jkt') group by t.id_prof_bill order by t.id_prof_bill desc", [(string) ($date_start), (string) ($date_end)]);		
	}	   
else
	{
	$query = q_set($__p_query, "SELECT t.id_prof_bill, concat_ws(' ',a.nama, a.middle_name,a.family_name), concat_ws(' ',t.country_dest, t.school_dest, t.prg_dest), c.status_host, c.status_part, t.st_refund, t.rp_mount,t.tgl_cetak,t.branch,t.sc_name  FROM ves_inc.tb_prof_bill t\r
left join ves_inc.tb_biodata a on t.id_stu = a.kd_biodata left join ves_inc.tb_enrolled c on t.school_dest = c.sch_dest and t.country_dest = c.country_dest\r
where tgl_cetak between ? and ? and t.branch = ? group by t.id_prof_bill order by t.id_prof_bill desc", [(string) ($date_start), (string) ($date_end), (string) ($nm_cabang)]);		
	}


$no_urut = 1;
$result=db_query_or_die("Wah error nih11", $query, $__p_query ?? []);
$num_rows = db_num_rows($result);?>

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
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
<style type="text/css">
<!--

	.style33 {
	color:#000;
	font-size:75%;
	}

</style>  

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
          </i> VOS Income Summary
          
          <br>
       </i><?php echo e($cabang) ?><small class="pull-right">Date Period: <?php echo e($date_start) ?>To <?php echo e($date_end) ?></small> </h2>
      </div>
      <!-- /.col -->
    </div>
    <!-- info row -->
    <div class="row invoice-info"><!-- /.col --><!-- /.col --><!-- /.col -->
    </div>
    <!-- Table row -->
    <div class="row">
      <div class="col-xs-12 table-responsive">
<table width="97%" class="table table-bordered table-striped" id="example1">
  <thead>
    <tr>
      <th width="3%">No</th>
      <th width="12%">Payment Date</th>
      <th width="12%">Receipt Number</th>
      <th width="22%">Student Name</th>
      <th width="25%">Destination</th>
      <th width="12%">P/NP</th>
      <th width="12%">Refund/<br>
        Non Refund</th>
      <th width="14%">SC</th>
      <th width="14%">Amount</th>
    </tr>
  </thead>
  <tbody>
    <?php 
					if ($result) 
						{ 
						while ($r = db_fetch($result))
							{		
							//$query_last_progress= "SELECT pro
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
      <td><?php echo e($r[7]) ; ?></td>
      <td><?php echo e($r[0]) ; ?></td>
      <td><?php echo e($r[1]) ; ?></td>
      <td><?php echo e($r[2]) ; ?></td>
      <td><?php echo e($r[10]) ; ?></td>
      <td><?php echo e($r[5]) ; ?></td>
      <td><?php echo e($r[8]) ; ?> - <?php echo e($r[9]) ; ?></td>
      <td><?php echo e($r[6]) ; ?></td>
    </tr>
    <?php $no_urut = num($no_urut) + 1; } }?>
  </tbody>
  <tfoot>
  </tfoot>
</table>
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->
<?php
$query_jns_pay = q_set($__p_query_jns_pay, "SELECT  a.pay_mtd,   sum(amount) as jumlah FROM vip_billing_payment a left join vip_billing b on a.kd_biodata = b.kd_biodata where a.id_receipt <> '' and a.kd_branch = ?\r
and dt_payment between ? and ? group by a.pay_mtd order by id_receipt", [(string) ($kd_cbg), (string) ($date_start), (string) ($date_end)]);
	
	
$result_jns_pay=db_query_or_die("Wah error nih15", $query_jns_pay, $__p_query_jns_pay ?? []);	
while ($r_jns_pay = db_fetch($result_jns_pay))
	{ $jns_pay = $r_jns_pay[0]; $jns_amount = $r_jns_pay[1];
	 if($jns_pay =='Debit Card'){$jmldebit = $jns_amount;}
	 elseif($jns_pay =='Credit Card'){$jmlcredit = $jns_amount;}
	 elseif($jns_pay =='Cash'){$jmlcash = $jns_amount;}
	 elseif($jns_pay =='Transfer'){$jmltransfer = $jns_amount;}
	 elseif($jns_pay =='Cek-Bg'){$jmlcekbg = $jns_amount;}
	 elseif($jns_pay =='Voucher'){$jmlvoucher = $jns_amount;}
	}

?>
    <div class="row">
      <!-- accepted payments column -->
      <div class="col-xs-3">
        <p class="style33">Prepared By</p>
        <p class="text-muted well well-sm no-shadow" style="margin-top: 10px;">&nbsp;</p>
      </div>
      <div class="col-xs-3">
        <p class="style33">Received By</p>
        <p class="text-muted well well-sm no-shadow" style="margin-top: 10px;">&nbsp;</p>
      </div>
      <!-- /.col -->
      <div class="col-xs-5">
        <div class="table-responsive"></div>
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
