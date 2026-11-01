-- Membatalkan index_performa2_up.sql (tidak mengubah data).
ALTER TABLE ves_data.adm_stu_progress DROP INDEX idx_asp_bio_enroll;
ALTER TABLE ves_data.purchase_order_item DROP INDEX idx_poi_kode;
ALTER TABLE ves_data.purchase_order_file DROP INDEX idx_pof_kode;
ALTER TABLE ves_data.vip_teacher_schedule DROP INDEX idx_vts_teacher_mulai, DROP INDEX idx_vts_biodata;
ALTER TABLE ves_data.vip_class_score_profile DROP INDEX idx_vcsp_bio_test;
ALTER TABLE ves_data.vip_student_comment DROP INDEX idx_vsc_bio_cl;
ALTER TABLE ves_data.tb_master_partner DROP INDEX idx_mp_kdschool;
ALTER TABLE ves_inc.tb_biodata DROP INDEX idx_bio_kd;
ALTER TABLE ves_inc.tb_acd_history DROP INDEX idx_acdh_bio;
