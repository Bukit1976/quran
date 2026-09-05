<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DoaController extends Controller
{
    public function index()
    {
        $doas = [
            [
                'id' => 1,
                'judul' => 'Doa Setelah Sholat Fardhu (Lengkap)',
                'arab' => 'اَسْتَغْفِرُ اللهَ الْعَظِيْمَ الَّذِيْ لَا اِلٰهَ اِلَّا هُوَ الْحَيُّ الْقَيُّوْمُ وَاَتُوْبُ اِلَيْهِ تَوْبَةَ عَبْدٍ ظَالِمٍ لَانَفْسَ لَهٗ ضَرًّاوَلَانَفْعًا وَلَا مَوْتًا وَلَا حَيٰوةً وَلَا نُشُوْرًا. اَللّٰهُمَّ اَنْتَ السَّلَامُ وَمِنْكَ السَّلَامُ تَبَارَكْتَ يَا ذَالْجَلَالِ وَالْاِكْرَامِ. اَللّٰهُمَّ اَعِنِّيْ عَلٰى ذِكْرِكَ وَشُكْرِكَ وَحُسْنِ عِبَادَتِكَ. اَللّٰهُمَّ اِنِّيْ اَسْئَلُكَ سَلَامَةً فِى الدِّيْنِ وَعَافِيَةً فِى الْجَسَدِ وَزِيَادَةً فِى الْعِلْمِ وَبَرَكَةً فِى الرِّزْقِ وَتَوْبَةً قَبْلَ الْمَوْتِ وَرَحْمَةً عِنْدَ الْمَوْتِ وَمَغْفِرَةً بَعْدَ الْمَوْتِ. اَللّٰهُمَّ هَوِّنْ عَلَيْنَا سَكَرَاتِ الْمَوْتِ وَنَجِّنَا مِنْ عَذَابِ الْقَبْرِ وَفِتْنَتِهِ. اَللّٰهُمَّ اِنَّا نَعُوْذُ بِكَ مِنْ عَذَابِ النَّارِ وَفِتْنَةِ الْقَبْرِ. رَبَّنَا لَا تُزِغْ قُلُوْبَنَا بَعْدَ اِذْ هَدَيْتَنَا وَهَبْ لَنَا مِنْ لَّدُنْكَ رَحْمَةً اِنَّكَ اَنْتَ الْوَهَّابُ. رَبَّنَا اِنَّنَا سَمِعْنَا مُنَادِيًا يُنَادِيْ لِلْاِيْمَانِ اَنْ اٰمِنُوْا بِرَبِّكُمْ فَاٰمَنَّا رَبَّنَا فَاغْفِرْلَنَا ذُنُوْبَنَا وَكَفِّرْ عَنَّا سَيِّاٰتِنَا وَتَوَفَّنَا مَعَ الْاَبْرَارِ. رَبَّنَا وَاٰتِنَا مَاوَعَدْتَّنَا عَلٰى رُسُلِكَ وَلَا تُخْزِنَا يَوْمَ الْقِيٰمَةِ اِنَّكَ لَا تُخْلِفُ الْمِيْعَادَ.',
                'latin' => 'Astaghfirullāhal-ʿaẓīmal-lażī lā ilāha illā huwal-ḥayyul-qayyūmu wa atūbu ilaihi taubata ʿabdin ẓālimil lā yanfaʿu linafsihī arran wa lā yanfaʿu wa lā mautan wa lā ḥayātan wa lā nushūrā. Allāhumma antas-salāmu wa minkas-salām, tabārakta yā żal-jalāli wal-ikrām. Allāhumma ainnī ʿalā żikrika wa syukrika wa ḥusni ʿibādatik. Allāhumma innī as-aluka salāmatan fid-dīn, wa ʿāfiyatan fil-jasad, wa ziyādatan fil-ʿilm, wa barakatan fir-rizq, wa taubatan qablal-maut, wa raḥmatan ʿindal-maut, wa maghfiratan baʿdal-maut. Allāhumma hawwin ʿalainā sakarātil-maut wa najjinā min ʿażābil-qabri wa fitnatihi. Allāhumma innā naʿūżu bika min ʿażābin-nāri wa fitnatil-qabr. Rabbanā lā tuzigh qulūbanā baʿda iż hadaitanā wa hab lanā mil ladunka raḥmah, innaka antal-wahhāb. Rabbanā innanā samiʿnā munādiyan yunādi lil-īmāni an āminū birabbikum fa āmannā, rabbanā faghfirlanā żunūbanā wa kaffir ʿannā sayyi-ātinā wa tawaffanā maʿal-abrār. Rabbanā wa ātinā mā waʿadtanā ʿalā rusulika wa lā tukhzinā yaumal-qiyāmah, innaka lā tukhliful-mīʿād.',
                'arti' => 'Aku memohon ampun kepada Allah Yang Maha Agung, yang tidak ada tuhan selain Dia, Yang Maha Hidup dan Maha Berdiri Sendiri, dan aku bertaubat kepada-Nya dengan taubanya hamba yang zalim, yang tidak memiliki manfaat dan mudarat, tidak bisa hidup dan mati, dan tidak bisa bangkit. Ya Allah, Engkau adalah Dzat Yang Maha Sejahtera dan dari-Mu kesejahteraan, Maha Berkah Engkau, wahai Dzat Yang Maha Agung dan Maha Mulia. Ya Allah, tolonglah aku untuk mengingat-Mu, bersyukur kepada-Mu, dan beribadah dengan baik kepada-Mu. Ya Allah, sesungguhnya aku memohon kepada-Mu keselamatan dalam agama, kesehatan pada tubuh, penambahan ilmu, keberkahan rezeki, taubat sebelum mati, rahmat saat mati, dan ampunan setelah mati. Ya Allah, mudahkanlah kami saat sakaratul maut dan selamatkanlah kami dari azab kubur dan fitnahnya. Ya Allah, sesungguhnya kami berlindung kepada-Mu dari azab neraka dan fitnah kubur. Ya Tuhan kami, janganlah Engkau palingkan hati kami setelah Engkau beri petunjuk, dan karuniakanlah kepada kami rahmat dari sisi-Mu, sesungguhnya Engkau Maha Pemberi. Ya Tuhan kami, sesungguhnya kami mendengar penyeru yang menyeru kepada iman: berimanlah kamu kepada Tuhanmu, maka kami pun beriman. Ya Tuhan kami, ampunilah dosa-dosa kami, hapuskanlah kesalahan-kesalahan kami, dan wafatkanlah kami bersama orang-orang yang shalih. Ya Tuhan kami, berikanlah kepada kami apa yang Engkau janjikan kepada kami melalui rasul-rasul-Mu, dan janganlah Engkau hinakan kami pada hari kiamat, sesungguhnya Engkau tidak pernah mengingkari janji.',
            ],
            [
                'id' => 2,
                'judul' => 'Doa Setelah Sholat Tarawih',
                'arab' => 'اَللّٰهُمَّ اجْعَلْنَا بِالْاِيْمَانِ كَامِلِيْنَ. وَلِفَرَآئِضِكَ مُؤَدِّيْنَ. وَلِلصَّلَاةِ حَافِظِيْنَ. وَلِلزَّكَاةِ فَاعِلِيْنَ. وَلِمَاعِنْدَكَ طَالِبِيْنَ. وَلِعَفْوِكَ رَاجِيْنَ. وَبِالْهُدَى مُتَمَسِّكِيْنَ. وَعَنِ الَّلغْوِ مُعْرِضِيْنَ. وَفِى الدُّنْيَا زَاهِدِيْنَ. وَفِى الْاٰخِرَةِ رَاغِبِيْنَ. وَبِالْقَضَآءِ رَاضِيْنَ. وَلِلنَّعْمَآءِ شَاكِرِيْنَ. وَعَلَى الْبَلَاءِ صَابِرِيْنَ. وَتَحْتَ لِوَاءِ مُحَمَّدٍ صَلَّى اللهُ عَلَيْهِ وَسَلَّمَ يَوْمَ الْقِيَامَةِ سَآئِرِيْنَ. وَاِلَى الْحَوْضِ وَارِدِيْنَ. وَاِلَى الْجَنَّةِ دَاخِلِيْنَ. وَمِنَ النَّارِ خَارِجِيْنَ. وَمِنَ الْقَعْدِ فِى النَّارِ خَالِصِيْنَ. وَعَلٰى سَرِيْرِالْكَرَامَةِ قَاعِدِيْنَ. وَمِنْ حُوْرٍعِيْنٍ مُتَزَوِّجِيْنَ. وَمِنْ سُنْدُسٍ وَاِسْتَبْرَقٍ وَدِيْبَاجٍ مُتَلَبِّسِيْنَ. وَمِنْ طَعَامِ الْجَنَّةِ اٰكِلِيْنَ. وَمِنْ لَبَنٍ وَعَسَلٍ مُصَفًّى شَارِبِيْنَ. بِاَكْوَابٍ وَّاَبَارِيْقَ وَكَأْسٍ مِّنْ مَّعِيْنٍ. مَعَ الَّذِيْنَ اَنْعَمْتَ عَلَيْهِمْ مِنَ النَّبِيِّيْنَ وَالصِّدِّيْقِيْنَ وَالشُّهَدَآءِ وَالصَّالِحِيْنَ وَحَسُنَ اُولٰۤىِٕكَ رَفِيْقًا. ذٰلِكَ الْفَضْلُ مِنَ اللّٰهِ ۚوَكَفٰى بِاللّٰهِ عَلِيْمًا.',
                'latin' => 'Allāhumma-jʿalnā bil-īmāni kāmilīn. Wa lifarā-iḍika mu-addīn. Wa liṣ-ṣalāti ḥāfiīn. Wa liz-zakāti fāʿilīn. Wa limā ʿindaka ṭālibīn. Wa liʿafwika rājīn. Wa bil-hudā mutamassikīn. Wa ʿanil-laghwi muʿriḍīn. Wa fid-dunyā zāhidīn. Wa fil-ākhirati rāghibīn. Wa bil-qaḍā-i rāḍīn. Wa lin-naʿmā-i syākirīn. Wa ʿalal-balā-i ṣābirīn. Wa taḥta liwā-i Muammadin ṣallallāhu ʿalaihi wa sallama yaumal-qiyāmati sā-irīn. Wa ilal-auḍi wāridīn. Wa ilal-jannati dākhilīn. Wa minan-nāri khārijīn. Wa minal-qaʿdi fin-nāri khāliṣīn. Wa ʿalā sarīril-karāmati qāʿidīn. Wa min ūrin ʿīnim mutazawwijīn. Wa min sundusin wa istabraqin wa dībājin mutalabbisīn. Wa min ṭaʿāmil-jannati ākilīn. Wa min labanin wa ʿasalin muṣaffan syāribīn. Bi-akwābin wa abārīqa wa kaʾsim mim maʿīn. Maʿal-lażīna anʿamta ʿalaihim minan-nabiyyīna waṣ-ṣiddīqīna wasy-syuhadā-i waṣ-ṣāliḥīn, wa ḥasuna ulā-ika rafīqā. Żālikal-falu minallāh, wa kafā billāhi ʿalīmā.',
                'arti' => 'Ya Allah, jadikanlah kami orang-orang yang sempurna imannya, yang memenuhi kewajiban-kewajiban-Mu, yang memelihara sholat, yang menunaikan zakat, yang mencari apa yang ada di sisi-Mu, yang mengharapkan ampunan-Mu, yang berpegang teguh pada petunjuk, yang berpaling dari kesia-siaan, yang zuhud di dunia, yang menginginkan akhirat, yang ridha dengan ketentuan-Mu, yang bersyukur atas nikmat-Mu, yang sabar atas musibah-Mu, yang berjalan di bawah panji Muhammad SAW pada hari kiamat, yang mendatangi telaga, yang masuk surga, yang keluar dari neraka, yang bersih dari duduk di neraka, yang duduk di atas kursi kemuliaan, yang menikah dengan bidadari, yang mengenakan pakaian dari sutera, yang memakan makanan surga, yang meminum susu dan madu murni dengan gelas, cangkir, dan piala dari mata air yang mengalir, bersama orang-orang yang Engkau beri nikmat dari para nabi, shiddiqin, syuhada, dan shalihin. Mereka itulah teman yang terbaik. Itulah karunia dari Allah, dan cukuplah Allah Yang Maha Mengetahui.',
            ],
            [
                'id' => 3,
                'judul' => 'Doa Witir',
                'arab' => 'اَللّٰهُمَّ اِنَّا نَسْئَلُكَ اِيْمَانًا دَائِمًا، وَنَسْئَلُكَ قَلْبًا خَاشِعًا، وَنَسْئَلُكَ عِلْمًا نَافِعًا، وَنَسْئَلُكَ يَقِيْنًا صَادِقًا، وَنَسْئَلُكَ عَمَلًا صَالِحًا، وَنَسْئَلُكَ دِيْنًا قَيِّمًا، وَنَسْئَلُكَ خَيْرًا كَثِيْرًا، وَنَسْئَلُكَ الْعَفْوَ وَالْعَافِيَةَ، وَنَسْئَلُكَ تَمَامَ الْعَافِيَةِ، وَنَسْئَلُكَ الشُّكْرَ عَلَى الْعَافِيَةِ، وَنَسْئَلُكَ الْغِنَى عَنِ النَّاسِ. اَللّٰهُمَّ رَبَّنَا تَقَبَّلْ مِنَّا صَلَاتَنَا وَصِيَامَنَا وَقِيَامَنَا وَتَخَشُّعَنَا وَتَضَرُّعَنَا وَتَعَبُّدَنَا وَتَمِّمْ تَقْصِيْرَنَا يَا اَللّٰهُ يَااَللّٰهُ يَااَللّٰهُ. يَااَرْحَمَ الرَّاحِمِيْنَ. وَصَلَّى اللهُ عَلٰى خَيْرِ خَلْقِهٖ مُحَمَّدٍ وَّعَلٰى اٰلِهٖ وَصَحْبِهٖ اَجْمَعِيْنَ. وَالْحَمْدُ لِلّٰهِ رَبِّ الْعٰلَمِيْنَ.',
                'latin' => 'Allāhumma innā nas-aluka īmānan dā-imā, wa nas-aluka qalban khāsyiʿā, wa nas-aluka ʿilman nāfiʿā, wa nas-aluka yaqīnan ṣādiqā, wa nas-aluka ʿamalan āliḥā, wa nas-aluka dīnan qayyimā, wa nas-aluka khairan kaṡīrā, wa nas-aluka al-ʿafwa wal-ʿāfiyah, wa nas-aluka tamāmal-ʿāfiyah, wa nas-aluka syukra ʿalal-āfiyah, wa nas-aluka al-ghinā ʿanin-nās. Allāhumma rabbanā taqabbal minnā ṣalātanā wa ṣiyāmanā wa qiyāmanā wa takhasysyuʿanā wa taḍarruʿanā wa taʿabbudanā wa tammim taqīranā yā Allāh yā Allāh yā Allāh. Yā arḥamar-rāḥimīn. Wa ṣallallāhu ʿalā khairi khalqihī Muḥammadin wa ʿalā ālihī wa ṣaḥbihī ajmaʿīn. Wal-ḥamdulillāhi rabbil-ʿālamīn.',
                'arti' => 'Ya Allah, sesungguhnya kami memohon kepada-Mu iman yang langgeng, hati yang khusyu, ilmu yang bermanfaat, keyakinan yang benar, amal yang shalih, agama yang lurus, kebaikan yang banyak. Kami memohon kepada-Mu ampunan dan kesehatan, kesempurnaan kesehatan, bersyukur atas kesehatan, dan kecukupan dari manusia. Ya Allah, Tuhan kami, terimalah dari kami sholat kami, puasa kami, sholat malam kami, kekhusyukan kami, ketundukan kami, ibadah kami, dan sempurnakanlah kekurangan kami, ya Allah, ya Allah, ya Allah. Wahai Dzat Yang Maha Penyayang. Semoga Allah melimpahkan shalawat kepada sebaik-baik makhluk-Nya, Muhammad, beserta keluarga dan para sahabatnya semua. Segala puji bagi Allah Tuhan semesta alam.',
            ],
            [
                'id' => 4,
                'judul' => 'Doa Qunut Subuh',
                'arab' => 'اَللّٰهُمَّ اهْدِنَا فِيْمَنْ هَدَيْتَ. وَعَافِنَا فِيْمَنْ عَافَيْتَ. وَتَوَلَّنَا فِيْمَنْ تَوَلَّيْتَ. وَبَارِكْ لَنَا فِيْمَا اَعْطَيْتَ. وَقِنَا شَرَّمَا قَضَيْتَ. فَاِنَّكَ تَقْضِيْ وَلَا يُقْضٰى عَلَيْكَ. وَاِنَّهٗ لَا يَذِلُّ مَنْ وَالَيْتَ. وَلَا يَعِزُّ مَنْ عَادَيْتَ. تَبٰرَكْتَ رَبَّنَا وَتَعَالَيْتَ. فَلَكَ الْحَمْدُ عَلٰى مَا قَضَيْتَ. وَاَسْتَغْفِرُكَ وَاَتُوْبُ اِلَيْكَ. وَصَلَّى اللّٰهُ عَلٰى سَيِّدِنَا مُحَمَّدٍ النَّبِيِّ الْاُمِّيِّ وَعَلٰى اٰلِهٖ وَصَحْبِهٖ وَسَلَّم.',
                'latin' => 'Allāhumma-hdinā fīman hadait. Wa ʿāfinā fīman ʿāfait. Wa tawallanā fīman tawallait. Wa bārik lanā fīmā aʿṭait. Wa qinā syarra mā qaḍait. Fa innaka taqḍī wa lā yuqḍā ʿalaik. Wa innahū lā yażillu man wālait. Wa lā yaʿizzu man ʿādait. Tabārakta rabbanā wa taʿālait. Falakal-amdu ʿalā mā qaḍait. Wa astaghfiruka wa atūbu ilaik. Wa ṣallallāhu ʿalā sayyidinā Muḥammadinin-nabiyyil-ummiyyi wa ʿalā ālihī wa ṣaḥbihī wa sallam.',
                'arti' => 'Ya Allah, berilah kami petunjuk seperti orang-orang yang telah Engkau beri petunjuk. Berilah kami kesehatan seperti orang-orang yang telah Engkau beri kesehatan. Pimpinlah kami bersama-sama orang-orang yang telah Engkau pimpin. Berilah berkah pada segala apa yang telah Engkau karuniakan kepada kami. Dan peliharalah kami dari kejahatan yang Engkau pastikan. Karena sesungguhnya Engkau-lah yang menentukan dan tidak ada yang menentukan atas Engkau. Sesungguhnya tidak akan hina orang-orang yang telah Engkau beri kekuasaan. Dan tidak akan mulia orang-orang yang Engkau musuhi. Maha Berkahlah Engkau dan Maha Luhurlah Engkau. Segala puji bagi-Mu atas apa yang Engkau pastikan. Kami mohon ampun dan bertaubat kepada-Mu. Semoga Allah memberikan shalawat dan salam kepada junjungan kami Nabi Muhammad SAW yang ummi, beserta keluarga dan para sahabatnya.',
            ],
            [
                'id' => 5,
                'judul' => 'Doa Rebo Wekasan',
                'arab' => 'اَللّٰهُمَّ يَا وَاسِعَ الْفَضْلِ يَا كَرِيْمُ يَا جَلِيْلَ الْقَدْرِ يَا خَافِيَ النِّعَمِ يَا كَاشِفَ النِّقَمِ يَا مَنْ عَيْنُهُ لَا تَنَامُ وَلَا تَسْهُوْ يَا اَرْحَمَ الرَّاحِمِيْنَ. صَلّٰى اللهُ عَلٰى سَيِّدِنَا مُحَمَّدٍ وَعَلٰى اٰلِ سَيِّدِنَا مُحَمَّدٍ. اَللّٰهُمَّ اكْفِنَا شَرَّ هٰذَا الْيَوْمِ وَمَا فِيْهِ. اَللّٰهُمَّ اصْرِفْ عَنَّا شَرَّ مَا خُلِقَ فِيْهِ. اَللّٰهُمَّ رَبَّنَا اَنْزِلْ عَلَيْنَا سَكِيْنَةً وَاَفِضْ عَلَيْنَا رَحْمَةً مِنْكَ وَهَيِّئْ لَنَا مِنْ اَمْرِنَا مِرْفَقًا.',
                'latin' => 'Allāhumma yā wāsiʿal-faḍli yā karīm, yā jalīlal-qadri yā khāfiyan-niam, yā kāsyifan-niqam, yā man ʿainuhū lā tanāmu wa lā tashū, yā arḥamar-rāḥimīn. Ṣallallāhu alā sayyidinā Muḥammadin wa ʿalā āli sayyidinā Muḥammad. Allāhumma-kfinā syarra hāżal-yaumi wa mā fīh. Allāhummaṣrif ʿannā syarra mā khuliqa fīh. Allāhumma rabbanā anzil ʿalainā sakīnatan wa afiḍ ʿalainā raḥmatan minka wa hayyiʾ lanā min amrinā mirfaqā.',
                'arti' => 'Ya Allah, Yang Maha Luas Karunia-Nya, Yang Maha Mulia, Yang Maha Agung Kedudukan-Nya, Yang Menyembunyikan Nikmat, Yang Menyingkapkan Bencana, Yang Mata-Nya tidak tidur dan tidak lupa, Wahai Yang Maha Penyayang di antara para penyayang. Semoga Allah melimpahkan shalawat kepada junjungan kami Muhammad dan keluarga junjungan kami Muhammad. Ya Allah, cukupkanlah kami dari kejahatan hari ini dan apa yang ada di dalamnya. Ya Allah, palingkanlah dari kami kejahatan yang diciptakan di dalamnya. Ya Allah, Tuhan kami, turunkanlah kepada kami ketenangan dan curahkanlah kepada kami rahmat dari-Mu, dan persiapkanlah untuk kami kemudahan dari urusan kami.',
            ],
            [
                'id' => 6,
                'judul' => 'Doa Awal Tahun (1 Muharram)',
                'arab' => 'اَللّٰهُمَّ اَنْتَ الْاَبَدِيُّ الْقَدِيْمُ الْاَوَّلُ، وَعَلَى فَضْلِكَ الْكَبِيْرِ وَكَرِيْمِ جُوْدِكَ الْمُعَوَّلُ، وَهٰذَا عَامٌ جَدِيْدٌ قَدْ اَقْبَلَ، نَسْئَلُكَ الْعِصْمَةَ فِيْهِ مِنَ الشَّيْطَانِ وَاَوْلِيَاىِٕهِ، وَالْعَوْنَ عَلٰى هٰذِهِ النَّفْسِ الْاَمَّارَةِ بِالسُّوْءِ، وَالِاشْتِغَالَ بِمَا يُقَرِّبُنَا اِلَيْكَ زُلْفٰى، يَا ذَالْجَلَالِ وَالْاِكْرَامِ.',
                'latin' => 'Allāhumma antal-abadiyyul-qadīmul-awwal, wa ʿalā faḍlikal-kabīri wa karīmi jūdikal-muawwal, wa hāżā ʿāmun jadīdun qad aqbal, nas-alukal-ʿiṣmata fīhi minasy-syaiṭāni wa auliyā-ih, wal-ʿauna ʿalā hāżihin-nafsil-ammārati bis-sū-i, wal-isytighāla bimā yuqarribunā ilaika zulfā, yā żal-jalāli wal-ikrām.',
                'arti' => 'Ya Allah, Engkaulah Yang Maha Kekal, Yang Maha Dahulu, dan Yang Maha Awal. Atas karunia dan kemurahan-Mu yang besar kami bergantung. Dan ini adalah tahun baru yang telah datang. Kami memohon kepada-Mu perlindungan di dalamnya dari godaan setan dan para walinya, pertolongan untuk menghadapi hawa nafsu yang selalu mendorong kepada kejahatan, dan kesibukan dengan amal yang mendekatkan kami kepada-Mu sedekat-dekatnya, wahai Dzat Yang Maha Agung dan Maha Mulia.',
            ],
            [
                'id' => 7,
                'judul' => 'Doa Tahlil / Kirim Doa untuk Mayit',
                'arab' => 'اَللّٰهُمَّ اغْفِرْ لَهُ وَارْحَمْهُ وَعَافِهِ وَاعْفُ عَنْهُ وَاَكْرِمْ نُزُلَهُ وَوَسِّعْ مُدْخَلَهُ وَاغْسِلْهُ بِالْمَاۤءِ وَالثَّلْجِ وَالْبَرَدِ. وَنَقِّهِ مِنَ الْخَطَايَا كَمَا يُنَقَّى الثَّوْبُ الْاَبْيَضُ مِنَ الدَّنَسِ. وَاَبْدِلْهُ دَارًا خَيْرًا مِّنْ دَارِه وَاَهْلًا خَيْرًا مِّنْ اَهْلِهٖ وَزَوْجًا خَيْرًا مِّنْ زَوْجِهٖ. وَاَدْخِلْهُ الْجَنَّةَ وَاَعِذْهُ مِنْ عَذَابِ الْقَبْرِ وَعَذَابِ النَّارِ. اَللّٰهُمَّ اجْعَلْ قَبْرَهٗ رَوْضَةً مِّنْ رِيَاضِ الْجَنَّةِ وَلَا تَجْعَلْهُ حُفْرَةً مِّنْ حُفَرِ النَّارِ.',
                'latin' => 'Allāhummaghfir lahū warḥamhu wa ʿāfihī waʿfu anhu, wa akrim nuzulahū, wa wassiʿ mudkhalahū, waghsil-hu bil-mā-i wa-ṡalji wal-barad. Wa naqqihi minal-khaṭā-yā kamā yunaqqaṡ-aubul-abyaḍu minad-danas. Wa abdil-hu dāran khairam min dārihī wa ahlan khairam min ahlihī wa zaujan khairam min zaujih. Wa adkhilhul-jannata wa aʿiż-hu min ʿażābil-qabri wa ʿażābin-nār. Allāhumma-jʿal qabrahu rauḍatam min riyāḍil-jannati wa lā tajʿal-hu hufratam min ḥufarin-nār.',
                'arti' => 'Ya Allah, ampunilah dia, rahmatilah dia, sejahterakanlah dia, maafkanlah dia, muliakanlah tempat tinggalnya, luaskanlah tempat masuknya, mandikanlah dia dengan air, salju, dan embun. Bersihkanlah dia dari kesalahan-kesalahan sebagaimana dibersihkannya kain putih dari kotoran. Gantikanlah dia dengan rumah yang lebih baik dari rumahnya, keluarga yang lebih baik dari keluarganya, dan pasangan yang lebih baik dari pasangannya. Masukkanlah dia ke dalam surga dan lindungilah dia dari azab kubur dan azab neraka. Ya Allah, jadikanlah kuburnya sebagai taman dari taman-taman surga, dan janganlah Engkau jadikan kuburnya sebagai lubang dari lubang-lubang neraka.',
            ],
            [
                'id' => 8,
                'judul' => 'Doa Sapu Jagat (Rabbana Atina)',
                'arab' => 'رَبَّنَآ اٰتِنَا فِى الدُّنْيَا حَسَنَةً وَّفِى الْاٰخِرَةِ حَسَنَةً وَّقِنَا عَذَابَ النَّارِ',
                'latin' => 'Rabbanā ātinā fid-dunyā ḥasanatan wa fil-ākhirati ḥasanatan wa qinā ʿażāban-nār.',
                'arti' => 'Ya Tuhan kami, berilah kami kebaikan di dunia dan kebaikan di akhirat, dan lindungilah kami dari azab neraka.',
            ],
            [
                'id' => 9,
                'judul' => 'Doa Sebelum Tidur',
                'arab' => 'بِاسْمِكَ اللّٰهُمَّ اَحْيَا وَاَمُوْتُ',
                'latin' => 'Bismikallāhumma aḥyā wa amūt.',
                'arti' => 'Dengan menyebut nama-Mu ya Allah, aku hidup dan aku mati.',
            ],
            [
                'id' => 10,
                'judul' => 'Doa Bangun Tidur',
                'arab' => 'اَلْحَمْدُ لِلّٰهِ الَّذِيْ اَحْيَانَا بَعْدَ مَآ اَمَاتَنَا وَاِلَيْهِ النُّشُوْرُ',
                'latin' => 'Alḥamdulillāhil-lażī aḥyānā baʿda mā amātanā wa ilaihin-nusyūr.',
                'arti' => 'Segala puji bagi Allah yang telah menghidupkan kami setelah mematikan kami, dan hanya kepada-Nya kami dikembalikan.',
            ],
            [
                'id' => 11,
                'judul' => 'Doa Masuk Rumah',
                'arab' => 'اَللّٰهُمَّ اِنِّىْ اَسْأَلُكَ خَيْرَ الْمَوْلِجِ وَخَيْرَ الْمَخْرَجِ بِسْمِ اللّٰهِ وَلَجْنَا وَبِسْمِ اللّٰهِ خَرَجْنَا وَعَلَى اللّٰهِ رَبِّنَا تَوَكَّلْنَا',
                'latin' => 'Allāhumma innī as-aluka khairal-mauliji wa khairal-makhraji, bismillāhi walajnā, wa bismillāhi kharajnā, wa ʿalallāhi rabbinā tawakkalnā.',
                'arti' => 'Ya Allah, sesungguhnya aku memohon kepada-Mu kebaikan tempat masuk dan kebaikan tempat keluar. Dengan nama Allah kami masuk, dan dengan nama Allah kami keluar, dan kepada Allah Tuhan kami, kami bertawakkal.',
            ],
            [
                'id' => 12,
                'judul' => 'Doa Keluar Rumah',
                'arab' => 'بِسْمِ اللّٰهِ تَوَكَّلْتُ عَلَى اللّٰهِ لَا حَوْلَ وَلَا قُوَّةَ اِلَّا بِاللّٰهِ الْعَلِيِّ الْعَظِيْمِ',
                'latin' => 'Bismillāhi tawakkaltu ʿalallāh, lā ḥaula wa lā quwwata illā billāhil-ʿaliyyil-ʿaẓīm.',
                'arti' => 'Dengan nama Allah aku bertawakkal kepada Allah, tidak ada daya dan kekuatan kecuali dengan pertolongan Allah Yang Maha Tinggi lagi Maha Agung.',
            ],
            [
                'id' => 13,
                'judul' => 'Doa Makan',
                'arab' => 'اَللّٰهُمَّ بَارِكْ لَنَا فِيْمَا رَزَقْتَنَا وَقِنَا عَذَابَ النَّارِ',
                'latin' => 'Allāhumma bārik lanā fīmā razaqtanā wa qinā ʿażāban-nār.',
                'arti' => 'Ya Allah, berkahilah kami dalam rezeki yang telah Engkau berikan kepada kami dan peliharalah kami dari azab neraka.',
            ],
            [
                'id' => 14,
                'judul' => 'Doa Setelah Makan',
                'arab' => 'اَلْحَمْدُ لِلّٰهِ الَّذِيْ اَطْعَمَنَا وَسَقَانَا وَجَعَلَنَا مِنَ الْمُسْلِمِيْنَ',
                'latin' => 'Alḥamdulillāhil-lażī aṭʿamanā wa saqānā wa jaʿalanā minal-muslimīn.',
                'arti' => 'Segala puji bagi Allah yang telah memberi makan dan minum kepada kami, dan menjadikan kami termasuk orang-orang Muslim.',
            ],
            [
                'id' => 15,
                'judul' => 'Doa Masuk Masjid',
                'arab' => 'اَللّٰهُمَّ افْتَحْ لِيْ اَبْوَابَ رَحْمَتِكَ',
                'latin' => 'Allāhumma-fta lī abwāba raḥmatik.',
                'arti' => 'Ya Allah, bukakanlah untukku pintu-pintu rahmat-Mu.',
            ],
            [
                'id' => 16,
                'judul' => 'Doa Keluar Masjid',
                'arab' => 'اَللّٰهُمَّ اِنِّيْ اَسْئَلُكَ مِنْ فَضْلِكَ',
                'latin' => 'Allāhumma innī as-aluka min falik.',
                'arti' => 'Ya Allah, sesungguhnya aku memohon kepada-Mu dari karunia-Mu.',
            ],
            [
                'id' => 17,
                'judul' => 'Doa Belajar',
                'arab' => 'رَبِّ زِدْنِيْ عِلْمًا وَّارْزُقْنِيْ فَهْمًا',
                'latin' => 'Rabbi zidnī ʿilman warzuqnī fahmā.',
                'arti' => 'Ya Tuhanku, tambahkanlah aku ilmu dan berilah aku rezeki akan kepahaman.',
            ],
            [
                'id' => 18,
                'judul' => 'Doa Sebelum Belajar',
                'arab' => 'يَا رَبِّ اشْرَحْ لِيْ صَدْرِيْ وَيَسِّرْ لِيْٓ اَمْرِيْ',
                'latin' => 'Yā rabbisyra lī ṣadrī wa yassir lī amrī.',
                'arti' => 'Ya Tuhanku, lapangkanlah dadaku dan mudahkanlah urusanku.',
            ],
            [
                'id' => 19,
                'judul' => 'Doa Mohon Kesabaran',
                'arab' => 'رَبَّنَآ اَفْرِغْ عَلَيْنَا صَبْرًا وَتَوَفَّنَا مُسْلِمِيْنَ',
                'latin' => 'Rabbanā afrigh ʿalainā ṣabraw wa tawaffanā muslimīn.',
                'arti' => 'Ya Tuhan kami, limpahkanlah kesabaran kepada kami dan matikanlah kami dalam keadaan Muslim.',
            ],
            [
                'id' => 20,
                'judul' => 'Doa Mohon Ampunan',
                'arab' => 'رَبَّنَا ظَلَمْنَآ اَنْفُسَنَا وَاِنْ لَّمْ تَغْفِرْ لَنَا وَتَرْحَمْنَا لَنَكُوْنَنَّ مِنَ الْخٰسِرِيْنَ',
                'latin' => 'Rabbanā ẓalamnā anfusanā wa il lam taghfir lanā wa tarḥamnā lanakūnanna minal-khāsirīn.',
                'arti' => 'Ya Tuhan kami, kami telah menzalimi diri kami sendiri. Jika Engkau tidak mengampuni kami dan memberi rahmat kepada kami, niscaya kami termasuk orang-orang yang rugi.',
            ]
        ];

        return view('doa.index', compact('doas'));
    }
}
