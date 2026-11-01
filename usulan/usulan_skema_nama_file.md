# Usulan perubahan skema: kolom nama asli file

Status: **DISETUJUI 2026-10-28** (semua 9 tabel, nama kolom `nama_asli`). Sudah diterapkan di
DB lokal laptop (7 tabel yang ada) dan kode sudah diubah — lihat bagian 7. Di server: jalankan
`nama_file_asli_up.sql` **sebelum** kode di-deploy (wajib, DEPLOY bagian 10).
Terkait: `proses_migrasi.md` keputusan #13–#14, bagian 4f.

## 1. Masalah

Sejak migrasi, file upload disimpan di disk dengan nama acak (32 karakter hex) supaya penyerang
tidak bisa menebak/menimpa file atau menaruh skrip. Di 6 handler yang punya kolom nama tampilan
terpisah, nama asli sudah dikembalikan (`upload_display_name()`). Di tabel di bawah, **satu kolom**
dipakai sekaligus untuk nama/path di disk dan untuk teks yang dilihat pengguna, sehingga pengguna
kini melihat nama acak, mis. `a3f9…e1.pdf` alih-alih `Invoice Supplier Oktober.pdf`.

## 2. Usulan

Tambah satu kolom `nama_asli VARCHAR(255) NULL` di akhir 9 tabel. Kolom lama tetap berisi nama di
disk (untuk link/download); kolom baru hanya untuk teks tampilan.

| Tabel | Kolom nama di disk | ± Baris (lokal) | Ditulis oleh | Dibaca oleh |
|---|---|---|---|---|
| `purchase_order_file` | `nama_file` | 14.839 | po_entry, accnt/po_entry, csr_po_entry, incentive_entry, po_entryupload, po_upload_file, ttd_upload | 18 halaman PO (daftar, detail, mobile, view, hapus) |
| `adm_doc` | `nama_file` | 109 | doc_upload_file | doc_upload_file, doc_view_img, doc_del_img, vos_inc_list |
| `brg_master_img` | `namafile` | 51 | brg_upload | brg_list, brg_img_view |
| `hrd_mst_cntrct` | `nama_file` | 1 | hrd_ctrct_newsave | hrd_ctrct_dtl, hrd_list_upd |
| `fnc_data` | `nm_file` | 94 | fnc_updoc_save | commmonitoring |
| `rulesmemofile` | `file_memo` | 346 | rulesmemouploadsave | rulesmemo, rulesmemodtl, rulesmemodtlpdf, regulation, internmemo |
| `vip_data` | `vip_file` | 445 | vip_updoc_save | vip_data, vip_datareport, vip_file_view, vip_set_del |
| `file_student`* | `nm_file` | ? | pdoimg_upsv | pdoform |
| `acd_material`* | `material_gambar` | ? | material_input | material_list, profilemateri |

\* Tidak ada di salinan DB laptop — cek dulu di server.

Tidak termasuk: `mst_signature` (1 baris tanda tangan untuk render sertifikat, namanya tidak
pernah ditampilkan) dan `inventory_data` (sejak versi lama nama foto sudah dibuat aplikasi:
tanggal + angka).

File SQL:
- `usulan/nama_file_asli_up.sql` — menambah kolom (`ADD COLUMN IF NOT EXISTS … ALGORITHM=INSTANT`).
- `usulan/nama_file_asli_down.sql` — rollback (`DROP COLUMN IF EXISTS`).

## 3. Dampak & keamanan perubahan

- **Tanpa downtime**: MariaDB menambah kolom secara INSTANT (hanya metadata). Diuji di MariaDB
  11.4 lokal pada salinan 7 tabel: ±0,01 detik per tabel, termasuk 14.839 baris
  `purchase_order_file`; tidak ada rebuild/lock tabel.
- **Kode lama tetap jalan** (penting bila server lama dan baru berjalan berdampingan saat
  transisi): sudah diperiksa di `C:\vcms` dan `C:\vcms_php8` — tidak ada `INSERT … VALUES` tanpa
  daftar kolom ke tabel-tabel ini; `SELECT *` hanya dipakai untuk menghitung baris
  (po_entry, po_detail_display, hrd_list_upd, …), dan kolom baru ada di paling akhir.
- **Idempoten**: aman dijalankan dua kali (`IF NOT EXISTS` / `IF EXISTS`), sudah diuji.
- **Data lama tidak perlu diisi ulang**: baris sebelum migrasi PHP 8 sudah berisi nama asli di
  kolom lama; halaman menampilkan `COALESCE(NULLIF(nama_asli, ''), <kolom lama>)`, jadi baris
  dengan `nama_asli` NULL tampil persis seperti sekarang. Uji: baris lama → `lama.pdf`, baris
  baru → `Café Résumé.pdf` (file di disk `acak.pdf`).
- **Charset**: kolom mengikuti charset tabel (latin1), sama seperti kolom nama lainnya;
  aplikasi menulis lewat koneksi latin1 seperti sebelumnya.
- **Hak akses**: `ALTER` dijalankan oleh DBA/root. User aplikasi (`vcms_app`, DEPLOY bagian 5)
  tidak perlu hak tambahan — hak INSERT/SELECT/UPDATE di level tabel sudah mencakup kolom baru.

## 4. Perubahan kode (dikerjakan setelah disetujui)

1. **Handler (15 file: 7 untuk lampiran PO + 8 lainnya)**: tambahkan `nama_asli` ke INSERT dengan nilai
   `upload_display_name('<field>')` — helper yang sudah dipakai & diuji untuk 6 handler lain
   (membuang path, karakter kontrol, `< > : " / \ | ? *`; maks 150 karakter, ekstensi dipertahankan).
2. **Halaman pembaca**: hanya di tempat nama tampil sebagai **teks**, SELECT diubah menjadi
   `COALESCE(NULLIF(nama_asli,''), nama_file)` (atau kolom lama yang setara); semua `href`,
   `src`, path download, dan pengecekan file tetap memakai kolom lama. Teks tetap lewat `e()`.
   Banyak halaman PO hanya menampilkan ikon (mata/hapus) — halaman seperti itu tidak berubah.
3. **Uji**: ulangi uji upload 4f (file valid + 8 file serangan, lama vs baru) dan uji tampilan
   ujung ke ujung seperti untuk 6 handler sebelumnya; lint semua file yang berubah.

Perkiraan: perubahan kode kecil dan mekanis; risiko utama = salah memakai kolom baru untuk
link, yang tertangkap oleh uji ujung ke ujung (link harus tetap menuju file acak).

## 5. Urutan penerapan

1. Backup DB (`mariadb-dump` seperti DEPLOY bagian 10).
2. DBA menjalankan `nama_file_asli_up.sql` (lewati 2 tabel terakhir bila tidak ada di server).
3. Cek: `SELECT table_name FROM information_schema.columns WHERE table_schema='ves_data' AND column_name='nama_asli';`
4. Deploy kode yang menulis/membaca `nama_asli`.
   Disarankan langkah 2 dilakukan **sebelum atau bersamaan** dengan go-live PHP 8, supaya tidak
   ada baris baru yang terlanjur tersimpan tanpa nama asli.

**Rollback**: kembalikan kode dulu (kode baru akan error bila kolom hilang), baru jalankan
`nama_file_asli_down.sql`. Nama asli yang sudah tersimpan di kolom ini ikut hilang; file di disk
tidak terpengaruh.

## 6. Yang perlu diputuskan

1. Setujui penambahan kolom `nama_asli` di 9 tabel di atas (atau pilih sebagian).
2. Nama kolom: `nama_asli` (usulan) atau nama lain sesuai konvensi tim.
3. Siapa yang menjalankan SQL di server dan kapan (lihat urutan di bagian 5).

## 7. Pelaksanaan (2026-10-28)

**DB lokal**: backup `sebelum_kolom_nama_asli_20261028.sql`, lalu SQL up diterapkan ke 7 tabel
(±0,01–0,02 dtk/tabel); `file_student` & `acd_material` dilewati (tidak ada di lokal).

**Handler (15 file)** — INSERT kini mengisi `nama_asli` = `upload_display_name('<field>')`:
po_entry, accnt/po_entry, csr_po_entry, incentive_entry, po_entryupload, po_upload_file,
ttd_upload, doc_upload_file, brg_upload, hrd_ctrct_newsave, fnc_updoc_save, rulesmemouploadsave,
vip_updoc_save, pdoimg_upsv, material_input (`upload_display_name('file_array', $i)`).

**Halaman pembaca (23 file)** — kolom `COALESCE(NULLIF(nama_asli,''), <kolom lama>)` ditambahkan
di akhir SELECT; hanya **teks** yang memakainya, semua href/src/path/hidden input tetap kolom lama:
- daftar lampiran PO: po_entry, accnt/po_entry, csr_po_entry, incentive_entry, po_upload_file,
  po_detail_display, po_detail_display_with_sign, mob_po_detail_display,
  accnt/po_detail_display_acc, brg_upload, po_entryupload, ttd_upload, purchasinglist,
  mob_purchasinglist;
- doc_upload_file; judul halaman po_view_img & doc_view_img; vip_data & vip_datareport (teks
  link); vip_file_view (label); commmonitoring & commmonitoring_withoutPDO (teks link, hanya bila
  file ada); profilemateri (judul).
- Tidak diubah (hanya path, tidak menampilkan nama): po_del_img, doc_del_img, brg_img_view,
  brg_list, hrd_ctrct_dtl, rulesmemodtlpdf, rulesmemo/regulation/internmemo/rulesmemodtl,
  vip_set_del, pdoform, material_list, vos_inc_list, accnt/purchasingorder.

**Uji** (salinan terisolasi + backup `sesudah_kolom_nama_asli_20261028.sql`, dipulihkan sesudahnya):
- 9 handler (yang tabelnya ada di lokal): file `Invoice Supplier & Co 'Okt'.pdf` →
  `nama_asli` tersimpan persis, kolom lama & file di disk tetap acak — semua OK.
- Tampilan: po_upload_file, doc_upload_file, vip_datareport menampilkan nama asli ter-escape
  (`&amp;`, `&#039;`); po_view_img & doc_view_img `<title>` nama asli dengan embed tetap ke file
  acak; vip_file_view label nama asli dengan input path tetap acak; baris lama (`nama_asli`
  NULL) tetap tampil nama lama.
- Uji serangan upload diulang di 9 handler: semua file berisi PHP tetap ditolak.
- Hanya lint + review kode (data lokal tidak menampilkan baris uji karena filter halaman):
  vip_data (kode identik dengan vip_datareport), purchasinglist, mob_purchasinglist,
  commmonitoring*, dan handler/pembaca `file_student`/`acd_material` (tabel tidak ada di lokal).
