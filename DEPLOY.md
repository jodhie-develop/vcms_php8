# DEPLOY V-CMS ke PHP 8.4 + MariaDB 11.4

Dokumen ini untuk admin server. Kode di folder ini (`vcms_php8/`) adalah hasil konversi
V-CMS lama (PHP 5.2 + `mysql_*`) ke PHP 8.4. Detail proses dan keputusan yang masih terbuka
ada di `proses_migrasi.md`. **Jangan di-deploy sebelum bagian 8 (pustaka) dan 9 (rotasi
kredensial) beres.**

---

## 1. Isi paket

| Bagian | Keterangan |
|---|---|
| `*.php`, `accnt/`, `ecert/`, `printable/`, `cetak/`, `printing/` | Halaman hasil konversi (nama & struktur sama dengan aslinya) |
| `_lib/` | Fondasi baru: bootstrap, PDO, CSRF, escape, auth, upload aman. Tidak boleh diakses dari web (`.htaccess` di dalamnya) |
| `_lib/config.sample.php` | Contoh konfigurasi. Config asli disimpan **di luar webroot** |
| `_lib/SKIPPED.md` | Daftar file lama yang sengaja tidak dibawa (backup, debug, rusak, orphan) |
| `.htaccess` | Aturan Apache untuk root (lihat bagian 6) |

Folder aset lama (css, js, images, plugins, dist, bootstrap, dll.) **tidak** ada di paket ini:
salin dari aplikasi lama (lihat langkah 10).

---

## 2. Prasyarat server

- PHP **8.4** (SAPI: PHP-FPM atau mod_php) dengan ekstensi:
  `pdo_mysql`, `mbstring`, `fileinfo`, `gd`, `curl`, `iconv`, `openssl`, `session`, `ctype`,
  ditambah untuk pustaka Composer (bagian 8a): `zip`, `xml`, `dom`, `xmlreader`, `xmlwriter`,
  `simplexml`, `libxml`, `zlib` (PhpSpreadsheet & dompdf).
- MariaDB **11.4** (LTS).
- Apache 2.4 dengan `mod_headers`, `mod_alias`, `AllowOverride All` untuk webroot
  (atau salin aturan `.htaccess` ke konfigurasi VirtualHost).
- HTTPS aktif (sertifikat valid). Cookie sesi diset `Secure` otomatis bila request HTTPS.

---

## 3. php.ini (produksi)

```ini
; --- informasi & error ---
expose_php = Off
display_errors = Off
display_startup_errors = Off
log_errors = On
error_log = /var/www/vcms_private/logs/php_error.log
error_reporting = E_ALL
zend.exception_ignore_args = On

; --- fungsi berbahaya (aplikasi tidak memakainya) ---
disable_functions = exec,passthru,shell_exec,system,proc_open,popen,proc_get_status,proc_terminate,pcntl_exec,pcntl_fork,pcntl_signal,dl,putenv,show_source,highlight_file,phpinfo,posix_kill,posix_setuid,posix_setgid,symlink,link
; curl dipakai kirim_wa.php (API Fonnte) -> curl_exec JANGAN dimatikan.

; --- akses file & URL ---
allow_url_fopen = Off
allow_url_include = Off
open_basedir = /var/www/vcms:/var/www/vcms_private:/tmp:/var/lib/php/sessions
; sesuaikan path; webroot, folder config/log privat, tmp upload, dan folder sesi wajib tercantum
upload_tmp_dir = /tmp
file_uploads = On
upload_max_filesize = 50M      ; batas terbesar di kode lama (50 MB)
post_max_size = 55M
max_file_uploads = 20

; --- batas eksekusi (beberapa laporan besar) ---
max_execution_time = 300
max_input_time = 120
memory_limit = 512M            ; beberapa halaman memasang ini sendiri
max_input_vars = 10000         ; form per-baris: vip_scorerecord ±8.500 field, invoicebill ±5.600
                               ; (lebih dari ini, field di akhir form hilang tanpa pesan)

; --- sesi ---
session.save_path = /var/lib/php/sessions
session.use_strict_mode = 1
session.use_only_cookies = 1
session.use_trans_sid = 0
session.cookie_httponly = 1
session.cookie_secure = 1
session.cookie_samesite = Lax
session.cookie_lifetime = 0
session.gc_maxlifetime = 7200
session.name = VCMSSESSID

; --- lain-lain ---
short_open_tag = Off           ; semua "<?" sudah diubah menjadi "<?php"
date.timezone = Asia/Jakarta
default_charset = "UTF-8"
```

Catatan: `session.sid_length`/`sid_bits_per_character` sudah deprecated di PHP 8.4, biarkan default.

---

## 4. Konfigurasi aplikasi

1. Buat folder privat **di luar webroot**, contoh struktur:
   ```
   /var/www/vcms            <- webroot (isi paket ini + aset lama)
   /var/www/vcms_private/   <- config.php, logs/
   ```
2. Salin `_lib/config.sample.php` ke `/var/www/vcms_private/config.php`, isi:
   - `app_env` = `prod`
   - `db.user` / `db.pass` = user aplikasi dari bagian 5 (bukan root)
   - `db.charset` = `latin1` (hampir semua tabel latin1; jangan diubah sebelum konversi data)
   - `db.sql_mode` = `NO_ENGINE_SUBSTITUTION` (kode lama mengandalkan mode non-strict)
   - `smtp.*` dan `fonnte_token` dengan kredensial **baru** (bagian 9)
3. Bila config tidak di `<induk webroot>/vcms_private/config.php`, set env `VCMS_CONFIG`
   (Apache: `SetEnv VCMS_CONFIG /path/config.php`; FPM: `env[VCMS_CONFIG] = ...`).
4. Hak akses:
   ```
   chown -R root:www-data /var/www/vcms && find /var/www/vcms -type d -exec chmod 755 {} + && find /var/www/vcms -type f -exec chmod 644 {} +
   chown -R root:www-data /var/www/vcms_private && chmod 750 /var/www/vcms_private && chmod 640 /var/www/vcms_private/config.php
   mkdir -p /var/www/vcms_private/logs && chown www-data:www-data /var/www/vcms_private/logs && chmod 750 /var/www/vcms_private/logs
   ```
   Hanya folder upload (bagian 6) yang boleh ditulis oleh `www-data`.

---

## 5. MariaDB: user aplikasi dengan hak minimal

Aplikasi memakai database: `ves_data` (utama), `ves_inc`, `ves_event`, `data_absen`
(`conndbs.php`, absensi), `dbsertifikat` (`ecert/conndb.php`), dan dari laporan lama:
`billing`, `billing_west`, `billing_bali`, `billing_malang`, `billing_new_bdg`, `billing_new_gs`, `billing_jkt_02`, `billing_m2`,
`absensi`, `vistaedu_optimus`, `hrd` (berikan GRANT hanya untuk database yang ada). Kode tidak menjalankan DDL
(CREATE/ALTER/DROP), `LOAD DATA`, `INTO OUTFILE`, atau procedure.

```sql
-- jalankan sebagai admin DB
CREATE USER 'vcms_app'@'localhost' IDENTIFIED BY '<password-acak-minimal-24-karakter>';

GRANT SELECT, INSERT, UPDATE, DELETE ON ves_data.*     TO 'vcms_app'@'localhost';
GRANT SELECT, INSERT, UPDATE, DELETE ON ves_inc.*      TO 'vcms_app'@'localhost';
GRANT SELECT, INSERT, UPDATE, DELETE ON ves_event.*    TO 'vcms_app'@'localhost';
GRANT SELECT, INSERT, UPDATE, DELETE ON data_absen.*   TO 'vcms_app'@'localhost';
GRANT SELECT, INSERT, UPDATE, DELETE ON dbsertifikat.* TO 'vcms_app'@'localhost';
-- database laporan lama (read-only cukup, kecuali bila halaman terkait memang menulis):
GRANT SELECT ON billing.*          TO 'vcms_app'@'localhost';
GRANT SELECT ON billing_west.*     TO 'vcms_app'@'localhost';
GRANT SELECT ON billing_bali.*     TO 'vcms_app'@'localhost';
GRANT SELECT ON billing_malang.*   TO 'vcms_app'@'localhost';
GRANT SELECT ON billing_new_bdg.*  TO 'vcms_app'@'localhost';
GRANT SELECT ON billing_new_gs.*   TO 'vcms_app'@'localhost';
GRANT SELECT ON billing_jkt_02.*   TO 'vcms_app'@'localhost';
GRANT SELECT ON billing_m2.*       TO 'vcms_app'@'localhost';
GRANT SELECT ON absensi.*          TO 'vcms_app'@'localhost';
GRANT SELECT ON vistaedu_optimus.* TO 'vcms_app'@'localhost';
GRANT SELECT ON hrd.*              TO 'vcms_app'@'localhost';
-- TIDAK diberikan: FILE, SUPER, PROCESS, CREATE, ALTER, DROP, GRANT OPTION, CREATE USER, EXECUTE
FLUSH PRIVILEGES;

-- verifikasi
SHOW GRANTS FOR 'vcms_app'@'localhost';
```

Jika aplikasi dan DB beda host, ganti `'localhost'` dengan IP server aplikasi (bukan `'%'`),
dan batasi port 3306 di firewall hanya untuk IP tersebut.

### 5a. Hosting yang memberi awalan nama database (shared hosting / cPanel)

Kode menulis nama database langsung di query (`ves_data.tabel`, `ves_inc.tabel`, `billing_west.…`).
Bila hosting memaksa awalan akun (mis. `akunanda_ves_data`), **kode tidak perlu diubah** — isi
pemetaan di `config.php`; `_lib/db.php` menerjemahkan nama saat memilih database dan di setiap query
(isi string/data tidak ikut diubah):

```php
'db_names' => [
    'ves_data'     => 'akunanda_ves_data',
    'ves_inc'      => 'akunanda_ves_inc',
    'data_absen'   => 'akunanda_data_absen',
    'dbsertifikat' => 'akunanda_dbsertifikat',
    // tambahkan bila database ini ikut dipindah: ves_event, absensi, vistaedu_optimus, hrd,
    // billing, billing_west, billing_bali, billing_malang, billing_new_bdg, billing_new_gs,
    // billing_jkt_02, billing_m2
],
```

Pindah data ke database berawalan — dump **per database tanpa** `--databases` (supaya file tidak
berisi `CREATE DATABASE`/`USE` nama lama), lalu impor ke nama baru:
```bash
# di server lama
mariadb-dump --single-transaction --routines --events --triggers ves_data > ves_data.sql
mariadb-dump --single-transaction --routines --events --triggers ves_inc  > ves_inc.sql
# di hosting (SSH; database dibuat dulu lewat panel, user diberi hak ke database itu)
mariadb -u akunanda_vcms -p akunanda_ves_data < ves_data.sql
mariadb -u akunanda_vcms -p akunanda_ves_inc  < ves_inc.sql
```
Di DB lokal (2026-10-29) tidak ada view/trigger/procedure/event — cek juga di produksi:
`SELECT TABLE_SCHEMA, TABLE_NAME FROM information_schema.VIEWS WHERE TABLE_SCHEMA IN ('ves_data','ves_inc');`
(bila ada, nama database di dalam definisinya harus disesuaikan manual).

File SQL di `usulan/` menulis `ves_data.` — ganti dulu sebelum dijalankan, mis.:
`sed 's/\bves_data\./akunanda_ves_data./g' usulan/index_performa_up.sql | mariadb -u … -p`

Hak user DB diatur lewat panel hosting (MySQL Databases → Add User To Database): cukup SELECT,
INSERT, UPDATE, DELETE; ALTER/INDEX hanya sementara untuk menjalankan file `usulan/`.

Pengaturan server MariaDB yang disarankan (`my.cnf`, bagian `[mysqld]`):
```ini
bind-address = 127.0.0.1          ; bila DB satu server dengan aplikasi
local_infile = 0
secure_file_priv = /var/lib/mysql-files   ; tetap batasi walau user aplikasi tanpa FILE
skip_name_resolve = 1
```
Aplikasi mengatur `sql_mode` per koneksi (`NO_ENGINE_SUBSTITUTION`), jadi default ketat
MariaDB 11.4 tidak memutus query lama (mis. string kosong ke kolom angka).

DDL opsional yang disebut di komentar kode lama (jalankan oleh DBA bila belum ada; cek dulu):
- `teacher_master_upd.php` / `teacher_salary_report.php`: kolom `jenis_rate`, `satuan`,
  `tgl_efektif`, `id` di `ves_data.vip_mst_teacher_rate`.
- `vip_academic_review.php`: tabel `ves_data.vip_academic_review` dan `vip_academic_review_notif`.
- `vip_rpt_open_class.php`, `vip_rpt_payment_detail.php`: index yang disarankan untuk performa.

---

## 6. `.htaccess`

- Root: file `.htaccess` di paket ini (directory listing mati, file sensitif & folder internal
  ditolak, folder pustaka tidak bisa dipanggil langsung — termasuk `ecert/dompdf/*.php` yang
  punya celah RCE lama, dan PHP di folder upload ditolak).
- `_lib/.htaccess`: `Require all denied`.
- Folder upload menerima `.htaccess` berikut secara otomatis pada upload pertama
  (`upload_prepare_dir()`); sebaiknya dipasang manual sejak awal:

```apache
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
```

Folder upload (harus ada & bisa ditulis `www-data`):
`brg_img/ ctrct/ doc_vos/ e_sign/ e_sign/po/ e_sign/speciment/ fncfile/ gb/ gbmaterial/ gbpdo/
gbstaff/ gudangfile/ imgs/meeting/ po_docs/ rulesmemofile/ uploads/inventory_docs/
uploads/inventory_photo/ vipfile/ vipscsq/`
dan `ecert/` (berisi juga halaman PHP, jadi **tidak** diberi `.htaccess` di atas; file yang
masuk tetap dibatasi PDF/gambar + cek isi + nama acak).

Dengan PHP-FPM, `php_flag` tidak berlaku; pastikan handler PHP hanya dipasang untuk webroot
dan tambahkan di VirtualHost:
```apache
<DirectoryMatch "^/var/www/vcms/(brg_img|ctrct|doc_vos|e_sign|fncfile|gb|gbmaterial|gbpdo|gbstaff|gudangfile|imgs/meeting|po_docs|rulesmemofile|uploads|vipfile|vipscsq)">
    <FilesMatch "\.ph(p\d?|tml|ar)$">
        SetHandler none
        Require all denied
    </FilesMatch>
</DirectoryMatch>
```

---

## 7. Perubahan perilaku yang perlu diketahui pengguna

- Semua form POST membawa token CSRF; form yang dibiarkan terbuka sangat lama (sesi habis)
  akan menampilkan "Sesi formulir sudah kedaluwarsa".
- Aksi tulis yang dulu lewat GET dari form (tombol Save/Submit) kini POST.
- Link aksi lama (Delete/Approve/Generate via URL) tetap jalan bila diklik dari dalam aplikasi;
  bila dibuka dari situs/aplikasi lain muncul halaman konfirmasi "Lanjutkan".
- Nama file upload baru diacak (32 karakter hex + ekstensi asli); hanya ekstensi yang dulu
  diizinkan, dan isi file diperiksa. Di daftar dokumen yang punya kolom nama sendiri (file
  gudang, scope & sequence, foto profil, gambar meeting) tetap tampil nama asli file; di daftar
  lain (lampiran PO, dokumen sales, kontrak HRD, memo, dll.) yang tampil nama acak.
- Halaman yang dulu tanpa cek login kini wajib login, kecuali halaman publik (login, absensi
  PIN `attendance.php`/`jam_waktu.php`, sertifikat `ecert/` yang dibuka lewat link/QR).

---

## 8. Pustaka pihak ketiga — WAJIB diganti sebelum go-live

Pustaka berikut tidak bisa jalan di PHP 8.4 (parse error saat di-load) dan harus diganti
dengan versi baru (butuh internet/composer di server build; tidak dilakukan di laptop ini):

| Pustaka lama | Dipakai oleh | Pengganti |
|---|---|---|
| `html2pdf/` (HTML2PDF 4 + TCPDF lama) | 15 halaman PDF: enrollmentformprev, enrollmentformprevvv, invoice-print, mca_ielts, mca_ielts_print, ocp, ocp_print, prt_refund, rpt_vip_outstanding, soaprint, ve_incentive_formm, vip_receipt_dailypdf, vip_scorerecordpoutt, vipscrcrd, printable/vipscrcrd | **Kode SUDAH disiapkan** (2026-10-28): `spipu/html2pdf` 5.x lewat Composer + adapter `_lib/html2pdf.php` — tinggal pasang pustakanya (8a). |
| `PHPExcel/` | vip_file_view.php | **Kode SUDAH disiapkan** (2026-10-29): `phpoffice/phpspreadsheet` lewat Composer — tinggal pasang (8a). |
| `ecert/dompdf/` (0.6) | ecert/capstpdf.php | **Kode SUDAH disiapkan** (2026-10-29): `dompdf/dompdf` 3.x lewat Composer — tinggal pasang (8a). Versi lama punya celah RCE — sudah diblok dari web oleh `.htaccess`; jangan disalin ke server baru |
| `PHPMailer5/` | po_entry, csr_po_entry, incentive_entry, po_entry_add_item, accnt/po_entry | Lolos lint PHP 8.4, tetapi PHPMailer 5.2 sudah EOL: disarankan `phpmailer/phpmailer` 6.x (folder `src/` di aplikasi lama sudah berisi PHPMailer 6) |

Sudah rusak sejak versi lama (folder pustaka tidak ada): `qrcode.php` (phpqrcode),
`monthly_oc_report_pdf.php` (TCPDF).

### 8a. Memasang pustaka Composer (html2pdf, PhpSpreadsheet, dompdf)

Kode sudah memakai pustaka baru: 15 halaman PDF lewat adapter `_lib/html2pdf.php` (API lama `HTML2PDF`,
`setTestTdInOnePage`, `writeHTML(..., vuehtml)`, `Output($nama)`, `HTML2PDF_exception` dipertahankan),
`vip_file_view.php` (PhpSpreadsheet) dan `ecert/capstpdf.php` (dompdf 3.x). Pemuatnya
`_lib/vendor.php`. Yang tersisa hanya memasang pustakanya:

1. Di mesin yang punya internet + PHP 8.4 + Composer 2 (dengan ekstensi di bagian 2), di folder
   aplikasi (berisi `composer.json`):
   `composer install --no-dev --optimize-autoloader`
   → membuat `vendor/` (spipu/html2pdf + tecnickcom/tcpdf, phpoffice/phpspreadsheet, dompdf/dompdf +
   dependensinya) dan `composer.lock`.
2. Salin `vendor/` (dan `composer.lock`) ke webroot server, di samping `_lib/`. Lokasi lain bisa diatur
   lewat config `'vendor_autoload' => '/path/ke/vendor/autoload.php'`.
3. `vendor/` sudah ditolak dari web oleh `.htaccess` (404); `composer.json/lock` juga.
4. **Jangan** salin folder `html2pdf/`, `PHPExcel/` dan `ecert/dompdf/` lama ke server baru (tidak
   dipakai lagi, kode PHP 5; dompdf 0.6 punya celah RCE).
5. Uji: buka mis. `soaprint.php?kdb=…`, `ocp.php?cd_cl=…`, `mca_ielts.php?kdcl=…` → PDF tampil di
   browser. Tambahkan `&vuehtml=1` untuk melihat HTML sumbernya. Bila gagal, layar menampilkan
   "PDF gagal dibuat…" dan detailnya ada di `app.log` (cari "V-CMS PDF").

Sebelum pustaka dipasang, halaman PDF menampilkan "Fitur PDF belum tersedia di server ini…"
(HTTP 503) — tidak crash.

Yang sudah diuji tanpa pustaka asli (stub perekam API, 2026-10-28): HTML yang dikirim ke generator
PDF, argumen constructor (orientasi/A4/en), `setTestTdInOnePage(false)` dan nama file `Output` —
**identik dengan kode lama** di 14 halaman yang sampai ke PDF (mca_ielts hanya beda URL link yang kini
ter-encode benar; printable/vipscrcrd tanpa parameter tidak sampai ke PDF di kedua versi). Yang
**belum** bisa diuji di laptop: render PDF sebenarnya oleh spipu 5.x — versi 5 sedikit lebih ketat
terhadap HTML yang tidak rapi dibanding versi 4; periksa hasil cetak tiap halaman di staging.
Catatan: `vip_receipt_dailypdf.php` dulu selalu crash (salah ketik `setTestthInOnePage`); kini
diperbaiki sehingga PDF-nya bisa dibuat untuk pertama kali.

PhpSpreadsheet & dompdf (diuji dengan stub perekam, 2026-10-29):
- `vip_file_view.php?nfl=…` (tombol Preview di vip_data / vip_datareport) → isi file Excel tampil
  sebagai tabel. Hanya file di folder `vipfile/`; file non-Excel → "Pratinjau hanya tersedia untuk
  file Excel"; file rusak → "File Excel tidak bisa ditampilkan." (detail di log "V-CMS Excel gagal").
  Untuk file .xls besar PhpSpreadsheet butuh memori lebih — naikkan `memory_limit` bila perlu.
- `ecert/capstpdf.php?kd=<kd_biodata>` (wajib login) → PDF `student_report_<kd>.pdf` tampil di
  browser, tampilan mengikuti desain `ecert/ca_prograss.jpg`; `&vuehtml=1` menampilkan HTML-nya.
  Butuh file baru `ecert/ca_logo.png` (ada di folder hasil) — pastikan ikut tersalin. Lihat
  proses_migrasi 4d-4.
- Sebelum pustaka dipasang kedua halaman menampilkan "Fitur … belum tersedia di server ini…" (503).
- Yang belum bisa diuji di laptop: hasil render asli kedua pustaka — periksa di staging.

---

## 9. Rotasi kredensial (wajib)

Kredensial berikut pernah tertanam di kode lama dan ikut tersalin di backup/arsip mana pun.
Kode baru sudah tidak memuatnya (diambil dari config), tetapi nilainya harus dianggap bocor:

1. Password database yang ada di `conndb.php`, `conndbs.php`, `accnt/conndb.php`,
   `ecert/conndb.php`, `ecert/db.php`, `agenda/conndb*.php`, `rw10/pemilu_conndb.php`, `bca/db.php`, dan
   `mysql_connect(...)` di `detail_sales_admission_productivity.php`, `statement.php`,
   `mgr_office_sales_by_branch_new_admin_new_period.php` -> ganti password user DB lama
   (atau hapus user itu setelah `vcms_app` dipakai).
2. Akun email SMTP di halaman PO/incentive -> ganti password akun email.
3. Token Fonnte di `kirim_wa.php` dan `dns_test.php` -> buat token baru.
4. Kredensial OAuth di `get_oauth_token.php` (bila pernah diisi) -> cabut di Google Console.

---

## 10. Checklist migrasi server

Persiapan
- [ ] Backup penuh: `mariadb-dump --all-databases --routines --events > vcms_full_<tgl>.sql` +
      arsip folder aplikasi lama. Uji restore di server staging.
- [ ] Siapkan server staging PHP 8.4 + MariaDB 11.4; restore dump ke staging.
- [ ] Upgrade data MariaDB: jalankan `mariadb-upgrade` setelah restore ke 11.4.
- [ ] Cek tabel MyISAM/charset: `SELECT TABLE_SCHEMA, ENGINE, TABLE_COLLATION, COUNT(*) FROM
      information_schema.TABLES WHERE TABLE_SCHEMA IN ('ves_data','ves_inc','ves_event','data_absen','dbsertifikat') GROUP BY 1,2,3;`
      (tetap latin1; konversi ke utf8mb4 adalah proyek terpisah).
- [ ] Buat user `vcms_app` (bagian 5); pastikan aplikasi TIDAK memakai root.

Deploy kode (staging dulu)
- [ ] Salin aset lama dari aplikasi lama ke webroot baru, **kecuali** file `.php` di root,
      `accnt/`, `ecert/`, `printable/`, `cetak/`, `printing/` dan folder `backup/`, `trial/`,
      `vcms/` (berisi dump SQL), `catatan/`, `New folder*`, `_tmp_*`.
- [ ] **Sangat disarankan**: DBA menjalankan `usulan/index_performa_up.sql` (2 index, tanpa
      mengubah data; lihat `usulan/usulan_index_performa.md`). Tanpa index ini setiap halaman
      ber-header ±2 detik lebih lambat dan halaman absensi kelas (acdcal dll.) bisa puluhan detik.
- [ ] **WAJIB sebelum kode di-deploy**: DBA menjalankan `usulan/nama_file_asli_up.sql` (kolom
      `nama_asli` di 9 tabel; instan, tanpa lock — lihat `usulan/usulan_skema_nama_file.md`).
      Kode baru menulis & membaca kolom ini; tanpa kolom, upload lampiran PO/dokumen/memo/kontrak
      gagal dan daftar lampiran kosong. Cek: `SELECT table_name FROM information_schema.columns
      WHERE table_schema='ves_data' AND column_name='nama_asli';` → 9 baris (`file_student` dan
      `acd_material` harus ada di server; di laptop kedua tabel itu tidak ada).
- [ ] Pastikan folder upload ada dan bisa ditulis user PHP-FPM (upload ke folder yang tidak ada
      gagal, sama seperti dulu): gbstaff, gbpdo, gbmaterial, gb, e_sign, e_sign/speciment, ctrct,
      doc_vos, fncfile, gudangfile, po_docs, brg_img, rulesmemofile, vipscsq, vipfile, imgs/meeting,
      uploads/inventory_docs, uploads/inventory_photo, ecert. Aplikasi menaruh `.htaccess`
      anti-eksekusi otomatis di folder upload saat file pertama masuk (berlaku di Apache; di
      server lain terapkan aturan setara dari bagian 6).
- [ ] Salin isi paket `vcms_php8/` ke webroot (menimpa).
- [ ] Folder lain yang berisi PHP lama dan **tidak dikonversi** (`quizz/`, `newdata/`, `agenda/`,
      `bca/`, `rw10/`, `ptest/`, `modal/`, `mca_print/`, `pblc/`, `imgs/*.php`, `dtleads/`,
      `inventory/`, `pages/`): jangan di-deploy, atau blok aksesnya, sampai dikonversi
      (lihat proses_migrasi.md). Catatan: `bca/cron.php` kemungkinan dijalankan cron.
- [ ] Ganti pustaka (bagian 8).
- [ ] Buat config privat (bagian 4), php.ini (bagian 3), `.htaccess` (bagian 6).
- [ ] Buat folder upload + `.htaccess` + hak tulis `www-data`.

Uji di staging
- [ ] `php -l` semua file: `find /var/www/vcms -name '*.php' -not -path '*/html2pdf/*' -print0 | xargs -0 -n1 php -l | grep -v 'No syntax'`
- [ ] Login/logout, ganti password, menu sesuai jabatan.
- [ ] Alur billing: buat billing VIP, bayar, cetak kwitansi/print, hapus billing belum bayar.
- [ ] Input skor, jadwal guru, kalender, absensi PIN.
- [ ] Upload dokumen (PDF/JPG) di beberapa modul; coba upload `.php` -> harus ditolak.
- [ ] Export Excel (sales_xl, leaving_xl, admxl, dst.) dan cetak PDF (setelah pustaka diganti).
- [ ] Pantau `/var/www/vcms_private/logs/app.log` & log PHP selama uji.

Go-live
- [ ] Jadwalkan downtime; set aplikasi lama read-only/maintenance.
- [ ] Dump ulang DB produksi -> restore ke server baru -> `mariadb-upgrade`.
- [ ] Arahkan DNS / VirtualHost ke server baru; HTTPS aktif; aktifkan HSTS setelah stabil.
- [ ] Rotasi kredensial (bagian 9).
- [ ] Pantau log 1-2 minggu; simpan server lama (mati, tidak terekspos) untuk rollback.

Rollback
- Arahkan kembali ke server lama; data yang masuk selama di server baru diekspor manual
  (tabel transaksi: vip_billing, vip_billing_payment, vip_teacher_schedule, tb_log_activities, dll.).
