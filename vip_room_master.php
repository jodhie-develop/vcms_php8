<?php
require_once __DIR__ . "/_lib/bootstrap.php"; csrf_guard_get(); auth_require_login();

include __DIR__ . "/conndb.php";
include __DIR__ . "/profiledata.php";

/* ============================================================
   MASTER ROOM (per cabang)
   - Tambah / ubah ruangan, aktif / nonaktif
   - Atur denah: geser kotak ruangan dengan mouse, lalu "Simpan Posisi Denah"
   Tabel: ves_data.vip_room
   Semua POST diproses SEBELUM ada output, lalu redirect.
   ============================================================ */

$T_ROOM = q_set($__p_T_ROOM, "ves_data.vip_room");

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
function rb_batas($v, $min, $max) { $v = intval($v); if ($v < $min) { return $min; } if ($v > $max) { return $max; } return $v; }

$kd_cbg = isset($_GET['kd_cbg']) ? in_val('kd_cbg', 'get') : '1';
if (!isset($center_list[$kd_cbg])) { $kd_cbg = '1'; }
$kd_cbg_sql = $kd_cbg;
$self = basename($_SERVER['PHP_SELF']) . '?kd_cbg=' . urlencode($kd_cbg);

// ---- Proses POST ----
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$act = isset($_POST['act']) ? in_val('act', 'post') : '';
	$msg = 'gagal';

	if ($act == 'save') {
		$p_id   = isset($_POST['id_room']) ? intval(in_val('id_room', 'post')) : 0;
		$nama   = isset($_POST['room_name']) ? trim(in_val('room_name', 'post')) : '';
		$tipe   = substr(trim(isset($_POST['room_type']) ? in_val('room_type', 'post') : ''), 0, 30);
		$fas    = substr(trim(isset($_POST['facility']) ? in_val('facility', 'post') : ''), 0, 150);
		$kap    = rb_batas(isset($_POST['capacity']) ? in_val('capacity', 'post') : 0, 0, 9999);
		$w      = rb_batas(isset($_POST['pos_w']) ? in_val('pos_w', 'post') : 190, 80, 780);
		$h      = rb_batas(isset($_POST['pos_h']) ? in_val('pos_h', 'post') : 150, 80, 600);
		if ($nama == '') {
			$msg = 'nama';
		} else {
			$nama_sql = substr($nama, 0, 50);
			if (num($p_id) > 0) {
				$ok = db_query_soft("UPDATE " . $T_ROOM . " SET room_name = ? , room_type = ? , capacity = ? , facility = ? , pos_w = ? , pos_h = ? \r
\t\t\t\t\tWHERE id_room = ?  AND kd_branch = ? ", [...($__p_T_ROOM ?? []), (string) ($nama_sql), (string) ($tipe), (string) ($kap), (string) ($fas), (string) ($w), (string) ($h), (string) ($p_id), (string) ($kd_cbg_sql)]);
			} else {
				// ruangan baru ditaruh di bawah ruangan yang sudah ada, supaya tidak menumpuk
				$y = 10;
				$rs = db_query_soft("SELECT MAX(pos_y + pos_h) FROM " . $T_ROOM . " WHERE kd_branch = ? AND status = 'ACTIVE'", [...($__p_T_ROOM ?? []), (string) ($kd_cbg_sql)]);
				if ($rs && ($ry = db_fetch($rs, PDO::FETCH_NUM)) && $ry[0] !== null) { $y = intval($ry[0]) + 10; }
				$ok = db_query_soft("INSERT INTO " . $T_ROOM . " (kd_branch, room_name, room_type, capacity, facility, pos_x, pos_y, pos_w, pos_h, status)\r
\t\t\t\t\tVALUES (? , ? , ? , ? , ? , 10, ? , ? , ? , 'ACTIVE')", [...($__p_T_ROOM ?? []), (string) ($kd_cbg_sql), (string) ($nama_sql), (string) ($tipe), (string) ($kap), (string) ($fas), (string) ($y), (string) ($w), (string) ($h)]);
			}
			$msg = $ok ? 'ok' : 'gagal';
		}
	} elseif ($act == 'status') {
		$p_id = isset($_POST['id_room']) ? intval(in_val('id_room', 'post')) : 0;
		$st   = (isset($_POST['status']) && in_val('status', 'post') == 'ACTIVE') ? 'ACTIVE' : 'INACTIVE';
		$ok   = db_query_soft("UPDATE " . $T_ROOM . " SET status = ? WHERE id_room = ?  AND kd_branch = ? ", [...($__p_T_ROOM ?? []), (string) ($st), (string) ($p_id), (string) ($kd_cbg_sql)]);
		$msg  = $ok ? 'ok' : 'gagal';
	} elseif ($act == 'pos') {
		// format: id:x:y;id:x:y;...
		$ok = true;
		$list = explode(';', isset($_POST['pos']) ? in_val('pos', 'post') : '');
		foreach ($list as $item) {
			$p = explode(':', $item);
			if (cnt($p) != 3) { continue; }
			$pid = intval($p[0]); $px = rb_batas($p[1], 0, 800); $py = rb_batas($p[2], 0, 5000);
			if (!db_query_soft("UPDATE " . $T_ROOM . " SET pos_x = ? , pos_y = ?  WHERE id_room = ?  AND kd_branch = ? ", [...($__p_T_ROOM ?? []), (string) ($px), (string) ($py), (string) ($pid), (string) ($kd_cbg_sql)])) { $ok = false; }
		}
		$msg = $ok ? 'pos' : 'gagal';
	}

	header("Location: $self&msg=$msg");
	exit;
}

$msg_list = array(
	'ok'    => array('success', 'Data ruangan disimpan.'),
	'pos'   => array('success', 'Posisi denah disimpan.'),
	'nama'  => array('danger',  'Isi nama ruangan dulu.'),
	'gagal' => array('danger',  'Gagal menyimpan: ' . ''),
);
$msg_kode = isset($_GET['msg']) ? in_val('msg', 'get') : '';

// ---- Data ruangan cabang ini ----
$rooms = array();
$res = db_query_or_die("Query gagal: " . '', "SELECT id_room, room_name, room_type, capacity, facility, pos_x, pos_y, pos_w, pos_h, status\r
\tFROM " . $T_ROOM . " WHERE kd_branch = ? ORDER BY status, room_name", [...($__p_T_ROOM ?? []), (string) ($kd_cbg_sql)]);
$denah_h = 300;
while ($r = db_fetch($res, PDO::FETCH_ASSOC)) {
	$rooms[$r['id_room']] = $r;
	if ($r['status'] == 'ACTIVE') { $denah_h = max($denah_h, num($r['pos_y']) + num($r['pos_h']) + 10); }
}
$denah_h = num($denah_h) + num((170)); // ruang kosong di bawah untuk menggeser

// ---- Mode edit ----
$edit_id = isset($_GET['edit']) ? intval(in_val('edit', 'get')) : 0;
$f = array('id_room' => 0, 'room_name' => '', 'room_type' => '', 'capacity' => '', 'facility' => '', 'pos_w' => 190, 'pos_h' => 150);
if (isset($rooms[$edit_id])) { $f = $rooms[$edit_id]; }
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Master Room</title>
  <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
  <link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">
  <style>
	.denah-wrap { overflow-x: auto; border: 1px solid #ddd; background: #f4f4f4; }
	.denah-wrap svg { display: block; width: 100%; min-width: 600px; height: auto; }
	.rm { cursor: move; }
	.rm text { font-size: 18px; font-weight: bold; fill: #333; pointer-events: none; -webkit-user-select: none; user-select: none; }
  </style>
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="content">
  <div class="box">
    <section class="content-header"><h1>Master Room <small><?php echo rb_h($center_list[$kd_cbg]); ?></small></h1></section>
    <section class="content">

      <form method="get" class="form-inline" style="margin-bottom:15px;">
        <div class="form-group" style="margin-right:10px;">
          <label>Branch</label>
          <select class="form-control" name="kd_cbg" onchange="this.form.submit();">
<?php foreach ($center_list as $kd => $nm) { ?>
            <option value="<?php echo e($kd); ?>" <?php echo e(($kd_cbg == $kd) ? 'selected' : ''); ?>><?php echo e($nm); ?></option>
<?php } ?>
          </select>
        </div>
        <a class="btn btn-default" href="vip_room_book.php?kd_cbg=<?php echo urlencode($kd_cbg); ?>">Ke Room Booking</a>
      </form>

<?php if (isset($msg_list[$msg_kode])) { ?>
      <div class="alert alert-<?php echo e($msg_list[$msg_kode][0]); ?>"><?php echo rb_h($msg_list[$msg_kode][1]); ?></div>
<?php } ?>

      <div class="row">
        <!-- ================= FORM ================= -->
        <div class="col-md-4">
          <h4><?php echo e($f['id_room'] ? 'Ubah Ruangan' : 'Tambah Ruangan'); ?></h4>
          <form method="post" action="<?php echo rb_h($self); ?>"><?php echo csrf_field(); ?>

            <input type="hidden" name="act" value="save">
            <input type="hidden" name="id_room" value="<?php echo intval($f['id_room']); ?>">
            <div class="form-group">
              <label>Nama Ruangan</label>
              <input type="text" class="form-control" name="room_name" maxlength="50" value="<?php echo rb_h($f['room_name']); ?>" required>
            </div>
            <div class="form-group">
              <label>Tipe</label>
              <input type="text" class="form-control" name="room_type" maxlength="30" value="<?php echo rb_h($f['room_type']); ?>" placeholder="Classroom / Meeting Room / Aula">
            </div>
            <div class="form-group">
              <label>Kapasitas (orang)</label>
              <input type="number" class="form-control" name="capacity" min="0" value="<?php echo rb_h($f['capacity']); ?>">
            </div>
            <div class="form-group">
              <label>Fasilitas</label>
              <input type="text" class="form-control" name="facility" maxlength="150" value="<?php echo rb_h($f['facility']); ?>" placeholder="TV, proyektor, papan tulis">
            </div>
            <div class="row">
              <div class="col-xs-6 form-group">
                <label>Lebar di denah</label>
                <input type="number" class="form-control" name="pos_w" min="80" max="780" step="10" value="<?php echo intval($f['pos_w']); ?>">
              </div>
              <div class="col-xs-6 form-group">
                <label>Tinggi di denah</label>
                <input type="number" class="form-control" name="pos_h" min="80" max="600" step="10" value="<?php echo intval($f['pos_h']); ?>">
              </div>
            </div>
            <p style="color:#777;">Lebar penuh denah = 800.</p>
            <button type="submit" class="btn btn-primary">Simpan Ruangan</button>
<?php if ($f['id_room']) { ?>
            <a class="btn btn-default" href="<?php echo rb_h($self); ?>">Batal</a>
<?php } ?>
          </form>
        </div>

        <!-- ================= DENAH ================= -->
        <div class="col-md-8">
          <h4>Denah</h4>
          <p style="color:#777;">Geser kotak ruangan ke posisinya, lalu simpan.</p>
          <div class="denah-wrap">
            <svg id="denah" viewBox="0 0 800 <?php echo e($denah_h); ?>" xmlns="http://www.w3.org/2000/svg">
<?php
foreach ($rooms as $r) {
	if ($r['status'] != 'ACTIVE') { continue; }
	$x = intval($r['pos_x']); $y = intval($r['pos_y']); $w = intval($r['pos_w']); $h = intval($r['pos_h']);
	echo "<g class='rm' data-id='" . intval($r['id_room']) . "' data-x='" . e($x) . "' data-y='" . e($y) . "' data-w='" . e($w) . "' data-h='" . e($h) . "' transform='translate(" . e($x) . "," . e($y) . ")'>";
	echo "<rect width='" . e($w) . "' height='" . e($h) . "' fill='#d9edf7' stroke='#444' stroke-width='3'/>";
	echo "<text x='14' y='32'>" . rb_h($r['room_name']) . "</text>";
	echo "</g>\n";
}
?>
            </svg>
          </div>
          <form method="post" action="<?php echo rb_h($self); ?>" style="margin-top:10px;" onsubmit="return kumpulkanPosisi();"><?php echo csrf_field(); ?>

            <input type="hidden" name="act" value="pos">
            <input type="hidden" name="pos" id="pos">
            <button type="submit" class="btn btn-success">Simpan Posisi Denah</button>
          </form>
        </div>
      </div>

      <!-- ================= DAFTAR ================= -->
      <h4 style="margin-top:25px;">Daftar Ruangan</h4>
      <table class="table table-bordered table-condensed">
        <thead>
          <tr><th>Nama</th><th>Tipe</th><th>Kapasitas</th><th>Fasilitas</th><th>Status</th><th style="width:170px;"></th></tr>
        </thead>
        <tbody>
<?php
if (cnt($rooms) == 0) {
	echo "<tr><td colspan='6'>Belum ada ruangan untuk cabang ini. Isi form Tambah Ruangan di atas.</td></tr>";
}
foreach ($rooms as $r) {
	$aktif = ($r['status'] == 'ACTIVE');
	echo "<tr" . e(($aktif ? "" : " style='color:#999;'")) . ">";
	echo "<td>" . rb_h($r['room_name']) . "</td>";
	echo "<td>" . rb_h($r['room_type']) . "</td>";
	echo "<td>" . intval($r['capacity']) . "</td>";
	echo "<td>" . rb_h($r['facility']) . "</td>";
	echo "<td>" . e(($aktif ? 'Aktif' : 'Nonaktif')) . "</td>";
	echo "<td><form method='post' action='" . rb_h($self) . "' style='margin:0;'>"
		. "<a class='btn btn-xs btn-default' href='" . rb_h($self . '&edit=' . intval($r['id_room'])) . "'>Ubah</a> "
		. "<input type='hidden' name='act' value='status'>"
		. "<input type='hidden' name='id_room' value='" . intval($r['id_room']) . "'>"
		. "<input type='hidden' name='status' value='" . e(($aktif ? 'INACTIVE' : 'ACTIVE')) . "'>"
		. "<button type='submit' class='btn btn-xs " . e(($aktif ? 'btn-warning' : 'btn-success')) . "'>" . e(($aktif ? 'Nonaktifkan' : 'Aktifkan')) . "</button>"
		. "</form></td>";
	echo "</tr>";
}
?>
        </tbody>
      </table>

    </section>
  </div>
</div>

<script>
// ---- Geser kotak ruangan di denah (kelipatan 10) ----
var svg = document.getElementById('denah'), geser = null;
var tinggiDenah = <?php echo intval($denah_h); ?>;

function titik(e) {
	var s = e.touches ? e.touches[0] : e;
	var p = svg.createSVGPoint();
	p.x = s.clientX; p.y = s.clientY;
	return p.matrixTransform(svg.getScreenCTM().inverse());
}
function mulai(e) {
	var g = e.target;
	while (g && g !== svg && !(g.getAttribute && g.getAttribute('class') === 'rm')) { g = g.parentNode; }
	if (!g || g === svg) { return; }
	var p = titik(e);
	geser = { g: g, dx: p.x - parseInt(g.getAttribute('data-x'), 10), dy: p.y - parseInt(g.getAttribute('data-y'), 10) };
	svg.appendChild(g); // bawa ke depan
	e.preventDefault();
}
function gerak(e) {
	if (!geser) { return; }
	var p = titik(e), g = geser.g;
	var w = parseInt(g.getAttribute('data-w'), 10), h = parseInt(g.getAttribute('data-h'), 10);
	var x = Math.round((p.x - geser.dx) / 10) * 10, y = Math.round((p.y - geser.dy) / 10) * 10;
	x = Math.max(0, Math.min(800 - w, x));
	y = Math.max(0, Math.min(tinggiDenah - h, y));
	g.setAttribute('data-x', x); g.setAttribute('data-y', y);
	g.setAttribute('transform', 'translate(' + x + ',' + y + ')');
	e.preventDefault();
}
function selesai() { geser = null; }

svg.addEventListener('mousedown', mulai);
document.addEventListener('mousemove', gerak);
document.addEventListener('mouseup', selesai);
svg.addEventListener('touchstart', mulai, { passive: false });
svg.addEventListener('touchmove', gerak, { passive: false });
document.addEventListener('touchend', selesai);

function kumpulkanPosisi() {
	var gs = svg.querySelectorAll('g.rm'), out = [];
	for (var i = 0; i < gs.length; i++) {
		out.push(gs[i].getAttribute('data-id') + ':' + gs[i].getAttribute('data-x') + ':' + gs[i].getAttribute('data-y'));
	}
	document.getElementById('pos').value = out.join(';');
	return true;
}
</script>
</body>
</html>
