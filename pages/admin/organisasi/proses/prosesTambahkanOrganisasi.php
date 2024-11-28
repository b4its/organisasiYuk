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

    // Query untuk tabel pemasukan
    $sqlOrganisasi = "INSERT INTO organisasi (namaOrganisasi, deskripsi, jenis) 
                      VALUES (?, ?, ?)";
    $stmtOrganisasi = $db->prepare($sqlOrganisasi);

    // Periksa apakah prepare berhasil
    if (!$stmtOrganisasi) {
        throw new Exception("Query prepare gagal: " . $db->error);
    }

    // Bind parameter
    $stmtOrganisasi->bind_param("sss", $nama, $deskripsi, $jenis);

    // Eksekusi query
    if (!$stmtOrganisasi->execute()) {
        throw new Exception("Query execute gagal: " . $stmtOrganisasi->error);
    }

    // Set pesan sukses
    $_SESSION['messages'] = 'Penambahan organisasi telah berhasil.';
    $_SESSION['statusAlert'] = 'success';
    header("Location: ../../organisasi.php?p=dataOrganisasi");
    exit();
} catch (Exception $e) {
    // Tampilkan error
    echo "Error: " . $e->getMessage();
}
?>
