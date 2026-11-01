<?php
require_once __DIR__ . "/../_lib/bootstrap.php";
include __DIR__ . "/../conndb.php";
$gambar = "ecertbimwsign.jpg";
//$tanda = "tanda.jpg";

$query_file = q_set($__p_query_file, "SELECT m.nama_file FROM mst_signature m");

$resource_file = db_query_soft($query_file, $__p_query_file ?? []);
if(num(db_num_rows($resource_file)) > 0){
	
	while ($row_file  =  db_fetch($resource_file, PDO::FETCH_NUM))
		{$namafile = $row_file[0]; 
		}
}
$tanda = $namafile;


$kdb = in_val('kdb', 'get');
$kc = in_val('kc', 'get');

$query = q_set($__p_query, "SELECT v.nama_student, v.no_registrasi FROM vip_kd_certificate v where kd_biodata = ? and kode_kelas = ? ", [(string) ($kdb), (string) ($kc)]);

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
	$nama_student =   $row_nama[0];
	$no_registrasi =   $row_nama[1];
	
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
$imgtd = imagecreatefromjpeg($tanda);
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