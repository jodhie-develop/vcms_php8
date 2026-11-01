# Usulan index performa database

Status: **diterapkan di DB lokal 2026-10-29** (atas permintaan "perbaiki supaya lebih cepat" untuk
`acdcal.php`). Untuk server: jalankan `index_performa_up.sql` (batal: `index_performa_down.sql`).
Hanya menambah index — tidak mengubah data, kolom, atau kode.

## Masalah

`acdcal.php?kdcl=VEABEP 06060606-01-01&kdcbg=1` butuh **±27 detik** di laptop.
Diukur per query (slow query log lokal):

| Query | Waktu | Penyebab |
|---|---|---|
| Jumlah hadir per pertemuan di `vip_attendance` (1× per pertemuan, 20 pertemuan) | ±1,2 s × 20 = ±24 s | tabel ±1,6 juta baris tanpa index → scan penuh tiap query |
| `UPDATE tb_report_user_login` (jam logout) di `atas.php` | ±2,2 s | dijalankan di **setiap** halaman ber-header; ±193 ribu baris tanpa index |

## Perbaikan

1. **Kode `acdcal.php`** (tanpa ubah DB): jumlah hadir semua pertemuan diambil dalam **1 query**
   (`GROUP BY dt_meeting`) lalu dibaca per pertemuan. Hitungan sama dengan cara lama (diuji di 5
   kelas berabsensi: 71 pertemuan, 0 beda). 27 s → 3,9 s.
2. **Index** (file SQL ini):

| Tabel | Index | Dipakai oleh |
|---|---|---|
| `vip_attendance` (InnoDB) | `idx_att_class_meeting (kd_class, dt_meeting)` | 71 query di ±35 halaman yang memfilter `kd_class` (absensi, laporan kelas) |
| `tb_report_user_login` (MyISAM) | `idx_login_user_tgl (id_user_log, tgl_in_log)` | UPDATE jam logout di `atas.php` & `logout.php` (setiap halaman) |

   Dengan index: acdcal **3,9 s → 0,24 s**; tidak ada lagi query > 50 ms di halaman itu.
   Isi halaman identik dengan sebelum perbaikan.

## Dampak & cara menjalankan

- Waktu bangun index di laptop: `vip_attendance` 5,9 s (online, `LOCK=NONE`: tabel tetap bisa
  dipakai), `tb_report_user_login` 0,8 s (MyISAM: tabel terkunci sebentar — login/logout menunggu
  sejenak). Di server bisa sedikit lebih lama; jalankan di luar jam sibuk.
- Ruang disk tambahan ± 40–60 MB. INSERT absensi sedikit lebih berat (tidak terasa).
- Cek sesudahnya:
  `SHOW INDEX FROM ves_data.vip_attendance WHERE Key_name='idx_att_class_meeting';`
  `SHOW INDEX FROM ves_data.tb_report_user_login WHERE Key_name='idx_login_user_tgl';`
