<?php

use PHPUnit\Framework\TestCase;
use App\Services\UniqueCombinationService;
use App\Models\Product;

class UniqueCombinationServiceTest extends TestCase
{
    public function testGetCombinationCounts()
    {
        $service = new UniqueCombinationService();

        // Create multiple products with a few duplicates
        $products = [
            new Product('Apple', 'iPhone 14', 'Working', 'Grade A', '128GB', 'Red', 'Unlocked'),
            new Product('Apple', 'iPhone 14', 'Working', 'Grade A', '128GB', 'Red', 'Unlocked'),
            new Product('Samsung', 'Galaxy S9', 'Working', 'Grade A', '256GB', 'Purple', 'Unlocked'),
        ];

        // Normally we might call a method that loops, but here we do it manually
        foreach ($products as $product) {
            $service->incrementCombinationCount($product);
        }

        $results = $service->getAllCombinationCounts();

        // We expect 2 unique combos:
        // 1) Apple iPhone 14 (count=2)
        // 2) Samsung Galaxy S9 (count=1)
        $this->assertCount(2, $results);

        // Let's find the Apple combination
        $appleCombo = array_filter($results, function ($combo) {
            return $combo['brand_name'] === 'Apple' && $combo['model_name'] === 'iPhone 14';
        });
        $appleCombo = reset($appleCombo); // get first

        $this->assertEquals(2, $appleCombo['count']);

        // Let's find the Samsung combo
        $samsungCombo = array_filter($results, function ($combo) {
            return $combo['brand_name'] === 'Samsung' && $combo['model_name'] === 'Galaxy S9';
        });
        $samsungCombo = reset($samsungCombo);

        $this->assertEquals(1, $samsungCombo['count']);
    }
}
