<?php declare(strict_types=1);

namespace CageIs\Lexer;

class StringPointer
{
    /**
     * @var int
     */
    private $pointer = 0;

    /**
     * @var string
     */
    private $string;

    /**
     * @param string $string
     * @return self
     */
    public function setString(string $string): self
    {
        $this->string = $string;
        $this->reset();
        return $this;
    }

    /**
     * @param int $increment
     * @return StringPointer
     */
    public function forward(int $increment = 1): self
    {
        $this->pointer += abs($increment);
        $this->rebound();
        return $this;
    }

    /**
     * @param int $decrement
     * @return StringPointer
     */
    public function reverse(int $decrement = 1): self
    {
        $this->pointer -= abs($decrement);
        return $this->rebound();
    }

    /**
     * This method runs after a forward/reverse call and ensures that the
     * pointer always stay within the bounds of the indexes.
     *
     * @return StringPointer
     */
    private function rebound(): self
    {
        $maxPointer = strlen($this->string) - 1;

        if ($this->pointer > $maxPointer) {
            $this->pointer = ($this->pointer % $maxPointer) - 1;
        }

        if ($this->pointer < 0) {
            $this->pointer = ($this->pointer % ($maxPointer + $this->pointer));
        }

        return $this;
    }

    /**
     * @return self
     */
    public function reset(): self
    {
        $this->pointer = 0;
        return $this;
    }

    /**
     * @return bool
     */
    public function isEnd(): bool
    {
        return $this->pointer === strlen($this->string) - 1;
    }

    /**
     * @return string
     */
    public function getSegment(): string
    {
        return substr($this->string, $this->pointer);
    }

    /**
     * @return bool
     */
    public function isStart(): bool
    {
        return $this->pointer === 1;
    }

    /**
     * @return int
     */
    public function getPointer(): int
    {
        return $this->pointer;
    }
}
