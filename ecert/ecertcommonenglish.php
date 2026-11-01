<?php
require_once __DIR__ . "/../_lib/bootstrap.php"; csrf_guard_get();
include __DIR__ . "/../conndb.php";
$gambar = "commenglish.jpg";
//$tanda = "tanda.jpg";
$hari=date("d");
$bulan=date("m");
$tahun=date("Y");
$tgl_hari_ini =  "$tahun-$bulan-$hari";



$kd = in_val('kd', 'get');
$kds = in_val('kds', 'get');

$query = q_set($__p_query, "SELECT kode, nama, e_mail, sertifikat,kds FROM vip_data_sertifikat where sertifikat = 'Masterclass' and kode = ? and kds= ? ", [(string) ($kd), (string) ($kds)]);

$resource = db_query_or_die('errro_76', $query, $__p_query ?? []);
if(num(db_num_rows($resource)) == 0)
	{
		echo "<script type=\"text/javascript\">\n";
		echo "alert('You dont have privillage to access this page');\n";
		echo "window.location = ('https://vistaeducation.com');\n";				
		echo "</script>";
	}
while ($row_nama=  db_fetch($resource, PDO::FETCH_NUM))
	{
	$nama_student =   $row_nama[1];
	$query_upd = q_set($__p_query_upd, "update  vip_data_sertifikat set dt_open = ? where  kode = ? and kds= ? ", [(string) ($tgl_hari_ini), (string) ($kd), (string) ($kds)]);
	$resource_upd = db_query_or_die('errro_76', $query_upd, $__p_query_upd ?? []);	
	}

if($prgg != ''){$prg = $prgg;}
if($prg_type ==''){$prg_type = $prgg;}
$image = imagecreatefromjpeg($gambar);

//imagecopymerge($image, $imgtd, 1410, 980, 0, 0, 170, 170, 35);
$white = imageColorAllocate($image, 255, 255, 255);
$black = imageColorAllocate($image, 0, 0, 0);
$font = "MonotypeCorsiva.ttf";
$fontnama = "greatvibesregular.ttf";
$fontnomor = "Montserrat-Medium.ttf";

$sizenama = 73;
$sizenomor = 15;
$sizekecil = 20;
	//definisikan lebar gambar agar posisi teks selalu ditengah berapapun jumlah hurufnya
	$image_width = imagesx($image); 
	//membuat textbox agar text centered
	$text_boxnama = imagettfbbox($sizenama,0,$fontnama,$nama_student);
	$text_widthnama = num($text_boxnama[2])-num($text_boxnama[0]);
	$text_box = imagettfbbox($size,0,$font,$nama_student);
	$text_width = num($text_box[2])-num($text_box[0]); // lower right corner - lower left corner
	$text_height = num($text_box[3])-num($text_box[1]);
	$x = num((num($image_width)/2)) - num((num($text_widthnama)/2));
	//$x = ($image_width/2) - ($text_width/3);
	//generate sertifikat beserta namanya
	imagettftext($image, $sizenama, 0, $x, 534, $black, $fontnama, $nama_student);
	imagettftext($image, $sizenomor, 0, 1700, 1395, $white, $fontnomor, $no_registrasi);

	//tampilkan di browser
	header("Content-type:  image/jpeg");
	imagejpeg($image);
	imagedestroy($image);
?>
<head>
<title><?php echo e($nama_student) ?> - VIP English E Certificate </title>
</head>