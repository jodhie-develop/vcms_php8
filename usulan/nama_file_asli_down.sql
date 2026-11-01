-- ROLLBACK usulan nama_file_asli_up.sql.
-- URUTAN PENTING: kembalikan dulu kode yang membaca/menulis kolom nama_asli, BARU jalankan ini.
-- Nama asli yang sudah tersimpan di kolom ini ikut hilang (file di disk tidak terpengaruh).

ALTER TABLE ves_data.purchase_order_file DROP COLUMN IF EXISTS nama_asli;
ALTER TABLE ves_data.adm_doc             DROP COLUMN IF EXISTS nama_asli;
ALTER TABLE ves_data.brg_master_img      DROP COLUMN IF EXISTS nama_asli;
ALTER TABLE ves_data.hrd_mst_cntrct      DROP COLUMN IF EXISTS nama_asli;
ALTER TABLE ves_data.fnc_data            DROP COLUMN IF EXISTS nama_asli;
ALTER TABLE ves_data.rulesmemofile       DROP COLUMN IF EXISTS nama_asli;
ALTER TABLE ves_data.vip_data            DROP COLUMN IF EXISTS nama_asli;
ALTER TABLE ves_data.file_student        DROP COLUMN IF EXISTS nama_asli;
ALTER TABLE ves_data.acd_material        DROP COLUMN IF EXISTS nama_asli;
