<?php
/*
 * Bootstrap V-CMS: config, error handling, session aman, helper DB/keamanan/auth.
 * Di-include oleh conndb.php (dan oleh setiap halaman sebelum output apa pun).
 */
if (defined('VCMS')) {
    return;
}
define('VCMS', true);
define('VCMS_ROOT', dirname(__DIR__));

date_default_timezone_set('Asia/Jakarta');

/** Ambil nilai config; tanpa argumen mengembalikan seluruh array. */
function vcms_config(?string $key = null): mixed
{
    static $config = null;
    if ($config === null) {
        $candidates = array_filter([
            getenv('VCMS_CONFIG') ?: null,
            dirname(VCMS_ROOT) . '/vcms_private/config.php',
        ]);
        foreach ($candidates as $file) {
            if (is_file($file)) {
                $config = require $file;
                break;
            }
        }
        if (!is_array($config)) {
            http_response_code(500);
            error_log('V-CMS: file config tidak ditemukan (' . implode(', ', $candidates) . ')');
            exit('Konfigurasi aplikasi tidak ditemukan.');
        }
    }
    return $key === null ? $config : ($config[$key] ?? null);
}

define('APP_ENV', vcms_config('app_env') === 'dev' ? 'dev' : 'prod');

// ---- Error handling: tampil hanya di dev, selalu ke log -------------------
error_reporting(E_ALL);
ini_set('display_errors', APP_ENV === 'dev' ? '1' : '0');
ini_set('log_errors', '1');
if ($logFile = vcms_config('log_file')) {
    ini_set('error_log', $logFile);
}

// Kode lama ditulis untuk PHP 5 yang menganggap variabel/indeks tak terdefinisi sebagai NOTICE
// (umumnya disembunyikan). PHP 8 menaikkannya menjadi WARNING; perilakunya tetap sama (nilai null),
// jadi pesan jenis ini tidak ditampilkan/di-log agar log tidak banjir. Error lain tetap normal.
set_error_handler(function (int $no, string $msg): bool {
    if ($no === E_WARNING && preg_match('/^(Undefined (variable|array key|offset|index|property)|Trying to access array offset on (value of type )?(null|bool|false|true|int|float)|foreach\(\) argument must be of type array\|object|Uninitialized string offset)/', $msg)) {
        return true;
    }
    // null ke fungsi string bawaan (substr(null) dsb.): PHP 5 memperlakukannya sebagai '' tanpa pesan.
    // "Optional parameter ... before required" muncul dari pustaka lama (excel_reader2) saat kompilasi.
    if ($no === E_DEPRECATED && (str_contains($msg, 'Passing null to parameter') || str_contains($msg, 'Optional parameter') || str_contains($msg, 'Using null as an array offset'))) {
        return true;
    }
    return false;   // lanjut ke penanganan standar (display/log)
});

set_exception_handler(function (Throwable $e): void {
    error_log(sprintf(
        "Uncaught %s: %s in %s:%d [%s]\n%s",
        get_class($e), $e->getMessage(), $e->getFile(), $e->getLine(),
        $_SERVER['REQUEST_URI'] ?? 'cli', $e->getTraceAsString()
    ));
    if (!headers_sent()) {
        http_response_code(500);
    }
    if (APP_ENV === 'dev') {
        echo '<pre style="color:#b00">' . htmlspecialchars((string) $e, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') . '</pre>';
    } else {
        echo 'Terjadi kesalahan pada server. Silakan coba lagi atau hubungi administrator.';
    }
});

// ---- Header keamanan ------------------------------------------------------
if (!headers_sent()) {
    header_remove('X-Powered-By');
    header('X-Content-Type-Options: nosniff');
    header('X-Frame-Options: SAMEORIGIN');
    header('Referrer-Policy: same-origin');
}

require __DIR__ . '/db.php';
require __DIR__ . '/security.php';
require __DIR__ . '/auth.php';
require __DIR__ . '/upload.php';
require __DIR__ . '/app.php';

// ---- Session --------------------------------------------------------------
if (PHP_SAPI !== 'cli' && session_status() === PHP_SESSION_NONE) {
    $sess = vcms_config('session') ?? [];
    $https = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off')
        || (int) ($_SERVER['SERVER_PORT'] ?? 0) === 443;
    ini_set('session.use_strict_mode', '1');
    ini_set('session.use_only_cookies', '1');
    ini_set('session.use_trans_sid', '0');
    session_name($sess['name'] ?? 'VCMSSESSID');
    session_set_cookie_params([
        'lifetime' => 0,
        'path'     => '/',
        'secure'   => $sess['secure'] ?? $https,
        'httponly' => true,
        'samesite' => 'Lax',
    ]);
    session_start();
}

// Semua request POST wajib membawa token CSRF yang valid.
csrf_enforce();
