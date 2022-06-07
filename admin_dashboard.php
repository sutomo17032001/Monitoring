<?php
    session_start();
    if (isset($_SESSION["user"])) {
        if ($_SESSION["user"] != "admin") {
            header("Location: login.php");
        }
    }
    else {
        header("Location: login.php");
    }
    include "config.php"; 
    error_reporting(0);
    date_default_timezone_set('Asia/Jakarta');
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
                var id_cuti = "";
                $(document).on("click", ".contoh", function() {
                    var id = $(this).attr('id');
                    var name = $("#namaPegawai"+id).text();
                    var type = $("#namaCuti"+id).text();
                    var teks = $("#deskripsi"+id).val();
                    id_cuti = $("#idCuti"+id).val();
                    $("#Label").html(name);
                    $("#Body").html("Jenis Cuti: "+type);
                    $("#view").attr("href", "view_letter.php?id_cuti="+id_cuti);
                    $("#description").html("Deskripsi: "+teks);
                    $("#messageModal").modal('show');
                })
                $("#acc").click(function() {
                    $.post("set_cuti.php", 
                        {
                            id: id_cuti,
                            stats: 1
                        },
                        function(data, status){
                            console.log("Data: " + data + "\nStatus: " + status);
                            var dat = JSON.parse(data);
                            var len = dat.length;
                            $("#hasil").empty();
                            var res = "<h6 class='dropdown-header' style='position: sticky; top: 0; z-index: 99'>Message Center</h6>";
                            for (var i = 1;i <= len;i++) {
                                res += "<input type='hidden' id='idCuti"+i+"' value='"+dat[i-1]["id_cuti"]+"'>";
                                res += "<input type='hidden' id='deskripsi"+i+"' value='"+dat[i-1]["deskripsi"]+"'>";
                                res += "<a class='contoh dropdown-item d-flex align-items-center' id='"+i+"'";
                                res += "<div class='dropdown-list-image mr-3'>";
                                res += "<img class='rounded' src='img/pending.png' width='40' height='40' style='margin-right: 15px' alt='...'>";
                                res += "<div class='status-indicator bg-sucesss'></div></div>";
                                res += "<div class='font-weight-bold'>";
                                res += "<div class='text-truncate' id='namaCuti"+i+"'>"+dat[i-1]["nama_cuti"]+"</div>";
                                res += "<div class='small text-gray-500' id='namaPegawai"+i+"'>"+dat[i-1]["nama_pegawai"]+" #"+dat[i-1]["id_pegawai"]+"</div>";
                                res += "</div></a>";
                            }
                            $("#hasil").html(res);
                            $("#hitung").html(len);
                        });
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
    </head>
    <body id="page-top">
        <!-- Page Wrapper -->
        <div id="wrapper">
            <!-- Sidebar -->
            <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
                <!-- Sidebar - Brand -->
                <a class="sidebar-brand d-flex align-items-center justify-content-center">
                    <div class="sidebar-brand-icon ">
                        <img src="img/logoukp2.png" alt="blank" width="50" height="50">
                    </div>
                    <div class="sidebar-brand-text mx-3"><?php echo $_SESSION['name']; ?></div>
                </a>
                <!-- Divider -->
                <hr class="sidebar-divider my-0">
                <!-- Nav Item - Dashboard -->
                <li class="nav-item active">
                    <a class="nav-link" href="admin_dashboard.php">
                        <i class="fas fa-fw fa-tachometer-alt"></i>
                        <span>Dashboard</span></a>
                </li>
                <li class="nav-item inactive">
                    <a class="nav-link" href="admin_data_absensi.php">
                        <i class="fas fa-clipboard-check"></i>
                        <span>Data Absensi</span></a>
                </li>
                <li class="nav-item inactive">
                    <a class="nav-link" href="admin_data_pegawai.php">
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
                                        $sql = "SELECT c.id_cuti, c.id_pegawai, p.nama_pegawai, c.id_katagoricuti, k.nama_cuti, c.deskripsi FROM cuti c JOIN pegawai p ON c.id_pegawai = p.id_pegawai JOIN katagori_cuti k ON c.id_katagoricuti = k.id_katagoricuti WHERE c.status_cuti = 0";
                                        $result = mysqli_query($conn, $sql);
                                    ?>
                                    <span class="badge badge-danger badge-counter" id="hitung"><?php echo $result->num_rows;?></span>
                                </a>
                                <!-- Dropdown - Messages -->
                                <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                    aria-labelledby="messagesDropdown" id="hasil" style="overflow-y: auto; max-height:209px">
                                    <h6 class="dropdown-header" style='position: sticky; top: 0; z-index: 99'>
                                        Message Center
                                    </h6>
                                    <?php
                                        if ($result->num_rows > 0) {
                                            $counter = 1;
                                            while ($row = $result->fetch_assoc()) {
                                                $idc = $row["id_cuti"];
                                                $teks = $row["deskripsi"];
                                                echo "<input type='hidden' id='idCuti".$counter."' value='$idc'>";
                                                echo "<input type='hidden' id='deskripsi".$counter."' value='$teks'>";
                                                echo "<a class='contoh dropdown-item d-flex align-items-center' id='$counter'>";
                                                echo "<div class='dropdown-list-image mr-3'>";
                                                echo "<img class='rounded' src='img/pending.png' width='40' height='40' style='margin-right: 15px' alt='...'>";
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
                                    <span class="mr-2 d-none d-lg-inline text-gray-600 small">Kelompok 8</span>
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
                            <!-- Pie Chart -->
                            <div class="col-xs-12 col-sm-6 col-md-4">
                                <div class="card shadow mb-4">
                                    <!-- Card Header - Dropdown -->
                                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                        <h6 class="m-0 font-weight-bold text-primary">Absensi Tiap Unit</h6>
                                    </div>
                                    <!-- Card Body -->
                                    <div class="card-body">
                                        <div class="chart-bar">
                                            <canvas id="coba"></canvas>
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
                        <a class="btn btn-primary" href="logout.php">Logout</a>
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
                        <p id="Body"></p>
                        <p id="description"></p>
                        <a id="view" href="#">View Letter</a>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                        <a class="btn btn-primary" data-dismiss="modal" id="acc">Approve</a>
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
        <script src="js/demo/test.js"></script>
        <!-- Pie Chart php -->
        <?php 
            //data absen per bulan
            $sql1 = "SELECT COUNT(*) AS w FROM absensi a JOIN unit u ON u.Id_unit = a.id_unit WHERE u.id_unit = 1 AND MONTH(a._timestamp) = MONTH(CURRENT_DATE)";
            $query1 = mysqli_query($conn, $sql1);
            $result1 = mysqli_fetch_assoc($query1);
            
            //data izin per bulan
            $sql2 = "SELECT COUNT(*) AS x FROM absensi a JOIN unit u ON u.Id_unit = a.id_unit WHERE u.id_unit = 2 AND MONTH(a._timestamp) = MONTH(CURRENT_DATE)";
            $query2 = mysqli_query($conn, $sql2);
            $result2 = mysqli_fetch_assoc($query2);

            //total hari dalam bulan
            $sql3 = "SELECT COUNT(*) AS y FROM absensi a JOIN unit u ON u.Id_unit = a.id_unit WHERE u.id_unit = 3 AND MONTH(a._timestamp) = MONTH(CURRENT_DATE)";
            $query3 = mysqli_query($conn, $sql3);
            $result3 = mysqli_fetch_assoc($query3);

            $sql4 = "SELECT COUNT(*) AS z FROM absensi a JOIN unit u ON u.Id_unit = a.id_unit WHERE u.id_unit = 4 AND MONTH(a._timestamp) = MONTH(CURRENT_DATE)";
            $query4 = mysqli_query($conn, $sql4);
            $result4 = mysqli_fetch_assoc($query4);
            mysqli_close($conn);
        ?>
        <!-- Pie Chart config -->
        <script>
            Chart.defaults.global.defaultFontFamily = 'Nunito', '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
            Chart.defaults.global.defaultFontColor = '#858796';
            //total absen database
            var a = <?php echo $result1["w"];  ?>;
            //total absen frontend
            var b = <?php echo $result2["x"]; ?>;
            //total absen backend
            var c = <?php echo $result3["y"];  ?>;
            //total absen sekret
            var d = <?php echo $result4["z"];  ?>;
            // Donut Chart code
            var ctx = document.getElementById("coba");
            var coba = new Chart(ctx, {
            type: 'bar',
            data: {
                    labels: ['Database', 'FrontEnd', 'BackEnd', 'Sekret'],
                    datasets: [{
                        label: 'Count',
                        data: [a, b, c, d],
                        backgroundColor: [
                            'rgba(204, 241, 255, 1)',
                            'rgba(224, 215, 255, 1)',
                            'rgba(255, 204, 225, 1)',
                            'rgba(250, 255, 199, 1)',
                        ],
                        borderColor: [
                            'rgba(0, 0, 0, 0.2)',
                            'rgba(0, 0, 0, 0.2)',
                            'rgba(0, 0, 0, 0.2)',
                            'rgba(0, 0, 0, 0.2)',
                        ],
                        borderWidth: 2
                    }]
                },
                options: {
                            maintainAspectRatio: false,
                        }
            });
        </script>
    </body>
</html>