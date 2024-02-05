<?php include "inc_header.php"; ?>

<?php
$judul    = "";
$sinopsis = "";
$genre    = "";
$harga    = ""; 
$gambar   = "";
$error    = "";
$sukses   = "";

if(isset($_POST['simpan'])){
    $judul    = $_POST['judul'];
    $sinopsis = $_POST['sinopsis'];
    $genre    = $_POST['genre'];
    $harga    = $_POST['harga']; 

    if ($_FILES['gambar']['error'] == 0) {
        $gambar = uploadGambar();  
    }

    if($judul == '' or $genre == '' or $harga == ''){
        $error  ="Silahkan masukkan semua data yakni data judul, genre, dan harga";
    }

    if (empty($error)) {
        $sql1 = "INSERT INTO halaman (judul, genre, sinopsis, harga, gambar) VALUES (?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($koneksi, $sql1);

        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "sssss", $judul, $genre, $sinopsis, $harga, $gambar);
            
            $result = mysqli_stmt_execute($stmt);

            if($result){
                $sukses   = "Sukses memasukkan data";
            }else{
                $error    = "Gagal memasukkan data";
            }

            mysqli_stmt_close($stmt);
        } else {
            $error = "Gagal membuat prepared statement";
        }
    }
}

function uploadGambar()
{
    $uploadDir = 'uploads/';  

    
    if (!file_exists($uploadDir)) {
        mkdir($uploadDir, 0777, true); 
    }

    $uploadedFile = $_FILES['gambar']['tmp_name'];
    $fileName = $_FILES['gambar']['name'];
    $destination = $uploadDir . $fileName;

    if (move_uploaded_file($uploadedFile, $destination)) {
        return $fileName;  
    } else {
        return false;
    }
}
?>

<h1>Halaman Novel Input Data</h1>
<div class="mb-3-row">
    <a href="halaman.php">&lt; Kembali ke halaman novel</a>
</div>

<?php
if($error){
?>
<div class="alert alert-danger" role="alert">
    <?php echo $error ?>
</div>
<?php 
}
?>

<?php
if($sukses){
?>
<div class="alert alert-primary" role="alert">
    <?php echo $sukses ?>
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
            <input type="submit" name="simpan" value="Simpan Data" class="btn btn-primary">
        </div>
    </div>
</form>

<?php include("inc_footer.php")?>