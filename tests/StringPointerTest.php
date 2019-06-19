<?php declare(strict_types=1);

namespace Tests\CageIs\Lexer;

use CageIs\Lexer\StringPointer;
use PHPUnit\Framework\TestCase;

class StringPointerTest extends TestCase
{
    public function testGetSegmentReturnsFullString()
    {
        $pointer = new StringPointer();
        $this->assertEquals('hello, world', $pointer->setString('hello, world')->getSegment());
    }

    public function testIncrementingDefaultsToOne()
    {
        $pointer = new StringPointer();
        $pointer->setString('hello, world');
        $this->assertEquals('ello, world', $pointer->forward()->getSegment());
        $this->assertEquals('llo, world', $pointer->forward()->getSegment());
    }

    public function testIncrementingByMultiple()
    {
        $pointer = new StringPointer();
        $pointer->setString('hello, world');
        $this->assertEquals('llo, world', $pointer->forward(2)->getSegment());
        $this->assertEquals(', world', $pointer->forward(3)->getSegment());
    }

    public function testRewindingByOne()
    {
        $pointer = new StringPointer();
        $pointer->setString('hello, world');
        $pointer->forward(4)->getSegment();
        $this->assertEquals('lo, world', $pointer->reverse()->getSegment());
    }

    public function testRewindingByMultiple()
    {
        $pointer = new StringPointer();
        $pointer->setString('hello, world');
        $pointer->forward(4);
        $this->assertEquals('llo, world', $pointer->reverse(2)->getSegment());
    }

    public function testForwardOutOfBounds()
    {
        $pointer = new StringPointer();
        $pointer->setString('testing123');
        $this->assertEquals('testing123', $pointer->forward(10)->getSegment());

        $pointer = new StringPointer();
        $pointer->setString('testing123');
        $this->assertEquals('3', $pointer->forward(9)->getSegment());
    }

    public function testRewindOutOfBounds()
    {
        $pointer = new StringPointer();
        $pointer->setString('testing123');
        $this->assertEquals('3', $pointer->reverse(1)->getSegment());

        $pointer = new StringPointer();
        $pointer->setString('testing123');
        $this->assertEquals('123', $pointer->reverse(3)->getSegment());
    }

    public function testIsEndReturnsTrue()
    {
        $pointer = new StringPointer();
        $pointer->setString('test');
        $this->assertTrue($pointer->forward(3)->isEnd());
    }

    public function testIsEndReturnsFalse()
    {
        $pointer = new StringPointer();
        $pointer->setString('test');
        $this->assertFalse($pointer->forward(2)->isEnd());
    }
}
