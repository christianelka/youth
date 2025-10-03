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
        'bright_red' => "\033[91m",
        'bright_green' => "\033[92m",
        'bright_yellow' => "\033[93m",
        'bright_blue' => "\033[94m",
        'bright_magenta' => "\033[95m",
        'bright_cyan' => "\033[96m",
        'bright_white' => "\033[97m",
        'bold' => "\033[1m",
        'underline' => "\033[4m",
        'bg_red' => "\033[41m",
        'bg_green' => "\033[42m",
        'bg_yellow' => "\033[43m",
        'bg_blue' => "\033[44m",
        'bg_magenta' => "\033[45m",
        'bg_cyan' => "\033[46m",
        'reset' => "\033[0m"
    ];
    return $colors[$color] . $text . $colors['reset'];
}

// Fungsi styling khusus
function headerText($text) {
    $border = str_repeat("═", strlen($text) + 4);
    return colorText("╔$border╗\n", 'bright_cyan') .
           colorText("║ ", 'bright_cyan') . colorText($text, 'bold') . colorText(" ║\n", 'bright_cyan') .
           colorText("╚$border╝\n", 'bright_cyan');
}

function successMessage($text) {
    return "✅ " . colorText($text, 'bright_green');
}

function errorMessage($text) {
    return "❌ " . colorText($text, 'bright_red');
}

function warningMessage($text) {
    return "⚠️  " . colorText($text, 'bright_yellow');
}

function infoMessage($text) {
    return "ℹ️  " . colorText($text, 'bright_blue');
}

function menuItem($number, $text, $icon = "📋") {
    return colorText("$number.", 'bright_cyan') . " $icon " . colorText($text, 'white');
}

function scoreDisplay($tim, $skor) {
    return "🏆 " . colorText($tim, 'bright_yellow') . ": " . colorText($skor . " poin", 'bright_green');
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
    echo headerText("👑 PEMILIHAN KETUA TIM");
    echo "\n";
    
    $votes = [];
    while (true) {
        $nama = getInput("👤 " . colorText("Masukkan nama calon ketua: ", 'bright_cyan'));
        if (!isset($votes[$nama])) {
            $votes[$nama] = 0;
        }
        $votes[$nama]++;
        
        echo successMessage("Suara untuk '$nama' berhasil dicatat!") . "\n";
        $opsi = getInput("📝 " . colorText("1. Lanjutkan masukkan, 2. Selesai memasukkan: ", 'bright_yellow'));
        if ($opsi == 2) break;
        
        // Clear screen setelah input untuk menjaga privacy voting
        clearScreen();
        echo headerText("👑 PEMILIHAN KETUA TIM");
        echo "\n";
    }
    
    // Summary votes
    arsort($votes);
    $calon_list = array_keys($votes);
    echo "\n" . colorText("📊 HASIL PEMILIHAN KETUA:", 'bright_magenta') . "\n";
    echo colorText(str_repeat("─", 40), 'cyan') . "\n";
    foreach ($calon_list as $i => $nama) {
        $medal = ($i == 0) ? "🥇" : (($i == 1) ? "🥈" : (($i == 2) ? "🥉" : "🏅"));
        echo "$medal " . colorText(($i+1) . ".", 'bright_cyan') . " " . colorText($nama, 'bright_white') . " (" . colorText($votes[$nama] . " vote", 'bright_green') . ")\n";
    }
    echo colorText(str_repeat("─", 40), 'cyan') . "\n\n";
    
    $state['jumlah_tim'] = (int)getInput("🎯 " . colorText("Ingin membuat berapa tim? (min 2): ", 'bright_cyan'));
    if ($state['jumlah_tim'] < 2 || $state['jumlah_tim'] > count($calon_list)) {
        echo errorMessage("Jumlah tim tidak valid! Harus antara 2 dan " . count($calon_list)) . "\n";
        getInput("⏎ " . colorText("Tekan Enter untuk kembali...", 'white'));
        return;
    }
    
    $pilihan = explode(',', getInput("🎯 " . colorText("Pilih ketua (angka urutan, pisah koma, sebanyak " . $state['jumlah_tim'] . " tim): ", 'bright_cyan')));
    if (count($pilihan) != $state['jumlah_tim']) {
        echo errorMessage("Jumlah pilihan tidak sesuai! Harus memilih " . $state['jumlah_tim'] . " ketua.") . "\n";
        getInput("⏎ " . colorText("Tekan Enter untuk kembali...", 'white'));
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
    
    echo "\n" . successMessage("Tim berhasil dibuat!") . "\n\n";
    echo colorText("🎯 PEMBAGIAN TIM:", 'bright_magenta') . "\n";
    echo colorText(str_repeat("═", 35), 'bright_cyan') . "\n";
    foreach ($state['tim'] as $tim_key => $data) {
        echo "👑 " . colorText($tim_key, 'bright_yellow') . " - " . colorText($data['ketua'], 'bright_white') . "\n";
    }
    echo colorText(str_repeat("═", 35), 'bright_cyan') . "\n";
    
    getInput("\n⏎ " . colorText("Tekan Enter untuk kembali ke menu utama...", 'white'));
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
    
    echo successMessage("Tim telah diseimbangkan otomatis untuk keadilan!") . "\n";
}

// Fungsi Menu 2: Tentukan Tim
function menuTentukanTim(&$state) {
    if ($state['jumlah_tim'] == 0) {
        clearScreen();
        echo errorMessage("Tentukan ketua tim terlebih dahulu!") . "\n";
        getInput("⏎ " . colorText("Tekan Enter untuk kembali...", 'white'));
        return;
    }
    
    clearScreen();
    echo headerText("👥 PENDAFTARAN ANGGOTA TIM");
    echo "\n";
    
    $ketua_list = array_values(array_column($state['tim'], 'ketua'));
    $anggota_fleksibel = []; // Track anggota yang melihat label diacak (bisa dipindah)
    
    while (true) {
        $nama = getInput("👤 " . colorText("Masukkan nama Anda (bukan ketua): ", 'bright_cyan'));
        if (in_array($nama, $ketua_list)) {
            echo errorMessage("Nama '$nama' sudah terdaftar sebagai ketua tim!") . "\n";
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
            echo warningMessage("Label tim diacak untuk keadilan pemilihan") . "\n";
        } else {
            $labels = $display_list;
            echo infoMessage("Menampilkan nama ketua tim") . "\n";
        }
        
        echo "\n" . colorText("🎯 PILIH TIM ANDA:", 'bright_magenta') . "\n";
        echo colorText(str_repeat("─", 25), 'cyan') . "\n";
        foreach ($labels as $i => $label) {
            echo colorText(($i+1) . ".", 'bright_cyan') . " 🏷️  " . colorText($label, 'bright_white') . "\n";
        }
        echo colorText(str_repeat("─", 25), 'cyan') . "\n";
        
        $pilihan = (int)getInput("🎯 " . colorText("Pilih nomor tim: ", 'bright_cyan'));
        if ($pilihan < 1 || $pilihan > count($display_list)) {
            echo errorMessage("Pilihan tidak valid! Pilih angka 1-" . count($display_list)) . "\n";
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
                echo successMessage("'$nama' berhasil bergabung dengan tim!") . "\n";
                $found = true;
                break;
            }
        }
        
        if (!$found) {
            echo errorMessage("Tim tidak ditemukan! Silakan coba lagi.") . "\n";
            continue;
        }
        
        $opsi = getInput("📝 " . colorText("1. Lanjutkan masukkan, 2. Selesai mendaftar: ", 'bright_yellow'));
        if ($opsi == 2) break;
        
        // Clear screen setelah input untuk menjaga privacy pemilihan tim
        clearScreen();
        echo headerText("👥 PENDAFTARAN ANGGOTA TIM");
        echo "\n";
    }
    
    // Penyeimbangan otomatis untuk anggota yang fleksibel
    if (count($anggota_fleksibel) > 0) {
        echo "\n" . infoMessage("Melakukan penyeimbangan tim...") . "\n";
        balanceTeams($state, $anggota_fleksibel);
    }
    
    // Summary tim
    echo "\n" . colorText("📋 SUSUNAN FINAL TIM:", 'bright_magenta') . "\n";
    echo colorText(str_repeat("═", 50), 'bright_cyan') . "\n";
    foreach ($state['tim'] as $tim_key => $data) {
        echo "🏆 " . colorText($tim_key, 'bright_yellow') . " (Ketua: " . colorText($data['ketua'], 'bright_white') . ")\n";
        if (!empty($data['anggota'])) {
            echo "   👥 Anggota: " . colorText(implode(', ', $data['anggota']), 'white') . "\n";
        } else {
            echo "   👥 Anggota: " . colorText("Belum ada", 'yellow') . "\n";
        }
        echo "\n";
    }
    echo colorText(str_repeat("═", 50), 'bright_cyan') . "\n";
    
    getInput("⏎ " . colorText("Tekan Enter untuk kembali ke menu utama...", 'white'));
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
            
            // Pilih penebak secara acak
            $all_members = array_merge([$state['tim'][$tim_key]['ketua']], $state['tim'][$tim_key]['anggota']);

            // Filter anggota kosong jika ada, untuk menghindari error
            $valid_members = array_filter($all_members);
            if (empty($valid_members)) {
                echo errorMessage("Tim ini tidak memiliki anggota untuk bisa menebak!");
                getInput("\n" . colorText("Tekan Enter untuk melanjutkan...", 'white'));
                continue;
            }

            $penebak_key = array_rand($valid_members);
            $penebak = $valid_members[$penebak_key];

            echo "\n" . infoMessage("Penebak yang terpilih secara acak adalah: " . colorText($penebak, 'bright_white')) . "\n";
            getInput(colorText("Tekan Enter untuk memulai...", 'white'));
            
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
            
            $rebut_berhasil = false; // Flag to track if a steal was successful
            if (!$benar) {
                // Log kegagalan tim utama
                $state['sesuatu_riwayat'][] = ['tim' => $tim_key, 'sesuatu' => $sesuatu['nama'], 'benar' => false];

                // KESEMPATAN REBUT
                echo "\n" . headerText("⚡️ KESEMPATAN REBUT ⚡️");
                echo warningMessage("Tim $tim_key gagal menebak. Kesempatan terbuka untuk tim lain!") . "\n";
                echo infoMessage("Jawaban yang benar akan mendapatkan 5 poin.") . "\n\n";

                $other_teams = array_filter($tim_keys, function($t) use ($tim_key) {
                    return $t !== $tim_key;
                });

                if (!empty($other_teams)) {
                    shuffle($other_teams); // Acak urutan tim yang merebut

                    foreach ($other_teams as $rebut_tim_key) {
                        echo "Giliran merebut untuk " . colorText($rebut_tim_key, 'bright_yellow') . "!\n";
                        $tebakan_rebut = getInput(colorText("Tebakan Anda: ", 'bright_cyan'));

                        if (isCorrectGuess($tebakan_rebut, $sesuatu['nama'])) {
                            $skor_rebut = 5;
                            $state['skor'][$rebut_tim_key] += $skor_rebut;

                            echo successMessage("BENAR! Tim $rebut_tim_key berhasil merebut $skor_rebut poin!");
                            echo "\n" . infoMessage("Jawaban yang benar adalah: " . $sesuatu['nama']) . "\n";

                            // Catat di riwayat sebagai 'rebut'
                            $state['sesuatu_riwayat'][] = [
                                'tim' => $rebut_tim_key,
                                'sesuatu' => $sesuatu['nama'],
                                'benar' => true,
                                'rebut' => true // Flag baru
                            ];

                            $rebut_berhasil = true;
                            break; // Hentikan kesempatan rebut jika sudah ada yang benar
                        } else {
                            echo errorMessage("Salah! Kesempatan untuk tim selanjutnya.") . "\n\n";
                        }
                    }
                }

                if (!$rebut_berhasil) {
                    echo "\n" . errorMessage("Tidak ada tim yang berhasil menebak.");
                    echo "\n" . infoMessage("Jawaban yang benar adalah: " . $sesuatu['nama']) . "\n";
                }

            } else {
                // Jika tim utama berhasil menebak, catat kesuksesan mereka
                $state['sesuatu_riwayat'][] = ['tim' => $tim_key, 'sesuatu' => $sesuatu['nama'], 'benar' => true];
            }
            
            $lanjut = getInput("\n1. Lanjut ke tim selanjutnya, 2. Akhiri permainan: ");
            if ($lanjut == 2) return;
        }
    }
}

// Fungsi Menu 4: Skor Akhir
function menuSkorAkhir($state) {
    clearScreen();
    echo headerText("🏆 HASIL AKHIR PERMAINAN");
    echo "\n";
    
    // Sort skor dari tertinggi ke terendah
    $sorted_skor = $state['skor'];
    arsort($sorted_skor);
    
    echo colorText("🎉 PAPAN SKOR FINAL:", 'bright_magenta') . "\n";
    echo colorText(str_repeat("═", 50), 'bright_cyan') . "\n";
    
    $position = 1;
    foreach ($sorted_skor as $tim_key => $skor) {
        $medal = ($position == 1) ? "🥇" : (($position == 2) ? "🥈" : (($position == 3) ? "🥉" : "🏅"));
        echo "$medal " . colorText("#$position", 'bright_cyan') . " " . scoreDisplay($tim_key, $skor) . "\n";
        $position++;
    }
    
    echo colorText(str_repeat("═", 50), 'bright_cyan') . "\n";
    
    $pemenang = key($sorted_skor);
    $skor_tertinggi = current($sorted_skor);
    echo "\n" . colorText("🎊 SELAMAT! 🎊", 'bright_yellow') . "\n";
    echo "👑 " . colorText("PEMENANG: $pemenang", 'bold') . " dengan " . colorText("$skor_tertinggi poin!", 'bright_green') . "\n\n";
    
    if (!empty($state['sesuatu_riwayat'])) {
        echo colorText("📜 RIWAYAT PERMAINAN:", 'bright_magenta') . "\n";
        echo colorText(str_repeat("─", 45), 'cyan') . "\n";
        foreach ($state['sesuatu_riwayat'] as $riw) {
            $status_icon = $riw['benar'] ? "✅" : "❌";
            $status_text = $riw['benar'] ? colorText("BENAR", 'bright_green') : colorText("SALAH", 'bright_red');
            $rebut_text = isset($riw['rebut']) && $riw['rebut'] ? colorText(" (Rebut)", 'bright_yellow') : "";
            echo "$status_icon " . colorText($riw['tim'], 'bright_cyan') . ": " . colorText($riw['sesuatu'], 'white') . " (" . $status_text . "$rebut_text)\n";
        }
        echo colorText(str_repeat("─", 45), 'cyan') . "\n";
    }
    
    getInput("\n⏎ " . colorText("Tekan Enter untuk kembali ke menu utama...", 'white'));
}

// Fungsi Menu 8: Skor Sementara
function menuSkorSementara($state) {
    clearScreen();
    echo headerText("📊 SKOR SEMENTARA");
    echo "\n";
    
    // Sort skor dari tertinggi ke terendah
    $sorted_skor = $state['skor'];
    arsort($sorted_skor);
    
    echo colorText("🏆 PAPAN SKOR SEMENTARA:", 'bright_magenta') . "\n";
    echo colorText(str_repeat("═", 40), 'bright_cyan') . "\n";
    
    $position = 1;
    foreach ($sorted_skor as $tim_key => $skor) {
        $medal = ($position == 1) ? "🥇" : (($position == 2) ? "🥈" : (($position == 3) ? "🥉" : "🏅"));
        echo "$medal " . colorText("#$position", 'bright_cyan') . " " . scoreDisplay($tim_key, $skor) . "\n";
        $position++;
    }
    
    echo colorText(str_repeat("═", 40), 'bright_cyan') . "\n";
    
    getInput("⏎ " . colorText("Tekan Enter untuk kembali ke menu utama...", 'white'));
}

// Fungsi Menu 9: Status Item
function menuStatusItem($state, $daftar_sesuatu) {
    clearScreen();
    echo headerText("📝 STATUS ITEM PERMAINAN");
    echo "\n";
    
    $total_items = count($daftar_sesuatu);
    $used_items = count($state['sesuatu_digunakan']);
    $available_items = $total_items - $used_items;
    
    echo colorText("📊 STATISTIK UMUM:", 'bright_magenta') . "\n";
    echo colorText(str_repeat("═", 40), 'bright_cyan') . "\n";
    echo "📦 " . colorText("Total item:", 'bright_yellow') . " " . colorText($total_items, 'bright_white') . "\n";
    echo "✅ " . colorText("Sudah digunakan:", 'bright_yellow') . " " . colorText($used_items, 'bright_green') . "\n";
    echo "⭐ " . colorText("Masih tersedia:", 'bright_yellow') . " " . colorText($available_items, 'bright_cyan') . "\n";
    echo colorText(str_repeat("═", 40), 'bright_cyan') . "\n\n";
    
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
    
    echo colorText("👤 KATEGORI TOKOH PENTING:", 'bright_blue') . "\n";
    echo colorText(str_repeat("─", 35), 'cyan') . "\n";
    echo "📦 Total: " . colorText($tokoh_total, 'bright_white') . " | ✅ Digunakan: " . colorText($tokoh_used, 'bright_green') . " | ⭐ Tersisa: " . colorText(($tokoh_total - $tokoh_used), 'bright_cyan') . "\n\n";
    
    echo colorText("📅 KATEGORI KEJADIAN BESAR:", 'bright_yellow') . "\n";
    echo colorText(str_repeat("─", 35), 'cyan') . "\n";
    echo "📦 Total: " . colorText($kejadian_total, 'bright_white') . " | ✅ Digunakan: " . colorText($kejadian_used, 'bright_green') . " | ⭐ Tersisa: " . colorText(($kejadian_total - $kejadian_used), 'bright_cyan') . "\n\n";
    
    if (!empty($state['sesuatu_digunakan'])) {
        echo colorText("🗂️ ITEM YANG SUDAH DIGUNAKAN:", 'bright_red') . "\n";
        echo colorText(str_repeat("─", 40), 'cyan') . "\n";
        foreach ($state['sesuatu_digunakan'] as $i => $used) {
            echo colorText(($i+1) . ".", 'bright_cyan') . " " . colorText($used, 'white') . "\n";
        }
        echo colorText(str_repeat("─", 40), 'cyan') . "\n";
    } else {
        echo infoMessage("Belum ada item yang digunakan.") . "\n";
    }
    
    getInput("\n⏎ " . colorText("Tekan Enter untuk kembali ke menu utama...", 'white'));
}

// Halaman Utama
while (true) {
    clearScreen();
    echo headerText("🎮 PERMAINAN YOUTH - TEBAK ALKITAB BERSAMA! 🎮");
    echo "\n";
    
    if ($state['jumlah_tim'] > 0) {
        echo infoMessage("Permainan dengan " . $state['jumlah_tim'] . " tim aktif") . "\n";
        echo "👑 " . colorText("Ketua Tim:", 'bright_yellow') . " " . colorText(implode(', ', $state['ketua_terpilih']), 'bright_white') . "\n";
        echo "👥 " . colorText("Tim:", 'bright_yellow') . " ";
        foreach ($state['tim'] as $tim_key => $data) {
            echo colorText("$tim_key", 'bright_cyan') . colorText("(" . $data['ketua'] . ")", 'white') . " ";
        }
        echo "\n\n";
    }
    
    echo colorText("📋 MENU UTAMA:\n", 'bright_magenta');
    echo menuItem("1", "Tentukan Ketua", "👑") . "\n";
    echo menuItem("2", "Tentukan Tim", "👥") . "\n"; 
    echo menuItem("3", "Mulai Bermain", "🎯") . "\n";
    echo menuItem("4", "Cek Skor Akhir", "🏆") . "\n";
    if (!empty($state['tim'])) {
        echo menuItem("8", "Skor Sementara", "📊") . "\n";
    }
    echo menuItem("9", "Status Item", "📝") . "\n";
    echo menuItem("0", "Keluar", "🚪") . "\n\n";
    
    $menu = getInput("🎯 " . colorText("Pilih menu: ", 'bright_cyan'));
    
    if ($menu == 1) menuTentukanKetua($state);
    elseif ($menu == 2) menuTentukanTim($state);
    elseif ($menu == 3) menuMulaiBermain($state, $daftar_sesuatu);
    elseif ($menu == 4) menuSkorAkhir($state);
    elseif ($menu == 8 && !empty($state['tim'])) menuSkorSementara($state);
    elseif ($menu == 9) menuStatusItem($state, $daftar_sesuatu);
    elseif ($menu == 0) break;
    else echo errorMessage("Menu tidak valid! Silakan pilih angka yang tersedia.") . "\n";
}
