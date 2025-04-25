<?php
// Color constants
$reset = "\033[0m";
$green = "\033[32m";
$yellow = "\033[33m";
$blue = "\033[34m";
$bold_yellow = "\033[1;33m"; // Bold yellow untuk gold
$red = "\033[31m";
$cyan = "\033[36m";
$bold = "\033[1m";

// Database of characters and clues
$database = [
    'Adam' => [
        'general' => [
            "Tokoh ini hidup pada masa Perjanjian Lama.",
            "Dia adalah manusia pertama yang diciptakan oleh Tuhan.",
            "Dia tinggal di sebuah taman yang indah.",
            "Dia memiliki seorang istri.",
            "Dia melakukan kesalahan yang mempengaruhi seluruh umat manusia."
        ],
        'slightly_general' => [
            "Dia diciptakan dari debu tanah.",
            "Istrinya diciptakan dari tulang rusuknya.",
            "Dia memberi nama kepada semua binatang.",
            "Dia tinggal di Taman Eden."
        ],
        'specific' => [
            "Dia memakan buah dari pohon yang dilarang.",
            "Dia memiliki dua anak laki-laki yang terkenal dalam cerita Alkitab."
        ],
        'very_specific' => [
            "Nama tokoh ini diawali dengan huruf A dan dia adalah bapa umat manusia."
        ]
    ],
    'Nuh' => [
        'general' => [
            "Tokoh ini hidup pada masa Perjanjian Lama.",
            "Dia adalah seorang yang taat kepada Tuhan.",
            "Dia tinggal di sebuah dunia yang penuh dosa.",
            "Dia memiliki keluarga yang diselamatkan oleh Tuhan.",
            "Dia dikenal karena sebuah peristiwa besar dalam Alkitab."
        ],
        'slightly_general' => [
            "Dia membangun sebuah bahtera besar.",
            "Dia membawa binatang-binatang ke dalam bahtera.",
            "Dia dan keluarganya selamat dari banjir besar.",
            "Dia membuat perjanjian dengan Tuhan setelah banjir."
        ],
        'specific' => [
            "Dia membawa tujuh pasang binatang yang tahir.",
            "Dia mengirim burung merpati untuk mencari daratan."
        ],
        'very_specific' => [
            "Nama tokoh ini diawali dengan huruf N dan dia adalah nenek moyang semua manusia setelah banjir."
        ]
    ],
    'Abraham' => [
        'general' => [
            "Tokoh ini hidup pada masa Perjanjian Lama.",
            "Dia adalah seorang yang sangat taat kepada Tuhan.",
            "Dia tinggal di sebuah tenda dan berpindah-pindah.",
            "Dia memiliki seorang istri yang setia.",
            "Dia dikenal sebagai bapa dari banyak bangsa."
        ],
        'slightly_general' => [
            "Dia awalnya bernama Abram.",
            "Dia pergi dari Ur Kasdim atas perintah Tuhan.",
            "Dia hampir mengorbankan anaknya sebagai persembahan.",
            "Dia memiliki seorang anak laki-laki pada usia tua."
        ],
        'specific' => [
            "Anaknya yang dijanjikan bernama Ishak.",
            "Dia membeli sebidang tanah untuk makam istrinya."
        ],
        'very_specific' => [
            "Nama tokoh ini diawali dengan huruf A dan dia adalah bapa dari bangsa Israel."
        ]
    ],
    'Musa' => [
        'general' => [
            "Tokoh ini hidup pada masa Perjanjian Lama.",
            "Dia adalah seorang pemimpin besar.",
            "Dia tinggal di Mesir pada awal hidupnya.",
            "Dia memiliki seorang saudara yang membantunya.",
            "Dia dikenal karena membawa bangsa Israel keluar dari perbudakan."
        ],
        'slightly_general' => [
            "Dia ditemukan di sungai Nil oleh putri Firaun.",
            "Dia melihat semak yang terbakar tetapi tidak habis.",
            "Dia membawa Sepuluh Perintah Tuhan.",
            "Dia memimpin bangsa Israel melintasi Laut Merah."
        ],
        'specific' => [
            "Dia memukul batu untuk mengeluarkan air.",
            "Dia tidak diizinkan masuk ke Tanah Perjanjian."
        ],
        'very_specific' => [
            "Nama tokoh ini diawali dengan huruf M dan dia adalah penulis dari lima kitab pertama Alkitab."
        ]
    ],
    'Daud' => [
        'general' => [
            "Tokoh ini hidup pada masa Perjanjian Lama.",
            "Dia adalah seorang raja yang terkenal.",
            "Dia tinggal di Yerusalem.",
            "Dia memiliki banyak anak.",
            "Dia dikenal sebagai seorang yang berkenan di hati Tuhan."
        ],
        'slightly_general' => [
            "Dia adalah seorang gembala domba.",
            "Dia mengalahkan raksasa Goliat dengan ketapel.",
            "Dia adalah seorang penulis mazmur.",
            "Dia memiliki persahabatan yang erat dengan Yonatan."
        ],
        'specific' => [
            "Dia melakukan dosa dengan Batsyeba.",
            "Dia adalah ayah dari Salomo."
        ],
        'very_specific' => [
            "Nama tokoh ini diawali dengan huruf D dan dia adalah raja Israel yang paling terkenal."
        ]
    ],
    'Salomo' => [
        'general' => [
            "Tokoh ini hidup pada masa Perjanjian Lama.",
            "Dia adalah seorang raja yang bijaksana.",
            "Dia tinggal di Yerusalem.",
            "Dia memiliki banyak istri.",
            "Dia dikenal karena kekayaannya yang luar biasa."
        ],
        'slightly_general' => [
            "Dia membangun Bait Suci di Yerusalem.",
            "Dia adalah putra dari Daud.",
            "Dia meminta hikmat dari Tuhan.",
            "Dia menulis kitab Amsal."
        ],
        'specific' => [
            "Dia menghakimi dua wanita yang memperebutkan seorang bayi.",
            "Dia dikunjungi oleh Ratu Syeba."
        ],
        'very_specific' => [
            "Nama tokoh ini diawali dengan huruf S dan dia adalah raja Israel yang paling bijaksana."
        ]
    ],
    'Yesus' => [
        'general' => [
            "Tokoh ini hidup pada masa Perjanjian Baru.",
            "Dia adalah seorang guru dan penyembuh.",
            "Dia tinggal di Israel.",
            "Dia memiliki murid-murid yang mengikuti-Nya.",
            "Dia dikenal sebagai Anak Allah."
        ],
        'slightly_general' => [
            "Dia lahir di Betlehem.",
            "Dia dibaptis oleh Yohanes Pembaptis.",
            "Dia melakukan banyak mukjizat.",
            "Dia mengajar dengan perumpamaan."
        ],
        'specific' => [
            "Dia disalibkan di Golgota.",
            "Dia bangkit dari kematian pada hari ketiga."
        ],
        'very_specific' => [
            "Nama tokoh ini diawali dengan huruf Y dan Dia adalah Juruselamat dunia."
        ]
    ],
    'Paulus' => [
        'general' => [
            "Tokoh ini hidup pada masa Perjanjian Baru.",
            "Dia adalah seorang misionaris.",
            "Dia tinggal di berbagai kota di Kekaisaran Romawi.",
            "Dia memiliki banyak teman dan rekan sekerja.",
            "Dia dikenal sebagai rasul bagi bangsa-bangsa lain."
        ],
        'slightly_general' => [
            "Dia awalnya bernama Saulus.",
            "Dia mengalami perubahan hidup di jalan ke Damsyik.",
            "Dia menulis banyak surat kepada jemaat-jemaat.",
            "Dia adalah seorang warga Romawi."
        ],
        'specific' => [
            "Dia pernah ditangkap dan dipenjara karena imannya.",
            "Dia adalah murid dari Gamaliel."
        ],
        'very_specific' => [
            "Nama tokoh ini diawali dengan huruf P dan dia adalah penulis sebagian besar Perjanjian Baru."
        ]
    ],
    'Yusuf' => [
        'general' => [
            "Tokoh ini hidup pada masa Perjanjian Lama.",
            "Dia adalah seorang yang saleh.",
            "Dia tinggal di Mesir.",
            "Dia memiliki banyak saudara.",
            "Dia dikenal karena mimpinya."
        ],
        'slightly_general' => [
            "Dia dijual oleh saudara-saudaranya.",
            "Dia menjadi penguasa di Mesir.",
            "Dia menafsirkan mimpi Firaun.",
            "Dia memaafkan saudara-saudaranya."
        ],
        'specific' => [
            "Dia memiliki jubah yang berwarna-warni.",
            "Dia adalah putra kesayangan Yakub."
        ],
        'very_specific' => [
            "Nama tokoh ini diawali dengan huruf Y dan dia adalah salah satu dari dua belas suku Israel."
        ]
    ],
    'Daniel' => [
        'general' => [
            "Tokoh ini hidup pada masa Perjanjian Lama.",
            "Dia adalah seorang yang bijaksana.",
            "Dia tinggal di Babel.",
            "Dia memiliki teman-teman yang saleh.",
            "Dia dikenal karena keteguhannya dalam iman."
        ],
        'slightly_general' => [
            "Dia menafsirkan mimpi Nebukadnezar.",
            "Dia selamat dari gua singa.",
            "Dia berdoa tiga kali sehari.",
            "Dia adalah seorang nabi."
        ],
        'specific' => [
            "Dia adalah salah satu dari tiga gubernur di Babel.",
            "Dia memiliki visi tentang akhir zaman."
        ],
        'very_specific' => [
            "Nama tokoh ini diawali dengan huruf D dan dia adalah penulis Kitab Daniel."
        ]
    ],
    'Ester' => [
        'general' => [
            "Tokoh ini hidup pada masa Perjanjian Lama.",
            "Dia adalah seorang wanita yang berani.",
            "Dia tinggal di Persia.",
            "Dia memiliki seorang paman yang bijaksana.",
            "Dia dikenal karena menyelamatkan bangsanya."
        ],
        'slightly_general' => [
            "Dia menjadi ratu Persia.",
            "Dia menggantikan Ratu Wasti.",
            "Dia berpuasa untuk meminta pertolongan Tuhan.",
            "Dia mengadakan perjamuan untuk raja dan Haman."
        ],
        'specific' => [
            "Dia adalah seorang Yahudi yang menyembunyikan identitasnya.",
            "Dia adalah anak angkat Mordekhai."
        ],
        'very_specific' => [
            "Nama tokoh ini diawali dengan huruf E dan dia adalah tokoh utama dalam Kitab Ester."
        ]
    ],
    'Yohanes Pembaptis' => [
        'general' => [
            "Tokoh ini hidup pada masa Perjanjian Baru.",
            "Dia adalah seorang yang mengajar di padang gurun.",
            "Dia tinggal di tepi Sungai Yordan.",
            "Dia memiliki murid-murid yang mengikuti ajarannya.",
            "Dia dikenal sebagai pembuka jalan bagi Mesias."
        ],
        'slightly_general' => [
            "Dia adalah anak dari Zakaria dan Elisabet.",
            "Dia membaptis orang-orang di Sungai Yordan.",
            "Dia memakai pakaian dari bulu unta.",
            "Dia menegur Herodes karena perbuatannya."
        ],
        'specific' => [
            "Dia adalah sepupu Yesus.",
            "Dia dipenggal kepalanya atas perintah Herodes."
        ],
        'very_specific' => [
            "Nama tokoh ini diawali dengan huruf Y dan dia adalah nabi terakhir sebelum Yesus."
        ]
    ],
    'Maria' => [
        'general' => [
            "Tokoh ini hidup pada masa Perjanjian Baru.",
            "Dia adalah seorang wanita yang saleh.",
            "Dia tinggal di Nazaret.",
            "Dia memiliki seorang suami yang setia.",
            "Dia dikenal sebagai ibu dari Yesus."
        ],
        'slightly_general' => [
            "Dia dikunjungi oleh malaikat Gabriel.",
            "Dia melahirkan Yesus di Betlehem.",
            "Dia pergi ke Mesir untuk melindungi Yesus.",
            "Dia hadir saat penyaliban Yesus."
        ],
        'specific' => [
            "Dia adalah seorang perawan yang mengandung oleh Roh Kudus.",
            "Dia menyanyikan sebuah kidung pujian yang terkenal."
        ],
        'very_specific' => [
            "Nama tokoh ini diawali dengan huruf M dan dia adalah ibu dari Juruselamat."
        ]
    ],
    'Petrus' => [
        'general' => [
            "Tokoh ini hidup pada masa Perjanjian Baru.",
            "Dia adalah seorang nelayan.",
            "Dia tinggal di Kapernaum.",
            "Dia memiliki seorang saudara yang juga murid Yesus.",
            "Dia dikenal sebagai salah satu dari dua belas rasul."
        ],
        'slightly_general' => [
            "Dia awalnya bernama Simon.",
            "Dia berjalan di atas air menuju Yesus.",
            "Dia menyangkal Yesus tiga kali.",
            "Dia adalah pemimpin dari para rasul."
        ],
        'specific' => [
            "Dia adalah rasul yang pertama kali berkhotbah pada hari Pentakosta.",
            "Dia disembuhkan dari penjara oleh malaikat."
        ],
        'very_specific' => [
            "Nama tokoh ini diawali dengan huruf P dan dia adalah 'batu' yang menjadi dasar gereja."
        ]
    ],
    'Rahab' => [
        'general' => [
            "Tokoh ini hidup pada masa Perjanjian Lama.",
            "Dia adalah seorang wanita yang tinggal di Yerikho.",
            "Dia memiliki profesi yang kurang terhormat.",
            "Dia membantu orang-orang Israel.",
            "Dia dikenal karena imannya."
        ],
        'slightly_general' => [
            "Dia menyembunyikan mata-mata Israel di rumahnya.",
            "Dia menurunkan mata-mata dari jendela dengan tali.",
            "Dia meminta tanda pengenal berupa tali merah.",
            "Dia selamat saat Yerikho dihancurkan."
        ],
        'specific' => [
            "Dia adalah nenek moyang dari Raja Daud.",
            "Dia disebutkan dalam silsilah Yesus."
        ],
        'very_specific' => [
            "Nama tokoh ini diawali dengan huruf R dan dia adalah seorang pelacur yang bertobat."
        ]
    ],
    'Elia' => [
        'general' => [
            "Tokoh ini hidup pada masa Perjanjian Lama.",
            "Dia adalah seorang nabi.",
            "Dia tinggal di Israel.",
            "Dia memiliki seorang murid yang menggantikannya.",
            "Dia dikenal karena mukjizat-mukjizatnya."
        ],
        'slightly_general' => [
            "Dia menantang nabi-nabi Baal di Gunung Karmel.",
            "Dia dibawa ke surga dengan kereta berapi.",
            "Dia memberi makan seorang janda di Sarfat.",
            "Dia menghidupkan kembali anak janda tersebut."
        ],
        'specific' => [
            "Dia adalah nabi yang tidak mati.",
            "Dia muncul bersama Musa saat Yesus dimuliakan."
        ],
        'very_specific' => [
            "Nama tokoh ini diawali dengan huruf E dan dia adalah nabi yang paling terkenal di Israel."
        ]
    ],
    'Elisa' => [
        'general' => [
            "Tokoh ini hidup pada masa Perjanjian Lama.",
            "Dia adalah seorang nabi.",
            "Dia tinggal di Israel.",
            "Dia memiliki seorang guru yang terkenal.",
            "Dia dikenal karena mukjizat-mukjizatnya."
        ],
        'slightly_general' => [
            "Dia adalah murid Elia.",
            "Dia meminta dua kali lipat dari roh Elia.",
            "Dia menyembuhkan Naaman dari penyakit kusta.",
            "Dia menghidupkan kembali anak perempuan Sunem."
        ],
        'specific' => [
            "Dia membuat kapak mengapung di sungai.",
            "Dia meramalkan kematian raja Israel."
        ],
        'very_specific' => [
            "Nama tokoh ini diawali dengan huruf E dan dia adalah penerus Elia."
        ]
    ],
    'Yakub' => [
        'general' => [
            "Tokoh ini hidup pada masa Perjanjian Lama.",
            "Dia adalah seorang yang cerdik.",
            "Dia tinggal di Kanaan dan Haran.",
            "Dia memiliki dua istri.",
            "Dia dikenal sebagai bapa dari dua belas suku Israel."
        ],
        'slightly_general' => [
            "Dia adalah saudara kembar Esau.",
            "Dia mencuri berkat dari Esau.",
            "Dia bermimpi tentang tangga ke surga.",
            "Dia bergulat dengan malaikat."
        ],
        'specific' => [
            "Dia memiliki dua belas anak laki-laki.",
            "Dia berganti nama menjadi Israel."
        ],
        'very_specific' => [
            "Nama tokoh ini diawali dengan huruf Y dan dia adalah ayah dari Yusuf."
        ]
    ],
    'Yosua' => [
        'general' => [
            "Tokoh ini hidup pada masa Perjanjian Lama.",
            "Dia adalah seorang pemimpin militer.",
            "Dia tinggal di padang gurun dan Kanaan.",
            "Dia memiliki seorang mentor yang terkenal.",
            "Dia dikenal karena menaklukkan Tanah Perjanjian."
        ],
        'slightly_general' => [
            "Dia adalah penerus Musa.",
            "Dia memimpin bangsa Israel melintasi Sungai Yordan.",
            "Dia memimpin pertempuran Yerikho.",
            "Dia membagi tanah Kanaan kepada suku-suku Israel."
        ],
        'specific' => [
            "Dia adalah mata-mata yang setia di Kanaan.",
            "Dia memerintahkan matahari berhenti di Gibeon."
        ],
        'very_specific' => [
            "Nama tokoh ini diawali dengan huruf Y dan dia adalah penulis Kitab Yosua."
        ]
    ],
    'Debora' => [
        'general' => [
            "Tokoh ini hidup pada masa Perjanjian Lama.",
            "Dia adalah seorang wanita yang bijaksana.",
            "Dia tinggal di Israel.",
            "Dia memiliki peran penting dalam pemerintahan.",
            "Dia dikenal sebagai seorang hakim."
        ],
        'slightly_general' => [
            "Dia adalah seorang nabi perempuan.",
            "Dia memimpin Israel dalam pertempuran melawan Sisera.",
            "Dia duduk di bawah pohon kurma untuk mengadili.",
            "Dia menyanyikan sebuah kidung kemenangan."
        ],
        'specific' => [
            "Dia adalah satu-satunya hakim perempuan dalam Alkitab.",
            "Dia bekerja sama dengan Barak dalam pertempuran."
        ],
        'very_specific' => [
            "Nama tokoh ini diawali dengan huruf D dan dia adalah tokoh wanita yang berpengaruh di Israel."
        ]
    ],
    'Mesakh' => [
        'general' => [
            "Tokoh ini hidup pada masa Perjanjian Lama.",
            "Dia adalah seorang pria yang saleh.",
            "Dia tinggal di sebuah kerajaan besar pada zamannya.",
            "Dia adalah seorang tawanan dari Yehuda.",
            "Dia dikenal karena imannya yang kuat kepada Tuhan."
        ],
        'slightly_general' => [
            "Dia adalah seorang pemuda Ibrani yang tinggal di Babel.",
            "Dia memiliki dua teman dekat yang juga saleh.",
            "Dia menolak untuk menyembah dewa-dewa lain.",
            "Dia mengalami mukjizat yang luar biasa."
        ],
        'specific' => [
            "Dia adalah salah satu dari tiga orang yang selamat dari perapian yang menyala-nyala.",
            "Dia disebutkan dalam Kitab Daniel."
        ],
        'very_specific' => [
            "Nama tokoh ini diawali dengan huruf 'M' dan dia adalah salah satu dari Sadrakh, Mesakh, dan Abednego."
        ]
    ],
    'Yafet' => [
        'general' => [
            "Tokoh ini hidup pada masa Perjanjian Lama.",
            "Dia adalah seorang pria yang taat kepada Tuhan.",
            "Dia tinggal di sebuah dunia yang penuh dosa.",
            "Dia memiliki keluarga yang diselamatkan oleh Tuhan.",
            "Dia dikenal karena peristiwa besar dalam Alkitab."
        ],
        'slightly_general' => [
            "Dia adalah salah satu putra Nuh.",
            "Dia masuk ke dalam bahtera bersama keluarganya.",
            "Dia adalah salah satu dari tiga putra yang disebutkan dalam kisah banjir.",
            "Dia adalah nenek moyang dari banyak bangsa."
        ],
        'specific' => [
            "Dia adalah saudara dari Sem dan Ham.",
            "Dia diberkati oleh Nuh setelah banjir."
        ],
        'very_specific' => [
            "Nama tokoh ini diawali dengan huruf 'Y' dan dia adalah putra bungsu Nuh."
        ]
    ],
    'Bileam' => [
        'general' => [
            "Tokoh ini hidup pada masa Perjanjian Lama.",
            "Dia adalah seorang yang memiliki kemampuan khusus.",
            "Dia tinggal di daerah Timur Dekat.",
            "Dia memiliki hubungan dengan bangsa Israel.",
            "Dia dikenal karena sebuah peristiwa yang melibatkan hewan."
        ],
        'slightly_general' => [
            "Dia adalah seorang nabi yang disewa untuk mengutuk Israel.",
            "Dia memiliki keledai yang berbicara.",
            "Dia akhirnya memberkati Israel alih-alih mengutuknya.",
            "Dia disebutkan dalam Kitab Bilangan."
        ],
        'specific' => [
            "Dia adalah orang yang diutus oleh Balak, raja Moab.",
            "Dia melihat malaikat Tuhan di jalan."
        ],
        'very_specific' => [
            "Nama tokoh ini diawali dengan huruf 'B' dan dia adalah nabi yang keledainya berbicara."
        ]
    ],
    'Abigail' => [
        'general' => [
            "Tokoh ini hidup pada masa Perjanjian Lama.",
            "Dia adalah seorang wanita yang cerdas.",
            "Dia tinggal di Israel.",
            "Dia memiliki suami yang kurang bijaksana.",
            "Dia dikenal karena tindakannya yang menyelamatkan keluarganya."
        ],
        'slightly_general' => [
            "Dia adalah istri Nabal, seorang pria kaya tetapi bodoh.",
            "Dia mencegah Daud dari membunuh suaminya.",
            "Dia membawa persembahan kepada Daud dan tentaranya.",
            "Dia kemudian menjadi istri Daud."
        ],
        'specific' => [
            "Dia disebutkan dalam Kitab 1 Samuel.",
            "Dia adalah wanita yang cantik dan bijaksana."
        ],
        'very_specific' => [
            "Nama tokoh ini diawali dengan huruf 'A' dan dia adalah salah satu istri Daud."
        ]
    ],
    'Gideon' => [
        'general' => [
            "Tokoh ini hidup pada masa Perjanjian Lama.",
            "Dia adalah seorang pemimpin militer.",
            "Dia tinggal di Israel.",
            "Dia memiliki keraguan pada awalnya.",
            "Dia dikenal karena kemenangannya yang luar biasa."
        ],
        'slightly_general' => [
            "Dia adalah seorang hakim Israel.",
            "Dia meminta tanda dari Tuhan dengan bulu domba.",
            "Dia memimpin 300 orang untuk mengalahkan Midian.",
            "Dia menggunakan terompet dan obor dalam pertempuran."
        ],
        'specific' => [
            "Dia adalah putra Yoas dari suku Manasye.",
            "Dia disebutkan dalam Kitab Hakim-hakim."
        ],
        'very_specific' => [
            "Nama tokoh ini diawali dengan huruf 'G' dan dia adalah hakim yang mengalahkan Midian dengan pasukan kecil."
        ]
    ],
    'Haman' => [
        'general' => [
            "Tokoh ini hidup pada masa Perjanjian Lama.",
            "Dia adalah seorang pejabat tinggi.",
            "Dia tinggal di Persia.",
            "Dia memiliki rencana jahat terhadap orang Yahudi.",
            "Dia dikenal karena kejatuhannya yang tragis."
        ],
        'slightly_general' => [
            "Dia adalah musuh dari Mordekhai.",
            "Dia merencanakan untuk membunuh semua orang Yahudi.",
            "Dia membangun tiang gantungan untuk Mordekhai.",
            "Dia akhirnya digantung di tiang yang dia buat sendiri."
        ],
        'specific' => [
            "Dia adalah tokoh antagonis dalam Kitab Ester.",
            "Dia adalah keturunan Agag, raja Amalek."
        ],
        'very_specific' => [
            "Nama tokoh ini diawali dengan huruf 'H' dan dia adalah musuh utama dalam perayaan Purim."
        ]
    ],
    'Yehu' => [
        'general' => [
            "Tokoh ini hidup pada masa Perjanjian Lama.",
            "Dia adalah seorang raja Israel.",
            "Dia tinggal di Samaria.",
            "Dia memiliki misi untuk membersihkan kerajaan.",
            "Dia dikenal karena tindakannya yang tegas."
        ],
        'slightly_general' => [
            "Dia diurapi oleh Elisa untuk menjadi raja.",
            "Dia membunuh Yoram, raja Israel, dan Ahazia, raja Yehuda.",
            "Dia memerintahkan kematian Izebel.",
            "Dia menghancurkan penyembahan Baal di Israel."
        ],
        'specific' => [
            "Dia adalah putra Yosafat, cucu Nimsi.",
            "Dia disebutkan dalam Kitab 2 Raja-raja."
        ],
        'very_specific' => [
            "Nama tokoh ini diawali dengan huruf 'Y' dan dia adalah raja yang mengendarai kereta dengan cepat."
        ]
    ],
    'Bartimeus' => [
        'general' => [
            "Tokoh ini hidup pada masa Perjanjian Baru.",
            "Dia adalah seorang yang memiliki keterbatasan fisik.",
            "Dia tinggal di Yerikho.",
            "Dia bertemu dengan Yesus.",
            "Dia dikenal karena imannya yang kuat."
        ],
        'slightly_general' => [
            "Dia adalah seorang pengemis buta.",
            "Dia berseru kepada Yesus, 'Anak Daud, kasihanilah aku!'",
            "Dia disembuhkan oleh Yesus dan mengikuti-Nya.",
            "Dia disebutkan dalam Injil Markus."
        ],
        'specific' => [
            "Dia adalah putra Timeus.",
            "Dia melemparkan jubahnya saat dipanggil Yesus."
        ],
        'very_specific' => [
            "Nama tokoh ini diawali dengan huruf 'B' dan dia adalah orang buta yang disembuhkan di Yerikho."
        ]
    ],
    'Ananias' => [
        'general' => [
            "Tokoh ini hidup pada masa Perjanjian Baru.",
            "Dia adalah seorang yang taat kepada Tuhan.",
            "Dia tinggal di Damsyik.",
            "Dia memiliki peran penting dalam kehidupan seorang rasul.",
            "Dia dikenal karena ketaatannya kepada perintah Tuhan."
        ],
        'slightly_general' => [
            "Dia adalah seorang murid Yesus di Damsyik.",
            "Dia menyembuhkan kebutaan Saulus.",
            "Dia membaptis Saulus, yang kemudian menjadi Paulus.",
            "Dia awalnya ragu tetapi taat kepada perintah Tuhan."
        ],
        'specific' => [
            "Dia disebutkan dalam Kisah Para Rasul.",
            "Dia adalah orang yang dipilih Tuhan untuk bertemu Saulus."
        ],
        'very_specific' => [
            "Nama tokoh ini diawali dengan huruf 'A' dan dia adalah orang yang membaptis Paulus."
        ]
    ],
    'Yitro' => [
        'general' => [
            "Tokoh ini hidup pada masa Perjanjian Lama.",
            "Dia adalah seorang yang bijaksana.",
            "Dia tinggal di Midian.",
            "Dia memiliki hubungan keluarga dengan Musa.",
            "Dia dikenal karena nasihatnya yang berharga."
        ],
        'slightly_general' => [
            "Dia adalah ayah mertua Musa.",
            "Dia adalah imam Midian.",
            "Dia menyarankan Musa untuk membagi tugas kepemimpinan.",
            "Dia membawa Zipora dan anak-anaknya kepada Musa."
        ],
        'specific' => [
            "Dia adalah orang yang memuji Tuhan setelah mendengar pembebasan Israel.",
            "Dia disebutkan dalam Kitab Keluaran."
        ],
        'very_specific' => [
            "Nama tokoh ini diawali dengan huruf 'Y' dan dia adalah mertua Musa."
        ]
    ]
];

// Inisialisasi variabel
$teams = []; // team_name => score
$team_history = []; // team_name => [[character, points], ...]
$team_order = []; // Urutan tim
$current_team_index = 0; // Indeks tim yang sedang bermain

// Fungsi untuk membersihkan layar
function clear_screen() {
    if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
        system('cls');
    } else {
        system('clear');
    }
}

// Fungsi untuk mendapatkan warna clue berdasarkan kategori
function get_clue_color($category) {
    switch ($category) {
        case 'general':
            return "\033[32m"; // Hijau
        case 'slightly_general':
            return "\033[33m"; // Kuning
        case 'specific':
            return "\033[34m"; // Biru
        case 'very_specific':
            return "\033[1;33m"; // Bold yellow untuk gold
        default:
            return "\033[0m";
    }
}

// Animasi loading
function loading_animation() {
    global $cyan, $reset, $green;
    echo $cyan . "Reading database" . $reset;
    for ($i = 0; $i < 5; $i++) {
        echo ".";
        sleep(1);
    }
    echo "\n" . $green . "Database read and studied." . $reset . "\n";
    sleep(2);
}

// Main game loop
loading_animation();
while (true) {
    clear_screen();
    echo $cyan . $bold . "=== Main Menu ===" . $reset . "\n";
    echo $cyan . "1. Register Team\n";
    echo "2. View Scores and Rankings\n";
    echo "3. Start Game\n";
    echo "4. Exit" . $reset . "\n";
    echo "Choose an option: ";
    $choice = trim(fgets(STDIN));

    if ($choice == '1') {
        echo $cyan . "Enter team name: " . $reset;
        $team_name = trim(fgets(STDIN));
        if (!isset($teams[$team_name])) {
            $teams[$team_name] = 0;
            $team_history[$team_name] = [];
            $team_order[] = $team_name; // Tambahkan ke urutan tim
            echo $green . "Team $team_name registered." . $reset . "\n";
        } else {
            echo $red . "Team $team_name already exists." . $reset . "\n";
        }
        sleep(2);
    } elseif ($choice == '2') {
        clear_screen();
        if (empty($teams)) {
            echo $red . "No teams registered yet." . $reset . "\n";
        } else {
            echo $cyan . $bold . "=== Rankings ===" . $reset . "\n";
            arsort($teams);
            $rank = 1;
            foreach ($teams as $team => $score) {
                echo "$rank. " . $bold . "$team" . $reset . ": $score points\n";
                $rank++;
            }
            echo "\n" . $bold . "History:" . $reset . "\n";
            foreach ($team_history as $team => $history) {
                echo "$team:\n";
                if (empty($history)) {
                    echo "  None\n";
                } else {
                    foreach ($history as $item) {
                        echo "  - " . $item[0] . ": " . $item[1] . " points\n";
                    }
                }
            }
        }
        echo "\n" . $cyan . "Press Enter to continue..." . $reset;
        fgets(STDIN);
    } elseif ($choice == '3') {
        if (count($teams) < 2) {
            echo $red . "At least two teams are required to start the game." . $reset . "\n";
            sleep(2);
            continue;
        }
        $available_characters = array_keys($database);
        $current_team_index = 0; // Mulai dari tim pertama
        while (true) {
            if (count($available_characters) < 2) {
                clear_screen();
                echo $red . "Not enough characters left. Ending game session." . $reset . "\n";
                echo $cyan . $bold . "=== Game Session Ended ===" . $reset . "\n";
                echo $bold . "Final Scores and Rankings:" . $reset . "\n";
                arsort($teams);
                $rank = 1;
                foreach ($teams as $team => $score) {
                    echo "$rank. " . $bold . "$team" . $reset . ": $score points\n";
                    $rank++;
                }
                echo "\n" . $bold . "History:" . $reset . "\n";
                foreach ($team_history as $team => $history) {
                    echo "$team:\n";
                    if (empty($history)) {
                        echo "  None\n";
                    } else {
                        foreach ($history as $item) {
                            echo "  - " . $item[0] . ": " . $item[1] . " points\n";
                        }
                    }
                }
                echo "\n" . $cyan . "Press Enter to return to main menu..." . $reset;
                fgets(STDIN);
                break;
            }
            $playing_team = $team_order[$current_team_index];
            clear_screen(); // Bersihkan layar sebelum giliran tim baru
            echo $cyan . $bold . "=== Team $playing_team's Turn ===" . $reset . "\n";
            $selected_indices = array_rand($available_characters, 2);
            $char1 = $available_characters[$selected_indices[0]];
            $char2 = $available_characters[$selected_indices[1]];
            echo "Choose a character:\n";
            echo "1. " . $yellow . $char1 . $reset . "\n";
            echo "2. " . $yellow . $char2 . $reset . "\n";
            echo $cyan . "Enter 1 or 2: " . $reset;
            $choice = trim(fgets(STDIN));
            if ($choice == '1') {
                $chosen_character = $char1;
            } elseif ($choice == '2') {
                $chosen_character = $char2;
            } else {
                echo $red . "Invalid choice." . $reset . "\n";
                sleep(2);
                continue;
            }
            $index = array_search($chosen_character, $available_characters);
            unset($available_characters[$index]);
            $available_characters = array_values($available_characters);
            $all_clues = array_merge(
                array_map(function($clue) { return [$clue, 'general']; }, $database[$chosen_character]['general']),
                array_map(function($clue) { return [$clue, 'slightly_general']; }, $database[$chosen_character]['slightly_general']),
                array_map(function($clue) { return [$clue, 'specific']; }, $database[$chosen_character]['specific']),
                array_map(function($clue) { return [$clue, 'very_specific']; }, $database[$chosen_character]['very_specific'])
            );
            shuffle($all_clues);
            $revealed_clues = 0;
            $total_clues = count($all_clues);
            $guessed_correctly = false;
            while ($revealed_clues < $total_clues) {
                $clue = $all_clues[$revealed_clues];
                echo get_clue_color($clue[1]) . "Clue " . ($revealed_clues + 1) . ": " . $clue[0] . $reset . "\n";
                echo $cyan . "Has the team guessed correctly? (Y/N): " . $reset;
                $answer = strtoupper(trim(fgets(STDIN)));
                if ($answer == 'Y') {
                    $deduction = (100 / $total_clues) * $revealed_clues;
                    $score = 100 - $deduction;
                    $score = max(0, $score);
                    $teams[$playing_team] += round($score, 2);
                    $team_history[$playing_team][] = [$chosen_character, round($score, 2)];
                    echo $green . "Correct! Team $playing_team earns " . round($score, 2) . " points. Total: " . $teams[$playing_team] . $reset . "\n";
                    $guessed_correctly = true;
                    break;
                } elseif ($answer == 'N') {
                    $revealed_clues++;
                } else {
                    echo $red . "Invalid input." . $reset . "\n";
                }
            }
            if (!$guessed_correctly) {
                echo $red . "Team $playing_team did not guess correctly. 0 points." . $reset . "\n";
                $team_history[$playing_team][] = [$chosen_character, 0];
            }
            echo $cyan . "Continue to next team? (Y) or End session (X): " . $reset;
            $continue = strtoupper(trim(fgets(STDIN)));
            if ($continue == 'X') {
                clear_screen();
                echo $cyan . $bold . "=== Game Session Ended ===" . $reset . "\n";
                echo $bold . "Final Scores and Rankings:" . $reset . "\n";
                arsort($teams);
                $rank = 1;
                foreach ($teams as $team => $score) {
                    echo "$rank. " . $bold . "$team" . $reset . ": $score points\n";
                    $rank++;
                }
                echo "\n" . $bold . "History:" . $reset . "\n";
                foreach ($team_history as $team => $history) {
                    echo "$team:\n";
                    if (empty($history)) {
                        echo "  None\n";
                    } else {
                        foreach ($history as $item) {
                            echo "  - " . $item[0] . ": " . $item[1] . " points\n";
                        }
                    }
                }
                echo "\n" . $cyan . "Press Enter to return to main menu..." . $reset;
                fgets(STDIN);
                break;
            }
            // Pindah ke tim berikutnya dengan memastikan tim yang sama tidak bermain lagi
            $current_team_index = ($current_team_index + 1) % count($team_order);
            // Bersihkan layar sebelum giliran tim berikutnya dimulai
            clear_screen();
        }
    } elseif ($choice == '4') {
        echo $red . "Exiting game. All data will be reset." . $reset . "\n";
        break;
    } else {
        echo $red . "Invalid option." . $reset . "\n";
        sleep(2);
    }
}
?>