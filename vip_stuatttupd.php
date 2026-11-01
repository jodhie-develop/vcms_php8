<?php
require_once __DIR__ . "/_lib/bootstrap.php"; csrf_guard_get(); auth_require_login(); 
include __DIR__ . "/conndb.php";

$hari=date("d");
$bulan=date("m");
$tahun=date("Y");
$hari_ini = "$tahun-$bulan-$hari";

$nama_lengkap = $_SESSION['nama_lengkap'];
$kdb = in_val('kdb', 'get');
$st = in_val('st', 'get');
$nomor = in_val('id', 'get');


//--ambil tanggal kelas
$query_kelas = q_set($__p_query_kelas, "SELECT kelas, kd_branch, mulai_tm  FROM ves_data.vip_teacher_schedule v where id = ? ", [(string) ($nomor)]);

$resource_kelas= db_query_or_die('errro_visitor1', $query_kelas, $__p_query_kelas ?? []);
$keluar_kelas= db_num_rows($resource_kelas);
	if(num(db_num_rows($resource_kelas)) > 0)
		{
		while ($row_kelas =   db_fetch($resource_kelas, PDO::FETCH_NUM))
			{
			$kdcl = $row_kelas[0];
			$kdcbg = $row_kelas[1];	
			$tgl_meeting = $row_kelas[2];	
			}
		}
$query_check = q_set($__p_query_check, "SELECT v.kd_class, v.kd_branch, v.kd_biodata, v.dt_meeting FROM ves_data.vip_attendance v where kd_class = ? and dt_meeting = ? and kd_biodata = ? ", [(string) ($kdcl), (string) ($tgl_meeting), (string) ($kdb)]);

$resource_check= db_query_or_die('errro_visitor1', $query_check, $__p_query_check ?? []);
$keluar_check= db_num_rows($resource_check);
if(num(db_num_rows($resource_check)) > 0)
	{
	$query_upd = q_set($__p_query_upd, "update ves_data.vip_attendance  set st_attendance = ? ,dt_entry = ? ,pic= ? where kd_class = ?  and dt_meeting = ? and kd_biodata = ? ", [(string) ($st), (string) ($hari_ini), (string) ($nama_lengkap), (string) ($kdcl), (string) ($tgl_meeting), (string) ($kdb)]);
	$resource_upd= db_query_or_die('errro_visitor2', $query_upd, $__p_query_upd ?? []);
	}
else
	{
	$query_masuk = q_set($__p_query_masuk, "insert into ves_data.vip_attendance (kd_class, kd_branch, kd_biodata, dt_meeting,st_attendance,dt_entry, pic) values(? ,? ,? ,? ,? ,? ,? )", [(string) ($kdcl), (string) ($kdcbg), (string) ($kdb), (string) ($tgl_meeting), (string) ($st), (string) ($hari_ini), (string) ($nama_lengkap)]);
	$resource_masuk= db_query_or_die('errro_visitor3', $query_masuk, $__p_query_masuk ?? []);
	}
echo "<script type=\"text/javascript\">\n";

echo "window.location = ('vip_stuattt.php?no=" . e(u($nomor)) . "');\n";				
echo "</script>";
?>