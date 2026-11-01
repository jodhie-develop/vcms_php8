<?php
require_once __DIR__ . "/_lib/bootstrap.php"; csrf_guard_get(); auth_require_login();

include __DIR__ . "/conndb.php";

// Pastikan ID ada
if (!isset($_POST['id'])) {
    die("Error: ID tidak ditemukan.");
}

$id = intval(in_val('id', 'post'));

// ---------------------------------------
// Ambil data lama (agar bisa hapus file lama jika diganti)
// ---------------------------------------
$sql_old = db_query_soft("SELECT photo, photo_device FROM inventory_data WHERE id = ? ", [(string) ($id)]);
$oldData = $sql_old->fetch(PDO::FETCH_ASSOC);

$old_invoice     = $oldData['photo'];
$old_devicePhoto = $oldData['photo_device'];

// Ambil semua data POST
$Asset_ID                 = in_val('Asset_ID', 'post');
$Make_Manufacturer        = in_val('Make_Manufacturer', 'post');
$Model                    = in_val('Model', 'post');
$Branch_id                = in_val('branch_id', 'post');
$Branch                   = in_val('Branch', 'post');
$DEPT                     = in_val('DEPT', 'post');
$User                     = in_val('User', 'post');
$PrimarySecondary_Dev     = in_val('PrimarySecondary_Dev', 'post');
$Processor                = in_val('Processor_Type_and_Speed', 'post');
$Purchase_Date            = in_val('Purchase_Date', 'post');
$Purchase_Cost_Budget     = in_val('Purchase_Cost_Budget', 'post');
$New_Model                = in_val('New_Model', 'post');
$Month_Plan               = in_val('Month_Plan', 'post');
$Warranty_Expiry_Date     = in_val('Warranty_Expiry_Date', 'post');
$REMARK                   = in_val('REMARK', 'post');
$STATUS                   = in_val('STATUS', 'post');

$format_tgl = date("Ymd");
$hari_ini   = date("Y-m-d H:i:s");

// ==============================================
// 1️⃣ UPLOAD FILE INVOICE (photo)
// ==============================================

$upload_dir_docs = "uploads/inventory_docs/";
$new_invoice = $old_invoice; // default pakai yang lama

if (!file_exists($upload_dir_docs)) {
    mkdir($upload_dir_docs, 0775, true);
}

if (!empty($_FILES['photo']['name'])) {

    $allowed_ext = array('jpg','jpeg','png','pdf');
    $file_name   = $_FILES['photo']['name'];
    $file_tmp    = $_FILES['photo']['tmp_name'];
    $file_size   = $_FILES['photo']['size'];
    $file_ext    = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

    if (!in_array($file_ext, $allowed_ext)) {
        die("<script>alert('File Invoice harus JPG/PNG/PDF'); history.back()</script>");
    }

    if ($file_size > 3 * 1024 * 1024) {
        die("<script>alert('Maksimum ukuran file 3MB'); history.back()</script>");
    }

    $new_invoice = "INV_" . $format_tgl . "_" . time() . "." . $file_ext;
    $destination = $upload_dir_docs . $new_invoice;

    // upload file baru
    if (!upload_move('photo', upload_allow('jpg', 'jpeg', 'png', 'pdf'), $destination, 3 * 1024 * 1024)) { die("<script>alert(" . js(upload_error()) . "); history.back()</script>"); }

    // hapus file lama
    if (!empty($old_invoice) && file_exists($upload_dir_docs.$old_invoice)) {
        unlink($upload_dir_docs.basename($old_invoice));
    }
}


// ==============================================
// 2️⃣ UPLOAD FILE DEVICE PHOTO (photo_device)
// ==============================================

$upload_dir_photo = "uploads/inventory_photo/";
$new_devicePhoto = $old_devicePhoto; // default pakai yang lama

if (!file_exists($upload_dir_photo)) {
    mkdir($upload_dir_photo, 0775, true);
}

if (!empty($_FILES['photo_device']['name'])) {

    $allowed_ext2 = array('jpg','jpeg','png');
    $file_name2   = $_FILES['photo_device']['name'];
    $file_tmp2    = $_FILES['photo_device']['tmp_name'];
    $file_size2   = $_FILES['photo_device']['size'];
    $file_ext2    = strtolower(pathinfo($file_name2, PATHINFO_EXTENSION));

    if (!in_array($file_ext2, $allowed_ext2)) {
        die("<script>alert('Foto Perangkat harus JPG / PNG'); history.back()</script>");
    }

    if ($file_size2 > 3 * 1024 * 1024) {
        die("<script>alert('Maksimum ukuran foto 3MB'); history.back()</script>");
    }

    $new_devicePhoto = "DEV_" . $format_tgl . "_" . time() . "." . $file_ext2;
    $destination2 = $upload_dir_photo . $new_devicePhoto;

    if (!upload_move('photo_device', upload_allow('jpg', 'jpeg', 'png'), $destination2, 3 * 1024 * 1024)) { die("<script>alert(" . js(upload_error()) . "); history.back()</script>"); }

    // hapus file lama
    if (!empty($old_devicePhoto) && file_exists($upload_dir_photo.$old_devicePhoto)) {
        unlink($upload_dir_photo.basename($old_devicePhoto));
    }
}


// ==============================================
// 3️⃣ UPDATE DATA KE DATABASE
// ==============================================

$query = q_set($__p_query, "\r
UPDATE inventory_data SET\r
    Asset_ID = ? ,\r
    Make_Manufacturer = ? ,\r
    Model = ? ,\r
    Branch_id = ? ,\r
    Branch = ? ,\r
    DEPT = ? ,\r
    User = ? ,\r
    PrimarySecondary_Dev = ? ,\r
    Processor_Type_and_Speed = ? ,\r
    Purchase_Date = ? ,\r
    Purchase_Cost_Budget = ? ,\r
    New_Model = ? ,\r
    Month_Plan = ? ,\r
    Warranty_Expiry_Date = ? ,\r
    REMARK = ? ,\r
    STATUS = ? ,\r
    photo = ? ,\r
    dev_img = ?\r
WHERE id = ? \r
", [(string) ($Asset_ID), (string) ($Make_Manufacturer), (string) ($Model), (string) ($Branch_id), (string) ($Branch), (string) ($DEPT), (string) ($User), (string) ($PrimarySecondary_Dev), (string) ($Processor), (string) ($Purchase_Date), (string) ($Purchase_Cost_Budget), (string) ($New_Model), (string) ($Month_Plan), (string) ($Warranty_Expiry_Date), (string) ($REMARK), (string) ($STATUS), (string) ($new_invoice), (string) ($new_devicePhoto), (string) ($id)]);

// dulu: or die("Gagal update: " . mysql_error()) — detail error kini hanya di log
$result = db_query_or_die('Gagal update', $query, $__p_query ?? []);

?>

<script>
    if (window.opener) {
        window.opener.location.reload();
    }
    window.close();
</script>

<?php exit; ?>