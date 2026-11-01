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
$kd_cabang = in_val('kd_cbg', 'get');
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
//$kd_cbg = $_SESSION['kd_branch'];
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

<style type="text/css">
<!--
.style2 {
	color: #FFFFFF;
	font-size:xxx-small;	
	}
-->
.style32 {
	color:#000;
	font-size:80%;
	}
-->
	.style33 {
	color:#000;
	font-size:75%;
	}
-->
	.style34 {
	color:#000;
	font-size:80%;
	}
-->	
	    .tbl{
     width: 700pt;
     border: 1px solid #000;
    }
</style>

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
</head>
<body class="hold-transition skin-blue sidebar-mini">

  <!-- 

 
 side column. contains the logo and sidebar -->
  <?php  //    include __DIR__ . "/left.php";	 ?>

         <?php	
	$dibayar = 0;
				$nomor = 1;
			$nm_t = '';
$query_billing = q_set($__p_query_billing, "SELECT c.nm_teacher, b.type_program, b.nm_program, b.level_program,c.kelas, date_format(min(mulai_tm),'%d %b %y') , date_format(max(mulai_tm),'%d %b %y'),b.kd_program FROM ves_data.vip_teacher_schedule c\r
left join ves_data.vip_mst_code_prg b on c.kode_program = b.kd_program where  c.kelas = ?  group by c.kelas", [(string) ($cd_cl)]);
		
$resource_billing = db_query_soft($query_billing, $__p_query_billing ?? []);
$keluar_billing = db_num_rows($resource_billing);				
if(num(db_num_rows($resource_billing)) > 0)
	{
	while ($row_billing  =  db_fetch($resource_billing, PDO::FETCH_NUM))
		{

		$periode_kelas = "$row_billing[5] to $row_billing[6]";
$kode_program = $row_billing[7];
		$query_ambil_tf = q_set($__p_query_ambil_tf, "SELECT tf,level_program FROM ves_data.vip_billing where kd_program = ? and kd_class= ?  group by tf ", [(string) ($kode_program), (string) ($cd_cl)]);

		$resource_ambil_tf = db_query_soft($query_ambil_tf, $__p_query_ambil_tf ?? []);
		$keluar_ambil_tf = db_num_rows($resource_ambil_tf);				
		if(num(db_num_rows($resource_ambil_tf)) > 0)
			{
			while ($row_ambil_tf  =  db_fetch($resource_ambil_tf, PDO::FETCH_NUM))
				{
				$harga_asli = $row_ambil_tf[0];
				$nm_level = $row_ambil_tf[1];					
				}
			}
		$Program_info = "$row_billing[1] $row_billing[2] $nm_level";			
		}
	}
	

	?> 
    <table width="684" id="">

	        <tbody>

	          <tr>
	            <td height="14" colspan="4" align=center  class="style34"><strong><h5>Open Class Payment Detail</h5></strong><strong><?php echo e($cd_cl); ?></strong> </td>
              </tr>
	          <tr>
	            <td width="128" height="14" align=center   class="style34" >Center<br><?php echo e($cabang); ?></td>
	            <td width="225" align=center   class="style34" >Program<br><?php echo e($Program_info); ?><br></td>
	            <td width="208" align=center   class="style34">Tuition Fee<br>
                Rp. <?php echo number_format(num($harga_asli),0,".",".")  ?></td>
	            <td width="103" align=center   class="style34">Class Period<br>
                <?php echo e($periode_kelas); ?></td>
              </tr>
				    </tbody>
            <tfoot>
            </tfoot>
          </table><br>
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
 FROM ves_data.vip_teacher_schedule c left join ves_data.vip_mst_code_prg b on c.kode_program = b.kd_program where c.kelas = ? group by date_format(mulai_tm,'%W')", [(string) ($cd_cl)]);
		
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
<br>
       	  
	  
   	  <table width="815" class="tbl" id="">
        <thead><small>
	          <tr>
	            <td width="18" rowspan="2" align=center bgcolor=#CCCCCC class="style33" >NO</td>
	            <td width="40" rowspan="2" align=center bgcolor=#CCCCCC class="style33"><br>
	              <br>
                Student Name </td>
	            <td colspan="2" align=center bgcolor=#CCCCCC class="style33">Registration <br></td>
	            <td colspan="2" align=center bgcolor=#CCCCCC class="style33">Material <br>
Cost</td>
	            <td width=36 rowspan="2" align=center bgcolor=#CCCCCC class="style33">Disc</td>
	            <td width=39 rowspan="2" align=center bgcolor=#CCCCCC class="style33">Neet<br>
	              Tuition Fee</td>
	            <td colspan="2" align=center bgcolor=#CCCCCC class="style33">Full Payment</td>
	            <td colspan="2" align=center bgcolor=#CCCCCC class="style33">DP</td>
	            <td colspan="2" align=center bgcolor=#CCCCCC class="style33">Payment 1</td>
	            <td colspan="2" align=center bgcolor=#CCCCCC class="style33">Payment 2</td>
	            <td colspan="2" align=center bgcolor=#CCCCCC class="style33">Payment 3</td>
	            <td width="62" rowspan="2" align=center bgcolor=#CCCCCC class="style33">Outstanding Balance</td>
	            <td align=center bgcolor=#CCCCCC class="style33">&nbsp;</td>
              </tr>
	          </small><tr>
<td width="37" align=center bgcolor=#CCCCCC class="style33">Receipt</td>
        <td width=40 align=center bgcolor=#CCCCCC class="style33">Amount</td>
        <td width="37" align=center bgcolor=#CCCCCC class="style33">Receipt</td>
        <td width="40" align=center bgcolor=#CCCCCC class="style33">Amount</td>
        <td width="37" align=center bgcolor=#CCCCCC class="style33">Receipt</td>
        <td width="40" align=center bgcolor=#CCCCCC class="style33">Amount</td>
        <td width="37" align=center bgcolor=#CCCCCC class="style33">Receipt</td>
        <td width="40" align=center bgcolor=#CCCCCC class="style33">Amount</td>
        <td width="37" align=center bgcolor=#CCCCCC class="style33">Receipt</td>
        <td width="40" align=center bgcolor=#CCCCCC class="style33">Amount</td>
        <td width="37" align=center bgcolor=#CCCCCC class="style33">Receipt</td>
        <td width="40" align=center bgcolor=#CCCCCC class="style33">Amount</td>
        <td width="37" align=center bgcolor=#CCCCCC class="style33">Receipt</td>
        <td width="40" align=center bgcolor=#CCCCCC class="style33">Amount</td>
        <td width="10" align=center bgcolor=#CCCCCC class="style33">SC</td>
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
$query_billing = q_set($__p_query_billing, "SELECT b.nama_lengkap , kd_class,tf,promo_persen,\r
discount,net_tf,reg_fee,material_cost,a.kd_billing,a.sc,a.voucher,a.kd_branch\r
FROM ves_data.vip_billing a left join ves_data.vip_student_data b on a.kd_biodata = b.kd_biodata left join vip_teacher_schedule c on a.kd_class = c.kelas where   kd_class = ? group by a.kd_billing", [(string) ($cd_cl)]);

$resource_billing = db_query_soft($query_billing, $__p_query_billing ?? []);
$keluar_billing = db_num_rows($resource_billing);				
if(num(db_num_rows($resource_billing)) > 0)
	{
	while ($row_billing  =  db_fetch($resource_billing, PDO::FETCH_NUM))
		{


		if (num($kd_cabang) == 100)
			{
			
	if (num($row_billing[11]) ==1){$cabang = 'East Sby';}
if (num($row_billing[11]) ==2){$cabang = 'West Sby';}
if (num($row_billing[11]) ==3){$cabang = 'Denpasar';}
if (num($row_billing[11]) ==4){$cabang = 'South Jkt';}
if (num($row_billing[11]) ==5){$cabang = 'North Jkt';}
if (num($row_billing[11]) ==6){$cabang = 'West Jkt';}
if (num($row_billing[11]) ==7){$cabang = 'Bandung';}
if (num($row_billing[11]) ==8){$cabang = 'Malang';}		
			}

		$hrg_net = $row_billing[5];
		$jdwl='';
		$query_score = q_set($__p_query_score, "SELECT date_format(mulai_tm,'%a') as hr,\r
\t\tdate_format(mulai_tm,'%H') as mulai,\r
\t\tdate_format(selesai_tm,'%H') as selesai,\r
\t\tnm_teacher  FROM ves_data.vip_teacher_schedule where kelas = ? group by date_format(mulai_tm,'%a') order by date_format(mulai_tm,'%w')", [(string) ($row_billing[1])]);
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
		$reg_fee = $row_billing[6];
			//==reg==
//		$query_dp_ins ="SELECT id_receipt, amount, dt_payment  FROM ves_data.vip_billing_payment where  jns_payment = 'Down Payment' or jns_payment like 'Installment%'  or jns_payment like 'Full%') and kd_billing = '$row_billing[8]' and status = 'PAID'"; 
		$query_reg_ins = q_set($__p_query_reg_ins, "SELECT id_receipt, DATE_FORMAT(dt_payment,'%d %b %y'), amount  FROM ves_data.vip_billing_payment where  jns_payment = 'Registration' and kd_billing = ? ", [(string) ($row_billing[8])]); 
		$resource_reg_ins = db_query_or_die('errro_7', $query_reg_ins, $__p_query_reg_ins ?? []);
			while ($row_reg_ins=  db_fetch($resource_reg_ins, PDO::FETCH_NUM))
			{
			$reg_receipt =   $row_reg_ins[0];		
			$reg_date =   $row_reg_ins[1];	
			$reg_amount =   $row_reg_ins[2];
			if ($reg_receipt <> ''){$reg_paid = $reg_amount;}
			//if ($reg_amount != 0 or $reg_amount != ''){$dibayar = $dibayar + $reg_amount;}
			}			
			$mc = $row_billing[7];

			//==mc==
//		$query_dp_ins ="SELECT id_receipt, amount, dt_payment  FROM ves_data.vip_billing_payment where  jns_payment = 'Down Payment' or jns_payment like 'Installment%'  or jns_payment like 'Full%') and kd_billing = '$row_billing[8]' and status = 'PAID'"; 
		$query_mc_ins = q_set($__p_query_mc_ins, "SELECT id_receipt,  DATE_FORMAT(dt_payment,'%d %b %y'), amount  FROM ves_data.vip_billing_payment where  jns_payment = 'Material' and kd_billing = ? ", [(string) ($row_billing[8])]); 
		$resource_mc_ins = db_query_or_die('errro_7', $query_mc_ins, $__p_query_mc_ins ?? []);
			while ($row_mc_ins=  db_fetch($resource_mc_ins, PDO::FETCH_NUM))
			{
			$mc_receipt =   $row_mc_ins[0];	
			$mc_date =   $row_mc_ins[1];	
			$mc_amount =   $row_mc_ins[2];	
			if ($mc_receipt <> ''){$mc_paid = $mc_amount;}
				

			}
			//==mc==
//		$query_dp_ins ="SELECT id_receipt, amount, dt_payment  FROM ves_data.vip_billing_payment where  jns_payment = 'Down Payment' or jns_payment like 'Installment%'  or jns_payment like 'Full%') and kd_billing = '$row_billing[8]' and status = 'PAID'"; 
		$query_full_ins = q_set($__p_query_full_ins, "SELECT id_receipt,  DATE_FORMAT(dt_payment,'%d %b %y'), amount  FROM ves_data.vip_billing_payment where  jns_payment = 'Full Payment' and kd_billing = ? ", [(string) ($row_billing[8])]); 
		$resource_full_ins = db_query_or_die('errro_7', $query_full_ins, $__p_query_full_ins ?? []);
			while ($row_full_ins=  db_fetch($resource_full_ins, PDO::FETCH_NUM))
			{
			$full_receipt =   $row_full_ins[0];	
			$full_date =   $row_full_ins[1];	
			$full_amount =   $row_full_ins[2];	

			}			
			//==DP==
//		$query_dp_ins ="SELECT id_receipt, amount, dt_payment  FROM ves_data.vip_billing_payment where  jns_payment = 'Down Payment' or jns_payment like 'Installment%'  or jns_payment like 'Full%') and kd_billing = '$row_billing[8]' and status = 'PAID'"; 
		$query_dp_ins = q_set($__p_query_dp_ins, "SELECT id_receipt,  DATE_FORMAT(dt_payment,'%d %b %y'), amount  FROM ves_data.vip_billing_payment where  jns_payment = 'Down Payment' and kd_billing = ? ", [(string) ($row_billing[8])]); 
		$resource_dp_ins = db_query_or_die('errro_7', $query_dp_ins, $__p_query_dp_ins ?? []);
			while ($row_dp_ins=  db_fetch($resource_dp_ins, PDO::FETCH_NUM))
			{
			$dp_receipt =   $row_dp_ins[0];	
			$dp_date =   $row_dp_ins[1];	
			$dp_amount =   $row_dp_ins[2];	

			}
			//==inst 1==
//		$query_dp_ins ="SELECT id_receipt, amount, dt_payment  FROM ves_data.vip_billing_payment where  jns_payment = 'Down Payment' or jns_payment like 'Installment%'  or jns_payment like 'Full%') and kd_billing = '$row_billing[8]' and status = 'PAID'"; 
		$query_ins_1 = q_set($__p_query_ins_1, "SELECT id_receipt,  DATE_FORMAT(dt_payment,'%d %b %y'), amount  FROM ves_data.vip_billing_payment where  jns_payment = 'Installment 1' and kd_billing = ? ", [(string) ($row_billing[8])]); 
		$resource_ins_1 = db_query_or_die('errro_7', $query_ins_1, $__p_query_ins_1 ?? []);
			while ($row_ins_1=  db_fetch($resource_ins_1, PDO::FETCH_NUM))
			{
			$inst_1_receipt =   $row_ins_1[0];	
			$inst_1_date =   $row_ins_1[1];	
			$inst_1_amount =   $row_ins_1[2];	

			}			
			//==inst 1==
//		$query_dp_ins ="SELECT id_receipt, amount, dt_payment  FROM ves_data.vip_billing_payment where  jns_payment = 'Down Payment' or jns_payment like 'Installment%'  or jns_payment like 'Full%') and kd_billing = '$row_billing[8]' and status = 'PAID'"; 
		$query_ins_2 = q_set($__p_query_ins_2, "SELECT id_receipt,  DATE_FORMAT(dt_payment,'%d %b %y'), amount  FROM ves_data.vip_billing_payment where  jns_payment = 'Installment 2' and kd_billing = ? ", [(string) ($row_billing[8])]); 
		$resource_ins_2 = db_query_or_die('errro_7', $query_ins_2, $__p_query_ins_2 ?? []);
			while ($row_ins_2=  db_fetch($resource_ins_2, PDO::FETCH_NUM))
			{
			$inst_2_receipt =   $row_ins_2[0];	
			$inst_2_date =   $row_ins_2[1];	
			$inst_2_amount =   $row_ins_2[2];	

			}	
			//==inst 1==
//		$query_dp_ins ="SELECT id_receipt, amount, dt_payment  FROM ves_data.vip_billing_payment where  jns_payment = 'Down Payment' or jns_payment like 'Installment%'  or jns_payment like 'Full%') and kd_billing = '$row_billing[8]' and status = 'PAID'"; 
		$query_ins_3 = q_set($__p_query_ins_3, "SELECT id_receipt,  DATE_FORMAT(dt_payment,'%d %b %y'), amount  FROM ves_data.vip_billing_payment where  jns_payment = 'Installment 3' and kd_billing = ? ", [(string) ($row_billing[8])]); 
		$resource_ins_3 = db_query_or_die('errro_7', $query_ins_3, $__p_query_ins_3 ?? []);
			while ($row_ins_3=  db_fetch($resource_ins_3, PDO::FETCH_NUM))
			{
			$inst_3_receipt =   $row_ins_3[0];	
			$inst_3_date =   $row_ins_3[1];	
			$inst_3_amount =   $row_ins_3[2];	
			}	
		$sisa = num((num($reg_fee) + num($mc) +num($hrg_net))) - num((num($full_amount)  + num($dp_amount) + num($inst_1_amount) + num($inst_2_amount) + num($inst_3_amount)+ num($reg_paid) + num($mc_paid))) ;	
		
	?>  <small>
	          <tr>
	            <td height="14" align=left class="style33" ><?php echo e($nomor) ; ?></td>
	            <td height="14" align=left class="style33" ><?php echo e($row_billing[0]); ?><br>
                <small><?php echo e($cabang); ?></small></td>
	            <td align=right class="style33" ><?php echo e(substr($reg_receipt,0,4)); ?><br>	              <?php echo e($reg_date); ?></td>
	            <td align=right class="style33" ><?php echo number_format(num($reg_fee),0,".",".") ?></td>
	            <td align=right class="style33" ><?php echo e(substr($mc_receipt,0,4)); ?><br>	              <?php echo e($mc_date); ?></td>
	            <td align=right class="style33" ><?php echo number_format(num($mc),0,".",".") ?></td>
	            <td align=center class="style33" ><?php echo e($row_billing[3]); ?>% <br>
	              <?php echo e($row_billing[4]); ?><small><br>
	              <?php echo number_format(num($row_billing[10]),0,".",".") ?></small></td>
	            <td align=center class="style33" ><?php echo number_format(num($hrg_net),0,".",".") ?></td>
	            <td align=right class="style33" ><?php echo e(substr($full_receipt,0,4)); ?><br>	              <?php echo e($full_date); ?></td>
	            <td align=right class="style33" ><?php echo number_format(num($full_amount),0,".",".") ?></td>
	            <td align=right class="style33" ><?php echo e(substr($dp_receipt,0,4)); ?><br>	              <?php echo e($dp_date); ?></td>
	            <td align=right class="style33" ><?php echo number_format(num($dp_amount),0,".",".") ?></td>
	            <td align=right class="style33" ><?php echo e(substr($inst_1_receipt,0,4)); ?><br>	              <?php echo e($inst_1_date); ?></td>
	            <td align=right class="style33" ><?php echo number_format(num($inst_1_amount),0,".",".") ?></td>
	            <td align=right class="style33" ><?php echo e(substr($inst_2_receipt,0,4)); ?><br>	              <?php echo e($inst_2_date); ?></td>
	            <td align=right class="style33" ><?php echo number_format(num($inst_2_amount),0,".",".") ?></td>
	            <td align=right class="style33" ><?php echo e(substr($inst_3_receipt,0,4)); ?><br>	              <?php echo e($inst_3_date); ?></td>
	            <td align=right class="style33" ><?php echo number_format(num($inst_3_amount),0,".",".") ?></td>
	            <td height="14" align=right class="style33" ><?php echo number_format(num($sisa),0,".",".") ; ?></td>
	            <td height="14" align=left class="style33" ><span class="style24"><?php echo e($row_billing[9]); ?></span></td> 
              </tr>   
				</small>                        <?php $nomor = num($nomor) + 1;$reg_receipt =0;$reg_date =0;$reg_amount =0;$mc_receipt =0;$mc_date =0;$mc_amount =0;$full_receipt =0;$full_date =0;$full_amount = 0;$dp_receipt =    0;$dp_date =0;$dp_amount =0;	$inst_1_receipt =0;	$inst_1_date =0;$inst_1_amount =0;$inst_2_receipt =0;$inst_2_date = 0;$inst_2_amount =    0;$inst_3_receipt =    0;$inst_3_date =    0;
			$inst_3_amount =    0;$reg_paid=0;$mc_paid=0;		$cabang = '';
			$inst_3_amount =    0;}
 }?>
            
				    </tbody>
          </table>
   	  <br>
   	  <table width="1002" id="table2" align="">
   	    <tbody>
   	      <tr>
   	        <td width="64" align=center   class="style34"><table width="144" height="39" border="1">
   	          <tbody>
   	            <tr>
   	              <th width="134" scope="row">&nbsp;</th>
                </tr>
              </tbody>
            </table></td>
   	        <td height="14" colspan="4" align=left   class="style34">I state that the following data has been checked and is correct</td>
          </tr>
   	      <tr>
   	        <td colspan="2" align=center   class="style34">&nbsp;</td>
   	        <td width="74" height="84" align=center valign="top"   class="style34">&nbsp;</td>
   	        <td width="10" align=center  valign="top"  class="style34">&nbsp;</td>
   	        <td width="517" align="right" valign="top"  class="style34" ><table width="404" border="1" cellpadding="1" cellspacing="1">
              <tbody>
   	              <tr>
   	                <th width="113" scope="row"><p>Prepared By</p></th>
   	                <th width="115" scope="row"><p>Approved  By</p></th>
   	                <th width="158" scope="row"><p>Checked By</p></th>
                  </tr>
   	              <tr>
   	                <th scope="row"><p>&nbsp;</p>
   	                  <p>&nbsp;</p></th>
   	                <th scope="row"><p>&nbsp;</p>
   	                  <p>&nbsp;</p></th>
   	                <th scope="row"><p>&nbsp;</p>
                    <p>&nbsp;</p></th>
                  </tr>
   	              <tr>
   	                <th scope="row">Student Consultant</th>
   	                <th scope="row">Center Manager</th>
   	                <th scope="row">Accounting Dept</th>
                </tr>
                </tbody>
              </table>
   	          <p><br>
              </p>
            <p>&nbsp;</p></td>
          </tr>
   	      <tr>
   	        <td colspan="2" align=center   class="style34">&nbsp;</td>
   	        <td height="23" align=center   class="style34">&nbsp;</td>
   	        <td align=center  class="style34" >&nbsp;</td>
   	        <td align=center  class="style34" >&nbsp;</td>
          </tr>

        </tbody>
   	    <tfoot>
        </tfoot>
</table>
            <!-- /.box-body -->

</body>
</html>
<?php
    $content = ob_get_clean();
	$namafile = "ocp.$kode_student.pdf";
    // convert in PDF
    require_once VCMS_ROOT . '/_lib/html2pdf.php';   // spipu/html2pdf 5.x (pengganti html2pdf/ lama)
    try
    {
        $html2pdf = new HTML2PDF('L', 'A4', 'en');
 		$html2pdf->setTestTdInOnePage(false);		
        $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
        $html2pdf->Output($namafile);
    }
    catch(HTML2PDF_exception $e) {
        html2pdf_fail($e);
    }
?>
