<?php

namespace Acentrix\Transcriptions;

use function preg_match;

class Line
{
    public function __construct(
        public string $position,
        public string $timestamp,
        public string $body
    )
    {
        //
    }

    public function toAnchorTag(): string
    {
        return "<a href=\"?time={$this->beginningTimestamp()}\">{$this->body}</a>";
    }

    public function beginningTimestamp(): string
    {
        // 00:00:04.300 becomes 00:04
        preg_match('/^\d{2}:(\d{2}:\d{2})\.\d{3}/', $this->timestamp, $matches);

        return $matches[1];
    }
}