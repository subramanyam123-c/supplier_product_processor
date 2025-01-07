<?php

namespace App\Parsers;

use App\Contracts\ParserInterface;
use Generator;

/**
 * Parses a tab-separated (.tsv) file line by line.
 */
class TsvProductParser implements ParserInterface
{
    public function parse(string $filePath): Generator
    {
        $handle = fopen($filePath, 'r');
        if (!$handle) {
            throw new \RuntimeException("Cannot open TSV file: $filePath");
        }

        try {
            // Read the header row with tab delimiter
            $header = fgetcsv($handle, 0, "\t");
            if ($header === false) {
                throw new \RuntimeException("TSV file is empty or invalid: $filePath");
            }

            // For each line, read using tab delimiter
            while (($row = fgetcsv($handle, 0, "\t")) !== false) {
                if (count($row) !== count($header)) {
                    // If mismatch in columns, skip or handle as needed
                    continue;
                }

                $data = array_combine($header, $row);
                yield $data;
            }
        } finally {
            fclose($handle);
        }
    }
}
