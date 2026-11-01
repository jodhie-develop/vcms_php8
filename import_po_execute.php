<?php
require_once __DIR__ . "/_lib/bootstrap.php"; csrf_guard_get(); auth_require_login(); 
include __DIR__ . "/conndb.php";

$hari=date("d");
$bulan=date("m");
$tahun=date("Y");
$hari_ini = "$tahun-$bulan-$hari";
$thn = in_val('thn', 'get');
$kdp= in_val('kdp', 'get');
$idsoa= in_val('idsoa', 'get');
$kdb=in_val('kdb', 'get');

			
$query_baca_po = q_set($__p_query_baca_po, "SELECT order_cost , amount, dt_po,b.id FROM ves_data.purchase_order p left join ves_data.purchase_order_item b on p.kode = b.kode where b.kode  = ? ", [(string) ($kdp)]);
			$resource_baca_po= db_query_or_die('errro_visitor8', $query_baca_po, $__p_query_baca_po ?? []);	
			if(num(db_num_rows($resource_baca_po)) > 0)
				{
				while ($row_baca_po =   db_fetch($resource_baca_po, PDO::FETCH_NUM))
					{

					$peruntukan = $row_baca_po[0];
					$amount = $row_baca_po[1];
					$dt_entry = $row_baca_po[2];
					$id_po = $row_baca_po[3];				
					$query_insert_po = q_set($__p_query_insert_po, "insert into ves_data.adm_soa (kd_biodata,  keterangan, cur_kredit, rp_kredit, id_soa, no_ref, jns_transaksi, dt_entry) values (? ,? ,'Rp',? ,? ,? ,3,? )", [(string) ($kdb), (string) ($peruntukan), (string) ($amount), (string) ($idsoa), (string) ($kdp), (string) ($dt_entry)]); 	
					$resource_insert_po= db_query_or_die('errro_visitor9', $query_insert_po, $__p_query_insert_po ?? []);	
					$query_upd_po_item = q_set($__p_query_upd_po_item, "update ves_data.purchase_order set id_soa = ? ,kd_biodata = ? where kode  =? ", [(string) ($idsoa), (string) ($kdb), (string) ($kdp)]);
					$resource_upd_po= db_query_or_die('errro_visitor10', $query_upd_po_item, $__p_query_upd_po_item ?? []);
					$query_upd_po = q_set($__p_query_upd_po, "update ves_data.purchase_order_item set id_soa = ? where kode  =? ", [(string) ($idsoa), (string) ($kdp)]);
					$resource_upd_po= db_query_or_die('errro_visitor11', $query_upd_po, $__p_query_upd_po ?? []);
											
					}
			}
		echo "<script type=\"text/javascript\">\n";
		echo "alert('Import Succesfully');\n";
		echo "window.opener.location.reload(true);\n";
		echo "window.close(); \n";				
		echo "</script>";