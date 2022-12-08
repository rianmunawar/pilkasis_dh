<?php

//Mengaktifkan output buffering
ob_start();

include "../koneksi.php";

$data = mysqli_query($koneksi, "SELECT * FROM tbl_akses");

?>

<!DOCTYPE html>
<html>

<head>
 <title>Cetak</title>
 <style type="text/css">
  td {
   padding: 3px 3px;
  }
 </style>
</head>

<body>
 <h3 align="center">Daftar Akses</h3>
 <table style="border-collapse:collapse;border-spacing:0;" align="center" border="1">
  <thead>
   <tr>
    <th>No Peserta</th>
    <th>Kode Akses</th>
   </tr>
  </thead>
  <tbody>
   <?php
   $daftar_akses = mysqli_query($koneksi, "SELECT * FROM tbl_akses");
   while ($d = mysqli_fetch_array($daftar_akses)) {
   ?>
    <tr>
     <td><?php echo $d['NISN']; ?></td>
     <td><?php echo $d['kode_akses']; ?></td>
    </tr>
   <?php } ?>
  </tbody>
 </table>
</body>

</html>

<?php

//Meload library mPDF
require '../vendor/autoload.php';

//Membuat inisialisasi objek mPDF
$mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' => 'A4', 'margin_top' => 25, 'margin_bottom' => 25, 'margin_left' => 25, 'margin_right' => 25]);

//Memasukkan output yang diambil dari output buffering ke variabel html
$html = ob_get_contents();

//Menghapus isi output buffering
ob_end_clean();

$mpdf->WriteHTML(utf8_encode($html));

//Membuat output file
$content = $mpdf->Output("daftar_akses.pdf", "D");

?>