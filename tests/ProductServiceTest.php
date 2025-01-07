<?php

use PHPUnit\Framework\TestCase;
use App\Services\ProductService;
use App\Models\Product;
use App\Exceptions\RequiredFieldMissingException;

class ProductServiceTest extends TestCase
{
    private $productService;

    protected function setUp(): void
    {
        $this->productService = new ProductService();
    }

    public function testCreateProductFromRowSuccess()
    {
        $row = [
            'brand_name' => 'Apple',
            'model_name' => 'iPhone 14',
            'condition_name' => 'Working',
            'grade_name' => 'Grade A',
            'gb_spec_name' => '128GB',
            'colour_name' => 'Red',
            'network_name' => 'Unlocked'
        ];

        $product = $this->productService->createProductFromRow($row);

        $this->assertInstanceOf(Product::class, $product);
        $this->assertEquals('Apple', $product->brand_name);
        $this->assertEquals('iPhone 14', $product->model_name);
    }

    public function testCreateProductFromRowMissingRequiredFieldBrandName()
    {
        $this->expectException(RequiredFieldMissingException::class);

        $row = [
            // 'brand_name' => 'Apple',  // Missing on purpose
            'model_name' => 'iPhone 14'
        ];

        $this->productService->createProductFromRow($row);
    }

    public function testCreateProductFromRowMissingRequiredFieldModelName()
    {
        $this->expectException(RequiredFieldMissingException::class);

        $row = [
            'brand_name' => 'Apple',
            // 'model_name' => 'iPhone 14', // Missing
        ];

        $this->productService->createProductFromRow($row);
    }
}
