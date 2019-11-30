<?php 
	$data = array("Yesus Mengubah Air Menjadi Anggur", "Yesus Menyembuhkan Orang Lumpuh di Kolam Betesda", "Yesus Memberi Makan 5000 Orang", "Yesus Membangkitkan Lazarus", "Yesus Menghentikan Angin Topan", "Yesus Menyembukan Orang Kerasukan Setan", "Yesus Menyembuhkan Perempuan Yang 12 Tahun Pendarahan", "Yesus Berjalan Diatas Air", "Yohanes di asingkan ke Pulau Patmos", "Petrus Menyangkal Yesus", "Yudas menghianati Yesus", "Hawa Memakan Buah Pengetahuan Baik dan Jahat", "Yunus di perut ikan", "Yesus Disalibkan" ); // Nama Nama Benda Di Alkitab
		
shuffle($data);
$hasil = array_shift($data);
sleep(1);
flush();
echo "Kalimat yang harus diperagakkan 1 > $hasil\n";
shuffle($data);
$hasil = array_shift($data);
sleep(1);
flush();
echo "Kalimat yang harus diperagakkan 2 > $hasil\n";
?>
