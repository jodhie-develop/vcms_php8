<?php
require_once __DIR__ . "/_lib/bootstrap.php"; csrf_guard_get(); auth_require_login(); 
ini_set("memory_limit","256M");
include __DIR__ . "/conndb.php";
include __DIR__ . "/profiledata.php";
$hari=date("d");
$bulan=date("m");
$tahun=date("Y");
$tgl_hari_ini =  "$tahun-$bulan-$hari";
$nama_lengkap = $_SESSION['nama_lengkap']; 
$no = in_val('no', 'get');
$kd_branch = $_SESSION['kd_branch'];
$user = in_val('user', 'get');
if ($no != '')
{	
$query = q_set($__p_query, "SELECT m.id, m.id_item, t.kode_item, m.q FROM ves_data.mst_asset_in m left join mst_asset t on m.id_item = t.id where m.id = ? ", [(string) ($no)]);

$resource = db_query_soft($query, $__p_query ?? []);
$keluar = db_num_rows($resource);
if(num(db_num_rows($resource)) > 0)
	{
	while ($row  =  db_fetch($resource, PDO::FETCH_NUM))
		{
		$id_transaksi = $row[0];
		$id_book = $row[1];
		$q = $row[3];
		$kode_item = $row[2];
		}
	}
}
$querylastcode = q_set($__p_querylastcode, "SELECT MAX(right(m.reg_code,4)) FROM ves_data.mst_asset_reg_dtl m WHERE  id_book = ? ", [(string) ($id_book)]);
$resourcelastcode = db_query_soft($querylastcode, $__p_querylastcode ?? []);
$keluar = db_num_rows($resourcelastcode);
if(num(db_num_rows($resourcelastcode)) > 0)
	{
	while ($rowlastcode  =  db_fetch($resourcelastcode, PDO::FETCH_NUM))
		{
		$kode_terakhir = $rowlastcode[0];
		}
	}
if ($kode_terakhir ==''){$kode_terakhir = '1';}
else{$kode_terakhir = number_format(num($kode_terakhir));$kode_terakhir = num($kode_terakhir)+1;}

$i = 1;
do {
if(num($kode_terakhir) <= 9){$nol = '000';}
elseif(num($kode_terakhir) >= 10 and num($kode_terakhir) <=99){$nol = '00';}
elseif(num($kode_terakhir) >= 100 and num($kode_terakhir) <=999){$nol = '0';}
elseif(num($kode_terakhir) >= 1000){$nol = '';}


$kode_buku_baru = $kode_item.$nol.$kode_terakhir;

$query_skil = q_set($__p_query_skil, "insert into  ves_data.mst_asset_reg_dtl (id_book,id_transaksi, reg_code, storage, pic, dt_entry,status)values (? ,? ,? ,? ,? ,? ,5)", [(string) ($id_book), (string) ($id_transaksi), (string) ($kode_buku_baru), (string) ($storage), (string) ($nama_lengkap), (string) ($tgl_hari_ini) . " "]);
		$resource_insert_booklog = db_query_or_die('errro_simpan_3', $query_skil, $__p_query_skil ?? []);	
$kode_terakhir = num($kode_terakhir)+1;
  $i++;
} while ($i <= $q);

	echo "<script type=\"text/javascript\">\n";
	echo "alert('Code Generated	');\n";
	echo "window.opener.location.reload(true);\n";
	echo "window.close(); \n";				
	echo "</script>";
?>
