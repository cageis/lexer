<?php declare(strict_types=1);

namespace CageIs\Lexer;

class TokenizedCollection
{
    private $tokens = [];

    /**
     * @param Token $token
     * @return self
     */
    public function add(Token $token): self
    {
        $this->tokens[] = $token;
        return $this;
    }

    /**
     * @return Token[]
     */
    public function all()
    {
        return $this->tokens;
    }

    /**
     * Get a specific token by it's index (if it exists).
     *
     * @param int $index
     * @return Token|null
     */
    public function get(int $index): ?Token
    {
        return $this->tokens[$index] ?? null;
    }
}
