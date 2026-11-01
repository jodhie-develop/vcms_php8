<?php
require_once __DIR__ . "/../_lib/bootstrap.php";
include __DIR__ . "/../conndb.php";


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

$query = q_set($__p_query, "SELECT v.nama_student, v.no_registrasi, date_format(start_class,'%d %M %Y'), date_format(end_class,'%d %M %Y'),date_format(tgl_cetak,'%d %M') ,date_format(tgl_cetak,'%Y'), namafile,date_format(tgl_cetak,'%M'),remark FROM vip_kd_certificate v where kd_biodata = ? and kode_kelas = ? ", [(string) ($kdb), (string) ($kc)]);

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
	$jml_char = strlen($nama_student);
	$no_registrasi =   $row_nama[1];
	$start_class =    $row_nama[2];
	$end_class =    $row_nama[3];
	$nmbln = $row_nama[7];
	$remark_program = $row_nama[8];
	if ($nmbln =='September')
		{
		$tgl_cetak =    "     Surabaya, ".$row_nama[4];

		}
	else
		{
		$tgl_cetak =    "             Surabaya, ".$row_nama[4];
		}
	$thn_cetak =    $row_nama[5];
	$app =    $row_nama[6];	
	if ($app !='')
		{
		$gambar = "vipcert030723ok.jpg";
		}
	else
		{
		$gambar = "vipcert030723draft.jpg";
		}
	
	}

$query_program= q_set($__p_query_program, "SELECT b.nm_program, a.level_program, b.type_program FROM ves_data.vip_billing a left join ves_data.vip_mst_code_prg b on a.kd_program = b.kd_program and a.level_program = b.level_program where kd_biodata = ? and kd_class = ? ", [(string) ($kdb), (string) ($kc)]);
$resource_program = db_query_or_die('errro_716', $query_program, $__p_query_program ?? []);
while ($row_program=  db_fetch($resource_program, PDO::FETCH_NUM))
	{
	$nm_program = $row_program[0];
	$lvl_program = $row_program[1];
	$type_program = $row_program[2];
	if($type_program =='PRI')
		{
		$query_cek_private= q_set($__p_query_cek_private, "SELECT b.nm_program, a.level_program, b.type_program FROM ves_data.vip_billing a left join ves_data.vip_mst_code_prg b on a.kd_program = b.kd_program and a.level_program = b.level_program where kd_class = ? group by kd_biodata", [(string) ($kc)]);
		$resource_cek_private = db_query_or_die('errro_716', $query_cek_private, $__p_query_cek_private ?? []);
		$jml_pri = db_num_rows($resource_cek_private);
		if (num($jml_pri) ==1){$type_program = 'Private';}
		elseif (num($jml_pri) ==2 or num($jml_pri) ==3 or num($jml_pri) == 4  ){$type_program = 'Semi Private';}
		
		}
	elseif($type_program =='REG'){$type_program = 'Regular';}	
	if($lvl_program =='In Focus 1') {$lvl_program = 'In Focus';}
	elseif($lvl_program =='Savvy 1') {$lvl_program = 'Savvy';}
	elseif($lvl_program =='Access 1') {$lvl_program = 'Access';}	
	if($nm_program =='AE') {$nm_program = 'Academic English';}
	elseif($nm_program =='NGTOEFL') {$nm_program = 'TOEFL IBT';}
if ($remark_program!='')
	{	$program_lengkap = $remark_program;}
	else
	{	$program_lengkap = $type_program." Preparation Course for " .$nm_program." Level ".$lvl_program;}

	}
if($prgg != ''){$prg = $prgg;}
if($prg_type ==''){$prg_type = $prgg;}
$image = imagecreatefromjpeg($gambar);
//$imgtd = imagecreatefromjpeg($tanda);
//imagecopymerge($image, $imgtd, 1410, 980, 0, 0, 170, 170, 35);
$white = imageColorAllocate($image, 255, 255, 255);
$black = imageColorAllocate($image, 0, 0, 0);
$font = "MonotypeCorsiva.ttf";
$fontnama = "greatvibesregular.ttf";
$fontnomor = "Montserrat-Medium.ttf";
$ivan = "Ivan Liusaputra";

if (num($jml_char) >= 35)
	{
$sizenama = 50;
	
	}
else
	{
	
$sizenama = 76;
	}
//echo $jml_char;echo $sizenama;die;
$sizeprogram = 25;
$sizedurasi = 25;
$sizecetak = 18;
$sizeivan = 28;

$sizenomor = 15;
$sizekecil = 20;
	//definisikan lebar gambar agar posisi teks selalu ditengah berapapun jumlah hurufnya
	$image_width = imagesx($image); 
	//membuat textbox agar text centered
	$text_boxnama = imagettfbbox($sizenama,0,$fontnama,$nama_student);
	$text_widthnama = num($text_boxnama[2])-num($text_boxnama[0]);
	$text_box = imagettfbbox($size,0,$fontnama,$nama_student);
	$text_width = num($text_box[2])-num($text_box[0]); // lower right corner - lower left corner
	$text_height = num($text_box[3])-num($text_box[1]);
	$x = num((num($image_width)/2)) - num((num($text_widthnama)/2));
	//$x = ($image_width/2) - ($text_width/3);
	//generate sertifikat beserta namanya
	imagettftext($image, $sizenama, 0, $x, 514, $black, $fontnama, $nama_student);
	imagettftext($image, $sizeprogram, 0, 301, 730, $black, $fontnomor, $program_lengkap);
	imagettftext($image, $sizedurasi, 0, 848, 832, $black, $fontnomor, $start_class);
	imagettftext($image, $sizedurasi, 0, 1232, 832, $black, $fontnomor, $end_class);
	imagettftext($image, $sizecetak, 0, 280, 1170, $black, $fontnomor, $tgl_cetak);
	imagettftext($image, $sizecetak, 0, 655, 1170, $black, $fontnomor, $thn_cetak);
	imagettftext($image, $sizeivan, 0, 1351, 1170, $black, $fontnomor, $ivan);
	imagettftext($image, $sizenomor, 0, 1700, 1395, $white, $fontnomor, $no_registrasi);
//echo $fontnama;echo $sizenama;die;
	//tampilkan di browser
	header("Content-type:  image/jpeg");
	imagejpeg($image);
	imagedestroy($image);
?>
<head>
<title><?php echo e($nama_student) ?> - VIP English E Certificate </title>
</head>