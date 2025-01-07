<?php

namespace App\Services;

use App\Models\Product;

class UniqueCombinationService
{
    /**
     * Store combination counts, keyed by a combination "signature".
     * e.g., "Apple|iPhone 6s Plus|Red|256GB|Unlocked|Grade A|Working"
     */
    private $counts = [];

    /**
     * Increment the count for a given Product's combination
     */
    public function incrementCombinationCount(Product $product): void
    {
        
            $key = $this->createCombinationKey($product);
            
            if (!isset($this->counts[$key])) {
                $this->counts[$key] = [
                    'brand_name'      => $product->brand_name,
                    'model_name'     => $product->model_name,
                    'condition_name' => $product->condition_name,
                    'grade_name'     => $product->grade_name,
                    'gb_spec_name'  => $product->gb_spec_name,
                    'colour_name'    => $product->colour_name,
                    'network_name'   => $product->network_name,
                    'count'     => 0
                ];
            }
            
            $this->counts[$key]['count']++;
    }

    /**
     * Get all combination counts as an array (for writing to CSV).
     */
    public function getAllCombinationCounts(): array
    {
        return array_values($this->counts);
    }

    /**
     * Create a unique signature for grouping combinations
     */
    private function createCombinationKey(Product $product): string
    {
        // final JSON string for one set of fields cannot match the final JSON string of a different set of fields.
        $fields = [
            'brand_name'    => $product->brand_name,
            'model_name'    => $product->model_name,
            'condition_name'=> $product->condition_name,
            'grade_name'    => $product->grade_name,
            'gb_spec_name'  => $product->gb_spec_name,
            'colour_name'   => $product->colour_name,
            'network_name'  => $product->network_name,
        ];
    
        // Convert array to a JSON string
        return json_encode($fields, JSON_UNESCAPED_UNICODE);
    }
}
