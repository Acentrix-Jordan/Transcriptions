<?php

namespace Tests;

use Acentrix\Transcriptions\Line;
use Acentrix\Transcriptions\Transcription;
use PHPUnit\Framework\TestCase;

class TranscriptionTest extends TestCase
{
    protected Transcription $transcription;

    protected function setUp(): void
    {
        $this->transcription = Transcription::load(__DIR__ . '/stubs/sample.vtt');
    }

    /**
     * @test
     * @covers Transcription::load
     */
    public function it_loads_a_vtt_file_as_a_string(): void
    {
        $this->assertStringContainsString('The Web is always changing', $this->transcription);
        $this->assertStringContainsString('and the way we access it is changing', $this->transcription);
    }

    /**
     * @test
     * @covers Transcription::lines()
     */
    public function it_can_convert_to_an_array_of_line_objects(): void
    {
        $lines = $this->transcription->lines();

        $this->assertCount(2, $lines);
        $this->assertContainsOnlyInstancesOf(Line::class, $lines);
    }

    /**
     * @test
     * @covers Transcription::filterLines()
     */
    public function it_discards_invalid_lines_from_the_vtt_file(): void
    {
        $this->assertStringNotContainsString('WEBVTT', $this->transcription);
        $this->assertCount(2, $this->transcription->lines());
    }

    /**
     * @test
     * @covers Transcription::htmlLines()
     */
    public function it_renders_the_lines_as_html(): void
    {
        $expected = '<a href="?time=00:00">The Web is always changing</a>\n<a href="?time=00:02">and the way we access it is changing</a>';

        $this->assertEquals($expected, $this->transcription->lines()->asHtml());
    }
}