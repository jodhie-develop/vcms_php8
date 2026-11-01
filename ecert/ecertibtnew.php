<?php
require_once __DIR__ . "/../_lib/bootstrap.php";
include __DIR__ . "/../conndb.php";
$kd = in_val('kd', 'get');
//$gambar = "ecertieltibt.jpg";
$gambar = "ecertieltibtnewfrmt.jpg";
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

$query_test = q_set($__p_query_test, "SELECT L, S, R, W, total, date_format(test_date,'%d %M %Y'),prg_recom,prg_type,target_score,prg_recom_2,prg_recom_3,prg_recom_4,prg_recom_5 FROM ves_data.vip_class_score_profile where kd_biodata= ? and   no = ?  order by no desc limit 1", [(string) ($kdb), (string) ($nr)]);

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
	$prg_recom =   $row_test[6];
	$is_digit_1 = ctype_digit((string)$prg_recom);

		if(num($is_digit_1) == 1)
		{
	$query_recom = q_set($__p_query_recom, "SELECT v.prg_recomm, v.jam FROM ves_data.vip_recomm_list v  where id = ? ", [(string) ($prg_recom)]);
	$resource_recom = db_query_or_die('errro_761', $query_recom, $__p_query_recom ?? []);
	while ($row_recom=  db_fetch($resource_recom, PDO::FETCH_NUM))
		{
		$rec_1 =   "1. ".$row_recom[0];
		$rec_jam_1 = $row_recom[1];
		}
		}
	$target_score =   $row_test[8];	
	$prg_recom_2 =   $row_test[9];
		if($prg_recom_2 != '')
		{
	$query_recom = q_set($__p_query_recom, "SELECT v.prg_recomm, v.jam FROM ves_data.vip_recomm_list v  where id = ? ", [(string) ($prg_recom_2)]);
	$resource_recom = db_query_or_die('errro_762', $query_recom, $__p_query_recom ?? []);
	while ($row_recom=  db_fetch($resource_recom, PDO::FETCH_NUM))
		{
		$rec_2 =   "2. ".$row_recom[0];
		$rec_jam_2 = $row_recom[1];
		}	
		}
	$prg_recom_3 =   $row_test[10];
	if($prg_recom_3 !='')
		{
		$query_recom = q_set($__p_query_recom, "SELECT v.prg_recomm, v.jam FROM ves_data.vip_recomm_list v  where id = ? ", [(string) ($prg_recom_3)]);
	$resource_recom = db_query_or_die('errro_763', $query_recom, $__p_query_recom ?? []);
	if(num(db_num_rows($resource_recom)) > 0)
	{
	while ($row_recom=  db_fetch($resource_recom, PDO::FETCH_NUM))
		{
		$rec_3 =   "3. ".$row_recom[0];
		$rec_jam_3 = $row_recom[1];
		}	
	}	
		}
	$prg_recom_4 =   $row_test[11];	
	if($prg_recom_4 !='')
		{

	$query_recom = q_set($__p_query_recom, "SELECT v.prg_recomm, v.jam FROM ves_data.vip_recomm_list v  where id = ? ", [(string) ($prg_recom_4)]);
	$resource_recom = db_query_or_die('errro_767', $query_recom, $__p_query_recom ?? []);
		if(num(db_num_rows($resource_recom)) > 0)
	{
	while ($row_recom=  db_fetch($resource_recom, PDO::FETCH_NUM))
		{
		$rec_4 =   "4. ".$row_recom[0];
		$rec_jam_4 = $row_recom[1];
		}	
		}
	}
		$prg_recom_5 =   $row_test[12];
	if($prg_recom_5 !='')
		{	

	$query_recom = q_set($__p_query_recom, "SELECT v.prg_recomm, v.jam FROM ves_data.vip_recomm_list v  where id = ? ", [(string) ($prg_recom_5)]);
	$resource_recom = db_query_or_die('errro_764', $query_recom, $__p_query_recom ?? []);
		if(num(db_num_rows($resource_recom)) > 0)
	{
	while ($row_recom=  db_fetch($resource_recom, PDO::FETCH_NUM))
		{
		$rec_5 =   "5. ".$row_recom[0];
		$rec_jam_5 = $row_recom[1];
		}	
		}
	}
	$total_jam_recom = num($rec_jam_1) + num($rec_jam_2) + num($rec_jam_3) + num($rec_jam_4) + num($rec_jam_5) ;
	if ($target_score =='' or num($target_score) == 0)
		{ 
		$query_test_target_score = q_set($__p_query_test_target_score, "SELECT target_score FROM ves_data.vip_class_score_profile where kd_biodata= ?  and (target_score <> '' or target_score <> 0) order by no desc limit 1", [(string) ($kdb)]);
		$resource_target_score = db_query_or_die('errro_76', $query_test_target_score, $__p_query_test_target_score ?? []);
		while ($row_target_score=  db_fetch($resource_target_score, PDO::FETCH_NUM))
		{
		$target_score =   $row_target_score[0];
		}
		
		}
	
	
	}
if($prgg != ''){$prg = $prgg;}
if($prg_type ==''){$prg_type = $prgg;}
$image = imagecreatefromjpeg($gambar);
$white = imageColorAllocate($image, 255, 255, 255);
$black = imageColorAllocate($image, 0, 0, 0);
//$font = "ALEXBRUSH-REGULAR.TTF";
$font = "MonotypeCorsiva.ttf";
$fontlagi = "taile.ttf";
$size = 70;
$sizekecil = 37;
$sizefontlagi = 33;
$sizefontsnk = 20;
$snk = "* This Placement Test Report is valid for three months from the test date. Over the deadline, the test taker should take another Placement Test
   for more relevant results. ";
$ket_1 = "To achieve a target score of $target_score  in  $prg_type is recommended to take the following programs :";
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
	imagettftext($image, $sizefontlagi, 0, 428, 2330, $black, $fontlagi, $ket_1);
	imagettftext($image, $sizefontlagi, 0, 428, 2390, $black, $fontlagi, "$rec_1");
	imagettftext($image, $sizefontlagi, 0, 428, 2460, $black, $fontlagi, "$rec_2");
	imagettftext($image, $sizefontlagi, 0, 428, 2530, $black, $fontlagi, "$rec_3");
	imagettftext($image, $sizefontlagi, 0, 428, 2600, $black, $fontlagi, "$rec_4");
	imagettftext($image, $sizefontlagi, 0, 428, 2670, $black, $fontlagi, "$rec_5");
	imagettftext($image, $sizefontlagi, 0, 428, 2760, $black, $fontlagi, "Total : .$total_jam_recom  Hours");
	imagettftext($image, $sizefontsnk, 0, 428, 3360, $black, $fontlagi, $snk);
	//tampilkan di browser
	header("Content-type:  image/jpeg");
	imagejpeg($image);
	imagedestroy($image);
?>
