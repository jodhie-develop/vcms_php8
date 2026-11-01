<?php
/*
 * Helper keamanan: escape output, CSRF, validasi input.
 */
defined('VCMS') or exit;

// ---- Escape output -----------------------------------------------------------

/**
 * Escape untuk HTML (isi elemen dan nilai atribut).
 *
 * Teks biasa di-escape penuh. Beberapa kolom DB berisi rich text dari editor (ckeditor):
 * mis. invoice_project.invoice_description, vip_cosheet.coverage, rulesmemofile.deskripsi_memo.
 * Kode lama mencetaknya mentah; agar tampilan tetap sama TANPA membuka XSS, tag format yang
 * aman dipertahankan (p, br, b, table, ...), atribut hanya yang tervalidasi, entity yang sudah
 * ada (&nbsp;) tidak di-encode ulang, dan semua yang lain (script, on*=, javascript:) di-escape.
 * Byte latin1/cp1252 dari DB (bukan UTF-8 valid) dikonversi ke UTF-8 agar tidak menjadi "?".
 */
function e(mixed $value): string
{
    $s = (string) $value;
    if ($s !== '' && !mb_check_encoding($s, 'UTF-8')) {
        $s = mb_convert_encoding($s, 'UTF-8', 'Windows-1252');
    }
    if (!str_contains($s, '<') && !str_contains($s, '&')) {
        return htmlspecialchars($s, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
    }
    return html_keep_safe($s);
}

/** Bagian dari e(): pertahankan tag format allowlist, escape sisanya. */
function html_keep_safe(string $s): string
{
    static $tags = ['p', 'br', 'b', 'strong', 'i', 'em', 'u', 's', 'strike', 'sub', 'sup', 'small', 'big',
        'ul', 'ol', 'li', 'span', 'div', 'font', 'center', 'blockquote', 'pre', 'hr', 'h1', 'h2', 'h3', 'h4',
        'h5', 'h6', 'table', 'thead', 'tbody', 'tfoot', 'tr', 'td', 'th', 'caption', 'col', 'colgroup', 'a', 'img', 'iframe'];
    $esc = fn(string $t) => htmlspecialchars($t, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8', false);
    $out = '';
    $pos = 0;
    $n = preg_match_all('/<\s*(\/?)\s*([a-zA-Z][a-zA-Z0-9]*)((?:\s+[a-zA-Z_:][-a-zA-Z0-9_:.]*(?:\s*=\s*(?:"[^"<>]*"|\'[^\'<>]*\'|[^\s"\'<>`=]+))?)*)\s*(\/?)\s*>/', $s, $m, PREG_OFFSET_CAPTURE | PREG_SET_ORDER);
    for ($k = 0; $k < $n; $k++) {
        [$full, $off] = $m[$k][0];
        $out .= $esc(substr($s, $pos, $off - $pos));
        $pos = $off + strlen($full);
        $name = strtolower($m[$k][2][0]);
        if (!in_array($name, $tags, true)) {
            $out .= $esc($full);
            continue;
        }
        if ($m[$k][1][0] === '/') {
            $out .= '</' . $name . '>';
            continue;
        }
        $attrs = '';
        preg_match_all('/([a-zA-Z_:][-a-zA-Z0-9_:.]*)(?:\s*=\s*(?:"([^"]*)"|\'([^\']*)\'|([^\s"\'<>`=]+)))?/', $m[$k][3][0], $am, PREG_SET_ORDER);
        foreach ($am as $a) {
            $an = strtolower($a[1]);
            $av = html_entity_decode(($a[2] ?? '') . ($a[3] ?? '') . ($a[4] ?? ''), ENT_QUOTES | ENT_HTML5, 'UTF-8');
            $ok = match (true) {
                in_array($an, ['colspan', 'rowspan', 'width', 'height', 'border', 'cellpadding', 'cellspacing', 'size'], true)
                    => (bool) preg_match('/^\d{1,4}%?$/', $av),
                in_array($an, ['align', 'valign'], true) => (bool) preg_match('/^(left|right|center|justify|top|middle|bottom)$/i', $av),
                in_array($an, ['color', 'bgcolor'], true) => (bool) preg_match('/^(#[0-9a-f]{3,8}|[a-z]{3,20})$/i', $av),
                $an === 'face' => (bool) preg_match('/^[a-z0-9 ,\-]{1,80}$/i', $av),
                $an === 'style' => (bool) preg_match('/^[a-z0-9 #:;,.%()\-\'"]*$/i', $av) && !preg_match('/url\s*\(|expression|behavior|javascript/i', $av),
                $an === 'href' && $name === 'a' => (bool) preg_match('#^(https?://|mailto:|/|[a-z0-9_\-]+\.php)#i', $av),
                $an === 'target' && $name === 'a' => (bool) preg_match('/^_(blank|self)$/', $av),
                $an === 'src' && $name === 'img' => (bool) preg_match('#^(https?://|[a-z0-9_\-/]+\.(png|jpe?g|gif|webp))#i', $av),
                $an === 'alt' && $name === 'img' => true,
                $an === 'src' && $name === 'iframe' => (bool) preg_match('#^https://(www\.)?google\.com/maps/#i', $av),
                in_array($an, ['allowfullscreen', 'loading', 'referrerpolicy'], true) && $name === 'iframe' => true,
                default => false,
            };
            if ($ok) {
                $attrs .= ' ' . $an . '="' . htmlspecialchars($av, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') . '"';
            }
        }
        if ($name === 'iframe' && !str_contains($attrs, ' src="')) {
            $out .= $esc($full);    // iframe hanya untuk embed Google Maps
            continue;
        }
        $out .= '<' . $name . $attrs . ($m[$k][4][0] === '/' ? ' /' : '') . '>';
    }
    return $out . $esc(substr($s, $pos));
}

/** Literal JavaScript yang aman disisipkan di dalam <script> atau atribut onclick. */
function js(mixed $value): string
{
    return json_encode(
        $value,
        JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_INVALID_UTF8_SUBSTITUTE
    );
}

/** Escape komponen URL (query string / path). */
function u(mixed $value): string
{
    return rawurlencode((string) $value);
}

/**
 * Pola lama: echo "<script>alert('...'); window.location = ('...');</script>".
 * $url null = tanpa redirect.
 */
function js_alert(string $message, ?string $url = null): void
{
    echo "<script type=\"text/javascript\">\n";
    echo 'alert(' . js($message) . ");\n";
    if ($url !== null) {
        echo 'window.location = (' . js($url) . ");\n";
    }
    echo "</script>";
}

// ---- CSRF ----------------------------------------------------------------------

function csrf_token(): string
{
    if (empty($_SESSION['_csrf'])) {
        $_SESSION['_csrf'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['_csrf'];
}

/** Hidden input untuk setiap <form method="post">. */
function csrf_field(): string
{
    return '<input type="hidden" name="_csrf" value="' . e(csrf_token()) . '">';
}

function csrf_rotate(): void
{
    unset($_SESSION['_csrf']);
    csrf_token();
}

function csrf_valid(): bool
{
    $sent = $_POST['_csrf'] ?? $_SERVER['HTTP_X_CSRF_TOKEN'] ?? '';
    return is_string($sent) && !empty($_SESSION['_csrf']) && hash_equals($_SESSION['_csrf'], $sent);
}

/**
 * Dipanggil otomatis oleh bootstrap: tolak POST tanpa token valid.
 * Halaman yang memang menerima POST dari luar (callback API) harus
 * define('VCMS_SKIP_CSRF', true) SEBELUM meng-include bootstrap/conndb.
 */
function csrf_enforce(): void
{
    if (($_SERVER['REQUEST_METHOD'] ?? 'GET') !== 'POST' || defined('VCMS_SKIP_CSRF')) {
        return;
    }
    if (!csrf_valid()) {
        error_log('CSRF ditolak: ' . ($_SERVER['REQUEST_URI'] ?? ''));
        http_response_code(400);
        echo "<script type=\"text/javascript\">\n";
        echo "alert('Sesi formulir sudah kedaluwarsa. Silakan muat ulang halaman dan coba lagi.');\n";
        echo "history.back();\n";
        echo "</script>";
        exit;
    }
}

/**
 * Untuk halaman lama yang MENULIS data lewat GET (link "Delete", "Approve", "Generate", ...).
 * Mengubah semuanya menjadi form POST akan mengubah tampilan/alur, jadi dipakai pengaman ini:
 * permintaan GET yang datang dari situs LAIN (Sec-Fetch-Site cross-site/same-site,
 * atau Referer dari host lain bila browser tidak mengirim Sec-Fetch-Site) tidak dijalankan;
 * yang tampil halaman konfirmasi berisi tombol ke URL yang sama. Klik dari dalam aplikasi,
 * URL yang diketik/bookmark berjalan seperti biasa. (Cookie sesi SameSite=Lax sudah mencegah
 * permintaan lintas situs lewat <img>/fetch; ini menutup navigasi lintas situs.)
 */
function csrf_guard_get(): void
{
    if (($_SERVER['REQUEST_METHOD'] ?? 'GET') !== 'GET') {
        return;
    }
    $site = strtolower($_SERVER['HTTP_SEC_FETCH_SITE'] ?? '');
    $cross = in_array($site, ['cross-site', 'same-site'], true);
    if ($site === '' && !empty($_SERVER['HTTP_REFERER'])) {
        $refHost = strtolower((string) parse_url($_SERVER['HTTP_REFERER'], PHP_URL_HOST));
        $host = strtolower(preg_replace('/:\d+$/', '', $_SERVER['HTTP_HOST'] ?? ''));
        $cross = $refHost !== '' && $refHost !== $host;
    }
    if (!$cross) {
        return;
    }
    error_log('GET lintas situs ditahan: ' . ($_SERVER['REQUEST_URI'] ?? ''));
    http_response_code(403);
    $url = $_SERVER['REQUEST_URI'] ?? '';
    echo '<!DOCTYPE html><html><head><meta charset="utf-8"><title>Konfirmasi</title></head><body style="font-family:sans-serif;margin:40px">'
        . '<p>Permintaan ini berasal dari luar aplikasi V-CMS dan dapat mengubah data.</p>'
        . '<p><a href="' . e($url) . '">Lanjutkan</a> &nbsp; <a href="javascript:history.back()">Batal</a></p></body></html>';
    exit;
}

/**
 * Jaring pengaman untuk form/AJAX lama: menambahkan token ke setiap POST
 * (form submit, form.submit(), XMLHttpRequest/jQuery, fetch) ke origin yang sama.
 * Form hasil konversi tetap memakai csrf_field() secara eksplisit.
 */
function csrf_script(): string
{
    $t = js(csrf_token());
    $attr = e(csrf_token());
    return <<<HTML
<meta name="csrf-token" content="{$attr}">
<script>
(function () {
  if (window.__vcmsCsrf) { return; }
  window.__vcmsCsrf = true;
  var t = {$t};
  function same(u) { var a = document.createElement('a'); a.href = u || location.href; return a.host === location.host; }
  function add(f) {
    if (f && String(f.method).toLowerCase() === 'post' && same(f.action) && !f.querySelector('input[name="_csrf"]')) {
      var i = document.createElement('input'); i.type = 'hidden'; i.name = '_csrf'; i.value = t; f.appendChild(i);
    }
  }
  document.addEventListener('submit', function (ev) { add(ev.target); }, true);
  var submit = HTMLFormElement.prototype.submit;
  HTMLFormElement.prototype.submit = function () { add(this); return submit.apply(this, arguments); };
  var open = XMLHttpRequest.prototype.open, send = XMLHttpRequest.prototype.send;
  XMLHttpRequest.prototype.open = function (m, u) { this._vcmsSame = same(u); return open.apply(this, arguments); };
  XMLHttpRequest.prototype.send = function () {
    if (this._vcmsSame) { try { this.setRequestHeader('X-CSRF-Token', t); } catch (e) {} }
    return send.apply(this, arguments);
  };
  if (window.fetch) {
    var f = window.fetch;
    window.fetch = function (input, init) {
      var url = typeof input === 'string' ? input : (input && input.url);
      if (same(url)) {
        init = init || {};
        var h = new Headers(init.headers || (typeof input !== 'string' && input.headers) || {});
        h.set('X-CSRF-Token', t);
        init.headers = h;
      }
      return f.call(this, input, init);
    };
  }
})();
</script>
HTML;
}

// ---- Kompatibilitas angka PHP 5 -------------------------------------------------

/**
 * Nilai angka seperti konversi PHP 5 untuk aritmetika/perbandingan kode lama:
 * ''/null/non-angka -> 0, '12abc' -> 12, ' 7.5 ' -> 7.5.
 * Di PHP 8, '5000' - '' melempar TypeError dan '' == 0 bernilai false.
 */
function num(mixed $v): int|float
{
    if (is_int($v) || is_float($v)) {
        return $v;
    }
    if (is_bool($v)) {
        return (int) $v;
    }
    // Hasil query (dulu resource mysql, kini PDOStatement): kode lama menulis "if ($result > 0)";
    // resource selalu bernilai > 0. Array dianggap 1 bila berisi.
    if (is_object($v)) {
        return 1;
    }
    if (is_array($v)) {
        return $v ? 1 : 0;
    }
    $s = trim((string) $v);
    if (is_numeric($s)) {
        return $s + 0;
    }
    return preg_match('/^[+-]?(\d+\.?\d*|\.\d+)([eE][+-]?\d+)?/', $s, $m) ? $m[0] + 0 : 0;
}

/**
 * Pembagian seperti PHP 5: pembagi 0/kosong -> false (PHP 8 melempar DivisionByZeroError).
 * false menjadi 0 di aritmetika dan '' saat di-echo, sama dengan perilaku lama.
 */
function div(mixed $a, mixed $b): int|float|false
{
    $b = num($b);
    return $b == 0 ? false : num($a) / $b;
}

/** count() seperti PHP 5: null -> 0, nilai skalar -> 1 (PHP 8 melempar TypeError). */
function cnt(mixed $v): int
{
    return is_countable($v) ? count($v) : ($v === null ? 0 : 1);
}

// ---- Validasi input -------------------------------------------------------------
// $src: 'get', 'post', atau 'any' (POST lalu GET; cookie tidak ikut seperti $_REQUEST).
// Nilai yang tidak lolos validasi (tipe salah, terlalu panjang, array) -> $default.

function in_raw(string $key, string $src = 'any'): mixed
{
    return match ($src) {
        'get'  => $_GET[$key] ?? null,
        'post' => $_POST[$key] ?? null,
        default => $_POST[$key] ?? $_GET[$key] ?? null,
    };
}

function in_str(string $key, int $max = 255, string $src = 'any', string $default = ''): string
{
    $v = in_raw($key, $src);
    if (!is_string($v)) {
        return $default;
    }
    $v = trim(str_replace("\0", '', $v));
    return mb_strlen($v, 'UTF-8') <= $max ? $v : $default;
}

function in_int(string $key, ?int $default = null, string $src = 'any', ?int $min = null, ?int $max = null): ?int
{
    $v = in_raw($key, $src);
    if (!is_string($v)) {
        return $default;
    }
    $opt = array_filter(['min_range' => $min, 'max_range' => $max], fn($x) => $x !== null);
    $r = filter_var(trim($v), FILTER_VALIDATE_INT, ['options' => $opt]);
    return $r === false ? $default : $r;
}

function in_float(string $key, ?float $default = null, string $src = 'any'): ?float
{
    $v = in_raw($key, $src);
    if (!is_string($v)) {
        return $default;
    }
    $r = filter_var(trim($v), FILTER_VALIDATE_FLOAT);
    return $r === false ? $default : $r;
}

/** Tanggal valid sesuai format (default Y-m-d), dikembalikan sebagai string. */
function in_date(string $key, ?string $default = null, string $src = 'any', string $format = 'Y-m-d'): ?string
{
    $v = in_raw($key, $src);
    if (!is_string($v)) {
        return $default;
    }
    $v = trim($v);
    $d = DateTime::createFromFormat('!' . $format, $v);
    return ($d && $d->format($format) === $v) ? $v : $default;
}

/** Jam format HH:MM (00:00 - 23:59). */
function in_time(string $key, string $default = '', string $src = 'any'): string
{
    $v = in_raw($key, $src);
    return (is_string($v) && preg_match('/^([01]\d|2[0-3]):[0-5]\d$/', $v = trim($v))) ? $v : $default;
}

/**
 * Input untuk halaman hasil konversi otomatis: string (di-trim, tanpa NUL) atau array string.
 * Tipe lain/tidak ada -> null (sama dengan indeks $_GET/$_POST yang tidak ada di versi lama).
 */
function in_val(string $key, string $src = 'any'): string|array|null
{
    $v = in_raw($key, $src);
    if (is_array($v)) {
        array_walk_recursive($v, function (&$x) { $x = is_string($x) ? trim(str_replace("\0", '', $x)) : $x; });
        return $v;
    }
    return is_string($v) ? trim(str_replace("\0", '', $v)) : null;
}

/** Nilai harus salah satu dari $allowed (perbandingan string). */
function in_enum(string $key, array $allowed, ?string $default = null, string $src = 'any'): ?string
{
    $v = in_raw($key, $src);
    return (is_string($v) && in_array($v, array_map('strval', $allowed), true)) ? $v : $default;
}
