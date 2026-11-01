-- Membatalkan index_performa_up.sql (tidak mengubah data).
ALTER TABLE ves_data.vip_attendance DROP INDEX idx_att_class_meeting;
ALTER TABLE ves_data.tb_report_user_login DROP INDEX idx_login_user_tgl;
