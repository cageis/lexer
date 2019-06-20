<?php declare(strict_types=1);

namespace Tests\CageIs\Lexer;

use CageIs\Lexer\TokenPattern;
use PHPUnit\Framework\TestCase;

class TokenPatternTest extends TestCase
{
    public function testMatchReturnsString()
    {
        $tokenPattern = new TokenPattern('\d+', 'number');
        $this->assertEquals('5432', $tokenPattern->match('5432 testing')->getMatch());
    }

    public function testMatchReturnsNull()
    {
        $tokenPattern = new TokenPattern('\d+', 'number');
        $this->assertNull($tokenPattern->match('testing 5432'));
    }

    public function testCaseInsensitiveMatchingReturnsValue()
    {
        $tokenPattern = new TokenPattern('AND|OR', 'logical', false);
        $this->assertEquals('and', $tokenPattern->match('and')->getMatch());
    }

    public function testCaseSensitiveMatchingReturnsNull()
    {
        $tokenPattern = new TokenPattern('AND|OR', 'logical');
        $this->assertNull($tokenPattern->match('and'));
    }
}
