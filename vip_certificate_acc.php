<?php
require_once __DIR__ . "/_lib/bootstrap.php"; auth_require_login(); 
include __DIR__ . "/conndb.php";
include __DIR__ . "/profiledata.php";
include __DIR__ . "/atas.php";
include __DIR__ . "/left.php";
$hari=date("d");
$bulan=date("m");
$tahun=date("Y");
$st_sign = in_val('st_sign', 'get');
if($st_sign ==''){$st_sign = '--All--';}
$hari_ini = "$tahun-$bulan-$hari";
$date_start = in_val('date_start', 'get');
$date_end = in_val('date_end', 'get');
$cd_cl = in_val('cd_cl', 'get');
$progress = in_val('progress', 'get');
$query_file = q_set($__p_query_file, "SELECT m.nama_file FROM mst_signature m");

$resource_file = db_query_soft($query_file, $__p_query_file ?? []);
if(num(db_num_rows($resource_file)) > 0)
{	
    $adattd = 1; 
}

if ($date_start ==''){$date_start = "$tahun-$bulan-01";}
if ($date_end ==''){$date_end = $hari_ini;}

$nama_lengkap = $_SESSION['nama_lengkap'];
$posisi = $_SESSION['posisi']; 
$kelompok = $_SESSION['kelompok'];
$kd_staff = $_SESSION['kd_staff'];
$flt_name = in_val('flt_name', 'get');
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>VE Student Record</title>
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="cdnjs/font-awesome.min.css">
  <link rel="stylesheet" href="../vcms/cdnjs/ionicons.min.css">
  <link rel="stylesheet" href="plugins/datatables/dataTables.bootstrap.css">
  <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
  <link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">
</head>

<form method=get action=#> 
  <div class="content-wrapper">
    <section class="content-header">
      <h1>VIP E-CERTIFICATE GENERATOR - Signed<br></h1>
      <form method=get action=vip_pt_record.php>
        <table width="453" border="0">
          <tbody>
            <tr>
              <td width="148"><small><label for="date4">Student Name</label></small></td>
              <td width="289"><span class="form-group">
                <input type="text" lang="en-150" class="form-control" placeholder="Name Search" name="flt_name" value="<?php echo e($flt_name) ?>">
              </span></td>
            </tr>
            <tr>
              <td><small>
              <label for="date3">Status</label></small></td>
              <td><span class="form-group">
                <select class="form-control" name="st_sign"   onChange="this.form.submit()" >
                  <option>--All--</option>
                  <option>Signed</option>
                  <option>To be Signed</option>

                  <option selected="selected"><?php echo e($st_sign) ?></option>
                </select>
              </span></td>
            </tr>
          </tbody>
        </table>
      </form>
    </section>

    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-body">
<div class="box box-warning">
  <div class="box-body">
    <div class="col-md-4">
      <div class="form-group">
        <label>Student List</label>
      </div>				
    </div>
<?php if ($nama_lengkap == 'lanni susanti'){?>		
    <div class="col-md-4">
      <a href="vip_agendadel.php?id=<?php echo e(u($r[14])) ?>" 
         target="popup" 
         onClick="window.open('vipcer_upload.php?kb=<?php echo e(u($kd_biodata)) ?>&kc=<?php echo e(u($kode_class)) ?>','popup','width=800,height=350,left=700px'); return false;" 
         class="btn btn-block btn-danger btn-sm" role="button">
        <i class="glyphicon glyphicon-certificate" aria-hidden="true"></i>
        <?php if(num($adattd) ==0) {?> Setting E-Sign <?php } else { ?> Modify E-Sign <?php } ?>
      </a>				
    </div>		
<?php } ?>
		
    <div class="col-md-12">
      <div class="form-group">
        <table width="100%" class="table table-bordered table-striped" id="example3">
          <thead>
            <tr>
              <td height="14" align=center>Branch</td>
              <td align=center>Student Name</td>
              <td align=center>Program - Class Code</td>
              <td colspan="6" align=center>Placement Test Score</td>
              <td colspan="6" align=center>Final Test</td>
              <td colspan="3" align=center>Attendance</td>
              <td align=center>&nbsp;</td>
            </tr>
            <tr>
              <td width=6% height="14" align=center>&nbsp;</td>
              <td width="17%" align=center>&nbsp;</td>
              <td width="17%" align=center>&nbsp;</td>
              <td width="1%" align=center>L</td>
              <td width="2%" align=center>R</td>
              <td width="2%" align=center>W</td>
              <td width="2%" align=center>Sp</td>
              <td width="2%" align=center>St</td>
              <td width="3%" align=center bgcolor="#D7D7D7">Overall</td>
              <td width="1%" align=center>L</td>
              <td width="2%" align=center>R</td>
              <td width="2%" align=center>W</td>
              <td width="2%" align=center>Sp</td>
              <td width="2%" align=center>St</td>
              <td width="2%" align=center bgcolor="#C1C1C1">Overall</td>
              <td colspan="2" align=center>Class</td>
              <td width="3%" align=center>&nbsp;</td>
              <td width="26%" align=center>Certificate</td>
            </tr>
          </thead>

<?php

// ============================================================
// STEP 1: Ambil daftar utama student (sama seperti sebelumnya)
// ============================================================
$flt_sql = $flt_name != '' ? "and nama_student like '%" . $flt_name . "%'" : "";
if ($st_sign=='--All--')
{
$query_open_class = q_set($__p_query_open_class, "\r
    SELECT a.kd_biodata, a.kode_kelas, a.nama_student, a.id, a.st_cert\r
    FROM ves_data.vip_kd_certificate a\r
    LEFT JOIN vip_billing b ON a.kd_biodata = b.kd_biodata\r
    WHERE a.st_cert = 2  " . $flt_sql . "\r
    GROUP BY a.kd_biodata, a.kode_kelas\r
    ORDER BY a.id DESC\r
    LIMIT 50\r
", [...($__p_flt_sql ?? [])]);
}
elseif ($st_sign=='Signed')
{
$query_open_class = q_set($__p_query_open_class, "\r
    SELECT a.kd_biodata, a.kode_kelas, a.nama_student, a.id, a.st_cert\r
    FROM ves_data.vip_kd_certificate a\r
    LEFT JOIN vip_billing b ON a.kd_biodata = b.kd_biodata\r
    WHERE a.st_cert = 2 and namafile <>'' " . $flt_sql . "\r
    GROUP BY a.kd_biodata, a.kode_kelas\r
    ORDER BY a.id DESC\r
    LIMIT 50\r
", [...($__p_flt_sql ?? [])]);
}
else
{
$query_open_class = q_set($__p_query_open_class, "\r
    SELECT a.kd_biodata, a.kode_kelas, a.nama_student, a.id, a.st_cert\r
    FROM ves_data.vip_kd_certificate a\r
    LEFT JOIN vip_billing b ON a.kd_biodata = b.kd_biodata\r
    WHERE a.st_cert = 2 and namafile ='' " . $flt_sql . "\r
    GROUP BY a.kd_biodata, a.kode_kelas\r
    ORDER BY a.id DESC\r
    LIMIT 50\r
", [...($__p_flt_sql ?? [])]);
}			
			
$resource_open_class = db_query_soft($query_open_class, $__p_query_open_class ?? []);

if (num(db_num_rows($resource_open_class)) > 0)
{
    // ============================================================
    // STEP 2: Kumpulkan semua kd_biodata & kode_kelas untuk batch query
    // ============================================================
    $students = array();
    while ($row = db_fetch($resource_open_class, PDO::FETCH_NUM)) {
        $students[] = array(
            'kd_biodata'  => $row[0],
            'kode_kelas'  => $row[1],
            'nama'        => $row[2],
            'id'          => $row[3],
            'st_cert'     => $row[4],
        );
    }

    // Buat list untuk IN clause (kompatibel PHP 5.4 ke bawah)
    $biodata_arr = array();
    $kelas_arr   = array();
    foreach ($students as $s) {
        $biodata_arr[] = $s['kd_biodata'];
        $kelas_arr[]   = $s['kode_kelas'];
    }
    $biodata_arr = array_unique($biodata_arr);
    $kelas_arr   = array_unique($kelas_arr);
    $biodata_list = implode("','", $biodata_arr);
    $kelas_list   = implode("','", $kelas_arr);

    // ============================================================
    // STEP 3a: Placement Test — filter kd_biodata saja, test_date terakhir
    // ============================================================
    $query_placement = q_set($__p_query_placement, "\r
        SELECT t.kd_biodata, t.L, t.other, t.S, t.R, t.W, t.total, t.test_date\r
        FROM ves_data.vip_class_score_profile t\r
        INNER JOIN (\r
            SELECT kd_biodata, MAX(test_date) AS last_date\r
            FROM ves_data.vip_class_score_profile\r
            WHERE kd_biodata IN (" . db_in(explode('\',\'', (string) $biodata_list)) . ")\r
              AND jns_test = '1'\r
            GROUP BY kd_biodata\r
        ) latest ON t.kd_biodata = latest.kd_biodata AND t.test_date = latest.last_date\r
        WHERE t.jns_test = '1'\r
    ", [...explode('\',\'', (string) $biodata_list)]);
    $res_placement = db_query_soft($query_placement, $__p_query_placement ?? []);
    $map_placement = array();
    while ($row = db_fetch($res_placement, PDO::FETCH_ASSOC)) {
        $map_placement[$row['kd_biodata']] = $row;
    }

    // ============================================================
    // STEP 3b: Final Test — filter kd_biodata + class_code, test_date terakhir
    // ============================================================
    $query_final = q_set($__p_query_final, "\r
        SELECT t.kd_biodata, t.class_code, t.L, t.other, t.S, t.R, t.W, t.total\r
        FROM ves_data.vip_class_score_profile t\r
        INNER JOIN (\r
            SELECT kd_biodata, class_code, MAX(test_date) AS last_date\r
            FROM ves_data.vip_class_score_profile\r
            WHERE kd_biodata IN (" . db_in(explode('\',\'', (string) $biodata_list)) . ")\r
\r
              AND class_code IN (" . db_in(explode('\',\'', (string) $kelas_list)) . ")\r
              AND jns_test = '3'\r
            GROUP BY kd_biodata, class_code\r
        ) latest ON t.kd_biodata = latest.kd_biodata\r
               AND t.class_code  = latest.class_code\r
               AND t.test_date   = latest.last_date\r
        WHERE t.jns_test = '3'\r
    ", [...explode('\',\'', (string) $biodata_list), ...explode('\',\'', (string) $kelas_list)]);
    $res_final = db_query_soft($query_final, $__p_query_final ?? []);
    $map_final = array();
    while ($row = db_fetch($res_final, PDO::FETCH_ASSOC)) {
        $map_final[$row['kd_biodata'] . '|' . $row['class_code']] = $row;
    }

    // ============================================================
    // STEP 4: Satu query untuk tanggal selesai kelas
    // ============================================================
    $query_last_date = q_set($__p_query_last_date, "\r
        SELECT kelas,\r
               date_format(max(mulai_tm), '%b %d, %Y') AS tgl_selesai\r
        FROM ves_data.vip_teacher_schedule\r
        WHERE kelas IN (" . db_in(explode('\',\'', (string) $kelas_list)) . ")\r
        GROUP BY kelas\r
    ", [...explode('\',\'', (string) $kelas_list)]);
    $res_last_date = db_query_soft($query_last_date, $__p_query_last_date ?? []);
    $map_last_date = array();
    while ($row = db_fetch($res_last_date, PDO::FETCH_ASSOC)) {
        $map_last_date[$row['kelas']] = $row['tgl_selesai'];
    }

    // ============================================================
    // STEP 5: Satu query untuk kehadiran per student per kelas
    // ============================================================
    $query_hadir = q_set($__p_query_hadir, "\r
        SELECT kd_biodata, kd_class,\r
               SUM(st_attendance) AS total_hadir\r
        FROM vip_attendance\r
        WHERE kd_biodata IN (" . db_in(explode('\',\'', (string) $biodata_list)) . ")\r
          AND kd_class IN (" . db_in(explode('\',\'', (string) $kelas_list)) . ")\r
        GROUP BY kd_biodata, kd_class\r
    ", [...explode('\',\'', (string) $biodata_list), ...explode('\',\'', (string) $kelas_list)]);
    $res_hadir = db_query_soft($query_hadir, $__p_query_hadir ?? []);
    $map_hadir = array();
    while ($row = db_fetch($res_hadir, PDO::FETCH_ASSOC)) {
        $map_hadir[$row['kd_biodata'] . '|' . $row['kd_class']] = $row['total_hadir'];
    }

    // ============================================================
    // STEP 6: Satu query untuk jumlah pertemuan per kelas
    // ============================================================
    $query_jml_kelas = q_set($__p_query_jml_kelas, "\r
        SELECT kelas,\r
               COUNT(DISTINCT mulai_tm) AS jml_kelas\r
        FROM ves_data.vip_teacher_schedule\r
        WHERE kelas IN (" . db_in(explode('\',\'', (string) $kelas_list)) . ")\r
          AND status_kelas = 1\r
        GROUP BY kelas\r
    ", [...explode('\',\'', (string) $kelas_list)]);
    $res_jml_kelas = db_query_soft($query_jml_kelas, $__p_query_jml_kelas ?? []);
    $map_jml_kelas = array();
    while ($row = db_fetch($res_jml_kelas, PDO::FETCH_ASSOC)) {
        $map_jml_kelas[$row['kelas']] = $row['jml_kelas'];
    }

    // ============================================================
    // STEP 7: Satu query untuk status sertifikat
    // ============================================================
    $query_cert = q_set($__p_query_cert, "\r
        SELECT kd_biodata, kode_kelas, namafile\r
        FROM vip_kd_certificate\r
        WHERE kd_biodata IN (" . db_in(explode('\',\'', (string) $biodata_list)) . ")\r
          AND kode_kelas IN (" . db_in(explode('\',\'', (string) $kelas_list)) . ")\r
    ", [...explode('\',\'', (string) $biodata_list), ...explode('\',\'', (string) $kelas_list)]);
    $res_cert = db_query_soft($query_cert, $__p_query_cert ?? []);
    $map_cert = array();
    while ($row = db_fetch($res_cert, PDO::FETCH_ASSOC)) {
        $key = $row['kd_biodata'] . '|' . $row['kode_kelas'];
        $map_cert[$key] = $row['namafile'];
    }

    // ============================================================
    // STEP 8: Render tabel — tidak ada query di sini lagi
    // ============================================================
    echo "<tbody>";
    foreach ($students as $s) {
        $kd_biodata  = $s['kd_biodata'];
        $kode_class  = $s['kode_kelas'];
        $idcert      = $s['id'];
        $st_cert     = $s['st_cert'];
        $nama_student = $s['nama'];
        $key         = $kd_biodata . '|' . $kode_class;

        // Placement Test — key by kd_biodata saja
        $pt = isset($map_placement[$kd_biodata]) ? $map_placement[$kd_biodata] : array();
        $l   = isset($pt['L'])     ? $pt['L']     : '';
        $r   = isset($pt['R'])     ? $pt['R']     : '';
        $w   = isset($pt['W'])     ? $pt['W']     : '';
        $sp  = isset($pt['S'])     ? $pt['S']     : '';
        $st  = isset($pt['other']) ? $pt['other'] : '';
        $ttl = isset($pt['total']) ? $pt['total'] : '';

        // Final Test — key by kd_biodata|kode_kelas
        $fn = isset($map_final[$key]) ? $map_final[$key] : array();
        $l_final   = isset($fn['L'])     ? $fn['L']     : '';
        $r_final   = isset($fn['R'])     ? $fn['R']     : '';
        $w_final   = isset($fn['W'])     ? $fn['W']     : '';
        $sp_final  = isset($fn['S'])     ? $fn['S']     : '';
        $st_final  = isset($fn['other']) ? $fn['other'] : '';
        $ttl_final = isset($fn['total']) ? $fn['total'] : '';

        // Kehadiran
        $kehadiran = isset($map_hadir[$key])           ? $map_hadir[$key]           : 0;
        $jml_kelas = isset($map_jml_kelas[$kode_class])? $map_jml_kelas[$kode_class]: 0;
        $presen_hadir = num($jml_kelas) > 0 ? num((div($kehadiran, $jml_kelas))) * 100 : 0;

        // Status sertifikat
        if (isset($map_cert[$key])) {
            $signed = ($map_cert[$key] != '') ? 2 : 1;
        } else {
            $signed = 0;
        }
?>
        <tr>
          <td height="14" align=center class="style24">&nbsp;</td>
          <td align=left class="style24"><?php echo e($nama_student) ?></td>
          <td align=left class="style24"><?php echo e($kode_class) ?><br></td>
          <td align=center class="style24"><?php echo e($l) ?></td>
          <td align=center class="style24"><?php echo e($r) ?></td>
          <td align=center class="style24"><?php echo e($w) ?></td>
          <td align=center class="style24"><?php echo e($sp) ?></td>
          <td align=center class="style24"><?php echo e($st) ?></td>
          <td align=center bgcolor="#D7D7D7" class="style24"><?php echo e($ttl) ?></td>
          <td align=center class="style24"><?php echo e($l_final) ?></td>
          <td align=center class="style24"><?php echo e($r_final) ?></td>
          <td align=center class="style24"><?php echo e($w_final) ?></td>
          <td align=center class="style24"><?php echo e($sp_final) ?></td>
          <td align=center class="style24"><?php echo e($st_final) ?></td>
          <td align=center bgcolor="#C1C1C1" class="style24"><?php echo e($ttl_final) ?></td>
          <td width="4%" align=center class="style24"><?php echo e($kehadiran) ?>/<?php echo e($jml_kelas) ?></td>
          <td width="4%" align=center class="style24"><?php echo round(num($presen_hadir), 2) ?> %</td>
          <td align=center class="style24">&nbsp;</td>
          <td align=center class="style24">
            <?php if (num($st_cert) == 2 && num($signed) != 2) { ?>
              <a href="#" target="popup"
                 onClick="window.open('vipcer_create.php?id=<?php echo e(u($idcert)) ?>','popup','width=800,height=350,left=700px'); return false;"
                 class="btn btn-block btn-success btn-sm" role="button">
                <i class="glyphicon glyphicon-certificate" aria-hidden="true"></i>To be Signed
              </a>
            <?php } elseif (num($st_cert) == 2 && num($signed) == 2) { ?>
              <a href="#" target="popup"
                 onClick="window.open('ecert/ecertbimvista2022.php?kdb=<?php echo e(u($kd_biodata)) ?>&kc=<?php echo e(u($kode_class)) ?>','blank'); return false;"
                 class="btn btn-block btn-success btn-sm" role="button">
                <i class="glyphicon glyphicon-certificate" aria-hidden="true"></i>View
              </a>
            <?php } ?>
          </td>
        </tr>
<?php
    } // end foreach
    echo "</tbody>";
} // end if num_rows
?>

          <tfoot></tfoot>
        </table>
      </div>
    </div>
  </div>
</div>
          </div>
        </div>
      </div>
    </section>
  </div>
</form>

<aside class="control-sidebar control-sidebar-dark">
  <ul class="nav nav-tabs nav-justified control-sidebar-tabs">
    <li><a href="#control-sidebar-home-tab" data-toggle="tab"><i class="fa fa-home"></i></a></li>
    <li><a href="#control-sidebar-settings-tab" data-toggle="tab"><i class="fa fa-gears"></i></a></li>
  </ul>
</aside>

<script src="plugins/jQuery/jquery-2.2.3.min.js"></script>
<script src="bootstrap/js/bootstrap.min.js"></script>
<script src="plugins/datatables/jquery.dataTables.min.js"></script>
<script src="plugins/datatables/dataTables.bootstrap.min.js"></script>
<script src="plugins/slimScroll/jquery.slimscroll.min.js"></script>
<script src="plugins/fastclick/fastclick.js"></script>
<script src="dist/js/app.min.js"></script>
<script src="dist/js/demo.js"></script>
<script>
  $(function () {
    $("#example1").DataTable();
    $('#example2').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false
    });
  });
</script>
</body>
</html>
<?php 
if (isset($_GET['Export'])) 
{
    echo "<script type=\"text/javascript\">\n";
    echo "window.location=('vip_student_recordxl.php?cd_cl=" . e(u($cd_cl)) . "&progress=" . e(u($progress)) . "&ds=" . e(u($date_start)) . "&de=" . e(u($date_end)) . "');\n";				
    echo "</script>";
}
?>