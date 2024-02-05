<?php
include "inc_header.php";
?>

<style>
    body {
        font-family: 'Arial', sans-serif;
        background-color: yellow;
        padding: 20px;
    }

    h1 {
        color: #6f42c1;
    }

    p {
        margin-bottom: 20px;
    }

    .btn-primary {
        background-color: #6f42c1;
        border-color: #6f42c1;
    }

    .btn-primary:hover {
        background-color: #53368e;
        border-color: #53368e;
    }

    .form-control {
        margin-bottom: 10px;
    }

    .table {
        background-color: #fff;
        border-radius: 5px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    th,
    td {
        text-align: center;
    }

    th {
        background-color: #6f42c1;
        color: #fff;
    }

    .pagination {
        margin-top: 20px;
    }

    .pagination .page-item .page-link {
        color: black;
        border-color: purple;
    }

    .pagination .page-item.active .page-link {
        background-color: #6f42c1;
        border-color: #6f42c1;
    }

    .pagination .page-link {
        background-color: #f8f9fa;
    }

    .pagination .page-link:hover {
        background-color: #e9ecef;
    }

    .badge {
        margin-right: 5px;
    }

    .badge.bg-success a {
        color: #fff;
        text-decoration: none;
    }

    .badge.bg-danger a {
        color: #fff;
        text-decoration: none;
    }
</style>

<?php
$katakunci = (isset($_GET['katakunci'])) ? $_GET['katakunci'] : "";
if (isset($_GET['op'])) {
    $op = $_GET['op'];
} else {
    $op = "";
}
if ($op == 'delete') {
    $id = $_GET['id'];
    $sql1   = "DELETE FROM halaman WHERE id = '$id'";
    $q1     = mysqli_query($koneksi, $sql1);
    if ($q1) {
        $sukses = "Berhasil hapus data";
    }
}
?>

<h1>Halaman Novel</h1>

<form class="row g 3" method="get">
    <div class="col-auto">
        <input type="text" class="form-control" placeholder="Masukkan Nama Novel" name="katakunci" value="<?php echo $katakunci ?>" />
    </div>
    <div class="col-auto">
        <input type="submit" name="cari" class="btn btn-secondary" />
    </div>
</form>

<table class="table table-striped">
    <thead>
        <tr>
            <th class="col-1">No</th>
            <th>Judul</th>
            <th>Genre</th>
            <th>Harga</th>
            <th>Sinopsis</th>
            <th>Gambar</th>
            <th class="col-2">Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $sqltambahan = "";
        $per_halaman = 2;
        if ($katakunci != '') {
            $array_katakunci = explode(" ", $katakunci);
            $sqlcari = [];
            for ($x = 0; $x < count($array_katakunci); $x++) {
                $sqlcari[] = "(judul LIKE '%" . $array_katakunci[$x] . "%' OR genre LIKE '%" . $array_katakunci[$x] . "%' OR sinopsis LIKE '%" . $array_katakunci[$x] . "%')";
            }
            $sqltambahan = "WHERE " . implode(" OR ", $sqlcari);
        }
        $sql1 = "SELECT * FROM halaman $sqltambahan ";
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $mulai = ($page > 1) ? ($page * $per_halaman) - $per_halaman : 0;
        $q1 = mysqli_query($koneksi, $sql1);
        $total = mysqli_num_rows($q1);
        $pages = ceil($total / $per_halaman);
        $nomor = $mulai + 1;
        $sql1 = $sql1 . " ORDER BY id DESC LIMIT $mulai, $per_halaman ";

        $q1   = mysqli_query($koneksi, $sql1);

        while ($r1 = mysqli_fetch_array($q1)) {
        ?>
            <tr>
                <td><?php echo $nomor++ ?></td>
                <td><?php echo $r1['judul'] ?></td>
                <td><?php echo $r1['genre'] ?></td>
                <td><?php echo $r1['harga'] ?></td>
                <td><?php echo $r1['sinopsis'] ?></td>
                <td><img src="uploads/<?php echo $r1['gambar']; ?>" alt="Gambar Novel" style="max-width: 100px;"></td>
                <td>
                    <span class="badge bg-success">
                        <a href="beli_novel.php?id=<?php echo $r1['id'] ?>" onclick="return confirm('Apakah Anda ingin membeli novel ini?')">Beli</a>
                    </span>
                </td>
            </tr>
        <?php
        }
        ?>
    </tbody>
</table>

<div class="pagination">
    <ul class="pagination">
        <?php
        for ($i = 1; $i <= $pages; $i++) {
        ?>
            <li class="page-item <?php if ($i == $page) echo 'active'; ?>">
                <a class="page-link" href="halaman.php?katakunci=<?php echo $katakunci ?>&page=<?php echo $i ?>"><?php echo $i ?></a>
            </li>
        <?php
        }
        ?>
    </ul>
</div>