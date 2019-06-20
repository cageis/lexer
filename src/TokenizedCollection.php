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

    public function toArray(): array
    {
        return array_map(function (Token $token) {
            return [
                'name' => $token->getTokenPattern()->getName(),
                'match' => $token->getMatch(),
                'length' => $token->getLength(),
                'index' => $token->getIndex(),
            ];
        }, $this->all());
    }
}
