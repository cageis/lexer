<?php declare(strict_types=1);

namespace Tests\CageIs\Lexer;

use CageIs\Lexer\Lexer;
use CageIs\Lexer\LexerFactory;
use CageIs\Lexer\TokenPattern;
use CageIs\Lexer\StringPointer;
use PHPUnit\Framework\TestCase;
use CageIs\Lexer\TokenizedCollection;
use PHPUnit\Framework\MockObject\MockObject;

class LexerTest extends TestCase
{
    /**
     * @var TokenizedCollection|MockObject
     */
    private $tokenizedCollectionMock;

    /**
     * @var Lexer
     */
    private $lexer;

    protected function setUp()
    {
        $this->tokenizedCollectionMock = $this->createMock(TokenizedCollection::class);
        $this->lexer = new Lexer(new TokenizedCollection(), new StringPointer());
    }

    public function testExampleOne()
    {
        $tokens = $this->lexer->addTokenPattern(new TokenPattern('\d+', 'Numbers'))->parse('test123');
        $this->assertCount(5, $tokens->all());

        $expected = array_fill(0, 4, 'Unknown');
        $expected[] = 'Numbers';

        array_map(function (string $expectedName, int $index) use ($tokens) {
            $this->assertEquals($expectedName, $tokens->get($index)->getTokenPattern()->getName());
        }, $expected, array_keys($expected));

        $this->assertEquals('123', $tokens->get(4)->getMatch());
    }

    public function testExampleTwo()
    {
        $tokens = $this->lexer
            ->addTokenPattern(new TokenPattern('\(', 'NEST_START'))
            ->addTokenPattern(new TokenPattern('\)', 'NEST_END'))
            ->addTokenPattern(new TokenPattern('\d+', 'NUMBER'))
            ->addTokenPattern(new TokenPattern('AND|OR', 'LOGICAL'))
            ->setWhitespaceIgnore(true)
            ->parse('1 AND (2 OR 3)');
        $this->assertCount(7, $tokens->all());

        $expectedNames = [
            'NUMBER',
            'LOGICAL',
            'NEST_START',
            'NUMBER',
            'LOGICAL',
            'NUMBER',
            'NEST_END',
        ];

        $expectedValues = ['1', 'AND', '(', '2', 'OR', '3', ')'];

        array_map(function (string $expectedName, int $index) use ($tokens, $expectedValues) {
            $this->assertEquals($expectedName, $tokens->get($index)->getTokenPattern()->getName());
            $this->assertEquals($expectedValues[$index], $tokens->get($index)->getMatch());
        }, $expectedNames, array_keys($expectedNames));
    }

    public function testExampleFromReadMe()
    {
        $lexer = LexerFactory::create();
        $tokens = $lexer->addTokenPattern(new TokenPattern('\d+', 'num'))
            ->addTokenPattern(new TokenPattern('[a-zA-Z]+', 'alpha'))
            ->setWhitespaceIgnore(true)
            ->parse("hello\n123\n^&111111");

        $this->assertEquals([
            ['name' => "alpha", 'match' => "hello", 'index' => 0, 'length' => 5],
            ['name' => "num", 'match' => "123", 'index' => 5, 'length' => 3],
            ['name' => "Unknown", 'match' => "^", 'index' => 8, 'length' => 1],
            ['name' => "Unknown", 'match' => "&", 'index' => 9, 'length' => 1],
            ['name' => "num", 'match' => "111111", 'index' => 10, 'length' => 6],
        ], $tokens->toArray());
    }
}
