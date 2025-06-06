<?php

namespace Tests\Unit;

use App\Actions\PhonePrepare\PhonePrepare;
use PHPUnit\Framework\TestCase;

class PhonePrepareTest extends TestCase
{
    /**
     * A basic unit test example.
     */
    public function test_example(): void
    {
        $standard = '+79026223673';

        $phonePrepare = new PhonePrepare();

        $prepare = $phonePrepare('8(9026223673');
        $this->assertTrue($prepare['status']);
        $this->assertEquals($standard, $prepare['phone']);

        $prepare = $phonePrepare('+7(902)622 36-73');
        $this->assertTrue($prepare['status']);
        $this->assertEquals($standard, $prepare['phone']);

        $prepare = $phonePrepare('+902)622 36-73');
        $this->assertTrue($prepare['status']);
        $this->assertEquals($standard, $prepare['phone']);

        $prepare = $phonePrepare($standard);
        $this->assertTrue($prepare['status']);
        $this->assertEquals($standard, $prepare['phone']);

        $prepare = $phonePrepare('+8(90262236739');
        $this->assertFalse($prepare['status']);
        $this->assertEquals('', $prepare['phone']);


    }
}
