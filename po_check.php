<?php
require_once __DIR__ . "/_lib/bootstrap.php"; csrf_guard_get(); auth_require_login(); 
$id = in_val('id', 'get');
$kode_po = in_val('kode_po', 'get');


include __DIR__ . "/conndb.php";
include __DIR__ . "/profiledata.php";
$nama_check = $_SESSION['nama_lengkap'];
$hari=date("d");
$bulan=date("m");
$tahun=date("y");
$hari_ini = "$tahun-$bulan-$hari";
echo e($hari_ini);
echo e($nama_check);die;

$query_delete = q_set($__p_query_delete, "update ves_data.purchase_order set po_status = 3, ack_by = ? ,ack_date = '' where kode = '' where  kode = ? ", [(string) ($nam), (string) ($kode_po)]);	
$resource_po = db_query_or_die('errro_1', $query_delete, $__p_query_delete ?? []);
$query_log = q_set($__p_query_log, "insert into purchase_order_log (kode, dt_entry,po_status,pic, remark) values (? ,? ,'3',? ,'Checked')", [(string) ($kode_po), (string) ($hari_ini), (string) ($nama_check)]);
$resource_po = db_query_or_die('errro_2', $query_log, $__p_query_log ?? []);
		echo "<script type=\"text/javascript\">\n";
		echo "alert('Purchase Order Propose Deleted');\n";
		echo "window.opener.location.reload(true);\n";
		echo "window.close(); \n";				
		echo "</script>";
?>