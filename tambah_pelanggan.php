<?php
include "template/header.php";
include "koneksi.php";

$pesan = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil data pembeli yang dikirim melalui form
    $nama_pembeli = $_POST['nama_pembeli'];
    $alamat = $_POST['alamat'];

    // Query untuk menambahkan data pembeli ke dalam tabel
    $stmt = $pdo->prepare("INSERT INTO tb_pembeli (nama_pembeli, alamat) VALUES (:nama_pembeli, :alamat)");
    $stmt->bindParam(':nama_pembeli', $nama_pembeli, PDO::PARAM_STR);
    $stmt->bindParam(':alamat', $alamat, PDO::PARAM_STR);
    $stmt->execute();

    // Set pesan sukses jika penambahan berhasil
    $pesan = "Data pembeli berhasil ditambahkan.";
}
?>

<h1>Tambah Data pembeli</h1>

<?php
if ($pesan != '') {
    echo "<div>$pesan</div>";
}
?>

<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
    <table cellpadding="8">
        <tr>
            <td>Nama Pembeli</td>
            <td><input type="text" name="nama_pembeli"></td>
        </tr>
        <tr>
            <td>Alamat</td>
            <td><input type="text" name="alamat"></td>
        </tr>
    </table>
    <hr>

    <button type='submit' class="btn btn-success btn-icon-split">
        <span class='icon text-white-50'>
            <i class='fas fa-check'></i>
        </span>
        <span class='text'>Simpan</span>
    </button>
    <a href='view_pelanggan.php' class='btn btn-danger btn-icon-split'>
        <span class='icon text-white-50'>
            <i class='fas fa-trash'></i>
        </span>
        <span class='text'>Batal</span>
    </a>
</form>

<?php
include "template/footer.php";
?>