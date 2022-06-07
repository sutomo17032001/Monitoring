<?php
session_start();
if (isset($_SESSION["user"])) {
    if ($_SESSION["user"] != "unit") {
        header("Location: login.php");
    }
}
else {
    header("Location: login.php");
}
include "config.php"; 
error_reporting(0);
date_default_timezone_set('Asia/Jakarta');
$id = $_SESSION["id"];
$date = date("Y-m-d");
$sql = "SELECT * FROM absensi WHERE id_pegawai='$id' AND DATE(_timestamp)='$date'";
$result = mysqli_query($conn, $sql);
if ($result->num_rows > 0) {
    $row = mysqli_fetch_assoc($result);
    $lat = $row['latitude'];
    $lat = round($lat, 3);
    $long = $row['longitude'];
    $long = round($long, 3);
    if (($lat == -7.255 or $lat == -7.256) and ($long == 112.749 or $long == 112.450)) {
        $type = "Work From Office";
    }
    else {
        $type = "Work From Home";
    }
}
        $timeout = 7200; // durasi sebelum sesi berakhir (dalam detik)
        $logout = "login.php";
        if(isset($_SESSION['start_session'])){
            $elapsed_time = time()-$_SESSION['start_session'];
            if($elapsed_time >= $timeout){
                session_destroy();
                echo "<script type='text/javascript'>alert('Sesi telah berakhir');window.location='$logout'</script>";
            }
        }
        $_SESSION['start_session']=time();
?>
<!DOCTYPE html>
<html lang="en">
<head>
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script>
    $(document).ready(function() {
        $(document).on("click", ".contoh", function() {
            var id = $(this).attr('id');
            var name = $("#namaPegawai"+id).text();
            var type = $("#namaCuti"+id).text();
            var cuti = $("#idCuti"+id).val();
            var teks = $("#deskripsi"+id).val();
            $("#Body").html("Jenis Cuti: "+type);
            $("#Label").html(name);
            $("#view").attr("href", "view_letter.php?id_cuti="+cuti);
            $("#description").html("Deskripsi: "+teks);
            $("#messageModal").modal('show');
        })
    })
</script>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Pengajuan Cuti</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
    <link href="css/stylecuti.css" rel="stylesheet">
</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-info sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <!--<a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">-->
            <a class="sidebar-brand d-flex align-items-center justify-content-center">
                <div class="sidebar-brand-icon">
                    <img src="img/logoukp2.png" alt="blank" width="50" height="50">
                </div>
                <div class="sidebar-brand-text mx-3"><?php echo $_SESSION['name']; ?></div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <li class="nav-item inactive">
                <a class="nav-link" href="unit_dashboard.php">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span></a>
            </li>

            <li class="nav-item inactive">
                <a class="nav-link" href="unit_data_absensi.php">
                    <i class="fas fa-clipboard-check"></i>
                    <span>Data Absensi</span></a>
            </li>

            <li class="nav-item active">
                <a class="nav-link" href="unit_cuti.php">
                    <i class="far fa-calendar-minus"></i>
                    <span>Pengajuan Cuti</span></a>
            </li>

            <li class="nav-item inactive">
                <a class="nav-link" href="unit_data_pegawai.php">
                    <i class="fas fa-fw fa-table"></i>
                    <span>Data Pegawai</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">

            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>

        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>

                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">

                        <!-- Nav Item - Messages -->
                        <li class="nav-item dropdown no-arrow mx-1">
                            <a class="nav-link dropdown-toggle" href="#" id="messagesDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-envelope fa-fw"></i>
                                <!-- Counter - Messages -->
                                <?php
                                $sql = "SELECT id_unit FROM pegawai WHERE id_pegawai = '$id'";
                                $result = mysqli_query($conn, $sql);
                                $row = mysqli_fetch_assoc($result);
                                $unit = $row['id_unit'];
                                $sql = "SELECT c.id_cuti, c.id_pegawai, p.nama_pegawai, c.id_katagoricuti, k.nama_cuti, c.status_cuti, c.deskripsi FROM cuti c JOIN pegawai p ON c.id_pegawai = p.id_pegawai JOIN katagori_cuti k ON c.id_katagoricuti = k.id_katagoricuti WHERE p.id_unit = '$unit'";
                                $result = mysqli_query($conn, $sql);
                                ?>
                                <span class="badge badge-danger badge-counter"><?php echo $result->num_rows;?></span>
                            </a>
                            <!-- Dropdown - Messages -->
                            <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="messagesDropdown" style="overflow-y: auto; max-height:209px">
                                <h6 class="dropdown-header" style='position: sticky; top: 0; z-index: 99'>
                                    Message Center
                                </h6>
                                <?php
                                if ($result->num_rows > 0) {
                                    $counter = 1;
                                    while ($row = $result->fetch_assoc()) {
                                        $sta = $row["status_cuti"];
                                        $cuti = $row["id_cuti"];
                                        $teks = $row["deskripsi"];
                                        $src = "img/pending.png";
                                        if ($sta == 1) {
                                            $src = "img/accepted.png";
                                        }
                                        echo "<input type='hidden' id='idCuti".$counter."' value='$cuti'>";
                                        echo "<input type='hidden' id='deskripsi".$counter."' value='$teks'>";
                                        echo "<a class='contoh dropdown-item d-flex align-items-center' id='$counter'>";
                                        echo "<div class='dropdown-list-image mr-3'>";
                                        echo "<img class='rounded' src='".$src."' width='40' height='40' alt='...'>";
                                        echo "<div class='status-indicator bg-sucesss'></div>";
                                        echo "</div>";
                                        echo "<div class='font-weight-bold'>";
                                        echo "<div class='text-truncate' id='namaCuti".$counter."'>".$row["nama_cuti"]."</div>";
                                        echo "<div class='small text-gray-500' id='namaPegawai".$counter."'>".$row["nama_pegawai"]." #".$row["id_pegawai"]."</div>";
                                        echo "</div>";
                                        echo "</a>";
                                        $counter++;
                                    }
                                }
                                
                                ?>
                            </div>
                        </li>

                        <div class="topbar-divider d-none d-sm-block"></div>

                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?php echo $type; ?></span>
                                <img class="img-profile rounded-circle"
                                    src="img/logoukp2.png">
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Logout
                                </a>
                            </div>
                        </li>

                    </ul>

                </nav>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-cuti">
                    <div class="form-container">
					    <h1 style="font-weight: bold">FORM CUTI</h1>
				    </div>
				    <form action="send_cuti.php" method="post" enctype="multipart/form-data">
					    <div class="form-group">
                            <label for="katagoricuti">Kategori</label>
                            <select name="katagoricuti" class="form-control" id="dropbox-container">
                            <?php
                                $sql2="SELECT * FROM katagori_cuti";
                                $resultset=mysqli_query($conn,$sql2);
                                while($hsl=mysqli_fetch_array($resultset))
                                {
                                ?>
                                    <option value="<?php echo $hsl["id_katagoricuti"];?>">
                                        <?php
                                            echo $hsl["nama_cuti"];
                                        ?>
                                    </option>
                                <?php
                                }
                                mysqli_close($conn);
                            ?>
                            </select>
                        </div>
                        <tr>
                            <td width="150">File PDF</td>
                        </tr>
                        <div class="form-group">
                            <input type="file" name="nama_surat" id="nama_surat" required>
                        </div>
                        <tr>
                            <td width="150">Comment</td>
                        </tr>
                        <div class="form-group color-border-focus">
                            <textarea class="form-control" name="comment" id="comment" rows="4" cols="40" placeholder="Write something here..."></textarea>
                        </div>
                        <div class="loading-dock">
                            <button type="input" class="btn btn-success">Submit</button>
                        </div>
                    </form>
			    </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-info" href="logout.php">Logout</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Message Modal-->
    <div class="modal fade" id="messageModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="Label">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p id="Body"></p>
                    <p id="description"></p>
                    <a id="view" href="#">View Letter</a>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

    <!-- Page level plugins -->
    <script src="vendor/chart.js/Chart.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="js/demo/chart-area-demo.js"></script>
    <script src="js/demo/chart-pie-demo.js"></script>

</body>

</html>