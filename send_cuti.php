<?php
	session_start();
	if (isset($_SESSION["user"])) {
		if ($_SESSION["user"] == "admin") {
			header("Location: login.php");
		}
	}
	else {
		header("Location: login.php");
	}
	include "config.php";
    error_reporting(0);
    date_default_timezone_set('Asia/Jakarta');
	
	$type = $_FILES['nama_surat']['type'];
	if ($type == "application/pdf")
	{
		$katagoricuti = mysqli_real_escape_string($conn, $_POST["katagoricuti"]);
		$comment = mysqli_real_escape_string($conn, $_POST["comment"]);
		$id = $_SESSION["id"];
		$nama_surat = trim($_FILES['nama_surat']['name']);
		$date = date("Y-m-d H:i:s");

		$sql = "INSERT INTO cuti (id_pegawai, id_katagoricuti, deskripsi, _time) VALUES ('$id', '$katagoricuti', '$comment', '$date')";
		mysqli_query($conn, $sql);
		$query = mysqli_query($conn, "SELECT id_cuti FROM cuti ORDER BY id_cuti DESC LIMIT 1");
		$data  = mysqli_fetch_array($query);

		$nama_baru = "file_".$data['id_cuti'].".pdf";
		$file_temp = $_FILES['nama_surat']['tmp_name'];
		$folder    = "file";

		move_uploaded_file($file_temp, "$folder/$nama_baru");
		mysqli_query($conn, "UPDATE cuti SET nama_surat = '$nama_baru' WHERE id_cuti = '$data[id_cuti]' ");
		mysqli_close($conn);

		if ($_SESSION["user"] == "employee") {
			echo "<script>alert('Submitted Successfully');window.location.href='employee_cuti.php';</script>";
		} 
		else {
			echo "<script>alert('Submitted Successfully');window.location.href='unit_cuti.php';</script>";
		}
	} 
	else {
		if ($_SESSION["user"] == "employee") {
			echo "Gagal Upload File Bukan PDF! <a href='employee_cuti.php'> Kembali </a>";
		} 
		else {
			echo "Gagal Upload File Bukan PDF! <a href='unit_cuti.php'> Kembali </a>";
		}
	}
?>