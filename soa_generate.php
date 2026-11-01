<?php
require_once __DIR__ . "/_lib/bootstrap.php"; csrf_guard_get(); auth_require_login(); 
include __DIR__ . "/conndb.php";

$hari=date("d");
$bulan=date("m");
$tahun=date("Y");
$hari_ini = "$tahun-$bulan-$hari";
$thn = in_val('thn', 'get');
//$query_enroll_student = "SELECT kd_biodata, no,kd_cabang,enroll_date FROM tb_sales_report where date_format(enroll_date,'%Y') =   '$thn' and prioritas = 1  order by no  ";
$query_enroll_student = q_set($__p_query_enroll_student, "SELECT kd_biodata, no,kd_cabang,enroll_date FROM tb_sales_report where no = 2612  ");

$resource_enroll_student= db_query_or_die('errro_visitor1', $query_enroll_student, $__p_query_enroll_student ?? []);
	if(num(db_num_rows($resource_enroll_student)) > 0)
		{
		while ($row_es =   db_fetch($resource_enroll_student, PDO::FETCH_NUM))
			{

			$kd_biodata = $row_es[0];
			$no = $row_es[1];$no_sales = $no;
			$kd_cabang = $row_es[2];
			$enroll_date = $row_es[3];
			$id_soa = "$kd_biodata$no";
			$query_baca_service_fee = q_set($__p_query_baca_service_fee, "SELECT no, curr, rp_mount, id_prof_bill,tgl_cetak FROM ves_inc.tb_prof_bill t where id_stu = ? and rp_mount is not null", [(string) ($kd_biodata)]);
			$resource_baca_service_fee= db_query_or_die('errro_visitor2', $query_baca_service_fee, $__p_query_baca_service_fee ?? []);
			if(num(db_num_rows($resource_baca_service_fee)) > 0)
				{
				while ($row_bcservice =   db_fetch($resource_baca_service_fee, PDO::FETCH_NUM))
					{
					$no_service_fee = $row_bcservice[0];
					$curr = $row_bcservice[1];
					$rp_mount = $row_bcservice[2];
					$id_prof_bill = $row_bcservice[3];
					$tgl_cetak = $row_bcservice[4];
					$query_insert_service_fee = q_set($__p_query_insert_service_fee, "insert into ves_data.adm_soa (kd_biodata, enroll_date, keterangan, cur_debet, rp_debet, id_soa, no_ref,jns_transaksi,dt_entry,id_nomor) values (? ,? ,'Service Fee Paid',? ,? ,? ,? ,1,? ,? )", [(string) ($kd_biodata), (string) ($enroll_date), (string) ($curr), (string) ($rp_mount), (string) ($id_soa), (string) ($id_prof_bill), (string) ($tgl_cetak), (string) ($no_service_fee)]);
					$resource_insert_service_fee= db_query_or_die('errro_visitor3', $query_insert_service_fee, $__p_query_insert_service_fee ?? []);
					$query_upd_service_fee = q_set($__p_query_upd_service_fee, "update ves_inc.tb_prof_bill set id_soa = ? where no  =? ", [(string) ($id_soa), (string) ($no_service_fee)]);
					$resource_upd_service_fee= db_query_or_die('errro_visitor4', $query_upd_service_fee, $__p_query_upd_service_fee ?? []);	
					echo e($no_service_fee) . " <br>";
					}
				}
			$query_baca_other_billing = q_set($__p_query_baca_other_billing, "SELECT kd_biodata, keterangan, id_invoice, dt_payment, nominal,id FROM tb_invoice_paid where keterangan like  '%Deposit%' and kd_biodata = ? ", [(string) ($kd_biodata)]);
			$resource_baca_other_billing= db_query_or_die('errro_visitor5', $query_baca_other_billing, $__p_query_baca_other_billing ?? []);	
			if(num(db_num_rows($resource_baca_other_billing)) > 0)
				{
				while ($row_bcsotherbill =   db_fetch($resource_baca_other_billing, PDO::FETCH_NUM))
					{

					$kd_biodata = $row_bcsotherbill[0];
					$keterangan = $row_bcsotherbill[1];
					$id_invoice = $row_bcsotherbill[2];
					$dt_payment = $row_bcsotherbill[3];
					$nominal = $row_bcsotherbill[4];
					$id_invoice_paid = $row_bcsotherbill[5];
					
					$query_insert_other_billing = q_set($__p_query_insert_other_billing, "insert into ves_data.adm_soa (kd_biodata,  keterangan, cur_debet, rp_debet, id_soa, no_ref,jns_transaksi,dt_entry,id_nomor) values (? ,? ,'Rp',? ,? ,? ,2,? ,? )", [(string) ($kd_biodata), (string) ($keterangan), (string) ($nominal), (string) ($id_soa), (string) ($id_invoice), (string) ($dt_payment), (string) ($id_invoice_paid)]); 	
					$resource_insert_service_fee= db_query_or_die('errro_visitor6', $query_insert_other_billing, $__p_query_insert_other_billing ?? []);		echo "Baris : " . e($baris) . " <br>";;		
					$query_upd_other_bill = q_set($__p_query_upd_other_bill, "update ves_data.tb_invoice_paid set id_soa = ? where id  =? ", [(string) ($id_soa), (string) ($id_invoice_paid)]);
					$resource_upd_other_bill= db_query_or_die('errro_visitor7', $query_upd_other_bill, $__p_query_upd_other_bill ?? []);
					echo e($id_invoice) . " <br>";
					}
				}
$query_upd_sales_report = q_set($__p_query_upd_sales_report, "update ves_data.tb_sales_report set id_soa = ? where no  =? ", [(string) ($id_soa), (string) ($no_sales)]);
					$resource_upd_sales_report= db_query_or_die('errro_visitor7', $query_upd_sales_report, $__p_query_upd_sales_report ?? []);
$baris = 1;
			}
		}
echo "selesai";die;
