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