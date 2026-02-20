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
        $this->assertSame(Scheme::HTTP, Scheme::from('http'));
        $this->assertSame(Scheme::HTTPS, Scheme::from('https'));
        $this->assertSame(Scheme::WS, Scheme::from('ws'));
        $this->assertSame(Scheme::WSS, Scheme::from('wss'));
        $this->assertSame(Scheme::FTP, Scheme::from('ftp'));
        $this->assertSame(Scheme::SFTP, Scheme::from('sftp'));
        $this->assertSame(Scheme::SSH, Scheme::from('ssh'));
        $this->assertSame(Scheme::TELNET, Scheme::from('telnet'));
        $this->assertSame(Scheme::SMTP, Scheme::from('smtp'));
        $this->assertSame(Scheme::IMAP, Scheme::from('imap'));
        $this->assertSame(Scheme::POP, Scheme::from('pop'));
        $this->assertSame(Scheme::LDAP, Scheme::from('ldap'));
        $this->assertSame(Scheme::LDAPS, Scheme::from('ldaps'));
        $this->assertSame(Scheme::GOPHER, Scheme::from('gopher'));
        $this->assertSame(Scheme::NNTP, Scheme::from('nntp'));
        $this->assertSame(Scheme::NEWS, Scheme::from('news'));
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

    #[DataProvider('schemePortProvider')]
    public function testDefaultPortReturnsCorrectValue(
        Scheme $scheme,
        int $expectedPort
    ): void {
        $this->assertSame($expectedPort, $scheme->defaultPort());
    }

    /**
     * @return array<string, array{scheme: Scheme, expectedPort:int}>
     */
    public static function schemePortProvider(): array
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
            'gopher is 110' => [
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

    #[DataProvider('secureSchemeProvider')]
    public function testIsSecureReturnsCorrectBoolean(
        Scheme $scheme,
        bool $expectedSecure
    ): void {
        $this->assertSame($expectedSecure, $scheme->isSecure());
    }

    /**
     * @return array<string, array{scheme: Scheme, expectedSecure:bool}>
     */
    public static function secureSchemeProvider(): array
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

}
