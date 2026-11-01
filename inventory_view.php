<?php
require_once __DIR__ . "/_lib/bootstrap.php"; auth_require_login(); include __DIR__ . "/conndb.php"; 
$id = intval(in_val('id', 'get')); // aman dari injection

$query_item = q_set($__p_query_item, "\r
    SELECT \r
        Id, \r
        Asset_ID, \r
        Make_Manufacturer, \r
        PERFORMANCE_SCORE,\r
        Model,\r
        Branch_id,\r
        Branch,\r
        DEPT,\r
        User,\r
        PrimarySecondary_Dev,\r
        Processor_Type_and_Speed,\r
        Purchase_Date,\r
        Purchase_Cost_Budget,\r
        New_Model,\r
        Month_Plan,\r
        Warranty_Expiry_Date,\r
        REMARK,\r
        STATUS,\r
        Photo\r
    FROM inventory_data \r
    WHERE id = ? \r
", [(string) ($id)]);

$result_item = db_query_or_die("Query error: inventory_data", $query_item, $__p_query_item ?? []);

if(num(db_num_rows($result_item)) > 0)
{	
    $row = db_fetch($result_item, PDO::FETCH_ASSOC);
}
else {
    die("Data tidak ditemukan");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>Dashboard Inventori</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
<style>
body { background:#f5f5f5; }
.card { border-radius: 16px; }
.table thead { background:#0d6efd; color:white; }
#qrcode canvas, #qrcode img { width:20% !important; height:20% !important; }
</style>
</head>
<body>
<div class="container py-4">
<h2 class="mb-4 fw-bold text-primary">Dashboard Inventori</h2>


<!-- Info Perangkat -->
<div class="card mb-4 shadow-sm">
<div class="card-body">
<h4 class="card-title mb-3">Informasi Perangkat</h4>


<div class="row g-3">
<div class="col-md-4">
<label class="form-label">Asset ID</label>
<input type="text" class="form-control" id="asset_id" value="<?php echo e($row['Asset_ID']) ?>" />
</div>
<div class="col-md-4">
  <label class="form-label">Teknis</label>
  <input type="text" class="form-control" id="asset_id2" value="<?php echo e($row['Processor_Type_and_Speed,']) ?>" />
</div>


<div class="col-md-4">
<label class="form-label">Branch</label>
<input type="text" class="form-control" id="asset_id3" value="<?php echo e($row['Branch']) ?>" />
</div>
<div class="col-md-4">
  <label class="form-label">User</label>
  <input type="text" class="form-control" id="asset_id4" value="<?php echo e($row['Branch']) ?>" />
</div>
<div class="col-md-4">
  <label class="form-label">Year</label>
  <input type="text" class="form-control" id="asset_id5" value="<?php echo e($row['User']) ?>" />
</div>
<div class="col-md-4">
  <label class="form-label">Status</label>
  <input type="text" class="form-control" id="asset_id6" value="<?php echo e($row['STATUS']) ?>" />
</div>
<div class="col-md-8">
  <label class="form-label">Remark</label>
  <input type="text" class="form-control" id="asset_id7" value="<?php echo e($row['REMARK']) ?>" />
</div>
</div>
</div>
</div>


<!-- QR CODE -->
<div class="card mb-4 shadow-sm">
<div class="card-body">
<h4 class="card-title mb-3">QR Code Perangkat</h4>
<div id="qrcode"></div>

</div>
</div>


<!-- Tabel Riwayat Perbaikan -->
<div class="card shadow-sm mb-4">
<div class="card-body">
<h4 class="card-title mb-3">Riwayat Perbaikan</h4>


<table class="table table-bordered table-striped" id="tblHistory">
<thead>
<tr>
<th>Tanggal</th>
<th>Deskripsi</th>
<th>Biaya (Rp)</th>
</tr>
</thead>
<tbody>
<tr>
<td>2023-02-10</td>
<td>Ganti SSD</td>
<td>850000</td>
</tr>
<tr>
<td>2024-01-14</td>
<td>Ganti Baterai</td>
<td>650000</td>
</tr>
</tbody>
</table>
</div>
</div>


<!-- Tombol Aksi -->
<button class="btn btn-success" onclick="printPage()">Print / Export PDF</button>
</div>


<script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
<script>
function generateQR() {
document.getElementById('qrcode').innerHTML = '';
let text = document.getElementById('asset_id').value;;
new QRCode(document.getElementById('qrcode'), text);
}


generateQR();


function printPage() {
window.print();
}
</script>


</body>
</html>