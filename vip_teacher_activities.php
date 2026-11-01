<?php
require_once __DIR__ . "/_lib/bootstrap.php"; auth_require_login(); 
include __DIR__ . "/conndb.php";
include __DIR__ . "/profiledata.php";
 include __DIR__ . "/atas.php";
include __DIR__ . "/left.php";
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
if ($kd_cbg == 'Malang'){$kd_cbg = 8;}
if ($kd_cbg == 'Bandung TBI'){$kd_cbg = 9;}
if ($kd_cbg == 'Bali TBI'){$kd_cbg = 10;}
if ($kd_cbg == 'Online'){$kd_cbg = 100;}
if ($kd_cbg == 'PIK'){$kd_cbg = 11;}
if ($kd_cbg == 'Serpong'){$kd_cbg = 12;}

if (num($kd_cbg) ==0){$cabang = '--ALL--';}
if ($kd_cbg ==''){$cabang = '--ALL--';}

$nama_lengkap = $_SESSION['nama_lengkap'];
$nama_depan = $_SESSION['nama_depan'];

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
if (num($kd_cbg) ==100){$cabang = 'Online';}
if (num($kd_cbg) ==111){$cabang = 'All';}
if (num($kd_cbg) ==11){$cabang = 'PIK';}
if (num($kd_cbg) ==12){$cabang = 'Serpong';}
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

  <!-- Content Wrapper. Contains page content -->
 <form method=get action=vip_teacher_activities.php> 
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="row">
        <div class="col-xs-12">
          <!-- /.box -->
<section class="content-header">
      <h1>Teacher Activities Record<br>
  </h1>	<div class="box-body">
  <div class="row">  <div class="col-md-12">
	    <div class="form-group">
   	      <table width="527" border="0">
        <tbody>
          <tr class="table table-bordered table-striped">
            <th scope="row">Center</th>
            <td><select name="kd_cbg"  onChange="this.form.submit()"   class="style33" id="select">
              <option value="0">--CHOOSE--</option>
              <option value="1">East Sby</option>
              <option value="2">West Sby</option>
              <option value="3">Denpasar</option>
              <option value="8">Malang</option>
              <option value="101">East Area</option>
              <option value="4">South Jkt</option>
              <option value="5">North Jkt</option>
              <option value="11">PIK</option>	
              <option value="12">Serpong</option>					
              <option value="6">West Jkt</option>
              <option value="7">Bandung</option>
              <option value="102">West Area</option>
              <option value="100">Online</option>
              <option value="111">All</option>				
              <option selected="selected"><?php echo e($cabang) ?></option>
            </select></td>
          </tr>
          <tr>
			  <td width="149">
              <label for="date5"> Start Class Period </label>
              </small></td>
            <td width="368">
            <input type="date" format="dd/MM/yyyy" name="date_start" id="date2" value="<?php echo e($date_start) ; ?>" onChange="this.form.submit()">
To </small><small>
<input type="date" name="date_end" id="date2" value="<?php echo e($date_end) ; ?>"  onChange="this.form.submit()">
</small></td>
          </tr>
          <tr>
			  <td><label for="date5">Class Code</label></td>
            <td>
            <select class="form-control" name="cd_cl"  onChange="this.form.submit()">
        <?php
							//	$query_cl_code = "SELECT distinct kd_class FROM ves_data.vip_billing a left join vip_teacher_schedule c on a.kd_class = c.kelas where c.kd_branch = '1' and c.mulai_tm between '2018-08-01' and '2018-08-30' group by a.kd_class";

								$query_cl_code = q_set($__p_query_cl_code, "SELECT a.kelas FROM ves_data.vip_teacher_schedule a\r
INNER JOIN ( SELECT kelas, MIN(mulai_tm) AS min_mulai FROM vip_teacher_schedule where status_kelas = 1\r
GROUP BY kelas ) f ON a.kelas = f.kelas AND a.mulai_tm = f.min_mulai\r
where a.kd_branch = ? and f.min_mulai between ? and ?\r
and a.status_kelas = 1 group by a.kelas order by mulai_tm desc", [(string) ($kd_cbg), (string) ($date_start) . " 00:00:00", (string) ($date_end) . " 23:00:00"]);	


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
			$nm_t = '';
$query_mulai = q_set($__p_query_mulai, "SELECT date_format((mulai_tm),'%d %b %y') FROM ves_data.vip_teacher_schedule c where  c.kelas = ?  order by mulai_tm limit 1", [(string) ($cd_cl)]);
$resource_mulai = db_query_soft($query_mulai, $__p_query_mulai ?? []);		
if(num(db_num_rows($resource_mulai)) > 0)
	{
	while ($row_mulai  =  db_fetch($resource_mulai, PDO::FETCH_NUM))
		{
		$mulai_kelas = $row_mulai[0];
		}
	}
$query_selesai = q_set($__p_query_selesai, "SELECT date_format((mulai_tm),'%d %b %y') FROM ves_data.vip_teacher_schedule c where  c.kelas = ?  order by mulai_tm desc limit 1", [(string) ($cd_cl)]);
$resource_selesai = db_query_soft($query_selesai, $__p_query_selesai ?? []);		
if(num(db_num_rows($resource_selesai)) > 0)
	{
	while ($row_selesai  =  db_fetch($resource_selesai, PDO::FETCH_NUM))
		{
		$selesai_kelas = $row_selesai[0];
		}
	}
	
$periode_kelas = "$mulai_kelas to $selesai_kelas";
		
			
$query_billing = q_set($__p_query_billing, "SELECT c.nm_teacher, b.type_program, b.nm_program, b.level_program,c.kelas, date_format(min(mulai_tm),'%d %b %y') , date_format(max(mulai_tm),'%d %b %y'),b.kd_program FROM ves_data.vip_teacher_schedule c\r
left join ves_data.vip_mst_code_prg b on c.kode_program = b.kd_program where c.kelas = ?  group by c.kelas", [(string) ($cd_cl)]);
$resource_billing = db_query_soft($query_billing, $__p_query_billing ?? []);
$keluar_billing = db_num_rows($resource_billing);				
if(num(db_num_rows($resource_billing)) > 0)
	{
	while ($row_billing  =  db_fetch($resource_billing, PDO::FETCH_NUM))
		{
			$kode_program = $row_billing[7];
		$query_ambil_tf = q_set($__p_query_ambil_tf, "SELECT tf,level_program FROM ves_data.vip_billing where kd_program = ? and kd_class= ?  group by tf  ", [(string) ($kode_program), (string) ($cd_cl)]);

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
			      	      <table width="100%" class="table table-bordered table-striped" id="">

	        <tbody>

	          <tr>
	            <td height="14" colspan="4" align=center class="style24"><h3>Open Class Payment Detail</h3><br>
                <strong><?php echo e($cd_cl); ?> </strong></td>
              </tr>
	          <tr>
	            <td width="310" height="14" align=center class="style24">Center<br><strong><?php echo e($cabang); ?></strong></td>
	            <td width="400" align=center class="style24">Program<br><strong><?php echo e($Program_info); ?><br>
	            </strong></td>
	            <td width="401" align=center class="style24">Tuition Fee<br>
                <strong>Rp. <?php echo number_format(num($harga_asli),0,".",".")  ?></strong></td>
	            <td width="382" align=center class="style24">Class Period<br>
                <strong><?php echo e($periode_kelas); ?></strong></td>
              </tr>
				    </tbody>
            <tfoot>
            </tfoot>
          </table>
<table width="100%" class="table table-bordered table-striped" id="">

	        <tbody>
	          <tr>
	            <td width="239" height="14" align=center class="style24">Day</td>
	            <td width="183" align=center class="style24">Time</td>
	            <td width="225" align=center class="style24">Room</td>
	            <td width="192" align=center class="style24">Teacher</td>
	            <td width="726" align=right class="style24">&nbsp;</td>
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
	            <td height="14" align=center class="style24"><strong><?php echo e($sch_hari); ?></strong></td>
	            <td align=center class="style24"><strong><?php echo e($sch_jam); ?></strong></td>
	            <td align=center class="style24"><strong><?php echo e($sch_room); ?></strong></td>
	            <td align=center class="style24"><strong><?php echo e($sch_teacher); ?></strong></td>
	            <td align=right class="style24">&nbsp;</td>
              </tr><?php }} ?>
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
	            <td width="46" rowspan="2" align=center bgcolor=#CCCCCC class="style81">NO</td>
	            <td width="83" rowspan="2" align=center bgcolor=#CCCCCC class="style81"><br>
	              <br>
                Student Name </td>
	            <td colspan="2" align=center bgcolor=#CCCCCC class="style81">Registration <br></td>
	            <td colspan="2" align=center bgcolor=#CCCCCC class="style81">Material <br>
Cost</td>
	            <td width=67 rowspan="2" align=center bgcolor=#CCCCCC class="style81">Disc</td>
	            <td width=110 rowspan="2" align=center bgcolor=#CCCCCC class="style81">Neet<br>
	              Tuition Fee</td>
	            <td colspan="2" align=center bgcolor=#CCCCCC class="style81">Full Payment</td>
	            <td colspan="2" align=center bgcolor=#CCCCCC class="style81">DP</td>
	            <td colspan="2" align=center bgcolor=#CCCCCC class="style81">Payment 1</td>
	            <td colspan="2" align=center bgcolor=#CCCCCC class="style81">Payment 2</td>
	            <td colspan="2" align=center bgcolor=#CCCCCC class="style81">Payment 3</td>
	            <td width="97" rowspan="2" align=center bgcolor=#CCCCCC class="style81">Outstanding Balance</td>
	            <td align=center bgcolor=#CCCCCC class="style81">&nbsp;</td>
              </tr>
	          <tr>
<td width="79" align=center bgcolor=#CCCCCC class="style81">Receipt</td>
        <td width=79 align=center bgcolor=#CCCCCC class="style81">Amount</td>
        <td width="72" align=center bgcolor=#CCCCCC class="style81">Receipt</td>
        <td width="72" align=center bgcolor=#CCCCCC class="style81">Amount</td>
        <td width="74" align=center bgcolor=#CCCCCC class="style81">Receipt</td>
        <td width="65" align=center bgcolor=#CCCCCC class="style81">Amount</td>
        <td width="88" align=center bgcolor=#CCCCCC class="style81">Receipt</td>
        <td width="65" align=center bgcolor=#CCCCCC class="style81">Amount</td>
        <td width="87" align=center bgcolor=#CCCCCC class="style81">Receipt</td>
        <td width="74" align=center bgcolor=#CCCCCC class="style81">Amount</td>
        <td width="76" align=center bgcolor=#CCCCCC class="style81">Receipt</td>
        <td width="64" align=center bgcolor=#CCCCCC class="style81">Amount</td>
        <td width="64" align=center bgcolor=#CCCCCC class="style81">Receipt</td>
        <td width="90" align=center bgcolor=#CCCCCC class="style81">Amount</td>
        <td width="53" align=center bgcolor=#CCCCCC class="style81">SC</td>
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
if ($cd_cl == '')
{
$nilai_kelas =" kd_class <> '' ";
}
else
{
$nilai_kelas = " kd_class = '$cd_cl' ";	
}

				
if (num($kd_cbg) == 100)
{
$query_billing = q_set($__p_query_billing, "SELECT nama_lengkap, kd_class,tf,promo_persen,\r
discount,net_tf,reg_fee,material_cost,a.kd_billing,a.sc,a.voucher, b.kd_branch\r
FROM ves_data.vip_billing a left join ves_data.vip_student_data b on a.kd_biodata = b.kd_biodata left join vip_teacher_schedule c on a.kd_class = c.kelas where kd_class = ? group by a.kd_billing", [(string) ($cd_cl)]);	
}
else
{
$query_billing = q_set($__p_query_billing, "SELECT nama_lengkap, kd_class,tf,promo_persen,\r
discount,net_tf,reg_fee,material_cost,a.kd_billing,a.sc,a.voucher\r
FROM ves_data.vip_billing a left join ves_data.vip_student_data b on a.kd_biodata = b.kd_biodata left join vip_teacher_schedule c on a.kd_class = c.kelas where kd_class = ? group by a.kd_billing", [(string) ($cd_cl)]);		
}


$resource_billing = db_query_soft($query_billing, $__p_query_billing ?? []);
$keluar_billing = db_num_rows($resource_billing);				
if(num(db_num_rows($resource_billing)) > 0)
	{
	while ($row_billing  =  db_fetch($resource_billing, PDO::FETCH_NUM))
		{
		$refund= 0;
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
$_cbg =$row_billing[11];
if (num($_cbg) ==1){$cabang = 'East Sby';}
if (num($_cbg) ==2){$cabang = 'West Sby';}
if (num($_cbg) ==3){$cabang = 'Denpasar';}
if (num($_cbg) ==4){$cabang = 'South Jkt';}
if (num($_cbg) ==5){$cabang = 'North Jkt';}
if (num($_cbg) ==6){$cabang = 'West Jkt';}
if (num($_cbg) ==7){$cabang = 'Bandung';}
if (num($_cbg) ==8){$cabang = 'Malang';}
if (num($_cbg) ==100){$cabang = 'Online';}	
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
			if ($reg_receipt != ''){$reg_paid = $reg_amount;}
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
			if ($mc_receipt != ''){$mc_paid = $mc_amount;}
				

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
				
			if ($full_receipt != ''){$full_amount_paid = $full_amount;}				

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
				
			if ($dp_receipt != ''){$dp_amount_paid = $dp_amount;}						

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

			if ($inst_1_receipt != ''){$inst_1_amount_paid = $inst_1_amount;}					
				
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
			
			if ($inst_2_receipt != ''){$inst_2_amount_paid = $inst_2_amount;}
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

			if ($inst_3_receipt != ''){$inst_3_amount_paid = $inst_3_amount;}				
			}	
	

//=======
		$query_refund = q_set($__p_query_refund, "SELECT sum(v.amount)  FROM ves_data.vip_billing_refund v where kd_billing = ? ", [(string) ($row_billing[8])]);

		$resource_refund = db_query_soft($query_refund, $__p_query_refund ?? []);
		$keluar_refund = db_num_rows($resource_refund);	
		if(num(db_num_rows($resource_refund)) > 0)
			{
			while ($row_refund  =  db_fetch($resource_refund, PDO::FETCH_NUM))	
				{
				$refund = $row_refund[0];
				$st_refund = 1;
				if (num($refund) != 0 )
				{$RefundPaid = "Refund Paid";}
				}
			}	
//=======		
//			$sisa = ($reg_fee + $mc +$hrg_net) - ($full_amount  + $dp_amount + $inst_1_amount + $inst_2_amount + $inst_3_amount+ $reg_paid + $mc_paid) ;	
			$total_hrs_dibayar = num($reg_fee) + num($mc) +num($hrg_net)  ;	
			$sdh_dibayar = num($full_amount_paid)  + num($dp_amount_paid) + num($inst_1_amount_paid) + num($inst_2_amount_paid) + num($inst_3_amount_paid) + num($reg_paid) + num($mc_paid);

			$sisa =  num($total_hrs_dibayar) - num($sdh_dibayar);
			$sisa = num($sisa) + num($refund);
		
		
		
	?> 
	          <tr>
	            <td height="14" align=left class="style24"><?php echo e($nomor) ; ?></td>
	            <td height="14" align=left class="style24"><?php echo e($row_billing[0]); ?><?php echo e($cabang) ?> </td>
	            <td align=right class="style24"><?php echo e(substr($reg_receipt,0,4)); ?>
	              <p><?php echo e($reg_date); ?></p></td>
	            <td align=right class="style24"><?php echo number_format(num($reg_fee),0,".",".") ?></td>
	            <td align=right class="style24"><?php echo e(substr($mc_receipt,0,4)); ?>
	              <p><?php echo e($mc_date); ?></p></td>
	            <td align=right class="style24"><?php echo number_format(num($mc),0,".",".") ?></td>
	            <td align=center class="style24"><?php echo e($row_billing[3]); ?>% <br>
	              <?php echo e($row_billing[4]); ?><br>
	              <?php echo e($row_billing[10]); ?></td>
	            <td align=center class="style24"><?php echo number_format(num($hrg_net),0,".",".") ?></td>
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
              </tr>             <?php $nomor = num($nomor) + 1;$reg_receipt =0;$reg_date =0;$reg_amount =0;$mc_receipt =0;$mc_date =0;$mc_amount =0;$full_receipt =0;$full_date =0;$full_amount = 0;$dp_receipt =    0;$dp_date =0;$dp_amount =0;	$inst_1_receipt =0;	$inst_1_date =0;$inst_1_amount =0;$inst_2_receipt =0;$inst_2_date = 0;$inst_2_amount =    0;$inst_3_receipt =    0;$inst_3_date =    0;$reg_paid=0;$mc_paid=0;$cabang='';$st_refund = 0;$RefundPaid = '';
			$inst_3_amount =    0;$sisa=0;
	$full_amount_paid = 0;$dp_amount_paid =    0;$inst_1_amount_paid =0;$inst_2_amount_paid =    0;		$inst_3_amount_paid =    0;$mc_paid=0;	
	}
 }?>
            
				    </tbody>
            <tfoot>
            </tfoot>
          </table>
			<label><a href="ocp.php?cd_cl=<?php echo e(u($cd_cl)) ?>&kd_cbg=<?php echo e(u($kd_cbg)) ?>" target="_blank">Print</a> </label>
        </div>
	    <label><a href="vip_open_class_report_sum.php" target="_blank">Summary By Center</a> </label>
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
	