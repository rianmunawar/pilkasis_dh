<?php
session_start();
if (!isset($_SESSION["login"])) {
  header("location:../index.php");
  exit;
}
include '../koneksi.php';

if (isset($_POST['simpan'])) {
  $NISN_ketua = mysqli_real_escape_string($koneksi, $_POST['NISN_ketua']);
  $nm_paslon_ketua = mysqli_real_escape_string($koneksi, $_POST['nm_paslon_ketua']);
  $NISN_wakil = mysqli_real_escape_string($koneksi, $_POST['NISN_wakil']);
  $nm_paslon_wakil = mysqli_real_escape_string($koneksi, $_POST['nm_paslon_wakil']);
  $no_urut = mysqli_real_escape_string($koneksi, $_POST['no_urut']);

  if ($_POST['simpan']) {
    $ekstensi_diperbolehkan = array('png', 'jpg');
    $gambar1 = $_FILES['gambar1']['name'];
    $x = explode('.', $gambar1);
    $ekstensi = strtolower(end($x));
    $ukuran = $_FILES['gambar1']['size'];
    $file_tmp = $_FILES['gambar1']['tmp_name'];
    if (in_array($ekstensi, $ekstensi_diperbolehkan) === true) {
      if ($ukuran < 5044070) {
        move_uploaded_file($file_tmp, 'foto/' . $gambar1);
        $query = mysqli_query($koneksi, "INSERT INTO data_paslon VALUES(NULL, '$gambar1')");
        $gambar2 = $_FILES['gambar2']['name'];
        $x = explode('.', $gambar2);
        $ekstensi = strtolower(end($x));
        $ukuran = $_FILES['gambar2']['size'];
        $file_tmp = $_FILES['gambar2']['tmp_name'];
        if (in_array($ekstensi, $ekstensi_diperbolehkan) === true) {
          if ($ukuran < 5044070) {
            move_uploaded_file($file_tmp, 'foto/' . $gambar2);
            $query = mysqli_query($koneksi, "INSERT INTO data_paslon VALUES(NULL, '$gambar2')");
          }
        }
      }
    }
  }

  mysqli_query($koneksi, "INSERT INTO data_paslon(id, NISN_ketua, nm_paslon_ketua, gambar1, NISN_wakil, nm_paslon_wakil, gambar2, no_urut)
    VALUES ('','$NISN_ketua','$nm_paslon_ketua','$gambar1','$NISN_wakil','$nm_paslon_wakil','$gambar2','$no_urut')");

  echo "<script>window.alert('Berhasil')
  window.location='input_data_paslon.php'</script>";
}
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>E-Voting</title>
  <link rel="icon" type="image/png" href="../images/faviconMA.ico" />
  <script type="text/javascript" src="assets/chart/chart.js"></script>
  <!-- BOOTSTRAP STYLES-->
  <link href="assets/css/bootstrap.css" rel="stylesheet" />
  <!-- FONTAWESOME STYLES-->
  <link href="assets/css/font-awesome.css" rel="stylesheet" />
  <!-- CUSTOM STYLES-->
  <link href="assets/css/custom.css" rel="stylesheet" />
  <!-- GOOGLE FONTS-->
  <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />
  <style type="text/css">
    img {
      width: 100%;
      height: 500px;
      text-align: center;
    }

    img {
      border-radius: 10px;
    }
  </style>
</head>

<body>

  <div id="wrapper">
    <div class="navbar navbar-inverse navbar-fixed-top" style="background-color: #00296b;">
      <div class="adjust-nav">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".sidebar-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#">
            <!--  <img src="assets/img/logo.png" /> -->
            <h4 style="color: white;">MAK DARUL HIKMAH</h4>
          </a>

        </div>

        <span class="logout-spn">
          <a href="../logout.php" style="color:#fff;"><i class="fa fa-circle-o-notch"> Logout</i></a>
        </span>
      </div>
    </div>
    <!-- /. NAV TOP  -->
    <nav class="navbar-default navbar-side" role="navigation">
      <div class="sidebar-collapse">
        <div class="menu">
          <ul class="nav" id="main-menu">

            <li>
              <a href="index.php"><i class="fa fa-desktop"></i>Home</a>
            </li>
            <?php
            $level = $_SESSION['level'] == 'admin';
            if ($level) {
            ?>

              <li>
                <a href="input_data_paslon.php"><i class="fa fa-user "></i>Upload Data Paslon</a>
              </li>

              <li>
                <a href="upload_dpt.php"><i class="fa fa-file "></i> Upload DPT</a>
              </li>

              <li>
                <a href="buat_akses.php"><i class="fa fa-lightbulb-o "></i>Buat Akses </a>
              </li>

              <li>
                <a href="daftar_akses.php"><i class="fa fa-lightbulb-o "></i>Daftar Akses </a>
              </li>

              <li>
                <a href="hasil_suara.php"><i class=""></i>Quick Count </a>
              </li>

            <?php } ?>
            <li>
              <a href="../logout.php"><i class="fa fa-circle-o-notch "></i>Logout</a>
            </li>

          </ul>
        </div>
      </div>

    </nav>
    <!-- /. NAV SIDE  -->


    <div id="page-wrapper">
      <div id="page-inner">
        <div class="row">
          <div class="col-lg-12">
            <h2><i class="fa fa-chart"> Quick Count</i></h2>
          </div>
        </div>
        <!-- /. ROW  -->

        <div style="width: 800px;margin: 0px auto;">
          <canvas id="myChart"></canvas>

          <script>
            var ctx = document.getElementById("myChart").getContext('2d');
            var myChart = new Chart(ctx, {
              type: 'bar',
              data: {
                labels: ["Sri&Tia", "Hodijah&Darul", "Lia&Amir"],
                datasets: [{
                  label: 'Jumlah Suara',
                  data: [
                    <?php
                    $paslon1 = mysqli_query($koneksi, "select * from tbl_paslon where nomor_paslon='1'");
                    echo mysqli_num_rows($paslon1);
                    ?>,
                    <?php
                    $paslon2 = mysqli_query($koneksi, "select * from tbl_paslon where nomor_paslon='2'");
                    echo mysqli_num_rows($paslon2);
                    ?>,
                    <?php
                    $paslon3 = mysqli_query($koneksi, "select * from tbl_paslon where nomor_paslon='3'");
                    echo mysqli_num_rows($paslon3);
                    ?>,
                  ],
                  backgroundColor: [
                    'rgba(255, 99, 132, .7)',
                    'rgba(54, 162, 235, .7)',
                    'rgba(255, 206, 86, .7)',
                  ],
                  borderColor: [
                    'rgba(255,99,132,1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                  ],
                  borderWidth: 1
                }]
              },
              options: {
                scales: {
                  yAxes: [{
                    ticks: {
                      beginAtZero: true
                    }
                  }]
                }
              }
            });
          </script>
        </div>
      </div>
      <!-- /. ROW  -->
    </div>
    <!-- /. PAGE INNER  -->
  </div>
  <!-- /. PAGE WRAPPER  -->
  </div>


  <div class="footer" style="background-color: #00296b;">
    <div class="row">
      <div class="col-lg-12">
        &copy; Copyright rWar TECH <?php echo date('Y') ?> <a href="https://www.instagram.com/rianmunawar0513/" style="color:#fff;" target="_blank"></a>
      </div>
    </div>
  </div>


  <!-- /. WRAPPER  -->
  <!-- SCRIPTS -AT THE BOTOM TO REDUCE THE LOAD TIME-->
  <!-- JQUERY SCRIPTS -->
  <script src="assets/js/jquery-1.10.2.js"></script>
  <!-- BOOTSTRAP SCRIPTS -->
  <script src="assets/js/bootstrap.min.js"></script>
  <!-- CUSTOM SCRIPTS -->
  <script src="assets/js/custom.js"></script>




</body>

</html>