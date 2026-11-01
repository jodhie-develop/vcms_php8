<?php
require_once __DIR__ . "/../_lib/bootstrap.php"; auth_require_login(); 
include __DIR__ . "/conndb.php";
include __DIR__ . "/profiledata.php";
 include __DIR__ . "/atas.php";
 session_destroy();
echo "<script type=\"text/javascript\">\n";
echo "alert('End Session');\n";
echo "window.location = ('../login.php');\n";				
echo "</script>";	
?>