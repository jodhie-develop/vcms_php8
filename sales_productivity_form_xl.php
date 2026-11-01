<?php
require_once __DIR__ . "/_lib/bootstrap.php"; auth_require_login();
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=sales_productivity_xl.xls");
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
                  <th width="9%">No</th>
                  <th width="57%">Sales Name</th>
                  <th width="20%">Center</th>
                  <th width="14%">Count</th>
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
                  <td><?php echo e($r[2]) ; ?></td>
                  <td><?php echo e($r[1]) ; ?></td>
                  <td><?php echo e($r[3]) ; ?></td>
                  </tr>
                <?php $no_urut = num($no_urut) + 1; } }?>
                </tbody>
                <tfoot>
                </tfoot>
              </table>