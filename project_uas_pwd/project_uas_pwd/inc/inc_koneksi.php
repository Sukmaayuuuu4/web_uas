<?php
$host       = "localhost";
$user       = "root";
$pass       = "";
$db         = "project_uas_pwd";

$koneksi    = mysqli_connect($host, $user, $pass, $db);

if (!$koneksi) {
    die("Gagal terkoneksi: " . mysqli_connect_error());
}

?>
