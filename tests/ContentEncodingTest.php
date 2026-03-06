<?php

declare(strict_types=1);

namespace Philharmony\Http\Enum\Tests;

use Philharmony\Http\Enum\ContentEncoding;
use PHPUnit\Framework\TestCase;

class ContentEncodingTest extends TestCase
{
    public function testFromString(): void
    {
        $this->assertSame(ContentEncoding::GZIP, ContentEncoding::fromString('gzip'));
        $this->assertSame(ContentEncoding::BR, ContentEncoding::fromString('BR'));
        $this->assertSame(ContentEncoding::DEFLATE, ContentEncoding::fromString(' deflate '));
    }

    public function testTryFromString(): void
    {
        $this->assertSame(ContentEncoding::GZIP, ContentEncoding::tryFromString('gzip'));
        $this->assertNull(ContentEncoding::tryFromString('unknown'));
    }

    public function testIsCompressed(): void
    {
        foreach (ContentEncoding::cases() as $encoding) {
            $expected = \in_array($encoding, [
                ContentEncoding::GZIP,
                ContentEncoding::DEFLATE,
                ContentEncoding::BR,
                ContentEncoding::COMPRESS,
            ], true);

            $this->assertSame($expected, $encoding->isCompressed());
        }
    }
}
