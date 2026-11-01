<?php
/*
 * Contoh konfigurasi V-CMS.
 *
 * Salin file ini ke LUAR webroot, lalu isi kredensial yang benar:
 *   - default: <folder induk webroot>/vcms_private/config.php
 *     (mis. webroot /var/www/vcms  ->  /var/www/vcms_private/config.php)
 *   - atau tentukan path lewat environment variable VCMS_CONFIG.
 *
 * JANGAN commit file config asli ke repository.
 */
return [
    // 'prod' = error tidak ditampilkan, hanya ditulis ke log.
    // 'dev'  = error ditampilkan di halaman (hanya untuk laptop developer).
    'app_env' => 'prod',

    'db' => [
        'host'     => '127.0.0.1',
        'port'     => 3306,
        'user'     => 'vcms_app',
        'pass'     => 'GANTI_DENGAN_PASSWORD_KUAT',
        // Hampir semua tabel latin1; koneksi latin1 meneruskan byte apa adanya
        // seperti ext/mysql lama, sehingga data lama tetap tampil sama.
        'charset'  => 'latin1',
        // Kode lama ditulis untuk MySQL non-strict (mis. '' ke kolom INT).
        // Kosongkan (null) bila ingin memakai sql_mode bawaan server.
        'sql_mode' => 'NO_ENGINE_SUBSTITUTION',
    ],

    // Nama database di server bila BERBEDA dari nama di kode (mis. shared hosting yang memberi
    // awalan akun). Kode tetap menulis ves_data/ves_inc/...; _lib/db.php menerjemahkannya.
    // Hapus/biarkan dikomentari bila nama database sama persis.
    // 'db_names' => [
    //     'ves_data'     => 'akunanda_ves_data',
    //     'ves_inc'      => 'akunanda_ves_inc',
    //     'data_absen'   => 'akunanda_data_absen',
    //     'dbsertifikat' => 'akunanda_dbsertifikat',
    // ],

    // File log error aplikasi (harus di luar webroot dan bisa ditulis PHP).
    'log_file' => __DIR__ . '/logs/app.log',

    // Autoload Composer (html2pdf, PhpSpreadsheet, dompdf; lihat _lib/vendor.php). Kosong = <webroot>/vendor/autoload.php.
    // 'vendor_autoload' => '/var/www/vcms/vendor/autoload.php',

    'session' => [
        'name'   => 'VCMSSESSID',
        // null = otomatis (Secure hanya bila request HTTPS). Set true di produksi HTTPS.
        'secure' => null,
    ],

    // Akun email untuk notifikasi PO/incentive (PHPMailer). Dulu tertanam di kode
    // (po_entry.php, csr_po_entry.php, incentive_entry.php, po_entry_add_item.php,
    // accnt/po_entry.php) -> GANTI password akun itu, lalu isi di sini.
    'smtp' => [
        'host' => 'smtp.example.com',
        'user' => 'notifikasi@example.com',
        'pass' => 'GANTI',
    ],

    // Token API Fonnte (WhatsApp) untuk kirim_wa.php. Token lama pernah tertanam di
    // kode (kirim_wa.php, dns_test.php) -> buat token baru di dashboard Fonnte.
    'fonnte_token' => '',
];
