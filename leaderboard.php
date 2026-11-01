<?php
include __DIR__ . "/conndb.php";
include __DIR__ . "/profiledata.php";
include __DIR__ . "/atas.php";
include __DIR__ . "/left.php";

$hari=date("d");
$bulan=date("m");
$tahun=date("Y");
$hari_ini = "$tahun-$bulan-$hari";
$date_start = in_date('date_start', '2026-01-01', 'get');
$date_end = in_date('date_end', $hari_ini, 'get');

$nama_lengkap = $_SESSION['nama_lengkap'];
$posisi = $_SESSION['posisi'];
$kd_staff = $_SESSION['kd_staff'] ;
// Filter cabang ($_GET['kd_cbg'], $filter_cbg_*) dan thn_period di versi lama
// tidak pernah dipakai di query, jadi tidak dibawa.

// ==== Mapping label & warna badge cabang, disesuaikan dengan tampilan di gambar ====
function get_branch_style($kd)
{
	switch ($kd) {
		case 1:  return array('label' => 'ESB',           'color' => '#0d2350'); // East Sby - navy
		case 2:  return array('label' => 'WSB',           'color' => '#2f80c9'); // West Sby - blue
		case 3:  return array('label' => 'Denpasar',      'color' => '#1e7a44'); // hijau
		case 4:  return array('label' => 'South Jakarta', 'color' => '#d9534f'); // merah
		case 5:  return array('label' => 'North Jakarta', 'color' => '#e08a2c'); // oranye
		case 6:  return array('label' => 'West Jakarta',  'color' => '#159a89'); // teal
		case 7:  return array('label' => 'Bandung',       'color' => '#7b3fa0'); // ungu
		case 8:  return array('label' => 'Malang',        'color' => '#d94f8c'); // pink
		case 11: return array('label' => 'PIK',           'color' => '#6c757d');
		case 12: return array('label' => 'Serpong',       'color' => '#6c757d');
		case 14: return array('label' => 'Medan',         'color' => '#6c757d');
		case 0:  return array('label' => 'HO',            'color' => '#6c757d');
		default: return array('label' => '-',             'color' => '#6c757d');
	}
}
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Leader Board</title>
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="cdnjs/font-awesome.min.css">
  <link rel="stylesheet" href="../vcms/cdnjs/ionicons.min.css">
  <link rel="stylesheet" href="plugins/datatables/dataTables.bootstrap.css">
  <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
  <link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">

  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <style>
    .leaderboard-wrap{
      border-radius:14px;
      overflow:hidden;
      box-shadow:0 2px 10px rgba(0,0,0,0.15);
      background:#fff;
    }
    table.leaderboard{
      width:100%;
      border-collapse:collapse;
      font-family:Arial, Helvetica, sans-serif;
    }
    table.leaderboard thead th{
      background:#0d2350;
      color:#ffffff;
      text-transform:uppercase;
      font-size:14px;
      padding:14px 16px;
      text-align:left;
      border:none;
    }
    table.leaderboard thead th.col-achievement{
      background:#d4a13d;
      color:#0d2350;
      text-align:left;
    }
    table.leaderboard tbody td{
      padding:12px 16px;
      font-size:15px;
      vertical-align:middle;
      border-bottom:1px solid #eee;
    }
    table.leaderboard tbody tr:nth-child(odd){ background:#ffffff; }
    table.leaderboard tbody tr:nth-child(even){ background:#fbf3e2; }

    .rank-num{ font-weight:bold; font-size:16px; }
    .medal{
      display:inline-flex;
      align-items:center;
      justify-content:center;
      width:26px;height:26px;
      border-radius:50%;
      color:#fff;
      font-weight:bold;
      font-size:13px;
    }
    .medal-gold{ background:#f2c14e; color:#5c4300; }
    .medal-silver{ background:#c9c9c9; color:#3d3d3d; }
    .medal-bronze{ background:#d98b4a; color:#4a2b0e; }

    .branch-badge{
      display:inline-block;
      padding:4px 14px;
      border-radius:14px;
      color:#fff;
      font-size:13px;
      font-weight:600;
      white-space:nowrap;
    }
    .achievement-val{ font-weight:600; color:#111; }
  </style>
</head>

 <form method="get" action="leaderboard.php">
  <div class="content-wrapper">
    <section class="content">

<section class="content-header">
  <h1><i class="fa fa-trophy"></i></h1>
  <table width="527" border="0">
    <tbody>
      <tr>
        <td width="149"><label for="date2"> Open Class Period </label></td>
        <td width="368">
          <input type="date" name="date_start" id="date2" value="<?php echo e($date_start); ?>" onChange="this.form.submit()">
          To
          <input type="date" name="date_end" id="date2" value="<?php echo e($date_end); ?>" onChange="this.form.submit()">
        </td>
      </tr>
    </tbody>
  </table>
  <br>
  <h1>VIP Leaderboard Sales <small>Achievement</small></h1>
</section>

<section class="content">



  <br>

  <!-- MAIN CONTENT -->
  <div class="row">

    <!-- LEADERBOARD TABLE (sesuai gambar) -->
    <div class="col-md-8">
      <div class="leaderboard-wrap">
        <table class="leaderboard">
          <thead>
            <tr>
              <th style="width:70px;">Rank</th>
              <th>Name</th>
              <th style="width:150px;">Branch</th>
              <th class="col-achievement">Achievement</th>
            </tr>
          </thead>
          <tbody>
<?php 
$total_amount = 0;
$top_sc = '';

//$query_sc = "select b.sc, b.kd_branch, sum(a.amount) as ttl from vip_billing_payment a
//left join vip_billing b on a.kd_biodata = b.kd_biodata and a.kd_billing = b.kd_billing
//where dt_payment between '$date_start' and '$date_end' and status = 'PAID' and (jns_payment <> 'Registration') and b.kd_program not like 'CA%'
//group by b.sc, b.kd_branch order by ttl desc";	

			  
$query_sc = "SELECT
    g.sc AS nama,
    g.kd_branch AS branch,
    MIN(f.min_mulai) AS tanggal_mulai,
    SUM(g.net_tf) AS total_payment
FROM ves_data.vip_billing g
INNER JOIN (
    SELECT kelas, MIN(mulai_tm) AS min_mulai
    FROM vip_teacher_schedule
    WHERE status_kelas = 1
    GROUP BY kelas
) f ON g.kd_class = f.kelas
WHERE f.min_mulai BETWEEN ? and ? and g.kd_program not like 'CA%'
GROUP BY g.sc, g.kd_branch
ORDER BY total_payment DESC";

$rows_sc = db_all($query_sc, [$date_start, $date_end], PDO::FETCH_NUM);
$jml_sc = count($rows_sc);

if ($jml_sc > 0) {
	$nomor = 1;
	foreach ($rows_sc as $row_sc) {

		$nama_sc   = $row_sc[0];
		$kd_branch = $row_sc[1];
		$amount    = $row_sc[3];

		if ($nomor == 1) { $top_sc = $nama_sc; }

		$branch = get_branch_style($kd_branch);

		// Badge / angka rank -> pakai gambar badge untuk rank 1-3
		if ($nomor == 1) {
			$rank_html = '<img src="imgs/badge_1_gold.png" alt="Rank 1" style="width:36px;height:auto;">';
		} elseif ($nomor == 2) {
			$rank_html = '<img src="imgs/badge_2_silver.png" alt="Rank 2" style="width:36px;height:auto;">';
		} elseif ($nomor == 3) {
			$rank_html = '<img src="imgs/badge_3_bronze.png" alt="Rank 3" style="width:36px;height:auto;">';
		} else {
			$rank_html = '<span class="rank-num">'.$nomor.'</span>';
		}
?>
            <tr>
              <td><?php echo $rank_html; ?></td>
              <td><?php echo e($nama_sc); ?></td>
              <td><span class="branch-badge" style="background:<?php echo e($branch['color']); ?>;"><?php echo e($branch['label']); ?></span></td>
              <td class="achievement-val">Rp<?php echo number_format((float) $amount,0,".",","); ?></td>
            </tr>
<?php
		$total_amount += (float) $amount;
		$nomor++;
	}
} else {
?>
            <tr><td colspan="4" class="text-center">Tidak ada data pembayaran pada periode ini.</td></tr>
<?php } ?>
          </tbody>
        </table>
      </div>
    </div>

    <!-- SIDEBAR -->
    <div class="col-md-4">

      <div class="box box-primary">
        <div class="box-header">
          <h3 class="box-title">Statistik</h3>
        </div>
        <div class="box-body">
          <p><b>Total Income :</b><br>Rp<?php echo number_format($total_amount,0,".",","); ?></p>
          <p><b>Sales Aktif:</b><br><?php echo $jml_sc; ?></p>
          <p><b>Average:</b><br>Rp<?php echo ($jml_sc > 0) ? number_format(($total_amount/$jml_sc),0,".",",") : 0; ?></p>
        </div>
      </div>

      <div class="box box-success">
        <div class="box-header">
          <h3 class="box-title">Top Achievement</h3>
        </div>
        <div class="box-body text-center">
          <h2><i class="fa fa-trophy text-yellow"></i> #1</h2>
          <img src="https://i.pravatar.cc/80?img=2" class="img-circle" />
          <h3><b><?php echo e($top_sc); ?></b></h3>
        </div>
      </div>

    </div>

  </div>

</section>
    </section>
  </div>
 </form>

  <div class="control-sidebar-bg"></div>

<script src="plugins/jQuery/jquery-2.2.3.min.js"></script>
<script src="bootstrap/js/bootstrap.min.js"></script>
<script src="plugins/datatables/jquery.dataTables.min.js"></script>
<script src="plugins/datatables/dataTables.bootstrap.min.js"></script>
<script src="plugins/slimScroll/jquery.slimscroll.min.js"></script>
<script src="plugins/fastclick/fastclick.js"></script>
<script src="dist/js/app.min.js"></script>
<script src="dist/js/demo.js"></script>
</body>
</html>
