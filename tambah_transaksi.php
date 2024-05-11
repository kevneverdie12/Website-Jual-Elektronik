<?php
include "template/header.php";

// Include file koneksi.php
include "koneksi.php";

// Query untuk mendapatkan data pembeli
$sql_tb_pembeli = $pdo->prepare("SELECT id_pembeli, nama_pembeli FROM tb_pembeli");
$sql_tb_pembeli->execute();
$data_tb_pembeli = $sql_tb_pembeli->fetchAll();

// Query untuk mendapatkan data obat
$sql_produk = $pdo->prepare("SELECT id_produk, nama_obat FROM tb_produk");
$sql_produk->execute();
$data_produk = $sql_produk->fetchAll();

// Cek apakah form telah dikirimkan untuk disimpan
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil data yang dikirimkan melalui form
    $id_pembeli = $_POST['id_pembeli'];
    $id_produk = $_POST['id_produk'];
    $jumlah_obat = $_POST['jumlah_obat'];
    $tanggal_transaksi = date("Y-m-d H:i:s");

    $sql_produk_detail = $pdo->prepare("SELECT harga_obat FROM tb_produk WHERE id_produk = :id_produk");
    $sql_produk_detail->bindParam(':id_produk', $id_produk);
    $sql_produk_detail->execute();
    $produk_detail = $sql_produk_detail->fetch();
    $harga_obat = $produk_detail['harga_obat'];
    $total_harga = $harga_obat * $jumlah_obat;

    // Query untuk menyimpan transaksi baru
    $sql_insert = $pdo->prepare("INSERT INTO penjualan (id_pembeli, id_produk, jumlah_obat, total_harga, tanggal_transaksi) VALUES (:id_pembeli, :id_produk, :jumlah_obat, :total_harga, :tanggal_transaksi)");
    $sql_insert->bindParam(':id_pembeli', $id_pembeli);
    $sql_insert->bindParam(':id_produk', $id_produk);
    $sql_insert->bindParam(':jumlah_obat', $jumlah_obat);
    $sql_insert->bindParam(':total_harga', $total_harga);
    $sql_insert->bindParam(':tanggal_transaksi', $tanggal_transaksi);

    // Eksekusi query insert
    if ($sql_insert->execute()) {
        // Jika berhasil disimpan, redirect ke halaman view_transaksi.php
        echo "Data berhasil disimpan";
        echo "<a href='view_transaksi.php'>kembali</a>";
        exit();
    } else {
        echo "Terjadi kesalahan saat menyimpan transaksi.";
    }
}
?>

<!-- Begin Page Content -->
<div class="container-fluid">

    <h1 class="h3 mb-4 text-gray-800">Tambah Transaksi</h1>

    <div class="row">
        <div class="col-lg-6">

            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Form Tambah Transaksi</h6>
                </div>
                <div class="card-body">
                    <form action="" method="POST">
                        <div class="form-group">
                            <label>Nama tb_pembeli</label>
                            <select class="form-control" name="id_pembeli">
                                <?php foreach ($data_tb_pembeli as $tb_pembeli): ?>
                                    <option value="<?php echo $tb_pembeli['id_pembeli']; ?>"><?php echo $tb_pembeli['nama_pembeli']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Nama Produk</label>
                            <select class="form-control" name="id_produk">
                                <?php foreach ($data_produk as $produk): ?>
                                    <option value="<?php echo $produk['id_produk']; ?>"><?php echo $produk['nama_obat']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Kuantitas</label>
                            <input type="text" class="form-control" name="jumlah_obat">
                        </div>

                        <button type="submit" class="btn btn-primary">Simpan</button>
                        <a href="view_transaksi.php" class="btn btn-secondary">Batal</a>
                    </form>
                </div>
            </div>

        </div>
    </div>

</div>
<!-- /.container-fluid -->

<?php
include 'template/footer.php';
?>
