<?php
require_once __DIR__ . "/_lib/bootstrap.php"; csrf_guard_get(); auth_require_login(); 
include __DIR__ . "/conndb.php"; 
include __DIR__ . "/profiledata.php";
$hari=date("d");
$bulan=date("m");
$tahun=date("Y");
$hari_ini = "$tahun-$bulan-$hari";
$kdb = in_val('kdb', 'any');
$ins = in_val('ins', 'any');	
$nub = in_val('nub', 'any');	
$upd = in_val('upd', 'any');
$weak_l = in_val('weak_l', 'any');
$weak_s = in_val('weak_s', 'any');
$weak_r = in_val('weak_r', 'any');
$weak_w = in_val('weak_w', 'any');
$target_score = in_val('target_score', 'any');
$query_data = q_set($__p_query_data, "SELECT v.nama_lengkap,kd_biodata FROM ves_data.vip_student_data v where kd_biodata = ? ", [(string) ($kdb)]);
$resource_data = db_query_soft($query_data, $__p_query_data ?? []);	
if(num(db_num_rows($resource_data)) > 0)
	{
	while ($row_data  =  db_fetch($resource_data, PDO::FETCH_NUM))
		{
		$nama_lengkap_student = $row_data[0];
		$kd_biodata = $row_data[1];
		}
	}
else
	{
	$query_data = q_set($__p_query_data, "SELECT concat_ws(' ',nama, middle_name, family_name) FROM ves_inc.tb_biodata  where kd_biodata = ? ", [(string) ($kdb)]);
$resource_data = db_query_soft($query_data, $__p_query_data ?? []);	
if(num(db_num_rows($resource_data)) > 0)
	{
	while ($row_data  =  db_fetch($resource_data, PDO::FETCH_NUM))
		{
		$nama_lengkap_student = $row_data[0];
		$kd_biodata = $row_data[1];
		}
	}
	
	}
if(num($upd) == 1)
	{
	$query_upd = q_set($__p_query_upd, "select  L,S,R,W,other,total,remark , test_date, prg_type,prg_recom,prg_recom_2,prg_recom_3,prg_recom_4,prg_recom_5,durasi from ves_data.vip_class_score_profile   where no = ? ", [(string) ($nub)]);
	$resource_upd = db_query_soft($query_upd, $__p_query_upd ?? []);	
	while ($row_upd  =  db_fetch($resource_upd, PDO::FETCH_NUM))
		{
		$tgl_testing = $row_upd[7];
		$prg_type = $row_upd[8];
		$l = $row_upd[0];
		$st = $row_upd[4];
		$sp = $row_upd[1];
		$r = $row_upd[2];
		$w = $row_upd[3];
		$ttl =$row_upd[5];
		$note_score = $row_upd[6];
		$kd_prg_recom_1 = $row_upd[9];
				$kd_prg_recom_2 = $row_upd[10];	
		$duration=$row_upd[14];
if($kd_prg_recom_1 !='')
	{
	$query_prg_recom_dipilih_1 = q_set($__p_query_prg_recom_dipilih_1, "SELECT v.prg_recomm, v.jam FROM ves_data.vip_recomm_list v where id =? ", [(string) ($kd_prg_recom_1)]);
	$resource_prg_recom_dipilih_1 = db_query_soft($query_prg_recom_dipilih_1, $__p_query_prg_recom_dipilih_1 ?? []);	
	if(num(db_num_rows($resource_prg_recom_dipilih_1)) > 0)
		{
		while ($row_prg_recom_dipilih_1  =  db_fetch($resource_prg_recom_dipilih_1, PDO::FETCH_NUM))
			{	
			$prg_recom_dipilih_1 =$row_prg_recom_dipilih_1[0];
			}
		}
}
		$kd_prg_recom_2 = $row_upd[10];	
if($kd_prg_recom_2 !='')
	{
	$query_prg_recom_dipilih_2 = q_set($__p_query_prg_recom_dipilih_2, "SELECT v.prg_recomm, v.jam FROM ves_data.vip_recomm_list v where id =? ", [(string) ($kd_prg_recom_2)]);
	$resource_prg_recom_dipilih_2 = db_query_soft($query_prg_recom_dipilih_2, $__p_query_prg_recom_dipilih_2 ?? []);	
	if(num(db_num_rows($resource_prg_recom_dipilih_1)) > 0)
		{
		while ($row_prg_recom_dipilih_2  =  db_fetch($resource_prg_recom_dipilih_2, PDO::FETCH_NUM))
			{	
			$prg_recom_dipilih_2 =$row_prg_recom_dipilih_2[0];
			}
		}
}
		$kd_prg_recom_3 = $row_upd[11];	

if($kd_prg_recom_3 !='')
	{
	$query_prg_recom_dipilih_3 = q_set($__p_query_prg_recom_dipilih_3, "SELECT v.prg_recomm, v.jam FROM ves_data.vip_recomm_list v where id =? ", [(string) ($kd_prg_recom_3)]);
	$resource_prg_recom_dipilih_3 = db_query_soft($query_prg_recom_dipilih_3, $__p_query_prg_recom_dipilih_3 ?? []);	
	if(num(db_num_rows($resource_prg_recom_dipilih_1)) > 0)
		{
		while ($row_prg_recom_dipilih_3  =  db_fetch($resource_prg_recom_dipilih_3, PDO::FETCH_NUM))
			{	
			$prg_recom_dipilih_3 =$row_prg_recom_dipilih_3[0];
			}
		}
}
		$kd_prg_recom_4 = $row_upd[12];	

if($kd_prg_recom_4 !='')
	{
	$query_prg_recom_dipilih_4 = q_set($__p_query_prg_recom_dipilih_4, "SELECT v.prg_recomm, v.jam FROM ves_data.vip_recomm_list v where id =? ", [(string) ($kd_prg_recom_4)]);
	$resource_prg_recom_dipilih_4 = db_query_soft($query_prg_recom_dipilih_4, $__p_query_prg_recom_dipilih_4 ?? []);	
	if(num(db_num_rows($resource_prg_recom_dipilih_1)) > 0)
		{
		while ($row_prg_recom_dipilih_4  =  db_fetch($resource_prg_recom_dipilih_4, PDO::FETCH_NUM))
			{	
			$prg_recom_dipilih_4 =$row_prg_recom_dipilih_4[0];
			}
		}
}
		$kd_prg_recom_5 = $row_upd[13];	

if($kd_prg_recom_5 !='')
	{

	$query_prg_recom_dipilih_5 = q_set($__p_query_prg_recom_dipilih_5, "SELECT v.prg_recomm, v.jam FROM ves_data.vip_recomm_list v where id =? ", [(string) ($kd_prg_recom_5)]);
	$resource_prg_recom_dipilih_5 = db_query_soft($query_prg_recom_dipilih_5, $__p_query_prg_recom_dipilih_5 ?? []);	
	if(num(db_num_rows($resource_prg_recom_dipilih_1)) > 0)
		{
		while ($row_prg_recom_dipilih_5  =  db_fetch($resource_prg_recom_dipilih_5, PDO::FETCH_NUM))
			{	
			$prg_recom_dipilih_5 =$row_prg_recom_dipilih_5[0];
			}
		}
}	
		
		}
 	}
else
{
$tgl_testing = in_val('tgl_testing', 'any');if($tgl_testing == ''){$tgl_testing = $hari_ini;}
$prg_type = in_val('prg_type', 'any');
$l = in_val('l', 'any');
$st = in_val('st', 'any');
$sp = in_val('sp', 'any');
$r = in_val('r', 'any');
$w = in_val('w', 'any');
$ttl = in_val('ttl', 'any');
$sat_eng = in_val('sat_eng', 'any');
$sat_math = in_val('sat_math', 'any');
	
$note_score = in_val('note_score', 'any');
$prg_recom_1 = in_val('prg_recom_1', 'any');
$kd_prg_recom_1 = $prg_recom_1;
$duration = in_val('duration', 'any');
if($prg_recom_1 ==''){$kd_prg_recom_1 = in_val('kd_prg_recom_1', 'any');$prg_recom_1 =$kd_prg_recom_1;}
if($prg_recom_1 !='')
	{
	$query_prg_recom_dipilih_1 = q_set($__p_query_prg_recom_dipilih_1, "SELECT v.prg_recomm, v.jam FROM ves_data.vip_recomm_list v where id =? ", [(string) ($prg_recom_1)]);
	$resource_prg_recom_dipilih_1 = db_query_soft($query_prg_recom_dipilih_1, $__p_query_prg_recom_dipilih_1 ?? []);	
	if(num(db_num_rows($resource_prg_recom_dipilih_1)) > 0)
		{
		while ($row_prg_recom_dipilih_1  =  db_fetch($resource_prg_recom_dipilih_1, PDO::FETCH_NUM))
			{	
			$prg_recom_dipilih_1 =$row_prg_recom_dipilih_1[0];
			}
		}
}
$prg_recom_2 = in_val('prg_recom_2', 'any');
$kd_prg_recom_2 = $prg_recom_2;

if($prg_recom_2 ==''){$kd_prg_recom_2 = in_val('kd_prg_recom_2', 'any');$prg_recom_2 =$kd_prg_recom_2;}
if($prg_recom_2 !='')
	{
	$query_prg_recom_dipilih_2 = q_set($__p_query_prg_recom_dipilih_2, "SELECT v.prg_recomm, v.jam FROM ves_data.vip_recomm_list v where id =? ", [(string) ($prg_recom_2)]);
	$resource_prg_recom_dipilih_2 = db_query_soft($query_prg_recom_dipilih_2, $__p_query_prg_recom_dipilih_2 ?? []);	
	if(num(db_num_rows($resource_prg_recom_dipilih_1)) > 0)
		{
		while ($row_prg_recom_dipilih_2  =  db_fetch($resource_prg_recom_dipilih_2, PDO::FETCH_NUM))
			{	
			$prg_recom_dipilih_2 =$row_prg_recom_dipilih_2[0];
			}
		}
}
$prg_recom_3 = in_val('prg_recom_3', 'any');
$kd_prg_recom_3 = $prg_recom_3;

if($prg_recom_3 ==''){$kd_prg_recom_3 = in_val('kd_prg_recom_3', 'any');$prg_recom_3 =$kd_prg_recom_3;}
if($prg_recom_3 !='')
	{
	$query_prg_recom_dipilih_3 = q_set($__p_query_prg_recom_dipilih_3, "SELECT v.prg_recomm, v.jam FROM ves_data.vip_recomm_list v where id =? ", [(string) ($prg_recom_3)]);
	$resource_prg_recom_dipilih_3 = db_query_soft($query_prg_recom_dipilih_3, $__p_query_prg_recom_dipilih_3 ?? []);	
	if(num(db_num_rows($resource_prg_recom_dipilih_1)) > 0)
		{
		while ($row_prg_recom_dipilih_3  =  db_fetch($resource_prg_recom_dipilih_3, PDO::FETCH_NUM))
			{	
			$prg_recom_dipilih_3 =$row_prg_recom_dipilih_3[0];
			}
		}
}
$prg_recom_4 = in_val('prg_recom_4', 'any');
$kd_prg_recom_4 = $prg_recom_4;

if($prg_recom_4 ==''){$kd_prg_recom_4 = in_val('kd_prg_recom_4', 'any');$prg_recom_4 =$kd_prg_recom_4;}
if($prg_recom_4 !='')
	{
	$query_prg_recom_dipilih_4 = q_set($__p_query_prg_recom_dipilih_4, "SELECT v.prg_recomm, v.jam FROM ves_data.vip_recomm_list v where id =? ", [(string) ($prg_recom_4)]);
	$resource_prg_recom_dipilih_4 = db_query_soft($query_prg_recom_dipilih_4, $__p_query_prg_recom_dipilih_4 ?? []);	
	if(num(db_num_rows($resource_prg_recom_dipilih_1)) > 0)
		{
		while ($row_prg_recom_dipilih_4  =  db_fetch($resource_prg_recom_dipilih_4, PDO::FETCH_NUM))
			{	
			$prg_recom_dipilih_4 =$row_prg_recom_dipilih_4[0];
			}
		}
}
$prg_recom_5 = in_val('prg_recom_5', 'any');
$kd_prg_recom_5 = $prg_recom_5;

if($prg_recom_5 ==''){$kd_prg_recom_5 = in_val('kd_prg_recom_5', 'any');$prg_recom_5 =$kd_prg_recom_5;}
if($prg_recom_5 !='')
	{
	$query_prg_recom_dipilih_5 = q_set($__p_query_prg_recom_dipilih_5, "SELECT v.prg_recomm, v.jam FROM ves_data.vip_recomm_list v where id =? ", [(string) ($prg_recom_5)]);
	$resource_prg_recom_dipilih_5 = db_query_soft($query_prg_recom_dipilih_5, $__p_query_prg_recom_dipilih_5 ?? []);	
	if(num(db_num_rows($resource_prg_recom_dipilih_1)) > 0)
		{
		while ($row_prg_recom_dipilih_5  =  db_fetch($resource_prg_recom_dipilih_5, PDO::FETCH_NUM))
			{	
			$prg_recom_dipilih_5 =$row_prg_recom_dipilih_5[0];
			}
		}
}

}
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>PT Update</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

	  <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="css/font-awesome/css/font-awesome.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="css/ionicons/css/ionicons.min.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="plugins/datatables/dataTables.bootstrap.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/AdminLTE.min.css">

</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">
<?php //  include ('left.php') ?>
     <form name="form1" action="#"  enctype="multipart/form-data" method="post"><?php echo csrf_field(); ?>

  <!-- Content Wrapper. Contains page content -->
 
    <!-- Content Header (Page header) --><!-- Main content -->
    <section class="content">
		            	            <input type="hidden" class="form-control"  placeholder="Enter CLass Code" name="n_urut" value="<?php echo e($n_urut) ?>" required>
		            	            <input type="hidden" class="form-control"  placeholder="Enter CLass Code" name="ins" value="<?php echo e($ins) ?>">
		            	            <input type="hidden" class="form-control"  placeholder="Enter CLass Code" name="kdb" value="<?php echo e($kdb) ?>">
       <input type="hidden" class="form-control"  placeholder="Enter CLass Code" name="nub" value="<?php echo e($nub) ?>" >		 
<span class="form-group">
		            	            <input type="hidden" class="form-control"  placeholder="Enter ..." name="nama_lengkap_student" 
                 	      value="<?php echo e($nama_lengkap_student) ?>">
</span>
<div class="box-body">	
		<div class="col-xs-12">
	  <h3><?php echo e($nama_lengkap_student) ?> </h3>
  </div>
<div class="col-xs-12">	
<div class="col-xs-4">
    <div class="form-group">
      <label>Test Date</label><input type="date" class="form-control"  placeholder="Enter ..." name="tgl_testing" 
                 	      value="<?php echo e($tgl_testing) ?>">
    </div>
  </div>
<div class="col-xs-4">
    <div class="form-group">
      <label>Test Type</label><select class="form-control" name="prg_type"   onChange="this.form.submit()">
	      <option>IELTS</option>
<option>TOEFL IBT</option>
<option>TOEFL PBT</option>
<option>TOEIC</option>
<option>VIP Signature Test</option>
<option>SAT</option>		
		
	
		      
              <option selected="selected"><?php echo e($prg_type) ?></option>							  		
	        </select>
    </div>
  </div>
<?php if(num($ins) ==1){ ?>	
<div class="col-xs-4">
  <div class="form-group">
    <label>Score Target</label>
    <input type="text" ang="en-150" class="form-control"  placeholder="Enter ..." name="target_score" 
                 	      value="<?php echo e($target_score) ?>">
  </div>
</div>	
<?php } ?>	
</div> 
</div>
<div class="box-body">
<?php if($prg_type == 'SAT'){?>		
<div class="col-xs-12">
  <div class="col-xs-3">
    <div class="form-group">
      <label>English</label>
      <input type="text" ang="en-150" class="form-control"  placeholder="Enter ..." name="sat_eng" 
                 	      value="<?php echo e($sat_eng) ?>">
    </div>
  </div>
  <div class="col-xs-3">
    <div class="form-group">
      <label>Math</label>
      <input type="text" ang="en-150" class="form-control"  placeholder="Enter ..." name="sat_math" 
                 	      value="<?php echo e($sat_math) ?>">
    </div>
  </div>	
</div>
<?php }  elseif($prg_type == 'VIP Signature Test') {?>
<div class="col-xs-12">
  <div class="col-xs-3">
    <div class="form-group">
      <label>Grammar & Vocabulary</label><input type="text" ang="en-150" class="form-control"  placeholder="Enter ..." name="l" 
                 	      value="<?php echo e($l) ?>">
    </div>
  </div>

  <div class="col-md-3">
    <div class="form-group">
      <label>Speaking</label>
      <input type="text" ang="en-150" class="form-control"  placeholder="Enter ..." name="sp" 
                 	      value="<?php echo e($sp) ?>">
    </div>
  </div>

</div>	
<?php }  else {?>	
<div class="col-xs-12">
  <div class="col-xs-2">
    <div class="form-group">
      <label>Listening</label><input type="text" ang="en-150" class="form-control"  placeholder="Enter ..." name="l" 
                 	      value="<?php echo e($l) ?>">
    </div>
  </div>
  <div class="col-lg-3">
	      <div class="form-group">
	        <label>Listening Weakness</label>
		    <select class="form-control select2" style="width: 50%;" name="weak_l">
			      <?php
	
					
				$query_skill = q_set($__p_query_skill, "SELECT weakness FROM ves_data.vip_mst_skill_weakness where skill = 'Listening'");
				$resource_skill = db_query_or_die('errro_7', $query_skill, $__p_query_skill ?? []);
				while ($row_skill=  db_fetch($resource_skill, PDO::FETCH_NUM))
					{
					echo '<option value="'.e($row_skill[0]).'">'.e($row_skill[0]).'</option>';
					}      
				?>
			      <option value selected = "<?php echo e($row_skill[0]) ?>"><?php echo e($weak_l) ?></option>
		    </select>
          </div>
        </div>
	</div>
<div class="col-xs-12">	
  <div class="col-xs-3">
    <div class="form-group">
      <label>Structure</label>
      <input type="text" ang="en-150" class="form-control"  placeholder="Enter ..." name="st" 
                 	      value="<?php echo e($st) ?>">
    </div>
  </div>
	</div>
<div class="col-xs-12">		
  <div class="col-xs-2">
    <div class="form-group">
      <label>Speaking</label>
      <input type="text" ang="en-150" class="form-control"  placeholder="Enter ..." name="sp" 
                 	      value="<?php echo e($sp) ?>">
    </div>
  </div>
<div class="col-lg-3">
	      <div class="form-group">
	        <label>Speaking Weakness</label>
		    <select class="form-control select2" style="width: 50%;" name="weak_s">
			      <?php
	
					
				$query_skill = q_set($__p_query_skill, "SELECT weakness FROM ves_data.vip_mst_skill_weakness where skill = 'Speaking'");
				$resource_skill = db_query_or_die('errro_7', $query_skill, $__p_query_skill ?? []);
				while ($row_skill=  db_fetch($resource_skill, PDO::FETCH_NUM))
					{
					echo '<option value="'.e($row_skill[0]).'">'.e($row_skill[0]).'</option>';
					}      
				?>
			      <option value selected = "<?php echo e($row_skill[0]) ?>"><?php echo e($weak_s) ?></option>
		    </select>

          </div>
        </div>
</div>
<div class="col-xs-12">
  <div class="col-xs-2">
    <div class="form-group">
      <label>Reading</label>
      <input type="text" ang="en-150" class="form-control"  placeholder="Enter ..." name="r" 
                 	      value="<?php echo e($r) ?>">
    </div>
  </div>
  <div class="col-lg-4">
	      <div class="form-group">
	        <label>Reading Weakness</label>
		    <select class="form-control select2" style="width: 50%;" name="weak_r">
			     			      <?php
	
					
				$query_skill = q_set($__p_query_skill, "SELECT weakness FROM ves_data.vip_mst_skill_weakness where skill = 'Reading'");
				$resource_skill = db_query_or_die('errro_7', $query_skill, $__p_query_skill ?? []);
				while ($row_skill=  db_fetch($resource_skill, PDO::FETCH_NUM))
					{
					echo '<option value="'.e($row_skill[0]).'">'.e($row_skill[0]).'</option>';
					}      
				?>
			      <option value selected = "<?php echo e($row_skill[0]) ?>"><?php echo e($weak_r) ?></option>
		    </select>

          </div>
        </div>
  <div class="col-xs-2">
    <div class="form-group">
      <label>Writing</label>
      <input type="text" ang="en-150" class="form-control"  placeholder="Enter ..." name="w" 
                 	      value="<?php echo e($w) ?>">
    </div>
  </div>	
  <div class="col-lg-4">
	      <div class="form-group">
	        <label>Writing Weakness</label>
		    <select class="form-control select2" style="width: 50%;" name="weak_w">
			      <?php
	
					
				$query_skill = q_set($__p_query_skill, "SELECT weakness FROM ves_data.vip_mst_skill_weakness where skill = 'Writing'");
				$resource_skill = db_query_or_die('errro_7', $query_skill, $__p_query_skill ?? []);
				while ($row_skill=  db_fetch($resource_skill, PDO::FETCH_NUM))
					{
					echo '<option value="'.e($row_skill[0]).'">'.e($row_skill[0]).'</option>';
					}      
				?>
			      <option value selected ="<?php echo e($row_skill[0]) ?>"><?php echo e($weak_w) ?></option>

		    </select>
	
          </div>
        </div>
</div>
<?php } ?>	
<div class="col-xs-12">
  <div class="col-xs-3">
    <div class="form-group">
      <label>TOTAL</label>
      <input type="text" ang="en-150" class="form-control"  placeholder="Enter ..." name="ttl" 
                 	      value="<?php echo e($ttl) ?>">
    </div>
</div>	
</div>	
<div class="col-xs-12">
  <div class="col-xs-12">
    <div class="col-xs-12">
      <div class="form-group">
        <label>Duration Needed (Month)</label>
        <input type="number" ang="en-150" class="form-control"  placeholder="Duration" name="duration" 
                 	      value="<?php echo e($duration) ?>">
      </div>
    </div>
  </div>
  <div class="col-xs-12">
    <div class="form-group">
      <label>Note</label>
      <input type="text" ang="en-150" class="form-control"  placeholder="Enter ..." name="note_score" 
                 	      value="<?php echo e($note_score) ?>">
    </div>
</div>
</div>	  
</div>		

<div class="box-body">
  <div class="col-xs-12"></div>
	  <div class="col-lg-12">
	    <div class="col-lg-4">
	      <div class="form-group">
	        <label>Recommendation Program #1</label>
		    <select class="form-control select2" style="width: 100%;" name="prg_recom_1"  onChange="this.form.submit()">
			      <?php
	
					
				$query_recom_list1 = q_set($__p_query_recom_list1, "SELECT v.id, v.prg_recomm, v.jam FROM ves_data.vip_recomm_list v");
				$resource_recom_list1 = db_query_or_die('errro_7', $query_recom_list1, $__p_query_recom_list1 ?? []);
				while ($row_recom_list1=  db_fetch($resource_recom_list1, PDO::FETCH_NUM))
					{
					echo '<option value="'.e($row_recom_list1[0]).'">'.e($row_recom_list1[1]).'</option>';
					}      
				?>
			      <option value selected = <?php echo e($row_recom_list1[0]) ?>><?php echo e($prg_recom_dipilih_1) ?></option>
		    </select>
		    <input type="hidden" class="form-control"  placeholder="Enter ..." name="kd_prg_recom_1" 
                 	      value="<?php echo e($kd_prg_recom_1) ?>">	
          </div>
        </div>
		  <?php if ($kd_prg_recom_1 != ''){?>
	    <div class="col-lg-4">
	      <div class="form-group">
	        <label>Recommendation Program #2</label>
	        <select class="form-control select2" style="width: 100%;" name="prg_recom_2"  onChange="this.form.submit()">
	          <?php
	
					
				$query_recom_list2 = q_set($__p_query_recom_list2, "SELECT v.id, v.prg_recomm, v.jam FROM ves_data.vip_recomm_list v where id <> ? ", [(string) ($kd_prg_recom_1)]);
				$resource_recom_list2 = db_query_or_die('errro_7', $query_recom_list2, $__p_query_recom_list2 ?? []);
				while ($row_recom_list2=  db_fetch($resource_recom_list2, PDO::FETCH_NUM))
					{
					echo '<option value="'.e($row_recom_list2[0]).'">'.e($row_recom_list2[1]).'</option>';
					}      
				?>
	          <option value selected = <?php echo e($row_recom_list2[0]) ?>><?php echo e($prg_recom_dipilih_2) ?></option>
            </select>
	        <input type="hidden" class="form-control"  placeholder="Enter ..." name="kd_prg_recom_2" 
                 	      value="<?php echo e($kd_prg_recom_2) ?>">
	      </div>
        </div>
	   <?php } if ($kd_prg_recom_2 != ''){?>
		  <div class="col-lg-4">
	      <div class="form-group">
	        <label>Recommendation Program #3</label>
	        <select class="form-control select2" style="width: 100%;" name="prg_recom_3"  onChange="this.form.submit()">
	          <?php
	
					
				$query_recom_list3 = q_set($__p_query_recom_list3, "SELECT v.id, v.prg_recomm, v.jam FROM ves_data.vip_recomm_list v where id <> ?  and id <> ? ", [(string) ($kd_prg_recom_1), (string) ($kd_prg_recom_2)]); 
				$resource_recom_list3 = db_query_or_die('errro_7', $query_recom_list3, $__p_query_recom_list3 ?? []);
				while ($row_recom_list3=  db_fetch($resource_recom_list3, PDO::FETCH_NUM))
					{
					echo '<option value="'.e($row_recom_list3[0]).'">'.e($row_recom_list3[1]).'</option>';
					}      
				?>
	          <option value selected = <?php echo e($row_recom_list3[0]) ?>><?php echo e($prg_recom_dipilih_3) ?></option>
            </select>
	        <input type="hidden" class="form-control"  placeholder="Enter ..." name="kd_prg_recom_3" 
                 	      value="<?php echo e($kd_prg_recom_3) ?>">
	      </div>
        </div>
		   <?php } if ($kd_prg_recom_3 != ''){?>
		  <div class="col-lg-4">
	      <div class="form-group">
	        <label>Recommendation Program #4</label>
	        <select class="form-control select2" style="width: 100%;" name="prg_recom_4"  onChange="this.form.submit()">
	          <?php
	
					
				$query_recom_list4 = q_set($__p_query_recom_list4, "SELECT v.id, v.prg_recomm, v.jam FROM ves_data.vip_recomm_list v where id <> ?  and id <> ?   and id <> ? ", [(string) ($kd_prg_recom_1), (string) ($kd_prg_recom_2), (string) ($kd_prg_recom_3)]); 
				$resource_recom_list4 = db_query_or_die('errro_7', $query_recom_list4, $__p_query_recom_list4 ?? []);
				while ($row_recom_list4=  db_fetch($resource_recom_list4, PDO::FETCH_NUM))
					{
					echo '<option value="'.e($row_recom_list4[0]).'">'.e($row_recom_list4[1]).'</option>';
					}      
				?>
	          <option value selected = <?php echo e($row_recom_list4[0]) ?>><?php echo e($prg_recom_dipilih_4) ?></option>
            </select>
	        <input type="hidden" class="form-control"  placeholder="Enter ..." name="kd_prg_recom_4" 
                 	      value="<?php echo e($kd_prg_recom_4) ?>">
	      </div>
        </div>
		   <?php } if ($kd_prg_recom_4 != ''){?>  
		  <div class="col-lg-4">
	      <div class="form-group">
	        <label>Recommendation Program #5</label>
	        <select class="form-control select2" style="width: 100%;" name="prg_recom_5"  onChange="this.form.submit()">
	          <?php
	
					
				$query_recom_list5 = q_set($__p_query_recom_list5, "SELECT v.id, v.prg_recomm, v.jam FROM ves_data.vip_recomm_list v where id <> ?  and id <> ?   and id <> ?   and id <> ? ", [(string) ($kd_prg_recom_1), (string) ($kd_prg_recom_2), (string) ($kd_prg_recom_3), (string) ($kd_prg_recom_4)]); 
				$resource_recom_list5 = db_query_or_die('errro_7', $query_recom_list5, $__p_query_recom_list5 ?? []);
				while ($row_recom_list5=  db_fetch($resource_recom_list5, PDO::FETCH_NUM))
					{
					echo '<option value="'.e($row_recom_list5[0]).'">'.e($row_recom_list5[1]).'</option>';
					}      
				?>
	          <option value selected = <?php echo e($row_recom_list5[0]) ?>><?php echo e($prg_recom_dipilih_5) ?></option>
            </select>
	        <input type="hidden" class="form-control"  placeholder="Enter ..." name="kd_prg_recom_5" 
                 	      value="<?php echo e($kd_prg_recom_5) ?>">
	      </div>
        </div>
	<?php } ?>  
	</div> 
<div class="box-body"></div>		
	<div class="modal-footer">
      <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
      <input type="submit" class="btn btn-success" name="save_score" value="Save Score">
    </div>
<?php 
if (($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['save_score']))) 
	{
$ins = in_val('ins', 'any');
$skr = date("Y-m-d H:i:s");
$tgl_testing = in_val('tgl_testing', 'any');
$prg_type = in_val('prg_type', 'any');
$l = in_val('l', 'any');
$st = in_val('st', 'any');
$sp = in_val('sp', 'any');
$r = in_val('r', 'any');
$w = in_val('w', 'any');
$other = in_val('other', 'any');	
$ttl = in_val('ttl', 'any');
$target_score = in_val('target_score', 'any');if($target_score == ''){$target_score = 0;}
$duration = in_val('duration', 'any');	
$note_score = in_val('note_score', 'any');
$sat_eng = in_val('sat_eng', 'any');
$sat_math = in_val('sat_math', 'any');	
$prg_recom_1 = in_val('kd_prg_recom_1', 'any');if (num($prg_recom_1) == 41 ){$prg_recom_1 = '';}
$prg_recom_2 = in_val('kd_prg_recom_2', 'any');if (num($prg_recom_2) == 41 ){$prg_recom_2 = '';}
$prg_recom_3 = in_val('kd_prg_recom_3', 'any');if (num($prg_recom_3) == 41 ){$prg_recom_3 = '';}
$prg_recom_4 = in_val('kd_prg_recom_4', 'any');if (num($prg_recom_4) == 41 ){$prg_recom_4 = '';}
$prg_recom_5 = in_val('kd_prg_recom_5', 'any');if (num($prg_recom_5) == 41 ){$prg_recom_5 = null;}
$nub = in_val('nub', 'any');
	$nama_lengkap_student = in_val('nama_lengkap_student', 'any');		
 $kdb = in_val('kdb', 'any'); 
$nama_lengkap = $_SESSION['nama_lengkap']; 
$kd_branch = $_SESSION['kd_branch'];
if (num($jns) == 1 or $nub =='')
	{
	
	if ($prg_type =='SAT')
		{
		$query_simpan_score_class = q_set($__p_query_simpan_score_class, "insert into  ves_data.vip_class_score_profile (kd_biodata,target_score,  jns_test,total,remark, test_date,dt_entry,pic, prg_type,prg_recom,prg_recom_2,prg_recom_3,prg_recom_4,prg_recom_5,durasi,english, math) values (? ,? ,'1',? ,? ,? ,? ,? ,? ,? ,? ,? ,? ,? ,? ,\r
\t\t? ,? )", [(string) ($kdb), (string) ($target_score), (string) ($ttl), (string) ($note_score), (string) ($tgl_testing), (string) ($skr), (string) ($nama_lengkap), (string) ($prg_type), (string) ($prg_recom_1), (string) ($prg_recom_2), (string) ($prg_recom_3), (string) ($prg_recom_4), (string) ($prg_recom_5), (string) ($duration), (string) ($sat_eng), (string) ($sat_math)]); ;		
		
		
		}
	else
		{
		$query_simpan_score_class = q_set($__p_query_simpan_score_class, "insert into  ves_data.vip_class_score_profile (kd_biodata,target_score,  jns_test,L,S,R,W,other,total,remark, test_date,dt_entry,pic, prg_type,prg_recom,prg_recom_2,prg_recom_3,prg_recom_4,prg_recom_5,durasi) values (? ,? ,'1',? ,? ,? ,? ,? ,? ,? ,? ,? ,? ,? ,? ,? ,? ,? ,? ,? )", [(string) ($kdb), (string) ($target_score), (string) ($l), (string) ($sp), (string) ($r), (string) ($w), (string) ($st), (string) ($ttl), (string) ($note_score), (string) ($tgl_testing), (string) ($skr), (string) ($nama_lengkap), (string) ($prg_type), (string) ($prg_recom_1), (string) ($prg_recom_2), (string) ($prg_recom_3), (string) ($prg_recom_4), (string) ($prg_recom_5), (string) ($duration)]); ;		
		
		}
	$resource_simpan = db_query_or_die('errro_simpan2', $query_simpan_score_class, $__p_query_simpan_score_class ?? []);/* echo $query_simpan_score_class (debug SQL versi lama) dihapus */
	}
else
	{
	if($prg_type !='SAT')
		{
	$query_simpan_score_class = q_set($__p_query_simpan_score_class, "update  ves_data.vip_class_score_profile set jns_test = '1',L = ? ,S = ? ,R=? ,W=? ,other=? ,total=? ,remark = ? , test_date = ? ,dt_entry=? ,pic=? , prg_type=? ,prg_recom = ? ,prg_recom_2= ? ,prg_recom_3= ? ,prg_recom_4= ? ,prg_recom_5= ? ,durasi=? where no = ? ", [(string) ($l), (string) ($sp), (string) ($r), (string) ($w), (string) ($st), (string) ($ttl), (string) ($note_score), (string) ($tgl_testing), (string) ($skr), (string) ($nama_lengkap), (string) ($prg_type), (string) ($prg_recom_1), (string) ($prg_recom_2), (string) ($prg_recom_3), (string) ($prg_recom_4), (string) ($prg_recom_5), (string) ($duration), (string) ($nub)]);;
		
		}
	else
		{
	$query_simpan_score_class = q_set($__p_query_simpan_score_class, "update  ves_data.vip_class_score_profile set jns_test = '1',total=? ,remark = ? , test_date = ? ,dt_entry=? ,pic=? , prg_type=? ,prg_recom = ? ,prg_recom_2= ? ,prg_recom_3= ? ,prg_recom_4= ? ,prg_recom_5= ? ,durasi=? ,english =? ,math = ? where no = ? ", [(string) ($ttl), (string) ($note_score), (string) ($tgl_testing), (string) ($skr), (string) ($nama_lengkap), (string) ($prg_type), (string) ($prg_recom_1), (string) ($prg_recom_2), (string) ($prg_recom_3), (string) ($prg_recom_4), (string) ($prg_recom_5), (string) ($duration), (string) ($sat_eng), (string) ($sat_math), (string) ($nub)]);;
		
		}
	$resource_simpan = db_query_or_die('errro_simpan2', $query_simpan_score_class, $__p_query_simpan_score_class ?? []);
	}

		echo "<script type=\"text/javascript\">\n";
		echo "window.opener.location.reload(true);\n";
		echo "window.close(); \n";					
		echo "</script>";	
	die;
	}
 ?>		


      <!-- /.row -->
    </section>
    <!-- /.content -->
 
    </form>	

</div>
   <script>
   function popitup(url) 
   {
    newwindow=window.open(url,'name','height=600,width=750,screenX=400,screenY=350');
    if (window.focus) {newwindow.focus()}
    return false;
   }
   </script>
<script>
    function submit(form) {
        form.submit();
    }
</script>
</body>
</html>
