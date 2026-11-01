<?php
require_once __DIR__ . "/_lib/bootstrap.php"; auth_require_login();

include __DIR__ . "/conndb.php";
include __DIR__ . "/profiledata.php";
 //include __DIR__ . "/atas.php";


date_default_timezone_set('Asia/Jakarta'); 		

$nama_lengkap = $_SESSION['nama_lengkap'];

$nama_depan = $_SESSION['nama_depan'];
$kd_cbg = $_SESSION['kd_branch'];
$posisi = $_SESSION['posisi']; 
$kd_staff = $_SESSION['kd_staff'] ;
$branch = $_SESSION['branch'] ;
$jamskrg= date('h:i:s', time());
$hari_ini = date('Y-m-d');	
$group = in_val('group', 'get');
$category = in_val('category', 'post');
$program = in_val('program', 'post');
$level = in_val('level', 'post');
$skill = in_val('skill', 'post');
$description = in_val('description', 'post');
$keyword = in_val('keyword', 'post');

echo e($group);



	
?>