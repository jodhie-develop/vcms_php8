# Panduan Testing V-CMS (PHP 8.4)

Panduan uji terima (UAT) hasil migrasi V-CMS dari PHP 5.2 ke PHP 8.4 sebelum go-live.
Tujuannya memastikan **semua fitur tetap berjalan seperti aplikasi lama** dan perbaikan keamanan
tidak mengganggu pekerjaan sehari-hari. Tampilan memang **tidak** diubah — yang dicari adalah
fitur yang rusak, data yang salah, atau halaman yang error/lambat.

Dokumen terkait: `DEPLOY.md` (pemasangan server), `proses_migrasi.md` (catatan teknis migrasi).

| Bagian | Untuk siapa |
|---|---|
| 1. Persiapan lingkungan uji | Koordinator test / IT |
| 2. Aturan umum | Semua penguji |
| 3. Skenario uji per modul | Penguji sesuai jabatan |
| 4. Yang **bukan** bug | Semua penguji |
| 5. Cara melapor temuan | Semua penguji |
| 6. Uji teknis tambahan | IT |
| 7. Kriteria lulus & jadwal | Koordinator / pemilik aplikasi |

---

## 1. Persiapan lingkungan uji (koordinator / IT)

**Testing dilakukan di server STAGING, bukan di server produksi.** Data yang diubah saat testing
tidak boleh ikut ke data asli.

1. Siapkan server staging sesuai `DEPLOY.md` bagian 2–6 (PHP 8.4, MariaDB 11.4, Apache, HTTPS).
2. Restore **salinan terbaru** database produksi ke staging (`DEPLOY.md` bagian 10, "Persiapan").
3. Jalankan di database staging:
   - `usulan/nama_file_asli_up.sql` — **wajib** (tanpa ini upload lampiran gagal);
   - `usulan/index_performa_up.sql` — sangat disarankan (kecepatan).
4. Pasang pustaka PDF/Excel: `composer install` lalu salin `vendor/` (`DEPLOY.md` bagian 8a).
5. Salin aset lama (gambar, css, js, template sertifikat `ecert/*.jpg`, font `*.ttf`) dan folder
   upload (`vipfile/`, `gbpdo/`, `vipscsq/`, dll.) — `DEPLOY.md` bagian 10.
6. **Matikan pengiriman keluar** agar pelanggan/staf tidak menerima pesan dari testing — di
   `config.php` staging:
   - `smtp` → isi akun email uji (bukan akun notifikasi asli), atau host yang tidak bisa dihubungi;
   - `fonnte_token` → kosongkan `''` (WhatsApp tidak terkirim).
7. Buat **akun uji** untuk tiap jabatan yang akan diuji (lihat tabel di bagian 3), atau pakai akun
   staf asli **di staging saja**. Catat siapa memegang akun apa.
8. Beri penguji alamat staging (mis. `https://staging.../login.php`) dan formulir laporan (bagian 5).
9. Pastikan IT bisa membaca log aplikasi `vcms_private/logs/app.log` untuk menyelidiki laporan.

**Kalau tidak ada staging**: uji di laptop (lokal, `http://localhost:8000`) dengan salinan DB —
sudah dilakukan sebagian oleh tim migrasi (`proses_migrasi.md` bagian 4). PDF/Excel belum bisa
diuji di laptop karena pustakanya belum terpasang.

---

## 2. Aturan umum untuk penguji

- Kerjakan **pekerjaan sehari-hari Anda** di staging seperti biasa: buka menu yang biasa dipakai,
  input data, edit, cetak, upload, lihat laporan.
- **Bandingkan dengan aplikasi lama** (produksi) bila ragu: buka halaman yang sama di keduanya
  dan cocokkan angka/isi. **Jangan** input/ubah data di aplikasi lama untuk keperluan testing.
- Pakai data yang mudah dikenali, mis. nama siswa diawali `TEST -`, agar bisa dibersihkan.
- Setiap kali menemukan masalah, **langsung catat** (bagian 5) — jangan menunggu akhir hari.
- Centang skenario yang sudah dicoba di tabel bagian 3 (✓ lulus / ✗ gagal + nomor laporan).
- Browser: Chrome atau Edge terbaru. Coba juga di HP untuk halaman yang biasa dibuka di HP
  (mis. Purchasing mobile).

---

## 3. Skenario uji per modul

Kolom **Hasil**: isi ✓ (sesuai), ✗ (gagal — tulis nomor laporan), atau – (tidak dipakai).
Setiap skenario dianggap lulus bila: halaman terbuka tanpa error, data yang tampil benar
(sama dengan aplikasi lama), dan data yang disimpan muncul kembali dengan benar.

### 3.1 Semua pengguna (wajib dicoba setiap penguji)

| No | Skenario | Yang diperiksa | Hasil |
|---|---|---|---|
| U-01 | Login dengan akun sendiri | Masuk ke dashboard, nama & cabang benar | |
| U-02 | Login dengan password salah | Ditolak dengan pesan, tidak masuk | |
| U-03 | Buka menu-menu di sidebar kiri yang biasa dipakai | Tiap halaman terbuka; tidak ada halaman putih/kosong atau tulisan error | |
| U-04 | Ganti password (menu profil) lalu login ulang | Password baru berlaku | |
| U-05 | Biarkan tidak aktif lama / logout, lalu buka halaman | Diminta login ulang | |
| U-06 | Buka halaman yang bukan hak jabatan Anda (mis. menu admin) | Akses ditolak, bukan error | |
| U-07 | Ketik nama dengan tanda petik / karakter khusus, mis. `D'Souza`, `Café`, `José` | Tersimpan dan tampil persis sama | |
| U-08 | Cetak / unduh PDF dari halaman yang biasa Anda pakai | PDF terbuka, isi & tata letak benar | |
| U-09 | Kecepatan halaman yang biasa dipakai | Tidak lebih lambat dari aplikasi lama | |

### 3.2 Sales / Admission / VOS

| No | Skenario | Menu / halaman | Hasil |
|---|---|---|---|
| S-01 | Input lead baru, lalu edit dan ubah status | Leads → New Leads / Leads (`newleads.php`, `leads.php`) | |
| S-02 | Jadwal placement test | `ptschedule.php` | |
| S-03 | Lihat daftar siswa terdaftar & detailnya | Enrolled Student (`sales_center.php`) | |
| S-04 | Interview order & admission progress | `admission_order_new.php`, `admission_progress.php` | |
| S-05 | Upload dokumen siswa/sales, lalu buka kembali | Dokumen tampil dengan **nama asli** dan bisa dibuka | |
| S-06 | SOA: buat / lihat / cetak | `soastatlist.php` → cetak SOA (PDF) | |
| S-07 | Laporan leaving (by step, by staff, by SC) | Report → Leaving | |
| S-08 | Laporan sales & produktivitas | `sales.php`, `sales_productivity_form.php` | |
| S-09 | Incentive VOS/VE/TBI: lihat, ajukan, approval | Menu Incentive | |

### 3.3 VIP / FA / CA (akademik & kelas)

| No | Skenario | Menu / halaman | Hasil |
|---|---|---|---|
| V-01 | Daftar siswa VIP/FA, buka detail | VIP/FA Enrolled Student (`vip_sales_center.php`) | |
| V-02 | Booking guru & kalender ketersediaan | Teacher Booking (`entryact.php`), Teachers Availability | |
| V-03 | Buat / ubah / hapus kelas & jadwal | VIP Class List (`vip_class_list.php`) | |
| V-04 | Kalender kelas: buka kelas, lihat jumlah hadir per pertemuan, upload & lihat foto meeting | `acdcal.php` (dari daftar kelas) — harus terbuka cepat (± 1 detik) | |
| V-05 | Absensi siswa per pertemuan: isi & ubah | Attendance (`vip_stuattt.php`) | |
| V-06 | Input skor PT & lihat riwayat | VIP PT Score (`vip_pt_record.php`) | |
| V-07 | Student record & score card (PDF) | `vip_student_record.php`, cetak score card | |
| V-08 | Meeting order list | `vip_order_list.php` | |
| V-09 | Laporan open class & teaching hour | `vip_open_class_report.php`, `vip_tchhourrpt.php` | |
| V-10 | Report List: upload laporan Excel, klik **Preview** | `vip_data.php` → isi Excel tampil sebagai tabel | |
| V-11 | Sertifikat: generate, approval, buka link sertifikat | `vip_certificate.php`, `vip_certificate_app.php`, link `ecert/…` | |
| V-12 | Placement test report (gambar sertifikat) | `ecert/ecertibt.php?...` dari daftar PT — gambar & tulisan pas | |
| V-13 | Coordination sheet CA & laporan siswa CA (PDF) | `vip_ca_crsh.php`, `ecert/capstpdf.php?kd=…` | |
| V-14 | LC: booking, open date, standby registration | Menu LC | |
| V-15 | Buku: distribusi & stok | `vip_book_distrib.php`, `book_inventory*.php` | |
| V-16 | Scope & sequence upload, material management | `vip_mst_form.php`, `vipbook.php` | |
| V-17 | My Agenda / My Activities (guru) | `entryactteac.php`, `vip_activities.php` | |
| V-18 | Setting jam kerja bulanan | `entryworking_hor.php` | |

### 3.4 Billing, kasir & accounting

**Bandingkan angka dengan aplikasi lama untuk setiap skenario di bagian ini.**

| No | Skenario | Menu / halaman | Hasil |
|---|---|---|---|
| F-01 | Buat billing / invoice siswa VIP | VE Payment (`vip_sales_center.php`) → bill | |
| F-02 | Bayar (receipt), cetak kwitansi | `vipbillreceipt*.php`, cetak receipt | |
| F-03 | Voucher / diskon / cicilan | Form billing | |
| F-04 | Refund VE / CA / FA | `vip_refund*.php`, `ca_refund*.php`, `fa_refund.php` — cetak refund (PDF) | |
| F-05 | Other billing & other payment | `invoicebilllist.php`, `otherpaymentlist.php` | |
| F-06 | Invoice CA | `ca_invoicelist.php` | |
| F-07 | Laporan receipt harian/bulanan (layar, Excel, PDF) | VE/CA/FA Receipt, `vossf_receipt_daily.php` | |
| F-08 | Outstanding payment | `vip_outstanding.php`, `vip_ca_outstanding.php` | |
| F-09 | Summary income & laporan per cabang | `vip_sum_receipt.php`, `ca_oc_branch.php`, `ca_monthly_report.php` | |
| F-10 | Export ke Excel dari laporan | File terbuka di Excel, kolom & angka benar | |
| F-11 | Gaji guru & teacher master | `teacher_master.php`, `teacher_salary_report.php` | |

### 3.5 Purchasing, admin, HRD

| No | Skenario | Menu / halaman | Hasil |
|---|---|---|---|
| P-01 | Buat PO + lampiran, approval, cetak PO | Purchasing (`purchasinglist.php`) | |
| P-02 | Purchasing versi HP | `mob_purchasinglist.php` di HP | |
| P-03 | Lampiran PO: nama file asli tampil, file bisa dibuka | Detail PO | |
| P-04 | Tanda tangan (upload/gambar) | Halaman tanda tangan PO | |
| P-05 | Barang gudang: tambah, ubah, upload gambar | `brg_list.php` | |
| P-06 | Kontrak HRD: upload & lihat | Menu HRD | |
| P-07 | Rules & memo: upload & lihat | `rulesmemo.php` | |
| P-08 | Email notifikasi PO / incentive | Di staging: **pastikan tidak terkirim ke penerima asli** (lihat 1.6) | |

### 3.6 Manajemen / dashboard / laporan

| No | Skenario | Menu / halaman | Hasil |
|---|---|---|---|
| M-01 | Dashboard | `dashboard.php` — angka sama dengan aplikasi lama | |
| M-02 | Center achievement | `centersummary.php` | |
| M-03 | Laporan per periode (ubah tanggal awal/akhir, cabang) | Laporan yang biasa dipakai | |
| M-04 | Scheduler / working calendar | `workingcalendar.php` | |
| M-05 | Log pengguna | `user_log.php` | |

> Halaman yang tidak tercantum tetap boleh (dan sebaiknya) diuji bila Anda memakainya.

---

## 4. Yang **bukan** bug (perubahan yang disengaja)

Hal berikut memang berubah demi keamanan — **tidak perlu dilaporkan**:

1. **Halaman "Lanjutkan?"** muncul bila link aksi (hapus/approve/generate) dibuka dari luar
   aplikasi (mis. dari WhatsApp/email). Klik "Lanjutkan" — dari dalam aplikasi tidak muncul.
2. **Wajib login** di beberapa halaman yang dulu bisa dibuka tanpa login (export Excel, generator
   SOA/PT, laporan siswa CA `capstpdf`). Sertifikat `ecert/` dari link/QR tetap publik.
3. **Nama file di folder upload diacak**; di daftar lampiran tetap tampil nama asli file.
4. **Spasi di awal/akhir isian dibuang**, mis. "Speaking 6 " tersimpan "Speaking 6".
5. **Pesan error teknis tidak ditampilkan** di layar — hanya pesan singkat (detail di log IT).
6. **Huruf khusus** (é, ñ, dll.) yang dulu tampil "?" atau "�" sekarang tampil benar.
7. **Upload file berbahaya ditolak** (file berisi kode program walau berekstensi .jpg).
8. **Laporan siswa CA** (`capstpdf`) tampil dengan desain baru sesuai `ecert/ca_prograss.jpg`.
9. **Akses ditolak** untuk menu Teachers Availability bagi jabatan selain ACD/Admin/SC/CM/ACCM.
10. Halaman yang **dulu memang sudah rusak** di aplikasi lama (mis. `cact_add`, `qrcode.php`,
    `monthly_oc_report_pdf.php`) tetap belum berfungsi — dicatat di `proses_migrasi.md` bagian 7.

Ragu apakah sesuatu bug atau bukan? **Laporkan saja** — lebih baik terlapor dua kali daripada
terlewat.

---

## 5. Cara melapor temuan

Satu masalah = satu laporan. Gunakan format berikut (spreadsheet bersama atau grup chat khusus
testing):

```
No laporan   : T-<inisial>-<nomor urut>        mis. T-AR-007
Tanggal/jam  : 2026-11-05 10:42
Penguji      : <nama>, jabatan <…>, cabang <…>
Halaman/URL  : https://staging…/vip_class_list.php?...   (salin dari address bar)
Skenario     : V-03 (bila ada)
Langkah      : 1) buka … 2) isi … 3) klik Simpan
Hasil        : <yang terjadi>   mis. halaman putih / "Wah error nih5" / angka total 1.250.000
Seharusnya   : <yang diharapkan> mis. total 1.500.000 seperti di aplikasi lama
Tingkat      : Kritis / Tinggi / Sedang / Rendah
Lampiran     : screenshot (layar penuh, terlihat URL & jam)
```

**Tingkat masalah**

| Tingkat | Arti | Contoh |
|---|---|---|
| Kritis | Pekerjaan inti tidak bisa dilakukan, atau data/uang salah | Tidak bisa login, receipt tidak tersimpan, total tagihan salah |
| Tinggi | Fitur penting gagal tetapi ada jalan lain | Cetak PDF gagal, upload lampiran gagal |
| Sedang | Fitur jarang dipakai gagal / tampilan berantakan | Laporan tahunan error, kolom bergeser |
| Rendah | Kosmetik | Salah ketik, ikon hilang |

**Untuk IT yang menindaklanjuti**: cari jam kejadian di `vcms_private/logs/app.log`. Kata kunci:
`V-CMS SQL gagal` (query bermasalah), `Uncaught` (error PHP), `V-CMS PDF` / `V-CMS Excel`
(pustaka), `Akses ditolak` (hak akses), `CSRF` (token form kedaluwarsa).

---

## 6. Uji teknis tambahan (IT)

| No | Uji | Cara | Hasil yang diharapkan |
|---|---|---|---|
| T-01 | Folder internal tidak bisa dibuka dari web | Buka `/_lib/`, `/vendor/`, `/composer.json`, `/ecert/dompdf/` | 403/404 |
| T-02 | Upload file PHP | Upload `tes.php` dan `tes.php.jpg` (isi teks `<?php`) di form upload | Ditolak |
| T-03 | File upload tidak bisa dieksekusi | Buka file upload `.jpg` langsung | Tampil sebagai gambar, bukan dijalankan |
| T-04 | Form tanpa token | Kirim POST tanpa `_csrf` (mis. dari halaman HTML lain) | Ditolak |
| T-05 | Session cookie | Periksa cookie `VCMSSESSID` di browser | `HttpOnly`, `Secure` (HTTPS), `SameSite=Lax` |
| T-06 | Error tidak bocor | Buka halaman dengan parameter aneh, mis. `?id='` | Tidak tampil pesan SQL/path server |
| T-07 | Log | Setelah 1 hari testing, tinjau `app.log` | Semua error tercatat & ditindaklanjuti |
| T-08 | Kecepatan | Ukur halaman berat (acdcal, laporan receipt bulanan, dashboard) | Tidak lebih lambat dari produksi |
| T-09 | Index DB | `SHOW INDEX` sesuai `usulan/usulan_index_performa.md` | Index ada |
| T-10 | Kolom `nama_asli` | Query cek di `DEPLOY.md` bagian 10 | 9 tabel (atau sesuai tabel yang ada) |
| T-11 | Email & WhatsApp | Coba fitur kirim di staging | Tidak sampai ke penerima asli |
| T-12 | Cron / tugas terjadwal | Daftar cron server lama | Semua dicek: masih dibutuhkan? jalan di PHP 8.4? |

---

## 7. Kriteria lulus & jadwal

**Siap go-live bila:**
- Semua skenario bagian 3 yang relevan sudah dicoba oleh minimal satu penguji per jabatan.
- **Tidak ada temuan Kritis atau Tinggi yang terbuka.** Temuan Sedang/Rendah boleh tersisa bila
  disetujui pemilik aplikasi dan dijadwalkan perbaikannya.
- Angka keuangan (bagian 3.4) cocok dengan aplikasi lama untuk minimal 1 bulan data.
- Uji teknis bagian 6 lulus.
- Keputusan terbuka di `proses_migrasi.md` bagian 7 sudah dijawab (terutama rotasi kredensial).

**Usulan jadwal**

| Hari | Kegiatan |
|---|---|
| 1 | Koordinator siapkan staging & akun (bagian 1); briefing penguji 30 menit |
| 2–4 | Penguji menjalankan skenario jabatan masing-masing; IT memantau log harian |
| 5 | Rekap temuan, prioritas, perbaikan |
| 6–7 | Uji ulang temuan yang sudah diperbaiki + uji regresi singkat (U-01…U-09) |
| 8 | Keputusan go-live oleh pemilik aplikasi |

**Setelah go-live**: pantau `app.log` setiap hari selama 2 minggu pertama; simpan aplikasi lama
dan backup DB minimal 1 bulan untuk jaga-jaga (rollback: `DEPLOY.md`).
