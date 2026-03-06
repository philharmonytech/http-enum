<?php

declare(strict_types=1);

namespace Philharmony\Http\Enum\Tests;

use Philharmony\Http\Enum\HttpMethod;
use PHPUnit\Framework\TestCase;
use ValueError;

class HttpMethodTest extends TestCase
{
    public function testFromReturnsCorrectCase(): void
    {
        foreach (HttpMethod::cases() as $method) {
            $this->assertSame($method, HttpMethod::from($method->value));
        }
    }

    public function testFromIsCaseSensitive(): void
    {
        $this->expectException(ValueError::class);
        HttpMethod::from('get');
    }

    public function testTryFromReturnsNullForInvalidValues(): void
    {
        $invalid = ['', 'BOOM', 'GETT', 'get', 'Post', 'DELETEE', '123', 'HTTP', 'GET '];

        foreach ($invalid as $value) {
            $this->assertNull(HttpMethod::tryFrom($value));
        }
    }

    public function testFromThrowsOnInvalidValue(): void
    {
        $this->expectException(ValueError::class);
        HttpMethod::from('INVALID');
    }

    public function testFromStringIsCaseInsensitive(): void
    {
        $this->assertSame(HttpMethod::GET, HttpMethod::fromString('get'));
        $this->assertSame(HttpMethod::POST, HttpMethod::fromString('post'));
    }

    public function testTryFromStringIsCaseInsensitive(): void
    {
        $this->assertSame(HttpMethod::GET, HttpMethod::tryFromString('get'));
        $this->assertSame(HttpMethod::POST, HttpMethod::tryFromString('post'));
        $this->assertNull(HttpMethod::tryFromString('boom'));
    }

    public function testIsValid(): void
    {
        foreach (HttpMethod::cases() as $method) {
            $this->assertTrue(HttpMethod::isValid($method->value));
        }

        $invalid = ['', 'BOOM', 'GETT', '123', 'GET '];

        foreach ($invalid as $method) {
            $this->assertFalse(HttpMethod::isValid($method));
        }
    }

    public function testIsSafe(): void
    {
        $safe = [
            HttpMethod::GET,
            HttpMethod::HEAD,
            HttpMethod::OPTIONS,
            HttpMethod::TRACE,
        ];

        foreach (HttpMethod::cases() as $method) {
            $expected = \in_array($method, $safe, true);
            $this->assertSame($expected, $method->isSafe());
        }
    }

    public function testIsIdempotent(): void
    {
        $expected = [
            HttpMethod::GET,
            HttpMethod::HEAD,
            HttpMethod::PUT,
            HttpMethod::DELETE,
            HttpMethod::OPTIONS,
            HttpMethod::TRACE,
            HttpMethod::CONNECT,
        ];

        foreach (HttpMethod::cases() as $method) {
            $this->assertSame(
                \in_array($method, $expected, true),
                $method->isIdempotent()
            );
        }
    }

    public function testIsCacheable(): void
    {
        $expected = [
            HttpMethod::GET,
            HttpMethod::HEAD,
        ];

        foreach (HttpMethod::cases() as $method) {
            $this->assertSame(
                \in_array($method, $expected, true),
                $method->isCacheable()
            );
        }
    }

    public function testIsReadOnly(): void
    {
        $safe = [
            HttpMethod::GET,
            HttpMethod::HEAD,
            HttpMethod::OPTIONS,
            HttpMethod::TRACE,
        ];

        foreach (HttpMethod::cases() as $method) {
            $expected = \in_array($method, $safe, true);
            $this->assertSame($expected, $method->isReadOnly());
        }
    }

    public function testIsWriteOnly(): void
    {
        $expected = [
            HttpMethod::POST,
            HttpMethod::PUT,
            HttpMethod::PATCH,
            HttpMethod::DELETE,
            HttpMethod::CONNECT,
        ];

        foreach (HttpMethod::cases() as $method) {
            $this->assertSame(
                \in_array($method, $expected, true),
                $method->isWriteOnly()
            );
        }
    }

    public function testUsuallyHasBody(): void
    {
        $expected = [
            HttpMethod::POST,
            HttpMethod::PUT,
            HttpMethod::PATCH,
        ];

        foreach (HttpMethod::cases() as $method) {
            $this->assertSame(
                \in_array($method, $expected, true),
                $method->usuallyHasBody()
            );
        }
    }

    public function testAllowsBody(): void
    {
        $expected = [
            HttpMethod::POST,
            HttpMethod::PUT,
            HttpMethod::PATCH,
            HttpMethod::DELETE,
        ];

        foreach (HttpMethod::cases() as $method) {
            $this->assertSame(
                \in_array($method, $expected, true),
                $method->allowsBody()
            );
        }
    }
}
