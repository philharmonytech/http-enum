# philharmony/http-enum

[![Validate](https://github.com/philharmonytech/http-enum/actions/workflows/ci.yml/badge.svg?job=validate)](https://github.com/philharmonytech/http-enum/actions/workflows/ci.yml)
[![Static Analysis](https://github.com/philharmonytech/http-enum/actions/workflows/ci.yml/badge.svg?job=static-analysis)](https://github.com/philharmonytech/http-enum/actions/workflows/ci.yml)
[![Test](https://github.com/philharmonytech/http-enum/actions/workflows/ci.yml/badge.svg?job=tests)](https://github.com/philharmonytech/http-enum/actions/workflows/ci.yml)
[![codecov](https://codecov.io/github/philharmonytech/http-enum/graph/badge.svg?token=JVGM1RRACK)](https://codecov.io/github/philharmonytech/http-enum)
[![PHP Version](https://img.shields.io/badge/PHP-8.1%20to%208.4-8892BF.svg)](https://www.php.net/supported-versions.php)
[![Latest Stable Version](https://img.shields.io/github/v/release/philharmonytech/http-enum?label=stable)](https://github.com/philharmonytech/http-enum/releases)
[![Total Downloads](https://img.shields.io/packagist/dt/philharmony/http-enum)](https://packagist.org/packages/philharmony/http-enum)
[![License](https://img.shields.io/packagist/l/philharmony/http-enum)](https://github.com/philharmonytech/http-enum/blob/main/LICENSE)

Type-safe HTTP enums for PHP: methods, status codes, content types and scheme — designed for modern applications and libraries.

## 📖 Description

`philharmony/http-enum` provides a set of **strictly typed, PSR-compliant enums** for common HTTP concepts:

- `HttpMethod` — standard HTTP request methods
- `StatusCode` — HTTP status codes with semantic grouping
- `ContentType` — common media types for responses and requests
- `Scheme` — URI schemes with default port mapping (RFC 3986 compliant)

Built for **clean, expressive, and safe code**, this lightweight library requires no dependencies beyond PHP 8.1+ and is ideal for frameworks, middleware, and reusable components.

## 📦 Installation

Install via Composer:

```bash
composer require philharmony/http-enum
```

## ⚙️ Requirements

- PHP 8.1 or higher

## 🚀 Usage

### HTTP Methods

```php
use Philharmony\Http\Enum\HttpMethod;

$method = HttpMethod::POST;

if ($method->isSafe()) { /* Handle GET, HEAD... */ }
if ($method->isIdempotent()) { /* Handle PUT, DELETE... */ }
if ($method->isCacheable()) { /* Handle GET, HEAD */ }
if ($method->isReadOnly()) { /* Handle GET, HEAD, OPTION, TRACE */ }
if ($method->isWriteOnly()) { /* Handle POST, PUT, PATCH, DELETE, CONNECT */ }
if ($method->usuallyHasBody()) { /* POST, PUT, PATCH -> true, other false */ }
if ($method->allowsBody()) { /* POST, PUT, PATCH, DELETE -> true, other false */ }
```

### Status Codes

```php
use Philharmony\Http\Enum\StatusCode;

$status = StatusCode::NOT_FOUND;

if ($status->isInformational()) { /* 1xx */ }
if ($status->isSuccess()) { /* 2xx */ }
if ($status->isRedirection()) { /* 3xx */ }
if ($status->isClientError()) { /* 4xx */ }
if ($status->isServerError()) { /* 5xx */ }
if ($status->isError()) { /* 4xx and 5xx */ }
if ($status->phrase() === 'Not Found') { /* Semantic phrases */ }

echo StatusCode::NOT_FOUND->toStatusLine(); // 404 Not Found
```

### Content Types

```php
use Philharmony\Http\Enum\ContentType;

$contentType = ContentType::JSON;
header('Content-Type: ' . $contentType->value);

if ($contentType->isTextBased()) { /* Handle text-like responses (JSON, HTML, etc.) */ }
if ($contentType->isJson()) { /* Handle json types */ }
if ($contentType->isXml()) { /* Handle xml types */ }
if ($contentType->isImage()) { /* Handle image types */ }
if ($contentType->isAudio()) { /* Handle audio types */ }
if ($contentType->isVideo()) { /* Handle video types */ }
if ($contentType->isMedia()) { /* Handle audio, video and image types */ }
if ($contentType->isFont()) { /* Handle font types */ }
if ($contentType->isForm()) { /* Handle for form types */ }
if ($contentType->isBinary()) { /* Handle for binary types */ }
if ($contentType->isScript()) { /* Handle for script type */ }
if ($contentType->isArchive()) { /* Handle for archive type */ }

$type = ContentType::fromHeader('application/json; charset=utf-8');
if ($type?->isJson()) { /* Handle JSON */ }

$type = ContentType::fromExtension('txt');
header('Content-Type: ' . $type->value);

echo ContentType::JSON->baseType(); // 'json'
echo ContentType::MP4->category(); // 'video'
echo ContentType::JSON->is('application/json'); // true
echo ContentType::JSON->is('APPLICATION/JSON'); // true
echo ContentType::JSON->matches('application/*');  // true
echo ContentType::PNG->matches('image/*');        // true
```

### URI Schemes & Ports

```php
use Philharmony\Http\Enum\Scheme;

$scheme = Scheme::HTTPS;
echo $scheme->defaultPort(); // 443

if ($scheme->isSecure()) { /* Logic for secure connection (SSL/TLS) */ }
if ($scheme->requiresHost()) { /* Logic for requires host */ }
if ($scheme->isHttp()) { /* Handle HTTP, HTTPS */ }
if ($scheme->isWebSocket()) { /* Handle WS, WSS */ }
if ($scheme->isMail()) { /* Handle IMAP, POP, SMTP */ }
if ($scheme->isLdap()) { /* Handle LDAP, LDAPS */ }
```

### HTTP Headers

```php
use Philharmony\Http\Enum\HttpHeader;

$header = HttpHeader::CONTENT_TYPE;

if ($header->isContentHeader()) { /* Handle content headers */ }
if ($header->isCacheHeader()) { /* Handle caching logic */ }
if ($header->isAuthHeader()) { /* Handle authentication */ }
if ($header->isSecurityHeader()) { /* Sensitive headers */ }
if ($header->isCors()) { /* CORS headers */ }
if ($header->isProxy()) { /* Proxy / forwarded headers */ }
if ($header->isConditional()) { /* Conditional requests */ }

$header = HttpHeader::fromString('content-type');

echo $header->value; // Content-Type

// HttpHeader::X_FORWARDED_FOR
$header = HttpHeader::tryFromString('x-forwarded-for');
```

## ✨ Enum Methods

Each enum provides a set of utility methods for semantic checks, parsing, and grouping — enabling expressive, safe, and framework-agnostic HTTP handling.

### 🏷️ `HttpMethod`

Represents standard HTTP request methods as a backed enum (`string`).

| Method                          | Description                                                                                          |
|---------------------------------|------------------------------------------------------------------------------------------------------|
| `isSafe(): bool`                | Returns `true` for safe methods: `GET`, `HEAD`, `OPTIONS`, `TRACE`                                   |
| `isIdempotent(): bool`          | Returns `true` for idempotent methods: `GET`, `HEAD`, `PUT`, `DELETE`, `OPTIONS`, `TRACE`, `CONNECT` |
| `isCacheable(): bool`           | Returns `true` for cacheable methods: `GET`, `HEAD`                                                  |
| `isReadOnly(): bool`            | Returns `true` for read only methods: `GET`, `HEAD`, `OPTIONS`, `TRACE`                              |
| `isWriteOnly(): bool`           | Returns `true` for write only methods: `POST`, `PUT`, `PATCH`, `DELETE`, `CONNECT`                   |
| `usuallyHasBody(): bool`        | Returns `true` for write only methods: `POST`, `PUT`, `PATCH`                                        |
| `allowsBody(): bool`            | Returns `true` for write only methods: `POST`, `PUT`, `PATCH`, `DELETE`                              |
| `isValid(string $method): bool` | Checks if the given string is a valid HTTP method (case-sensitive)                                   |
| `fromString(string $value)`     | Creates an instance from a valid method string - used strtoupper for value and from()                |
| `tryFromString(string $value)`  | Creates an instance from a valid method string - used strtoupper for value and tryFrom()             |
| `from(string $value)`           | Built-in (PHP 8.1+) — creates an instance from a valid method string                                 |
| `tryFrom(string $value)`        | Built-in (PHP 8.1+) — returns `null` if invalid                                                      |

> Example: `HttpMethod::isValid('POST')` → `true`
> Example: `HttpMethod::tryFromString('post')` → `HttpMethod::POST`

---

### 🔢 `StatusCode`

Represents HTTP status codes as a backed enum (`int`) with semantic grouping and standard reason phrases.

| Method                      | Description                                                                                 |
|-----------------------------|---------------------------------------------------------------------------------------------|
| `isInformational(): bool`   | `1xx` (100–199)                                                                             |
| `isSuccess(): bool`         | `2xx` (200–299)                                                                             |
| `isRedirection(): bool`     | `3xx` (300–399)                                                                             |
| `isClientError(): bool`     | `4xx` (400–499)                                                                             |
| `isServerError(): bool`     | `5xx` (500–599)                                                                             |
| `isError(): bool`           | `4xx` or `5xx` — indicates an error condition                                               |
| `phrase(): string`          | Returns the standard reason phrase (e.g., `OK` → `"OK"`, `I_M_A_TEAPOT` → `"I'm a teapot"`) |
| `toStatusLine(): string`    | Returns full status line fragment like `404 Not Found`                                      |
| `from(int $code)`           | Built-in — creates from status code                                                         |
| `tryFrom(int $code)`        | Built-in — returns `null` if invalid                                                        |

#### Static Group Methods (return `StatusCode[]`):
- `informational()` — all `1xx`
- `success()` — all `2xx`
- `redirection()` — all `3xx`
- `clientError()` — all `4xx`
- `serverError()` — all `5xx`
- `error()` — all `4xx` and `5xx`

> Example: `StatusCode::NOT_FOUND->isClientError()` → `true`

---

### 📝 `ContentType`

Represents media types as a backed enum (`string`) with parsing and detection utilities.

| Method                                    | Description                                                                                     |
|-------------------------------------------|-------------------------------------------------------------------------------------------------|
| `isTextBased(): bool`                     | `text/*`, `application/json`, `application/xml`, `application/javascript`, etc.                 |
| `isJson(): bool`                          | `application/json`, `application/hal+json`, `application/problem+json`, etc.                    |
| `isXml(): bool`                           | `application/xml`, `application/atom+xml`, `application/rss+xml`, `application/xhtml+xml`, etc. |
| `isImage(): bool`                         | `image/*`                                                                                       |
| `isAudio(): bool`                         | `audio/*`                                                                                       |
| `isVideo(): bool`                         | `video/*`                                                                                       |
| `isMedia(): bool`                         | `image/*`, `audio/*`, `video/*`                                                                 |
| `isFont(): bool`                          | `font/woff`, `font/woff2`, `font/ttf`, `font/otf`                                               |
| `isForm(): bool`                          | `application/x-www-form-urlencoded`, `multipart/form-data`                                      |
| `isBinary(): bool`                        | Includes media, fonts, PDF, ZIP, Protobuf, etc.                                                 |
| `isScript(): bool`                        | `application/javascript`                                                                        |
| `isArchive(): bool`                       | `application/zip`                                                                               |
| `baseType(): string`                      | Returns base subtype (e.g. `application/json` → `json`)                                         |
| `category(): string`                      | Returns MIME category (e.g. `json`, `image`, `video`, `audio`, `text`)                          |
| `is(): bool`                              | Case-insensitive exact match for MIME type                                                      |
| `matches(): bool`                         | Pattern match like `image/*`, `application/*`                                                   |
| `fromHeader(string $header): ?self`       | Parses from `Content-Type` header (ignores parameters like `; charset=utf-8`)                   |
| `fromExtension(string $extension): ?self` | Maps file extension (e.g., `.json`, `.png`) to content type                                     |
| `from(string $value)`                     | Built-in — creates from MIME type                                                               |
| `tryFrom(string $value)`                  | Built-in — returns `null` if invalid                                                            |

#### Static Group Methods (return `ContentType[]`):
- `textBased()`, 
- `json()`, 
- `xml()`,
- `image()`, 
- `audio()`, 
- `video()`, 
- `media()`, 
- `font()`, 
- `form()`, 
- `binary()`

> Example: `ContentType::fromHeader('application/json; charset=utf-8')` → `ContentType::JSON`

### 🌐 `Scheme`

Represents URI schemes as a backed enum (string) with port mapping.

| Method                 | Description                                                                                 |
|------------------------|---------------------------------------------------------------------------------------------|
| `defaultPort(): ?int`  | Returns standard port (e.g., `HTTP` → `80`, `HTTPS` → `443`, `LDAPS` → `636`)               |
| `isSecure(): bool`     | Returns `true` for secure protocols: `HTTPS`, `WSS`, `SFTP`, `LDAPS`, `SSH`                 |
 | `requiresHost(): bool` | Returns `true` for schemes that require a host: `HTTP`, `HTTPS`, `WS`, `WSS`, `FTP`, `SFTP` |
| `isHttp(): bool`       | Returns `true` for `HTTP`, `HTTPS`                                                          |
| `isWebSocket(): bool`  | Returns `true` for `WS`, `WSS`                                                              |
| `isMail(): bool`       | Returns `true` for `SMTP`, `IMAP`, `POP`                                                    |
| `isLdap(): bool`       | Returns `true` for `LDAP`, `LDAPS`                                                          |

### 📨 `HttpHeader`

Represents common HTTP headers as a backed enum (`string`) with semantic grouping and normalization utilities.

| Method                                     | Description                                                          |
|--------------------------------------------|----------------------------------------------------------------------|
| `isRequestHeader(): bool`                  | Returns `true` if header is typically used in HTTP requests          |
| `isResponseHeader(): bool`                 | Returns `true` if header is typically used in HTTP responses         |
| `isContentHeader(): bool`                  | `Content-*` headers (`Content-Type`, `Content-Length`, etc.)         |
| `isCors(): bool`                           | `Access-Control-*` headers                                           |
| `isProxy(): bool`                          | Proxy headers (`X-Forwarded-*`, `X-Real-IP`)                         |
| `isCacheHeader(): bool`                    | Cache-related headers (`Cache-Control`, `ETag`, `Expires`, etc.)     |
| `isAuthHeader(): bool`                     | Authentication headers (`Authorization`, `WWW-Authenticate`, etc.)   |
| `isSecurityHeader(): bool`                 | Security-sensitive headers (`Authorization`, `Cookie`, `Set-Cookie`) |
| `isConditional(): bool`                    | Conditional request headers (`If-Match`, `If-None-Match`, etc.)      |
| `fromString(string $header): self`         | Creates enum from header name with normalization                     |
| `tryFromString(string $header): ?self`     | Safe version returning `null` if header is unknown                   |
| `from(string $value)`                      | Built-in — creates from header string                                |
| `tryFrom(string $value)`                   | Built-in — returns `null` if invalid                                 |

> Example: `HttpHeader::fromString('content-type')` → `HttpHeader::CONTENT_TYPE`


## 🧪 Testing

The package is strictly tested with PHPUnit 10 to ensure full compliance with HTTP standards and RFCs.

### Run Tests

```bash
composer test
```

### Code Coverage

```bash
composer test:coverage
```

## 🏗️ Static Analysis & Code Style

Verified with PHPStan Level 9 to ensure total type safety and prevent runtime errors.

```bash
composer phpstan
```

Check and fix code style (PSR-12):

```bash
composer cs-check
composer cs-fix
```

## 📄 License

This package is open-source and licensed under the MIT License. See the [LICENSE](LICENSE) file for details.