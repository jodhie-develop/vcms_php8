<?php
require_once __DIR__ . "/_lib/bootstrap.php"; csrf_guard_get(); auth_require_login(); 
include __DIR__ . "/conndb.php";
include __DIR__ . "/profiledata.php";

$kodemaju = in_val('kodemaju', 'any');
if($kodemaju == '')
	{
	$kodemaju = rand(1111,9999);
	$query_kode = q_set($__p_query_kode, "SELECT kodemaju FROM ves_data.vip_proposed_class where kodemaju = ? ", [(string) ($kodemaju)]);
	$resource_kode = db_query_soft($query_kode, $__p_query_kode ?? []);
	$keluar_kode = db_num_rows($resource_kode);				
	if(num(db_num_rows($resource_kode)) == 0)
		{
		$query_s = "insert into ves_data.vip_teacher_schedule (nm_teacher, kelas, center,  mulai_tm, selesai_tm,dt_entry, pic,kd_branch,status_kelas, catatan,keterangan,kd_biodata)
	values ('$nm_teacher','$kdcl - $aktifitas','$center','$tanggalpilih $mulai:01','$tanggalpilih $selesai:00','$hari_ini','$nama_lengkap','$kd_center','$t','Booking','$remark','$kd_biodata')";
//	$resource_simpan_1= mysql_query($query_simpan_1) or die('errro_simpan1');	
		}
	}

$nm_teacher = in_val('nm_teacher', 'any');
if ($nm_teacher ==''){$nm_teacher= in_val('nmt', 'any');}

$center = in_val('center', 'any');
$kd_center = $_SESSION['kd_branch'];
$id = in_val('id', 'any');
$type_class = in_val('type_class', 'any');
$nm_program = in_val('nm_program', 'any');
$nm_level = in_val('nm_level', 'any');
if($nm_program !="" and $nm_level !="" and $type_class !="")
	{
	$query_kode_program = q_set($__p_query_kode_program, "SELECT kd_program FROM ves_data.vip_mst_code_prg where nm_program = ? and level_program = ? and type_program = ? ", [(string) ($nm_program), (string) ($nm_level), (string) ($type_class)]);			
	$resource_kode_program = db_query_or_die('errro_7', $query_kode_program, $__p_query_kode_program ?? []);
	while ($row_kode_program=  db_fetch($resource_kode_program, PDO::FETCH_NUM))
		{
		$kode_program =   $row_kode_program[0];
		}   
	}

$days = in_val('days', 'any');
$times = in_val('times', 'any');
$teacher = in_val('teacher', 'any');
$tanggal_awal = in_val('tanggal_awal', 'any');

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
   <style>

function fScroll(val)
{
        var hidScroll = document.getElementById('hidScroll');
        hidScroll.value = val.scrollTop;
}

// function moves scroll position to saved value
function fScrollMove(what)
{
        var hidScroll = document.getElementById('hidScroll');
        document.getElementById(what).scrollTop = hidScroll.value;
}
.style92 {color: #FFFFFF; font-weight: bold; font-size: 13px; font-family: Calibri; }
</style>
    <script language="JavaScript">
function readCookie(name){
return(document.cookie.match('(^|; )'+name+'=([^;]*)')||0)[2]
}

</script><body onScroll="document.cookie='ypos=' + window.pageYOffset" onLoad="window.scrollTo(0,readCookie('ypos'))">
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

  <!-- Left side column. contains the logo and sidebar -->
  

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>Class Proposed Form<span class="form-group">
        
      </span></h1>
    </section>
     <form name="form1" action="#" method="post"><?php echo csrf_field(); ?>

   <input type="text" class="form-control"  placeholder="Mon, Tue, Wed, .." name="kodemaju"  value="<?php echo e($kodemaju) ?>">
   <input type="text" class="form-control"  placeholder="Mon, Tue, Wed, .." name="kd_center"  value="<?php echo e($kd_center) ?>">
    <!-- Main content -->
<section class="content">
  <div class="row">
        <!-- left column -->
<?php   //    include __DIR__ . "/left.php";	 ?>
        <!--/.col (left) -->
        <!-- right column -->

    <div class="col-md-12">
<div class="box box-warning">		
<div class="box-body">
  <div class="col-md-12">
    <div class="form-group">
      <label>PROGRAM INFO</label>
    </div>
  </div>
<div class="row">
  <div class="col-md-12">  
  <div class="col-md-3">
	      <div class="form-group">
			      <label>Type Class</label>
	        <select class="form-control" name="type_class"  onChange="this.form.submit()">
			        <option>REG</option>
			        <option>PRI</option>
			        <option>WORKSHOP</option>
			        
			        <option selected><?php echo  e($type_class) ?></option>
            </select>
          </div>
	    </div>
  <div class="col-md-3">
    <div class="form-group">
      <label>Program</label>
      <select class="form-control" name="nm_program"  onChange="this.form.submit()">
        <?php
									$query_nm_program = q_set($__p_query_nm_program, "SELECT distinct nm_program FROM ves_data.vip_mst_code_prg WHERE type_program = ? ", [(string) ($type_class)]);
								$resource_nm_program = db_query_or_die('errro_7', $query_nm_program, $__p_query_nm_program ?? []);
								while ($row_nm_program=  db_fetch($resource_nm_program, PDO::FETCH_NUM))
									{
							  		echo '<option value="'.e($row_nm_program[0]).'">'.e($row_nm_program[0]).'</option>';
							  		}      ?>
        <option selected><?php echo  e($nm_program) ?></option>
      </select>
    </div>
  </div>
  <div class="col-md-3">
    <div class="form-group">
      <label>Level</label>
      <select class="form-control" name="nm_level"  onChange="this.form.submit()">
        <?php
								$query_level = q_set($__p_query_level, "SELECT level_program FROM vip_mst_code_prg where nm_program = ? and  type_program = ? ", [(string) ($nm_program), (string) ($type_class)]);
								$resource_level = db_query_or_die('errro_7', $query_level, $__p_query_level ?? []);
								while ($row_level=  db_fetch($resource_level, PDO::FETCH_NUM))
									{
							  		echo '<option value="'.e($row_level[0]).'">'.e($row_level[0]).'</option>';
							  		}      ?>
        <option selected><?php echo  e($nm_level) ?></option>
      </select>
    </div>
  </div>
  <div class="col-md-3">
    <div class="form-group">
      <label>Code</label>
      <input type="text" ang="en-150" class="form-control"  placeholder="Enter ..." name="kode_program" 
                 	      value="<?php echo e($kode_program) ?>" readonly>
    </div>
  </div>
  </div> 
	</div> 
   <div class="col-md-3">
    <div class="form-group">
      <label>Day(s)</label>
      <input type="text" class="form-control"  placeholder="Mon, Tue, Wed, .." name="days" value="<?php echo e($days) ?>">
      <input type="hidden" ang="en-150" class="form-control"  placeholder="Enter ..." name="material_fee" 
                 	      value="<?php echo e($material_fee) ?>" hidden="">
    </div>
</div>
   <div class="col-md-4">
     <div class="form-group">
       <label>Time</label>
       <input type="text" class="form-control"  placeholder="13:00 - 15:00 / 17:00 - 19:00" name="times" value="<?php echo e($times) ?>">
       <input type="hidden" ang="en-150" class="form-control"  placeholder="Enter ..." name="material_fee2" 
                 	      value="<?php echo e($material_fee) ?>" hidden="">
     </div>
   </div>
   <div class="col-md-2">
     <div class="form-group">
       <label>Teacher</label>
       <input type="text" class="form-control"  placeholder="IR, IW, RS" name="teacher" value="<?php echo e($teacher) ?>">
       <input type="hidden" ang="en-150" class="form-control"  placeholder="Enter ..." name="material_fee3" 
                 	      value="<?php echo e($material_fee) ?>" hidden="">
     </div>
   </div>
   <div class="col-md-3">
     <div class="form-group">
       <label>First Meeting</label>
       <input type="DATE" class="form-control"   placeholder="Enter ..." name="tanggal_awal" value="<?php echo e($tanggal_awal) ?>">
     </div>
   </div>
   <div class="col-md-4">
     <div class="form-group">

             <input type="submit" name="SAVE" value="SAVE"  class="btn btn-primary" >
				  
     </div>
   </div>

 <input type="hidden" name="tf" id="textfield" value="<?php echo e($tf) ?>" hidden="hidden" >
 <input type="hidden" name="tf_nett" id="textfield2" value="<?php echo e($tf_nett) ?>">
      <input type="hidden" name="discount_tf" id="textfield3" value="<?php echo e($discount_tf) ?>" hidden="">
</div>
	  </div>
<div class="box box-warning">
		  		<div class="box-header with-border"><strong>Billing  List</strong></div>
		  		<div class="col-md-12">
		  		  <div class="form-group">
		  		    <table width="100%" class="table table-bordered table-striped" id="example1">
		  		      <thead>
		  		        <tr>
		  		          <td width=12% align=center >No</td>
		  		          <td width=27% align=center >ID Billing</td>
		  		          <td width=12% height="14" align=center >Student Name</td>
		  		          <td width="14%" align=center >Program</td>
		  		          <td width="11%" align=center >Invoiced</td>
		  		          <td width="11%" align=center >Paid</td>
		  		          <td width="13%" align=center >Action</td>
	  		            </tr>
	  		          </thead>
		  		      <?php 
//===jika ada billing
//$query_billing = "SELECT a.kd_billing,b.nm_program, b.level_program, b.type_program, sum(net_tf+reg_fee+material_cost) as invoiced,a.dt_entry,c.nama, c.middle_name, c.family_name,a.kd_biodata FROM ves_data.vip_billing a left join ves_data.vip_mst_code_prg b on a.kd_program = b.kd_program left join ves_inc.tb_biodata c on a.kd_biodata = c.kd_biodata where a.kd_branch = '$kd_cbg' and a.dt_entry between '$date_start' and '$date_end' group by a.kd_billing order by a.kd_billing" ;
//						   /* echo $query_billing (debug SQL versi lama) dihapus */
						   
//$resource_billing = mysql_query($query_billing);
//$keluar_billing = db_num_rows($resource_billing);
					   ?>
		  		      <tbody>
		  		        <?php	
//$query_billing = "SELECT a.kd_billing,b.nm_program, a.level_program, b.type_program, sum(net_tf+reg_fee+material_cost) as invoiced,a.dt_entry,c.nama, c.middle_name, c.family_name,a.kd_biodata,a.net_tf, a.reg_fee, a.material_cost FROM ves_data.vip_billing a left join ves_data.vip_mst_code_prg b on a.kd_program = b.kd_program left join ves_inc.tb_biodata c on a.kd_biodata = c.kd_biodata where a.kd_branch = '$kd_cbg' and a.dt_entry between '$date_start' and '$date_end' group by a.kd_billing order by a.no desc" ;
$query_billing = q_set($__p_query_billing, "SELECT a.kd_billing,b.nm_program, a.level_program, b.type_program, sum(net_tf+reg_fee+material_cost) as invoiced,a.dt_entry,c.nama_lengkap,a.kd_biodata,a.net_tf, a.reg_fee, a.material_cost,a.kd_class,a.kd_program,a.kd_branch FROM ves_data.vip_billing a left join ves_data.vip_mst_code_prg b on a.kd_program = b.kd_program left join ves_data.vip_student_data c on a.kd_biodata = c.kd_biodata and a.kd_branch = c.kd_branch where a.kd_branch = ? and kd_class = '' group by a.kd_billing order by a.no desc", [(string) ($kd_center)]);	
	/* echo $query_billing (debug SQL versi lama) dihapus */	
$i = 1;		
$resource_billing = db_query_soft($query_billing, $__p_query_billing ?? []);
$keluar_billing = db_num_rows($resource_billing);				
if(num(db_num_rows($resource_billing)) > 0)
	{
	while ($row_billing  =  db_fetch($resource_billing, PDO::FETCH_NUM))
		{

		$query_bayar = q_set($__p_query_bayar, "SELECT sum(amount) as ttl  FROM ves_data.vip_billing_payment where kd_billing = ? and id_receipt <> ''", [(string) ($row_billing[0])]);
		$resource_bayar = db_query_soft($query_bayar, $__p_query_bayar ?? []);
		$keluar_bayar = db_num_rows($resource_bayar);	
		if(num(db_num_rows($resource_bayar)) > 0)
			{
			while ($row_bayar  =  db_fetch($resource_bayar, PDO::FETCH_NUM))	
				{
				$mbayar = $row_bayar[0];	
				}
			}	
	?>
		  		        <tr>
		  		          <td align=center class="style24"><?php echo e($i) ?>
	  		              <input type="text" class="form-control"  placeholder="Enter ..." name="i" 
                 	      value="<?php echo e($i) ?>" readonly></td>
		  		          <td align=center class="style24">
		  		              <input type="text" class="form-control"  placeholder="Enter ..." name="no_billing_<?php echo e($i) ?>" 
                 	      value="<?php echo e($row_billing[0]) ?>" readonly></td>
		  		          <td height="14" align=center class="style24"><?php echo e($row_billing[6]) ?></td>
		  		          <td align=center class="style24"><?php echo e($row_billing[1]) ?> <?php echo e($row_billing[2]) ?> - <?php echo e($row_billing[3]) ?></td>
		  		          <td align=center class="style24"><?php echo  number_format(num((num($row_billing[8])+num($row_billing[9])+num($row_billing[10]))),0,".",".")  ?></td>
		  		          <td align=center class="style24"><?php echo  number_format(num($mbayar),0,".",".") ?></td>
		  		          <td align=center class="style24"><input type="submit" name="Submit" value="Submit" /></td>
	  		            </tr>
		  		        <?php $i = num($i) +1; }} ?>
		  		        <tr>
		  		          <td width=12% align=center >&nbsp;</td>
		  		          <td width=27% align=center >ID Billing</td>
		  		          <td width=12% height="14" align=center >Student Name</td>
		  		          <td width="14%" align=center >Program</td>
		  		          <td width="11%" align=center >Invoiced</td>
		  		          <td width="11%" align=center >Paid</td>
		  		          <td width="13%" align=center >Action</td>
	  		            </tr>
	  		          </tbody>
		  		      <tfoot>
	  		          </tfoot>
	  		        </table>
	  		      </div>
		  		  <!-- /.box-body -->
</div>
		  		<div class="box-body">
</form>
</body>
</html>
<?php
if (($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['SAVE']))) 
{
$kd_center = in_val('kd_center', 'any');
$kodemaju = in_val('kodemaju', 'any');
$type_class = in_val('type_class', 'any');
$nm_program = in_val('nm_program', 'any');
$nm_level = in_val('nm_level', 'any');
$kode_program = in_val('kode_program', 'any');
$days = in_val('days', 'any');
$times = in_val('times', 'any');
$teacher = in_val('teacher', 'any');
$tanggal_awal = in_val('tanggal_awal', 'any');
$query = q_set($__p_query, "SELECT kodemaju FROM vip_proposed_class v where kodemaju = ? ", [(string) ($kodemaju)]);
$resource = db_query_soft($query, $__p_query ?? []);
$keluar = db_num_rows($resource);				
if(num($keluar) == 0)
	{
	$query = q_set($__p_query, "insert into vip_proposed_class (kodemaju,kd_branch,kd_program,hari,jam,teacher,mulai_tm) \r
\tvalues (? ,? ,? ,? ,? ,? ,? )", [(string) ($kodemaju), (string) ($kd_center), (string) ($kode_program), (string) ($days), (string) ($times), (string) ($teacher), (string) ($tanggal_awal)]);	
	$result=db_query_or_die("Wah error nih1", $query, $__p_query ?? []);		
	}
else
	{
	$query = q_set($__p_query, "update vip_proposed_class set kd_branch = ? ,kd_program = ? ,hari = ? ,jam = ? ,teacher = ? ,mulai_tm = ? where kodemaju = ? ", [(string) ($kd_center), (string) ($kode_program), (string) ($days), (string) ($times), (string) ($teacher), (string) ($tanggal_awal), (string) ($kodemaju)]); 
	$result=db_query_or_die("Wah error nih1", $query, $__p_query ?? []);		
	}
}
?>
