<?php
include "template/header.php";
include "koneksi.php";

$pesan = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_pembeli = $_GET['id_pembeli'];
    $nama_pembeli = $_POST['nama_pembeli'];
    $alamat = $_POST['alamat'];

    $stmt = $pdo->prepare("UPDATE tb_pembeli SET nama_pembeli = :nama_pembeli, alamat = :alamat WHERE id_pembeli = :id_pembeli");
    $stmt->bindParam(':id_pembeli', $id_pembeli, PDO::PARAM_INT);
    $stmt->bindParam(':nama_pembeli', $nama_pembeli, PDO::PARAM_STR);
    $stmt->bindParam(':alamat', $alamat, PDO::PARAM_STR);
    $stmt->execute();

    $pesan = "Data pembeli berhasil diubah.";
}

$id_pembeli = $_GET['id_pembeli'];
$sql_pembeli = $pdo->prepare("SELECT * FROM tb_pembeli WHERE id_pembeli = :id_pembeli");
$sql_pembeli->bindParam(':id_pembeli', $id_pembeli, PDO::PARAM_INT);
$sql_pembeli->execute();
$data_pembeli = $sql_pembeli->fetch(PDO::FETCH_ASSOC);
?>

<h1>Update Data pembeli</h1>

<?php
if ($pesan != '') {
    echo "<div>$pesan</div>";
}
?>

<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . "?id_pembeli=" . $id_pembeli; ?>">
    <table cellpadding="8">
        <tr>
            <td>Nama pembeli</td>
            <td><input type="text" name="nama_pembeli" value="<?php echo $data_pembeli['nama_pembeli']; ?>"></td>
        </tr>
        <tr>
            <td>Alamat</td>
            <td><input type="text" name="alamat" value="<?php echo $data_pembeli['alamat']; ?>"></td>
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