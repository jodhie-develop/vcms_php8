<?php
require_once __DIR__ . "/../_lib/bootstrap.php";
include __DIR__ . "/../conndb.php";

//$kd = in_val('kd', 'get');
$kd = '2510201592584414';
/*
|--------------------------------------------------------------------------
| GET ATTACHMENT LINK
|--------------------------------------------------------------------------
*/
$q = db_query_soft("\r
SELECT\r
    b.nama_lengkap,\r
   a.Attachment_Link,DATE_FORMAT(date_cl, '%d%m%Y')\r
\r
FROM vip_ca_coshet a\r
\r
LEFT JOIN vip_student_data b\r
    ON a.kd_biodata = b.kd_biodata where a.kd_biodata = ?\r
", [(string) ($kd)]);

$d = db_fetch($q, PDO::FETCH_ASSOC);

$attachment = $d['Attachment_Link'];
$student_name = $d['nama_lengkap'];
$tgl = $d['2'];


?>
<!DOCTYPE html>
<html>
<head>

<title>Student Report - <?php echo e($student_name); ?></title>

<meta property="og:title" content="Student Progress Report - <?php echo e(num($student_name)-num($tgl)); ?>">
<meta property="og:description" content="Automated Student Report Champions Academy">
<meta property="og:image" content="https://domainkamu.com/capst.php?kd=<?php echo e(u($kd)); ?>">
<meta property="og:url" content="https://domainkamu.com/report.php?kd=<?php echo e(u($kd)); ?>">
<meta property="og:type" content="website">

<meta name="twitter:card" content="summary_large_image">

</head>

<body style="margin:0; background:#f5f5f5;">
<div style="position:relative; width:1240px; margin:auto;">

    <!-- GENERATED IMAGE -->
    <img src="capst.php?kd=<?php echo e(u($kd)); ?>" width="1240">

    <!-- TRANSPARENT BUTTON -->
    <a href="<?php echo e($attachment); ?>"
       target="_blank"
       style="
            position:absolute;
            left:930px;
            top:1420px;
            width:220px;
            height:60px;
            display:block;
       ">
    </a>

</div>
	</body>
</html>