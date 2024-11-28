<?php
require_once('../../../../helper/currency.php');
require_once('../../../../database/connection.php');
session_start();

// Ambil data dari form
$nama = htmlspecialchars($_POST['nama']);
$deskripsi = htmlspecialchars($_POST['deskripsi']);
$jenis = htmlspecialchars($_POST['jenis']);

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

    // Proses unggah gambar
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['imageFile'])) {
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
        $rename_targetFile = str_replace("../../../../", "", $target_file);

        // Query untuk tabel organisasi
        $sqlOrganisasi = "INSERT INTO organisasi (namaOrganisasi, deskripsi, jenis, foto) 
                          VALUES (?, ?, ?, ?)";
        $stmtOrganisasi = $db->prepare($sqlOrganisasi);

        // Periksa apakah prepare berhasil
        if (!$stmtOrganisasi) {
            throw new Exception("Query prepare gagal: " . $db->error);
        }

        // Bind parameter
        $stmtOrganisasi->bind_param("ssss", $nama, $deskripsi, $jenis, $rename_targetFile);

        // Eksekusi query
        if (!$stmtOrganisasi->execute()) {
            throw new Exception("Query execute gagal: " . $stmtOrganisasi->error);
        }

        // Set pesan sukses
        $_SESSION['messages'] = 'Penambahan organisasi telah berhasil.';
        $_SESSION['statusAlert'] = 'success';
        header("Location: ../../organisasi.php?p=dataOrganisasi");
        exit();
    } else {
        throw new Exception("File gambar tidak ditemukan.");
    }
} catch (Exception $e) {
    // Set pesan error
    $_SESSION['messages'] = $e->getMessage();
    $_SESSION['statusAlert'] = 'error';
    header("Location: ../../organisasi.php?p=dataOrganisasi");
    exit();
}
?>
