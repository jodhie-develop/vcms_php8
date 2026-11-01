<?php
require_once __DIR__ . "/_lib/bootstrap.php"; auth_require_login();
/* ==========================================================================
 MONTHLY OPEN CLASS REPORT
 Dibuat mengikuti pola script "vip_open_class_report_acc.php" yang dikirim
 (sama-sama pakai conndb.php / profiledata.php / atas.php / left.php,
 session, dan layout AdminLTE), tapi bentuk tabel & kolomnya mengikuti
 template Excel "template_monthly_oc_ve.xls" (sheet "Open Cls").

 CATATAN PENTING - kolom yang TIDAK ada di query pada script asli dan
 harus dicek/disesuaikan nama kolomnya oleh yang paham struktur DB:
   - School / Institution   -> asumsi: e.no   (vip_student_data) - TOLONG DICEK ULANG
   - Grd (Grade)            -> asumsi: e.no   (vip_student_data) - TOLONG DICEK ULANG
   - Disc. Promo            -> belum ada sumbernya, sementara 0 / kosong
   - Rmk (Remark)           -> belum ada sumbernya, sementara kosong
   - Additional Students, Added Programs (LC), Cancelation Students
     pada bagian summary bawah -> belum ada sumbernya, dibuat manual/kosong
 Cari komentar "TODO" di bawah untuk titik-titik yang perlu disesuaikan.

 FILTER PROGRAM (permintaan revisi):
   - "Fellows Academy" -> b.kd_program LIKE 'FA-%'
   - "CA"              -> b.kd_program LIKE 'CA%' OR b.type_program = 'CA CoT'
   - "VIP English"     -> selain 2 kondisi di atas (komplemen)
   TODO: pastikan kolom "type_program" memang ada di ves_data.vip_mst_code_prg.
========================================================================== */
include __DIR__ . "/conndb.php";
include __DIR__ . "/profiledata.php";
include __DIR__ . "/atas.php";
include __DIR__ . "/left.php";

$hari   = date("d");
$bulan_now  = date("n");
$tahun_now  = date("Y");

$Display    = in_val('Display', 'get');
$kd_program = in_val('kd_program', 'get'); // 'All' | 'FA' | 'CA' | 'VIP'
$date_start = in_val('date_start', 'get'); // Period dari tanggal
$date_end   = in_val('date_end', 'get');   // Period sampai tanggal
$nm_sc      = in_val('nm_sc', 'get');      // Teacher / Consultant

if ($date_start == '') { $date_start = date('Y-m-01'); } // default: awal bulan berjalan
if ($date_end   == '') { $date_end   = date('Y-m-d'); }  // default: hari ini
if ($kd_program == '') { $kd_program = 'All'; }
if ($nm_sc == '') { $nm_sc = 'All'; }

$nama_lengkap = $_SESSION['nama_lengkap'];
$posisi       = $_SESSION['posisi'];
$kd_staff     = $_SESSION['kd_staff'];
$kelompok     = $_SESSION['kelompok'];

// Sama seperti script asli: user tertentu / kelompok ACC boleh pilih cabang manapun,
// selain itu dibatasi ke cabang session dia sendiri.
if ($nama_depan == 'jimmy' or $nama_lengkap == 'Stevanus Yustiawan' or $nama_lengkap == 'kimberly' or $kelompok == 'ACC') {
    $kd_cbg = in_val('kd_cbg', 'get');
    if ($kd_cbg == '') { $kd_cbg = 'All'; }
} else {
    $kd_cbg = $_SESSION['kd_branch'];
}

// --- filter cabang (dipakai untuk batasi query, ambil dari kolom g.kd_branch) ---
if ($kd_cbg == '' or $kd_cbg == 'All' or $kd_cbg == '1000') {
    $filter_cbg = q_set($__p_filter_cbg, " ");
} else {
    $filter_cbg = q_set($__p_filter_cbg, " and g.kd_branch = ? ", [(string) ($kd_cbg)]);
}

// --- filter teacher / consultant ---
if ($nm_sc != '' and $nm_sc != 'All') {
    $filter_sc = q_set($__p_filter_sc, " and g.sc = ? ", [(string) ($nm_sc)]);
} else {
    $filter_sc = q_set($__p_filter_sc, " ");
}

// --- filter program: cuma 2 pilihan sesuai permintaan ---
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

// --- filter periode (Start Prog. s/d End Prog., dipakai ke tanggal mulai kelas) ---
$filter_tgl = q_set($__p_filter_tgl, " and f.min_mulai between ? and ? ", [(string) ($date_start) . " 00:00:00", (string) ($date_end) . " 23:59:59"]);

// Dropdown Branch - sama seperti mapping pada script asli
$branch_list = array(
    'All' => 'All',
    '1'   => 'East Sby',
    '2'   => 'West Sby',
    '3'   => 'Denpasar',
    '4'   => 'South Jkt',
    '5'   => 'North Jkt',
    '6'   => 'West Jkt',
    '7'   => 'Bandung',
    '8'   => 'Malang',
    '11'  => 'PIK',
    '14'  => 'Medan',
    '15'  => 'CA',
    '100' => 'Online',
    '1000'=> 'National',
);

// Dropdown Teacher / Consultant, dibatasi cabang bila cabang dipilih spesifik
if ($kd_cbg == '' or $kd_cbg == 'All' or $kd_cbg == '1000') {
    $query_nm_sc = q_set($__p_query_nm_sc, "SELECT nama_detail FROM ves_data.tb_user WHERE (posisi = 'SC' or posisi = 'AC' or posisi = 'CM' or posisi = 'admission') and aktif = 'Y' GROUP BY nama_detail ORDER BY nama_detail");
} else {
    $query_nm_sc = q_set($__p_query_nm_sc, "SELECT nama_detail FROM ves_data.tb_user WHERE (posisi = 'SC' or posisi = 'AC' or posisi = 'CM' or posisi = 'admission') and aktif = 'Y' and kd_branch = ? GROUP BY nama_detail ORDER BY nama_detail", [(string) ($kd_cbg)]);
}
$resource_nm_sc = db_query_or_die('', $query_nm_sc, $__p_query_nm_sc ?? []);

?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Monthly Open Class Report</title>
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
        border: 1px solid #d6d9dd;
        border-radius: 8px;
        padding: 7px 12px;
        font-size: 14px;
        color: #333;
        background: #fff;
        min-width: 110px;
        height: 38px;
    }
    .filter-item select.filter-control { min-width: 140px; }
    .filter-item input[type="date"] { width: 150px; }
    .btn-filter { border-radius: 8px; padding: 8px 18px; font-size: 14px; border: none; height: 38px; }
    .btn-tampilkan { background: #3f7fd1; color: #fff; }
    .btn-tampilkan:hover { background: #326ab5; color: #fff; }
    .btn-export-excel { background: #1fa955; color: #fff; }
    .btn-export-excel:hover { background: #178a44; color: #fff; }
    .btn-export-pdf { background: #d9534f; color: #fff; }
    .btn-export-pdf:hover { background: #c9302c; color: #fff; }
  </style>
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

<form method="get" action="monthly_oc_report.php">
  <div class="content-wrapper">
    <section class="content-header">
      <h1>Monthly Open Class Report</h1>

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
          <label>Program</label>
          <select name="kd_program" class="filter-control">
            <option value="All" <?php if ($kd_program == 'All') echo 'selected'; ?>>All</option>
            <option value="FA" <?php if ($kd_program == 'FA') echo 'selected'; ?>>Fellows Academy</option>
            <option value="CA" <?php if ($kd_program == 'CA') echo 'selected'; ?>>CA</option>
            <option value="VIP" <?php if ($kd_program == 'VIP') echo 'selected'; ?>>VIP English</option>
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
          <a href="monthly_oc_report_pdf.php?kd_program=<?php echo e(u($kd_program)); ?>&date_start=<?php echo e(u($date_start)); ?>&date_end=<?php echo e(u($date_end)); ?>&kd_cbg=<?php echo e(u($kd_cbg)); ?>&nm_sc=<?php echo e(u($nm_sc)); ?>" target="_blank" class="btn-filter btn-export-pdf"><i class="fa fa-file-pdf-o"></i> Export PDF</a>
        </div>

        <div class="filter-item">
          <a href="monthly_oc_report_xls.php?kd_program=<?php echo e(u($kd_program)); ?>&date_start=<?php echo e(u($date_start)); ?>&date_end=<?php echo e(u($date_end)); ?>&kd_cbg=<?php echo e(u($kd_cbg)); ?>&nm_sc=<?php echo e(u($nm_sc)); ?>" target="_blank" class="btn-filter btn-export-excel">Export to Excel</a>
        </div>
      </div>
    </section>

    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box box-warning">
            <div class="box-body">
              <table width="100%" class="table table-bordered table-striped" id="example3">
                <thead>
                  <tr style="background:#dce6f1;">
                    <td align="center">Ttl. Std</td>
                    <td align="center">Std. Cls</td>
                    <td align="center">Name</td>
                    <td align="center">Prog.</td>
                    <td align="center">Start Prog.</td>
                    <td align="center">End Prog</td>
                    <td align="center">Day</td>
                    <td align="center">School / Institution</td>
                    <td align="center">Grd</td>
                    <td align="center">Prog. Fee</td>
                    <td align="center">Disc. %</td>
                    <td align="center">Disc. Promo</td>
                    <td align="center">Fix Tuition Fee</td>
                    <td align="center">Reg. Fee</td>
                    <td align="center">Material Fee</td>
                    <td align="center">Student Paid</td>
                    <td align="center">Student Outstd.</td>
                    <td align="center">Rmk</td>
                    <td align="center">SC</td>
                  </tr>
                </thead>
                <tbody>
                <?php
                if ($Display != '') {

                    /* ============================================================
                     Query utama: satu baris per murid, dikelompokkan per kelas
                     (a.kelas), mengikuti pola JOIN pada script asli
                     (vip_teacher_schedule, vip_mst_code_prg, vip_billing,
                     vip_student_data, INNER JOIN cari tanggal mulai kelas paling awal).
                    ============================================================ */
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
                            g.private_pax,\r
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
                    $cnt_private = 0; $cnt_reguler = 0; $cnt_semiprivate = 0;
                    $rows_buffer = array();

                    while ($row = db_fetch($resource_oc, PDO::FETCH_NUM)) {
                        $rows_buffer[] = $row;
                    }
                    $total_rows = cnt($rows_buffer);

                    foreach ($rows_buffer as $i => $row) {
                        list($kelas, $nama, $nm_program, $start_prog, $end_prog, $hari_kelas, $sekolah, $grade, $tf, $discount, $net_tf, $sc, $private_pax, $kd_billing) = $row;

                        // Pembayaran per billing, sama pola dengan script asli
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
                        $disc_promo   = 0; // TODO: belum ada sumber data untuk "Disc. Promo"
                        $remark       = ''; // TODO: belum ada sumber data untuk "Rmk"

                        // Cetak baris header kelas (subtotal kelas sebelumnya) saat ganti kelas
                        if ($kelas != $kelas_lama && $kelas_lama != '') {
                            echo '<tr style="background:#eaf3d0;font-weight:bold;">
                                    <td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td>
                                    <td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td>
                                    <td align="right">Subtotal '.e($kelas_lama).'</td>
                                    <td align="center">'.number_format(num($sub_progfee),0,",",".").'</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td align="center">'.number_format(num($sub_fixtuition),0,",",".").'</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td align="center">'.number_format(num($sub_paid),0,",",".").'</td>
                                    <td align="center">'.number_format(num($sub_outstd),0,",",".").'</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                  </tr>';
                            $sub_progfee = 0; $sub_fixtuition = 0; $sub_paid = 0; $sub_outstd = 0;
                        }

                        if ($kelas != $kelas_lama) {
                            // klasifikasi kelas: Private / Semi-private / Reguler, berdasarkan vip_billing.private_pax
                            // PRIVATE  : private_pax = 1 atau 2
                            // SEMI     : private_pax = 3 atau 4
                            // REGULER  : private_pax kosong
                            if ($private_pax == '1' or $private_pax == '2') { $cnt_private++; }
                            elseif ($private_pax == '3' or $private_pax == '4') { $cnt_semiprivate++; }
                            else { $cnt_reguler++; }
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
                                <td align="center">'.e($urut_std).'</td>
                                <td align="center">'.e(($kelas != $kelas_lama ? $kelas : '')).'</td>
                                <td align="left">'.e($nama).'</td>
                                <td align="left">'.e($nm_program).'</td>
                                <td align="center">'.e(($start_prog ? date('d M Y', strtotime($start_prog)) : '')).'</td>
                                <td align="center">'.e(($end_prog ? date('d M Y', strtotime($end_prog)) : '')).'</td>
                                <td align="center">'.e($hari_kelas).'</td>
                                <td align="center">'.e($sekolah).'</td>
                                <td align="center">'.e($grade).'</td>
                                <td align="right">'.number_format(num((float)$tf),0,",",".").'</td>
                                <td align="center">'.e(($discount ? number_format(num((float)$discount*100),0).'%' : '')).'</td>
                                <td align="right">'.number_format(num($disc_promo),0,",",".").'</td>
                                <td align="right">'.number_format(num((float)$net_tf),0,",",".").'</td>
                                <td align="right">'.e(($reg_amount ? number_format(num($reg_amount),0,",",".") : '')).'</td>
                                <td align="right">'.e(($material_amt ? number_format(num($material_amt),0,",",".") : '')).'</td>
                                <td align="right">'.number_format(num($tf_paid),0,",",".").'</td>
                                <td align="right">'.number_format(num($outstanding),0,",",".").'</td>
                                <td align="left">'.e($remark).'</td>
                                <td align="center">'.e($sc).'</td>
                              </tr>';

                        $kelas_lama = $kelas;

                        // subtotal untuk kelas terakhir
                        if ($i == num($total_rows) - 1) {
                            echo '<tr style="background:#eaf3d0;font-weight:bold;">
                                    <td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td>
                                    <td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td>
                                    <td align="right">Subtotal '.e($kelas).'</td>
                                    <td align="center">'.number_format(num($sub_progfee),0,",",".").'</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td align="center">'.number_format(num($sub_fixtuition),0,",",".").'</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td align="center">'.number_format(num($sub_paid),0,",",".").'</td>
                                    <td align="center">'.number_format(num($sub_outstd),0,",",".").'</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                  </tr>';
                        }
                    }
                    ?>
                    <tr style="background:#a4d94a;font-weight:bold;">
                        <td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td>
                        <td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td>
                        <td align="right">GRAND TOTAL</td>
                        <td align="center"><?php echo number_format(num($grand_progfee),0,",","."); ?></td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td align="center"><?php echo number_format(num($grand_fixtuition),0,",","."); ?></td>
                        <td align="center"><?php echo number_format(num($grand_reg),0,",","."); ?></td>
                        <td align="center"><?php echo number_format(num($grand_material),0,",","."); ?></td>
                        <td align="center"><?php echo number_format(num($grand_paid),0,",","."); ?></td>
                        <td align="center"><?php echo number_format(num($grand_outstd),0,",","."); ?></td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                    </tr>
                    <?php
                    $total_kelas = num($cnt_private) + num($cnt_reguler) + num($cnt_semiprivate);
                    $avg_std = num($total_kelas) > 0 ? round(div($urut_std, $total_kelas), 1) : 0;
                    } // tutup if ($Display != '') - jangan dihapus
                    ?>
                </tbody>
              </table>

              <?php if ($Display != '') { ?>
              <!-- Ringkasan bawah, mengikuti bagian summary template excel -->
              <table width="60%" class="table table-bordered" style="margin-top:15px;">
                <tr><td>Private</td><td><?php echo e($cnt_private); ?></td><td>Total Program Fee</td><td><?php echo number_format(num($grand_progfee),0,",","."); ?></td></tr>
                <tr><td>Reguler</td><td><?php echo e($cnt_reguler); ?></td><td>Total Fix Tuition Fee</td><td><?php echo number_format(num($grand_fixtuition),0,",","."); ?></td></tr>
                <tr><td>Semi-private</td><td><?php echo e($cnt_semiprivate); ?></td><td>Total Registration</td><td><?php echo number_format(num($grand_reg),0,",","."); ?></td></tr>
                <tr><td>Monthly Student Average</td><td><?php echo e($avg_std); ?></td><td>Material Fee</td><td><?php echo number_format(num($grand_material),0,",","."); ?></td></tr>
                <tr><td colspan="2">&nbsp;</td><td>Grand Total INCOME by Open Class</td><td><strong><?php echo number_format(num($grand_paid),0,",","."); ?></strong></td></tr>
                <tr><td colspan="4"><em>Total Additional Students / Added Programs (LC) / Cancelation Students belum tersedia sumber datanya - isi manual bila diperlukan.</em></td></tr>
              </table>
              <?php } ?>

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
<script src="plugins/datatables/jquery.dataTables.min.js"></script>
<script src="plugins/datatables/dataTables.bootstrap.min.js"></script>
<script src="dist/js/app.min.js"></script>
<script>
  $(function () {
    $("#example3").DataTable({
      "paging": true,
      "searching": true,
      "ordering": false,
      "info": true,
      "autoWidth": false
    });
  });
</script>
</body>
</html>