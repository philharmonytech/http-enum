<?php

declare(strict_types=1);

namespace Philharmony\Http\Enum;

enum HttpVersion: string
{
    case HTTP_1_0 = '1.0';
    case HTTP_1_1 = '1.1';
    case HTTP_2   = '2';
    case HTTP_3   = '3';

    public function toProtocolString(): string
    {
        return \sprintf('HTTP/%s', $this->value);
    }

    public static function fromProtocol(string $protocol): ?self
    {
        $protocol = strtoupper(trim($protocol));

        if (!str_starts_with($protocol, 'HTTP/')) {
            return null;
        }

        return self::tryFrom(substr($protocol, 5));
    }

    public static function fromString(string $version): self
    {
        return self::from(trim($version));
    }

    public static function tryFromString(string $version): ?self
    {
        return self::tryFrom(trim($version));
    }
}
