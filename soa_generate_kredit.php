<?php
require_once __DIR__ . "/_lib/bootstrap.php"; csrf_guard_get(); auth_require_login(); 
include __DIR__ . "/conndb.php";

$hari=date("d");
$bulan=date("m");
$tahun=date("Y");
$hari_ini = "$tahun-$bulan-$hari";
$thn = in_val('thn', 'get');
$idbcpo = in_val('idbcpo', 'get');
$query_enroll_student = q_set($__p_query_enroll_student, "SELECT kd_biodata, no,kd_cabang,enroll_date FROM tb_sales_report where date_format(enroll_date,'%Y') =   ? and prioritas = 1  order by no  ", [(string) ($thn)]);
$resource_enroll_student= db_query_or_die('errro_visitor1', $query_enroll_student, $__p_query_enroll_student ?? []);
	if(num(db_num_rows($resource_enroll_student)) > 0)
		{
		while ($row_es =   db_fetch($resource_enroll_student, PDO::FETCH_NUM))
			{
			$kd_biodata = $row_es[0];
			$no = $row_es[1];
			$kd_cabang = $row_es[2];
			$enroll_date = $row_es[3];
			$id_soa = "$kd_biodata$no";
			
$query_baca_po = q_set($__p_query_baca_po, "SELECT peruntukan , amount, p.kode,dt_po,b.id,order_cost FROM ves_data.purchase_order p left join ves_data.purchase_order_item b on p.kode = b.kode where kd_biodata = ? and p.id > ?  ", [(string) ($kd_biodata), (string) ($idbcpo)]);
			$resource_baca_po= db_query_or_die('errro_visitor8', $query_baca_po, $__p_query_baca_po ?? []);	
			if(num(db_num_rows($resource_baca_po)) > 0)
				{
				while ($row_baca_po =   db_fetch($resource_baca_po, PDO::FETCH_NUM))
					{

					$peruntukan = $row_baca_po[5];
					$amount = $row_baca_po[1];
					$kode_po = $row_baca_po[2];
					$dt_entry = $row_baca_po[3];
					$id_po = $row_baca_po[4];	
					echo e($id_po) . " <br>";	
			
					$query_insert_po = q_set($__p_query_insert_po, "insert into ves_data.adm_soa (kd_biodata,  keterangan, cur_kredit, rp_kredit, id_soa, no_ref, jns_transaksi, dt_entry) values (? ,? ,'Rp',? ,? ,? ,3,? )", [(string) ($kd_biodata), (string) ($peruntukan), (string) ($amount), (string) ($id_soa), (string) ($kode_po), (string) ($dt_entry)]); 	
					$resource_insert_po= db_query_or_die('errro_visitor9', $query_insert_po, $__p_query_insert_po ?? []);	
					$query_upd_po_item = q_set($__p_query_upd_po_item, "update ves_data.purchase_order set id_soa = ? where kode  =? ", [(string) ($id_soa), (string) ($kode_po)]);
					$resource_upd_po= db_query_or_die('errro_visitor10', $query_upd_po_item, $__p_query_upd_po_item ?? []);
					$query_upd_po = q_set($__p_query_upd_po, "update ves_data.purchase_order_item set id_soa = ? where kode  =? ", [(string) ($id_soa), (string) ($kode_po)]);
					$resource_upd_po= db_query_or_die('errro_visitor11', $query_upd_po, $__p_query_upd_po ?? []);
											
					}
			}

			}
		}
echo "selesai";die;
