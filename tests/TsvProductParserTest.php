<?php

use PHPUnit\Framework\TestCase;
use App\Parsers\TsvProductParser;

class TsvProductParserTest extends TestCase
{
    public function testParseSimpleTsv()
    {
        $parser = new TsvProductParser();
        $filePath = __DIR__ . '/Fixtures/sample.tsv'; 
        // sample.tsv example (tab-separated):
        // brand_name    model_name    condition_name   grade_name  gb_spec_name    colour_name network_name
        // Apple iPhone 14    Working Grade A 128GB   Red Unlocked
        // Samsung   Galaxy S9   Working Grade A 256GB  Purple Unlocked

        $rows = [];
        foreach ($parser->parse($filePath) as $row) {
            $rows[] = $row;
        }

        $this->assertCount(2, $rows);

        $this->assertEquals('Apple', $rows[0]['brand_name']);
        $this->assertEquals('iPhone 14', $rows[0]['model_name']);
    }
}
