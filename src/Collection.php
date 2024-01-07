<?php

namespace Acentrix\Transcriptions;

use ArrayAccess;
use ArrayIterator;
use Countable;
use IteratorAggregate;
use JsonSerializable;
use Traversable;
use function is_null;

class Collection implements Countable, IteratorAggregate, ArrayAccess, JsonSerializable
{
    public function __construct(protected array $items)
    {
        // ...
    }

    public function map(callable $fn): self
    {
        return new static(array_map($fn, $this->items));
    }


    /**
     * ======================
     * =  JsonSerializable  =
     * ======================
     */
    public function jsonSerialize(): mixed
    {
        return $this->items;
    }

    /**
     * =================
     * =  ArrayAccess  =
     * =================
     */
    public function offsetUnset(mixed $offset): void
    {
        unset($this->items[$offset]);
    }

    public function offsetGet(mixed $offset): mixed
    {
        return $this->items[$offset];
    }

    public function offsetExists(mixed $offset): bool
    {
        return isset($this->items[$offset]);
    }

    public function offsetSet(mixed $offset, mixed $value): void
    {
        if (is_null($offset)) {
            $this->items[] = $value;
        } else {
            $this->items[$offset] = $value;
        }

    }

    /**
     * =======================
     * =  IteratorAggregate  =
     * =======================
     */
    public function getIterator(): Traversable
    {
        return new ArrayIterator($this->items);
    }


    /**
     * ===============
     * =  Countable  =
     * ===============
     */
    public function count(): int
    {
        return count($this->items);
    }
}