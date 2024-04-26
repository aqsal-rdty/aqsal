<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembelian Bahan Bakar</title>
    <style>
        body {
            text-align: center;
            margin: 20;
            padding: 0;
            font-family: Arial, sans-serif;
            background-size: cover;
            color: #fff;
        }

        #container {
            width: 0%;
            margin: 50px auto;
            background-image: url(https://carnetwork.s3.ap-southeast-1.amazonaws.com/file/626e422dcfda4fceb83c33b7437d27c7.jpeg);
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            text-align: center;
            background-size: cover;
        }

        h2 {
            color: #FF6500;
            font-size: 20px;
        }

        form {
            margin-bottom: 20px;
            margin-top: 20px;
        }

        label {
            display: block;
            margin-bottom: 5px;
            color: #f9f9f9;
            /* Warna teks */
        }

        select,
        input[type="number"] {
            width: calc(30% - 10px);
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        button {
            width: calc(100% - 20px);
            padding: 15px;
            /* Perbesar tombol */
            border: none;
            border-radius: 4px;
            background-color: #FFC700;
            /* Warna tombol */
            color: #fff;
            /* Warna teks tombol */
            cursor: pointer;
        }

        button:hover {
            background-color: #45a049;
            /* Warna tombol hover */
        }

        hr {
            border: none;
            border-top: 1px dashed #ccc;
            margin: 20px 0;
        }

        .bukti-transaksi {
            text-align: center;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            background-color: #f9f9f9;
            /* Warna latar belakang bukti transaksi */
            color: #000;
            /* Warna teks output */
        }

        @media screen and (max-width: 600px) {
            #container {
                width: 90%;
                margin: 20px auto;
                /* Ubah margin agar terlihat lebih baik di layar kecil */
            }

            h2 {
                font-size: 30px;
                /* Sesuaikan ukuran judul untuk layar kecil */
            }
        }
    </style>
</head>

<body>
    <div id="container">
        <h2>Shell Bensin</h2>
        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            class Shell
            {
                protected $jenis;
                protected $harga;
                protected $jumlah;
                protected $ppn;

                public function __construct($jenis, $harga, $jumlah)
                {
                    $this->jenis = $jenis;
                    $this->harga = $harga;
                    $this->jumlah = $jumlah;
                    $this->ppn = 10; // PPN tetap 10%
                }

                public function getJenis()
                {
                    return $this->jenis;
                }

                public function getHarga()
                {
                    return $this->harga;
                }

                public function getJumlah()
                {
                    return $this->jumlah;
                }

                public function getPpn()
                {
                    return $this->ppn;
                }
            }

            class Beli extends Shell
            {
                public function hitungTotal()
                {
                    $total = $this->harga * $this->jumlah;
                    $total += $total * $this->ppn / 100;
                    return $total;
                }

                public function buktiTransaksi()
                {
                    $total = $this->hitungTotal();
                    echo "<div class='bukti-transaksi'>";
                    echo "<hr>"; // Garis putus-putus sebelum output
                    echo "<h3>Bukti Transaksi:</h3>";
                    echo "<p><strong>Anda membeli bahan bakar minyak dengan tipe :</strong> " . $this->jenis . "</p>";
                    echo "<p><strong>dengan jumlah :</strong> " . $this->jumlah . " Liter</p>"; // Menambahkan kata "Liter"
                    echo "<p><strong>Total yang harus anda bayar:</strong> Rp " . number_format($total, 2, ',', '.') . "</p>";
                    echo "<hr>"; // Garis putus-putus setelah output
                    echo "</div>";
                }
            }

            $hargaBahanBakar = [
                "Shell Super" => 15420.00,
                "Shell V-Power" => 16130.00,
                "Shell V-Power Diesel" => 18310.00,
                "Shell V-Power Nitro" => 16510.00,
            ];

            $jenis = $_POST["jenis"];
            $jumlah = $_POST["jumlah"];

            if (array_key_exists($jenis, $hargaBahanBakar)) {
                $harga = $hargaBahanBakar[$jenis];
                $beli = new Beli($jenis, $harga, $jumlah);
                $beli->buktiTransaksi();
            } else {
                echo "<p style='text-align: center;'>Jenis bahan bakar tidak valid.</p>";
            }
        }
        ?>

        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
            <label for="jenis">Jenis Bahan Bakar:</label>
            <select id="jenis" name="jenis">
                <option value="Shell Super">Shell Super</option>
                <option value="Shell V-Power">Shell V-Power</option>
                <option value="Shell V-Power Diesel">Shell V-Power Diesel</option>
                <option value="Shell V-Power Nitro">Shell V-Power Nitro</option>
            </select>
            <br><br>
            <label for="jumlah">Jumlah Liter:</label>
            <input type="number" id="jumlah" name="jumlah" min="0" step="1" required>
            <br><br>
            <button type="submit">Buy</button>
        </form>

    </div>
</body>

</html>