<?php
declare(strict_types=1);
namespace App\Http\Assembler\Product;

use App\Application\Product\DTO\ProductDTO;
use Generator;
use InvalidArgumentException;

class ProductDTOsAssembler
{
    /**
     * @param array $products
     * @return ProductDTO[]|Generator
     */
    public function create(array $products): iterable
    {
        foreach ($products as $key => $product) {
            $productName = $product['name'] ?? null;
            if (!is_string($productName)) {
                throw new InvalidArgumentException('Incorrect name of product #' . $key);
            }

            $productPrice = $product['price'] ?? null;
            if (!is_numeric($productPrice)) {
                throw new InvalidArgumentException('Incorrect price of product #' . $key);
            }

            yield new ProductDTO($productName, (float)$productPrice);
        }
    }
}
