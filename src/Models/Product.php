<?php

namespace App\Models;

class Product
{
    /**
     * Required fields
     */
    public $brand_name;   // string (required)
    public $model_name;   // string (required)

    /**
     * Optional fields
     */
    public $condition_name; // string
    public $grade_name;     // string
    public $gb_spec_name;   // string
    public $colour_name;    // string
    public $network_name;   // string

    public function __construct(
        string $brand_name,
        string $model_name,
        string $condition_name = null,
        string $grade_name = null,
        string $gb_spec_name = null,
        string $colour_name = null,
        string $network_name = null
    ) {
        $this->brand_name     = $brand_name;
        $this->model_name     = $model_name;
        $this->condition_name = $condition_name;
        $this->grade_name     = $grade_name;
        $this->gb_spec_name   = $gb_spec_name;
        $this->colour_name    = $colour_name;
        $this->network_name   = $network_name;
    }

    /**
     * Convert the product object to a string (for debugging/printing).
     */
    public function __toString()
    {
        return sprintf(
            "Product: brand_name=%s, model_name=%s, condition_name=%s, grade_name=%s, gb_spec_name=%s, colour_name=%s, network_name=%s",
            $this->brand_name,
            $this->model_name,
            $this->condition_name,
            $this->grade_name,
            $this->gb_spec_name,
            $this->colour_name,
            $this->network_name
        );
    }
}
