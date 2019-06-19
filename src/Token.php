<?php declare(strict_types=1);

namespace CageIs\Lexer;

class Token
{
    /**
     * @var string
     */
    private $match;

    /**
     * @var TokenPattern
     */
    private $tokenPattern;

    /**
     * Token constructor.
     * @param TokenPattern $tokenPattern
     * @param string $match
     */
    public function __construct(TokenPattern $tokenPattern, string $match)
    {
        $this->match = $match;
        $this->tokenPattern = $tokenPattern;
    }

    /**
     * Gives you the value that matched the token.
     *
     * @return string
     */
    public function getMatch(): string
    {
        return $this->match;
    }

    /**
     * Gives you the TokenPattern that was used to match the token.
     *
     * @return TokenPattern
     */
    public function getTokenPattern(): TokenPattern
    {
        return $this->tokenPattern;
    }
}
