<?php
require_once __DIR__ . "/../_lib/bootstrap.php";
include __DIR__ . "/../conndb.php";

$kd  = in_val('kd', 'get');
$kdb = in_val('kdb', 'get');
$nr  = in_val('nr', 'get');

// ====== GANTI DENGAN NAMA FILE TEMPLATE BARU DI SERVER ANDA ======
// Upload Placement_Test_Report_Clean.jpg ke folder yang sama dengan file ini,
// atau sesuaikan path-nya di bawah ini.
$gambar = "pt_record_new.jpg";

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

// ---------- Ambil data hasil test + area of weakness + risk + teacher's note ----------
$query_test = q_set($__p_query_test, "SELECT L, S, R, W, total, date_format(test_date,'%d %M %Y'),\r
    prg_type, weak_l, weak_r, weak_w, weak_s, risk, remark\r
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
    $tgl_test = $row_test[5];
    $l        = $row_test[0];
    $s        = $row_test[1];
    $r        = $row_test[2];
    $w        = $row_test[3];
    $total    = $row_test[4];
    $prg_type = $row_test[6];

    $weak_l   = $row_test[7];
    $weak_r   = $row_test[8];
    $weak_w   = $row_test[9];
    $weak_s   = $row_test[10];
    $risk     = $row_test[11];
    $remark   = $row_test[12];
}

if ($prg_type == '') { $prg_type = $prg; }

// ====================== SETUP GAMBAR & FONT ======================
$image = imagecreatefromjpeg($gambar);
$black = imageColorAllocate($image, 0, 0, 0);

// Gunakan font non-cursive supaya sesuai gaya form (ganti path sesuai font yang tersedia di server)
$font        = "taile.ttf";   // font untuk isian utama (nama, tanggal, program, skor)
$fontkecil   = "taile.ttf";   // font untuk area of weakness / risk / teacher's note

$size_field  = 50; // Name, Test date, Program
$size_score  = 50; // L / R / W / S / Overall
$size_small  = 30; // Area of Weakness, Risk, Teacher's Note

// ====================== HELPER: fit satu baris ke lebar maksimum (auto shrink) ======================
function drawFitText($image, $font, $size, $minSize, $color, $x, $y, $maxWidth, $text)
{
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

// ====================== HELPER: wrap teks ke beberapa baris ======================
function drawWrappedText($image, $font, $size, $color, $x, $y, $maxWidth, $lineHeight, $maxLines, $text)
{
    if ($text === null || $text === '') { return; }
    $words = explode(' ', $text);
    $lines = array();
    $current = '';

    foreach ($words as $word) {
        $test = ($current === '') ? $word : $current . ' ' . $word;
        $box  = imagettfbbox($size, 0, $font, $test);
        $w    = num($box[2]) - num($box[0]);
        if ($w > $maxWidth && $current !== '') {
            $lines[]  = $current;
            $current  = $word;
        } else {
            $current = $test;
        }
    }
    if ($current !== '') { $lines[] = $current; }

    // Batasi jumlah baris, kalau lebih tambahkan "..." di baris terakhir
    if (cnt($lines) > $maxLines) {
        $lines = array_slice($lines, 0, $maxLines);
        $lines[num($maxLines) - 1] = rtrim($lines[num($maxLines) - 1]) . '...';
    }

    foreach ($lines as $i => $line) {
        imagettftext($image, $size, 0, $x, num($y) + num((num($i) * num($lineHeight))), $color, $font, $line);
    }
}

// ====================== ISI FORM ======================
// Test taker's name / Test date / Program
drawFitText($image, $font, $size_field, 20, $black, 970, 610, 750, $nama_student);
drawFitText($image, $font, $size_field, 20, $black, 970, 740, 470, $tgl_test);
drawFitText($image, $font, $size_field, 20, $black, 970, 870, 470, $prg_type);

// ====================== THE RESULTS ======================
$score_x = 1275;
drawFitText($image, $font, $size_score, 18, $black, $score_x, 1150, 320, $l);      // Listening
drawFitText($image, $font, $size_score, 18, $black, $score_x, 1255, 320, $r);      // Reading
drawFitText($image, $font, $size_score, 18, $black, $score_x, 1355, 320, $w);      // Writing
drawFitText($image, $font, $size_score, 18, $black, $score_x, 1463, 320, $s);      // Speaking
drawFitText($image, $font, $size_score, 18, $black, $score_x, 1565, 320, $total);  // Overall

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
