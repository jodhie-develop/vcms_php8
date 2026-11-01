<?php
require_once __DIR__ . "/_lib/bootstrap.php"; auth_require_login();

include __DIR__ . "/conndb.php";
include __DIR__ . "/profiledata.php";

/*
 * VIP MONTHLY PAYMENT REPORT
 * Layout follows sheet "2026" in COMPARISON VIP template.xlsx:
 * Center | Payment Desc | Detail | monthly Pax/Amount | YTD Pax/Amount.
 *
 * Income source follows vip_receipt.php:
 * vip_billing_payment.amount, dt_payment, status='PAID', jns_payment,
 * joined to vip_billing to exclude FA-% programs.
 *
 * Pax is counted as distinct kd_biodata (student/customer) per month,
 * center and payment category. Amount is SUM(amount).
 */

$today = date('Y-m-d');
$date_start = isset($_GET['date_start']) && in_val('date_start', 'get') !== '' ? in_val('date_start', 'get') : date('Y-01-01');
$date_end = isset($_GET['date_end']) && in_val('date_end', 'get') !== '' ? in_val('date_end', 'get') : $today;
if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $date_start)) $date_start = date('Y-01-01');
if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $date_end)) $date_end = $today;
if ($date_start > $date_end) { $tmp = $date_start; $date_start = $date_end; $date_end = $tmp; }
$tahun_pilih = date('Y', strtotime($date_start));
$branch_filter = isset($_GET['cabang']) ? in_val('cabang', 'get') : 'All';
$produk = isset($_GET['produk']) ? strtoupper(in_val('produk', 'get')) : 'ALL';
if (!in_array($produk, array('ALL','VIP','CA','FA'), true)) $produk = 'ALL';
$export_mode = isset($_GET['export']) && in_val('export', 'get') == 'xls';

if ($export_mode) {
    header("Content-Type: application/vnd.ms-excel; charset=utf-8");
    header("Content-Disposition: attachment; filename=VIP_Monthly_Payment_".$date_start."_to_".$date_end.".xls");
}

$centers = array(
    'ESB' => array('name' => 'East Sby', 'codes' => array('1')),
    'WSB' => array('name' => 'West Sby', 'codes' => array('2')),
    'MLG' => array('name' => 'Malang', 'codes' => array('8')),
    'DPS' => array('name' => 'Denpasar', 'codes' => array('3')),
    // Branch code references follow vip_receipt.php where available.
    'MOI' => array('name' => 'MOI', 'codes' => array('5')), // North Jkt
    'TDR' => array('name' => 'TDR', 'codes' => array('6')), // West Jkt
    'PIK' => array('name' => 'PIK', 'codes' => array('11')),
    'PIM' => array('name' => 'PIM', 'codes' => array('4')), // South Jkt
    'BDG' => array('name' => 'Bandung', 'codes' => array('7')),
    'MEDAN' => array('name' => 'Medan', 'codes' => array('14')),
    'TGR' => array('name' => 'Tangerang', 'codes' => array('16'))
);
$payment_rows = array(
    'registration' => array('label' => 'Registration + PT', 'types' => array('Registration')),
    'material' => array('label' => 'Material Cost', 'types' => array('Material')),
    'dp' => array('label' => 'Down Payment', 'types' => array('Down Payment')),
    'full' => array('label' => 'Full Payment', 'types' => array('Full Payment')),
    'installment' => array('label' => 'Installment', 'types' => array('Installment 1', 'Installment 2', 'Installment 3'))
);

$data = array();
$year_totals = array();
foreach ($centers as $center_code => $center_info) {
    foreach ($payment_rows as $key => $payment_info) {
        for ($m = 1; num($m) <= 12; $m++) $data[$center_code][$key][$m] = array('pax' => 0, 'amount' => 0);
        $year_totals[$center_code][$key] = array('pax' => 0, 'amount' => 0);
    }
}

$date_start_sql = $date_start . ' 00:00:00';
$date_end_sql = $date_end . ' 23:59:59';
$where = q_set($__p_where, "a.status = 'PAID' AND a.dt_payment BETWEEN ? AND ? ", [(string) ($date_start_sql), (string) ($date_end_sql)]);
if ($branch_filter !== 'All' && isset($centers[$branch_filter])) {
    $branch_codes = array_map('intval', $centers[$branch_filter]['codes']);
    $where .= q_add($__p_where, " AND a.kd_branch IN (" . db_in(array_values((array) $branch_codes)) . ")", [...array_map('strval', array_values((array) $branch_codes))]);
}
// Product classification from vip_billing.type_program, linked by kd_billing.
if ($produk == 'CA') {
    $where .= q_add($__p_where, " AND (d.kd_program LIKE 'CA%' OR d.type_program = 'CA CoT')");
} elseif ($produk == 'FA') {
    $where .= q_add($__p_where, " AND d.type_program = 'FELLOWS ACADEMY'");
} elseif ($produk == 'VIP') {
    $where .= q_add($__p_where, " AND d.kd_program NOT LIKE 'CA%' AND (d.kd_program IS NULL OR d.kd_program != 'CA CoT') AND (d.kd_program IS NULL OR d.kd_program != 'FELLOWS ACADEMY')");
}

$query = q_set($__p_query, "\r
    SELECT a.kd_branch, MONTH(a.dt_payment) AS payment_month, a.jns_payment,\r
           COUNT(DISTINCT a.kd_biodata) AS pax, SUM(a.amount) AS amount\r
    FROM vip_billing_payment a\r
    LEFT JOIN vip_billing d ON a.kd_billing = d.kd_billing\r
    WHERE " . $where . "\r
    GROUP BY a.kd_branch, MONTH(a.dt_payment), a.jns_payment\r
", [...($__p_where ?? [])]);

$result = db_query_or_die("Query VIP monthly payment gagal: ".'', $query, $__p_query ?? []);
while ($row = db_fetch($result, PDO::FETCH_ASSOC)) {
    $branch = (string)$row['kd_branch'];
    $month = intval($row['payment_month']);
    $type = $row['jns_payment'];
    foreach ($centers as $center_code => $center_info) {
        if ($branch_filter !== 'All' && $branch_filter !== $center_code) continue;
        if (!in_array($branch, $center_info['codes'], true)) continue;
        foreach ($payment_rows as $key => $payment_info) {
            if (!in_array($type, $payment_info['types'], true)) continue;
            $data[$center_code][$key][$month]['pax'] = num($data[$center_code][$key][$month]['pax']) + num((intval($row['pax'])));
            $data[$center_code][$key][$month]['amount'] = num($data[$center_code][$key][$month]['amount']) + num((floatval($row['amount'])));
            $year_totals[$center_code][$key]['pax'] = num($year_totals[$center_code][$key]['pax']) + num((intval($row['pax'])));
            $year_totals[$center_code][$key]['amount'] = num($year_totals[$center_code][$key]['amount']) + num((floatval($row['amount'])));
        }
    }
}

function vip_fmt($value) {
    return number_format(num((float)$value), 0, ',', '.');
}
function vip_cell($value) {
    return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8');
}
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>VIP Monthly Payment Report</title>
<?php if (!$export_mode) { ?>
<link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
<link rel="stylesheet" href="dist/css/AdminLTE.min.css">
<link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">
<?php } ?>
<style>
html, body { margin:0; padding:0; width:100%; min-height:100%; font-family: Calibri, Arial, sans-serif; font-size: 12px; }
.content-wrapper { margin-left:0 !important; width:100% !important; min-height:100vh; }
.content, .content-header { padding-left:10px; padding-right:10px; }
.report-table { border-collapse: collapse; width: 100%; min-width: 1500px; }
.report-table th, .report-table td { border: 1px solid #777; padding: 4px 6px; }
.report-table .title { font-size: 18px; font-weight: bold; text-align: left; border: 0; }
.report-table .year-title { font-size: 14px; font-weight: bold; text-align: left; border: 0; }
.report-table thead th { background: #D9EAD3; text-align: center; font-weight: bold; }
.report-table .left { text-align: left; }
.report-table .number { text-align: right; mso-number-format: "#,##0"; }
.report-table .center-name { font-weight: bold; background: #F2F2F2; }
.report-table .total-row { font-weight: bold; background: #D9EAD3; }
.report-table .sub-row { padding-left: 22px; }
.filters { margin-bottom: 15px; }
</style>
</head>
<body>
<?php if (!$export_mode) { ?>
<div class="content-wrapper">
<section class="content-header"><h1>VIP Monthly Payment Report</h1></section>
<section class="content">
<form method="get" class="form-inline filters">
  <label for="date_start">Periode</label>
  <input type="date" class="form-control" id="date_start" name="date_start" value="<?php echo vip_cell($date_start); ?>" required>
  <label for="date_end">sampai</label>
  <input type="date" class="form-control" id="date_end" name="date_end" value="<?php echo vip_cell($date_end); ?>" required>
  <label for="cabang">Cabang</label>
  <select class="form-control" id="cabang" name="cabang">
    <option value="All" <?php echo e($branch_filter === 'All' ? 'selected' : ''); ?>>All</option>
<?php foreach ($centers as $center_code => $center_info) { ?>
    <option value="<?php echo vip_cell($center_code); ?>" <?php echo e($branch_filter === $center_code ? 'selected' : ''); ?>><?php echo vip_cell($center_code . ' - ' . $center_info['name']); ?></option>
<?php } ?>
  </select>
  <label for="produk">Product</label>
  <select class="form-control" id="produk" name="produk">
    <option value="ALL" <?php echo e($produk === 'ALL' ? 'selected' : ''); ?>>All</option>
    <option value="VIP" <?php echo e($produk === 'VIP' ? 'selected' : ''); ?>>VIP English</option>
    <option value="CA" <?php echo e($produk === 'CA' ? 'selected' : ''); ?>>CA</option>
    <option value="FA" <?php echo e($produk === 'FA' ? 'selected' : ''); ?>>Fellows Academy</option>
  </select>
  <button type="submit" class="btn btn-primary">Tampilkan</button>
  <button type="submit" name="export" value="xls" class="btn btn-success">Export to Excel</button>
</form>
<?php } ?>
<div style="<?php echo e($export_mode ? '' : 'overflow-x:auto;'); ?>">
<table class="report-table" cellspacing="0" cellpadding="0">
<thead>
<tr><th class="title" colspan="29">INCOME VIP BY PAYMENT</th></tr>
<tr><th class="year-title" colspan="29"><?php echo vip_cell($date_start . " s/d " . $date_end); ?> | Product: <?php echo vip_cell($produk === "ALL" ? "All" : ($produk === "VIP" ? "VIP English" : ($produk === "FA" ? "Fellows Academy" : "CA"))); ?> | Cabang: <?php echo vip_cell($branch_filter); ?></th></tr>
<tr>
  <th rowspan="2">CENTER</th><th rowspan="2">PAYMENT DESC</th><th rowspan="2">DETAIL</th>
<?php for ($m=1; num($m)<=12; $m++) { ?>
  <th colspan="2"><?php echo e(strtoupper(date('M', mktime(0,0,0,$m,1)))); ?></th>
<?php } ?>
  <th colspan="2">TOTAL PERIOD</th>
</tr>
<tr>
<?php for ($m=1; num($m)<=13; $m++) { ?><th>Pax</th><th>Amount</th><?php } ?>
</tr>
</thead>
<tbody>
<?php
$grand = array();
foreach ($payment_rows as $key => $info) {
    for ($m=1; num($m)<=12; $m++) $grand[$key][$m] = array('pax'=>0,'amount'=>0);
    $grand[$key]['ytd'] = array('pax'=>0,'amount'=>0);
}
foreach ($centers as $center_code => $center_info) {
    $center_total = array();
    for ($m=1; num($m)<=12; $m++) $center_total[$m] = array('pax'=>0,'amount'=>0);
    $center_total['ytd'] = array('pax'=>0,'amount'=>0);
    $first = true;

    // Registration and material lines
    foreach (array('registration','material') as $key) {
        echo '<tr>';
        echo '<td class="center-name">'.e(($first ? vip_cell($center_code) : '')).'</td>';
        echo '<td class="left">'.vip_cell($payment_rows[$key]['label']).'</td><td></td>';
        for ($m=1; num($m)<=12; $m++) {
            $v = $data[$center_code][$key][$m];
            echo '<td class="number">'.e(vip_fmt($v['pax'])).'</td><td class="number">'.e(vip_fmt($v['amount'])).'</td>';
            $center_total[$m]['pax'] = num($center_total[$m]['pax']) + num(($v['pax'])); $center_total[$m]['amount'] = num($center_total[$m]['amount']) + num(($v['amount']));
            $grand[$key][$m]['pax'] = num($grand[$key][$m]['pax']) + num(($v['pax'])); $grand[$key][$m]['amount'] = num($grand[$key][$m]['amount']) + num(($v['amount']));
        }
        $yt = $year_totals[$center_code][$key];
        echo '<td class="number">'.e(vip_fmt($yt['pax'])).'</td><td class="number">'.e(vip_fmt($yt['amount'])).'</td></tr>';
        $center_total['ytd']['pax'] = num($center_total['ytd']['pax']) + num(($yt['pax'])); $center_total['ytd']['amount'] = num($center_total['ytd']['amount']) + num(($yt['amount']));
        $grand[$key]['ytd']['pax'] = num($grand[$key]['ytd']['pax']) + num(($yt['pax'])); $grand[$key]['ytd']['amount'] = num($grand[$key]['ytd']['amount']) + num(($yt['amount']));
        $first = false;
    }

    // Tuition Fee heading
    echo '<tr><td></td><td class="left">Tuition Fee</td><td></td>';
    for ($m=1; num($m)<=12; $m++) echo '<td></td><td></td>';
    echo '<td></td><td></td></tr>';

    foreach (array('dp','full','installment') as $key) {
        echo '<tr><td></td><td></td><td class="left sub-row">'.vip_cell($payment_rows[$key]['label']).'</td>';
        for ($m=1; num($m)<=12; $m++) {
            $v = $data[$center_code][$key][$m];
            echo '<td class="number">'.e(vip_fmt($v['pax'])).'</td><td class="number">'.e(vip_fmt($v['amount'])).'</td>';
            $center_total[$m]['pax'] = num($center_total[$m]['pax']) + num(($v['pax'])); $center_total[$m]['amount'] = num($center_total[$m]['amount']) + num(($v['amount']));
            $grand[$key][$m]['pax'] = num($grand[$key][$m]['pax']) + num(($v['pax'])); $grand[$key][$m]['amount'] = num($grand[$key][$m]['amount']) + num(($v['amount']));
        }
        $yt = $year_totals[$center_code][$key];
        echo '<td class="number">'.e(vip_fmt($yt['pax'])).'</td><td class="number">'.e(vip_fmt($yt['amount'])).'</td></tr>';
        $center_total['ytd']['pax'] = num($center_total['ytd']['pax']) + num(($yt['pax'])); $center_total['ytd']['amount'] = num($center_total['ytd']['amount']) + num(($yt['amount']));
        $grand[$key]['ytd']['pax'] = num($grand[$key]['ytd']['pax']) + num(($yt['pax'])); $grand[$key]['ytd']['amount'] = num($grand[$key]['ytd']['amount']) + num(($yt['amount']));
    }

    echo '<tr class="total-row"><td></td><td class="left">TOTAL Tuition Fee</td><td></td>';
    for ($m=1; num($m)<=12; $m++) echo '<td class="number">'.e(vip_fmt($center_total[$m]['pax'])).'</td><td class="number">'.e(vip_fmt($center_total[$m]['amount'])).'</td>';
    echo '<td class="number">'.e(vip_fmt($center_total['ytd']['pax'])).'</td><td class="number">'.e(vip_fmt($center_total['ytd']['amount'])).'</td></tr>';
}
?>
<tr class="total-row">
<td class="center-name">TOTAL</td><td class="left">Registration + PT</td><td></td>
<?php
for ($m=1; num($m)<=12; $m++) {
    $p=$grand['registration'][$m]['pax']; $a=$grand['registration'][$m]['amount'];
    echo '<td class="number">'.e(vip_fmt($p)).'</td><td class="number">'.e(vip_fmt($a)).'</td>';
}
echo '<td class="number">'.e(vip_fmt($grand['registration']['ytd']['pax'])).'</td><td class="number">'.e(vip_fmt($grand['registration']['ytd']['amount'])).'</td></tr>';
?>
<?php foreach (array('material','dp','full','installment') as $key) { ?>
<tr class="total-row"><td></td><td class="left"><?php echo vip_cell($payment_rows[$key]['label']); ?></td><td></td>
<?php for ($m=1; num($m)<=12; $m++) { ?>
<td class="number"><?php echo e(vip_fmt($grand[$key][$m]['pax'])); ?></td><td class="number"><?php echo e(vip_fmt($grand[$key][$m]['amount'])); ?></td>
<?php } ?>
<td class="number"><?php echo e(vip_fmt($grand[$key]['ytd']['pax'])); ?></td><td class="number"><?php echo e(vip_fmt($grand[$key]['ytd']['amount'])); ?></td></tr>
<?php } ?>
<tr class="total-row"><td></td><td class="left">TOTAL TUITION FEE</td><td></td>
<?php
for ($m=1; num($m)<=12; $m++) {
    $p=num($grand['dp'][$m]['pax'])+num($grand['full'][$m]['pax'])+num($grand['installment'][$m]['pax']);
    $a=num($grand['dp'][$m]['amount'])+num($grand['full'][$m]['amount'])+num($grand['installment'][$m]['amount']);
    echo '<td class="number">'.e(vip_fmt($p)).'</td><td class="number">'.e(vip_fmt($a)).'</td>';
}
$yp=num($grand['dp']['ytd']['pax'])+num($grand['full']['ytd']['pax'])+num($grand['installment']['ytd']['pax']);
$ya=num($grand['dp']['ytd']['amount'])+num($grand['full']['ytd']['amount'])+num($grand['installment']['ytd']['amount']);
echo '<td class="number">'.e(vip_fmt($yp)).'</td><td class="number">'.e(vip_fmt($ya)).'</td></tr>';
?>
<tr class="total-row"><td></td><td class="left">TOTAL REGIS+TUITION</td><td></td>
<?php
for ($m=1; num($m)<=12; $m++) {
    $p=num($grand['registration'][$m]['pax'])+num($grand['dp'][$m]['pax'])+num($grand['full'][$m]['pax'])+num($grand['installment'][$m]['pax']);
    $a=num($grand['registration'][$m]['amount'])+num($grand['dp'][$m]['amount'])+num($grand['full'][$m]['amount'])+num($grand['installment'][$m]['amount']);
    echo '<td class="number">'.e(vip_fmt($p)).'</td><td class="number">'.e(vip_fmt($a)).'</td>';
}
$yp=num($grand['registration']['ytd']['pax'])+num($grand['dp']['ytd']['pax'])+num($grand['full']['ytd']['pax'])+num($grand['installment']['ytd']['pax']);
$ya=num($grand['registration']['ytd']['amount'])+num($grand['dp']['ytd']['amount'])+num($grand['full']['ytd']['amount'])+num($grand['installment']['ytd']['amount']);
echo '<td class="number">'.e(vip_fmt($yp)).'</td><td class="number">'.e(vip_fmt($ya)).'</td></tr>';
?>
</tbody>
</table>
</div>
<?php if (!$export_mode) { ?></section></div><?php } ?>
</body>
</html>
