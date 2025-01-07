<?php

use PHPUnit\Framework\TestCase;
use App\Models\Product;

class ProductTest extends TestCase
{
    public function testCreateProductWithRequiredFields()
    {
        $product = new Product('Apple', 'iPhone X');

        $this->assertEquals('Apple', $product->brand_name);
        $this->assertEquals('iPhone X', $product->model_name);
        $this->assertNull($product->condition_name);
        $this->assertNull($product->grade_name);
        $this->assertNull($product->gb_spec_name);
        $this->assertNull($product->colour_name);
        $this->assertNull($product->network_name);
    }

    public function testCreateProductWithAllFields()
    {
        $product = new Product(
            'Samsung',
            'Galaxy S9',
            'Working',
            'Grade A',
            '256GB',
            'Purple',
            'Unlocked'
        );

        $this->assertEquals('Samsung', $product->brand_name);
        $this->assertEquals('Galaxy S9', $product->model_name);
        $this->assertEquals('Working', $product->condition_name);
        $this->assertEquals('Grade A', $product->grade_name);
        $this->assertEquals('256GB', $product->gb_spec_name);
        $this->assertEquals('Purple', $product->colour_name);
        $this->assertEquals('Unlocked', $product->network_name);
    }

    public function testToStringMethod()
    {
        $product = new Product(
            'Apple',
            'iPhone 14',
            'Working',
            'Grade A',
            '128GB',
            'Red',
            'Unlocked'
        );

        $expected = 'Product: brand_name=Apple, model_name=iPhone 14, condition_name=Working, grade_name=Grade A, gb_spec_name=128GB, colour_name=Red, network_name=Unlocked';
        $this->assertEquals($expected, (string) $product);
    }
}
