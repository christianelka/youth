<?php
// Array Nama-nama Benda di Alkitab
$data = array(
    "Perisai", "Kasut", "Roti Mana", "Anggur", "Ikan", 
    "Lalat", "Tiang Awan", "Tiang Api", "Bahtera", 
    "Emas", "Mur", "Kemenyan", "Tongkat", "2 Loh Batu", 
    "Buah Pengetahuan Baik dan Jahat", "Penjara", 
    "Pedang", "Perut Ikan"
);

// Fungsi untuk membersihkan layar
function clear_screen() {
    if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
        system('cls'); // Windows
    } else {
        system('clear'); // Linux/Unix/MacOS
    }
}

// Mulai permainan
while (true) {
    // Cek apakah masih ada kata di array
    if (count($data) == 0) {
        echo "Permainan selesai! Semua kata telah digunakan.\n";
        break;
    }
    
    // Bersihkan layar dan acak data
    clear_screen();
    shuffle($data);
    
    // Ambil kata pertama dari array
    $hasil = array_shift($data);

    // Tampilkan hasil
    echo "Kata yang keluar > $hasil\n";
    
    // Tunggu 1 detik sebelum melanjutkan
    sleep(1);
    
    // Tanyakan kepada pengguna apakah ingin lanjut
    echo "\nTekan Enter untuk melanjutkan atau ketik 'stop' untuk keluar...";
    $handle = fopen("php://stdin", "r");
    $input = trim(fgets($handle));
    fclose($handle);

    if (strtolower($input) === 'stop') {
        echo "Permainan dihentikan. Sampai jumpa!\n";
        break;
    }
}
?>
