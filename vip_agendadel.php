<?php
// Hapus jadwal (vip_teacher_schedule). Dibuka sebagai popup dari beberapa halaman
// lewat link GET ?id=...; versi lama langsung menghapus saat link dibuka (bisa
// dipicu CSRF). Sekarang GET menampilkan konfirmasi, penghapusan lewat POST + token.
include __DIR__ . "/conndb.php";
auth_require_login();
$nama_lengkap = $_SESSION['nama_lengkap'];
$id = in_int('id', null, 'any', 1);
if ($id === null)
	{
	js_alert('Jadwal tidak valid');
	exit;
	}
$jadwal = db_row(
	"SELECT v.id, v.nm_teacher, v.kelas, v.center, date_format(v.mulai_tm,'%d %b %Y %H:%i') AS mulai, date_format(v.selesai_tm,'%H:%i') AS selesai, v.keterangan, v.status_kelas
	 FROM ves_data.vip_teacher_schedule v WHERE v.id = ?",
	[$id]
);

if ($_SERVER['REQUEST_METHOD'] == 'POST')
	{
	db_exec("delete FROM ves_data.vip_teacher_schedule WHERE id = ?", [$id]);
	error_log(sprintf('Jadwal dihapus oleh %s (kd_staff %s): %s', $nama_lengkap, $_SESSION['kd_staff'], json_encode($jadwal)));
	echo "<script type=\"text/javascript\">\n";
	echo 'alert(' . js('Jadwal sudah dihapus oleh ' . $nama_lengkap) . ");\n";
	echo "if (window.opener) { window.opener.location.reload(true); }\n";
	echo "window.close();\n";
	echo "</script>";
	exit;
	}
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Hapus Jadwal</title>
  <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
</head>
<body style="padding:20px">
<?php if ($jadwal === null) { ?>
  <p>Jadwal tidak ditemukan atau sudah dihapus.</p>
  <button type="button" class="btn btn-default" onclick="window.close()">Tutup</button>
<?php } else { ?>
  <h4>Hapus jadwal ini?</h4>
  <table class="table table-bordered">
    <tr><th>Teacher</th><td><?php echo e($jadwal['nm_teacher']) ?></td></tr>
    <tr><th>Kelas</th><td><?php echo e($jadwal['kelas']) ?></td></tr>
    <tr><th>Center</th><td><?php echo e($jadwal['center']) ?></td></tr>
    <tr><th>Waktu</th><td><?php echo e($jadwal['mulai']) ?> - <?php echo e($jadwal['selesai']) ?></td></tr>
    <tr><th>Keterangan</th><td><?php echo e($jadwal['keterangan']) ?></td></tr>
  </table>
  <form method="post" action="vip_agendadel.php">
    <?php echo csrf_field(); ?>
    <input type="hidden" name="id" value="<?php echo e($id) ?>">
    <button type="submit" class="btn btn-danger"><i class="glyphicon glyphicon-erase"></i> Hapus</button>
    <button type="button" class="btn btn-default" onclick="window.close()">Batal</button>
  </form>
<?php } ?>
</body>
</html>
