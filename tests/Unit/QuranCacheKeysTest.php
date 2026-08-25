<?php

namespace Adyatama\Quran\Tests\Unit;

use Adyatama\Quran\Support\QuranCacheKeys;
use PHPUnit\Framework\TestCase;

class QuranCacheKeysTest extends TestCase
{
    public function test_cache_keys_change_when_request_parameters_change(): void
    {
        $a = QuranCacheKeys::surah(36, ['include' => 'translations']);
        $b = QuranCacheKeys::surah(36, ['include' => 'tafsirs']);

        $this->assertNotSame($a, $b);
        $this->assertSame($a, QuranCacheKeys::surah(36, ['include' => 'translations']));
    }
}
