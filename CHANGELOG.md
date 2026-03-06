# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.1.0/)
and this project adheres to [Semantic Versioning](https://semver.org/).

---

## [1.2.0] - 2026-03-06

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

[1.2.0]: https://github.com/philharmonytech/http-enum/compare/v1.1.0...v1.2.0
[1.1.1]: https://github.com/philharmonytech/http-enum/compare/v1.1.0...v1.1.1
[1.1.0]: https://github.com/philharmonytech/http-enum/compare/v1.0.0...v1.1.0
[1.0.0]: https://github.com/philharmonytech/http-enum/releases/tag/v1.0.0