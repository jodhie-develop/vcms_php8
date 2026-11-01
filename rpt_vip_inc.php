<?php
require_once __DIR__ . "/_lib/bootstrap.php"; auth_require_login(); 
include __DIR__ . "/conndb.php";
include __DIR__ . "/profiledata.php";
include __DIR__ . "/atas.php";
$q = in_val('q', 'get');
$hari=date("d");
$bulan=date("m");
$tahun=date("Y");
$hari_ini = "$tahun-$bulan-$hari";
$date_start = in_val('date_start', 'get');
$date_end = in_val('date_end', 'get');
$kd_cbg = in_val('kd_cbg', 'get');

$pilihan_sc = in_val('pilihan_sc', 'get');
if ($pilihan_sc ==''){$pilihan_sc = 'My Leads';}
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

if (num($kd_cbg) ==0){$cabang = '--ALL--';}
if ($kd_cbg ==''){$cabang = '--ALL--';}
if (num($kd_cbg) ==1){$cabang = 'East Sby';$db_cabang = q_set($__p_db_cabang, "billing.");}
if (num($kd_cbg) ==2){$cabang = 'West Sby';$db_cabang = q_set($__p_db_cabang, "billing_west.");}
if (num($kd_cbg) ==3){$cabang = 'Denpasar';$db_cabang = q_set($__p_db_cabang, "billing_bali.");}
if (num($kd_cbg) ==4){$cabang = 'South Jkt';$db_cabang = q_set($__p_db_cabang, "billing_jkt_02.");}
if (num($kd_cbg) ==5){$cabang = 'North Jkt';$db_cabang = q_set($__p_db_cabang, "billing_new_gs.");}
if (num($kd_cbg) ==6){$cabang = 'West Jkt';$db_cabang = q_set($__p_db_cabang, "billing_m2.");}
if (num($kd_cbg) ==7){$cabang = 'Bandung';$db_cabang = q_set($__p_db_cabang, "billing_new_bdg.");}
if (num($kd_cbg) ==8){$cabang = 'Malang TBI';$db_cabang = q_set($__p_db_cabang, "billing_malang.");}

$nama_lengkap = $_SESSION['nama_lengkap'];
$nama_depan = $_SESSION['nama_depan'];
$posisi = $_SESSION['posisi']; 
$kd_staff = $_SESSION['kd_staff'] ;



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
          </i> VIP Income Summary
          
          <br>
       </i><?php echo e($cabang) ?><small class="pull-right">Date Period: <?php echo e($date_start) ?>To <?php echo e($date_end) ?></small> </h2>
      </div>
      <!-- /.col -->
    </div>
    <!-- info row -->
    <div class="row invoice-info"><!-- /.col --><!-- /.col --><!-- /.col -->
    </div>
    <!-- /.row -->
     <?php 

$query = q_set($__p_query, "SELECT date_format(a.dt_payment,'%d/%m/%Y'), date_format(a.dt_cetak,'%d/%m/%Y'), MID(a.id_receipt,1,4), a.kd_biodata, b.kd_program,a.kd_branch,amount, jns_Payment,a.pay_mtd   FROM vip_billing_payment a left join vip_billing b on a.kd_biodata = b.kd_biodata and a.kd_billing = b.kd_billing where a.id_receipt <> '' and a.kd_branch = ?\r
and dt_payment between ? and ? group by id_receipt order by id_receipt", [(string) ($kd_cbg), (string) ($date_start), (string) ($date_end)]);	

$no_urut = 1;
$result=db_query_or_die("Wah error nih1", $query, $__p_query ?? []);
$num_rows = db_num_rows($result);?>
    <!-- Table row -->
    <div class="row">
      <div class="col-xs-12 table-responsive">
        <table width="97%" class="table table-bordered table-striped" id="example222">
     
            <tr>
              <th width="2%" class="style33">No</th>
              <th width="7%" class="style33">Effective Date</th>
              <th width="7%" class="style33"> Receipt Date</th>
              <th width="21%" class="style33">Student Name</th>
              <th width="8%" class="style33">Receipt Number</th>
              <th width="19%" class="style33">Program</th>
              <th width="15%" class="style33">Detail</th>
              <th width="8%" class="style33">Amount</th>
              <th width="13%" class="style33">Payment Metodh</th>
            </tr>
       
          <tbody>
            <?php 
					if ($result) 
						{ 
						while ($r = db_fetch($result))
							{
							$query_nama = q_set($__p_query_nama, "SELECT concat_ws(' ',nama, middle_name) from ves_inc.tb_biodata where kd_biodata = ? and kd_branch = ? ", [(string) ($r[3]), (string) ($r[5])]);
							$result_nama=db_query_or_die("Wah error nih1", $query_nama, $__p_query_nama ?? []);	
							while ($r_nama = db_fetch($result_nama))
								{ $nama_student = $r_nama[0];}
							$query_program = q_set($__p_query_program, "SELECT type_program, level_program, buku FROM ves_data.vip_mst_code_prg  where kd_program =  ? group by kd_program", [(string) ($r[4])]);
							$result_program=db_query_or_die("Wah error nih1", $query_program, $__p_query_program ?? []);	
							while ($r_program = db_fetch($result_program))
								{ $nama_program = $r_program[0];$jenis_program = $r_program[1];}		
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
              <td class="style33"><?php echo e($no_urut) ; ?></td>
              <td class="style33"><?php echo e($r[0]) ; ?></td>
              <td class="style33"><?php echo e($r[1]) ; ?></td>
              <td class="style33"><?php echo e($nama_student) ; ?></td>
              <td class="style33"><?php echo e($r[2]) ; ?></td>
              <td class="style33"><?php echo e($nama_program) ; ?> - <?php echo e($jenis_program) ; ?></td>
              <td class="style33"><?php echo e($r[7]) ; ?></td>
              <td class="style33"><?php echo number_format(num($r[6]),0,".",".") ; ?></td>
              <td class="style33"><?php echo e($r[8]) ; ?></td>
            </tr>
            <?php $no_urut = num($no_urut) + 1; } }
$query_lama = q_set($__p_query_lama, "select date_format(waktu,'%d/%m/%Y'), date_format(tgl_cetak,'%d/%m/%Y'), nm_student,  MID(id_receipt,1,4), nm_prg, mount_pat, jns_pay,pay_mtd from " . $db_cabang . "tb_receipt where waktu between ? and ? order by tgl_pay", [...($__p_db_cabang ?? []), (string) ($date_start), (string) ($date_end)]);
				
							$result_lama=db_query_or_die("Wah error nih1", $query_lama, $__p_query_lama ?? []);	
							while ($r_lama = db_fetch($result_lama))
								{ 
					?><tr>
                  <td class="style33"><?php echo e($no_urut) ; ?></td>
                  <td class="style33"><?php echo e($r_lama[0]) ; ?></td>
                  <td class="style33"><?php echo e($r_lama[1]) ; ?></td>
                  <td class="style33"><?php echo e($r_lama[2]) ; ?></td>
                  <td class="style33"><?php echo e($r_lama[3]) ; ?></td>
                  <td class="style33"><?php echo e($r_lama[4]) ; ?></td>
                  <td class="style33"><?php echo number_format(num($r_lama[5]),0,".",".")  ; ?></td>
                  <td class="style33"><?php echo  e($r_lama[6]) ; ?></td>
                  <td class="style33"><?php echo e($r_lama[7]) ; ?></td>  </tr>
                  <?php $total_rp = num($total_rp) + num($r_lama[5]); $no_urut = num($no_urut) + 1; }  ?>              
          </tbody>
          <tfoot>
          </tfoot>
        </table>
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->
<?php
$query_jns_pay = q_set($__p_query_jns_pay, "SELECT  a.pay_mtd,   sum(amount) as jumlah FROM vip_billing_payment a where a.id_receipt <> '' and a.kd_branch = ?\r
and dt_payment between ? and ? group by a.pay_mtd order by id_receipt", [(string) ($kd_cbg), (string) ($date_start), (string) ($date_end)]);
	
	
$result_jns_pay=db_query_or_die("Wah error nih1", $query_jns_pay, $__p_query_jns_pay ?? []);	
while ($r_jns_pay = db_fetch($result_jns_pay))
	{ $jns_pay = $r_jns_pay[0]; $jns_amount = $r_jns_pay[1];
	 if($jns_pay =='Debit Card'){$jmldebit = $jns_amount;}
	 elseif($jns_pay =='Credit Card'){$jmlcredit = $jns_amount;}
	 elseif($jns_pay =='Cash'){$jmlcash = $jns_amount;}
	 elseif($jns_pay =='Transfer'){$jmltransfer = $jns_amount;}
	 elseif($jns_pay =='Cek-Bg'){$jmlcekbg = $jns_amount;}
	 elseif($jns_pay =='Voucher'){$jmlvoucher = $jns_amount;}
	 elseif($jns_pay =='QRIS'){$jmlqris = $jns_amount;}	 
	}
$query_jns_pay_lama = q_set($__p_query_jns_pay_lama, "SELECT  pay_mtd,   sum(mount_pat) as jumlah FROM " . $db_cabang . "tb_receipt where waktu between ? and ? group by pay_mtd ", [...($__p_db_cabang ?? []), (string) ($date_start), (string) ($date_end)]);
$result_jns_pay_lama=db_query_or_die("Wah error nih1", $query_jns_pay_lama, $__p_query_jns_pay_lama ?? []);	
while ($r_jns_pay_lama = db_fetch($result_jns_pay_lama))
	{ $jns_pay_lama = $r_jns_pay_lama[0]; $jns_amount_lama = $r_jns_pay_lama[1];
	 if($jns_pay_lama =='Debit Card'){$jmldebit_lama = $jns_amount_lama;}
	 elseif($jns_pay_lama =='Credit Card'){$jmlcredit_lama = $jns_amount_lama;}
	 elseif($jns_pay_lama =='Cash'){$jmlcash_lama = $jns_amount_lama;}
	 elseif($jns_pay_lama =='Transfer'){$jmltransfer_lama = $jns_amount_lama;}
	 elseif($jns_pay_lama =='Cek-Bg'){$jmlcekbg_lama = $jns_amount_lama;}
	 elseif($jns_pay_lama =='Voucher'){$jmlvoucher_lama = $jns_amount_lama;}
	}
$jml_tot = num($jmlqris)+num($jmldebit)+num($jmlcash)+num($jmlcredit)+num($jmltransfer)+num($jmlcekbg)+num($jmlvoucher)+num($jmldebit_lama)+num($jmlcash_lama)+num($jmlcredit_lama)+num($jmltransfer_lama)+num($jmlcekbg_lama)+num($jmlvoucher_lama);	
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
        <div class="table-responsive">
          <table class="table">
            <tr>
              <th width="19%" class="style33">Transfer</th>
              <td width="59%" class="style33" align="right"><?php echo number_format(num($jmltransfer),0,".",".") ; ?></td>
              <td width="1%">&nbsp;</td>
              <td width="2%">&nbsp;</td>
              <td width="9%" class="style33"><strong>Cash</strong></span></td>
              <td width="10%" class="style33" align="right"><?php echo number_format(num($jmlcash),0,".",".") ; ?></td>
            </tr>
            <tr>
              <th class="style33">Debit Card</th>
              <td class="style33" align="right"><?php echo number_format(num($jmldebit),0,".",".") ; ?></td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td class="style33"><strong>Credit Card</strong></span></td>
              <td class="style33" align="right"><?php echo number_format(num($jmlcredit),0,".",".") ; ?></td>
            </tr>
            <tr>
              <th><span class="style33">Qris</span></th>
              <td class="style33" align="right"><?php echo number_format(num($jmlqris),0,".",".") ; ?></td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <th colspan="2" align="right">Total:</th>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td  align="right"><span class="style33"><?php echo number_format(num($jml_tot),0,".",".") ; ?></span></td>
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
