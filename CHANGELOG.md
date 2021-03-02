# Changelog

All notable changes to this project will be documented in this file.

## [0.1.0] - 2021-03-03

### Added

 * Response classes implements [`JsonSerializable`](https://www.php.net/JsonSerializable).
 * Response classes implements [`__debugInfo()`](https://www.php.net/manual/language.oop5.magic.php#object.debuginfo) magic method.
 * Add `Corporation` class instead of associative arrays.

### Changed

 * Rename `src/functions.php` to `src/kenall.php`
 * Class name follows the same as [kenall-js v1.0.5](https://github.com/KEN-ALL/kenall-js/releases/tag/v1.0.5)
   * Response classes move into `zonuexe\Kenall\Response\V1` namespace.
   * `Response/Area` => `Response\V1/Address`
   * `Response/PostalCodeResponse` -> `Response/V1/AddressResolverResponse`

### Fixed

 * Fix typing for `Corporation`.
