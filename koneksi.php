<?php
// Development
$DB_Name = "e-voting";
$DB_User = "root";
$DB_Password = "";
$DB_Host = "localhost";

$koneksi = mysqli_connect($DB_Host, $DB_User, $DB_Password, $DB_Name);

if (mysqli_connect_error()) {
	echo "koneksi database gagal " . mysqli_connect_error();
}
