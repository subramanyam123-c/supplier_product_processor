<?php

namespace App\Services;

use App\Exceptions\RequiredFieldMissingException;
use App\Models\Product;

class ProductService
{
    /**
     * Convert an associative array from the CSV to a Product object.
     * 
     * If required fields are missing, throw an exception.
     */
    public function createProductFromRow(array $row): Product
    {
        // Check for required fields
        if (!isset($row['brand_name']) || empty($row['brand_name'])) {
            throw new RequiredFieldMissingException("Required field 'brand_name' not found or empty.");
        }

        if (!isset($row['model_name']) || empty($row['model_name'])) {
            throw new RequiredFieldMissingException("Required field 'model_name' not found or empty.");
        }

        // Create the product
        $product = new Product(
            $row['brand_name'],
            $row['model_name'],
            $row['condition_name'] ?? null,
            $row['grade_name'] ?? null,
            $row['gb_spec_name'] ?? null,
            $row['colour_name'] ?? null,
            $row['network_name'] ?? null
        );

        return $product;
    }
}
