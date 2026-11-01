# File yang TIDAK dikonversi ke vcms_php8

Folder `_lib/` tidak bisa diakses dari web. File di bawah ini sengaja tidak dibawa,
sehingga tidak ikut ter-deploy (mengurangi permukaan serangan).

## 1. Salinan backup / trial / temp / bertanggal (keputusan 2026-10-27)

- accnt/ve_inc_list_accounting_try.php
- acdcal_backup.php, acdcal1108.php, acdcal2208.php, acdcall_back.php
- admission_progress_old.php
- brg_input_old.php, brg_list_backup.php
- ecert/ecertbimvista2022temp.php
- entryact-backup.php
- entrydata_bak.php, entrydataMay26.php, entrydataold.php
- freeteachercalendar_FIX.php
- invoicebill_back.php, invoicebill_old.php, invoiceprintold.php
- leads_old.php, leads_try.php, leadstatementold.php
- left_bak.php
- mca_ielts_print_bak.php
- mob_po_ttd_bak.php
- po_detail_display_bak.php, po_entry_back.php, po_entry_old.php, po_item_dtl_old.php
- printable/vipreceiptprint_old.php
- rpt_acdcalold.php
- stuadmprogress_backup.php, stuadmprogress_old.php, stuadmprogressold.php, stuadmsoatrial.php
- teachercalendar_try.php, teachercalendarBak.php, teachercalendarold.php
- ve_inc_list_back.php, ve_inc_list_bak.php
- vip_class_listold.php
- vip_mca_back.php
- vip_open_class_report_acc_old.php, vip_open_class_report_accounting_bak.php,
  vip_open_class_report_accxltrial.php,
  vip_open_class_report_try.php
- vip_pt_record_upd_back.php, vip_pt_record_updnew_back.php, vip_pt_recordold.php
- vip_receipt_report_try.php
- vip_scorerecordpouttbak.php
- vip_stuattt_backup.php
- vip_tchhourrptpdf_temp.php, vip_tchhourrptpdfMar26.php, vip_tchhourrptpdftry.php
- vip_teacher_free_bak.php
- vip_th_backup.php, vip_th_trial.php
- vipbill_bak.php, vipbill_testing.php, vipbillold.php, vipbillprint_bak.php
- vipreceiptprintbak.php, vipreceiptprintold.php

## 2. File debug (keputusan 2026-10-27)

- phpinfo.php, info.php, dns_test.php, domain_audit.php
  (token Fonnte di dns_test.php harus di-rotate)
- kirim_email.php, kirim_email_baru.php (skrip uji SMTP PHPMailer; periksa apakah berisi kredensial SMTP)

## 3. Orphan: tidak di-link dari halaman mana pun (keputusan 2026-10-27)

- entryactnofilter.php
- entryactteac_sv.php (endpoint upload tanpa cek login)
- availabilityteachercalendar.php
- agendakerja.php, agendakerja_update.php (hanya dipanggil dari agendakerja.php)
- myslottime.php
- teachercalendarnew.php
- vip_order_check.php
- vip_class_student_list_tr.php

## 3b. Rusak di versi lama / alat bantu (tidak dikonversi)

- ca_payment_summary.php: parse error di file asli (kurung kurawal tidak ditutup, baris 110),
  halaman ini tidak pernah bisa jalan bahkan di PHP 5.
- listvisitoroptimus.php: meng-include tool.php / tool_load_data.php yang tidak ada; tidak di-link.
- absenDisplaygeo.php: meng-include konek.php yang tidak ada; hanya me-link dirinya sendiri.
- mgr_office_sales_by_branch_new_admin_new_period.php: `require './mngr_home.php'` (file tidak ada)
  -> fatal sejak versi lama; tidak di-link. Berisi password DB tertanam (lihat DEPLOY.md rotasi).
- timestampnow.php: berisi kode C# (`DateTime.Now.ToString(...)`), fatal error sejak versi lama.
- lokasiku.php: halaman login aplikasi lain (tabel `pengguna`) memakai `mysqli_query($koneksi)`
  yang tidak pernah terdefinisi di conndb.php -> tidak berfungsi; tidak di-link; rawan SQL injection.
- modal.php: demo "dependent dropdown" memakai `$mysqli` yang tidak terdefinisi; tidak di-link.
- ecert/db.php: skrip uji koneksi `mysqli` dengan username/password DB tertanam dan mencetak
  "Connected successfully"; tidak di-include file lain. **Ganti password user DB tersebut.**
- get_oauth_token.php: skrip contoh PHPMailer untuk membuat token OAuth (alat setup, bukan halaman
  aplikasi); jangan di-deploy.

- device_invent.phpx, ocp.phpx, vip_sum_receipt.phpX: bukan .php (tidak dieksekusi Apache,
  tetapi bisa terunduh sebagai teks sumber) -> jangan di-deploy; `.htaccess` menolak `*.phpx`.

## 4. Perlu dicek (belum diputuskan)

Nama mengandung tahun; bisa laporan aktif, bisa salinan lama:
detail_pipeline_2021.php, pipeline_2021.php, productivity_2020.php, sc_prod_2024.php,
vos_sales_20102024.php.

## 5. Bernama backup/trial tetapi MASIH DIPAKAI (tetap dikonversi)

Ditemukan dengan mencari link dari file aktif ke daftar di atas:
- entryactteactemp.php: menu "My Agenda" untuk user Savita di left.php
- vip_open_class_report_accountingtry.php: target form vip_open_class_report_accounting.php
- ecert/ecertbimvista2022.php: tombol cetak di bim_list.php, vip_certificate*.php, vipcertificatexl.php

Template yang kemungkinan tidak dipakai: template_form..php, template_page.php,
template_page_utk_form.php.
