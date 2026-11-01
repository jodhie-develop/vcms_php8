<?php
require_once __DIR__ . "/_lib/bootstrap.php"; csrf_guard_get(); auth_require_login();
include __DIR__ . "/conndb.php";
include __DIR__ . "/profiledata.php";

/* ============================================================
   TEACHER RATE EDITOR (dibuka sebagai popup) — v2

   Dipanggil dari teacher_salary_report.php dengan klik nama teacher.
   Setelah submit sukses, otomatis reload halaman yang membuka popup
   ini (window.opener.location.reload()).

   PERUBAHAN pada versi ini:

   1. JENIS RATE (CA / VIP / FA)
      Ditambahkan dropdown "Jenis Rate" di atas form. Semua rate
      yang di-set di halaman ini berlaku untuk jenis_rate yang lagi
      dipilih. Ini konsisten dengan teacher_salary_report.php, yang
      menentukan jenis_rate sebuah sesi dari pola kode kelas
      (CA%, FA-%, selain itu VIP).

   2. RATE EFEKTIF DATE (histori rate, bukan overwrite)
      Tiap kombinasi (nama_rate, jenis_rate, tgl_efektif) adalah
      baris rate TERSENDIRI. Simpan rate baru dengan tanggal efektif
      baru -> jadi histori baru (tidak menghapus rate lama), supaya
      kelas yang berjalan sebelum tanggal efektif tetap dihitung
      pakai rate lama (lihat get_applicable_rate() di
      teacher_salary_report.php). Kalau tanggal efektif yang
      dimasukkan SAMA dengan yang sudah ada, baris itu di-UPDATE
      (dianggap koreksi, bukan histori baru).

   3. RATE PER SESSION / PER SATUAN SESSION
      Ditambahkan tipe rate baru "Session". Untuk tipe ini ada 2
      input: "Rate / Satuan" dan "Jumlah Satuan per Session"
      (misalnya 1 session = 1.5 satuan). Total per session dihitung
      otomatis (RATE DIBAGI SATUAN, bukan dikali) dan ditampilkan
      sebagai referensi, contoh: rate 150.000, satuan 1.5 -> total
      per session = 150.000 / 1.5 = 100.000.
      Untuk tipe rate lain (Online/Offiline/Visit/Corporate), satuan
      selalu 1 (tidak ditampilkan ke user).

   4. HISTORI RATE + EDIT/DELETE (v3)
      Ditambahkan tabel "Riwayat Rate" di bawah form, menampilkan
      semua rate (semua tanggal efektif) untuk jenis_rate yang lagi
      dipilih, supaya bisa dicek kapan rate berubah. Tiap baris
      histori sekarang punya 2 tombol:
        - "Edit"   -> isi ulang input di form atas (rate/satuan/
                      tanggal efektif) pakai nilai baris itu (lewat
                      JS, tidak reload), tinggal ubah nilainya lalu
                      klik Save -> karena tanggal efektifnya sama,
                      baris itu di-UPDATE (bukan jadi histori baru).
        - "Delete" -> hapus baris rate itu (dengan konfirmasi JS),
                      diproses lewat parameter GET Delete=1 sebelum
                      ada output HTML apa pun, sama seperti Submit.

   -> WAJIB jalankan dulu (kalau kolom belum ada), sama seperti yang
      sudah disebutkan di teacher_salary_report.php:
        ALTER TABLE ves_data.vip_mst_teacher_rate
          ADD COLUMN jenis_rate VARCHAR(10) NOT NULL DEFAULT 'VIP' AFTER nama_rate,
          ADD COLUMN satuan DECIMAL(6,2) NOT NULL DEFAULT 1 AFTER rate,
          ADD COLUMN tgl_efektif DATE NULL DEFAULT NULL AFTER satuan;
      Kalau tabel vip_mst_teacher_rate belum punya kolom "id" auto
      increment sebagai primary key, tambahkan juga supaya tiap
      baris histori punya identitas sendiri:
        ALTER TABLE ves_data.vip_mst_teacher_rate
          ADD COLUMN id INT AUTO_INCREMENT PRIMARY KEY FIRST;
   ============================================================ */

$hari  = date("d");
$bulan = date("m");
$tahun = date("Y");
$hari_ini = "$tahun-$bulan-$hari";

$id = isset($_GET['id']) ? intval(in_val('id', 'any')) : 0;

// Tipe rate yang didukung -- TODO: sesuaikan kalau ada tipe baru
$RATE_TYPES = array('Online', 'Offline', 'Visit', 'Corporate', 'Session');
$SESSION_TYPE = 'Session'; // tipe yang punya input rate/satuan terpisah

// Jenis rate yang didukung
$JENIS_RATE_LIST = array('CA', 'VIP', 'FA');
$jenis_rate_pilih = isset($_GET['jenis_rate_pilih']) && in_array(in_val('jenis_rate_pilih', 'any'), $JENIS_RATE_LIST)
	? in_val('jenis_rate_pilih', 'any') : 'VIP';

// ---- Helper: cari rate yang berlaku hari ini dari sekumpulan histori ----
// $history[] = array('rate'=>.., 'satuan'=>.., 'tgl_efektif'=>..), urut ASC by tgl_efektif (null dulu)
function get_active_rate($history, $tgl_cek) {
	$applicable = null;
	foreach ($history as $h) {
		if ($h['tgl_efektif'] === null || $h['tgl_efektif'] <= $tgl_cek) {
			$applicable = $h;
		} else {
			break;
		}
	}
	return $applicable;
}

// ---- Proses submit: simpan rate baru (histori) / update rate pada
//      tanggal efektif yang sama -- dicek & diproses duluan, sebelum
//      ada output HTML apa pun ----
if (($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['Submit'])) && num($id) > 0) {
	$jenis_rate_sql = $jenis_rate_pilih;

	foreach ($RATE_TYPES as $type) {
		$field_rate = 'rate_' . $type;
		if (!isset($_POST[$field_rate]) || $_POST[$field_rate] === '') {
			continue; // rate tidak diisi -> lewati, tidak menyentuh data lama
		}

		$rate_value = (float) $_POST[$field_rate];

		if ($type == $SESSION_TYPE) {
			$field_satuan = 'satuan_' . $type;
			$satuan_value = (isset($_POST[$field_satuan]) && $_POST[$field_satuan] !== '') ? (float) $_POST[$field_satuan] : 1;
		} else {
			$satuan_value = 1;
		}

		$field_tgl = 'tgl_efektif_' . $type;
		$tgl_efektif = (isset($_POST[$field_tgl]) && $_POST[$field_tgl] !== '') ? $_POST[$field_tgl] : $hari_ini;
		$tgl_efektif_sql = $tgl_efektif;

		$type_sql = $type;

		// Cek apakah sudah ada baris rate persis di tanggal efektif yang sama
		// (kombinasi nama_rate + jenis_rate + tgl_efektif) -> kalau ada berarti
		// ini koreksi, bukan histori baru.
		$query_cek = q_set($__p_query_cek, "SELECT id_teacher FROM ves_data.vip_mst_teacher_rate\r
\t\t\tWHERE id_teacher = ?  AND nama_rate = ? AND jenis_rate = ?\r
\t\t\tAND tgl_efektif = ? ", [(string) ($id), (string) ($type_sql), (string) ($jenis_rate_sql), (string) ($tgl_efektif_sql)]);
		$result_cek = db_query_or_die('Wah error nih cek rate', $query_cek, $__p_query_cek ?? []);

		if (num($result_cek->rowCount()) > 0) {
			$query_upd = q_set($__p_query_upd, "UPDATE ves_data.vip_mst_teacher_rate\r
\t\t\t\tSET rate = ? , satuan = ? , update_date = ?\r
\t\t\t\tWHERE id_teacher = ?  AND nama_rate = ? AND jenis_rate = ?\r
\t\t\t\tAND tgl_efektif = ? ", [(string) ($rate_value), (string) ($satuan_value), (string) ($hari_ini), (string) ($id), (string) ($type_sql), (string) ($jenis_rate_sql), (string) ($tgl_efektif_sql)]);
			db_query_or_die('Wah error nih update rate', $query_upd, $__p_query_upd ?? []);
		} else {
			$query_ins = q_set($__p_query_ins, "INSERT INTO ves_data.vip_mst_teacher_rate\r
\t\t\t\t(id_teacher, nama_rate, jenis_rate, rate, satuan, tgl_efektif, update_date)\r
\t\t\t\tVALUES (? , ? , ? , ? , ? , ? , ? )", [(string) ($id), (string) ($type_sql), (string) ($jenis_rate_sql), (string) ($rate_value), (string) ($satuan_value), (string) ($tgl_efektif_sql), (string) ($hari_ini)]);
			db_query_or_die('Wah error nih insert rate', $query_ins, $__p_query_ins ?? []);
		}
	}

	echo "<script type=\"text/javascript\">
		alert('Teacher Rate berhasil diupdate');
		if (window.opener) { window.opener.location.reload(); }
		window.close();
	</script>";
	exit;
}

// ---- Proses hapus 1 baris rate histori -- dicek & diproses duluan,
//      sebelum ada output HTML apa pun ----
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['Delete']) && num($id) > 0 && isset($_POST['del_type']) && isset($_POST['del_jenis_rate'])) {
	$del_type_sql = in_val('del_type', 'any');
	$del_jenis_rate_sql = in_val('del_jenis_rate', 'any');
	$del_tgl = isset($_POST['del_tgl']) ? in_val('del_tgl', 'post') : '';

	if ($del_tgl !== '') {
		$del_tgl_sql = $del_tgl;
		$query_del = q_set($__p_query_del, "DELETE FROM ves_data.vip_mst_teacher_rate\r
\t\t\tWHERE id_teacher = ?  AND nama_rate = ? AND jenis_rate = ?\r
\t\t\tAND tgl_efektif = ? ", [(string) ($id), (string) ($del_type_sql), (string) ($del_jenis_rate_sql), (string) ($del_tgl_sql)]);
	} else {
		// baris legacy tanpa tanggal efektif (tgl_efektif NULL)
		$query_del = q_set($__p_query_del, "DELETE FROM ves_data.vip_mst_teacher_rate\r
\t\t\tWHERE id_teacher = ?  AND nama_rate = ? AND jenis_rate = ?\r
\t\t\tAND tgl_efektif IS NULL", [(string) ($id), (string) ($del_type_sql), (string) ($del_jenis_rate_sql)]);
	}
	db_query_or_die('Wah error nih hapus rate', $query_del, $__p_query_del ?? []);

	echo "<script type=\"text/javascript\">
		alert('Rate berhasil dihapus');
		if (window.opener) { window.opener.location.reload(); }
		window.location.href = 'teacher_master_upd.php?id=" . (int) $id . "&jenis_rate_pilih=" . urlencode($jenis_rate_pilih) . "';
	</script>";
	exit;
}

// ---- Ambil data teacher ----
$nm_teacher = ''; $kd_teacher = ''; $branch = ''; $group_teacher = ''; $aktif = '';
$query_nm_teacher = q_set($__p_query_nm_teacher, "SELECT a.no, nama_detail, kd_teacher, a.branch, posisi, a.aktif FROM ves_data.tb_user a LEFT JOIN ves_data.vip_teacher_name b ON a.no = b.kd_user WHERE a.no = ? ", [(string) (intval($id))]);
$resource_nm_teacher = db_query_soft($query_nm_teacher, $__p_query_nm_teacher ?? []);
if ($resource_nm_teacher && num($resource_nm_teacher->rowCount()) > 0) {
	$row_nm_teacher = $resource_nm_teacher->fetch(PDO::FETCH_NUM);
	$nm_teacher    = $row_nm_teacher[1];
	$kd_teacher    = $row_nm_teacher[2];
	$branch        = $row_nm_teacher[3];
	$group_teacher = $row_nm_teacher[4];
	$aktif         = $row_nm_teacher[5];
}

$center_list = array(
	'1' => 'East Sby', '2' => 'West Sby', '3' => 'Bali', '4' => 'South Jkt',
	'5' => 'North Jkt', '6' => 'West Jkt', '7' => 'Bandung', '8' => 'Malang',
);
$branch_nama = isset($center_list[$branch]) ? $center_list[$branch] : $branch;

// ---- Ambil SEMUA histori rate teacher ini untuk jenis_rate yang dipilih,
//      key by nama_rate, urut ASC by tgl_efektif (null / tanggal kosong dulu) ----
$rate_history_by_type = array(); // nama_rate => array of history rows
$jenis_rate_sql = $jenis_rate_pilih;
$query_rate = q_set($__p_query_rate, "SELECT nama_rate, rate, satuan, tgl_efektif FROM ves_data.vip_mst_teacher_rate\r
\tWHERE id_teacher = ?  AND jenis_rate = ?\r
\tORDER BY nama_rate, (tgl_efektif IS NULL) DESC, tgl_efektif ASC", [(string) (intval($id)), (string) ($jenis_rate_sql)]);
$resource_rate = db_query_soft($query_rate, $__p_query_rate ?? []);
if ($resource_rate) {
	while ($row_rate = $resource_rate->fetch(PDO::FETCH_NUM)) {
		$rn = $row_rate[0];
		if (!isset($rate_history_by_type[$rn])) $rate_history_by_type[$rn] = array();
		$rate_history_by_type[$rn][] = array(
			'rate'        => $row_rate[1],
			'satuan'      => ($row_rate[2] !== null && $row_rate[2] !== '') ? $row_rate[2] : 1,
			'tgl_efektif' => $row_rate[3],
		);
	}
}
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Update Teacher Rate</title>
  <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
  <style>
	body { background: #f4f6f9; padding: 20px; font-family: Arial, sans-serif; }
	.card { background: #fff; border-radius: 6px; box-shadow: 0 1px 3px rgba(0,0,0,.15); overflow: hidden; }
	.card-header { background: #3c8dbc; color: #fff; padding: 12px 18px; font-size: 16px; font-weight: bold; }
	.card-body { padding: 18px; }
	.info-table td { padding: 4px 8px; }
	.info-table td.label { color: #666; width: 110px; }
	.rate-table th, .rate-table td { vertical-align: middle; }
	.footer-btn { margin-top: 15px; text-align: right; }
	.rate-active-hint { font-size: 11px; color: #777; margin-top: 2px; }
	.history-table th, .history-table td { font-size: 12px; text-align: center; vertical-align: middle; }
	.jenis-rate-tab .btn { margin-right: 4px; }
	.jenis-rate-tab .btn.active-tab { background: #3c8dbc; color: #fff; }
  </style>
</head>
<body>
  <div class="card">
    <div class="card-header">Update Teacher Rate</div>
    <div class="card-body">

<?php if (num($id) <= 0 || $nm_teacher === '') { ?>
      <div class="alert alert-danger">Teacher tidak ditemukan. Halaman ini harus dibuka dengan parameter <code>?id=</code> yang valid.</div>
<?php } else { ?>

      <table class="info-table">
        <tr><td class="label">Teacher Name</td><td><strong><?php echo htmlspecialchars($nm_teacher); ?></strong></td></tr>
        <tr><td class="label">Branch</td><td><?php echo htmlspecialchars($branch_nama); ?></td></tr>
        <tr><td class="label">Group</td><td><?php echo htmlspecialchars($group_teacher); ?></td></tr>
        <tr><td class="label">Status</td><td><?php echo htmlspecialchars($aktif); ?></td></tr>
      </table>

      <!-- Pilihan Jenis Rate: CA / VIP / FA -->
      <div class="jenis-rate-tab" style="margin-top:12px;">
        <label style="display:block; font-size:12px; color:#666;">Jenis Rate</label>
<?php foreach ($JENIS_RATE_LIST as $jr) { ?>
        <a class="btn btn-default btn-sm <?php echo e(($jr == $jenis_rate_pilih) ? 'active-tab' : ''); ?>"
           href="?id=<?php echo (int) $id; ?>&jenis_rate_pilih=<?php echo urlencode($jr); ?>"><?php echo htmlspecialchars($jr); ?></a>
<?php } ?>
      </div>

      <form style="margin-top:12px;" method="post"><?php echo csrf_field(); ?>

        <input type="hidden" name="id" value="<?php echo (int) $id; ?>">
        <input type="hidden" name="jenis_rate_pilih" value="<?php echo htmlspecialchars($jenis_rate_pilih); ?>">
        <table class="table table-bordered rate-table">
          <thead>
            <tr>
              <th>Type of Teaching</th>
              <th style="width:160px;">Rate<?php echo e(($jenis_rate_pilih != '') ? " ($jenis_rate_pilih)" : ''); ?></th>
              <th style="width:130px;">Satuan / Session</th>
              <th style="width:150px;">Tanggal Efektif</th>
            </tr>
          </thead>
          <tbody>
<?php foreach ($RATE_TYPES as $type) {
	$history = isset($rate_history_by_type[$type]) ? $rate_history_by_type[$type] : array();
	$active  = get_active_rate($history, $hari_ini);
	$is_session = ($type == $SESSION_TYPE);
?>
            <tr>
              <td>
                <?php echo htmlspecialchars($type); ?>
<?php if ($active) { ?>
                <div class="rate-active-hint">
                  Rate aktif sekarang: <?php echo number_format(num($active['rate'])); ?>
<?php if ($is_session) { ?>
                  &divide; <?php echo e($active['satuan']); ?> satuan
                  = <strong><?php echo number_format(num($active['satuan']) != 0 ? round(div($active['rate'], $active['satuan'])) : 0); ?></strong>
<?php } ?>
<?php if ($active['tgl_efektif']) { ?>
                  (efektif sejak <?php echo htmlspecialchars($active['tgl_efektif']); ?>)
<?php } ?>
                </div>
<?php } else { ?>
                <div class="rate-active-hint">Belum ada rate.</div>
<?php } ?>
              </td>
              <td>
                <input type="number" step="1" min="0" class="form-control"
                       id="rate_<?php echo htmlspecialchars($type); ?>"
                       name="rate_<?php echo htmlspecialchars($type); ?>"
                       placeholder="<?php echo e($is_session ? 'Rate / satuan...' : 'Rate baru...'); ?>">
              </td>
              <td>
<?php if ($is_session) { ?>
                <input type="number" step="0.1" min="0" class="form-control"
                       id="satuan_<?php echo htmlspecialchars($type); ?>"
                       name="satuan_<?php echo htmlspecialchars($type); ?>"
                       placeholder="cth: 1.5" value="1">
<?php } else { ?>
                <span class="text-muted">-</span>
<?php } ?>
              </td>
              <td>
                <input type="date" class="form-control"
                       id="tgl_efektif_<?php echo htmlspecialchars($type); ?>"
                       name="tgl_efektif_<?php echo htmlspecialchars($type); ?>"
                       value="<?php echo htmlspecialchars($hari_ini); ?>">
              </td>
            </tr>
<?php } ?>
          </tbody>
        </table>
        <p class="text-muted" style="font-size:12px;">
          Kosongkan kolom Rate kalau tidak ingin mengubah tipe tersebut. Mengisi Rate dengan
          Tanggal Efektif baru akan menyimpan sebagai histori baru (rate lama tetap tersimpan
          dan tetap dipakai untuk kelas sebelum tanggal efektif tsb). Mengisi dengan Tanggal
          Efektif yang sama seperti histori yang sudah ada akan mengoreksi baris tsb.
        </p>

        <div class="footer-btn">
          <button type="button" class="btn btn-default" onclick="window.close();">Cancel</button>
          <button type="submit" name="Submit" value="1" class="btn btn-primary">Save</button>
        </div>
      </form>

      <!-- ============ Riwayat Rate ============ -->
      <h5 style="margin-top:20px;">Riwayat Rate — Jenis Rate: <?php echo htmlspecialchars($jenis_rate_pilih); ?></h5>
      <table class="table table-bordered history-table">
        <thead>
          <tr><th>Type</th><th>Tanggal Efektif</th><th>Rate</th><th>Satuan</th><th>Total / Session</th><th style="width:120px;">Aksi</th></tr>
        </thead>
        <tbody>
<?php
$ada_histori = false;
foreach ($RATE_TYPES as $type) {
	if (empty($rate_history_by_type[$type])) continue;
	$ada_histori = true;
	// tampilkan terbaru dulu
	$rows = array_reverse($rate_history_by_type[$type]);
	foreach ($rows as $h) {
		$total = (num($h['satuan']) != 0) ? round(div($h['rate'], $h['satuan'])) : 0;
		$tgl_js = $h['tgl_efektif'] ? $h['tgl_efektif'] : '';
?>
          <tr>
            <td><?php echo htmlspecialchars($type); ?></td>
            <td><?php echo e($h['tgl_efektif'] ? htmlspecialchars($h['tgl_efektif']) : '(tanpa tanggal / legacy)'); ?></td>
            <td><?php echo number_format(num($h['rate'])); ?></td>
            <td><?php echo e($h['satuan']); ?></td>
            <td><?php echo e(($type == $SESSION_TYPE) ? number_format(num($total)) : '-'); ?></td>
            <td>
              <button type="button" class="btn btn-default btn-xs"
                      onclick="isiForm('<?php echo htmlspecialchars($type, ENT_QUOTES); ?>', <?php echo (float) $h['rate']; ?>, <?php echo (float) $h['satuan']; ?>, '<?php echo htmlspecialchars($tgl_js, ENT_QUOTES); ?>')">Edit</button>
              <form method="post" action="?id=<?php echo (int) $id; ?>&jenis_rate_pilih=<?php echo e(u($jenis_rate_pilih)); ?>" style="display:inline"
                    onsubmit="return confirm(<?php echo e(js('Hapus rate ' . $type . ' tanggal efektif ' . ($tgl_js ? $tgl_js : 'legacy') . '?')); ?>);"><?php echo csrf_field(); ?>
                <input type="hidden" name="Delete" value="1">
                <input type="hidden" name="del_type" value="<?php echo e($type); ?>">
                <input type="hidden" name="del_jenis_rate" value="<?php echo e($jenis_rate_pilih); ?>">
                <input type="hidden" name="del_tgl" value="<?php echo e($tgl_js); ?>">
                <button type="submit" class="btn btn-danger btn-xs">Delete</button>
              </form>
            </td>
          </tr>
<?php
	}
}
if (!$ada_histori) {
	echo "<tr><td colspan='6' class='text-muted'>Belum ada histori rate untuk jenis rate ini.</td></tr>";
}
?>
        </tbody>
      </table>

      <script type="text/javascript">
        function isiForm(type, rate, satuan, tglEfektif) {
          var rateInput = document.getElementById('rate_' + type);
          var satuanInput = document.getElementById('satuan_' + type);
          var tglInput = document.getElementById('tgl_efektif_' + type);
          if (rateInput) rateInput.value = rate;
          if (satuanInput) satuanInput.value = satuan;
          if (tglInput) tglInput.value = tglEfektif; // kosong (legacy) -> browser tampilkan input date kosong
          if (rateInput) rateInput.scrollIntoView({behavior: 'smooth', block: 'center'});
        }
      </script>

<?php } ?>
    </div>
  </div>
</body>
</html>
