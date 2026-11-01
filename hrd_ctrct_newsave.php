<?php
require_once __DIR__ . "/_lib/bootstrap.php"; csrf_guard_get(); auth_require_login();
ini_set("memory_limit","512M");
include __DIR__ . "/conndb.php";
$hari=date("d");
$bulan=date("m");
$tahun=date("Y");
$tgl_hari_ini =  "$tahun-$bulan-$hari";
$tglnm =  "$tahun$bulan$hari";

$blnhr = "$hari$bulan";
$nama_lengkap =	$_SESSION['nama_lengkap']; 
$hr_id = in_val('hr_id', 'post');
$catatan = in_val('catatan', 'post');

$contract_type = in_val('contract_type', 'post');
$contract_no = in_val('contract_no', 'post');
$catatan_title = in_val('catatan_title', 'post');
$start_contract = in_val('start_contract', 'post');
$end_contract = in_val('end_contract', 'post');
$target_dir = "ctrct/";
$namafile = upload_random_name('fileToUpload');;

$target_file = $target_dir.$tglnm."_".$hr_id."_".$contract_no."_".upload_random_name('fileToUpload');
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
if( $imageFileType != "pdf" and $imageFileType != "jpeg" and $imageFileType != "jpg" and $imageFileType != "png"  ) {
    echo "Sorry, only PDF files are allowed.";
    $uploadOk = 0;
}
// Check if $uploadOk is set to 0 by an error
if (num($uploadOk) == 0) {
    echo "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
} else {
    if (upload_move('fileToUpload', upload_allow('pdf', 'jpeg', 'jpg', 'png'), $target_file, 50000000)) {
	$query_simpan = q_set($__p_query_simpan, "insert into ves_data.hrd_mst_cntrct (hr_kode,contract_no, catatan_title, catatan, start_contract, end_contract, nama_file, st_contract,dt_create, pic_create , nama_asli)values (? ,? ,? ,? ,? ,? ,? ,0,? ,?  ,? )", [(string) ($hr_id), (string) ($contract_no), (string) ($catatan_title), (string) ($catatan), (string) ($start_contract), (string) ($end_contract), (string) ($target_file), (string) ($tgl_hari_ini), (string) ($nama_lengkap), upload_display_name('fileToUpload')]);
		/* echo $query_simpan (debug SQL versi lama) dihapus */ 
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