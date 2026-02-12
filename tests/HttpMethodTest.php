<?php

declare(strict_types=1);

namespace Philharmony\Http\Tests\Enum;

use Philharmony\Http\Enum\HttpMethod;
use PHPUnit\Framework\TestCase;
use ValueError;

/**
 * @psalm-suppress UnusedClass
 */
class HttpMethodTest extends TestCase
{
    public function testFromReturnsCorrectCase(): void
    {
        $this->assertSame(HttpMethod::GET, HttpMethod::from('GET'));
        $this->assertSame(HttpMethod::POST, HttpMethod::from('POST'));
    }

    public function testTryFromReturnsNullForInvalidValues(): void
    {
        $invalid = ['', 'BOOM', 'GETT', 'get', 'Post', 'DELETEE'];
        foreach ($invalid as $value) {
            $this->assertNull(HttpMethod::tryFrom($value));
        }
    }

    public function testFromThrowsOnInvalidValue(): void
    {
        $this->expectException(ValueError::class);
        HttpMethod::from('INVALID');
    }

    public function testIsIdempotentReturnsCorrectValue(): void
    {
        $idempotent = [HttpMethod::GET, HttpMethod::PUT, HttpMethod::DELETE, HttpMethod::HEAD, HttpMethod::OPTIONS];
        $nonIdempotent = [HttpMethod::POST, HttpMethod::PATCH];

        foreach ($idempotent as $method) {
            $this->assertTrue($method->isIdempotent());
        }

        foreach ($nonIdempotent as $method) {
            $this->assertFalse($method->isIdempotent());
        }
    }

    public function testIsValidReturnsTrueForValidMethods(): void
    {
        $valid = ['GET', 'POST', 'PUT', 'DELETE', 'PATCH', 'HEAD', 'OPTIONS'];
        $invalid = ['', 'BOOM', 'GETT', 'get', 'Post'];

        foreach ($valid as $method) {
            $this->assertTrue(HttpMethod::isValid($method), "Expected '$method' to be valid");
        }

        foreach ($invalid as $method) {
            $this->assertFalse(HttpMethod::isValid($method), "Expected '$method' to be invalid");
        }
    }

    public function testFromIsCaseSensitive(): void
    {
        $this->expectException(ValueError::class);
        HttpMethod::from('get');
    }
}
