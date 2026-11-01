<?php
require_once __DIR__ . "/_lib/bootstrap.php"; csrf_guard_get(); auth_require_login(); 
ini_set("memory_limit","256M");
include __DIR__ . "/conndb.php";
include __DIR__ . "/profiledata.php";
$hari=date("d");
$bulan=date("m");
$tahun=date("Y");
$tgl_hari_ini =  "$tahun-$bulan-$hari";
	$nama_pemohon = $_SESSION['nama_lengkap'];
$cid = in_val('cid', 'get');
$hrid = in_val('hrid', 'get');

	$query_review= q_set($__p_query_review, "select st_contract from ves_data.hr_cntrct_review where id = ?  and hr_id = ? ", [(string) ($id), (string) ($hrid)]);
$resource_review = db_query_soft($query_review, $__p_query_review ?? []);			
if(num(db_num_rows($resource_review)) > 0)
	{ 
	while ($row_contract  =  db_fetch($resource_contract, PDO::FETCH_NUM))
		{
		if (num($row_contract[0]) == 0 and $nama_pemohon ="lanni susanti")
			{
			$query_insert_po_item = q_set($__p_query_insert_po_item, "update ves_data.hr_cntrct_review set st_contract = 1, pic = ? where id = ?  and hr_id = ?  ", [(string) ($nama_pemohon), (string) ($cid), (string) ($hrid)]);
	$resource_urut_po_item = db_query_or_die('errro_1', $query_insert_po_item, $__p_query_insert_po_item ?? []);	
			}
		elseif (num($row_contract[0]) == 1 and $nama_pemohon ="lanni susanti")
			{
			$query_insert_po_item = q_set($__p_query_insert_po_item, "update ves_data.hr_cntrct_review set st_contract = 0, pic = ? where id = ?  and hr_id = ?  ", [(string) ($nama_pemohon), (string) ($cid), (string) ($hrid)]);
	$resource_urut_po_item = db_query_or_die('errro_1', $query_insert_po_item, $__p_query_insert_po_item ?? []);	
			}
		elseif (num($row_contract[0]) == 1 and $nama_pemohon ="jimmy")
			{
			$query_insert_po_item = q_set($__p_query_insert_po_item, "update ves_data.hr_cntrct_review set st_contract = 2, pic = ? where id = ?  and hr_id = ?  ", [(string) ($nama_pemohon), (string) ($cid), (string) ($hrid)]);
	$resource_urut_po_item = db_query_or_die('errro_1', $query_insert_po_item, $__p_query_insert_po_item ?? []);	
			}	
		
		
		}
	}
		
		echo "<script type=\"text/javascript\">\n";
	echo "alert('Item Added');\n";

	echo "window.opener.location.reload(true);\n";
	echo "window.close(); \n";				
	echo "</script>";



?>

	
	