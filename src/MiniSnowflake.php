<?php
namespace MarcinJean\MiniSnowflake;

class MiniSnowflake
{
    private const SEQUENCE_MASK = 255; // 8 bits = 256 IDs per millisecond
    private const ID_LENGTH = 9; // Always 9 characters
    private const CHARACTERS = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    private const DEFAULT_EPOCH = 1704067200000; // 2025-01-01 00:00:00 UTC

    private static int $customEpoch = self::DEFAULT_EPOCH;

    private static int $lastTimestamp = 0;
    private static int $sequence = 0;

    public static function setEpoch(int $milliseconds): void
    {
        self::$customEpoch = $milliseconds;
    }

    public static function resetEpoch(): void
    {
        self::$customEpoch = self::DEFAULT_EPOCH;
    }

    public static function generateId(?int $customEpoch = null): string
    {
        $epoch = $customEpoch ?? self::$customEpoch;

        $now = (int)(microtime(true) * 1000);
        $timestamp = $now - $epoch;

        if ($timestamp == self::$lastTimestamp) {
            self::$sequence = (self::$sequence + 1) & self::SEQUENCE_MASK;
            if (self::$sequence == 0) {
                while (($now = (int)(microtime(true) * 1000)) <= self::$lastTimestamp) {
                    $timestamp = $now - $epoch;
                }
            }
        } else {
            self::$sequence = 0;
        }

        self::$lastTimestamp = $timestamp;

        $id = ($timestamp << 8) | self::$sequence;

        return self::base36Encode($id);
    }

    public static function decodeId(string $id, ?int $customEpoch = null): array
    {
        if (!self::isValidId($id)) {
            throw new \Exception('Invalid ID format.');
        }

        $epoch = $customEpoch ?? self::$customEpoch;

        $number = self::base36Decode($id);

        $sequence = $number & self::SEQUENCE_MASK;
        $timestampOffset = $number >> 8;
        $realTimestamp = $timestampOffset + $epoch;

        return [
            'timestamp' => $realTimestamp,
            'datetime' => date('Y-m-d H:i:s', (int)($realTimestamp / 1000)),
            'sequence' => $sequence
        ];
    }

    public static function isValidId(string $id): bool
    {
        $id = strtoupper($id);
        if (strlen($id) !== self::ID_LENGTH) {
            return false;
        }
        return preg_match('/^[0-9A-Z]+$/', $id) === 1;
    }

    private static function base36Encode(int $number): string
    {
        $base = strlen(self::CHARACTERS);
        $result = '';

        while ($number > 0) {
            $result = self::CHARACTERS[$number % $base] . $result;
            $number = (int)($number / $base);
        }

        return str_pad($result, self::ID_LENGTH, '0', STR_PAD_LEFT);
    }

    private static function base36Decode(string $string): int
    {
        $base = strlen(self::CHARACTERS);
        $string = strtoupper($string);
        $length = strlen($string);
        $number = 0;

        for ($i = 0; $i < $length; $i++) {
            $pos = strpos(self::CHARACTERS, $string[$i]);
            if ($pos === false) {
                throw new \Exception('Invalid character in ID.');
            }
            $number = $number * $base + $pos;
        }

        return $number;
    }
}

