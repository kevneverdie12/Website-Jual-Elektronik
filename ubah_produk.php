<?php
// Load file koneksi.php
include "template/header.php";
include "koneksi.php";

// Inisialisasi variabel untuk menampung pesan hasil proses
$pesan = '';

// Cek apakah form telah disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Tangkap data yang dikirim melalui form
    $id_obat = $_GET['id_obat'];
    $nama_obat = $_POST['nama_obat'];
    $harga_obat = $_POST['harga_obat'];
    $stok = $_POST['stok'];

    // Panggil stored procedure untuk mengubah data obat
    $stmt = $pdo->prepare("CALL update_obat(:id_obat, :nama_obat, :harga_obat, :stok)");
    $stmt->bindParam(':id_obat', $id_obat, PDO::PARAM_INT);
    $stmt->bindParam(':nama_obat', $nama_obat, PDO::PARAM_STR);
    $stmt->bindParam(':harga_obat', $harga_obat, PDO::PARAM_STR);
    $stmt->bindParam(':stok', $stok, PDO::PARAM_INT);
    $stmt->execute();

    // Periksa apakah proses perubahan berhasil atau tidak
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($result = true) {
        $pesan = "Data obat berhasil diubah.";
    } else {
        $pesan = "Gagal mengubah data obat.";
    }
}

// Ambil data obat berdasarkan ID yang dikirim melalui URL
$id_obat = $_GET['id_obat'];
$sql_obat = $pdo->prepare("SELECT * FROM tb_produk WHERE id_obat = :id_obat");
$sql_obat->bindParam(':id_obat', $id_obat, PDO::PARAM_INT);
$sql_obat->execute();
$data_obat = $sql_obat->fetch(PDO::FETCH_ASSOC);
?>

<h1>Update Data obat</h1>

<?php
// Tampilkan pesan hasil proses 
if ($pesan != '') {
    echo "<div>$pesan</div>";
}
?>

<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . "?id_obat=" . $id_obat; ?>">
    <table cellpadding="8">
        <tr>
            <td>Nama obat</td>
            <td><input type="text" name="nama_obat" value="<?php echo $data_obat['nama_obat']; ?>"></td>
        </tr>
        <tr>
            <td>harga_obat</td>
            <td><input type="text" name="harga_obat" value="<?php echo $data_obat['harga_obat']; ?>"></td>
        </tr>
        <tr>
            <td>stok</td>
            <td><input type="text" name="stok" value="<?php echo $data_obat['stok']; ?>"></td>
        </tr>
    </table>
    <hr>

    <button type='submit' class="btn btn-success btn-icon-split">
        <span class='icon text-white-50'>
            <i class='fas fa-check'></i>
        </span>
        <span class='text'>Update</span>
    </button>
    <a href='index.php' class='btn btn-danger btn-icon-split'>
        <span class='icon text-white-50'>
            <i class='fas fa-trash'></i>
        </span>
        <span class='text'>Batal</span>
    </a>
</form>
<?php
include "template/footer.php";
?>
