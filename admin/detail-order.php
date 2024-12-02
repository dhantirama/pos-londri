<?php
include '../koneksi.php';

$dataCustomer = mysqli_query($koneksi, "SELECT * FROM customer ORDER BY id DESC");
$id = isset($_GET['ambil']) ? $_GET['ambil'] : "";
$queryTransDetail = mysqli_query($koneksi, "SELECT 
customer.nama_customer, 
customer.phone, 
customer.address, 
trans_order.id_customer,
trans_order.order_code,
trans_order.order_change, 
trans_order.order_pay, 
trans_order.total_price, 
trans_order.order_date, 
trans_order.order_status, 
type_of_service.service_name, 
type_of_service.price, 
trans_order_detail.* 
FROM trans_order_detail 
LEFT JOIN trans_order ON trans_order.id = trans_order_detail.id_order
LEFT JOIN customer ON customer.id = trans_order.id_customer
LEFT JOIN type_of_service ON type_of_service.id = trans_order_detail.id_service 
WHERE trans_order_detail.id_order = '$id'");

$row = [];
while ($dataTrans = mysqli_fetch_assoc($queryTransDetail)) {
    $row[] = $dataTrans;
}
$queryPaket = mysqli_query($koneksi, "SELECT * FROM type_of_service ORDER BY id DESC");
$rowPaket = [];
while ($data = mysqli_fetch_assoc($queryPaket)) {
    $rowPaket[] = $data;
}

$queryTransPickup = mysqli_query($koneksi, "SELECT * FROM trans_laundry_pickup WHERE id_order = '$id'"); //id diambil dari line 4


?>
<!DOCTYPE html>

<html
    lang="en"
    class="light-style layout-menu-fixed"
    dir="ltr"
    data-theme="theme-default"
    data-assets-path="../assets/"
    data-template="vertical-menu-template-free">

<head>
    <?php include '../inc/header.php' ?>
</head>

<body>
    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">
            <!-- Menu -->

            <?php include '../inc/sidebar.php' ?>
            <!-- / Menu -->

            <!-- Layout container -->
            <div class="layout-page">
                <!-- Navbar -->

                <?php include '../inc/navbar.php' ?>

                <!-- / Navbar -->

                <!-- Content wrapper -->
                <div class="content-wrapper">
                    <!-- Content -->
                    <?php if (isset($_GET['ambil'])) : ?>
                        <div class="container-xxl flex-grow-1 container-p-y">
                            <div class="row">
                                <div class="col-sm-12 mb-3">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <h5>Pengambilan Laundry <?php echo $row[0]['nama_customer'] ?></h5>
                                                </div>
                                                <div class="col-sm-6" align="right">
                                                    <a href="data-transaksi.php" class="btn btn-secondary">Kembali</a>
                                                    <a href="print.php?id=<?php echo $id ?>" class="btn btn-success">Print</a>
                                                    <a href="" class="btn btn-warning">Ambil Cucian</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="card">
                                        <div class="card-header">
                                            <h5>Data Transaksi</h5>
                                        </div>
                                        <div class="card-body">
                                            <table class="table table-bordered table-striped">
                                                <tr> <!-- mengapa tidak memakai foreach karena invoice satu untuk banyak transaksi, semantara foreach digunakan untuk memanggil seluruh data dri satu invoice -->
                                                    <th>No Invoice</th>
                                                    <td><?php echo $row[0]['order_code'] ?></td>
                                                </tr>
                                                <tr>
                                                    <th>Tanggal Laundry</th>
                                                    <td><?php echo $row[0]['order_date'] ?></td>
                                                </tr>
                                                <tr>
                                                    <th>Status</th>
                                                    <td></td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="card">
                                        <div class="card-header">
                                            <h5>Data Customer</h5>
                                        </div>
                                        <div class="card-body">
                                            <table class="table table-bordered table-striped">
                                                <tr>
                                                    <th>Nama</th>
                                                    <td><?php echo $row[0]['nama_customer'] ?></td>
                                                </tr>
                                                <tr>
                                                    <th>Telepon</th>
                                                    <td><?php echo $row[0]['phone'] ?></td>
                                                </tr>
                                                <tr>
                                                    <th>Alamat</th>
                                                    <td><?php echo $row[0]['address'] ?></td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12 mt-2">
                                    <div class="card">
                                        <div class="card-header">
                                            <h5>Transaksi Detail</h5>
                                        </div>
                                        <div class="card-body">
                                            <form action="" method="post">
                                                <table class="table table-bordered table-striped">
                                                    <thead>
                                                        <tr>
                                                            <th>No</th>
                                                            <th>Qty</th>
                                                            <th>Nama Paket</th>
                                                            <th>Harga</th>
                                                            <th>Subtotal</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        $no = 1;
                                                        $total = 0; // $total dimasukkan keatas foreach agar kembali k nol
                                                        foreach ($row as $key => $value) : ?>
                                                            <tr>
                                                                <td><?php echo $no++ ?></td>
                                                                <td><?php echo $value['qty'] ?></td>
                                                                <td><?php echo $value['service_name'] ?></td>
                                                                <td><?php echo $value['price'] ?></td>
                                                                <td><?php echo $value['subtotal'] ?></td>
                                                            </tr>
                                                            <tr>
                                                                <td colspan="4" align="right">
                                                                    <strong>Total Keseluruhan</strong>
                                                                </td>
                                                                <td><strong><input type="text" name="total_price" placeholder="Dibayar" class="form-control"
                                                                            value="<?php echo "Rp" .  number_format($value['total_price'])  ?>" readonly></strong></td>
                                                            </tr>
                                                            <tr>
                                                                <td colspan="4" align="right">
                                                                    <strong>Dibayar</strong>
                                                                </td>
                                                                <td>
                                                                    <strong>
                                                                        <input type="text" name="order_pay" placeholder="Dibayar" class="form-control"
                                                                            value="<?php echo "Rp" .  number_format($value['order_pay'])  ?>" readonly>
                                                                    </strong>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td colspan="4" align="right">
                                                                    <strong>Kembalian</strong>
                                                                </td>
                                                                <td>
                                                                    <strong>
                                                                        <input type="text" name="order_change" placeholder="Kembalian" class="form-control" value="<?php echo "Rp" . "" . number_format($value['order_change']) ?>" readonly>
                                                                    </strong>
                                                                </td>
                                                            </tr>
                                                        <?php endforeach ?>
                                                    </tbody>
                                                </table>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endif ?>
                    <!-- / Content -->

                    <!-- Footer -->
                    <?php include '../inc/footer.php'; ?>
</body>

</html>