<?php
require_once __DIR__ . "/_lib/bootstrap.php"; auth_require_login();
include __DIR__ . "/conndb.php";
include __DIR__ . "/profiledata.php";

/* ============================================================
   POPUP DETAIL TRANSAKSI PER SC
   Dibuka dari link nama SC di vip_sc_monthly_report.php.
   Query:
   SELECT v.id_receipt, c.nama_lengkap, kd_class, v.jns_payment, v.amount, v.dt_payment
   FROM ves_data.vip_billing_payment v
   LEFT JOIN ves_data.vip_billing t ON v.kd_billing = t.kd_billing
   LEFT JOIN ves_data.vip_student_data c ON v.kd_biodata = c.kd_biodata
   WHERE dt_payment BETWEEN '$mulai' AND '$selesai'
     AND v.status = 'PAID' AND t.sc = '$sc' [AND t.kd_branch = '$branch']
   ============================================================ */

$sc      = isset($_GET['sc'])      ? in_val('sc', 'get')      : '';
$branch  = isset($_GET['branch'])  ? in_val('branch', 'get')  : '';
$produk  = isset($_GET['produk'])  ? in_val('produk', 'get')  : ''; // '', 'CA', 'FA', 'VIP' - samain dgn vip_sc_monthly_report.php
$mulai   = isset($_GET['mulai'])   ? in_val('mulai', 'get')   : date("Y-m-01");
$selesai = isset($_GET['selesai']) ? in_val('selesai', 'get') : date("Y-m-t");

// mapping cabang - sama seperti di vip_sc_monthly_report.php
$center_list = array(
	''   => '--ALL--',
	'0'  => 'HO',
	'1'  => 'East Sby',
	'2'  => 'West Sby',
	'3'  => 'Denpasar',
	'4'  => 'South Jkt',
	'5'  => 'North Jkt',
	'6'  => 'West Jkt',
	'7'  => 'Bandung',
	'8'  => 'Malang TBI',
	'9'  => 'Bandung TBI',
	'10' => 'Bali TBI',
	'11' => 'PIK',
	'12' => 'Serpong',
	'14' => 'Medan',
	'15' => 'CA',
	'16' => 'Tangerang',
);
$branch_nama = isset($center_list[$branch]) ? $center_list[$branch] : $branch;

$sc_sql      = $sc;
$branch_sql  = $branch;
$mulai_sql   = $mulai;
$selesai_sql = $selesai;

$where = q_set($__p_where, "v.dt_payment between ? and ? and v.status = 'PAID' and t.sc = ? ", [(string) ($mulai_sql), (string) ($selesai_sql), (string) ($sc_sql)]);
if ($branch_sql !== '') {
	$where .= q_add($__p_where, " and t.kd_branch = ? ", [(string) ($branch_sql)]);
}

// filter Product - samain dgn logic di vip_sc_monthly_report.php
if ($produk == 'CA') {
	$where .= q_add($__p_where, " and (t.kd_program like 'CA%' or d.type_program = 'CA CoT')");
} elseif ($produk == 'FA') {
	$where .= q_add($__p_where, " and d.type_program = 'FELLOWS ACADEMY'");
} elseif ($produk == 'VIP') {
	$where .= q_add($__p_where, " and t.kd_program not like 'CA%' and (d.type_program is null or d.type_program != 'CA CoT') and (d.type_program is null or d.type_program != 'FELLOWS ACADEMY')");
}

$query = q_set($__p_query, "SELECT v.id_receipt, c.nama_lengkap, kd_class, v.jns_payment, v.amount, v.dt_payment\r
\tFROM ves_data.vip_billing_payment v\r
\tLEFT JOIN ves_data.vip_billing t ON v.kd_billing = t.kd_billing\r
\tLEFT JOIN ves_data.vip_student_data c ON v.kd_biodata = c.kd_biodata\r
\tLEFT JOIN ves_data.vip_mst_code_prg d ON t.kd_program = d.kd_program\r
\tWHERE " . $where . "  group by v.id_receipt\r
\tORDER BY v.dt_payment", [...($__p_where ?? [])]);
$resource = db_query_or_die("Query gagal: " . '', $query, $__p_query ?? []);
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Detail Transaksi - <?php echo htmlspecialchars($sc); ?></title>
  <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
  <style>
	body { padding: 15px; font-family: Calibri, Arial, sans-serif; }
	.detail-table { font-size: 12px; border-collapse: collapse; width: 100%; }
	.detail-table th, .detail-table td { border: 1px solid #999; padding: 4px 8px; text-align: center; }
	.detail-table thead th { background: #4F81BD; color: #fff; }
	.text-left { text-align: left !important; }
	.total-row { background: #F2F2F2; font-weight: bold; }
	.info-box { margin-bottom: 12px; font-size: 13px; }
  </style>
</head>
<body>
  <h4>Detail Transaksi</h4>
  <div class="info-box">
    SC: <b><?php echo htmlspecialchars($sc); ?></b> &nbsp;|&nbsp;
    Branch: <b><?php echo htmlspecialchars($branch_nama); ?></b> &nbsp;|&nbsp;
    Periode: <b><?php echo date("d M Y", strtotime($mulai)); ?></b> s/d <b><?php echo date("d M Y", strtotime($selesai)); ?></b>
<?php if ($produk !== '') { ?>
    &nbsp;|&nbsp; Product: <b><?php echo htmlspecialchars($produk); ?></b>
<?php } ?>
  </div>

  <table class="detail-table">
    <thead>
      <tr>
        <th>No</th>
        <th>Nama Siswa</th>
        <th>Kode Kelas</th>
        <th>No Receipt</th>
        <th>Jenis Payment</th>
        <th>Tanggal Payment</th>
        <th>Amount</th>
      </tr>
    </thead>
    <tbody>
<?php
$no = 1;
$total = 0;
if (num(db_num_rows($resource)) == 0) {
	echo "<tr><td colspan='7'>Tidak ada transaksi untuk SC & periode ini.</td></tr>";
} else {
	while ($row = db_fetch($resource, PDO::FETCH_NUM)) {
		$id_receipt   = $row[0];
		$nama_lengkap = $row[1];
		$kd_class     = $row[2];
		$jns_payment  = $row[3];
		$amount       = (float) $row[4];
		$dt_payment   = $row[5];
		$total = num($total) + num(($amount));
		echo "<tr>
				<td>" . e($no) . "</td>
				<td class='text-left'>" . htmlspecialchars($nama_lengkap) . "</td>
				<td class='text-left'>" . htmlspecialchars($kd_class) . "</td>
				<td class='text-left'>" . htmlspecialchars($id_receipt) . "</td>
				<td class='text-left'>" . htmlspecialchars($jns_payment) . "</td>
				<td>" . date("d M Y", strtotime($dt_payment)) . "</td>
				<td>" . number_format(num($amount), 0, ",", ".") . "</td>
			  </tr>";
		$no++;
	}
	echo "<tr class='total-row'>
			<td colspan='6' class='text-left'>Total</td>
			<td>" . number_format(num($total), 0, ",", ".") . "</td>
		  </tr>";
}
?>
    </tbody>
  </table>

  <p style="margin-top:15px;">
    <button type="button" class="btn btn-default btn-sm" onclick="window.print()">Print</button>
    <button type="button" class="btn btn-default btn-sm" onclick="window.close()">Tutup</button>
  </p>
</body>
</html>