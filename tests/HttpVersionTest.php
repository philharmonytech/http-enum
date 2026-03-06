<?php

declare(strict_types=1);

namespace Philharmony\Http\Enum\Tests;

use Philharmony\Http\Enum\HttpVersion;
use PHPUnit\Framework\TestCase;

class HttpVersionTest extends TestCase
{
    public function testToProtocolString(): void
    {
        foreach (HttpVersion::cases() as $version) {
            $this->assertSame('HTTP/' . $version->value, $version->toProtocolString());
        }
    }

    public function testFromProtocol(): void
    {
        foreach (HttpVersion::cases() as $version) {
            $this->assertEquals($version, HttpVersion::fromProtocol('HTTP/' . $version->value));
        }

        $this->assertNull(HttpVersion::fromProtocol('FTP/1.0'));
        $this->assertNull(HttpVersion::fromProtocol('1.1'));
    }

    public function testFromString(): void
    {
        foreach (HttpVersion::cases() as $version) {
            $this->assertSame($version, HttpVersion::fromString($version->value));
        }
    }

    public function testTryFromString(): void
    {
        foreach (HttpVersion::cases() as $version) {
            $this->assertSame($version, HttpVersion::tryFromString($version->value));
        }

        $this->assertNull(HttpVersion::tryFromString('9'));
    }
}
