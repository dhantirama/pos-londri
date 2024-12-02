<?php
include "../koneksi.php";

$id = isset($_GET['id']) ? $_GET['id'] : '';
$queryDetail = mysqli_query($koneksi, "SELECT 
type_of_service.service_name, 
type_of_service.price, 
trans_order.order_code, 
trans_order.order_date, 
trans_order.order_end_date,
trans_order.order_pay,
trans_order.order_change,
trans_order.total_price,
trans_order_detail.* 
FROM trans_order_detail 
LEFT JOIN type_of_service ON type_of_service.id = trans_order_detail.id_service 
LEFT JOIN trans_order ON trans_order.id = trans_order_detail.id_order 
WHERE trans_order_detail.id= '$id'");
$row = [];
while ($rowDetail = mysqli_fetch_assoc($queryDetail)) {
    $row[] = $rowDetail;
}




?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Transaksi : </title>
    <style>
        body {
            margin: 20px;
        }

        .struk {
            width: 80mm;
            max-width: 100%;
            border: 1px solid #000;
            padding: 10px;
            margin: 0 auto;
        }

        .struk-header,
        .struk-footer {
            text-align: center;
            margin-bottom: 10px;
        }

        .struk-header h1 {
            font-size: 18px;
            margin: 0;
        }

        .struk-body {
            margin-bottom: 10px;
        }

        .struk-body table {
            border-collapse: collapse;
            width: 100%;
        }

        .struk-body table th,
        .struk-body table td {
            padding: 5px;
            text-align: left;
        }

        .struk-body table th {
            border-bottom: 1px solid #000;
        }

        .total,
        .payment,
        .change {
            display: flex;
            justify-content: space-evenly;
            /* memberikan space antara dua bagian */
            padding: 5px 0;
            font-weight: bold;
        }

        .total {
            margin-top: 10px;
            border-top: 1px solid #000;
        }

        @media print {
            body {
                margin: 0;
                padding: 0;
                background-color: #BFECFF;
            }

            .struk {
                width: auto;
                border: none;
                margin: 0;
                padding: 0;
            }

            .struk-header h1,
            .struk-footer {
                font-size: 14px;
            }

            .struk-body table th,
            .struk-body table td {
                padding: 2px;
            }

            .total,
            .payment,
            .change {
                padding: 2px 0;
            }
        }
    </style>
</head>

<body>
    <div class="struk">
        <div class="struk-header">
            <h1>Laundry Banyak Gaya</h1>
            <p>Jl. Karet Jakarta Pusat</p>
            <p>08213694204</p>
        </div>
        <div class="struk-body">
            <table>
                <thead>
                    <tr>
                        <th>Paket</th>
                        <th>Harga</th>
                        <th>Jumlah</th>
                        <th>Sub Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($row as $key => $rowDetail) : ?>
                        <!-- cara panggilanya juga bisa $row as $rowDetail -->
                        <tr>
                            <td><?php echo $rowDetail['service_name'] ?></td>
                            <td><?php echo "Rp." . number_format($rowDetail['price']) ?></td>
                            <td><?php echo $rowDetail['qty'] ?></td>
                            <td><?php echo "Rp." . number_format($rowDetail['subtotal']) ?></td>
                        </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
        </div>
        <div class="struk-footer">
            <p>Terima Kasih</p>
            <p>Selamat Berbelanja Kembali</p>
        </div>
    </div>
    <script>
        //untuk print struk 
        window.onload = function() {
            window.print();
        }
    </script>
</body>

</html>