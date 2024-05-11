<?php
include "template/header.php";

// Cek apakah id_transaksi telah diberikan melalui parameter GET
if (!isset($_GET['id_transaksi'])) {
    echo "ID Transaksi tidak diberikan.";
    exit();
}

// Ambil id_transaksi dari parameter GET
$id_transaksi = $_GET['id_transaksi'];

// Include file koneksi.php
include "koneksi.php";

// Cek apakah form telah dikirimkan untuk disimpan
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil data yang dikirimkan melalui form
    $id_pembeli = $_POST['id_pembeli'];
    $id_produk = $_POST['id_produk'];
    $jumlah_obat = $_POST['jumlah_obat'];

    // Query untuk melakukan update transaksi
    $sql_update = $pdo->prepare("UPDATE transaksipenjualan SET id_pembeli = :id_pembeli, id_produk = :id_produk, jumlah_obat = :jumlah_obat WHERE id_transaksi = :id_transaksi");
    $sql_update->bindParam(':id_pembeli', $id_pembeli);
    $sql_update->bindParam(':id_produk', $id_produk);
    $sql_update->bindParam(':jumlah_obat', $jumlah_obat);
    $sql_update->bindParam(':id_transaksi', $id_transaksi);

    // Eksekusi query update
    if ($sql_update->execute()) {
        // Jika update berhasil, redirect ke halaman view_transaksi.php
        echo "<a href='view_transaksi.php'>kembali</a>";
        exit();
    } else {
        echo "Terjadi kesalahan saat melakukan update transaksi.";
    }
}

// Query untuk mendapatkan data transaksi berdasarkan id_transaksi
$sql_transaksi = $pdo->prepare("SELECT * FROM penjualan WHERE id_transaksi = :id_transaksi");
$sql_transaksi->bindParam(':id_transaksi', $id_transaksi);
$sql_transaksi->execute();
$data_transaksi = $sql_transaksi->fetch();

// Query untuk mendapatkan data pelanggan
$sql_pelanggan = $pdo->prepare("SELECT id_pembeli, nama_pembeli FROM tb_pembeli");
$sql_pelanggan->execute();
$data_pelanggan = $sql_pelanggan->fetchAll();
?>

<!-- Begin Page Content -->
<div class="container-fluid">

    <h1 class="h3 mb-4 text-gray-800">Edit Transaksi</h1>

    <div class="row">
        <div class="col-lg-6">

            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Form Edit Penjualan</h6>
                </div>
                <div class="card-body">
                    <form action="" method="POST">
                        <input type="hidden" name="id_transaksi" value="<?php echo $data_transaksi['id_transaksi']; ?>">

                        <div class="form-group">
                            <label>Nama Pembeli</label>
                            <select class="form-control" name="id_pembeli">
                                <?php foreach ($data_pelanggan as $pelanggan) : ?>
                                    <option value="<?php echo $pelanggan['id_pembeli']; ?>" <?php if ($pelanggan['id_pembeli'] == $data_transaksi['id_pembeli']) echo 'selected'; ?>>
                                        <?php echo $pelanggan['nama_pembeli']; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Nama Obat</label>
                            <select class="form-control" name="id_produk">
                                <?php
                                // Query untuk mendapatkan data produk
                                $sql_produk = $pdo->prepare("SELECT id_produk, nama_obat FROM tb_produk");
                                $sql_produk->execute();
                                $data_produk = $sql_produk->fetchAll();

                                // Loop untuk menampilkan opsi produk
                                foreach ($data_produk as $produk) :
                                ?>
                                    <option value="<?php echo $produk['id_produk']; ?>" <?php if ($produk['id_produk'] == $data_transaksi['id_produk']) echo 'selected'; ?>>
                                        <?php echo $produk['nama_obat']; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>


                        <div class="form-group">
                            <label>jumlah_obat</label>
                            <input type="text" class="form-control" name="jumlah_obat" value="<?php echo $data_transaksi['jumlah_obat']; ?>">
                        </div>

                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                        <a href="view_transaksi.php" class="btn btn-secondary">Kembali</a>
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