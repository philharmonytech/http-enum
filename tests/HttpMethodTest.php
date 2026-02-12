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
        $this->assertSame(HttpMethod::GET, HttpMethod::from('GET'));
        $this->assertSame(HttpMethod::POST, HttpMethod::from('POST'));
        $this->assertSame(HttpMethod::PUT, HttpMethod::from('PUT'));
        $this->assertSame(HttpMethod::DELETE, HttpMethod::from('DELETE'));
        $this->assertSame(HttpMethod::PATCH, HttpMethod::from('PATCH'));
        $this->assertSame(HttpMethod::HEAD, HttpMethod::from('HEAD'));
        $this->assertSame(HttpMethod::OPTIONS, HttpMethod::from('OPTIONS'));
        $this->assertSame(HttpMethod::TRACE, HttpMethod::from('TRACE'));
        $this->assertSame(HttpMethod::CONNECT, HttpMethod::from('CONNECT'));
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

    public function testFromIsCaseSensitive(): void
    {
        $this->expectException(ValueError::class);
        HttpMethod::from('get');
    }

    public function testTryFromIsCaseSensitive(): void
    {
        $this->assertNull(HttpMethod::tryFrom('get'));
        $this->assertNull(HttpMethod::tryFrom('Get'));
        $this->assertNull(HttpMethod::tryFrom('POST '));
        $this->assertNull(HttpMethod::tryFrom('put'));
    }

    public function testIsIdempotentReturnsCorrectValue(): void
    {
        $idempotent = [
            HttpMethod::GET,
            HttpMethod::HEAD,
            HttpMethod::PUT,
            HttpMethod::DELETE,
            HttpMethod::OPTIONS,
            HttpMethod::TRACE,
            HttpMethod::CONNECT,
        ];

        $nonIdempotent = [
            HttpMethod::POST,
            HttpMethod::PATCH,
        ];

        foreach ($idempotent as $method) {
            $this->assertTrue($method->isIdempotent());
        }

        foreach ($nonIdempotent as $method) {
            $this->assertFalse($method->isIdempotent());
        }
    }

    public function testIsValidReturnsTrueForValidMethods(): void
    {
        $valid = ['GET', 'POST', 'PUT', 'DELETE', 'PATCH', 'HEAD', 'OPTIONS', 'TRACE', 'CONNECT'];

        foreach ($valid as $method) {
            $this->assertTrue(HttpMethod::isValid($method));
        }
    }

    public function testIsValidReturnsFalseForInvalidMethods(): void
    {
        $invalid = ['', 'BOOM', 'GETT', 'get', 'Post', 'DELETEE', 'GET ', '123'];

        foreach ($invalid as $method) {
            $this->assertFalse(HttpMethod::isValid($method));
        }
    }

    public function testIsSafeReturnsCorrectValue(): void
    {
        $safe = [
            HttpMethod::GET,
            HttpMethod::HEAD,
            HttpMethod::OPTIONS,
            HttpMethod::TRACE,
        ];

        $unsafe = [
            HttpMethod::POST,
            HttpMethod::PUT,
            HttpMethod::DELETE,
            HttpMethod::PATCH,
            HttpMethod::CONNECT,
        ];

        foreach ($safe as $method) {
            $this->assertTrue($method->isSafe());
        }

        foreach ($unsafe as $method) {
            $this->assertFalse($method->isSafe());
        }
    }
}
