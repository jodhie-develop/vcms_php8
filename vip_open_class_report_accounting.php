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


// ==== FIX: guard supaya $kd_cbg TIDAK PERNAH berupa array ====
// Ini akar masalah "muncul Array" - kalau request datang sebagai kd_cbg[]=..
// (mis. dari filter lain / option dropdown yang rusak), in_val('kd_cbg', 'get') jadi
// array, lalu dipakai langsung di query & di-echo -> PHP mencetak literal "Array".
$kd_cbg_raw = isset($_GET['kd_cbg']) ? in_val('kd_cbg', 'get') : '';
if (is_array($kd_cbg_raw)) {
    $kd_cbg_raw = reset($kd_cbg_raw); // ambil elemen pertama, jangan biarkan jadi array
}
$kd_cbg_raw = trim((string)$kd_cbg_raw);

// Satu sumber kebenaran untuk mapping kode <-> nama cabang (dulu ada 2 blok
// if/elseif terpisah yang saling tidak sinkron - itu penyebab dropdown
// "nyangkut"/tidak konsisten saat cabang dipilih).
$branch_map = array(
    1   => 'East Sby',
    2   => 'West Sby',
    3   => 'Denpasar',
    4   => 'South Jkt',
    5   => 'North Jkt',
    6   => 'West Jkt',
    7   => 'Bandung',
    8   => 'Malang',
    9   => 'Bandung TBI',
    10  => 'Bali TBI',
    15  => 'CA',
    100 => 'Online',
    111 => 'All',
);

// Value dari <select> di form ini SELALU angka (lihat option value="..").
// Blok if/elseif lama yang membandingkan ke string nama cabang ('East Sby' dst)
// tidak pernah kena karena itu, jadi dihapus (dead code) dan diganti cast int biasa.
if ($kd_cbg_raw === '' || $kd_cbg_raw === '0') {
    $kd_cbg = 0;
    $cabang = '--ALL--';
} else {
    $kd_cbg = (int)$kd_cbg_raw;
    $cabang = isset($branch_map[$kd_cbg]) ? $branch_map[$kd_cbg] : '--ALL--';
}

$nama_lengkap = $_SESSION['nama_lengkap'];
$nama_depan = $_SESSION['nama_depan'];

$posisi = $_SESSION['posisi']; 
$kd_staff = $_SESSION['kd_staff'] ;
$kdprg = isset($_GET['kdprg']) ? in_val('kdprg', 'get') : '';

$pilihan_sc = isset($_GET['pilihan_sc']) ? in_val('pilihan_sc', 'get') : '';
if ($pilihan_sc ==''){$pilihan_sc = 'All Leads';}
$cd_cl = isset($_GET['cd_cl']) ? trim(in_val('cd_cl', 'get')) : '';
// escape untuk dipakai di query mentah (masih pakai mysql_* lama, lihat catatan di bawah)
$cd_cl_sql = function_exists('mysql_real_escape_string') ? $cd_cl : addslashes($cd_cl);
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
  <link rel="stylesheet" href="cdnjs/ionicons.min.css">
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
 <form method=get action=vip_open_class_report_accountingtry.php> 
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="row">
        <div class="col-xs-12">
          <!-- /.box -->
<section class="content-header">
      <h1>VIP Open Class Payment Detail and SC Incentive<br>
  </h1>	<div class="box-body">
  <div class="row">  <div class="col-md-12">
	    <div class="form-group">
   	      <table width="527" border="0">
        <tbody>
          <tr class="table table-bordered table-striped">
            <th scope="row">Center</th>
            <td><select name="kd_cbg"  onChange="this.form.submit()"   class="style33" id="select">
              <option value="0" <?php echo e((num($kd_cbg)==0)?'selected':''); ?>>--CHOOSE--</option>
              <option value="1" <?php echo e((num($kd_cbg)==1)?'selected':''); ?>>East Sby</option>
              <option value="2" <?php echo e((num($kd_cbg)==2)?'selected':''); ?>>West Sby</option>
              <option value="3" <?php echo e((num($kd_cbg)==3)?'selected':''); ?>>Denpasar</option>
              <option value="8" <?php echo e((num($kd_cbg)==8)?'selected':''); ?>>Malang</option>
              <option value="4" <?php echo e((num($kd_cbg)==4)?'selected':''); ?>>South Jkt</option>
              <option value="5" <?php echo e((num($kd_cbg)==5)?'selected':''); ?>>North Jkt</option>
              <option value="6" <?php echo e((num($kd_cbg)==6)?'selected':''); ?>>West Jkt</option>
              <option value="7" <?php echo e((num($kd_cbg)==7)?'selected':''); ?>>Bandung</option>
              <option value="15" <?php echo e((num($kd_cbg)==15)?'selected':''); ?>>CA</option>
              <option value="100" <?php echo e((num($kd_cbg)==100)?'selected':''); ?>>Online</option>
              <option value="111" <?php echo e((num($kd_cbg)==111)?'selected':''); ?>>All</option>
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
and a.status_kelas = 1 group by a.kelas order by mulai_tm desc", [(string) ((int)$kd_cbg), (string) ($date_start) . " 00:00:00", (string) ($date_end) . " 23:00:00"]);	

								$resource_cl_code = db_query_or_die('errro_7', $query_cl_code, $__p_query_cl_code ?? []);
								while ($row_cl_code=  db_fetch($resource_cl_code, PDO::FETCH_NUM))
									{
							  		echo '<option value="'.htmlspecialchars($row_cl_code[0]).'">'.htmlspecialchars($row_cl_code[0]).'</option>';
							  		}      ?>
        <option selected><?php echo  htmlspecialchars($cd_cl) ?></option>
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
	            <td width="53" rowspan="2" align=center bgcolor=#CCCCCC class="style81">SC</td>
	            <td width="53" rowspan="2" align=center bgcolor=#CCCCCC class="style81">Reward</td>
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
$nilai_kelas = " kd_class = '$cd_cl_sql' ";	
}

				
if (num($kd_cbg) == 100)
{
$query_billing = q_set($__p_query_billing, "SELECT nama_lengkap, kd_class,tf,promo_persen,\r
discount,net_tf,reg_fee,material_cost,a.kd_billing,a.sc,a.voucher, b.kd_branch,a.kd_biodata\r
FROM ves_data.vip_billing a left join ves_data.vip_student_data b on a.kd_biodata = b.kd_biodata left join vip_teacher_schedule c on a.kd_class = c.kelas where kd_class = ? group by a.kd_billing", [(string) ($cd_cl_sql)]);	
}
else
{
$query_billing = q_set($__p_query_billing, "SELECT nama_lengkap, kd_class,tf,promo_persen,\r
discount,net_tf,reg_fee,material_cost,a.kd_billing,a.sc,a.voucher,b.kd_branch,a.kd_biodata\r
FROM ves_data.vip_billing a left join ves_data.vip_student_data b on a.kd_biodata = b.kd_biodata left join vip_teacher_schedule c on a.kd_class = c.kelas where a.kd_branch = ? and kd_class = ? group by a.kd_billing", [(string) ((int)$kd_cbg), (string) ($cd_cl_sql)]);		
}


$resource_billing = db_query_soft($query_billing, $__p_query_billing ?? []);
$keluar_billing = db_num_rows($resource_billing);

// ==== OPTIMASI: tarik semua baris billing dulu ke array PHP, ====
// baru kumpulkan ID-ID nya, supaya semua data pembayaran/refund/incentive
// bisa ditarik dalam BEBERAPA query saja (bukan per-siswa).
$billing_rows = array();
$billing_ids = array();
$biodata_ids = array();
if (num(db_num_rows($resource_billing)) > 0) {
	while ($row_billing = db_fetch($resource_billing, PDO::FETCH_NUM)) {
		$billing_rows[] = $row_billing;
		$billing_ids[$row_billing[8]] = true;   // kd_billing, dedup otomatis via key
		$biodata_ids[$row_billing[12]] = true;  // kd_biodata, dedup otomatis via key
	}
}

$payments = array();   // $payments[kd_billing][jns_payment] = array(receipt, date, amount)
$refunds  = array();   // $refunds[kd_billing] = total refund
$incentives = array(); // $incentives[kd_biodata] = array(nominal, st_paid)

if (cnt($billing_ids) > 0) {
	$billing_ids_sql = implode(",", array_map('intval', array_keys($billing_ids)));

	// 1 query untuk SEMUA jenis pembayaran SEMUA siswa (dulu 7 query x N siswa)
	$query_payments = "SELECT kd_billing, jns_payment, id_receipt,
		DATE_FORMAT(dt_payment,'%d %b %y') as tgl, amount
		FROM ves_data.vip_billing_payment
		WHERE kd_billing IN ($billing_ids_sql)";
	$resource_payments = db_query_or_die('errro_7', $query_payments, $__p_query_payments ?? []);
	while ($row_pay = db_fetch($resource_payments, PDO::FETCH_NUM)) {
		// kalau ada beberapa baris untuk kd_billing+jns_payment yang sama,
		// yang terakhir yang dipakai (sama seperti perilaku kode lama)
		$payments[$row_pay[0]][$row_pay[1]] = array($row_pay[2], $row_pay[3], $row_pay[4]);
	}

	// 1 query untuk SEMUA refund (dulu 1 query x N siswa)
	$query_refund = "SELECT kd_billing, sum(amount) FROM ves_data.vip_billing_refund
		WHERE kd_billing IN ($billing_ids_sql) GROUP BY kd_billing";
	$resource_refund = db_query_or_die('errro_7', $query_refund, $__p_query_refund ?? []);
	while ($row_refund = db_fetch($resource_refund, PDO::FETCH_NUM)) {
		$refunds[$row_refund[0]] = $row_refund[1];
	}

	// 1 query untuk SEMUA incentive (dulu 1 query x N siswa)
	if (cnt($biodata_ids) > 0) {
		$biodata_ids_sql = q_set($__p_biodata_ids_sql, "" . db_in(array_values((array) array_map('mysql_real_escape_string', array_keys($biodata_ids)))), [...array_map('strval', array_values((array) array_map('mysql_real_escape_string', array_keys($biodata_ids))))]);
		$query_incentive = q_set($__p_query_incentive, "SELECT kd_biodata, nominal, st_paid FROM ves_data.ve_incentive\r
\t\t\tWHERE kelas = ? AND kd_biodata IN (" . $biodata_ids_sql . ")", [(string) ($cd_cl_sql), ...($__p_biodata_ids_sql ?? [])]);
		$resource_incentive = db_query_or_die('errro_7', $query_incentive, $__p_query_incentive ?? []);
		while ($row_inc = db_fetch($resource_incentive, PDO::FETCH_NUM)) {
			$incentives[$row_inc[0]] = array($row_inc[1], $row_inc[2]);
		}
	}
}

foreach ($billing_rows as $row_billing) {
		$refund= 0;
		$hrg_net = $row_billing[5];
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
		$kdb = $row_billing[8];
			//==reg==
			if (isset($payments[$kdb]['Registration'])) {
				list($reg_receipt, $reg_date, $reg_amount) = $payments[$kdb]['Registration'];
				if ($reg_receipt != ''){$reg_paid = $reg_amount;}
			}
			$mc = $row_billing[7];
			//==mc==
			if (isset($payments[$kdb]['Material'])) {
				list($mc_receipt, $mc_date, $mc_amount) = $payments[$kdb]['Material'];
				if ($mc_receipt != ''){$mc_paid = $mc_amount;}
			}
			//==full payment==
			if (isset($payments[$kdb]['Full Payment'])) {
				list($full_receipt, $full_date, $full_amount) = $payments[$kdb]['Full Payment'];
				if ($full_receipt != ''){$full_amount_paid = $full_amount;}
			}
			//==DP==
			if (isset($payments[$kdb]['Down Payment'])) {
				list($dp_receipt, $dp_date, $dp_amount) = $payments[$kdb]['Down Payment'];
				if ($dp_receipt != ''){$dp_amount_paid = $dp_amount;}
			}
			//==inst 1==
			if (isset($payments[$kdb]['Installment 1'])) {
				list($inst_1_receipt, $inst_1_date, $inst_1_amount) = $payments[$kdb]['Installment 1'];
				if ($inst_1_receipt != ''){$inst_1_amount_paid = $inst_1_amount;}
			}
			//==inst 2==
			if (isset($payments[$kdb]['Installment 2'])) {
				list($inst_2_receipt, $inst_2_date, $inst_2_amount) = $payments[$kdb]['Installment 2'];
				if ($inst_2_receipt != ''){$inst_2_amount_paid = $inst_2_amount;}
			}
			//==inst 3==
			if (isset($payments[$kdb]['Installment 3'])) {
				list($inst_3_receipt, $inst_3_date, $inst_3_amount) = $payments[$kdb]['Installment 3'];
				if ($inst_3_receipt != ''){$inst_3_amount_paid = $inst_3_amount;}
			}

//=======
		if (isset($refunds[$kdb])) {
			$refund = $refunds[$kdb];
			$st_refund = 1;
			if (num($refund) != 0) {$RefundPaid = "Refund Paid";}
		}
//=======		
		if (isset($incentives[$row_billing[12]])) {
			$inc_amount = $incentives[$row_billing[12]][0];
			$inc_st_paid = $incentives[$row_billing[12]][1];
		}
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
	            <td align=left class="style24"><?php echo e($row_billing[9]); ?></td>
	            <td height="14" align=left class="style24"><?php echo  number_format(num($inc_amount),0,".","."); ?> <?php echo e($inc_st_paid); ?><br>
                <a href="ve_incentive_input.php?id=<?php echo e(u($row_billing[8])); ?>" 
target="popup" 
onclick="window.open('ve_incentive_input.php?cl=<?php echo e(u($cd_cl)); ?>&kd_biodata=<?php echo e(u($row_billing[12])) ?>&sc=<?php echo e(u($row_billing[9])) ?> ','popup','width=1000,height=800'); return false;"> <button type="button" class="btn btn-block btn-info">Edit</button></a></td> 
              </tr>             <?php $nomor = num($nomor) + 1;$reg_receipt =0;$reg_date =0;$reg_amount =0;$mc_receipt =0;$mc_date =0;$mc_amount =0;$full_receipt =0;$full_date =0;$full_amount = 0;$dp_receipt =    0;$dp_date =0;$dp_amount =0;	$inst_1_receipt =0;	$inst_1_date =0;$inst_1_amount =0;$inst_2_receipt =0;$inst_2_date = 0;$inst_2_amount =    0;$inst_3_receipt =    0;$inst_3_date =    0;$reg_paid=0;$mc_paid=0;$cabang='';$st_refund = 0;$RefundPaid = '';$inc_amount=0;$inc_st_paid='';
			$inst_3_amount =    0;$sisa=0;
	$full_amount_paid = 0;$dp_amount_paid =    0;$inst_1_amount_paid =0;$inst_2_amount_paid =    0;		$inst_3_amount_paid =    0;$mc_paid=0;	
	}
?>
            
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