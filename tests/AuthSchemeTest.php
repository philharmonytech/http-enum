<?php

declare(strict_types=1);

namespace Philharmony\Http\Enum\Tests;

use Philharmony\Http\Enum\AuthScheme;
use PHPUnit\Framework\TestCase;

class AuthSchemeTest extends TestCase
{
    public function testFromHeader(): void
    {
        $this->assertSame(AuthScheme::BEARER, AuthScheme::fromHeader('Bearer token123'));
        $this->assertSame(AuthScheme::BASIC, AuthScheme::fromHeader('Basic YWRtaW46cGFzcw=='));
        $this->assertNull(AuthScheme::fromHeader(''));
    }

    public function testFromHeaderWithSpaces(): void
    {
        $this->assertSame(AuthScheme::BEARER, AuthScheme::fromHeader('   Bearer token'));
    }

    public function testFromString(): void
    {
        $this->assertSame(AuthScheme::BEARER, AuthScheme::fromString('bearer'));
        $this->assertSame(AuthScheme::OAUTH, AuthScheme::fromString('OAuth'));
    }

    public function testFromStringThrowsOnInvalid(): void
    {
        $this->expectException(\ValueError::class);
        AuthScheme::fromString('unknown');
    }

    public function testTryFromString(): void
    {
        $this->assertSame(AuthScheme::BASIC, AuthScheme::tryFromString('BASIC'));
        $this->assertSame(AuthScheme::HOBA, AuthScheme::tryFromString('hoba'));
    }

    public function testTryFromStringInvalid(): void
    {
        $this->assertNull(AuthScheme::tryFromString('unknown'));
    }

    public function testIsTokenBased(): void
    {
        foreach (AuthScheme::cases() as $scheme) {
            $expected = \in_array($scheme, [AuthScheme::BEARER, AuthScheme::OAUTH,], true);

            $this->assertSame($expected, $scheme->isTokenBased());
        }
    }

    public function testIsPasswordBased(): void
    {
        foreach (AuthScheme::cases() as $scheme) {
            $expected = \in_array($scheme, [AuthScheme::BASIC, AuthScheme::DIGEST,], true);

            $this->assertSame($expected, $scheme->isPasswordBased());
        }
    }

    public function testIsChallengeBased(): void
    {
        $map = [
            AuthScheme::BASIC,
            AuthScheme::DIGEST,
            AuthScheme::NEGOTIATE,
            AuthScheme::HOBA,
            AuthScheme::MUTUAL,
        ];

        foreach (AuthScheme::cases() as $scheme) {
            $expected = \in_array($scheme, $map, true);

            $this->assertSame($expected, $scheme->isChallengeBased());
        }
    }
}
