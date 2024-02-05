<?php

if (isset($_POST['upload'])) {
    
    $uploadDir = 'uploads/';

    
    $uploadedFile = $_FILES['gambar']['tmp_name'];
    $fileName = $_FILES['gambar']['name'];

    
    $destination = $uploadDir . $fileName;

    
    if (move_uploaded_file($uploadedFile, $destination)) {
        echo "Gambar berhasil diupload.";
    } else {
        echo "Gagal mengupload gambar.";
    }
}
?>
