<?php
namespace MiniSnowflake\IdGenerator\Tests;

use MiniSnowflake\IdGenerator\MiniSnowflake;
use PHPUnit\Framework\TestCase;

class MiniSnowflakeTest extends TestCase
{
    public function testGenerateIdLength()
    {
        $id = MiniSnowflake::generateId();
        $this->assertEquals(9, strlen($id), "ID should be exactly 9 characters long");
    }

    public function testGenerateIdIsValid()
    {
        $id = MiniSnowflake::generateId();
        $this->assertTrue(MiniSnowflake::isValidId($id), "Generated ID should be valid");
    }

    public function testDecodeId()
    {
        $id = MiniSnowflake::generateId();
        $decoded = MiniSnowflake::decodeId($id);

        $this->assertArrayHasKey('timestamp', $decoded, "Decoded ID should contain timestamp");
        $this->assertArrayHasKey('datetime', $decoded, "Decoded ID should contain datetime");
        $this->assertArrayHasKey('sequence', $decoded, "Decoded ID should contain sequence");

        $this->assertIsInt($decoded['timestamp'], "Timestamp should be an integer");
        $this->assertIsString($decoded['datetime'], "Datetime should be a string");
        $this->assertIsInt($decoded['sequence'], "Sequence should be an integer");
    }

    public function testInvalidId()
    {
        $this->assertFalse(MiniSnowflake::isValidId('INVALID!'), "ID with special characters should be invalid");
        $this->expectException(\Exception::class);
        MiniSnowflake::decodeId('INVALID!');
    }
}
