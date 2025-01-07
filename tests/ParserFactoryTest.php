<?php

use PHPUnit\Framework\TestCase;
use App\Factories\ParserFactory;
use App\Parsers\CsvProductParser;
use App\Parsers\TsvProductParser;
use App\Parsers\JsonProductParser;

class ParserFactoryTest extends TestCase
{
    public function testCreateCsvParser()
    {
        $parser = ParserFactory::create('somefile.csv');
        $this->assertInstanceOf(CsvProductParser::class, $parser);
    }

    public function testCreateTsvParser()
    {
        $parser = ParserFactory::create('somefile.tsv');
        $this->assertInstanceOf(TsvProductParser::class, $parser);
    }

    public function testCreateJsonParser()
    {
        $parser = ParserFactory::create('somefile.json');
        $this->assertInstanceOf(JsonProductParser::class, $parser);
    }

    public function testCreateUnsupportedFormat()
    {
        $this->expectException(\InvalidArgumentException::class);
        ParserFactory::create('somefile.xml');
    }
}
