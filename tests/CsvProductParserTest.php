<?php

use PHPUnit\Framework\TestCase;
use App\Parsers\CsvProductParser;

class CsvProductParserTest extends TestCase
{
    public function testParseSimpleCsv()
    {
        $parser = new CsvProductParser();
        $filePath = __DIR__ . '/Fixtures/sample.csv'; 
       
        $rows = [];
        foreach ($parser->parse($filePath) as $row) {
            $rows[] = $row;
        }

        // Check we have 2 rows
        $this->assertCount(2, $rows);

        // Check first row
        $this->assertEquals('Apple', $rows[0]['brand_name']);
        $this->assertEquals('iPhone 14', $rows[0]['model_name']);
        $this->assertEquals('Working', $rows[0]['condition_name']);
    }
}
