<?php

namespace App\Parsers;

use App\Contracts\ParserInterface;
use Generator;

/**
 * A simple CSV parser that streams the file line by line
 * and yields each row as an associative array
 */
class CsvProductParser implements ParserInterface
{
    /**
     * Parse the CSV file and yield each row as an associative array.
     */
    public function parse(string $filePath): Generator
    {
        // Open the file
        $handle = fopen($filePath, 'r');
        if (!$handle) {
            throw new \RuntimeException("Cannot open CSV file: $filePath");
        }

        try {
            // Read the header row
            $header = fgetcsv($handle);
            if ($header === false) {
                throw new \RuntimeException("CSV file is empty or invalid: $filePath");
            }

            // For each subsequent line, parse the row
            while (($row = fgetcsv($handle)) !== false) {
                // Combine header with row to get an associative array
                $data = array_combine($header, $row);
                yield $data;
            }
        } finally {
            fclose($handle);
        }
    }
}
