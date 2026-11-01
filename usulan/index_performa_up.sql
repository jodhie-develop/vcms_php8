-- Usulan index performa (2026-10-29), lihat usulan_index_performa.md
-- Tidak mengubah data. Jalankan di luar jam sibuk. Batalkan dengan index_performa_down.sql.

-- vip_attendance (InnoDB, +-1,6 juta baris): 71 query memfilter kd_class (+ dt_meeting).
-- Online: tabel tetap bisa dibaca/ditulis selama index dibangun.
ALTER TABLE ves_data.vip_attendance
    ADD INDEX idx_att_class_meeting (kd_class, dt_meeting),
    ALGORITHM=INPLACE, LOCK=NONE;

-- tb_report_user_login (MyISAM): UPDATE jam logout di atas.php berjalan di SETIAP halaman.
-- MyISAM: tabel terkunci sebentar selama index dibangun (tabel +-10 MB, hitungan detik).
ALTER TABLE ves_data.tb_report_user_login
    ADD INDEX idx_login_user_tgl (id_user_log, tgl_in_log);
