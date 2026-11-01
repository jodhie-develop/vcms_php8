# Proses migrasi V-CMS ke PHP 8.4

Catatan kerja konversi `C:\vcms` (PHP 5.2 + `mysql_*`) menjadi `C:\vcms_php8` (PHP 8.4,
PDO + prepared statement). File asli di `C:\vcms` tidak diubah. Tidak ada koneksi ke server
produksi atau ke luar laptop; semua pengujian memakai MariaDB lokal.

Panduan deploy: `DEPLOY.md`. Daftar file yang tidak dibawa: `_lib/SKIPPED.md`.

---

## 1. Ringkasan

| | Jumlah |
|---|---|
| File `.php` di cakupan (root, `accnt/`, `ecert/`, `printable/`) | 830 |
| Dilewati (backup/trial, debug, orphan, rusak sejak versi lama) — lihat `_lib/SKIPPED.md` | 94 |
| Dikonversi manual/semi-otomatis, diuji per batch dengan persetujuan (Tahap 2, batch 1–8) | 44 |
| Dikonversi dengan konverter otomatis + perbaikan manual (setelah batch 8) | 692 |
| Tambahan di luar cakupan karena di-link langsung oleh halaman aktif (`cetak/invrefund.php`, `cetak/invtest.php`, `printing/po_print.php`) | 3 |
| **Total file PHP di `vcms_php8`** (di luar `_lib/`) | **739** |

Semua 739 file lolos `php -l` (PHP 8.4) dan pemindaian keamanan otomatis (bagian 5).
(Ditambah 3 file `.phpx` yang bukan PHP aktif — tidak dibawa.)

---

## 2. Tahapan

- **Tahap 1** – inventaris file (pola `mysql_*`, input, upload, short tag, dll.).
- **Tahap 2** – fondasi `_lib/`: config di luar webroot, PDO (latin1, `EMULATE_PREPARES` off,
  multi-statement off), sesi aman (HttpOnly, SameSite=Lax, strict mode), header keamanan,
  CSRF global untuk semua POST, helper escape (`e`, `js`, `u`), input (`in_*`), auth/role,
  upload aman. Halaman inti: conndb*, profiledata, atas, left, login, loginpop, logout, index.
- **Tahap 3, batch 1–8** (disetujui per batch): leaderboard, vip_activities, chgpwd, survey,
  vip_agendadel, entryact*, teachercalendar*, freeteachercalendar, slotteachercalendar,
  teacher_master, vip_shitupd, vip_teacher_free*, vip_order_*, vip_class_student_list,
  vip_del_conf, vip_score*, vip_student_list, vipbill, vipbill_del, vipbillprint, vipbillreceipt.
- **Tahap 3, sisa file** (mode otomatis sesuai instruksi "lanjutkan setiap batch tanpa
  persetujuan sampai 100%"): konverter berbasis token + perbaikan manual + pengujian (bagian 3–5).
- **Tahap 4** – `DEPLOY.md`: php.ini, user MariaDB hak minimal, `.htaccess`, checklist migrasi.

---

## 3. Cara konversi file sisa

Konverter otomatis (alat bantu di scratchpad sesi, tidak ikut deploy) memproses tiap file:

1. Short open tag `<?` → `<?php` (402 tempat); literal oktal tidak valid (`08`) → desimal.
2. `include "x.php"` → `include __DIR__ . "/x.php"`; include ke luar folder aplikasi
   (`../conndb.php` di file root) diarahkan ke file di folder yang sama.
3. `$_GET/$_POST/$_REQUEST['k']` → `in_val('k', ...)`.
4. **SQL**: 4.545 pemanggilan `mysql_query` dan 5.933 perakitan string query diubah menjadi
   prepared statement (`db_query`, `q_set`/`q_add` untuk query yang dirakit bertahap,
   `db_in()` untuk `IN (...)`, `kol_harga()` untuk kolom harga per cabang).
   `mysql_query(...) or die("pesan")` → `db_query_or_die("pesan", ...)` (perilaku sama:
   SQL gagal → pesan yang sama, detail hanya ke log). `die(konstanta_tak_terdefinisi)` → string.
5. Fungsi `mysql_*` lain → PDO (`fetch`, `rowCount`, `db_insert_id`, `db_affected_rows`,
   `mysql_data_seek(…,0)` → `execute()` ulang). `mysql_connect` dengan password di kode dihapus.
6. Aritmetika/perbandingan gaya PHP 5 → `num()`, `div()`, `cnt()` (24.156 / 175 / 53 tempat):
   `'5000' - ''`, `'' == 0`, pembagian nol, `count(null)` tidak lagi fatal dan hasilnya sama
   dengan PHP 5.
7. **Escape output**: 19.450 `echo`/`print`/`<?=` dibungkus `e()` (konteks URL: `e(u())`).
8. **Form**: 395 form POST diberi `csrf_field()`. Aksi tulis lewat form GET (tombol
   Save/Submit) diubah menjadi POST + CSRF.
9. Cek login (`auth_require_login()`) di setiap halaman, kecuali halaman publik (login,
   absensi PIN `attendance.php`/`jam_waktu.php`, sertifikat `ecert/` tanpa sesi).
10. `csrf_guard_get()` di 272 halaman yang menulis DB: link aksi lama (Delete/Approve/
    Generate lewat URL) tetap jalan bila diklik dari dalam aplikasi; dari situs lain muncul
    halaman konfirmasi.

Perbaikan manual setelah konverter:

| File | Perbaikan |
|---|---|
| 24 halaman upload (acdcal, brg_*_save, po_entry, po_upload_file, vip_updoc_save, …) | `upload_move()`: whitelist ekstensi yang sama dengan kode lama, cek isi (finfo + getimagesize), nama file acak, batas ukuran lama, `.htaccess` anti-eksekusi di folder upload |
| `upload.php`, `simpanttd.php`, `mob_po_detail_display.php`, `mob_po_ttd.php`, `po_detail_display*.php`, `ttd_spe.php` | Tanda tangan base64: **celah web shell** — ekstensi file diambil dari teks kiriman browser (`data:image/php;base64,...` menulis `.php`). Kini tipe dari isi file, hanya png/jpg/gif/webp, nama acak |
| `vip_set_del.php` | **Hapus file sembarang**: `unlink($_GET['vip_file'])` → `safe_unlink()` hanya di folder upload |
| `doc_del_img.php`, `po_del_img.php`, `brg_update_save.php` | `unlink()` dengan `basename()` |
| `sales_xl.php`, `leaving_xl.php`, `sales_productivity_form_xl.php`, `admxl.php`, `komisireportaccxl.php` + 30 halaman pemanggil | SQL lengkap dikirim lewat URL (`?q=SELECT ...`) dan sesi. Parameter prepared statement ikut disimpan di sesi; SQL tidak lagi muncul di URL |
| `brg_list.php`, `vip_rpt_monthly_payment.php`, `vip_academic_review_notif_api.php`, `ca_receipt*.php` | Filter dinamis / `IN (...)` → placeholder + parameter |
| `teacher_master_upd.php` | Hapus rate lewat link GET → form POST + CSRF + konfirmasi |
| 6 halaman (bim_att, book_inventory*, book_stock, invoicebillreceipt) | Blok simpan `isset($_GET['Save'])` tanpa tombol pemicu → hanya POST + CSRF |
| `po_entry.php`, `csr_po_entry.php`, `incentive_entry.php`, `po_entry_add_item.php`, `accnt/po_entry.php`, `kirim_wa.php` | Password SMTP & token Fonnte di kode → `config.php` (`smtp`, `fonnte_token`) |
| `detail_sales_admission_productivity.php`, `statement.php` | `mysql_connect` dengan password di kode → koneksi bersama (`mgr_office_sales_by_branch_new_admin_new_period.php` dilewati: file wajibnya tidak ada) |
| `student_list.php` | Versi lama selalu fatal (`MYSQL_ASSOC(...)` bukan fungsi); diperbaiki sesuai maksudnya (read-only JSON) |
| `cact_add.php` | Lihat keputusan terbuka #1 |
| `left.php`, `accnt/left.php` (Tahap 2) | Bug ditemukan saat uji: `left.php` baru mengisi `$kd_cbg` default sehingga mengubah query halaman pemanggil (mis. aktifitas.php). Diperbaiki: variabel halaman tidak disentuh |

Fondasi `_lib/` yang ditambah setelah batch 8: `db_query_or_die`, `db_affected_rows`, `db_query`
menerima SQL kosong (hasil kosong, seperti `mysql_query(null)` dulu), `upload_move`,
`upload_random_name`, `upload_allow`, `upload_save_dataurl`, `safe_unlink`, `csrf_guard_get`;
`e()` kini mempertahankan tag format aman pada rich text (bagian 6) dan memperbaiki byte latin1;
error handler meredam warning PHP 8 yang dulu notice (variabel/indeks tak terdefinisi, `null`
ke fungsi string) — perilakunya sama dengan PHP 5, hanya pesannya.

---

## 4. Pengujian

Lingkungan: PHP lokal di `C:\php84` — **koreksi 2026-10-28: versinya ternyata PHP 8.5.12**, bukan
8.4; kode tidak memakai fitur khusus 8.5, tetapi uji ulang di PHP 8.4 (staging) tetap perlu.
MariaDB lokal (salinan data; database `data_absen`, `dbsertifikat`, `ves_event`, `billing*` dan
beberapa tabel tidak ada di lokal), user uji sementara `zz_vcms_test`.

1. **Lint**: semua 739 file `php -l` PHP 8.4 — lolos.
2. **Golden diff (halaman read-only)**: kode asli dijalankan di server lama (PHP 8.4 + shim
   `mysql_*`→`mysqli`, short tag on) dan dibandingkan HTML-nya dengan versi baru, sesi login sama.
   Hasil: lihat bagian 4a.
3. **Smoke test (halaman yang menulis DB)**: setiap halaman di-GET tanpa parameter memakai
   user DB **read-only** khusus uji (`vcms_smoke_ro`), sehingga tidak ada data yang berubah;
   dicatat error PHP/SQL dan percobaan tulis saat GET. Hasil: bagian 4b.
4. **Uji tulis lama vs baru** (batch 6–8 dan validasi konverter): skor, billing, pembayaran,
   hapus — hasil tabel identik, termasuk penolakan POST tanpa token CSRF.
5. **Uji keamanan unit**: `e()` terhadap 20 payload XSS (script, on*=, javascript:, svg,
   iframe asing, kutip bertingkat) — semua ter-escape; `csrf_guard_get()` — lintas situs 403,
   dari aplikasi 200.

### 4a. Golden diff (419 halaman read-only, dibuka tanpa parameter)

| Hasil | Halaman |
|---|---|
| **Sama** dengan versi lama (setelah normalisasi token CSRF/entity/URL-encoding) | 265 |
| Beda — versi lama crash/berhenti lebih awal di server pembanding PHP 8, versi baru tampil penuh | 32 |
| Beda — lingkungan lokal (database `data_absen`/`dbsertifikat`/`billing*`, tabel/kolom, ekstensi GD tidak ada) | 24 |
| Beda — pesan error sama ("Wah error nih…"), versi baru menambah detail (hanya mode dev) | 24 |
| Beda — link export kini `?q=1` (SQL tidak lagi di URL) | 14 |
| Beda — pustaka lama tidak jalan di PHP 8 (html2pdf/PHPExcel/dompdf), lihat keputusan #2 | 12 |
| Beda — laporan sangat berat (query N+1 tanpa index) timeout di **kedua** versi | 5 |
| Beda — SQL debug yang dulu dicetak ke halaman kini tidak tampil | 3 |
| Beda — ditinjau manual satu per satu, semuanya terjelaskan (di bawah) | 39 |

Catatan penting: server pembanding menjalankan kode lama di PHP 8.4 (bukan PHP 5), sehingga
perbandingan longgar PHP 8 (`'' == 0` → false) membuat beberapa halaman lama berbeda dari
perilaku produksi. Versi baru meniru PHP 5 (`num()`), jadi pada kasus ini versi baru-lah yang
sesuai produksi. Hasil tinjauan 39 halaman:
- `vip_mst_form`, `purchasing`, `invoicebilllist`, `event_commision`, `vip_teacher_activities`,
  `vip_open_class_*` (laporan besar), `ve_inc_list_claim`, `vip_outstanding`, `vpro_sales_center`,
  `vip_sales_center_new`, `accnt/ve_inc_list_accountingg`: perbedaan semantik PHP 5/PHP 8 di
  server pembanding atau pembanding berhenti lebih awal; query hasil konversi diperiksa setara
  (mis. `kd_class = ''` memang mengembalikan 6.542 billing bila halaman dibuka tanpa parameter).
- `acc_ves_pf`, `hr_ves_pf`: include `../atas.php` (gagal diam-diam di versi lama) kini diarahkan
  ke `atas.php` → header/menu + cek login tampil.
- `ca_oc_branch`, `liu_ves_pf`, `vip_accounting`, `vip_open_class_report_acc*`,
  `vip_sum_tchhourrptpdf`, `carry_on_student_xl_all`: hanya SQL debug yang hilang.
- `inventory_detail`: dulu SQL error karena `id =` kosong (sel kosong), kini query sah (0).
- `tbi_list_payment`: tanda `+` di nilai link kini di-encode benar (`%2B`).
- `user_log`: jam login berbeda (waktu uji). `accnt/vip_receiptt`: include `profiledata.php` yang
  tidak ada di `accnt/` — sama dengan versi lama; peringatannya hanya terlihat di mode dev.
- `enrollmentform`: fungsi `buatrp()` tidak terdefinisi di kedua versi (bug lama).
- `mca_ielts`, `printable/vipscrcrd`: html2pdf (keputusan #2).
- `vip_certificate_acc*`: **bug konversi ditemukan & diperbaiki** (lihat 4c), kini sama.

### 4b. Smoke test (251 halaman yang menulis DB, user DB read-only)

| Hasil | Halaman |
|---|---|
| OK tanpa error | 209 |
| Menulis DB saat dibuka tanpa parameter (by design: generator/export/update massal) — ditolak user read-only; kini dilindungi login + `csrf_guard_get()` | 18 |
| Error lingkungan lokal / pustaka lama / timeout laporan berat | 23 |
| Bug konversi (`profile_sales.php`: `->rowCount()` pada hasil null) — diperbaiki secara umum dengan `db_fetch()`/`db_num_rows()`; halaman ini **belum** diuji ulang satu per satu | 1 |

Halaman yang menulis saat GET: export_sc_sales_signed, export_sc_signed, inventory_generate,
inventory_move, medan_bio_update, meda_pt_update, os_inc_proses_all, pt_input, soa_generate,
soa_genfromcashdeposit, update_step, ve_inc_list_generate, vipbillreceipt_dtl_import,
vipcer_create, vipcer_create_app, vip_book_distrib_dtl, vip_stuatttupd, vos_inc_proses.

Tidak diuji: alur POST (simpan/ubah/hapus) dari ~270 halaman tulis hasil konversi otomatis
selain yang dipakai memvalidasi konverter (skor, billing, pembayaran, hapus). Sebelum go-live,
uji alur utama di staging (checklist `DEPLOY.md` bagian 10).

### 4c. Bug yang ditemukan lewat pengujian dan sudah diperbaiki

- Parameter fragmen `$area` tidak ikut dikirim (HY093) — dashboard*, leads, leadsmon.
- `left.php` mengubah `$kd_cbg` halaman pemanggil.
- `num()` pada objek hasil query (`if ($result > 0)`) → Error.
- `IN ('$daftar')` dengan `$daftar = implode("','", …)` → satu parameter (vip_certificate_acc*).
- `IN ('" . implode("','", $arr) . "')` → kini `db_in()` (ca_receipt*).
- Placeholder menempel kata berikutnya (`?group by`) — vip_class_student_list, vip_teacher_free*.
- Form POST di dalam string `echo` diberi tag PHP (parse error) — vip_room_book.
- Fungsi escape lokal (`rb_h()`) di-escape dua kali.
- `<?PHP` huruf besar, literal oktal `08`, include `../`.
- Rich text dari editor tampil sebagai kode HTML → `e()` mempertahankan tag aman (ca_invoicelist kini sama).
- Byte latin1 ("Café") tampil "�" → dikonversi ke UTF-8.
- Warning PHP 8 untuk hal yang dulu notice (variabel/indeks/offset tak terdefinisi) diredam.
- 5 file yang masih dipakai sempat terlewat (bim_list, vipcertificatexl,
  vip_open_class_report_accounting, vip_open_class_report_accountingtry,
  ecert/ecertbimvista2022) — kini dikonversi; bim_list & vip_open_class_report_accounting sama
  dengan versi lama, vipcertificatexl versi lama crash di pembanding. Di
  vip_open_class_report_accounting* daftar `IN ($billing_ids_sql)` dibiarkan sebagai fragmen
  karena isinya hasil `intval()` (hanya angka).
- (2026-10-28) Query yang gagal menghentikan seluruh halaman, padahal `mysql_query()` lama hanya
  mengembalikan `false` dan sisa halaman tetap tampil. Contoh: `ve_monitoring.php` baris 620
  memakai `a.kd_branch` tanpa alias `a` (selalu gagal, juga di produksi) sehingga halaman baru
  berhenti di tengah. Diperbaiki di `_lib/db.php` dengan fungsi baru `db_query_soft()`: error
  dicatat ke `app.log` (+ pesan merah di layar hanya bila `APP_ENV` dev) lalu dikembalikan hasil
  kosong. **Revisi (uji upload, 28-10):** versi pertama perbaikan ini membuat `db_query()` sendiri
  "gagal diam", sehingga file batch 1–8 tulisan tangan (vipbill, vipbillreceipt, login, …) dan
  overlay — yang mengandalkan query gagal = halaman berhenti, setara `or die` — ikut terus berjalan
  (risiko tulis sebagian). Kini: `db_query()` kembali ketat (exception → halaman berhenti);
  `db_query_soft()` hanya dipakai di 355 file hasil konverter otomatis, menggantikan `db_query()`
  yang berasal dari `mysql_query($q)` tanpa `or die` (1.213 panggilan, semua lolos lint);
  `db_query_or_die()` tetap berhenti dengan pesan lamanya. Overlay yang `or die`-nya sempat hilang
  dipulihkan: material_input, brg_list (7), brg_new_save, brg_update_save, teacher_master_upd (4).
  Uji regresi: 13 halaman baca + 33 halaman batch — semuanya tampil seperti sebelumnya.

- (2026-10-28, dilaporkan pemilik saat uji di browser) **Form bersarang**: `entrydata.php` di-submit
  tanpa pesan apa pun. Penyebab: halaman lama punya `<form method=get>` yang membungkus
  `<form>` kedua; browser **mengabaikan tag form di dalam form yang masih terbuka**, jadi semua
  field terkirim lewat form luar (GET). Konverter mengubah form dalam ke POST + CSRF dan handler
  ke `$_POST`, sementara form luar tetap GET → submit hanya memuat ulang halaman. Uji otomatis
  sebelumnya tidak menangkapnya karena parser HTML-nya (libxml) tidak meniru aturan browser.
  Deteksi ulang dengan parser HTML5 PHP (`Dom\HTMLDocument`, aturan sama dengan browser) di semua
  339 halaman berform + pemindaian sumber: **41 halaman** terdampak, semuanya di versi asli
  luar=GET & dalam=GET (jadi murni akibat konversi). Perbaikan: form luar dijadikan
  `method="post"` + `csrf_field()` (accnt/po_item_dtl_upd, activites_new, ca_invoice_paid,
  entrydata, entrydataa, entryworking_hor(_admin/_set/_upd), hapuskelas, hapuspot,
  institution_update, institutionaddevent, institutionupdate, inv_del, inv_event, inv_event_fu,
  inv_event_payment, inv_leaving, inv_void, invoice_generator(upd), leadsupdate, onoff_clupd,
  pay_leaving, po_item_dtl_upd, quizupdate, rubahdata, soaupd, vip_clupd, vip_crshupd,
  vip_lcupd, vip_order_class, vip_otbupd, vip_set_del, vip_stucmdupd, vip_ttrupd, vipbook_del,
  vipquiz, vipquizreview, wh_upd). Tidak ada field form yang dibaca khusus dari `$_GET`.
  Verifikasi: parser HTML5 → 0 tombol yang handler-nya butuh POST tetapi form efektifnya GET;
  simulasi browser submit `entrydata.php` → alert "New Scheduled has been set" + redirect ke
  acdcal, jadwal tersimpan. Bukan masalah (sudah dicek): `institution.php` (form dalam sudah POST
  sejak versi asli), `survey.php` (kata `<form>` di komentar), `invoicebill*`, `vproaddstu`,
  `vprro_invnew` (form di dalam tabel — browser tetap mengaitkan tombol ke form-nya).

### 4d. Uji jalan di laptop (2026-10-28)

Aplikasi dijalankan di `http://localhost:8000` (`php -S` + `C:\vcms_private\dev_router.php`,
aset statis dibaca dari `C:\vcms`). Login oleh pemilik aplikasi berhasil. Lalu 419 halaman
read-only dibuka otomatis sebagai user uji (ACD/AS) di server terpisah :8010:

| Hasil (setelah perbaikan `db_query` di atas, halaman gagal diuji ulang satu per satu) | Halaman |
|---|---|
| Tampil normal (HTTP 200, tanpa error PHP)¹ | 372 |
| Pustaka lama belum diganti (html2pdf 10, TCPDF, phpqrcode, PHPExcel, dompdf) | 14 |
| Lingkungan lokal: ecert (gambar template `*.jpg`/font di `C:\vcms\ecert` tidak ada di paket + DB `dbsertifikat`), `data_absen` | 17 |
| Laporan sangat berat, > 180 detik (sama seperti versi lama, tanpa index) | 8 |
| Kosong tanpa parameter — memang begitu (materialsave, simpanttd, doc_view_img, excel_reader2 = file pustaka, vip_academic_review_auth = API) | 5 |
| Bug lama, sama dengan versi asli: `enrollmentform` (`buatrp()` tidak ada), `accnt/vip_receiptt` + `accnt/logout` (include `profiledata.php`/`atas.php` yang tidak ada di `accnt/`) | 3 |

¹ Termasuk 5 halaman yang tabelnya tidak ada di DB lokal (hrd_ctrct_dtl, rpt_csr, student_list,
ve_certi_list, vip_oc): kini tampil tanpa bagian itu, seperti versi lama.

Catatan:
- Laporan berat: progress_admission, sales_hitung, vip_open_class_report_acd_ira,
  vip_student_profile, vip_scorerecordpout, vip_scorerecordpoutt, mca_ielts, mca_ielts_print.
  Halaman lain yang sempat timeout saat 4 penguji jalan bersamaan ternyata selesai 2–20 detik
  bila dibuka sendiri.
- Ekstensi `gd` di `C:\php84\php.ini` masih nonaktif; server lokal kini dijalankan dengan
  `-d extension=gd` (php.ini tidak diubah). Di server produksi `gd` wajib aktif (DEPLOY bagian 2).
- `vipscrcrd.php` & `printable/vipscrcrd.php`: path `dirname(__FILE__).'../html2pdf/...'` tanpa
  `/` sudah salah sejak versi asli — perbaiki sekalian saat mengganti html2pdf.
- `vip_oc.php` tanpa `?kd_cbg=` memakai `$nm_db` kosong (`FROM .tb_pay_dtl`) — sama dengan asli.

### 4d-3. Pengganti html2pdf (2026-10-28)

Pustaka lama `html2pdf/` (4.01, PHP 5) diganti `spipu/html2pdf` 5.x lewat Composer
(`composer.json` baru; `vendor/` diblok `.htaccess`). Adapter `_lib/html2pdf.php` menyediakan
API lama (`HTML2PDF`, `HTML2PDF_exception`, `writeHTML($html, $vuehtml)`, `Output($nama, $dest)`)
di atas spipu, nama file PDF dibersihkan (tanpa CR/LF/path, wajib `.pdf`), error PDF → pesan umum
+ detail di log, dan bila pustaka belum dipasang → pesan "Fitur PDF belum tersedia" (503).
Perubahan per halaman (15): hanya baris `require` dan isi `catch` (`echo e($e)` → `html2pdf_fail($e)`);
`vip_receipt_dailypdf` juga salah ketik `setTestthInOnePage` (fatal sejak dulu) diperbaiki;
`vipscrcrd`/`printable/vipscrcrd` path lama `dirname(__FILE__).'../html2pdf'` (rusak di Linux) ikut
beres karena kini memakai `VCMS_ROOT`.
Uji dengan stub perekam API di kedua versi (kode lama + stub HTML2PDF 4; kode baru + stub spipu),
parameter dari data nyata: **14 halaman input PDF identik** (HTML, orientasi, nama file); mca_ielts
hanya beda URL link yang kini ter-encode; printable/vipscrcrd tanpa parameter tidak sampai ke PDF di
kedua versi. soaprint & vip_receipt_dailypdf dibandingkan setelah menambal salinan lama (number_format
PHP 8, salah ketik). Juga diuji: `?vuehtml=1`, pesan error tanpa detail (detail di log), nama file
berbahaya, dan mode tanpa pustaka (15/15 → 503 dengan pesan). Render PDF asli oleh spipu 5.x belum
bisa diuji (pustaka belum diunduh) — DEPLOY bagian 8a.

### 4d-4. Pengganti PHPExcel dan dompdf ecert (2026-10-29)

Pemuat Composer dipindah ke `_lib/vendor.php` (`vendor_require()` → 503 + pesan bila pustaka belum
dipasang, `vendor_fail()` → pesan umum + detail di log); `_lib/html2pdf.php` kini memakainya (pesan
ke pengguna tidak berubah). `composer.json` ditambah `phpoffice/phpspreadsheet` (^4/^5) dan
`dompdf/dompdf` ^3.1.

- `vip_file_view.php` (pratinjau laporan VIP): PHPExcel → PhpSpreadsheet (`Excel5`→`Xls`,
  `Excel2007`→`Xlsx`, writer `Html`, semua sheet — alur sama). Tambahan keamanan: path dari DB hanya
  boleh menunjuk file di folder `vipfile/` (semua 445 baris lokal memenuhi). File non-Excel (dulu fatal
  error) → "Pratinjau hanya tersedia untuk file Excel"; file hilang → "File tidak ditemukan."; file
  rusak → "File Excel tidak bisa ditampilkan." (detail di log "V-CMS Excel gagal").
- `ecert/capstpdf.php`: dompdf 0.6 → dompdf 3.x (`loadHtml`/`setPaper`/`render`/`stream` inline).
  Opsi aman: gambar lokal hanya dari folder `ecert/` (chroot, base path sama seperti 0.6), tanpa
  akses URL luar, tanpa PHP/JavaScript di HTML. Error → "PDF gagal dibuat…", detail di log.
- Uji (stub perekam; DB tidak berubah — uji path berbahaya memakai UPDATE dalam transaksi yang
  dibatalkan): capstpdf lama vs baru dengan data nyata → HTML ke dompdf **identik** kecuali `&` di
  href kini `&amp;` (HTML benar, URL sama), kertas A4 portrait & nama `student_report.pdf` inline sama.
  vip_file_view: xls/xlsx nyata → reader & writer benar; file hilang, nfl tidak ada, pdf, traversal
  `vipfile/../_lib/…`, path absolut, file rusak, dan tanpa pustaka → pesan yang benar.
  Render asli PhpSpreadsheet/dompdf belum bisa diuji (belum diunduh).
- Temuan di kode asli: `capstpdf.php` memakai `kd_biodata` tetap `'2510201592584414'` di SQL
  (parameter `?kd=` diabaikan), atribut HTML-nya `class=\"…\"` (CSS tidak berlaku), `ca_logo.png`
  tidak ada. **Diperbaiki atas persetujuan pemilik (2026-10-29):**
  - SQL memakai `?kd=` (prepared); kd kosong/tidak ada → "Data not found".
  - Wajib login staf (dulu publik tetapi terkunci ke satu siswa; dengan `?kd=` laporan siswa mana
    pun bisa dibuka, jadi tidak dibiarkan publik). Bila orang tua perlu membuka langsung, butuh link
    bertoken — belum dibuat.
  - Tampilan dibuat ulang mengikuti desain `ecert/ca_prograss.jpg` (header logo + judul, 5 kolom
    informasi siswa, baris Main Activities / Participation / Progress Today, kotak Primary Strength &
    Support Area, Parent Update, Teacher Comment, tombol View Evidence, footer). Logo baru
    `ecert/ca_logo.png` dipotong dari `ca_prograssx.jpg`.
  - Label diperbaiki: dulu "Main Activities Done" berisi Progress_Today; kini Progress_Today tampil di
    baris "Progress Today" dan "Main Activities Done" = "-" (tidak ada kolomnya, seperti Topic Covered).
  - Attendance 1/Y → "Present", 0/N → "Absent"; tanggal pertemuan (`date_cl`) di subjudul; komentar
    guru dari editor (HTML) tetap terpisah per paragraf/butir list; tombol View Evidence hanya untuk
    link http(s); nama file `student_report_<kd>.pdf`; `&vuehtml=1` menampilkan HTML sumber.
  - Diuji: 2 data lokal dirender dengan Edge headless (tampilan sesuai desain), jalur PDF (stub),
    tanpa login, kd kosong/tidak ada/injeksi. Render dompdf asli belum diuji.

### 4d-5. Performa acdcal.php + index (2026-10-29)

Laporan pemilik: `acdcal.php?kdcl=VEABEP 06060606-01-01&kdcbg=1` sangat lambat (±27 s). Penyebab:
query jumlah hadir per pertemuan di `vip_attendance` (±1,6 juta baris, tanpa index) dijalankan 20×,
plus UPDATE jam logout `tb_report_user_login` di `atas.php` (±2 s, setiap halaman). Perbaikan: kode
acdcal mengambil jumlah hadir sekali (GROUP BY; hitungan identik, diuji 5 kelas/71 pertemuan) →
3,9 s; ditambah 2 index (`usulan/index_performa_up.sql`, diterapkan di DB lokal) → **0,24 s**. HTML
halaman identik dengan sebelum perbaikan. Detail: `usulan/usulan_index_performa.md`; DEPLOY bagian 10.

### 4d-6. Nama database bisa diatur (shared hosting berawalan) (2026-10-29)

Kode menulis nama database di query ±4.200× (568 file; `ves_data`, `ves_inc`, juga `billing*`,
`absensi`, `hrd`, `ves_event`, `vistaedu_optimus`). Semua akses DB lewat `_lib/db.php`, jadi
ditambah pemetaan config `db_names` (contoh di `config.sample.php`, DEPLOY 5a): `db_use()`
memakai nama sebenarnya, dan `db_map_sql()` mengganti awalan `nama.`/`` `nama`. `` di setiap SQL
sebelum dikirim (isi string/komentar tidak disentuh; ±0,07 ms/query). Tanpa `db_names` = perilaku
lama. Uji:
- unit 13 kasus (backtick, huruf besar, spasi, string berisi nama DB, komentar `-- don't`,
  `a--b`, nama mirip `my_ves_data`/`ves_datax`);
- salinan `zzhost_ves_data`/`zzhost_ves_inc` (362 tabel, checksum identik) + user DB yang **hanya**
  berhak atas `zzhost_*` → query yang lolos tanpa terjemahan pasti ditolak & tercatat;
  crawl 731 halaman di :8000 (asli) vs :8030 (berawalan): 712 identik; 9 beda karena database lain
  yang sengaja tidak dipetakan saat uji (`billing*`, `absensi`, `hrd`, `ves_event` → "denied",
  membuktikan deteksi); 10 beda karena laporan berat terpotong batas 30 detik di **kedua** server
  (urutan SQL identik sampai titik berhenti — dicek via general log);
- tulis: login, ganti password, INSERT berawalan + JOIN lintas DB → masuk ke salinan, `ves_data`
  asli tidak berubah. Lingkungan uji dihapus sesudahnya.

Temuan sampingan — halaman yang melebihi 30 detik di laptop (perlu optimasi / `max_execution_time`
lebih besar di server): accnt/purchasingorder, freeteachercalendar, progress_admission,
sales_contoh, sales_hitung, vip_class_student_list, vip_scorerecordpout(t), vip_student_profile.

### 4d-2. Uji manual pemilik aplikasi di browser (2026-10-28)

Pemilik aplikasi mencoba halaman di http://localhost:8000 sementara `app.log` dipantau.
- Sesi 1 (15.37–16.5x): ditemukan `entrydata.php` submit tanpa pesan → bug form bersarang,
  41 halaman diperbaiki (lihat 4c). Setelah perbaikan dikonfirmasi pemilik: "sudah bisa".
- Sesi 2 (16.56–17.12): **0 baris log** — tidak ada error PHP, SQL gagal, CSRF ditolak, upload
  ditolak, atau akses ditolak. Logging :8000 diverifikasi aktif (login palsu tercatat 17.12:40).

### 4e. Uji simpan/ubah lama vs baru (2026-10-28)

Cara: DB lokal di-backup dulu (`C:\vcms_private\backup\sebelum_uji_tulis_20261028.sql`), lalu
untuk setiap halaman yang punya form POST (339 file) form dibuka sebagai user uji, diisi otomatis
(nilai yang sudah ada dipakai, field kosong `ZZTEST`/tanggal hari ini/angka 1), lalu nilai yang
sama dikirim ke versi baru dan ke kode asli (server pembanding PHP 8 + shim). Semua
INSERT/UPDATE/DELETE yang sampai ke MariaDB direkam (general log) dan dibandingkan setelah
normalisasi (kutip angka, jam, spasi). Kedua versi dijalankan dari **salinan** di folder
sementara agar file yang ditulis halaman tidak masuk ke `C:\vcms`. Halaman yang bisa mengirim
email/WhatsApp atau membuka koneksi keluar dilewati (11 form). Sesudahnya DB dipulihkan dari
backup dan diverifikasi bersih; general log dikembalikan ke setelan semula.

| Hasil (form; form berulang per baris dihitung 2) | Jumlah |
|---|---|
| Query tulis **sama persis** (ada tulis: 62, tanpa tulis: 218) | 280 |
| Kode lama crash di pembanding PHP 8 (`or die(errro_x)` = konstanta tak terdefinisi); query sebelum crash sama | 12 |
| Tabel/kolom/database tidak ada di DB lokal (`budgeting`, `ves_event`, `hr_type`, `cp`, …) — query asli juga gagal | 6 |
| Token CSRF disisipkan JavaScript (`atas.php`) — harness tidak menjalankan JS; di browser normal | 6 |
| Berbeda — semuanya ditinjau, **tidak ada bug konversi** (rincian di bawah) | 22 |
| Tidak ada form bila dibuka tanpa parameter / dilewati | 43 / 13 |

Rincian 22 yang berbeda:
- Efek urutan uji (versi baru menyimpan duluan, versi lama lalu menemukan data "sudah ada"/bentrok
  jadwal/nomor urut berikutnya): device_invent_upd, inventory_reg, invoice_generator,
  invoicebillliu, po_sup_new, rubahdata, vip_ca_crshupd, vip_lcupd, vip_room_master,
  vip_upfile_new_cat.
- Kode lama menulis id tanpa kutip (`where no = ZZTEST` → error SQL); dengan id angka (pemakaian
  nyata) sama: inv_del, inv_void, wh_upd.
- Disengaja sejak batch awal: vipbill_del, vip_del_conf (hapus hanya via POST + cek status),
  ttd_spe (tanda tangan bukan gambar valid ditolak, dulu tersimpan path rusak).
- Spasi di awal/akhir input kini dipangkas (lihat bagian 6): vip_crshupd, vip_order_class.
- leadsupdate: nilai berisi `'` dulu merusak SQL (tersimpan terpotong), kini tersimpan utuh.
- Lain-lain: vip_mca_teacher_quiz (artefak harness), vos_inc_upd (`'' == 0` di pembanding PHP 8;
  versi baru mengikuti PHP 5 produksi), vip_student_recordd (timeout di kedua versi).

Temuan untuk deploy: `vip_scorerecord.php` (±8.500 field) dan `invoicebill.php` (±5.600) melebihi
`max_input_vars = 5000` — saran di DEPLOY dinaikkan ke 10000.
Belum diuji di sini: alur yang butuh data lengkap/ID nyata (sebagian besar form dibuka tanpa
parameter, jadi banyak UPDATE memakai id kosong). Upload: lihat 4f.

### 4f. Uji upload file lama vs baru (2026-10-28)

Cara sama dengan 4e (backup `sebelum_uji_upload_20261028.sql`, salinan terisolasi berisi struktur
folder `C:\vcms` tanpa isi, general log, restore + verifikasi sesudahnya). Untuk setiap handler
upload dikirim file valid (jpg/png/pdf/csv/gif, dicoba sampai diterima) lalu 8 file serangan:
`shell.php`, `shell.phtml`, `shell.php.jpg` (isi PHP), `fake.jpg` (isi PHP), GIF valid bernama
`avatar.php`, GIF valid + kode PHP di ekor (`poly.gif`), file bernama `.htaccess`, PDF 12 MB.
Juga endpoint tanda tangan base64 (`upload.php`, `simpanttd.php`): PNG valid dan "PNG" berisi PHP.

Hasil (20 handler teruji, 4 dilewati karena juga mengirim email: po_entry, accnt/po_entry,
csr_po_entry, incentive_entry):
- **Tidak ada satu pun file berisi PHP atau berekstensi script yang tersimpan di versi baru.**
  Kode lama menyimpan `shell.php.jpg`/`fake.jpg` (isi PHP) di 16 handler yang menerima jpg, dan
  "PNG" berisi PHP di `upload.php` (e_sign/). `.php`/`.phtml` ditolak kedua versi
  (whitelist ekstensi lama), tetapi di versi lama hanya karena pengecekan ekstensi di tiap halaman.
- File valid tersimpan di kedua versi; query DB sama kecuali nama file (kini acak 32 hex,
  di folder yang diberi `.htaccess` anti-eksekusi otomatis).
- `poly.gif` (GIF valid + teks PHP) diterima sebagai `.gif` bernama acak — aman karena tidak
  pernah dieksekusi sebagai PHP (ekstensi gif, folder ber-`.htaccess`).
- PDF 12 MB: diterima di handler yang batas lamanya 50 MB (sesuai kode lama), ditolak di yang 5 MB.
- Lingkungan lokal: folder `gbpdo/`, `vipscsq/`, `vipfile/` tidak ada di salinan `C:\vcms`
  laptop (upload ke sana gagal di kedua versi) — pastikan ada di server (DEPLOY bagian 10);
  tabel `file_student`, `acd_material` tidak ada di DB lokal.
- Bug ditemukan & diperbaiki: `material_input.php` (overlay) kehilangan `or die` sehingga file
  tetap tersimpan walau insert gagal; lalu temuan lebih besar tentang `db_query` (revisi di 4c).
- Tidak teruji langsung: `acdcal.php`/`lc_acdcal.php` (form gambar meeting hanya muncul untuk
  meeting terpilih dan 3 nama user tertentu; kodenya sama dengan handler yang lolos),
  `purchasingupload.php` (input file tanpa handler — sama dengan asli), `member_add_new.php`
  (form menuju `simpanmember.php` yang tidak ada sejak versi asli).
- Nama tampilan: kolom nama terpisah (`vip_ssq.namafile`, `file_data.namafile`,
  `tb_user.namafile`, `vip_meeting_image.nama_file`) kembali berisi nama asli (dibersihkan) —
  lihat keputusan #13.

---

## 5. Pemindaian keamanan (semua file hasil)

Tidak ditemukan: sisa `mysql_*`, `eval`, `exec/system/shell_exec/passthru/proc_open/popen`,
backtick, `assert`/`create_function`, `move_uploaded_file` mentah, include dengan path dari
input, `unlink` dari input, form POST tanpa token, halaman tanpa bootstrap.
Sisa input dinamis `$_POST['field_'.$i]` (form berulang) hanya dipakai sebagai parameter
prepared statement.

---

## 6. Perubahan perilaku yang disengaja

- Output di-escape; rich text dari editor (kolom berisi `<p>`, `<br>`, `&nbsp;`, tabel, embed
  Google Maps di `mp_embed.lokasi_map`) tetap tampil sebagai format, tetapi tag/atribut
  berbahaya dibuang.
- Byte latin1 dari DB (mis. "Café") tampil benar sebagai UTF-8 (dulu "?" / "�").
- Query yang dulu gagal karena input kosong (`where id = ` tanpa nilai) kini berjalan dengan
  parameter kosong dan menampilkan hasil kosong, bukan "Wah error nih...".
- Halaman yang dulu tanpa cek login kini wajib login (67 halaman, mis. export xls, *_save,
  generator SOA/PT). Publik: lihat bagian 3 butir 9.
- SQL debug yang dulu dicetak ke halaman (`echo $query`) dihapus.
- Nama file upload baru diacak.
- Input form/URL dipangkas spasi di awal/akhir (`in_val()`/`in_str()`), mis. judul
  "Speaking 6 " tersimpan "Speaking 6". Catatan: password yang di DB berakhiran spasi tidak
  akan cocok saat login — di salinan DB lokal 2026-10-28 jumlahnya 0; cek ulang di produksi:
  `SELECT COUNT(*) FROM tb_user WHERE password <> TRIM(password)`.
- Pesan error SQL detail hanya di log (`app.log`); di layar pesan lama ("Wah error nih5")
  atau pesan umum. Query gagal tanpa `or die` tidak menghentikan halaman (sama seperti dulu),
  tetapi kini tercatat di `app.log` (cari "V-CMS SQL gagal") — berguna untuk menemukan query
  yang diam-diam rusak sejak lama.

---

## 7. Keputusan terbuka (perlu jawaban pemilik aplikasi)

1. **`cact_add.php`**: INSERT billing 'CACT' tidak pernah berhasil di versi lama (salah ketik
   `''$kdcl'` → SQL error, halaman berhenti "errro_simpan"). Dipertahankan tidak menyimpan.
   Perbaiki salah ketik (fitur mulai aktif) atau biarkan?
2. **Pustaka PDF/Excel** (`DEPLOY.md` bagian 8): html2pdf (15 halaman), PHPExcel
   (`vip_file_view.php`), dompdf ecert (`capstpdf.php`) — **kode sudah disiapkan** (4d-3, 4d-4);
   tinggal `composer install` di mesin ber-internet lalu salin `vendor/` (DEPLOY 8a).
3. **Folder PHP di luar cakupan** yang masih berisi kode PHP 5 (`quizz/` 90 file, `trial/`,
   `newdata/`, `agenda/`, `bca/` (ada `cron.php`), `rw10/`, `ptest/`, `modal/`, `mca_print/`,
   `pblc/`, `imgs/ca_oc_branch.php`, `dtleads/`, `pages/forms/certi_form.php`): tidak dikonversi
   sesuai cakupan. Tidak bisa jalan di PHP 8.4 (`mysql_*`) dan sebagian rawan SQL injection;
   jangan di-deploy/blok, atau masukkan ke tahap berikutnya.
4. **Batch 6 (belum dijawab)**: bug nama field `progress_check` dipertahankan; halaman skor
   hanya butuh login (tanpa batas jabatan); perbaikan SQL t=21 dipertahankan.
5. **Kode unik pembayaran habis** (96/96 terpakai) di data lokal — masalah data produksi yang
   sudah ada sebelumnya.
6. **Menu `vip_teacher_free*`**: sudah dibatasi ke ACD/Admin/SC/CM/ACCM (batch 4); menu di
   `left.php` masih tampil untuk jabatan lain (klik → akses ditolak). Sembunyikan menunya?
7. **Index database** yang disarankan di komentar kode lama (vip_rpt_open_class,
   vip_rpt_payment_detail) dan untuk vip_order_new/freeteachercalendar (query lambat).
8. **Halaman `ecert/` publik** yang menulis DB (`ecertcommonenglish*.php`, `vprodec.php`,
   `vprooct.php`): publik sejak versi lama (dibuka lewat link sertifikat). Tetap publik?
9. **Kolom 'fa' Debora** (catatan batch 5) — data khusus satu user, belum dikonfirmasi.
10. **File bertahun** di `_lib/SKIPPED.md` bagian 4 (pipeline_2021, productivity_2020, …): tidak
    di-link dari mana pun, jadi tidak dikonversi (aturan orphan). Konversi bila ternyata dipakai.
11. **Rotasi kredensial** (`DEPLOY.md` bagian 9) — wajib sebelum go-live.
12. **Kandidat orphan** (nama file tidak disebut di file lain mana pun; bisa saja dibuka lewat
    bookmark, QR, cron, atau URL yang dirakit JavaScript): tetap dikonversi dan wajib login,
    tetapi sebaiknya ditinjau lalu dihapus bila tidak dipakai. Termasuk skrip pemeliharaan sekali
    pakai yang menulis data saat dibuka (mis. `medan_bio_update.php` dan `meda_pt_update.php`
    meng-UPDATE massal `tb_biodata`/skor; dulu bisa dijalankan siapa pun tanpa login).
    Daftar (243 file): absensilist.php, absensilistmonth.php, accnt/po_check.php, accnt/tbi_inc_list_accounting.php, accnt/ve_inc_list_accountingg.php, accnt/vip_receipt_monthly.php, acd_cal.php, acd_dash.php, acdcall.php, acdcallnew.php, admsummary.php, bim_acdcal.php, bim_index.php, brg_img_view.php, brg_lokasi_input.php, brg_new.php, budget.php, ca_billprint.php, ca_front.php, ca_inc_list.php, ca_receipt_ori.php, ca_soastatlist.php, carry_on_student_all.php, carry_on_student_xl_all.php, carry_on_studentt.php, cavip_score.php, commmonitoring_withoutPDO.php, dashboardd.php, dashboarddd.php, dashboardmkt.php, dashboardnew.php, detail_sales_admission_productivity.php, device_invent_upds.php, e_sign.php, e_sign_entry.php, ecert/ca_prgs.php, ecert/capstpdf.php, ecert/e_diagtest.php, ecert/ecertbimvista2022new.php, ecert/ecertcommonenglish.php, ecert/ecertcommonenglishrekap.php, ecert/ecertfer.php, ecert/ecertibtmockup.php, ecert/ecertibtmockupcomplete.php, ecert/ecertibtnew.php, ecert/ecertibtt.php, ecert/ecertibtvita.php, ecert/ecertpbtmdn.php, ecert/ecertpbtnew.php, ecert/vprodec.php, ecert/vprooct.php, enroll_soa.php, enrollment.php, enrollmentform.php, enrollmentformprevvv.php, entrydataa.php, entryworking_hor_admin.php, entryworking_hor_set.php, excel_reader2.php, export_sc_sales_signed.php, export_sc_signed.php, formprogress.php, hr_ves_pf.php, incentive_entry.php, inpueventroom.php, institution_leaving_summary.php, institution_update.php, institutionevent.php, institutionsalesleaving.php, institutionupdate.php, internbill.php, internmemo.php, invoice-print.php, invoice_generatorupd.php, invoicebillprint.php, jam_waktu.php, kirim_wa.php, komisireportnew.php, lc_acdcal.php, leads_1.php, leads_pot.php, leadsmon.php, leadssum.php, leadstatement.php, leftnav.php, liu_inc_dtl.php, liu_ves_pf.php, loginnew.php, mca_ielts.php, mca_ielts_print.php, meda_pt_update.php, medan_bio_update.php, member_add_new.php, mob_po_print.php, myprofile.php, newleads_new.php, newleads_public.php, ocp_print.php, payment_refund.php, pdo-print.php, pdo-print_p1.php, pfnew.php, po_check.php, po_detail_display_with_sign.php, po_entry_add_item.php, po_entryupload.php, po_print_new.php, po_upd.php, prestuadmpdo.php, printable/careceiptinvoinceprint.php, printable/coba_print.php, printable/fer.php, printable/ildprt_refund.php, printable/prtcasoa.php, printable/vipscrcrd.php, product_sales.php, progress_admission.php, pt_generate.php, pt_input.php, pt_migrasi_input.php, ptregistration.php, purchasing.php, qrcode.php, regulation.php, regulation_new.php, rekapabsen.php, roomcalendar.php, roomusage.php, rpt_csr.php, rpt_tbi_receipt_daily.php, rpt_vip_opcl.php, rpt_vip_open_cl.php, rpt_vip_outstanding.php, rubahdata.php, rulesmemodtl.php, sales_center_app.php, sales_contoh.php, sales_hitung.php, samplecalendar.php, sc_achieve_payment.php, sc_productivity.php, sf_generate.php, simpanttd.php, situation.php, soa_generate.php, soa_generate_cashreceipt.php, soa_generate_cashreceiptonly.php, soa_generate_kredit.php, soa_genfromcashdeposit.php, soa_import.php, soa_import_cashreceipt.php, soaprint.php, stu_adm_progress.php, stuadmprogress_sc_assign.php, stuadmprogressdrat.php, sumfinstat.php, tbi_receipt_dailyxl.php, teacher_master_updd.php, teacher_salary_report1.php, thprint.php, tr_liu_inc_generator.php, ttd_spe.php, ttd_upload.php, update_step.php, user_log.php, utama.php, ve_certi_list.php, ve_certi_proses.php, ve_inc_list_generate.php, ve_inc_listt.php, ve_incentive_formm.php, ve_monitoring.php, vip_academic_review_check_api.php, vip_accounting.php, vip_banking.php, vip_book_distrib_dtl.php, vip_ca_crsh.php, vip_certificate_accc.php, vip_class_generate.php, vip_crsh_baru.php, vip_daily_report.php, vip_datareport.php, vip_import_bill.php, vip_income.php, vip_mca_ira.php, vip_mca_teacher_quiz.php, vip_mon_cm.php, vip_oc.php, vip_open_class_list_cb.php, vip_open_class_print.php, vip_open_class_report_acc_base_prg.php, vip_open_class_report_acc_base_prgxl.php, vip_open_class_report_acc_ca.php, vip_open_class_report_acc_complet.php, vip_open_class_report_acc_new.php, vip_open_class_report_accc.php, vip_open_class_report_accxl_multisheet.php, vip_open_class_report_acd_ira.php, vip_open_class_report_incentive.php, vip_open_class_reportt.php, vip_order_class.php, vip_proposed_class_add.php, vip_pt_record_updnew.php, vip_pt_record_updneww.php, vip_pt_recordnew.php, vip_receipt_dailycek.php, vip_receipt_dailypdf.php, vip_receipt_dtl.php, vip_receiptt.php, vip_rpt_monthly_payment.php, vip_rpt_open_class_accounting.php, vip_sales_center_new.php, vip_scorerecordpout.php, vip_scorerecordpoutt.php, vip_stuatttt.php, vip_stuatttupd.php, vip_stucmdupd.php, vip_student_list_detail.php, vip_student_recordd.php, vip_student_score.php, vip_sum_receipt_all.php, vip_sum_receipt_new.php, vip_sum_receiptxl.php, vip_sum_tchhourrptpdf.php, vip_tchhour.php, vip_tchhourrptbeta.php, vip_tchhourrptpdfsum.php, vip_tchhourrptsum.php, vip_teacher_activities.php, vip_teacher_shift.php, vipbilll.php, vipbillreceiptt.php, vipcer_create_new.php, vipinvoice.php, vipolive_reg_date.php, vipquiz.php, vipreceipt.php, vipscrcrd.php, vos_inc_proses.php, vos_inc_upd.php, vos_sales_20102024_dtl.php, vpro_student_list.php, vprro_invnew.php.
13. ~~**Nama file yang ditampilkan**~~ — **SELESAI 2026-10-28 (opsi b dipilih pemilik)**: helper
    baru `upload_display_name()` (`_lib/upload.php`) menyimpan nama asli yang dibersihkan (tanpa
    path, karakter kontrol, `< > : " / \ | ? *`; maks 150 karakter dengan ekstensi dipertahankan;
    nama kosong/UTF-8 rusak → nama acak) ke kolom tampilan: `tb_user.namafile` (imgupld_save),
    `vip_ssq.namafile` (vip_scsq_save, vip_scsqbyprg_save), `file_data.namafile`
    (vip_upfilenext_save), `vip_meeting_image.nama_file` (acdcal, lc_acdcal; kode+tanggal+nama
    asli seperti dulu). File di disk & kolom lokasi tetap acak; semua halaman pembaca sudah
    dicek memakai kolom lokasi untuk link dan `e()` untuk teks. Diuji unit (10 nama sulit) dan
    ujung ke ujung (4 handler + vip_file_browser/vip_file_dwld: teks ter-escape, link ke file
    acak). Tidak berubah: handler yang memakai **satu** kolom untuk nama di disk sekaligus nama
    tampilan (purchase_order_file, adm_doc, mst_signature, acd_material, brg_master_img,
    hrd_mst_cntrct, fnc_data, rulesmemofile, vip_data, file_student) — di sana nama tampil tetap
    acak karena menampilkan nama asli butuh kolom baru (perubahan skema; perlu persetujuan).
14. ~~**Usulan skema kolom `nama_asli`**~~ — **DISETUJUI & DIKERJAKAN 2026-10-28**: kolom
    diterapkan di DB lokal (7 tabel), 15 handler + 23 halaman pembaca diubah dan diuji; rincian di
    `usulan/usulan_skema_nama_file.md` bagian 7. **Di server, `usulan/nama_file_asli_up.sql`
    wajib dijalankan sebelum deploy kode** (DEPLOY bagian 10).

---

## 8. Riwayat insiden selama pengerjaan

- 2026-10-27: cleanup data uji menghapus 8.903 baris `vip_teacher_schedule` + 1.590
  `vip_class_score_profile` milik user lokal (bukan produksi) karena user uji sempat diganti
  nama menjadi nama user asli. Dipulihkan dari dump lokal (checksum sama). Prosedur uji diubah:
  data uji dihapus berdasarkan id/penanda unik saja.
