<?php
require_once __DIR__ . "/_lib/bootstrap.php"; auth_require_login();

include __DIR__ . "/conndb.php";

$date_start = isset($_GET['date_start']) && in_val('date_start', 'get') != '' ? in_val('date_start', 'get') : date("Y-m-01");
$date_end   = isset($_GET['date_end']) && in_val('date_end', 'get') != '' ? in_val('date_end', 'get') : date("Y-m-d");
$kd_cbg     = isset($_GET['kd_cbg']) ? in_val('kd_cbg', 'get') : '15';

// Daftar Cabang sesuai Urutan Gambar
$cabang_order = array(
    'East Sby', 'West Sby', 'Denpasar', 'South Jkt', 'North Jkt', 
    'West Jkt', 'Bandung', 'Malang', 'PIK', 'Online', 'Medan', 'Tangerang'
);

$summary = array();
foreach ($cabang_order as $cbg) {
    $summary[$cbg] = array(
        'DP'   => 0,
        'RF'   => 0,
        'i1'   => 0,
        'i2'   => 0,
        'i3'   => 0,
        'fp'   => 0,
    );
}

// Query mengambil data payment per receipt
if ($kd_cbg == '15' || $kd_cbg == 'CA') {
    $where_filter = q_set($__p_where_filter, "b.kd_program LIKE 'CA%' AND b.kd_program NOT LIKE 'CAWS%'");
} else {
    $sc_array = explode(',', $kd_cbg);
    $sc_array = $sc_array;
    $sc_in = q_set($__p_sc_in, "" . db_in(array_values((array) $sc_array)), [...array_map('strval', array_values((array) $sc_array))]);
    $where_filter = q_set($__p_where_filter, "b.sc IN (" . $sc_in . ")", [...($__p_sc_in ?? [])]);
}

$query = q_set($__p_query, "SELECT \r
    b.sc,\r
    SUM(CASE WHEN a.jns_Payment = 'Down Payment' THEN a.amount ELSE 0 END) AS DP,\r
    SUM(CASE WHEN a.jns_Payment = 'Registration' THEN a.amount ELSE 0 END) AS RF,\r
    SUM(CASE WHEN a.jns_Payment = 'Installment 1' THEN a.amount ELSE 0 END) AS i1,\r
    SUM(CASE WHEN a.jns_Payment = 'Installment 2' THEN a.amount ELSE 0 END) AS i2,\r
    SUM(CASE WHEN a.jns_Payment = 'Installment 3' THEN a.amount ELSE 0 END) AS i3,\r
    SUM(CASE WHEN a.jns_Payment = 'Full Payment' THEN a.amount ELSE 0 END) AS fp\r
    FROM vip_billing_payment a \r
    LEFT JOIN vip_billing b ON a.kd_biodata = b.kd_biodata AND a.kd_billing = b.kd_billing \r
    WHERE a.id_receipt <> '' \r
    AND " . $where_filter . "\r
    AND a.dt_payment BETWEEN ? AND ?\r
    GROUP BY b.sc", [...($__p_where_filter ?? []), (string) ($date_start), (string) ($date_end)]);

$result = db_query_soft($query, $__p_query ?? []);
if ($result && num(db_num_rows($result)) > 0) {
    while ($r = db_fetch($result)) {
        $sc = $r['sc'];
        
        // Mapping SC ke Cabang
        if ($sc == 'Britney Sherleen Poogoh') { $cbg_sc = 'West Sby'; }
        elseif ($sc == 'Jeanny Merilla Theda Lukito') { $cbg_sc = 'Denpasar'; }
        elseif ($sc == 'Levinia Aldora Susmono') { $cbg_sc = 'West Jkt'; }
        elseif ($sc == 'Indah Nur Atika Sari') { $cbg_sc = 'Denpasar'; }
        elseif ($sc == 'Simon') { $cbg_sc = 'West Jkt'; }
        elseif ($sc == 'sabrina marcela' || $sc == 'sabrina marchella') { $cbg_sc = 'East Sby'; }
        elseif ($sc == 'Cornelia Nathalie' || $sc == 'Arsyi Aisyah' || $sc == 'Event') { $cbg_sc = 'East Sby'; }
        elseif ($sc == 'Stevanus Yustiawan') { $cbg_sc = 'West Jkt'; }
        else { $cbg_sc = ''; }

        if (isset($summary[$cbg_sc])) {
            $summary[$cbg_sc]['DP'] = num($summary[$cbg_sc]['DP']) + num(($r['DP']));
            $summary[$cbg_sc]['RF'] = num($summary[$cbg_sc]['RF']) + num(($r['RF']));
            $summary[$cbg_sc]['i1'] = num($summary[$cbg_sc]['i1']) + num(($r['i1']));
            $summary[$cbg_sc]['i2'] = num($summary[$cbg_sc]['i2']) + num(($r['i2']));
            $summary[$cbg_sc]['i3'] = num($summary[$cbg_sc]['i3']) + num(($r['i3']));
            $summary[$cbg_sc]['fp'] = num($summary[$cbg_sc]['fp']) + num(($r['fp']));
        }
    }
}

// Set Header Excel
header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=ca_receipt_summary_" . date('Ymd') . ".xls");
header("Pragma: no-cache");
header("Expires: 0");
?>
<table border="1">
    <thead>
        <tr style="background-color:#1F4E78; color:#ffffff; font-weight:bold; text-align:center;">
            <th>Cabang</th>
            <th>DP</th>
            <th>RF</th>
            <th>Inst 1</th>
            <th>Inst 2</th>
            <th>Inst 3</th>
            <th>Full Payment</th>
            <th>TOTAL</th>
        </tr>
    </thead>
    <tbody>
<?php
$g_dp = $g_rf = $g_i1 = $g_i2 = $g_i3 = $g_fp = $g_total = 0;

foreach ($cabang_order as $cbg) {
    $row = $summary[$cbg];
    $row_total = num($row['DP']) + num($row['RF']) + num($row['i1']) + num($row['i2']) + num($row['i3']) + num($row['fp']);

    $g_dp    = num($g_dp) + num(($row['DP']));
    $g_rf    = num($g_rf) + num(($row['RF']));
    $g_i1    = num($g_i1) + num(($row['i1']));
    $g_i2    = num($g_i2) + num(($row['i2']));
    $g_i3    = num($g_i3) + num(($row['i3']));
    $g_fp    = num($g_fp) + num(($row['fp']));
    $g_total = num($g_total) + num(($row_total));
?>
        <tr>
            <td style="background-color:#FCE4D6; font-weight:bold;"><?php echo e($cbg); ?></td>
            <td align="right"><?php echo number_format(num($row['DP']), 0, ',', '.'); ?></td>
            <td align="right"><?php echo number_format(num($row['RF']), 0, ',', '.'); ?></td>
            <td align="right"><?php echo number_format(num($row['i1']), 0, ',', '.'); ?></td>
            <td align="right"><?php echo number_format(num($row['i2']), 0, ',', '.'); ?></td>
            <td align="right"><?php echo number_format(num($row['i3']), 0, ',', '.'); ?></td>
            <td align="right"><?php echo number_format(num($row['fp']), 0, ',', '.'); ?></td>
            <td align="right" style="font-weight:bold;"><?php echo number_format(num($row_total), 0, ',', '.'); ?></td>
        </tr>
<?php
}
?>
        <tr style="background-color:#A9D08E; font-weight:bold;">
            <td>GRAND TOTAL</td>
            <td align="right"><?php echo number_format(num($g_dp), 0, ',', '.'); ?></td>
            <td align="right"><?php echo number_format(num($g_rf), 0, ',', '.'); ?></td>
            <td align="right"><?php echo number_format(num($g_i1), 0, ',', '.'); ?></td>
            <td align="right"><?php echo number_format(num($g_i2), 0, ',', '.'); ?></td>
            <td align="right"><?php echo number_format(num($g_i3), 0, ',', '.'); ?></td>
            <td align="right"><?php echo number_format(num($g_fp), 0, ',', '.'); ?></td>
            <td align="right"><?php echo number_format(num($g_total), 0, ',', '.'); ?></td>
        </tr>
    </tbody>
</table>