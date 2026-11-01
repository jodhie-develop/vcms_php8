-- USULAN (belum diterapkan) — kolom nama asli file untuk tampilan.
-- Lihat usulan_skema_nama_file.md. Dijalankan oleh DBA (bukan user aplikasi), SEBELUM kode baru
-- yang memakai kolom ini di-deploy. MariaDB 10.3+ : ALGORITHM=INSTANT = tanpa rebuild/lock tabel.
-- Kolom ditaruh paling akhir, NULL, sehingga kode lama (yang selalu menyebut daftar kolom pada
-- INSERT) tetap jalan tanpa perubahan.

ALTER TABLE ves_data.purchase_order_file
  ADD COLUMN IF NOT EXISTS nama_asli VARCHAR(255) NULL DEFAULT NULL
  COMMENT 'nama asli file (tampilan), nama_file = nama di disk', ALGORITHM=INSTANT;

ALTER TABLE ves_data.adm_doc
  ADD COLUMN IF NOT EXISTS nama_asli VARCHAR(255) NULL DEFAULT NULL
  COMMENT 'nama asli file (tampilan), nama_file = nama di disk', ALGORITHM=INSTANT;

ALTER TABLE ves_data.brg_master_img
  ADD COLUMN IF NOT EXISTS nama_asli VARCHAR(255) NULL DEFAULT NULL
  COMMENT 'nama asli file (tampilan), namafile = nama di disk', ALGORITHM=INSTANT;

ALTER TABLE ves_data.hrd_mst_cntrct
  ADD COLUMN IF NOT EXISTS nama_asli VARCHAR(255) NULL DEFAULT NULL
  COMMENT 'nama asli file (tampilan), nama_file = path di disk', ALGORITHM=INSTANT;

ALTER TABLE ves_data.fnc_data
  ADD COLUMN IF NOT EXISTS nama_asli VARCHAR(255) NULL DEFAULT NULL
  COMMENT 'nama asli file (tampilan), nm_file = path di disk', ALGORITHM=INSTANT;

ALTER TABLE ves_data.rulesmemofile
  ADD COLUMN IF NOT EXISTS nama_asli VARCHAR(255) NULL DEFAULT NULL
  COMMENT 'nama asli file (tampilan), file_memo = path di disk', ALGORITHM=INSTANT;

ALTER TABLE ves_data.vip_data
  ADD COLUMN IF NOT EXISTS nama_asli VARCHAR(255) NULL DEFAULT NULL
  COMMENT 'nama asli file (tampilan), vip_file = path di disk', ALGORITHM=INSTANT;

-- Dua tabel berikut tidak ada di salinan DB laptop; jalankan hanya bila ada di server.
ALTER TABLE ves_data.file_student
  ADD COLUMN IF NOT EXISTS nama_asli VARCHAR(255) NULL DEFAULT NULL
  COMMENT 'nama asli file (tampilan), nm_file = path di disk', ALGORITHM=INSTANT;

ALTER TABLE ves_data.acd_material
  ADD COLUMN IF NOT EXISTS nama_asli VARCHAR(255) NULL DEFAULT NULL
  COMMENT 'nama asli file (tampilan), material_gambar = nama di disk', ALGORITHM=INSTANT;
