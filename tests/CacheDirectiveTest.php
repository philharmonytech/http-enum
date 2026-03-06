<?php

declare(strict_types=1);

namespace Philharmony\Http\Enum\Tests;

use Philharmony\Http\Enum\CacheDirective;
use PHPUnit\Framework\TestCase;

class CacheDirectiveTest extends TestCase
{
    public function testFromString(): void
    {
        $this->assertSame(CacheDirective::NO_CACHE, CacheDirective::fromString('no-cache'));
        $this->assertSame(CacheDirective::NO_STORE, CacheDirective::fromString('NO-STORE'));
        $this->assertSame(CacheDirective::MAX_AGE, CacheDirective::fromString(' max-age '));
    }

    public function testTryFromString(): void
    {
        $this->assertSame(CacheDirective::PUBLIC, CacheDirective::tryFromString('public'));
        $this->assertNull(CacheDirective::tryFromString('invalid'));
    }

    public function testIsRestriction(): void
    {
        foreach (CacheDirective::cases() as $directive) {
            $expected = \in_array($directive, [CacheDirective::NO_CACHE, CacheDirective::NO_STORE,], true);

            $this->assertSame($expected, $directive->isRestriction());
        }
    }

    public function testIsExpiration(): void
    {
        foreach (CacheDirective::cases() as $directive) {
            $expected = \in_array($directive, [CacheDirective::MAX_AGE, CacheDirective::S_MAXAGE,], true);

            $this->assertSame($expected, $directive->isExpiration());
        }
    }

    public function testIsVisibility(): void
    {
        foreach (CacheDirective::cases() as $directive) {
            $expected = \in_array($directive, [CacheDirective::PUBLIC, CacheDirective::PRIVATE,], true);

            $this->assertSame($expected, $directive->isVisibility());
        }
    }

    public function testValues(): void
    {
        foreach (CacheDirective::cases() as $directive) {
            $this->assertIsString($directive->value);
            $this->assertSame($directive, CacheDirective::from($directive->value));
        }
    }
}
