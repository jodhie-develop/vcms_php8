<?php
/*
 * Pustaka pihak ketiga dari Composer (lihat composer.json & DEPLOY.md bagian 8):
 *   spipu/html2pdf (halaman PDF, lewat _lib/html2pdf.php), phpoffice/phpspreadsheet
 *   (vip_file_view.php), dompdf/dompdf (ecert/capstpdf.php).
 *
 * Lokasi autoload Composer: env VCMS_VENDOR_AUTOLOAD (khusus uji), config 'vendor_autoload',
 * atau default <folder aplikasi>/vendor/autoload.php.
 */
defined('VCMS') or exit;

function vendor_autoload_path(): string
{
    return getenv('VCMS_VENDOR_AUTOLOAD') ?: (vcms_config('vendor_autoload') ?: VCMS_ROOT . '/vendor/autoload.php');
}

/** Hentikan halaman dengan status & pesan polos (buffer output dibuang). */
function vendor_stop(int $status, string $pesan): never
{
    while (ob_get_level() > 0) {
        ob_end_clean();
    }
    if (!headers_sent()) {
        http_response_code($status);
        header('Content-Type: text/html; charset=UTF-8');
    }
    exit($pesan);
}

/**
 * Muat autoload Composer dan pastikan $class tersedia. Bila pustaka belum dipasang, halaman
 * berhenti dengan 503 + pesan untuk pengguna (bukan fatal error), detail ke log.
 */
function vendor_require(string $class, string $fitur, string $pustaka): void
{
    $path = vendor_autoload_path();
    if (is_file($path)) {
        require_once $path;
    }
    if (class_exists($class)) {
        return;
    }
    error_log('V-CMS vendor: ' . $pustaka . ' belum dipasang (' . $path . ') [' . ($_SERVER['REQUEST_URI'] ?? 'cli') . ']');
    vendor_stop(503, 'Fitur ' . $fitur . ' belum tersedia di server ini (pustaka ' . $pustaka . ' belum dipasang). Hubungi administrator.');
}

/** Kegagalan pustaka saat dipakai: pesan umum ke pengguna, detail hanya ke log. */
function vendor_fail(Throwable $e, string $log, string $pesan): never
{
    error_log($log . ' [' . ($_SERVER['REQUEST_URI'] ?? 'cli') . ']: ' . get_class($e) . ': ' . $e->getMessage());
    vendor_stop(500, $pesan);
}
