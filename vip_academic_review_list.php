<?php
require_once __DIR__ . "/_lib/bootstrap.php"; auth_require_login('json');
/* ============================================================
   STUDENT ACADEMIC REVIEW - LIST (PWA)

   Halaman ini DIBUKA STANDALONE (tanpa include atas.php / left.php)
   -- atas.php & left.php di codebase ini masing-masing punya
   <!DOCTYPE html><head>...<body> sendiri yg lengkap, jadi kalau
   di-include di sini hasilnya 3 dokumen HTML numpuk jadi 1 respons.
   Itu yg bikin: (1) tag <link rel="manifest"> tidak kebaca browser
   (karena <head> milik file ini dianggap tidak sah), dan (2) area
   kosong hitam di kiri + style berantakan (class AdminLTE
   "sidebar-mini skin-blue" + div "wrapper"/"content-wrapper"
   didesain utk SELALU ada sidebar fisik dari left.php; begitu
   left.php di-skip, CSS-nya tetap mengira ada sidebar & nyisain
   ruang kosong). Makanya di file ini layout dibuat polos/mandiri
   (top bar sendiri, tanpa div wrapper/sidebar AdminLTE), supaya
   rapi & PWA-nya valid.

   Kalau nanti mau "nempel" lagi ke menu utama V-CMS, cukup tambah
   link manual (lihat tombol "Buka V-CMS" di top bar).

   Fitur:
   - List review tersimpan: Kode Kelas, Nama Student, PT Score,
     Mid Test, Final Test, dan kolom Aksi berisi tombol "View" (buka vip_academic_review_print.php
     dalam mode lihat, tanpa langsung trigger print dialog).
   - Halaman ini KHUSUS utk menerima notifikasi & melihat hasil review
     (bukan utk input/edit review baru -- itu di vip_academic_review.php
     terpisah, diakses dari menu V-CMS biasa, bukan dari app ini).
   - Notifikasi (polling ~15 detik ke vip_academic_review_notif_api.php)
     -- bukan true Web Push (butuh VAPID/push server yg tdk tersedia
     di hosting ini), tapi notifikasi OS muncul selama PWA ini
     terbuka (foreground/background tab), jadi terasa seperti push.
   - Login gate: profiledata.php (yg tadinya dipakai utk cek status
     login) ternyata ikut mengeluarkan HTML tambahan (bikin dokumen
     HTML numpuk & area kosong gelap di kiri, sama kasusnya dgn
     atas.php/left.php), jadi TIDAK di-include di sini. Sebagai
     gantinya, status login dicek manual via $_SESSION['st_login'] --
     kalau belum login, data TIDAK di-query sama sekali & muncul popup
     login (lewat vip_academic_review_login_api.php, yg isinya adopsi
     logic login.php tapi "cek saja" -- tanpa nulis log aktivitas --
     dan dibatasi hanya utk 3 nama Academic Supervisor yg terdaftar).
   ============================================================ */
include __DIR__ . "/conndb.php";
include __DIR__ . "/vip_academic_review_auth.php";
include __DIR__ . "/left.php";
// Login = boleh buka list. Academic Supervisor (3 nama di auth.php) melihat
// SEMUA review; user lain hanya review yg dia input sendiri (kolom pic).
$is_logged_in  = ar_is_logged_in();
$is_supervisor = ar_is_supervisor();

$hari  = date("d");
$bulan = date("m");
$tahun = date("Y");
$hari_ini = "$tahun-$bulan-$hari";

$date_start = isset($_GET['date_start']) ? in_val('date_start', 'get') : '';
$date_end   = isset($_GET['date_end'])   ? in_val('date_end', 'get')   : '';
$cd_cl      = isset($_GET['cd_cl'])      ? trim(in_val('cd_cl', 'get')) : '';

if ($date_start == '') { $date_start = "$tahun-01-01"; }
if ($date_end   == '') { $date_end   = $hari_ini; }

$date_start_sql = $date_start;
$date_end_sql   = $date_end;

$where = q_set($__p_where, "r.created_at between ? and ? ", [(string) ($date_start_sql) . " 00:00:00", (string) ($date_end_sql) . " 23:59:59"]);
if ($cd_cl != '') {
	$cd_cl_sql = $cd_cl;
	$where .= q_add($__p_where, " and r.kd_class like ? ", ["%" . (string) ($cd_cl_sql) . "%"]);
}
if ($is_logged_in && !$is_supervisor) {
	$where .= q_add($__p_where, " and r.pic = ? ", [(string) (trim($_SESSION['nama_lengkap']))]);
}

// Ambil 1 baris terbaru per (kd_biodata, kd_class) -- supaya kalau
// sebuah review disimpan ulang (insert baru tiap Save), yang tampil
// di list cuma versi paling baru, tidak dobel-dobel.
// Query HANYA dijalankan kalau sudah login -- supaya data review tidak
// kebaca sama sekali sebelum lolos popup login.
$resource_list = false;
if ($is_logged_in) {
	$query_list = q_set($__p_query_list, "SELECT r.id, r.kd_class, r.nama_lengkap, r.placement_total, r.mid_total, r.final_total,\r
\t\t\tr.pic, r.created_at, r.kd_biodata, r.checked_by, r.checked_at\r
\t\tFROM ves_data.vip_academic_review r\r
\t\tINNER JOIN (\r
\t\t\tSELECT kd_biodata, kd_class, MAX(id) AS max_id\r
\t\t\tFROM ves_data.vip_academic_review\r
\t\t\tGROUP BY kd_biodata, kd_class\r
\t\t) latest ON r.id = latest.max_id\r
\t\tWHERE " . $where . "\r
\t\tORDER BY r.created_at DESC", [...($__p_where ?? [])]);
	$resource_list = db_query_or_die('', $query_list, $__p_query_list ?? []);
}

$current_user = $is_logged_in ? $_SESSION['nama_lengkap'] : '';
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Student Academic Review - List</title>
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

  <!-- ====== PWA ====== -->
  <link rel="manifest" href="manifest_academic_review.json">
  <meta name="theme-color" content="#3f7fd1">
  <meta name="mobile-web-app-capable" content="yes">
  <meta name="apple-mobile-web-app-capable" content="yes">
  <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
  <meta name="apple-mobile-web-app-title" content="Academic Review">
  <link rel="apple-touch-icon" href="icon-192.png">
  <link rel="icon" type="image/png" sizes="192x192" href="icon-192.png">

  <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
  <!-- Font Awesome dari CDN (bukan file lokal server) -- supaya icon
       tidak tampil kotak kosong kalau file font lokal di server lagi
       bermasalah/404. -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="plugins/datatables/dataTables.bootstrap.css">
  <style>
    :root { --brand:#3f7fd1; --brand-dark:#2f66ac; }
    body { background:#f4f6f9; font-family: "Source Sans Pro", Helvetica, Arial, sans-serif; margin:0; }

    .topbar {
      background: var(--brand); color:#fff; padding:12px 18px;
      display:flex; align-items:center; justify-content:space-between;
      box-shadow:0 1px 4px rgba(0,0,0,.15); position:sticky; top:0; z-index:20;
    }
    .topbar .title { font-size:18px; font-weight:600; margin:0; }
    .topbar .title small { font-weight:400; opacity:.85; font-size:13px; margin-left:6px; }
    .topbar .actions { display:flex; align-items:center; gap:10px; }
    .topbar .icon-btn {
      background:rgba(255,255,255,.15); border:none; color:#fff; border-radius:6px;
      padding:7px 10px; cursor:pointer; position:relative; font-size:15px; line-height:1;
    }
    .topbar .icon-btn:hover { background:rgba(255,255,255,.28); }
    .bell-badge {
      position:absolute; top:-6px; right:-6px; background:#e74c3c; color:#fff;
      border-radius:999px; font-size:10px; min-width:16px; height:16px; line-height:16px;
      text-align:center; padding:0 3px; font-weight:700;
    }

    .page-wrap { max-width:1200px; margin:0 auto; padding:18px 18px 40px; }
    .filter-box { border:1px solid #e3e8ef; border-radius:8px; padding:16px 18px; margin-bottom:16px; background:#fff; }
    .box { background:#fff; border-radius:8px; border:1px solid #e3e8ef; }
    .box-body { padding:16px; }

    .score-pill { display:inline-block; min-width:34px; padding:2px 6px; border-radius:4px; background:#eef3fb; font-weight:600; text-align:center; }
    .score-pill.empty { background:#f5f5f5; color:#aaa; font-weight:400; }

    .btn-check { background:#fff8e1; border:1px solid #f1c40f; color:#8a6d00; border-radius:4px; padding:3px 9px; font-size:12px; cursor:pointer; }
    .btn-check:hover { background:#fff3cd; }
    .checked-badge { display:block; font-size:12px; }
    .checked-badge .name { font-weight:600; color:#1e824c; }
    .checked-badge .time { color:#888; font-size:11px; }

    #toast-wrap { position:fixed; right:16px; bottom:16px; z-index:9999; display:flex; flex-direction:column; gap:8px; }
    .toast-notif {
      background:#263445; color:#fff; padding:12px 16px; border-radius:8px; max-width:320px;
      box-shadow:0 4px 14px rgba(0,0,0,.25); font-size:13px; animation:toast-in .25s ease-out;
    }
    @keyframes toast-in { from { transform:translateY(10px); opacity:0; } to { transform:translateY(0); opacity:1; } }

    table.dataTable { font-size:13px; }
    @media (max-width: 700px) {
      .page-wrap { padding:12px; }
      .topbar .title small { display:block; margin-left:0; }
    }

    /* ====== Popup Login ====== */
    #loginOverlay {
      position:fixed; inset:0; background:rgba(20,30,45,.72);
      display:flex; align-items:center; justify-content:center; z-index:9998;
      padding:16px;
    }
    .login-card {
      background:#fff; border-radius:10px; padding:28px 26px; width:100%; max-width:340px;
      box-shadow:0 10px 30px rgba(0,0,0,.25);
    }
    .login-card h3 { margin:0 0 4px; font-size:19px; }
    .login-card p.sub { margin:0 0 18px; color:#777; font-size:13px; }
    .login-card .form-group { margin-bottom:12px; }
    .login-card .error-msg { color:#c0392b; font-size:12.5px; margin-bottom:10px; min-height:16px; }
    .login-card button[type="submit"] { width:100%; }
  </style>
</head>
<body>

<div class="topbar">
  <div class="title">Student Academic Review <small>List</small></div>
  <div class="actions">
    <button id="notifPermBtn" class="icon-btn" title="Aktifkan Notifikasi" style="display:none;">
      <i class="fa fa-bell-o"></i>
    </button>
    <button id="bellBtn" class="icon-btn" title="Notifikasi">
      <i class="fa fa-bell"></i>
      <span id="bellBadge" class="bell-badge" style="display:none;">0</span>
    </button>
    <button id="installBtn" class="icon-btn" style="display:none;" title="Install App">
      <i class="fa fa-download"></i>
    </button>
    <a href="vip_academic_review_dashboard.php" class="icon-btn" style="text-decoration:none;" title="Kembali ke Dashboard">
      <i class="fa fa-home"></i>
    </a>
    <a href="vip_class_list.php" class="icon-btn" style="text-decoration:none;" title="Buka menu V-CMS">
      <i class="fa fa-th-large"></i>
    </a>
  </div>
</div>

<div class="page-wrap">

  <?php if (isset($_GET['saved']) && (in_val('saved', 'get') == '1' || in_val('saved', 'get') == '2')) { ?>
  <div class="alert alert-success" style="margin-bottom:12px;">
    <?php echo e(in_val('saved', 'get') == '2' ? 'Review berhasil diperbarui (update).' : 'Review berhasil disimpan.'); ?>
  </div>
  <?php } ?>

  <form method="get" action="vip_academic_review_list.php" class="filter-box">
    <div class="row">
      <div class="col-sm-3">
        <label><small>Periode (disimpan tgl)</small></label>
        <input type="date" class="form-control" name="date_start" value="<?php echo htmlspecialchars($date_start); ?>">
      </div>
      <div class="col-sm-3">
        <label><small>&nbsp;</small></label>
        <input type="date" class="form-control" name="date_end" value="<?php echo htmlspecialchars($date_end); ?>">
      </div>
      <div class="col-sm-3">
        <label><small>Kode Kelas</small></label>
        <input type="text" class="form-control" name="cd_cl" placeholder="cth: FA-..." value="<?php echo htmlspecialchars($cd_cl); ?>">
      </div>
      <div class="col-sm-3">
        <label><small>&nbsp;</small></label><br>
        <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i> Tampilkan</button>
        <a href="vip_academic_review.php" class="btn btn-success"><i class="fa fa-plus"></i> Create</a>
      </div>
    </div>
  </form>

  <div class="box">
    <div class="box-body">
      <table id="tbl_review" class="table table-bordered table-striped" width="100%">
        <thead>
          <tr>
            <th>No</th>
            <th>Kode Kelas</th>
            <th>Nama Student</th>
            <th>PT Score</th>
            <th>Mid Test</th>
            <th>Final Test</th>
            <th>Tanggal</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
<?php
function score_pill($v) {
	if ($v === null || trim($v) === '') { return '<span class="score-pill empty">-</span>'; }
	return '<span class="score-pill">' . htmlspecialchars($v) . '</span>';
}

$no = 1;
if (!$resource_list || num(db_num_rows($resource_list)) == 0) {
	/* PENTING: jangan pakai <td colspan="8"> tunggal di sini -- DataTables
	   (versi yg dipakai di codebase ini) membaca jumlah <td> per baris utk
	   dicocokkan dgn jumlah <th> di thead (8). Baris dgn 1 <td> ber-colspan
	   dianggap baris data biasa yg "kurang kolom", bukan baris kosong
	   khusus -- makanya muncul "DataTables warning: Requested unknown
	   parameter '1' for row 0" (sama persis kasusnya dgn monthly_oc_report.php
	   yg sudah pernah diperbaiki sebelumnya). Solusinya: tetap keluarkan 9
	   <td> fisik, pesannya cukup ditaruh di <td> pertama.
	*/
	$empty_msg = 'Tidak ada data review untuk filter ini' . ($is_logged_in ? '' : ' (silakan login dulu)') . '.';
	echo '<tr>'
		. '<td class="text-center">' . e($empty_msg) . '</td>'
		. '<td></td><td></td><td></td><td></td><td></td><td></td><td></td>'
		. '</tr>';
} else {
	while ($row = db_fetch($resource_list, PDO::FETCH_NUM)) {
		$r_id         = $row[0];
		$r_kd_class   = $row[1];
		$r_nama       = $row[2];
		$r_plc        = $row[3];
		$r_mid        = $row[4];
		$r_fin        = $row[5];
		$r_pic        = $row[6];
		$r_created    = $row[7];
		$r_kd_biodata = $row[8];
		$r_checked_by = $row[9];
		$r_checked_at = $row[10];

		echo '<tr>';
		echo '<td>' . e($no) . '</td>';
		echo '<td>' . htmlspecialchars($r_kd_class) . '</td>';
		echo '<td>' . htmlspecialchars($r_nama) . '</td>';
		echo '<td class="text-center">' . e(score_pill($r_plc)) . '</td>';
		echo '<td class="text-center">' . e(score_pill($r_mid)) . '</td>';
		echo '<td class="text-center">' . e(score_pill($r_fin)) . '</td>';

		echo '<td>' . e(($r_created ? date('d M Y H:i', strtotime($r_created)) : '-')) . '</td>';
		echo '<td class="text-center">
				<a class="btn btn-xs btn-primary" title="Lihat detail review" target="_blank"
				   href="vip_academic_review_print.php?id=' . urlencode($r_id) . '&view=1">
				   <i class="fa fa-eye"></i> View
				</a>
			  </td>';
		echo '</tr>';
		$no++;
	}
}
?>
        </tbody>
      </table>
    </div>
  </div>

</div>

<div id="toast-wrap"></div>

<?php if (!$is_logged_in) { ?>
<div id="loginOverlay">
  <div class="login-card">
    <h3>Sign In</h3>
    <p class="sub">Login dengan akun V-CMS.</p>
    <div id="loginError" class="error-msg"></div>
    <form id="loginForm" onsubmit="return doLogin(event)">
      <div class="form-group">
        <input type="text" class="form-control" id="loginName" placeholder="User Login" autocomplete="username" required>
      </div>
      <div class="form-group">
        <input type="password" class="form-control" id="loginPassword" placeholder="Password" autocomplete="current-password" required>
      </div>
      <button type="submit" class="btn btn-primary" id="loginSubmitBtn">Sign In</button>
    </form>
  </div>
</div>
<?php } ?>

<script src="plugins/jQuery/jquery-2.2.3.min.js"></script>
<script src="bootstrap/js/bootstrap.min.js"></script>
<script src="plugins/datatables/jquery.dataTables.min.js"></script>
<script src="plugins/datatables/dataTables.bootstrap.min.js"></script>
<script>
  var CURRENT_USER = <?php echo json_encode($current_user); ?>;

  // ====== Popup Login ======
  // (hanya ada di DOM kalau $is_logged_in == false, lihat PHP di atas)
  function doLogin(e) {
    e.preventDefault();
    var btn = document.getElementById('loginSubmitBtn');
    var errEl = document.getElementById('loginError');
    var name = document.getElementById('loginName').value;
    var password = document.getElementById('loginPassword').value;
    errEl.textContent = '';
    btn.disabled = true;
    btn.textContent = 'Memeriksa...';
    fetch('vip_academic_review_login_api.php', {
      method: 'POST',
      headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
      body: 'name=' + encodeURIComponent(name) + '&password=' + encodeURIComponent(password)
    })
      .then(function (r) { return r.json(); })
      .then(function (data) {
        if (data.status === 'ok') {
          location.reload();
        } else {
          errEl.textContent = data.message || 'Login gagal.';
          btn.disabled = false;
          btn.textContent = 'Sign In';
        }
      })
      .catch(function () {
        errEl.textContent = 'Gagal menghubungi server.';
        btn.disabled = false;
        btn.textContent = 'Sign In';
      });
    return false;
  }

  $(function () {
    $('#tbl_review').DataTable({
      "paging": true,
      "lengthChange": true,
      "searching": true,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "order": []
    });
  });

  // ====== PWA: suntik tag manifest/icon/theme-color ke document.head ======
  // Dibutuhkan jaga-jaga kalau suatu saat file ini kembali dipakai dari
  // dalam include atas.php/left.php (lihat catatan panjang di komentar
  // PHP paling atas file ini). Di versi standalone ini sebenarnya <head>
  // sudah sah & manifest sudah kebaca langsung, tapi baris ini tetap
  // dibiarkan sbg pengaman tambahan (tidak merusak apa pun kalau dobel).
  (function () {
    if (document.querySelector('link[rel="manifest"]')) { return; }
    var l = document.createElement('link');
    l.rel = 'manifest';
    l.href = 'manifest_academic_review.json';
    document.head.appendChild(l);
  })();

  // ====== PWA: register service worker ======
  var swRegistration = null;
  if ('serviceWorker' in navigator) {
    window.addEventListener('load', function () {
      navigator.serviceWorker.register('sw_academic_review.js').then(function (reg) {
        swRegistration = reg;
      }).catch(function (err) {
        console.log('SW register gagal:', err);
      });
    });
  }

  // ====== Install App ======
  var deferredPrompt;
  var installBtn = document.getElementById('installBtn');
  window.addEventListener('beforeinstallprompt', function (e) {
    e.preventDefault();
    deferredPrompt = e;
    installBtn.style.display = 'inline-block';
  });
  installBtn.addEventListener('click', function () {
    installBtn.style.display = 'none';
    if (deferredPrompt) {
      deferredPrompt.prompt();
      deferredPrompt.userChoice.then(function () { deferredPrompt = null; });
    }
  });

  // ====== Notifikasi (polling, "push-style") ======
  // Catatan: ini BUKAN Web Push asli (butuh VAPID + push server, tidak
  // tersedia di hosting PHP legacy ini). Ini polling tiap 15 detik
  // selama halaman ini terbuka -- notifikasi OS tetap muncul walau tab
  // di-minimize, tapi tidak akan muncul kalau app/tab-nya ditutup total.
  var notifPermBtn = document.getElementById('notifPermBtn');
  var bellBtn = document.getElementById('bellBtn');
  var bellBadge = document.getElementById('bellBadge');

  function updateBellBadge(count) {
    if (count > 0) {
      bellBadge.style.display = 'inline-block';
      bellBadge.textContent = count > 9 ? '9+' : count;
    } else {
      bellBadge.style.display = 'none';
    }
  }

  function showToast(message) {
    var el = document.createElement('div');
    el.className = 'toast-notif';
    el.textContent = message;
    document.getElementById('toast-wrap').appendChild(el);
    setTimeout(function () { el.remove(); }, 6000);
  }

  function showOsNotification(message) {
    if (!('Notification' in window) || Notification.permission !== 'granted') { return; }
    var title = 'Student Academic Review';
    var opts = { body: message, icon: 'icon-192.png', badge: 'icon-192.png' };
    if (swRegistration) {
      swRegistration.showNotification(title, opts);
    } else {
      new Notification(title, opts);
    }
  }

  function refreshNotifUI() {
    if (!('Notification' in window)) { return; }
    if (Notification.permission === 'default') {
      notifPermBtn.style.display = 'inline-block';
    } else {
      notifPermBtn.style.display = 'none';
    }
  }
  refreshNotifUI();

  notifPermBtn.addEventListener('click', function () {
    Notification.requestPermission().then(function () { refreshNotifUI(); });
  });

  bellBtn.addEventListener('click', function () {
    if ('Notification' in window && Notification.permission === 'default') {
      Notification.requestPermission().then(function () { refreshNotifUI(); });
    }
  });

  function pollNotifications() {
    if (!CURRENT_USER) { return; }
    fetch('vip_academic_review_notif_api.php?action=check&user=' + encodeURIComponent(CURRENT_USER))
      .then(function (r) { return r.json(); })
      .then(function (data) {
        var list = data.notifications || [];
        list.forEach(function (n) {
          showToast(n.message);
          showOsNotification(n.message);
        });
        if (list.length > 0) { updateBellBadge(0); }
      })
      .catch(function () { /* diamkan kalau network error sesaat */ });
  }

  function loadInitialUnreadCount() {
    if (!CURRENT_USER) { return; }
    fetch('vip_academic_review_notif_api.php?action=unread_count&user=' + encodeURIComponent(CURRENT_USER))
      .then(function (r) { return r.json(); })
      .then(function (data) { updateBellBadge(data.count || 0); })
      .catch(function () {});
  }

  // Membuka list = notifikasi dianggap sudah dilihat -> badge di dashboard reset
  if (CURRENT_USER) {
    fetch('vip_academic_review_notif_api.php?action=mark_all_read').catch(function () {});
  }
  setInterval(pollNotifications, 15000);
</script>
</body>
</html>
