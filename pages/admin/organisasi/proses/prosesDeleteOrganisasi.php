<?php
require_once('../../../../database/connection.php');
session_start();

// Ambil ID organisasi dari request
$idOrganisasi = (int)$_GET['id'];

try {
    // Pastikan koneksi database aktif
    if (!$db) {
        throw new Exception("Koneksi database gagal.");
    }

    // Ambil data organisasi untuk mendapatkan informasi file gambar
    $sqlSelect = "SELECT foto FROM organisasi WHERE idOrganisasi = ?";
    $stmtSelect = $db->prepare($sqlSelect);

    if (!$stmtSelect) {
        throw new Exception("Query prepare gagal: " . $db->error);
    }

    // Bind parameter dan eksekusi query
    $stmtSelect->bind_param("i", $idOrganisasi);
    if (!$stmtSelect->execute()) {
        throw new Exception("Query select gagal: " . $stmtSelect->error);
    }

    // Ambil hasil
    $result = $stmtSelect->get_result();
    if ($result->num_rows === 0) {
        throw new Exception("Organisasi tidak ditemukan.");
    }

    // Ambil nama file gambar
    $organisasi = $result->fetch_assoc();
    $fotoPath = "../../../../" . $organisasi['foto'];

    // Hapus file gambar jika ada
    if (file_exists($fotoPath) && !empty($organisasi['foto'])) {
        if (!unlink($fotoPath)) {
            throw new Exception("Gagal menghapus file gambar.");
        }
    }

    // Hapus data organisasi dari database
    $sqlDelete = "DELETE FROM organisasi WHERE idOrganisasi = ?";
    $stmtDelete = $db->prepare($sqlDelete);

    if (!$stmtDelete) {
        throw new Exception("Query prepare gagal: " . $db->error);
    }

    // Bind parameter dan eksekusi query
    $stmtDelete->bind_param("i", $idOrganisasi);
    if (!$stmtDelete->execute()) {
        throw new Exception("Query delete gagal: " . $stmtDelete->error);
    }

    // Set pesan sukses
    $_SESSION['messages'] = 'Organisasi telah berhasil dihapus.';
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
