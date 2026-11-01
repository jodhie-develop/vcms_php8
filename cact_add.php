<?php
require_once __DIR__ . "/_lib/bootstrap.php"; auth_require_login();
ini_set("memory_limit","256M");
include __DIR__ . "/conndb.php";
include __DIR__ . "/profiledata.php";
/*
 * Versi lama: INSERT ke ves_data.vip_billing dengan SQL yang salah ketik
 *   values ('CACT',''$kdcl', ...)   <- kutip ganda berlebih
 * sehingga query SELALU gagal dan halaman berhenti dengan teks "errro_simpan"
 * (tidak pernah ada baris yang tersimpan). Perilaku itu dipertahankan: tidak ada insert.
 * Memperbaiki salah ketik akan MENGAKTIFKAN penambahan billing 'CACT' -> perlu keputusan
 * pemilik aplikasi (lihat proses_migrasi.md).
 */
exit('errro_simpan');
