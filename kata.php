<?php
session_start();

// Warna ANSI untuk styling terminal
$reset = "\033[0m";
$green = "\033[32m";
$yellow = "\033[33m";
$red = "\033[31m";
$cyan = "\033[36m";
$bold = "\033[1m";

// Fungsi untuk membersihkan layar
function clear_screen() {
    if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
        system('cls'); // Windows
    } else {
        system('clear'); // Linux/Unix/MacOS
    }
}

// Inisialisasi data jika belum ada di session
if (!isset($_SESSION['data'])) {
    $_SESSION['data'] = array(
    // Cerita Yesus
    "Yesus Menyembuhkan Orang Lumpuh di Kolam Betesda",
    "Yesus Memberi Makan 5000 Orang",
    "Yesus Membangkitkan Lazarus",
    "Yesus Menghentikan Angin Topan",
    "Yesus Menyembuhkan Orang Kerasukan Setan",
    "Yesus Menyembuhkan Perempuan Yang 12 Tahun Pendarahan",
    "Yesus Berjalan Diatas Air",
    "Yesus Mengubah Air Menjadi Anggur di Pesta Pernikahan",
    "Yesus Menyembuhkan 10 Orang Kusta dan Hanya Satu yang Kembali",
    "Yesus Mengutuk Pohon Ara",
    "Yesus Memberikan Perumpamaan tentang Penabur",
    "Yesus Memberikan Perumpamaan tentang Uang Persepuluhan",
    
    // Peristiwa Dramatis
    "Lot Melarikan Diri dari Sodom dan Gomora",
    "Istri Lot Menjadi Tiang Garam",
    "Kain Membunuh Habel",
    "Nuh Membangun Bahtera",
    "Air Bah Melanda Seluruh Bumi",
    "Hawa Memakan Buah Pengetahuan Baik dan Jahat",
    "Yunus di Perut Ikan Selama Tiga Hari",
    "Menara Babel Dibangun dan Bahasa Manusia Dicerai-beraikan",
    "Saul Menyembunyikan Dirinya Saat Akan Diurapi sebagai Raja",
    
    // Mukjizat Nabi
    "Musa Membelah Laut Merah",
    "Musa Menerima Sepuluh Perintah Allah di Gunung Sinai",
    "Musa Memukul Batu untuk Mengeluarkan Air",
    "Runtuhnya Tembok Yerikho",
    "Elia Memanggil Api dari Langit di Gunung Karmel",
    "Elia Diangkat ke Surga dengan Kereta Api",
    "Elisa Membuat Kapak Terapung",
    "Elisa Menghidupkan Anak Perempuan Janda Sunem",
    "Daniel di Liang Singa",
    "Daniel Menafsirkan Mimpi Raja Nebukadnezar",
    
    // Kisah Para Tokoh
    "Abraham Mengorbankan Ishak",
    "Yakub Bergulat dengan Malaikat di Peniel",
    "Yusuf Dijual oleh Saudara-saudaranya ke Mesir",
    "Yusuf Menafsirkan Mimpi Firaun",
    "Daud Mengalahkan Goliat dengan Ketapel",
    "Salomo Membangun Bait Allah",
    "Ester Menyelamatkan Bangsanya dari Pembantaian",
    "Rut Memungut Jelai di Ladang Boas",
    "Debora, Hakim Perempuan yang Memimpin Israel",
    "Samson Mengalahkan Orang Filistin dengan Rahang Keledai",
    "Raja Saul Mengunjungi Perempuan Pemanggil Arwah",
    
    // Kisah Kelahiran dan Kehidupan
    "Maria Melahirkan Yesus di Betlehem",
    "Para Gembala Menyembah Yesus di Palungan",
    "Kelahiran Yohanes Pembaptis",
    "Yesus Dibaptis di Sungai Yordan oleh Yohanes Pembaptis",
    "Yesus Dikhianati dengan Ciuman oleh Yudas",
    "Perjamuan Malam Terakhir",
    "Yesus Disalibkan dan Tirai Bait Allah Terbelah Dua",
    "Yesus Bangkit dari Kematian",
    "Yesus Naik ke Surga",
    
    // Kisah Para Rasul
    "Petrus Menyangkal Yesus Tiga Kali Sebelum Ayam Berkokok",
    "Petrus Ditangkap dan Dibebaskan oleh Malaikat",
    "Paulus dan Silas Bernyanyi di Penjara",
    "Perjalanan Paulus ke Damaskus",
    "Stefanus Dirajam Batu sebagai Martir Pertama",
    "Ananias dan Safira Berbohong tentang Harta Mereka dan Meninggal",
    "Roh Kudus Turun di Hari Pentakosta",
    "Filipus Membaptis Sida-sida Etiopia di Padang Gurun",
    
    // Cerita Lainnya
    "Sapi Emas Dibuat oleh Bangsa Israel di Kaki Gunung Sinai",
    "Burung Gagak Membawa Makanan untuk Elia di Sungai Kerit",
    "Raja Hizkia Berdoa dan Umurnya Ditambah 15 Tahun",
    "Mahluk Misterius Menulis di Dinding di Perjamuan Raja Belsyazar",
    "Yonatan dan Pembawa Senjatanya Mengalahkan Pasukan Filistin",
    "Gideon Memilih 300 Pasukan untuk Melawan Orang Midian",
    "Simson Kehilangan Kekuatan Setelah Rambutnya Dipotong Delila",
    "Tiga Teman Daniel Selamat dari Perapian yang Menyala-nyala",
    "Keledai Balaam Berbicara di Jalan",
    "Malaikat Membunuh 185.000 Tentara Asyur Semalam",
    "Raja Nebukadnezar Dihukum Menjadi seperti Hewan selama Tujuh Tahun",
    "Tabut Perjanjian Dibawa Keluar dan Menjatuhkan Dagon",
    "Orang-orang Israel Menangkap Kota Betlehem dengan Trik Mata-mata"
        // Tambahkan data lain sesuai kebutuhan
    );
    $_SESSION['digunakan'] = array();
}

// Periksa apakah masih ada data untuk permainan
while (true) {
    clear_screen(); // Bersihkan layar di setiap iterasi permainan
    $data = $_SESSION['data'];

    if (count($data) < 2) {
        echo "{$red}Permainan selesai! Semua kalimat telah digunakan.{$reset}\n";
        session_destroy(); // Hapus session untuk memulai ulang
        break;
    }

    // Pilih dua kalimat acak untuk ditampilkan
    shuffle($data);
    $pilihan1 = array_shift($data);
    $pilihan2 = array_shift($data);

    // Simpan data yang tersisa kembali ke session
    $_SESSION['data'] = $data;

    // Tampilkan dua pilihan kepada peserta
    echo "\n{$cyan}Peserta, pilih salah satu dari dua kalimat berikut:{$reset}\n";
    echo "1. {$yellow}$pilihan1{$reset}\n";
    echo "2. {$yellow}$pilihan2{$reset}\n";

    // Kelompok 1 memilih
    echo "{$green}Kelompok 1, masukkan pilihan Anda (1 atau 2): {$reset}";
    $handle = fopen("php://stdin", "r");
    $input1 = trim(fgets($handle));

    if ($input1 == "1") {
        $pilihanKelompok1 = $pilihan1;
    } elseif ($input1 == "2") {
        $pilihanKelompok1 = $pilihan2;
    } else {
        echo "{$red}Input tidak valid untuk Kelompok 1. Pilih 1 atau 2!{$reset}\n";
        continue; // Kembali ke awal loop
    }

    // Kelompok 2 memilih
    echo "{$green}Kelompok 2, masukkan pilihan Anda (1 atau 2): {$reset}";
    $input2 = trim(fgets($handle));
    fclose($handle);

    if ($input2 == "1") {
        $pilihanKelompok2 = $pilihan1;
    } elseif ($input2 == "2") {
        $pilihanKelompok2 = $pilihan2;
    } else {
        echo "{$red}Input tidak valid untuk Kelompok 2. Pilih 1 atau 2!{$reset}\n";
        continue; // Kembali ke awal loop
    }

    // Tambahkan pilihan kelompok ke daftar "digunakan"
    $_SESSION['digunakan'][] = $pilihanKelompok1;
    $_SESSION['digunakan'][] = $pilihanKelompok2;

    // Tampilkan hasil pilihan
    clear_screen(); // Bersihkan layar sebelum menampilkan hasil
    echo "{$bold}Hasil Pilihan Peserta:{$reset}\n";
    echo "Kelompok 1 memilih: {$cyan}$pilihanKelompok1{$reset}\n";
    echo "Kelompok 2 memilih: {$cyan}$pilihanKelompok2{$reset}\n";

    // Tampilkan informasi kepada pembawa permainan
    echo "\n{$bold}Pembawa permainan, berikut informasi untuk Anda:{$reset}\n";
    echo "{$bold}Kata yang sudah digunakan:{$reset}\n";
    foreach ($_SESSION['digunakan'] as $index => $used) {
        echo ($index + 1) . ". {$yellow}$used{$reset}\n";
    }

    // Tunggu pembawa permainan untuk melanjutkan
    echo "\n{$cyan}Tekan Enter untuk melanjutkan permainan...{$reset}";
    fgets(STDIN); // Tunggu input untuk melanjutkan
}
