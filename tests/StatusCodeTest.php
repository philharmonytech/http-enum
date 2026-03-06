<?php

declare(strict_types=1);

namespace Philharmony\Http\Enum\Tests;

use Philharmony\Http\Enum\StatusCode;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use ValueError;

class StatusCodeTest extends TestCase
{
    public function testFromReturnsCorrectCase(): void
    {
        $this->assertSame(StatusCode::OK, StatusCode::from(200));
        $this->assertSame(StatusCode::BAD_REQUEST, StatusCode::from(400));
    }

    public function testFromIsCaseSensitive(): void
    {
        $this->expectException(ValueError::class);
        StatusCode::from(700);
    }

    public function testTryFromReturnsNullForInvalidValues(): void
    {
        $invalid = [0, 640,];
        foreach ($invalid as $value) {
            $this->assertNull(StatusCode::tryFrom($value));
        }
    }

    public function testIsInformationalReturnsTrueForInformationalTypes(): void
    {
        foreach (StatusCode::cases() as $statusCode) {
            $expected = \in_array($statusCode, StatusCode::informational(), true);
            $this->assertSame($expected, $statusCode->isInformational());
        }
    }

    public function testIsSuccessReturnsTrueForSuccessTypes(): void
    {
        foreach (StatusCode::cases() as $statusCode) {
            $expected = \in_array($statusCode, StatusCode::success(), true);
            $this->assertSame($expected, $statusCode->isSuccess());
        }
    }

    public function testIsRedirectionReturnsTrueForRedirectionTypes(): void
    {
        foreach (StatusCode::cases() as $statusCode) {
            $expected = \in_array($statusCode, StatusCode::redirection(), true);
            $this->assertSame($expected, $statusCode->isRedirection());
        }
    }

    public function testIsClientErrorReturnsTrueForClientErrorTypes(): void
    {
        foreach (StatusCode::cases() as $statusCode) {
            $expected = \in_array($statusCode, StatusCode::clientError(), true);
            $this->assertSame($expected, $statusCode->isClientError());
        }
    }

    public function testIsServerErrorReturnsTrueForServerErrorTypes(): void
    {
        foreach (StatusCode::cases() as $statusCode) {
            $expected = \in_array($statusCode, StatusCode::serverError(), true);
            $this->assertSame($expected, $statusCode->isServerError());
        }
    }

    public function testIsErrorReturnsTrueForErrorTypes(): void
    {
        foreach (StatusCode::cases() as $statusCode) {
            $expected = \in_array($statusCode, StatusCode::error(), true);
            $this->assertSame($expected, $statusCode->isError());
        }
    }

    #[DataProvider('getPhraseDataProvider')]
    public function testPhraseReturnsCorrectString(
        int $statusCode,
        string $expectedMessage
    ): void {
        $this->assertSame($expectedMessage, StatusCode::from($statusCode)->phrase());
    }

    /**
     * @return array<string, array{statusCode: int, expectedMessage: string}>
     */
    public static function getPhraseDataProvider(): array
    {
        return [
            '100-Continue' => [
                'statusCode' => 100,
                'expectedMessage' => 'Continue',
            ],
            '101-Switching Protocols' => [
                'statusCode' => 101,
                'expectedMessage' => 'Switching Protocols',
            ],
            '102-Processing' => [
                'statusCode' => 102,
                'expectedMessage' => 'Processing',
            ],
            '103-Early Hints' => [
                'statusCode' => 103,
                'expectedMessage' => 'Early Hints',
            ],

            '200-OK' => [
                'statusCode' => 200,
                'expectedMessage' => 'OK',
            ],
            '201-Created' => [
                'statusCode' => 201,
                'expectedMessage' => 'Created',
            ],
            '202-Accepted' => [
                'statusCode' => 202,
                'expectedMessage' => 'Accepted',
            ],
            '203-Non-Authoritative Information' => [
                'statusCode' => 203,
                'expectedMessage' => 'Non-Authoritative Information',
            ],
            '204-No Content' => [
                'statusCode' => 204,
                'expectedMessage' => 'No Content',
            ],
            '205-Reset Content' => [
                'statusCode' => 205,
                'expectedMessage' => 'Reset Content',
            ],
            '206-Partial Content' => [
                'statusCode' => 206,
                'expectedMessage' => 'Partial Content',
            ],
            '207-Multi-Status' => [
                'statusCode' => 207,
                'expectedMessage' => 'Multi-Status',
            ],
            '208-Already Reported' => [
                'statusCode' => 208,
                'expectedMessage' => 'Already Reported',
            ],
            '226-IM Used' => [
                'statusCode' => 226,
                'expectedMessage' => 'IM Used',
            ],

            '300-Multiple Choices' => [
                'statusCode' => 300,
                'expectedMessage' => 'Multiple Choices',
            ],
            '301-Moved Permanently' => [
                'statusCode' => 301,
                'expectedMessage' => 'Moved Permanently',
            ],
            '302-Found' => [
                'statusCode' => 302,
                'expectedMessage' => 'Found',
            ],
            '303-See Other' => [
                'statusCode' => 303,
                'expectedMessage' => 'See Other',
            ],
            '304-Not Modified' => [
                'statusCode' => 304,
                'expectedMessage' => 'Not Modified',
            ],
            '305-Use Proxy' => [
                'statusCode' => 305,
                'expectedMessage' => 'Use Proxy',
            ],
            '306-Switch Proxy' => [
                'statusCode' => 306,
                'expectedMessage' => 'Switch Proxy',
            ],
            '307-Temporary Redirect' => [
                'statusCode' => 307,
                'expectedMessage' => 'Temporary Redirect',
            ],
            '308-Permanent Redirect' => [
                'statusCode' => 308,
                'expectedMessage' => 'Permanent Redirect',
            ],

            '400-Bad Request' => [
                'statusCode' => 400,
                'expectedMessage' => 'Bad Request',
            ],
            '401-Unauthorized' => [
                'statusCode' => 401,
                'expectedMessage' => 'Unauthorized',
            ],
            '402-Payment Required' => [
                'statusCode' => 402,
                'expectedMessage' => 'Payment Required',
            ],
            '403-Forbidden' => [
                'statusCode' => 403,
                'expectedMessage' => 'Forbidden',
            ],
            '404-Not Found' => [
                'statusCode' => 404,
                'expectedMessage' => 'Not Found',
            ],
            '405-Method Not Allowed' => [
                'statusCode' => 405,
                'expectedMessage' => 'Method Not Allowed',
            ],
            '406-Not Acceptable' => [
                'statusCode' => 406,
                'expectedMessage' => 'Not Acceptable',
            ],
            '407-Proxy Authentication Required' => [
                'statusCode' => 407,
                'expectedMessage' => 'Proxy Authentication Required',
            ],
            '408-Request Timeout' => [
                'statusCode' => 408,
                'expectedMessage' => 'Request Timeout',
            ],
            '409-Conflict' => [
                'statusCode' => 409,
                'expectedMessage' => 'Conflict',
            ],
            '410-Gone' => [
                'statusCode' => 410,
                'expectedMessage' => 'Gone',
            ],
            '411-Length Required' => [
                'statusCode' => 411,
                'expectedMessage' => 'Length Required',
            ],
            '412-Precondition Failed' => [
                'statusCode' => 412,
                'expectedMessage' => 'Precondition Failed',
            ],
            '413-Content Too Large' => [
                'statusCode' => 413,
                'expectedMessage' => 'Content Too Large',
            ],
            '414-URI Too Long' => [
                'statusCode' => 414,
                'expectedMessage' => 'URI Too Long',
            ],
            '415-Unsupported Media Type' => [
                'statusCode' => 415,
                'expectedMessage' => 'Unsupported Media Type',
            ],
            '416-Range Not Satisfiable' => [
                'statusCode' => 416,
                'expectedMessage' => 'Range Not Satisfiable',
            ],
            '417-Expectation Failed' => [
                'statusCode' => 417,
                'expectedMessage' => 'Expectation Failed',
            ],
            '418-I\'m a teapot' => [
                'statusCode' => 418,
                'expectedMessage' => 'I\'m a teapot',
            ],
            '421-Misdirected Request' => [
                'statusCode' => 421,
                'expectedMessage' => 'Misdirected Request',
            ],
            '422-Unprocessable Content' => [
                'statusCode' => 422,
                'expectedMessage' => 'Unprocessable Content',
            ],
            '423-Locked' => [
                'statusCode' => 423,
                'expectedMessage' => 'Locked',
            ],
            '424-Failed Dependency' => [
                'statusCode' => 424,
                'expectedMessage' => 'Failed Dependency',
            ],
            '425-Too Early' => [
                'statusCode' => 425,
                'expectedMessage' => 'Too Early',
            ],
            '426-Upgrade Required' => [
                'statusCode' => 426,
                'expectedMessage' => 'Upgrade Required',
            ],
            '428-Precondition Required' => [
                'statusCode' => 428,
                'expectedMessage' => 'Precondition Required',
            ],
            '429-Too Many Requests' => [
                'statusCode' => 429,
                'expectedMessage' => 'Too Many Requests',
            ],
            '431-Request Header Fields Too Large' => [
                'statusCode' => 431,
                'expectedMessage' => 'Request Header Fields Too Large',
            ],
            '451-Unavailable For Legal Reasons' => [
                'statusCode' => 451,
                'expectedMessage' => 'Unavailable For Legal Reasons',
            ],

            '500-Internal Server Error' => [
                'statusCode' => 500,
                'expectedMessage' => 'Internal Server Error',
            ],
            '501-Not Implemented' => [
                'statusCode' => 501,
                'expectedMessage' => 'Not Implemented',
            ],
            '502-Bad Gateway' => [
                'statusCode' => 502,
                'expectedMessage' => 'Bad Gateway',
            ],
            '503-Service Unavailable' => [
                'statusCode' => 503,
                'expectedMessage' => 'Service Unavailable',
            ],
            '504-Gateway Timeout' => [
                'statusCode' => 504,
                'expectedMessage' => 'Gateway Timeout',
            ],
            '505-HTTP Version Not Supported' => [
                'statusCode' => 505,
                'expectedMessage' => 'HTTP Version Not Supported',
            ],
            '506-Variant Also Negotiates' => [
                'statusCode' => 506,
                'expectedMessage' => 'Variant Also Negotiates',
            ],
            '507-Insufficient Storage' => [
                'statusCode' => 507,
                'expectedMessage' => 'Insufficient Storage',
            ],
            '508-Loop Detected' => [
                'statusCode' => 508,
                'expectedMessage' => 'Loop Detected',
            ],
            '510-Not Extended' => [
                'statusCode' => 510,
                'expectedMessage' => 'Not Extended',
            ],
            '511-Network Authentication Required' => [
                'statusCode' => 511,
                'expectedMessage' => 'Network Authentication Required',
            ],
        ];
    }

    public function testToStatusLine(): void
    {
        $this->assertSame(
            '404 Not Found',
            StatusCode::NOT_FOUND->toStatusLine()
        );

        $this->assertSame(
            '200 OK',
            StatusCode::OK->toStatusLine()
        );
    }
}
