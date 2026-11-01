<?php
require_once __DIR__ . "/_lib/bootstrap.php"; csrf_guard_get(); auth_require_login();
ini_set("memory_limit","512M");
include __DIR__ . "/conndb.php";
$hari=date("d");
$bulan=date("m");
$tahun=date("Y");
$tgl_hari_ini =  "$tahun-$bulan-$hari";
$blnhr = "$hari$bulan";
//==unik kode mulai
$x = 0;
while(num($x) <= 100)
{
$kd_unik= rand(5,100);
$query_unik = q_set($__p_query_unik, "select kd_unik from ves_data.tb_banking WHERE kd_unik= ?  and status = 0", [(string) ($kd_unik)]);
$resource_unik = db_query_or_die('errro_last_billing', $query_unik, $__p_query_unik ?? []);
if(num(db_num_rows($resource_unik)) == 0)
	{
	$query_insert_kd = q_set($__p_query_insert_kd, "insert into ves_data.tb_banking (jns_transaksi, id_transaksi, kd_unik, status, dt_entry,nominal ) values (1,? ,? ,? ,'0',? )", [(string) ($kode_transaksi), (string) ($kd_unik), (string) ($saat_ini), (string) ($amount)]);
	$resource = db_query_or_die('errro_simpan1', $query_insert_kd, $__p_query_insert_kd ?? []);
	$akhir_id = db_insert_id();
	echo e($kd_unik);
	echo e($akhir_id);
	break;	
	}
	$x++;
}
//==unik kode selesai
//=====================
?>