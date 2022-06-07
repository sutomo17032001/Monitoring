<?php
	session_start();
    if (isset($_SESSION["user"])) {
        if ($_SESSION["user"] != "admin") {
            header("Location: login.php");
        }
        elseif (!isset($_POST["id"]) and !isset($_POST["stats"])) {
            header("Location: login.php");
        }
    }
    else {
        header("Location: login.php");
    }
    include "config.php";
    error_reporting(0);
    date_default_timezone_set('Asia/Jakarta');
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS");

    $id_cuti = $_POST["id"];
    $stats = $_POST["stats"];
    $sql = "UPDATE cuti SET status_cuti='$stats' WHERE id_cuti='$id_cuti'";
    $result = mysqli_query($conn, $sql);
    $sql = "SELECT c.id_cuti, c.id_pegawai, p.nama_pegawai, c.id_katagoricuti, k.nama_cuti, c.deskripsi FROM cuti c JOIN pegawai p ON c.id_pegawai = p.id_pegawai JOIN katagori_cuti k ON c.id_katagoricuti = k.id_katagoricuti WHERE c.status_cuti = 0";
    $result = mysqli_query($conn, $sql);
    $arr = [];
    if ($result->num_rows > 0) {
        while ($row= $result->fetch_assoc()) {
            $arr[] = $row;
        }
    }
    mysqli_close($conn);
    $_POST["id"] = null;
    $_POST["stats"] = null;
    echo(json_encode($arr));
?>