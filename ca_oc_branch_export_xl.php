<?php
require_once __DIR__ . "/_lib/bootstrap.php"; auth_require_login();

include __DIR__ . "/conndb.php";

// Parameters
$date_start = isset($_GET['date_start']) && in_val('date_start', 'get') != '' ? in_val('date_start', 'get') : '2026-01-01';
$date_end   = isset($_GET['date_end']) && in_val('date_end', 'get') != '' ? in_val('date_end', 'get') : date("Y-m-d");
$kd_cbg     = isset($_GET['kd_cbg']) ? in_val('kd_cbg', 'get') : 'CA';
$nm_sc      = isset($_GET['nm_sc']) ? in_val('nm_sc', 'get') : 'All';
$kelas_name = isset($_GET['kelas_name']) ? in_val('kelas_name', 'get') : '';

// Mapping Branch
$cabang_report_order = array(
    1   => 'East Sby',
    2   => 'West Sby',
    3   => 'Denpasar',
    4   => 'South Jkt',
    5   => 'North Jkt',
    6   => 'West Jkt',
    7   => 'Bandung',
    8   => 'Malang',
    11  => 'PIK',
    100 => 'Online',
    14  => 'Medan',
    16  => 'Tangerang',
);

$cabang_report = array();
foreach ($cabang_report_order as $kd => $nm) {
    $cabang_report[$kd] = array(
        'nama'          => $nm,
        'event_payment' => 0,
        'total_income'  => 0,
        'reg_fee'       => 0,
        'material_paid' => 0,
        'tuition_paid'  => 0,
        'kelas_set'     => array(),
        'total_student' => 0,
    );
}

$cabang_name_to_kd = array_flip($cabang_report_order);
$cabang_report['CA_UNMAPPED'] = array(
    'nama'          => 'CA - Unmapped SC',
    'event_payment' => 0,
    'total_income'  => 0,
    'reg_fee'       => 0,
    'material_paid' => 0,
    'tuition_paid'  => 0,
    'kelas_set'     => array(),
    'total_student' => 0,
);

// Filters
if ($kd_cbg == '1000') {
    $filter_cbg = q_set($__p_filter_cbg, " where (a.kd_branch between 1 and 16) and b.nm_program != 'CA' ");
} elseif ($kd_cbg == '15' || $kd_cbg == 'CA') {
    $filter_cbg = q_set($__p_filter_cbg, " where b.nm_program = 'CA' ");
} else {
    $filter_cbg = q_set($__p_filter_cbg, " where a.kd_branch = ? ", [(string) ($kd_cbg)]);
}

$filter_tgl = q_set($__p_filter_tgl, " and f.min_mulai between ? and ? ", [(string) ($date_start) . " 00:00:00", (string) ($date_end) . " 23:00:00"]);
$filter_kelas = ($kelas_name != '') ? " and a.kelas like '%$kelas_name%' " : '';
$filter_sc_clause = ($nm_sc != 'All' && $nm_sc != '') ? " and g.sc = '$nm_sc' " : '';

// Main Query
$query_open_class = q_set($__p_query_open_class, "\r
SELECT\r
  a.mulai_tm,\r
  a.kelas,\r
  g.sc,\r
  g.net_tf,\r
  g.kd_billing,\r
  g.kd_branch,\r
  b.nm_program,\r
  COALESCE(pay.reg_amount, 0)       AS reg_amount,\r
  COALESCE(pay.material_amount, 0)  AS material_amount,\r
  COALESCE(pay.tf_amount, 0)        AS tf_amount\r
FROM ves_data.vip_teacher_schedule a\r
LEFT JOIN ves_data.vip_mst_code_prg b ON a.kode_program = b.kd_program AND a.level_program = b.level_program\r
LEFT JOIN ves_data.vip_billing g ON a.kelas = g.kd_class\r
LEFT JOIN ves_data.vip_student_data e ON g.kd_biodata = e.kd_biodata\r
LEFT JOIN (\r
  SELECT\r
    p.kd_billing,\r
    SUM(CASE WHEN p.jns_payment = 'Registration' AND p.status='PAID' THEN p.amount ELSE 0 END) AS reg_amount,\r
    SUM(CASE WHEN p.jns_payment = 'Material' AND p.status='PAID' THEN p.amount ELSE 0 END) AS material_amount,\r
    SUM(CASE WHEN p.jns_payment IN ('Down Payment','Full Payment','Installment 1','Installment 2','Installment 3')\r
             AND p.status='PAID' THEN p.amount ELSE 0 END) AS tf_amount\r
  FROM vip_billing_payment p\r
  GROUP BY p.kd_billing\r
) pay ON g.kd_billing = pay.kd_billing\r
INNER JOIN (\r
  SELECT kelas, MIN(mulai_tm) AS min_mulai\r
  FROM vip_teacher_schedule\r
  WHERE status_kelas = 1\r
  GROUP BY kelas\r
) f ON a.kelas = f.kelas AND a.mulai_tm = f.min_mulai\r
" . $filter_cbg . " " . $filter_tgl . " " . $filter_kelas . "\r
AND a.kd_biodata = ''\r
AND a.status_kelas = 1\r
" . $filter_sc_clause . "\r
GROUP BY a.kelas, e.kd_biodata\r
ORDER BY g.kd_branch, a.kelas\r
", [...($__p_filter_cbg ?? []), ...($__p_filter_tgl ?? []), ...($__p_filter_kelas ?? []), ...($__p_filter_sc_clause ?? [])]);

$resource = db_query_soft($query_open_class, $__p_query_open_class ?? []);
if ($resource && num(db_num_rows($resource)) > 0) {
    while ($row_open_class = db_fetch($resource)) {
        $nm_program    = $row_open_class['nm_program'];
        $kelas_baru    = $row_open_class['kelas'];
        $kd_branch_row = $row_open_class['kd_branch'];
        $reg_amount    = $row_open_class['reg_amount'];
        $reg_material  = $row_open_class['material_amount'];
        $tf_amount     = $row_open_class['tf_amount'];
        $net_tf        = $row_open_class['net_tf'];

        if (trim($nm_program) === 'CA') {
            $sc = $row_open_class['sc'];
            if ($sc == 'Britney Sherleen Poogoh') {$cabang = 'West Sby';}
            elseif ($sc == 'Jeanny Merilla Theda Lukito') {$cabang = 'Denpasar';}
            elseif ($sc == 'Levinia Aldora Susmono') {$cabang = 'West Jkt';}
            elseif ($sc == 'Indah Nur Atika Sari') {$cabang = 'Denpasar';}
            elseif ($sc == 'Simon') {$cabang = 'West Jkt';}
            elseif ($sc == 'sabrina marcela' || $sc == 'sabrina marchella') {$cabang = 'East Sby';}
            elseif ($sc == 'Cornelia Nathalie' || $sc == 'Arsyi Aisyah' || $sc == 'Event') {$cabang = 'East Sby';}
            elseif ($sc == 'Stevanus Yustiawan') {$cabang = 'West Jkt';}
            else {$cabang = null;}

            $kd_branch_key = ($cabang !== null && isset($cabang_name_to_kd[$cabang])) ? $cabang_name_to_kd[$cabang] : 'CA_UNMAPPED';
        } else {
            $kd_branch_key = $kd_branch_row;
        }

        if ($kd_branch_key !== '' && isset($cabang_report[$kd_branch_key])) {
            $cabang_report[$kd_branch_key]['total_income']  = num($cabang_report[$kd_branch_key]['total_income']) + num((num($net_tf) + num($reg_amount)));
            $cabang_report[$kd_branch_key]['reg_fee']       = num($cabang_report[$kd_branch_key]['reg_fee']) + num(($reg_amount));
            $cabang_report[$kd_branch_key]['material_paid'] = num($cabang_report[$kd_branch_key]['material_paid']) + num(($reg_material));
            $cabang_report[$kd_branch_key]['tuition_paid']  = num($cabang_report[$kd_branch_key]['tuition_paid']) + num(($tf_amount));
            $cabang_report[$kd_branch_key]['kelas_set'][$kelas_baru] = true;
            $cabang_report[$kd_branch_key]['total_student'] = num($cabang_report[$kd_branch_key]['total_student']) + num((1));
        }
    }
}

// Export Headers for Excel
header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=ca_open_class_report_" . date('Ymd') . ".xls");
header("Pragma: no-cache");
header("Expires: 0");
?>
<table border="1">
    <thead>
        <tr style="background-color:#1F4E78; color:#ffffff; font-weight:bold; text-align:center;">
            <th>Cabang</th>
            <th>Event Payment</th>
            <th>Total Income</th>
            <th>Reg Fee Paid</th>
            <th>Material Paid</th>
            <th>Tuition Paid</th>
            <th>Total Payment</th>
            <th>Outstanding</th>
            <th>Jumlah Kelas</th>
            <th>Total Student</th>
        </tr>
    </thead>
    <tbody>
<?php
$grand_event = $grand_income = $grand_regfee = $grand_material = $grand_tuition = $grand_payment = $grand_outstanding = 0;
$grand_kelas = $grand_student = 0;

foreach ($cabang_report_order as $kd => $nm) {
    $row = $cabang_report[$kd];
    $total_income  = $row['total_income'];
    $total_payment = num($row['reg_fee']) + num($row['tuition_paid']);
    $outstanding   = num($total_income) - num($total_payment);
    $jumlah_kelas  = cnt($row['kelas_set']);
    $event_payment = $row['event_payment'];

    $grand_event       = num($grand_event) + num(($event_payment));
    $grand_income      = num($grand_income) + num(($total_income));
    $grand_regfee      = num($grand_regfee) + num(($row['reg_fee']));
    $grand_material    = num($grand_material) + num(($row['material_paid']));
    $grand_tuition     = num($grand_tuition) + num(($row['tuition_paid']));
    $grand_payment     = num($grand_payment) + num(($total_payment));
    $grand_outstanding = num($grand_outstanding) + num(($outstanding));
    $grand_kelas       = num($grand_kelas) + num(($jumlah_kelas));
    $grand_student     = num($grand_student) + num(($row['total_student']));
?>
        <tr>
            <td style="background-color:#FCE4D6; font-weight:bold;"><?php echo e($nm); ?></td>
            <td align="right"><?php echo number_format(num($event_payment), 0, ',', '.'); ?></td>
            <td align="right"><?php echo number_format(num($total_income), 0, ',', '.'); ?></td>
            <td align="right"><?php echo number_format(num($row['reg_fee']), 0, ',', '.'); ?></td>
            <td align="right"><?php echo number_format(num($row['material_paid']), 0, ',', '.'); ?></td>
            <td align="right"><?php echo number_format(num($row['tuition_paid']), 0, ',', '.'); ?></td>
            <td align="right"><?php echo number_format(num($total_payment), 0, ',', '.'); ?></td>
            <td align="right"><?php echo number_format(num($outstanding), 0, ',', '.'); ?></td>
            <td align="center"><?php echo e($jumlah_kelas); ?></td>
            <td align="center"><?php echo e($row['total_student']); ?></td>
        </tr>
<?php
}
?>
        <tr style="background-color:#A9D08E; font-weight:bold;">
            <td>GRAND TOTAL</td>
            <td align="right"><?php echo number_format(num($grand_event), 0, ',', '.'); ?></td>
            <td align="right"><?php echo number_format(num($grand_income), 0, ',', '.'); ?></td>
            <td align="right"><?php echo number_format(num($grand_regfee), 0, ',', '.'); ?></td>
            <td align="right"><?php echo number_format(num($grand_material), 0, ',', '.'); ?></td>
            <td align="right"><?php echo number_format(num($grand_tuition), 0, ',', '.'); ?></td>
            <td align="right"><?php echo number_format(num($grand_payment), 0, ',', '.'); ?></td>
            <td align="right"><?php echo number_format(num($grand_outstanding), 0, ',', '.'); ?></td>
            <td align="center"><?php echo e($grand_kelas); ?></td>
            <td align="center"><?php echo e($grand_student); ?></td>
        </tr>
    </tbody>
</table>