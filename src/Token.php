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
     * @var int
     */
    private $length;

    /**
     * @var int
     */
    private $index;

    /**
     * Token constructor.
     * @param TokenPattern $tokenPattern
     * @param string $match
     * @param int $length
     */
    public function __construct(TokenPattern $tokenPattern, string $match, int $length)
    {
        $this->match = $match;
        $this->tokenPattern = $tokenPattern;
        $this->length = $length;
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

    /**
     * @return int
     */
    public function getLength(): int
    {
        return $this->length;
    }

    /**
     * @return int
     */
    public function getIndex(): int
    {
        return $this->index;
    }

    /**
     * @param int $index
     * @return self
     */
    public function setIndex(int $index): self
    {
        $this->index = $index;
        return $this;
    }

}
