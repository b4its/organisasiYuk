<?php
require_once('../../database/connection.php');
session_start();

// Ambil data dari form
$nama = $_POST['nama'];
$alasan = $_POST['alasan'];
$user = (int)$_POST['user']; // ID pengguna
$organisasi = (int)$_POST['organisasi']; // ID organisasi

// Validasi data
if (empty($nama) || empty($alasan) || empty($user) || empty($organisasi)) {
    $_SESSION['messages'] = 'Data tidak valid. Pastikan semua field diisi.';
    $_SESSION['statusAlert'] = 'error';
    header("Location: ../index.php?p=halamanDashboard");
    exit();
}

try {
    // Pastikan koneksi database aktif
    if (!$db) {
        throw new Exception("Koneksi database gagal.");
    }

    // Query untuk menyimpan data ke tabel pendaftaranOrganisasi
    $sql = "INSERT INTO pendaftaranOrganisasi (user, nama, alasan, organisasi) 
            VALUES (?, ?, ?, ?)";
    $stmt = $db->prepare($sql);

    // Periksa apakah prepare berhasil
    if (!$stmt) {
        throw new Exception("Query prepare gagal: " . $db->error);
    }

    // Bind parameter
    $stmt->bind_param("isss", $user, $nama, $alasan, $organisasi);

    // Eksekusi query
    if (!$stmt->execute()) {
        throw new Exception("Query execute gagal: " . $stmt->error);
    }

    // Set pesan sukses
    $_SESSION['messages'] = 'anda telah berhasil mendaftar organisasi.';
    $_SESSION['statusAlert'] = 'success';
    header("Location: ../index.php?p=halamanDashboard");
    exit();
} catch (Exception $e) {
    // Set pesan error
    $_SESSION['messages'] = $e->getMessage();
    $_SESSION['statusAlert'] = 'error';
    header("Location: ../index.php?p=halamanDashboard");
    exit();
}
?>
