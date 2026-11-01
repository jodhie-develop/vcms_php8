<?php
require_once __DIR__ . "/../_lib/bootstrap.php";
include __DIR__ . "/../conndb.php";
$kd = in_val('kd', 'get');
$gambar = "ecertbim.jpg";
$kdb = in_val('kdb', 'get');
$query = q_set($__p_query, "SELECT concat_ws(' ',nama, middle_name, family_name) FROM ves_inc.tb_biodata a where kd_biodata = ? ", [(string) ($kdb)]);
$resource = db_query_or_die('errro_76', $query, $__p_query ?? []);
while ($row_nama=  db_fetch($resource, PDO::FETCH_NUM))
	{
	$nama_student =   $row_nama[0];
	}
$query_prgm = q_set($__p_query_prgm, "SELECT nm_program, a.level_program FROM ves_data.vip_billing a left join ves_data.vip_mst_code_prg b on a.kd_program = b.kd_program where kd_biodata = ? order by a.no desc limit 1", [(string) ($kdb)]);
$resource_prg = db_query_or_die('errro_76', $query_prgm, $__p_query_prgm ?? []);
while ($row_prg=  db_fetch($resource_prg, PDO::FETCH_NUM))
	{
	$prg =   $row_prg[0];
	}

$query_test = q_set($__p_query_test, "SELECT L, S, R, W, total, date_format(test_date,'%d %M %Y'),prg_recom,prg_type FROM ves_data.vip_class_score_profile where kd_biodata= ? and jns_test = 1 order by no desc limit 1", [(string) ($kdb)]);
$resource_test = db_query_or_die('errro_76', $query_test, $__p_query_test ?? []);
while ($row_test=  db_fetch($resource_test, PDO::FETCH_NUM))
	{
	$tgl_test =   $row_test[5];
	$l =   $row_test[0];
	$s =   $row_test[1];
	$r =   $row_test[2];
	$w =   $row_test[3];
	$total =   $row_test[4];
	$prgg =   $row_test[6];
	$prg_type =   $row_test[7];	
	}
if($prgg != ''){$prg = $prgg;}
if($prg_type ==''){$prg_type = $prgg;}
$image = imagecreatefromjpeg($gambar);
$white = imageColorAllocate($image, 255, 255, 255);
$black = imageColorAllocate($image, 0, 0, 0);
$font = "MonotypeCorsiva.ttf";
$fontnama = "greatvibesregular.ttf";
//$fontnama = "MonotypeCorsiva.ttf";
$sizenama = 56;
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
	imagettftext($image, $sizenama, 0, $x, 500, $black, $fontnama, $nama_student);
	imagettftext($image, $size, 0, 510, 558, $black, $font, $tgl_test);
	imagettftext($image, $size, 0, 510, 658, $black, $font, $prg_type);
	imagettftext($image, $size, 0, 750, 888, $black, $font, $l);
	imagettftext($image, $size, 0, 750, 935, $black, $font, $r);
	imagettftext($image, $size, 0, 750, 978, $black, $font, $w);
	imagettftext($image, $size, 0, 750, 1029, $black, $font, $s);
	imagettftext($image, $size, 0, 750, 1079, $black, $font, $total);
	imagettftext($image, $sizekecil, 0, 625, 1210, $black, $font, $prg);
	//tampilkan di browser
	header("Content-type:  image/jpeg");
	imagejpeg($image);
	imagedestroy($image);
?>
<head>
<title>Vista Education E Certificate</title>
</head>