<?php
require_once __DIR__ . "/../_lib/bootstrap.php";
include __DIR__ . "/../conndb.php";

$kd  = in_val('kd', 'get');
$kdb = in_val('kdb', 'get');
$nr  = in_val('nr', 'get');

// ====== MENGGUNAKAN TEMPLATE GAMBAR NO. 2 ======
$gambar = "pt_record_newsign.jpg";

// ---------- Ambil nama student ----------
$query    = q_set($__p_query, "SELECT concat_ws(' ',nama, middle_name, family_name) FROM ves_inc.tb_biodata a where kd_biodata = ? ", [(string) ($kdb)]);
$resource = db_query_or_die('errro_761', $query, $__p_query ?? []);
while ($row_nama = db_fetch($resource, PDO::FETCH_NUM)) {
    $nama_student = $row_nama[0];
}

// ---------- Ambil nama program (enrolled program) ----------
$query_prgm    = q_set($__p_query_prgm, "SELECT nm_program, a.level_program FROM ves_data.vip_billing a left join ves_data.vip_mst_code_prg b on a.kd_program = b.kd_program where kd_biodata = ? order by a.no desc limit 1", [(string) ($kdb)]);
$resource_prg  = db_query_or_die('errro_762', $query_prgm, $__p_query_prgm ?? []);
while ($row_prg = db_fetch($resource_prg, PDO::FETCH_NUM)) {
    $prg = $row_prg[0];
}

// ---------- Ambil data hasil test + target score + rekomendasi program + area of weakness dll ----------
$query_test = q_set($__p_query_test, "SELECT L, S, R, W, total, date_format(test_date,'%d %M %Y'),\r
    prg_recom, prg_type, target_score, prg_recom_2, prg_recom_3, prg_recom_4, prg_recom_5, \r
    durasi, catatan, weak_l, weak_r, weak_w, weak_s, risk, remark\r
    FROM ves_data.vip_class_score_profile\r
    where kd_biodata= ? and no = ? \r
    order by no desc limit 1", [(string) ($kdb), (string) ($nr)]);

$resource_test = db_query_or_die('errro_763', $query_test, $__p_query_test ?? []);

if (num(db_num_rows($resource_test)) == 0) {
    echo "<script type=\"text/javascript\">\n";
    echo "alert('You dont have privillage to access this page');\n";
    echo "window.location = ('https://vistaeducation.com');\n";
    echo "</script>";
    exit;
}

while ($row_test = db_fetch($resource_test, PDO::FETCH_NUM)) {
    $l            = $row_test[0];
    $s            = $row_test[1];
    $r            = $row_test[2];
    $w            = $row_test[3];
    $total        = $row_test[4];
    $tgl_test     = $row_test[5];
    $prgg         = $row_test[6];
    $prg_type     = $row_test[7];
    $target_score = $row_test[8];
    $prg_recom    = $row_test[6];
    $prg_recom_2  = $row_test[9];
    $prg_recom_3  = $row_test[10];
    $prg_recom_4  = $row_test[11];
    $prg_recom_5  = $row_test[12];
    $duration     = $row_test[13];
    $catatan      = $row_test[14];
    
    $weak_l       = $row_test[15];
    $weak_r       = $row_test[16];
    $weak_w       = $row_test[17];
    $weak_s       = $row_test[18];
    $risk         = $row_test[19];
    $remark       = $row_test[20];
}

if ($prg_type == '') { $prg_type = $prg; }

// ---------- AMBIL DATA REKOMENDASI PROGRAM (1 - 5) ----------
$rec_1 = $rec_2 = $rec_3 = $rec_4 = $rec_5 = "";
$rec_jam_1 = $rec_jam_2 = $rec_jam_3 = $rec_jam_4 = $rec_jam_5 = 0;

if (ctype_digit((string)$prg_recom)) {
    $query_recom = q_set($__p_query_recom, "SELECT v.prg_recomm, v.jam FROM ves_data.vip_recomm_list v where id = ? ", [(string) ($prg_recom)]);
    $resource_recom = db_query_or_die('errro_761', $query_recom, $__p_query_recom ?? []);
    while ($row_recom = db_fetch($resource_recom, PDO::FETCH_NUM)) {
        $rec_1 = "1. " . $row_recom[0];
        $rec_jam_1 = $row_recom[1];
    }
}

if ($prg_recom_2 != '') {
    $query_recom = q_set($__p_query_recom, "SELECT v.prg_recomm, v.jam FROM ves_data.vip_recomm_list v where id = ? ", [(string) ($prg_recom_2)]);
    $resource_recom = db_query_or_die('errro_762', $query_recom, $__p_query_recom ?? []);
    while ($row_recom = db_fetch($resource_recom, PDO::FETCH_NUM)) {
        $rec_2 = "2. " . $row_recom[0];
        $rec_jam_2 = $row_recom[1];
    }
}

if ($prg_recom_3 != '') {
    $query_recom = q_set($__p_query_recom, "SELECT v.prg_recomm, v.jam FROM ves_data.vip_recomm_list v where id = ? ", [(string) ($prg_recom_3)]);
    $resource_recom = db_query_or_die('errro_763', $query_recom, $__p_query_recom ?? []);
    if (num(db_num_rows($resource_recom)) > 0) {
        while ($row_recom = db_fetch($resource_recom, PDO::FETCH_NUM)) {
            $rec_3 = "3. " . $row_recom[0];
            $rec_jam_3 = $row_recom[1];
        }
    }
}

if ($prg_recom_4 != '') {
    $query_recom = q_set($__p_query_recom, "SELECT v.prg_recomm, v.jam FROM ves_data.vip_recomm_list v where id = ? ", [(string) ($prg_recom_4)]);
    $resource_recom = db_query_or_die('errro_767', $query_recom, $__p_query_recom ?? []);
    if (num(db_num_rows($resource_recom)) > 0) {
        while ($row_recom = db_fetch($resource_recom, PDO::FETCH_NUM)) {
            $rec_4 = "4. " . $row_recom[0];
            $rec_jam_4 = $row_recom[1];
        }
    }
}

if ($prg_recom_5 != '') {
    $query_recom = q_set($__p_query_recom, "SELECT v.prg_recomm, v.jam FROM ves_data.vip_recomm_list v where id = ? ", [(string) ($prg_recom_5)]);
    $resource_recom = db_query_or_die('errro_764', $query_recom, $__p_query_recom ?? []);
    if (num(db_num_rows($resource_recom)) > 0) {
        while ($row_recom = db_fetch($resource_recom, PDO::FETCH_NUM)) {
            $rec_5 = "5. " . $row_recom[0];
            $rec_jam_5 = $row_recom[1];
        }
    }
}

$total_jam_recom = num($rec_jam_1) + num($rec_jam_2) + num($rec_jam_3) + num($rec_jam_4) + num($rec_jam_5);

// Lookup Target Score jika belum ada
if ($target_score == '' or num($target_score) == 0) {
    $query_test_target_score = q_set($__p_query_test_target_score, "SELECT target_score FROM ves_data.vip_class_score_profile where kd_biodata= ? and (target_score <> '' or target_score <> 0) order by no desc limit 1", [(string) ($kdb)]);
    $resource_target_score = db_query_or_die('errro_76', $query_test_target_score, $__p_query_test_target_score ?? []);
    while ($row_target_score = db_fetch($resource_target_score, PDO::FETCH_NUM)) {
        $target_score = $row_target_score[0];
    }
}

// Setup Kalimat Target & Rekomendasi
if ($duration == '' or num($duration) == 0) {
    $ket_1 = "To achieve a target score of $target_score in $prg_type, $nama_student"; 
} else {
    $ket_1 = "To achieve a target score of $target_score in $prg_type within $duration months, $nama_student"; 
}
$ket_2 = "is recommended to take the following programs :";

if ($catatan == 'LENTERA SCHOOL INDONESIA' or $catatan == 'SMAK Ekumene') {
    $ket_1 = '';
    $ket_2 = '';
}

// ====================== SETUP GAMBAR & FONT ======================
$image = imagecreatefromjpeg($gambar);
$black = imageColorAllocate($image, 0, 0, 0);

$font      = "taile.ttf";
$fontkecil = "taile.ttf";

$size_field = 50;
$size_score = 50;
$size_small = 30;

// ====================== HELPER FUNCTIONS ======================
function drawFitText($image, $font, $size, $minSize, $color, $x, $y, $maxWidth, $text) {
    if ($text === null) { $text = ''; }
    $s = $size;
    while ($s > $minSize) {
        $box = imagettfbbox($s, 0, $font, $text);
        $w   = num($box[2]) - num($box[0]);
        if ($w <= $maxWidth) { break; }
        $s--;
    }
    imagettftext($image, $s, 0, $x, $y, $color, $font, $text);
}

function drawWrappedText($image, $font, $size, $color, $x, $y, $maxWidth, $lineHeight, $maxLines, $text) {
    if ($text === null || $text === '') { return; }
    $words = explode(' ', $text);
    $lines = array();
    $current = '';

    foreach ($words as $word) {
        $test = ($current === '') ? $word : $current . ' ' . $word;
        $box  = imagettfbbox($size, 0, $font, $test);
        $w    = num($box[2]) - num($box[0]);
        if ($w > $maxWidth && $current !== '') {
            $lines[] = $current;
            $current = $word;
        } else {
            $current = $test;
        }
    }
    if ($current !== '') { $lines[] = $current; }

    if (cnt($lines) > $maxLines) {
        $lines = array_slice($lines, 0, $maxLines);
        $lines[num($maxLines) - 1] = rtrim($lines[num($maxLines) - 1]) . '...';
    }

    foreach ($lines as $i => $line) {
        imagettftext($image, $size, 0, $x, num($y) + num((num($i) * num($lineHeight))), $color, $font, $line);
    }
}

// ====================== ISI FORM (BIODATA & RESULT) ======================
drawFitText($image, $font, $size_field, 20, $black, 970, 610, 750, $nama_student);
drawFitText($image, $font, $size_field, 20, $black, 970, 740, 470, $tgl_test);
drawFitText($image, $font, $size_field, 20, $black, 970, 870, 470, $prg_type);

$score_x = 1275;
drawFitText($image, $font, $size_score, 18, $black, $score_x, 1150, 320, $l);      // Listening
drawFitText($image, $font, $size_score, 18, $black, $score_x, 1255, 320, $r);      // Reading
drawFitText($image, $font, $size_score, 18, $black, $score_x, 1355, 320, $w);      // Writing
drawFitText($image, $font, $size_score, 18, $black, $score_x, 1463, 320, $s);      // Speaking
drawFitText($image, $font, $size_score, 18, $black, $score_x, 1565, 320, $total);  // Overall

// ====================== REKOMENDASI PROGRAM & TARGET SCORE ======================
// Dicetak di area kosong antara tabel "The Results" dan tabel "Skill-by-Skill Gap"
if ($catatan != 'John Paul IELTS PT' and $catatan != 'SMA St.Yoseph') {
    $x_recom = 428;
    drawFitText($image, $font, $size_small, 16, $black, $x_recom, 1720, 1500, $ket_1);
    drawFitText($image, $font, $size_small, 16, $black, $x_recom, 1770, 1500, $ket_2);
    
    if ($rec_1 != '') { drawFitText($image, $font, $size_small, 14, $black, $x_recom, 1820, 1500, $rec_1); }
    if ($rec_2 != '') { drawFitText($image, $font, $size_small, 14, $black, $x_recom, 1870, 1500, $rec_2); }
    if ($rec_3 != '') { drawFitText($image, $font, $size_small, 14, $black, $x_recom, 1920, 1500, $rec_3); }
    if ($rec_4 != '') { drawFitText($image, $font, $size_small, 14, $black, $x_recom, 1970, 1500, $rec_4); }
    if ($rec_5 != '') { drawFitText($image, $font, $size_small, 14, $black, $x_recom, 2020, 1500, $rec_5); }
}

if ($catatan != 'LENTERA SCHOOL INDONESIA' and $catatan != 'SMA St.Yoseph' and $catatan != 'SMAK Ekumene') {
    if (num($total_jam_recom) > 0) {
        drawFitText($image, $font, $size_small, 14, $black, 428, 2080, 1500, "Total : $total_jam_recom Hours");
    }
}

// ====================== SKILL-BY-SKILL GAP (Area of Weakness) ======================
$weak_x     = 1310;
$weak_maxw  = 1000;
drawFitText($image, $fontkecil, $size_small, 14, $black, $weak_x, 2290, $weak_maxw, $weak_l); // Listening
drawFitText($image, $fontkecil, $size_small, 14, $black, $weak_x, 2380, $weak_maxw, $weak_r); // Reading
drawFitText($image, $fontkecil, $size_small, 14, $black, $weak_x, 2460, $weak_maxw, $weak_w); // Writing
drawFitText($image, $fontkecil, $size_small, 14, $black, $weak_x, 2530, $weak_maxw, $weak_s); // Speaking

// ====================== MAIN LEARNING RISKS ======================
drawWrappedText($image, $fontkecil, $size_small, $black, 1000, 2650, 900, 34, 2, $risk);

// ====================== TEACHER'S NOTE ======================
drawWrappedText($image, $fontkecil, $size_small, $black, 1000, 2820, 690, 36, 3, $remark);

// ====================== OUTPUT ======================
header("Content-type: image/jpeg");
imagejpeg($image);
imagedestroy($image);
?>