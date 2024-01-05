<?php
include_once("koneksi.php");
// getDokterJadwal.php

// Ambil id poli dari parameter GET
$id_poli = isset($_GET['idpoli']) ? $_GET['idpoli'] : null;

// Query untuk mendapatkan dokter dan jadwal berdasarkan id poli
$query = "SELECT po.*, dk.*, jp.*, jp.id AS jp_id FROM poli AS po 
            JOIN dokter AS dk ON po.id = dk.id_poli
            JOIN jadwal_periksa AS jp ON dk.id = jp.id_dokter
            WHERE po.id = $id_poli";

$result = mysqli_query($mysqli, $query);

// Buat opsi dokter dan jadwal
$options = '';
while ($row = mysqli_fetch_array($result)) {
    $options .= "<option value='" . $row["jp_id"] . "'>" . $row["nama"] . '-' . $row["hari"] . '-' . $row["nama_poli"] . "</option>";
}

echo $options;
?>
