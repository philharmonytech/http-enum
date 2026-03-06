<?php

declare(strict_types=1);

namespace Philharmony\Http\Enum\Tests;

use Philharmony\Http\Enum\SameSite;
use PHPUnit\Framework\TestCase;

class SameSiteTest extends TestCase
{
    public function testFromString(): void
    {
        $this->assertSame(SameSite::STRICT, SameSite::fromString('Strict'));
        $this->assertSame(SameSite::LAX, SameSite::fromString('lax'));
        $this->assertSame(SameSite::NONE, SameSite::fromString('NONE'));
    }

    public function testTryFromString(): void
    {
        $this->assertSame(SameSite::STRICT, SameSite::tryFromString('strict'));
        $this->assertNull(SameSite::tryFromString('invalid'));
    }

    public function testIsStrict(): void
    {
        $this->assertTrue(SameSite::STRICT->isStrict());
        $this->assertFalse(SameSite::LAX->isStrict());
    }

    public function testAllowsCrossSite(): void
    {
        $this->assertTrue(SameSite::NONE->allowsCrossSite());
        $this->assertFalse(SameSite::STRICT->allowsCrossSite());
    }
}
