<?php
require_once __DIR__ . "/_lib/bootstrap.php"; auth_require_login();
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=leavingxl.xls");
include __DIR__ . "/conndb.php";
?>
<?php 
/* $query = $_GET['q'] (SQL dari URL) dihapus: query diambil dari sesi */
$no_urut = 1;
$query = q_set($__p_query, $_SESSION['ngueri'] ?? '', $_SESSION['ngueri__p'] ?? []);
$result=db_query_or_die("Wah error nih5", $query, $__p_query ?? []);
				  	$num_rows = db_num_rows($result);?>    

               <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th colspan="11"> LEAVING REPORT</th>
                  </tr>
                <tr>
                  <th width="6%">No</th>
                  <th width="8%">Enroll Date</th>
                  <th width="14%">Student Name</th>
                  <th width="42%">Institution</th>
                  <th width="18%">H</th>
                  <th width="18%">NON</th>
                  <th width="18%">P</th>
                  <th width="18%">NON P</th>
                  <th width="18%">STAR</th>
                  <th width="18%">Commencement Date</th>
                  <th width="12%">Center</th>
                </tr>
                </thead>
                <tbody>

				  <?php 
					if ($result) 
						{ 
						while ($r = db_fetch($result))
							{
							 					
				?>                
                <tr>
                  <td><?php echo e($no_urut) ; ?></td>
                  <td><?php echo e($r[0]) ; ?></td>
                  <td><?php echo e($r[1]) ; ?></td>
                  <td><?php echo e($r[2]) ; ?> - <?php echo e($r[3]) ; ?> (<?php echo e($r[4]) ; ?>)</td>
                  <td><?php echo e($r[5]) ; ?></td>
                  <td><?php echo e($r[6]) ; ?></td>
                  <td><?php echo e($r[7]) ; ?></td>
                  <td><?php echo e($r[8]) ; ?></td>
                  <td><?php echo e($r[10]) ; ?></td>
                  <td><?php echo e($r[9]) ; ?></td>
                  <td><?php echo e($r[11]) ; ?></td>
                </tr>
                <?php $no_urut = num($no_urut) + 1; } }?>
                </tbody>
                <tfoot>
                </tfoot>
              </table>