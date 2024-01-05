<?php
if (!isset($_SESSION)) {
    session_start();
}
if (!isset($_SESSION['role'])) {
    // Jika pengguna sudah login, tampilkan tombol "Logout"
    header("Location: index.php?page=loginDokter");
    exit;
}

?>
<h2>Riwayat Pasien</h2>
<br>
<div class="container">
    <br>
    <br>
    <!-- Table-->
    <table class="table table-hover">
        <!--thead atau baris judul-->
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Nama Pasien</th>
                <th scope="col">Tanggal Periksa</th>
                <th scope="col">No RM</th>
                <th scope="col">Catatan</th>
                <th scope="col">Obat</th>
                <th scope="col">Biaya</th>
            </tr>
        </thead>
        <!--tbody berisi isi tabel sesuai dengan judul atau head-->
        <tbody>
            <!-- Kode PHP untuk menampilkan semua isi dari tabel urut-->
            <?php
            $result = mysqli_query($mysqli, "SELECT ps.nama, ps.no_rm, pr.tgl_periksa, pr.catatan, o.nama_obat, pr.biaya_periksa FROM pasien AS ps
                                                JOIN daftar_poli AS dp ON ps.id = dp.id_pasien
                                                JOIN periksa AS pr ON dp.id = pr.id_daftar_poli
                                                JOIN detail_periksa AS dep ON pr.id = dep.id_periksa
                                                JOIN obat AS o ON dep.id_obat = o.id
                                                JOIN jadwal_periksa AS jp ON dp.id_jadwal = jp.id
                                                JOIN dokter AS dok ON jp.id_dokter = dok.id
                                                WHERE jp.id_dokter IN (SELECT id FROM dokter WHERE id =  '".$_SESSION['id_dokter']."')
                                            ");
            $no = 1;
            while ($data = mysqli_fetch_array($result)) {
            ?>
                <tr>
                    <th scope="row"><?php echo $no++ ?></th>
                    <td><?php echo $data['nama'] ?></td>
                    <td><?php echo $data['tgl_periksa'] ?></td>
                    <td><?php echo $data['no_rm'] ?></td>
                    <td><?php echo $data['catatan'] ?></td>
                    <td><?php echo $data['nama_obat'] ?></td>
                    <td><?php echo $data['biaya_periksa'] ?></td>
                </tr>
            <?php
            }
            ?>
        </tbody>
    </table>