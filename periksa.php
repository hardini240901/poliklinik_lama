<?php
if (!isset($_SESSION)) {
    session_start();
}
if (!isset($_SESSION['role'])) {
    // Jika pengguna sudah login, tampilkan tombol "Logout"
    header("Location: index.php?page=loginDokter");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $biaya_default = 150000;
    $tgl_periksa = $_POST['tgl_periksa'];
    $catatan = $_POST['catatan'];
    $harga_obat;
    $ambilHarga = mysqli_query($mysqli, "SELECT * FROM obat WHERE id = '" . $_POST['new_id_obat'] . "'");
    $data = mysqli_fetch_array($ambilHarga);
    $harga_obat = $data['harga'];
    $biaya_periksa = $biaya_default + $harga_obat;
    $id_dapol = $_GET['dpid'];
    $id_obat = $_POST['new_id_obat'];
    if (isset($_POST['simpan'])) {
        
            
        if (isset($_GET['id'])) {
            $ubah = mysqli_query($mysqli, "INSERT INTO periksa(id_daftar_poli, tgl_periksa, catatan, biaya_periksa) VALUES ('$id_dapol', '$tgl_periksa', '$catatan', '$biaya_periksa')");
                                                    
        }
        echo "<script>
                document.location='index.php?page=periksa&dpid=$id_dapol&id_obat=$id_obat&aksi=update';
                </script>";

        
        
    }
}
if (isset($_GET['aksi'])) {
    if ($_GET['aksi'] == 'update') {
        $id_dapol = $_GET['dpid'];
        $id_obat = $_GET['id_obat'];
        $id_periksa = mysqli_query($mysqli, "SELECT * FROM periksa WHERE id_daftar_poli = '$id_dapol'");
        $data = mysqli_fetch_array($id_periksa);
        $id_periksa = $data['id'];
        $simpan = mysqli_query($mysqli, "INSERT INTO detail_periksa(id_periksa, id_obat) VALUES ('$id_periksa', '$id_obat')");
    }

    echo "<script> 
                document.location='index.php?page=periksa';
                </script>";
}

?>
<h2>Periksa Pasien</h2>
<br>
<div class="container">
    <!--Form Input Data-->
    <?php
        if (isset($_GET["id"])) {
    ?>
            <form class="form row" method="POST" action="" name="myForm" onsubmit="return(validate());">
                <!-- Kode php untuk menghubungkan form dengan database -->
                <?php
                $nama_pasien = '';
                if (isset($_GET['id'])) {
                    $ambil = mysqli_query($mysqli, "SELECT ps.*
                                                        FROM pasien AS ps
                                                            WHERE ps.id = '" . $_GET['id'] . "'"
                                                        );
                    while ($row = mysqli_fetch_array($ambil)) {
                        $nama_pasien = $row['nama'];
                    }
                ?>
                    <input type="hidden" name="id" value="<?php echo $_GET['id'] ?>">
                <?php
                }
                ?>
                <div class="row">
                    <label for="inputNama" class="form-label fw-bold">
                        Nama Pasien
                    </label>
                    <div>
                        <input type="text" readonly class="form-control" name="nama_pasien" id="inputNama" placeholder="Nama Pasien" value="<?php echo $nama_pasien ?>">
                    </div>
                </div>
                <div class="row mt-1">
                    <label for="inputJadwal" class="form-label fw-bold">
                        Tanggal Periksa
                    </label>
                    <div>
                        <input type="datetime-local" class="form-control" name="tgl_periksa" id="inputJadwal" required placeholder="Tanggal Periksa">
                    </div>
                </div>
                <div class="row mt-1">
                    <label for="inputCatatan" class="form-label fw-bold">
                        Catatan
                    </label>
                    <div>
                        <input type="text" class="form-control" name="catatan" id="inputCatatan" required placeholder="Catatan">
                    </div>
                </div>
                <div class="row mt-1">
                <label for="inputObat" class="form-label fw-bold">
                    Obat
                </label>
                <div>
                    <select class="form-select" aria-label="Default select example" name="new_id_obat" id ="inputObat">
                        <?php
                            $ambilObat = mysqli_query($mysqli, "SELECT * FROM obat");
                            while ($row = mysqli_fetch_array($ambilObat)) {
                                echo "<option value='" . $row["id"] . "'>" . $row["nama_obat"] . "</option>";
                            }
                        ?>
                    </select>
                </div>
                </div>
                <div class="row mt-3">
                    <div class=col>
                        <button type="submit" class="btn btn-primary rounded-pill px-3 mt-auto" name="simpan">Simpan</button>
                    </div>
                </div>
            </form>
    <?php
        }
    ?>
    <br>
    <br>
    <!-- Table-->
    <table class="table table-hover">
        <!--thead atau baris judul-->
        <thead>
            <tr>
                <th scope="col">No. Antrian</th>
                <th scope="col">Pasien</th>
                <th scope="col">Keluhan</th>
                <th scope="col">Aksi</th>
            </tr>
        </thead>
        <!--tbody berisi isi tabel sesuai dengan judul atau head-->
        <tbody>
            <!-- Kode PHP untuk menampilkan semua isi dari tabel urut-->
            <?php
            $result = mysqli_query($mysqli, "SELECT ps.id, ps.nama AS nama_pasien, dp.id AS dpid, dp.keluhan, dp.no_antrian
                                                FROM daftar_poli AS dp
                                                    JOIN pasien AS ps ON ps.id = dp.id_pasien
                                                    JOIN jadwal_periksa AS jp ON dp.id_jadwal = dp.id_jadwal
                                                    JOIN dokter AS dok ON jp.id_dokter = dok.id
                                                WHERE  dp.id_jadwal = jp.id AND jp.id_dokter = '".$_SESSION['id_dokter']."'
                                                    ");
            while ($data = mysqli_fetch_array($result)) {
            ?>
                <tr>
                    <td><?php echo $data['no_antrian'] ?></td>
                    <td><?php echo $data['nama_pasien'] ?></td>
                    <td><?php echo $data['keluhan'] ?></td>
                    <td>
                        <a class="btn btn-success rounded-pill px-3" href="index.php?page=periksa&id=<?php echo $data['id'] ?>&dpid=<?php echo $data['dpid'] ?>">Periksa</a>
                    </td>
                </tr>
            <?php
            }
            ?>
        </tbody>
    </table>
</div>