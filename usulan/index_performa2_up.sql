-- Usulan index performa tahap 2 (2026-10-30), lihat usulan_index_performa.md bagian "Tahap 2".
-- Tidak mengubah data. Jalankan di luar jam sibuk. Batalkan dengan index_performa2_down.sql.
-- InnoDB: online (LOCK=NONE). MyISAM (ves_inc.*): tabel terkunci beberapa detik selama dibangun.

-- adm_stu_progress: progress_admission, sales_contoh, sales_hitung (1 query per siswa x 2)
ALTER TABLE ves_data.adm_stu_progress
    ADD INDEX idx_asp_bio_enroll (kd_biodata, enroll_date, update_date), ALGORITHM=INPLACE, LOCK=NONE;

-- purchase_order_item / purchase_order_file: daftar PO (1 query per PO)
ALTER TABLE ves_data.purchase_order_item ADD INDEX idx_poi_kode (kode), ALGORITHM=INPLACE, LOCK=NONE;
ALTER TABLE ves_data.purchase_order_file ADD INDEX idx_pof_kode (kode), ALGORITHM=INPLACE, LOCK=NONE;

-- vip_teacher_schedule: kalender guru (per guru per hari) & riwayat kelas per siswa
ALTER TABLE ves_data.vip_teacher_schedule
    ADD INDEX idx_vts_teacher_mulai (nm_teacher, mulai_tm),
    ADD INDEX idx_vts_biodata (kd_biodata, status_kelas),
    ALGORITHM=INPLACE, LOCK=NONE;

-- vip_class_score_profile: skor per siswa (score record, class student list)
ALTER TABLE ves_data.vip_class_score_profile
    ADD INDEX idx_vcsp_bio_test (kd_biodata, jns_test, test_date), ALGORITHM=INPLACE, LOCK=NONE;

-- vip_student_comment: komentar per siswa per kelas
ALTER TABLE ves_data.vip_student_comment ADD INDEX idx_vsc_bio_cl (kd_biodata, kd_cl), ALGORITHM=INPLACE, LOCK=NONE;

-- tb_master_partner: JOIN sekolah di laporan sales/admission (t.kd_school = a.kd_school)
ALTER TABLE ves_data.tb_master_partner ADD INDEX idx_mp_kdschool (kd_school), ALGORITHM=INPLACE, LOCK=NONE;

-- ves_inc (MyISAM): biodata & riwayat akademik per siswa - dipakai di sangat banyak halaman
ALTER TABLE ves_inc.tb_biodata ADD INDEX idx_bio_kd (kd_biodata);
ALTER TABLE ves_inc.tb_acd_history ADD INDEX idx_acdh_bio (kd_biodata);
