<?php

namespace Acentrix\Transcriptions;

use function implode;

class Lines extends Collection
{
    public function asHtml(): string
    {
        return $this->map(static fn(Line $line) => $line->toAnchorTag())
            ->__toString();
    }


    /**
     * Use as a string
     * @return string
     */

    public function __toString(): string
    {
        return implode('\n', $this->items);
    }
}