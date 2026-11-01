<?php
require_once __DIR__ . "/_lib/bootstrap.php"; auth_require_login();
/**
 * vip_open_class_report_accxl_multisheet.php
 * Export Open Class Report ke Excel multi-sheet (per tahun ajaran)
 * Sheet: 2026, 2025 — mengikuti format file vip_openclass2526.xlsx
 *
 * Dipanggil dari: vip_open_class_report_acccx.php (tombol Excel)
 * Parameter GET : kd_cbg, date_start, date_end, nm_sc
 */


include __DIR__ . "/conndb.php";
include __DIR__ . "/profiledata.php";

// ── 1. PARAMETER INPUT ──────────────────────────────────────────────────────
$hari_ini  = date("Y-m-d");
$date_start = isset($_GET['date_start']) && in_val('date_start', 'get') != ''
              ? in_val('date_start', 'get') : '2025-07-01';
$date_end   = isset($_GET['date_end'])   && in_val('date_end', 'get')   != ''
              ? in_val('date_end', 'get')   : $hari_ini;

$nama_lengkap = $_SESSION['nama_lengkap'];
$kelompok     = $_SESSION['kelompok'];

// Resolusi cabang (sama dengan file utama)
if ($nama_lengkap == 'Stevanus Yustiawan' || $kelompok == 'ACC') {
    $kd_cbg = isset($_GET['kd_cbg']) ? in_val('kd_cbg', 'get') : '';
} else {
    $kd_cbg = $_SESSION['kd_branch'];
}
if ($kd_cbg == 'National') { $kd_cbg = '1000'; }

$branch_map = array(
    'East Sby'  => 1,  'West Sby' => 2,  'Denpasar'  => 3,
    'South Jkt' => 4,  'North Jkt'=> 5,  'West Jkt'  => 6,
    'Bandung'   => 7,  'Malang'   => 8,  'CA'        => 15,
    'East Area' => 101,'JAKARTA'  => 111,'West Area' => 102,
    'Online'    => 100,'Medan'    => 14, 'PIK'       => 11,
);
if (array_key_exists($kd_cbg, $branch_map)) {
    $kd_cbg = $branch_map[$kd_cbg];
}

$cabang_map = array_flip($branch_map);
$cabang_map[100]  = 'Online';
$cabang_map[1000] = 'National';

$nm_sc = isset($_GET['nm_sc']) ? in_val('nm_sc', 'get') : 'All';

// ── 2. FILTER SQL ────────────────────────────────────────────────────────────
if ($kd_cbg == '') {
    $filter_cbg = '';
    $filter_tgl = q_set($__p_filter_tgl, " where f.min_mulai between ? and ? ", [(string) ($date_start) . " 00:00:00", (string) ($date_end) . " 23:00:00"]);
} elseif ($kd_cbg == '100') {
    $filter_cbg = q_set($__p_filter_cbg, " where a.kd_branch = '100' ");
    $filter_tgl = q_set($__p_filter_tgl, " and f.min_mulai between ? and ? ", [(string) ($date_start) . " 00:00:00", (string) ($date_end) . " 23:00:00"]);
} elseif ($kd_cbg == '1000') {
    $filter_cbg = q_set($__p_filter_cbg, " where (a.kd_branch between 1 and 16) and b.nm_program != 'CA' ");
    $filter_tgl = q_set($__p_filter_tgl, " and f.min_mulai between ? and ? ", [(string) ($date_start) . " 00:00:00", (string) ($date_end) . " 23:00:00"]);
} elseif ($kd_cbg == '101') {
    $filter_cbg = q_set($__p_filter_cbg, " where (a.kd_branch='1' or a.kd_branch='3' or a.kd_branch='8') ");
    $filter_tgl = q_set($__p_filter_tgl, " and f.min_mulai between ? and ? ", [(string) ($date_start) . " 00:00:00", (string) ($date_end) . " 23:00:00"]);
} elseif ($kd_cbg == '102') {
    $filter_cbg = q_set($__p_filter_cbg, " where (a.kd_branch='4' or a.kd_branch='5' or a.kd_branch='6' or a.kd_branch='7') ");
    $filter_tgl = q_set($__p_filter_tgl, " and f.min_mulai between ? and ? ", [(string) ($date_start) . " 00:00:00", (string) ($date_end) . " 23:00:00"]);
} elseif ($kd_cbg == '111') {
    $filter_cbg = q_set($__p_filter_cbg, " where (a.kd_branch='4' or a.kd_branch='5' or a.kd_branch='6' or a.kd_branch='11') ");
    $filter_tgl = q_set($__p_filter_tgl, " and f.min_mulai between ? and ? ", [(string) ($date_start) . " 00:00:00", (string) ($date_end) . " 23:00:00"]);
} elseif ($kd_cbg == '15') {
    $filter_cbg = q_set($__p_filter_cbg, " where b.nm_program = 'CA' ");
    $filter_tgl = q_set($__p_filter_tgl, " and f.min_mulai between ? and ? ", [(string) ($date_start) . " 00:00:00", (string) ($date_end) . " 23:00:00"]);
} else {
    $filter_cbg = q_set($__p_filter_cbg, " where a.kd_branch = ? ", [(string) ($kd_cbg)]);
    $filter_tgl = q_set($__p_filter_tgl, " and f.min_mulai between ? and ? ", [(string) ($date_start) . " 00:00:00", (string) ($date_end) . " 23:00:00"]);
}

$filter_sc_clause = ($nm_sc != 'All' && $nm_sc != '')
    ? "and g.sc = '$nm_sc'" : '';

// ── 3. QUERY UTAMA (sama dengan versi yang dioptimasi di file asli) ──────────
$query = q_set($__p_query, "\r
SELECT\r
  date_format(a.mulai_tm, '%M'),\r
  h.minggu,\r
  e.nama_lengkap,\r
  a.kelas,\r
  b.duration_program,\r
  date_format(a.mulai_tm,'%b %d, %Y'),\r
  g.sc,\r
  g.tf,\r
  g.net_tf,\r
  g.discount,\r
  g.kd_billing,\r
  date_format(a.mulai_tm, '%c'),\r
  g.kd_branch,\r
  date_format(a.mulai_tm, '%y'),\r
  b.nm_program,\r
  a.level_program,\r
  COALESCE(pay.reg_amount,      0) AS reg_amount,\r
  COALESCE(pay.material_amount, 0) AS material_amount,\r
  COALESCE(pay.tf_amount,       0) AS tf_amount,\r
  COALESCE(pay.refund_tf,       0) AS refund_tf,\r
  COALESCE(pay.refund_other,    0) AS refund_other\r
FROM ves_data.vip_teacher_schedule a\r
LEFT JOIN ves_data.vip_mst_code_prg b\r
  ON a.kode_program = b.kd_program AND a.level_program = b.level_program\r
LEFT JOIN ves_data.vip_billing g\r
  ON a.kelas = g.kd_class\r
LEFT JOIN ves_data.vip_student_data e\r
  ON g.kd_biodata = e.kd_biodata\r
LEFT JOIN ves_data.tb_minggu_detail h\r
  ON date_format(a.mulai_tm,'%Y-%m-%d') = date_format(h.detail,'%Y-%m-%d')\r
LEFT JOIN (\r
  SELECT\r
    p.kd_billing,\r
    SUM(CASE WHEN p.jns_payment = 'Registration'\r
             AND p.status='PAID' THEN p.amount ELSE 0 END) AS reg_amount,\r
    SUM(CASE WHEN p.jns_payment = 'Material'\r
             AND p.status='PAID' THEN p.amount ELSE 0 END) AS material_amount,\r
    SUM(CASE WHEN p.jns_payment IN\r
             ('Down Payment','Full Payment','Installment 1','Installment 2','Installment 3')\r
             AND p.status='PAID' THEN p.amount ELSE 0 END) AS tf_amount,\r
    SUM(CASE WHEN r.id_refund IS NOT NULL\r
             AND p.jns_payment IN\r
             ('Down Payment','Full Payment','Installment 1','Installment 2','Installment 3')\r
             THEN r.amount ELSE 0 END) AS refund_tf,\r
    SUM(CASE WHEN r.id_refund IS NOT NULL\r
             AND p.jns_payment IN ('Registration','Material')\r
             THEN r.amount ELSE 0 END) AS refund_other\r
  FROM vip_billing_payment p\r
  LEFT JOIN vip_billing_refund r ON p.id_receipt = r.id_receipt\r
  GROUP BY p.kd_billing\r
) pay ON g.kd_billing = pay.kd_billing\r
INNER JOIN (\r
  SELECT kelas, MIN(mulai_tm) AS min_mulai\r
  FROM vip_teacher_schedule\r
  WHERE status_kelas = 1\r
  GROUP BY kelas\r
) f ON a.kelas = f.kelas AND a.mulai_tm = f.min_mulai\r
" . $filter_cbg . " " . $filter_tgl . "\r
AND a.kd_biodata = ''\r
AND a.status_kelas = 1\r
" . $filter_sc_clause . "\r
GROUP BY a.kelas, e.kd_biodata\r
ORDER BY g.kd_branch, a.kelas\r
", [...($__p_filter_cbg ?? []), ...($__p_filter_tgl ?? []), ...($__p_filter_sc_clause ?? [])]);

$resource = db_query_or_die("Query error: " . '', $query, $__p_query ?? []);

// ── 4. KELOMPOKKAN DATA PER TAHUN ────────────────────────────────────────────
// Sheet tahun ditentukan dari date_format(mulai_tm,'%Y') → kolom index 13 = '%y' (2-digit)
// Kita perlu tahun 4-digit: ambil dari date_start / date_end atau parsing kolom bulan+tahun
// Gunakan strategi: jika tahun 2-digit < 50 → 2000+xx, sisanya 1900+xx (konvensi umum)
$data_by_year = array();

while ($row = db_fetch($resource, PDO::FETCH_NUM)) {
    $yr2 = (int)$row[13]; // 2-digit year dari date_format('%y')
    $year4 = (num($yr2) < 50) ? 2000 + num($yr2) : 1900 + num($yr2);
    $data_by_year[$year4][] = $row;
}

// Urutkan sheet: tahun terbaru di depan (sesuai urutan 2026, 2025 di file referensi)
krsort($data_by_year);

// ── 5. GENERATE EXCEL (native XML / SpreadsheetML — tanpa library eksternal) ─
// Format: SpreadsheetML (.xls yang bisa dibuka Excel, kompatibel PHP lama)

$filename = "VIP_OpenClass_" . $date_start . "_" . $date_end . ".xls";

header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=\"$filename\"");
header("Pragma: no-cache");
header("Expires: 0");

// Helper: escape XML
function xe($str) {
    return htmlspecialchars((string)$str, ENT_QUOTES, 'UTF-8');
}

// Helper: format angka (kosong jika 0/null, angka jika ada nilai)
function fmt($val) {
    if ($val === '' || $val === null) return '';
    $n = (float)$val;
    return (num($n) == 0) ? 0 : $n;
}

echo '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
echo '<Workbook xmlns="urn:schemas-microsoft-com:office:spreadsheet"' . "\n";
echo '  xmlns:ss="urn:schemas-microsoft-com:office:spreadsheet"' . "\n";
echo '  xmlns:x="urn:schemas-microsoft-com:office:excel">' . "\n";

// ── Styles ──────────────────────────────────────────────────────────────────
echo '
<Styles>
  <Style ss:ID="sHeader">
    <Font ss:Bold="1" ss:Color="#FFFFFF" ss:Size="10"/>
    <Interior ss:Color="#17375E" ss:Pattern="Solid"/>
    <Alignment ss:Horizontal="Center" ss:Vertical="Center" ss:WrapText="1"/>
    <Borders>
      <Border ss:Position="Bottom" ss:LineStyle="Continuous" ss:Weight="1" ss:Color="#FFFFFF"/>
      <Border ss:Position="Right"  ss:LineStyle="Continuous" ss:Weight="1" ss:Color="#FFFFFF"/>
    </Borders>
  </Style>
  <Style ss:ID="sTitle">
    <Font ss:Bold="1" ss:Color="#FFFFFF" ss:Size="10"/>
    <Interior ss:Color="#4472C4" ss:Pattern="Solid"/>
    <Alignment ss:Horizontal="Left" ss:Vertical="Center"/>
  </Style>
  <Style ss:ID="sGrandTotal">
    <Font ss:Bold="1" ss:Size="10"/>
    <Interior ss:Color="#A4D94A" ss:Pattern="Solid"/>
    <Alignment ss:Horizontal="Center" ss:Vertical="Center"/>
    <Borders>
      <Border ss:Position="Bottom" ss:LineStyle="Continuous" ss:Weight="1"/>
      <Border ss:Position="Right"  ss:LineStyle="Continuous" ss:Weight="1"/>
      <Border ss:Position="Top"    ss:LineStyle="Continuous" ss:Weight="1"/>
    </Borders>
  </Style>
  <Style ss:ID="sData">
    <Font ss:Size="9"/>
    <Alignment ss:Horizontal="Center" ss:Vertical="Center"/>
    <Borders>
      <Border ss:Position="Bottom" ss:LineStyle="Continuous" ss:Weight="1" ss:Color="#CCCCCC"/>
      <Border ss:Position="Right"  ss:LineStyle="Continuous" ss:Weight="1" ss:Color="#CCCCCC"/>
    </Borders>
  </Style>
  <Style ss:ID="sDataLeft">
    <Font ss:Size="9"/>
    <Alignment ss:Horizontal="Left" ss:Vertical="Center"/>
    <Borders>
      <Border ss:Position="Bottom" ss:LineStyle="Continuous" ss:Weight="1" ss:Color="#CCCCCC"/>
      <Border ss:Position="Right"  ss:LineStyle="Continuous" ss:Weight="1" ss:Color="#CCCCCC"/>
    </Borders>
  </Style>
  <Style ss:ID="sDataNum">
    <Font ss:Size="9"/>
    <Alignment ss:Horizontal="Right" ss:Vertical="Center"/>
    <NumberFormat ss:Format="#,##0"/>
    <Borders>
      <Border ss:Position="Bottom" ss:LineStyle="Continuous" ss:Weight="1" ss:Color="#CCCCCC"/>
      <Border ss:Position="Right"  ss:LineStyle="Continuous" ss:Weight="1" ss:Color="#CCCCCC"/>
    </Borders>
  </Style>
  <Style ss:ID="sGrandNum">
    <Font ss:Bold="1" ss:Size="10"/>
    <Interior ss:Color="#A4D94A" ss:Pattern="Solid"/>
    <Alignment ss:Horizontal="Right" ss:Vertical="Center"/>
    <NumberFormat ss:Format="#,##0"/>
    <Borders>
      <Border ss:Position="Bottom" ss:LineStyle="Continuous" ss:Weight="1"/>
      <Border ss:Position="Right"  ss:LineStyle="Continuous" ss:Weight="1"/>
      <Border ss:Position="Top"    ss:LineStyle="Continuous" ss:Weight="1"/>
    </Borders>
  </Style>
  <Style ss:ID="sOdd">
    <Font ss:Size="9"/>
    <Interior ss:Color="#EBF1DE" ss:Pattern="Solid"/>
    <Alignment ss:Horizontal="Center" ss:Vertical="Center"/>
    <Borders>
      <Border ss:Position="Bottom" ss:LineStyle="Continuous" ss:Weight="1" ss:Color="#CCCCCC"/>
      <Border ss:Position="Right"  ss:LineStyle="Continuous" ss:Weight="1" ss:Color="#CCCCCC"/>
    </Borders>
  </Style>
  <Style ss:ID="sOddLeft">
    <Font ss:Size="9"/>
    <Interior ss:Color="#EBF1DE" ss:Pattern="Solid"/>
    <Alignment ss:Horizontal="Left" ss:Vertical="Center"/>
    <Borders>
      <Border ss:Position="Bottom" ss:LineStyle="Continuous" ss:Weight="1" ss:Color="#CCCCCC"/>
      <Border ss:Position="Right"  ss:LineStyle="Continuous" ss:Weight="1" ss:Color="#CCCCCC"/>
    </Borders>
  </Style>
  <Style ss:ID="sOddNum">
    <Font ss:Size="9"/>
    <Interior ss:Color="#EBF1DE" ss:Pattern="Solid"/>
    <Alignment ss:Horizontal="Right" ss:Vertical="Center"/>
    <NumberFormat ss:Format="#,##0"/>
    <Borders>
      <Border ss:Position="Bottom" ss:LineStyle="Continuous" ss:Weight="1" ss:Color="#CCCCCC"/>
      <Border ss:Position="Right"  ss:LineStyle="Continuous" ss:Weight="1" ss:Color="#CCCCCC"/>
    </Borders>
  </Style>
</Styles>
';

// ── 6. BUAT WORKSHEET PER TAHUN ─────────────────────────────────────────────
foreach ($data_by_year as $year => $rows) {

    // Grand total per sheet
    $ttl_tf        = 0;
    $ttl_refund_tf = 0;
    $ttl_reg       = 0;
    $ttl_material  = 0;
    $ttl_refund_ot = 0;
    $ttl_total     = 0;

    echo '<Worksheet ss:Name="' . xe($year) . '">' . "\n";
    echo '<Table ss:DefaultRowHeight="15">' . "\n";

    // Lebar kolom (21 kolom sesuai header)
    $col_widths = array(40, 55, 35, 30, 90, 30, 130, 80, 80, 90, 80, 70, 70, 80, 30, 30, 70, 80, 60, 100, 70);
    foreach ($col_widths as $w) {
        echo '<Column ss:Width="' . e($w) . '"/>' . "\n";
    }

    // ── Baris info laporan ──────────────────────────────────────────────────
    echo '<Row ss:Height="20">';
    echo '<Cell ss:MergeAcross="20" ss:StyleID="sTitle">';
    echo '<Data ss:Type="String">VIP Open Class and Payment List — Period: '
         . xe($date_start) . ' s/d ' . xe($date_end) . '</Data></Cell>';
    echo '</Row>' . "\n";

    // ── Baris header (2 baris merge: header1 + "Date" di kolom Incentive) ──
    $headers = array(
        'No Month','Month','Week','No','Class','No','Name',
        'TF','Nett TF','Discount','Tuition Paid','Tuition Refund',
        'Reg Fee Paid','Material Book Paid','Mb','Nmb','Other Refund',
        'Total Paid','Center','SC','Incentive Date'
    );
    echo '<Row ss:Height="28">';
    foreach ($headers as $h) {
        echo '<Cell ss:StyleID="sHeader"><Data ss:Type="String">' . xe($h) . '</Data></Cell>';
    }
    echo '</Row>' . "\n";

    // ── Data rows ────────────────────────────────────────────────────────────
    $urut_no      = 1;
    $angkakelas   = 0;
    $kelas_lama   = '';
    $row_idx      = 0;  // untuk alternating color

    foreach ($rows as $r) {
        // Kolom-kolom dari query (index sesuai SELECT)
        // [0]=bulan [1]=minggu [2]=nama [3]=kelas [4]=duration
        // [5]=tgl_mulai [6]=sc [7]=tf [8]=net_tf [9]=discount
        // [10]=kd_billing [11]=no_bulan [12]=kd_branch [13]=yr2digit
        // [14]=nm_program [15]=level_program
        // [16]=reg_amount [17]=material_amount [18]=tf_amount
        // [19]=refund_tf [20]=refund_other

        $kelas_baru = $r[3];

        // Resolusi nama cabang
        $br = (int)$r[12];
        $cabangdisplay = isset($cabang_map[$br]) ? $cabang_map[$br] : $r[12];

        // Hitung per kelas
        if ($kelas_lama != $kelas_baru) {
            $angkakelas++;

            // ── Baris judul kelas ─────────────────────────────────────────
            echo '<Row ss:Height="14">';
            echo '<Cell ss:MergeAcross="20" ss:StyleID="sTitle">';
            echo '<Data ss:Type="String">'
                 . xe($angkakelas . '.' . $kelas_baru
                    . ' [' . $r[14] . ' - ' . $r[15] . ']')
                 . '</Data></Cell>';
            echo '</Row>' . "\n";

            $hitungperkelas = 1;
            $urut_no = 1;
        }

        // Kalkulasi payment
        $reg_amount       = (float)$r[16];
        $reg_material     = (float)$r[17];
        $tf_paid          = (float)$r[18];
        $refund_tf        = (float)$r[19];
        $refund_other     = (float)$r[20];
        $tf_nett          = num($tf_paid) - num($refund_tf);
        $total_paid       = num($reg_amount) + num($reg_material) + num($tf_nett) - num($refund_other);

        // Mb / Nmb flag
        $mb  = (num($reg_material) > 0) ? 1 : '';
        $nmb = (num($mb) != 1)          ? 1 : '';

        // Akumulasi grand total
        $ttl_tf        = num($ttl_tf) + num(($tf_nett));
        $ttl_refund_tf = num($ttl_refund_tf) + num(($refund_tf));
        $ttl_reg       = num($ttl_reg) + num(($reg_amount));
        $ttl_material  = num($ttl_material) + num(($reg_material));
        $ttl_refund_ot = num($ttl_refund_ot) + num(($refund_other));
        $ttl_total     = num($ttl_total) + num(($total_paid));

        // Style alternating
        $sC   = (num($row_idx) % 2 == 0) ? 'sData'    : 'sOdd';
        $sCL  = (num($row_idx) % 2 == 0) ? 'sDataLeft' : 'sOddLeft';
        $sCN  = (num($row_idx) % 2 == 0) ? 'sDataNum'  : 'sOddNum';

        echo '<Row ss:Height="14">';

        // Col 0: No Month
        echo '<Cell ss:StyleID="'.e($sC).'"><Data ss:Type="Number">' . xe($r[11]) . '</Data></Cell>';
        // Col 1: Month-Year  (contoh: January-26)
        echo '<Cell ss:StyleID="'.e($sC).'"><Data ss:Type="String">' . xe($r[0] . '-' . $r[13]) . '</Data></Cell>';
        // Col 2: Week
        echo '<Cell ss:StyleID="'.e($sC).'"><Data ss:Type="String">' . xe($r[1]) . '</Data></Cell>';
        // Col 3: No (urut per kelas)
        echo '<Cell ss:StyleID="'.e($sC).'"><Data ss:Type="Number">' . xe($urut_no) . '</Data></Cell>';
        // Col 4: Class
        echo '<Cell ss:StyleID="'.e($sC).'"><Data ss:Type="String">' . xe($r[3]) . '</Data></Cell>';
        // Col 5: No (hitungperkelas)
        echo '<Cell ss:StyleID="'.e($sC).'"><Data ss:Type="Number">' . xe($hitungperkelas) . '</Data></Cell>';
        // Col 6: Name
        echo '<Cell ss:StyleID="'.e($sCL).'"><Data ss:Type="String">' . xe($r[2]) . '</Data></Cell>';
        // Col 7: TF
        echo '<Cell ss:StyleID="'.e($sCN).'"><Data ss:Type="Number">' . xe(fmt($r[7])) . '</Data></Cell>';
        // Col 8: Nett TF
        echo '<Cell ss:StyleID="'.e($sCN).'"><Data ss:Type="Number">' . xe(fmt($r[8])) . '</Data></Cell>';
        // Col 9: Discount
        echo '<Cell ss:StyleID="'.e($sCL).'"><Data ss:Type="String">' . xe($r[9]) . '</Data></Cell>';
        // Col 10: Tuition Paid
        echo '<Cell ss:StyleID="'.e($sCN).'"><Data ss:Type="Number">' . xe(fmt($tf_nett)) . '</Data></Cell>';
        // Col 11: Tuition Refund
        echo '<Cell ss:StyleID="'.e($sCN).'"><Data ss:Type="Number">' . xe(fmt($refund_tf)) . '</Data></Cell>';
        // Col 12: Reg Fee Paid
        echo '<Cell ss:StyleID="'.e($sCN).'"><Data ss:Type="Number">' . xe(fmt($reg_amount)) . '</Data></Cell>';
        // Col 13: Material Book Paid
        echo '<Cell ss:StyleID="'.e($sCN).'"><Data ss:Type="Number">' . xe(fmt($reg_material)) . '</Data></Cell>';
        // Col 14: Mb
        echo '<Cell ss:StyleID="'.e($sC).'"><Data ss:Type="String">' . xe($mb) . '</Data></Cell>';
        // Col 15: Nmb
        echo '<Cell ss:StyleID="'.e($sC).'"><Data ss:Type="String">' . xe($nmb) . '</Data></Cell>';
        // Col 16: Other Refund
        echo '<Cell ss:StyleID="'.e($sCN).'"><Data ss:Type="Number">' . xe(fmt($refund_other)) . '</Data></Cell>';
        // Col 17: Total Paid
        echo '<Cell ss:StyleID="'.e($sCN).'"><Data ss:Type="Number">' . xe(fmt($total_paid)) . '</Data></Cell>';
        // Col 18: Center
        echo '<Cell ss:StyleID="'.e($sC).'"><Data ss:Type="String">' . xe($cabangdisplay) . '</Data></Cell>';
        // Col 19: SC
        echo '<Cell ss:StyleID="'.e($sCL).'"><Data ss:Type="String">' . xe($r[6]) . '</Data></Cell>';
        // Col 20: Incentive Date (kosong dari query; kolom dipertahankan untuk konsistensi)
        echo '<Cell ss:StyleID="'.e($sC).'"><Data ss:Type="String"></Data></Cell>';

        echo '</Row>' . "\n";

        // Reset per iterasi
        $kelas_lama     = $kelas_baru;
        $hitungperkelas = num($hitungperkelas) + 1;
        $urut_no        = num($urut_no) + 1;
        $row_idx++;
    }

    // ── Baris GRAND TOTAL ────────────────────────────────────────────────────
    echo '<Row ss:Height="18">';
    // Col 0-9: label
    echo '<Cell ss:MergeAcross="9" ss:StyleID="sGrandTotal"><Data ss:Type="String">GRAND TOTAL</Data></Cell>';
    // Col 10: Tuition Paid total
    echo '<Cell ss:StyleID="sGrandNum"><Data ss:Type="Number">' . xe(fmt($ttl_tf)) . '</Data></Cell>';
    // Col 11: Tuition Refund total
    echo '<Cell ss:StyleID="sGrandNum"><Data ss:Type="Number">' . xe(fmt($ttl_refund_tf)) . '</Data></Cell>';
    // Col 12: Reg Fee total
    echo '<Cell ss:StyleID="sGrandNum"><Data ss:Type="Number">' . xe(fmt($ttl_reg)) . '</Data></Cell>';
    // Col 13: Material total
    echo '<Cell ss:StyleID="sGrandNum"><Data ss:Type="Number">' . xe(fmt($ttl_material)) . '</Data></Cell>';
    // Col 14-15: Mb/Nmb (kosong di grand total)
    echo '<Cell ss:StyleID="sGrandTotal"><Data ss:Type="String"></Data></Cell>';
    echo '<Cell ss:StyleID="sGrandTotal"><Data ss:Type="String"></Data></Cell>';
    // Col 16: Other Refund total
    echo '<Cell ss:StyleID="sGrandNum"><Data ss:Type="Number">' . xe(fmt($ttl_refund_ot)) . '</Data></Cell>';
    // Col 17: Total Paid total
    echo '<Cell ss:StyleID="sGrandNum"><Data ss:Type="Number">' . xe(fmt($ttl_total)) . '</Data></Cell>';
    // Col 18-20: kosong
    echo '<Cell ss:StyleID="sGrandTotal"><Data ss:Type="String"></Data></Cell>';
    echo '<Cell ss:StyleID="sGrandTotal"><Data ss:Type="String"></Data></Cell>';
    echo '<Cell ss:StyleID="sGrandTotal"><Data ss:Type="String"></Data></Cell>';
    echo '</Row>' . "\n";

    echo '</Table>' . "\n";

    // ── AutoFilter (aktifkan di baris header = Row 2 setelah baris info) ────
    echo '<AutoFilter x:Range="R2C1:R2C21" xmlns="urn:schemas-microsoft-com:office:excel"/>' . "\n";

    echo '</Worksheet>' . "\n";
}

echo '</Workbook>';
?>
