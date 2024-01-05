<?php
if (!isset($_SESSION)) {
    session_start();
}
if (!isset($_SESSION['username'])) {
    // Jika pengguna sudah login, tampilkan tombol "Logout"
    header("Location: index.php?page=loginAdmin");
    exit;
}



if (isset($_POST['simpan'])) {
    if ($_POST['id_poli'] == '999') {
        echo'
            <script>alert("Poli Tidak Boleh Kosong")</script>
        ';
        echo'meta http-equiv="refresh" content="0>';
    }
    $password = $_POST['password'];
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    if (isset($_POST['id'])) {
        $ubah = mysqli_query($mysqli, "UPDATE dokter SET 
                                            nama = '" . $_POST['nama'] . "',
                                            nip = '" . $_POST['nip'] . "',
                                            password = '" . $_POST['password'] . "',
                                            alamat = '" . $_POST['alamat'] . "',
                                            no_hp = '" . $_POST['no_hp'] . "',
                                            id_poli = '" . $_POST['id_poli'] . "'
                                            WHERE
                                            id = '" . $_POST['id'] . "'");
    } else {
        $tambah = mysqli_query($mysqli, "INSERT INTO dokter (nama, nip, password, alamat, no_hp, id_poli) 
                                            VALUES (
                                                '" . $_POST['nama'] . "',
                                                '" . $_POST['nip'] . "',
                                                '" . $hashed_password . "',
                                                '" . $_POST['alamat'] . "',
                                                '" . $_POST['no_hp'] . "',
                                                '" . $_POST['id_poli'] . "'
                                            )");
    }
    echo "<script> 
                document.location='index.php?page=dokter';
                </script>";
}
if (isset($_GET['aksi'])) {
    if ($_GET['aksi'] == 'hapus') {
        $hapus = mysqli_query($mysqli, "DELETE FROM dokter WHERE id = '" . $_GET['id'] . "'");
    }

    echo "<script> 
                document.location='index.php?page=dokter';
                </script>";
}
?>
<h2>Dokter</h2>
<br>
<div class="container">
    <!--Form Input Data-->

    <form class="form row" method="POST" action="" name="myForm" onsubmit="return(validate());">
        <!-- Kode php untuk menghubungkan form dengan database -->
        <?php
        $nama_dokter = '';
        $nip = '';
        $password = '';
        $alamat = '';
        $no_hp = '';
        $id_poli = '';
        $namapoli = '';
        if (isset($_GET['id'])) {
            $ambil = mysqli_query($mysqli, "SELECT dk.*, po.nama_poli FROM dokter AS dk JOIN  poli AS po ON dk.id_poli = po.id
                    WHERE dk.id='" . $_GET['id'] . "'");
            while ($row = mysqli_fetch_array($ambil)) {
                $nama_dokter = $row['nama'];
                $nip = $row['nip'];
                $password = $row['password'];
                $alamat = $row['alamat'];
                $no_hp = $row['no_hp'];
                $id_poli = $row['id_poli'];
                $namapoli = $row["nama_poli"];
            }
        ?>
            <input type="hidden" name="id" value="<?php echo $_GET['id'] ?>">
        <?php
        }

        
        ?>
        <div class="row">
            <label for="inputNama" class="form-label fw-bold">
                Nama Dokter
            </label>
            <div>
                <input type="text" class="form-control" name="nama" id="inputNama" placeholder="Nama Dokter" value="<?php echo $nama_dokter ?>">
            </div>
        </div>
        <div class="row mt-1">
            <label for="inputNip" class="form-label fw-bold">
                NIP
            </label>
            <div>
                <input type="text" class="form-control" name="nip" id="inputNip" placeholder="NIP" value="<?php echo $nip ?>">
            </div>
        </div>
        <div class="row mt-1">
            <label for="inputPassword" class="form-label fw-bold">
                Password
            </label>
            <div>
                <input type="text" class="form-control" name="password" id="inputPassword" placeholder="Password" value="<?php echo $password ?>">
            </div>
        </div>
        <div class="row mt-1">
            <label for="inputAlamat" class="form-label fw-bold">
                Alamat
            </label>
            <div>
                <input type="text" class="form-control" name="alamat" id="inputAlamat" placeholder="Alamat" value="<?php echo $alamat ?>">
            </div>
        </div>
        <div class="row mt-1">
            <label for="inputHp" class="form-label fw-bold">
                No. HP
            </label>
            <div>
                <input type="text" class="form-control" name="no_hp" id="inputHp" placeholder="No. HP" value="<?php echo $no_hp ?>">
            </div>
        </div>
        <div class="row mt-1">
            <label for="id_poli" class="form-label fw-bold">
                Nama Poli
            </label>
            <div>
                <select class="form-select" aria-label="Default select example" name="id_poli" id ="id_poli" required>
                    <?php
                    if (!isset($_GET['id'])) {
                    ?>
                    <option value="999" selected>Pilih Poli</option>
                    <?php
                    }
                    else{
                    ?>
                    <option value="<?php echo $id_poli?>"><?php echo $namapoli?></option>
                    <?php
                    }
                        $ambilPoli = mysqli_query($mysqli, "SELECT * FROM poli");
                        
                        while ($row = mysqli_fetch_array($ambilPoli)) {
                            echo "<option value='" . $row["id"] . "'>" . $row["nama_poli"] . "</option>";
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
    <br>
    <br>
    <!-- Table-->
    <table class="table table-hover">
        <!--thead atau baris judul-->
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Nama Dokter</th>
                <th scope="col">Poli</th>
                <th scope="col">NIP</th>
                <th scope="col">Alamat</th>
                <th scope="col">No. HP</th>
                <th scope="col">Aksi</th>
            </tr>
        </thead>
        <!--tbody berisi isi tabel sesuai dengan judul atau head-->
        <tbody>
            <!-- Kode PHP untuk menampilkan semua isi dari tabel urut-->
            <?php
            $result = mysqli_query($mysqli, "SELECT dk.*, p.nama_poli FROM dokter AS dk JOIN poli AS p ON dk.id_poli = p.id");
            $no = 1;
            while ($data = mysqli_fetch_array($result)) {
            ?>
                <tr>
                    <th scope="row"><?php echo $no++ ?></th>
                    <td><?php echo $data['nama'] ?></td>
                    <td><?php echo $data['nama_poli'] ?></td>
                    <td><?php echo $data['nip'] ?></td>
                    <td><?php echo $data['alamat'] ?></td>
                    <td><?php echo $data['no_hp'] ?></td>
                    <td>
                        <a class="btn btn-success rounded-pill px-3" href="index.php?page=dokter&id=<?php echo $data['id'] ?>">Ubah</a>
                        <a class="btn btn-danger rounded-pill px-3" href="index.php?page=dokter&id=<?php echo $data['id'] ?>&aksi=hapus">Hapus</a>
                    </td>
                </tr>
            <?php
            }
            ?>
        </tbody>
    </table>