<?php

namespace Acentrix\Transcriptions;

use ArrayAccess;
use ArrayIterator;
use Countable;
use IteratorAggregate;
use Traversable;
use function array_map;
use function implode;

class Lines implements Countable, IteratorAggregate, ArrayAccess
{
    public function __construct(protected array $lines)
    {
        // ...
    }

    public function asHtml(): string
    {
        $formattedLines = array_map(
            static fn(Line $line) => $line->toAnchorTag(),
            $this->lines
        );

        return (new static($formattedLines))->__toString();
    }

    /**
     * ===============
     * =  Countable  =
     * ===============
     */

    public function count(): int
    {
        return count($this->lines);
    }

    /**
     * =======================
     * =  IteratorAggregate  =
     * =======================
     */

    public function getIterator(): Traversable
    {
        return new ArrayIterator($this->lines);
    }

    /**
     * =================
     * =  ArrayAccess  =
     * =================
     */

    public function offsetExists(mixed $offset): bool
    {
        return isset($this->lines[$offset]);
    }

    public function offsetGet(mixed $offset): mixed
    {
        return $this->lines[$offset];
    }

    public function offsetSet(mixed $offset, mixed $value): void
    {
        if (is_null($offset)) {
            $this->lines[] = $value;
        } else {
            $this->lines[$offset] = $value;
        }

    }

    public function offsetUnset(mixed $offset): void
    {
        unset($this->lines[$offset]);
    }

    /**
     * Use as a string
     * @return string
     */

    public function __toString(): string
    {
        return implode('\n', $this->lines);
    }
}