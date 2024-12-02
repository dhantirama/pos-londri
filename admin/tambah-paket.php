<?php
include '../koneksi.php';
if (isset($_POST['simpan'])) {
    $nama_paket = $_POST['nama_paket'];
    $harga      = $_POST['harga'];
    $deskripsi  = $_POST['deskripsi'];

    $insert = mysqli_query($koneksi, "INSERT INTO paket (nama_paket, harga, deskripsi) VALUES ('$nama_paket', '$harga', '$deskripsi')");
    header("location: paket.php?tambah=berhasil");
}

$id = isset($_GET['edit']) ? $_GET['edit'] : '';
$querySet = mysqli_query($koneksi, "SELECT * FROM paket WHERE id = '$id'");
$rowSet = mysqli_fetch_assoc($querySet);

if (isset($_POST['edit'])) {
    $nama_paket = $_POST['nama_paket'];
    $harga      = $_POST['harga'];
    $deskripsi  = $_POST['deskripsi'];

    $update = mysqli_query($koneksi, "UPDATE paket SET nama_paket='$nama_paket', harga='$harga', deskripsi='$deskripsi' WHERE id = '$id'");
    header("location: paket.php?edit=berhasil");
}



?>


<!DOCTYPE html>
<html
  lang="en"
  class="light-style layout-menu-fixed"
  dir="ltr"
  data-theme="theme-default"
  data-assets-path="../assets/"
  data-template="vertical-menu-template-free"
>
  <head>
    <?php include '../inc/header.php'; ?>
  </head>

  <body>
    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar">
      <div class="layout-container">
        <!-- Menu -->

        <!-- / Menu -->
         <?php include '../inc/sidebar.php'; ?>
        <!-- Layout container -->
        <div class="layout-page">
          <!-- Navbar -->
           <?php include '../inc/navbar.php'; ?>
          <!-- / Navbar -->

          <!-- Content wrapper -->
          <div class="content-wrapper">
            <!-- Content -->

            <div class="container-xxl flex-grow-1 container-p-y">
              <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Forms /</span> Basic Inputs</h4>

              <div class="row">
                <div class="col-xl-12">
                  <!-- HTML5 Inputs -->
                  <div class="card mb-4">
                    <h5 class="card-header"><?php echo isset($_GET['edit']) ? 'Edit' : 'Tambah' ?> Paket</h5>
                    <form action="" method="post">
                        <div class="card-body">
                          <div class="mb-3 row">
                            <label for="html5-text-input" class="col-md-2 col-form-label">Jenis Paket</label>
                            <div class="col-md-10">
                              <input class="form-control" type="text" name="nama_paket" value="<?php echo isset($_GET['edit']) ? $rowSet['nama_paket'] : '' ?>" id="nama" />
                            </div>
                          </div>
                          <div class="mb-3 row">
                            <label for="html5-text-input" class="col-md-2 col-form-label">Harga</label>
                            <div class="col-md-10">
                              <input class="form-control" type="text" name="harga" value="<?php echo isset($_GET['edit']) ? $rowSet['harga'] : '' ?>" id="nama" />
                            </div>
                          </div>
                          <div class="mb-3 row">
                            <label for="html5-text-input" class="col-md-2 col-form-label">Deskripsi</label>
                            <div class="col-md-10">
                                <textarea name="deskripsi" class="form-control" colspan="5" id=""><?php echo isset($_GET['edit']) ? $rowSet['deskripsi'] : '' ?></textarea>
                            </div>
                          </div>
                        </div>
                        <div class="m-3">
                            <button class="btn btn-success" type="submit" name="<?php echo isset($_GET['edit']) ? 'edit' : 'simpan' ?>">Simpan</button>
                            <button class="btn btn-warning"name=""><a href="paket.php">Kembali</a></button>
                        </div>
                    </form>
                  </div>
                </div>
              </div>
            </div>
            <!-- / Content -->

            <!-- Footer -->
             <?php include '../inc/footer.php' ?>
  </body>
</html>
