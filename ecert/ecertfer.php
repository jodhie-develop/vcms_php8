<?php
require_once __DIR__ . "/../_lib/bootstrap.php";
include __DIR__ . "/../conndb.php";
$kd = in_val('kd', 'get');
$gambar = "fer.jpg";
$kdb = in_val('kdb', 'get');
$query = q_set($__p_query, "SELECT concat_ws(' ',nama, middle_name, family_name) FROM ves_inc.tb_biodata a where kd_biodata = ? ", [(string) ($kdb)]);
$resource = db_query_or_die('errro_76', $query, $__p_query ?? []);
while ($row_nama=  db_fetch($resource, PDO::FETCH_NUM))
	{
	$nama_student =   $row_nama[0];
	}
$query_prgm = q_set($__p_query_prgm, "SELECT nm_program, a.level_program,kd_class FROM ves_data.vip_billing a left join ves_data.vip_mst_code_prg b on a.kd_program = b.kd_program where kd_biodata = ? order by a.no desc limit 1", [(string) ($kdb)]);
$resource_prg = db_query_or_die('errro_76', $query_prgm, $__p_query_prgm ?? []);
while ($row_prg=  db_fetch($resource_prg, PDO::FETCH_NUM))
	{
	$prg =   $row_prg[0];
	$levl_prg =   $row_prg[1];
	$nm_program = "$prg $levl_prg";
	$kd_class = $row_prg[2];;	
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
$query_test = q_set($__p_query_test, "SELECT L, S, R, W, total, date_format(test_date,'%d %M %Y'),prg_recom,prg_type FROM ves_data.vip_class_score_profile where kd_biodata= ? and jns_test = 3 and class_code = ? order by no desc limit 1", [(string) ($kdb), (string) ($kd_class)]);
$resource_test = db_query_or_die('errro_76', $query_test, $__p_query_test ?? []);
while ($row_test_f=  db_fetch($resource_test, PDO::FETCH_NUM))
	{

	$l_f =   $row_test_f[0];
	$s_f =   $row_test_f[1];
	$r_f =   $row_test_f[2];
	$w_f =   $row_test_f[3];
	$total_f =   $row_test_f[4];
	}


$image = imagecreatefromjpeg($gambar);
$white = imageColorAllocate($image, 255, 255, 255);
$black = imageColorAllocate($image, 0, 0, 0);
$font = "MonotypeCorsiva.ttf";
$fontnama = "greatvibesregular.ttf";
//$fontnama = "MonotypeCorsiva.ttf";
$sizenama = 16;
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
	imagettftext($image, $sizenama, 0, 195, 248, $black, $fontnama, $nama_student);
	imagettftext($image, $sizenama, 0, 195, 275, $black, $font, $nm_program);
	imagettftext($image, $sizenama, 0, 102, 545, $black, $font, $l);
	imagettftext($image, $sizenama, 0, 157, 545, $black, $font, $r);
	imagettftext($image, $sizenama, 0, 219, 545, $black, $font, $w);
	imagettftext($image, $sizenama, 0, 272, 545, $black, $font, $s);
	imagettftext($image, $sizenama, 0, 335, 545, $black, $font, $total);

	imagettftext($image, $sizenama, 0, 402, 545, $black, $font, $l_f);
	imagettftext($image, $sizenama, 0, 457, 545, $black, $font, $r_f);
	imagettftext($image, $sizenama, 0, 519, 545, $black, $font, $w_f);
	imagettftext($image, $sizenama, 0, 572, 545, $black, $font, $s_f);
	imagettftext($image, $sizenama, 0, 635, 545, $black, $font, $total_f);

	//tampilkan di browser
	header("Content-type:  image/jpeg");
	imagejpeg($image);
	imagedestroy($image);
?>
<head>
<title><?php echo e($nama_student) ?> - VIP FER </title>
</head>