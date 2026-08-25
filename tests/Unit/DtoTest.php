<?php

namespace Adyatama\Quran\Tests\Unit;

use Adyatama\Quran\Data\SurahData;
use Adyatama\Quran\Data\VerseData;
use PHPUnit\Framework\TestCase;

class DtoTest extends TestCase
{
    public function test_cached_audio_payload_is_rehydrated(): void
    {
        $surah = new SurahData([
            'number' => 36,
            'verses' => [[
                'ayah_number' => 1,
                'arabic_uthmani' => 'يسٓ',
                'audio_url' => 'https://audio.test/36-1.mp3',
            ]],
            'audio_url' => 'https://audio.test/36.mp3',
        ]);

        $this->assertSame('https://audio.test/36.mp3', $surah->audioUrl);
        $this->assertSame('https://audio.test/36-1.mp3', $surah->verses[0]->audioUrl);
    }

    public function test_verse_number_is_normalized_from_numeric_payload(): void
    {
        $verse = new VerseData(['ayah_number' => '7']);

        $this->assertSame(7, $verse->ayahNumber);
        $this->assertStringContainsString('٧', $verse->getArabicAyahNumber());
    }
}
