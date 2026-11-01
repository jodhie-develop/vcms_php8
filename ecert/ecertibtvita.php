<?php
require_once __DIR__ . "/../_lib/bootstrap.php";
include __DIR__ . "/../conndb.php";
$kd = in_val('kd', 'get');
//$gambar = "ecertieltibt.jpg";
$gambar = "ecertieltibtnew_vita.jpg";
$kdb = in_val('kdb', 'get');
$nr = in_val('nr', 'get');
$query = q_set($__p_query, "SELECT concat_ws(' ',nama, middle_name, family_name) FROM ves_inc.tb_biodata a where kd_biodata = ? ", [(string) ($kdb)]);
$resource = db_query_or_die('errro_761', $query, $__p_query ?? []);
while ($row_nama=  db_fetch($resource, PDO::FETCH_NUM))
	{
	$nama_student =   $row_nama[0];
	}
$query_prgm = q_set($__p_query_prgm, "SELECT nm_program, a.level_program FROM ves_data.vip_billing a left join ves_data.vip_mst_code_prg b on a.kd_program = b.kd_program where kd_biodata = ? order by a.no desc limit 1", [(string) ($kdb)]);
$resource_prg = db_query_or_die('errro_762', $query_prgm, $__p_query_prgm ?? []);
while ($row_prg=  db_fetch($resource_prg, PDO::FETCH_NUM))
	{
	$prg =   $row_prg[0];
	}

$query_test = q_set($__p_query_test, "SELECT L, S, R, W, total, date_format(test_date,'%d %M %Y'),prg_recom,prg_type FROM ves_data.vip_class_score_profile where kd_biodata= ? and   no = ?  order by no desc limit 1", [(string) ($kdb), (string) ($nr)]);

$resource_test = db_query_or_die('errro_763', $query_test, $__p_query_test ?? []);
if(num(db_num_rows($resource_test)) == 0)
	{
		echo "<script type=\"text/javascript\">\n";
		echo "alert('You dont have privillage to access this page');\n";
		echo "window.location = ('https://vistaeducation.com');\n";				
		echo "</script>";
	}
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
//$font = "ALEXBRUSH-REGULAR.TTF";
$font = "MonotypeCorsiva.ttf";
$size = 70;
$sizekecil = 37;
	//definisikan lebar gambar agar posisi teks selalu ditengah berapapun jumlah hurufnya
	$image_width = imagesx($image);  
	//membuat textbox agar text centered
	$text_box = imagettfbbox($size,0,$font,$nama_student);
	$text_width = num($text_box[2])-num($text_box[0]); // lower right corner - lower left corner
	$text_height = num($text_box[3])-num($text_box[1]);
	$x = num((num($image_width)/2)) - num((num($text_width)/3));
	//generate sertifikat beserta namanya
	imagettftext($image, $size, 0, 1020, 970, $black, $font, $nama_student);
	imagettftext($image, $size, 0, 1020, 1158, $black, $font, $tgl_test);
	imagettftext($image, $size, 0, 1020, 1354, $black, $font, $prg_type);
	imagettftext($image, $size, 0, 1350, 1810, $black, $font, $l);
	imagettftext($image, $size, 0, 1350, 1900, $black, $font, $r);
	imagettftext($image, $size, 0, 1350, 1990, $black, $font, $w);
	imagettftext($image, $size, 0, 1350, 2080, $black, $font, $s);
	imagettftext($image, $size, 0, 1350, 2180, $black, $font, $total);
	imagettftext($image, $sizekecil, 0, 1250, 2445, $black, $font, $prg);
	//tampilkan di browser
	header("Content-type:  image/jpeg");
	imagejpeg($image);
	imagedestroy($image);
?>
