<?php
require_once __DIR__ . "/_lib/bootstrap.php"; csrf_guard_get(); auth_require_login(); 
include __DIR__ . "/conndb.php";
include __DIR__ . "/profiledata.php";
$nama_lengkap = $_SESSION['nama_lengkap']; 
$kdcbg = $_SESSION['kd_branch']; 
$id_cust = in_val('id_cust', 'any');

$upd = 0;

$comp_name = in_val('comp_name', 'any');
$cbg = in_val('cbg', 'any');
$address = in_val('address', 'any');
$city = in_val('city', 'any');
$e_mail = in_val('e_mail', 'any');
$phone_1 = in_val('phone_1', 'any');
$cp = in_val('cp', 'any');
$cp_dept = in_val('cp_dept', 'any');
$cp_hp = in_val('cp_hp', 'any');

$type_class = in_val('type_class', 'any');
$nm_program = in_val('nm_program', 'any');
$nm_level = in_val('nm_level', 'any');
$material_book = in_val('material_book', 'any');
$private_pax = in_val('private_pax', 'any');
$kode_program = in_val('kode_program', 'any');

$material_book = in_val('material_book', 'any');

$material_fee = in_val('material_fee', 'any');
if($nm_program != '' and $type_class !='')
{
	$query_kode_program = q_set($__p_query_kode_program, "SELECT kd_program FROM ves_data.vip_mst_code_prg where nm_program = ? and type_program = ? ", [(string) ($nm_program), (string) ($type_class)]);			
	$resource_kode_program = db_query_or_die('errro_7', $query_kode_program, $__p_query_kode_program ?? []);
	while ($row_kode_program=  db_fetch($resource_kode_program, PDO::FETCH_NUM))
		{
		$kode_program =   $row_kode_program[0];
		}   
}	
$material_book_pax = in_val('material_book_pax', 'any');
$tf_net = in_val('tf_net', 'any');
$material_fee = in_val('material_fee', 'any');
$kd_cbg = in_val('kd_cbg', 'any');
if (num($kd_cbg) ==351){$cbg = 'VPRO Sby';}
if (num($kd_cbg) ==355){$cbg = 'VPRO Dps';}
if (num($kd_cbg) ==358){$cbg = 'VPRO Mlg';}
if (num($kd_cbg) ==357){$cbg = 'VPRO Jkt';}
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Vista Customer System Management</title>
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
  <!-- Left side column. contains the logo and sidebar -->
<?php //  include __DIR__ . "/left.php";	 ?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
     <div class="box box-warning">
<div class="box-body">
	<h3>VPRO Billing Statement</h3>
	<h5>Invoice Number : <?php echo e($idb) ?></h5>
</div>
     </div>
    </section>
   <!-- Main content -->
<section class="content">
  <div class="row">
        <!-- left column -->

        <!--/.col (left) -->
        <!-- right column -->

<form name="myform" id="myform" method="post"><?php echo csrf_field(); ?>

<div class="col-md-12">
<div class="box box-warning">
<div class="box-body">
 <span class="form-group">
  <input type="text" ang="en-150"  name="kdcbg" 
                 	      value="<?php echo e($kdcbg) ?>" hidden="hidden">
</span>
  <div class="col-md-6">
    <div class="form-group">
      <label for="exampleInputEmail1">Searching Company</label>
      <input type="text" class="form-control" id="exampleInputEmail1" placeholder="Write Down Company Name" name="id_cust" list="listcustomer" autocomplete="OFF"  onchange="this.form.submit()" value="<?php echo e($namadipilih) ?>"  >
      <datalist id="listcustomer"   onchange="this.form.submit()"  >
        <?php 
	$query_cust = q_set($__p_query_cust, "SELECT no, comp_name, address, city FROM ves_inc.vpro_main_data order by comp_name");
	$resource = db_query_or_die('errro_217', $query_cust, $__p_query_cust ?? []);	
	while($row = db_fetch($resource, PDO::FETCH_NUM)) { ?>
        <option value="<?php echo e($row['0']); ?>"><?php echo e($row['1']); ?> <?php echo e($row['2']); ?><?php echo e($row['3']); ?></option>
        <?php } ?>
    </datalist>
    </div>
  </div>
	</div></div>
<div class="box box-warning">
<div class="box-body">
 <span class="form-group">
  <input type="text" ang="en-150"  name="kdcbg" 
                 	      value="<?php echo e($kdcbg) ?>" hidden="hidden">
</span>
  <div class="col-md-3">
    <div class="form-group">
      <label>Office</label>
<select class="form-control"  name="kd_cbg">
        <option value="351">VPRO Sby</option>
        <option value="355">VPRO Dps</option>
        <option value="358">VPRO Mlg</option>
        <option value="357">VPRO Jkt</option>
        <option selected value=<?php echo e($kd_cbg) ?>><?php echo  e($cbg) ?></option>
      </select>
    </div>
  </div>
  <div class="col-md-6">
    <div class="form-group">
      <label for="exampleInputEmail1">Company Name</label>
      <input type="text" class="form-control" id="exampleInputEmail1" placeholder="Enter email" name="comp_name"  value="<?php echo e($comp_name) ?>"  >
      <input type="text"  name="id_cust" value="<?php echo e($id_cust) ?>"  >
      <input type="text"  name="upd" value="<?php echo e($upd) ?>"  >
    </div>
  </div>
  <span class="form-group">
  <input type="hidden" ang="en-150" name="kdb" 
                 	      value="<?php echo e($kdb) ?>" hidden="hidden">
<input type="hidden" ang="en-150"   name="enroll_date" 
                 	      value="<?php echo e($enroll_date) ?>" hidden="hidden">
  </span>
  <div class="col-md-6">
    <div class="form-group">
      <label>Address</label>
      <input name="address"  class="form-control"  type="text" size="90" value="<?php echo e($address) ?>" />
    </div>
  </div>
  <div class="col-md-3">
    <div class="form-group">
      <label>City</label>
      <select class="form-control" name="city">
        <option>JAKARTA</option>
        <option>BANDUNG</option>
        <option>BALI</option>
        <option>SURABAYA</option>
        <option>MALANG</option>
        <option>MEDAN</option>
        <option selected><?php echo  e($city) ?></option>
      </select>
    </div>
  </div>
  <div class="col-md-3">
    <div class="form-group">
      <label>E-Mail</label>
      <input name="e_mail"  class="form-control"  type="text" size="90" value="<?php echo e($e_mail)  ?>" />
    </div>
  </div>
  <div class="col-md-3">
    <div class="form-group">
      <label>Phone Number</label>
      <input name="phone_1"  class="form-control"  type="text" size="90" value="<?php echo e($phone_1)  ?>" />
    </div>
  </div>

    <div class="col-md-3">
      <div class="form-group">
        <label>Contact Person</label>
        <input name="cp"  class="form-control"  type="text" size="90" value="<?php echo e($cp)  ?>" />
      </div>
    </div>
    <div class="col-md-3">
      <div class="form-group">
        <label>Departmen / Position</label>
        <input name="cp_dept"  class="form-control"  type="text" size="90" value="<?php echo e($cp_dept) ?>" />
      </div>
    </div>
    <div class="col-md-3">
      <div class="form-group">
        <label>Handphone</label>
        <input name="cp_hp"  class="form-control"  type="text" size="90" value="<?php echo e($cp_hp) ?>" />
      </div>
    </div>

  <span class="form-group">
  <input type="text" ang="en-150"   name="st" 
                 	      value="<?php echo e($st) ?>" hidden="hidden" >
  </span><span class="form-group">
  <input type="hidden" ang="en-150"   name="idb" 
                 	      value="<?php echo e($idb) ?>" >
  </span></div>
	  </div>
<div class="box box-warning">		
<div class="box-body">
  <div class="col-md-12">
    <div class="form-group">
      <label>PROGRAM INFO</label>
    </div>
  </div>
  <div class="col-md-2">
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
									$query_nm_program = q_set($__p_query_nm_program, "SELECT distinct nm_program FROM ves_data.vip_mst_code_prg WHERE type_program = ? and nm_program like 'V-PRO%'", [(string) ($type_class)]);
								$resource_nm_program = db_query_or_die('errro_7', $query_nm_program, $__p_query_nm_program ?? []);
								while ($row_nm_program=  db_fetch($resource_nm_program, PDO::FETCH_NUM))
									{
							  		echo '<option value="'.e($row_nm_program[0]).'">'.e($row_nm_program[0]).'</option>';
							  		}      ?>
        <option selected><?php echo  e($nm_program) ?></option>
      </select>
    </div>
  </div>
  <div class="col-md-2">
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
  <div class="col-md-1">
    <div class="form-group">
      <label> Pax</label>
      <input type="NUMBER" name="private_pax"  class="form-control" value = "<?php echo e($private_pax)  ?>"/>
    </div>
  </div>
  <div class="col-md-2">
    <div class="form-group">
      <label>Code</label>
      <input type="text" ang="en-150" class="form-control"  placeholder="Enter ..." name="kode_program" 
                 	      value="<?php echo e($kode_program) ?>" readonly>
    </div>
  </div>
  <div class="col-md-3">
    <div class="form-group">
      <label>Total Tuition Fee (Netto)</label>
      <input type="text" name="tf_net"  class="form-control" value = "<?php echo e($tf_net)  ?>"/>
    </div>
</div>
  <div class="col-md-2">
    <div class="form-group">
      <label>Material Book</label>
      <select name="material_book" id="program_clasifie3" class="form-control"   onChange="this.form.submit()">
        <?php
								$query_exam = q_set($__p_query_exam, "SELECT v.title_material, v.group_material FROM vip_material_stock v where group_material = ? group by title_material", [(string) ($nm_level)]);
								$resource_exam = db_query_or_die('errro_7', $query_exam, $__p_query_exam ?? []);
								while ($row_exam=  db_fetch($resource_exam, PDO::FETCH_NUM))
									{
							  		echo '<option value="'.e($row_exam[0]).'">'.e($row_exam[0]).'</option>';
							  		}      ?>
							  		<option>No</option>       
        <option selected="selected">          <?php  echo e($material_book)    ?>          </option>
      </select>
      <input type="hidden" ang="en-150" class="form-control"  placeholder="Enter ..." name="material_fee" 
                 	      value="<?php echo e($material_fee) ?>" hidden="">
    </div>
</div>
  <div class="col-md-1">
    <div class="form-group">
      <label> Pax</label>
      <input type="NUMBER" name="material_book_pax"  class="form-control" value = "<?php echo e($material_book_pax)   ?>"/>
    </div>
  </div>
 <?php //==== 
if ($type_class == 'PRI')
{
	?>
 <?php }//==== ?>
 <input type="hidden" name="tf" id="textfield" value="<?php echo e($tf) ?>" hidden="hidden" >
 <div class="col-md-3">
   <div class="form-group">
<label>Total Material Book Fee</label>
          <input type="text" name="material_fee"  class="form-control" value = "<?php echo e($material_fee)  ?>"/>
        </div>
</div>
      <input type="hidden" name="tf_nett" id="textfield2" value="<?php echo e($tf_nett) ?>">
      <input type="hidden" name="discount_tf" id="textfield3" value="<?php echo e($discount_tf) ?>" hidden="">
</div>
	  </div>
<div class="box box-warning">
	  <div class="box-body">
		    <div class="col-md-6">
		      <div class="form-group">
		        <label>SC Name</label>
		        <input type="text" name="sc"  class="form-control" value = "<?php echo e($sc)  ?>"/>
		      </div>
	        </div>    
		    <div class="row"></div>

      </div>
    </div>
		<div class="box box-warning">
		  <div class="box-body">
		    <div class="row">
		      <div class="col-md-2">
		        <div class="form-group">
		          <label></label>
		          <input name="Save" type="submit" id="Save"  class="form-control"  value="Save" />
	            </div>
	          </div>
	          	        <div class="col-md-2">
	          <div class="form-group">
	       
	           <input name="Print" type="submit" id="Print"  class="form-control"  value="Print" />
              </div>
            </div></a>
            
		    
		    <div class="col-md-2">
		      <div class="form-group">
	        <a href="profile_newvip.php?kdb=<?php echo e(u($kdb)) ?>" onClick="window.open('profile_newvip.php?kdb=<?php echo e(u($kdb)) ?>')"> 
		        <input name="Save2" type="submit" id="Save3"  class="form-control"  value="Exit" /></a>
		        </div>
		      </div>
		    </div>

		  </div>
	  </div>
  </div>
</form>
</body>
</html>
<?php 
if (($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['Save']))) 
	{
	$saat_ini = date('Y-m-d H:i:s');
	$kd_branch = in_val('kd_cbg', 'any');
	$comp_name = in_val('comp_name', 'any');
	$id_cust = in_val('id_cust', 'any');
	$comp_name = in_val('comp_name', 'any');
	$cbg = in_val('cbg', 'any');
	$address = in_val('address', 'any');
	$city = in_val('city', 'any');
	$e_mail = in_val('e_mail', 'any');
	$phone_1 = in_val('phone_1', 'any');
	$cp = in_val('cp', 'any');
	$cp_dept = in_val('cp_dept', 'any');
	$cp_hp = in_val('cp_hp', 'any');

	$upd = in_val('upd', 'any');
	$type_class = in_val('type_class', 'any');
	$nm_program = in_val('nm_program', 'any');
	$nm_level = in_val('nm_level', 'any');
	$material_book = in_val('material_book', 'any');
	$private_pax = in_val('private_pax', 'any');
	$kode_program = in_val('kode_program', 'any');

	$material_book = in_val('material_book', 'any');
	$material_book_pax = in_val('material_book_pax', 'any');
	$material_fee = in_val('material_fee', 'any');
	$tf_net = in_val('tf_net', 'any');		
	$sc = in_val('sc', 'any');	
	$hari=date("d");$bulan=date("m");$tahun=date("Y");
	$hari_ini = "$tahun-$bulan-$hari";	
	if (num($upd) == 0)
		{
		$query = q_set($__p_query, "insert into ves_inc.vpro_main_data (comp_name,center,address,city,e_mail,phone_1,cp,cp_dept,cp_hp) values (? ,\r
\t\t? ,? ,? ,? ,? ,? ,? ,? ) ", [(string) ($comp_name), (string) ($cbg), (string) ($address), (string) ($city), (string) ($e_mail), (string) ($phone_1), (string) ($cp), (string) ($cp_dept), (string) ($cp_hp)]);
		$resource = db_query_or_die('errro_simpan1', $query, $__p_query ?? []);
//===
			
		$query_ambil_kode = q_set($__p_query_ambil_kode, "SELECT no FROM ves_inc.vpro_main_data where  comp_name = ? and center = ? and address = ? and city =? and phone_1 = ? ", [(string) ($comp_name), (string) ($cbg), (string) ($address), (string) ($city), (string) ($phone_1)]);
		$resource_ambil_kode = db_query_or_die('errro_last_billing', $query_ambil_kode, $__p_query_ambil_kode ?? []);
		if(num(db_num_rows($resource_ambil_kode)) > 0)
			{	
				while ($row_ambil_kode=  db_fetch($resource_ambil_kode, PDO::FETCH_NUM))
					{
					$kd_biodata = $row_ambil_kode[0];
					}
			}
		$query = q_set($__p_query, "insert into ves_data.vip_student_data ( nama_lengkap, kd_branch,kd_biodata) values (? ,\r
\t\t? ,? ) ", [(string) ($comp_name), (string) ($kd_branch), (string) ($kd_biodata)]);
		$resource = db_query_or_die('errro_simpan1', $query, $__p_query ?? []);			
			
			
//=		if (db_num_rows($resource_nm_cust) > 0)
			$bulan=date("m");
				if($bulan =='01'){$bln_rom="I";}if($bulan =='02'){$bln_rom="II";}	if($bulan =='03'){$bln_rom="III";}	if($bulan =='04'){$bln_rom="IV";}
	if($bulan =='05'){$bln_rom="V";}	if($bulan =='06'){$bln_rom="VI";}	if($bulan =='07'){$bln_rom="VII";}	if($bulan =='08'){$bln_rom="VIII";}
	if($bulan =='09'){$bln_rom="IX";}	if($bulan =='10'){$bln_rom="X";}	if($bulan =='11'){$bln_rom="XI";}	if($bulan =='12'){$bln_rom="XII";}
			$query_last_billing = q_set($__p_query_last_billing, "SELECT kd_billing FROM ves_data.vip_billing where  kd_branch = ? order by no desc limit 1", [(string) ($kd_branch)]);
			$resource_last_billing = db_query_or_die('errro_last_billing', $query_last_billing, $__p_query_last_billing ?? []);
			if(num(db_num_rows($resource_last_billing)) > 0)
				{
				while ($row_last_billing=  db_fetch($resource_last_billing, PDO::FETCH_NUM))
					{
					$kd_billing = $row_last_billing[0];
					$ambilangka =  substr($kd_billing,0,-4);
					#ketemu angka awal(angka sebelumnya) + dengan 1
					$nextangka=num($ambilangka)+1;
					#menhitung jumlah karakter
					$digit=strlen($nextangka);
					if(!$kd_billing){ $nol='000'; }elseif(num($digit)==1){ $nol='000'; }	elseif(num($digit)==2){ $nol='00'; }	elseif(num($digit)==3)
					{ $nol='0'; }	
					$nomor_baru = $nol.$nextangka."/VPRO/".$kd_branch."/".$bln_rom."-".$tahun;	
					}
				}
			else
				{
				$nomor_baru =  "0001/VPRO/".$kd_branch."/".$bln_rom."-".$tahun;
				}
			
			
		$query = q_set($__p_query, "insert into ves_data.vip_billing (kd_billing, kd_biodata, kd_program, level_program, private_pax, material, private_hours, material_cost,net_tf,kd_branch,sc, pic, dt_entry) values (? ,? ,? ,? ,? ,? ,? ,? ,? ,? ,? ,? ,? ) ", [(string) ($nomor_baru), (string) ($kd_biodata), (string) ($kode_program), (string) ($nm_level), (string) ($private_pax), (string) ($material_book), (string) ($material_book_pax), (string) ($material_fee), (string) ($tf_net), (string) ($kd_branch), (string) ($sc), (string) ($nama_lengkap), (string) ($hari_ini)]);

		$resource = db_query_or_die('errro_simpan2', $query, $__p_query ?? []);
		
		echo "<script type=\"text/javascript\">\n";
		echo "alert('VPRO Billing Submitted');\n";
		echo "window.location = ('vprobill.php?idb=" . e(u($idb)) . "&kdb=" . e(u($kdb)) . "&st=" . e(u($st)) . "');\n";				
		echo "</script>";
			
		}
	else
		{
		echo "<script type=\"text/javascript\">\n";
		echo "alert('" . e($pesan) . "');\n";
		echo "</script>";
		}
	}
if (($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['Print']))) 
	{
	if ($idb !='')
		{

			echo "<script type=\"text/javascript\">\n";
			echo "window.open('vprobillprint.php?idb=" . e(u($idb)) . "&kdb" . e($kdb) . "','width=560,height=340,toolbar=0,menubar=0,location=0');\n";				
			echo "</script>";		

		}
	}
?>