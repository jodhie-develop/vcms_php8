<?php
require_once __DIR__ . "/../_lib/bootstrap.php"; auth_require_login();


header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=vip_receiptmonthlyxl.xls");

include __DIR__ . "/conndb.php";

$q = isset($_GET['q']) ? in_val('q', 'get') : '';

$hari  = date("d");
$bulan = date("m");
$tahun = date("Y");
$hari_ini = "$tahun-$bulan-$hari";

$date_start = isset($_GET['date_start']) ? in_val('date_start', 'get') : '';
$date_end   = isset($_GET['date_end']) ? in_val('date_end', 'get') : '';

if ($date_start == '') { $date_start = "$tahun-$bulan-01"; }
if ($date_end   == '') { $date_end   = $hari_ini; }

$kd_cbg = isset($_GET['kd_cbg']) ? in_val('kd_cbg', 'get') : 1;

// Nama cabang
if (num($kd_cbg) == 1) { $cabang = 'East Sby'; $nm_cabang = $cabang; }
elseif (num($kd_cbg) == 2) { $cabang = 'West Sby'; $nm_cabang = $cabang; }
elseif (num($kd_cbg) == 3) { $cabang = 'Denpasar'; $nm_cabang = 'Bali'; }
elseif (num($kd_cbg) == 4) { $cabang = 'South Jkt'; $nm_cabang = 'Patal Jkt'; }
elseif (num($kd_cbg) == 5) { $cabang = 'North Jkt'; $nm_cabang = 'Central Jkt'; }
elseif (num($kd_cbg) == 6) { $cabang = 'West Jkt'; $nm_cabang = $cabang; }
elseif (num($kd_cbg) == 7) { $cabang = 'Bandung'; $nm_cabang = $cabang; }
elseif (num($kd_cbg) == 8) { $cabang = 'Malang TBI'; $nm_cabang = $cabang; }
elseif (num($kd_cbg) == 9) { $cabang = 'Bandung TBI'; $nm_cabang = $cabang; }
elseif (num($kd_cbg) == 10){ $cabang = 'Bali TBI'; $nm_cabang = $cabang; }
elseif (num($kd_cbg) == 100){ $cabang = 'National'; $nm_cabang = $cabang; }
elseif (num($kd_cbg) == 15){ $cabang = 'CA'; $nm_cabang = $cabang; }
elseif (num($kd_cbg) == 14){ $cabang = 'Medan'; $nm_cabang = $cabang; }

elseif ($kd_cbg == '00'){ $cabang = 'HO'; $nm_cabang = $cabang; }
else { $cabang = 'Unknown'; $nm_cabang = 'Unknown'; }

// helper: angka mentah untuk excel (jangan pakai format titik)
function excel_num($n) {
  if ($n === null || $n === '') return 0;
  // jaga-jaga kalau ada string "1.700.000" dari mana pun:
  $n = str_replace(array('.', ','), array('', '.'), $n); 
  return (float)$n;
}

// escape date (kalau masih mysql_*)
$date_start_esc = $date_start;
$date_end_esc   = $date_end;

// kolom bulan tampil sampai end_date
$endMonth = (int)date('n', strtotime($date_end)); // 1..12
$monthKeys  = array('Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sept','Oct','Nov','Dec');
$monthNames = array('Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sep','Okt','Nov','Des');

$visibleMonths     = array_slice($monthKeys, 0, $endMonth);
$visibleMonthNames = array_slice($monthNames, 0, $endMonth);
// ====== penampung total per bulan + total keseluruhan
$sumMonth = array();
for ($i=0; $i<cnt($visibleMonths); $i++) {
  $sumMonth[$visibleMonths[$i]] = 0;
}
$sumTotal = 0;

// QUERY
if ($kd_cbg !='100'){
$query_monthly = q_set($__p_query_monthly, "\r
SELECT \r
  jenis,\r
  SUM(CASE WHEN MONTH(dt_payment) = 1  THEN amount ELSE 0 END) AS Jan,\r
  SUM(CASE WHEN MONTH(dt_payment) = 2  THEN amount ELSE 0 END) AS Feb,\r
  SUM(CASE WHEN MONTH(dt_payment) = 3  THEN amount ELSE 0 END) AS Mar,\r
  SUM(CASE WHEN MONTH(dt_payment) = 4  THEN amount ELSE 0 END) AS Apr,\r
  SUM(CASE WHEN MONTH(dt_payment) = 5  THEN amount ELSE 0 END) AS May,\r
  SUM(CASE WHEN MONTH(dt_payment) = 6  THEN amount ELSE 0 END) AS Jun,\r
  SUM(CASE WHEN MONTH(dt_payment) = 7  THEN amount ELSE 0 END) AS Jul,\r
  SUM(CASE WHEN MONTH(dt_payment) = 8  THEN amount ELSE 0 END) AS Aug,\r
  SUM(CASE WHEN MONTH(dt_payment) = 9  THEN amount ELSE 0 END) AS Sept,\r
  SUM(CASE WHEN MONTH(dt_payment) = 10 THEN amount ELSE 0 END) AS Oct,\r
  SUM(CASE WHEN MONTH(dt_payment) = 11 THEN amount ELSE 0 END) AS Nov,\r
  SUM(CASE WHEN MONTH(dt_payment) = 12 THEN amount ELSE 0 END) AS `Dec`,\r
  SUM(amount) AS Total\r
FROM (\r
  SELECT\r
    amount,\r
    dt_payment,\r
    CASE\r
      WHEN jns_payment = 'Registration'  THEN 'Registration'\r
      WHEN jns_payment = 'Down Payment' THEN 'DP'\r
      WHEN jns_payment LIKE 'Inst%'     THEN 'Installment'\r
      WHEN jns_payment = 'Full Payment' THEN 'Full Payment'\r
      ELSE NULL\r
    END AS jenis\r
  FROM vip_billing_payment\r
  WHERE status = 'PAID'\r
    AND kd_branch = ?\r
    AND dt_payment BETWEEN ? AND ?\r
) x\r
WHERE jenis IS NOT NULL\r
GROUP BY jenis\r
ORDER BY FIELD(jenis,'Registration','DP','Installment','Full Payment')\r
", [(string) ($kd_cbg), (string) ($date_start_esc), (string) ($date_end_esc)]);
}
else
{	
$query_monthly = q_set($__p_query_monthly, "SELECT \r
  jenis,\r
  SUM(CASE WHEN MONTH(dt_payment) = 1  THEN amount ELSE 0 END) AS Jan,\r
  SUM(CASE WHEN MONTH(dt_payment) = 2  THEN amount ELSE 0 END) AS Feb,\r
  SUM(CASE WHEN MONTH(dt_payment) = 3  THEN amount ELSE 0 END) AS Mar,\r
  SUM(CASE WHEN MONTH(dt_payment) = 4  THEN amount ELSE 0 END) AS Apr,\r
  SUM(CASE WHEN MONTH(dt_payment) = 5  THEN amount ELSE 0 END) AS May,\r
  SUM(CASE WHEN MONTH(dt_payment) = 6  THEN amount ELSE 0 END) AS Jun,\r
  SUM(CASE WHEN MONTH(dt_payment) = 7  THEN amount ELSE 0 END) AS Jul,\r
  SUM(CASE WHEN MONTH(dt_payment) = 8  THEN amount ELSE 0 END) AS Aug,\r
  SUM(CASE WHEN MONTH(dt_payment) = 9  THEN amount ELSE 0 END) AS Sept,\r
  SUM(CASE WHEN MONTH(dt_payment) = 10 THEN amount ELSE 0 END) AS Oct,\r
  SUM(CASE WHEN MONTH(dt_payment) = 11 THEN amount ELSE 0 END) AS Nov,\r
  SUM(CASE WHEN MONTH(dt_payment) = 12 THEN amount ELSE 0 END) AS `Dec`,\r
  SUM(amount) AS Total\r
FROM (\r
  SELECT\r
    amount,\r
    dt_payment,\r
    CASE\r
      WHEN jns_payment = 'Registration'  THEN 'Registration'\r
      WHEN jns_payment = 'Down Payment' THEN 'DP'\r
      WHEN jns_payment LIKE 'Inst%'     THEN 'Installment'\r
      WHEN jns_payment = 'Full Payment' THEN 'Full Payment'\r
      ELSE NULL\r
    END AS jenis\r
  FROM vip_billing_payment\r
  WHERE status = 'PAID'\r
    AND (kd_branch = '1' or kd_branch = '2' or kd_branch = '3' or kd_branch = '4' or kd_branch = '5' or kd_branch = '6' or kd_branch = '7' or kd_branch = '8' or kd_branch = '11' or kd_branch = '14' or kd_branch = '15' ) \r
    AND dt_payment BETWEEN ? and ?\r
) x\r
WHERE jenis IS NOT NULL\r
GROUP BY jenis\r
ORDER BY FIELD(jenis,'Registration','DP','Installment','Full Payment')\r
", [(string) ($date_start), (string) ($date_end)]);}
$result_monthly = db_query_or_die("Query error: ".'', $query_monthly, $__p_query_monthly ?? []);

// ambil semua row
$rows = array();
while ($r = db_fetch($result_monthly, PDO::FETCH_ASSOC)) {
  $rows[] = $r;
}
?>
<html>
<head>
<meta charset="utf-8">
<style>
  /* Penting: ini yang bikin Excel baca angka sebagai number */
/*  .num { mso-number-format:"\\#\\,\\#\\#0"; text-align:right; } */
  .num { mso-number-format:"0"; text-align:right; }	
  .head { font-weight:bold; background:#f2f2f2; }
  .left { text-align:left; }
</style>
</head>
<body>

<table border="1" cellpadding="6" cellspacing="0">
  <thead>
    <tr class="head">
      <th colspan="3" class="left">MONTHLY SUMMARY</th>
    </tr>
    <tr class="head">
      <th class="left"><?php echo e($cabang); ?></th>

      <?php for ($i=0; $i<cnt($visibleMonthNames); $i++): ?>
        <th class="num"><?php echo e($visibleMonthNames[$i]); ?></th>
      <?php endfor; ?>

      <th class="num">Total</th>
    </tr>
  </thead>

  <tbody>
    <?php if (cnt($rows) == 0): ?>
      <tr>
        <td colspan="<?php echo 2 + cnt($visibleMonths); ?>" class="left">
          Data tidak ada pada periode ini.
        </td>
      </tr>
    <?php else: ?>
<?php for ($i=0; $i<cnt($rows); $i++): $r_m = $rows[$i]; ?>
  <tr>
    <td class="left"><?php echo htmlspecialchars($r_m['jenis']); ?></td>

    <?php for ($j=0; $j<cnt($visibleMonths); $j++):
      $m = $visibleMonths[$j];
      $val = isset($r_m[$m]) ? $r_m[$m] : 0;

      // akumulasi total per bulan
      $sumMonth[$m] = num($sumMonth[$m]) + num(((float)$val));
    ?>
      <td class="num"><?php echo e(excel_num($val)); ?></td>
    <?php endfor; ?>

    <?php
      $rowTotal = isset($r_m['Total']) ? $r_m['Total'] : 0;
      $sumTotal = num($sumTotal) + num(((float)$rowTotal)); // akumulasi grand total
    ?>
    <td class="num"><b><?php echo e(excel_num($rowTotal)); ?></b></td>
  </tr>
<?php endfor; ?>
 <tr class="head">
  <td class="left"><b>TOTAL</b></td>

  <?php for ($j=0; $j<cnt($visibleMonths); $j++):
    $m = $visibleMonths[$j];
  ?>
    <td class="num"><b><?php echo e(excel_num($sumMonth[$m])); ?></b></td>
  <?php endfor; ?>

  <td class="num"><b><?php echo e(excel_num($sumTotal)); ?></b></td>
</tr>
    <?php endif; ?>

  </tbody>
</table>

</body>
</html>