<?php
require_once __DIR__ . "/_lib/bootstrap.php"; csrf_guard_get(); auth_require_login(); 
include __DIR__ . "/conndb.php";
include __DIR__ . "/profiledata.php";
$hari=date("d");
$bulan=date("m");
$tahun=date("Y");
$hari_ini = "$tahun-$bulan-$hari";
$id = in_val('id', 'any');
$first_name = in_val('first_name', 'any');$middle_name = in_val('middle_name', 'any');

$family_name = in_val('family_name', 'any');
$gender = in_val('gender', 'any');
$dob = in_val('dob', 'any');
$phone = in_val('phone', 'any');
$hp1 = in_val('hp1', 'any');
$e_mail = in_val('e_mail', 'any');
$vpro_remark = in_val('vpro_remark', 'any');
$nama_lengkap = $_SESSION['nama_lengkap'];
$query_get_leads = q_set($__p_query_get_leads, "SELECT comp_name, comp_id, comp_address, comp_type, comp_size, comp_phone, comp_email, comp_website, comp_media_source, comp_remark, comp_add_information,cp_nama, cp_jabatan, cp_telepon, cp_email,dt_entry,pic FROM vpro_company_data where  id =? ", [(string) ($id)]);

$resource_get_leads = db_query_or_die('errro_7', $query_get_leads, $__p_query_get_leads ?? []);
if(num(db_num_rows($resource_get_leads))>0){

	while ($row_get_leads=  db_fetch($resource_get_leads, PDO::FETCH_NUM))
		{
$vpro_nama = $row_get_leads['0'];
	}
}

?>
<!DOCTYPE html>
<html>
<head>
<body onScroll="document.cookie='ypos=' + window.pageYOffset" onLoad="window.scrollTo(0,readCookie('ypos'))">
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>PO LIST</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="cdnjs/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="cdnjs/ionicons.min.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="plugins/datatables/dataTables.bootstrap.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">
  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
</head>
<body class="hold-transition skin-blue sidebar-mini">

    <br>
    <table width="100%" class="table table-bordered table-striped" id="example1">
      <thead>
        <tr>
          <td width=31% height="14" align=center >Student Name</td>
          <td width=19% align=center >Phone</td>
          <td width=16% align=center >Email</td>
          <td width=34% align=center >Remark</td>
        </tr>
      </thead>
      <tbody>
        <?php	
	
$query_student = q_set($__p_query_student, "SELECT concat_ws('',nama, middle_name, family_name), e_mail, hp, vpro_remark FROM ves_inc.tb_biodata where vpro_id =?  order by no desc", [(string) ($id)]);

$no_urut = 1;		
$resource_student = db_query_soft($query_student, $__p_query_student ?? []);			
if(num(db_num_rows($resource_student)) > 0)
	{
	while ($row_billing  =  db_fetch($resource_student, PDO::FETCH_NUM))
		{

		
	?>
        <tr>
          <td height="14" align=left class="style24"><?php echo e($row_billing[0]) ?></td>
          <td align=left class="style24"><?php echo e($row_billing[2]) ?><br></td>
          <td align=left class="style24"><?php echo e($row_billing[1]) ?></td>
          <td align=left class="style24"><?php echo e($row_billing[3]) ?></td>
        </tr>
        <?php $no_urut = num($no_urut) +1;}} ?>
      </tbody>
      <tfoot>
      </tfoot>
    </table>
    <!-- Content Header (Page header) -->
   <!-- Main content -->
<section class="content">
<form name="myform" id="myform" method="post"><?php echo csrf_field(); ?>


    <div class="col-xs-12">
<div class="box box-warning">
<div class="box-body"><span class="form-group">
  <input type="text" ang="en-150"  name="id" 
                 	      value="<?php echo e($id) ?>" hidden="hidden">
</span>
 <div class="row">
 	  <div class="col-xs-8">
    <div class="form-group">
      <label>Corporate Name</label>
      <input type="text" ang="en-150" class="form-control"  placeholder="Enter ..." name="student_name" 
                 	      value="<?php echo e($vpro_nama) ?>" readonly>
    </div>
  </div>
 </div>
<div class="row">
<div class="col-xs-4">
    <div class="form-group" >
      <label>First Name</label>
      <input type="text" name="first_name"   class="form-control" value = "<?php echo e($first_name)  ?>"/>
    </div>
  </div>
<div class="col-xs-4">
  <div class="form-group">
    <label>Middle Name</label>
    <input type="text" name="middle_name"  class="form-control" value = "<?php echo e($middle_name)  ?>"/>
  </div>
</div>
<div class="col-xs-4">
  <div class="form-group">
    <label>Family Name</label>
    <input type="text" name="family_name"  class="form-control" value = "<?php echo e($family_name)  ?>"/>
  </div>
</div>
	</div>
<div class="row">
<div class="col-xs-2">
  <div class="form-group">
    <label>Gender</label>
    <select name="gender" class="form-control" >
                  <option>M</option>
                  <option>F</option>
              <option selected="selected"> <?php echo e($gender);  ?> </option>
    </select>
  </div>
</div>  	

<div class="col-xs-4">
    <div class="form-group">
      <label>DOB</label>
      <input type="date" name="dob"  class="form-control" value = "<?php echo e($dob)  ?>"/>
    </div>
  </div>
</div>
     
<div class="row">
<div class="col-xs-4">
    <div class="form-group">
      <label>Mobile Phone</label>
      <input name="hp1" type="text" id="hp1" value="<?php echo e($hp1) ?>" class="form-control" >
    </div>
  </div>
<div class="col-xs-4">
  <div class="form-group">
    <label>Whatsapp</label>
    <input name="wa" type="text" id="wa" value="<?php echo e($wa) ?>" class="form-control" >
  </div>
</div>
<div class="col-xs-4">
  <div class="form-group">
    <label>Home Phone</label>
    <input name="phone" type="text" id="phone" value="<?php echo e($phone) ?>" class="form-control" >
  </div>
</div>
</div>
<div class="row">
<div class="col-xs-6">
    <div class="form-group">
      <label>E-Mail</label>
      <input name="e_mail" type="text" id="e_mail" value="<?php echo e($e_mail) ?>" class="form-control" >
    </div>
  </div>
</div> 
<div class="row">
<div class="col-xs-8">
    <div class="form-group">
      <label>VPRO Remark</label>
      <input name="vpro_remark" type="nextremark" id="vip_remark" value="<?php echo e($vpro_remark) ?>" class="form-control" >
    </div>
  </div>
</div>   

<input name="Save" type="submit" id="Save"  class="form-control"  value="Save" />
<input name="Close" type="submit" id="Close"  class="form-control"  value="Close" />
    </div>
		      
 
</form>
		</section>

</body>
</html>
<?php
if (($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['Save']))) 
{
$statussimpan = 0;
$jamskrg= date('h:i:s', time());

$tanggal_hri = date('Y-m-d');
$nama_lengkap = $_SESSION['nama_lengkap'];

$kd_cbg = $_SESSION['kd_branch'];
$posisi = $_SESSION['posisi']; 
$kd_staff = $_SESSION['kd_staff'] ; 
$first_name = in_val('first_name', 'any');	
$middle_name = in_val('middle_name', 'any');
if ($first_name=='')
	{
	if (num($statussimpan)==0){$pesan="First Name ";}
	$statussimpan=1;
	}
$id = in_val('id', 'any');

$kd_cbg = $_SESSION['kd_branch'];
$family_name = in_val('family_name', 'any');

$gender = in_val('gender', 'any');
if ($gender=='')
	{
	if (num($statussimpan)==0){$pesan="gender ";}
	$statussimpan=1;
	}	
$dob = in_val('dob', 'any');
$phone = in_val('phone', 'any');
$hp1 = in_val('hp1', 'any');
if ($hp1=='')
	{
	if (num($statussimpan)==0){$pesan="hp  ";}
	$statussimpan=1;
	}
$e_mail = in_val('e_mail', 'any');
if ($e_mail=='')
	{
	if (num($statussimpan)==0){$pesan="e_mail  ";}
	$statussimpan=1;
	}
	$kodetgl = date('ymd');
$vpro_remark = in_val('vpro_remark', 'any');
$tanggal_hri = date('Y-m-d h:i:s');
if (num($statussimpan)==0)
	{
//===autonumber
	$query = q_set($__p_query, "SELECT MAX(t.no) as max_id FROM ves_inc.tb_biodata t where vpro_id = ? and (kd_biodata is not null or kd_biodata <>'')", [(string) ($id)]);
	$result = db_query_soft($query, $__p_query ?? []);
	$data = db_fetch($result);
	$id_max = $data['max_id'];
	$sort_num = $id_max;
	$sort_num++;
	$new_code = sprintf($sort_num);
	$kode_biodata = "$kodetgl$id$new_code";	
	$query_simpan = q_set($__p_query_simpan, "insert into ves_inc.tb_biodata \r
\t(kd_biodata, \r
\tnama, middle_name, family_name, gender,\r
\tdob, \r
\thm_ph, hp, \t\r
\te_mail, \r
\tvpro_remark,vpro_id,pic, dt_entry,kd_branch )\r
\tvalues \r
\t(? ,? , ? , ? , ? ,? , ? , ? ,? ,  ? , ? ,? ,?\t,? )", [(string) ($kode_biodata), (string) ($first_name), (string) ($middle_name), (string) ($family_name) . " ", (string) ($gender), (string) ($dob), (string) ($phone) . " ", (string) ($hp1) . " ", (string) ($e_mail), (string) ($vpro_remark) . " ", (string) ($id), (string) ($nama_lengkap), (string) ($tanggal_hri), (string) ($kd_cbg)]);
	$resource_simpan= db_query_or_die('errro_simpan', $query_simpan, $__p_query_simpan ?? []);
	echo "<script type=\"text/javascript\">\n";
	echo "alert('New Leads has been Submitted by " . e($nama_lengkap) . "');\n";
	echo "window.location = ('vpro_leads_student.php?id=1952');\n";			
	echo "</script>";	
			
	}
else
	{
	echo "<script type=\"text/javascript\">\n";
	echo "alert('" . e($pesan) . " must be filled');\n";
	echo "</script>";
		
		
	}

}
?>