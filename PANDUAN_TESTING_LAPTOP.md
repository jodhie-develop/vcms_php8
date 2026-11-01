# Panduan Testing V-CMS di Laptop (lokal)

Cara menguji hasil migrasi PHP 8.4 di laptop ini, **tanpa server staging dan tanpa menyentuh
server produksi**. Daftar skenario uji (apa saja yang dicoba) ada di `PANDUAN_TESTING.md`
bagian 3 — panduan ini menjelaskan **cara** menjalankannya di laptop dan apa saja batasannya.

| Komponen | Lokasi di laptop |
|---|---|
| Aplikasi baru (yang diuji) | `C:\vcms_php8` |
| Aplikasi lama (asli, **jangan diubah**) | `C:\vcms` — dipakai hanya sebagai sumber gambar/css/template |
| Konfigurasi, log, sesi, backup, alat bantu | `C:\vcms_private` (di luar webroot) |
| Database | MariaDB 11.4 lokal, `ves_data` + `ves_inc` (salinan data produksi) |
| Alamat aplikasi | http://localhost:8000/login.php |

---

## 1. Sebelum mulai (sekali per sesi testing)

### 1.1 Backup database
Testing simpan/ubah/hapus akan mengubah data lokal. Backup dulu agar bisa dikembalikan:

```powershell
php C:\vcms_private\tools\db.php backup sebelum_testing
```
± 20 detik, ± 375 MB, tersimpan di `C:\vcms_private\backup\sebelum_testing_<tanggal_jam>.sql`.
Lihat daftar backup: `php C:\vcms_private\tools\db.php list`

### 1.2 Catat jam mulai
Untuk membersihkan file upload uji nanti (bagian 5). Mis. tulis: *mulai 29-10-2026 14:30*.

### 1.3 Nyalakan server
Buka PowerShell, jalankan:

```powershell
powershell -ExecutionPolicy Bypass -File C:\vcms_private\tools\server.ps1
```
Biarkan jendela itu terbuka selama testing (berhenti: **Ctrl+C**).
Bila laptop kekurangan memori (server tiba-tiba mati), pakai `-Workers 2` di akhir perintah.

### 1.4 Buka log (jendela PowerShell kedua)
Semua error aplikasi tercatat di sini — biarkan terbuka sambil testing:

```powershell
Get-Content C:\vcms_private\logs\app.log -Tail 20 -Wait
```

### 1.5 Login
Buka http://localhost:8000/login.php dan login dengan **akun Anda sendiri** (data user di laptop
adalah salinan produksi, jadi username/password sama seperti di aplikasi lama pada saat
salinan dibuat). Untuk menguji jabatan lain, login dengan akun staf berjabatan itu.

---

## 2. Cara menguji

1. Ikuti tabel skenario di `PANDUAN_TESTING.md` bagian 3 sesuai jabatan / modul yang diuji.
2. Untuk setiap halaman perhatikan:
   - halaman terbuka tanpa layar putih atau tulisan error;
   - **jendela log** (1.4) tidak memunculkan baris baru berisi `Uncaught`, `V-CMS SQL gagal`,
     atau `Fatal`;
   - data yang tampil masuk akal — **bandingkan dengan aplikasi lama di produksi** dengan
     membuka halaman yang sama di sana **hanya untuk melihat** (jangan simpan/ubah apa pun di
     produksi untuk keperluan testing);
   - data yang disimpan muncul kembali dengan benar setelah halaman dibuka ulang.
3. Catat temuan dengan format di `PANDUAN_TESTING.md` bagian 5. Untuk testing di laptop, sertakan
   juga **baris log** yang muncul saat masalah terjadi (salin dari jendela log).
4. Hal yang memang berubah dengan sengaja (bukan bug): `PANDUAN_TESTING.md` bagian 4.

**Tips**
- Pakai data yang mudah dikenali, mis. nama siswa `TEST - Budi`, keterangan `uji lokal`.
- Kalau sebuah halaman lambat, catat URL-nya — sudah ada contoh perbaikan kecepatan
  (`acdcal.php`, 27 detik → 0,2 detik).
- Kalau muncul **"Sesi formulir sudah kedaluwarsa…"** saat menyimpan, muat ulang halamannya lalu
  simpan lagi.

---

## 3. Batasan di laptop (bukan bug aplikasi)

| Fitur | Di laptop | Cara menguji / catatan |
|---|---|---|
| Cetak PDF (15 halaman html2pdf, laporan siswa CA) | Tampil "Fitur PDF belum tersedia…" | Pustaka belum dipasang. Tambahkan **`&vuehtml=1`** di akhir URL untuk melihat isi/HTML yang akan dicetak |
| Preview Excel (Report List → Preview) | Tampil "Fitur pratinjau Excel belum tersedia…" | Pustaka belum dipasang; diuji di staging |
| Email notifikasi PO / incentive | **Tidak terkirim** (server email tidak dikonfigurasi di laptop) | Pesan gagal kirim email wajar; periksa bahwa data PO/incentive tetap tersimpan |
| WhatsApp (`kirim_wa.php`) | **Jangan dibuka** | Halaman uji kirim WA; menghubungi internet (Fonnte). Token kosong di laptop |
| Rekap absensi staf (`absensilist.php`, `absensilistmonth.php`) | Error / kosong | Memakai DB `data_absen` yang tidak ada di laptop |
| Halaman `ecert/` yang memakai `ecert/conndb.php` (DB `dbsertifikat`) | Error / kosong | DB `dbsertifikat` tidak ada di laptop. Sertifikat yang memakai `../conndb.php` (mis. `ecertibt.php`) jalan normal |
| Upload ke folder `vipfile/`, `gbpdo/`, `vipscsq/` | Bisa gagal | Folder tidak ada di salinan laptop; di server wajib ada |
| Tabel `file_student`, `acd_material` | Halaman terkait kosong/error | Tabel tidak ada di DB laptop |
| Gambar lama, css, template sertifikat (`ecert/*.jpg`, font) | Diambil otomatis dari `C:\vcms` | Hanya dibaca, tidak diubah |
| Link di data yang menuju `https://allspark.vistaeducation.com/...` | **Jangan diklik saat testing** | Itu server produksi |
| Kecepatan | Bisa berbeda dari server | Laptop lebih lambat/cepat; bandingkan secara relatif |

---

## 4. Setelah selesai testing

### 4.1 Matikan server
Tekan **Ctrl+C** di jendela server.

### 4.2 Kembalikan database (bila ingin membuang data uji)

```powershell
php C:\vcms_private\tools\db.php list
php C:\vcms_private\tools\db.php restore sebelum_testing_<tanggal_jam>.sql
php C:\vcms_private\tools\db_cek.php
```
Restore ± 1,5 menit. `db_cek.php` harus menampilkan **Index performa 2** dan **Kolom nama_asli 7**.
Bila memakai backup lama (sebelum 29-10-2026), ikuti pesan "PERHATIAN" yang muncul (menjalankan
ulang SQL index / kolom `nama_asli`).

> Restore **menimpa** semua perubahan sejak backup — termasuk data yang mungkin sengaja ingin
> disimpan. Jangan restore bila belum yakin.

### 4.3 Bersihkan file upload uji
File yang di-upload saat testing tersimpan di dalam `C:\vcms_php8` (folder hasil migrasi).
Tampilkan file non-PHP yang dibuat setelah jam mulai (ganti tanggal/jam sesuai catatan 1.2):

```powershell
Get-ChildItem C:\vcms_php8 -Recurse -File | Where-Object { $_.LastWriteTime -gt [datetime]'2026-10-29 14:30' -and $_.Extension -notin '.php','.md','.sql','.json' } | Select-Object FullName, LastWriteTime
```
Periksa daftarnya, lalu hapus file uji tersebut (**jangan** menghapus file `.php` atau `ecert\ca_logo.png`).
Bila ragu, minta bantuan IT / kirim daftar tersebut.

### 4.4 Simpan log
Salin baris log selama sesi testing bila ada temuan:
`C:\vcms_private\logs\app.log` (cari jam kejadian).

---

## 5. Ringkasan perintah

| Keperluan | Perintah |
|---|---|
| Backup DB | `php C:\vcms_private\tools\db.php backup <nama>` |
| Daftar backup | `php C:\vcms_private\tools\db.php list` |
| Restore DB | `php C:\vcms_private\tools\db.php restore <file.sql>` |
| Cek DB setelah restore | `php C:\vcms_private\tools\db_cek.php` |
| Nyalakan server | `powershell -ExecutionPolicy Bypass -File C:\vcms_private\tools\server.ps1 [-Workers 2]` |
| Pantau log | `Get-Content C:\vcms_private\logs\app.log -Tail 20 -Wait` |
| Alamat aplikasi | http://localhost:8000/login.php |

| Nyalakan server untuk jaringan (komputer lain) | `powershell -ExecutionPolicy Bypass -File C:\vcms_private\tools\server.ps1 -Lan` |

---

## 6. Akses dari komputer lain (jaringan kantor yang sama)

1. **Sekali saja**, buka PowerShell **sebagai Administrator** (klik kanan → *Run as administrator*):
   ```powershell
   # hanya bila Wi-Fi ini jaringan kantor/rumah yang dipercaya (bukan Wi-Fi umum)
   Set-NetConnectionProfile -InterfaceAlias "Wi-Fi" -NetworkCategory Private
   New-NetFirewallRule -DisplayName "V-CMS lokal (port 8000)" -Direction Inbound -Protocol TCP -LocalPort 8000 -Action Allow -Profile Private -RemoteAddress LocalSubnet
   ```
   Hanya komputer di jaringan lokal yang sama yang bisa masuk; dari internet tetap tertutup.
2. Nyalakan server dengan `server.ps1 -Lan`; alamat untuk komputer lain ditampilkan di layar,
   mis. `http://192.168.18.214:8000/login.php`. IP bisa berubah bila laptop pindah jaringan /
   router membagi IP baru — lihat lagi alamat yang tampil saat server dinyalakan.
3. Bila Windows memunculkan jendela *"Windows Defender Firewall has blocked some features of PHP"*,
   centang **Private networks** lalu **Allow access** (jangan Cancel — Cancel membuat aturan blokir).
4. Selesai testing: matikan server (Ctrl+C). Menutup akses permanen (PowerShell Administrator):
   `Remove-NetFirewallRule -DisplayName "V-CMS lokal (port 8000)"`
5. **IP tetap lewat kabel LAN (192.168.5.101)**: PowerShell Administrator →
   `powershell -ExecutionPolicy Bypass -File C:\vcms_private\tools\set_ip_lan.ps1`
   (memasang IP 192.168.5.101/24, gateway & DNS 192.168.5.1 di adaptor Ethernet, profil Private,
   aturan firewall port 8000). Kembali ke otomatis: tambahkan `-Revert`. Alamat untuk komputer
   lain: `http://192.168.5.101:8000/login.php`.
6. Router lokal meniru aturan `.htaccess`: dump SQL, arsip `.zip/.tar.gz`, dokumen `.md`, folder
   `_lib/`, `usulan/`, `vcms/`, `catatan/`, `vendor/` tidak bisa dibuka dari komputer lain (404).
   Data aplikasi di laptop adalah **salinan data produksi** — beri akses hanya ke penguji.

**Aturan penting**
1. Jangan mengubah apa pun di `C:\vcms` (aplikasi asli).
2. Jangan menyimpan/mengubah data di **server produksi** untuk keperluan testing.
3. Backup DB sebelum menguji simpan/ubah/hapus.
4. Jangan membuka `kirim_wa.php` dan link ke `allspark.vistaeducation.com` saat testing.
