# MiniSnowflake

[![License](https://img.shields.io/badge/license-MIT-blue.svg)](LICENSE)

A lightweight, case-insensitive, 9-character unique ID generator based on a mini Snowflake algorithm, written in PHP.

Built for high-performance systems needing short, collision-resistant IDs without long UUIDs.

---

## Features

- ✅ 9-character alphanumeric IDs
- ✅ Based on a customizable epoch (like Twitter Snowflake)
- ✅ No collision up to 256 IDs per millisecond
- ✅ Case-insensitive for user input
- ✅ Optional CLI tool for generating IDs
- ✅ Fully unit-tested with PHPUnit
- ✅ PSR-4 autoloaded, Composer ready

---

## Installation

Install via Composer:

```bash
composer require marcinjean/minisnowflake
```

---

## Basic Usage

```php
use MarcinJean\MiniSnowflake\MiniSnowflake;

// Generate a new ID
$id = MiniSnowflake::generateId();

echo $id; // Example: "00D2D87XE"

// Validate an ID
if (MiniSnowflake::isValidId($id)) {
    echo "ID is valid!";
}

// Decode an ID
$data = MiniSnowflake::decodeId($id);

print_r($data);
/*
Array
(
    [timestamp] => 1714256780000
    [datetime] => 2025-04-27 22:19:40
    [sequence] => 123
)
*/
```

---

## Custom Epoch

By default, IDs are generated relative to **January 1st, 2025**.

You can **customize the epoch** globally:

```php
// Set a custom epoch (in milliseconds)
MiniSnowflake::setEpoch(strtotime('2024-01-01 00:00:00') * 1000);

// Reset to default epoch (2025-01-01)
MiniSnowflake::resetEpoch();
```

Or pass a **custom epoch per call**:

```php
$customEpoch = strtotime('2023-01-01 00:00:00') * 1000;

$id = MiniSnowflake::generateId($customEpoch);
$data = MiniSnowflake::decodeId($id, $customEpoch);
```

---

## CLI Usage

After installing:

```bash
php bin/generate-id.php
```

Example output:

```
Generated ID: 00D2D87XE
Decoded Info:
- Timestamp: 1714256780000
- Datetime: 2025-04-27 22:19:40
- Sequence: 123
```

You can also specify a custom epoch:

```bash
php bin/generate-id.php --epoch=1704067200000
```

---

## Running Tests

This package is fully unit-tested with PHPUnit.

Install dev dependencies:

```bash
composer install
```

Run tests:

```bash
composer test
```

You should see:

```
OK (4 tests, 10 assertions)
```

---

## License

This package is open-sourced software licensed under the [MIT license](LICENSE).

---

