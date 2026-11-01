<?php
require_once __DIR__ . "/_lib/bootstrap.php"; csrf_guard_get(); auth_require_login();
include __DIR__ . "/conndb.php";
include __DIR__ . "/profiledata.php";

/* ============================================================
   CREATE PEMBAYARAN (popup) -- device_invent_pay.php
   Dibuka dari tombol "PAID" per baris di device_invent.php, lewat
   popitup('device_invent_pay.php?id_aset=...'). Style & pola form
   mengacu ke device_invent_upd.php (dv-header/dv-section/dv-footer,
   submit via GET, dicek & diproses SEBELUM ada output HTML apa pun,
   setelah save reload window pembuka lalu tutup popup sendiri).

   ALUR:
   - Data device (Nomor HP, Penanggung Jawab, Divisi, Tipe Layanan,
     Biaya Bulanan) ditarik OTOMATIS dari ves_data.mst_device_inventory
     berdasarkan id_aset -- user tidak perlu isi ulang, tinggal cek.
   - Jumlah Tagihan & Metode Pembayaran BOLEH diubah user (kadang beda
     dari biaya_bulanan default, misal ada denda/prorata).
   - Saat Save:
       * tanggal_bayar  = tanggal yang dipilih user di form (default
         hari ini, tapi bisa diubah kalau bayar mundur/nyicil telat).
       * tgl_input      = timestamp SERVER saat data disimpan, TIDAK
         bisa diedit user -- ini "kapan data ini dicatat ke sistem",
         beda dari tanggal_bayar. WAJIB kolom ini sudah ada, lihat
         alter_table_riwayat_pembayaran.sql.
       * periode_text / periode_bulan diturunkan OTOMATIS dari
         tanggal_bayar yang dipilih (bulan Indonesia, cth "Agustus
         2026"), bukan diketik manual, supaya konsisten.
       * id_transaksi di-generate OTOMATIS server-side (format
         TRX-<tahun>-<urutan 4 digit>, mengikuti pola data contoh:
         TRX-2026-0801, TRX-2026-0802, dst), dicek dulu belum kepakai
         sebelum INSERT -- TIDAK ditimpa diam-diam kalau bentrok.
   - Data Nomor HP/Penanggung Jawab/Divisi/Tipe Layanan yang dipakai
     untuk INSERT diambil ULANG dari DB pakai id_aset saat Save (bukan
     dari field readonly yang tampil di form), supaya konsisten dengan
     master data terbaru walau form sempat dibuka lama.
   ============================================================ */

$today = date("Y-m-d");

$NAMA_BULAN_ID = array(
	1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
	5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
	9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember',
);

// Helper: format tanggal (Y-m-d) jadi "Agustus 2026" + tanggal 1 bulan itu (Y-m-01)
function periode_dari_tanggal($tgl, $NAMA_BULAN_ID) {
	$ts = strtotime($tgl);
	$bln = (int) date('n', $ts);
	$thn = date('Y', $ts);
	return array(
		'text'   => $NAMA_BULAN_ID[$bln] . ' ' . $thn,
		'bulan'  => date('Y-m-01', $ts),
	);
}

// Helper: generate id_transaksi berikutnya untuk tahun berjalan, format TRX-<tahun>-<0001..>
function generate_id_transaksi($tahun) {
	$tahun_sql = $tahun;
	$q = q_set($__p_q, "SELECT id_transaksi FROM ves_data.device_payment_log\r
\t\tWHERE id_transaksi LIKE ? ORDER BY id_transaksi DESC LIMIT 1", ["TRX-" . (string) ($tahun_sql) . "-%"]);
	$res = db_query_or_die('error_generating_id_transaksi', $q, $__p_q ?? []);
	$next_seq = 1;
	if ($res && num(db_num_rows($res)) > 0) {
		$row = db_fetch($res, PDO::FETCH_NUM);
		$parts = explode('-', $row[0]);
		$last_seq = isset($parts[2]) ? (int) $parts[2] : 0;
		$next_seq = num($last_seq) + 1;
	}
	return 'TRX-' . $tahun . '-' . str_pad($next_seq, 4, '0', STR_PAD_LEFT);
}

// ---------------------------------------------------------------------
// Ambil id_aset & data device (untuk ditampilkan di form)
// ---------------------------------------------------------------------
$id_aset = isset($_GET['id_aset']) ? in_val('id_aset', 'any') : '';

if ($id_aset == '') {
	echo "<script>alert('ID Aset tidak ditemukan. Buka form ini dari tombol PAID di Device Inventory.'); window.close();</script>";
	exit;
}

$id_aset_sql = $id_aset;
$q_device = q_set($__p_q_device, "SELECT id_aset, nomor_hp, provider, tipe_layanan, penanggung_jawab, divisi, biaya_bulanan, status_nomor\r
\tFROM ves_data.mst_device_inventory WHERE id_aset = ? ", [(string) ($id_aset_sql)]);
$res_device = db_query_or_die('error_loading_device', $q_device, $__p_q_device ?? []);
$device = db_fetch($res_device, PDO::FETCH_ASSOC);

if (!$device) {
	echo "<script>alert('Data device dengan ID Aset " . e($id_aset) . " tidak ditemukan.'); window.close();</script>";
	exit;
}

// Default nilai form (bisa di-override user, TIDAK di-override untuk hidden id_aset)
$tanggal_bayar     = isset($_GET['tanggal_bayar']) ? in_val('tanggal_bayar', 'any') : $today;
$jumlah_tagihan    = isset($_GET['jumlah_tagihan']) ? in_val('jumlah_tagihan', 'any') : $device['biaya_bulanan'];
$metode_pembayaran = isset($_GET['metode_pembayaran']) ? in_val('metode_pembayaran', 'any') : '';
$no_bukti          = isset($_GET['no_bukti_referensi']) ? in_val('no_bukti_referensi', 'any') : '';
$status_bayar      = isset($_GET['status_bayar']) ? in_val('status_bayar', 'any') : 'Lunas'; // default Lunas krn dipicu tombol "PAID"

// Daftar metode pembayaran yang sudah pernah dipakai (buat datalist, bukan dihardcode
// supaya otomatis ikut kalau ada metode baru yang pernah diinput sebelumnya)
$METODE_LIST = array();
$q_metode = q_set($__p_q_metode, "SELECT DISTINCT metode_pembayaran FROM ves_data.device_payment_log\r
\tWHERE metode_pembayaran IS NOT NULL AND metode_pembayaran <> '' ORDER BY metode_pembayaran");
$res_metode = db_query_soft($q_metode, $__p_q_metode ?? []);
if ($res_metode) {
	while ($m = db_fetch($res_metode, PDO::FETCH_NUM)) {
		$METODE_LIST[] = $m[0];
	}
}

$STATUS_BAYAR_LIST = array('Lunas', 'Pending');

// ---------------------------------------------------------------------
// Save (triggered by the "Save Pembayaran" button) -- dicek & diproses
// SEBELUM ada output HTML apa pun.
// ---------------------------------------------------------------------
if (($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['save_payment']))) {
	$tanggal_bayar     = in_val('tanggal_bayar', 'any') != '' ? in_val('tanggal_bayar', 'any') : $today;
	$jumlah_tagihan    = (in_val('jumlah_tagihan', 'any') !== '') ? (float) in_val('jumlah_tagihan', 'any') : 0;
	$metode_pembayaran = trim(in_val('metode_pembayaran', 'any'));
	$no_bukti          = trim(in_val('no_bukti_referensi', 'any'));
	$status_bayar      = in_val('status_bayar', 'any');

	if (num($jumlah_tagihan) <= 0 || $metode_pembayaran == '') {
		echo "<script>alert('Jumlah Tagihan dan Metode Pembayaran wajib diisi.');</script>";
		// lanjut render form lagi di bawah, tidak exit, supaya input lain tidak hilang
	} else {
		// ---- Ambil ULANG data device dari DB pakai id_aset (bukan dari field
		//      readonly di form), supaya konsisten dengan master data terbaru ----
		$q_device2 = q_set($__p_q_device2, "SELECT nomor_hp, penanggung_jawab, divisi, tipe_layanan\r
\t\t\tFROM ves_data.mst_device_inventory WHERE id_aset = ? ", [(string) ($id_aset_sql)]);
		$res_device2 = db_query_or_die('error_reloading_device', $q_device2, $__p_q_device2 ?? []);
		$dev2 = db_fetch($res_device2, PDO::FETCH_ASSOC);

		if (!$dev2) {
			echo "<script>alert('Data device tidak ditemukan lagi (mungkin sudah dihapus). Tutup form ini dan cek ulang.');</script>";
		} else {
			$periode = periode_dari_tanggal($tanggal_bayar, $NAMA_BULAN_ID);
			$tahun_transaksi = date('Y', strtotime($tanggal_bayar));

			// generate id_transaksi, cek bentrok, retry beberapa kali kalau ada race condition
			$id_transaksi = generate_id_transaksi($tahun_transaksi);
			$percobaan = 0;
			do {
				$id_transaksi_sql = $id_transaksi;
				$q_cek = q_set($__p_q_cek, "SELECT id_transaksi FROM ves_data.device_payment_log WHERE id_transaksi = ? ", [(string) ($id_transaksi_sql)]);
				$res_cek = db_query_or_die('error_cek_id_transaksi', $q_cek, $__p_q_cek ?? []);
				$bentrok = (num(db_num_rows($res_cek)) > 0);
				if ($bentrok) {
					$id_transaksi = generate_id_transaksi($tahun_transaksi);
				}
				$percobaan++;
			} while ($bentrok && num($percobaan) < 5);

			if ($bentrok) {
				echo "<script>alert('Gagal generate ID Transaksi (bentrok terus). Coba klik Save sekali lagi.');</script>";
			} else {
				$nomor_hp_sql         = $dev2['nomor_hp'];
				$penanggung_jawab_sql = $dev2['penanggung_jawab'];
				$divisi_sql           = $dev2['divisi'];
				$tipe_layanan_sql     = $dev2['tipe_layanan'];
				$periode_text_sql     = $periode['text'];
				$periode_bulan_sql    = $periode['bulan'];
				$tanggal_bayar_sql    = $tanggal_bayar;
				$metode_sql           = $metode_pembayaran;
				$no_bukti_sql         = $no_bukti;
				$status_bayar_sql     = $status_bayar;
				$tgl_input_sql        = date('Y-m-d H:i:s'); // timestamp server, bukan input user

				$query_simpan = q_set($__p_query_simpan, "INSERT INTO ves_data.device_payment_log\r
\t\t\t\t\t(id_transaksi, nomor_hp, penanggung_jawab, divisi, periode_text, periode_bulan,\r
\t\t\t\t\t tanggal_bayar, tgl_input, tipe_layanan, jumlah_tagihan, metode_pembayaran,\r
\t\t\t\t\t no_bukti_referensi, status_bayar)\r
\t\t\t\t\tVALUES (? , ? , ? , ? ,\r
\t\t\t\t\t ? , ? , ? , ? ,\r
\t\t\t\t\t ? , ? , ? , ? , ? )", [(string) ($id_transaksi_sql), (string) ($nomor_hp_sql), (string) ($penanggung_jawab_sql), (string) ($divisi_sql), (string) ($periode_text_sql), (string) ($periode_bulan_sql), (string) ($tanggal_bayar_sql), (string) ($tgl_input_sql), (string) ($tipe_layanan_sql), (string) ($jumlah_tagihan), (string) ($metode_sql), (string) ($no_bukti_sql), (string) ($status_bayar_sql)]);
				db_query_or_die('error_saving_payment', $query_simpan, $__p_query_simpan ?? []);

				echo "<script type=\"text/javascript\">\n";
				echo "window.opener.location.reload(true);\n";
				echo "window.close();\n";
				echo "</script>";
				exit;
			}
		}
	}
}
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Catat Pembayaran</title>
  <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="css/font-awesome/css/font-awesome.css">
  <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
  <style>
	body { background: #f4f6f9; }
	.dv-form-wrap { max-width: 560px; margin: 0 auto; padding: 18px 20px 6px; }
	.dv-header {
	  display: flex; align-items: center; justify-content: space-between;
	  padding: 14px 18px; margin-bottom: 18px;
	  background: linear-gradient(135deg,#00a65a,#008d4c);
	  border-radius: 6px; color: #fff;
	}
	.dv-header h3 { margin: 0; font-weight: 600; }
	.dv-section {
	  background: #fff; border-radius: 6px; margin-bottom: 18px;
	  box-shadow: 0 1px 3px rgba(0,0,0,.08); overflow: hidden;
	}
	.dv-section-title {
	  padding: 10px 16px; font-weight: 600; font-size: 14px; color: #444;
	  background: #f8f9fb; border-bottom: 1px solid #eceff3;
	}
	.dv-section-body { padding: 16px 18px 4px; }
	.form-group label { font-weight: 600; color: #555; font-size: 12.5px; margin-bottom: 4px; }
	.form-control { border-radius: 4px; box-shadow: none; }
	.form-control[readonly] { background: #f4f6f9; color: #666; }
	.dv-footer {
	  display: flex; justify-content: flex-end; gap: 8px;
	  padding: 14px 18px; background: #fff; border-radius: 6px;
	  box-shadow: 0 1px 3px rgba(0,0,0,.08); margin-bottom: 24px;
	}
	.dv-hint { font-size: 11px; color: #888; margin-top: 3px; }
  </style>
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">
  <form name="form_payment" action="#" class="dv-form-wrap" method="post"><?php echo csrf_field(); ?>


    <input type="hidden" name="id_aset" value="<?php echo htmlspecialchars($id_aset); ?>">

    <div class="dv-header">
      <div>
        <h3>Catat Pembayaran</h3>
        <small><?php echo htmlspecialchars($device['id_aset']); ?> &mdash; <?php echo htmlspecialchars($device['nomor_hp']); ?></small>
      </div>
      <i class="fa fa-money fa-2x" style="opacity:.5"></i>
    </div>

    <!-- ============ Data Device (readonly, dari master) ============ -->
    <div class="dv-section">
      <div class="dv-section-title"><i class="fa fa-mobile"></i> Data Nomor (dari Device Inventory)</div>
      <div class="dv-section-body">
        <div class="row">
          <div class="col-xs-6">
            <div class="form-group">
              <label>Nomor HP / WA</label>
              <input type="text" class="form-control" value="<?php echo htmlspecialchars($device['nomor_hp']); ?>" readonly>
            </div>
          </div>
          <div class="col-xs-6">
            <div class="form-group">
              <label>Penanggung Jawab</label>
              <input type="text" class="form-control" value="<?php echo htmlspecialchars($device['penanggung_jawab']); ?>" readonly>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-xs-6">
            <div class="form-group">
              <label>Divisi</label>
              <input type="text" class="form-control" value="<?php echo htmlspecialchars($device['divisi']); ?>" readonly>
            </div>
          </div>
          <div class="col-xs-6">
            <div class="form-group">
              <label>Tipe Layanan</label>
              <input type="text" class="form-control" value="<?php echo htmlspecialchars($device['tipe_layanan']); ?>" readonly>
            </div>
          </div>
        </div>
        <div class="dv-hint">Data di atas otomatis dari Device Inventory, tidak bisa diedit di sini. Kalau ada yang salah, ubah lewat Edit di halaman utama.</div>
      </div>
    </div>

    <!-- ============ Detail Pembayaran (bisa diubah) ============ -->
    <div class="dv-section">
      <div class="dv-section-title"><i class="fa fa-credit-card"></i> Detail Pembayaran</div>
      <div class="dv-section-body">
        <div class="row">
          <div class="col-xs-6">
            <div class="form-group">
              <label>Tanggal Bayar</label>
              <input type="date" class="form-control" name="tanggal_bayar" value="<?php echo htmlspecialchars($tanggal_bayar); ?>">
            </div>
          </div>
          <div class="col-xs-6">
            <div class="form-group">
              <label>Status Bayar</label>
              <select class="form-control" name="status_bayar">
<?php foreach ($STATUS_BAYAR_LIST as $sb) { ?>
                <option value="<?php echo e($sb); ?>" <?php echo e(($sb == $status_bayar) ? 'selected' : ''); ?>><?php echo e($sb); ?></option>
<?php } ?>
              </select>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-xs-6">
            <div class="form-group">
              <label>Jumlah Tagihan (Rp)</label>
              <input type="number" step="1" min="0" class="form-control" name="jumlah_tagihan" value="<?php echo htmlspecialchars($jumlah_tagihan); ?>">
              <div class="dv-hint">Default dari Biaya Bulanan (Rp <?php echo number_format(num((float) $device['biaya_bulanan']), 0, ',', '.'); ?>), boleh diubah kalau beda (denda/prorata dsb).</div>
            </div>
          </div>
          <div class="col-xs-6">
            <div class="form-group">
              <label>Metode Pembayaran</label>
              <input type="text" class="form-control" list="metode_list" name="metode_pembayaran" value="<?php echo htmlspecialchars($metode_pembayaran); ?>" placeholder="cth: Transfer Bank">
              <datalist id="metode_list">
<?php foreach ($METODE_LIST as $m) { ?>
                <option value="<?php echo htmlspecialchars($m); ?>">
<?php } ?>
              </datalist>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-xs-12">
            <div class="form-group">
              <label>No. Bukti / Referensi</label>
              <input type="text" class="form-control" name="no_bukti_referensi" value="<?php echo htmlspecialchars($no_bukti); ?>" placeholder="cth: INV-TEL-98211 (opsional)">
            </div>
          </div>
        </div>
        <div class="dv-hint">ID Transaksi & tanggal input ke sistem akan dibuat otomatis saat Save (tidak perlu diisi manual).</div>
      </div>
    </div>

    <div class="dv-footer">
      <input type="button" class="btn btn-default" value="Cancel" onclick="window.close();">
      <input type="submit" class="btn btn-success" name="save_payment" value="Save Pembayaran">
    </div>
  </form>
</div>
</body>
</html>
