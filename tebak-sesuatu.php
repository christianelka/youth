<?php

// Permainan Youth - Tebak Alkitab Bersama!
// Jalankan dengan: php games-youth.php di Termux

// Load daftar sesuatu dari JSON
$json_data = file_get_contents('daftar_sesuatu.json');
$daftar_sesuatu = json_decode($json_data, true);
if (json_last_error() !== JSON_ERROR_NONE) {
    die("Error loading JSON: " . json_last_error_msg());
}

// Fungsi bantu
function clearScreen() {
    echo "\033[2J\033[;H"; // Clear screen ANSI
}

function getInput($prompt) {
    echo $prompt;
    return trim(fgets(STDIN));
}

function colorText($text, $color) {
    $colors = [
        'red' => "\033[31m",
        'green' => "\033[32m",
        'yellow' => "\033[33m",
        'blue' => "\033[34m",
        'magenta' => "\033[35m",
        'cyan' => "\033[36m",
        'white' => "\033[37m",
        'reset' => "\033[0m"
    ];
    return $colors[$color] . $text . $colors['reset'];
}

// Fuzzy matching untuk tebakan
function isCorrectGuess($guess, $answer) {
    $percent = 0;
    similar_text(strtolower($guess), strtolower($answer), $percent);
    return $percent >= 80;
}

// Data state
$state = [
    'jumlah_tim' => 0,
    'ketua_terpilih' => [],
    'tim' => [],
    'skor' => [],
    'sesuatu_digunakan' => [],
    'sesuatu_riwayat' => [] // Untuk skor akhir: ['tim' => 'X', 'sesuatu' => 'Nama', 'benar' => true/false]
];

// Fungsi Menu 1: Tentukan Ketua
function menuTentukanKetua(&$state) {
    clearScreen();
    echo colorText("Menu 1: Tentukan Ketua\n", 'green');
    
    $votes = [];
    while (true) {
        $nama = getInput("Masukkan nama calon ketua: ");
        if (!isset($votes[$nama])) {
            $votes[$nama] = 0;
        }
        $votes[$nama]++;
        
        $opsi = getInput("1. Lanjutkan masukkan, 2. Selesai memasukkan: ");
        if ($opsi == 2) break;
        
        // Clear screen setelah input untuk menjaga privacy voting
        clearScreen();
        echo colorText("Menu 1: Tentukan Ketua\n", 'green');
    }
    
    // Summary votes
    arsort($votes);
    $calon_list = array_keys($votes);
    echo "Summary calon ketua:\n";
    foreach ($calon_list as $i => $nama) {
        echo ($i+1) . ". $nama (" . $votes[$nama] . " vote)\n";
    }
    
    $state['jumlah_tim'] = (int)getInput("Ingin membuat berapa tim? (min 2): ");
    if ($state['jumlah_tim'] < 2 || $state['jumlah_tim'] > count($calon_list)) {
        echo colorText("Invalid jumlah tim!\n", 'red');
        return;
    }
    
    $pilihan = explode(',', getInput("Pilih ketua (angka urutan, pisah koma, sebanyak jumlah tim): "));
    if (count($pilihan) != $state['jumlah_tim']) {
        echo colorText("Jumlah pilihan tidak sesuai!\n", 'red');
        return;
    }
    
    $ketua_terpilih = [];
    foreach ($pilihan as $p) {
        $idx = (int)trim($p) - 1;
        if (isset($calon_list[$idx])) {
            $ketua_terpilih[] = $calon_list[$idx];
        }
    }
    
    // Acak assignment ke tim
    shuffle($ketua_terpilih);
    $state['ketua_terpilih'] = $ketua_terpilih;
    for ($i = 0; $i < $state['jumlah_tim']; $i++) {
        $tim_key = 'tim' . ($i+1);
        $state['tim'][$tim_key] = ['ketua' => $ketua_terpilih[$i], 'anggota' => []];
        $state['skor'][$tim_key] = 0;
    }
    
    echo "Permainan dengan " . $state['jumlah_tim'] . " tim. Ketua:\n";
    foreach ($state['tim'] as $tim_key => $data) {
        echo "$tim_key - " . $data['ketua'] . "\n";
    }
    
    getInput("Tekan 0 untuk kembali: ");
}

// Fungsi untuk menyeimbangkan tim
function balanceTeams(&$state, $anggota_fleksibel) {
    $tim_keys = array_keys($state['tim']);
    $jumlah_tim = count($tim_keys);
    
    // Hitung total anggota per tim
    $anggota_per_tim = [];
    $total_anggota = 0;
    foreach ($tim_keys as $tim_key) {
        $anggota_per_tim[$tim_key] = count($state['tim'][$tim_key]['anggota']);
        $total_anggota += $anggota_per_tim[$tim_key];
    }
    
    // Hitung distribusi ideal
    $target_per_tim = floor($total_anggota / $jumlah_tim);
    $sisa = $total_anggota % $jumlah_tim;
    
    // Array target: beberapa tim mendapat +1 anggota
    $target = [];
    foreach ($tim_keys as $i => $tim_key) {
        $target[$tim_key] = $target_per_tim + ($i < $sisa ? 1 : 0);
    }
    
    // Kumpulkan semua anggota fleksibel beserta tim asalnya
    $fleksibel_data = [];
    foreach ($tim_keys as $tim_key) {
        foreach ($state['tim'][$tim_key]['anggota'] as $anggota) {
            if (in_array($anggota, $anggota_fleksibel)) {
                $fleksibel_data[] = ['nama' => $anggota, 'tim_asal' => $tim_key];
            }
        }
    }
    
    // Hapus semua anggota fleksibel dari tim mereka
    foreach ($tim_keys as $tim_key) {
        $state['tim'][$tim_key]['anggota'] = array_filter(
            $state['tim'][$tim_key]['anggota'], 
            function($anggota) use ($anggota_fleksibel) {
                return !in_array($anggota, $anggota_fleksibel);
            }
        );
        $state['tim'][$tim_key]['anggota'] = array_values($state['tim'][$tim_key]['anggota']);
    }
    
    // Redistribute anggota fleksibel secara merata
    $fleksibel_index = 0;
    foreach ($tim_keys as $tim_key) {
        $current_count = count($state['tim'][$tim_key]['anggota']);
        $need = $target[$tim_key] - $current_count;
        
        for ($i = 0; $i < $need && $fleksibel_index < count($fleksibel_data); $i++) {
            $state['tim'][$tim_key]['anggota'][] = $fleksibel_data[$fleksibel_index]['nama'];
            $fleksibel_index++;
        }
    }
    
    echo colorText("Tim telah diseimbangkan otomatis!\n", 'yellow');
}

// Fungsi Menu 2: Tentukan Tim
function menuTentukanTim(&$state) {
    if ($state['jumlah_tim'] == 0) {
        echo colorText("Tentukan ketua dulu!\n", 'red');
        getInput("Tekan enter...");
        return;
    }
    
    clearScreen();
    echo colorText("Menu 2: Tentukan Tim\n", 'green');
    
    $ketua_list = array_values(array_column($state['tim'], 'ketua'));
    $anggota_fleksibel = []; // Track anggota yang melihat label diacak (bisa dipindah)
    
    while (true) {
        $nama = getInput("Masukkan nama Anda (non-ketua): ");
        if (in_array($nama, $ketua_list)) {
            echo colorText("Nama ini adalah ketua!\n", 'red');
            continue;
        }
        
        // Acak presentase: 45% normal, 55% acak & samarkan (setiap iterasi)
        $is_normal = mt_rand(1, 100) <= 45;
        $display_list = $ketua_list;
        $labels = [];
        if (!$is_normal) {
            shuffle($display_list);
            for ($i = 0; $i < count($display_list); $i++) {
                $labels[] = "Kelompok " . chr(65 + $i); // A, B, C...
            }
        } else {
            $labels = $display_list;
        }
        
        echo "Pilih tim:\n";
        foreach ($labels as $i => $label) {
            echo ($i+1) . ". $label\n";
        }
        
        $pilihan = (int)getInput("Pilih (angka): ");
        if ($pilihan < 1 || $pilihan > count($display_list)) {
            echo colorText("Invalid!\n", 'red');
            continue;
        }
        
        // Map kembali ke ketua asli
        $ketua_pilih = $display_list[$pilihan - 1];
        
        // Cari tim yang sesuai dan tambahkan anggota
        $found = false;
        foreach ($state['tim'] as $tim_key => $data) {
            if ($data['ketua'] == $ketua_pilih) {
                $state['tim'][$tim_key]['anggota'][] = $nama;
                // Track anggota yang melihat label diacak (bisa dipindah untuk balancing)
                if (!$is_normal) {
                    $anggota_fleksibel[] = $nama;
                }
                $found = true;
                break;
            }
        }
        
        if (!$found) {
            echo colorText("Error: Tim tidak ditemukan!\n", 'red');
            continue;
        }
        
        $opsi = getInput("1. Lanjutkan masukkan, 2. Selesai mendaftar: ");
        if ($opsi == 2) break;
        
        // Clear screen setelah input untuk menjaga privacy pemilihan tim
        clearScreen();
        echo colorText("Menu 2: Tentukan Tim\n", 'green');
    }
    
    // Penyeimbangan otomatis untuk anggota yang fleksibel
    if (count($anggota_fleksibel) > 0) {
        balanceTeams($state, $anggota_fleksibel);
    }
    
    // Summary tim
    echo "Summary Kelompok:\n";
    foreach ($state['tim'] as $tim_key => $data) {
        echo "$tim_key (Ketua: " . $data['ketua'] . "): Anggota - " . implode(', ', $data['anggota']) . "\n";
    }
    
    getInput("Tekan 0 untuk kembali: ");
}

// Fungsi Menu 3: Mulai Bermain
function menuMulaiBermain(&$state, $daftar_sesuatu) {
    if (empty($state['tim'])) {
        echo colorText("Tentukan tim dulu!\n", 'red');
        getInput("Tekan enter...");
        return;
    }
    
    clearScreen();
    echo colorText("Menu 3: Mulai Bermain\n", 'green');
    
    $tim_keys = array_keys($state['tim']);
    
    // Filter sesuatu yang belum digunakan dan reindex array
    $sesuatu_tersedia = array_values(array_filter($daftar_sesuatu, function($s) use ($state) {
        return !in_array($s['nama'], $state['sesuatu_digunakan']);
    }));
    
    if (count($sesuatu_tersedia) == 0) {
        echo colorText("Semua item sudah digunakan! Permainan selesai.\n", 'red');
        return;
    }
    
    while (true) {
        foreach ($tim_keys as $tim_key) {
            clearScreen();
            echo "Giliran $tim_key (Ketua: " . $state['tim'][$tim_key]['ketua'] . ")\n";
            
            // Pilih penebak
            $all_members = array_merge([$state['tim'][$tim_key]['ketua']], $state['tim'][$tim_key]['anggota']);
            $penebak = getInput("Pilih penebak (nama): ");
            if (!in_array($penebak, $all_members)) {
                echo colorText("Invalid!\n", 'red');
                continue;
            }
            
            // Sistem pilihan acak - memberikan 2 opsi random untuk menghindari bias kategori
            if (count($sesuatu_tersedia) == 1) {
                // Hanya 1 item tersisa
                $kategori_terakhir = (!isset($sesuatu_tersedia[0]['kategori']) || $sesuatu_tersedia[0]['kategori'] === 'tokoh') ? 'Tokoh Penting' : 'Kejadian Besar';
                echo colorText("Hanya 1 item tersisa: $kategori_terakhir (otomatis dipilih)\n", 'cyan');
                $sesuatu = $sesuatu_tersedia[0];
            } else {
                // Ambil 2 item acak untuk menciptakan pilihan yang seimbang
                $random_keys = array_rand($sesuatu_tersedia, min(2, count($sesuatu_tersedia)));
                if (!is_array($random_keys)) {
                    $random_keys = [$random_keys];
                }
                
                $pilihan1 = $sesuatu_tersedia[$random_keys[0]];
                $pilihan2 = isset($random_keys[1]) ? $sesuatu_tersedia[$random_keys[1]] : null;
                
                // Tampilkan pilihan dengan kategori yang sesuai
                echo colorText("Pilihan tersedia (dipilih secara acak dari " . count($sesuatu_tersedia) . " item):\n", 'white');
                $kategori1 = (!isset($pilihan1['kategori']) || $pilihan1['kategori'] === 'tokoh') ? 'Tokoh Penting' : 'Kejadian Besar';
                echo "1. $kategori1\n";
                
                if ($pilihan2) {
                    $kategori2 = (!isset($pilihan2['kategori']) || $pilihan2['kategori'] === 'tokoh') ? 'Tokoh Penting' : 'Kejadian Besar';
                    echo "2. $kategori2\n";
                    
                    // Tampilkan kombinasi yang mungkin
                    if ($kategori1 === $kategori2) {
                        echo colorText("(Kedua pilihan dari kategori yang sama)\n", 'yellow');
                    } else {
                        echo colorText("(Pilihan campuran kategori)\n", 'yellow');
                    }
                    
                    $pilih_opsi = (int)getInput("Pilih opsi (1/2): ");
                    
                    if ($pilih_opsi == 1) {
                        $sesuatu = $pilihan1;
                    } elseif ($pilih_opsi == 2) {
                        $sesuatu = $pilihan2;
                    } else {
                        echo colorText("Pilihan tidak valid! Silakan pilih 1 atau 2.\n", 'red');
                        continue;
                    }
                } else {
                    // Fallback jika hanya ada 1 pilihan (seharusnya tidak terjadi, tapi untuk safety)
                    echo colorText("(Hanya 1 pilihan tersedia)\n", 'yellow');
                    $sesuatu = $pilihan1;
                }
            }
            $state['sesuatu_digunakan'][] = $sesuatu['nama'];
            
            // Tampilkan kategori yang dipilih dan status
            $kategori_display = isset($sesuatu['kategori']) ? 
                ($sesuatu['kategori'] === 'tokoh' ? 'Tokoh Penting' : 'Kejadian Besar') : 
                'Tokoh Penting';
            echo colorText("Kategori: $kategori_display\n", 'cyan');
            echo colorText("Item yang sudah digunakan: " . count($state['sesuatu_digunakan']) . " dari " . count($daftar_sesuatu) . "\n", 'white');
            
            // Gabung dan acak clue
            $clues = array_merge(
                array_map(function($c) { return ['type' => 'teks', 'content' => $c]; }, $sesuatu['clue_teks']),
                array_map(function($c) { return ['type' => 'gerakan', 'content' => $c]; }, $sesuatu['clue_gerakan']),
                [['type' => 'pembantu', 'content' => $sesuatu['clue_pembantu']]]
            );
            shuffle($clues);
            
            $sisa_clue = 10;
            $benar = false;
            foreach ($clues as $clue) {
                clearScreen();
                if ($clue['type'] == 'teks') {
                    echo colorText("Clue Teks (Bacakan): " . $clue['content'] . "\n", 'blue');
                } elseif ($clue['type'] == 'gerakan') {
                    echo colorText("Clue Gerakan (Praktekkan): " . $clue['content'] . "\n", 'yellow');
                } else {
                    echo colorText("Clue Pembantu: " . $clue['content'] . "\n", 'magenta');
                }
                
                $opsi = getInput("1. Lanjut clue, 2. Tebak sekarang: ");
                if ($opsi == 2) {
                    $tebakan = getInput("Tebakan: ");
                    if (isCorrectGuess($tebakan, $sesuatu['nama'])) {
                        $skor = 10 + ($sisa_clue * 2);
                        $state['skor'][$tim_key] += $skor;
                        echo colorText("Benar! Jawaban: " . $sesuatu['nama'] . ". Skor: $skor\n", 'green');
                        $benar = true;
                        // Tampil semua clue
                        echo "Semua Clue:\n";
                        foreach ($clues as $c) {
                            echo "- " . $c['content'] . "\n";
                        }
                        break;
                    } else {
                        echo colorText("Salah! Lanjut clue.\n", 'red');
                    }
                }
                $sisa_clue--;
            }
            
            if (!$benar) {
                echo colorText("Clue habis. Jawaban: " . $sesuatu['nama'] . ". Skor: 0\n", 'red');
            }
            
            $state['sesuatu_riwayat'][] = ['tim' => $tim_key, 'sesuatu' => $sesuatu['nama'], 'benar' => $benar];
            
            $lanjut = getInput("1. Lanjut ke tim selanjutnya, 2. Akhiri permainan: ");
            if ($lanjut == 2) return;
        }
    }
}

// Fungsi Menu 4: Skor Akhir
function menuSkorAkhir($state) {
    clearScreen();
    echo colorText("Menu 4: Skor Akhir\n", 'green');
    
    arsort($state['skor']);
    foreach ($state['skor'] as $tim_key => $skor) {
        echo "$tim_key: $skor poin\n";
    }
    
    $pemenang = key($state['skor']);
    echo "Pemenang: $pemenang!\n";
    
    echo "Riwayat Sesuatu:\n";
    foreach ($state['sesuatu_riwayat'] as $riw) {
        $status = $riw['benar'] ? 'Benar' : 'Salah';
        echo "- $riw[tim]: $riw[sesuatu] ($status)\n";
    }
    
    getInput("Tekan 0 untuk kembali: ");
}

// Fungsi Menu 8: Skor Sementara
function menuSkorSementara($state) {
    clearScreen();
    echo colorText("Menu 8: Skor Sementara\n", 'green');
    
    foreach ($state['skor'] as $tim_key => $skor) {
        echo "$tim_key: $skor poin\n";
    }
    
    getInput("Tekan 0 untuk kembali: ");
}

// Fungsi Menu 9: Status Item
function menuStatusItem($state, $daftar_sesuatu) {
    clearScreen();
    echo colorText("Menu 9: Status Item\n", 'green');
    
    $total_items = count($daftar_sesuatu);
    $used_items = count($state['sesuatu_digunakan']);
    $available_items = $total_items - $used_items;
    
    echo "Total item: $total_items\n";
    echo "Sudah digunakan: $used_items\n";
    echo "Masih tersedia: $available_items\n\n";
    
    // Hitung per kategori
    $tokoh_total = 0;
    $kejadian_total = 0;
    $tokoh_used = 0;
    $kejadian_used = 0;
    
    foreach ($daftar_sesuatu as $item) {
        if (!isset($item['kategori']) || $item['kategori'] === 'tokoh') {
            $tokoh_total++;
            if (in_array($item['nama'], $state['sesuatu_digunakan'])) {
                $tokoh_used++;
            }
        } else {
            $kejadian_total++;
            if (in_array($item['nama'], $state['sesuatu_digunakan'])) {
                $kejadian_used++;
            }
        }
    }
    
    echo colorText("TOKOH PENTING:\n", 'blue');
    echo "Total: $tokoh_total, Digunakan: $tokoh_used, Tersisa: " . ($tokoh_total - $tokoh_used) . "\n\n";
    
    echo colorText("KEJADIAN BESAR:\n", 'yellow');
    echo "Total: $kejadian_total, Digunakan: $kejadian_used, Tersisa: " . ($kejadian_total - $kejadian_used) . "\n\n";
    
    if (!empty($state['sesuatu_digunakan'])) {
        echo colorText("Item yang sudah digunakan:\n", 'red');
        foreach ($state['sesuatu_digunakan'] as $used) {
            echo "- $used\n";
        }
    }
    
    getInput("Tekan 0 untuk kembali: ");
}

// Halaman Utama
while (true) {
    clearScreen();
    echo colorText("Permainan Youth - Tebak Alkitab Bersama!\n", 'green');
    
    if ($state['jumlah_tim'] > 0) {
        echo "Permainan dengan " . $state['jumlah_tim'] . " tim. Ketua: " . implode(', ', $state['ketua_terpilih']) . "\n";
        echo "Tim: ";
        foreach ($state['tim'] as $tim_key => $data) {
            echo "$tim_key (" . $data['ketua'] . "), ";
        }
        echo "\n";
    }
    
    echo "Menu:\n1. Tentukan Ketua\n2. Tentukan Tim\n3. Mulai Bermain\n4. Cek Skor Akhir\n";
    if (!empty($state['tim'])) {
        echo "8. Skor Sementara\n";
    }
    echo "9. Status Item\n";
    echo "0. Keluar\n";
    
    $menu = getInput("Pilih menu: ");
    
    if ($menu == 1) menuTentukanKetua($state);
    elseif ($menu == 2) menuTentukanTim($state);
    elseif ($menu == 3) menuMulaiBermain($state, $daftar_sesuatu);
    elseif ($menu == 4) menuSkorAkhir($state);
    elseif ($menu == 8 && !empty($state['tim'])) menuSkorSementara($state);
    elseif ($menu == 9) menuStatusItem($state, $daftar_sesuatu);
    elseif ($menu == 0) break;
    else echo colorText("Menu invalid!\n", 'red');
}
