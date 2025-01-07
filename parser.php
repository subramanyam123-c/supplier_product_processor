#!/usr/bin/env php
<?php

require_once __DIR__ . '/vendor/autoload.php';

use App\Factories\ParserFactory;
use App\Services\ProductService;
use App\Services\UniqueCombinationService;

// ----------------------------------------------------------------------------
// 1. Parse CLI arguments
// ----------------------------------------------------------------------------

/**
 * We'll expect something like:
 * php parser.php --file=example_1.csv --unique-combinations=combination_count.csv
 *
 * We can parse $argv to get these.
 */

$filePath = null;
$uniqueFilePath = null;

foreach ($argv as $arg) {
    if (strpos($arg, '--file=') === 0) {
        $filePath = substr($arg, 7);
    } elseif (strpos($arg, '--unique-combinations=') === 0) {
        $uniqueFilePath = substr($arg, 22);
    }
}

if (!$filePath) {
    exit("Please provide --file=<path to csv> argument.\n");
}

// ----------------------------------------------------------------------------
// 2. Create the parser via ParserFactory
// ----------------------------------------------------------------------------

try {
    $parser = ParserFactory::create($filePath);
} catch (\Exception $e) {
    exit("Error creating parser: " . $e->getMessage() . "\n");
}

// ----------------------------------------------------------------------------
// 3. Initialize Services
// ----------------------------------------------------------------------------

$productService = new ProductService();
$uniqueService  = new UniqueCombinationService();

// ----------------------------------------------------------------------------
//  4. Parse CSV line-by-line, build product, increment count
// ----------------------------------------------------------------------------

try {
    $index = 0;
    foreach ($parser->parse($filePath) as $row) {
        $index++;
        try {
            $product = $productService->createProductFromRow($row);
            echo $product . PHP_EOL;
            // Increment combination count in memory
            $uniqueService->incrementCombinationCount($product);
        } catch (\Exception $e) {
            // Handle missing fields or other exceptions
            echo "Error processing row {$index}: " . $e->getMessage() . PHP_EOL;
        }
    }
} catch (\Exception $e) {
    exit("Error parsing file: " . $e->getMessage() . "\n");
}

// ----------------------------------------------------------------------------
// 5. If --unique-combinations was specified, output to CSV
// ----------------------------------------------------------------------------

if ($uniqueFilePath) {
    $combinations = $uniqueService->getAllCombinationCounts();

    $fp = fopen($uniqueFilePath, 'w');
    if (!$fp) {
        exit("Cannot open file for writing: $uniqueFilePath \n");
    }

    // Write header
    fputcsv($fp, ['brand_name', 'model_name', 'condition_name', 'grade_name', 'gb_spec_name', 'colour_name', 'network_name', 'count']);

    // Write each combination
    foreach ($combinations as $combo) {
        fputcsv($fp, [
            $combo['brand_name'],
            $combo['model_name'],
            $combo['condition_name'],
            $combo['grade_name'],
            $combo['gb_spec_name'],
            $combo['colour_name'],
            $combo['network_name'],
            $combo['count']
        ]);
    }

    fclose($fp);

    echo "Unique combination counts written to $uniqueFilePath\n";
}
