<?php 
	$data = array("Perisai", "Kasut", "Roti Mana", "Anggur", "Ikan", "Lalat", "Tiang Awan", "Tiang Api", "Bahtera", "Emas", "Mur", "Kemenyan", "Tongkat", "2 Loh Batu", "Buah Pengetahuan Baik dan Jahat", "Penjara", "Pedang", "Perut Ikan"); // Nama Nama Benda Di Alkitab
		
shuffle($data);
$hasil = array_shift($data);
sleep(1);
flush();
echo "Kata yang keluar > $hasil\n";
?>
