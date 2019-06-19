<?php declare(strict_types=1);

namespace Tests\CageIs\Lexer;

use CageIs\Lexer\TokenPattern;
use PHPUnit\Framework\TestCase;

class TokenPatternTest extends TestCase
{
    public function testMatchReturnsString()
    {
        $tokenPattern = new TokenPattern('\d+', 'number');
        $this->assertEquals('5432', $tokenPattern->match('5432 testing'));
    }

    public function testMatchReturnsNull()
    {
        $tokenPattern = new TokenPattern('\d+', 'number');
        $this->assertNull($tokenPattern->match('testing 5432'));
    }
}
