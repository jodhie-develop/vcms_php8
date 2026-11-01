<?php
require_once __DIR__ . "/_lib/bootstrap.php"; auth_require_login();
ob_start(); // tampung dulu semua output (termasuk dari atas.php) supaya header()
            // untuk export Excel di bawah tetap bisa dikirim tanpa error
            // "headers already sent" -- lihat catatan EXPORT TO EXCEL (v7).
include __DIR__ . "/conndb.php";
include __DIR__ . "/profiledata.php";
include __DIR__ . "/atas.php";

/* ============================================================
   DEVICE INVENTORY REPORT (device_invent.php) — v1
   Format mengikuti file Inventaris_Nomor_HP_dan_WA_Kantor.xlsx:
     1. Dashboard & Summary  -> dihitung LANGSUNG dari tabel via
        query SUM/COUNT (formula-driven), TIDAK ada angka hardcode
        dan tidak disimpan sebagai tabel terpisah.
     2. Data Inventaris Nomor -> daftar nomor HP/WA kantor.
     3. Riwayat Pembayaran    -> log transaksi bayar/isi ulang.

   Filter di GET, mode export ke Excel (?export=xls) dicek &
   header() dikirim SEBELUM ada output HTML apa pun (pola sama
   seperti teacher_salary_report.php).

   TOMBOL NEW / UPDATE (v2): "Tambah Nomor Baru" & "Edit" per baris
   membuka popup device_invent_upd.php (pola sama seperti tombol
   nama teacher di teacher_salary_report.php yang membuka
   teacher_master_upd.php, dan popitup() di vip_pt_record_upd.php).
   Setelah Save di popup, halaman ini otomatis reload
   (window.opener.location.reload) supaya data terbaru langsung
   kelihatan. device_invent_upd.php WAJIB ada di folder yang sama.

   TOMBOL PAID (v3): tiap baris di Data Inventaris Nomor sekarang
   ada tombol "PAID" yang membuka popup device_invent_pay.php,
   sudah otomatis terisi data device (Nomor HP, Penanggung Jawab,
   Divisi, Tipe Layanan, default Jumlah Tagihan dari Biaya Bulanan)
   -- user tinggal cek/ubah nominal & metode pembayaran lalu Save,
   otomatis tercatat sebagai baris baru di Riwayat Pembayaran.
   device_invent_pay.php WAJIB ada di folder yang sama.

   CATATAN DATA (lihat juga create_table_device_invent.sql):
   - tipe_layanan disimpan apa adanya dari sumber ("Pascapayar"),
     tidak dikoreksi otomatis jadi "Pascabayar".
   - Riwayat Pembayaran dihubungkan ke Data Inventaris lewat
     nomor_hp (bukan id_aset), karena begitu struktur data sumber.
     Kalau suatu saat 1 nomor HP pernah dipakai >1 aset (recycle
     nomor), relasi ini bisa salah tarik data -- perlu dicek manual
     kalau itu terjadi, TIDAK di-assume aman.
   - periode_bulan (DATE) di device_payment_log itu opsional/
     turunan dari periode_text ("Agustus 2026"). Kalau kolom itu
     belum diisi konsisten, filter per periode di bawah fallback
     ke periode_text.

   WAJIB jalankan dulu create_table_device_invent.sql kalau tabel
   ves_data.mst_device_inventory dan ves_data.device_payment_log
   belum ada.

   TAMPILAN (v5): wrapper/container disamakan dengan
   teacher_salary_report.php -- dari "content-wrapper > content >
   section.content" (AdminLTE default, ada margin-left buat
   sidebar) jadi "content > box > section.content-header +
   section.content" (tanpa content-wrapper), supaya lebar halaman
   FULL, tidak ketarik ke tengah/sempit oleh margin sidebar.

   EXPORT TO EXCEL (v6): sebelumnya export mode punya kode SENDIRI
   yang terpisah dari tampilan layar (tabel polos, tanpa Dashboard
   Summary, kolom beda escaping-nya) -- sekarang DISATUKAN mengikuti
   pola teacher_salary_report.php: SATU kode/loop yang sama dipakai
   baik untuk tampil di layar maupun untuk export, supaya data &
   struktur kolom di file Excel PASTI sama persis dengan yang di
   layar (tidak ada 2 versi yang bisa drift beda). Yang beda cuma
   kolom "Aksi" (Edit/PAID) yang otomatis disembunyikan saat export.

   EXPORT TO EXCEL FIX (v7): atas.php (menu "ALT V-CMS" dst) sudah
   mengeluarkan output SEBELUM header() export dipanggil, jadi
   header() gagal ("headers already sent") dan browser malah
   nampilin halaman HTML biasa (dengan warning PHP di atasnya)
   alih-alih men-download file .xls. Diperbaiki pakai output
   buffering: ob_start() di paling awal file, lalu ob_end_clean()
   PERSIS sebelum header() export dipanggil, supaya output dari
   atas.php dkk dibuang dulu dan header() bisa jalan normal.

   COLORING & STYLE DI EXPORT (v8): sebelumnya saat export, <style>
   di <head> TIDAK ikut terkirim (karena <head> cuma dirender saat
   !export_mode) -- jadi warna badge status/header tabel/baris
   subtotal HILANG di file Excel, tampil polos. Sekarang semua
   elemen yang butuh warna/format (header tabel, badge status,
   badge status bayar, baris subtotal, perataan kiri) DIBERI INLINE
   STYLE langsung di tag HTML-nya (bukan cuma lewat class CSS),
   supaya warnanya tetap muncul walau <style> di <head> tidak ikut
   ter-export -- Excel/browser membaca inline style="..." langsung
   dari tag, tidak perlu file CSS terpisah. Class CSS (utk tampilan
   di layar) tetap dipertahankan berdampingan, tidak dihapus.
   ============================================================ */

$hari  = date("d");
$bulan = date("m");
$tahun = date("Y");
$hari_ini = "$tahun-$bulan-$hari";

// Daftar status & divisi yang dipakai untuk badge warna & filter dropdown.
// TODO: sesuaikan/tambah kalau ada status atau divisi baru di data.
$STATUS_LIST = array('Aktif', 'Cadangan', 'Non-Aktif');
$STATUS_BADGE_CLASS = array(
	'Aktif'     => 'badge-aktif',
	'Cadangan'  => 'badge-cadangan',
	'Non-Aktif' => 'badge-nonaktif',
);

// ---- Inline style (v8): dipakai di layar MAUPUN export, supaya warna & format
//      tetap konsisten walau <style> di <head> tidak ikut ter-export ----
$FONT_BASE   = "font-family:Calibri,Arial,sans-serif;font-size:12px;";
$ST_TH       = "border:1px solid #999;padding:3px 6px;text-align:center;background:#4F81BD;color:#fff;$FONT_BASE";
$ST_TD       = "border:1px solid #999;padding:3px 6px;text-align:center;$FONT_BASE";
$ST_TD_LEFT  = "border:1px solid #999;padding:3px 6px;text-align:left;$FONT_BASE";
$ST_SUB      = "border:1px solid #999;padding:3px 6px;text-align:center;font-weight:bold;background:#eef3f8;$FONT_BASE";
$ST_SUB_LEFT = "border:1px solid #999;padding:3px 6px;text-align:left;font-weight:bold;background:#eef3f8;$FONT_BASE";
$ST_BADGE = array(
	'Aktif'     => 'background:#00a65a;color:#fff;padding:2px 8px;border-radius:3px;',
	'Cadangan'  => 'background:#f39c12;color:#fff;padding:2px 8px;border-radius:3px;',
	'Non-Aktif' => 'background:#dd4b39;color:#fff;padding:2px 8px;border-radius:3px;',
);
$ST_BADGE_BAYAR = array(
	'Lunas'   => 'background:#00a65a;color:#fff;padding:2px 8px;border-radius:3px;',
	'Pending' => 'background:#f39c12;color:#fff;padding:2px 8px;border-radius:3px;',
);

// ---- Ambil parameter filter ----
$divisi_filter = isset($_GET['divisi_filter']) ? in_val('divisi_filter', 'get') : 'All';
$status_filter = isset($_GET['status_filter']) ? in_val('status_filter', 'get') : 'All';
$periode_filter = isset($_GET['periode_filter']) ? in_val('periode_filter', 'get') : '';

// ---- WHERE clause untuk Data Inventaris (dipakai ulang di beberapa query) ----
$where_inv = q_set($__p_where_inv, "1=1");
if ($divisi_filter != '' && $divisi_filter != 'All') {
	$divisi_sql = $divisi_filter;
	$where_inv .= q_add($__p_where_inv, " AND divisi = ? ", [(string) ($divisi_sql)]);
}
if ($status_filter != '' && $status_filter != 'All') {
	$status_sql = $status_filter;
	$where_inv .= q_add($__p_where_inv, " AND status_nomor = ? ", [(string) ($status_sql)]);
}

// ---- Mode export HARUS dicek & header() dikirim SEBELUM ada output apa pun ----
$export_mode = isset($_GET['export']) && in_val('export', 'get') == 'xls';
if ($export_mode) {
	// Buang dulu semua output yang sudah kebuffer dari atas.php/dll (mis. menu
	// "ALT V-CMS") -- kalau tidak dibuang, header() di bawah gagal ("headers
	// already sent") dan browser jadinya nampilin halaman biasa alih-alih
	// nge-download file .xls (ini penyebab "formatnya rusak").
	if (ob_get_level()) {
		ob_end_clean();
	}
	header("Content-Type: application/vnd.ms-excel; charset=utf-8");
	header("Content-Disposition: attachment; filename=Device_Inventory_Report_$hari_ini.xls");
}

// ============================================================
// 1. DASHBOARD & SUMMARY -- semua angka dihitung via query,
//    bukan hardcode, supaya selalu ikut data terbaru.
// ============================================================

// -- Ringkasan Status Nomor --
$query_status = q_set($__p_query_status, "SELECT status_nomor, COUNT(*) AS jml, SUM(biaya_bulanan) AS total_biaya\r
\tFROM ves_data.mst_device_inventory\r
\tWHERE " . $where_inv . "\r
\tGROUP BY status_nomor", [...($__p_where_inv ?? [])]);
$result_status = db_query_or_die("Wah error nih query ringkasan status", $query_status, $__p_query_status ?? []);

$ringkasan_status = array();
$total_nomor_all = 0;
while ($row = db_fetch($result_status, PDO::FETCH_ASSOC)) {
	$ringkasan_status[$row['status_nomor']] = $row;
	$total_nomor_all = num($total_nomor_all) + num(((int) $row['jml']));
}

// -- Ringkasan Per Divisi --
$query_divisi = q_set($__p_query_divisi, "SELECT divisi, COUNT(*) AS jml, SUM(biaya_bulanan) AS total_biaya\r
\tFROM ves_data.mst_device_inventory\r
\tWHERE " . $where_inv . "\r
\tGROUP BY divisi\r
\tORDER BY divisi", [...($__p_where_inv ?? [])]);
$result_divisi = db_query_or_die("Wah error nih query ringkasan divisi", $query_divisi, $__p_query_divisi ?? []);

// -- Total Biaya Bulanan Keseluruhan (nomor Aktif + Cadangan, ikut filter) --
$query_total_biaya = q_set($__p_query_total_biaya, "SELECT SUM(biaya_bulanan) AS total_biaya, COUNT(*) AS jml_nomor\r
\tFROM ves_data.mst_device_inventory\r
\tWHERE " . $where_inv, [...($__p_where_inv ?? [])]);
$result_total_biaya = db_query_or_die("Wah error nih query total biaya", $query_total_biaya, $__p_query_total_biaya ?? []);
$row_total_biaya = db_fetch($result_total_biaya, PDO::FETCH_ASSOC);

// ============================================================
// 2. DATA INVENTARIS NOMOR -- daftar detail per nomor
// ============================================================
$query_data = q_set($__p_query_data, "SELECT id_aset, nomor_hp, provider, tipe_layanan, penanggung_jawab, divisi,\r
\t\tjabatan_peruntukan, status_nomor, status_wa_business, paket_plan,\r
\t\tbiaya_bulanan, tgl_jatuh_tempo, tgl_registrasi, no_iccid, keterangan\r
\tFROM ves_data.mst_device_inventory\r
\tWHERE " . $where_inv . "\r
\tORDER BY divisi, id_aset", [...($__p_where_inv ?? [])]);
$result_data = db_query_or_die("Wah error nih query data inventaris", $query_data, $__p_query_data ?? []);

// ============================================================
// 3. RIWAYAT PEMBAYARAN -- log transaksi, dihubungkan via nomor_hp
//    (lihat catatan di header file soal relasi ini)
// ============================================================
$where_riwayat = q_set($__p_where_riwayat, "1=1");
if ($divisi_filter != '' && $divisi_filter != 'All') {
	$where_riwayat .= q_add($__p_where_riwayat, " AND divisi = ? ", [(string) ($divisi_sql)]);
}
if ($periode_filter != '') {
	$periode_sql = $periode_filter;
	$where_riwayat .= q_add($__p_where_riwayat, " AND (periode_text = ? OR periode_bulan = ? )", [(string) ($periode_sql), (string) ($periode_sql)]);
}
$query_riwayat = q_set($__p_query_riwayat, "SELECT id_transaksi, nomor_hp, penanggung_jawab, divisi, periode_text,\r
\t\ttanggal_bayar, tipe_layanan, jumlah_tagihan, metode_pembayaran,\r
\t\tno_bukti_referensi, status_bayar\r
\tFROM ves_data.device_payment_log\r
\tWHERE " . $where_riwayat . "\r
\tORDER BY tanggal_bayar DESC", [...($__p_where_riwayat ?? [])]);
$result_riwayat = db_query_or_die("Wah error nih query riwayat pembayaran", $query_riwayat, $__p_query_riwayat ?? []);

$sum_tagihan = 0; // dihitung sambil loop render, bukan query terpisah, karena baris riwayat sudah kebaca di atas

// -- Dropdown filter divisi (distinct dari data, bukan hardcode) --
$query_dd_divisi = q_set($__p_query_dd_divisi, "SELECT DISTINCT divisi FROM ves_data.mst_device_inventory ORDER BY divisi");
$result_dd_divisi = db_query_soft($query_dd_divisi, $__p_query_dd_divisi ?? []);

if (!$export_mode) {
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Device Inventory Report</title>
  <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
  <link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">
  <style>
	.inv-table { font-family: Calibri, Arial, sans-serif; font-size: 12px; }
	.inv-table th, .inv-table td { border: 1px solid #999; padding: 3px 6px; text-align: center; }
	.inv-table thead th { background: #4F81BD; color: #fff; }
	.inv-table td.text-left { text-align: left; }
	.section-title { font-size: 16px; font-weight: bold; margin: 20px 0 8px 0; }
	.summary-box { border: 1px solid #ccc; border-radius: 4px; padding: 10px 14px; margin-bottom: 10px; background: #f9f9f9; }
	.summary-box .angka { font-size: 22px; font-weight: bold; }
	.badge-aktif { background: #00a65a; color: #fff; padding: 2px 8px; border-radius: 3px; }
	.badge-cadangan { background: #f39c12; color: #fff; padding: 2px 8px; border-radius: 3px; }
	.badge-nonaktif { background: #dd4b39; color: #fff; padding: 2px 8px; border-radius: 3px; }
	.badge-lunas { background: #00a65a; color: #fff; padding: 2px 8px; border-radius: 3px; }
	.badge-pending { background: #f39c12; color: #fff; padding: 2px 8px; border-radius: 3px; }
	.subtotal-row td { font-weight: bold; background: #eef3f8; }
	.filter-bar { margin-bottom: 15px; }
  </style>
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="content">
  <div class="box">
    <section class="content-header"><h1>Device Inventory Report</h1></section>
    <section class="content">

      <form method="get" class="filter-bar form-inline">
        <label>Center:</label>
        <select name="divisi_filter" class="form-control input-sm">
          <option value="All" <?php echo e(($divisi_filter == 'All') ? 'selected' : ''); ?>>All</option>
<?php while ($d = db_fetch($result_dd_divisi, PDO::FETCH_ASSOC)) { ?>
          <option value="<?php echo htmlspecialchars($d['divisi']); ?>" <?php echo e(($divisi_filter == $d['divisi']) ? 'selected' : ''); ?>><?php echo htmlspecialchars($d['divisi']); ?></option>
<?php } ?>
        </select>

        <label style="margin-left:10px;">Status Nomor:</label>
        <select name="status_filter" class="form-control input-sm">
          <option value="All" <?php echo e(($status_filter == 'All') ? 'selected' : ''); ?>>All</option>
<?php foreach ($STATUS_LIST as $st) { ?>
          <option value="<?php echo htmlspecialchars($st); ?>" <?php echo e(($status_filter == $st) ? 'selected' : ''); ?>><?php echo htmlspecialchars($st); ?></option>
<?php } ?>
        </select>

        <button type="submit" class="btn btn-primary btn-sm" style="margin-left:10px;">Filter</button>
        <a class="btn btn-default btn-sm" href="?<?php echo htmlspecialchars($_SERVER['QUERY_STRING']); ?>&export=xls" target="_blank">Export to Excel</a>
        <a class="btn btn-success btn-sm" href="#" onclick="return popitup('device_invent_upd.php?ins=1');" style="margin-left:10px;"><i class="fa fa-plus"></i> Tambah Nomor Baru</a>
      </form>

      <!-- ============ 1. DASHBOARD & SUMMARY ============ -->
      <div class="section-title">Dashboard & Summary</div>
      <div class="row">
        <div class="col-md-3">
          <div class="summary-box">
            <div>Total Nomor</div>
            <div class="angka"><?php echo (int) $row_total_biaya['jml_nomor']; ?></div>
          </div>
        </div>
        <div class="col-md-3">
          <div class="summary-box">
            <div>Nomor Aktif</div>
            <div class="angka"><?php echo e(isset($ringkasan_status['Aktif']) ? (int) $ringkasan_status['Aktif']['jml'] : 0); ?></div>
          </div>
        </div>
        <div class="col-md-3">
          <div class="summary-box">
            <div>Cadangan / Non-Aktif</div>
            <div class="angka"><?php
              $jml_cadangan = isset($ringkasan_status['Cadangan']) ? (int) $ringkasan_status['Cadangan']['jml'] : 0;
              $jml_nonaktif = isset($ringkasan_status['Non-Aktif']) ? (int) $ringkasan_status['Non-Aktif']['jml'] : 0;
              echo e(num($jml_cadangan) + num($jml_nonaktif));
            ?></div>
          </div>
        </div>
        <div class="col-md-3">
          <div class="summary-box">
            <div>Total Biaya Bulanan</div>
            <div class="angka">Rp <?php echo number_format(num((float) $row_total_biaya['total_biaya']), 0, ',', '.'); ?></div>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-md-6">
<?php } // end if (!$export_mode) -- untuk quick-stat "summary-box" di atas: dashboard visual saja, sengaja TIDAK di-export (bukan data tabular) ?>

          <table class="table table-bordered inv-table" cellspacing="0" cellpadding="0">
            <thead><tr>
              <th style="<?php echo e($ST_TH); ?>">Status</th><th style="<?php echo e($ST_TH); ?>">Jumlah Nomor</th>
              <th style="<?php echo e($ST_TH); ?>">Persentase</th><th style="<?php echo e($ST_TH); ?>">Total Biaya (Rp)</th>
            </tr></thead>
            <tbody>
<?php foreach ($STATUS_LIST as $st) {
	$jml = isset($ringkasan_status[$st]) ? (int) $ringkasan_status[$st]['jml'] : 0;
	$biaya = isset($ringkasan_status[$st]) ? (float) $ringkasan_status[$st]['total_biaya'] : 0;
	$persen = (num($total_nomor_all) > 0) ? round(num((div($jml, $total_nomor_all))) * 100, 1) : 0;
	$badge_class = $STATUS_BADGE_CLASS[$st];
	$badge_style = $ST_BADGE[$st];
?>
              <tr>
                <td class="text-left" style="<?php echo e($ST_TD_LEFT); ?>"><span class="<?php echo e($badge_class); ?>" style="<?php echo e($badge_style); ?>"><?php echo htmlspecialchars($st); ?></span></td>
                <td style="<?php echo e($ST_TD); ?>"><?php echo e($jml); ?></td>
                <td style="<?php echo e($ST_TD); ?>"><?php echo e($persen); ?>%</td>
                <td style="<?php echo e($ST_TD); ?>"><?php echo number_format(num($biaya), 0, ',', '.'); ?></td>
              </tr>
<?php } ?>
              <tr class="subtotal-row">
                <td class="text-left" style="<?php echo e($ST_SUB_LEFT); ?>">Total</td>
                <td style="<?php echo e($ST_SUB); ?>"><?php echo e($total_nomor_all); ?></td>
                <td style="<?php echo e($ST_SUB); ?>">100%</td>
                <td style="<?php echo e($ST_SUB); ?>"><?php echo number_format(num((float) $row_total_biaya['total_biaya']), 0, ',', '.'); ?></td>
              </tr>
            </tbody>
          </table>

<?php if (!$export_mode) { ?>
        </div>
        <div class="col-md-6">
<?php } else { echo "<br>"; } ?>

          <table class="table table-bordered inv-table" cellspacing="0" cellpadding="0">
            <thead><tr>
              <th style="<?php echo e($ST_TH); ?>">Divisi</th><th style="<?php echo e($ST_TH); ?>">Jumlah Nomor</th><th style="<?php echo e($ST_TH); ?>">Total Biaya (Rp)</th>
            </tr></thead>
            <tbody>
<?php
$sum_divisi_jml = 0; $sum_divisi_biaya = 0;
($result_divisi instanceof PDOStatement && $result_divisi->execute());
while ($rd = db_fetch($result_divisi, PDO::FETCH_ASSOC)) {
	$sum_divisi_jml = num($sum_divisi_jml) + num(((int) $rd['jml']));
	$sum_divisi_biaya = num($sum_divisi_biaya) + num(((float) $rd['total_biaya']));
?>
              <tr>
                <td class="text-left" style="<?php echo e($ST_TD_LEFT); ?>"><?php echo htmlspecialchars($rd['divisi']); ?></td>
                <td style="<?php echo e($ST_TD); ?>"><?php echo (int) $rd['jml']; ?></td>
                <td style="<?php echo e($ST_TD); ?>"><?php echo number_format(num((float) $rd['total_biaya']), 0, ',', '.'); ?></td>
              </tr>
<?php } ?>
              <tr class="subtotal-row">
                <td class="text-left" style="<?php echo e($ST_SUB_LEFT); ?>">Total</td>
                <td style="<?php echo e($ST_SUB); ?>"><?php echo e($sum_divisi_jml); ?></td>
                <td style="<?php echo e($ST_SUB); ?>"><?php echo number_format(num($sum_divisi_biaya), 0, ',', '.'); ?></td>
              </tr>
            </tbody>
          </table>

<?php if (!$export_mode) { ?>
        </div>
      </div>

      <!-- ============ 2. DATA INVENTARIS NOMOR ============ -->
      <div class="section-title">Data Inventaris Nomor</div>
<?php } else { ?>
          <br>
          <h4>Data Inventaris Nomor</h4>
<?php } ?>
      <table class="table table-bordered inv-table" cellspacing="0" cellpadding="0">
        <thead>
          <tr>
            <th style="<?php echo e($ST_TH); ?>">ID Aset</th><th style="<?php echo e($ST_TH); ?>">Nomor HP / WA</th><th style="<?php echo e($ST_TH); ?>">Provider</th><th style="<?php echo e($ST_TH); ?>">Tipe Layanan</th>
            <th style="<?php echo e($ST_TH); ?>">Penanggung Jawab</th><th style="<?php echo e($ST_TH); ?>">Divisi</th><th style="<?php echo e($ST_TH); ?>">Jabatan / Peruntukan</th>
            <th style="<?php echo e($ST_TH); ?>">Status Nomor</th><th style="<?php echo e($ST_TH); ?>">Status WA Business</th><th style="<?php echo e($ST_TH); ?>">Paket / Plan</th>
            <th style="<?php echo e($ST_TH); ?>">Biaya Bulanan (Rp)</th><th style="<?php echo e($ST_TH); ?>">Tgl Jatuh Tempo</th><th style="<?php echo e($ST_TH); ?>">Tgl Registrasi</th>
            <th style="<?php echo e($ST_TH); ?>">Nomor ICCID / SIM</th><th style="<?php echo e($ST_TH); ?>">Keterangan</th>
<?php if (!$export_mode) { ?><th style="<?php echo e($ST_TH); ?>">Aksi</th><?php } ?>
          </tr>
        </thead>
        <tbody>
<?php
$sum_biaya_data = 0;
while ($r = db_fetch($result_data, PDO::FETCH_ASSOC)) {
	$sum_biaya_data = num($sum_biaya_data) + num(((float) $r['biaya_bulanan']));
	$badge_class = isset($STATUS_BADGE_CLASS[$r['status_nomor']]) ? $STATUS_BADGE_CLASS[$r['status_nomor']] : '';
	$badge_style = isset($ST_BADGE[$r['status_nomor']]) ? $ST_BADGE[$r['status_nomor']] : '';
	$edit_url = "device_invent_upd.php?upd=1&id_aset=" . urlencode($r['id_aset']);
?>
          <tr>
            <td style="<?php echo e($ST_TD); ?>"><?php echo htmlspecialchars($r['id_aset']); ?></td>
            <td style="<?php echo e($ST_TD); ?>"><?php echo htmlspecialchars($r['nomor_hp']); ?></td>
            <td style="<?php echo e($ST_TD); ?>"><?php echo htmlspecialchars($r['provider']); ?></td>
            <td style="<?php echo e($ST_TD); ?>"><?php echo htmlspecialchars($r['tipe_layanan']); ?></td>
            <td class="text-left" style="<?php echo e($ST_TD_LEFT); ?>"><?php echo htmlspecialchars($r['penanggung_jawab']); ?></td>
            <td class="text-left" style="<?php echo e($ST_TD_LEFT); ?>"><?php echo htmlspecialchars($r['divisi']); ?></td>
            <td class="text-left" style="<?php echo e($ST_TD_LEFT); ?>"><?php echo htmlspecialchars($r['jabatan_peruntukan']); ?></td>
            <td style="<?php echo e($ST_TD); ?>"><span class="<?php echo e($badge_class); ?>" style="<?php echo e($badge_style); ?>"><?php echo htmlspecialchars($r['status_nomor']); ?></span></td>
            <td style="<?php echo e($ST_TD); ?>"><?php echo htmlspecialchars($r['status_wa_business']); ?></td>
            <td class="text-left" style="<?php echo e($ST_TD_LEFT); ?>"><?php echo htmlspecialchars($r['paket_plan']); ?></td>
            <td style="<?php echo e($ST_TD); ?>"><?php echo number_format(num((float) $r['biaya_bulanan']), 0, ',', '.'); ?></td>
            <td style="<?php echo e($ST_TD); ?>"><?php echo e($r['tgl_jatuh_tempo'] ? date("d M Y", strtotime($r['tgl_jatuh_tempo'])) : '-'); ?></td>
            <td style="<?php echo e($ST_TD); ?>"><?php echo e($r['tgl_registrasi'] ? date("d M Y", strtotime($r['tgl_registrasi'])) : '-'); ?></td>
            <td style="<?php echo e($ST_TD); ?>"><?php echo htmlspecialchars($r['no_iccid']); ?></td>
            <td class="text-left" style="<?php echo e($ST_TD_LEFT); ?>"><?php echo htmlspecialchars($r['keterangan']); ?></td>
<?php if (!$export_mode) { ?>
            <td style="<?php echo e($ST_TD); ?>"><a class="btn btn-default btn-xs" href="#" onclick="return popitup('<?php echo e($edit_url); ?>');">Edit</a>
                <a class="btn btn-success btn-xs" href="#" onclick="return popitup('device_invent_pay.php?id_aset=<?php echo urlencode($r['id_aset']); ?>');">PAID</a></td>
<?php } ?>
          </tr>
<?php } ?>
          <tr class="subtotal-row">
            <td colspan="10" class="text-left" style="<?php echo e($ST_SUB_LEFT); ?>">TOTAL BIAYA / BULAN</td>
            <td style="<?php echo e($ST_SUB); ?>"><?php echo number_format(num($sum_biaya_data), 0, ',', '.'); ?></td>
            <td colspan="<?php echo e($export_mode ? 4 : 5); ?>" style="<?php echo e($ST_SUB); ?>"></td>
          </tr>
        </tbody>
      </table>

<?php if (!$export_mode) { ?>
      <!-- ============ 3. RIWAYAT PEMBAYARAN ============ -->
      <div class="section-title">Riwayat Pembayaran & Isi Ulang Nomor</div>
<?php } else { ?>
      <br>
      <h4>Riwayat Pembayaran & Isi Ulang Nomor</h4>
<?php } ?>
      <table class="table table-bordered inv-table" cellspacing="0" cellpadding="0">
        <thead>
          <tr>
            <th style="<?php echo e($ST_TH); ?>">ID Transaksi</th><th style="<?php echo e($ST_TH); ?>">Nomor HP / WA</th><th style="<?php echo e($ST_TH); ?>">Penanggung Jawab</th><th style="<?php echo e($ST_TH); ?>">Divisi</th>
            <th style="<?php echo e($ST_TH); ?>">Periode / Bulan</th><th style="<?php echo e($ST_TH); ?>">Tanggal Bayar</th><th style="<?php echo e($ST_TH); ?>">Tipe Layanan</th>
            <th style="<?php echo e($ST_TH); ?>">Jumlah Tagihan (Rp)</th><th style="<?php echo e($ST_TH); ?>">Metode Pembayaran</th><th style="<?php echo e($ST_TH); ?>">No. Bukti / Referensi</th><th style="<?php echo e($ST_TH); ?>">Status Bayar</th>
          </tr>
        </thead>
        <tbody>
<?php
while ($rp = db_fetch($result_riwayat, PDO::FETCH_ASSOC)) {
	$sum_tagihan = num($sum_tagihan) + num(((float) $rp['jumlah_tagihan']));
	$badge_bayar = ($rp['status_bayar'] == 'Lunas') ? 'badge-lunas' : 'badge-pending';
	$badge_bayar_style = isset($ST_BADGE_BAYAR[$rp['status_bayar']]) ? $ST_BADGE_BAYAR[$rp['status_bayar']] : '';
?>
          <tr>
            <td style="<?php echo e($ST_TD); ?>"><?php echo htmlspecialchars($rp['id_transaksi']); ?></td>
            <td style="<?php echo e($ST_TD); ?>"><?php echo htmlspecialchars($rp['nomor_hp']); ?></td>
            <td class="text-left" style="<?php echo e($ST_TD_LEFT); ?>"><?php echo htmlspecialchars($rp['penanggung_jawab']); ?></td>
            <td class="text-left" style="<?php echo e($ST_TD_LEFT); ?>"><?php echo htmlspecialchars($rp['divisi']); ?></td>
            <td style="<?php echo e($ST_TD); ?>"><?php echo htmlspecialchars($rp['periode_text']); ?></td>
            <td style="<?php echo e($ST_TD); ?>"><?php echo e($rp['tanggal_bayar'] ? date("d M Y", strtotime($rp['tanggal_bayar'])) : '-'); ?></td>
            <td style="<?php echo e($ST_TD); ?>"><?php echo htmlspecialchars($rp['tipe_layanan']); ?></td>
            <td style="<?php echo e($ST_TD); ?>"><?php echo number_format(num((float) $rp['jumlah_tagihan']), 0, ',', '.'); ?></td>
            <td style="<?php echo e($ST_TD); ?>"><?php echo htmlspecialchars($rp['metode_pembayaran']); ?></td>
            <td style="<?php echo e($ST_TD); ?>"><?php echo htmlspecialchars($rp['no_bukti_referensi']); ?></td>
            <td style="<?php echo e($ST_TD); ?>"><span class="<?php echo e($badge_bayar); ?>" style="<?php echo e($badge_bayar_style); ?>"><?php echo htmlspecialchars($rp['status_bayar']); ?></span></td>
          </tr>
<?php } ?>
          <tr class="subtotal-row">
            <td colspan="7" class="text-left" style="<?php echo e($ST_SUB_LEFT); ?>">TOTAL PEMBAYARAN</td>
            <td style="<?php echo e($ST_SUB); ?>"><?php echo number_format(num($sum_tagihan), 0, ',', '.'); ?></td>
            <td colspan="3" style="<?php echo e($ST_SUB); ?>"></td>
          </tr>
        </tbody>
      </table>

<?php if (!$export_mode) { ?>
    </section>
  </div>
</div>

<script>
  function popitup(url) {
    var newwindow = window.open(url, 'name', 'height=650,width=700,screenX=350,screenY=100');
    if (window.focus) { newwindow.focus(); }
    return false;
  }
</script>
</body>
</html>
<?php } ?>
