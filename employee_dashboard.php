<?php
    session_start();
    if (isset($_SESSION["user"])) {
        if ($_SESSION["user"] != "employee") {
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
    //ambil jabatan
    $sql2 = "SELECT jabatan_pegawai FROM pegawai WHERE id_pegawai='$id'";
    $result2 = mysqli_query($conn, $sql2);
    $row2 = mysqli_fetch_assoc($result2);
    //ambil nama unit
    $sql3 = "SELECT u.nama_unit FROM unit u JOIN pegawai p WHERE p.id_pegawai='$id'";
    $result3 = mysqli_query($conn, $sql3);
    $row3 = mysqli_fetch_assoc($result3);
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
                    var type = $("#namaCuti"+id).text();
                    var cuti = $("#idCuti"+id).val();
                    var teks = $("#deskripsi"+id).val();
                    $("#Label").html(type);
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
        <title>Dashboard</title>
        <!-- Custom fonts for this template-->
        <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
        <!-- Custom styles for this template-->
        <link href="css/sb-admin-2.min.css" rel="stylesheet">
        <link href="css/card.css" rel="stylesheet">
    </head>
    <body id="page-top">
        <!-- Page Wrapper -->
        <div id="wrapper">
            <!-- Sidebar -->
            <ul class="navbar-nav bg-gradient-info sidebar sidebar-dark accordion" id="accordionSidebar">
                <!-- Sidebar - Brand -->
                <a class="sidebar-brand d-flex align-items-center justify-content-center">
                    <div class="sidebar-brand-icon">
                        <img src="img/logoukp2.png" alt="blank" width="50" height="50">
                    </div>
                    <div class="sidebar-brand-text mx-3"><?php echo $_SESSION['name']; ?></div>
                </a>
                <!-- Divider -->
                <hr class="sidebar-divider my-0">
                <!-- Nav Item - Dashboard -->
                <li class="nav-item active">
                    <a class="nav-link" href="employee_dashboard.php">
                        <i class="fas fa-fw fa-tachometer-alt"></i>
                        <span>Dashboard</span></a>
                </li>
                <li class="nav-item inactive">
                    <a class="nav-link" href="employee_absensi.php">
                        <i class="fas fa-clipboard-check"></i>
                        <span>Data Absensi</span></a>
                </li>
                <li class="nav-item inactive">
                    <a class="nav-link" href="employee_cuti.php">
                        <i class="far fa-calendar-minus"></i>
                        <span>Pengajuan Cuti</span></a>
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
                                        $sql = "SELECT c.id_cuti, c.id_pegawai, p.nama_pegawai, c.id_katagoricuti, k.nama_cuti, c.status_cuti, c.deskripsi FROM cuti c JOIN pegawai p ON c.id_pegawai = p.id_pegawai JOIN katagori_cuti k ON c.id_katagoricuti = k.id_katagoricuti WHERE p.id_pegawai = '$id'";
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
                                                echo "<div class='small text-gray-500'>#".$counter."</div>";
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
                    <div class="container-fluid">
                        <!-- Content Row -->
                        <div class="row">
                            <!-- Pending Requests Card Example -->
                            <div class="col-xl-3 col-md-6 mb-4">
                                <div class="card border-left-warning shadow h-100 py-2">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                                    Pending Requests</div>
                                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                <?php
                                                    $sql = "SELECT id_cuti FROM cuti WHERE id_pegawai = '$id' AND status_cuti = 0";
                                                    $result = mysqli_query($conn, $sql);
                                                    echo $result->num_rows;
                                                ?>
                                                </div>
                                            </div>
                                            <div class="col-auto">
                                                <i class="fas fa-comments fa-2x text-gray-300"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Content Row -->
                        <div class="row">
                            <!-- Profile -->
                            <div class="col-xs-12 col-sm-6 col-md-4">
                                <div class="image-flip " ontouchstart="this.classList.toggle('hover');">
                                    <div class="mainflip">
                                        <div class="frontside shadow">
                                            <div class="card">
                                                <?php 
                                                    $sql = "SELECT tbl_img FROM pegawai WHERE id_pegawai = '$id'";
                                                    $result = mysqli_query($conn, $sql);
                                                    $row = mysqli_fetch_assoc($result);
                                                ?>
                                                <div class="card-body text-center">
                                                    <p><img class=" img-fluid" src="img/<?php echo $row["tbl_img"];?>" alt="card image"></p>
                                                    <h4 class="card-title"><?php echo $_SESSION['name']; ?></h4>
                                                    <p class="card-text"><?php echo $row2["jabatan_pegawai"]; ?></p>
                                                    <a href="#" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="backside shadow">
                                            <div class="card">
                                                <div class="card-body text-center mt-4">
                                                    <h4 class="card-title"> Unit : <?php echo $row3["nama_unit"]; ?></h4>
                                                    <p class="card-text">Halo, namaku <?php echo $_SESSION['name'];?>. Semangat untuk diriku :D </p>
                                                    <ul class="list-inline">
                                                        <li class="list-inline-item">
                                                            <a class="social-icon text-xs-center" href="">
                                                                <i class="fa fa-facebook"></i>
                                                            </a>
                                                        </li>
                                                        <li class="list-inline-item">
                                                            <a class="social-icon text-xs-center" href="">
                                                                <i class="fa fa-twitter"></i>
                                                            </a>
                                                        </li>
                                                        <li class="list-inline-item">
                                                            <a class="social-icon text-xs-center" href="">
                                                                <i class="fa fa-instagram"></i>
                                                            </a>
                                                        </li>
                                                        <li class="list-inline-item">
                                                            <a class="social-icon text-xs-center" href="">
                                                                <i class="fa fa-linkedin"></i>
                                                            </a>
                                                        </li>
                                                        <li class="list-inline-item">
                                                            <a class="social-icon text-xs-center" href="">
                                                                <i class="fa fa-google"></i>
                                                            </a>
                                                        </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- ./Team member -->
                            <!-- Pie Chart -->
                            <div class="col-xs-12 col-sm-6 col-md-4">
                                <div class="card shadow mb-4">
                                    <!-- Card Header - Dropdown -->
                                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                        <h6 class="m-0 font-weight-bold text-primary">Absensi</h6>
                                    </div>
                                    <!-- Card Body -->
                                    <div class="card-body">
                                        <div class="chart-pie pt-4 pb-2">
                                            <canvas id="coba2"></canvas>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
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
                        <h5 class="modal-title" id="Label"></h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p id="description"></p>
                        <a id="view" href="#">View Letter</a>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
                        <!-- <a class="btn btn-primary" data-dismiss="modal" id="acc">Approve</a> -->
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
        <!-- Add icon library -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    </body>
    <!-- Pie Chart php -->
    <?php 
        //data absen per bulan
        $sql1 = "SELECT COUNT(_timestamp) AS x FROM absensi a JOIN pegawai p ON p.id_pegawai = a.id_pegawai WHERE MONTH(a._timestamp) = MONTH(CURRENT_DATE) AND p.id_pegawai = '$id' ";
        $query1 = mysqli_query($conn, $sql1);
        $result1 = mysqli_fetch_assoc($query1);
        //data izin per bulan
        $sql2 = "SELECT COUNT(k.nama_cuti) AS y FROM cuti c JOIN pegawai p ON c.id_pegawai = p.id_pegawai JOIN katagori_cuti k ON k.id_katagoricuti = c.id_katagoricuti JOIN unit u ON u.Id_unit = p.id_unit WHERE p.id_pegawai = '$id'";
        $query2 = mysqli_query($conn, $sql2);
        $result2 = mysqli_fetch_assoc($query2);
        //tgl skrng
        $sql3 = "SELECT Day(CURDATE()) AS b";
        $query3 = mysqli_query($conn, $sql3);
        $result3 = mysqli_fetch_assoc($query3);
        //total hari dalam bulan
        $sql4 = "SELECT DAY(LAST_DAY( NOW() )) AS c";
        $query4 = mysqli_query($conn, $sql4);
        $result4 = mysqli_fetch_assoc($query4);
        mysqli_close($conn);
    ?>
    <!-- Pie Chart config -->
    <script>
    Chart.defaults.global.defaultFontFamily = 'Nunito', '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
    Chart.defaults.global.defaultFontColor = '#858796';
    //tidak masuk
    var z = 0;
    var b = <?php echo $result3["b"];  ?>;
    var c = <?php echo $result4["c"];  ?>;
    //total masuk
    var x = <?php echo $result1["x"];  ?>;
    //total izin
    var y = <?php echo $result2["y"]; ?>;
    //total tidak masuk
    var z = b - x;
    // Pie Chart Example
    var ctx = document.getElementById("coba2");
    var coba2 = new Chart(ctx, {
      type: 'pie',
      data: {
            labels: ['Masuk', 'Izin', 'Tidak masuk'],
            datasets: [{
                label: 'Count',
                data: [x, y, z],
                backgroundColor: [
                    'rgba(0, 0, 255, 0.8)',
                    'rgba(255, 255, 0, 0.8)',
                    'rgba(255, 0, 0, 0.8)',
                ],
                borderColor: [
                    'rgba(0, 0, 0, 0.3)',
                    'rgba(0, 0, 0, 0.3)',
                    'rgba(0, 0, 0, 0.3)',
                ],
                borderWidth: 1
            }]
        },
        options: {
                    maintainAspectRatio: false,
                }
    });
    </script>
</html>