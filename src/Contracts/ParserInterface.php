<?php

namespace App\Contracts;

use Generator;

interface ParserInterface
{
    /**
     * Parse a file and yield each row as an associative array.
     */
    public function parse(string $filePath): Generator;
}
