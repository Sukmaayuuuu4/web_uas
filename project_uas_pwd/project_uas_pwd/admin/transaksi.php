<?php
session_start();

include("../inc/inc_koneksi.php");

if (!isset($_SESSION['admin_username'])) {
    header("location: login.php");
    exit();
}

$id_halaman = isset($_GET['id_halaman']) ? $_GET['id_halaman'] : '';

if (isset($_POST['beli'])) {
    
    $sql_transaksi = "INSERT INTO transaksi (id_halaman, username_admin) VALUES ('$id_halaman', '{$_SESSION['admin_username']}')";
    $result_transaksi = mysqli_query($koneksi, $sql_transaksi);

    if ($result_transaksi) {
        $pesan_berhasil = "Anda telah berhasil membeli halaman novel ini.";
    } else {
        $pesan_gagal = "Gagal melakukan transaksi. Silakan coba lagi.";
    }
}


$sql_halaman = "SELECT * FROM halaman WHERE id = '$id_halaman'";
$query_halaman = mysqli_query($koneksi, $sql_halaman);
$data_halaman = mysqli_fetch_assoc($query_halaman);


if (!$data_halaman) {
    
    header("location: halaman.php");
    exit();
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <title>Transaksi Halaman Novel</title>
</head>
<body style="width:100%;max-width:330px;margin:auto;padding:15px;">

    <h1>Halaman Novel</h1>

    <?php if (isset($pesan_berhasil)) : ?>
        <div class="alert alert-success" role="alert">
            <?php echo $pesan_berhasil; ?>
        </div>
    <?php endif; ?>

    <?php if (isset($pesan_gagal)) : ?>
        <div class="alert alert-danger" role="alert">
            <?php echo $pesan_gagal; ?>
        </div>
    <?php endif; ?>

    <h2>Detail Halaman Novel</h2>
    <p>Judul: <?php echo $data_halaman['judul']; ?></p>
    <p>Genre: <?php echo $data_halaman['genre']; ?></p>
    <p>Genre: <?php echo $data_halaman['harga']; ?></p>
    <p>Sinopsis: <?php echo $data_halaman['sinopsis']; ?></p>

    <form action="" method="POST">
        <button type="submit" class="btn btn-primary" name="beli">Beli Halaman Ini</button>
    </form>

    <p><a href="halaman.php">Kembali ke Halaman Novel</a></p>

</body>
</html>
