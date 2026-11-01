<?php
require_once __DIR__ . "/../_lib/bootstrap.php";
// Laporan siswa per kd_biodata: hanya staf yang login (dulu publik tetapi terkunci ke satu siswa).
auth_require_login();
ob_start();
include __DIR__ . "/../conndb.php";

require_once VCMS_ROOT . '/_lib/vendor.php';   // dompdf/dompdf 3.x (pengganti ecert/dompdf 0.6 lama)

/*
|--------------------------------------------------------------------------
| GET PARAMETER
|--------------------------------------------------------------------------
*/
$kd_biodata = in_val('kd', 'get');

if($kd_biodata === '' || strlen($kd_biodata) > 30)
{
    die("Data not found");
}

/*
|--------------------------------------------------------------------------
| QUERY DATA
|--------------------------------------------------------------------------
*/
$query_progress = q_set($__p_query_progress, "
SELECT
    d.nm_program,
    d.level_program,
    b.nama_lengkap,
    a.Meeting_Type,
    a.attendance,
    a.Primary_Strength,
    a.participation,
    a.Progress_Today,
    a.Primary_Support_Area,
    a.Parent_Update_Note,
    a.Written_Teachers_Comment,
    a.Attachment_Link,
    a.date_cl

FROM vip_ca_coshet a

LEFT JOIN vip_student_data b
    ON a.kd_biodata = b.kd_biodata

LEFT JOIN vip_billing c
    ON a.kd_biodata = c.kd_biodata
    AND a.kdcl = c.kd_class

LEFT JOIN vip_mst_code_prg d
    ON c.kd_program = d.kd_program
    AND c.level_program = d.level_program

WHERE a.kd_biodata = ?

ORDER BY a.id DESC
LIMIT 1
", [(string) $kd_biodata]);

$resource = db_query_soft($query_progress, $__p_query_progress ?? []);

if(num(db_num_rows($resource)) == 0)
{
    die("Data not found");
}

$data = db_fetch($resource, PDO::FETCH_ASSOC);

/*
|--------------------------------------------------------------------------
| VARIABLE
|--------------------------------------------------------------------------
*/
/** Teks dari DB (bisa HTML editor TinyMCE) -> HTML aman; baris/paragraf/list tetap terpisah. */
function ca_text($value): string
{
    $t = preg_replace('#<br\s*/?>|</(p|div|li|h[1-6]|tr)>#i', "\n", (string) $value);
    $t = preg_replace('#<li[^>]*>#i', '• ', $t);
    $t = strip_tags(html_entity_decode($t, ENT_QUOTES | ENT_HTML5, 'UTF-8'));
    $t = preg_replace("/[ \t\x{00A0}]+/u", ' ', $t) ?? $t;
    $t = trim(preg_replace("/\s*\n\s*/", "\n", $t) ?? $t);
    return $t === '' ? '-' : nl2br(e($t), false);
}

$class_group          = trim($data['nm_program'].' - '.$data['level_program'], ' -');
$class_group          = $class_group === '' ? '-' : e($class_group);
$student_name         = ca_text($data['nama_lengkap']);
$meeting_type         = ca_text($data['Meeting_Type']);
$attendance           = match (strtoupper(trim((string) $data['attendance']))) {
    '1', 'Y' => 'Present',
    '0', 'N' => 'Absent',
    default  => ca_text($data['attendance']),
};
$meeting_date         = $data['date_cl'] ? date('d M Y', strtotime($data['date_cl'])) : '';

$participation        = ca_text($data['participation']);
$progress_today       = ca_text($data['Progress_Today']);

$primary_strength     = ca_text($data['Primary_Strength']);
$primary_support      = ca_text($data['Primary_Support_Area']);

$parent_update        = ca_text($data['Parent_Update_Note']);
$teacher_comment      = ca_text($data['Written_Teachers_Comment']);

// Hanya link http(s) yang dijadikan tombol (bukan javascript:/file: dll.)
$attachment           = trim((string) $data['Attachment_Link']);
$evidence = preg_match('#^https?://#i', $attachment)
    ? '<a href="'.e($attachment).'" class="evidence-btn">View Evidence</a>'
    : '<span class="muted">No evidence attached.</span>';

/*
|--------------------------------------------------------------------------
| LOGO (dipotong dari desain ecert/ca_prograss.jpg)
|--------------------------------------------------------------------------
*/
$logo = "ca_logo.png";

/*
|--------------------------------------------------------------------------
| HTML TEMPLATE (mengikuti desain ecert/ca_prograss.jpg)
|--------------------------------------------------------------------------
*/
$html = '
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">

<style>

@page{
    margin:34px 40px 30px 40px;
}

body{
    font-family: DejaVu Sans, sans-serif;
    color:#2b2b2b;
    margin:0;
    font-size:11px;
}

.serif{
    font-family: DejaVu Serif, serif;
}

.header{
    width:100%;
    border-collapse:collapse;
    border-bottom:2px solid #e3d3ad;
    margin-bottom:16px;
}

.header td{
    vertical-align:top;
    padding:0 0 14px 0;
}

.logo{
    width:78px;
}

.brand{
    font-family: DejaVu Serif, serif;
    color:#c9a45c;
    font-size:12px;
    border-bottom:1px solid #e3d3ad;
    padding-bottom:3px;
    margin:4px 0 8px 0;
}

.title{
    font-family: DejaVu Serif, serif;
    font-size:24px;
    color:#a5162b;
    font-weight:bold;
}

.subtitle{
    font-family: DejaVu Serif, serif;
    font-style:italic;
    font-size:13px;
    color:#555;
    margin-top:4px;
}

.section-title{
    font-family: DejaVu Serif, serif;
    color:#a5162b;
    font-size:14px;
    font-weight:bold;
    margin:14px 0 8px 0;
}

.box{
    border:1px solid #ead8d8;
    border-radius:6px;
    padding:10px 12px;
    page-break-inside:avoid;
}

.info-table{
    width:100%;
    border-collapse:collapse;
}

.info-table td{
    width:20%;
    padding:6px 8px;
    text-align:center;
    vertical-align:top;
    border-right:1px solid #eadfcb;
}

.info-table td.last{
    border-right:none;
}

.label{
    font-family: DejaVu Serif, serif;
    color:#333;
    font-size:11px;
    padding-bottom:6px;
    margin-bottom:6px;
    border-bottom:1px solid #eee;
}

.value{
    font-size:11px;
    font-weight:bold;
}

.rows{
    width:100%;
    border-collapse:collapse;
}

.rows td{
    padding:9px 8px;
    vertical-align:top;
    border-bottom:1px solid #f0e6e6;
}

.rows td.row-label{
    font-family: DejaVu Serif, serif;
    width:28%;
    border-right:1px solid #e6d6d6;
}

.highlight{
    width:100%;
    border-collapse:collapse;
    background:#faf4ea;
    margin-top:8px;
}

.highlight td{
    width:50%;
    padding:12px 14px;
    vertical-align:top;
}

.highlight td.first{
    border-right:1px solid #e3d3ad;
}

.highlight-label{
    font-family: DejaVu Serif, serif;
    font-weight:bold;
    color:#a5162b;
    margin-bottom:6px;
}

.pill{
    background:#ffffff;
    border:1px solid #ead8d8;
    border-radius:12px;
    padding:6px 12px;
}

.text{
    line-height:1.6;
}

.muted{
    color:#999;
}

.evidence-btn{
    display:inline-block;
    color:#a5162b;
    border:1px solid #d9c3a0;
    border-radius:4px;
    padding:6px 16px;
    text-decoration:none;
}

.footer{
    text-align:center;
    font-family: DejaVu Serif, serif;
    font-size:10px;
    color:#777;
    margin-top:22px;
    border-top:2px solid #e3d3ad;
    padding-top:10px;
}

</style>
</head>

<body>

<table class="header">
    <tr>
        <td style="width:96px;"><img src="'.e($logo).'" class="logo"></td>
        <td>
            <div class="brand">Champions Academy</div>
            <div class="title">AUTOMATED STUDENT REPORT</div>
            <div class="subtitle">Student Progress Summary'.($meeting_date !== '' ? ' &middot; '.e($meeting_date) : '').'</div>
        </td>
    </tr>
</table>

<div class="section-title">STUDENT INFORMATION</div>

<div class="box">
    <table class="info-table">
        <tr>
            <td>
                <div class="label">Class / Group</div>
                <div class="value">'.$class_group.'</div>
            </td>
            <td>
                <div class="label">Student Name</div>
                <div class="value">'.$student_name.'</div>
            </td>
            <td>
                <div class="label">Meeting Type</div>
                <div class="value">'.$meeting_type.'</div>
            </td>
            <td>
                <div class="label">Attendance</div>
                <div class="value">'.$attendance.'</div>
            </td>
            <td class="last">
                <div class="label">Topic Covered</div>
                <div class="value">-</div>
            </td>
        </tr>
    </table>
</div>

<div class="section-title">MEETING SUMMARY</div>

<div class="box">
    <table class="rows">
        <tr>
            <td class="row-label">Main Activities Done</td>
            <td class="text">-</td>
        </tr>
        <tr>
            <td class="row-label">Participation</td>
            <td class="text">'.$participation.'</td>
        </tr>
        <tr>
            <td class="row-label">Progress Today</td>
            <td class="text">'.$progress_today.'</td>
        </tr>
    </table>

    <table class="highlight">
        <tr>
            <td class="first">
                <div class="highlight-label">Primary Strength</div>
                <div class="pill">'.$primary_strength.'</div>
            </td>
            <td>
                <div class="highlight-label">Primary Support Area</div>
                <div class="pill">'.$primary_support.'</div>
            </td>
        </tr>
    </table>
</div>

<div class="section-title">PARENT UPDATE SUMMARY</div>

<div class="box">
    <div class="text">'.$parent_update.'</div>
</div>

<div class="section-title">TEACHER COMMENT</div>

<div class="box">
    <div class="text">'.$teacher_comment.'</div>
</div>

<div class="section-title">SUPPORTING EVIDENCE</div>

<div class="box">
    '.$evidence.'
</div>

<div class="footer">
    Champions Academy &nbsp;|&nbsp; Building Strong Learners, Achieving Greater Futures.
</div>

</body>
</html>
';
/*
|--------------------------------------------------------------------------
| GENERATE PDF
|--------------------------------------------------------------------------
*/

if (isset($_GET['vuehtml'])) {
    // Pratinjau HTML sumber PDF (seperti ?vuehtml=1 di halaman html2pdf)
    while (ob_get_level() > 0) {
        ob_end_clean();
    }
    echo $html;
    exit;
}

vendor_require(\Dompdf\Dompdf::class, 'PDF', 'dompdf');

// Seperti dompdf 0.6: gambar relatif (logo) dibaca dari folder ecert/. Gambar/CSS dari URL luar
// dan <script>/PHP di HTML tidak diproses.
$options = new \Dompdf\Options();
$options->setChroot(__DIR__);
$options->setIsRemoteEnabled(false);
$options->setIsPhpEnabled(false);
$options->setIsJavascriptEnabled(false);

try {
    $dompdf = new \Dompdf\Dompdf($options);
    $dompdf->setBasePath(__DIR__ . '/');

    $dompdf->loadHtml($html, 'UTF-8');

    $dompdf->setPaper('A4', 'portrait');

    $dompdf->render();

    $dompdf->stream(
        "student_report_" . preg_replace('/[^0-9A-Za-z_-]/', '', $kd_biodata) . ".pdf",
        array("Attachment" => false)
    );
} catch (\Throwable $e) {
    vendor_fail($e, 'V-CMS PDF gagal', 'PDF gagal dibuat. Silakan coba lagi atau hubungi administrator.');
}

exit;
?>
