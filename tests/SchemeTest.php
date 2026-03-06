<?php

declare(strict_types=1);

namespace Philharmony\Http\Enum\Tests;

use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;
use Philharmony\Http\Enum\Scheme;
use ValueError;

class SchemeTest extends TestCase
{
    public function testFromReturnsCorrectCase(): void
    {
        foreach (Scheme::cases() as $case) {
            $this->assertSame($case, Scheme::from($case->value));
        }
    }

    public function testTryFromReturnsCorrectCase(): void
    {
        foreach (Scheme::cases() as $case) {
            $this->assertSame($case, Scheme::tryFrom($case->value));
        }
    }

    public function testTryFromReturnsNullForInvalidValues(): void
    {
        $invalid = ['invalid-proto', '', 'IMAP', 'git+ssh',];
        foreach ($invalid as $value) {
            $this->assertNull(Scheme::tryFrom($value));
        }
    }

    public function testFromThrowsOnInvalidValue(): void
    {
        $this->expectException(ValueError::class);
        Scheme::from('INVALID');
    }

    public function testFromIsCaseSensitive(): void
    {
        $this->expectException(ValueError::class);
        Scheme::from('HTTP');
    }

    public function testTryFromIsCaseSensitive(): void
    {
        $this->assertNull(Scheme::tryFrom('HTTP'));
        $this->assertNull(Scheme::tryFrom('Smtp'));
        $this->assertNull(Scheme::tryFrom('POP '));
        $this->assertNull(Scheme::tryFrom(''));
    }

    public function testTryFromStringIsCaseInsensitive(): void
    {
        $this->assertSame(Scheme::HTTP, Scheme::tryFromString('HTTP'));
        $this->assertSame(Scheme::SMTP, Scheme::tryFromString('SMTP'));
    }

    public function testFromStringIsCaseInsensitive(): void
    {
        $this->assertSame(Scheme::HTTPS, Scheme::fromString('HTTPS'));
        $this->assertSame(Scheme::IMAP, Scheme::fromString('IMAP'));
    }

    #[DataProvider('schemePortDataProvider')]
    public function testDefaultPort(
        Scheme $scheme,
        int $expectedPort
    ): void {
        $this->assertSame($expectedPort, $scheme->defaultPort());
        $this->assertTrue($scheme->isDefaultPort($expectedPort));
    }

    /**
     * @return array<string, array{scheme: Scheme, expectedPort:int}>
     */
    public static function schemePortDataProvider(): array
    {
        return [
            'http is 80' => [
                'scheme' => Scheme::HTTP,
                'expectedPort' => 80,
            ],
            'https is 443' => [
                'scheme' => Scheme::HTTPS,
                'expectedPort' => 443,
            ],
            'ws is 80' => [
                'scheme' => Scheme::WS,
                'expectedPort' => 80,
            ],
            'wss is 443' => [
                'scheme' => Scheme::WSS,
                'expectedPort' => 443,
            ],
            'ftp is 21' => [
                'scheme' => Scheme::FTP,
                'expectedPort' => 21,
            ],
            'sftp is 22' => [
                'scheme' => Scheme::SFTP,
                'expectedPort' => 22,
            ],
            'ssh is 22' => [
                'scheme' => Scheme::SSH,
                'expectedPort' => 22,
            ],
            'telnet is 23' => [
                'scheme' => Scheme::TELNET,
                'expectedPort' => 23,
            ],
            'smtp is 25' => [
                'scheme' => Scheme::SMTP,
                'expectedPort' => 25,
            ],
            'gopher is 70' => [
                'scheme' => Scheme::GOPHER,
                'expectedPort' => 70,
            ],
            'pop is 110' => [
                'scheme' => Scheme::POP,
                'expectedPort' => 110,
            ],
            'nntp is 119' => [
                'scheme' => Scheme::NNTP,
                'expectedPort' => 119,
            ],
            'news is 119' => [
                'scheme' => Scheme::NEWS,
                'expectedPort' => 119,
            ],
            'imap is 143' => [
                'scheme' => Scheme::IMAP,
                'expectedPort' => 143,
            ],
            'ldap is 389' => [
                'scheme' => Scheme::LDAP,
                'expectedPort' => 389,
            ],
            'ldaps is 143' => [
                'scheme' => Scheme::LDAPS,
                'expectedPort' => 636,
            ],
        ];
    }

    #[DataProvider('requiresHostDataProvider')]
    public function testRequiresHostCorrectBoolean(
        Scheme $scheme,
        bool $expectedRequiresHost
    ): void {
        $this->assertSame($expectedRequiresHost, $scheme->requiresHost());
    }

    /**
     * @return array<string, array{scheme: Scheme, expectedRequiresHost:bool}>
     */
    public static function requiresHostDataProvider(): array
    {
        return [
            'http is require host' => [
                'scheme' => Scheme::HTTP,
                'expectedRequiresHost' => true,
            ],
            'https is require host' => [
                'scheme' => Scheme::HTTPS,
                'expectedRequiresHost' => true,
            ],
            'ws is require host' => [
                'scheme' => Scheme::WS,
                'expectedRequiresHost' => true,
            ],
            'wss is require host' => [
                'scheme' => Scheme::WSS,
                'expectedRequiresHost' => true,
            ],
            'ftp is require host' => [
                'scheme' => Scheme::FTP,
                'expectedRequiresHost' => true,
            ],
            'sftp is require host' => [
                'scheme' => Scheme::SFTP,
                'expectedRequiresHost' => true,
            ],
            'ldap is not require host' => [
                'scheme' => Scheme::LDAP,
                'expectedRequiresHost' => false,
            ],
            'ldaps is not require host' => [
                'scheme' => Scheme::LDAPS,
                'expectedRequiresHost' => false,
            ],
            'imap is not require host' => [
                'scheme' => Scheme::IMAP,
                'expectedRequiresHost' => false,
            ],
            'smtp is not require host' => [
                'scheme' => Scheme::SMTP,
                'expectedRequiresHost' => false,
            ],
            'POP is not require host' => [
                'scheme' => Scheme::POP,
                'expectedRequiresHost' => false,
            ],
        ];
    }

    #[DataProvider('secureSchemeDataProvider')]
    public function testIsSecureReturnsCorrectBoolean(
        Scheme $scheme,
        bool $expectedSecure
    ): void {
        $this->assertSame($expectedSecure, $scheme->isSecure());
    }

    /**
     * @return array<string, array{scheme: Scheme, expectedSecure:bool}>
     */
    public static function secureSchemeDataProvider(): array
    {
        return [
            'http is not secure' => [
                'scheme' => Scheme::HTTP,
                'expectedSecure' => false,
            ],
            'https is secure' => [
                'scheme' => Scheme::HTTPS,
                'expectedSecure' => true,
            ],
            'ws is not secure' => [
                'scheme' => Scheme::WS,
                'expectedSecure' => false,
            ],
            'wss is secure' => [
                'scheme' => Scheme::WSS,
                'expectedSecure' => true,
            ],
            'ftp is not secure' => [
                'scheme' => Scheme::FTP,
                'expectedSecure' => false,
            ],
            'sftp is secure' => [
                'scheme' => Scheme::SFTP,
                'expectedSecure' => true,
            ],
            'ldap is not secure' => [
                'scheme' => Scheme::LDAP,
                'expectedSecure' => false,
            ],
            'ldaps is secure' => [
                'scheme' => Scheme::LDAPS,
                'expectedSecure' => true,
            ],
        ];
    }

    public function testIsHttp(): void
    {
        foreach (Scheme::cases() as $type) {
            $expected = in_array($type, [Scheme::HTTPS, Scheme::HTTP,], true);

            $this->assertSame($expected, $type->isHttp());
        }
    }

    public function testIsWebSocket(): void
    {
        foreach (Scheme::cases() as $type) {
            $expected = in_array($type, [Scheme::WS, Scheme::WSS,], true);

            $this->assertSame($expected, $type->isWebSocket());
        }
    }

    public function testIsMail(): void
    {
        foreach (Scheme::cases() as $type) {
            $expected = in_array($type, [Scheme::SMTP, Scheme::IMAP, Scheme::POP], true);

            $this->assertSame($expected, $type->isMail());
        }
    }

    public function testIsLdap(): void
    {
        foreach (Scheme::cases() as $type) {
            $expected = in_array($type, [Scheme::LDAP, Scheme::LDAPS,], true);

            $this->assertSame($expected, $type->isLdap());
        }
    }
}
