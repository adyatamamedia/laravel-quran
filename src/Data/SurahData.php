<?php

namespace Adyatama\Quran\Data;

use Adyatama\Quran\Support\SurahSlug;

class SurahData
{
    public int $number;
    public string $slug;
    public string $nameLatin;
    public string $nameArabic;
    public string $translatedName;
    public string $calligraphyLigature;
    public string $calligraphyGlyph;
    public string $revelationType;
    public int $versesCount;
    public ?string $audioUrl = null;
    public array $audioReciters = [];
    /** @var VerseData[] */
    public array $verses = [];

    public function __construct(array $data = [])
    {
        $this->number = (int) ($data['number'] ?? $data['surah_number'] ?? $data['id'] ?? 1);
        $this->slug = $data['slug'] ?? SurahSlug::getSlug($this->number);
        
        $meta = SurahSlug::findByNumber($this->number);

        $this->nameLatin = $meta['latin'] ?? $data['name_latin'] ?? $data['nama_latin'] ?? $data['name_transliterated'] ?? '';
        $this->nameArabic = $data['name_arabic'] ?? $data['nama'] ?? $data['name_short'] ?? ($meta['arabic'] ?? '');
        $this->translatedName = $meta['translation'] ?? $data['translated_name'] ?? $data['arti'] ?? $data['name_translation'] ?? '';
        $this->calligraphyLigature = $data['calligraphy']['ligature'] ?? sprintf('surah%03d', $this->number);
        $this->calligraphyGlyph = ($this->number === 102) ? mb_chr(0xE102, 'UTF-8') : mb_chr(0xE000 + $this->number, 'UTF-8');
        // API uses 'revelation_place' (Makkah/Madinah), legacy used 'revelation_type'
        $rawRevelation = $data['revelation_place'] ?? $data['revelation_type'] ?? $data['tempat_turun'] ?? $data['type'] ?? ($meta['revelation'] ?? 'Makkiyah');
        $this->revelationType = match(strtolower($rawRevelation)) {
            'makkah', 'mekah' => 'Makkiyah',
            'madinah', 'madinah' => 'Madaniyah',
            default => $rawRevelation,
        };
        // API uses 'total_ayahs', legacy used 'verses_count'
        $this->versesCount = (int) ($data['total_ayahs'] ?? $data['verses_count'] ?? $data['jumlah_ayat'] ?? ($meta['count'] ?? 0));

        // Audio: fresh API payload uses nested 'audio' array,
        // cached (toArray) payload uses flat 'audio_url'/'audio_reciters'.
        if (!empty($data['audio']) && is_array($data['audio'])) {
            $this->audioUrl = $data['audio']['primary'] ?? null;
            $this->audioReciters = $data['audio']['reciters'] ?? [];
        } else {
            if (!empty($data['audio_url']) && is_string($data['audio_url'])) {
                $this->audioUrl = $data['audio_url'];
            }
            if (!empty($data['audio_reciters']) && is_array($data['audio_reciters'])) {
                $this->audioReciters = $data['audio_reciters'];
            }
        }

        // API uses 'ayahs', legacy used 'verses' or 'ayat'
        $ayahsSource = $data['ayahs'] ?? $data['verses'] ?? $data['ayat'] ?? [];
        if (!empty($ayahsSource) && is_array($ayahsSource)) {
            foreach ($ayahsSource as $v) {
                $this->verses[] = $v instanceof VerseData ? $v : new VerseData($v, $this->number);
            }
        }
    }

    public static function fromArray(array $data): self
    {
        return new self($data);
    }

    public function toArray(): array
    {
        return [
            'number'         => $this->number,
            'slug'           => $this->slug,
            'name_latin'     => $this->nameLatin,
            'name_arabic'    => $this->nameArabic,
            'translated_name'=> $this->translatedName,
            'revelation_type'=> $this->revelationType,
            'verses_count'   => $this->versesCount,
            'audio_url'      => $this->audioUrl,
            'audio_reciters' => $this->audioReciters,
            'calligraphy_ligature' => $this->calligraphyLigature,
            'verses'         => array_map(fn(VerseData $v) => $v->toArray(), $this->verses),
        ];
    }
}
