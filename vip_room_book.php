<?php
require_once __DIR__ . "/_lib/bootstrap.php"; csrf_guard_get(); auth_require_login();

include __DIR__ . "/conndb.php";
include __DIR__ . "/profiledata.php";

/* ============================================================
   ROOM BOOKING
   Denah ruangan per cabang + booking per tanggal & jam.

   Tabel:
   - ves_data.vip_room          (master ruangan per cabang, lihat vip_room_master.php)
   - ves_data.vip_room_booking  (transaksi booking)

   Alur:
   - Filter (GET): kd_cbg, tgl, jam_mulai, jam_selesai, id_room
   - Booking / batal (POST) diproses SEBELUM ada output, lalu redirect
     balik ke halaman yang sama (supaya refresh tidak dobel insert)
   - Bentrok jam dicek di dalam query INSERT (NOT EXISTS)
   ============================================================ */

$T_ROOM = q_set($__p_T_ROOM, "ves_data.vip_room");
$T_BOOK = q_set($__p_T_BOOK, "ves_data.vip_room_booking");
$JAM_BUKA  = 7;   // 07:00
$JAM_TUTUP = 21;  // 21:00

// GANTI kalau nama variabel session user login berbeda
$user_login = isset($_SESSION['username']) ? $_SESSION['username'] : '';

$center_list = array(
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

function rb_h($s) { return htmlspecialchars($s, ENT_QUOTES); }
function rb_min($hm) { return intval(substr($hm, 0, 2)) * 60 + intval(substr($hm, 3, 2)); }
function rb_hm($min) { return sprintf('%02d:%02d', floor(num($min) / 60), num($min) % 60); }

$hari_ini = date("Y-m-d");

// ---- Daftar pilihan jam (per 30 menit) ----
$jam_list = array();
for ($t = num($JAM_BUKA) * 60; $t <= num($JAM_TUTUP) * 60; $t = num($t) + num((30))) { $jam_list[] = rb_hm($t); }

// ---- Ambil parameter filter ----
$kd_cbg = isset($_GET['kd_cbg']) ? in_val('kd_cbg', 'get') : '1';
if (!isset($center_list[$kd_cbg])) { $kd_cbg = '1'; }

$tgl = isset($_GET['tgl']) ? in_val('tgl', 'get') : $hari_ini;
if (!preg_match('/^(\d{4})-(\d{2})-(\d{2})$/', $tgl, $mt) || !checkdate(intval($mt[2]), intval($mt[3]), intval($mt[1]))) {
	$tgl = $hari_ini;
}

$def_mulai = ceil(num((intval(date("G")) * 60 + intval(date("i")))) / 30) * 30;
if ($def_mulai < num($JAM_BUKA) * 60 || $def_mulai > num((num($JAM_TUTUP) - 1)) * 60) { $def_mulai = 9 * 60; }

$jam_mulai   = isset($_GET['jam_mulai'])   ? in_val('jam_mulai', 'get')   : rb_hm($def_mulai);
$jam_selesai = isset($_GET['jam_selesai']) ? in_val('jam_selesai', 'get') : rb_hm(num($def_mulai) + 60);
if (!in_array($jam_mulai, $jam_list, true) || $jam_mulai == rb_hm(num($JAM_TUTUP) * 60)) { $jam_mulai = rb_hm($def_mulai); }
if (!in_array($jam_selesai, $jam_list, true) || $jam_selesai <= $jam_mulai) {
	$jam_selesai = rb_hm(min(num($JAM_TUTUP) * 60, num(rb_min($jam_mulai)) + 60)); // jaga2 kalau jam kebalik
}

$id_room = isset($_GET['id_room']) ? intval(in_val('id_room', 'get')) : 0;

function rb_url($extra) {
	global $kd_cbg, $tgl, $jam_mulai, $jam_selesai, $id_room;
	$p = array('kd_cbg' => $kd_cbg, 'tgl' => $tgl, 'jam_mulai' => $jam_mulai, 'jam_selesai' => $jam_selesai, 'id_room' => $id_room);
	foreach ($extra as $k => $v) { $p[$k] = $v; }
	return basename($_SERVER['PHP_SELF']) . '?' . http_build_query($p, '', '&');
}

$kd_cbg_sql = $kd_cbg;

// ---- Proses POST (booking / batal) SEBELUM ada output apa pun ----
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$act = isset($_POST['act']) ? in_val('act', 'post') : '';
	$msg = '';
	$user_sql = $user_login;

	if ($act == 'book') {
		$p_room    = isset($_POST['id_room']) ? q_set($__p_p_room, intval(in_val('id_room', 'post'))) : q_set($__p_p_room, 0);
		$nama      = isset($_POST['nama']) ? trim(in_val('nama', 'post')) : '';
		$keperluan = isset($_POST['keperluan']) ? trim(in_val('keperluan', 'post')) : '';

		if ($nama == '') {
			$msg = 'nama';
		} elseif ($tgl < $hari_ini) {
			$msg = 'lewat';
		} else {
			// ruangan harus milik cabang ini dan aktif
			$cek = db_query_soft("SELECT id_room FROM " . $T_ROOM . " WHERE id_room = ?  AND kd_branch = ? AND status = 'ACTIVE'", [...($__p_T_ROOM ?? []), (string) ($p_room), (string) ($kd_cbg_sql)]);
			if (!$cek || num(db_num_rows($cek)) == 0) {
				$msg = 'room';
			} else {
				$nama_sql = substr($nama, 0, 60);
				$kep_sql  = substr($keperluan, 0, 150);
				// insert hanya kalau TIDAK ada booking lain yang jamnya beririsan
				$sql = q_set($__p_sql, "INSERT INTO " . $T_BOOK . " (id_room, dt_booking, time_start, time_end, booked_by, purpose, user_input, dt_input, status)\r
\t\t\t\t\tSELECT " . $p_room . ", ? , ? , ? , ? , ? , ? , NOW(), 'BOOKED'\r
\t\t\t\t\tFROM DUAL\r
\t\t\t\t\tWHERE NOT EXISTS (\r
\t\t\t\t\t\tSELECT 1 FROM " . $T_BOOK . " x\r
\t\t\t\t\t\tWHERE x.id_room = ?  AND x.dt_booking = ? AND x.status = 'BOOKED'\r
\t\t\t\t\t\t  AND x.time_start < ? AND x.time_end > ?\r
\t\t\t\t\t)", [...($__p_T_BOOK ?? []), ...($__p_p_room ?? []), (string) ($tgl), (string) ($jam_mulai) . ":00", (string) ($jam_selesai) . ":00", (string) ($nama_sql), (string) ($kep_sql), (string) ($user_sql), ...($__p_T_BOOK ?? []), (string) ($p_room), (string) ($tgl), (string) ($jam_selesai) . ":00", (string) ($jam_mulai) . ":00"]);
				$ok = db_query_soft($sql, $__p_sql ?? []);
				if (!$ok) { $msg = 'gagal'; }
				elseif (num(db_affected_rows()) < 1) { $msg = 'bentrok'; }
				else { $msg = 'ok'; }
			}
		}
		$id_room = $p_room;
	} elseif ($act == 'cancel') {
		$p_book = isset($_POST['id_booking']) ? intval(in_val('id_booking', 'post')) : 0;
		$ok = db_query_soft("UPDATE " . $T_BOOK . " SET status = 'CANCEL', user_cancel = ? , dt_cancel = NOW()\r
\t\t\tWHERE id_booking = ?  AND status = 'BOOKED'", [...($__p_T_BOOK ?? []), (string) ($user_sql), (string) ($p_book)]);
		$msg = $ok ? 'batal' : 'gagal';
	}

	header("Location: " . rb_url(array('msg' => $msg)));
	exit;
}

// ---- Pesan hasil proses ----
$msg_list = array(
	'ok'      => array('success', 'Ruangan dibooking.'),
	'batal'   => array('success', 'Booking dibatalkan.'),
	'bentrok' => array('danger',  'Ruangan sudah dibooking pada jam itu. Pilih jam lain atau ruangan lain.'),
	'nama'    => array('danger',  'Isi nama pemesan dulu.'),
	'lewat'   => array('danger',  'Tanggal sudah lewat. Pilih hari ini atau setelahnya.'),
	'room'    => array('danger',  'Ruangan tidak ditemukan atau tidak aktif di cabang ini.'),
	'gagal'   => array('danger',  'Gagal menyimpan: ' . ''),
);
$msg_kode = isset($_GET['msg']) ? in_val('msg', 'get') : '';

// ---- Master ruangan cabang ini ----
$rooms = array();
$res = db_query_or_die("Query gagal: " . '', "SELECT id_room, room_name, room_type, capacity, facility, pos_x, pos_y, pos_w, pos_h\r
\tFROM " . $T_ROOM . " WHERE kd_branch = ? AND status = 'ACTIVE' ORDER BY room_name", [...($__p_T_ROOM ?? []), (string) ($kd_cbg_sql)]);
$denah_h = 300;
while ($r = db_fetch($res, PDO::FETCH_ASSOC)) {
	$rooms[$r['id_room']] = $r;
	$denah_h = max($denah_h, num($r['pos_y']) + num($r['pos_h']) + 10);
}

// ---- Booking pada tanggal terpilih ----
$bookings = array();          // semua booking tanggal ini (untuk daftar)
$per_room = array();          // $per_room[id_room] = array(booking, ...)
$res = db_query_or_die("Query gagal: " . '', "SELECT b.id_booking, b.id_room,\r
\t\tTIME_FORMAT(b.time_start, '%H:%i') AS jam1, TIME_FORMAT(b.time_end, '%H:%i') AS jam2,\r
\t\tb.booked_by, b.purpose\r
\tFROM " . $T_BOOK . " b\r
\tINNER JOIN " . $T_ROOM . " r ON b.id_room = r.id_room\r
\tWHERE r.kd_branch = ? AND b.dt_booking = ? AND b.status = 'BOOKED'\r
\tORDER BY b.time_start, r.room_name", [...($__p_T_BOOK ?? []), ...($__p_T_ROOM ?? []), (string) ($kd_cbg_sql), (string) ($tgl)]);
while ($b = db_fetch($res, PDO::FETCH_ASSOC)) {
	$bookings[] = $b;
	$per_room[$b['id_room']][] = $b;
}

$room_pilih = isset($rooms[$id_room]) ? $rooms[$id_room] : null;
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Room Booking</title>
  <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
  <link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">
  <style>
	.denah-wrap { overflow-x: auto; border: 1px solid #ddd; background: #f4f4f4; }
	.denah-wrap svg { display: block; width: 100%; min-width: 600px; height: auto; }
	.rm-name { font-size: 20px; font-weight: bold; fill: #333; }
	.rm-sub  { font-size: 12px; fill: #666; }
	.rm-stat { font-size: 13px; font-weight: bold; }
	.legend span { display: inline-block; margin-right: 14px; color: #666; }
	.legend i { display: inline-block; width: 14px; height: 14px; border: 1px solid #555; vertical-align: -2px; margin-right: 5px; }
	.tl { position: relative; height: 26px; background: #dff0d8; border: 1px solid #ccc; overflow: hidden; }
	.tl div { position: absolute; top: 0; bottom: 0; }
	.tl .blk { background: #a94442; }
	.tl .win { border: 2px solid #3c8dbc; background: rgba(60,141,188,.25); }
	.tl-jam { font-size: 11px; color: #777; margin-bottom: 12px; }
	.tl-jam span { display: inline-block; width: 24%; }
  </style>
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="content">
  <div class="box">
    <section class="content-header"><h1>Room Booking <small><?php echo rb_h($center_list[$kd_cbg]); ?></small></h1></section>
    <section class="content">

      <form method="get" class="form-inline" style="margin-bottom:15px;">
        <input type="hidden" name="id_room" value="<?php echo e($id_room); ?>">
        <div class="form-group" style="margin-right:10px;">
          <label>Branch</label>
          <select class="form-control" name="kd_cbg">
<?php foreach ($center_list as $kd => $nm) { ?>
            <option value="<?php echo e($kd); ?>" <?php echo e(($kd_cbg == $kd) ? 'selected' : ''); ?>><?php echo e($nm); ?></option>
<?php } ?>
          </select>
        </div>
        <div class="form-group" style="margin-right:10px;">
          <label>Tanggal</label>
          <a class="btn btn-default" href="<?php echo rb_h(rb_url(array('tgl' => date('Y-m-d', strtotime("$tgl -1 day"))))); ?>">&lsaquo;</a>
          <input type="date" class="form-control" name="tgl" value="<?php echo e($tgl); ?>">
          <a class="btn btn-default" href="<?php echo rb_h(rb_url(array('tgl' => date('Y-m-d', strtotime("$tgl +1 day"))))); ?>">&rsaquo;</a>
        </div>
        <div class="form-group" style="margin-right:10px;">
          <label>Jam Mulai</label>
          <select class="form-control" name="jam_mulai">
<?php foreach ($jam_list as $j) { if ($j == rb_hm(num($JAM_TUTUP) * 60)) { continue; } ?>
            <option <?php echo e(($jam_mulai == $j) ? 'selected' : ''); ?>><?php echo e($j); ?></option>
<?php } ?>
          </select>
        </div>
        <div class="form-group" style="margin-right:10px;">
          <label>Jam Selesai</label>
          <select class="form-control" name="jam_selesai">
<?php foreach ($jam_list as $j) { if ($j == rb_hm(num($JAM_BUKA) * 60)) { continue; } ?>
            <option <?php echo e(($jam_selesai == $j) ? 'selected' : ''); ?>><?php echo e($j); ?></option>
<?php } ?>
          </select>
        </div>
        <button type="submit" class="btn btn-primary">Tampilkan</button>
        <a class="btn btn-default" href="vip_room_master.php?kd_cbg=<?php echo urlencode($kd_cbg); ?>">Master Room</a>
      </form>

<?php if (isset($msg_list[$msg_kode])) { ?>
      <div class="alert alert-<?php echo e($msg_list[$msg_kode][0]); ?>"><?php echo rb_h($msg_list[$msg_kode][1]); ?></div>
<?php } ?>

      <div class="row">
        <!-- ================= DENAH ================= -->
        <div class="col-md-8">
          <p class="legend">
            <b>Denah <?php echo date("d M Y", strtotime($tgl)); ?>, <?php echo e($jam_mulai) . " - " . e($jam_selesai); ?></b> &nbsp;
            <span><i style="background:#dff0d8;"></i>Tersedia</span>
            <span><i style="background:#f2dede;"></i>Terpakai</span>
          </p>
<?php if (cnt($rooms) == 0) { ?>
          <div class="alert alert-warning">Belum ada ruangan untuk cabang ini. Tambahkan dulu di <a href="vip_room_master.php?kd_cbg=<?php echo urlencode($kd_cbg); ?>">Master Room</a>.</div>
<?php } else { ?>
          <div class="denah-wrap">
            <svg viewBox="0 0 800 <?php echo e($denah_h); ?>" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
              <defs>
                <pattern id="arsir" width="8" height="8" patternUnits="userSpaceOnUse" patternTransform="rotate(45)">
                  <line x1="0" y1="0" x2="0" y2="8" stroke="#a94442" stroke-width="1.5" opacity=".4"/>
                </pattern>
              </defs>
<?php
	foreach ($rooms as $r) {
		// cari booking ruangan ini yang beririsan dengan jam terpilih
		$kena = array();
		if (isset($per_room[$r['id_room']])) {
			foreach ($per_room[$r['id_room']] as $b) {
				if ($b['jam1'] < $jam_selesai && $b['jam2'] > $jam_mulai) { $kena[] = $b; }
			}
		}
		$terpakai = cnt($kena) > 0;
		$x = intval($r['pos_x']); $y = intval($r['pos_y']); $w = intval($r['pos_w']); $h = intval($r['pos_h']);
		$fill  = $terpakai ? '#f2dede' : '#dff0d8';
		$warna = $terpakai ? '#a94442' : '#3c763d';
		$link  = rb_h(rb_url(array('id_room' => $r['id_room'], 'msg' => '')));
		$sub   = trim($r['room_type'] . (num($r['capacity']) > 0 ? ', ' . $r['capacity'] . ' org' : ''), ', ');

		echo "<a xlink:href=\"" . e($link) . "\" href=\"" . e($link) . "\">";
		echo "<rect x='" . e($x) . "' y='" . e($y) . "' width='" . e($w) . "' height='" . e($h) . "' fill='" . e($fill) . "' stroke='#444' stroke-width='3'/>";
		if ($terpakai) { echo "<rect x='" . e($x) . "' y='" . e($y) . "' width='" . e($w) . "' height='" . e($h) . "' fill='url(#arsir)'/>"; }
		if ($r['id_room'] == $id_room) {
			echo "<rect x='" . e((num($x) + 5)) . "' y='" . e((num($y) + 5)) . "' width='" . e((num($w) - 10)) . "' height='" . e((num($h) - 10)) . "' fill='none' stroke='#3c8dbc' stroke-width='4'/>";
		}
		echo "<text class='rm-name' x='" . e((num($x) + 14)) . "' y='" . e((num($y) + 34)) . "'>" . rb_h($r['room_name']) . "</text>";
		echo "<text class='rm-sub' x='" . e((num($x) + 14)) . "' y='" . e((num($y) + 52)) . "'>" . rb_h($sub) . "</text>";
		echo "<text class='rm-stat' fill='" . e($warna) . "' x='" . e((num($x) + 14)) . "' y='" . e((num($y) + num($h) - 30)) . "'>" . e(($terpakai ? 'Terpakai' : 'Tersedia')) . "</text>";
		if ($terpakai) {
			$ket = $kena[0]['jam1'] . ' - ' . $kena[0]['jam2'] . (cnt($kena) > 1 ? ' +' . (cnt($kena) - 1) : '');
			echo "<text class='rm-sub' style='fill:" . e($warna) . "' x='" . e((num($x) + 14)) . "' y='" . e((num($y) + num($h) - 13)) . "'>" . rb_h($ket) . "</text>";
		}
		echo "</a>\n";
	}
?>
            </svg>
          </div>
<?php } ?>
        </div>

        <!-- ================= PANEL RUANGAN ================= -->
        <div class="col-md-4">
<?php if (!$room_pilih) { ?>
          <h4>Pilih ruangan</h4>
          <p style="color:#777;">Klik salah satu ruangan di denah untuk melihat jadwalnya dan membuat booking.</p>
<?php } else {
	$total = num((num($JAM_TUTUP) - num($JAM_BUKA))) * 60;
	$awal  = num($JAM_BUKA) * 60;
?>
          <h4><?php echo rb_h(trim($room_pilih['room_type'] . ' ' . $room_pilih['room_name'])); ?></h4>
          <p style="color:#777;">
            <?php if (num($room_pilih['capacity']) > 0) { echo 'Kapasitas ' . intval($room_pilih['capacity']) . ' orang. '; } ?>
            <?php echo rb_h($room_pilih['facility']); ?>
          </p>
          <div class="tl">
<?php
	if (isset($per_room[$id_room])) {
		foreach ($per_room[$id_room] as $b) {
			$a = max($awal, rb_min($b['jam1'])); $z = min(num($awal) + num($total), rb_min($b['jam2']));
			if ($z > $a) {
				echo "<div class='blk' title='" . rb_h($b['jam1'] . ' - ' . $b['jam2'] . ' ' . $b['booked_by']) . "' style='left:" . round(div((num($a) - num($awal)), $total) * 100, 2) . "%;width:" . round(div((num($z) - num($a)), $total) * 100, 2) . "%'></div>";
			}
		}
	}
	$a = rb_min($jam_mulai); $z = rb_min($jam_selesai);
	echo "<div class='win' style='left:" . round(div((num($a) - num($awal)), $total) * 100, 2) . "%;width:" . round(div((num($z) - num($a)), $total) * 100, 2) . "%'></div>";
?>
          </div>
          <div class="tl-jam">
<?php for ($i = 0; num($i) < 4; $i++) { echo "<span>" . e(rb_hm(num($awal) + num($total) / 4 * num($i))) . "</span>"; } ?>
          </div>

          <form method="post" action="<?php echo rb_h(rb_url(array('msg' => ''))); ?>"><?php echo csrf_field(); ?>

            <input type="hidden" name="act" value="book">
            <input type="hidden" name="id_room" value="<?php echo e($id_room); ?>">
            <div class="form-group">
              <label>Nama Pemesan</label>
              <input type="text" class="form-control" name="nama" maxlength="60" value="<?php echo rb_h($user_login); ?>" required>
            </div>
            <div class="form-group">
              <label>Keperluan</label>
              <input type="text" class="form-control" name="keperluan" maxlength="150" placeholder="Contoh: placement test, meeting SC">
            </div>
            <button type="submit" class="btn btn-primary btn-block">Booking <?php echo rb_h($room_pilih['room_name']) . " " . e($jam_mulai) . " - " . e($jam_selesai); ?></button>
          </form>
<?php } ?>
        </div>
      </div>

      <!-- ================= DAFTAR BOOKING ================= -->
      <h4 style="margin-top:25px;">Daftar Booking <?php echo date("d M Y", strtotime($tgl)); ?></h4>
      <table class="table table-bordered table-condensed">
        <thead>
          <tr><th style="width:110px;">Jam</th><th>Ruangan</th><th>Pemesan</th><th>Keperluan</th><th style="width:90px;"></th></tr>
        </thead>
        <tbody>
<?php
if (cnt($bookings) == 0) {
	echo "<tr><td colspan='5'>Belum ada booking pada tanggal ini. Pilih ruangan di denah untuk membuat yang pertama.</td></tr>";
}
foreach ($bookings as $b) {
	$nm_room = isset($rooms[$b['id_room']]) ? $rooms[$b['id_room']]['room_name'] : '#' . $b['id_room'];
	echo "<tr>";
	echo "<td>" . e($b['jam1']) . " - " . e($b['jam2']) . "</td>";
	echo "<td>" . rb_h($nm_room) . "</td>";
	echo "<td>" . rb_h($b['booked_by']) . "</td>";
	echo "<td>" . rb_h($b['purpose']) . "</td>";
	echo "<td><form method='post' action='" . rb_h(rb_url(array('msg' => ''))) . "' style='margin:0;' onsubmit=\"return confirm('Batalkan booking ini?');\">"
		. "<input type='hidden' name='act' value='cancel'>"
		. "<input type='hidden' name='id_booking' value='" . intval($b['id_booking']) . "'>"
		. "<button type='submit' class='btn btn-xs btn-danger'>Batalkan</button></form></td>";
	echo "</tr>";
}
?>
        </tbody>
      </table>

    </section>
  </div>
</div>
</body>
</html>
