<?php
require_once __DIR__ . "/_lib/bootstrap.php"; auth_require_login();
include __DIR__ . "/conndb.php";
include __DIR__ . "/profiledata.php";

/* ============================================================
   SC MONTHLY PAYMENT REPORT
   Format tabel: 1 baris = 1 kombinasi (sc + branch), kolom bulan
   dinamis sesuai periode filter (Bulan Awal s/d Bulan Akhir),
   nilai per bulan = SUM(v.amount) berdasarkan v.dt_payment.

   Sumber data:
   SELECT t.sc, t.kd_branch, v.amount, v.dt_payment
   FROM ves_data.vip_billing_payment v
   LEFT JOIN ves_data.vip_billing t ON v.kd_billing = t.kd_billing
   WHERE v.dt_payment BETWEEN '$mulai' AND '$selesai' AND v.status = 'PAID'

   Mengikuti pola teacher_salary_report.php:
   - include conndb.php + profiledata.php
   - mysql_* (sesuai codebase existing)
   - export ke Excel via header() sebelum output apa pun
   - AdminLTE/Bootstrap hanya di-load kalau BUKAN mode export
   ============================================================ */

$hari  = date("d");
$bulan = date("m");
$tahun = date("Y");
$hari_ini = "$tahun-$bulan-$hari";

// ---- Ambil parameter filter ----
$kd_cbg      = isset($_GET['kd_cbg']) ? in_val('kd_cbg', 'get') : '';
$produk      = isset($_GET['produk']) ? in_val('produk', 'get') : ''; // '', 'CA', 'FA', 'VIP'
$sc_filter   = isset($_GET['sc_filter']) ? trim(in_val('sc_filter', 'get')) : ''; // '' = semua SC
$tahun_pilih = isset($_GET['tahun_pilih']) ? in_val('tahun_pilih', 'get') : $tahun;
$bulan_awal  = isset($_GET['bulan_awal'])  ? intval(in_val('bulan_awal', 'get'))  : 1;
$bulan_akhir = isset($_GET['bulan_akhir']) ? intval(in_val('bulan_akhir', 'get')) : intval($bulan);
if (num($bulan_awal) < 1)  { $bulan_awal = 1; }
if (num($bulan_akhir) > 12) { $bulan_akhir = 12; }
if ($bulan_akhir < $bulan_awal) { $bulan_akhir = $bulan_awal; } // jaga2 kalau filter kebalik

$mulai   = "$tahun_pilih-" . str_pad($bulan_awal, 2, '0', STR_PAD_LEFT) . "-01";
$selesai = date("Y-m-t", strtotime("$tahun_pilih-" . str_pad($bulan_akhir, 2, '0', STR_PAD_LEFT) . "-01"));

// ---- Mode export HARUS dicek & header() dikirim SEBELUM ada output apa pun ----
$export_mode = isset($_GET['export']) && in_val('export', 'get') == 'xls';
if ($export_mode) {
	header("Content-Type: application/vnd.ms-excel; charset=utf-8");
	header("Content-Disposition: attachment; filename=SC_Payment_Report_$tahun_pilih" . "_$bulan_awal-$bulan_akhir.xls");
}

// ---- Mapping cabang (pakai key string supaya '0' dan '' tidak tabrakan) ----
$center_list = array(
	''   => '--ALL--',
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
$cabang = isset($center_list[$kd_cbg]) ? $center_list[$kd_cbg] : '--ALL--';

// ---- Mapping filter Product ----
// CA             : d.kd_program LIKE 'CA%'  OR d.type_program = 'CA CoT'
// Fellows Academy: d.type_program = 'FELLOWS ACADEMY'
// VIP English    : selain 2 kondisi di atas
$produk_list = array(
	''    => 'All Product',
	'CA'  => 'CA',
	'FA'  => 'Fellows Academy',
	'VIP' => 'VIP English',
);
$produk_nama = isset($produk_list[$produk]) ? $produk_list[$produk] : 'All Product';

// ---- Daftar bulan yang ditampilkan sebagai kolom, sesuai filter ----
$months_to_show = array();
for ($m = $bulan_awal; $m <= $bulan_akhir; $m++) {
	$months_to_show[$m] = date("M", mktime(0, 0, 0, $m, 1)); // Jan, Feb, Mar, ... Dec
}

// ---- Daftar SC untuk dropdown filter (hanya perlu di mode web) ----
$sc_list = array();
if (!$export_mode) {
	$res_sc = db_query_soft("SELECT DISTINCT sc FROM ves_data.vip_billing WHERE sc IS NOT NULL AND sc <> '' ORDER BY sc");
	if ($res_sc) {
		while ($r_sc = db_fetch($res_sc, PDO::FETCH_NUM)) { $sc_list[] = $r_sc[0]; }
	}
}
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>SC Monthly Payment Report</title>
<?php if (!$export_mode) { ?>
  <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
  <link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">
<?php } ?>
  <style>
	.salary-table { font-family: Calibri, Arial, sans-serif; font-size: 12px; border-collapse: collapse; }
	.salary-table th, .salary-table td { border: 1px solid #999; padding: 3px 6px; text-align: center; }
	.salary-table thead th { background: #4F81BD; color: #fff; }
	.text-left { text-align: left !important; }
	.grandtotal-row { background: #DCE6F1; font-weight: bold; }
	.subtotal-row { background: #F2F2F2; font-weight: bold; }
  </style>
</head>
<body<?php echo e($export_mode ? '' : ' class="hold-transition skin-blue sidebar-mini"'); ?>>
<?php if (!$export_mode) { ?>
<div class="content">
  <div class="box">
    <section class="content-header"><h1>SC Monthly Payment Report</h1></section>
    <section class="content">
      <form method="get" class="form-inline" style="margin-bottom:15px;">
        <div class="form-group" style="margin-right:10px;">
          <label>Branch</label>
          <select class="form-control" name="kd_cbg">
<?php foreach ($center_list as $kd => $nm) { ?>
            <option value="<?php echo e($kd); ?>" <?php echo e(($kd_cbg == $kd) ? 'selected' : ''); ?>><?php echo e($nm); ?></option>
<?php } ?>
          </select>
        </div>
        <div class="form-group" style="margin-right:10px;">
          <label>SC</label>
          <select class="form-control" name="sc_filter">
            <option value="">-- All SC --</option>
<?php foreach ($sc_list as $nm) { ?>
            <option value="<?php echo htmlspecialchars($nm); ?>" <?php echo e(($sc_filter === $nm) ? 'selected' : ''); ?>><?php echo htmlspecialchars($nm); ?></option>
<?php } ?>
          </select>
        </div>
        <div class="form-group" style="margin-right:10px;">
          <label>Tahun</label>
          <input type="number" class="form-control" name="tahun_pilih" value="<?php echo htmlspecialchars($tahun_pilih); ?>" style="width:90px;">
        </div>
        <div class="form-group" style="margin-right:10px;">
          <label>Bulan Awal</label>
          <select class="form-control" name="bulan_awal">
<?php for ($m = 1; num($m) <= 12; $m++) { ?>
            <option value="<?php echo e($m); ?>" <?php echo e(($bulan_awal == $m) ? 'selected' : ''); ?>><?php echo date("F", mktime(0,0,0,$m,1)); ?></option>
<?php } ?>
          </select>
        </div>
        <div class="form-group" style="margin-right:10px;">
          <label>Bulan Akhir</label>
          <select class="form-control" name="bulan_akhir">
<?php for ($m = 1; num($m) <= 12; $m++) { ?>
            <option value="<?php echo e($m); ?>" <?php echo e(($bulan_akhir == $m) ? 'selected' : ''); ?>><?php echo date("F", mktime(0,0,0,$m,1)); ?></option>
<?php } ?>
          </select>
        </div>
        <div class="form-group" style="margin-right:10px;">
          <label>Product</label>
          <select class="form-control" name="produk">
<?php foreach ($produk_list as $kd => $nm) { ?>
            <option value="<?php echo e($kd); ?>" <?php echo e(($produk == $kd) ? 'selected' : ''); ?>><?php echo e($nm); ?></option>
<?php } ?>
          </select>
        </div>
        <button type="submit" class="btn btn-primary">Tampilkan</button>
        <a class="btn btn-success" href="?<?php echo htmlspecialchars($_SERVER['QUERY_STRING']); ?>&export=xls" target="_blank">Export to Excel</a>
      </form>
      <p style="color:#777;">Periode: <b><?php echo date("d M Y", strtotime($mulai)); ?></b> s/d <b><?php echo date("d M Y", strtotime($selesai)); ?></b> &nbsp;|&nbsp; Branch: <b><?php echo htmlspecialchars($cabang); ?></b> &nbsp;|&nbsp; SC: <b><?php echo htmlspecialchars($sc_filter === '' ? 'All SC' : $sc_filter); ?></b> &nbsp;|&nbsp; Product: <b><?php echo htmlspecialchars($produk_nama); ?></b></p>
<?php
} // end if (!$export_mode)
?>
<?php

// ---- Query utama ----
$mulai_sql   = $mulai;
$selesai_sql = $selesai;

$where = q_set($__p_where, "v.dt_payment between ? and ? and v.status = 'PAID'", [(string) ($mulai_sql), (string) ($selesai_sql)]);
if ($kd_cbg !== '') {
	$kd_cbg_sql = $kd_cbg;
	$where .= q_add($__p_where, " and t.kd_branch = ? ", [(string) ($kd_cbg_sql)]);
}
if ($sc_filter !== '') {
	$sc_filter_sql = $sc_filter;
	$where .= q_add($__p_where, " and t.sc = ? ", [(string) ($sc_filter_sql)]);
}

// filter Product: CA (kd_program LIKE 'CA%' atau type_program = 'CA CoT'),
// Fellows Academy (type_program = 'FELLOWS ACADEMY'), VIP English (selain dua itu)
// -- kd_program dicek dari t.kd_program (vip_billing), type_program dari d.type_program (master)
if ($produk == 'CA') {
	$where .= q_add($__p_where, " and (t.kd_program like 'CA%' or d.type_program = 'CA CoT')");
} elseif ($produk == 'FA') {
	$where .= q_add($__p_where, " and d.type_program = 'FELLOWS ACADEMY'");
} elseif ($produk == 'VIP') {
	$where .= q_add($__p_where, " and t.kd_program not like 'CA%' and (d.type_program is null or d.type_program != 'CA CoT') and (d.type_program is null or d.type_program != 'FELLOWS ACADEMY')");
}

$query = q_set($__p_query, "SELECT t.sc, t.kd_branch, v.amount, v.dt_payment\r
\tFROM ves_data.vip_billing_payment v\r
\tLEFT JOIN ves_data.vip_billing t ON v.kd_billing = t.kd_billing\r
\tLEFT JOIN ves_data.vip_mst_code_prg d ON t.kd_program = d.kd_program\r
\tWHERE " . $where . " group by v.id_receipt", [...($__p_where ?? [])]);
$resource = db_query_or_die("Query gagal: " . '', $query, $__p_query ?? []);

// ---- Debug: tambahkan &debug=1 di URL buat lihat SQL yang jalan ----
if (!$export_mode && isset($_GET['debug'])) {
	echo "<pre style='background:#f5f5f5;padding:10px;border:1px solid #ccc;font-size:11px;white-space:pre-wrap;'>" . htmlspecialchars($query) . "</pre>";
}

// ---- Susun data: $data[sc|branch] = array('sc'=>.., 'branch'=>.., 'bulan'=>array(m=>total)) ----
$data = array();
$grand_per_bulan = array();
foreach ($months_to_show as $m => $lbl) { $grand_per_bulan[$m] = 0; }
$grand_total = 0;

while ($row = db_fetch($resource, PDO::FETCH_NUM)) {
	$sc         = $row[0];
	$kd_branch  = $row[1];
	$amount     = (float) $row[2];
	$dt_payment = $row[3];

	$bln = (int) date("n", strtotime($dt_payment)); // 1..12
	if (!isset($months_to_show[$bln])) { continue; } // di luar range filter, skip

	$key = $sc . '|' . $kd_branch;
	if (!isset($data[$key])) {
		$data[$key] = array(
			'sc'     => $sc,
			'branch' => $kd_branch,
			'bulan'  => array(),
		);
		foreach ($months_to_show as $m => $lbl) { $data[$key]['bulan'][$m] = 0; }
	}

	$data[$key]['bulan'][$bln] = num($data[$key]['bulan'][$bln]) + num(($amount));
	$grand_per_bulan[$bln]     = num($grand_per_bulan[$bln]) + num(($amount));
	$grand_total                = num($grand_total) + num(($amount));
}

// urut berdasarkan branch lalu nama sc
// (pakai named function, bukan closure, supaya kompatibel dengan PHP versi lama)
function cmp_branch_sc($a, $b) {
	$cmp = strcmp($a['branch'], $b['branch']);
	if (num($cmp) != 0) { return $cmp; }
	return strcmp($a['sc'], $b['sc']);
}
uasort($data, 'cmp_branch_sc');
?>

<table class="salary-table" width="100%" cellspacing="0" cellpadding="0">
  <thead>
    <tr>
      <th>Name</th>
      <th>Branch</th>
<?php foreach ($months_to_show as $m => $lbl) { ?>
      <th><?php echo e($lbl); ?></th>
<?php } ?>
      <th>Total</th>
    </tr>
  </thead>
  <tbody>
<?php
if (cnt($data) == 0) {
	$colspan = 3 + cnt($months_to_show);
	echo "<tr><td colspan='" . e($colspan) . "'>Tidak ada data untuk periode/filter ini.</td></tr>";
}

foreach ($data as $d) {
	$branch_nama = isset($center_list[$d['branch']]) ? $center_list[$d['branch']] : $d['branch'];
	$row_total = 0;

	// nama SC di-link ke popup detail transaksi (vip_sc_detail.php), hanya di mode web
	if ($export_mode) {
		$sc_cell = htmlspecialchars($d['sc']);
	} else {
		$popup_url = "vip_sc_detail.php?sc=" . urlencode($d['sc'])
			. "&branch=" . urlencode($d['branch'])
			. "&mulai=" . urlencode($mulai)
			. "&selesai=" . urlencode($selesai)
			. "&produk=" . urlencode($produk);
		$sc_cell = "<a href=\"" . e($popup_url) . "\" target=\"popup_sc\" "
			. "onClick=\"window.open('" . e($popup_url) . "','popup_sc','width=750,height=550,left=250,top=100'); return false;\">"
			. htmlspecialchars($d['sc']) . "</a>";
	}

	echo "<tr>";
	echo "<td class='text-left'>" . $sc_cell . "</td>";
	echo "<td class='text-left'>" . htmlspecialchars($branch_nama) . "</td>";
	foreach ($months_to_show as $m => $lbl) {
		$val = $d['bulan'][$m];
		$row_total = num($row_total) + num(($val));
		echo "<td>" . number_format(num($val), 0, ",", ".") . "</td>";
	}
	echo "<td><b>" . number_format(num($row_total), 0, ",", ".") . "</b></td>";
	echo "</tr>";
}

if (cnt($data) > 0) {
	echo "<tr class='grandtotal-row'>";
	echo "<td colspan='2' class='text-left'>Grand Total</td>";
	foreach ($months_to_show as $m => $lbl) {
		echo "<td>" . number_format(num($grand_per_bulan[$m]), 0, ",", ".") . "</td>";
	}
	echo "<td>" . number_format(num($grand_total), 0, ",", ".") . "</td>";
	echo "</tr>";
}
?>
  </tbody>
</table>

<?php if (!$export_mode) { ?>
    </section>
  </div>
</div>
<?php } ?>
</body>
</html>