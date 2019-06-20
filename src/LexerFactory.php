<?php declare(strict_types=1);

namespace CageIs\Lexer;

class LexerFactory
{
    /**
     * Create a new Lexer class when dependency inject is not available.
     *
     * @return Lexer
     */
    public static function create(): Lexer
    {
        return new Lexer(new TokenizedCollection(), new StringPointer());
    }
}
