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
        <title>Data Absensi</title>
        <!-- Custom fonts for this template-->
        <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
        <!-- Custom styles for this template-->
        <link href="css/sb-admin-2.min.css" rel="stylesheet">
        <!-- Custom styles for this page -->
        <link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
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
                <li class="nav-item inactive">
                    <a class="nav-link" href="employee_dashboard.php">
                        <i class="fas fa-fw fa-tachometer-alt"></i>
                        <span>Dashboard</span></a>
                </li>
                <li class="nav-item active">
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
                        <!-- Page Heading -->
                        <div class="d-sm-flex align-items-center justify-content-between mb-4">
                            <h1 class="h3 mb-0 text-gray-800">Data Absensi </h1>
                            <a href="generate_report.php" class="d-none d-sm-inline-block btn btn-sm btn-info shadow-sm"><i
                                    class="fas fa-download fa-sm text-white-50"></i> Generate Report</a>
                        </div>
                        <div class="d-sm-flex align-items-center justify-content-end mb-4">  
                            <button onclick="window.print()" style="border:none; padding:0">
                                    <a class="d-none d-sm-inline-block btn btn-sm btn-info shadow-sm">
                                        <i class="fas fa-download fa-sm text-white-50"></i> Print Page</a>
                            </button>            
                        </div>
                        <div class="card shadow mb-4">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="dataTable1" width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th>Nama</th>
                                                <th>Hadir</th>
                                                <th>Terlambat</th>
                                                <th>Tidak masuk</th>
                                                <th>Sakit</th>
                                                <th>Cuti</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>
                                                <th>Nama</th>
                                                <th>Hadir</th>
                                                <th>Terlambat</th>
                                                <th>Tidak masuk</th>
                                                <th>Sakit</th>
                                                <th>Cuti</th>
                                                <th></th>
                                            </tr>
                                        </tfoot>
                                        <tbody>
                                            <?php
                                                //ambil nama pegawai
                                                $sql = "SELECT nama_pegawai FROM pegawai WHERE id_pegawai = '$id'";
                                                $query = mysqli_query($conn, $sql);
                                                $result = mysqli_fetch_assoc($query);
                                                //tgl skrng
                                                $sql0 = "SELECT Day(CURDATE()) AS total";
                                                $query0 = mysqli_query($conn, $sql0);
                                                $result0 = mysqli_fetch_assoc($query0);
                                                //ambil data hadir
                                                $sql1 = "SELECT COUNT(_timestamp) AS hadir FROM absensi WHERE MONTH(_timestamp) = MONTH(CURRENT_DATE) AND id_pegawai = '$id' ";
                                                $query1 = mysqli_query($conn, $sql1);
                                                $result1 = mysqli_fetch_assoc($query1);
                                                //ambil data terlambat
                                                $sql2 = "SELECT COUNT(_timestamp) AS telat FROM absensi WHERE MONTH(_timestamp) = MONTH(CURRENT_DATE) AND id_pegawai = '$id' AND terlambat = 1";
                                                $query2 = mysqli_query($conn, $sql2);
                                                $result2 = mysqli_fetch_assoc($query2);
                                                //ambil data sakit
                                                $sql3 = "SELECT COUNT(_time) AS sakit FROM cuti WHERE MONTH(_time) = MONTH(CURRENT_DATE) AND id_pegawai = '$id' AND id_katagoricuti = 1 ";
                                                $query3 = mysqli_query($conn, $sql3);
                                                $result3 = mysqli_fetch_assoc($query3);
                                                //ambil data cuti
                                                $sql4 = "SELECT COUNT(_time) AS cuti FROM cuti WHERE MONTH(_time) = MONTH(CURRENT_DATE) AND id_pegawai = '$id' AND NOT id_katagoricuti = 1 ";
                                                $query4 = mysqli_query($conn, $sql4);
                                                $result4 = mysqli_fetch_assoc($query4);
                                                //hitung jumlah absen (tidak masuk)
                                                $absen = $result0["total"] - $result1["hadir"];
                                                echo "
                                                <tr>
                                                <td>".$result['nama_pegawai']."</td>
                                                <td>".$result1["hadir"]."</td>
                                                <td>".$result2["telat"]."</td>
                                                <td>".$absen."</td>
                                                <td>".$result3["sakit"]."</td>
                                                <td>".$result4["cuti"]."</td>
                                                <td class = 'detail-control'><i class='fa fa-plus-square' aria-hidden='true'></td>
                                                </tr>
                                                ";
                                                mysqli_close($conn);
                                        ?>
                                        </tbody>
                                    </table>
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
                            <span aria-hidden="true">??</span>
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
                            <span aria-hidden="true">??</span>
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
        <script src="vendor/datatables/jquery.dataTables.min.js"></script>
        <script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>
        <!-- Page level custom scripts -->
        <script src="js/demo/datatables-demo.js"></script>
        <script src="http://maps.google.com/maps/api/js?sensor=false&callback=myMap"></script>
    </body>
    <script>
        /* Initialization of datatables */
        $(document).ready(function () {
            var table1 = $('#dataTable1').DataTable({
                columns: [
                    null,
                    null,
                    null,
                    null,
                    null,
                    null,
                    { orderable: false },
                  ]
            });
            $('#dataTable1 tbody').on( 'mouseenter', 'td', function () {
                var colIdx1 = table1.cell(this).index().column;
                $( table1.cells().nodes() ).removeClass( 'highlight' );
                $( table1.column( colIdx1 ).nodes() ).addClass( 'highlight' );
            });
            function createCookie(name, value, days) {
                var expires;
                if (days) {
                    var date = new Date();
                    date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
                    expires = "; expires=" + date.toGMTString();
                }
                else {
                    expires = "";
                }
                document.cookie = escape(name) + "=" + escape(value) + expires + "; path=/";
            }
            $('#dataTable1 tbody').on('click', 'td.detail-control', function () {
                var data = table1.row( this ).data();
                createCookie("test1234", data[0] , "10");
                window.location.href = "employee_absensi_detail.php";
            });
        });
    </script>  
    <style>
        td.highlight {
            background-color: whitesmoke !important;
        }
        td.detail-control {
            text-align:center;
            color:forestgreen;
            cursor: pointer;
        }
        tr.shown td.detail-control {
            text-align:center; 
            color:red;
        }
    </style>
</html>