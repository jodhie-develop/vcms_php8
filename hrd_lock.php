<?php
require_once __DIR__ . "/_lib/bootstrap.php"; auth_require_login();  
if ($_SESSION['nama_lengkap'] != 'jimmy' and $_SESSION['nama_lengkap'] != 'Daniar Atika Utami')
{

	echo "<script type=\"text/javascript\">\n";
	echo "alert('Anda tidak diijinkan akses halaman ini');\n";
	echo "window.open('loginpop.php','popUpWindow','height=500,width=400,left=100,top=100,resizable=yes,scrollbars=yes,toolbar=yes,menubar=no,location=no,directories=no, status=yes');\n";				
	echo "</script>";
	die;
 }
 ?>
