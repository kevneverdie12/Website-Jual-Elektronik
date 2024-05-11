<?php
include "koneksi.php";

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id_pembeli'])) {
    // Ambil ID pelanggan dari parameter URL
    $id_pembeli = $_GET['id_pembeli'];

    // Query untuk menghapus data pelanggan berdasarkan ID
    $stmt = $pdo->prepare("DELETE FROM tb_pembeli WHERE id_pembeli = :id_pembeli");
    $stmt->bindParam(':id_pembeli', $id_pembeli, PDO::PARAM_INT);
    $stmt->execute();

    // Redirect kembali ke halaman view_pelanggan.php setelah penghapusan selesai
    header("Location: view_pelanggan.php");
    exit();
} else {
    // Redirect ke halaman view_pelanggan.php jika tidak ada ID pelanggan yang diberikan
    header("Location: view_pelanggan.php");
    exit();
}
?>
