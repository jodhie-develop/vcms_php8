<?php
// Popup ubah shift guru per hari (vip_teacher_name.day_1..day_6).
// Versi lama: GET tanpa login, nama kolom dan nilai langsung ditempel ke SQL.
include __DIR__ . "/conndb.php";
auth_require_login();

$hari=date("d");
$bulan=date("m");
$tahun=date("Y");
$hari_ini = "$tahun-$bulan-$hari";

$not = in_int('not', 0);
$nod = in_int('nod', 0, 'any', 1, 6);
$nmday = '';
$shift = '';
if ($nod ==1) {$nmday ='Monday';}
elseif ($nod ==2) {$nmday ='Tuesday';}
elseif ($nod ==3) {$nmday ='Wednesday';}
elseif ($nod ==4) {$nmday ='Thursday';}
elseif ($nod ==5) {$nmday ='Friday';}
elseif ($nod ==6) {$nmday ='Saturday';}
$row_nm_teacher = db_row(
	"SELECT a.nm_teacher, a.kd_teacher,a.day_1,a.day_2,a.day_3,a.day_4,a.day_5,a.day_6,a.no,a.kd_user FROM ves_data.vip_teacher_name a where a.no = ?",
	[$not],
	PDO::FETCH_NUM
);
if ($row_nm_teacher !== null)
	{
	$nm_teacher = $row_nm_teacher[0];
	$kd_teacher = $row_nm_teacher[1];
	if ($nod >= 1) {$shift = $row_nm_teacher[$nod + 1];}
	}

// Boleh mengubah: guru pemilik baris ini, atau pengelola master guru
// (sama dengan hak akses teacher_master.php).
auth_require(
	$row_nm_teacher !== null && $nod >= 1 && (
		(string) $row_nm_teacher[9] === (string) $_SESSION['kd_staff']
		|| auth_is('posisi', 'ACCM', 'HRD')
		|| (auth_is('kelompok', 'ACD') && auth_is('posisi', 'AS'))
	)
);

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['Submit']))
{
	$shift = in_str('shift', 45, 'post');
	// Nama kolom dari whitelist (bukan dari input).
	$kolom = ['', 'day_1', 'day_2', 'day_3', 'day_4', 'day_5', 'day_6'][$nod];
	db_exec("update ves_data.vip_teacher_name set $kolom = ? where no = ?", [$shift, $not]);
	echo "<script type=\"text/javascript\">\n";
	echo "if (window.opener) { window.opener.location.reload(true); }\n";
	echo "window.close(); \n";
	echo "</script>";
	exit;
}

?>
     <form name="form1" method="post" action="vip_shitupd.php"><?php echo csrf_field(); ?>
 <table width="40%" class="table table-bordered table-striped" id="example1">

  <tbody>
    <tr>
      <td><strong>Day</strong></td>
      <td><span class="form-group">
        <?php echo e($nmday) ?>
        <input type="hidden" name="nod" width="250px"  value="<?php echo e($nod) ?>" >
        <input type="hidden" name="not" width="250px"  value="<?php echo e($not) ?>" >
      </span></td>
    </tr>
    <tr>
      <td><strong>Shift</strong></td>
      <td><span class="form-group">
        <input type="text" name="shift" width="250px"  value="<?php echo e($shift) ?>" maxlength="45">
      </span></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td><span class="form-group">
        <input type="submit" name="Submit" value="Submit" />
      </span></td>
    </tr>
  </tbody>
  <tfoot>
  </tfoot>
</table>
</form>
