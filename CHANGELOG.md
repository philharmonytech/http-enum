# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.1.0/)
and this project adheres to [Semantic Versioning](https://semver.org/).

---

## [1.3.0] - 2026-03-14

### Fixed
- Header and auth scheme parsing is now case-insensitive and trims input.
- `ContentType::fromExtension()` now accepts extensions with a leading dot (e.g. `.json`).
- `Scheme::fromString()` and `tryFromString()` now trim whitespace.
- HTTP status reason phrase for 413 is now `Payload Too Large`.

### Changed
- `HttpHeader::isRequestHeader()` now treats general headers as valid for requests.
- Added `HttpHeader::isRequestOnly()` and `HttpHeader::isResponseOnly()`.
- Added `HttpHeader::isHopByHop()` with RFC 7230 hop-by-hop headers.
- Added `HttpHeader::TE` and `HttpHeader::TRAILER` enum cases.
- Added `StatusCode::statusClass()` and `StatusCode::category()`.
- Added `StatusCode::isCacheable()` for RFC 9111 cacheable-by-default statuses.
- Added `ContentType` helpers: `fromFilename()`, `isCompressible()`, `defaultCharset()`, and `negotiate()`.

### Tests
- Added tests for header/auth scheme parsing edge cases and dot-prefixed extensions.

---

## [1.2.0] - 2026-03-07

### Added
- Added new HTTP enums:
    - `HttpHeader`
    - `AuthScheme`
    - `HttpVersion`
    - `CacheDirective`
    - `ContentEncoding`
    - `SameSite`

### Improved
- Improved existing enums:
    - `HttpMethod`
    - `StatusCode`
    - `ContentType`
    - `Scheme`

### Documentation
- Expanded README with:
    - usage examples for all enums
    - full enum method reference
    - RFC compliance section
    - feature overview

### Tests
- Added PHPUnit tests for new enums
- Improved test coverage

---

## [1.1.1] - 2026-03-01

### Fixed
- Minor improvements and internal fixes in enums.

---

## [1.1.0] - 2026-02-25

### Added
- `ContentType` enum
- `Scheme` enum
- `StatusCode` enum
- `HttpMethod` enum

### Improved
- Better HTTP-related enum organization.

---

## [1.0.0] - 2026-02-20

### Added
- Initial release of the library.
- Core HTTP enums implementation.

[1.3.0]: https://github.com/philharmonytech/http-enum/compare/v1.2.0...v1.3.0
[1.2.0]: https://github.com/philharmonytech/http-enum/compare/v1.1.0...v1.2.0
[1.1.1]: https://github.com/philharmonytech/http-enum/compare/v1.1.0...v1.1.1
[1.1.0]: https://github.com/philharmonytech/http-enum/compare/v1.0.0...v1.1.0
[1.0.0]: https://github.com/philharmonytech/http-enum/releases/tag/v1.0.0
