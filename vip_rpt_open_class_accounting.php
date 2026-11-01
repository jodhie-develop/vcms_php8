<?php
require_once __DIR__ . "/_lib/bootstrap.php"; auth_require_login();
/* ==========================================================================
 ACCOUNTING CA - PAYMENT DETAIL REPORT
 Dibuat mengikuti bentuk file "accountingCA_Payment_Detail_2026.xls" yang
 dikirim (sheet "2026"): list rincian pembayaran per murid, dikelompokkan
 per BRANCH (baris header cabang), lalu per BULAN di dalam masing-masing
 cabang. Program di-filter khusus CA (sama seperti aturan sebelumnya):
   b.kd_program LIKE 'CA%' OR b.type_program = 'CA CoT'

 CATATAN PENTING - kolom yang perlu dicek/disesuaikan:
   - Reg (kolom "Reg" pertama / charge) -> asumsi: g.reg_fee (vip_billing) - TOLONG DICEK
   - Tanggal bayar per termin (DP/Fullpay/Pay-1/2/3) -> asumsi kolom
     ves_data.vip_billing_payment.tgl_bayar - TOLONG DICEK nama kolomnya
   - Akun Pendapatan & Keterangan -> tidak ada sumber datanya di DB, sengaja
     dikosongkan (memang manual diisi tim accounting, sama seperti di file
     template aslinya)
   - Pax -> asumsi: g.private_pax (vip_billing), sudah dipakai juga untuk
     klasifikasi Private/Semi/Reguler di report sebelumnya
========================================================================== */
include __DIR__ . "/conndb.php";
include __DIR__ . "/profiledata.php";
include __DIR__ . "/atas.php";
include __DIR__ . "/left.php";

$Display    = in_val('Display', 'get');
$date_start = in_val('date_start', 'get');
$date_end   = in_val('date_end', 'get');
$kd_cbg     = in_val('kd_cbg', 'get');

if ($date_start == '') { $date_start = date('Y-m-01'); }
if ($date_end   == '') { $date_end   = date('Y-m-d'); }
if ($kd_cbg == '') { $kd_cbg = 'All'; }

if ($kd_cbg == '' or $kd_cbg == 'All' or $kd_cbg == '1000') {
    $filter_cbg = q_set($__p_filter_cbg, " ");
} else {
    $filter_cbg = q_set($__p_filter_cbg, " and g.kd_branch = ? ", [(string) ($kd_cbg)]);
}
$filter_tgl = q_set($__p_filter_tgl, " and f.min_mulai between ? and ? ", [(string) ($date_start) . " 00:00:00", (string) ($date_end) . " 23:59:59"]);
// Report ini khusus program CA
$filter_program = q_set($__p_filter_program, " and (b.kd_program LIKE 'CA%' OR b.type_program = 'CA CoT') ");

// Mapping cabang: kode DB -> [nama panjang utk header, kode singkat kolom "Branch"]
// Sama seperti mapping di monthly_oc_report.php, disesuaikan label tampilannya
// dengan yang dipakai di file accountingCA_Payment_Detail_2026.xls
$branch_map = array(
    '1'   => array('East Surabaya', 'ESB'),
    '2'   => array('West Surabaya', 'WSB'),
    '3'   => array('Denpasar', 'DPS'),
    '4'   => array('South Jakarta', 'SJK'),
    '5'   => array('North Jakarta (NJK)', 'NJK'),
    '6'   => array('West Jakarta (WJK)', 'WJK'),
    '7'   => array('Bandung', 'BDG'),
    '8'   => array('Malang', 'MLG'),
    '11'  => array('PIK', 'PIK'),
    '14'  => array('Medan', 'MDN'),
    '100' => array('ONLINE ', 'ONLINE'),
);

$branch_list = array('All' => 'All');
foreach ($branch_map as $code => $info) { $branch_list[$code] = $info[0]; }
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Accounting CA - Payment Detail</title>
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="cdnjs/font-awesome.min.css">
  <link rel="stylesheet" href="../vcms/cdnjs/ionicons.min.css">
  <link rel="stylesheet" href="plugins/datatables/dataTables.bootstrap.css">
  <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
  <link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">
  <style>
    .filter-bar { display: flex; flex-wrap: wrap; align-items: center; gap: 14px; padding: 10px 0 18px 0; }
    .filter-item { display: flex; align-items: center; gap: 8px; }
    .filter-item label { margin: 0; font-size: 14px; color: #444; white-space: nowrap; }
    .filter-item select.filter-control,
    .filter-item input.filter-control {
        border: 1px solid #d6d9dd; border-radius: 8px; padding: 7px 12px;
        font-size: 14px; color: #333; background: #fff; min-width: 110px; height: 38px;
    }
    .filter-item select.filter-control { min-width: 160px; }
    .filter-item input[type="date"] { width: 150px; }
    .btn-filter { border-radius: 8px; padding: 8px 18px; font-size: 14px; border: none; height: 38px; }
    .btn-tampilkan { background: #3f7fd1; color: #fff; }
    .btn-tampilkan:hover { background: #326ab5; color: #fff; }
    .btn-export-excel { background: #1fa955; color: #fff; }
    .btn-export-excel:hover { background: #178a44; color: #fff; }
    .btn-export-pdf { background: #d9534f; color: #fff; }
    .btn-export-pdf:hover { background: #c9302c; color: #fff; }
    table.report-table td, table.report-table th { font-size:12px; white-space:nowrap; }
    tr.branch-row td { background:#d9d9d9; font-weight:bold; }
  </style>
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

<form method="get" action="accountingCA_payment_detail.php">
  <div class="content-wrapper">
    <section class="content-header">
      <h1>Summary Payment Details by Open Class CA</h1>

      <div class="filter-bar">
        <div class="filter-item">
          <label>Branch</label>
          <select name="kd_cbg" class="filter-control">
            <?php foreach ($branch_list as $code => $label) { ?>
              <option value="<?php echo e($code); ?>" <?php if ($kd_cbg == $code) echo 'selected'; ?>><?php echo e($label); ?></option>
            <?php } ?>
          </select>
        </div>

        <div class="filter-item">
          <label>Period</label>
          <input type="date" name="date_start" class="filter-control" value="<?php echo e($date_start); ?>">
          <span>to</span>
          <input type="date" name="date_end" class="filter-control" value="<?php echo e($date_end); ?>">
        </div>

        <div class="filter-item">
          <input type="submit" name="Display" id="Display" value="Tampilkan" class="btn-filter btn-tampilkan">
        </div>

        <div class="filter-item">
          <a href="accountingCA_payment_detail_pdf.php?date_start=<?php echo e(u($date_start)); ?>&date_end=<?php echo e(u($date_end)); ?>&kd_cbg=<?php echo e(u($kd_cbg)); ?>" target="_blank" class="btn-filter btn-export-pdf"><i class="fa fa-file-pdf-o"></i> Export PDF</a>
        </div>

        <div class="filter-item">
          <a href="accountingCA_payment_detail_xls.php?date_start=<?php echo e(u($date_start)); ?>&date_end=<?php echo e(u($date_end)); ?>&kd_cbg=<?php echo e(u($kd_cbg)); ?>" target="_blank" class="btn-filter btn-export-excel">Export to Excel</a>
        </div>
      </div>
    </section>

    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box box-warning">
            <div class="box-body" style="overflow-x:auto;">
              <table class="table table-bordered table-striped report-table" id="example4">
                <thead>
                  <tr style="background:#dce6f1;">
                    <td>Branch</td><td>Filter</td><td>Bulan</td><td>NO</td><td>Std Name</td>
                    <td>Akun Pendapatan</td><td>Keterangan</td><td>Class Code</td><td>Program</td><td>Pax</td>
                    <td>Tuition Fee</td><td>Nett Tuition</td><td>Reg</td><td>Total Fee</td><td>Reg</td>
                    <td>Date DP</td><td>DP</td><td>Date Fullpay</td><td>Fullpay</td>
                    <td>Date Pay-1</td><td>Pay-1</td><td>Date Pay-2</td><td>Pay-2</td><td>Date Pay-3</td><td>Pay-3</td>
                    <td>Date Tuition Paid</td><td>Tuition Paid</td><td>Std Payment</td><td>OS</td><td>SC</td>
                  </tr>
                </thead>
                <tbody>
<?php
if ($Display != '') {

    $query_ca = q_set($__p_query_ca, "\r
        SELECT\r
            g.kd_branch,\r
            a.kelas,\r
            f.min_mulai AS start_prog,\r
            e.nama_lengkap,\r
            b.nm_program,\r
            g.private_pax,\r
            g.tf,\r
            g.net_tf,\r
            g.reg_fee,          -- TODO: cek nama kolom reg fee (charge) yang benar di vip_billing\r
            g.sc,\r
            g.kd_billing\r
        FROM ves_data.vip_teacher_schedule a\r
        LEFT JOIN ves_data.vip_mst_code_prg b ON a.kode_program = b.kd_program AND a.level_program = b.level_program\r
        LEFT JOIN ves_data.vip_billing g ON a.kelas = g.kd_class\r
        LEFT JOIN ves_data.vip_student_data e ON g.kd_biodata = e.kd_biodata\r
        INNER JOIN (SELECT kelas, MIN(mulai_tm) AS min_mulai FROM ves_data.vip_teacher_schedule WHERE status_kelas = 1 GROUP BY kelas) f\r
            ON a.kelas = f.kelas AND a.mulai_tm = f.min_mulai\r
        WHERE a.kd_biodata = '' AND a.status_kelas = 1\r
        " . $filter_tgl . " " . $filter_program . " " . $filter_cbg . "\r
        GROUP BY a.kelas, e.kd_biodata\r
        ORDER BY g.kd_branch, f.min_mulai, a.kelas, e.nama_lengkap\r
    ", [...($__p_filter_tgl ?? []), ...($__p_filter_program ?? []), ...($__p_filter_cbg ?? [])]);
    $resource_ca = db_query_or_die('', $query_ca, $__p_query_ca ?? []);

    $rows = array();
    while ($row = db_fetch($resource_ca, PDO::FETCH_ASSOC)) { $rows[] = $row; }

    $branch_lama = null;
    $bulan_lama  = null;
    $grand_nett  = 0;

    foreach ($rows as $r) {
        $kd_branch = $r['kd_branch'];
        $branch_info = isset($branch_map[$kd_branch]) ? $branch_map[$kd_branch] : array('Lainnya', '-');
        $bulan_key = date('Y-m', strtotime($r['start_prog']));

        // Baris header Branch (sekali tiap ganti cabang)
        if ($kd_branch != $branch_lama) {
            echo '<tr class="branch-row"><td colspan="29">'.e($branch_info[0]).'</td></tr>';
            $branch_lama = $kd_branch;
            $bulan_lama = null; // reset supaya Bulan tampil lagi di cabang baru
        }

        // Breakdown pembayaran per termin, dari vip_billing_payment
        $pay = array();
        $query_pay = q_set($__p_query_pay, "\r
            SELECT jns_payment, SUM(amount) AS amt, MAX(tgl_bayar) AS tgl\r
            FROM ves_data.vip_billing_payment\r
            WHERE kd_billing = ? AND status = 'PAID'\r
            GROUP BY jns_payment\r
        ", [(string) ($r['kd_billing'])]);
        $resource_pay = db_query_soft($query_pay, $__p_query_pay ?? []);
        while ($rp = db_fetch($resource_pay, PDO::FETCH_ASSOC)) {
            $pay[$rp['jns_payment']] = array('amt' => (float)$rp['amt'], 'tgl' => $rp['tgl']);
        }

        // Refund yang mengurangi pembayaran tuition (DP/Fullpay/Pay-1/2/3)
        $query_refund = q_set($__p_query_refund, "\r
            SELECT SUM(rf.amount) AS refund_tf\r
            FROM ves_data.vip_billing_payment p\r
            LEFT JOIN ves_data.vip_billing_refund rf ON p.id_receipt = rf.id_receipt\r
            WHERE p.kd_billing = ?\r
              AND p.jns_payment IN ('Down Payment','Full Payment','Installment 1','Installment 2','Installment 3')\r
        ", [(string) ($r['kd_billing'])]);
        $resource_refund = db_query_soft($query_refund, $__p_query_refund ?? []);
        $row_refund = db_fetch($resource_refund, PDO::FETCH_ASSOC);
        $refund_tf = (float) $row_refund['refund_tf'];

        $dp        = isset($pay['Down Payment'])    ? $pay['Down Payment']['amt']    : 0;
        $dp_tgl    = isset($pay['Down Payment'])    ? $pay['Down Payment']['tgl']    : '';
        $fullpay   = isset($pay['Full Payment'])     ? $pay['Full Payment']['amt']    : 0;
        $fullpay_tgl = isset($pay['Full Payment'])   ? $pay['Full Payment']['tgl']    : '';
        $pay1      = isset($pay['Installment 1'])    ? $pay['Installment 1']['amt']   : 0;
        $pay1_tgl  = isset($pay['Installment 1'])    ? $pay['Installment 1']['tgl']   : '';
        $pay2      = isset($pay['Installment 2'])    ? $pay['Installment 2']['amt']   : 0;
        $pay2_tgl  = isset($pay['Installment 2'])    ? $pay['Installment 2']['tgl']   : '';
        $pay3      = isset($pay['Installment 3'])    ? $pay['Installment 3']['amt']   : 0;
        $pay3_tgl  = isset($pay['Installment 3'])    ? $pay['Installment 3']['tgl']   : '';
        $reg_paid  = isset($pay['Registration'])     ? $pay['Registration']['amt']    : 0;

        $tuition_paid = num($dp) + num($fullpay) + num($pay1) + num($pay2) + num($pay3) - num($refund_tf);
        $tgl_candidates = array_filter(array($dp_tgl, $fullpay_tgl, $pay1_tgl, $pay2_tgl, $pay3_tgl));
        $tuition_paid_tgl = cnt($tgl_candidates) ? max($tgl_candidates) : '';

        $reg_fee    = (float) $r['reg_fee'];
        $total_fee  = (float) $r['net_tf'] + num($reg_fee);
        $std_payment = num($tuition_paid) + num($reg_paid);
        $os          = num($total_fee) - num($std_payment);
        $grand_nett = num($grand_nett) + num(((float) $r['net_tf']));

        echo '<tr>
                <td>'.e($branch_info[1]).'</td>
                <td>'.date('M', strtotime($r['start_prog'])).'</td>
                <td>'.e(($bulan_key != $bulan_lama ? date('d M Y', strtotime($r['start_prog'])) : '')).'</td>
                <td>&nbsp;</td>
                <td>'.e($r['nama_lengkap']).'</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>'.e($r['kelas']).'</td>
                <td>'.e($r['nm_program']).'</td>
                <td align="center">'.e($r['private_pax']).'</td>
                <td align="right">'.number_format(num((float)$r['tf']),0,",",".").'</td>
                <td align="right">'.number_format(num((float)$r['net_tf']),0,",",".").'</td>
                <td align="right">'.number_format(num($reg_fee),0,",",".").'</td>
                <td align="right">'.number_format(num($total_fee),0,",",".").'</td>
                <td align="right">'.e(($reg_paid ? number_format(num($reg_paid),0,",",".") : '')).'</td>
                <td>'.e(($dp_tgl ? date('d/m/y', strtotime($dp_tgl)) : '')).'</td>
                <td align="right">'.e(($dp ? number_format(num($dp),0,",",".") : '')).'</td>
                <td>'.e(($fullpay_tgl ? date('d/m/y', strtotime($fullpay_tgl)) : '')).'</td>
                <td align="right">'.e(($fullpay ? number_format(num($fullpay),0,",",".") : '')).'</td>
                <td>'.e(($pay1_tgl ? date('d/m/y', strtotime($pay1_tgl)) : '')).'</td>
                <td align="right">'.e(($pay1 ? number_format(num($pay1),0,",",".") : '')).'</td>
                <td>'.e(($pay2_tgl ? date('d/m/y', strtotime($pay2_tgl)) : '')).'</td>
                <td align="right">'.e(($pay2 ? number_format(num($pay2),0,",",".") : '')).'</td>
                <td>'.e(($pay3_tgl ? date('d/m/y', strtotime($pay3_tgl)) : '')).'</td>
                <td align="right">'.e(($pay3 ? number_format(num($pay3),0,",",".") : '')).'</td>
                <td>'.e(($tuition_paid_tgl ? date('d/m/y', strtotime($tuition_paid_tgl)) : '')).'</td>
                <td align="right">'.number_format(num($tuition_paid),0,",",".").'</td>
                <td align="right">'.number_format(num($std_payment),0,",",".").'</td>
                <td align="right">'.number_format(num($os),0,",",".").'</td>
                <td>'.e($r['sc']).'</td>
              </tr>';

        $bulan_lama = $bulan_key;
    }
    ?>
                </tbody>
              </table>
              <p><strong>Grand Total Nett Tuition: Rp <?php echo number_format(num($grand_nett),0,",","."); ?></strong></p>
              <?php
}
?>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
</form>
</div>
<script src="plugins/jQuery/jquery-2.2.3.min.js"></script>
<script src="bootstrap/js/bootstrap.min.js"></script>
<script src="dist/js/app.min.js"></script>
</body>
</html>