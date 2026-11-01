<?php
require_once __DIR__ . "/_lib/bootstrap.php"; csrf_guard_get(); auth_require_login(); 
include __DIR__ . "/conndb.php";

$hari=date("d");
$bulan=date("m");
$tahun=date("Y");
$hari_ini = "$tahun-$bulan-$hari";
$thn = in_val('thn', 'get');
$nd = in_val('nd', 'get');
$idsoa = in_val('idsoa', 'get');

//$query_enroll_student = "SELECT kd_biodata, no,kd_cabang,enroll_date FROM tb_sales_report where date_format(enroll_date,'%Y') =   '$thn' and prioritas = 1  order by no  ";

if($nd !='' and $idsoa !='')
{
$query_baca_other_billing = q_set($__p_query_baca_other_billing, "SELECT a.kd_biodata, b.keterangan, a.id_invoice, dt_payment, a.nominal,a.id,a.id_soa FROM ves_data.tb_invoice_paid a left join ves_data.tb_invoice b on a.id_billing = b.id_billing where a.id_invoice = ? ", [(string) ($nd)]);

$resource_baca_other_billing= db_query_or_die('errro_visitor5', $query_baca_other_billing, $__p_query_baca_other_billing ?? []);	
if(num(db_num_rows($resource_baca_other_billing)) > 0)
	{
	while ($row_bcsotherbill =   db_fetch($resource_baca_other_billing, PDO::FETCH_NUM))
		{
		$kd_biodata = $row_bcsotherbill[0];
		$id_soa = $row_bcsotherbill[6];		
		if($id_soa =='')
		{		
		$keterangan = $row_bcsotherbill[1];
		$id_invoice = $row_bcsotherbill[2];
		$dt_payment = $row_bcsotherbill[3];
		$nominal = $row_bcsotherbill[4];
		$id_invoice_paid = $row_bcsotherbill[5];
		$query_insert_other_billing = q_set($__p_query_insert_other_billing, "insert into ves_data.adm_soa (kd_biodata,  keterangan, cur_debet, rp_debet, id_soa, no_ref,jns_transaksi,dt_entry,id_nomor) values (? ,? ,'Rp',? ,? ,? ,2,? ,? )", [(string) ($kd_biodata), (string) ($keterangan), (string) ($nominal), (string) ($idsoa), (string) ($id_invoice), (string) ($dt_payment), (string) ($id_invoice_paid)]);/* echo $query_insert_other_billing (debug SQL versi lama) dihapus */
		$resource_insert_service_fee= db_query_or_die('errro_visitor6', $query_insert_other_billing, $__p_query_insert_other_billing ?? []);				
		$query_upd_other_bill = q_set($__p_query_upd_other_bill, "update ves_data.tb_invoice_paid set id_soa = ? where id  =? ", [(string) ($idsoa), (string) ($id_invoice_paid)]);
		$resource_upd_other_bill= db_query_or_die('errro_visitor7', $query_upd_other_bill, $__p_query_upd_other_bill ?? []);
			echo "selesai";die;
		}
		else
		{echo "Receipt already assigned into another soa : " . e($id_soa) . " ";}
	}
}
}
	else
	{echo "nd and idsoa must be filled";}


	
		

