<?php
require_once __DIR__ . "/_lib/bootstrap.php"; auth_require_login(); 
include __DIR__ . "/conndb.php";
include __DIR__ . "/profiledata.php";
 include __DIR__ . "/atas.php";
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

if (num($kd_cbg) ==1){$cabang = 'East Sby';}
if (num($kd_cbg) ==2){$cabang = 'West Sby';}
if (num($kd_cbg) ==3){$cabang = 'Denpasar';}
if (num($kd_cbg) ==4){$cabang = 'South Jkt';}
if (num($kd_cbg) ==5){$cabang = 'North Jkt';}
if (num($kd_cbg) ==6){$cabang = 'West Jkt';}
if (num($kd_cbg) ==7){$cabang = 'Bandung';}
if (num($kd_cbg) ==8){$cabang = 'Malang TBI';}
if (num($kd_cbg) ==9){$cabang = 'Bandung TBI';}
if (num($kd_cbg) ==10){$cabang = 'Bali TBI';}
$nama_lengkap = $_SESSION['nama_lengkap'];
$nama_depan = $_SESSION['nama_depan'];
$kd_cbg = $_SESSION['kd_branch'];
$posisi = $_SESSION['posisi']; 
$kd_staff = $_SESSION['kd_staff'] ;
$kdcl = in_val('kdcl', 'get');
$kdprg = in_val('kdprg', 'get');





$pilihan_sc = in_val('pilihan_sc', 'get');
if ($pilihan_sc ==''){$pilihan_sc = 'All Leads';}
$cd_cl = in_val('cd_cl', 'get');
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>AdminLTE 2 | Data Tables</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="cdnjs/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="../vcms/cdnjs/ionicons.min.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="plugins/datatables/dataTables.bootstrap.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
</head>
<?php //========================== left nav ?>
 <?php  // include __DIR__ . "/left.php";	 ?>
 <?php //====================== ?>
  <!-- Content Wrapper. Contains page content -->
 <form method=get action=vip_open_class_report.php> 
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="row">
        <div class="col-xs-12">
          <!-- /.box -->
<section class="content-header">
      <h1>VIP Open Class Payment Detail<br>
  </h1>	<div class="box-body">
  <div class="row">  <div class="col-md-12">
	    <div class="form-group">
   	      <table width="453" border="0">
        <tbody>
          <tr>
			  <td width="148"><small>
              <label for="date5"> Start Class Period :</label>
              </small></td>
            <td width="289"><small>
              <label for="date2">:</label>
            <input type="date" format="dd/MM/yyyy" name="date_start" id="date2" value="<?php echo e($date_start) ; ?>" onChange="this.form.submit()">
To </small><small>
<input type="date" name="date_end" id="date2" value="<?php echo e($date_end) ; ?>"  onChange="this.form.submit()">
</small></td>
          </tr>
          <tr>
            <td>Class Code</td>
            <td><small>
            <label for="date3">:</label>
            <select class="form-control" name="cd_cl"  onChange="this.form.submit()">
        <?php
							//	$query_cl_code = "SELECT distinct kd_class FROM ves_data.vip_billing a left join vip_teacher_schedule c on a.kd_class = c.kelas where c.kd_branch = '1' and c.mulai_tm between '2018-08-01' and '2018-08-30' group by a.kd_class";
								$query_cl_code = q_set($__p_query_cl_code, "SELECT kelas FROM ves_data.vip_teacher_schedule c where c.kd_branch = ? group by kelas order by mulai_tm desc", [(string) ($kd_cbg)]);
								$resource_cl_code = db_query_or_die('errro_7', $query_cl_code, $__p_query_cl_code ?? []);
								while ($row_cl_code=  db_fetch($resource_cl_code, PDO::FETCH_NUM))
									{
							  		echo '<option value="'.e($row_cl_code[0]).'">'.e($row_cl_code[0]).'</option>';
							  		}      ?>
        <option selected><?php echo  e($cd_cl) ?></option>
      </select>
            </small></td>
          </tr>
        </tbody>
      </table>
		</div>
	
		</div></div>


</section>
<div class="box box-warning">
	<div class="box-body">
  	  <div class="col-md-12">
	    <div class="form-group">
		</div>
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
		}}
	

	?> 
			      	      <table width="100%" class="table table-bordered table-striped" id="">

	        <tbody>

	          <tr>
	            <td height="14" align=right class="style24">&nbsp;</td>
	            <td align=left class="style24">&nbsp;</td>
	            <td align=left class="style24">&nbsp;</td>
	            <td align=left class="style24">&nbsp;</td>
	            <td align=left class="style24">&nbsp;</td>
	            <td height="14" align=left class="style24">&nbsp;</td>
              </tr>
	          <tr>
	            <td width="197" height="14" align=right class="style24">Program<?php echo number_format(num($sisa),0,".",".") ; ?></td>
	            <td width="229" align=left class="style24">&nbsp;</td>
	            <td width="1147" align=left class="style24">&nbsp;</td>
	            <td width="1147" align=left class="style24">&nbsp;</td>
	            <td width="1147" align=right class="style24">Class Period</td>
	            <td width="1147" height="14" align=left class="style24"><?php echo e($row_billing[9]); ?></td>
              </tr>
	          <tr>
	            <td height="14" align=right class="style24">Tuition Fee</td>
	            <td align=left class="style24">&nbsp;</td>
	            <td align=left class="style24">&nbsp;</td>
	            <td align=left class="style24">&nbsp;</td>
	            <td align=right class="style24">Day &amp; Time Class</td>
	            <td height="14" align=left class="style24">&nbsp;</td>
              </tr>
	          <tr>
	            <td height="14" align=right class="style24">Teacher</td>
	            <td align=left class="style24">&nbsp;</td>
	            <td align=left class="style24">&nbsp;</td>
	            <td align=left class="style24">&nbsp;</td>
	            <td align=right class="style24">Date Printed</td>
	            <td height="14" align=left class="style24">&nbsp;</td>
              </tr>
				    </tbody>
            <tfoot>
            </tfoot>
          </table>
		</div>
	  <div class="col-md-12">
	    <div class="form-group">
	      	      <table width="100%" class="table table-bordered table-striped" id="">
	        <thead>
	          <tr>
	            <td width="40" rowspan="2" align=center bgcolor=#CCCCCC class="style81">NO</td>
	            <td width="82" rowspan="2" align=center bgcolor=#CCCCCC class="style81"><br>
	              <br>
                Student Name </td>
	            <td colspan="2" align=center bgcolor=#CCCCCC class="style81">Registration <br></td>
	            <td colspan="2" align=center bgcolor=#CCCCCC class="style81">Material <br>
Cost</td>
	            <td width=75 rowspan="2" align=center bgcolor=#CCCCCC class="style81">Discount</td>
	            <td colspan="2" align=center bgcolor=#CCCCCC class="style81">Full Payment</td>
	            <td colspan="2" align=center bgcolor=#CCCCCC class="style81">DP</td>
	            <td colspan="2" align=center bgcolor=#CCCCCC class="style81">Payment 1</td>
	            <td colspan="2" align=center bgcolor=#CCCCCC class="style81">Payment 2</td>
	            <td colspan="2" align=center bgcolor=#CCCCCC class="style81">Payment 3</td>
	            <td width="110" rowspan="2" align=center bgcolor=#CCCCCC class="style81">Outstanding Balance</td>
	            <td align=center bgcolor=#CCCCCC class="style81">&nbsp;</td>
              </tr>
	          <tr>
<td width="78" align=center bgcolor=#CCCCCC class="style81">Receipt</td>
        <td width=78 align=center bgcolor=#CCCCCC class="style81">Amount</td>
        <td width="64" align=center bgcolor=#CCCCCC class="style81">Receipt</td>
        <td width="64" align=center bgcolor=#CCCCCC class="style81">Amount</td>
        <td width="68" align=center bgcolor=#CCCCCC class="style81">Receipt</td>
        <td width="68" align=center bgcolor=#CCCCCC class="style81">Amount</td>
        <td width="68" align=center bgcolor=#CCCCCC class="style81">Receipt</td>
        <td width="68" align=center bgcolor=#CCCCCC class="style81">Amount</td>
        <td width="68" align=center bgcolor=#CCCCCC class="style81">Receipt</td>
        <td width="68" align=center bgcolor=#CCCCCC class="style81">Amount</td>
        <td width="68" align=center bgcolor=#CCCCCC class="style81">Receipt</td>
        <td width="68" align=center bgcolor=#CCCCCC class="style81">Amount</td>
        <td width="68" align=center bgcolor=#CCCCCC class="style81">Receipt</td>
        <td width="120" align=center bgcolor=#CCCCCC class="style81">Amount</td>
        <td width="50" align=center bgcolor=#CCCCCC class="style81">SC</td>
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
		$query_reg_ins = q_set($__p_query_reg_ins, "SELECT id_receipt, DATE_FORMAT(dt_payment,'%d %b %y'), amount  FROM ves_data.vip_billing_payment where  jns_payment = 'Registration' and kd_billing = ? ", [(string) ($row_billing[8])]); 
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
		$query_mc_ins = q_set($__p_query_mc_ins, "SELECT id_receipt,  DATE_FORMAT(dt_payment,'%d %b %y'), amount  FROM ves_data.vip_billing_payment where  jns_payment = 'Material Cost' and kd_billing = ? ", [(string) ($row_billing[8])]); 
		$resource_mc_ins = db_query_or_die('errro_7', $query_mc_ins, $__p_query_mc_ins ?? []);
			while ($row_mc_ins=  db_fetch($resource_mc_ins, PDO::FETCH_NUM))
			{
			$mc_receipt =   $row_mc_ins[0];	
			$mc_date =   $row_mc_ins[1];	
			$mc_amount =   $row_mc_ins[2];	
			//if ($mc_amount != 0 or $mc_amount != ''){$dibayar = $dibayar + $mc_amount;}
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
			if (num($full_amount) != 0 or $full_amount != ''){$dibayar = num($dibayar) + num($full_amount);}
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
			if (num($dp_amount) != 0 or $dp_amount != ''){$dibayar = num($dibayar) + num($dp_amount);}
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
			if (num($inst_1_amount) != 0 or $inst_1_amount != ''){$dibayar = num($dibayar) + num($inst_1_amount);}
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
			if (num($inst_2_amount) != 0 or $inst_2_amount != ''){$dibayar = num($dibayar) + num($inst_2_amount);}
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
			if (num($inst_3_amount) != 0 or $inst_3_amount != ''){$dibayar = num($dibayar) + num($inst_3_amount);}
			}	
		$sisa = num($hrg_net) - num($dibayar) ;	
		
	?> 
	          <tr>
	            <td height="14" align=left class="style24"><?php echo e($nomor) ; ?></td>
	            <td height="14" align=left class="style24"><?php echo e($row_billing[0]); ?></td>
	            <td align=right class="style24"><?php echo e(substr($reg_receipt,0,4)); ?>
	              <p><?php echo e($reg_date); ?></p></td>
	            <td align=right class="style24"><?php echo number_format(num($reg_amount),0,".",".") ?></td>
	            <td align=right class="style24"><?php echo e(substr($mc_receipt,0,4)); ?>
	              <p><?php echo e($mc_date); ?></p></td>
	            <td align=right class="style24"><?php echo number_format(num($mc_amount),0,".",".") ?></td>
	            <td height="14" align=center class="style24"><?php echo e($row_billing[3]); ?>% <br>	              <?php echo e($row_billing[4]); ?></td>
	            <td align=right class="style24"><?php echo e(substr($full_receipt,0,4)); ?>
	              <p><?php echo e($full_date); ?></p></td>
	            <td align=right class="style24"><?php echo number_format(num($full_amount),0,".",".") ?></td>
	            <td align=right class="style24"><?php echo e(substr($dp_receipt,0,4)); ?>
	              <p><?php echo e($dp_date); ?></p></td>
	            <td align=right class="style24"><?php echo number_format(num($dp_amount),0,".",".") ?></td>
	            <td align=right class="style24"><?php echo e(substr($inst_1_receipt,0,4)); ?>
	              <p><?php echo e($inst_1_date); ?></p></td>
	            <td align=right class="style24"><?php echo number_format(num($inst_1_amount),0,".",".") ?></td>
	            <td align=right class="style24"><?php echo e(substr($inst_2_receipt,0,4)); ?>
	              <p><?php echo e($inst_2_date); ?></p></td>
	            <td align=right class="style24"><?php echo number_format(num($inst_2_amount),0,".",".") ?></td>
	            <td align=right class="style24"><?php echo e(substr($inst_3_receipt,0,4)); ?>
	              <p><?php echo e($inst_3_date); ?></p></td>
	            <td align=right class="style24"><?php echo number_format(num($inst_3_amount),0,".",".") ?></td>
	            <td height="14" align=right class="style24"><?php echo number_format(num($sisa),0,".",".") ; ?></td>
	            <td height="14" align=left class="style24"><?php echo e($row_billing[9]); ?></td>
              </tr>
	          <tr>
	            <td height="14" align=left class="style24">&nbsp;</td>
	            <td height="14" align=left class="style24">&nbsp;</td>
	            <td align=right class="style24">&nbsp;</td>
	            <td align=left class="style24">&nbsp;</td>
	            <td align=center class="style24">&nbsp;</td>
	            <td align=center class="style24">&nbsp;</td>
	            <td height="14" align=center class="style24">&nbsp;</td>
	            <td align=right class="style24">&nbsp;</td>
	            <td align=right class="style24">&nbsp;</td>
	            <td align=right class="style24">&nbsp;</td>
	            <td align=right class="style24">&nbsp;</td>
	            <td align=right class="style24">&nbsp;</td>
	            <td align=right class="style24">&nbsp;</td>
	            <td align=right class="style24">&nbsp;</td>
	            <td align=right class="style24">&nbsp;</td>
	            <td align=right class="style24">&nbsp;</td>
	            <td align=right class="style24">&nbsp;</td>
	            <td height="14" align=right class="style24">&nbsp;</td>
	            <td height="14" align=left class="style24">&nbsp;</td>
              </tr>
              <?php   $nomor = num($nomor)+1; $kd_kl_before = $row_billing[1]; $ttl_tf = num($ttl_tf) + num($row_billing[2]);} }?>
              <?php //=====sub total start ==== ?>
              <?php //=====sub total end==== ?>

             
				    </tbody>
            <tfoot>
            </tfoot>
          </table>
        </div>
            <!-- /.box-body -->
      </div>
          <!-- /.box -->
    </div>
        <!-- /.col -->
      </div>
      <!-- /.row --><!-- /.content -->
	</form> 
<!-- /.content-wrapper --><!-- Control Sidebar -->
  
  <!-- /.control-sidebar -->
  <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>
  <!-- ./wrapper -->
<!-- jQuery 2.2.3 -->
<script src="plugins/jQuery/jquery-2.2.3.min.js"></script>
<!-- Bootstrap 3.3.6 -->
<script src="bootstrap/js/bootstrap.min.js"></script>
<!-- DataTables -->
<script src="plugins/datatables/jquery.dataTables.min.js"></script>
<script src="plugins/datatables/dataTables.bootstrap.min.js"></script>
<!-- SlimScroll -->
<script src="plugins/slimScroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="plugins/fastclick/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/app.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
<!-- page script -->
<script>
  $(function () {
    $("#example1").DataTable();
    $('#example2').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false
    });
  });
</script>
</body>
</html>
<?php 
if (isset($_GET['Search'])) 
	{
			echo "<script type=\"text/javascript\">\n";
			echo "window.loleftcation = ('prestuvip.php');\n";				
			echo "</script>";
	}
?>
	