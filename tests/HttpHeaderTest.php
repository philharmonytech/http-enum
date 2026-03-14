<?php

declare(strict_types=1);

namespace Philharmony\Http\Enum\Tests;

use Philharmony\Http\Enum\HttpHeader;
use PHPUnit\Framework\TestCase;

class HttpHeaderTest extends TestCase
{
    public function testFromReturnsCorrectCase(): void
    {
        $this->assertSame(HttpHeader::CONTENT_TYPE, HttpHeader::from('Content-Type'));
        $this->assertSame(HttpHeader::ACCEPT, HttpHeader::from('Accept'));
    }

    public function testTryFromReturnsNullForInvalid(): void
    {
        $this->assertNull(HttpHeader::tryFrom('Invalid-Header'));
    }

    public function testFromStringNormalizesHeader(): void
    {
        $this->assertSame(
            HttpHeader::CONTENT_TYPE,
            HttpHeader::fromString('content-type')
        );

        $this->assertSame(
            HttpHeader::CONTENT_TYPE,
            HttpHeader::fromString('CONTENT-TYPE')
        );

        $this->assertSame(
            HttpHeader::CONTENT_TYPE,
            HttpHeader::fromString('Content-Type')
        );

        $this->assertSame(
            HttpHeader::ETAG,
            HttpHeader::fromString('ETag')
        );

        $this->assertSame(
            HttpHeader::WWW_AUTHENTICATE,
            HttpHeader::fromString('WWW-Authenticate')
        );
    }

    public function testTryFromString(): void
    {
        $this->assertSame(
            HttpHeader::CONTENT_TYPE,
            HttpHeader::tryFromString('content-type')
        );

        $this->assertNull(
            HttpHeader::tryFromString('invalid-header')
        );
    }

    public function testFromStringThrowsOnInvalid(): void
    {
        $this->expectException(\ValueError::class);
        HttpHeader::fromString('invalid-header');
    }

    public function testRequestAndResponseHeadersAreMutuallyExclusive(): void
    {
        foreach (HttpHeader::cases() as $header) {
            if ($header->isResponseHeader() && !$header->isGeneralHeader()) {
                $this->assertFalse($header->isRequestHeader());
            } else {
                $this->assertTrue($header->isRequestHeader());
            }
        }
    }

    public function testRequestOnlyAndResponseOnlyAreMutuallyExclusive(): void
    {
        foreach (HttpHeader::cases() as $header) {
            $this->assertFalse($header->isRequestOnly() && $header->isResponseOnly());
        }
    }

    public function testGeneralHeaders(): void
    {
        $general = [
            HttpHeader::CACHE_CONTROL,
            HttpHeader::CONNECTION,
            HttpHeader::DATE,
            HttpHeader::PRAGMA,
            HttpHeader::TRANSFER_ENCODING,
            HttpHeader::TRAILER,
            HttpHeader::UPGRADE,
            HttpHeader::VIA,
        ];

        foreach ($general as $header) {
            $this->assertTrue($header->isGeneralHeader());
        }
    }

    public function testHopByHopHeaders(): void
    {
        $hopByHop = [
            HttpHeader::CONNECTION,
            HttpHeader::KEEP_ALIVE,
            HttpHeader::PROXY_AUTHENTICATE,
            HttpHeader::PROXY_AUTHORIZATION,
            HttpHeader::TE,
            HttpHeader::TRAILER,
            HttpHeader::TRANSFER_ENCODING,
            HttpHeader::UPGRADE,
        ];

        foreach ($hopByHop as $header) {
            $this->assertTrue($header->isHopByHop());
        }
    }

    public function testCorsHeaders(): void
    {
        foreach (HttpHeader::cases() as $header) {
            if (str_starts_with($header->value, 'Access-Control-')) {
                $this->assertTrue($header->isCors());
            }
        }
    }

    public function testProxyHeaders(): void
    {
        $this->assertTrue(HttpHeader::X_FORWARDED_FOR->isProxy());
        $this->assertTrue(HttpHeader::X_FORWARDED_HOST->isProxy());
        $this->assertTrue(HttpHeader::X_FORWARDED_PROTO->isProxy());
        $this->assertTrue(HttpHeader::X_REAL_IP->isProxy());
    }

    public function testCacheHeaders(): void
    {
        $cacheHeaders = [
            HttpHeader::CACHE_CONTROL,
            HttpHeader::PRAGMA,
            HttpHeader::EXPIRES,
            HttpHeader::AGE,
            HttpHeader::ETAG,
            HttpHeader::LAST_MODIFIED,
            HttpHeader::IF_MATCH,
            HttpHeader::IF_NONE_MATCH,
            HttpHeader::IF_MODIFIED_SINCE,
            HttpHeader::IF_UNMODIFIED_SINCE,
        ];

        foreach ($cacheHeaders as $header) {
            $this->assertTrue($header->isCacheHeader());
        }
    }

    public function testAuthHeaders(): void
    {
        $authHeaders = [
            HttpHeader::AUTHORIZATION,
            HttpHeader::WWW_AUTHENTICATE,
            HttpHeader::PROXY_AUTHENTICATE,
            HttpHeader::PROXY_AUTHORIZATION,
        ];

        foreach ($authHeaders as $header) {
            $this->assertTrue($header->isAuthHeader());
        }
    }

    public function testSecurityHeaders(): void
    {
        $securityHeaders = [
            HttpHeader::AUTHORIZATION,
            HttpHeader::SET_COOKIE,
            HttpHeader::COOKIE,
        ];

        foreach ($securityHeaders as $header) {
            $this->assertTrue($header->isSecurityHeader());
        }
    }

    public function testConditionalHeaders(): void
    {
        $conditional = [
            HttpHeader::IF_MATCH,
            HttpHeader::IF_NONE_MATCH,
            HttpHeader::IF_MODIFIED_SINCE,
            HttpHeader::IF_UNMODIFIED_SINCE,
        ];

        foreach ($conditional as $header) {
            $this->assertTrue($header->isConditional());
        }
    }

    public function testContentHeaders(): void
    {
        $content = [
            HttpHeader::CONTENT_TYPE,
            HttpHeader::CONTENT_LENGTH,
            HttpHeader::CONTENT_ENCODING,
            HttpHeader::CONTENT_LANGUAGE,
            HttpHeader::CONTENT_LOCATION,
            HttpHeader::CONTENT_RANGE,
            HttpHeader::CONTENT_DISPOSITION,
        ];

        foreach ($content as $header) {
            $this->assertTrue($header->isContentHeader());
        }
    }
}
