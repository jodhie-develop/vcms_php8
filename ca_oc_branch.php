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
$Display = in_val('Display', 'get');
 
if ($date_start ==''){$date_start = "2026-01-01";}
if ($date_end ==''){$date_end = $hari_ini;}
 
$nama_lengkap = $_SESSION['nama_lengkap'];
$posisi = $_SESSION['posisi']; 
$kd_staff = $_SESSION['kd_staff'] ;
$kelompok = $_SESSION['kelompok'];
if ( $nama_depan == 'jimmy' or $nama_lengkap == 'Stevanus Yustiawan'  or $nama_lengkap == 'kimberly' or $kelompok=='ACC'){
$kd_cbg = in_val('kd_cbg', 'get');
}
else
{$kd_cbg = $_SESSION['kd_branch'];}
if ($kd_cbg == 'National'){$kd_cbg = '1000';}
 
elseif ($kd_cbg == 'East Sby'){$kd_cbg = 1;}
elseif ($kd_cbg == 'West Sby'){$kd_cbg = 2;}
elseif ($kd_cbg == 'Denpasar'){$kd_cbg = 3;}
elseif ($kd_cbg == 'South Jkt'){$kd_cbg = 4;}
elseif ($kd_cbg == 'North Jkt'){$kd_cbg = 5;}
elseif ($kd_cbg == 'West Jkt'){$kd_cbg = 6;}
elseif ($kd_cbg == 'Bandung'){$kd_cbg = 7;}
elseif ($kd_cbg == 'Malang'){$kd_cbg = 8;}
elseif ($kd_cbg == 'CA'){$kd_cbg = 15;}
elseif ($kd_cbg == 'East Area'){$kd_cbg = 101;}
elseif ($kd_cbg == 'JAKARTA'){$kd_cbg = 111;}
elseif ($kd_cbg == 'West Area'){$kd_cbg = 102;}
elseif ($kd_cbg == 'Online'){$kd_cbg = 100;}
elseif ($kd_cbg == 'National'){$kd_cbg = '1000';}
elseif ($kd_cbg == 'Medan'){$kd_cbg = 14;}
elseif ($kd_cbg == 'PIK'){$kd_cbg = 11;}
 
 
if (num($kd_cbg) ==100){$cabang = 'Online';}
elseif ($kd_cbg =='1000'){$cabang = 'National';}
 
elseif (num($kd_cbg) ==1){$cabang = 'East Sby';}
elseif (num($kd_cbg) ==2){$cabang = 'West Sby';}
elseif (num($kd_cbg) ==3){$cabang = 'Denpasar';}
elseif (num($kd_cbg) ==4){$cabang = 'South Jkt';}
elseif (num($kd_cbg) ==5){$cabang = 'North Jkt';}
elseif (num($kd_cbg) ==6){$cabang = 'West Jkt';}
elseif (num($kd_cbg) ==7){$cabang = 'Bandung';}
elseif (num($kd_cbg) ==8){$cabang = 'Malang';}
elseif (num($kd_cbg) ==15){$cabang = 'CA';}
elseif (num($kd_cbg) ==111){$cabang = 'JAKARTA';}
elseif (num($kd_cbg) ==11){$cabang = 'PIK';}
elseif (num($kd_cbg) ==14){$cabang = 'Medan';}
 
$kelas_name = in_val('kelas_name', 'get');
 
$pilihan_sc = in_val('pilihan_sc', 'get');
if ($pilihan_sc ==''){$pilihan_sc = 'All Leads';}
 
if($kd_cbg ==''){$filter_cbg = q_set($__p_filter_cbg, " ");}
 
elseif($kd_cbg == '100'){$filter_cbg = q_set($__p_filter_cbg, " where a.kd_branch = '100' "); 	$query_nm_sc = "select nama_detail from ves_data.tb_user a where (posisi = 'SC' or posisi = 'AC' or posisi = 'CM' or posisi = 'admission') and aktif = 'Y' group by nama_detail order by nama_detail";}
//elseif ($kd_cbg == '1000'){$filter_cbg = " where (a.kd_branch = '1' or a.kd_branch = '2' or a.kd_branch = '3' or a.kd_branch = '4' or a.kd_branch = '5'  or a.kd_branch = '6' or a.kd_branch = '7' or a.kd_branch = '11' or a.kd_branch = '8'  or a.kd_branch = '14' or a.kd_branch = '16'      ) and b.nm_program != 'CA'  ";	$query_nm_sc = "select nama_detail from ves_data.tb_user a where (posisi = 'SC' or posisi = 'AC' or posisi = 'CM' or posisi = 'admission') and aktif = 'Y' and (a.kd_branch = '1' or a.kd_branch = '2' or a.kd_branch = '3' or a.kd_branch = '4' or a.kd_branch = '5'  or a.kd_branch = '6' or a.kd_branch = '7' or a.kd_branch = '11' or a.kd_branch = '8'   or a.kd_branch = '14' or a.kd_branch = '16' )";}

elseif ($kd_cbg == '1000'){$filter_cbg = q_set($__p_filter_cbg, " where (a.kd_branch between 1 and 16 ) and b.nm_program != 'CA'  ");	$query_nm_sc = "select nama_detail from ves_data.tb_user a where (posisi = 'SC' or posisi = 'AC' or posisi = 'CM' or posisi = 'admission') and aktif = 'Y' and (a.kd_branch = '1' or a.kd_branch = '2' or a.kd_branch = '3' or a.kd_branch = '4' or a.kd_branch = '5'  or a.kd_branch = '6' or a.kd_branch = '7' or a.kd_branch = '11' or a.kd_branch = '8'   or a.kd_branch = '14' or a.kd_branch = '16' )";}


elseif ($kd_cbg == '101'){$filter_cbg = q_set($__p_filter_cbg, " where (a.kd_branch = '1' or a.kd_branch = '1' or a.kd_branch = '3' or a.kd_branch = '8'  )");	$query_nm_sc = "select nama_detail from ves_data.tb_user a where (posisi = 'SC' or posisi = 'AC' or posisi = 'CM' or posisi = 'admission') and aktif = 'Y' and a.kd_branch = '1' or a.kd_branch = '1' or a.kd_branch = '3' or a.kd_branch = '8' order by nama_detail";}
elseif ($kd_cbg == '102'){$filter_cbg = q_set($__p_filter_cbg, " where (a.kd_branch = '4' or a.kd_branch = '5' or a.kd_branch = '6' or a.kd_branch = '7'  )  ");	$query_nm_sc = "select nama_detail from ves_data.tb_user a where (posisi = 'SC' or posisi = 'AC' or posisi = 'CM' or posisi = 'admission') and aktif = 'Y' and a.kd_branch = '4' or a.kd_branch = '5' or a.kd_branch = '6' or a.kd_branch = '7' order by nama_detail";}
elseif ($kd_cbg == '111'){$filter_cbg = q_set($__p_filter_cbg, " where (a.kd_branch = '4' or a.kd_branch = '5' or a.kd_branch = '6' or a.kd_branch = '11'  )  ");	$query_nm_sc = "select nama_detail from ves_data.tb_user a where (posisi = 'SC' or posisi = 'AC' or posisi = 'CM' or posisi = 'admission') and aktif = 'Y' and (a.kd_branch = '4' or a.kd_branch = '5' or a.kd_branch = '6')";}
elseif ($kd_cbg =='15') {$filter_cbg = q_set($__p_filter_cbg, " where b.nm_program = 'CA' ");	$query_nm_sc = "select nama_detail from ves_data.tb_user a where (posisi = 'SC' or posisi = 'AC' or posisi = 'CM' or posisi = 'admission') and aktif = 'Y' and a.kd_branch = '$kd_cbg' order by nama_detail";}
//elseif ($kd_cbg !='15') {$filter_cbg = " where  a.kd_branch = '$kd_cbg' and b.nm_program <> 'CA' ";$query_nm_sc = "select nama_detail from ves_data.tb_user a where (posisi = 'SC' or posisi = 'AC' or posisi = 'CM' or posisi = 'admission') and aktif = 'Y' and a.kd_branch = '$kd_cbg' order by nama_detail";}
 
else {$filter_cbg = q_set($__p_filter_cbg, " where a.kd_branch = ? ", [(string) ($kd_cbg)]);$query_nm_sc = "select nama_detail from ves_data.tb_user a where (posisi = 'SC' or posisi = 'AC' or posisi = 'CM' or posisi = 'admission') and aktif = 'Y' and a.kd_branch = '$kd_cbg' order by nama_detail";}
if ($filter_cbg =='') {$filter_tgl = q_set($__p_filter_tgl, " where f.min_mulai\t between ? and ? ", [(string) ($date_start) . " 00:00:00", (string) ($date_end) . " 23:00:00"]);}
else {$filter_tgl = q_set($__p_filter_tgl, " and f.min_mulai between ? and ? ", [(string) ($date_start) . " 00:00:00", (string) ($date_end) . " 23:00:00"]);}
if ($kelas_name !=''){$filter_kelas = q_set($__p_filter_kelas, " and a.kelas like ?  ", ["%" . (string) ($kelas_name) . "%"]);} else {$filter_kelas ='';}
$nm_sc ='All';
$kd_cbg='CA';
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
 <form method=get action=#> 
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>CA Open Class and Payment List<br>
      </h1>
    <table width="685" border="0">
        <tbody>
          <tr>
            <td><small>
            <label for="date3">Center :</label>
            </small></td>
            <td>: 
              <select name="kd_cbg"     class="style33" id="select"   onChange="this.form.submit()">
				  
              <option selected="selected">CA</option>
            </select></td>
          </tr>
          <tr>
            <td><small>
              <label for="date4">Consultant :</label>
            </small></td>
            <td>:
              <select class="form-control" name="nm_sc">


          <option selected>All</option>
        </select></td>
          </tr>
          <tr>
			  <td width="129"><small>
              <label for="date5"> Start Class Period :</label>
              </small></td>
            <td width="546"><small>
              <label for="date2">:</label>
            <input type="date"  name="date_start" id="date_start" value="<?php echo e($date_start) ; ?>">
To </small><small>
<input type="date" name="date_end" id="date_end" value="<?php echo e($date_end) ; ?>">
</small></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td><input type="submit" name="Display" id="Display" value="Display"></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td><a href="ca_oc_branch_export_xl.php?kd_cbg=<?php echo e(u($kd_cbg))?>&date_start=<?php echo e(u($date_start)) ?>&date_end=<?php echo e(u($date_end)) ?>&nm_sc=<?php echo e(u($nm_sc)) ?>" target="_blank" class="btn btn-default"><i class="fa fa-print"></i>Excel</a><a href="vip_open_class_report_accxlraw.php?kd_cbg=<?php echo e(u($kd_cbg))?>&date_start=<?php echo e(u($date_start)) ?>&date_end=<?php echo e(u($date_end))?>&nm_sc=<?php echo e(u($nm_sc)) ?>" target="_blank" class="btn btn-default"><i class="fa fa-print"></i>Raw Excel</a></td>			  
          </tr>
        </tbody>
    </table>
  </section><!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <!-- /.box -->
 
          <div class="box">
            <!-- /.box-header -->
            <div class="box-body">
	        <?php 
//===jika ada billing
//$query_billing = "SELECT a.kd_billing,b.nm_program, b.level_program, b.type_program, sum(net_tf+reg_fee+material_cost) as invoiced,a.dt_entry,c.nama, c.middle_name, c.family_name,a.kd_biodata FROM ves_data.vip_billing a left join ves_data.vip_mst_code_prg b on a.kd_program = b.kd_program left join ves_inc.tb_biodata c on a.kd_biodata = c.kd_biodata where a.kd_branch = '$kd_cbg' and a.dt_entry between '$date_start' and '$date_end' group by a.kd_billing order by a.kd_billing" ;
//						   echo $query_billing;
						   
//$resource_billing = mysql_query($query_billing);
//$keluar_billing = db_num_rows($resource_billing);
					   ?>
	          <?php	
	$adafile = 0;
				$urut_no = 1;
// ===== OPTIMIZED: payment subquery digabung ke query utama (N+1 -> 1 query) =====
$filter_sc_clause = ($nm_sc != 'All' && $nm_sc != '') ? "and g.sc = '$nm_sc'" : '';
 
$query_open_class = q_set($__p_query_open_class, "\r
SELECT\r
  a.mulai_tm,\r
  h.minggu,\r
  e.nama_lengkap,\r
  a.kelas,\r
  b.duration_program,\r
  date_format(a.mulai_tm,'%b %d, %Y'),\r
  g.sc,\r
  g.tf,\r
  g.net_tf,\r
  g.discount,\r
  g.kd_billing,\r
  date_format(a.mulai_tm, '%c'),\r
  g.kd_branch,\r
  date_format(a.mulai_tm, '%y'),\r
  b.nm_program,\r
  a.level_program,\r
  COALESCE(pay.reg_amount, 0)       AS reg_amount,\r
  COALESCE(pay.material_amount, 0)  AS material_amount,\r
  COALESCE(pay.tf_amount, 0)        AS tf_amount\r
FROM ves_data.vip_teacher_schedule a\r
LEFT JOIN ves_data.vip_mst_code_prg b\r
  ON a.kode_program = b.kd_program AND a.level_program = b.level_program\r
LEFT JOIN ves_data.vip_billing g\r
  ON a.kelas = g.kd_class\r
LEFT JOIN ves_data.vip_student_data e\r
  ON g.kd_biodata = e.kd_biodata\r
LEFT JOIN ves_data.tb_minggu_detail h\r
  ON date_format(a.mulai_tm, '%Y-%m-%d') = date_format(h.detail, '%Y-%m-%d')\r
LEFT JOIN (\r
  SELECT\r
    p.kd_billing,\r
    SUM(CASE WHEN p.jns_payment = 'Registration' AND p.status='PAID' THEN p.amount ELSE 0 END) AS reg_amount,\r
    SUM(CASE WHEN p.jns_payment = 'Material'     AND p.status='PAID' THEN p.amount ELSE 0 END) AS material_amount,\r
    SUM(CASE WHEN p.jns_payment IN ('Down Payment','Full Payment','Installment 1','Installment 2','Installment 3')\r
             AND p.status='PAID' THEN p.amount ELSE 0 END) AS tf_amount\r
  FROM vip_billing_payment p\r
  GROUP BY p.kd_billing\r
) pay ON g.kd_billing = pay.kd_billing\r
INNER JOIN (\r
  SELECT kelas, MIN(mulai_tm) AS min_mulai\r
  FROM vip_teacher_schedule\r
  WHERE status_kelas = 1\r
  GROUP BY kelas\r
) f ON a.kelas = f.kelas AND a.mulai_tm = f.min_mulai\r
" . $filter_cbg . " " . $filter_tgl . " " . $filter_kelas . "\r
AND a.kd_biodata = ''\r
AND a.status_kelas = 1\r
" . $filter_sc_clause . "\r
GROUP BY a.kelas, e.kd_biodata\r
ORDER BY g.kd_branch, a.kelas\r
", [...($__p_filter_cbg ?? []), ...($__p_filter_tgl ?? []), ...($__p_filter_kelas ?? []), ...($__p_filter_sc_clause ?? [])]);
// ===== END OPTIMIZED QUERY =====
 /* echo $query_open_class (debug SQL versi lama) dihapus */
if ($Display != ''){
 
// ===== Open Class Report (per-cabang summary, seperti template Excel) =====
// Urutan & kode branch mengikuti mapping kd_cbg yang sudah dipakai di file ini
// Catatan: kode 15 (CA) TIDAK dipakai lagi sebagai bucket cabang biasa.
// Kelas dengan nm_program = 'CA' di-mapping ke cabang lewat nama SC (Consultant),
// lalu digabung ke bucket cabang yang bersangkutan (bukan bucket "CA" sendiri).
$cabang_report_order = array(
	1   => 'East Sby',
	2   => 'West Sby',
	3   => 'Denpasar',
	4   => 'South Jkt',
	5   => 'North Jkt',
	6   => 'West Jkt',
	7   => 'Bandung',
	8   => 'Malang',
	11  => 'PIK',
	100 => 'Online',
	14  => 'Medan',
	16  => 'Tangerang',
);
$cabang_report = array();
foreach ($cabang_report_order as $kd => $nm) {
	$cabang_report[$kd] = array(
		'nama'          => $nm,
		'event_payment' => 0,       // belum ada sumber data event di query ini, default 0
		'total_income'  => 0,
		'reg_fee'       => 0,
		'material_paid' => 0,       // Material Book Paid (sebelumnya tidak pernah diakumulasi)
		'tuition_paid'  => 0,       // installment/full payment yang PAID (sesuai kolom "Tuition Paid" di Excel)
		'kelas_set'     => array(), // untuk hitung jumlah kelas unik
		'total_student' => 0,
	);
}
// nama cabang -> kd_branch (reverse lookup), dipakai untuk mapping SC ke cabang
$cabang_name_to_kd = array_flip($cabang_report_order);

// Bucket untuk kelas CA yang SC-nya belum ada di mapping (supaya tidak hilang diam-diam)
$cabang_report['CA_UNMAPPED'] = array(
	'nama'          => 'CA - Unmapped SC',
	'event_payment' => 0,
	'total_income'  => 0,
	'reg_fee'       => 0,
	'material_paid' => 0,
	'tuition_paid'  => 0,
	'kelas_set'     => array(),
	'total_student' => 0,
);
// ===== END Open Class Report init =====

$resource_open_class = db_query_soft($query_open_class, $__p_query_open_class ?? []);
$keluar_open_class = db_num_rows($resource_open_class);				
if(num(db_num_rows($resource_open_class)) > 0)
	{
	while ($row_open_class  =  db_fetch($resource_open_class, PDO::FETCH_NUM))
		{
		$nm_program = $row_open_class[14];
		$kelas_baru = $row_open_class[3];
		$kd_branch_row = $row_open_class[12];
		if (num($row_open_class[12]) ==100){$cabangdisplay = 'Online';}
		elseif ($row_open_class[12] ==''){$cabangdisplay = 'National';}
		elseif (num($row_open_class[12]) ==1){$cabangdisplay = 'East Sby';}
		elseif (num($row_open_class[12]) ==2){$cabangdisplay = 'West Sby';}
		elseif (num($row_open_class[12]) ==3){$cabangdisplay = 'Denpasar';}
		elseif (num($row_open_class[12]) ==4){$cabangdisplay = 'South Jkt';}
		elseif (num($row_open_class[12]) ==5){$cabangdisplay = 'North Jkt';}
		elseif (num($row_open_class[12]) ==6){$cabangdisplay = 'West Jkt';}
		elseif (num($row_open_class[12]) ==7){$cabangdisplay = 'Bandung';}
		elseif (num($row_open_class[12]) ==8){$cabangdisplay = 'Malang';}
		elseif (num($row_open_class[12]) ==101){$cabangdisplay = 'East Area';}
		elseif (num($row_open_class[12]) ==102){$cabangdisplay = 'West Area';}
		elseif (num($row_open_class[12]) ==11){$cabangdisplay = 'PIK';}
		elseif (num($row_open_class[12]) ==14){$cabangdisplay = 'Medan';}
		elseif (num($row_open_class[12]) ==15){$cabangdisplay = 'CA';}
		elseif (num($row_open_class[12]) ==16){$cabangdisplay = 'Tangerang';}
		
		
		if ($kelas_lama  != $kelas_baru){$hitungperkelas = 1;$angkakelas = num($angkakelas) + 1;}
//		$query_jml_murid = "SELECT count(kd_billing) as jml FROM ves_data.vip_billing where kd_class= '$row_open_class[3]' and kd_branch = '$kd_cbg' ";
//		$resource_jml_murid = mysql_query($query_jml_murid);
//		$keluar_jml_murid = db_num_rows($resource_jml_murid);				
//		if(db_num_rows($resource_jml_murid) > 0)
//			{
//			while ($row_jml_murid  =  db_fetch($resource_jml_murid, PDO::FETCH_NUM))
//				{	
//				$jml_murid = $row_jml_murid[0];
//				}
//			}
//		$query_last_date = "SELECT max(mulai_tm) as selesai,date_format(max(mulai_tm),'%b %d, %Y') FROM ves_data.vip_teacher_schedule a where a.kelas = '$row_open_class[3]'" ;
//		$resource_last_date = mysql_query($query_last_date);
//		$keluar_last_date = db_num_rows($resource_last_date);				
//		if(db_num_rows($resource_last_date) > 0)
//			{
//			while ($row_last_date  =  db_fetch($resource_last_date, PDO::FETCH_NUM))
//				{
//				$kelas_selesai = $row_last_date[1];					
//				}
//			}
//		$query_time_teacher = "select date_format(mulai_tm, '%a'),  date_format(mulai_tm, '%H:%i'),date_format(selesai_tm, '%H:%i'),nm_teacher 	
//		$query_time_teacher = "select nm_teacher from vip_teacher_schedule where kelas = '$row_open_class[3]' group by  nm_teacher" ;
			
//		$resource_time_teacher = mysql_query($query_time_teacher);		
//		if(db_num_rows($resource_time_teacher) > 0)
//			{
//			while ($row_time_teacher  =  db_fetch($resource_time_teacher, PDO::FETCH_NUM))
//				{
				//$jadwal_1= "$row_time_teacher[0] ($row_time_teacher[1]-$row_time_teacher[2]) - $row_time_teacher[3]<br>";
//				$infoteacher= "$row_time_teacher[0]";
//					
				//$baris_jadwal = "$baris_jadwal $jadwal_1";	
//				$baris_teacher = "$baris_teacher $infoteacher";	
					
//				}
//			}
//		$query_day_teacher = "select date_format(mulai_tm,'%a') from vip_teacher_schedule where kelas = '$row_open_class[3]' group by date_format(mulai_tm,'%a') order by date_format(mulai_tm, '%w')" ;
			
//		$resource_day_teacher = mysql_query($query_day_teacher);		
//		if(db_num_rows($resource_day_teacher) > 0)
//			{
//			while ($row_day_teacher  =  db_fetch($resource_day_teacher, PDO::FETCH_NUM))
//				{
				//$jadwal_1= "$row_time_teacher[0] ($row_time_teacher[1]-$row_time_teacher[2]) - $row_time_teacher[3]<br>";
	//			$infoday= "$row_day_teacher[0]";
					
				//$baris_jadwal = "$baris_jadwal $jadwal_1";	
	//			$baris_day = "$baris_day $infoday";	
					
		//		}
		//	}
// tampilkan bayar
//		$query_reg ="SELECT  amount  FROM ves_data.vip_billing_payment where  jns_payment = 'Registration' and kd_billing = '$row_open_class[10]' and status = 'PAID' "; 
//		$resource_reg = mysql_query($query_reg) or die('errro_71');
//			while ($row_reg=  db_fetch($resource_reg, PDO::FETCH_NUM))
//			{
//			$reg_amount =   $row_reg[0];
//			$reg_amount_ttl = $reg_amount_ttl + $reg_amount;	
//			}
//		$query_material ="SELECT  amount  FROM ves_data.vip_billing_payment where  jns_payment = 'Material' and kd_billing = '$row_open_class[10]' and status = 'PAID' "; 
//		$resource_material = mysql_query($query_material) or die('errro_71');
//			while ($row_material=  db_fetch($resource_material, PDO::FETCH_NUM))
//			{
//			$reg_material =   $row_material[0];	
//			$reg_material_ttl =   $reg_material_ttl + $reg_material;				
//			$mb = 1;
//			}	
		
//		$query_tf ="SELECT  sum(amount)  FROM ves_data.vip_billing_payment where  (jns_payment = 'Down Payment' or jns_payment = 'Full Payment' or jns_payment = 'Installment 1' or jns_payment = 'Installment 2'  or jns_payment = 'Installment 3') and kd_billing = '$row_open_class[10]' and status = 'PAID' "; 
//		$resource_tf = mysql_query($query_tf) or die('errro_71');
//			while ($row_tf=  db_fetch($resource_tf, PDO::FETCH_NUM))
//			{
//			$tf_amount =   $row_tf[0];	
//			$tf_amount_ttl = $tf_amount_ttl+$tf_amount;	
//			}	
		
//		$query_refund_tf ="SELECT  sum(a.amount)  FROM vip_billing_refund a left join vip_billing_payment b on a.id_receipt = b.id_receipt where  a.kd_billing = '$row_open_class[10]'   and (b.jns_payment = 'Installment 1' or b.jns_payment = 'Installment 2' or b.jns_payment = 'Installment 3' or b.jns_payment = 'Down Payment' or b.jns_payment = 'Full Payment') "; 
 
	//	$resource_refund_tf = mysql_query($query_refund_tf) or die('errro_71');
	//		while ($row_refund_tf=  db_fetch($resource_refund_tf, PDO::FETCH_NUM))
	//		{
	//		$refund_tf_amount =   $row_refund_tf[0];
	//		$refund_tf_amount_ttl =   $refund_tf_amount_ttl+$refund_tf_amount;	
	//		}
		
//		$query_refund_other ="SELECT  sum(a.amount)  FROM vip_billing_refund a left join vip_billing_payment b on a.id_receipt = b.id_receipt where  a.kd_billing = '$row_open_class[10]'   and (b.jns_payment = 'Material' or b.jns_payment = 'Registration') "; 
 
//		$resource_refund_other = mysql_query($query_refund_other) or die('errro_71');
	//		while ($row_refund_other=  db_fetch($resource_refund_other, PDO::FETCH_NUM))
		//	{
		//	$refund_other_amount =   $row_refund_other[0];
		//	$refund_other_amount_ttl = $refund_other_amount_ttl + $refund_other_amount;				
		//	}
//		$query_incentive ="SELECT  nominal,date_format(a.paid_date, '%Y-%m-%d')  FROM ve_incentive a where  a.kd_billing = '$row_open_class[10]' and paid_by <>''";
 
//		$resource_incentive = mysql_query($query_incentive) or die('errro_71');
//			while ($row_incentive=  db_fetch($resource_incentive, PDO::FETCH_NUM))
//			{
//			$incentive =   $row_incentive[0];
//			$paid_date = $row_incentive[1];				
//			}	
		
		
		// Ambil data payment dari kolom hasil subquery (sudah di-aggregate, tidak perlu query ulang)
		$reg_amount       = $row_open_class[16];
		$reg_material     = $row_open_class[17];
		$tf_amount        = $row_open_class[18];
		if (num($mb) !=1){$nmb = 1;}else{$nmb = '';}

		// ===== Akumulasi Open Class Report per cabang =====
		// Total Income  = Net TF (nilai kontrak, row_open_class[8]) + Reg Fee Paid
		// Tuition Paid  = tf_amount (installment/full payment yang PAID)
		// Material Paid = Material Book Paid (dulu diambil tapi tidak pernah diakumulasi -> hilang dari total)
		// Total Payment (dihitung di bagian display) = Reg Fee + Material Paid + Tuition Paid
		// Refund SEMENTARA tidak diikutkan (data vip_billing_refund tidak bisa dipastikan link & periodenya)
		// Kelas dengan nm_program = 'CA' di-mapping ke cabang lewat nama SC (Consultant),
		// lalu digabung ke bucket cabang tsb (bukan bucket tersendiri).
		if (trim($nm_program) === 'CA') {
			$sc = $row_open_class[6];
			if ($sc =='Britney Sherleen Poogoh') {$cabang ='West Sby';}
			elseif ($sc =='Jeanny Merilla Theda Lukito') {$cabang ='Denpasar';}
			elseif ($sc =='Levinia Aldora Susmono') {$cabang ='West Jkt';}
			elseif ($sc =='Indah Nur Atika Sari') {$cabang ='Denpasar';}
			elseif ($sc =='Simon') {$cabang ='West Jkt';}
			elseif ($sc =='sabrina marcela') {$cabang ='East Sby';}
			elseif ($sc =='sabrina marchella') {$cabang ='East Sby';}
			elseif ($sc =='Cornelia Nathalie') {$cabang ='East Sby';}
			elseif ($sc =='Arsyi Aisyah') {$cabang ='East Sby';}
			elseif ($sc =='Stevanus Yustiawan') {$cabang ='West Jkt';}
			elseif ($sc =='Event') {$cabang ='East Sby';}
			else {$cabang = null;}

			$kd_branch_key = ($cabang !== null && isset($cabang_name_to_kd[$cabang])) ? $cabang_name_to_kd[$cabang] : 'CA_UNMAPPED';
		} else {
			$kd_branch_key = $kd_branch_row;
		}
		if ($kd_branch_key !== '' && isset($cabang_report[$kd_branch_key])) {
			$cabang_report[$kd_branch_key]['total_income']  = num($cabang_report[$kd_branch_key]['total_income']) + num((num($row_open_class[8]) + num($reg_amount)));
			$cabang_report[$kd_branch_key]['reg_fee']       = num($cabang_report[$kd_branch_key]['reg_fee']) + num(($reg_amount));
			$cabang_report[$kd_branch_key]['material_paid'] = num($cabang_report[$kd_branch_key]['material_paid']) + num(($reg_material));
			$cabang_report[$kd_branch_key]['tuition_paid']  = num($cabang_report[$kd_branch_key]['tuition_paid']) + num(($tf_amount));
			$cabang_report[$kd_branch_key]['kelas_set'][$kelas_baru] = true;
			$cabang_report[$kd_branch_key]['total_student'] = num($cabang_report[$kd_branch_key]['total_student']) + num((1));
		}
		// ===== END akumulasi =====
			
		}
	}
}
?>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>


<div class="box box-solid box-primary">
	<div class="box-header with-border">
		<h3 class="box-title">&nbsp;</h3>
	</div>
	<div class="box-body">
		<table width="100%" class="table table-bordered table-striped" id="example4">
			<thead>
				<tr style="background-color:#1F4E78;color:#ffffff;">
					<td align=center><strong>Cabang</strong></td>
					<td align=center><strong>Event Payment</strong></td>
					<td align=center><strong>Total Income</strong></td>
					<td align=center><strong>Reg Fee Paid</strong></td>
					<td align=center><strong>Material Paid</strong></td>
					<td align=center><strong>Tuition Paid</strong></td>
					<td align=center><strong>Total Payment</strong></td>
					<td align=center><strong>Outstanding</strong></td>
					<td align=center><strong>Jumlah Kelas</strong></td>
					<td align=center><strong>Total Student</strong></td>
				</tr>
			</thead>
			<tbody>
<?php
if ($Display != '') {
	$grand_event = $grand_income = $grand_regfee = $grand_material = $grand_tuition = $grand_payment = $grand_outstanding = 0;
	$grand_kelas = $grand_student = 0;
	foreach ($cabang_report_order as $kd => $nm) {
		$row = $cabang_report[$kd];
		$total_income  = $row['total_income'];                                   // Net TF + Reg Fee Paid
		// Total Payment = Reg Fee + Tuition Paid (Material Paid & Refund tidak diikutkan)
		$total_payment = num($row['reg_fee']) + num($row['tuition_paid']);
		$outstanding   = num($total_income) - num($total_payment);                         // Total Income - Total Payment
		$jumlah_kelas  = cnt($row['kelas_set']);
		$event_payment = $row['event_payment'];

		$grand_event       = num($grand_event) + num(($event_payment));
		$grand_income      = num($grand_income) + num(($total_income));
		$grand_regfee      = num($grand_regfee) + num(($row['reg_fee']));
		$grand_material    = num($grand_material) + num(($row['material_paid']));
		$grand_tuition     = num($grand_tuition) + num(($row['tuition_paid']));
		$grand_payment     = num($grand_payment) + num(($total_payment));
		$grand_outstanding = num($grand_outstanding) + num(($outstanding));
		$grand_kelas       = num($grand_kelas) + num(($jumlah_kelas));
		$grand_student     = num($grand_student) + num(($row['total_student']));
?>
				<tr>
					<td align=left bgcolor="#FCE4D6"><strong><?php echo e($nm); ?></strong></td>
					<td align=right><?php echo number_format(num($event_payment),0,',','.'); ?></td>
					<td align=right><?php echo number_format(num($total_income),0,',','.'); ?></td>
					<td align=right><?php echo number_format(num($row['reg_fee']),0,',','.'); ?></td>
					<td align=right><?php echo number_format(num($row['material_paid']),0,',','.'); ?></td>
					<td align=right><?php echo number_format(num($row['tuition_paid']),0,',','.'); ?></td>
					<td align=right><?php echo number_format(num($total_payment),0,',','.'); ?></td>
					<td align=right><?php echo number_format(num($outstanding),0,',','.'); ?></td>
					<td align=center><?php echo e($jumlah_kelas); ?></td>
					<td align=center><?php echo e($row['total_student']); ?></td>
				</tr>
<?php
	}
	// ===== Baris CA yang SC-nya belum ada di mapping (supaya tidak hilang diam-diam) =====
	$row = $cabang_report['CA_UNMAPPED'];
	if (num($row['total_student']) > 0) {
		$total_income  = $row['total_income'];
		$total_payment = num($row['reg_fee']) + num($row['tuition_paid']);
		$outstanding   = num($total_income) - num($total_payment);
		$jumlah_kelas  = cnt($row['kelas_set']);
		$event_payment = $row['event_payment'];

		$grand_event       = num($grand_event) + num(($event_payment));
		$grand_income      = num($grand_income) + num(($total_income));
		$grand_regfee      = num($grand_regfee) + num(($row['reg_fee']));
		$grand_material    = num($grand_material) + num(($row['material_paid']));
		$grand_tuition     = num($grand_tuition) + num(($row['tuition_paid']));
		$grand_payment     = num($grand_payment) + num(($total_payment));
		$grand_outstanding = num($grand_outstanding) + num(($outstanding));
		$grand_kelas       = num($grand_kelas) + num(($jumlah_kelas));
		$grand_student     = num($grand_student) + num(($row['total_student']));
?>
				<tr style="background-color:#FFF2CC;">
					<td align=left><strong>CA - Unmapped SC</strong></td>
					<td align=right><?php echo number_format(num($event_payment),0,',','.'); ?></td>
					<td align=right><?php echo number_format(num($total_income),0,',','.'); ?></td>
					<td align=right><?php echo number_format(num($row['reg_fee']),0,',','.'); ?></td>
					<td align=right><?php echo number_format(num($row['material_paid']),0,',','.'); ?></td>
					<td align=right><?php echo number_format(num($row['tuition_paid']),0,',','.'); ?></td>
					<td align=right><?php echo number_format(num($total_payment),0,',','.'); ?></td>
					<td align=right><?php echo number_format(num($outstanding),0,',','.'); ?></td>
					<td align=center><?php echo e($jumlah_kelas); ?></td>
					<td align=center><?php echo e($row['total_student']); ?></td>
				</tr>
<?php
	}
	// ===== END baris CA unmapped =====
?>
				<tr style="background-color:#A9D08E;font-weight:bold;">
					<td align=left><strong>GRAND TOTAL</strong></td>
					<td align=right><?php echo number_format(num($grand_event),0,',','.'); ?></td>
					<td align=right><?php echo number_format(num($grand_income),0,',','.'); ?></td>
					<td align=right><?php echo number_format(num($grand_regfee),0,',','.'); ?></td>
					<td align=right><?php echo number_format(num($grand_material),0,',','.'); ?></td>
					<td align=right><?php echo number_format(num($grand_tuition),0,',','.'); ?></td>
					<td align=right><?php echo number_format(num($grand_payment),0,',','.'); ?></td>
					<td align=right><?php echo number_format(num($grand_outstanding),0,',','.'); ?></td>
					<td align=center><?php echo e($grand_kelas); ?></td>
					<td align=center><?php echo e($grand_student); ?></td>
				</tr>
<?php
} else {
?>
				<tr><td colspan="10" align="center">Klik "Display" untuk menampilkan report.</td></tr>
<?php
}
?>
			</tbody>
		</table>
	</div>
</div>
<!-- /.box Open Class Report -->

        <!-- /.col -->
      </div>
      
      <!-- /.row --><!-- /.content -->
	</form> 
<!-- /.content-wrapper --><!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Create the tabs -->
    <ul class="nav nav-tabs nav-justified control-sidebar-tabs">
      <li><a href="#control-sidebar-home-tab" data-toggle="tab"><i class="fa fa-home"></i></a></li>
      <li><a href="#control-sidebar-settings-tab" data-toggle="tab"><i class="fa fa-gears"></i></a></li>
    </ul>
    <!-- Tab panes -->
    <div class="tab-content">
      <!-- Home tab content -->
      <div class="tab-pane" id="control-sidebar-home-tab">
        <h3 class="control-sidebar-heading">Recent Activity</h3>
        <ul class="control-sidebar-menu">
          <li>
            <a href="javascript:void(0)">
              <i class="menu-icon fa fa-birthday-cake bg-red"></i>
 
              <div class="menu-info">
                <h4 class="control-sidebar-subheading">Langdon's Birthday</h4>
 
                <p>Will be 23 on April 24th</p>
              </div>
            </a>
          </li>
          <li>
            <a href="javascript:void(0)">
              <i class="menu-icon fa fa-user bg-yellow"></i>
 
              <div class="menu-info">
                <h4 class="control-sidebar-subheading">Frodo Updated His Profile</h4>
 
                <p>New phone +1(800)555-1234</p>
              </div>
            </a>
          </li>
          <li>
            <a href="javascript:void(0)">
              <i class="menu-icon fa fa-envelope-o bg-light-blue"></i>
 
              <div class="menu-info">
                <h4 class="control-sidebar-subheading">Nora Joined Mailing List</h4>
 
                <p>nora@example.com</p>
              </div>
            </a>
          </li>
          <li>
            <a href="javascript:void(0)">
              <i class="menu-icon fa fa-file-code-o bg-green"></i>
 
              <div class="menu-info">
                <h4 class="control-sidebar-subheading">Cron Job 254 Executed</h4>
 
                <p>Execution time 5 seconds</p>
              </div>
            </a>
          </li>
        </ul>
        <!-- /.control-sidebar-menu -->
 
        <h3 class="control-sidebar-heading">Tasks Progress</h3>
        <ul class="control-sidebar-menu">
          <li>
            <a href="javascript:void(0)">
              <h4 class="control-sidebar-subheading">
                Custom Template Design
                <span class="label label-danger pull-right">70%</span>
              </h4>
 
              <div class="progress progress-xxs">
                <div class="progress-bar progress-bar-danger" style="width: 70%"></div>
              </div>
            </a>
          </li>
          <li>
            <a href="javascript:void(0)">
              <h4 class="control-sidebar-subheading">
                Update Resume
                <span class="label label-success pull-right">95%</span>
              </h4>
 
              <div class="progress progress-xxs">
                <div class="progress-bar progress-bar-success" style="width: 95%"></div>
              </div>
            </a>
          </li>
          <li>
            <a href="javascript:void(0)">
              <h4 class="control-sidebar-subheading">
                Laravel Integration
                <span class="label label-warning pull-right">50%</span>
              </h4>
 
              <div class="progress progress-xxs">
                <div class="progress-bar progress-bar-warning" style="width: 50%"></div>
              </div>
            </a>
          </li>
          <li>
            <a href="javascript:void(0)">
              <h4 class="control-sidebar-subheading">
                Back End Framework
                <span class="label label-primary pull-right">68%</span>
              </h4>
 
              <div class="progress progress-xxs">
                <div class="progress-bar progress-bar-primary" style="width: 68%"></div>
              </div>
            </a>
          </li>
        </ul>
        <!-- /.control-sidebar-menu -->
 
      </div>
      <!-- /.tab-pane -->
      <!-- Stats tab content -->
      <div class="tab-pane" id="control-sidebar-stats-tab">Stats Tab Content</div>
      <!-- /.tab-pane -->
      <!-- Settings tab content -->
      <div class="tab-pane" id="control-sidebar-settings-tab">
        <form method="post"><?php echo csrf_field(); ?>

          <h3 class="control-sidebar-heading">General Settings</h3>
 
          <div class="form-group">
            <label class="control-sidebar-subheading">
              Report panel usage
              <input type="checkbox" class="pull-right" checked>
            </label>
 
            <p>
              Some information about this general settings option
            </p>
          </div>
          <!-- /.form-group -->
 
          <div class="form-group">
            <label class="control-sidebar-subheading">
              Allow mail redirect
              <input type="checkbox" class="pull-right" checked>
            </label>
 
            <p>
              Other sets of options are available
            </p>
          </div>
          <!-- /.form-group -->
 
          <div class="form-group">
            <label class="control-sidebar-subheading">
              Expose author name in posts
              <input type="checkbox" class="pull-right" checked>
            </label>
 
            <p>
              Allow the user to show his name in blog posts
            </p>
          </div>
          <!-- /.form-group -->
 
          <h3 class="control-sidebar-heading">Chat Settings</h3>
 
          <div class="form-group">
            <label class="control-sidebar-subheading">
              Show me as online
              <input type="checkbox" class="pull-right" checked>
            </label>
          </div>
          <!-- /.form-group -->
 
          <div class="form-group">
            <label class="control-sidebar-subheading">
              Turn off notifications
              <input type="checkbox" class="pull-right">
            </label>
          </div>
          <!-- /.form-group -->
 
          <div class="form-group">
            <label class="control-sidebar-subheading">
              Delete chat history
              <a href="javascript:void(0)" class="text-red pull-right"><i class="fa fa-trash-o"></i></a>
            </label>
          </div>
          <!-- /.form-group -->
        </form>
      </div>
      <!-- /.tab-pane -->
    </div>
  </aside>
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
			echo "window.location = ('prestuvip.php');\n";				
			echo "</script>";
	}
?>
 