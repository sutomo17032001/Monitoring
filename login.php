<?php
  session_start();
  if (isset($_SESSION["user"])) {
    if ($_SESSION["user"] == "admin") {
        header("Location: admin_dashboard.php");
        exit;
    }
    else if ($_SESSION["user"] == "unit") {
        header("Location: unit_dashboard.php");
        exit;
    }
    else if ($_SESSION["user"] == "employee"){
        header("Location: employee_dashboard.php");
        exit;
    }
  }
  include 'config.php';
  error_reporting(0);
  date_default_timezone_set('Asia/Jakarta');
  if (isset($_POST['submit'])) {
      $user = test_input($_POST['user']);
      $password = test_input($_POST['password']);
      $sql = "SELECT * FROM biro WHERE username='$user' AND sandi='$password'";
      $result = mysqli_query($conn, $sql);
      if ($result->num_rows > 0) {
          $_SESSION["user"] = "admin";
          $_SESSION["name"] = "ADMIN";
          mysqli_close($conn);
          header("Location: admin_dashboard.php");
          exit;
      } else {
          $sql = "SELECT * FROM pegawai WHERE username='$user' AND sandi='$password'";
          $result = mysqli_query($conn, $sql);
          if ($result->num_rows > 0) {
              $row = mysqli_fetch_assoc($result);
              $_SESSION["name"] = $row['nama_pegawai'];
              $_SESSION["id"] = $row['id_pegawai'];
              $id = $row['id_pegawai'];
              $rank = $row['jabatan_pegawai'];
              $date = date("Y-m-d");
              $sql = "SELECT * FROM absensi WHERE id_pegawai='$id' AND DATE(_timestamp)='$date'";
              $result = mysqli_query($conn, $sql);
              if ($result->num_rows > 0) {
                  
              }
              else {
                  $unit = $row['id_unit'];
                  $lat = $_POST['latitude'];
                  $long = $_POST['longitude'];
                  $hostname = gethostbyaddr($_SERVER['REMOTE_ADDR']);
                  $date = date("Y-m-d H:i:s");
                  $curr_time = date("H:i:s", strtotime($date));
                  $curr_time = strtotime($curr_time);
                  $max_time = "10:00:00";
                  $max_time = strtotime($max_time);
                  if ($curr_time > $max_time) {
                    $sql = "INSERT INTO absensi (id_pegawai, id_unit, latitude, longitude, nama_device, _timestamp, terlambat)
                    VALUES ('$id', '$unit', '$lat', '$long', '$hostname', '$date', 1)";
                  }
                  else {
                    $sql = "INSERT INTO absensi (id_pegawai, id_unit, latitude, longitude, nama_device, _timestamp, terlambat)
                    VALUES ('$id', '$unit', '$lat', '$long', '$hostname', '$date', 0)";
                  }
                  $result = mysqli_query($conn, $sql);
              }
              mysqli_close($conn);
              if ($rank == "Kepala Unit") {
                  $_SESSION["user"] = "unit";
                  header("Location: unit_dashboard.php");
                  exit;
              }
              else {
                  $_SESSION["user"] = "employee";
                  header("Location: employee_dashboard.php");
                  exit;
              }
          }
          else {
              mysqli_close($conn);
              echo "<script>alert('Username atau password Anda salah. Silahkan coba lagi!')</script>";
          }
      }
  }
  function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }
?>
<title>Login Page</title>
<!-- Custom fonts for this template-->
<script>
    navigator.geolocation.getCurrentPosition(showPosition);
    function showPosition(position) {
        document.getElementById("longitude").value = position.coords.longitude;
        document.getElementById("latitude").value = position.coords.latitude;
    }
</script>
<!-- button pertama -->
<div id="login-button">
  <img src="https://dqcgrsy5v35b9.cloudfront.net/cruiseplanner/assets/img/icons/login-w-icon.png">
  </img>
</div>
<!-- login page -->
<div id="container">
  <h1>Log In</h1>
  <form class="user" method="POST" class="login-email" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                                        <div class="form-group">
                                            <input type="text" class="form-control form-control-user"
                                                id="user" name="user" 
                                                placeholder="Username" required>
                                        </div>
                                        <div class="form-group">
                                            <input type="password" class="form-control form-control-user"
                                                id="password" name="password" placeholder="Password" required>
                                        </div>
                                        <div class="form-group">
                                            <input type="hidden" id="latitude" name="latitude" value="0">
                                        </div>
                                        <div class="form-group">
                                            <input type="hidden" id="longitude" name="longitude" value="0">
                                        </div>
                                        <br>
                                        <button name="submit" class="btn btn-primary btn-user btn-block">
                                            Login
                                        </button>
</div>
<!-- style login page -->
<style>
html { 
  background: url('img/gedung.png') no-repeat center center fixed; 
  -webkit-background-size: cover;
  -moz-background-size: cover;
  -o-background-size: cover;
  background-size: cover;
  overflow: hidden;
}
img{
  display: block;
  margin: auto;
  width: 100%;
  height: auto;
}
#login-button{
  cursor: pointer;
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  padding: 30px;
  margin: auto;
  width: 100px;
  height: 100px;
  border-radius: 50%;
  background: rgba(3,3,3,.8);
  overflow: hidden;
  opacity: 0.8;
  box-shadow: 10px 10px 30px #000;}
/* Login container */
#container{
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  margin: auto;
  width: 260px;
  height: 260px;
  border-radius: 5px;
  background: rgba(3,3,3,0.6);
  box-shadow: 1px 1px 50px #000;
  display: none;
}
.close-btn{
  position: absolute;
  cursor: pointer;
  font-family: 'Open Sans Condensed', sans-serif;
  line-height: 18px;
  top: 3px;
  right: 3px;
  width: 20px;
  height: 20px;
  text-align: center;
  border-radius: 10px;
  opacity: 0.5;
  -webkit-transition: all 2s ease-in-out;
  -moz-transition: all 2s ease-in-out;
  -o-transition: all 2s ease-in-out;
  transition: all 0.2s ease-in-out;
}
.close-btn:hover{
  opacity: .7;
}
/* Heading */
h1{
  font-family: 'Open Sans Condensed', sans-serif;
  position: relative;
  margin-top: 0px;
  text-align: center;
  font-size: 40px;
  color: #ddd;
  text-shadow: 3px 3px 10px #000;
}
/* Inputs */
button,
input{
  font-family: 'Open Sans Condensed', sans-serif;
  text-decoration: none;
  position: relative;
  width: 80%;
  display: block;
  margin: 9px auto;
  font-size: 17px;
  color: #fff;
  padding: 8px;
  border-radius: 6px;
  border: none;
  background: rgba(3,3,3,.1);
  -webkit-transition: all 2s ease-in-out;
  -moz-transition: all 2s ease-in-out;
  -o-transition: all 2s ease-in-out;
  transition: all 0.2s ease-in-out;
}
input:focus{
  outline: none;
  box-shadow: 3px 3px 10px #333;
  background: rgba(3,3,3,.18);
}
/* Placeholders */
::-webkit-input-placeholder {
   color: #ddd;  }
:-moz-placeholder { /* Firefox 18- */
   color: red;  }
::-moz-placeholder {  /* Firefox 19+ */
   color: red;  }
:-ms-input-placeholder {  
   color: #333;  }
/* Link */
button{
  font-family: 'Open Sans Condensed', sans-serif;
  text-align: center;
  padding: 4px 8px;
  background: rgba(107,255,3,0.3);
}
button:hover{
  opacity: 0.7;
}
#remember-container{
  position: relative;
  margin: -5px 20px;
}
.checkbox {
  position: relative;
  cursor: pointer;
  -webkit-appearance: none;
  padding: 5px;
  border-radius: 4px;
  background: rgba(3,3,3,.2);
  display: inline-block;
  width: 16px;
  height: 15px;
}
.checkbox:checked:active {
  box-shadow: 0 1px 2px rgba(0,0,0,0.05), inset 0px 1px 3px rgba(0,0,0,0.1);
}
.checkbox:checked {
  background: rgba(3,3,3,.4);
  box-shadow: 0 1px 2px rgba(0,0,0,0.05), inset 0px -15px 10px -12px rgba(0,0,0,0.05), inset 15px 10px -12px rgba(255,255,255,0.5);
  color: #fff;
}
.checkbox:checked:after {
  content: '\2714';
  font-size: 10px;
  position: absolute;
  top: 0px;
  left: 4px;
  color: #fff;
}
#remember{
  position: absolute;
  font-size: 13px;
  font-family: 'Hind', sans-serif;
  color: rgba(255,255,255,.5);
  top: 7px;
  left: 20px;
}
#forgotten{
  position: absolute;
  font-size: 12px;
  font-family: 'Hind', sans-serif;
  color: rgba(255,255,255,.2);
  right: 0px;
  top: 8px;
  cursor: pointer;
  -webkit-transition: all 2s ease-in-out;
  -moz-transition: all 2s ease-in-out;
  -o-transition: all 2s ease-in-out;
  transition: all 0.2s ease-in-out;
}
#forgotten:hover{
  color: rgba(255,255,255,.6);
}
#forgotten-container{
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  margin: auto;
  width: 260px;
  height: 180px;
  border-radius: 10px;
  background: rgba(3,3,3,0.25);
  box-shadow: 1px 1px 50px #000;
  display: none;
}
.orange-btn{
  background: rgba(87,198,255,.5);
}
</style>
<!-- Bootstrap core JavaScript-->
<script src="vendor/jquery/jquery.min.js"></script>
<script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- Core plugin JavaScript-->
<script src="vendor/jquery-easing/jquery.easing.min.js"></script>
<!-- Custom scripts for all pages-->
<script src="js/sb-admin-2.min.js"></script>
<!-- script untuk button2 -->
<script src="js/newlogin.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/1.16.1/TweenMax.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>