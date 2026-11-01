<?php
require_once __DIR__ . "/../_lib/bootstrap.php";
include __DIR__ . "/../conndb.php";
	$kdb = in_val('kdb', 'get');
	$kdc = in_val('kdc', 'get');
$gambar = "./ve_sertifikat.jpg";


		$nama_student = "Rustian";
		$start_date = "24 July 2021";
		$end_date = "24 July 2021";
		$nm_program = "TEST TRIAL ONLINE";	
	$image = imagecreatefromjpeg($gambar);
	$white = imageColorAllocate($image, 255, 255, 255);
	$black = imageColorAllocate($image, 0, 0, 0);
	$font = "./MonotypeCorsiva.ttf";
	$size = 80;
	$size_tgl =50;
	//definisikan lebar gambar agar posisi teks selalu ditengah berapapun jumlah hurufnya
	$image_width = imagesx($image);  
	//membuat textbox agar text centered
	$text_box = imagettfbbox($size,0,$font,$nama_student);
	$text_width = num($text_box[2])-num($text_box[0]); // lower right corner - lower left corner
	$text_height = num($text_box[3])-num($text_box[1]);
	$x = num((num($image_width)/2)) - num((num($text_width)/2));
	//generate sertifikat beserta namanya
	imagettftext($image, $size, 0, 650, 700, $black, $font, $nama_student);
	imagettftext($image, $size, 0, 650, 1100, $black, $font, $nm_program);
	//imagettftext($image, $size, 0, 650, 1100, $black, $font, $str_program);
	imagettftext($image, $size, 0, 840, 1530, $black, $font, $start_date);
	imagettftext($image, $size, 0, 1840, 1530, $black, $font, $end_date);
	imagettftext($image, $size_tgl, 0, 940, 1930, $black, $font, $cetak_date);

	//tampilkan di browser
	header("Content-type:  image/jpeg");
	imagejpeg($image);
	imagedestroy($image);
?>
