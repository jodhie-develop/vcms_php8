<?php
require_once __DIR__ . "/_lib/bootstrap.php"; csrf_guard_get(); auth_require_login(); 
include __DIR__ . "/conndb.php";

$hari=date("d");
$bulan=date("m");
$tahun=date("Y");
$hari_ini = "$tahun-$bulan-$hari";

$nama_lengkap = $_SESSION['nama_lengkap'];
$kdb = in_val('kdb', 'any');
$st = in_val('st', 'any');
$nomor = in_val('id', 'any');
$nm_room = in_val('nmroom', 'any');
if(num($st)==1){$cat = 'Approve';}
elseif(num($st)==0){$cat = 'Reject';}
$query_order = q_set($__p_query_order, "SELECT nm_teacher,status_kelas,keterangan   FROM vip_teacher_schedule where id=? ", [(string) ($nomor)]);
$resource_order = db_query_or_die('errro_71', $query_order, $__p_query_order ?? []);
$keluar_order= db_num_rows($resource_order);
if(num(db_num_rows($resource_order)) > 0)
	{
	while ($row_periode=  db_fetch($resource_order, PDO::FETCH_NUM))
		{
		$nm_teacher =  $row_periode[0];
		$st_kelas =  $row_periode[1];
		$keterangan = $row_periode[2];
			
		}
	}
//--ambil tanggal kelas


//$resource_simpan_1= mysql_query($query_simpan_1) or die('errro_simpan1');		
//	echo "<script type=\"text/javascript\">\n";
//	echo "alert('Teachers activities has been updated by $nama_depan');\n";
//	echo "window.opener.location.reload(true);\n";
//	echo "window.close(); \n";				
//echo "</script>";
?>
     <form name="form1" action="#" method="post"><?php echo csrf_field(); ?>

 <table width="40%" class="table table-bordered table-striped" id="example1">

  <tbody>
   <tr>
     <td><strong>Teacher</strong></td>
     <td><span class="form-group"><?php echo e($nm_teacher) ;?></span></td>
   </tr>
   <tr>
      <td><strong>Status</strong></td>
      <td><span class="form-group"><?php echo e($cat) ;?>
        <input type="text" name="id" value="<?php echo e($nomor) ?>" hidden >
        <input type="text" name="keterangan" value="<?php echo e($keterangan) ?>" hidden >
        <input type="text" name="st" value="<?php echo e($st) ?>"hidden>
        <input type="text" name="st_kelas" value="<?php echo e($st_kelas) ?>"hidden>
      </span></td>
    </tr>
    <tr>
      <td><strong>Room</strong></td>
      <td><span class="form-group">
        <?php echo e($nm_room) ;?></span></td>
    </tr>
    <tr>
      <td><strong>Reason and Date Sugestion</strong></td>
      <td><span class="form-group">
        <input type="text" name="reason" width="250px"  value="<?php echo e($alasan) ?>" >
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

<?php 
if (($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['Submit']))) 
{


$hari=date("d");
$bulan=date("m");
$tahun=date("Y");
$hari_ini = "$tahun-$bulan-$hari";

$nama_lengkap = $_SESSION['nama_lengkap'];
$id = in_val('id', 'any');
$st = in_val('st', 'any');
$st_kelas = in_val('st_kelas', 'any');
$nomor = in_val('id', 'any');
$nm_room = in_val('nm_room', 'any');
$keterangan = in_val('keterangan', 'any');
$reason = in_val('reason', 'any');

//--ambil tanggal kelas
if (num($st) ==1)
{
if (num($st_kelas) == 50 or num($st_kelas) == 52){$st_kelas = 51;}
elseif (num($st_kelas) == 40 or num($st_kelas) == 42){$st_kelas = 41;}	
elseif (num($st_kelas) == 60  or num($st_kelas) == 62){$st_kelas = 61;}
elseif (num($st_kelas) == 70 or num($st_kelas) == 72){$st_kelas = 71;}
elseif (num($st_kelas) == 80 or num($st_kelas) == 82){$st_kelas = 81;}
elseif (num($st_kelas) == 90 or num($st_kelas) == 92){$st_kelas = 91;}
elseif (num($st_kelas) == 980 or num($st_kelas) == 982){$st_kelas = 981;}
	
	$query_simpan_1 = q_set($__p_query_simpan_1, "update ves_data.vip_teacher_schedule set keterangan = ? , room = ? ,status_kelas  = ? where id = ? ", [(string) ($keterangan) . " " . (string) ($reason), (string) ($nm_room), (string) ($st_kelas), (string) ($nomor)]);
	$resource_simpan_1= db_query_or_die('errro_simpan1', $query_simpan_1, $__p_query_simpan_1 ?? []);		
	echo "<script type=\"text/javascript\">\n";
		echo "alert('Teachers activities has been updated by " . e($nama_lengkap) . "');\n";
	echo "window.opener.location.reload(true);\n";	
		echo "window.close(); \n";				
	echo "</script>";	
}
if (num($st) == 0 and $reason <> '')
	{
	if (num($st_kelas) == 50   or num($st_kelas) == 51){$st_kelas = 52;}
	elseif (num($st_kelas) == 40   or num($st_kelas) == 41){$st_kelas = 42;}	
	elseif (num($st_kelas) == 60   or num($st_kelas) == 61){$st_kelas = 62;}
	elseif (num($st_kelas) == 70   or num($st_kelas) == 71){$st_kelas = 72;}
	elseif (num($st_kelas) == 80   or num($st_kelas) == 81){$st_kelas = 82;}
	elseif (num($st_kelas) == 90   or num($st_kelas) == 91){$st_kelas = 92;}
elseif (num($st_kelas) == 980 or num($st_kelas) == 981){$st_kelas = 982;}	
	$query_simpan_1 = q_set($__p_query_simpan_1, "update ves_data.vip_teacher_schedule set keterangan = ? , room = ? ,status_kelas  = ? where id = ? ", [(string) ($keterangan) . " " . (string) ($reason), (string) ($nm_room), (string) ($st_kelas), (string) ($nomor)]);
	$resource_simpan_1= db_query_or_die('errro_simpan1', $query_simpan_1, $__p_query_simpan_1 ?? []);		
	echo "<script type=\"text/javascript\">\n";
		echo "alert('Teachers activities has been updated by " . e($nama_lengkap) . "');\n";
	echo "window.opener.location.reload(true);\n";	
		echo "window.close(); \n";				
	echo "</script>";
	}
else
{echo "<script type=\"text/javascript\">\n";
	echo "alert('Reason Must be filled');\n";		
echo "</script>";die;}}
?>