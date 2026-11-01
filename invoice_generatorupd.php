<?php
require_once __DIR__ . "/_lib/bootstrap.php"; csrf_guard_get(); auth_require_login(); 
include __DIR__ . "/conndb.php";
include __DIR__ . "/profiledata.php";
$no = in_val('no', 'any');
$query_kelas = q_set($__p_query_kelas, "SELECT kelas, kd_branch, mulai_tm, nm_teacher,date_format(selesai_tm,'%k:%i'),room,date_format(mulai_tm,'%Y-%m-%d'),urutan,date_format(mulai_tm,'%k:%i') FROM ves_data.vip_teacher_schedule v where id = ? ", [(string) ($no)]);

$resource_kelas= db_query_or_die('errro_visitor1', $query_kelas, $__p_query_kelas ?? []);
$keluar_kelas= db_num_rows($resource_kelas);
	if(num(db_num_rows($resource_kelas)) > 0)
		{
		while ($row_kelas =   db_fetch($resource_kelas, PDO::FETCH_NUM))
			{
			$kdcl = $row_kelas[0];
			$kdcbg = $row_kelas[1];	
			$tgl_meeting_lama = $row_kelas[6];
			$teacher_lama = $row_kelas[3];	
			$end_schedule_lama = $row_kelas[4];
			$room_lama = $row_kelas[5];	
			$tgl_lama = $row_kelas[6];
			$urutan_lama = $row_kelas[7];
			$start_schedule_lama = $row_kelas[8];	
			$tgl_lengkap_lama = $row_kelas[2];
			}
		}
$query_coor = q_set($__p_query_coor, "select subject,coverage,material,assignment,hours from ves_data.vip_cosheet where kd_class=? and tgl_meeting = ? ", [(string) ($kdcl), (string) ($tgl_lengkap_lama)]);

$resource_coor= db_query_or_die('errro_visitor21', $query_coor, $__p_query_coor ?? []);
$keluar_coor= db_num_rows($resource_coor);
	if(num(db_num_rows($resource_coor)) > 0)
		{
		while ($row_coor =   db_fetch($resource_coor, PDO::FETCH_NUM))
			{
			$subject = $row_coor[0];
			$coverage = $row_coor[1];
			$material = $row_coor[2];
			$assignment = $row_coor[3];
			$hour = $row_coor[4];
			}
		}


$nama_lengkap = $_SESSION['nama_lengkap'];               
if($center =='East Sby'){$kd_center = '1';}
if($center =='West Sby'){$kd_center = '2';}
if($center =='Bali'){$kd_center = '3';}
if($center =='South Jkt'){$kd_center = '4';}
if($center =='North Jkt'){$kd_center = '5';}
if($center =='West Jkt'){$kd_center = '6';}
if($center =='Bandung'){$kd_center = '7';}
if($center =='Malang'){$kd_center = '8';}	

$mulai_kelas_baru = in_val('mulai_kelas_baru', 'any');
if($mulai_kelas_baru ==''){ $mulai_kelas_baru = $tgl_lama;}
$nm_teacher_baru = in_val('nm_teacher_baru', 'any');
if($nm_teacher_baru == ''){$nm_teacher_baru =  $teacher_lama;}
$room_baru = in_val('room_baru', 'any');
if($room_baru == ''){$room_baru = $room_lama;}
$start_schedule = in_val('start_schedule', 'any');
if ($start_schedule == ''){$start_schedule = $start_schedule_lama;}
$end_schedule = in_val('end_schedule', 'any');
if ($end_schedule == ''){$end_schedule = $end_schedule_lama;}

$remark_schedule = in_val('remark_schedule', 'any');
//$query_nm_teacher = "SELECT b.nm_teacher FROM ves_data.vip_teacher_schedule a left join ves_data.vip_teacher_name b on a.nm_teacher = b.kd_teacher  where kelas = '$kode_kelas' group by a.nm_teacher";

?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>AdminLTE 2 | General Form Elements</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="css/font-awesome/css/font-awesome.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="css/ionicons/css/ionicons.min.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="plugins/datatables/dataTables.bootstrap.css">
  <link rel="stylesheet" href="plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">
	    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"></link>
    <script src="http://code.jquery.com/jquery-3.1.1.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/js/bootstrap-datepicker.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/css/bootstrap-datepicker.css"></link>
  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
  <script src="js/tinymce.min.js"/></script>
<script type="text/javascript">
tinymce.init({
    selector: "textarea",
    plugins: [
        "advlist autolink lists link image charmap print preview anchor",
        "searchreplace visualblocks code fullscreen",
        "insertdatetime media table contextmenu paste"
    ],
    toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image"
});
</script>
</head>

<div class="wrapper">

  <!-- Left side column. contains the logo and sidebar -->
  

  <!-- Content Wrapper. Contains page content -->
  <div class="content">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>Invoice Generator</h1>
    </section>
<form method="post"><?php echo csrf_field(); ?> 
    <!-- Main content -->
<section class="content">
  <div class="row">
<form role="form" method="post"><?php echo csrf_field(); ?>

    <div class="col-md-12">

<div class="box box-warning">
  <div class="box-header with-border"><strong>Material</strong></div>
  <div class="box-body">
    <div class="col-md-8">
      <div class="form-group">
        <label>Group Business</label>
        <select class="form-control select2" style="width: 100%;" name="corporate"  >
          <option value="VIC">VIC</option>
          <option value="VIP">VIP</option>
          <option value="LIUMEDIA">LIUMEDIA</option>
          <option value="VPRO">VPRO</option>
          <option value="CA">CA</option>
			
          <option selected><?php echo e($corporate) ?></option>
        </select>
      </div>
    </div>
    <div class="col-md-8">
      <div class="form-group">
        <label>No Invoice</label>
        <input type="text" class="form-control"  placeholder="Enter CLass Code" name="invoice_id" value="<?php echo e($invoice_id) ?>" required>
      </div>
    </div>
    <div class="col-md-8">
      <div class="form-group">
        <label>Invoice Date</label>
        <input type="date" class="form-control"  placeholder="Enter CLass Code" name="invoice_date" value="<?php echo e($invoice_date) ?>" required>
      </div>
    </div>
    <div class="col-md-8">
      <div class="form-group">
        <label>Order By</label>
        <textarea class="textarea" placeholder="Masukkan data order by" style="width: 100%; height: 110px; font-size: 14px; line-height: 10px; border: 1px solid #dddddd; padding: 10px;" name="order_by"><?php echo  e($order_by) ?></textarea>
      </div>
    </div>
    <div class="col-md-8">
      <div class="form-group">
        <label>Amount</label>
        <input type="text" class="form-control"  placeholder="Enter CLass Code" name="amount" value="<?php echo e($amount) ?>"required>
      </div>
    </div>
    <div class="col-md-4">
      <div class="form-group">
        <label>VAT</label>
        <input type="text" class="form-control"  placeholder="Enter CLass Code" name="vat" value="<?php echo e($vat) ?>"required>
      </div>
    </div>
    <div class="col-md-8">
      <div class="form-group">
        <label>Description</label>
        <textarea class="textarea" placeholder="Place some text here" style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;" name="Description"><?php echo e($Description) ?></textarea>
      </div>
    </div>
    <div class="col-md-8">
      <div class="form-group">
        <label>Due Date</label>
        <input type="date" class="form-control"  placeholder="Enter CLass Code" name="due_date" value="<?php echo e($due_date) ?>" required>
      </div>
    </div>
  </div>
</div>
<div class="box-body"></div>

<input type="submit" name="Submit" value="Submit" />
</form>
<script src="plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
<script src="https://cdn.ckeditor.com/4.5.7/standard/ckeditor.js"></script>
<script>
	$('.textarea').wysihtml5();
</script>

<script type="text/javascript" charset="utf-8">
	$(prettyPrint);
</script>
</body>
</html>
<?php
if (($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['Submit']))) 
{
$fullurl="http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
$hari=date("d");
$bulan=date("m");
$tahun=date("Y");
$hari_ini = "$tahun-$bulan-$hari";	
$corporate = in_val('corporate', 'any');

$order_by = in_val('order_by', 'any');
$Description = in_val('Description', 'any');
$amount = in_val('amount', 'any'); 
$vat = in_val('vat', 'any');
$due_date = in_val('due_date', 'any');
$invoice_id = in_val('invoice_id', 'any');
$invoice_date = in_val('invoice_date', 'any');
	
	
$pic = $nama_lengkap;	

$query_check = q_set($__p_query_check, "SELECT i.invoice_id FROM invoice_project i where invoice_id = ? ", [(string) ($invoice_id)]);

$resource_check= db_query_or_die('errro_visitor21', $query_check, $__p_query_check ?? []);
$keluar_check= db_num_rows($resource_check);
	if(num(db_num_rows($resource_check)) > 0)
		{
//$query_coor = "update ves_data.vip_cosheet set subject = '$subject',coverage = '$coverage',material = '$material',assignment = '$assignment',hours = '$hour'  where kd_class = '$kdcl' and tgl_meeting = '$tgl_lengkap_lama'";	
$query_coor = q_set($__p_query_coor, "update ves_data.vip_cosheet set subject = ? ,coverage = ? ,material = ? ,assignment = ? ,hours = ?  where id = ? ", [(string) ($subject), (string) ($coverage), (string) ($material), (string) ($assignment), (string) ($hour), (string) ($no)]);	
		

$resource_coor = db_query_or_die('errro_simpan32', $query_coor, $__p_query_coor ?? []);			
		}
	else
	{
	
$query_simpan = q_set($__p_query_simpan, "insert into ves_data.invoice_project (busines_group, invoice_id, invoice_date, invoice_order, invoice_description, invoice_amount, vat, pic, dt_entry) values (? ,? ,? ,? ,? ,? ,? ,? ,? )", [(string) ($corporate), (string) ($invoice_id), (string) ($invoice_date), (string) ($order_by), (string) ($Description), (string) ($amount), (string) ($vat), "\$" . (string) ($nama_lengkap), (string) ($hari_ini)]);/* echo $query_simpan (debug SQL versi lama) dihapus */
$resource_simpan = db_query_or_die('errro_simpan2', $query_simpan, $__p_query_simpan ?? []);	

	}
echo "<script type=\"text/javascript\">\n";
echo "alert('Invoice Created by " . e($nama_lengkap) . "');\n";
echo "window.opener.location.reload(true);\n";								
echo "window.close();\n";				
echo "</script>";
}
?>
