<?php
session_start();
$userid = $_SESSION['userid'];
include '../config/koneksi.php';
if ($_SESSION['status'] != 'login') {
    echo "<script>
	alert('Anda Belum Login!');
	location.href='../index.php';
	</script>";
}

?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Website Galeri Foto</title>
    <link rel="stylesheet" type="text/css" href="../assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" /></head>

<body>
    <nav class="navbar navbar-expand-lg bg-dark mb-2">
        <div class="container">
            <a class="navbar-brand text-light" href="index.php">Website Galeri Foto</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup"
                aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse mt-2" id="navbarNavAltMarkup">
                <div class="navbar-nav me-auto">
                    <a href="home.php" class="nav-link text-secondary">Home</a>
                    <a href="album.php" class="nav-link text-secondary">Album</a>
                    <a href="foto.php" class="nav-link text-secondary">Foto</a>
                </div>
                <a href="../config/aksi_logout.php" class="btn btn-outline-danger m-1"><i class="bi bi-box-arrow-right"></i> Keluar</a>
            </div>
        </div>
    </nav>

    <div class="container mt-3">
        Album :
        <?php
        $album = mysqli_query($koneksi, "SELECT * FROM album WHERE userid='$userid'");
        while ($row = mysqli_fetch_array($album)) { ?>
        <a href="home.php?albumid=<?php echo $row['albumid'] ?>"
            class="btn btn-outline-dark"><?php echo $row['namaalbum'] ?></a>

        <?php } ?>

        <div class=" row">
            <?php
            if (isset($_GET['albumid'])) {
                $albumid = $_GET['albumid'];
                $query = mysqli_query($koneksi, "SELECT * FROM foto WHERE userid='$userid' AND albumid='$albumid'");
                while ($data = mysqli_fetch_array($query)) { ?>

            <div class="col-md-3 mt-2">
                <div class="card bg-dark text-light">
                    <img src="../assets/img/<?php echo $data['lokasifile'] ?>" class=" card-img-top"
                        title="../assets/img/<?php echo $data['judulfoto'] ?>" style="height: 12rem;">
                    <div class="card-footer text-center">
                        <?php
                                $fotoid = $data['fotoid'];
                                $ceksuka = mysqli_query($koneksi, "SELECT * FROM likefoto WHERE fotoid='$fotoid' AND userid='$userid'");
                                if (mysqli_num_rows($ceksuka) == 1) { ?>
                        <a href="../config/proses_like.php?fotoid=<?php echo $data['fotoid'] ?>" type="submit"
                            name="batalsuka"><i class=" fa fa-heart"></i></a>
                        <?php } else { ?>
                        <a href="../config/proses_like.php?fotoid=<?php echo $data['fotoid'] ?>" type="submit"
                            name="suka"><i class=" fa-regular fa-heart"></i></a>
                        <?php }
                                $like = mysqli_query($koneksi, "SELECT * FROM likefoto WHERE fotoid='$fotoid'");
                                echo
                                mysqli_num_rows($like) . ' Suka'; 
                                ?>
                        <a href=""><i class="fa-regular fa-comment"></i></a> 999 Komentar
                    </div>
                </div>
            </div>

            <?php } }else{ 

            $query = mysqli_query($koneksi, "SELECT * FROM foto WHERE userid='$userid'");
            while ($data = mysqli_fetch_array($query)) {
            ?>
            <div class="col-md-3 mt-2">
                <div class="card bg-dark text-light">
                    <img src="../assets/img/<?php echo $data['lokasifile'] ?>" class=" card-img-top"
                        title="../assets/img/<?php echo $data['judulfoto'] ?>" style="height: 12rem;">
                    <div class="card-footer text-center">
                        <?php
                            $fotoid = $data['fotoid'];
                            $ceksuka = mysqli_query($koneksi, "SELECT * FROM likefoto WHERE fotoid='$fotoid' AND userid='$userid'");
                            if (mysqli_num_rows($ceksuka) == 1) { ?>
                        <a href="../config/proses_like.php?fotoid=<?php echo $data['fotoid'] ?>" type="submit"
                            name="batalsuka"><i class=" fa fa-heart"></i></a>
                        <?php } else { ?>
                        <a href="../config/proses_like.php?fotoid=<?php echo $data['fotoid'] ?>" type="submit"
                            name="suka"><i class=" fa-regular fa-heart"></i></a>
                        <?php }
                            $like = mysqli_query($koneksi, "SELECT * FROM likefoto WHERE fotoid='$fotoid'");
                            echo
                            mysqli_num_rows($like) . ' Suka'; ?>
                        <a href=""><i class="fa-regular fa-comment"></i></a> 999 Komentar
                    </div>
                </div>
            </div>
            <?php } } ?>
        </div>
    </div>

    <footer class=" d-flex justify-content-center border-top mt-3 bg-dark fixed-bottom">
        <p class="text-light">&copy; UKK PPLG 2024 | Natannaeldf </p>
    </footer>

    <script type="text/javascript" src="../assets/js/bootstrap.min.js"></script>
</body>

</html>