<?php
require_once __DIR__ . "/_lib/bootstrap.php"; csrf_guard_get(); auth_require_login();
include __DIR__ . "/conndb.php";
$nama_lengkap = $_SESSION['nama_lengkap'];  
$id = in_val('id', 'get');
$kb = in_val('kb', 'get');$kc = in_val('kc', 'get');
$sekarang = date("Y-m-d H:i:s");
$bulan = date("m");
$thn = date("Y");
$query_nama = q_set($__p_query_nama, "SELECT  nama_lengkap FROM ves_data.vip_student_data  where  kd_biodata = ? ", [(string) ($kb)]);
$resource_nama = db_query_soft($query_nama, $__p_query_nama ?? []);				
if(num(db_num_rows($resource_nama)) > 0)
	{
	while ($row_nama  =  db_fetch($resource_nama, PDO::FETCH_NUM))
		{
		$nama_lengkap_student = $row_nama[0];
		}
	}
$query_kode = q_set($__p_query_kode, "select a.kd_program,b.nm_program,group_sertifikat from vip_billing a left join vip_mst_code_prg b on a.kd_program = b.kd_program where kd_class = ? ", [(string) ($kc)]);
$resource_kode = db_query_soft($query_kode, $__p_query_kode ?? []);				
if(num(db_num_rows($resource_kode)) > 0)
	{
	while ($row_kode  =  db_fetch($resource_kode, PDO::FETCH_NUM))
		{
		$kode_certificate = $row_kode[0];
		$group_certificate = $row_kode[2];
		}
	}
if($bulan =='01'){$bln_rom="I";} elseif($bulan =='02'){$bln_rom="II";}	elseif($bulan =='03'){$bln_rom="III";}	elseif($bulan =='04'){$bln_rom="IV";}
elseif($bulan =='05'){$bln_rom="V";}	elseif($bulan =='06'){$bln_rom="VI";}	elseif($bulan =='07'){$bln_rom="VII";}	elseif($bulan =='08'){$bln_rom="VIII";}
elseif($bulan =='09'){$bln_rom="IX";}	elseif($bulan =='10'){$bln_rom="X";}	elseif($bulan =='11'){$bln_rom="XI";}	elseif($bulan =='12'){$bln_rom="XII";}

$query_buat_kode = q_set($__p_query_buat_kode, "SELECT no_registrasi FROM vip_kd_certificate  where group_certificate = ? and tahun = ?  order by id desc limit 1", [(string) ($group_certificate), (string) ($thn)]);
$resource_buat_kode = db_query_soft($query_buat_kode, $__p_query_buat_kode ?? []);				
if(num(db_num_rows($resource_buat_kode)) > 0)
	{
	while ($row_buat_kode  =  db_fetch($resource_buat_kode, PDO::FETCH_NUM))
		{
		$no_registrasi =$row_buat_kode[0];
		$angka =  substr($no_registrasi,0,-4);
		$angkabaru=num($angka)+1;
		$digit=strlen($angkabaru);
		if(!$angkabaru){ $nol='000'; }elseif(num($digit)==1){ $nol='000'; }	elseif(num($digit)==2){ $nol='00'; }	elseif(num($digit)==3)
		{ $nol='0'; }	
		$nomor_baru = $nol.$angkabaru."/VIP/".$group_certificate."/".$bln_rom."/".$thn;			
		
		}
	}
else
	{
	$nomor_baru = "0001/VIP/".$group_certificate."/".$bln_rom."/".$thn;	
	}


$query_generate = q_set($__p_query_generate, "insert into vip_kd_certificate (kd_biodata, nama_student,  group_certificate, tgl_cetak, no_registrasi, kode_kelas)values(? ,? ,? ,? ,? ,? )", [(string) ($kb), (string) ($nama_lengkap_student), (string) ($group_certificate), (string) ($sekarang), (string) ($nomor_baru), (string) ($kc)]);
$resource_generate = db_query_soft($query_generate, $__p_query_generate ?? []);			

echo "<script type=\"text/javascript\">\n";
echo "alert('Certifikat atas nama " . e($nama_lengkap_student) . " sudah dibuat oleh " . e($nama_lengkap) . "');\n";
echo "window.opener.location.reload(true);\n";								
echo "window.close();\n";				
echo "</script>";
?>
