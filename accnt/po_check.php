<?php
require_once __DIR__ . "/../_lib/bootstrap.php"; csrf_guard_get(); auth_require_login(); 
$id = in_val('id', 'get');
$kode_po = in_val('kode_po', 'get');


include __DIR__ . "/../conndb.php";
include __DIR__ . "/../profiledata.php";
$nama_check = $_SESSION['nama_lengkap'];
$hari=date("d");
$bulan=date("m");
$tahun=date("y");
$hari_ini = "$tahun-$bulan-$hari";
$query_delete = q_set($__p_query_delete, "update ves_data.purchase_order set po_status = 3, ack_by = ? , ack_date = ? where  kode = ? ", [(string) ($nama_check), (string) ($hari_ini), (string) ($kode_po)]);	

$resource_po = db_query_or_die('errro_1', $query_delete, $__p_query_delete ?? []);

		echo "<script type=\"text/javascript\">\n";
		echo "alert('Purchase Order Checked');\n";
		echo "window.opener.location.reload(true);\n";
		echo "window.close(); \n";				
		echo "</script>";
?>