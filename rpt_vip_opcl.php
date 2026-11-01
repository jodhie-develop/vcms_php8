<?php
require_once __DIR__ . "/_lib/bootstrap.php"; auth_require_login(); 
include __DIR__ . "/conndb.php";
//include __DIR__ . "/profiledata.php";
 //include __DIR__ . "/atas.php";
$hari=date("d");
$bulan=date("m");
$tahun=date("Y");
$hari_ini = "$tahun-$bulan-$hari";
$date_start = in_val('date_start', 'get');
$date_end = in_val('date_end', 'get');

if ($date_start ==''){$date_start = "2019-01-01";}
if ($date_end ==''){$date_end = $hari_ini;}

$nama_lengkap = $_SESSION['nama_lengkap'];
$posisi = $_SESSION['posisi']; 
$kd_staff = $_SESSION['kd_staff'] ;
if ($nama_depan == 'Ira00' or $nama_depan == 'hanifa07' or $nama_depan == 'resty04'){
$kd_cbg = in_val('kd_cbg', 'get');
}
else
{$kd_cbg = $_SESSION['kd_branch'];}
if ($kd_cbg == 'National'){$kd_cbg = 100;}

if ($kd_cbg == 'East Sby'){$kd_cbg = 1;}
if ($kd_cbg == 'West Sby'){$kd_cbg = 2;}
if ($kd_cbg == 'Denpasar'){$kd_cbg = 3;}
if ($kd_cbg == 'South Jkt'){$kd_cbg = 4;}
if ($kd_cbg == 'North Jkt'){$kd_cbg = 5;}
if ($kd_cbg == 'West Jkt'){$kd_cbg = 6;}
if ($kd_cbg == 'Bandung'){$kd_cbg = 7;}
if ($kd_cbg == 'Malang'){$kd_cbg = 8;}
if ($kd_cbg == 'East Area'){$kd_cbg = 101;}
if ($kd_cbg == 'West Area'){$kd_cbg = 102;}


if (num($kd_cbg) ==100){$cabang = 'National';}
if ($kd_cbg ==''){$cabang = 'National';}

if (num($kd_cbg) ==1){$cabang = 'East Sby';}
if (num($kd_cbg) ==2){$cabang = 'West Sby';}
if (num($kd_cbg) ==3){$cabang = 'Denpasar';}
if (num($kd_cbg) ==4){$cabang = 'South Jkt';}
if (num($kd_cbg) ==5){$cabang = 'North Jkt';}
if (num($kd_cbg) ==6){$cabang = 'West Jkt';}
if (num($kd_cbg) ==7){$cabang = 'Bandung';}
if (num($kd_cbg) ==8){$cabang = 'Malang';}
if (num($kd_cbg) ==101){$cabang = 'East Area';}
if (num($kd_cbg) ==102){$cabang = 'West Area';}



$pilihan_sc = in_val('pilihan_sc', 'get');
if ($pilihan_sc ==''){$pilihan_sc = 'All Leads';}

if($kd_cbg == '100' or $kd_cbg ==''){$filter_cbg = q_set($__p_filter_cbg, " ");}
elseif ($kd_cbg == '101'){$filter_cbg = q_set($__p_filter_cbg, " where (a.kd_branch = '1' or a.kd_branch = '1' or a.kd_branch = '3' or a.kd_branch = '8'  )  ");}
elseif ($kd_cbg == '102'){$filter_cbg = q_set($__p_filter_cbg, " where (a.kd_branch = '4' or a.kd_branch = '5' or a.kd_branch = '6' or a.kd_branch = '7'  )  ");}
else {$filter_cbg = q_set($__p_filter_cbg, " where a.kd_branch = ? ", [(string) ($kd_cbg)]);}
if ($filter_cbg =='') {$filter_tgl = q_set($__p_filter_tgl, " where f.min_mulai\t between ? and ? ", [(string) ($date_start) . " 00:00:00", (string) ($date_end) . " 23:00:00"]);}
else {$filter_tgl = q_set($__p_filter_tgl, " and f.min_mulai between ? and ? ", [(string) ($date_start) . " 00:00:00", (string) ($date_end) . " 23:00:00"]);}

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
      <div class="col-xs-12" align="left">
        <h2 class="page-header">
          VIP Open Class<br>
       <?php echo e($cabang) ?><br>
       Date Period: <?php echo e($date_start) ?>To <?php echo e($date_end) ?></h2>
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
        <table width="100%" class="table table-bordered table-striped" id="example3">
	        <thead>
	          <tr>
	            <td width=9% height="14" align=center >Month</td>
	            <td width=4% align=center >Week</td>
	            <td width=2% align=center >No</td>
	            <td width=9% align=center >Class</td>
	            <td width=2% align=center >No </td>
	            <td width=21% align=center >Name</td>
	            <td width=9% align=center >Hours</td>
	            <td width=9% align=center >No <br>
                of Student</td>
	            <td width=9% align=center >Period</td>
	            <td width=9% align=center >Schedule(Days)</td>
	            <td width="8%" align=center >Teacher</td>
	            <td width="11%" align=center >Remark</td>
              </tr>
            </thead>
	        <?php 
//===jika ada billing
//$query_billing = "SELECT a.kd_billing,b.nm_program, b.level_program, b.type_program, sum(net_tf+reg_fee+material_cost) as invoiced,a.dt_entry,c.nama, c.middle_name, c.family_name,a.kd_biodata FROM ves_data.vip_billing a left join ves_data.vip_mst_code_prg b on a.kd_program = b.kd_program left join ves_inc.tb_biodata c on a.kd_biodata = c.kd_biodata where a.kd_branch = '$kd_cbg' and a.dt_entry between '$date_start' and '$date_end' group by a.kd_billing order by a.kd_billing" ;
//						   echo $query_billing;
						   
//$resource_billing = mysql_query($query_billing);
//$keluar_billing = db_num_rows($resource_billing);
					   ?>
	        <tbody>
	          <?php	
	$adafile = 0;
				$urut_no = 1;
$query_open_class = q_set($__p_query_open_class, "SELECT date_format(mulai_tm, '%M'),h.minggu, e.nama_lengkap, a.kelas, b.duration_program,date_format(mulai_tm,'%b %d, %Y') FROM ves_data.vip_teacher_schedule a\r
left join ves_data.vip_mst_code_prg b on a.kode_program = b.kd_program and a.level_program = b.level_program\r
left join ves_data.vip_billing g  on a.kelas = g.kd_class\r
left join ves_data.vip_student_data e  on g.kd_biodata = e.kd_biodata\r
left join ves_data.tb_minggu_detail h  on date_format(a.mulai_tm, '%Y-%m-%d') = date_format(h.detail, '%Y-%m-%d')\r
\r
INNER JOIN ( SELECT kelas, MIN(mulai_tm) AS min_mulai FROM vip_teacher_schedule\r
GROUP BY kelas ) f ON a.kelas = f.kelas AND a.mulai_tm = f.min_mulai " . $filter_cbg . "  " . $filter_tgl . " and a.kd_biodata = '' and a.status_kelas = 1\r
 group by a.kelas, e.kd_biodata order by mulai_tm", [...($__p_filter_cbg ?? []), ...($__p_filter_tgl ?? [])]); 

$resource_open_class = db_query_soft($query_open_class, $__p_query_open_class ?? []);
$keluar_open_class = db_num_rows($resource_open_class);				
if(num(db_num_rows($resource_open_class)) > 0)
	{
	while ($row_open_class  =  db_fetch($resource_open_class, PDO::FETCH_NUM))
		{
		$kelas_baru = $row_open_class[3];
		if ($kelas_lama  != $kelas_baru){$hitungperkelas = 1;}
		$query_jml_murid = q_set($__p_query_jml_murid, "SELECT count(kd_billing) as jml FROM ves_data.vip_billing where kd_class= ? and kd_branch = ? ", [(string) ($row_open_class[3]), (string) ($kd_cbg)]);
		$resource_jml_murid = db_query_soft($query_jml_murid, $__p_query_jml_murid ?? []);
		$keluar_jml_murid = db_num_rows($resource_jml_murid);				
		if(num(db_num_rows($resource_jml_murid)) > 0)
			{
			while ($row_jml_murid  =  db_fetch($resource_jml_murid, PDO::FETCH_NUM))
				{	
				$jml_murid = $row_jml_murid[0];
				}
			}
		$query_last_date = q_set($__p_query_last_date, "SELECT max(mulai_tm) as selesai,date_format(max(mulai_tm),'%b %d, %Y') FROM ves_data.vip_teacher_schedule a where a.kelas = ? ", [(string) ($row_open_class[3])]);
		$resource_last_date = db_query_soft($query_last_date, $__p_query_last_date ?? []);
		$keluar_last_date = db_num_rows($resource_last_date);				
		if(num(db_num_rows($resource_last_date)) > 0)
			{
			while ($row_last_date  =  db_fetch($resource_last_date, PDO::FETCH_NUM))
				{
				$kelas_selesai = $row_last_date[1];					
				}
			}
//		$query_time_teacher = "select date_format(mulai_tm, '%a'),  date_format(mulai_tm, '%H:%i'),date_format(selesai_tm, '%H:%i'),nm_teacher 	
		$query_time_teacher = q_set($__p_query_time_teacher, "select nm_teacher from vip_teacher_schedule where kelas = ? group by  nm_teacher", [(string) ($row_open_class[3])]);
			
		$resource_time_teacher = db_query_soft($query_time_teacher, $__p_query_time_teacher ?? []);		
		if(num(db_num_rows($resource_time_teacher)) > 0)
			{
			while ($row_time_teacher  =  db_fetch($resource_time_teacher, PDO::FETCH_NUM))
				{
				//$jadwal_1= "$row_time_teacher[0] ($row_time_teacher[1]-$row_time_teacher[2]) - $row_time_teacher[3]<br>";
				$infoteacher= "$row_time_teacher[0]";
					
				//$baris_jadwal = "$baris_jadwal $jadwal_1";	
				$baris_teacher = "$baris_teacher $infoteacher";	
					
				}
			}
		$query_day_teacher = q_set($__p_query_day_teacher, "select date_format(mulai_tm,'%a') from vip_teacher_schedule where kelas = ? group by date_format(mulai_tm,'%a') ", [(string) ($row_open_class[3])]);
			
		$resource_day_teacher = db_query_soft($query_day_teacher, $__p_query_day_teacher ?? []);		
		if(num(db_num_rows($resource_day_teacher)) > 0)
			{
			while ($row_day_teacher  =  db_fetch($resource_day_teacher, PDO::FETCH_NUM))
				{
				//$jadwal_1= "$row_time_teacher[0] ($row_time_teacher[1]-$row_time_teacher[2]) - $row_time_teacher[3]<br>";
				$infoday= "$row_day_teacher[0]";
					
				//$baris_jadwal = "$baris_jadwal $jadwal_1";	
				$baris_day = "$baris_day $infoday";	
					
				}
			}			
			
	?>
<?php if (num($hitungperkelas) ==1){?>
	          <tr>
	            <td height="14" colspan="12" align=center bgcolor="#E9DBDB" class="style24">&nbsp;</td>
              </tr>
<?php } ?>          
	          <tr>
	            <td height="14" align=center class="style24"><?php echo  e($row_open_class[0])  ?></td>
	            <td align=center class="style24"><?php echo  e($row_open_class[1])  ?></td>
	            <td align=center class="style24"><?php echo e($urut_no) ?></td>
	            <td align=center class="style24"><?php echo  e($row_open_class[3])  ?></td>
	            <td align=center class="style24"><?php echo e($hitungperkelas) ?></td>
	            <td align=left class="style24"><?php echo  e($row_open_class[2])  ?></td>
	            <td align=center class="style24"><?php echo  e($row_open_class[4])  ?></td>
	            <td align=center class="style24"><?php echo  e($jml_murid)  ?></td>
	            <td align=center class="style24"><?php echo  e($row_open_class[5])  ?> - <?php echo  e($kelas_selesai)  ?></td>
				  <td align=center class="style24"><?php echo  e($baris_day)  ?></td>
	            <td align=center class="style24"><?php echo e($baris_teacher) ?></td>
	            <td align=center class="style24">&nbsp;</td>
              </tr>

	          <?php 	$adafile = 0; 				$jadwal_1= '';
				$baris_teacher = '';$baris_day=''; $kelas_lama = $kelas_baru;$hitungperkelas = num($hitungperkelas) +1; $urut_no = num($urut_no)+1;}} ?>
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
	
	
$result_jns_pay=db_query_or_die("Wah error nih1", $query_jns_pay, $__p_query_jns_pay ?? []);	
while ($r_jns_pay = db_fetch($result_jns_pay))
	{ $jns_pay = $r_jns_pay[0]; $jns_amount = $r_jns_pay[1];
	 if($jns_pay =='Debit Card'){$jmldebit = $jns_amount;}
	 elseif($jns_pay =='Credit Card'){$jmlcredit = $jns_amount;}
	 elseif($jns_pay =='Cash'){$jmlcash = $jns_amount;}
	 elseif($jns_pay =='Transfer'){$jmltransfer = $jns_amount;}
	 elseif($jns_pay =='Cek-Bg'){$jmlcekbg = $jns_amount;}
	 elseif($jns_pay =='Voucher'){$jmlvoucher = $jns_amount;}
	}
$query_jns_pay_lama = q_set($__p_query_jns_pay_lama, "SELECT  pay_mtd,   sum(mount_pat) as jumlah FROM " . ($db_cabang ?? '') . "tb_receipt where waktu between ? and ? group by pay_mtd ", [(string) ($date_start), (string) ($date_end)]);
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
$jml_tot = num($jmldebit)+num($jmlcash)+num($jmlcredit)+num($jmltransfer)+num($jmlcekbg)+num($jmlvoucher)+num($jmldebit_lama)+num($jmlcash_lama)+num($jmlcredit_lama)+num($jmltransfer_lama)+num($jmlcekbg_lama)+num($jmlvoucher_lama);	
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
              <th>&nbsp;</th>
              <td>&nbsp;</td>
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
