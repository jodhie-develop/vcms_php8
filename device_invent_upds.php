<?php
require_once __DIR__ . "/_lib/bootstrap.php"; csrf_guard_get(); auth_require_login();
include __DIR__ . "/conndb.php";
include __DIR__ . "/profiledata.php";

/* ============================================================
   DEVICE INVENTORY -- NEW / UPDATE (popup)
   Mengikuti pola vip_pt_record_upd.php: dibuka via popitup() dari
   device_invent.php, mode ditentukan dari parameter GET (ins=1
   untuk baru, upd=1 untuk edit), submit lewat GET, setelah simpan
   me-reload window pembuka lalu menutup popup sendiri.

   BEDA DENGAN vip_pt_record_upd.php:
   - Di vip_pt_record_upd.php, primary key ("no") itu auto increment,
     jadi "insert vs update" cukup dicek dari $nub kosong/tidak.
   - Di sini, primary key (id_aset, cth "TEL-011") DIKETIK MANUAL
     oleh user, jadi tidak bisa dipakai untuk membedakan New vs
     Update. Makanya dipakai 2 field terpisah:
       - id_aset       : nilai id_aset yang mau disimpan (bisa diubah
                         kalau mode edit dan user ganti ID-nya)
       - orig_id_aset  : id_aset ASLI saat popup pertama dibuka
                         (kosong = mode New, tidak kosong = mode Edit,
                         dipakai sebagai WHERE saat UPDATE)
   - id_aset harus UNIK -- dicek dulu sebelum INSERT atau sebelum
     UPDATE yang mengubah id_aset, supaya tidak menimpa data lain
     secara diam-diam.
   ============================================================ */

$today = date("Y-m-d");

// ---------------------------------------------------------------------
// Request params (mode baca/tampil form)
// ---------------------------------------------------------------------
$upd            = isset($_GET['upd']) ? in_val('upd', 'any') : '';
$orig_id_aset   = isset($_GET['orig_id_aset']) ? in_val('orig_id_aset', 'any') : (isset($_GET['id_aset']) && num($upd) == 1 ? in_val('id_aset', 'any') : '');

if (num($upd) == 1 && $orig_id_aset != '') {
	// ---- Mode EDIT: load data existing dari DB ----
	$orig_id_aset_sql = $orig_id_aset;
	$q = q_set($__p_q, "SELECT id_aset, nomor_hp, provider, tipe_layanan, penanggung_jawab, divisi,\r
\t\t\tjabatan_peruntukan, status_nomor, status_wa_business, paket_plan,\r
\t\t\tbiaya_bulanan, tgl_jatuh_tempo, tgl_registrasi, no_iccid, keterangan\r
\t\tFROM ves_data.mst_device_inventory WHERE id_aset = ? ", [(string) ($orig_id_aset_sql)]);
	$res = db_query_or_die('error_loading_device', $q, $__p_q ?? []);
	$row = db_fetch($res, PDO::FETCH_ASSOC);

	if (!$row) {
		// id_aset yang dikirim tidak ditemukan -- jangan diam-diam dianggap "New",
		// tampilkan pesan supaya user sadar ada yang salah (link kadaluarsa dsb).
		echo "<script>alert('Data dengan ID Aset " . e($orig_id_aset) . " tidak ditemukan.'); window.close();</script>";
		exit;
	}

	$id_aset            = $row['id_aset'];
	$nomor_hp           = $row['nomor_hp'];
	$provider           = $row['provider'];
	$tipe_layanan       = $row['tipe_layanan'];
	$penanggung_jawab   = $row['penanggung_jawab'];
	$divisi             = $row['divisi'];
	$jabatan_peruntukan = $row['jabatan_peruntukan'];
	$status_nomor       = $row['status_nomor'];
	$status_wa_business = $row['status_wa_business'];
	$paket_plan         = $row['paket_plan'];
	$biaya_bulanan      = $row['biaya_bulanan'];
	$tgl_jatuh_tempo    = $row['tgl_jatuh_tempo'];
	$tgl_registrasi     = $row['tgl_registrasi'];
	$no_iccid           = $row['no_iccid'];
	$keterangan         = $row['keterangan'];
} else {
	// ---- Mode NEW, atau reload form karena validasi gagal saat Save ----
	$orig_id_aset       = ''; // mode New = selalu kosong
	$id_aset            = isset($_GET['id_aset']) ? in_val('id_aset', 'any') : '';
	$nomor_hp           = isset($_GET['nomor_hp']) ? in_val('nomor_hp', 'any') : '';
	$provider           = isset($_GET['provider']) ? in_val('provider', 'any') : '';
	$tipe_layanan       = isset($_GET['tipe_layanan']) ? in_val('tipe_layanan', 'any') : '';
	$penanggung_jawab   = isset($_GET['penanggung_jawab']) ? in_val('penanggung_jawab', 'any') : '';
	$divisi             = isset($_GET['divisi']) ? in_val('divisi', 'any') : '';
	$jabatan_peruntukan = isset($_GET['jabatan_peruntukan']) ? in_val('jabatan_peruntukan', 'any') : '';
	$status_nomor       = isset($_GET['status_nomor']) ? in_val('status_nomor', 'any') : 'Aktif';
	$status_wa_business = isset($_GET['status_wa_business']) ? in_val('status_wa_business', 'any') : '';
	$paket_plan         = isset($_GET['paket_plan']) ? in_val('paket_plan', 'any') : '';
	$biaya_bulanan      = isset($_GET['biaya_bulanan']) ? in_val('biaya_bulanan', 'any') : '';
	$tgl_jatuh_tempo    = isset($_GET['tgl_jatuh_tempo']) ? in_val('tgl_jatuh_tempo', 'any') : '';
	$tgl_registrasi     = isset($_GET['tgl_registrasi']) ? in_val('tgl_registrasi', 'any') : $today;
	$no_iccid           = isset($_GET['no_iccid']) ? in_val('no_iccid', 'any') : '';
	$keterangan         = isset($_GET['keterangan']) ? in_val('keterangan', 'any') : '';
}

$STATUS_LIST = array('Aktif', 'Cadangan', 'Non-Aktif');

// ---------------------------------------------------------------------
// Save (triggered by the "Save" button) -- dicek & diproses SEBELUM
// ada output HTML apa pun, sama seperti pola save_score di
// vip_pt_record_upd.php
// ---------------------------------------------------------------------
if (($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['save_device']))) {
	$orig_id_aset       = trim(in_val('orig_id_aset', 'any'));
	$id_aset            = trim(in_val('id_aset', 'any'));
	$nomor_hp           = trim(in_val('nomor_hp', 'any'));
	$provider           = in_val('provider', 'any');
	$tipe_layanan       = in_val('tipe_layanan', 'any');
	$penanggung_jawab   = in_val('penanggung_jawab', 'any');
	$divisi             = in_val('divisi', 'any');
	$jabatan_peruntukan = in_val('jabatan_peruntukan', 'any');
	$status_nomor       = in_val('status_nomor', 'any');
	$status_wa_business = in_val('status_wa_business', 'any');
	$paket_plan         = in_val('paket_plan', 'any');
	$biaya_bulanan      = (in_val('biaya_bulanan', 'any') !== '') ? (float) in_val('biaya_bulanan', 'any') : 0;
	$tgl_jatuh_tempo    = (in_val('tgl_jatuh_tempo', 'any') !== '') ? in_val('tgl_jatuh_tempo', 'any') : null;
	$tgl_registrasi     = (in_val('tgl_registrasi', 'any') !== '') ? in_val('tgl_registrasi', 'any') : null;
	$no_iccid           = in_val('no_iccid', 'any');
	$keterangan         = in_val('keterangan', 'any');

	// ---- Validasi minimum: ID Aset & Nomor HP wajib diisi ----
	if ($id_aset == '' || $nomor_hp == '') {
		echo "<script>alert('ID Aset dan Nomor HP / WA wajib diisi.');</script>";
		// lanjut ke render form di bawah (tidak exit), supaya user bisa perbaiki tanpa kehilangan input lain
	} else {
		$id_aset_sql            = $id_aset;
		$nomor_hp_sql           = $nomor_hp;
		$provider_sql           = $provider;
		$tipe_layanan_sql       = $tipe_layanan;
		$penanggung_jawab_sql   = $penanggung_jawab;
		$divisi_sql             = $divisi;
		$jabatan_peruntukan_sql = $jabatan_peruntukan;
		$status_nomor_sql       = $status_nomor;
		$status_wa_business_sql = $status_wa_business;
		$paket_plan_sql         = $paket_plan;
		$no_iccid_sql           = $no_iccid;
		$keterangan_sql         = $keterangan;
		$tgl_jatuh_tempo_sql    = $tgl_jatuh_tempo ? "'" . $tgl_jatuh_tempo . "'" : 'NULL';
		$tgl_registrasi_sql     = $tgl_registrasi ? "'" . $tgl_registrasi . "'" : 'NULL';
		$today_sql              = $today;

		// ---- Cek id_aset bentrok dengan data lain (baik mode New maupun
		//      Edit yang mengubah id_aset) sebelum simpan, TIDAK ditimpa diam-diam ----
		$query_cek = q_set($__p_query_cek, "SELECT id_aset FROM ves_data.mst_device_inventory WHERE id_aset = ? ", [(string) ($id_aset_sql)]);
		$result_cek = db_query_or_die('error_cek_id_aset', $query_cek, $__p_query_cek ?? []);
		$bentrok = false;
		if (num(db_num_rows($result_cek)) > 0) {
			// bentrok, KECUALI kalau ini mode edit dan id_aset yang bentrok = id_aset asli baris yang sama
			$bentrok = !($orig_id_aset != '' && $id_aset == $orig_id_aset);
		}

		if ($bentrok) {
			echo "<script>alert('ID Aset \'" . e(addslashes($id_aset)) . "\' sudah dipakai nomor lain. Gunakan ID Aset yang berbeda.');</script>";
		} else {
			if ($orig_id_aset == '') {
				// ---- Mode NEW: INSERT ----
				$query_simpan = q_set($__p_query_simpan, "INSERT INTO ves_data.mst_device_inventory\r
\t\t\t\t\t(id_aset, nomor_hp, provider, tipe_layanan, penanggung_jawab, divisi,\r
\t\t\t\t\t jabatan_peruntukan, status_nomor, status_wa_business, paket_plan,\r
\t\t\t\t\t biaya_bulanan, tgl_jatuh_tempo, tgl_registrasi, no_iccid, keterangan,\r
\t\t\t\t\t created_date, update_date)\r
\t\t\t\t\tVALUES (? , ? , ? , ? ,\r
\t\t\t\t\t ? , ? , ? , ? ,\r
\t\t\t\t\t ? , ? , ? , ? ,\r
\t\t\t\t\t ? , ? , ? , ? , ? )", [(string) ($id_aset_sql), (string) ($nomor_hp_sql), (string) ($provider_sql), (string) ($tipe_layanan_sql), (string) ($penanggung_jawab_sql), (string) ($divisi_sql), (string) ($jabatan_peruntukan_sql), (string) ($status_nomor_sql), (string) ($status_wa_business_sql), (string) ($paket_plan_sql), (string) ($biaya_bulanan), (string) ($tgl_jatuh_tempo_sql), (string) ($tgl_registrasi_sql), (string) ($no_iccid_sql), (string) ($keterangan_sql), (string) ($today_sql), (string) ($today_sql)]);
				db_query_or_die('error_saving_new_device', $query_simpan, $__p_query_simpan ?? []);
			} else {
				// ---- Mode EDIT: UPDATE (id_aset boleh berubah kalau user mengganti) ----
				$orig_id_aset_sql = $orig_id_aset;
				$query_simpan = q_set($__p_query_simpan, "UPDATE ves_data.mst_device_inventory SET\r
\t\t\t\t\tid_aset = ? , nomor_hp = ? , provider = ? ,\r
\t\t\t\t\ttipe_layanan = ? , penanggung_jawab = ? ,\r
\t\t\t\t\tdivisi = ? , jabatan_peruntukan = ? ,\r
\t\t\t\t\tstatus_nomor = ? , status_wa_business = ? ,\r
\t\t\t\t\tpaket_plan = ? , biaya_bulanan = ? ,\r
\t\t\t\t\ttgl_jatuh_tempo = ? , tgl_registrasi = ? ,\r
\t\t\t\t\tno_iccid = ? , keterangan = ? , update_date = ?\r
\t\t\t\t\tWHERE id_aset = ? ", [(string) ($id_aset_sql), (string) ($nomor_hp_sql), (string) ($provider_sql), (string) ($tipe_layanan_sql), (string) ($penanggung_jawab_sql), (string) ($divisi_sql), (string) ($jabatan_peruntukan_sql), (string) ($status_nomor_sql), (string) ($status_wa_business_sql), (string) ($paket_plan_sql), (string) ($biaya_bulanan), (string) ($tgl_jatuh_tempo_sql), (string) ($tgl_registrasi_sql), (string) ($no_iccid_sql), (string) ($keterangan_sql), (string) ($today_sql), (string) ($orig_id_aset_sql)]);
				db_query_or_die('error_saving_update_device', $query_simpan, $__p_query_simpan ?? []);
			}

			echo "<script type=\"text/javascript\">\n";
			echo "window.opener.location.reload(true);\n";
			echo "window.close();\n";
			echo "</script>";
			exit;
		}
	}
}
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title><?php echo e(($orig_id_aset == '') ? 'Tambah Nomor Baru' : 'Update Nomor'); ?></title>
  <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="css/font-awesome/css/font-awesome.css">
  <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
  <style>
	body { background: #f4f6f9; }
	.dv-form-wrap { max-width: 640px; margin: 0 auto; padding: 18px 20px 6px; }
	.dv-header {
	  display: flex; align-items: center; justify-content: space-between;
	  padding: 14px 18px; margin-bottom: 18px;
	  background: linear-gradient(135deg,#3c8dbc,#367fa9);
	  border-radius: 6px; color: #fff;
	}
	.dv-header h3 { margin: 0; font-weight: 600; }
	.dv-section {
	  background: #fff; border-radius: 6px; margin-bottom: 18px;
	  box-shadow: 0 1px 3px rgba(0,0,0,.08); overflow: hidden;
	}
	.dv-section-body { padding: 16px 18px 4px; }
	.form-group label { font-weight: 600; color: #555; font-size: 12.5px; margin-bottom: 4px; }
	.form-control { border-radius: 4px; box-shadow: none; }
	.dv-footer {
	  display: flex; justify-content: flex-end; gap: 8px;
	  padding: 14px 18px; background: #fff; border-radius: 6px;
	  box-shadow: 0 1px 3px rgba(0,0,0,.08); margin-bottom: 24px;
	}
  </style>
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">
  <form name="form_device" action="#" class="dv-form-wrap" method="post"><?php echo csrf_field(); ?>


    <input type="hidden" name="orig_id_aset" value="<?php echo htmlspecialchars($orig_id_aset); ?>">

    <div class="dv-header">
      <div>
        <h3><?php echo e(($orig_id_aset == '') ? 'Tambah Nomor Baru' : 'Update Nomor: ' . htmlspecialchars($orig_id_aset)); ?></h3>
        <small>Device Inventory &mdash; Nomor HP & WA Kantor</small>
      </div>
      <i class="fa fa-mobile fa-2x" style="opacity:.5"></i>
    </div>

    <div class="dv-section">
      <div class="dv-section-body">
        <div class="row">
          <div class="col-xs-6">
            <div class="form-group">
              <label>ID Aset</label>
              <input type="text" class="form-control" name="id_aset" value="<?php echo htmlspecialchars($id_aset); ?>" placeholder="cth: TEL-011">
            </div>
          </div>
          <div class="col-xs-6">
            <div class="form-group">
              <label>Nomor HP / WA</label>
              <input type="text" class="form-control" name="nomor_hp" value="<?php echo htmlspecialchars($nomor_hp); ?>" placeholder="cth: 0811-0000-0000">
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-xs-6">
            <div class="form-group">
              <label>Provider</label>
              <input type="text" class="form-control" name="provider" value="<?php echo htmlspecialchars($provider); ?>">
            </div>
          </div>
          <div class="col-xs-6">
            <div class="form-group">
              <label>Tipe Layanan</label>
              <input type="text" class="form-control" name="tipe_layanan" value="<?php echo htmlspecialchars($tipe_layanan); ?>" placeholder="Pascapayar / Prabayar">
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-xs-6">
            <div class="form-group">
              <label>Penanggung Jawab</label>
              <input type="text" class="form-control" name="penanggung_jawab" value="<?php echo htmlspecialchars($penanggung_jawab); ?>">
            </div>
          </div>
          <div class="col-xs-6">
            <div class="form-group">
              <label>Divisi</label>
              <input type="text" class="form-control" name="divisi" value="<?php echo htmlspecialchars($divisi); ?>">
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-xs-12">
            <div class="form-group">
              <label>Jabatan / Peruntukan</label>
              <input type="text" class="form-control" name="jabatan_peruntukan" value="<?php echo htmlspecialchars($jabatan_peruntukan); ?>">
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-xs-6">
            <div class="form-group">
              <label>Status Nomor</label>
              <select class="form-control" name="status_nomor">
<?php foreach ($STATUS_LIST as $st) { ?>
                <option value="<?php echo e($st); ?>" <?php echo e(($st == $status_nomor) ? 'selected' : ''); ?>><?php echo e($st); ?></option>
<?php } ?>
              </select>
            </div>
          </div>
          <div class="col-xs-6">
            <div class="form-group">
              <label>Status WA Business</label>
              <input type="text" class="form-control" name="status_wa_business" value="<?php echo htmlspecialchars($status_wa_business); ?>">
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-xs-6">
            <div class="form-group">
              <label>Paket / Plan</label>
              <input type="text" class="form-control" name="paket_plan" value="<?php echo htmlspecialchars($paket_plan); ?>">
            </div>
          </div>
          <div class="col-xs-6">
            <div class="form-group">
              <label>Biaya Bulanan (Rp)</label>
              <input type="number" step="1" min="0" class="form-control" name="biaya_bulanan" value="<?php echo htmlspecialchars($biaya_bulanan); ?>">
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-xs-6">
            <div class="form-group">
              <label>Tgl Jatuh Tempo</label>
              <input type="date" class="form-control" name="tgl_jatuh_tempo" value="<?php echo htmlspecialchars($tgl_jatuh_tempo); ?>">
            </div>
          </div>
          <div class="col-xs-6">
            <div class="form-group">
              <label>Tgl Registrasi</label>
              <input type="date" class="form-control" name="tgl_registrasi" value="<?php echo htmlspecialchars($tgl_registrasi); ?>">
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-xs-6">
            <div class="form-group">
              <label>Nomor ICCID / SIM</label>
              <input type="text" class="form-control" name="no_iccid" value="<?php echo htmlspecialchars($no_iccid); ?>">
            </div>
          </div>
          <div class="col-xs-6">
            <div class="form-group">
              <label>Keterangan</label>
              <input type="text" class="form-control" name="keterangan" value="<?php echo htmlspecialchars($keterangan); ?>">
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="dv-footer">
      <input type="button" class="btn btn-default" value="Cancel" onclick="window.close();">
      <input type="submit" class="btn btn-success" name="save_device" value="Save">
    </div>
  </form>
</div>
</body>
</html>
