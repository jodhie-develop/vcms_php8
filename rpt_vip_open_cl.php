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
$date_start = in_val('date_start', 'get');
$date_end = in_val('date_end', 'get');
if ($date_start ==''){$date_start = "$tahun-$bulan-01";}
if ($date_end ==''){$date_end = $hari_ini;}


$kd_cbg = in_val('kd_cbg', 'get');

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

$nama_lengkap = $_SESSION['nama_lengkap'];
$nama_depan = $_SESSION['nama_depan'];
$kd_cbg = $_SESSION['kd_branch'];
$posisi = $_SESSION['posisi']; 
$kd_staff = $_SESSION['kd_staff'] ;
$kdprg = in_val('kdprg', 'get');

if (num($kd_cbg) ==1){$cabang = 'East Sby';}
if (num($kd_cbg) ==2){$cabang = 'West Sby';}
if (num($kd_cbg) ==3){$cabang = 'Denpasar';}
if (num($kd_cbg) ==4){$cabang = 'South Jkt';}
if (num($kd_cbg) ==5){$cabang = 'North Jkt';}
if (num($kd_cbg) ==6){$cabang = 'West Jkt';}
if (num($kd_cbg) ==7){$cabang = 'Bandung';}
if (num($kd_cbg) ==8){$cabang = 'Malang';}





$pilihan_sc = in_val('pilihan_sc', 'get');
if ($pilihan_sc ==''){$pilihan_sc = 'All Leads';}
$cd_cl = in_val('cd_cl', 'get');
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

	.style35 {
	color:#000;
	font-size:75%;
	}
	.style34 {
	color:#000;
	font-size:45%;
	}
	.style35 {
	color:#000;
	font-size:55%;
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
     <?php  //    include __DIR__ . "/left.php";	 ?>

         <?php	
	$dibayar = 0;
				$nomor = 1;
			$nm_t = '';
$query_billing = q_set($__p_query_billing, "SELECT c.nm_teacher, b.type_program, b.nm_program, b.level_program,c.kelas, date_format(min(mulai_tm),'%d %b %y') , date_format(max(mulai_tm),'%d %b %y') FROM ves_data.vip_teacher_schedule c\r
left join ves_data.vip_mst_code_prg b on c.kode_program = b.kd_program where c.kd_branch = ? and c.kelas = ?  group by c.kelas", [(string) ($kd_cbg), (string) ($cd_cl)]);
		
$resource_billing = db_query_soft($query_billing, $__p_query_billing ?? []);
$keluar_billing = db_num_rows($resource_billing);				
if(num(db_num_rows($resource_billing)) > 0)
	{
	while ($row_billing  =  db_fetch($resource_billing, PDO::FETCH_NUM))
		{
		$Program_info = "$row_billing[1] $row_billing[2] $row_billing[3]";
		$periode_kelas = "$row_billing[5] to $row_billing[6]";
		
		}
	}
	

	?>        
  <table width="684" id="">

	        <tbody>

	          <tr>
	            <td height="14" colspan="3" align=center  class="style34"><p><strong>Open Class Payment Detail</strong><strong><br>
	              <?php echo e($cd_cl); ?></strong> </p>
	              <p><br>
                </p></td>
              </tr>
	          <tr>
	            <td width="129" height="14" align=center   class="style34" >Center<br><?php echo e($cabang); ?></td>
	            <td width="335" align=center   class="style34" >Program<br><?php echo e($Program_info); ?></td>
	            <td width="204" align=center   class="style34">Class Period<br><?php echo e($periode_kelas); ?></td>
              </tr>
				    </tbody>
            <tfoot>
            </tfoot>
          </table>
  <br>
  <table width="823" id="table">
    <tbody>
	          <tr>
	            <td width="239" height="14" align=center   class="style34" >Day</td>
	            <td width="183" align=center   class="style34">Time</td>
	            <td width="225" align=center  class="style34" >Room</td>
	            <td width="192" align=center  class="style34" >Teacher</td>
              </tr>
              		      	                <?php	
				
$query_data = q_set($__p_query_data, "SELECT c.nm_teacher, date_format(mulai_tm,'%W'),date_format(mulai_tm,'%k:%i'), date_format(selesai_tm,'%k:%i'),room\r
 FROM ves_data.vip_teacher_schedule c left join ves_data.vip_mst_code_prg b on c.kode_program = b.kd_program where c.kd_branch = ?\r
and c.kelas = ? group by date_format(mulai_tm,'%W')", [(string) ($kd_cbg), (string) ($cd_cl)]);
		
$resource_data = db_query_soft($query_data, $__p_query_data ?? []);
$keluar_data = db_num_rows($resource_data);				
if(num(db_num_rows($resource_data)) > 0)
	{
	while ($row_data  =  db_fetch($resource_data, PDO::FETCH_NUM))
		{
		$sch_teacher = $row_data[0];
		$sch_hari = $row_data[1];
		$sch_jam = "$row_data[2]-$row_data[3]";
		$sch_room = $row_data[4];
	
	?> 
	          <tr>
	            <td height="14" align=center   class="style34" ><?php echo e($sch_hari); ?></td>
	            <td align=center  class="style34" ><?php echo e($sch_jam); ?></td>
	            <td align=center  class="style34" ><?php echo e($sch_room); ?></td>
	            <td align=center  class="style34" ><?php echo e($sch_teacher); ?></td>
              </tr><?php }} ?>
        </tbody>
            <tfoot>
            </tfoot>
        </table>
      </div>
      <!-- /.col -->
    </div>
    <!-- info row -->
    <div class="row invoice-info"><!-- /.col --><!-- /.col --><!-- /.col -->
    </div>
    <!-- /.row -->
     <?php 

$query = q_set($__p_query, "SELECT date_format(min(a.dt_payment),'%d/%m/%Y'), date_format(min(a.dt_cetak),'%d/%m/%Y'), MID(a.id_receipt,1,4), a.kd_biodata, b.kd_program,a.kd_branch,amount, jns_Payment,a.pay_mtd   FROM vip_billing_payment a left join vip_billing b on a.kd_biodata = b.kd_biodata where a.id_receipt <> '' and a.kd_branch = ?\r
and dt_payment between ? and ? group by id_receipt order by id_receipt", [(string) ($kd_cbg), (string) ($date_start), (string) ($date_end)]);		
$no_urut = 1;
$result=db_query_or_die("Wah error nih1", $query, $__p_query ?? []);
$num_rows = db_num_rows($result);?>
    <!-- Table row -->
    <div class="row">
      <div class="col-xs-12 table-responsive">
        <table width="815" class="table table-bordered table-striped"  id=""  >
        <thead><small>
	          <tr>
	            <td width="18" rowspan="2" align=center bgcolor=#CCCCCC class="style35" >NO</td>
	            <td width="40" rowspan="2" align=center bgcolor=#CCCCCC class="style35"><br>
	              <br>
                Student Name </td>
	            <td colspan="2" align=center bgcolor=#CCCCCC class="style35">Registration <br></td>
	            <td colspan="2" align=center bgcolor=#CCCCCC class="style35">Material <br>
Cost</td>
	            <td width=36 rowspan="2" align=center bgcolor=#CCCCCC class="style35">Disc</td>
	            <td width=39 rowspan="2" align=center bgcolor=#CCCCCC class="style35">Neet<br>
	              Tuition Fee</td>
	            <td colspan="2" align=center bgcolor=#CCCCCC class="style35">Full Payment</td>
	            <td colspan="2" align=center bgcolor=#CCCCCC class="style35">DP</td>
	            <td colspan="2" align=center bgcolor=#CCCCCC class="style35">Payment 1</td>
	            <td colspan="2" align=center bgcolor=#CCCCCC class="style35">Payment 2</td>
	            <td colspan="2" align=center bgcolor=#CCCCCC class="style35">Payment 3</td>
	            <td colspan="2" rowspan="2" align=center bgcolor=#CCCCCC class="style35">Outstanding Balance</td>
              </tr>
	          </small><tr>
<td width="37" align=center bgcolor=#CCCCCC class="style35">Receipt</td>
        <td width=40 align=center bgcolor=#CCCCCC class="style35">Amount</td>
        <td width="37" align=center bgcolor=#CCCCCC class="style35">Receipt</td>
        <td width="40" align=center bgcolor=#CCCCCC class="style35">Amount</td>
        <td width="37" align=center bgcolor=#CCCCCC class="style35">Receipt</td>
        <td width="40" align=center bgcolor=#CCCCCC class="style35">Amount</td>
        <td width="37" align=center bgcolor=#CCCCCC class="style35">Receipt</td>
        <td width="40" align=center bgcolor=#CCCCCC class="style35">Amount</td>
        <td width="37" align=center bgcolor=#CCCCCC class="style35">Receipt</td>
        <td width="40" align=center bgcolor=#CCCCCC class="style35">Amount</td>
        <td width="37" align=center bgcolor=#CCCCCC class="style35">Receipt</td>
        <td width="40" align=center bgcolor=#CCCCCC class="style35">Amount</td>
        <td width="37" align=center bgcolor=#CCCCCC class="style35">Receipt</td>
        <td width="40" align=center bgcolor=#CCCCCC class="style35">Amount</td>
        </tr>
            </thead>
		<?php 
//===jika ada billing
//$query_billing = "SELECT a.kd_billing,b.nm_program, b.level_program, b.type_program, sum(net_tf+reg_fee+material_cost) as invoiced,a.dt_entry,c.nama, c.middle_name, c.family_name,a.kd_biodata FROM ves_data.vip_billing a left join ves_data.vip_mst_code_prg b on a.kd_program = b.kd_program left join ves_inc.tb_biodata c on a.kd_biodata = c.kd_biodata where a.kd_branch = '$kd_cbg' and a.dt_entry between '$date_start' and '$date_end' group by a.kd_billing order by a.kd_billing" ;
//						   /* echo $query_billing (debug SQL versi lama) dihapus */
						   
//$resource_billing = mysql_query($query_billing);
//$keluar_billing = db_num_rows($resource_billing);
					   ?>
	        <tbody>
          <?php	
	$dibayar = 0;
				$nomor = 1;
$query_billing = q_set($__p_query_billing, "SELECT concat_ws(' ',b.nama, b.middle_name, b.family_name) as nama, kd_class,tf,promo_persen,\r
discount,net_tf,reg_fee,material_cost,a.kd_billing,a.sc\r
FROM ves_data.vip_billing a left join ves_inc.tb_biodata b on a.kd_biodata = b.kd_biodata left join vip_teacher_schedule c on a.kd_class = c.kelas where a.kd_branch = ? and kd_class = ? group by a.kd_billing", [(string) ($kd_cbg), (string) ($cd_cl)]);

$resource_billing = db_query_soft($query_billing, $__p_query_billing ?? []);
$keluar_billing = db_num_rows($resource_billing);				
if(num(db_num_rows($resource_billing)) > 0)
	{
	while ($row_billing  =  db_fetch($resource_billing, PDO::FETCH_NUM))
		{
		$hrg_net = $row_billing[5];
		$jdwl='';
		$query_score = q_set($__p_query_score, "SELECT date_format(mulai_tm,'%a') as hr,\r
date_format(mulai_tm,'%H') as mulai,\r
date_format(selesai_tm,'%H') as selesai,\r
nm_teacher  FROM ves_data.vip_teacher_schedule where kelas = ? group by date_format(mulai_tm,'%a') order by date_format(mulai_tm,'%w')", [(string) ($row_billing[1])]);
		$resource_score = db_query_soft($query_score, $__p_query_score ?? []);
		$keluar_score = db_num_rows($resource_score);	
		if(num(db_num_rows($resource_score)) > 0)
			{
			while ($row_score  =  db_fetch($resource_score, PDO::FETCH_NUM))	
				{
				$hr = $row_score[0];$mulai = $row_score[1];$selesai = $row_score[2];$nmt = $row_score[3];
				$jdwl  = $jdwl . " " . e($hr) . " " . e($mulai) . "-" . e($selesai) . " " . e($nmt) . "<br>";
				}
			}
	
			//==reg==
//		$query_dp_ins ="SELECT id_receipt, amount, dt_payment  FROM ves_data.vip_billing_payment where  jns_payment = 'Down Payment' or jns_payment like 'Installment%'  or jns_payment like 'Full%') and kd_billing = '$row_billing[8]' and status = 'PAID'"; 
		$query_reg_ins = q_set($__p_query_reg_ins, "SELECT id_receipt, DATE_FORMAT(dt_payment,'%d/%m/%y'), amount  FROM ves_data.vip_billing_payment where  jns_payment = 'Registration' and kd_billing = ? ", [(string) ($row_billing[8])]); 
		$resource_reg_ins = db_query_or_die('errro_7', $query_reg_ins, $__p_query_reg_ins ?? []);
			while ($row_reg_ins=  db_fetch($resource_reg_ins, PDO::FETCH_NUM))
			{
			$reg_receipt =   $row_reg_ins[0];	
			$reg_date =   $row_reg_ins[1];	
			$reg_amount =   $row_reg_ins[2];	
			//if ($reg_amount != 0 or $reg_amount != ''){$dibayar = $dibayar + $reg_amount;}
			}			
	
			//==mc==
//		$query_dp_ins ="SELECT id_receipt, amount, dt_payment  FROM ves_data.vip_billing_payment where  jns_payment = 'Down Payment' or jns_payment like 'Installment%'  or jns_payment like 'Full%') and kd_billing = '$row_billing[8]' and status = 'PAID'"; 
		$query_mc_ins = q_set($__p_query_mc_ins, "SELECT id_receipt,  DATE_FORMAT(dt_payment,'%d/%m/%y'), amount  FROM ves_data.vip_billing_payment where  jns_payment = 'Material' and kd_billing = ? ", [(string) ($row_billing[8])]); 
		$resource_mc_ins = db_query_or_die('errro_7', $query_mc_ins, $__p_query_mc_ins ?? []);
			while ($row_mc_ins=  db_fetch($resource_mc_ins, PDO::FETCH_NUM))
			{
			$mc_receipt =   $row_mc_ins[0];	
			$mc_date =   $row_mc_ins[1];	
			$mc_amount =   $row_mc_ins[2];	

			}
			//==mc==
//		$query_dp_ins ="SELECT id_receipt, amount, dt_payment  FROM ves_data.vip_billing_payment where  jns_payment = 'Down Payment' or jns_payment like 'Installment%'  or jns_payment like 'Full%') and kd_billing = '$row_billing[8]' and status = 'PAID'"; 
		$query_full_ins = q_set($__p_query_full_ins, "SELECT id_receipt,  DATE_FORMAT(dt_payment,'%d/%m/%y'), amount  FROM ves_data.vip_billing_payment where  jns_payment = 'Full Payment' and kd_billing = ? ", [(string) ($row_billing[8])]); 
		$resource_full_ins = db_query_or_die('errro_7', $query_full_ins, $__p_query_full_ins ?? []);
			while ($row_full_ins=  db_fetch($resource_full_ins, PDO::FETCH_NUM))
			{
			$full_receipt =   $row_full_ins[0];	
			$full_date =   $row_full_ins[1];	
			$full_amount =   $row_full_ins[2];	

			}			
			//==DP==
//		$query_dp_ins ="SELECT id_receipt, amount, dt_payment  FROM ves_data.vip_billing_payment where  jns_payment = 'Down Payment' or jns_payment like 'Installment%'  or jns_payment like 'Full%') and kd_billing = '$row_billing[8]' and status = 'PAID'"; 
		$query_dp_ins = q_set($__p_query_dp_ins, "SELECT id_receipt,  DATE_FORMAT(dt_payment,'%d/%m/%y'), amount  FROM ves_data.vip_billing_payment where  jns_payment = 'Down Payment' and kd_billing = ? ", [(string) ($row_billing[8])]); 
		$resource_dp_ins = db_query_or_die('errro_7', $query_dp_ins, $__p_query_dp_ins ?? []);
			while ($row_dp_ins=  db_fetch($resource_dp_ins, PDO::FETCH_NUM))
			{
			$dp_receipt =   $row_dp_ins[0];	
			$dp_date =   $row_dp_ins[1];	
			$dp_amount =   $row_dp_ins[2];	

			}
			//==inst 1==
//		$query_dp_ins ="SELECT id_receipt, amount, dt_payment  FROM ves_data.vip_billing_payment where  jns_payment = 'Down Payment' or jns_payment like 'Installment%'  or jns_payment like 'Full%') and kd_billing = '$row_billing[8]' and status = 'PAID'"; 
		$query_ins_1 = q_set($__p_query_ins_1, "SELECT id_receipt,  DATE_FORMAT(dt_payment,'%d/%m/%y'), amount  FROM ves_data.vip_billing_payment where  jns_payment = 'Installment 1' and kd_billing = ? ", [(string) ($row_billing[8])]); 
		$resource_ins_1 = db_query_or_die('errro_7', $query_ins_1, $__p_query_ins_1 ?? []);
			while ($row_ins_1=  db_fetch($resource_ins_1, PDO::FETCH_NUM))
			{
			$inst_1_receipt =   $row_ins_1[0];	
			$inst_1_date =   $row_ins_1[1];	
			$inst_1_amount =   $row_ins_1[2];	

			}			
			//==inst 1==
//		$query_dp_ins ="SELECT id_receipt, amount, dt_payment  FROM ves_data.vip_billing_payment where  jns_payment = 'Down Payment' or jns_payment like 'Installment%'  or jns_payment like 'Full%') and kd_billing = '$row_billing[8]' and status = 'PAID'"; 
		$query_ins_2 = q_set($__p_query_ins_2, "SELECT id_receipt,  DATE_FORMAT(dt_payment,'%d/%m/%y'), amount  FROM ves_data.vip_billing_payment where  jns_payment = 'Installment 2' and kd_billing = ? ", [(string) ($row_billing[8])]); 
		$resource_ins_2 = db_query_or_die('errro_7', $query_ins_2, $__p_query_ins_2 ?? []);
			while ($row_ins_2=  db_fetch($resource_ins_2, PDO::FETCH_NUM))
			{
			$inst_2_receipt =   $row_ins_2[0];	
			$inst_2_date =   $row_ins_2[1];	
			$inst_2_amount =   $row_ins_2[2];	

			}	
			//==inst 1==
//		$query_dp_ins ="SELECT id_receipt, amount, dt_payment  FROM ves_data.vip_billing_payment where  jns_payment = 'Down Payment' or jns_payment like 'Installment%'  or jns_payment like 'Full%') and kd_billing = '$row_billing[8]' and status = 'PAID'"; 
		$query_ins_3 = q_set($__p_query_ins_3, "SELECT id_receipt,  DATE_FORMAT(dt_payment,'%d/%m/%y'), amount  FROM ves_data.vip_billing_payment where  jns_payment = 'Installment 3' and kd_billing = ? ", [(string) ($row_billing[8])]); 
		$resource_ins_3 = db_query_or_die('errro_7', $query_ins_3, $__p_query_ins_3 ?? []);
			while ($row_ins_3=  db_fetch($resource_ins_3, PDO::FETCH_NUM))
			{
			$inst_3_receipt =   $row_ins_3[0];	
			$inst_3_date =   $row_ins_3[1];	
			$inst_3_amount =   $row_ins_3[2];	
			}	
		$sisa = num($hrg_net) - num((num($full_amount)  + num($dp_amount) + num($inst_1_amount) + num($inst_2_amount) + num($inst_3_amount))) ;	
		
	?> <small>
	          <tr>
	            <td height="14" align=left class="style35" ><?php echo e($nomor) ; ?></td>
	            <td height="14" align=left class="style35" ><?php echo e($row_billing[0]); ?></td>
	            <td align=right class="style35" ><?php echo e(substr($reg_receipt,0,4)); ?><br>	              <?php echo e($reg_date); ?></td>
	            <td align=right class="style35" ><?php echo number_format(num($reg_amount),0,".",".") ?></td>
	            <td align=right class="style35" ><?php echo e(substr($mc_receipt,0,4)); ?><br>	              <?php echo e($mc_date); ?></td>
	            <td align=right class="style35" ><?php echo number_format(num($mc_amount),0,".",".") ?></td>
	            <td align=center class="style35" ><?php echo e($row_billing[3]); ?>% <br>
	              <?php echo e($row_billing[4]); ?></td>
	            <td align=center class="style35" ><?php echo number_format(num($hrg_net),0,".",".") ?></td>
	            <td align=right class="style35" ><?php echo e(substr($full_receipt,0,4)); ?><br>	              <?php echo e($full_date); ?></td>
	            <td align=right class="style35" ><?php echo number_format(num($full_amount),0,".",".") ?></td>
	            <td align=right class="style35" ><?php echo e(substr($dp_receipt,0,4)); ?><br>	              <?php echo e($dp_date); ?></td>
	            <td align=right class="style35" ><?php echo number_format(num($dp_amount),0,".",".") ?></td>
	            <td align=right class="style35" ><?php echo e(substr($inst_1_receipt,0,4)); ?><br>	              <?php echo e($inst_1_date); ?></td>
	            <td align=right class="style35" ><?php echo number_format(num($inst_1_amount),0,".",".") ?></td>
	            <td align=right class="style35" ><?php echo e(substr($inst_2_receipt,0,4)); ?><br>	              <?php echo e($inst_2_date); ?></td>
	            <td align=right class="style35" ><?php echo number_format(num($inst_2_amount),0,".",".") ?></td>
	            <td align=right class="style35" ><?php echo e(substr($inst_3_receipt,0,4)); ?><br>	              <?php echo e($inst_3_date); ?></td>
	            <td align=right class="style35" ><?php echo number_format(num($inst_3_amount),0,".",".") ?></td>
	            <td width="62" height="14" align=right class="style35" ><?php echo number_format(num($sisa),0,".",".") ; ?></td>
	            <td width="10" height="14" align=left class="style35" >&nbsp;</td> 
              </tr>   
				</small>                        <?php $nomor = num($nomor) + 1;$reg_receipt =0;$reg_date =0;$reg_amount =0;$mc_receipt =0;$mc_date =0;$mc_amount =0;$full_receipt =0;$full_date =0;$full_amount = 0;$dp_receipt =    0;$dp_date =0;$dp_amount =0;	$inst_1_receipt =0;	$inst_1_date =0;$inst_1_amount =0;$inst_2_receipt =0;$inst_2_date = 0;$inst_2_amount =    0;$inst_3_receipt =    0;$inst_3_date =    0;
			$inst_3_amount =    0;}
 }?>
            
				    </tbody>
          </table>
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->
<?php
$query_jns_pay = q_set($__p_query_jns_pay, "SELECT  a.pay_mtd,   sum(amount) as jumlah FROM vip_billing_payment a left join vip_billing b on a.kd_biodata = b.kd_biodata where a.id_receipt <> '' and a.kd_branch = ?\r
and dt_payment between ? and ? group by pay_mtd order by id_receipt", [(string) ($kd_cbg), (string) ($date_start), (string) ($date_end)]);
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
$jml_tot = num($jmldebit)+num($jmlcash)+num($jmlcredit)+num($jmltransfer)+num($jmlcekbg)+num($jmlvoucher);	
?>
    <div class="row">
      <!-- accepted payments column -->
      <div class="col-xs-3">
        <p class="style35">Prepared By</p>
        <p class="text-muted well well-sm no-shadow" style="margin-top: 10px;">&nbsp;</p>
      </div>
      <div class="col-xs-3">
        <p class="style35">Approved  By</p>
        <p class="text-muted well well-sm no-shadow" style="margin-top: 10px;">&nbsp;</p>
      </div>
      <div class="col-xs-3">
        <p class="style35">Checked By</p>
        <p class="text-muted well well-sm no-shadow" style="margin-top: 10px;">&nbsp;</p>
      </div>
      <!-- /.col -->
      <!-- /.col -->
    </div>
    <!-- /.row -->
  </section>
  <!-- /.content -->
</div>
<!-- ./wrapper -->
</body>
</html>
