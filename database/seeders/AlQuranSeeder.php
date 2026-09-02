<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Surah;
use App\Models\Ayat;

class AlQuranSeeder extends Seeder
{
    public function run(): void
    {
        // Daftar semua 114 Surah
        $surahs = [
            ['nomor' => 1, 'nama' => 'Al-Fatihah', 'nama_arab' => 'الفاتحة', 'jumlah_ayat' => 7],
            ['nomor' => 2, 'nama' => 'Al-Baqarah', 'nama_arab' => 'البقرة', 'jumlah_ayat' => 286],
            ['nomor' => 3, 'nama' => 'Ali Imran', 'nama_arab' => 'آل عمران', 'jumlah_ayat' => 200],
            ['nomor' => 4, 'nama' => 'An-Nisa', 'nama_arab' => 'النساء', 'jumlah_ayat' => 176],
            ['nomor' => 5, 'nama' => 'Al-Ma\'idah', 'nama_arab' => 'المائدة', 'jumlah_ayat' => 120],
            ['nomor' => 6, 'nama' => 'Al-An\'am', 'nama_arab' => 'الأنعام', 'jumlah_ayat' => 165],
            ['nomor' => 7, 'nama' => 'Al-A\'raf', 'nama_arab' => 'الأعراف', 'jumlah_ayat' => 206],
            ['nomor' => 8, 'nama' => 'Al-Anfal', 'nama_arab' => 'الأنفال', 'jumlah_ayat' => 75],
            ['nomor' => 9, 'nama' => 'At-Taubah', 'nama_arab' => 'التوبة', 'jumlah_ayat' => 129],
            ['nomor' => 10, 'nama' => 'Yunus', 'nama_arab' => 'يونس', 'jumlah_ayat' => 109],
            ['nomor' => 11, 'nama' => 'Hud', 'nama_arab' => 'هود', 'jumlah_ayat' => 123],
            ['nomor' => 12, 'nama' => 'Yusuf', 'nama_arab' => 'يوسف', 'jumlah_ayat' => 111],
            ['nomor' => 13, 'nama' => 'Ar-Ra\'d', 'nama_arab' => 'الرعد', 'jumlah_ayat' => 43],
            ['nomor' => 14, 'nama' => 'Ibrahim', 'nama_arab' => 'ابراهيم', 'jumlah_ayat' => 52],
            ['nomor' => 15, 'nama' => 'Al-Hijr', 'nama_arab' => 'الحجر', 'jumlah_ayat' => 99],
            ['nomor' => 16, 'nama' => 'An-Nahl', 'nama_arab' => 'النحل', 'jumlah_ayat' => 128],
            ['nomor' => 17, 'nama' => 'Al-Isra', 'nama_arab' => 'الإسراء', 'jumlah_ayat' => 111],
            ['nomor' => 18, 'nama' => 'Al-Kahf', 'nama_arab' => 'الكهف', 'jumlah_ayat' => 110],
            ['nomor' => 19, 'nama' => 'Maryam', 'nama_arab' => 'مريم', 'jumlah_ayat' => 98],
            ['nomor' => 20, 'nama' => 'Taha', 'nama_arab' => 'طه', 'jumlah_ayat' => 135],
            ['nomor' => 21, 'nama' => 'Al-Anbiya', 'nama_arab' => 'الأنبياء', 'jumlah_ayat' => 112],
            ['nomor' => 22, 'nama' => 'Al-Hajj', 'nama_arab' => 'الحج', 'jumlah_ayat' => 78],
            ['nomor' => 23, 'nama' => 'Al-Mu\'minun', 'nama_arab' => 'المؤمنون', 'jumlah_ayat' => 118],
            ['nomor' => 24, 'nama' => 'An-Nur', 'nama_arab' => 'النور', 'jumlah_ayat' => 64],
            ['nomor' => 25, 'nama' => 'Al-Furqan', 'nama_arab' => 'الفرقان', 'jumlah_ayat' => 77],
            ['nomor' => 26, 'nama' => 'Asy-Syu\'ara', 'nama_arab' => 'الشعراء', 'jumlah_ayat' => 227],
            ['nomor' => 27, 'nama' => 'An-Naml', 'nama_arab' => 'النمل', 'jumlah_ayat' => 93],
            ['nomor' => 28, 'nama' => 'Al-Qasas', 'nama_arab' => 'القصص', 'jumlah_ayat' => 88],
            ['nomor' => 29, 'nama' => 'Al-Ankabut', 'nama_arab' => 'العنكبوت', 'jumlah_ayat' => 69],
            ['nomor' => 30, 'nama' => 'Ar-Rum', 'nama_arab' => 'الروم', 'jumlah_ayat' => 60],
            ['nomor' => 31, 'nama' => 'Luqman', 'nama_arab' => 'لقمان', 'jumlah_ayat' => 34],
            ['nomor' => 32, 'nama' => 'As-Sajdah', 'nama_arab' => 'السجدة', 'jumlah_ayat' => 30],
            ['nomor' => 33, 'nama' => 'Al-Ahzab', 'nama_arab' => 'الأحزاب', 'jumlah_ayat' => 73],
            ['nomor' => 34, 'nama' => 'Saba', 'nama_arab' => 'سبأ', 'jumlah_ayat' => 54],
            ['nomor' => 35, 'nama' => 'Fatir', 'nama_arab' => 'فاطر', 'jumlah_ayat' => 45],
            ['nomor' => 36, 'nama' => 'Yasin', 'nama_arab' => 'يس', 'jumlah_ayat' => 83],
            ['nomor' => 37, 'nama' => 'As-Saffat', 'nama_arab' => 'الصافات', 'jumlah_ayat' => 182],
            ['nomor' => 38, 'nama' => 'Sad', 'nama_arab' => 'ص', 'jumlah_ayat' => 88],
            ['nomor' => 39, 'nama' => 'Az-Zumar', 'nama_arab' => 'الزمر', 'jumlah_ayat' => 75],
            ['nomor' => 40, 'nama' => 'Ghafir', 'nama_arab' => 'غافر', 'jumlah_ayat' => 85],
            ['nomor' => 41, 'nama' => 'Fussilat', 'nama_arab' => 'فصلت', 'jumlah_ayat' => 54],
            ['nomor' => 42, 'nama' => 'Asy-Syura', 'nama_arab' => 'الشورى', 'jumlah_ayat' => 53],
            ['nomor' => 43, 'nama' => 'Az-Zukhruf', 'nama_arab' => 'الزخرف', 'jumlah_ayat' => 89],
            ['nomor' => 44, 'nama' => 'Ad-Dukhan', 'nama_arab' => 'الدخان', 'jumlah_ayat' => 59],
            ['nomor' => 45, 'nama' => 'Al-Jatsiyah', 'nama_arab' => 'الجاثية', 'jumlah_ayat' => 37],
            ['nomor' => 46, 'nama' => 'Al-Ahqaf', 'nama_arab' => 'الأحقاف', 'jumlah_ayat' => 35],
            ['nomor' => 47, 'nama' => 'Muhammad', 'nama_arab' => 'محمد', 'jumlah_ayat' => 38],
            ['nomor' => 48, 'nama' => 'Al-Fath', 'nama_arab' => 'الفتح', 'jumlah_ayat' => 29],
            ['nomor' => 49, 'nama' => 'Al-Hujurat', 'nama_arab' => 'الحجرات', 'jumlah_ayat' => 18],
            ['nomor' => 50, 'nama' => 'Qaf', 'nama_arab' => 'ق', 'jumlah_ayat' => 45],
            ['nomor' => 51, 'nama' => 'Adz-Dzariyat', 'nama_arab' => 'الذاريات', 'jumlah_ayat' => 60],
            ['nomor' => 52, 'nama' => 'At-Tur', 'nama_arab' => 'الطور', 'jumlah_ayat' => 49],
            ['nomor' => 53, 'nama' => 'An-Najm', 'nama_arab' => 'النجم', 'jumlah_ayat' => 62],
            ['nomor' => 54, 'nama' => 'Al-Qamar', 'nama_arab' => 'القمر', 'jumlah_ayat' => 55],
            ['nomor' => 55, 'nama' => 'Ar-Rahman', 'nama_arab' => 'الرحمن', 'jumlah_ayat' => 78],
            ['nomor' => 56, 'nama' => 'Al-Waqi\'ah', 'nama_arab' => 'الواقعة', 'jumlah_ayat' => 96],
            ['nomor' => 57, 'nama' => 'Al-Hadid', 'nama_arab' => 'الحديد', 'jumlah_ayat' => 29],
            ['nomor' => 58, 'nama' => 'Al-Mujadilah', 'nama_arab' => 'المجادلة', 'jumlah_ayat' => 22],
            ['nomor' => 59, 'nama' => 'Al-Hasyr', 'nama_arab' => 'الحشر', 'jumlah_ayat' => 24],
            ['nomor' => 60, 'nama' => 'Al-Mumtahanah', 'nama_arab' => 'الممتحنة', 'jumlah_ayat' => 13],
            ['nomor' => 61, 'nama' => 'As-Saff', 'nama_arab' => 'الصف', 'jumlah_ayat' => 14],
            ['nomor' => 62, 'nama' => 'Al-Jumu\'ah', 'nama_arab' => 'الجمعة', 'jumlah_ayat' => 11],
            ['nomor' => 63, 'nama' => 'Al-Munafiqun', 'nama_arab' => 'المنافقون', 'jumlah_ayat' => 11],
            ['nomor' => 64, 'nama' => 'At-Taghabun', 'nama_arab' => 'التغابن', 'jumlah_ayat' => 18],
            ['nomor' => 65, 'nama' => 'At-Talaq', 'nama_arab' => 'الطلاق', 'jumlah_ayat' => 12],
            ['nomor' => 66, 'nama' => 'At-Tahrim', 'nama_arab' => 'التحريم', 'jumlah_ayat' => 12],
            ['nomor' => 67, 'nama' => 'Al-Mulk', 'nama_arab' => 'الملك', 'jumlah_ayat' => 30],
            ['nomor' => 68, 'nama' => 'Al-Qalam', 'nama_arab' => 'القلم', 'jumlah_ayat' => 52],
            ['nomor' => 69, 'nama' => 'Al-Haqqah', 'nama_arab' => 'الحاقة', 'jumlah_ayat' => 52],
            ['nomor' => 70, 'nama' => 'Al-Ma\'arij', 'nama_arab' => 'المعارج', 'jumlah_ayat' => 44],
            ['nomor' => 71, 'nama' => 'Nuh', 'nama_arab' => 'نوح', 'jumlah_ayat' => 28],
            ['nomor' => 72, 'nama' => 'Al-Jinn', 'nama_arab' => 'الجن', 'jumlah_ayat' => 28],
            ['nomor' => 73, 'nama' => 'Al-Muzzammil', 'nama_arab' => 'المزمل', 'jumlah_ayat' => 20],
            ['nomor' => 74, 'nama' => 'Al-Muddatstsir', 'nama_arab' => 'المدثر', 'jumlah_ayat' => 56],
            ['nomor' => 75, 'nama' => 'Al-Qiyamah', 'nama_arab' => 'القيامة', 'jumlah_ayat' => 40],
            ['nomor' => 76, 'nama' => 'Al-Insan', 'nama_arab' => 'الانسان', 'jumlah_ayat' => 31],
            ['nomor' => 77, 'nama' => 'Al-Mursalat', 'nama_arab' => 'المرسلات', 'jumlah_ayat' => 50],
            ['nomor' => 78, 'nama' => 'An-Naba', 'nama_arab' => 'النبأ', 'jumlah_ayat' => 40],
            ['nomor' => 79, 'nama' => 'An-Nazi\'at', 'nama_arab' => 'النازعات', 'jumlah_ayat' => 46],
            ['nomor' => 80, 'nama' => 'Abasa', 'nama_arab' => 'عبس', 'jumlah_ayat' => 42],
            ['nomor' => 81, 'nama' => 'At-Takwir', 'nama_arab' => 'التكوير', 'jumlah_ayat' => 29],
            ['nomor' => 82, 'nama' => 'Al-Infitar', 'nama_arab' => 'الإنفطار', 'jumlah_ayat' => 19],
            ['nomor' => 83, 'nama' => 'Al-Mutaffifin', 'nama_arab' => 'المطففين', 'jumlah_ayat' => 36],
            ['nomor' => 84, 'nama' => 'Al-Insyiqaq', 'nama_arab' => 'الإنشقاق', 'jumlah_ayat' => 25],
            ['nomor' => 85, 'nama' => 'Al-Buruj', 'nama_arab' => 'البروج', 'jumlah_ayat' => 22],
            ['nomor' => 86, 'nama' => 'At-Tariq', 'nama_arab' => 'الطارق', 'jumlah_ayat' => 17],
            ['nomor' => 87, 'nama' => 'Al-A\'la', 'nama_arab' => 'الأعلى', 'jumlah_ayat' => 19],
            ['nomor' => 88, 'nama' => 'Al-Ghasyiyah', 'nama_arab' => 'الغاشية', 'jumlah_ayat' => 26],
            ['nomor' => 89, 'nama' => 'Al-Fajr', 'nama_arab' => 'الفجر', 'jumlah_ayat' => 30],
            ['nomor' => 90, 'nama' => 'Al-Balad', 'nama_arab' => 'البلد', 'jumlah_ayat' => 20],
            ['nomor' => 91, 'nama' => 'Asy-Syams', 'nama_arab' => 'الشمس', 'jumlah_ayat' => 15],
            ['nomor' => 92, 'nama' => 'Al-Lail', 'nama_arab' => 'الليل', 'jumlah_ayat' => 21],
            ['nomor' => 93, 'nama' => 'Ad-Dhuha', 'nama_arab' => 'الضحى', 'jumlah_ayat' => 11],
            ['nomor' => 94, 'nama' => 'Asy-Syarh', 'nama_arab' => 'الشرح', 'jumlah_ayat' => 8],
            ['nomor' => 95, 'nama' => 'At-Tin', 'nama_arab' => 'التين', 'jumlah_ayat' => 8],
            ['nomor' => 96, 'nama' => 'Al-Alaq', 'nama_arab' => 'العلق', 'jumlah_ayat' => 19],
            ['nomor' => 97, 'nama' => 'Al-Qadr', 'nama_arab' => 'القدر', 'jumlah_ayat' => 5],
            ['nomor' => 98, 'nama' => 'Al-Bayyinah', 'nama_arab' => 'البينة', 'jumlah_ayat' => 8],
            ['nomor' => 99, 'nama' => 'Az-Zalzalah', 'nama_arab' => 'الزلزلة', 'jumlah_ayat' => 8],
            ['nomor' => 100, 'nama' => 'Al-Adiyat', 'nama_arab' => 'العاديات', 'jumlah_ayat' => 11],
            ['nomor' => 101, 'nama' => 'Al-Qari\'ah', 'nama_arab' => 'القارعة', 'jumlah_ayat' => 11],
            ['nomor' => 102, 'nama' => 'At-Takatsur', 'nama_arab' => 'التكاثر', 'jumlah_ayat' => 8],
            ['nomor' => 103, 'nama' => 'Al-Asr', 'nama_arab' => 'العصر', 'jumlah_ayat' => 3],
            ['nomor' => 104, 'nama' => 'Al-Humazah', 'nama_arab' => 'الهمزة', 'jumlah_ayat' => 9],
            ['nomor' => 105, 'nama' => 'Al-Fil', 'nama_arab' => 'الفيل', 'jumlah_ayat' => 5],
            ['nomor' => 106, 'nama' => 'Quraisy', 'nama_arab' => 'قريش', 'jumlah_ayat' => 4],
            ['nomor' => 107, 'nama' => 'Al-Ma\'un', 'nama_arab' => 'الماعون', 'jumlah_ayat' => 7],
            ['nomor' => 108, 'nama' => 'Al-Kautsar', 'nama_arab' => 'الكوثر', 'jumlah_ayat' => 3],
            ['nomor' => 109, 'nama' => 'Al-Kafirun', 'nama_arab' => 'الكافرون', 'jumlah_ayat' => 6],
            ['nomor' => 110, 'nama' => 'An-Nasr', 'nama_arab' => 'النصر', 'jumlah_ayat' => 3],
            ['nomor' => 111, 'nama' => 'Al-Lahab', 'nama_arab' => 'اللهب', 'jumlah_ayat' => 5],
            ['nomor' => 112, 'nama' => 'Al-Ikhlas', 'nama_arab' => 'الإخلاص', 'jumlah_ayat' => 4],
            ['nomor' => 113, 'nama' => 'Al-Falaq', 'nama_arab' => 'الفلق', 'jumlah_ayat' => 5],
            ['nomor' => 114, 'nama' => 'An-Nas', 'nama_arab' => 'الناس', 'jumlah_ayat' => 6],
        ];

        // Insert/Update semua surah (Aman dari duplikat)
        foreach ($surahs as $surahData) {
            Surah::updateOrCreate(['nomor' => $surahData['nomor']], $surahData);
        }

        // === AYAT-AYAT ===

        // Al-Fatihah (Surah 1)
        $surah = Surah::find(1);
        $ayats = [
            ['nomor_ayat' => 1, 'teks_arab' => 'بِسْمِ اللَّهِ الرَّحْمَٰنِ الرَّحِيمِ', 'transliterasi' => 'Bismillahirrahmanirrahim', 'terjemahan' => 'Dengan nama Allah Yang Maha Pengasih, Maha Penyayang.'],
            ['nomor_ayat' => 2, 'teks_arab' => 'الْحَمْدُ لِلَّهِ رَبِّ الْعَالَمِينَ', 'transliterasi' => 'Alhamdu lillahi rabbil \'alamin', 'terjemahan' => 'Segala puji bagi Allah, Tuhan seluruh alam,'],
            ['nomor_ayat' => 3, 'teks_arab' => 'الرَّحْمَٰنِ الرَّحِيمِ', 'transliterasi' => 'Ar-Rahmanir-Rahim', 'terjemahan' => 'Yang Maha Pengasih, Maha Penyayang,'],
            ['nomor_ayat' => 4, 'teks_arab' => 'مَالِكِ يَوْمِ الدِّينِ', 'transliterasi' => 'Maliki yawmid-din', 'terjemahan' => 'Pemilik hari pembalasan.'],
            ['nomor_ayat' => 5, 'teks_arab' => 'إِيَّاكَ نَعْبُدُ وَإِيَّاكَ نَسْتَعِينُ', 'transliterasi' => 'Iyyaka na\'budu wa iyyaka nasta\'in', 'terjemahan' => 'Hanya kepada Engkaulah kami menyembah dan hanya kepada Engkaulah kami mohon pertolongan.'],
            ['nomor_ayat' => 6, 'teks_arab' => 'اهْدِنَا الصِّرَاطَ الْمُسْتَقِيمَ', 'transliterasi' => 'Ihdinas-siratal-mustaqim', 'terjemahan' => 'Tunjukilah kami jalan yang lurus,'],
            ['nomor_ayat' => 7, 'teks_arab' => 'صِرَاطَ الَّذِينَ أَنْعَمْتَ عَلَيْهِمْ غَيْرِ الْمَغْضُوبِ عَلَيْهِمْ وَلَا الضَّالِّينَ', 'transliterasi' => 'Siratal-ladzina an\'amta \'alaihim ghairil-maghdubi \'alaihim wa lad-dallin', 'terjemahan' => '(yaitu) jalan orang-orang yang telah Engkau beri nikmat kepadanya; bukan (jalan) mereka yang dimurkai, dan bukan (pula jalan) mereka yang sesat.'],
        ];
        foreach ($ayats as $ayat) {
            $surah->ayats()->updateOrCreate(['nomor_ayat' => $ayat['nomor_ayat']], $ayat);
        }

        // Al-Ikhlas (Surah 112)
        $surah = Surah::find(112);
        $ayats = [
            ['nomor_ayat' => 1, 'teks_arab' => 'قُلْ هُوَ اللَّهُ أَحَدٌ', 'transliterasi' => 'Qul huwallahu ahad', 'terjemahan' => 'Katakanlah (Muhammad), "Dialah Allah, Yang Maha Esa.'],
            ['nomor_ayat' => 2, 'teks_arab' => 'اللَّهُ الصَّمَدُ', 'transliterasi' => 'Allahus-samad', 'terjemahan' => 'Allah tempat meminta segala sesuatu.'],
            ['nomor_ayat' => 3, 'teks_arab' => 'لَمْ يَلِدْ وَلَمْ يُولَدْ', 'transliterasi' => 'Lam yalid wa lam yulad', 'terjemahan' => '(Allah) tidak beranak dan tidak pula diperanakkan.'],
            ['nomor_ayat' => 4, 'teks_arab' => 'وَلَمْ يَكُنْ لَهُ كُفُوًا أَحَدٌ', 'transliterasi' => 'Wa lam yakul-lahu kufuwan ahad', 'terjemahan' => 'Dan tidak ada sesuatu yang setara dengan-Nya.'],
        ];
        foreach ($ayats as $ayat) {
            $surah->ayats()->updateOrCreate(['nomor_ayat' => $ayat['nomor_ayat']], $ayat);
        }

        // Al-Falaq (Surah 113)
        $surah = Surah::find(113);
        $ayats = [
            ['nomor_ayat' => 1, 'teks_arab' => 'قُلْ أَعُوذُ بِرَبِّ الْفَلَقِ', 'transliterasi' => 'Qul a\'udzu birabbil-falaq', 'terjemahan' => 'Katakanlah, "Aku berlindung kepada Tuhan yang menguasai subuh,'],
            ['nomor_ayat' => 2, 'teks_arab' => 'مِنْ شَرِّ مَا خَلَقَ', 'transliterasi' => 'Min sharri ma khalaq', 'terjemahan' => 'dari kejahatan (makhluk yang) Dia ciptakan,'],
            ['nomor_ayat' => 3, 'teks_arab' => 'وَمِنْ شَرِّ غَاسِقٍ إِذَا وَقَبَ', 'transliterasi' => 'Wa min sharri ghasiqin idha waqab', 'terjemahan' => 'dan dari kejahatan malam apabila telah gelap gulita,'],
            ['nomor_ayat' => 4, 'teks_arab' => 'وَمِنْ شَرِّ النَّفَّاثَاتِ فِي الْعُقَدِ', 'transliterasi' => 'Wa min sharrin-naffatsati fil-\'uqad', 'terjemahan' => 'dan dari kejahatan (perempuan-perempuan penyihir) yang meniup pada buhul-buhul (talinya),'],
            ['nomor_ayat' => 5, 'teks_arab' => 'وَمِنْ شَرِّ حَاسِدٍ إِذَا حَسَدَ', 'transliterasi' => 'Wa min sharri hasidin idha hasad', 'terjemahan' => 'dan dari kejahatan orang yang dengki apabila dia dengki.'],
        ];
        foreach ($ayats as $ayat) {
            $surah->ayats()->updateOrCreate(['nomor_ayat' => $ayat['nomor_ayat']], $ayat);
        }

        // An-Nas (Surah 114)
        $surah = Surah::find(114);
        $ayats = [
            ['nomor_ayat' => 1, 'teks_arab' => 'قُلْ أَعُوذُ بِرَبِّ النَّاسِ', 'transliterasi' => 'Qul a\'udzu birabbin-nas', 'terjemahan' => 'Katakanlah, "Aku berlindung kepada Tuhannya manusia,'],
            ['nomor_ayat' => 2, 'teks_arab' => 'مَلِكِ النَّاسِ', 'transliterasi' => 'Malikin-nas', 'terjemahan' => 'Raja manusia,'],
            ['nomor_ayat' => 3, 'teks_arab' => 'إِلَٰهِ النَّاسِ', 'transliterasi' => 'Ilahin-nas', 'terjemahan' => 'sembahan manusia,'],
            ['nomor_ayat' => 4, 'teks_arab' => 'مِنْ شَرِّ الْوَسْوَاسِ الْخَنَّاسِ', 'transliterasi' => 'Min sharril-waswasil-khannas', 'terjemahan' => 'dari kejahatan (bisikan) setan yang bersembunyi,'],
            ['nomor_ayat' => 5, 'teks_arab' => 'الَّذِي يُوَسْوِسُ فِي صُدُورِ النَّاسِ', 'transliterasi' => 'Alladzi yuwaswisu fi sudurin-nas', 'terjemahan' => 'yang membisikkan (kejahatan) ke dalam dada manusia,'],
            ['nomor_ayat' => 6, 'teks_arab' => 'مِنَ الْجِنَّةِ وَالنَّاسِ', 'transliterasi' => 'Minal-jinnati wan-nas', 'terjemahan' => 'dari (golongan) jin dan manusia.'],
        ];
        foreach ($ayats as $ayat) {
            $surah->ayats()->updateOrCreate(['nomor_ayat' => $ayat['nomor_ayat']], $ayat);
        }
    }
}
