<?php
require_once __DIR__ . "/_lib/bootstrap.php"; auth_require_login(); 
include __DIR__ . "/conndb.php";

//include __DIR__ . "/atas.php";
$q = q_set($__p_q, $_SESSION['dataquery'] ?? '', $_SESSION['dataquery__p'] ?? []);
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=accxl.xls");
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <title>Excel Bootstrap Table Filter</title>
</head>

<body>
  <!-- Load jQuery -->


      <table width="2640" class="table table-bordered table-intel" id="table">
        <thead>
          <tr>
            <th class="filter">&nbsp;</th>
            <th class="filter">&nbsp;</th>
            <th colspan="5" class="filter">STAR</th>
            <th class="filter">&nbsp;</th>
            <th colspan="5" class="filter">Enroll Date</th>
            <th class="filter">&nbsp;</th>
            <th class="filter">&nbsp;</th>
            <th class="filter">&nbsp;</th>
            <th class="filter">&nbsp;</th>
            <th class="filter">&nbsp;</th>
            <th class="filter">&nbsp;</th>
            <th class="filter">&nbsp;</th>
            <th class="filter">&nbsp;</th>
            <th class="filter">&nbsp;</th>
            <th class="filter">&nbsp;</th>
            <th class="filter">&nbsp;</th>
            <th class="filter">&nbsp;</th>
            <th class="filter">&nbsp;</th>
            <th class="filter">&nbsp;</th>
            <th class="filter">&nbsp;</th>
            <th class="filter">&nbsp;</th>
            <th class="filter">&nbsp;</th>
            <th class="filter">&nbsp;</th>
            <th class="filter">&nbsp;</th>
            <th class="filter">&nbsp;</th>
            <th class="filter">&nbsp;</th>
            <th class="filter">&nbsp;</th>
            <th class="filter">&nbsp;</th>
            <th class="filter">&nbsp;</th>
            <th class="filter">&nbsp;</th>
          </tr>
          <tr>
            <th width="54" class="filter">No</th>
            <th width="61" class="filter">School</th>
            <th width="17" class="filter">5</th>
            <th width="19" class="filter">4</th>
            <th width="22" class="filter">3</th>
            <th width="17" class="filter">2</th>
            <th width="21" class="filter">1</th>
            <th width="238" class="filter">Student Name</th>
            <th width="61" class="filter">-4</th>
            <th width="61" class="filter">-3</th>
            <th width="61" class="filter">-2</th>
            <th width="61" class="filter">-1</th>
            <th width="61" class="filter">CY</th>
            <th width="61" class="filter">Branch</th>
            <th width="61" class="filter">Enroll Date</th>
            <th width="61" class="filter">Intake Date</th>
            <th width="61" class="filter">Comm Date</th>
            <th width="59" class="filter">Main</th>
            <th width="66" class="filter">Language</th>
            <th width="68" class="filter">Additional</th>
            <th width="63" class="filter">Return Student</th>
            <th width="61" class="filter">Group School</th>
            <th width="64" class="filter">Program</th>
            <th width="63" class="filter">Country</th>
            <th width="63" class="filter">Invoice Code</th>
            <th width="63" class="filter">Invoice Date</th>
            <th width="59" class="filter">Pax</th>
            <th width="66" class="filter">Org Currency</th>
            <th width="63" class="filter">Org Amount</th>
            <th width="63" class="filter">Rupiah Rate</th>
            <th width="64" class="filter"> Amount Rp</th>
            <th width="63" class="filter">Bank Invoice</th>
            <th width="77" class="filter">Remark</th>
            <th width="114" class="filter">Payment  Date</th>
            <th width="64" class="filter">Cur Amount Pay</th>
            <th width="64" class="filter">Amount Pay</th>
            <th width="59" class="filter">Rp Rate Pay</th>
            <th width="84" class="filter">Amount Rp Pay</th>
          </tr>
 <?php
	
$nomor = 1;
$resource = db_query_soft($q, $__p_q ?? []);
$keluar = db_num_rows($resource);
if(num(db_num_rows($resource)) > 0)
	{
	while ($row  =  db_fetch($resource, PDO::FETCH_NUM))
		{	
			if ($row[32]=="Patal Jkt"){$row[32] = "South Jkt";}
			elseif ($row[32]=="Central Jkt"){$row[32] = "North Jkt";}

				  ?>          
        </thead>
        <tbody>
          <tr>
            <td><?php echo e($nomor) ?></td>
            <td><?php echo e($row[5]) ?></td>
            <td><?php echo e($row[13]) ?></td>
            <td><?php echo e($row[14]) ?></td>
            <td><?php echo e($row[15]) ?></td>
            <td><?php echo e($row[16]) ?></td>
            <td><?php echo e($row[17]) ?></td>
            <td><?php echo e($row[0]) ?></td>
            <td><?php echo e($row[37]) ?></td>
            <td><?php echo e($row[38]) ?></td>
            <td><?php echo e($row[39]) ?></td>
            <td><?php echo e($row[40]) ?></td>
            <td><?php echo e($row[41]) ?></td>
            <td><?php echo e($row[32]) ?></td>
            <td><?php echo e($row[1]) ?></td>
            <td><?php echo e($row[42]) ?></td>
            <td><?php echo e($row[2]) ?></td>
            <td><?php echo e($row[33]) ?></td>
            <td><?php echo e($row[34]) ?></td>
            <td><?php echo e($row[35]) ?></td>
            <td>&nbsp;</td>
            <td><?php echo e($row[3]) ?></td>
            <td><?php echo e($row[6]) ?></td>
            <td><?php echo e($row[4]) ?></td>
            <td><?php echo e($row[20]) ?></td>
            <td><?php echo e($row[19]) ?></td>
            <td>1</td>
            <td><?php echo e($row[21]) ?></td>
            <td><?php echo e($row[22]) ?></td>
            <td><?php echo e($row[23]) ?></td>
            <td><?php echo e((num($row[22]) * num($row[23]))) ?></td>
            <td><?php echo e($row[36]) ?></td>
            <td><?php echo e($row[30]) ?></td>
            <td><?php echo e($row[28]) ?></td>
            <td><?php echo e($row[24]) ?></td>
            <td><?php echo e($row[25]) ?></td>
            <td><?php echo e($row[26]) ?></td>
            <td><?php echo e($row[27]) ?></td>
          </tr>
          <?php $nomor = num($nomor)+1;}}?>
        </tbody>
      </table>

</body>

</html>

