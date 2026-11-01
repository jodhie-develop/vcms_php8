<?php
require_once __DIR__ . "/_lib/bootstrap.php"; auth_require_login();
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=salesxl.xls");
include __DIR__ . "/conndb.php";
?>
<?php 
/* $query = $_GET['q'] (SQL dari URL) dihapus: query diambil dari sesi */
$no_urut = 1;
$query = q_set($__p_query, $_SESSION['ngueri'] ?? '', $_SESSION['ngueri__p'] ?? []);
$result=db_query_or_die("Wah error nih5", $query, $__p_query ?? []);
				  	$num_rows = db_num_rows($result);?>    
<table width="97%" class="table table-bordered table-striped" id="example1" >
  <thead>
    <tr>
      <th width="3%" align="center">No</th>
      <th width="5%">Center</th>
      <th width="5%">Enroll Date</th>
      <th width="5%">Student Name</th>
      <th width="17%">Institution</th>
      <th width="4%">H<br>
        AD<br>
        STEM<br>
        NON<br></th>
      <th width="4%">P/NP</th>
      <th width="4%">STAR</th>
      <th width="4%">Final Status</th>
      <th width="10%">Admission Step</th>
      <th width="10%">Remark</th>
      <th width="3%">SC</th>
      <th width="3%">AC</th>
      <th width="17%">SOURCE</th>
      <th width="16%">Event</th>
    </tr>
  </thead>
  <tbody>
    <?php 
					if ($result) 
						{ 
						while ($r = db_fetch($result))
							{
							$tgl_enroll = $r[21];
							$kode_biodata = $r[2];
								
							$final_status = $r[10];	
							$query_get_last = q_set($__p_query_get_last, "SELECT update_date FROM adm_stu_progress where enroll_date = ? and kd_biodata = ? order by update_date desc limit 1", [(string) ($tgl_enroll), (string) ($kode_biodata)]);	
							$result_get_last=db_query_or_die("Wah error nih5", $query_get_last, $__p_query_get_last ?? []);	
							$jumlah_data = db_num_rows($result_get_last);								
							if (num($jumlah_data) > 0 ) 
								{ 
								while ($r_get_last = db_fetch($result_get_last))
									{
							 		$update_terakhir = 	$r_get_last[0];
									$query_get_admission = q_set($__p_query_get_admission, "SELECT dest_school, dest_program, dest_country, h_nh, p_np, bintang, final_status, remark, step, date_format(update_date,'%d/%m/%y') FROM adm_stu_progress where enroll_date = ? and kd_biodata = ? and update_date = ? order by no desc limit 1", [(string) ($tgl_enroll), (string) ($kode_biodata), (string) ($update_terakhir)]);

									$result_get_admission=db_query_or_die("Wah error nih5", $query_get_admission, $__p_query_get_admission ?? []);	
										if ($result_get_admission) 
											{ 
											while ($r_get_admission = db_fetch($result_get_admission))
												{
												$step = "Unknown Step";	
												$r[5] = $r_get_admission[0];
												$r[6] = $r_get_admission[1];
												$r[15] = $r_get_admission[2];
												$r[8] = $r_get_admission[3];
												$r[9] = $r_get_admission[4];
												$r[4] = $r_get_admission[6];
												$r[10] = $r_get_admission[6];
												$r[11] = $r_get_admission[7];
												$step = $r_get_admission[8];											
												$r[12] = $r_get_data[9];	
												}
											}
										}
									}
					
							if ($step==''){$step = "Unknown Step";}
									?>
    <tr>
      <td><?php echo e($no_urut) ; ?></td>
      <td><?php echo e($r[0]) ; ?></td>
      <td><?php echo e($r[1]) ; ?></td>
      <td><?php echo e($r[3]) ; ?><br>
        <?php echo e($r[13]) ; ?> - <?php echo e($r[14]) ; ?></td>
      <td><?php echo e($r[5]) ; ?> - <?php echo e($r[6]) ; ?> - <?php echo e($r[7]) ; ?> (<?php echo e($r[15]) ; ?>)</td>
      <td><?php echo e($r[8]) ; ?></td>
      <td><?php echo e($r[9]) ; ?></td>
      <td><?php echo e($r[4]) ; ?></td>
      <td><?php echo e($final_status) ; ?></td>
      <td><?php echo e($step) ; ?></td>
      <td><?php echo e($r[11]) ; ?><br>
        <?php echo e($r[12]) ; ?></td>
      <td><?php echo e($r[16]) ; ?></td>
      <td><?php echo e($r[11]) ; ?></td>
      <td><?php echo e($r[17]) ; ?><br>
        <?php echo e($r[18]) ; ?></td>
      <td><?php echo e($r[19]) ; ?></td>
    </tr>
    <?php $no_urut = num($no_urut) + 1; $step ='';} }?>
  </tbody>
  <tfoot>
  </tfoot>
</table>
