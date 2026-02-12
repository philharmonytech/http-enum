# philharmony/http-enum

[![CI](https://github.com/philharmonytech/http-enum/actions/workflows/ci.yml/badge.svg)](https://github.com/philharmonytech/http-enum/actions/workflows/ci.yml)
[![PHP Version](https://img.shields.io/badge/PHP-8.1%20to%208.4-8892BF.svg)](https://www.php.net/supported-versions.php)
[![Latest Stable Version](https://img.shields.io/github/v/release/philharmonytech/http-enum?label=stable)](https://github.com/philharmonytech/http-enum/releases)
[![Total Downloads](https://img.shields.io/packagist/dt/philharmony/http-enum)](https://packagist.org/packages/philharmony/http-enum)
[![License](https://img.shields.io/packagist/l/philharmony/http-enum)](https://github.com/philharmonytech/http-enum/blob/main/LICENSE)

Type-safe HTTP enums for PHP: methods, status codes, and content types — designed for modern applications and libraries.

## 📦 Description

`philharmony/http-enum` provides a set of **strictly typed, PSR-compliant enums** for common HTTP concepts:

- `HttpMethod` — standard HTTP request methods
- `StatusCode` — HTTP status codes with semantic grouping
- `ContentType` — common media types for responses and requests

Built for **clean, expressive, and safe code**, this lightweight library requires no dependencies beyond PHP 8.1+ and is ideal for frameworks, middleware, and reusable components.

## 🛠 Installation

Install via Composer:

```bash
composer require philharmony/http-enum
```

## 🧪 Usage
### HTTP Methods
```php
use Philharmony\Http\Enum\HttpMethod;

$method = HttpMethod::POST;

if ($method->isSafe()) {
    // Handle safe methods (GET, HEAD, etc.)
}

if ($method->isIdempotent()) {
    // Handle idempotent methods (GET, PUT, DELETE, etc.)
}
```
### Status Codes
```php
use Philharmony\Http\Enum\StatusCode;

$status = StatusCode::NOT_FOUND;

if ($status->isClientError()) {
    // 4xx — client-side error
}

if ($status->isServerError()) {
    // 5xx — server-side error
}

if ($status->isSuccess()) {
    // 2xx — success
}
```

### Content Types
```php
use Philharmony\Http\Enum\ContentType;

$contentType = ContentType::APPLICATION_JSON;

header('Content-Type: ' . $contentType->value);

if ($contentType->isTextBased()) {
    // Handle text-like responses (JSON, HTML, etc.)
}

if ($contentType->isImage()) {
    // Handle image types
}
```

## 📚 Enum Methods

Each enum provides a set of utility methods for semantic checks, parsing, and grouping — enabling expressive, safe, and framework-agnostic HTTP handling.

### `HttpMethod`

Represents standard HTTP request methods as a backed enum (`string`).

| Method | Description |
|-------|-------------|
| `isSafe(): bool` | Returns `true` for safe methods: `GET`, `HEAD`, `OPTIONS`, `TRACE` |
| `isIdempotent(): bool` | Returns `true` for idempotent methods: `GET`, `HEAD`, `PUT`, `DELETE`, `OPTIONS`, `TRACE`, `CONNECT` |
| `isValid(string $method): bool` | Checks if the given string is a valid HTTP method (case-sensitive) |
| `from(string $value)` | Built-in (PHP 8.1+) — creates an instance from a valid method string |
| `tryFrom(string $value)` | Built-in (PHP 8.1+) — returns `null` if invalid |

> Example: `HttpMethod::isValid('POST')` → `true`

---

### `StatusCode`

Represents HTTP status codes as a backed enum (`int`) with semantic grouping and standard reason phrases.

| Method | Description |
|-------|-------------|
| `isInformational(): bool` | `1xx` (100–199) |
| `isSuccess(): bool` | `2xx` (200–299) |
| `isRedirection(): bool` | `3xx` (300–399) |
| `isClientError(): bool` | `4xx` (400–499) |
| `isServerError(): bool` | `5xx` (500–599) |
| `isClientOrServerError(): bool` | `4xx` or `5xx` — indicates an error condition |
| `phrase(): string` | Returns the standard reason phrase (e.g., `OK` → `"OK"`, `I_M_A_TEAPOT` → `"I'm a teapot"`) |
| `from(int $code)` | Built-in — creates from status code |
| `tryFrom(int $code)` | Built-in — returns `null` if invalid |

#### Static Group Methods (return `StatusCode[]`):
- `informational()` — all `1xx`
- `success()` — all `2xx`
- `redirection()` — all `3xx`
- `clientError()` — all `4xx`
- `serverError()` — all `5xx`
- `clientOrServerError()` — all `4xx` and `5xx`

> Example: `StatusCode::NOT_FOUND->isClientError()` → `true`

---

### `ContentType`

Represents media types as a backed enum (`string`) with parsing and detection utilities.

| Method | Description |
|-------|-------------|
| `isTextBased(): bool` | `text/*`, `application/json`, `application/xml`, `application/javascript`, etc. |
| `isJson(): bool` | `application/json`, `application/hal+json`, `application/problem+json`, etc. |
| `isImage(): bool` | `image/*` |
| `isAudio(): bool` | `audio/*` |
| `isVideo(): bool` | `video/*` |
| `isMedia(): bool` | `image/*`, `audio/*`, `video/*` |
| `isFont(): bool` | `font/woff`, `font/woff2`, `font/ttf`, `font/otf` |
| `isForm(): bool` | `application/x-www-form-urlencoded`, `multipart/form-data` |
| `isBinary(): bool` | Includes media, fonts, PDF, ZIP, Protobuf, etc. |
| `fromHeader(string $header): ?self` | Parses from `Content-Type` header (ignores parameters like `; charset=utf-8`) |
| `fromExtension(string $extension): ?self` | Maps file extension (e.g., `.json`, `.png`) to content type |
| `from(string $value)` | Built-in — creates from MIME type |
| `tryFrom(string $value)` | Built-in — returns `null` if invalid |

#### Static Group Methods (return `ContentType[]`):
- `textBased()`, `json()`, `image()`, `audio()`, `video()`, `media()`, `font()`, `form()`, `binary()`

> Example: `ContentType::fromHeader('application/json; charset=utf-8')` → `ContentType::JSON`

## 📄 License
This package is open-source and licensed under the MIT License. See the [LICENSE](LICENSE) file for details.