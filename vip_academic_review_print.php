<?php
require_once __DIR__ . "/_lib/bootstrap.php"; auth_require_login();
/* ============================================================
   STUDENT - ACADEMIC REVIEW REQUIRED (PRINT VIEW)
   Dibuka via tombol "Print" di vip_academic_review.php (form yang
   sama tombolnya punya formtarget="_blank" & formaction ke file ini,
   jadi semua isian form -- termasuk yang BELUM disimpan ke DB --
   langsung terkirim ke sini lewat POST, tidak perlu query ulang ke
   database).
   Layout dibuat seperti dokumen formal siap cetak: kop judul, tabel
   data siswa, tabel perbandingan skor, 5 section narasi, dan baris
   tanda tangan (Teacher / Pairing Teacher / Academic Supervisor).

   Bisa dibuka dgn 2 cara:
   1) POST dari vip_academic_review.php (data form, termasuk yg belum
      disimpan ke DB) -- tidak perlu koneksi DB. Auto window.print()
      tetap jalan di mode ini (sesuai tombol "Print" di form).
   2) GET ?id=<id baris vip_academic_review>&view=1 -- dipakai dari
      tombol "View" di vip_academic_review_list.php, utk SEKEDAR
      lihat detail review yg sudah tersimpan (bukan print). Mode ini
      TIDAK auto-trigger dialog print -- user tinggal pencet tombol
      "Print / Save as PDF" di pojok kanan atas kalau memang mau cetak.
   ============================================================ */

function pf($arr, $key) {
	return isset($arr[$key]) ? trim($arr[$key]) : '';
}

$view_mode = isset($_GET['view']) && in_val('view', 'get') == '1';

$id_param = isset($_GET['id']) ? (int) in_val('id', 'get') : 0;

if (cnt($_POST) > 0) {
	// ---- Mode 1: data dari form (POST) ----
	$src = $_POST;

	$kd_biodata   = pf($src, 'kd_biodata');
	$kd_class     = pf($src, 'kd_class');
	$nama_lengkap = pf($src, 'nama_lengkap');
	$nm_program   = pf($src, 'nm_program');
	$level_program= pf($src, 'level_program');
	$teacher_name = pf($src, 'teacher_name');
	$final_test_date = pf($src, 'final_test_date');

	$reason_review        = pf($src, 'reason_review');
	$observations         = pf($src, 'observations');
	$support_provided     = pf($src, 'support_provided');
	$recommended_followup = pf($src, 'recommended_followup');
	$vcms_status          = pf($src, 'vcms_status');
	$pic_name             = '';
	$created_at_val       = '';

	$plc = array(
		'L' => pf($src, 'plc_L'), 'St' => pf($src, 'plc_St'), 'S' => pf($src, 'plc_S'),
		'R' => pf($src, 'plc_R'), 'W' => pf($src, 'plc_W'), 'Total' => pf($src, 'plc_Total'),
	);
	$mid = array(
		'L' => pf($src, 'mid_L'), 'St' => pf($src, 'mid_St'), 'S' => pf($src, 'mid_S'),
		'R' => pf($src, 'mid_R'), 'W' => pf($src, 'mid_W'), 'Total' => pf($src, 'mid_Total'),
	);
	$fin = array(
		'L' => pf($src, 'fin_L'), 'St' => pf($src, 'fin_St'), 'S' => pf($src, 'fin_S'),
		'R' => pf($src, 'fin_R'), 'W' => pf($src, 'fin_W'), 'Total' => pf($src, 'fin_Total'),
	);
} elseif (num($id_param) > 0) {
	// ---- Mode 2: data dari DB (GET ?id=) ----
	include __DIR__ . "/conndb.php";
	// Melihat review tersimpan lewat ?id= hanya utk 3 Academic Supervisor
	include __DIR__ . "/vip_academic_review_auth.php";
	if (!ar_is_logged_in()) {
		die("Akses ditolak. Silakan login dulu lewat halaman Student Academic Review.");
	}
	$id_sql = (int) $id_param;
	$query_row = q_set($__p_query_row, "SELECT kd_biodata, kd_class, nama_lengkap, nm_program, level_program, teacher_name, final_test_date,\r
\t\tplacement_l, placement_st, placement_s, placement_r, placement_w, placement_total,\r
\t\tmid_l, mid_st, mid_s, mid_r, mid_w, mid_total,\r
\t\tfinal_l, final_st, final_s, final_r, final_w, final_total,\r
\t\treason_review, observations, support_provided, recommended_followup, vcms_status,\r
\t\tpic, created_at\r
\t\tFROM ves_data.vip_academic_review WHERE id = ?  LIMIT 1", [(string) ($id_sql)]);
	// PENTING: "or die()" jangan ditaruh di dalam argumen db_fetch(, PDO::FETCH_NUM) --
	// karena prioritas operator, argumennya jadi boolean (true), bukan result
	// resource, sehingga muncul "supplied argument is not a valid MySQL
	// result resource". Query dijalankan dulu ke variabel terpisah.
	$res_row = db_query_or_die('', $query_row, $__p_query_row ?? []);
	$row = db_fetch($res_row, PDO::FETCH_NUM);

	if ($row) {
		$kd_biodata   = $row[0];
		$kd_class     = $row[1];
		$nama_lengkap = $row[2];
		$nm_program   = $row[3];
		$level_program= $row[4];
		$teacher_name = $row[5];
		$final_test_date = $row[6];
		$plc = array('L' => $row[7], 'St' => $row[8], 'S' => $row[9], 'R' => $row[10], 'W' => $row[11], 'Total' => $row[12]);
		$mid = array('L' => $row[13], 'St' => $row[14], 'S' => $row[15], 'R' => $row[16], 'W' => $row[17], 'Total' => $row[18]);
		$fin = array('L' => $row[19], 'St' => $row[20], 'S' => $row[21], 'R' => $row[22], 'W' => $row[23], 'Total' => $row[24]);
		$reason_review        = $row[25];
		$observations         = $row[26];
		$support_provided     = $row[27];
		$recommended_followup = $row[28];
		$vcms_status          = $row[29];
		$pic_name             = $row[30];
		$created_at_val       = $row[31];
		// selain Academic Supervisor, hanya boleh melihat review yg dia input sendiri
		if (!ar_is_supervisor() && strcasecmp(trim($pic_name), trim($_SESSION['nama_lengkap'])) !== 0) {
			die("Akses ditolak. Review ini bukan hasil input Anda.");
		}
	} else {
		die("Data review tidak ditemukan (id tidak valid).");
	}
} else {
	// tidak ada data sama sekali
	$kd_biodata = ''; $kd_class = ''; $nama_lengkap = ''; $nm_program = ''; $level_program = '';
	$teacher_name = ''; $final_test_date = '';
	$reason_review = ''; $observations = ''; $support_provided = ''; $recommended_followup = ''; $vcms_status = '';
	$pic_name = ''; $created_at_val = '';
	$plc = array('L'=>'','St'=>'','S'=>'','R'=>'','W'=>'','Total'=>'');
	$mid = $plc; $fin = $plc;
}

function dash($v) { return ($v === '' || $v === null) ? '-' : htmlspecialchars($v); }

$printed_at = date('d M Y H:i');
$final_test_date_fmt = $final_test_date != '' ? date('d M Y', strtotime($final_test_date)) : '-';
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Student - Academic Review Required<?php echo e($nama_lengkap != '' ? ' - ' . htmlspecialchars($nama_lengkap) : ''); ?></title>
<style>
  * { box-sizing: border-box; }
  body {
    font-family: "Segoe UI", Arial, sans-serif;
    color: #222;
    margin: 0;
    background: #e9ecef;
  }
  .page {
    max-width: 850px;
    margin: 20px auto 60px;
    background: #fff;
    padding: 34px 42px 40px;
    box-shadow: 0 0 10px rgba(0,0,0,0.15);
  }
  .toolbar {
    max-width: 850px;
    margin: 14px auto;
    text-align: right;
  }
  .toolbar button {
    padding: 8px 18px;
    font-size: 14px;
    border: 1px solid #ccc;
    border-radius: 4px;
    background: #fff;
    cursor: pointer;
    margin-left: 8px;
  }
  .toolbar button.primary { background: #3f7fd1; color: #fff; border-color: #3f7fd1; }

  .doc-header {
    text-align: center;
    border-bottom: 3px solid #3f7fd1;
    padding-bottom: 12px;
    margin-bottom: 20px;
  }
  .doc-header .inst-name { font-size: 14px; font-weight: 700; letter-spacing: 0.5px; color: #3f7fd1; text-transform: uppercase; }
  .doc-header .doc-title { font-size: 20px; font-weight: 700; margin-top: 5px; }
  .doc-header .doc-sub { font-size: 11px; color: #777; margin-top: 3px; }

  table.info-table { width: 100%; border-collapse: collapse; margin-bottom: 18px; font-size: 13px; }
  table.info-table td { padding: 5px 4px; vertical-align: top; }
  table.info-table td.lbl { width: 190px; color: #555; }
  table.info-table td.val { font-weight: 600; border-bottom: 1px dotted #bbb; }

  .sec-title {
    background: #3f7fd1;
    color: #fff;
    font-size: 12.5px;
    font-weight: 700;
    padding: 6px 10px;
    margin: 16px 0 0;
    border-radius: 3px 3px 0 0;
  }
  .sec-body {
    border: 1px solid #c9d6e8;
    border-top: none;
    padding: 10px 12px;
    min-height: 32px;
    font-size: 12.5px;
    line-height: 1.5;
    white-space: pre-wrap;
    border-radius: 0 0 3px 3px;
    margin-bottom: 0;
  }
  .sec-body.empty { color: #aaa; font-style: italic; }

  table.score-table { width: 100%; border-collapse: collapse; font-size: 12.5px; margin: 10px 0 4px; }
  table.score-table th, table.score-table td { border: 1px solid #c9d6e8; padding: 6px 10px; text-align: center; }
  table.score-table thead th { background: #dce6f5; font-weight: 700; }
  table.score-table td:first-child { text-align: left; font-weight: 600; background: #f7f9fc; }
  table.score-table tr.overall td { font-weight: 700; background: #eef3fb; }

  .sign-row { margin-top: 36px; width: 100%; border-collapse: collapse; font-size: 13px; }
  .sign-row td { width: 33.33%; text-align: center; vertical-align: top; padding-top: 42px; }
  .sign-row .line { border-top: 1px solid #333; padding-top: 6px; margin: 0 14px; }
  .sign-role { font-weight: 600; }
  .sign-sub { color: #777; font-size: 11px; }

  .footer-note { margin-top: 18px; font-size: 10px; color: #999; text-align: right; }

  @media print {
    body { background: #fff; }
    .toolbar { display: none; }
    .page { box-shadow: none; margin: 0; padding: 12mm 16mm; max-width: none; }
    @page { size: A4 portrait; margin: 0; }
  }
</style>
</head>
<body>

<div class="toolbar">
  <button class="primary" onclick="window.print()">&#128424; Print / Save as PDF</button>
  <button onclick="window.close()">Tutup</button>
</div>

<div class="page">

  <div class="doc-header">
    <div class="inst-name">Academic Supervision</div>
    <div class="doc-title">STUDENT - ACADEMIC REVIEW REQUIRED</div>
    <div class="doc-sub">Dicetak pada <?php echo e($printed_at); ?></div>
  </div>

  <table class="info-table">
    <tr>
      <td class="lbl">Student Name</td>
      <td class="val"><?php echo e(dash($nama_lengkap)); ?></td>
    </tr>
    <tr>
      <td class="lbl">Class Code / Program / Level</td>
      <td class="val"><?php echo e(dash($kd_class)) . ' / ' . e(dash($nm_program)) . ' / ' . e(dash($level_program)); ?></td>
    </tr>
    <tr>
      <td class="lbl">Teacher(s)</td>
      <td class="val"><?php echo e(dash($teacher_name)); ?></td>
    </tr>
    <tr>
      <td class="lbl">Final Test Date</td>
      <td class="val"><?php echo e(dash($final_test_date_fmt)); ?></td>
    </tr>
<?php if ($pic_name != '') { ?>
    <tr>
      <td class="lbl">Checked By</td>
      <td class="val"><?php echo e(dash($pic_name)); ?><?php echo e($created_at_val != '' ? ' &nbsp;(' . date('d M Y H:i', strtotime($created_at_val)) . ')' : ''); ?></td>
    </tr>
<?php } ?>
  </table>

  <div class="sec-title">2. Score Comparison</div>
  <table class="score-table">
    <thead>
      <tr><th style="text-align:left;">Skills</th><th>Placement Test Score</th><th>Mid Test Score</th><th>Final Test Score</th></tr>
    </thead>
    <tbody>
      <tr><td>Listening (L)</td><td><?php echo e(dash($plc['L'])); ?></td><td><?php echo e(dash($mid['L'])); ?></td><td><?php echo e(dash($fin['L'])); ?></td></tr>
      <tr><td>Reading (R)</td><td><?php echo e(dash($plc['R'])); ?></td><td><?php echo e(dash($mid['R'])); ?></td><td><?php echo e(dash($fin['R'])); ?></td></tr>
      <tr><td>Writing (W)</td><td><?php echo e(dash($plc['W'])); ?></td><td><?php echo e(dash($mid['W'])); ?></td><td><?php echo e(dash($fin['W'])); ?></td></tr>
      <tr><td>Speaking (S)</td><td><?php echo e(dash($plc['S'])); ?></td><td><?php echo e(dash($mid['S'])); ?></td><td><?php echo e(dash($fin['S'])); ?></td></tr>
      <tr><td>Structure (St)</td><td><?php echo e(dash($plc['St'])); ?></td><td><?php echo e(dash($mid['St'])); ?></td><td><?php echo e(dash($fin['St'])); ?></td></tr>
      <tr class="overall"><td>Overall</td><td><?php echo e(dash($plc['Total'])); ?></td><td><?php echo e(dash($mid['Total'])); ?></td><td><?php echo e(dash($fin['Total'])); ?></td></tr>
    </tbody>
  </table>

  <div class="sec-title">3. Reason for Review</div>
  <div class="sec-body<?php echo e($reason_review == '' ? ' empty' : ''); ?>"><?php echo e($reason_review != '' ? nl2br(htmlspecialchars($reason_review)) : 'Belum diisi.'); ?></div>

  <div class="sec-title">4. Observations &amp; Possible Contributing Factors</div>
  <div class="sec-body<?php echo e($observations == '' ? ' empty' : ''); ?>"><?php echo e($observations != '' ? nl2br(htmlspecialchars($observations)) : 'Belum diisi.'); ?></div>

  <div class="sec-title">5. Support Provided &amp; Coordination with Pairing Teacher</div>
  <div class="sec-body<?php echo e($support_provided == '' ? ' empty' : ''); ?>"><?php echo e($support_provided != '' ? nl2br(htmlspecialchars($support_provided)) : 'Belum diisi.'); ?></div>

  <div class="sec-title">6. Recommended Follow-up</div>
  <div class="sec-body<?php echo e($recommended_followup == '' ? ' empty' : ''); ?>"><?php echo e($recommended_followup != '' ? nl2br(htmlspecialchars($recommended_followup)) : 'Belum diisi.'); ?></div>

  <div class="sec-title">7. VCMS Status</div>
  <div class="sec-body<?php echo e($vcms_status == '' ? ' empty' : ''); ?>"><?php echo e($vcms_status != '' ? nl2br(htmlspecialchars($vcms_status)) : 'Belum diisi.'); ?></div>

  <table class="sign-row">
    <tr>
      <td><div class="line sign-role">Teacher</div><div class="sign-sub"><?php echo e(dash($teacher_name)); ?></div></td>
      <td><div class="line sign-role">Pairing Teacher</div><div class="sign-sub">&nbsp;</div></td>
      <td><div class="line sign-role">Academic Supervisor</div><div class="sign-sub">&nbsp;</div></td>
    </tr>
  </table>

  <div class="footer-note">vip_academic_review_print.php &middot; <?php echo htmlspecialchars($kd_biodata); ?></div>

</div>

<?php if (!$view_mode) { ?>
<script>
  // Auto-print TIDAK dijalankan dlm mode "view" (lihat dari tombol
  // View di list) -- hanya dijalankan utk mode Print asli (dari form).
  window.onload = function () { window.print(); };
</script>
<?php } ?>
</body>
</html>
