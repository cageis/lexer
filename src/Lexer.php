<?php declare(strict_types=1);

namespace CageIs\Lexer;

class Lexer
{
    /**
     * @var TokenPattern[]
     */
    private $tokenPatterns = [];

    /**
     * @var TokenizedCollection
     */
    private $tokenizedCollection;

    /**
     * @var StringPointer
     */
    private $stringPointer;

    /**
     * @var bool
     */
    private $ignoreWhitespace = false;

    /**
     * Lexer constructor.
     * @param TokenizedCollection $tokenizedCollection
     * @param StringPointer $stringPointer
     */
    public function __construct(TokenizedCollection $tokenizedCollection, StringPointer $stringPointer)
    {
        $this->tokenizedCollection = $tokenizedCollection;
        $this->stringPointer = $stringPointer;
    }

    public function parse(string $string)
    {
        if ($this->ignoreWhitespace) {
            $string = preg_replace('/\s/', '', $string);
        }

        $this->stringPointer->setString($string);

        $tokenPatterns = $this->getTokenPatterns();
        while (true) {
            foreach ($tokenPatterns as $tokenPattern) {
                if ($match = $tokenPattern->match($this->stringPointer->getSegment())) {
                    $this->tokenizedCollection->add(new Token($tokenPattern, $match));
                    $this->stringPointer->forward(strlen($match));

                    # When the pointer moves forward and back to 0, then the
                    # entire string has been traversed.
                    if ($this->stringPointer->getPointer() === 0) {
                        break 2;
                    }

                    continue 2;
                }
            }
        }

        return $this->tokenizedCollection;
    }

    /**
     * @param TokenPattern $tokenPattern
     * @return self
     */
    public function addTokenPattern(TokenPattern $tokenPattern): self
    {
        $this->tokenPatterns[] = $tokenPattern;
        return $this;
    }

    /**
     * Gets a list of token patterns, with the last one being the Unknown token.
     *
     * @return array|TokenPattern[]
     */
    private function getTokenPatterns()
    {
        $tokenPatters = $this->tokenPatterns;
        $tokenPatters[] = new TokenPattern('.{1}', 'Unknown');
        return $tokenPatters;
    }

    /**
     * @param bool $ignoreWhitespace
     * @return self
     */
    public function setWhitespaceIgnore(bool $ignoreWhitespace): self
    {
        $this->ignoreWhitespace = $ignoreWhitespace;
        return $this;
    }
}
