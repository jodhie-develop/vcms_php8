<?php
require_once __DIR__ . "/../_lib/bootstrap.php";
ob_start();
include __DIR__ . "/../conndb.php";

$gambar = "ca_prograss.jpg";

/*
|--------------------------------------------------------------------------
| GET PARAMETER
|--------------------------------------------------------------------------
*/
$kd_biodata = in_val('kd', 'get');

/*
|--------------------------------------------------------------------------
| QUERY DATA
|--------------------------------------------------------------------------
*/
$query_progress = q_set($__p_query_progress, "\r
SELECT\r
    d.nm_program,\r
    d.level_program,\r
    b.nama_lengkap,\r
    a.Meeting_Type,\r
    a.attendance,\r
    a.Primary_Strength,\r
    a.participation,\r
    a.Progress_Today,\r
    a.Primary_Support_Area,\r
    a.Parent_Update_Note,\r
    a.Written_Teachers_Comment,\r
    a.Attachment_Link\r
\r
FROM vip_ca_coshet a\r
\r
LEFT JOIN vip_student_data b\r
    ON a.kd_biodata = b.kd_biodata\r
\r
LEFT JOIN vip_billing c\r
    ON a.kd_biodata = c.kd_biodata\r
    AND a.kdcl = c.kd_class\r
\r
LEFT JOIN vip_mst_code_prg d\r
    ON c.kd_program = d.kd_program\r
    AND c.level_program = d.level_program\r
\r
WHERE a.kd_biodata = '2510201592584414'\r
\r
ORDER BY a.id DESC\r
LIMIT 1\r
");

$resource = db_query_soft($query_progress, $__p_query_progress ?? []);

if(num(db_num_rows($resource)) == 0)
{
    echo "
    <script>
        alert('Data not found');
        window.location='https://vistaeducation.com';
    </script>";
    exit;
}

$data = db_fetch($resource, PDO::FETCH_ASSOC);

/*
|--------------------------------------------------------------------------
| VARIABLE DATA
|--------------------------------------------------------------------------
*/
//$class_group            = $data['nm_program'].' - '.$data['level_program'];
$class_group            = $data['level_program'];
$student_name           = $data['nama_lengkap'];
$meeting_type           = $data['Meeting_Type'];
$attendance             = $data['attendance'];

$participation          = $data['participation'];
$progress_today         = $data['Progress_Today'];

$primary_strength       = $data['Primary_Strength'];
$primary_support_area   = $data['Primary_Support_Area'];

$parent_update          = $data['Parent_Update_Note'];
$teacher_comment        = $data['Written_Teachers_Comment'];

$attachment             = $data['Attachment_Link'];


/*
|--------------------------------------------------------------------------
| CLEAN HTML
|--------------------------------------------------------------------------
*/
$progress_today     = trim(strip_tags(html_entity_decode($progress_today)));
$participation      = trim(strip_tags(html_entity_decode($participation)));
$parent_update      = trim(strip_tags(html_entity_decode($parent_update)));
$teacher_comment    = trim(strip_tags(html_entity_decode($teacher_comment)));

$primary_strength   = trim(strip_tags(html_entity_decode($primary_strength)));
$primary_support_area = trim(strip_tags(html_entity_decode($primary_support_area)));




function wrapText($fontSize, $angle, $fontFace, $string, $maxWidth)
{
    $words = explode(' ', $string);
   $lines = array();
    $currentLine = '';

    foreach ($words as $word)
    {
        $testLine = $currentLine . $word . ' ';
        $box = imagettfbbox($fontSize, $angle, $fontFace, $testLine);
        $textWidth = num($box[2]) - num($box[0]);

        if ($textWidth > $maxWidth && $currentLine != '')
        {
            $lines[] = trim($currentLine);
            $currentLine = $word . ' ';
        }
        else
        {
            $currentLine = $testLine;
        }
    }

    $lines[] = trim($currentLine);

    return $lines;
}


/*
|--------------------------------------------------------------------------
| CREATE IMAGE
|--------------------------------------------------------------------------
*/
$image = imagecreatefromjpeg($gambar);

/*
|--------------------------------------------------------------------------
| COLOR
|--------------------------------------------------------------------------
*/
$black  = imagecolorallocate($image, 0, 0, 0);
$white  = imagecolorallocate($image, 255, 255, 255);
$gold   = imagecolorallocate($image, 180, 120, 0);
$red    = imagecolorallocate($image, 140, 0, 0);

/*
|--------------------------------------------------------------------------
| FONT
|--------------------------------------------------------------------------
*/
$font_regular   = "LibreBaskerville-Regular.ttf";
$font_bold      = "LibreBaskerville-Bold.ttf";

/*
|--------------------------------------------------------------------------
| FONT SIZE
|--------------------------------------------------------------------------
*/
$font_header 	= 10;
$font_small     = 18;
$font_normal    = 22;
$font_title     = 26;

/*
|--------------------------------------------------------------------------
| STUDENT INFORMATION
|--------------------------------------------------------------------------
*/

/* CLASS / GROUP */
$classLines = wrapText($font_header, 0, $font_regular, $class_group, 210);
$y = 470;

foreach($classLines as $line)
{
    imagettftext(
        $image,
        10,
        0,
        90,
        $y,
        $black,
        $font_regular,
        $line
    );

    $y = num($y) + num((24));
}
/* STUDENT NAME */
$nameLines = wrapText($font_header, 0, $font_regular, $student_name, 180);
$y = 470;

foreach($nameLines as $line)
{
    imagettftext(
        $image,
        10,
        0,
        290,
        $y,
        $black,
        $font_regular,
        $line
    );

    $y = num($y) + num((24));
}

/* MEETING TYPE */
$meetingLines = wrapText($font_header, 0, $font_regular, $meeting_type, 180);
$y = 470;

foreach($meetingLines as $line)
{
    imagettftext(
        $image,
        10,
        0,
        480,
        $y,
        $black,
        $font_regular,
        $line
    );

    $y = num($y) + num((24));
}
/* ATTENDANCE */
if (num($attendance) ==1){$attendance = 'Present';}else {$attendance = 'Not Present';}
$attendanceLines = wrapText($font_header, 0, $font_regular, $attendance, 120);
$y = 470;

foreach($attendanceLines as $line)
{
    imagettftext(
        $image,
        10,
        0,
        700,
        $y,
        $black,
        $font_regular,
        $line
    );

    $y = num($y) + num((24));
}

/*
|--------------------------------------------------------------------------
| MEETING SUMMARY
|--------------------------------------------------------------------------
*/

/* PROGRESS TODAY */
$activityLines = wrapText(18, 0, $font_regular, $progress_today, 700);
$y = 765;

foreach($activityLines as $line)
{
    imagettftext(
        $image,
        12,
        0,
        360,
        $y,
        $black,
        $font_regular,
        $line
    );

    $y = num($y) + num((30));
}

/* PARTICIPATION */
$participationLines = wrapText(18, 0, $font_regular, $participation, 750);
$y = 705;

foreach($participationLines as $line)
{
    imagettftext(
        $image,
        12,
        0,
        360,
        $y,
        $black,
        $font_regular,
        $line
    );

    $y = num($y) + num((30));
}

/*
|--------------------------------------------------------------------------
| PRIMARY STRENGTH
|--------------------------------------------------------------------------
*/
imagettftext(
    $image,
    13,
    0,
    240,
    875,
    $red,
    $font_bold,
    $primary_strength
);

/*
|--------------------------------------------------------------------------
| PRIMARY SUPPORT AREA
|--------------------------------------------------------------------------
*/
imagettftext(
    $image,
    13,
    0,
    685,
    875,
    $red,
    $font_bold,
    $primary_support_area
);

/*
|--------------------------------------------------------------------------
| PARENT UPDATE SUMMARY
|--------------------------------------------------------------------------
*/
$parentLines = wrapText(16, 0, $font_regular, $parent_update, 1050);
$y = 1020;

foreach($parentLines as $line)
{
    imagettftext(
        $image,
        14,
        0,
        190,
        $y,
        $black,
        $font_regular,
        $line
    );

    $y = num($y) + num((26));
}
/*
|--------------------------------------------------------------------------
| TEACHER COMMENT
|--------------------------------------------------------------------------
*/
imagettftext(
    $image,
    12,
    0,
    190,
    1000,
    $black,
    $font_regular,
    $tteacher_comment
);

/* teacher comment */
$classLines = wrapText($font_header, 0, $font_regular, $teacher_comment, 650);
$y = 1155;

foreach($classLines as $line)
{
    imagettftext(
        $image,
        12,
        0,
        190,
        $y,
        $black,
        $font_regular,
        $line
    );

    $y = num($y) + num((24));
}



/*
|--------------------------------------------------------------------------
| SUPPORTING EVIDENCE
|--------------------------------------------------------------------------
*/
$teacherLines = wrapText(16, 0, $font_regular, $teacher_comment, 850);
$y = 1120;

foreach($teacherLines as $line)
{
    imagettftext(
        $image,
        16,
        0,
        120,
        $y,
        $black,
        $font_regular,
        $$line
    );

    $y = num($y) + num((26));
}

/*
|--------------------------------------------------------------------------
| OUTPUT IMAGE
|--------------------------------------------------------------------------
*/
header("Content-Type: image/jpeg");

imagejpeg($image);
imagedestroy($image);
ob_end_flush();
?>