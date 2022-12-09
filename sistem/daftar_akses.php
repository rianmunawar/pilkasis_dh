<?php
session_start();
if (!isset($_SESSION["login"])) {
  header("location:../index.php");
  exit;
}
include '../koneksi.php';
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>PILKASIS</title>
  <link rel="icon" type="image/png" href="../images/faviconMA.ico" />
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
            <h2><i class="fa fa-user"> Daftar Akses</i></h2>
          </div>
        </div>
        <div class="row">
          <div class="col-lg-8">
            <div class="row">
              <div class="col-lg-12">
                <div class="table-responsive">
                  <table class="table table-striped table-bordered table-hover">
                    <tr>
                      <th>No Peserta</th>
                      <th>Nama</th>
                      <th>Kode Akses</th>
                    </tr>
                    <?php
                    $query = "SELECT * FROM tbl_akses 
                              INNER JOIN tbl_dpt 
                              ON tbl_akses.NISN = tbl_dpt.NISN";
                    $daftar_akses = mysqli_query($koneksi, $query);
                    while ($d = mysqli_fetch_array($daftar_akses)) {
                    ?>
                      <td><?php echo $d['NISN']; ?></td>
                      <td><?php echo $d['nama_siswa']; ?></td>
                      <td><?php echo $d['kode_akses']; ?></td>
                      </tr>
                    <?php } ?>
                  </table>
                </div>
              </div>
            </div>
          </div>
          <div class="col-lg-4">
            <a href="cetak.php" target="_blank" class="btn btn-primary">Cetak Data</a>
            <br>
            <br>
            <a href="cetak_kartu.php" target="_blank" class="btn btn-warning">Cetak Kartu</a>
          </div>
        </div>



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