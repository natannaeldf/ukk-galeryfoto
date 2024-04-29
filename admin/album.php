<?php
session_start();
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

</head>

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

    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <div class="card mt-2">
                    <div class="card-header bg-dark text-light fw-bold">Tambah Album</div>
                    <div class="card-body">
                        <form action="../config/aksi_album.php" method="POST">
                            <label class="form-label fw-bold">Nama Album</label>
                            <input type="text" name="namaalbum" class="form-control" required>
                            <label class="form-label fw-bold">Deskripsi</label>
                            <textarea class="form-control" name="deskripsi" required></textarea>
                            <button type="submit" class="btn btn-primary mt-2" name="tambah"><i class="bi bi-file-earmark-plus"></i> Tambah Album</button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="card mt-2">
                    <div class="card-header bg-dark text-light fw-bold">Data Album</div>
                    <div class="card-body">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Album</th>
                                    <th>Deskripsi</th>
                                    <th>Tanggal</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
								$no = 1;
								$userid = $_SESSION['userid'];
								$sql = mysqli_query($koneksi, "SELECT * FROM album WHERE userid='$userid'");
								while ($data = mysqli_fetch_array($sql)) {
								?>
                                <tr>
                                    <td><?php echo $no++ ?></td>
                                    <td><?php echo $data['namaalbum'] ?></td>
                                    <td><?php echo $data['deskripsi'] ?></td>
                                    <td><?php echo $data['tanggalbuat'] ?></td>
                                    <td>
                                        <button type="button" class="btn btn-warning" data-bs-toggle="modal"
                                            data-bs-target="#edit<?php echo $data['albumid'] ?>"><i class="bi bi-pencil-square"></i>                                        </button>

                                        <div class="modal fade" id="edit<?php echo $data['albumid'] ?>" tabindex="-1"
                                            aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header bg-dark text-light fw-bold" data-bs-theme="dark">
                                                        <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Album
                                                        </h1>
                                                        <button type="button" class="btn-close btn-light" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form action="../config/aksi_album.php" method="POST">
                                                            <input type="hidden" name="albumid"
                                                                value="<?php echo $data['albumid'] ?>">
                                                            <label class="form-label fw-bold">Nama Album</label>
                                                            <input type="text" name="namaalbum"
                                                                value="<?php echo $data['namaalbum'] ?>"
                                                                class="form-control" required>
                                                            <label class="form-label fw-bold">Deskripsi</label>
                                                            <textarea class="form-control" name="deskripsi" required>
																	<?php echo $data['deskripsi']; ?>
																</textarea>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="submit" name="edit" class="btn btn-warning"><i class="bi bi-pencil-square"></i> Edit
                                                            Album</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                                            data-bs-target="#hapus<?php echo $data['albumid'] ?>"><i class="bi bi-trash"></i>                                        </button>

                                        <div class="modal fade" id="hapus<?php echo $data['albumid'] ?>" tabindex="-1"
                                            aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header bg-dark text-light" data-bs-theme="dark">
                                                        <h1 class="modal-title fs-5" id="exampleModalLabel">Hapus Album
                                                        </h1>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form action="../config/aksi_album.php" method="POST">
                                                            <input type="hidden" name="albumid"
                                                                value="<?php echo $data['albumid'] ?>">
                                                            Apakah Anda Yakin Akan Menghapus Album
                                                            <strong><?php echo $data['namaalbum'] ?> </strong>?
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="submit" name="hapus" class="btn btn-danger"><i class="bi bi-trash"></i> Hapus Album</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </td>
                                </tr>
                                <?php 	} ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <footer class="d-flex justify-content-center border-top mt-3 bg-dark fixed-bottom">
        <p class="text-light">&copy; UKK PPLG 2024 | Natannaeldf </p>
    </footer>

    <script type="text/javascript" src="../assets/js/bootstrap.min.js"></script>
</body>

</html>