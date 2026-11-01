<?php
require_once __DIR__ . "/_lib/bootstrap.php"; auth_require_login('json');
/* ============================================================
   DASHBOARD - Student Academic Review (PWA)

   Halaman utama app (start_url PWA). Isinya menu-menu berupa tile;
   saat ini baru 1 menu: "Score Review" -> vip_academic_review_list.php.
   Notifikasi (push-style, polling 15 detik) ditampilkan sebagai badge
   angka di tile menu terkait, plus toast + notifikasi OS ketika ada
   notifikasi baru selama app terbuka.

   Menu baru nanti cukup ditambah 1 elemen di array $menus di bawah.

   Akses: HANYA 3 Academic Supervisor terdaftar (lihat
   vip_academic_review_auth.php). Selain itu muncul popup login.

   Seperti vip_academic_review_list.php, halaman ini STANDALONE:
   TIDAK meng-include atas.php / left.php / profiledata.php (ketiganya
   mengeluarkan dokumen HTML lengkap sendiri, bikin HTML numpuk dan
   manifest PWA tidak terbaca).
   ============================================================ */
include __DIR__ . "/conndb.php";
include __DIR__ . "/vip_academic_review_auth.php";

$is_logged_in = ar_is_logged_in();
$current_user = $is_logged_in ? $_SESSION['nama_lengkap'] : '';

$unread = 0;
if ($is_logged_in) {
	$res = db_query_soft("SELECT COUNT(*) FROM ves_data.vip_academic_review_notif\r
\t\tWHERE target_user = ? AND is_read = 0", [(string) ($current_user)]);
	if ($res) {
		$r = db_fetch($res, PDO::FETCH_NUM);
		$unread = (int) $r[0];
	}
}

// Daftar menu dashboard. 'badge_key' = nama sumber badge (saat ini cuma 'notif').
$menus = array(
	array(
		'title'     => 'Score Review',
		'desc'      => 'Daftar review, hasil, dan notifikasi baru',
		'icon'      => 'fa-bar-chart',
		'href'      => 'vip_academic_review_list.php',
		'badge_key' => 'notif',
	),
);
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Academic Review - Dashboard</title>
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
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
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

    .page-wrap { max-width:1000px; margin:0 auto; padding:22px 18px 40px; }
    .greeting { margin:0 0 18px; color:#445; }
    .greeting b { color:#222; }

    .menu-grid { display:grid; grid-template-columns:repeat(auto-fill, minmax(190px, 1fr)); gap:16px; }
    .menu-tile {
      display:block; position:relative; background:#fff; border:1px solid #e3e8ef; border-radius:12px;
      padding:24px 18px 20px; text-align:center; color:#263445; text-decoration:none;
      transition: transform .12s ease, box-shadow .12s ease;
    }
    .menu-tile:hover { transform:translateY(-2px); box-shadow:0 6px 16px rgba(30,60,110,.14); color:#263445; text-decoration:none; }
    .menu-tile .ico {
      width:60px; height:60px; border-radius:16px; margin:0 auto 12px;
      background:#eaf1fb; color:var(--brand); display:flex; align-items:center; justify-content:center; font-size:28px;
    }
    .menu-tile .name { font-size:16px; font-weight:600; }
    .menu-tile .desc { font-size:12px; color:#7a8594; margin-top:4px; }
    .tile-badge {
      position:absolute; top:10px; right:10px; background:#e74c3c; color:#fff;
      border-radius:999px; font-size:12px; min-width:22px; height:22px; line-height:22px;
      text-align:center; padding:0 6px; font-weight:700; box-shadow:0 1px 4px rgba(231,76,60,.5);
    }
    .tile-badge.pulse { animation: badge-pulse 1.2s ease-in-out 3; }
    @keyframes badge-pulse { 0%,100% { transform:scale(1); } 50% { transform:scale(1.25); } }

    #toast-wrap { position:fixed; right:16px; bottom:16px; z-index:9999; display:flex; flex-direction:column; gap:8px; }
    .toast-notif {
      background:#263445; color:#fff; padding:12px 16px; border-radius:8px; max-width:320px;
      box-shadow:0 4px 14px rgba(0,0,0,.25); font-size:13px; animation:toast-in .25s ease-out;
    }
    @keyframes toast-in { from { transform:translateY(10px); opacity:0; } to { transform:translateY(0); opacity:1; } }

    /* ====== Popup Login ====== */
    #loginOverlay {
      position:fixed; inset:0; background:rgba(20,30,45,.72);
      display:flex; align-items:center; justify-content:center; z-index:9998; padding:16px;
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
  <div class="title">Academic Review <small>Dashboard</small></div>
  <div class="actions">
    <button id="notifPermBtn" class="icon-btn" title="Aktifkan Notifikasi" style="display:none;">
      <i class="fa fa-bell-o"></i>
    </button>
    <button id="installBtn" class="icon-btn" style="display:none;" title="Install App">
      <i class="fa fa-download"></i>
    </button>
    <a href="vip_data.php" class="icon-btn" style="text-decoration:none;" title="Buka menu V-CMS">
      <i class="fa fa-th-large"></i>
    </a>
  </div>
</div>

<div class="page-wrap">
  <?php if ($is_logged_in) { ?>
  <p class="greeting">Halo, <b><?php echo htmlspecialchars($current_user); ?></b>.</p>

  <div class="menu-grid">
    <?php foreach ($menus as $m) { ?>
    <a class="menu-tile" href="<?php echo htmlspecialchars($m['href']); ?>">
      <?php if ($m['badge_key'] == 'notif') { ?>
      <span class="tile-badge" id="badge-notif" style="<?php echo e(num($unread) > 0 ? '' : 'display:none;'); ?>"><?php echo e(num($unread) > 99 ? '99+' : $unread); ?></span>
      <?php } ?>
      <div class="ico"><i class="fa <?php echo htmlspecialchars($m['icon']); ?>"></i></div>
      <div class="name"><?php echo htmlspecialchars($m['title']); ?></div>
      <div class="desc"><?php echo htmlspecialchars($m['desc']); ?></div>
    </a>
    <?php } ?>
  </div>
  <?php } ?>
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

<script>
  var CURRENT_USER = <?php echo json_encode($current_user); ?>;

  // ====== Popup Login ======
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
  // BUKAN Web Push asli (butuh VAPID + push server, tidak tersedia di
  // hosting ini). Polling tiap 15 detik selama dashboard terbuka (tab
  // background / window di-minimize tetap jalan, tapi tidak kalau app
  // ditutup total). Badge di tile = jumlah notifikasi BELUM DIBACA;
  // baru hilang setelah user membuka Score Review (list).
  var notifPermBtn = document.getElementById('notifPermBtn');
  var badgeEl = document.getElementById('badge-notif');
  var LAST_KEY = 'ar_last_notif_id_' + CURRENT_USER;
  var lastId = null;
  try {
    var stored = localStorage.getItem(LAST_KEY);
    if (stored !== null) { lastId = parseInt(stored, 10); }
  } catch (e) {}

  function setBadge(count, pulse) {
    if (!badgeEl) { return; }
    if (count > 0) {
      badgeEl.style.display = 'inline-block';
      badgeEl.textContent = count > 99 ? '99+' : count;
      if (pulse) {
        badgeEl.classList.remove('pulse');
        void badgeEl.offsetWidth;
        badgeEl.classList.add('pulse');
      }
    } else {
      badgeEl.style.display = 'none';
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
    notifPermBtn.style.display = (Notification.permission === 'default') ? 'inline-block' : 'none';
  }
  refreshNotifUI();
  notifPermBtn.addEventListener('click', function () {
    Notification.requestPermission().then(function () {
      refreshNotifUI();
    });
  });

  function pollNotifications() {
    if (!CURRENT_USER) { return; }
    // pertama kali (belum ada penanda id): minta after_id sangat besar
    // supaya tidak ada popup banjir -- cukup ambil max_id sbg titik awal
    var afterId = (lastId === null) ? 2147483647 : lastId;
    fetch('vip_academic_review_notif_api.php?action=poll&after_id=' + afterId)
      .then(function (r) { return r.json(); })
      .then(function (data) {
        if (data.auth === false) { location.reload(); return; }  // sesi habis -> tampil popup login
        var list = data.notifications || [];
        list.forEach(function (n) {
          showToast(n.message);
          showOsNotification(n.message);
        });
        setBadge(data.count || 0, list.length > 0);

        var newLast = lastId;
        if (lastId === null) {
          newLast = data.max_id || 0;
        } else if (list.length > 0) {
          newLast = list[list.length - 1].id;
        }
        if (newLast !== lastId) {
          lastId = newLast;
          try { localStorage.setItem(LAST_KEY, String(lastId)); } catch (e) {}
        }
      })
      .catch(function () { /* diamkan kalau network error sesaat */ });
  }

  if (CURRENT_USER) {
    pollNotifications();
    setInterval(pollNotifications, 15000);
  }
</script>
</body>
</html>
