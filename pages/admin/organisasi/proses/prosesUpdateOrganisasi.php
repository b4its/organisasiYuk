<?php
require_once('../../../../helper/currency.php');
require_once('../../../../database/connection.php');
session_start();

// Ambil data dari form
$nama = htmlspecialchars($_POST['nama']);
$deskripsi = htmlspecialchars($_POST['deskripsi']);
$jenis = htmlspecialchars($_POST['jenis']);
$idOrganisasi = (int)$_POST['idOrganisasi'];

// Validasi data
if (empty($nama) || empty($deskripsi) || empty($jenis)) {
    $_SESSION['messages'] = 'Data tidak valid.';
    $_SESSION['statusAlert'] = 'error';
    header("Location: ../../organisasi.php?p=dataOrganisasi");
    exit();
}

try {
    // Pastikan koneksi database aktif
    if (!$db) {
        throw new Exception("Koneksi database gagal.");
    }

    // Memeriksa apakah ada file gambar yang diunggah
    $foto = null;
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['imageFile']) && $_FILES['imageFile']['error'] == UPLOAD_ERR_OK) {
        $target_dir = "../../../../assets/media/";
        $target_file = $target_dir . basename($_FILES["imageFile"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Memeriksa apakah file benar-benar gambar
        $check = getimagesize($_FILES["imageFile"]["tmp_name"]);
        if ($check === false) {
            throw new Exception("File bukan gambar.");
        }

        // Memeriksa jika file sudah ada
        if (file_exists($target_file)) {
            throw new Exception("Maaf, file sudah ada.");
        }

        // Memeriksa ukuran file
        if ($_FILES["imageFile"]["size"] > 500_000) {
            throw new Exception("Maaf, file terlalu besar.");
        }

        // Memeriksa format file
        if (!in_array($imageFileType, ['jpg', 'png', 'jpeg', 'gif'])) {
            throw new Exception("Maaf, hanya JPG, JPEG, PNG & GIF yang diperbolehkan.");
        }

        // Memindahkan file ke direktori tujuan
        if (!move_uploaded_file($_FILES["imageFile"]["tmp_name"], $target_file)) {
            throw new Exception("Maaf, terjadi kesalahan saat mengunggah file.");
        }

        // Hapus path direktori sebelum menyimpan ke database
        $foto = str_replace("../../../../", "", $target_file);
    }

    // Jika ada file foto baru, sertakan di query update
    if ($foto) {
        $sqlOrganisasi = "UPDATE organisasi 
                          SET namaOrganisasi = ?, deskripsi = ?, jenis = ?, foto = ? 
                          WHERE idOrganisasi = ?";
        $stmtOrganisasi = $db->prepare($sqlOrganisasi);

        if (!$stmtOrganisasi) {
            throw new Exception("Query prepare gagal: " . $db->error);
        }

        // Bind parameter dengan foto
        $stmtOrganisasi->bind_param("ssssi", $nama, $deskripsi, $jenis, $foto, $idOrganisasi);
    } else {
        // Jika tidak ada file baru, update tanpa mengubah foto
        $sqlOrganisasi = "UPDATE organisasi 
                          SET namaOrganisasi = ?, deskripsi = ?, jenis = ? 
                          WHERE idOrganisasi = ?";
        $stmtOrganisasi = $db->prepare($sqlOrganisasi);

        if (!$stmtOrganisasi) {
            throw new Exception("Query prepare gagal: " . $db->error);
        }

        // Bind parameter tanpa foto
        $stmtOrganisasi->bind_param("sssi", $nama, $deskripsi, $jenis, $idOrganisasi);
    }

    // Eksekusi query
    if (!$stmtOrganisasi->execute()) {
        throw new Exception("Query execute gagal: " . $stmtOrganisasi->error);
    }

    // Set pesan sukses
    $_SESSION['messages'] = 'Data organisasi telah berhasil diperbarui.';
    $_SESSION['statusAlert'] = 'success';
    header("Location: ../../organisasi.php?p=dataOrganisasi");
    exit();
} catch (Exception $e) {
    // Set pesan error
    $_SESSION['messages'] = $e->getMessage();
    $_SESSION['statusAlert'] = 'error';
    header("Location: ../../organisasi.php?p=dataOrganisasi");
    exit();
}
?>
