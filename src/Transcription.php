<?php

namespace Acentrix\Transcriptions;

use function array_chunk;

/**
 * Class Transcription
 *
 * Represents a transcription with methods to load and manipulate lines of text.
 *
 * @package Acentrix\Transcriptions
 */
class Transcription
{
    /**
     * @param array $lines Array to store lines of the transcription.
     */
    public function __construct(protected array $lines)
    {
        $this->lines = $this->filterLines($this->lines);
    }

    /**
     * Load a transcription from a file path.
     *
     * @param string $path The path to the file containing the transcription.
     * @return Transcription An instance of the Transcription class loaded with lines from the specified file.
     */
    public static function load(string $path): self
    {
        $lines = file($path);
        return new static($lines);
    }

    /**
     * Get the array of lines in the transcription.
     *
     * @return Lines An array containing lines of the transcription.
     */
    public function lines(): Lines
    {
        return new Lines(array_map(
            static fn($line) => new Line(...$line),
            array_chunk($this->lines, 3)
        ));
    }

    /**
     * Discard invalid lines from the given array.
     *
     * Irrelevant lines include those containing 'WEBVTT', empty lines, and numeric lines.
     *
     * @param array $lines An array of lines to filter.
     * @return array An array containing only relevant lines after filtering.
     */
    protected function filterLines(array $lines): array
    {
        /**
         * Trim Lines
         * Remove any falsy values
         * Remove first line which has VTT Header
         */
        return array_slice(array_filter(array_map('trim', $lines)), 1);
    }

    /**
     * Convert the object to its string representation.
     *
     * This method is automatically called when the object is used in a string context,
     * such as when using the echo or print functions, or when casting the object to a string.
     *
     * @return string The string representation of the object, obtained by concatenating
     *                all lines stored in the object using an empty string as the separator.
     */
    public function __toString(): string
    {
        return implode("\n", $this->lines);
    }
}
