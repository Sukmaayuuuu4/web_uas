<?php
include "inc_header.php";

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $sql = "SELECT * FROM halaman WHERE id = ?";
    $stmt = mysqli_prepare($koneksi, $sql);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "i", $id);
        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        if ($row = mysqli_fetch_assoc($result)) {
            $judul = $row['judul'];
            $genre = $row['genre'];
            $harga = $row['harga'];
            $sinopsis = $row['sinopsis'];
        } else {
            echo "Data not found.";
            exit;
        }

        mysqli_stmt_close($stmt);
    } else {
        echo "Error in prepared statement.";
        exit;
    }
} else {
    echo "ID parameter is missing.";
    exit;
}

if (isset($_POST['update'])) {
    $judul = $_POST['judul'];
    $genre = $_POST['genre'];
    $harga = $_POST['harga'];
    $sinopsis = $_POST['sinopsis'];
    $sqlUpdate = "UPDATE halaman SET judul = ?, genre = ?, harga = ?, sinopsis = ? WHERE id = ?";
    $stmtUpdate = mysqli_prepare($koneksi, $sqlUpdate);

    if ($stmtUpdate) {
        mysqli_stmt_bind_param($stmtUpdate, "ssssi", $judul, $genre, $harga, $sinopsis, $id);
        $resultUpdate = mysqli_stmt_execute($stmtUpdate);

        if ($resultUpdate) {
            $sukses = "Sukses mengupdate data";
        } else {
            $error = "Gagal mengupdate data";
        }

        mysqli_stmt_close($stmtUpdate);
    } else {
        $error = "Gagal membuat prepared statement untuk update";
    }

    if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] == UPLOAD_ERR_OK) {
        $gambar_tmp = $_FILES['gambar']['tmp_name'];
        $gambar_name = $_FILES['gambar']['name'];

        $upload_dir = 'uploads/';
        $gambar_path = $upload_dir . $gambar_name;

        move_uploaded_file($gambar_tmp, $gambar_path);

        $sqlUpdateGambar = "UPDATE halaman SET gambar = ? WHERE id = ?";
        $stmtUpdateGambar = mysqli_prepare($koneksi, $sqlUpdateGambar);

        if ($stmtUpdateGambar) {
            mysqli_stmt_bind_param($stmtUpdateGambar, "si", $gambar_name, $id);
            mysqli_stmt_execute($stmtUpdateGambar);

            mysqli_stmt_close($stmtUpdateGambar);
        }
    }
}

?>

<h1>Edit Halaman Novel</h1>
<a href="halaman.php">&lt; Kembali ke halaman novel</a>

<?php
if (isset($sukses)) {
    ?>
    <div class="alert alert-primary" role="alert">
        <?php echo $sukses ?>
    </div>
<?php
}

if (isset($error)) {
    ?>
    <div class="alert alert-danger" role="alert">
        <?php echo $error ?>
    </div>
<?php
}
?>

<form action="" method="post" enctype="multipart/form-data">
    <div class="mb-3 row">
        <label for="judul" class="col-sm-2 col-form-label">Judul</label>
        <div class="col-sm-10">
            <input type="text" class="form-control" id="judul" value="<?php echo $judul ?>" name="judul">
        </div>
    </div>
    <div class="mb-3 row">
        <label for="genre" class="col-sm-2 col-form-label">Genre</label>
        <div class="col-sm-10">
            <input type="text" class="form-control" id="genre" value="<?php echo $genre ?>" name="genre">
        </div>
    </div>
    <div class="mb-3 row">
        <label for="harga" class="col-sm-2 col-form-label">Harga</label>
        <div class="col-sm-10">
            <input type="text" class="form-control" id="harga" value="<?php echo $harga ?>" name="harga">
        </div>
    </div>
    <div class="mb-3 row">
        <label for="gambar" class="col-sm-2 col-form-label">Gambar</label>
        <div class="col-sm-10">
            <input type="file" class="form-control" id="gambar" name="gambar">
        </div>
    </div>
    <div class="mb-3 row">
        <label for="sinopsis" class="col-sm-2 col-form-label">Sinopsis</label>
        <div class="col-sm-10">
            <textarea name="sinopsis" class="form-control" id="summernote"><?php echo $sinopsis ?></textarea>
        </div>
    </div>
    <div class="mb-3 row">
        <div class="col-sm-2"></div>
        <div class="col-sm-10">
            <input type="submit" name="update" value="Update Data" class="btn btn-primary">
        </div>
    </div>
</form>

<?php include "inc_footer.php"; ?>
