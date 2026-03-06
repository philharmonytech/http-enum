<?php

declare(strict_types=1);

namespace Philharmony\Http\Enum;

enum HttpHeader: string
{
    case ACCEPT = 'Accept';
    case ACCEPT_CHARSET = 'Accept-Charset';
    case ACCEPT_ENCODING = 'Accept-Encoding';
    case ACCEPT_LANGUAGE = 'Accept-Language';

    case AUTHORIZATION = 'Authorization';
    case WWW_AUTHENTICATE = 'WWW-Authenticate';
    case PROXY_AUTHENTICATE = 'Proxy-Authenticate';
    case PROXY_AUTHORIZATION = 'Proxy-Authorization';

    case CACHE_CONTROL = 'Cache-Control';
    case PRAGMA = 'Pragma';
    case EXPIRES = 'Expires';
    case AGE = 'Age';

    case CONNECTION = 'Connection';
    case KEEP_ALIVE = 'Keep-Alive';
    case UPGRADE = 'Upgrade';

    case CONTENT_TYPE = 'Content-Type';
    case CONTENT_LENGTH = 'Content-Length';
    case CONTENT_ENCODING = 'Content-Encoding';
    case CONTENT_LANGUAGE = 'Content-Language';
    case CONTENT_LOCATION = 'Content-Location';
    case CONTENT_RANGE = 'Content-Range';
    case CONTENT_DISPOSITION = 'Content-Disposition';

    case COOKIE = 'Cookie';
    case SET_COOKIE = 'Set-Cookie';

    case DATE = 'Date';
    case LAST_MODIFIED = 'Last-Modified';
    case ETAG = 'ETag';

    case HOST = 'Host';
    case LOCATION = 'Location';
    case ORIGIN = 'Origin';
    case REFERER = 'Referer';

    case USER_AGENT = 'User-Agent';
    case SERVER = 'Server';

    case RANGE = 'Range';
    case IF_MATCH = 'If-Match';
    case IF_NONE_MATCH = 'If-None-Match';
    case IF_MODIFIED_SINCE = 'If-Modified-Since';
    case IF_UNMODIFIED_SINCE = 'If-Unmodified-Since';

    case TRANSFER_ENCODING = 'Transfer-Encoding';
    case VARY = 'Vary';
    case VIA = 'Via';

    case ACCESS_CONTROL_ALLOW_ORIGIN = 'Access-Control-Allow-Origin';
    case ACCESS_CONTROL_ALLOW_METHODS = 'Access-Control-Allow-Methods';
    case ACCESS_CONTROL_ALLOW_HEADERS = 'Access-Control-Allow-Headers';
    case ACCESS_CONTROL_EXPOSE_HEADERS = 'Access-Control-Expose-Headers';
    case ACCESS_CONTROL_ALLOW_CREDENTIALS = 'Access-Control-Allow-Credentials';
    case ACCESS_CONTROL_MAX_AGE = 'Access-Control-Max-Age';

    case X_FORWARDED_FOR = 'X-Forwarded-For';
    case X_FORWARDED_PROTO = 'X-Forwarded-Proto';
    case X_FORWARDED_HOST = 'X-Forwarded-Host';
    case X_REAL_IP = 'X-Real-IP';

    public function isResponseHeader(): bool
    {
        return match ($this) {
            self::SET_COOKIE,
            self::LOCATION,
            self::SERVER,
            self::CACHE_CONTROL,
            self::CONTENT_TYPE,
            self::CONTENT_LENGTH,
            self::CONTENT_ENCODING,
            self::CONTENT_LANGUAGE,
            self::CONTENT_RANGE,
            self::CONNECTION,
            self::ETAG,
            self::LAST_MODIFIED,
            self::TRANSFER_ENCODING,
            self::VARY,
            self::WWW_AUTHENTICATE => true,
            default => false,
        };
    }

    public function isRequestHeader(): bool
    {
        return !$this->isResponseHeader();
    }

    public function isContentHeader(): bool
    {
        return match ($this) {
            self::CONTENT_TYPE,
            self::CONTENT_LENGTH,
            self::CONTENT_ENCODING,
            self::CONTENT_LANGUAGE,
            self::CONTENT_LOCATION,
            self::CONTENT_RANGE,
            self::CONTENT_DISPOSITION => true,
            default => false,
        };
    }

    public function isCors(): bool
    {
        return str_starts_with($this->value, 'Access-Control-');
    }

    public function isProxy(): bool
    {
        return str_starts_with($this->value, 'X-Forwarded-')
            || $this === self::X_REAL_IP;
    }

    public function isCacheHeader(): bool
    {
        return match ($this) {
            self::CACHE_CONTROL,
            self::PRAGMA,
            self::EXPIRES,
            self::AGE,
            self::ETAG,
            self::LAST_MODIFIED,
            self::IF_MATCH,
            self::IF_NONE_MATCH,
            self::IF_MODIFIED_SINCE,
            self::IF_UNMODIFIED_SINCE => true,
            default => false,
        };
    }

    public function isAuthHeader(): bool
    {
        return match ($this) {
            self::AUTHORIZATION,
            self::WWW_AUTHENTICATE,
            self::PROXY_AUTHENTICATE,
            self::PROXY_AUTHORIZATION => true,
            default => false,
        };
    }

    public function isSecurityHeader(): bool
    {
        return match ($this) {
            self::AUTHORIZATION,
            self::SET_COOKIE,
            self::COOKIE => true,
            default => false,
        };
    }

    public function isConditional(): bool
    {
        return match ($this) {
            self::IF_MATCH,
            self::IF_NONE_MATCH,
            self::IF_MODIFIED_SINCE,
            self::IF_UNMODIFIED_SINCE => true,
            default => false,
        };
    }

    public static function fromString(string $header): self
    {
        return self::from(self::normalize($header));
    }

    public static function tryFromString(string $header): ?self
    {
        return self::tryFrom(self::normalize($header));
    }

    private static function normalize(string $header): string
    {
        $header = strtolower($header);

        return implode('-', array_map(
            'ucfirst',
            explode('-', $header)
        ));
    }
}
