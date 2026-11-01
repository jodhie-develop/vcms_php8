<?php
require_once __DIR__ . "/_lib/bootstrap.php"; csrf_guard_get(); auth_require_login();

include __DIR__ . "/conndb.php";
include __DIR__ . "/profiledata.php";
 
$today = date("Y-m-d");
 
// ---------------------------------------------------------------------
// Request params
// ---------------------------------------------------------------------
$kdb          = in_val('kdb', 'any');
$ins          = in_val('ins', 'any');
$nub          = in_val('nub', 'any');
$upd          = in_val('upd', 'any');
$weak_l       = in_val('weak_l', 'any');
$weak_s       = in_val('weak_s', 'any');
$weak_r       = in_val('weak_r', 'any');
$weak_w       = in_val('weak_w', 'any');
$risk 		  = in_val('risk', 'any'); 
$target_score = in_val('target_score', 'any');
 
// ---------------------------------------------------------------------
// Helpers
// ---------------------------------------------------------------------
 
// Look up a student's display name from either of the two possible source tables.
function getStudentName($kdb)
{
    $q = q_set($__p_q, "SELECT nama_lengkap FROM ves_data.vip_student_data WHERE kd_biodata = ? ", [(string) ($kdb)]);
    $res = db_query_soft($q, $__p_q ?? []);
    if ($res && num(db_num_rows($res)) > 0) {
        $row = db_fetch($res, PDO::FETCH_NUM);
        return $row[0];
    }
 
    $q = q_set($__p_q, "SELECT concat_ws(' ', nama, middle_name, family_name) FROM ves_inc.tb_biodata WHERE kd_biodata = ? ", [(string) ($kdb)]);
    $res = db_query_soft($q, $__p_q ?? []);
    if ($res && num(db_num_rows($res)) > 0) {
        $row = db_fetch($res, PDO::FETCH_NUM);
        return $row[0];
    }
 
    return '';
}
 
// Look up a recommendation program's name by id.
function getRecommName($id)
{
    if ($id === '' || $id === null) {
        return '';
    }
    $q = q_set($__p_q, "SELECT prg_recomm FROM ves_data.vip_recomm_list WHERE id = ? ", [(string) (intval($id))]);
    $res = db_query_soft($q, $__p_q ?? []);
    if ($res && num(db_num_rows($res)) > 0) {
        $row = db_fetch($res, PDO::FETCH_NUM);
        return $row[0];
    }
    return '';
}
 
// Build <option> markup for a skill-weakness dropdown, correctly marking
// the previously chosen value as selected.
function renderWeaknessOptions($skill, $selected)
{
    $q = q_set($__p_q, "SELECT weakness FROM ves_data.vip_mst_skill_weakness WHERE skill = ? ", [(string) ($skill)]);
    $res = db_query_or_die('error_loading_weakness_list', $q, $__p_q ?? []);
    $html = '<option value="">-- Pilih --</option>';
    while ($row = db_fetch($res, PDO::FETCH_NUM)) {
        $sel   = ($row[0] == $selected) ? 'selected' : '';
        $html .= '<option value="' . htmlspecialchars($row[0]) . '" ' . e($sel) . '>' . htmlspecialchars($row[0]) . '</option>';
    }
    return $html;
}
 
// Build <option> markup for a recommendation-program dropdown, excluding
// ids already picked in earlier boxes and marking the current selection.
function renderRecommOptions($excludeIds, $selected)
{
    $where = '';
    foreach ($excludeIds as $id) {
        if ($id !== '' && $id !== null) {
            $where .= q_add($__p_where, " AND id <> ? ", [(string) (intval($id))]);
        }
    }
    $q = q_set($__p_q, "SELECT id, prg_recomm FROM ves_data.vip_recomm_list WHERE 1=1 " . $where, [...($__p_where ?? [])]);
    $res = db_query_or_die('error_loading_recomm_list', $q, $__p_q ?? []);
    $html = '<option value="">-- Pilih Program --</option>';
    while ($row = db_fetch($res, PDO::FETCH_NUM)) {
        $sel   = ($row[0] == $selected) ? 'selected' : '';
        $html .= '<option value="' . e($row[0]) . '" ' . e($sel) . '>' . htmlspecialchars($row[1]) . '</option>';
    }
    return $html;
}
 
// ---------------------------------------------------------------------
// Load student name
// ---------------------------------------------------------------------
$nama_lengkap_student = getStudentName($kdb);
 
// ---------------------------------------------------------------------
// Load score/recommendation data, either from the database (edit mode,
// upd=1) or from the current GET request (a select was just changed).
// ---------------------------------------------------------------------
$kd_recom = array('', '', '', '', ''); // kd_prg_recom_1 .. 5
 
if (num($upd) == 1) {
    $q = q_set($__p_q, "SELECT L,S,R,W,other,total,remark,test_date,prg_type,\r
                 prg_recom,prg_recom_2,prg_recom_3,prg_recom_4,prg_recom_5,durasi,weak_l,weak_s,weak_r,weak_w,risk          FROM ves_data.vip_class_score_profile\r
          WHERE no = ? ", [(string) (intval($nub))]);
    $res = db_query_soft($q, $__p_q ?? []);
    $row = $res ? db_fetch($res, PDO::FETCH_NUM) : null;
 
    if ($row) {
        $tgl_testing = $row[7];
        $prg_type    = $row[8];
        $l           = $row[0]; // Listening / Grammar & Vocabulary
        $sp          = $row[1]; // Speaking
        $r           = $row[2]; // Reading
        $w           = $row[3]; // Writing
        $st          = $row[4]; // Structure (stored in "other")
        $ttl         = $row[5];
        $note_score  = $row[6];
        $duration    = $row[14];
		$weak_l = $row[15];
		$weak_s = $row[16];
		$weak_r = $row[17];
		$weak_w = $row[18];
		$risk   = $row[19];
        $kd_recom    = array($row[9], $row[10], $row[11], $row[12], $row[13]);
    }
} else {
    $tgl_testing = in_val('tgl_testing', 'any') != '' ? in_val('tgl_testing', 'any') : $today;
    $prg_type    = in_val('prg_type', 'any');
    $l           = in_val('l', 'any');
    $st          = in_val('st', 'any');
    $sp          = in_val('sp', 'any');
    $r           = in_val('r', 'any');
    $w           = in_val('w', 'any');
    $ttl         = in_val('ttl', 'any');
    $sat_eng     = in_val('sat_eng', 'any');
    $sat_math    = in_val('sat_math', 'any');
    $note_score  = in_val('note_score', 'any');
    $duration    = in_val('duration', 'any');
	$weak_l 	= in_val('weak_l', 'any');
	$weak_s 	=  in_val('weak_s', 'any');
	$weak_r 	=  in_val('weak_r', 'any');
	$weak_w 	=  in_val('weak_w', 'any');
	$risk   	=  in_val('risk', 'any');
 
    for ($i = 1; num($i) <= 5; $i++) {
        $visible = $_GET['prg_recom_' . $i];
        $hidden  = $_GET['kd_prg_recom_' . $i];
        $kd_recom[num($i) - 1] = ($visible !== '' && $visible !== null) ? $visible : $hidden;
    }
}
 
// Resolve display names for whatever recommendation ids are currently set.
$recom_names = array();
foreach ($kd_recom as $id) {
    $recom_names[] = getRecommName($id);
}
 
// ---------------------------------------------------------------------
// Save (triggered by the "Save Score" button)
// ---------------------------------------------------------------------
if (($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['save_score']))) {
    $ins         = in_val('ins', 'any');
    $skr         = date("Y-m-d H:i:s");
    $tgl_testing = in_val('tgl_testing', 'any');
    $prg_type    = in_val('prg_type', 'any');
    $l           = in_val('l', 'any');
    $st          = in_val('st', 'any');
    $sp          = in_val('sp', 'any');
    $r           = in_val('r', 'any');
    $w           = in_val('w', 'any');
    $other       = in_val('other', 'any');
    $ttl         = in_val('ttl', 'any');
    $target_score = in_val('target_score', 'any') != '' ? in_val('target_score', 'any') : 0;
    $duration    = in_val('duration', 'any');
	$weak_l 	= in_val('weak_l', 'any');
	$weak_s 	=  in_val('weak_s', 'any');
	$weak_r 	=  in_val('weak_r', 'any');
	$weak_w 	=  in_val('weak_w', 'any');
	$risk   	=  in_val('risk', 'any');	
    $note_score  = in_val('note_score', 'any');
    $sat_eng     = in_val('sat_eng', 'any');
    $sat_math    = in_val('sat_math', 'any');
    $nub         = in_val('nub', 'any');
    $nama_lengkap_student = in_val('nama_lengkap_student', 'any');
    $kdb         = in_val('kdb', 'any');
    $nama_lengkap = $_SESSION['nama_lengkap'];
    $kd_branch    = $_SESSION['kd_branch'];
 
    // Program-recommendation ids, treating placeholder id 41 ("none") as empty.
    $save_recom = array();
    for ($i = 1; num($i) <= 5; $i++) {
        $val = $_GET['kd_prg_recom_' . $i];
        $save_recom[$i] = (num($val) == 41) ? '' : $val;
    }
 
    if ($nub == '') {
        if ($prg_type == 'SAT') {
            $query_simpan_score_class = q_set($__p_query_simpan_score_class, "INSERT INTO ves_data.vip_class_score_profile\r
                (kd_biodata,target_score,jns_test,total,remark,test_date,dt_entry,pic,\r
                 prg_type,prg_recom,prg_recom_2,prg_recom_3,prg_recom_4,prg_recom_5,durasi,english,math)\r
                VALUES (? ,? ,'1',? ,? ,? ,? ,? ,\r
                 ? ,? ,? ,? ,? ,? ,? ,\r
                 ? ,? )", [(string) ($kdb), (string) ($target_score), (string) ($ttl), (string) ($note_score), (string) ($tgl_testing), (string) ($skr), (string) ($nama_lengkap), (string) ($prg_type), (string) ($save_recom[1]), (string) ($save_recom[2]), (string) ($save_recom[3]), (string) ($save_recom[4]), (string) ($save_recom[5]), (string) ($duration), (string) ($sat_eng), (string) ($sat_math)]);
        } else {
            $query_simpan_score_class = q_set($__p_query_simpan_score_class, "INSERT INTO ves_data.vip_class_score_profile\r
                (kd_biodata,target_score,jns_test,L,S,R,W,other,total,remark,test_date,dt_entry,pic,\r
                 prg_type,prg_recom,prg_recom_2,prg_recom_3,prg_recom_4,prg_recom_5,durasi,weak_l, weak_s, weak_r, weak_w,risk)\r
                VALUES (? ,? ,'1',? ,? ,? ,? ,? ,? ,? ,? ,? ,? ,\r
                 ? ,? ,? ,? ,? ,? ,? ,? ,? ,? ,? ,? )", [(string) ($kdb), (string) ($target_score), (string) ($l), (string) ($sp), (string) ($r), (string) ($w), (string) ($st), (string) ($ttl), (string) ($note_score), (string) ($tgl_testing), (string) ($skr), (string) ($nama_lengkap), (string) ($prg_type), (string) ($save_recom[1]), (string) ($save_recom[2]), (string) ($save_recom[3]), (string) ($save_recom[4]), (string) ($save_recom[5]), (string) ($duration), (string) ($weak_l), (string) ($weak_s), (string) ($weak_r), (string) ($weak_w), (string) ($risk)]);
        }
        db_query_or_die('error_saving_new_record', $query_simpan_score_class, $__p_query_simpan_score_class ?? []);
    } else {
        if ($prg_type != 'SAT') {
            $query_simpan_score_class = q_set($__p_query_simpan_score_class, "UPDATE ves_data.vip_class_score_profile SET\r
                jns_test='1', L=? , S=? , R=? , W=? , other=? , total=? ,\r
                remark=? , test_date=? , dt_entry=? , pic=? ,\r
                prg_type=? , prg_recom=? , prg_recom_2=? ,\r
                prg_recom_3=? , prg_recom_4=? , prg_recom_5=? ,\r
                durasi=? ,weak_l = ? , weak_s = ? , weak_r = ? , weak_w = ? ,risk = ?\r
                WHERE no = ? ", [(string) ($l), (string) ($sp), (string) ($r), (string) ($w), (string) ($st), (string) ($ttl), (string) ($note_score), (string) ($tgl_testing), (string) ($skr), (string) ($nama_lengkap), (string) ($prg_type), (string) ($save_recom[1]), (string) ($save_recom[2]), (string) ($save_recom[3]), (string) ($save_recom[4]), (string) ($save_recom[5]), (string) ($duration), (string) ($weak_l), (string) ($weak_s), (string) ($weak_r), (string) ($weak_w), (string) ($risk), (string) ($nub)]);
        } else {
            $query_simpan_score_class = q_set($__p_query_simpan_score_class, "UPDATE ves_data.vip_class_score_profile SET\r
                jns_test='1', total=? , remark=? , test_date=? , dt_entry=? ,\r
                pic=? , prg_type=? , prg_recom=? , prg_recom_2=? ,\r
                prg_recom_3=? , prg_recom_4=? , prg_recom_5=? ,\r
                durasi=? , english=? , math=?\r
                WHERE no = ? ", [(string) ($ttl), (string) ($note_score), (string) ($tgl_testing), (string) ($skr), (string) ($nama_lengkap), (string) ($prg_type), (string) ($save_recom[1]), (string) ($save_recom[2]), (string) ($save_recom[3]), (string) ($save_recom[4]), (string) ($save_recom[5]), (string) ($duration), (string) ($sat_eng), (string) ($sat_math), (string) ($nub)]);
        }
        db_query_or_die('error_saving_update', $query_simpan_score_class, $__p_query_simpan_score_class ?? []);
    }
 
    echo "<script type=\"text/javascript\">\n";
    echo "window.opener.location.reload(true);\n";
    echo "window.close();\n";
    echo "</script>";
    die;
}
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Update Program Test</title>
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
 
  <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="css/font-awesome/css/font-awesome.css">
  <link rel="stylesheet" href="css/ionicons/css/ionicons.min.css">
  <link rel="stylesheet" href="plugins/datatables/dataTables.bootstrap.css">
  <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
 
  <style>
    body { background: #f4f6f9; }
    .pt-form-wrap { max-width: 1000px; margin: 0 auto; padding: 18px 20px 6px; }
    .pt-header {
      display: flex; align-items: center; justify-content: space-between;
      padding: 14px 18px; margin-bottom: 18px;
      background: linear-gradient(135deg,#3c8dbc,#367fa9);
      border-radius: 6px; color: #fff;
    }
    .pt-header h3 { margin: 0; font-weight: 600; }
    .pt-header small { opacity: .85; }
    .pt-section {
      background: #fff; border-radius: 6px; margin-bottom: 18px;
      box-shadow: 0 1px 3px rgba(0,0,0,.08); overflow: hidden;
    }
    .pt-section-title {
      padding: 10px 16px; font-weight: 600; font-size: 14px; color: #444;
      background: #f8f9fb; border-bottom: 1px solid #eceff3;
    }
    .pt-section-title i { color: #3c8dbc; margin-right: 6px; }
    .pt-section-body { padding: 16px 18px 4px; }
    .form-group label { font-weight: 600; color: #555; font-size: 12.5px; margin-bottom: 4px; }
    .form-control { border-radius: 4px; box-shadow: none; }
    .form-control:focus { border-color: #3c8dbc; box-shadow: 0 0 0 2px rgba(60,141,188,.15); }
    .pt-weakness-select { max-width: 220px; }
    .pt-footer {
      display: flex; justify-content: flex-end; gap: 8px;
      padding: 14px 18px; background: #fff; border-radius: 6px;
      box-shadow: 0 1px 3px rgba(0,0,0,.08); margin-bottom: 24px;
    }
  </style>
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">
  <form name="form1" action="#" enctype="multipart/form-data" class="pt-form-wrap" method="post"><?php echo csrf_field(); ?>

 
    <input type="hidden" name="n_urut" value="<?php echo e($n_urut) ?>">
    <input type="hidden" name="ins" value="<?php echo e($ins) ?>">
    <input type="hidden" name="kdb" value="<?php echo e($kdb) ?>">
    <input type="hidden" name="nub" value="<?php echo e($nub) ?>">
    <input type="hidden" name="nama_lengkap_student" value="<?php echo htmlspecialchars($nama_lengkap_student) ?>">
 
    <div class="pt-header">
      <div>
        <h3><?php echo htmlspecialchars($nama_lengkap_student) ?></h3>
        <small>Placement Test Record</small>
      </div>
      <i class="fa fa-graduation-cap fa-2x" style="opacity:.5"></i>
    </div>
 
    <!-- ============ Test Info ============ -->
    <div class="pt-section">
      <div class="pt-section-title"><i class="fa fa-calendar"></i> Test Information</div>
      <div class="pt-section-body">
        <div class="row">
          <div class="col-xs-4">
            <div class="form-group">
              <label>Test Date</label>
              <input type="date" class="form-control" name="tgl_testing" value="<?php echo e($tgl_testing) ?>">
            </div>
          </div>
          <div class="col-xs-4">
            <div class="form-group">
              <label>Test Type</label>
              <select class="form-control" name="prg_type" onChange="this.form.submit()">
                <?php
                $test_types = array('IELTS', 'TOEFL IBT', 'TOEFL PBT', 'TOEIC', 'VIP Signature Test', 'SAT');
                foreach ($test_types as $t) {
                    echo '<option' . e(($t == $prg_type ? ' selected' : '')) . '>' . e($t) . '</option>';
                }
                // Preserve the raw value even if it doesn't match the fixed list above.
                if ($prg_type != '' && !in_array($prg_type, $test_types)) {
                    echo '<option selected>' . htmlspecialchars($prg_type) . '</option>';
                }
                ?>
              </select>
            </div>
          </div>
          <?php if (num($ins) == 1) { ?>
          <div class="col-xs-4">
            <div class="form-group">
              <label>Score Target</label>
              <input type="text" class="form-control" name="target_score" value="<?php echo e($target_score) ?>">
            </div>
          </div>
          <?php } ?>
        </div>
      </div>
    </div>
 
    <!-- ============ Scores & Weaknesses ============ -->
    <div class="pt-section">
      <div class="pt-section-title"><i class="fa fa-bar-chart"></i>Score</div>
      <div class="pt-section-body">
 
        <?php if ($prg_type == 'SAT') { ?>
        <div class="row">
          <div class="col-xs-3">
            <div class="form-group">
              <label>English</label>
              <input type="text" class="form-control" name="sat_eng" value="<?php echo e($sat_eng) ?>">
            </div>
          </div>
          <div class="col-xs-3">
            <div class="form-group">
              <label>Math</label>
              <input type="text" class="form-control" name="sat_math" value="<?php echo e($sat_math) ?>">
            </div>
          </div>
        </div>
 
        <?php } elseif ($prg_type == 'VIP Signature Test') { ?>
        <div class="row">
          <div class="col-xs-3">
            <div class="form-group">
              <label>Grammar &amp; Vocabulary</label>
              <input type="text" class="form-control" name="l" value="<?php echo e($l) ?>">
            </div>
          </div>
          <div class="col-xs-3">
            <div class="form-group">
              <label>Speaking</label>
              <input type="text" class="form-control" name="sp" value="<?php echo e($sp) ?>">
            </div>
          </div>
        </div>
 
        <?php } else { ?>
        <div class="row">
          <div class="col-xs-2">
            <div class="form-group">
              <label>Listening</label>
              <input type="text" class="form-control" name="l" value="<?php echo e($l) ?>">
            </div>
          </div>
          <div class="col-xs-4">
            <div class="form-group">
              <label>Listening Weakness</label>
              <select class="form-control select2 pt-weakness-select" name="weak_l">
                <?php echo e(renderWeaknessOptions('Listening', $weak_l)) ?>
              </select>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-xs-3">
            <div class="form-group">
              <label>Structure</label>
              <input type="text" class="form-control" name="st" value="<?php echo e($st) ?>">
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-xs-2">
            <div class="form-group">
              <label>Speaking</label>
              <input type="text" class="form-control" name="sp" value="<?php echo e($sp) ?>">
            </div>
          </div>
          <div class="col-xs-4">
            <div class="form-group">
              <label>Speaking Weakness</label>
              <select class="form-control select2 pt-weakness-select" name="weak_s">
                <?php echo e(renderWeaknessOptions('Speaking', $weak_s)) ?>
              </select>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-xs-2">
            <div class="form-group">
              <label>Reading</label>
              <input type="text" class="form-control" name="r" value="<?php echo e($r) ?>">
            </div>
          </div>
          <div class="col-xs-3">
            <div class="form-group">
              <label>Reading Weakness</label>
              <select class="form-control select2 pt-weakness-select" name="weak_r">
                <?php echo e(renderWeaknessOptions('Reading', $weak_r)) ?>
              </select>
            </div>
          </div>
          <div class="col-xs-2">
            <div class="form-group">
              <label>Writing</label>
              <input type="text" class="form-control" name="w" value="<?php echo e($w) ?>">
            </div>
          </div>
          <div class="col-xs-3">
            <div class="form-group">
              <label>Writing Weakness</label>
              <select class="form-control select2 pt-weakness-select" name="weak_w">
                <?php echo e(renderWeaknessOptions('Writing', $weak_w)) ?>
              </select>
            </div>
          </div>
        </div>
        <?php } ?>
 
        <div class="row">
          <div class="col-xs-3">
            <div class="form-group">
              <label>TOTAL</label>
              <input type="text" class="form-control" name="ttl" value="<?php echo e($ttl) ?>">
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-xs-6">
            <div class="form-group">
              <label>Duration Needed (Month)</label>
              <input type="number" class="form-control" name="duration" value="<?php echo e($duration) ?>">
            </div>
          </div>
<div class="col-xs-12">
            <div class="form-group">
              <label>Main Learning Risks</label>
              <select class="form-control select2 pt-weakness-select" name="risk">
                <?php echo e(renderWeaknessOptions('Risk', $risk)) ?>
              </select>
            </div>
          </div>			
          <div class="col-xs-4">
            <div class="form-group">
            <label>Teacher's Note</label>
              <input type="text" class="form-control" name="note_score" value="<?php echo htmlspecialchars($note_score) ?>">
            </div>
          </div>
        </div>
      </div>
    </div>
 
    <!-- ============ Program Recommendations ============ -->
    <div class="pt-section">
      <div class="pt-section-title"><i class="fa fa-lightbulb-o"></i>Program Rekomendasi</div>
      <div class="pt-section-body">
        <div class="row">
          <?php
          for ($i = 1; num($i) <= 5; $i++) {
              // Box #1 always shows. Box #(n) only shows once box #(n-1) has a selection,
              // mirroring the original step-by-step behaviour.
              if (num($i) > 1 && $kd_recom[num($i) - 2] == '') {
                  break;
              }
              $exclude = array_slice($kd_recom, 0, num($i) - 1);
              ?>
              <div class="col-lg-4">
                <div class="form-group">
                  <label>Recommendation Program #<?php echo e($i) ?></label>
                  <select class="form-control select2" name="prg_recom_<?php echo e($i) ?>" onChange="this.form.submit()">
                    <?php echo e(renderRecommOptions($exclude, $kd_recom[num($i) - 1])) ?>
                  </select>
                  <input type="hidden" name="kd_prg_recom_<?php echo e($i) ?>" value="<?php echo htmlspecialchars($kd_recom[num($i) - 1]) ?>">
                </div>
              </div>
              <?php
          }
          ?>
        </div>
      </div>
    </div>
 
    <div class="pt-footer">
      <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
      <input type="submit" class="btn btn-success" name="save_score" value="Save Score">
    </div>
  </form>
</div>
 
<script>
  function popitup(url) {
    var newwindow = window.open(url, 'name', 'height=600,width=750,screenX=400,screenY=350');
    if (window.focus) { newwindow.focus(); }
    return false;
  }
</script>
</body>
</html>
