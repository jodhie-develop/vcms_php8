<?php
require_once __DIR__ . "/_lib/bootstrap.php"; auth_require_login();
/* ==========================================================================
 EXPORT EXCEL - Monthly Open Class Report
 Mengikuti pola export excel pada script asli (mis. vip_open_class_report_accxl.php):
 output HTML table dengan header Content-Type xls, supaya bisa dibuka
 langsung di Excel. Susunan kolom & baris subtotal mengikuti
 template_monthly_oc_ve.xls (sheet "Open Cls").
 Lihat komentar TODO di monthly_oc_report.php untuk kolom yang perlu dicek.
========================================================================== */
include __DIR__ . "/conndb.php";
include __DIR__ . "/profiledata.php";

$kd_program = in_val('kd_program', 'get'); // 'All' | 'FA' | 'CA' | 'VIP'
$kd_cbg     = in_val('kd_cbg', 'get');
$nm_sc      = in_val('nm_sc', 'get');
$date_start = in_val('date_start', 'get');
$date_end   = in_val('date_end', 'get');

if ($date_start == '') { $date_start = date('Y-m-01'); }
if ($date_end   == '') { $date_end   = date('Y-m-d'); }

if ($kd_cbg == '' or $kd_cbg == 'All' or $kd_cbg == '1000') {
    $filter_cbg = q_set($__p_filter_cbg, " ");
} else {
    $filter_cbg = q_set($__p_filter_cbg, " and g.kd_branch = ? ", [(string) ($kd_cbg)]);
}
if ($nm_sc != '' and $nm_sc != 'All') {
    $filter_sc = q_set($__p_filter_sc, " and g.sc = ? ", [(string) ($nm_sc)]);
} else {
    $filter_sc = q_set($__p_filter_sc, " ");
}
// Filter Program: cuma 2 pilihan sesuai permintaan revisi
if ($kd_program == 'FA') {
    $filter_program = q_set($__p_filter_program, " and b.kd_program LIKE 'FA-%' ");
} elseif ($kd_program == 'CA') {
    $filter_program = q_set($__p_filter_program, " and (b.kd_program LIKE 'CA%' OR b.type_program = 'CA CoT') ");
} elseif ($kd_program == 'VIP') {
    // VIP English: semua program SELAIN Fellows Academy dan CA
    $filter_program = q_set($__p_filter_program, " and b.kd_program NOT LIKE 'FA-%' and b.kd_program NOT LIKE 'CA%' and (b.type_program is null or b.type_program <> 'CA CoT') ");
} else {
    $filter_program = q_set($__p_filter_program, " ");
}
$filter_tgl = q_set($__p_filter_tgl, " and f.min_mulai between ? and ? ", [(string) ($date_start) . " 00:00:00", (string) ($date_end) . " 23:59:59"]);

header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=Monthly_Open_Class_" . date('Ymd_His') . ".xls");
header("Pragma: no-cache");
header("Expires: 0");
?>
<table border="1">
  <tr>
    <td colspan="19" align="center"><strong>MONTHLY OPEN CLASS PAYMENT DETAILS</strong></td>
  </tr>
  <tr>
    <td colspan="19" align="center">Period: <?php echo date('d M Y', strtotime($date_start)); ?> - <?php echo date('d M Y', strtotime($date_end)); ?></td>
  </tr>
  <tr><td colspan="19">&nbsp;</td></tr>
  <tr style="background:#dce6f1;font-weight:bold;">
    <td>Ttl. Std</td><td>Std. Cls</td><td>Name</td><td>Prog.</td><td>Start Prog.</td>
    <td>End Prog</td><td>Day</td><td>School / Institution</td><td>Grd</td><td>Prog. Fee</td>
    <td>Disc. %</td><td>Disc. Promo</td><td>Fix Tuition Fee</td><td>Reg. Fee</td><td>Material Fee</td>
    <td>Student Paid</td><td>Student Outstd.</td><td>Rmk</td><td>SC</td>
  </tr>
<?php
$query_oc = q_set($__p_query_oc, "\r
    SELECT\r
        a.kelas,\r
        e.nama_lengkap,\r
        b.nm_program,\r
        f.min_mulai AS start_prog,\r
        (SELECT MAX(mulai_tm) FROM ves_data.vip_teacher_schedule WHERE kelas = a.kelas AND status_kelas = 1) AS end_prog,\r
        (SELECT GROUP_CONCAT(DISTINCT DAYNAME(mulai_tm) ORDER BY DAYOFWEEK(mulai_tm) SEPARATOR ', ')\r
           FROM ves_data.vip_teacher_schedule WHERE kelas = a.kelas AND status_kelas = 1) AS hari_kelas,\r
        e.no,        -- TODO: cek nama kolom sekolah/institusi murid yang benar\r
        e.no,          -- TODO: cek nama kolom grade/tingkat murid yang benar\r
        g.tf,\r
        g.discount,\r
        g.net_tf,\r
        g.sc,\r
        g.kd_billing\r
    FROM ves_data.vip_teacher_schedule a\r
    LEFT JOIN ves_data.vip_mst_code_prg b ON a.kode_program = b.kd_program AND a.level_program = b.level_program\r
    LEFT JOIN ves_data.vip_billing g ON a.kelas = g.kd_class\r
    LEFT JOIN ves_data.vip_student_data e ON g.kd_biodata = e.kd_biodata\r
    INNER JOIN (SELECT kelas, MIN(mulai_tm) AS min_mulai FROM ves_data.vip_teacher_schedule WHERE status_kelas = 1 GROUP BY kelas) f\r
        ON a.kelas = f.kelas AND a.mulai_tm = f.min_mulai\r
    WHERE a.kd_biodata = '' AND a.status_kelas = 1\r
    " . $filter_tgl . " " . $filter_program . " " . $filter_cbg . " " . $filter_sc . "\r
    GROUP BY a.kelas, e.kd_biodata\r
    ORDER BY a.kelas, e.nama_lengkap\r
", [...($__p_filter_tgl ?? []), ...($__p_filter_program ?? []), ...($__p_filter_cbg ?? []), ...($__p_filter_sc ?? [])]);
$resource_oc = db_query_or_die('', $query_oc, $__p_query_oc ?? []);

$kelas_lama = '';
$urut_std = 0;
$sub_progfee = 0; $sub_fixtuition = 0; $sub_paid = 0; $sub_outstd = 0;
$grand_progfee = 0; $grand_fixtuition = 0; $grand_reg = 0; $grand_material = 0; $grand_paid = 0; $grand_outstd = 0;

$rows_buffer = array();
while ($row = db_fetch($resource_oc, PDO::FETCH_NUM)) { $rows_buffer[] = $row; }
$total_rows = cnt($rows_buffer);

foreach ($rows_buffer as $i => $row) {
    list($kelas, $nama, $nm_program, $start_prog, $end_prog, $hari_kelas, $sekolah, $grade, $tf, $discount, $net_tf, $sc, $kd_billing) = $row;

    $query_payment = q_set($__p_query_payment, "\r
        SELECT\r
            SUM(CASE WHEN p.jns_payment = 'Registration' AND p.status='PAID' THEN p.amount ELSE 0 END) AS reg_amount,\r
            SUM(CASE WHEN p.jns_payment = 'Material' AND p.status='PAID' THEN p.amount ELSE 0 END) AS material_amount,\r
            SUM(CASE WHEN p.jns_payment IN ('Down Payment','Full Payment','Installment 1','Installment 2','Installment 3') AND p.status='PAID' THEN p.amount ELSE 0 END) AS tf_amount,\r
            SUM(CASE WHEN r.id_refund IS NOT NULL AND p.jns_payment IN ('Down Payment','Full Payment','Installment 1','Installment 2','Installment 3') THEN r.amount ELSE 0 END) AS refund_tf\r
        FROM ves_data.vip_billing_payment p\r
        LEFT JOIN ves_data.vip_billing_refund r ON p.id_receipt = r.id_receipt\r
        WHERE p.kd_billing = ?\r
    ", [(string) ($kd_billing)]);
    $resource_payment = db_query_soft($query_payment, $__p_query_payment ?? []);
    $row_payment = db_fetch($resource_payment, PDO::FETCH_ASSOC);

    $reg_amount   = (float) $row_payment['reg_amount'];
    $material_amt = (float) $row_payment['material_amount'];
    $tf_paid      = (float) $row_payment['tf_amount'] - (float) $row_payment['refund_tf'];
    $outstanding  = (float) $net_tf - num($tf_paid);

    if ($kelas != $kelas_lama && $kelas_lama != '') {
        echo '<tr style="background:#eaf3d0;font-weight:bold;">
                <td colspan="9" align="right">Subtotal '.e($kelas_lama).'</td>
                <td>'.number_format(num($sub_progfee),0,",",".").'</td>
                <td></td><td></td>
                <td>'.number_format(num($sub_fixtuition),0,",",".").'</td>
                <td></td><td></td>
                <td>'.number_format(num($sub_paid),0,",",".").'</td>
                <td>'.number_format(num($sub_outstd),0,",",".").'</td>
                <td></td><td></td>
              </tr>';
        $sub_progfee = 0; $sub_fixtuition = 0; $sub_paid = 0; $sub_outstd = 0;
    }

    $urut_std++;
    $sub_progfee    = num($sub_progfee) + num(((float) $tf));
    $sub_fixtuition = num($sub_fixtuition) + num(((float) $net_tf));
    $sub_paid       = num($sub_paid) + num(($tf_paid));
    $sub_outstd     = num($sub_outstd) + num(($outstanding));

    $grand_progfee    = num($grand_progfee) + num(((float) $tf));
    $grand_fixtuition = num($grand_fixtuition) + num(((float) $net_tf));
    $grand_reg        = num($grand_reg) + num(($reg_amount));
    $grand_material   = num($grand_material) + num(($material_amt));
    $grand_paid       = num($grand_paid) + num(($tf_paid));
    $grand_outstd     = num($grand_outstd) + num(($outstanding));

    echo '<tr>
            <td>'.e($urut_std).'</td>
            <td>'.e(($kelas != $kelas_lama ? $kelas : '')).'</td>
            <td>'.e($nama).'</td>
            <td>'.e($nm_program).'</td>
            <td>'.e(($start_prog ? date('d M Y', strtotime($start_prog)) : '')).'</td>
            <td>'.e(($end_prog ? date('d M Y', strtotime($end_prog)) : '')).'</td>
            <td>'.e($hari_kelas).'</td>
            <td>'.e($sekolah).'</td>
            <td>'.e($grade).'</td>
            <td>'.number_format(num((float)$tf),0,",",".").'</td>
            <td>'.e(($discount ? number_format(num((float)$discount*100),0).'%' : '')).'</td>
            <td></td>
            <td>'.number_format(num((float)$net_tf),0,",",".").'</td>
            <td>'.e(($reg_amount ? number_format(num($reg_amount),0,",",".") : '')).'</td>
            <td>'.e(($material_amt ? number_format(num($material_amt),0,",",".") : '')).'</td>
            <td>'.number_format(num($tf_paid),0,",",".").'</td>
            <td>'.number_format(num($outstanding),0,",",".").'</td>
            <td></td>
            <td>'.e($sc).'</td>
          </tr>';

    $kelas_lama = $kelas;

    if ($i == num($total_rows) - 1) {
        echo '<tr style="background:#eaf3d0;font-weight:bold;">
                <td colspan="9" align="right">Subtotal '.e($kelas).'</td>
                <td>'.number_format(num($sub_progfee),0,",",".").'</td>
                <td></td><td></td>
                <td>'.number_format(num($sub_fixtuition),0,",",".").'</td>
                <td></td><td></td>
                <td>'.number_format(num($sub_paid),0,",",".").'</td>
                <td>'.number_format(num($sub_outstd),0,",",".").'</td>
                <td></td><td></td>
              </tr>';
    }
}
?>
  <tr style="background:#a4d94a;font-weight:bold;">
    <td colspan="9" align="right">GRAND TOTAL</td>
    <td><?php echo number_format(num($grand_progfee),0,",","."); ?></td>
    <td></td><td></td>
    <td><?php echo number_format(num($grand_fixtuition),0,",","."); ?></td>
    <td><?php echo number_format(num($grand_reg),0,",","."); ?></td>
    <td><?php echo number_format(num($grand_material),0,",","."); ?></td>
    <td><?php echo number_format(num($grand_paid),0,",","."); ?></td>
    <td><?php echo number_format(num($grand_outstd),0,",","."); ?></td>
    <td></td><td></td>
  </tr>
</table>