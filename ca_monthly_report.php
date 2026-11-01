<?php
require_once __DIR__ . "/_lib/bootstrap.php"; auth_require_login();
include __DIR__ . "/conndb.php";
include __DIR__ . "/profiledata.php";
include __DIR__ . "/atas.php";
include __DIR__ . "/left.php";

// ============================================================================
// Monthly Open Class Detail Report (program CA) - per cabang, per bulan
//
// Beda basis tanggal per metric (sesuai request):
//   - Total Income, Jumlah Class, Jumlah Student -> berdasarkan BULAN mulai kelas
//     (vip_teacher_schedule.mulai_tm), sama seperti report per-periode sebelumnya.
//   - Reg Fee Paid, Tuition Paid                 -> berdasarkan BULAN pembayaran
//     ACTUAL (vip_billing_payment.dt_payment), bukan bulan mulai kelas.
//   - Refund       -> SEMENTARA 0 / placeholder (data vip_billing_refund belum
//     bisa dipastikan valid linknya, sesuai keputusan waktu itu).
//   - Total Payment = Reg Fee Paid + Tuition Paid (Material Book Paid TIDAK
//     diikutkan, sesuai keputusan terakhir di report per-periode).
//   - Outstanding   = Total Income - Total Payment (nilai kontrak vs uang yang
//     beneran masuk di bulan itu; bisa != 0 kalau ada selisih waktu bayar/refund
//     yg belum tercermin).
// ============================================================================

$nama_lengkap = $_SESSION['nama_lengkap'];
$posisi       = $_SESSION['posisi'];
$kd_staff     = $_SESSION['kd_staff'];
$kelompok     = $_SESSION['kelompok'];

$tahun   = in_val('tahun', 'get');
$Display = in_val('Display', 'get');
if ($tahun == '') { $tahun = date('Y'); }

$bulan_label = array(
	1  => 'Jan', 2  => 'Feb', 3  => 'Mar', 4  => 'Apr',
	5  => 'Mei', 6  => 'Jun', 7  => 'Jul', 8  => 'Agu',
	9  => 'Sep', 10 => 'Okt', 11 => 'Nov', 12 => 'Des',
);
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>AdminLTE 2 | Monthly Open Class Detail</title>
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="cdnjs/font-awesome.min.css">
  <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">
	<div class="content-wrapper">
		<section class="content-header">
			<h1>Monthly Open Class Detail <small>(program CA)</small></h1>
		</section>
		<section class="content">
			<div class="row">
				<div class="col-xs-12">
					<div class="box">
						<div class="box-body">
							<form method="get" action="">
								<table>
									<tr>
										<td width="129"><small><label for="tahun">Tahun :</label></small></td>
										<td width="546"><small>
											<input type="number" name="tahun" id="tahun" value="<?php echo e($tahun); ?>" style="width:100px;">
										</small></td>
									</tr>
									<tr>
										<td>&nbsp;</td>
										<td><input type="submit" name="Display" id="Display" value="Display"></td>
									</tr>
								</table>
							</form>
							<?php
							if ($Display != '') {

								// =========================================================
								// QUERY A: Total Income + Jumlah Class + Jumlah Student
								// Basis tanggal: BULAN MULAI KELAS (a.mulai_tm)
								// =========================================================
								$query_income = q_set($__p_query_income, "\r
SELECT\r
  MONTH(a.mulai_tm) AS bulan,\r
  a.kelas,\r
  e.kd_biodata,\r
  g.sc,\r
  g.net_tf,\r
  g.kd_branch,\r
  COALESCE(pay.reg_amount, 0) AS reg_amount\r
FROM ves_data.vip_teacher_schedule a\r
LEFT JOIN ves_data.vip_mst_code_prg b\r
  ON a.kode_program = b.kd_program AND a.level_program = b.level_program\r
LEFT JOIN ves_data.vip_billing g\r
  ON a.kelas = g.kd_class\r
LEFT JOIN ves_data.vip_student_data e\r
  ON g.kd_biodata = e.kd_biodata\r
LEFT JOIN (\r
  SELECT\r
    p.kd_billing,\r
    SUM(CASE WHEN p.jns_payment = 'Registration' AND p.status='PAID' THEN p.amount ELSE 0 END) AS reg_amount\r
  FROM vip_billing_payment p\r
  GROUP BY p.kd_billing\r
) pay ON g.kd_billing = pay.kd_billing\r
INNER JOIN (\r
  SELECT kelas, MIN(mulai_tm) AS min_mulai\r
  FROM vip_teacher_schedule\r
  WHERE status_kelas = 1\r
  GROUP BY kelas\r
) f ON a.kelas = f.kelas AND a.mulai_tm = f.min_mulai\r
WHERE b.nm_program = 'CA'\r
  AND YEAR(a.mulai_tm) = ?\r
  AND a.kd_biodata = ''\r
  AND a.status_kelas = 1\r
GROUP BY a.kelas, e.kd_biodata\r
ORDER BY a.mulai_tm\r
", [(string) ($tahun)]);

								// =========================================================
								// QUERY B: Reg Fee Paid + Tuition Paid
								// Basis tanggal: BULAN PEMBAYARAN ACTUAL (p.dt_payment)
								// =========================================================
								$query_payment = q_set($__p_query_payment, "\r
SELECT\r
  MONTH(p.dt_payment) AS bulan,\r
  g.sc,\r
  g.kd_branch,\r
  SUM(CASE WHEN p.jns_payment = 'Registration' AND p.status='PAID'\r
           THEN p.amount ELSE 0 END) AS reg_amount,\r
  SUM(CASE WHEN p.jns_payment IN ('Down Payment','Full Payment','Installment 1','Installment 2','Installment 3')\r
           AND p.status='PAID' THEN p.amount ELSE 0 END) AS tf_amount\r
FROM vip_billing_payment p\r
JOIN ves_data.vip_billing g ON g.kd_billing = p.kd_billing\r
JOIN (\r
  SELECT DISTINCT a.kelas\r
  FROM ves_data.vip_teacher_schedule a\r
  JOIN ves_data.vip_mst_code_prg b\r
    ON a.kode_program = b.kd_program AND a.level_program = b.level_program\r
  WHERE b.nm_program = 'CA'\r
) ca ON ca.kelas = g.kd_class\r
WHERE p.status = 'PAID'\r
  AND YEAR(p.dt_payment) = ?\r
GROUP BY g.sc, g.kd_branch, MONTH(p.dt_payment)\r
", [(string) ($tahun)]);

								// =========================================================
								// Cabang mapping (sama seperti report per-periode CA)
								// =========================================================
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
								$cabang_name_to_kd = array_flip($cabang_report_order);

								// Struktur data: $monthly[$kd_branch_key]['nama'] , ['total_income'][$bulan], ['reg_fee'][$bulan],
								// ['tuition_paid'][$bulan], ['kelas_set'][$bulan][$kelas]=true, ['student_set'][$bulan][$kd_biodata]=true
								$monthly = array();
								foreach ($cabang_report_order as $kd => $nm) {
									$monthly[$kd] = array(
										'nama'         => $nm,
										'total_income' => array(),
										'reg_fee'      => array(),
										'tuition_paid' => array(),
										'kelas_set'    => array(),
										'student_set'  => array(),
									);
								}
								$monthly['CA'] = array(
									'nama'         => 'CA',
									'total_income' => array(),
									'reg_fee'      => array(),
									'tuition_paid' => array(),
									'kelas_set'    => array(),
									'student_set'  => array(),
								);

								// fungsi kecil buat nentuin cabang dari SC (khusus program CA)
								// -> semua kelas di report ini SUDAH pasti nm_program = 'CA' (di-filter dari query),
								//    jadi SC-mapping ini SELALU dipakai (beda dgn report lama yg campur program lain).
								function ca_sc_to_branch_key($sc, $cabang_name_to_kd) {
									if ($sc == 'Britney Sherleen Poogoh')            { $cabang = 'West Sby'; }
									elseif ($sc == 'Jeanny Merilla Theda Lukito')    { $cabang = 'Denpasar'; }
									elseif ($sc == 'Levinia Aldora Susmono')         { $cabang = 'West Jkt'; }
									elseif ($sc == 'Indah Nur Atika Sari')           { $cabang = 'Denpasar'; }
									elseif ($sc == 'Simon')                         { $cabang = 'West Jkt'; }
									elseif ($sc == 'sabrina marcela')               { $cabang = 'East Sby'; }
									elseif ($sc == 'sabrina marchella')             { $cabang = 'East Sby'; }
									elseif ($sc == 'Cornelia Nathalie')             { $cabang = 'East Sby'; }
									elseif ($sc == 'Arsyi Aisyah')                  { $cabang = 'East Sby'; }
									elseif ($sc == 'Stevanus Yustiawan')            { $cabang = 'West Jkt'; }
									elseif ($sc == 'Event')                         { $cabang = 'East Sby'; }
									else                                             { $cabang = null; }

									if ($cabang !== null && isset($cabang_name_to_kd[$cabang])) {
										return $cabang_name_to_kd[$cabang];
									}
									return 'CA'; // SC belum ke-mapping -> masuk bucket "CA"
								}

								// ---- Proses QUERY A (Income, Jumlah Class, Jumlah Student) ----
								$resource_income = db_query_soft($query_income, $__p_query_income ?? []);
								if ($resource_income && num(db_num_rows($resource_income)) > 0) {
									while ($row = db_fetch($resource_income, PDO::FETCH_NUM)) {
										$bulan      = (int) $row[0];
										$kelas      = $row[1];
										$kd_biodata = $row[2];
										$sc         = $row[3];
										$net_tf     = $row[4];
										$reg_amount = $row[6];

										$kd_key = ca_sc_to_branch_key($sc, $cabang_name_to_kd);
										if (!isset($monthly[$kd_key])) { continue; }

										if (!isset($monthly[$kd_key]['total_income'][$bulan])) { $monthly[$kd_key]['total_income'][$bulan] = 0; }
										$monthly[$kd_key]['total_income'][$bulan] = num($monthly[$kd_key]['total_income'][$bulan]) + num((num($net_tf) + num($reg_amount)));

										$monthly[$kd_key]['kelas_set'][$bulan][$kelas] = true;
										$monthly[$kd_key]['student_set'][$bulan][$kd_biodata] = true;
									}
								}

								// ---- Proses QUERY B (Reg Fee Paid, Tuition Paid) ----
								$resource_payment = db_query_soft($query_payment, $__p_query_payment ?? []);
								if ($resource_payment && num(db_num_rows($resource_payment)) > 0) {
									while ($row = db_fetch($resource_payment, PDO::FETCH_NUM)) {
										$bulan      = (int) $row[0];
										$sc         = $row[1];
										$reg_amount = $row[3];
										$tf_amount  = $row[4];

										$kd_key = ca_sc_to_branch_key($sc, $cabang_name_to_kd);
										if (!isset($monthly[$kd_key])) { continue; }

										if (!isset($monthly[$kd_key]['reg_fee'][$bulan]))      { $monthly[$kd_key]['reg_fee'][$bulan] = 0; }
										if (!isset($monthly[$kd_key]['tuition_paid'][$bulan])) { $monthly[$kd_key]['tuition_paid'][$bulan] = 0; }
										$monthly[$kd_key]['reg_fee'][$bulan]      = num($monthly[$kd_key]['reg_fee'][$bulan]) + num(($reg_amount));
										$monthly[$kd_key]['tuition_paid'][$bulan] = num($monthly[$kd_key]['tuition_paid'][$bulan]) + num(($tf_amount));
									}
								}
								?>
								<table class="table table-bordered table-condensed" id="tabel_monthly">
									<thead>
										<tr style="background-color:#4472C4;color:#fff;">
											<td align=center><strong>Cabang</strong></td>
											<td align=center><strong>Metric</strong></td>
											<?php foreach ($bulan_label as $bl) { ?>
												<td align=center><strong><?php echo e($bl); ?></strong></td>
											<?php } ?>
											<td align=center><strong>TOTAL</strong></td>
										</tr>
									</thead>
									<tbody>
										<?php
										// urutan baris cabang persis seperti template excel: 12 cabang + CA di akhir
										$display_order = $cabang_report_order;
										$display_order[999] = 'CA'; // pakai key unik biar gak bentrok, valuenya cuma label

										foreach ($display_order as $kd => $nm) {
											$kd_key = ($nm == 'CA') ? 'CA' : $kd;
											$row    = $monthly[$kd_key];

											$metrics = array('Total Income', 'Reg Fee Paid', 'Tuition Paid', 'Refund', 'Total Payment', 'Outstanding', 'Jumlah Class', 'Jumlah Student');
											$first_row = true;
											foreach ($metrics as $metric) {
												$total_baris = 0;
												?>
												<tr>
													<?php if ($first_row) { ?>
														<td align=left bgcolor="#FCE4D6" rowspan="8"><strong><?php echo e($nm); ?></strong></td>
													<?php } ?>
													<td align=left><?php echo e($metric); ?></td>
													<?php
													foreach ($bulan_label as $bulan_no => $bl) {
														$income  = isset($row['total_income'][$bulan_no])  ? $row['total_income'][$bulan_no]  : 0;
														$regfee  = isset($row['reg_fee'][$bulan_no])       ? $row['reg_fee'][$bulan_no]       : 0;
														$tuition = isset($row['tuition_paid'][$bulan_no])  ? $row['tuition_paid'][$bulan_no]  : 0;
														$refund  = 0; // placeholder, belum diikutkan
														$payment = num($regfee) + num($tuition);
														$outstanding = num($income) - num($payment);
														$jml_kelas   = isset($row['kelas_set'][$bulan_no])   ? cnt($row['kelas_set'][$bulan_no])   : 0;
														$jml_student = isset($row['student_set'][$bulan_no]) ? cnt($row['student_set'][$bulan_no]) : 0;

														switch ($metric) {
															case 'Total Income':    $val = $income; break;
															case 'Reg Fee Paid':    $val = $regfee; break;
															case 'Tuition Paid':    $val = $tuition; break;
															case 'Refund':          $val = $refund; break;
															case 'Total Payment':   $val = $payment; break;
															case 'Outstanding':     $val = $outstanding; break;
															case 'Jumlah Class':    $val = $jml_kelas; break;
															case 'Jumlah Student':  $val = $jml_student; break;
															default:                $val = 0;
														}
														$total_baris = num($total_baris) + num(($val));
														if ($metric == 'Jumlah Class' || $metric == 'Jumlah Student') {
															echo '<td align=right>' . e($val) . '</td>';
														} else {
															echo '<td align=right>' . number_format(num($val), 0, ',', '.') . '</td>';
														}
													}
													if ($metric == 'Jumlah Class' || $metric == 'Jumlah Student') {
														echo '<td align=right><strong>' . e($total_baris) . '</strong></td>';
													} else {
														echo '<td align=right><strong>' . number_format(num($total_baris), 0, ',', '.') . '</strong></td>';
													}
													?>
												</tr>
												<?php
												$first_row = false;
											}
										}
										?>
									</tbody>
								</table>
								<?php
							} else {
								?>
								<p>Klik "Display" untuk menampilkan report.</p>
								<?php
							}
							?>
						</div>
					</div>
				</div>
			</div>
		</section>
	</div>
</div>
</body>
</html>
