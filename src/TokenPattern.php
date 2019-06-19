<?php declare(strict_types=1);

namespace CageIs\Lexer;

class TokenPattern
{
    /**
     * @var string
     */
    private $pattern;

    /**
     * @var string
     */
    private $name;

    /**
     * TokenLocator constructor.
     * @param string $pattern
     * @param string $name
     */
    public function __construct(string $pattern, string $name)
    {
        $this->pattern = $pattern;
        $this->name = $name;
    }

    /**
     * @param string $segment
     * @return string|null
     */
    public function match(string $segment): ?string
    {
        preg_match("/^({$this->pattern})/", $segment, $matches);
        return $matches[1] ?? null;
    }

    /**
     * @return string
     */
    public function getPattern(): string
    {
        return $this->pattern;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }
}
