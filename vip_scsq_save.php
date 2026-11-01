<?php
require_once __DIR__ . "/_lib/bootstrap.php"; csrf_guard_get(); auth_require_login();
ini_set("memory_limit","512M");
include __DIR__ . "/conndb.php";
$hari=date("d");
$bulan=date("m");
$tahun=date("Y");
$tgl_hari_ini =  "$tahun-$bulan-$hari";
$blnhr = "$hari$bulan";
$nama_lengkap =	$_SESSION['nama_lengkap']; 


$kd_cbg = in_val('kd_cbg', 'post');
$kdcl = in_val('kdcl', 'post');
$kode_program = in_val('kode_program', 'post');

$target_dir = "vipscsq/";
$namafile = upload_display_name('fileToUpload');;

$target_file = $target_dir.$kdcl.$kd_cbg.$blnhr.upload_random_name('fileToUpload');
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
// Check if image file is a actual image or fake image
if(isset($_POST["submit"])) {
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if($check !== false) {
        echo "File is an image - " . e($check["mime"]) . ".";
        $uploadOk = 1;
    } else {
        echo "File is not an image.";
        $uploadOk = 0;
    }
}
// Check if file already exists
if (file_exists($target_file)) {
    echo "Sorry, file already exists.";
    $uploadOk = 0;
}
// Check file size
if (num($_FILES["fileToUpload"]["size"]) > 50000000) {
    echo "Sorry, your file is too large.";
    $uploadOk = 0;
}
// Allow certain file formats
if( $imageFileType != "pdf") {
    echo "Sorry, only PDF files are allowed.";
    $uploadOk = 0;
}
// Check if $uploadOk is set to 0 by an error
if (num($uploadOk) == 0) {
    echo "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
} else {
    if (upload_move('fileToUpload', upload_allow('pdf'), $target_file, 50000000)) {
	$query_simpan = q_set($__p_query_simpan, "insert into ves_data.vip_ssq (kdcbg, class_code, kode_program, namafile,lokasifile,dt_entry,pic)values (? ,? ,? ,? ,? ,? ,? )", [(string) ($kd_cbg), (string) ($kdcl), (string) ($kode_program), (string) ($namafile), (string) ($target_file), (string) ($tgl_hari_ini), (string) ($nama_lengkap)]);
	$resource_simpan= db_query_or_die('errro_simpans', $query_simpan, $__p_query_simpan ?? []);
echo "<script type=\"text/javascript\">\n";		
echo "alert('File successfully UPloaded');\n";	
	echo "window.opener.location.reload(true);\n";		
echo "window.close(); \n";	
echo "</script>";		
	} else {
        echo "Sorry, there was an error uploading your file.";
    }
}
	
//=====================
?>