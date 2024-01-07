<?php
require 'vendor/autoload.php';

use Acentrix\Transcriptions\Transcription;

/**
 * run in terminal using php src/index.php
 */

$vtt_file = __DIR__ . '/../tests/stubs/sample.vtt';

$lines = Transcription::load($vtt_file)->lines();

foreach ($lines as $line) {
    var_dump("{$line->beginningTimestamp()} - {$line->body}");
}