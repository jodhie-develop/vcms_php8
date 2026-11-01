<?php
require_once __DIR__ . "/../_lib/bootstrap.php";
include __DIR__ . "/../conndb.php";
$kd = in_val('kd', 'get');
$gambar = "ecertGE.jpg";
//$gambar = "ecertSignVIP.jpg";


$kdb = in_val('kdb', 'get');
$nr = in_val('nr', 'get');
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

$query_test = q_set($__p_query_test, "SELECT L, S, R, W, total, date_format(test_date,'%d %M %Y'),prg_recom,prg_type,other,prg_recom,prg_recom_2,prg_recom_3,prg_recom_4,prg_recom_5  FROM ves_data.vip_class_score_profile where kd_biodata= ? and no = ?  order by no desc limit 1", [(string) ($kdb), (string) ($nr)]);
$resource_test = db_query_or_die('errro_76', $query_test, $__p_query_test ?? []);
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
	$s =   $row_test[8];
	$sp =   $row_test[1];
	$w =   $row_test[3];
	$total =   $row_test[4];
	$prgg =   $row_test[6];
	$prg_type =   $row_test[7];	
	
	
	
	}
if($prgg != ''){$prg = $prgg;}
if($prg_type ==''){$prg_type = $prgg;}
if($prg_type == 'VIP Signature Test')
{
	$gambar = "ecertSignVIP.jpg";
$image = imagecreatefromjpeg($gambar);
$white = imageColorAllocate($image, 255, 255, 255);
$black = imageColorAllocate($image, 0, 0, 0);
//$font = "ALEXBRUSH-REGULAR.TTF";
$font = "MonotypeCorsiva.ttf";
$size = 35;
$sizenamastudent = 35;
	
$sizedata = 70;
$sizekecil = 20;
	//definisikan lebar gambar agar posisi teks selalu ditengah berapapun jumlah hurufnya
	$image_width = imagesx($image);  
	//membuat textbox agar text centered
	$text_box = imagettfbbox($size,0,$font,$nama_student);
	$text_width = num($text_box[2])-num($text_box[0]); // lower right corner - lower left corner
	$text_height = num($text_box[3])-num($text_box[1]);
	$x = num((num($image_width)/2)) - num((num($text_width)/3));
	//generate sertifikat beserta namanya
	imagettftext($image, $sizenamastudent, 0, 415, 420, $black, $font, $nama_student);
	imagettftext($image, $sizenamastudent, 0, 415, 505, $black, $font, $tgl_test);
	imagettftext($image, $sizenamastudent, 0, 415, 590, $black, $font, $prg_type);
	imagettftext($image, $size, 0, 685, 800, $black, $font, $l);
	imagettftext($image, $size, 0, 685, 860, $black, $font, $sp);
	imagettftext($image, $size, 0, 665, 910, $black, $font, $total);
}
else
{
$image = imagecreatefromjpeg($gambar);
$white = imageColorAllocate($image, 255, 255, 255);
$black = imageColorAllocate($image, 0, 0, 0);
//$font = "ALEXBRUSH-REGULAR.TTF";
$font = "MonotypeCorsiva.ttf";
$size = 55;
$sizedata = 70;
$sizekecil = 20;
	//definisikan lebar gambar agar posisi teks selalu ditengah berapapun jumlah hurufnya
	$image_width = imagesx($image);  
	//membuat textbox agar text centered
	$text_box = imagettfbbox($size,0,$font,$nama_student);
	$text_width = num($text_box[2])-num($text_box[0]); // lower right corner - lower left corner
	$text_height = num($text_box[3])-num($text_box[1]);
	$x = num((num($image_width)/2)) - num((num($text_width)/3));
	//generate sertifikat beserta namanya
	imagettftext($image, $sizedata, 0, 1020, 970, $black, $font, $nama_student);
	imagettftext($image, $sizedata, 0, 1020, 1150, $black, $font, $tgl_test);
	imagettftext($image, $sizedata, 0, 1020, 1340, $black, $font, $prg_type);
	imagettftext($image, $size, 0, 1190, 1810, $black, $font, $s);
	imagettftext($image, $size, 0, 1190, 1910, $black, $font, $sp);

	imagettftext($image, $size, 0, 1190, 1990, $black, $font, $total);
}	
	//tampilkan di browser
	header("Content-type:  image/jpeg");
	imagejpeg($image);
	imagedestroy($image);
?><head>
<title><?php echo e($nama_student) ?> - PREDICTION </title>
</head>
