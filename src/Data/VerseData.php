<?php

namespace Adyatama\Quran\Data;

class VerseData
{
    public int $surahNumber;
    public int $ayahNumber;
    public string $verseKey;
    public string $arabicUtsmani;
    public string $arabicSimple;
    public string $ayahMarker;
    public string $latin;
    public string $translationId;
    public ?int $juz;
    public ?int $page;
    public ?int $hizb;
    public ?string $audioUrl = null;
    public ?string $tafsir = null;

    public function __construct(array $data = [], int $fallbackSurah = 1)
    {
        $this->surahNumber  = (int) ($data['surah_number'] ?? $data['surah'] ?? $data['surah_id'] ?? $fallbackSurah);
        $this->ayahNumber   = (int) ($data['ayah_number'] ?? $data['nomorAyat'] ?? $data['ayah'] ?? $data['number'] ?? 1);
        $this->verseKey     = $data['verse_key'] ?? ($this->surahNumber . ':' . $this->ayahNumber);
        $this->ayahMarker   = $data['ayah_marker'] ?? '';

        $this->arabicUtsmani = $data['arabic_uthmani'] ?? $data['ar'] ?? $data['teksArab'] ?? $data['text_uthmani'] ?? $data['arabic'] ?? '';
        $this->arabicSimple  = $data['arabic_simple'] ?? $this->arabicUtsmani;
        $this->latin         = $data['latin'] ?? $data['tr'] ?? $data['teksLatin'] ?? $data['transliteration'] ?? '';
        
        $rawTranslation = $data['translation_id'] ?? $data['teksIndonesia'] ?? $data['translation'] ?? null;
        if (is_string($rawTranslation) && !empty($rawTranslation)) {
            $this->translationId = $rawTranslation;
        } elseif (!empty($data['translations']) && is_array($data['translations'])) {
            $firstTrans = reset($data['translations']);
            $this->translationId = is_array($firstTrans) ? ($firstTrans['translation'] ?? '') : (string) $firstTrans;
        } else {
            $this->translationId = '';
        }

        // Tafsir mapping from API
        $rawTafsir = $data['tafsir_id'] ?? $data['tafsir'] ?? null;
        if (is_string($rawTafsir) && !empty($rawTafsir)) {
            $this->tafsir = $rawTafsir;
        } elseif (!empty($data['tafsirs']) && is_array($data['tafsirs'])) {
            $firstTafsir = reset($data['tafsirs']);
            $this->tafsir = is_array($firstTafsir) ? ($firstTafsir['text'] ?? '') : (string) $firstTafsir;
        } else {
            $this->tafsir = null;
        }

        // API uses 'juz_number' and 'page_number'
        $this->juz  = isset($data['juz_number']) ? (int) $data['juz_number'] : (isset($data['juz']) ? (int) $data['juz'] : null);
        $this->page = isset($data['page_number']) ? (int) $data['page_number'] : (isset($data['page']) ? (int) $data['page'] : null);
        $this->hizb = isset($data['hizb']) ? (int) $data['hizb'] : null;

        // Per-ayah audio: fresh API payload uses nested 'audio' array,
        // cached (toArray) payload uses flat 'audio_url' string.
        if (!empty($data['audio']) && is_array($data['audio'])) {
            $this->audioUrl = $data['audio']['primary'] ?? null;
        } elseif (!empty($data['audio_url']) && is_string($data['audio_url'])) {
            $this->audioUrl = $data['audio_url'];
        }
    }

    public static function fromArray(array $data, int $surah = 1): self
    {
        return new self($data, $surah);
    }

    public function getArabicAyahNumber(): string
    {
        if (!empty($this->ayahMarker)) {
            return $this->ayahMarker;
        }

        $easternDigits = ['٠','١','٢','٣','٤','٥','٦','٧','٨','٩'];
        $numStr = (string) $this->ayahNumber;
        $converted = '';
        for ($i = 0; $i < strlen($numStr); $i++) {
            $converted .= $easternDigits[(int)$numStr[$i]] ?? $numStr[$i];
        }
        return "\u{06DD}" . $converted;
    }

    public function toArray(): array
    {
        return [
            'surah_number'   => $this->surahNumber,
            'ayah_number'    => $this->ayahNumber,
            'verse_key'      => $this->verseKey,
            'ayah_marker'    => $this->ayahMarker,
            'arabic_uthmani' => $this->arabicUtsmani,
            'arabic_simple'  => $this->arabicSimple,
            'latin'          => $this->latin,
            'translation_id' => $this->translationId,
            'juz'            => $this->juz,
            'page'           => $this->page,
            'hizb'           => $this->hizb,
            'audio_url'      => $this->audioUrl,
            'tafsir'         => $this->tafsir,
        ];
    }
}
