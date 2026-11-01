<?php
require_once __DIR__ . "/_lib/bootstrap.php";
include __DIR__ . "/phpqrcode/qrlib.php";
$text = in_val('text', 'get');
QRcode::png($text);
?>