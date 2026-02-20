<?php

declare(strict_types=1);

namespace Philharmony\Http\Enum;

enum Scheme: string
{
    case HTTP = 'http';
    case HTTPS = 'https';
    case WS = 'ws';
    case WSS = 'wss';
    case FTP = 'ftp';
    case SFTP = 'sftp';
    case SSH = 'ssh';
    case TELNET = 'telnet';
    case SMTP = 'smtp';
    case IMAP = 'imap';
    case POP = 'pop';
    case LDAP = 'ldap';
    case LDAPS = 'ldaps';
    case GOPHER = 'gopher';
    case NNTP = 'nntp';
    case NEWS = 'news';

    public function defaultPort(): ?int
    {
        return match ($this) {
            self::HTTP, self::WS => 80,
            self::HTTPS, self::WSS => 443,
            self::FTP => 21,
            self::SFTP, self::SSH => 22,
            self::TELNET => 23,
            self::SMTP => 25,
            self::GOPHER => 70,
            self::POP => 110,
            self::NNTP, self::NEWS => 119,
            self::IMAP => 143,
            self::LDAP => 389,
            self::LDAPS => 636,
        };
    }

    public function requiresHost(): bool
    {
        return match($this) {
            self::HTTP,
            self::HTTPS,
            self::WS,
            self::WSS,
            self::FTP,
            self::SFTP => true,
            default => false,
        };
    }

    public function isSecure(): bool
    {
        return match($this) {
            self::HTTPS, self::WSS, self::SFTP, self::LDAPS, self::SSH => true,
            default => false,
        };
    }
}
