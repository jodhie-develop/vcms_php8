<?php
require_once __DIR__ . "/_lib/bootstrap.php"; csrf_guard_get(); auth_require_login();
include __DIR__ . "/conndb.php";
$hari_ini = date("Y-m-d H:i:s");
$format_tgl = date("Ymd");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // Ambil semua field POST
    $Asset_ID               = in_val('Asset_ID', 'post');
    $Make_Manufacturer      = in_val('Make_Manufacturer', 'post');
    $PERFORMANCE_SCORE      = in_val('PERFORMANCE_SCORE', 'post');
    $Model                  = in_val('model', 'post');
    $Branch_id              = in_val('Branch_id', 'post');
    $Branch                 = in_val('Branch', 'post');
    $DEPT                   = in_val('DEPT', 'post');
    $User                   = in_val('User', 'post');
    $PrimarySecondary_Dev   = in_val('PrimarySecondary_Dev', 'post');
    $Processor_Type         = in_val('Processor_Type_and_Speed', 'post');
    $Purchase_Date          = in_val('Purchase_Date', 'post');
    $Purchase_Cost_Budget   = in_val('Purchase_Cost_Budget', 'post');
    $New_Model              = in_val('New_Model', 'post');
    $Month_Plan             = in_val('Month_Plan', 'post');
    $Warranty_Expiry_Date   = in_val('Warranty_Expiry_Date', 'post');
    $REMARK                 = in_val('REMARK', 'post');
    $STATUS                 = in_val('STATUS', 'post');

if($Branch == 'HO'){$kd_cbg = '00';}
elseif($Branch == 'East Sby'){$kd_cbg = '01';}
elseif($Branch == 'West Sby'){$kd_cbg = '02';}
elseif($Branch == 'Denpasar'){$kd_cbg = '03';}
elseif($Branch == 'South Jkt'){$kd_cbg = '04';}
elseif($Branch == 'North Jkt'){$kd_cbg = '05';}
elseif($Branch == 'PIK'){$kd_cbg = '11';}
elseif($Branch == 'West Jkt'){$kd_cbg = '06';}
elseif($Branch == 'Bandung'){$kd_cbg = '07';}
elseif($Branch == 'Malang'){$kd_cbg = '08';}
elseif($Branch == 'Medan'){$kd_cbg = '14';}
elseif($Branch == 'CA'){$kd_cbg = '15';}

	
	
    // -------------------------------------------------------
    // 1️⃣ PERSIAPAN UPLOAD FILE
    // -------------------------------------------------------
$upload_dir = "uploads/inventory_docs/";
    $Uploaded_File = ""; // default kosong

    if (!file_exists($upload_dir)) {
        mkdir($upload_dir, 0775, true);
    }

    if (!empty($_FILES['photo']['name'])) {

        $allowed_ext = array('jpg','jpeg','png','pdf');
        $file_name   = $_FILES['photo']['name'];
        $file_tmp    = $_FILES['photo']['tmp_name'];
        $file_size   = $_FILES['photo']['size'];

        $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

        // Validasi ekstensi
        if (!in_array($file_ext, $allowed_ext)) {
            die("<script>alert('File tidak diijinkan. Hanya JPG, PNG, PDF'); window.history.back();</script>");
        }

        // Validasi ukuran
        if ($file_size > 3 * 1024 * 1024) {
            die("<script>alert('Ukuran file max 3MB'); window.history.back();</script>");
        }

        // Nama file baru unik
        $new_filename = $kd_cbg.$format_tgl . "_" . time() . "." . $file_ext;
        $destination = $upload_dir . $new_filename;

        if (upload_move('photo', upload_allow('jpg', 'jpeg', 'png', 'pdf'), $destination, 3 * 1024 * 1024)) {
            $Uploaded_File = $new_filename;
        } else {
            die("<script>alert('Upload gagal'); window.history.back();</script>");
        }
    }
  // =======================================================
    // 2️⃣ UPLOAD FILE - DEVICE PHOTO
    // =======================================================
    $upload_dir2 = "uploads/inventory_photo/";
    $Uploaded_PhotoDevice = "";

    if (!file_exists($upload_dir2)) {
        mkdir($upload_dir2, 0775, true);
    }

    if (!empty($_FILES['photo_device']['name'])) {

        $allowed_ext2 = array('jpg','jpeg','png');
        $file_name2   = $_FILES['photo_device']['name'];
        $file_tmp2    = $_FILES['photo_device']['tmp_name'];
        $file_size2   = $_FILES['photo_device']['size'];

        $file_ext2 = strtolower(pathinfo($file_name2, PATHINFO_EXTENSION));

        if (!in_array($file_ext2, $allowed_ext2)) {
            die("<script>alert('Hanya JPG / PNG untuk Foto Perangkat'); window.history.back();</script>");
        }

        if ($file_size2 > 3 * 1024 * 1024) {
            die("<script>alert('Ukuran foto max 3MB'); window.history.back();</script>");
        }

        $new_filename2 = $kd_cbg.$format_tgl . "_DEV_" . time() . "." . $file_ext2;
        $destination2  = $upload_dir2 . $new_filename2;

        if (upload_move('photo_device', upload_allow('jpg', 'jpeg', 'png'), $destination2, 3 * 1024 * 1024)) {
            $Uploaded_PhotoDevice = $new_filename2;
        }
    }
    // -------------------------------------------------------
    // 2️⃣ SIMPAN DATA KE DATABASE
    // -------------------------------------------------------

    $sql = q_set($__p_sql, "INSERT INTO inventory_data (\r
        Asset_ID, Make_Manufacturer, PERFORMANCE_SCORE, Model, Branch_id, Branch, DEPT, User, \r
        PrimarySecondary_Dev, Processor_Type_and_Speed, Purchase_Date, Purchase_Cost_Budget,\r
        New_Model, Month_Plan, Warranty_Expiry_Date, REMARK, STATUS, photo, dt_entry,dev_img\r
    ) VALUES (\r
        ? ,? ,? ,? ,? ,? ,\r
        ? ,? ,? ,? ,? ,\r
        ? ,? ,? ,? ,\r
        ? ,? ,? ,? ,?\r
    )", [(string) ($Asset_ID), (string) ($Make_Manufacturer), (string) ($PERFORMANCE_SCORE), (string) ($Model), (string) ($Branch_id), (string) ($Branch), (string) ($DEPT), (string) ($User), (string) ($PrimarySecondary_Dev), (string) ($Processor_Type), (string) ($Purchase_Date), (string) ($Purchase_Cost_Budget), (string) ($New_Model), (string) ($Month_Plan), (string) ($Warranty_Expiry_Date), (string) ($REMARK), (string) ($STATUS), (string) ($Uploaded_File), (string) ($hari_ini), (string) ($Uploaded_PhotoDevice)]);

    $resource_sql = db_query_or_die('Error simpan data', $sql, $__p_sql ?? []);

    // -------------------------------------------------------
    // 3️⃣ SELESAI → TUTUP POPUP & REFRESH PAGE SEBELUMNYA
    // -------------------------------------------------------
    echo "<script>
        alert('Inventory Tersimpan');
        window.opener.location.reload(true);
        window.close();
    </script>";
}
?>