<?php
require_once __DIR__ . "/_lib/bootstrap.php"; csrf_guard_get(); auth_require_login(); 
include __DIR__ . "/conndb.php";
include __DIR__ . "/profiledata.php";

$hari=date("d");
$bulan=date("m");
$tahun=date("Y");
$hari_ini = "$tahun-$bulan-$hari";		
$brg_cat = in_val('brg_cat', 'post');
$brg_sub_cat = in_val('brg_sub_cat', 'post');
$query_cek_category = q_set($__p_query_cek_category, "SELECT id from brg_master_cat where brg_cat = ? and brg_sub_cat = ? ", [(string) ($brg_cat), (string) ($brg_sub_cat)]);

$result_cek_category=db_query_or_die("Wah error nih1", $query_cek_category, $__p_query_cek_category ?? []);
if(num(db_num_rows($result_cek_category)) > 0)
	{
	while ($row_cat=  db_fetch($result_cek_category, PDO::FETCH_NUM))
		{
		$id_cat = $row_cat[0];
		}
	}
	
$brg_title  = in_val('brg_title', 'post');	
$brg_deskripsi  = in_val('brg_deskripsi', 'post');	
$brg_tgl_beli = in_val('brg_tgl_beli', 'post');
$brg_vendor = in_val('brg_vendor', 'post');	
	
	$query_simpan_program = q_set($__p_query_simpan_program, "insert into ves_data.brg_master_item(id_cat, brg_title, brg_description, thn_pembelian, nm_vendor, item_registration,dt_entry) values(? ,? ,? ,? ,? ,'',? )", [(string) ($id_cat), (string) ($brg_title), (string) ($brg_deskripsi), (string) ($brg_tgl_beli), (string) ($brg_vendor), (string) ($hari_ini)]);
	$resource_simpan_score_class = db_query_or_die('errro_simpan2', $query_simpan_program, $__p_query_simpan_program ?? []);
echo e($brg_cat) ; echo e($brg_sub_cat);die;
					echo "<script type=\"text/javascript\">\n";
				echo "alert('New Item Submitted');\n";
				echo "window.open('brg_list.php?brg_cat=" . e(u($brg_cat)) . "&brg_sub_cat=" . e(u($brg_sub_cat)) . "', '_self');\n";				
				echo "</script>";	

?>	