<?php
namespace MiniSnowflake\IdGenerator;

class MiniSnowflake
{
    private static $sequenceMask = 255; // 8 bits = 256 IDs per millisecond
    private static $idLength = 9; // Always 9 characters
    private static $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';

    public static function generateId()
    {
        $timestamp = (int)(microtime(true) * 1000); // milliseconds

        static $lastTimestamp = 0;
        static $sequence = 0;

        if ($timestamp == $lastTimestamp) {
            self::$sequence = (self::$sequence + 1) & self::$sequenceMask;
            if (self::$sequence == 0) {
                while ($timestamp <= $lastTimestamp) {
                    $timestamp = (int)(microtime(true) * 1000);
                }
            }
        } else {
            self::$sequence = 0;
        }

        $lastTimestamp = $timestamp;

        $id = ($timestamp << 8) | self::$sequence;

        return self::base36Encode($id);
    }

    public static function decodeId($id)
    {
        if (!self::isValidId($id)) {
            throw new \Exception('Invalid ID format.');
        }

        $number = self::base36Decode($id);

        $sequence = $number & self::$sequenceMask;
        $timestamp = $number >> 8;

        return [
            'timestamp' => $timestamp,
            'datetime' => date('Y-m-d H:i:s', (int)($timestamp / 1000)),
            'sequence' => $sequence
        ];
    }

    public static function isValidId($id)
    {
        $id = strtoupper($id); // Normalize case
        if (strlen($id) !== self::$idLength) {
            return false;
        }
        return preg_match('/^[0-9A-Z]+$/', $id) === 1;
    }

    private static function base36Encode($number)
    {
        $base = strlen(self::$characters);
        $result = '';

        while ($number > 0) {
            $result = self::$characters[$number % $base] . $result;
            $number = (int)($number / $base);
        }

        return str_pad($result, self::$idLength, '0', STR_PAD_LEFT);
    }

    private static function base36Decode($string)
    {
        $base = strlen(self::$characters);
        $string = strtoupper($string);
        $length = strlen($string);
        $number = 0;

        for ($i = 0; $i < $length; $i++) {
            $pos = strpos(self::$characters, $string[$i]);
            if ($pos === false) {
                throw new \Exception('Invalid character in ID.');
            }
            $number = $number * $base + $pos;
        }

        return $number;
    }
}
