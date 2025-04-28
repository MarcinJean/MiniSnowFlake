<?php
namespace MarcinJean\MiniSnowflake\Tests;

use MarcinJean\MiniSnowflake\MiniSnowflake;
use PHPUnit\Framework\TestCase;

class MiniSnowflakeTest extends TestCase
{
    public function testGenerateIdLength()
    {
        $id = MiniSnowflake::generateId();
        $this->assertEquals(9, strlen($id));
    }

    public function testGenerateIdIsValid()
    {
        $id = MiniSnowflake::generateId();
        $this->assertTrue(MiniSnowflake::isValidId($id));
    }

    public function testDecodeId()
    {
        $id = MiniSnowflake::generateId();
        $decoded = MiniSnowflake::decodeId($id);

        $this->assertArrayHasKey('timestamp', $decoded);
        $this->assertArrayHasKey('datetime', $decoded);
        $this->assertArrayHasKey('sequence', $decoded);

        $this->assertIsInt($decoded['timestamp']);
        $this->assertIsString($decoded['datetime']);
        $this->assertIsInt($decoded['sequence']);
    }

    public function testInvalidId()
    {
        $this->assertFalse(MiniSnowflake::isValidId('INVALID!'));

        $this->expectException(\Exception::class);
        MiniSnowflake::decodeId('INVALID!');
    }
}
