# supplier_product_processor
A command-line PHP application designed to parse CSV or TSV product lists, output each row as a Product object, and generate unique combination counts grouped by fields (like brand_name, model_name, etc.). This project showcases stream processing, OOP design, and unit testing with PHPUnit.

## Features

### Parse CSV or TSV
- Utilizes a factory pattern (ParserFactory) to determine whether to use CsvProductParser or TsvProductParser based on the file extension.
- Reads files line-by-line to manage large files efficiently.

### Product Model
- Maps each row to a Product object with both required and optional fields:
  - **Required**: brand_name, model_name.
  - **Optional**: condition_name, grade_name, gb_spec_name, colour_name, network_name.

### Unique Combination Counts
- A UniqueCombinationService groups products by their unique combination of fields and tallies them.
- Allows saving these tallies to a CSV for analysis.

### Exception Handling
- Throws a RequiredFieldMissingException if essential fields are missing.

### Tests
- Includes multiple PHPUnit tests for models, services, and parsers (CSV, TSV).
- Ensures that each component functions correctly.

## Future Enhancements

### JSON Parsing
- Plans to add a JsonProductParser for handling .json files.
### XML Support
- Future support for .xml files.
### Database Integration
- Potential integration with databases for handling extremely large files or numerous unique combinations.
### Logging & Config
- Implementation of PSR-3 logging or a dedicated config file for enhanced error and environment handling.

## Requirements

- PHP 7+
- Composer (for autoloading and running PHPUnit tests)
- On Windows, ensure that `php` and `composer` commands are recognized in your terminal.

## Installation & Setup

```bash
# Clone the repository or download the project.
# Install Composer dependencies
composer install
```

This will create the `vendor/` directory with the necessary autoload files.

### Check Project Structure (simplified example)

```plaintext
supplier-product-processor/
├── parser.php               # Main script to run the parser
├── src/
│   ├── Models/
│   │   └── Product.php      # Defines the Product class
│   ├── Services/
│   │   ├── ProductService.php           # Handles processing of product data
│   │   └── UniqueCombinationService.php # Manages unique combination logic
│   ├── Parsers/
│   │   ├── CsvProductParser.php         # Parser for CSV files
│   │   └── TsvProductParser.php         # Parser for TSV files
│   ├── Factories/
│   │   └── ParserFactory.php            # Factory to choose the correct parser based on file type
│   └── Exceptions/
│       └── RequiredFieldMissingException.php  # Exception for missing required fields
├── tests/
│   ├── ProductTest.php                  # Tests for Product model
│   ├── ProductServiceTest.php           # Tests for ProductService
│   ├── UniqueCombinationServiceTest.php # Tests for UniqueCombinationService
│   ├── CsvProductParserTest.php         # Tests for CsvProductParser
│   ├── TsvProductParserTest.php         # Tests for TsvProductParser
│   └── ParserFactoryTest.php            # Tests for ParserFactory
├── vendor/                  # Autoloaded vendor libraries (generated by Composer)
├── composer.json            # Composer configuration file
└── composer.lock            # Lock file to ensure consistent installation of package versions

```

## How to Use

From your project’s root directory, run:

```bash
php parser.php --file=path_to_input_file [--unique-combinations=output_file]
```

- `--file=path_to_input_file`: The CSV or TSV file you want to parse.
- `--unique-combinations=output_file`: If provided, saves a CSV tally of unique combination counts.

### Example Usage

```bash
php parser.php --file=example.csv --unique-combinations=combination_count.csv
```

Each row from `example.csv` is mapped to a Product object and printed to the console. The unique combination counts are saved in `combination_count.csv`. For TSV files, just provide a .tsv file instead.

## Running Tests

### PHPUnit Tests

```bash
# Install dev-dependencies (if not already done)
composer require --dev phpunit/phpunit

# Run tests
php vendor/bin/phpunit --testdox
```

### Test Coverage (optional)

Configure coverage in `phpunit.xml` and run:

```bash
./vendor/bin/phpunit --coverage-html coverage
```

This generates an HTML coverage report in the `coverage` folder.

## Example File Formats

### CSV (example.csv)

```csv
brand_name,model_name,condition_name,grade_name,gb_spec_name,colour_name,network_name
Apple,iPhone 14,Working,Grade A,128GB,Red,Unlocked
Samsung,Galaxy S9,Working,Grade A,256GB,Purple,Unlocked
```

### TSV (example.tsv)

```plaintext
brand_name    model_name    condition_name    grade_name    gb_spec_name    colour_name    network_name
Apple  iPhone 14  Working  Grade A  128GB  Red  Unlocked
Samsung  Galaxy S9  Working  Grade A  256GB  Purple  Unlocked
```

(Tabs between columns, not spaces.)

## Contributing & Future

- **JSON and XML Parser Support**: Implement parsers to extend the functionality to additional file formats such as JSON and XML.
- **Database Integration**: Integrate a database for managing extremely large datasets or complex data relationships.
- **Enhanced Logging and Configuration**: Implement advanced logging mechanisms and customizable configuration settings to better manage different environments and error logging.

## License

- MIT.

