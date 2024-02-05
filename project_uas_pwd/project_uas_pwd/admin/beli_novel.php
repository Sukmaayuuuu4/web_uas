<?php include("inc_header.php"); ?>

<?php
if (isset($_GET['id'])) {
    $novel_id = $_GET['id'];

    $pesan = "Anda telah berhasil membeli novel ini! Anda sudah bisa membacanya:)";
} else {
    header("Location: halaman.php");
    exit();
}
?>

<h1>Halaman Pembelian</h1>

<?php if (isset($pesan)) : ?>
    <div class="alert alert-success" role="alert">
        <?php echo $pesan; ?>
    </div>
<?php endif; ?>

<a href="halaman.php">Kembali ke Halaman Utama</a>

<?php include("inc_footer.php"); ?>
