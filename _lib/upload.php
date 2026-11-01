<?php
/*
 * Upload file aman.
 *
 *   try {
 *       $nama = upload_save('foto', UPLOAD_IMAGES, VCMS_ROOT . '/upload', 2 * 1024 * 1024);
 *   } catch (UploadError $err) {
 *       js_alert($err->getMessage());
 *   }
 *
 * - whitelist ekstensi, MIME dicek dengan finfo (bukan dari browser)
 * - nama file acak (32 hex) + ekstensi asli yang sudah divalidasi
 * - batas ukuran
 * - folder tujuan otomatis diberi .htaccess yang mematikan eksekusi script
 */
defined('VCMS') or exit;

class UploadError extends RuntimeException
{
}

/** ekstensi => daftar MIME yang diterima (hasil finfo). */
const UPLOAD_IMAGES = [
    'jpg'  => ['image/jpeg'],
    'jpeg' => ['image/jpeg'],
    'png'  => ['image/png'],
    'gif'  => ['image/gif'],
    'webp' => ['image/webp'],
];

const UPLOAD_DOCS = [
    'pdf'  => ['application/pdf'],
    'doc'  => ['application/msword', 'application/CDFV2', 'application/x-ole-storage'],
    'docx' => ['application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'application/zip', 'application/octet-stream'],
    'xls'  => ['application/vnd.ms-excel', 'application/CDFV2', 'application/x-ole-storage'],
    'xlsx' => ['application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', 'application/zip', 'application/octet-stream'],
    'csv'  => ['text/plain', 'text/csv', 'application/csv'],
    'txt'  => ['text/plain'],
];

const UPLOAD_HTACCESS = <<<'HTACCESS'
# Dibuat oleh V-CMS: folder upload tidak boleh menjalankan script.
Options -ExecCGI -Indexes
<FilesMatch "(?i)\.(php\d?|phtml|pht|phar|phps|cgi|pl|py|sh|asp|aspx|jsp|shtml|htaccess)$">
    Require all denied
</FilesMatch>
<IfModule mod_php.c>
    php_flag engine off
</IfModule>
<IfModule php_module>
    php_flag engine off
</IfModule>
RemoveHandler .php .php3 .php4 .php5 .php7 .php8 .phtml .pht .phar
RemoveType .php .php3 .php4 .php5 .php7 .php8 .phtml .pht .phar

HTACCESS;

/** Pastikan folder upload ada dan berisi .htaccess pengaman. */
function upload_prepare_dir(string $dir): void
{
    if (!is_dir($dir) && !mkdir($dir, 0755, true)) {
        throw new UploadError('Folder upload tidak dapat dibuat');
    }
    $ht = $dir . '/.htaccess';
    // Folder yang juga berisi halaman PHP aplikasi (mis. ecert/) tidak boleh diberi .htaccess
    // anti-eksekusi; file yang masuk tetap dibatasi whitelist + finfo + nama acak.
    if (!is_file($ht) && !glob($dir . '/*.php')) {
        file_put_contents($ht, UPLOAD_HTACCESS);
    }
}

/**
 * Simpan file upload dari $_FILES[$field] (atau $_FILES[$field][..][$index] untuk input name="x[]").
 * Mengembalikan nama file baru (tanpa path).
 */
function upload_save(string $field, array $allowed, string $destDir, int $maxBytes = 5242880, ?int $index = null): string
{
    $f = $_FILES[$field] ?? null;
    if (!is_array($f)) {
        throw new UploadError('Tidak ada file yang diupload');
    }
    if ($index !== null) {
        $f = array_map(fn($v) => is_array($v) ? ($v[$index] ?? null) : null, $f);
    }
    if (is_array($f['error']) || $f['error'] !== UPLOAD_ERR_OK) {
        throw new UploadError(match ($f['error']) {
            UPLOAD_ERR_INI_SIZE, UPLOAD_ERR_FORM_SIZE => 'Ukuran file terlalu besar',
            UPLOAD_ERR_NO_FILE => 'Tidak ada file yang diupload',
            default => 'Upload file gagal',
        });
    }
    if (!is_uploaded_file($f['tmp_name'])) {
        throw new UploadError('Upload file tidak valid');
    }
    if ($f['size'] <= 0 || $f['size'] > $maxBytes) {
        throw new UploadError('Ukuran file maksimal ' . round($maxBytes / 1048576, 1) . ' MB');
    }

    $ext = strtolower(pathinfo((string) $f['name'], PATHINFO_EXTENSION));
    if (!isset($allowed[$ext])) {
        throw new UploadError('Jenis file tidak diizinkan. Hanya: ' . implode(', ', array_keys($allowed)));
    }
    $mime = (new finfo(FILEINFO_MIME_TYPE))->file($f['tmp_name']);
    if (!in_array($mime, $allowed[$ext], true)) {
        throw new UploadError('Isi file tidak sesuai dengan ekstensinya');
    }
    if (isset(UPLOAD_IMAGES[$ext]) && @getimagesize($f['tmp_name']) === false) {
        throw new UploadError('File gambar tidak valid');
    }

    upload_prepare_dir($destDir);
    $name = bin2hex(random_bytes(16)) . '.' . $ext;
    if (!move_uploaded_file($f['tmp_name'], $destDir . '/' . $name)) {
        throw new UploadError('File gagal disimpan');
    }
    @chmod($destDir . '/' . $name, 0644);
    return $name;
}

/** Gambar + PDF: whitelist yang dipakai sebagian besar form upload lama. */
const UPLOAD_IMG_PDF = UPLOAD_IMAGES + ['pdf' => ['application/pdf']];

/** Whitelist dari daftar ekstensi, mis. upload_allow('jpg', 'png', 'pdf'). */
function upload_allow(string ...$exts): array
{
    $all = UPLOAD_IMAGES + UPLOAD_DOCS + ['mp3' => ['audio/mpeg'], 'mp4' => ['video/mp4']];
    $out = [];
    foreach ($exts as $x) {
        $x = strtolower($x);
        if (isset($all[$x])) {
            $out[$x] = $all[$x];
        }
    }
    return $out;
}

/**
 * Simpan gambar dari data URL / base64 (tanda tangan canvas). Tipe ditentukan dari ISI (finfo),
 * bukan dari teks "data:image/xxx" kiriman browser; hanya png/jpeg/gif/webp. Mengembalikan path
 * file baru ($dir/<acak>.<ext>) atau false.
 */
function upload_save_dataurl(string $data, string $dir, int $maxBytes = 2097152): string|false
{
    $GLOBALS['__upload_error'] = '';
    if (str_contains($data, ';base64,')) {
        $data = substr($data, strpos($data, ';base64,') + 8);
    }
    $bin = base64_decode(str_replace(' ', '+', $data), true);
    if ($bin === false || $bin === '' || strlen($bin) > $maxBytes) {
        $GLOBALS['__upload_error'] = 'Data gambar tidak valid';
        return false;
    }
    $mime = (new finfo(FILEINFO_MIME_TYPE))->buffer($bin);
    $ext = ['image/png' => 'png', 'image/jpeg' => 'jpg', 'image/gif' => 'gif', 'image/webp' => 'webp'][$mime] ?? false;
    if ($ext === false || @getimagesizefromstring($bin) === false) {
        $GLOBALS['__upload_error'] = 'Data bukan gambar yang diizinkan';
        return false;
    }
    try {
        upload_prepare_dir(rtrim($dir, '/'));
    } catch (UploadError $err) {
        $GLOBALS['__upload_error'] = $err->getMessage();
        return false;
    }
    $file = rtrim($dir, '/') . '/' . bin2hex(random_bytes(16)) . '.' . $ext;
    return file_put_contents($file, $bin) === false ? false : $file;
}

/**
 * Hapus file hanya bila berada di salah satu folder $allowedDirs (relatif ke folder aplikasi)
 * dan bukan script. Pengganti unlink($_GET[...]) di kode lama.
 */
function safe_unlink(string $path, array $allowedDirs): bool
{
    $real = realpath($path);
    if ($real === false || !is_file($real) || preg_match('/\.(php\d?|phtml|phar|htaccess)$/i', $real)) {
        return false;
    }
    foreach ($allowedDirs as $d) {
        $base = realpath(VCMS_ROOT . '/' . $d);
        if ($base !== false && str_starts_with($real, $base . DIRECTORY_SEPARATOR)) {
            return unlink($real);
        }
    }
    error_log('V-CMS safe_unlink ditolak: ' . $path);
    return false;
}

/** Pesan error upload terakhir dari upload_move(). */
function upload_error(): string
{
    return $GLOBALS['__upload_error'] ?? '';
}

/**
 * Pengganti basename($_FILES[$field]['name']) di kode lama: nama acak (32 hex) + ekstensi asli
 * (huruf kecil, hanya a-z0-9). Nilai sama untuk field yang sama selama satu request, karena kode
 * lama memanggil basename() beberapa kali (nama di DB dan nama file di disk).
 */
function upload_random_name(string $field, ?int $index = null): string
{
    static $names = [];
    $key = $field . '#' . $index;
    if (!isset($names[$key])) {
        $orig = $_FILES[$field]['name'] ?? '';
        if ($index !== null) {
            $orig = is_array($orig) ? ($orig[$index] ?? '') : '';
        }
        $ext = preg_replace('/[^a-z0-9]/', '', strtolower(pathinfo((string) $orig, PATHINFO_EXTENSION)));
        $names[$key] = bin2hex(random_bytes(16)) . ($ext !== '' ? '.' . $ext : '');
    }
    return $names[$key];
}

/**
 * Nama asli file kiriman browser untuk DITAMPILKAN (kolom nama tampilan seperti vip_ssq.namafile),
 * bukan untuk path di disk — file tetap disimpan dengan upload_random_name(). Path dibuang, karakter
 * kontrol dan  < > : " / \ | ? *  dihapus, spasi dirapikan, dipotong ke $max karakter. Tetap
 * di-escape dengan e() saat ditampilkan.
 */
function upload_display_name(string $field, ?int $index = null, int $max = 150): string
{
    $orig = $_FILES[$field]['name'] ?? '';
    if ($index !== null) {
        $orig = is_array($orig) ? ($orig[$index] ?? '') : '';
    }
    $name = basename(str_replace('\\', '/', (string) $orig));
    $name = preg_replace('/[\x00-\x1F\x7F<>:"\/\\\\|?*]+/u', '', $name) ?? '';
    $name = trim(preg_replace('/\s+/u', ' ', $name) ?? '', " .");
    if ($name === '') {
        return upload_random_name($field, $index);
    }
    if (mb_strlen($name, 'UTF-8') > $max) {
        // potong nama, pertahankan ekstensi
        $ext = pathinfo($name, PATHINFO_EXTENSION);
        $ext = ($ext !== '' && mb_strlen($ext, 'UTF-8') <= 10) ? '.' . $ext : '';
        $name = mb_substr($name, 0, $max - mb_strlen($ext, 'UTF-8'), 'UTF-8') . $ext;
    }
    return $name;
}

/**
 * Pengganti move_uploaded_file($_FILES[$field]['tmp_name'], $target) di kode lama, dengan validasi
 * yang sama seperti upload_save(): status upload, ukuran, whitelist ekstensi (dari $target), MIME via
 * finfo, gambar valid; nama file di $target hanya boleh [A-Za-z0-9 ._-], tanpa '..', folder harus
 * sudah ada (diberi .htaccess anti-eksekusi). Mengembalikan false + upload_error() bila ditolak.
 */
function upload_move(string $field, array $allowed, string $target, int $maxBytes = 5242880, ?int $index = null): bool
{
    $GLOBALS['__upload_error'] = '';
    try {
        $f = $_FILES[$field] ?? null;
        if (!is_array($f)) {
            throw new UploadError('Tidak ada file yang diupload');
        }
        if ($index !== null) {
            $f = array_map(fn($v) => is_array($v) ? ($v[$index] ?? null) : null, $f);
        }
        if (is_array($f['error']) || $f['error'] !== UPLOAD_ERR_OK || !is_uploaded_file((string) $f['tmp_name'])) {
            throw new UploadError('Upload file gagal');
        }
        if ($f['size'] <= 0 || $f['size'] > $maxBytes) {
            throw new UploadError('Ukuran file maksimal ' . round($maxBytes / 1048576, 1) . ' MB');
        }
        $base = basename($target);
        $dir  = dirname($target);
        if (str_contains($target, '..') || !preg_match('/^[A-Za-z0-9 ._-]+$/', $base) || !is_dir($dir)) {
            throw new UploadError('Nama/folder tujuan file tidak valid');
        }
        $ext = strtolower(pathinfo($base, PATHINFO_EXTENSION));
        if (!isset($allowed[$ext])) {
            throw new UploadError('Jenis file tidak diizinkan. Hanya: ' . implode(', ', array_keys($allowed)));
        }
        $mime = (new finfo(FILEINFO_MIME_TYPE))->file($f['tmp_name']);
        if (!in_array($mime, $allowed[$ext], true)) {
            throw new UploadError('Isi file tidak sesuai dengan ekstensinya');
        }
        if (isset(UPLOAD_IMAGES[$ext]) && @getimagesize($f['tmp_name']) === false) {
            throw new UploadError('File gambar tidak valid');
        }
        upload_prepare_dir($dir);
        if (!move_uploaded_file($f['tmp_name'], $target)) {
            throw new UploadError('File gagal disimpan');
        }
        @chmod($target, 0644);
        return true;
    } catch (UploadError $err) {
        $GLOBALS['__upload_error'] = $err->getMessage();
        error_log('V-CMS upload ditolak (' . $field . '): ' . $err->getMessage());
        return false;
    }
}
