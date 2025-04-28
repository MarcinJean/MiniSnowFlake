#!/usr/bin/env php
<?php

require __DIR__ . '/../vendor/autoload.php';

use MarcinJean\MiniSnowflake\MiniSnowflake;

// Parse optional epoch argument
$options = getopt("", ["epoch::"]);

$customEpoch = null;
if (isset($options['epoch'])) {
    $customEpoch = (int) $options['epoch'];
}

try {
    $id = MiniSnowflake::generateId($customEpoch);
    echo "Generated ID: " . $id . PHP_EOL;

    $decoded = MiniSnowflake::decodeId($id, $customEpoch);
    echo "Decoded Info:" . PHP_EOL;
    echo "- Timestamp: " . $decoded['timestamp'] . PHP_EOL;
    echo "- Datetime:  " . $decoded['datetime'] . PHP_EOL;
    echo "- Sequence:  " . $decoded['sequence'] . PHP_EOL;
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . PHP_EOL;
    exit(1);
}
