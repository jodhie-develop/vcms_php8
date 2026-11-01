<?php
require_once __DIR__ . "/_lib/bootstrap.php"; csrf_guard_get(); auth_require_login(); 
include __DIR__ . "/conndb.php";

$hari=date("d");
$bulan=date("m");
$tahun=date("Y");
$hari_ini = "$tahun-$bulan-$hari";
$thn = in_val('thn', 'get');
$query_enroll_student = q_set($__p_query_enroll_student, "SELECT kd_biodata, no,kd_cabang,enroll_date FROM tb_sales_report where date_format(enroll_date,'%Y') =   ? and prioritas = 1  and kd_cabang = '3' order by no  ", [(string) ($thn)]);
//$query_enroll_student = "SELECT kd_biodata, no,kd_cabang,enroll_date FROM tb_sales_report where no = 8935  ";

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
			$query_baca_other_billing = q_set($__p_query_baca_other_billing, "SELECT t.id_stu, t.org_fee, t.id_cash_receipt, t.tgl_cetak, t.rp_mount, t.no FROM ves_inc.tb_cash_receipt t where id_stu = ? ", [(string) ($kd_biodata)]);
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
					
					$query_insert_other_billing = q_set($__p_query_insert_other_billing, "insert into ves_data.adm_soa (kd_biodata,  keterangan, cur_debet, rp_debet, id_soa, no_ref,jns_transaksi,dt_entry,id_nomor) values (? ,? ,'Rp',? ,? ,? ,4,? ,? )", [(string) ($kd_biodata), (string) ($keterangan), (string) ($nominal), (string) ($id_soa), (string) ($id_invoice), (string) ($dt_payment), (string) ($id_invoice_paid)]); 	
					$resource_insert_service_fee= db_query_or_die('errro_visitor6', $query_insert_other_billing, $__p_query_insert_other_billing ?? []);				
					$query_upd_other_bill = q_set($__p_query_upd_other_bill, "update ves_inc.tb_cash_receipt set id_soa = ? where no  =? ", [(string) ($id_soa), (string) ($id_invoice_paid)]);
					$resource_upd_other_bill= db_query_or_die('errro_visitor7', $query_upd_other_bill, $__p_query_upd_other_bill ?? []);
					echo e($id_invoice) . " <br>";
					}
				}

$baris = 1;
			}
		}
echo "selesai";die;
