<?php

//Mengaktifkan output buffering
ob_start();

include "../koneksi.php";

?>

<!DOCTYPE html>
<html>

<head>
 <title>Cetak</title>
 <link rel="stylesheet" href="./assets/css/bootstrap.css">
 <link rel="stylesheet" href="./assets/css/cetak_kartu.css">
</head>

<body>
 <div class="content">
  <?php
  $query = "SELECT * FROM tbl_akses 
             INNER JOIN tbl_dpt 
             ON tbl_akses.NISN = tbl_dpt.NISN";
  $daftar_akses = mysqli_query($koneksi, $query);
  while ($d = mysqli_fetch_array($daftar_akses)) {
  ?>
   <table class="kartu_peserta">
    <thead>
     <tr>
      <td>
       <img src="./assets/img/logoKPUOSIS.png" alt="" class="kop-img">
      </td>
      <td colspan="3" align="center">
       <p><strong>KARTU SUARA</strong></p>
       <p><strong>PEMILIHAN KETUA DAN WAKIL KETUA</strong></p>
       <p><strong>OSIS MAK DARUL HIKMAH</strong></p>
       <P><strong>MASA JIHAD 2023/2024</strong></P>
      </td>
     </tr>
    </thead>
    <tbody>
     <tr>
      <td>No. Peserta</td>
      <td>:</td>
      <td><strong><?php echo $d['NISN']; ?></strong></td>
      <td rowspan="3">
       <img src="./assets/img/qrcode.png" alt="qr-code" class="qr-code">
      </td>
     </tr>
     <tr>
      <td>Kode Akses</td>
      <td>:</td>
      <td><strong><?php echo $d['kode_akses']; ?></strong></td>
     </tr>
     <tr>
      <td>Nama</td>
      <td>:</td>
      <td><strong><?php echo $d['nama_siswa']; ?></strong></td>
     </tr>
     <tr>
      <td colspan="4">
       <em>Note : Vote dilakukan di website <a href="https://pilkasis.trimultistudio.com">pilkasis.trimultistudio.com</a> atau scan barcode. Silahkan login menggunakan No. Urut dan Kode akses, perhatikan dengan teliti. Pilihlah sesuai dengan hati nurani masing-masing.</em>
      </td>
     </tr>
    </tbody>
   </table>
  <?php } ?>
 </div>

 <script src="./assets/js/bootstrap.min.js"></script>
 <script src="./assets/js/jquery-1.10.2.js"></script>
</body>

</html>

<?php
//Meload library mPDF
require '../vendor/autoload.php';
//Membuat inisialisasi objek mPDF
$mpdf = new \Mpdf\Mpdf(
 [
  'mode' => 'utf-8',
  'format' => 'A4',
  'margin_top' => 2,
  'margin_bottom' => 2,
  'margin_left' => 2,
  'margin_right' => 2
 ]
);
//Memasukkan output yang diambil dari output buffering ke variabel html
$html = ob_get_contents();
//Menghapus isi output buffering
ob_end_clean();
$mpdf->WriteHTML(utf8_encode($html));
// Membuat output file
$content = $mpdf->Output("kartu-suara.pdf", 'D');
?>