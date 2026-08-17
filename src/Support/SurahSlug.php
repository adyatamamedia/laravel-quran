<?php

namespace Adyatama\Adyatama\Quran\Support;

class SurahSlug
{
    protected static array $surahs = [
        1   => ['slug' => 'al-fatihah', 'latin' => 'Al-Fātiḥah', 'arabic' => 'الفاتحة', 'translation' => 'Pembukaan', 'revelation' => 'Makkiyah', 'count' => 7],
        2   => ['slug' => 'al-baqarah', 'latin' => 'Al-Baqarah', 'arabic' => 'البقرة', 'translation' => 'Sapi Betina', 'revelation' => 'Madaniyah', 'count' => 286],
        3   => ['slug' => 'ali-imran', 'latin' => 'Āli ‘Imrān', 'arabic' => 'آل عمران', 'translation' => 'Keluarga Imran', 'revelation' => 'Madaniyah', 'count' => 200],
        4   => ['slug' => 'an-nisa', 'latin' => 'An-Nisā\'', 'arabic' => 'النساء', 'translation' => 'Wanita', 'revelation' => 'Madaniyah', 'count' => 176],
        5   => ['slug' => 'al-maidah', 'latin' => 'Al-Mā\'idah', 'arabic' => 'المائدة', 'translation' => 'Hidangan', 'revelation' => 'Madaniyah', 'count' => 120],
        6   => ['slug' => 'al-anam', 'latin' => 'Al-An‘ām', 'arabic' => 'الأنعام', 'translation' => 'Binatang Ternak', 'revelation' => 'Makkiyah', 'count' => 165],
        7   => ['slug' => 'al-araf', 'latin' => 'Al-A‘rāf', 'arabic' => 'الأعراف', 'translation' => 'Tempat Tertinggi', 'revelation' => 'Makkiyah', 'count' => 206],
        8   => ['slug' => 'al-anfal', 'latin' => 'Al-Anfāl', 'arabic' => 'الأنفال', 'translation' => 'Rampasan Perang', 'revelation' => 'Madaniyah', 'count' => 75],
        9   => ['slug' => 'at-taubah', 'latin' => 'At-Taubah', 'arabic' => 'التوبة', 'translation' => 'Pengampunan', 'revelation' => 'Madaniyah', 'count' => 129],
        10  => ['slug' => 'yunus', 'latin' => 'Yūnus', 'arabic' => 'يونس', 'translation' => 'Nabi Yunus', 'revelation' => 'Makkiyah', 'count' => 109],
        11  => ['slug' => 'hud', 'latin' => 'Hūd', 'arabic' => 'هود', 'translation' => 'Nabi Hud', 'revelation' => 'Makkiyah', 'count' => 123],
        12  => ['slug' => 'yusuf', 'latin' => 'Yūsuf', 'arabic' => 'يوسف', 'translation' => 'Nabi Yusuf', 'revelation' => 'Makkiyah', 'count' => 111],
        13  => ['slug' => 'ar-rad', 'latin' => 'Ar-Ra‘d', 'arabic' => 'الرعد', 'translation' => 'Guruh', 'revelation' => 'Madaniyah', 'count' => 43],
        14  => ['slug' => 'ibrahim', 'latin' => 'Ibrāhīm', 'arabic' => 'إبراهيم', 'translation' => 'Nabi Ibrahim', 'revelation' => 'Makkiyah', 'count' => 52],
        15  => ['slug' => 'al-hijr', 'latin' => 'Al-Ḥijr', 'arabic' => 'الحجر', 'translation' => 'Hizir', 'revelation' => 'Makkiyah', 'count' => 99],
        16  => ['slug' => 'an-nahl', 'latin' => 'An-Naḥl', 'arabic' => 'النحل', 'translation' => 'Lebah', 'revelation' => 'Makkiyah', 'count' => 128],
        17  => ['slug' => 'al-isra', 'latin' => 'Al-Isrā\'', 'arabic' => 'الإسراء', 'translation' => 'Perjalanan Malam', 'revelation' => 'Makkiyah', 'count' => 111],
        18  => ['slug' => 'al-kahf', 'latin' => 'Al-Kahf', 'arabic' => 'الكهف', 'translation' => 'Gua', 'revelation' => 'Makkiyah', 'count' => 110],
        19  => ['slug' => 'maryam', 'latin' => 'Maryam', 'arabic' => 'مريم', 'translation' => 'Maryam', 'revelation' => 'Makkiyah', 'count' => 98],
        20  => ['slug' => 'taha', 'latin' => 'Ṭāhā', 'arabic' => 'طه', 'translation' => 'Taha', 'revelation' => 'Makkiyah', 'count' => 135],
        21  => ['slug' => 'al-anbiya', 'latin' => 'Al-Anbiyā\'', 'arabic' => 'الأنبياء', 'translation' => 'Nabi-Nabi', 'revelation' => 'Makkiyah', 'count' => 112],
        22  => ['slug' => 'al-hajj', 'latin' => 'Al-Ḥajj', 'arabic' => 'Haji', 'revelation' => 'Madaniyah', 'count' => 78],
        23  => ['slug' => 'al-muminun', 'latin' => 'Al-Mu\'minūn', 'arabic' => 'المؤمنون', 'translation' => 'Orang-Orang Mukmin', 'revelation' => 'Makkiyah', 'count' => 118],
        24  => ['slug' => 'an-nur', 'latin' => 'An-Nūr', 'arabic' => 'النور', 'translation' => 'Cahaya', 'revelation' => 'Madaniyah', 'count' => 64],
        25  => ['slug' => 'al-furqan', 'latin' => 'Al-Furqān', 'arabic' => 'الفرقان', 'translation' => 'Pembeda', 'revelation' => 'Makkiyah', 'count' => 77],
        26  => ['slug' => 'ash-shuara', 'latin' => 'Ash-Shu‘arā\'', 'arabic' => 'الشعراء', 'translation' => 'Penyair', 'revelation' => 'Makkiyah', 'count' => 227],
        27  => ['slug' => 'an-naml', 'latin' => 'An-Naml', 'arabic' => 'النمل', 'translation' => 'Semut', 'revelation' => 'Makkiyah', 'count' => 93],
        28  => ['slug' => 'al-qasas', 'latin' => 'Al-Qaṣaṣ', 'arabic' => 'القصص', 'translation' => 'Kisah-Kisah', 'revelation' => 'Makkiyah', 'count' => 88],
        29  => ['slug' => 'al-ankabut', 'latin' => 'Al-‘Ankabūt', 'arabic' => 'العنكبوت', 'translation' => 'Laba-Laba', 'revelation' => 'Makkiyah', 'count' => 69],
        30  => ['slug' => 'ar-rum', 'latin' => 'Ar-Rūm', 'arabic' => 'الروم', 'translation' => 'Bangsa Romawi', 'revelation' => 'Makkiyah', 'count' => 60],
        31  => ['slug' => 'luqman', 'latin' => 'Luqmān', 'arabic' => 'لقمان', 'translation' => 'Luqman', 'revelation' => 'Makkiyah', 'count' => 34],
        32  => ['slug' => 'as-sajdah', 'latin' => 'As-Sajdah', 'arabic' => 'Sajdah', 'translation' => 'Sajdah', 'revelation' => 'Makkiyah', 'count' => 30],
        33  => ['slug' => 'al-ahzab', 'latin' => 'Al-Aḥzāb', 'arabic' => 'الأحزاب', 'translation' => 'Golongan Berserikat', 'revelation' => 'Madaniyah', 'count' => 73],
        34  => ['slug' => 'saba', 'latin' => 'Sabā\'', 'arabic' => 'سبإ', 'translation' => 'Saba\'', 'revelation' => 'Makkiyah', 'count' => 54],
        35  => ['slug' => 'fatir', 'latin' => 'Fāṭir', 'arabic' => 'فاطر', 'translation' => 'Maha Pencipta', 'revelation' => 'Makkiyah', 'count' => 45],
        36  => ['slug' => 'yasin', 'latin' => 'Yāsīn', 'arabic' => 'يس', 'translation' => 'Yasin', 'revelation' => 'Makkiyah', 'count' => 83],
        37  => ['slug' => 'as-saffat', 'latin' => 'As-Ṣāffāt', 'arabic' => 'الصافات', 'translation' => 'Yang Berbaris', 'revelation' => 'Makkiyah', 'count' => 182],
        38  => ['slug' => 'sad', 'latin' => 'Ṣād', 'arabic' => 'ص', 'translation' => 'Sad', 'revelation' => 'Makkiyah', 'count' => 88],
        39  => ['slug' => 'az-zumar', 'latin' => 'Az-Zumar', 'arabic' => 'Zumar', 'translation' => 'Rombongan', 'revelation' => 'Makkiyah', 'count' => 75],
        40  => ['slug' => 'ghafir', 'latin' => 'Ghāfir', 'arabic' => 'غافر', 'translation' => 'Maha Pengampun', 'revelation' => 'Makkiyah', 'count' => 85],
        41  => ['slug' => 'fussilat', 'latin' => 'Fuṣṣilat', 'arabic' => 'فصلت', 'translation' => 'Yang Dijelaskan', 'revelation' => 'Makkiyah', 'count' => 54],
        42  => ['slug' => 'ash-shura', 'latin' => 'Ash-Shūrā', 'arabic' => 'الشورى', 'translation' => 'Musyawarah', 'revelation' => 'Makkiyah', 'count' => 53],
        43  => ['slug' => 'az-zukhruf', 'latin' => 'Az-Zukhruf', 'arabic' => 'الزخرف', 'translation' => 'Perhiasan', 'revelation' => 'Makkiyah', 'count' => 89],
        44  => ['slug' => 'ad-dukhan', 'latin' => 'Ad-Dukhān', 'arabic' => 'الدخان', 'translation' => 'Kabut', 'revelation' => 'Makkiyah', 'count' => 59],
        45  => ['slug' => 'al-jathiyah', 'latin' => 'Al-Jāthiyah', 'arabic' => 'الجاشية', 'translation' => 'Yang Berlutut', 'revelation' => 'Makkiyah', 'count' => 37],
        46  => ['slug' => 'al-ahqaf', 'latin' => 'Al-Aḥqāf', 'arabic' => 'الأحقاف', 'translation' => 'Bukit-Bukit Pasir', 'revelation' => 'Makkiyah', 'count' => 35],
        47  => ['slug' => 'muhammad', 'latin' => 'Muḥammad', 'arabic' => 'محمد', 'translation' => 'Nabi Muhammad', 'revelation' => 'Madaniyah', 'count' => 38],
        48  => ['slug' => 'al-fath', 'latin' => 'Al-Fatḥ', 'arabic' => 'الفتح', 'translation' => 'Kemenangan', 'revelation' => 'Madaniyah', 'count' => 29],
        49  => ['slug' => 'al-hujurat', 'latin' => 'Al-Ḥujurāt', 'arabic' => 'Hujurat', 'translation' => 'Kamar-Kamar', 'revelation' => 'Madaniyah', 'count' => 18],
        50  => ['slug' => 'qaf', 'latin' => 'Qāf', 'arabic' => 'ق', 'translation' => 'Qaf', 'revelation' => 'Makkiyah', 'count' => 45],
        51  => ['slug' => 'adh-dhariyat', 'latin' => 'Adh-Dhāriyāt', 'arabic' => 'الذاريات', 'translation' => 'Angin Yang Menerbangkan', 'revelation' => 'Makkiyah', 'count' => 60],
        52  => ['slug' => 'at-tur', 'latin' => 'At-Ṭūr', 'arabic' => 'الطور', 'translation' => 'Bukit', 'revelation' => 'Makkiyah', 'count' => 49],
        53  => ['slug' => 'an-najm', 'latin' => 'An-Najm', 'arabic' => 'النجم', 'translation' => 'Bintang', 'revelation' => 'Makkiyah', 'count' => 62],
        54  => ['slug' => 'al-qamar', 'latin' => 'Al-Qamar', 'arabic' => 'القمر', 'translation' => 'Bulan', 'revelation' => 'Makkiyah', 'count' => 55],
        55  => ['slug' => 'ar-rahman', 'latin' => 'Ar-Raḥmān', 'arabic' => 'الرحمن', 'translation' => 'Maha Pengasih', 'revelation' => 'Madaniyah', 'count' => 78],
        56  => ['slug' => 'al-waqiah', 'latin' => 'Al-Wāqi‘ah', 'arabic' => 'الواقعة', 'translation' => 'Hari Kiamat', 'revelation' => 'Makkiyah', 'count' => 96],
        57  => ['slug' => 'al-hadid', 'latin' => 'Al-Ḥadīd', 'arabic' => 'الحديد', 'translation' => 'Besi', 'revelation' => 'Madaniyah', 'count' => 29],
        58  => ['slug' => 'al-mujadilah', 'latin' => 'Al-Mujādilah', 'arabic' => 'المجادلة', 'translation' => 'Gugatan', 'revelation' => 'Madaniyah', 'count' => 22],
        59  => ['slug' => 'al-hashr', 'latin' => 'Al-Ḥashr', 'arabic' => 'الحشر', 'translation' => 'Pengusiran', 'revelation' => 'Madaniyah', 'count' => 24],
        60  => ['slug' => 'al-mumtahanah', 'latin' => 'Al-Mumtaḥanah', 'arabic' => 'الممتحنة', 'translation' => 'Wanita Yang Diuji', 'revelation' => 'Madaniyah', 'count' => 13],
        61  => ['slug' => 'as-saff', 'latin' => 'As-Ṣaff', 'arabic' => 'الصف', 'translation' => 'Barisan', 'revelation' => 'Madaniyah', 'count' => 14],
        62  => ['slug' => 'al-jumuah', 'latin' => 'Al-Jumu‘ah', 'arabic' => 'الجمعة', 'translation' => 'Hari Jum\'at', 'revelation' => 'Madaniyah', 'count' => 11],
        63  => ['slug' => 'al-munafiqun', 'latin' => 'Al-Munāfiqūn', 'arabic' => 'المنافقون', 'translation' => 'Orang-Orang Munafik', 'revelation' => 'Madaniyah', 'count' => 11],
        64  => ['slug' => 'at-taghabun', 'latin' => 'At-Taghābun', 'arabic' => 'التغابن', 'translation' => 'Hari Dinampakkan Kesalahan', 'revelation' => 'Madaniyah', 'count' => 18],
        65  => ['slug' => 'at-talaq', 'latin' => 'At-Ṭalāq', 'arabic' => 'الطلاق', 'translation' => 'Talak', 'revelation' => 'Madaniyah', 'count' => 12],
        66  => ['slug' => 'at-tahrim', 'latin' => 'At-Taḥrīm', 'arabic' => 'التحريم', 'translation' => 'Mengharamkan', 'revelation' => 'Madaniyah', 'count' => 12],
        67  => ['slug' => 'al-mulk', 'latin' => 'Al-Mulk', 'arabic' => 'الملك', 'translation' => 'Kerajaan', 'revelation' => 'Makkiyah', 'count' => 30],
        68  => ['slug' => 'al-qalam', 'latin' => 'Al-Qalam', 'arabic' => 'القلم', 'translation' => 'Pena', 'revelation' => 'Makkiyah', 'count' => 52],
        69  => ['slug' => 'al-haqqah', 'latin' => 'Al-Ḥāqqah', 'arabic' => 'الحاقة', 'translation' => 'Hari Kiamat', 'revelation' => 'Makkiyah', 'count' => 52],
        70  => ['slug' => 'al-maarij', 'latin' => 'Al-Ma‘ārij', 'arabic' => 'المعارج', 'translation' => 'Tempat-Tempat Naik', 'revelation' => 'Makkiyah', 'count' => 44],
        71  => ['slug' => 'nuh', 'latin' => 'Nūḥ', 'arabic' => 'نوح', 'translation' => 'Nabi Nuh', 'revelation' => 'Makkiyah', 'count' => 28],
        72  => ['slug' => 'al-jinn', 'latin' => 'Al-Jinn', 'arabic' => 'الجن', 'translation' => 'Jin', 'revelation' => 'Makkiyah', 'count' => 28],
        73  => ['slug' => 'al-muzzammil', 'latin' => 'Al-Muzzammil', 'arabic' => 'المزمل', 'translation' => 'Orang Yang Berselimut', 'revelation' => 'Makkiyah', 'count' => 20],
        74  => ['slug' => 'al-muddaththir', 'latin' => 'Al-Muddaththir', 'arabic' => 'المدثر', 'translation' => 'Orang Yang Berkemul', 'revelation' => 'Makkiyah', 'count' => 56],
        75  => ['slug' => 'al-qiyamah', 'latin' => 'Al-Qiyāmah', 'arabic' => 'القيامة', 'translation' => 'Hari Kiamat', 'revelation' => 'Makkiyah', 'count' => 40],
        76  => ['slug' => 'al-insan', 'latin' => 'Al-Insān', 'arabic' => 'الإنسان', 'translation' => 'Manusia', 'revelation' => 'Madaniyah', 'count' => 31],
        77  => ['slug' => 'al-mursalat', 'latin' => 'Al-Mursalāt', 'arabic' => 'المرسلات', 'translation' => 'Malaikat Yang Diutus', 'revelation' => 'Makkiyah', 'count' => 50],
        78  => ['slug' => 'an-naba', 'latin' => 'An-Nabā\'', 'arabic' => 'النبإ', 'translation' => 'Berita Besar', 'revelation' => 'Makkiyah', 'count' => 40],
        79  => ['slug' => 'an-naziat', 'latin' => 'An-Nāzi‘āt', 'arabic' => 'النازعات', 'translation' => 'Malaikat Yang Mencabut', 'revelation' => 'Makkiyah', 'count' => 46],
        80  => ['slug' => 'abasa', 'latin' => '‘Abasa', 'arabic' => 'عبس', 'translation' => 'Ia Bermuka Masam', 'revelation' => 'Makkiyah', 'count' => 42],
        81  => ['slug' => 'at-takwir', 'latin' => 'At-Takwīr', 'arabic' => 'التكوير', 'translation' => 'Menggulung', 'revelation' => 'Makkiyah', 'count' => 29],
        82  => ['slug' => 'al-infitar', 'latin' => 'Al-Infiṭār', 'arabic' => 'الإنفطار', 'translation' => 'Terbelah', 'revelation' => 'Makkiyah', 'count' => 19],
        83  => ['slug' => 'al-mutaffifin', 'latin' => 'Al-Muṭaffifīn', 'arabic' => 'المطففين', 'translation' => 'Orang-Orang Curang', 'revelation' => 'Makkiyah', 'count' => 36],
        84  => ['slug' => 'al-inshiqaq', 'latin' => 'Al-Inshiqāq', 'arabic' => 'الإنشقاق', 'translation' => 'Terbelah', 'revelation' => 'Makkiyah', 'count' => 25],
        85  => ['slug' => 'al-buruj', 'latin' => 'Al-Burūj', 'arabic' => 'البروج', 'translation' => 'Gugusan Bintang', 'revelation' => 'Makkiyah', 'count' => 22],
        86  => ['slug' => 'at-tariq', 'latin' => 'At-Ṭāriq', 'arabic' => 'الطارق', 'translation' => 'Yang Datang Di Malam Hari', 'revelation' => 'Makkiyah', 'count' => 17],
        87  => ['slug' => 'al-ala', 'latin' => 'Al-A‘lā', 'arabic' => 'الأعلى', 'translation' => 'Maha Tinggi', 'revelation' => 'Makkiyah', 'count' => 19],
        88  => ['slug' => 'al-ghashiyah', 'latin' => 'Al-Ghāshiyah', 'arabic' => 'الغاشية', 'translation' => 'Hari Pembalasan', 'revelation' => 'Makkiyah', 'count' => 26],
        89  => ['slug' => 'al-fajr', 'latin' => 'Al-Fajr', 'arabic' => 'الفجر', 'translation' => 'Fajar', 'revelation' => 'Makkiyah', 'count' => 30],
        90  => ['slug' => 'al-balad', 'latin' => 'Al-Balad', 'arabic' => 'البلد', 'translation' => 'Negeri', 'revelation' => 'Makkiyah', 'count' => 20],
        91  => ['slug' => 'ash-shams', 'latin' => 'Ash-Shams', 'arabic' => 'الشمس', 'translation' => 'Matahari', 'revelation' => 'Makkiyah', 'count' => 15],
        92  => ['slug' => 'al-lail', 'latin' => 'Al-Lail', 'arabic' => 'الليل', 'translation' => 'Malam', 'revelation' => 'Makkiyah', 'count' => 21],
        93  => ['slug' => 'ad-duha', 'latin' => 'Ad-Ḍuḥā', 'arabic' => 'الضحى', 'translation' => 'Waktu Dhuha', 'revelation' => 'Makkiyah', 'count' => 11],
        94  => ['slug' => 'ash-sharh', 'latin' => 'Ash-Sharḥ', 'arabic' => 'الشرح', 'translation' => 'Kelapangan', 'revelation' => 'Makkiyah', 'count' => 8],
        95  => ['slug' => 'at-tin', 'latin' => 'At-Tīn', 'arabic' => 'التين', 'translation' => 'Buah Tin', 'revelation' => 'Makkiyah', 'count' => 8],
        96  => ['slug' => 'al-alaq', 'latin' => 'Al-‘Alaq', 'arabic' => 'العلق', 'translation' => 'Segumpal Darah', 'revelation' => 'Makkiyah', 'count' => 19],
        97  => ['slug' => 'al-qadr', 'latin' => 'Al-Qadr', 'arabic' => 'القدر', 'translation' => 'Kemuliaan', 'revelation' => 'Makkiyah', 'count' => 5],
        98  => ['slug' => 'al-bayyinah', 'latin' => 'Al-Bayyinah', 'arabic' => 'البينة', 'translation' => 'Bukti Nyata', 'revelation' => 'Madaniyah', 'count' => 8],
        99  => ['slug' => 'az-zalzalah', 'latin' => 'Az-Zalzalah', 'arabic' => 'الزلزلة', 'translation' => 'Kegoncangan', 'revelation' => 'Madaniyah', 'count' => 8],
        100 => ['slug' => 'al-adiyat', 'latin' => 'Al-‘Ādiyāt', 'arabic' => 'العاديات', 'translation' => 'Kuda Perang Berlari Kencang', 'revelation' => 'Makkiyah', 'count' => 11],
        101 => ['slug' => 'al-qariah', 'latin' => 'Al-Qāri‘ah', 'arabic' => 'القارعة', 'translation' => 'Hari Kiamat', 'revelation' => 'Makkiyah', 'count' => 11],
        102 => ['slug' => 'at-takathur', 'latin' => 'At-Takāthur', 'arabic' => 'التكاثر', 'translation' => 'Bermegah-Megahan', 'revelation' => 'Makkiyah', 'count' => 8],
        103 => ['slug' => 'al-asr', 'latin' => 'Al-‘Aṣr', 'arabic' => 'العصر', 'translation' => 'Masa/Waktu', 'revelation' => 'Makkiyah', 'count' => 3],
        104 => ['slug' => 'al-humazah', 'latin' => 'Al-Humazah', 'arabic' => 'الهمزة', 'translation' => 'Pengumpat', 'revelation' => 'Makkiyah', 'count' => 9],
        105 => ['slug' => 'al-fil', 'latin' => 'Al-Fīl', 'arabic' => 'الفيل', 'translation' => 'Gajah', 'revelation' => 'Makkiyah', 'count' => 5],
        106 => ['slug' => 'quraish', 'latin' => 'Quraish', 'arabic' => 'قريش', 'translation' => 'Suku Quraisy', 'revelation' => 'Makkiyah', 'count' => 4],
        107 => ['slug' => 'al-maun', 'latin' => 'Al-Mā‘ūn', 'arabic' => 'الماعون', 'translation' => 'Barang-Barang Berguna', 'revelation' => 'Makkiyah', 'count' => 7],
        108 => ['slug' => 'al-kauthar', 'latin' => 'Al-Kauthar', 'arabic' => 'الكوثر', 'translation' => 'Nikmat Yang Banyak', 'revelation' => 'Makkiyah', 'count' => 3],
        109 => ['slug' => 'al-kafirun', 'latin' => 'Al-Kāfirūn', 'arabic' => 'الكافرون', 'translation' => 'Orang-Orang Kafir', 'revelation' => 'Makkiyah', 'count' => 6],
        110 => ['slug' => 'an-nasr', 'latin' => 'An-Naṣr', 'arabic' => 'النصر', 'translation' => 'Pertolongan', 'revelation' => 'Madaniyah', 'count' => 3],
        111 => ['slug' => 'al-lahab', 'latin' => 'Al-Lahab', 'arabic' => 'اللهب', 'translation' => 'Gejolak Api', 'revelation' => 'Makkiyah', 'count' => 5],
        112 => ['slug' => 'al-ikhlas', 'latin' => 'Al-Ikhlāṣ', 'arabic' => 'الإخلاص', 'translation' => 'Ikhlas', 'revelation' => 'Makkiyah', 'count' => 4],
        113 => ['slug' => 'al-falaq', 'latin' => 'Al-Falaq', 'arabic' => 'الفلق', 'translation' => 'Waktu Subuh', 'revelation' => 'Makkiyah', 'count' => 5],
        114 => ['slug' => 'an-nas', 'latin' => 'An-Nās', 'arabic' => 'الناس', 'translation' => 'Manusia', 'revelation' => 'Makkiyah', 'count' => 6],
    ];

    public static function all(): array
    {
        return static::$surahs;
    }

    public static function findBySlug(string $slug): ?array
    {
        $normalized = strtolower(trim($slug));
        foreach (static::$surahs as $number => $data) {
            if ($data['slug'] === $normalized) {
                return array_merge(['number' => $number], $data);
            }
        }

        $cleanInput = preg_replace('/[^a-z0-9]/', '', $normalized);
        foreach (static::$surahs as $number => $data) {
            $cleanSlug = preg_replace('/[^a-z0-9]/', '', $data['slug']);
            if ($cleanSlug === $cleanInput) {
                return array_merge(['number' => $number], $data);
            }
        }

        return null;
    }

    public static function findByNumber(int $number): ?array
    {
        if (isset(static::$surahs[$number])) {
            return array_merge(['number' => $number], static::$surahs[$number]);
        }
        return null;
    }

    public static function getSlug(int $number): string
    {
        return static::$surahs[$number]['slug'] ?? 'al-fatihah';
    }

    public static function getNumber(string $slug): ?int
    {
        $found = static::findBySlug($slug);
        return $found ? $found['number'] : null;
    }
}
