<?php

namespace App\Factories;

use App\Contracts\ParserInterface;
use App\Parsers\CsvProductParser;
use App\Parsers\TsvProductParser;


class ParserFactory
{
    /**
     * Based on the file extension (csv, json, xml), return the appropriate parser.
     */
    public static function create(string $filePath): ParserInterface
    {
        // Very basic extension check
        $extension = pathinfo($filePath, PATHINFO_EXTENSION);

        switch (strtolower($extension)) {
            case 'csv':
                return new CsvProductParser();
            case 'tsv':
                return new TsvProductParser();
            // case 'json':
            //     return new JsonProductParser();
            // case 'xml':
            //     return new XmlProductParser();

            default:
                throw new \InvalidArgumentException("Unsupported file format: $extension");
        }
    }
}
