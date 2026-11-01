<?php
require_once __DIR__ . "/_lib/bootstrap.php"; csrf_guard_get(); auth_require_login(); 
include __DIR__ . "/conndb.php";
include __DIR__ . "/profiledata.php";
$nama_lengkap = $_SESSION['nama_lengkap']; 

$kdcbg = $_SESSION['kd_branch']; 
$kdc = in_val('kdc', 'get');
$kdb = in_val('kdb', 'get');
$cbg	 = in_val('cbg', 'get');

//==============list student
$query_student = q_set($__p_query_student, "SELECT v.comp_name FROM ves_inc.vpro_main_data v where no = ? ", [(string) ($kdc)]);

$resource_student= db_query_or_die('errro_8', $query_student, $__p_query_student ?? []);
$keluar_student= db_num_rows($resource_student);
if(num(db_num_rows($resource_student)) > 0)
	{
	while ($row_student=  db_fetch($resource_student, PDO::FETCH_NUM))
		{		
		$nama= $row_student[0];			
		}
	}

$query_student = q_set($__p_query_student, "SELECT t.kd_biodata, t.nama, t.middle_name, t.family_name, t.org_school FROM ves_inc.tb_biodata t where t.kd_biodata = ? ", [(string) ($browser)]);

$resource_student= db_query_or_die('errro_8', $query_student, $__p_query_student ?? []);
$keluar_student= db_num_rows($resource_student);
if(num(db_num_rows($resource_student)) > 0)
	{
	while ($row_student=  db_fetch($resource_student, PDO::FETCH_NUM))
		{
		$kd_biodata= $row_student[0];				
		$nama= $row_student[1];		
		$middle_name = $row_student[2];
		$family_name = $row_student[3];
		$org_school = $row_student[4];
			
		$student_lengkap_terpilih ="$nama $middle_name $family_name - $org_school";
			
		}
	}	

//====================

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
</head>
  <!-- Left side column. contains the logo and sidebar -->

<body class="hold-transition skin-blue sidebar-mini">

<?php //    include __DIR__ . "/left.php";	 ?>  

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
     <div class="box box-warning">
<div class="box-body">
      <h3>VPRO CUSTOMER PROFILE</h3>
</div>
     </div>
    </section>
 
    <!-- Main content -->
<section class="content">
  <div class="row">
        <!-- left column -->

        <!--/.col (left) -->
        <!-- right column -->



	<div class="col-md-12">
	  <div class="box box-warning">
	    <div class="box-body">

	          <div class="col-md-10">
	            <div class="form-group">
	              <label>COMPANY Name</label>
	              <input type="text" ang="en-150" class="form-control"  placeholder="Enter ..." name="student_name" 
                 	      value="<?php echo e($nama) ?>" readonly>
                </div>
              </div>
		<?php 
//===jika ada billing
$query_billing = q_set($__p_query_billing, "SELECT a.kd_billing,b.nm_program, b.level_program, b.type_program, sum(net_tf+reg_fee+material_cost) as invoiced,a.private_pax FROM ves_data.vip_billing a left join ves_data.vip_mst_code_prg b on a.kd_program = b.kd_program where a.kd_biodata = ? and a.kd_billing = ? and a.level_program  = b.level_program ", [(string) ($kdc), (string) ($kdb)]);
$resource_billing = db_query_soft($query_billing, $__p_query_billing ?? []);
$keluar_billing = db_num_rows($resource_billing);	
if(num(db_num_rows($resource_billing)) > 0)
		
	?>

	  <div class="col-md-10">
		<div class="form-group">
		  <label>Billing Statement List</label>
		</div>				
	  </div>
	  <div class="col-md-10">
	    <div class="form-group">
	      <table width="100%" class="table table-bordered table-striped" id="example1">
	        <thead>
	          <tr>
	            <td width=5% height="14" align=center >ID Billing</td>
	            <td width="32%" align=center >Program</td>
	            <td width="13%" align=center >Invoiced</td>
	            <td width="15%" align=center >Paid</td>
	            <td width="15%" align=center >Pax</td>
	            <td width="15%" align=center >Class Status</td>
	            </tr>
            </thead>
	        <tbody>
<?php
{
		while ($row_billing  =  db_fetch($resource_billing, PDO::FETCH_NUM))
			{
			$query_bayar = q_set($__p_query_bayar, "SELECT sum(amount) as ttl  FROM ves_data.vip_billing_payment where kd_biodata = ? and kd_billing = ? and id_receipt <> ''", [(string) ($browser), (string) ($row_billing[0])]);

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
	            <td height="14" align=center class="style24"><a href="vipbill.php?idb=<?php echo e(u($row_billing[0]))  ?>&kdb=<?php echo e(u($browser)) ?>&st=1"><?php echo e($row_billing[0]) ?></a></td>
	            <td align=center class="style24"><?php echo e($row_billing[1]) ?> <?php echo e($row_billing[2]) ?> - <?php echo e($row_billing[3]) ?></td>
	            <td align=center class="style24"><?php echo  number_format(num($row_billing[4]),0,".",".")  ?></td>
	            <td align=center class="style24"><?php echo  number_format(num($mbayar),0,".",".") ?></td>
	            <td align=center class="style24"><?php echo  e($row_billing[5]) ?></td>
	            <td align=center class="style24">&nbsp;</td>
	            </tr>
              <?php }
				?>

            <tfoot>
            </tfoot>
          </table>
	    </div>
      </div>
	  <?php }  ?>	              
        </div>
      </div>
	    </div>
	<div class="col-md-12">
	  <div class="box box-warning">
	    <div class="box-body">
	      <?php 
//===jika ada billing
$query_billing = q_set($__p_query_billing, "SELECT t.no,t.kd_biodata, t.nama, t.hp, t.e_mail, t.vgo_group, t.vgo_status,t.kd_branch  FROM ves_inc.tb_biodata t where t.vgo_group = ? order by no desc", [(string) ($kdb)]);
$resource_billing = db_query_soft($query_billing, $__p_query_billing ?? []);
$keluar_billing = db_num_rows($resource_billing);	
if(num(db_num_rows($resource_billing)) > 0)
		
	?>
	      <div class="col-md-10">
	        <div class="form-group">
	          <label>Participant List</label>
            </div>
          </div>
	      <div class="col-md-10">
	        <div class="form-group">
	          <table width="100%" class="table table-bordered table-striped" id="example2">
	            <thead>
	              <tr>
	                <td width=18% height="14" align=center >Name</td>
	                <td width="11%" align=center >Contact Number</td>
	                <td width="10%" align=center >E-Mail</td>
	                <td width="12%" align=center >Placement Test Score</td>
	                <td width="12%" align=center >Class</td>
	                <td width="13%" align=center >Action</td>
                  </tr>
                </thead>
	            <tbody>
<form method="POST"><?php echo csrf_field(); ?>
	            
<tr>
	                <td height="14" align=center class="style24">      <div class="form-group">
        <input name="vpro_name"  class="form-control"  type="text" size="50" value="<?php echo e($vpro_name) ?>" />
      </div></td>
	                <td align=center class="style24"><div class="form-group">
	                  <input name="vpro_hp"  class="form-control"  type="text" size="50" value="<?php echo e($vpro_hp) ?>" />
                    </div></td>
	                <td align=center class="style24"><div class="form-group">
	                  <input name="vpro_email"  class="form-control"  type="text" size="50" value="<?php echo e($vpro_email) ?>" />
                    </div></td>
	                <td align=center class="style24">&nbsp;</td>
	                <td align=center class="style24">&nbsp;</td>
	                <td align=center class="style24"> <input name="Save" type="submit" id="Save"  class="form-control"  value="Save" /></td>
                  </tr>
					</form>   
<?php 
if (isset($_POST['Save'])) 
	{  
	$kodetgl = date('ymd');	
	$query = q_set($__p_query, "SELECT MAX(t.no) as max_id FROM ves_inc.tb_biodata t where kd_branch = ? and (kd_biodata is not null or kd_biodata <>'')", [(string) ($cbg)]);
	$result = db_query_soft($query, $__p_query ?? []);
	$data = db_fetch($result);
	$id_max = $data['max_id'];
	$sort_num = $id_max;
	$sort_num++;
	$new_code = sprintf($sort_num);
	$kode_biodata = "$cbg$kodetgl$new_code";
	
	$vpro_name = in_val('vpro_name', 'post');
	$vpro_hp = in_val('vpro_hp', 'post');
	$vpro_email = in_val('vpro_email', 'post');
		
	$query = q_set($__p_query, "insert into ves_inc.tb_biodata (kd_biodata, nama, hp, e_mail, vgo_group, kd_branch) values (? ,? ,? ,? ,? ,? )", [(string) ($kode_biodata), (string) ($vpro_name), (string) ($vpro_hp), (string) ($vpro_email), (string) ($kdb), (string) ($cbg)]);
	$resource_simpan= db_query_or_die('errro_simpan1', $query, $__p_query ?? []);
	$query = q_set($__p_query, "insert into ves_data.vip_student_data (kd_biodata, nama_lengkap,  kd_branch) values (? ,? ,? )", [(string) ($kode_biodata), (string) ($vpro_name), (string) ($cbg)]);
		
	$resource_simpan= db_query_or_die('errro_simpan2', $query, $__p_query ?? []);
		
	}
?>
<?php
{
		while ($row_billing  =  db_fetch($resource_billing, PDO::FETCH_NUM))
			{

				
	?>
	              <tr>
	                <td height="14" align=center class="style24"><a href="vipbill.php?idb=<?php echo e(u($row_billing[0]))  ?>&kdb=<?php echo e(u($browser)) ?>&st=1"><?php echo e($row_billing[2]) ?></a></td>
	                <td align=center class="style24"><?php echo e($row_billing[3]) ?></td>
	                <td align=center class="style24"><?php echo e($row_billing[4]) ?></td>
	                <td align=center class="style24">&nbsp;</td>
	                <td align=center class="style24"><?php echo  number_format(num($mbayar),0,".",".") ?></td>
	                <td align=center class="style24">&nbsp;</td>
                  </tr>
	              <?php }
				?>
                <tfoot>
                </tfoot>
              </table>
            </div>
          </div>
	      <div class="col-md-8">
	        <div class="form-group"><a href="vipbill.php?kdb=<?php echo e(u($kd_biodata)) ?>&st=1">
	          <label>New Billing Statement</label>
            </div>
          </div>
	      <?php }  ?>
        </div>
      </div>
    </div>
		</div>
	
	
	</div>
	  </form> 

</body>
</html>
<?php 
if (isset($_GET['Display'])) 
	{
		$kdb = in_val('browser', 'get');
		echo "<script type=\"text/javascript\">\n";
		echo "window.location = ('prestuvip.php?kdb=" . e(u($kdb)) . "&st=1');\n";				
		echo "</script>";
	}
?>