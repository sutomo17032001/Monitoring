<?php
    session_start();
    if (!isset($_SESSION["user"])) {
        header("Location: login.php");
    }
    include "config.php";
    error_reporting(0);
    date_default_timezone_set('Asia/Jakarta');
?>

<!DOCTYPE html>
<html>
    <head>
        <title>View Letter</title>
        <style type="text/css">
            body {
                font-family: verdana;
                font-size: 12px;
            }
        </style>
    </head>
    <script>
        function goBack() {
            window.history.back();
        }
    </script>
    <body>
        <h1>Aplikasi Upload PDF dengan PHP dan MySQl</h1>
        <hr>
        <b>Data File PDF</b>
        <hr>
        <?php
            $id  = mysqli_real_escape_string($conn,$_GET['id_cuti']);
            $sql = "SELECT * FROM cuti WHERE id_cuti='$id' ";
            $query = mysqli_query($conn,$sql);
            $data = mysqli_fetch_array($query);
        ?>
        <table width="100%" border="0">
            <tr>
                <td width="120">Nama File</td>
                <td>: <?php echo $data['nama_surat'];?></td>
            </tr>
        </table>
        <hr>
        <button onclick="goBack()">Go Back</button>
        <embed src="file/<?php echo $data['nama_surat'];?>" type="application/pdf" width="800" height="600" ></embed>
    </body>
</html>