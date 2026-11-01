<?php
require_once __DIR__ . "/_lib/bootstrap.php"; csrf_guard_get(); auth_require_login();
ini_set("memory_limit","256M");
include __DIR__ . "/conndb.php";
$hari=date("d");
$bulan=date("m");
$tahun=date("Y");
$tgl_hari_ini =  "$tahun-$bulan-$hari";
$nama_lengkap =	$_SESSION['nama_lengkap']; 
$cabang = in_val('cabang', 'post') ;
if ($kd_cbg == 'East Sby'){$kdc = 1;}
if ($kd_cbg == 'West Sby'){$kdc = 2;}
if ($kd_cbg == 'Denpasar'){$kdc = 3;}
if ($kd_cbg == 'South Jkt'){$kdc = 4;}
if ($kd_cbg == 'North Jkt'){$kdc = 5;}
if ($kd_cbg == 'West Jkt'){$kdc = 6;}
if ($kd_cbg == 'Bandung'){$kdc = 7;}
$jns_report =	in_val('jns_report', 'post');
if ($jns_report == 'Sales'){$jnr = "sl";}
if ($jns_report == 'Marketing'){$jnr = "mk";}
if ($jns_report == 'Academic'){$jnr = "ac";}
$week = 	in_val('week', 'post'); 
$target_dir = "vipfile/";
$target_file = $target_dir.$kdc.$jnr.$week.upload_random_name('fileToUpload');
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
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
&& $imageFileType != "gif" && $imageFileType != "pdf" && $imageFileType != "xls" && $imageFileType != "xlsx"  && $imageFileType != "mp4") {
    echo "Sorry, only JPG, JPEG, PNG & GIF, PDF files are allowed.";
    $uploadOk = 0;
}
// Check if $uploadOk is set to 0 by an error
if (num($uploadOk) == 0) {
    echo "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
} else {
    if (upload_move('fileToUpload', upload_allow('jpg', 'png', 'jpeg', 'gif', 'pdf', 'xls', 'xlsx', 'mp4'), $target_file, 50000000)) {
		
	$query_simpan = q_set($__p_query_simpan, "insert into ves_data.vip_data (kd_branch, jns_report, week, vip_file,dt_entry,pic, nama_asli)values (? ,? ,? ,? ,? ,?  ,? )", [(string) ($cabang), (string) ($jns_report), (string) ($week), (string) ($target_file), (string) ($tgl_hari_ini), (string) ($nama_lengkap), upload_display_name('fileToUpload')]);
	$resource_simpan= db_query_or_die('errro_simpan', $query_simpan, $__p_query_simpan ?? []);
echo "<script type=\"text/javascript\">\n";
echo "window.opener.location.reload(true);\n";
echo "window.close(); \n";	
echo "</script>";		
	} else {
        echo "Sorry, there was an error uploading your file.";
    }
}
	
//=====================
?>