<?php
    session_start();
    if (isset($_SESSION["user"])) {
        if ($_SESSION["user"] != "admin" && $_SESSION["user"] != "unit" && $_SESSION["user"] != "employee") {
            header("Location: login.php");
        }
    }
    else {
        header("Location: login.php");
    }
    include "config.php";
    error_reporting(0);
    date_default_timezone_set('Asia/Jakarta');
    require_once("dompdf/autoload.inc.php");
    use Dompdf\Dompdf;
    $dompdf = new Dompdf();
    if($_SESSION["user"] == "admin"){
        if($_GET['test'] == 1){ 
            $sql = "SELECT p.nama_pegawai, p.jabatan_pegawai, u.nama_unit, a.latitude, a.longitude, a.nama_device, a._timestamp FROM pegawai p JOIN absensi a ON p.id_pegawai = a.id_pegawai JOIN unit u ON u.Id_unit = p.id_unit";
            $query = mysqli_query($conn, $sql);
            $html = '<center><h3>Daftar Absensi</h3></center><hr/><br/>';
            $html .= '<table border="1" width="100%">
                <tr>
                <th>Nama</th>
                <th>Jabatan</th>
                <th>Unit</th>
                <th>Latitude</th>
                <th>Longitude</th>
                <th>Device</th>
                <th>Time</th>
                </tr>';
            while($row = mysqli_fetch_array($query))
            {
                $html .= "<tr>
                <td>".$row['nama_pegawai']."</td>
                <td>".$row['jabatan_pegawai']."</td>
                <td>".$row['nama_unit']."</td> 
                <td>".$row['latitude']."</td>
                <td>".$row['longitude']."</td>
                <td>".$row['nama_device']."</td>
                <td>".$row['_timestamp']."</td>
                </tr>";
            }
            $html .= "</html>";
            $dompdf->loadHtml($html);
            // Setting ukuran dan orientasi kertas
            $dompdf->setPaper('A4', 'potrait');
            // Rendering dari HTML Ke PDF
            $dompdf->render();
            // Melakukan output file Pdf
            $dompdf->stream('Data absensi unit.pdf');
        } 
        else {
            $sql = "SELECT * FROM pegawai p JOIN unit u ON p.id_unit = u.id_unit ";
            $query = mysqli_query($conn, $sql);
            $html = '<center><h3>Daftar Pegawai</h3></center><hr/><br/>';
            $html .= '<table border="1" width="100%">
                <tr>
                <th>ID pegawai</th>
                <th>Nama</th>
                <th>Username</th>
                <th>Password</th>
                <th>Jabatan</th>
                <th>Unit</th>
                </tr>';
            while($row = mysqli_fetch_array($query))
            {
                $html .= "<tr>
                <td>".$row['id_pegawai']."</td>
                <td>".$row['nama_pegawai']."</td>
                <td>".$row['username']."</td>
                <td>".$row['sandi']."</td>
                <td>".$row['jabatan_pegawai']."</td>
                <td>".$row['nama_unit']."</td>
                </tr>";
            }
            $html .= "</html>";
            $dompdf->loadHtml($html);
            // Setting ukuran dan orientasi kertas
            $dompdf->setPaper('A4', 'potrait');
            // Rendering dari HTML Ke PDF
            $dompdf->render();
            // Melakukan output file Pdf
            $dompdf->stream('Data pegawai.pdf');
        }
    }
    switch($_SESSION["user"]){
        case "unit": 
            $id = $_SESSION["id"];
            $sql = "SELECT p.nama_pegawai, p.jabatan_pegawai, u.nama_unit, a.latitude, a.longitude, a.nama_device, a._timestamp FROM pegawai p JOIN absensi a ON p.id_pegawai = a.id_pegawai JOIN unit u ON u.Id_unit = p.id_unit WHERE  u.id_unit ='$id'";
            $query = mysqli_query($conn, $sql);
            $sql2 = "SELECT nama_unit FROM unit WHERE id_unit = '$id'";
            $query2 = mysqli_query($conn, $sql2);
            $result = mysqli_fetch_assoc($query2);
            $resultstring = $result['nama_unit'];
            $html = '<center><h3>Daftar Absensi</h3></center><hr/><br/>';
            $html .= '<table border="1" width="100%">
                <tr>
                <th>Nama</th>
                <th>Jabatan</th>
                <th>Unit</th>
                <th>Latitude</th>
                <th>Longitude</th>
                <th>Device</th>
                <th>Time</th>
                </tr>';
            while($row = mysqli_fetch_array($query))
            {
                $html .= "<tr>
                <td>".$row['nama_pegawai']."</td>
                <td>".$row['jabatan_pegawai']."</td>
                <td>".$row['nama_unit']."</td> 
                <td>".$row['latitude']."</td>
                <td>".$row['longitude']."</td>
                <td>".$row['nama_device']."</td>
                <td>".$row['_timestamp']."</td>
                </tr>";
            }
            $html .= "</html>";
            $dompdf->loadHtml($html);
            // Setting ukuran dan orientasi kertas
            $dompdf->setPaper('A4', 'potrait');
            // Rendering dari HTML Ke PDF
            $dompdf->render();
            // Melakukan output file Pdf
            $dompdf->stream('Data absensi unit ' . $resultstring . '.pdf');
            break;
        case "employee":
            $id = $_SESSION["id"];
            $sql = "SELECT p.nama_pegawai, p.jabatan_pegawai, u.nama_unit, a.latitude, a.longitude, a.nama_device, a._timestamp FROM pegawai p JOIN absensi a ON p.id_pegawai = a.id_pegawai JOIN unit u ON u.Id_unit = p.id_unit WHERE p.id_pegawai ='$id'";
            $query = mysqli_query($conn, $sql);
            $html = '<center><h3>Daftar Absensi</h3></center><hr/><br/>';
            $html .= '<table border="1" width="100%">
                <tr>
                <th>Nama</th>
                <th>Jabatan</th>
                <th>Unit</th>
                <th>Latitude</th>
                <th>Longitude</th>
                <th>Device</th>
                <th>Time</th>
                </tr>';
            while($row = mysqli_fetch_array($query))
            {
                $html .= "<tr>
                <td>".$row['nama_pegawai']."</td>
                <td>".$row['jabatan_pegawai']."</td>
                <td>".$row['nama_unit']."</td>
                <td>".$row['latitude']."</td>
                <td>".$row['longitude']."</td>
                <td>".$row['nama_device']."</td>
                <td>".$row['_timestamp']."</td>
                </tr>";
            }
            $html .= "</html>";
            $dompdf->loadHtml($html);
            // Setting ukuran dan orientasi kertas
            $dompdf->setPaper('A4', 'potrait');
            // Rendering dari HTML Ke PDF
            $dompdf->render();
            // Melakukan output file Pdf
            $dompdf->stream('Data absensi ' . $_SESSION['name'] . '.pdf');
            break;
        }
        mysqli_close($conn);
?>