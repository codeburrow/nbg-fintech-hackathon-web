<?php
/**
 * @author Rizart Dokollar <r.dokollari@gmail.com
 * @since 4/17/16
 */

namespace App\Requests\Api;

use App\DbServices\Product\ProductService;
use App\Responders\Api\ApiResponder;

class ProductsPayRequest implements Request
{
    use ApiResponder;

    /**
     * @var ProductService
     */
    private $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    /**
     * Validate request.
     * If successful allows request flow to continue. Else redirects back with relative errors.
     * @return mixed
     */
    public function validate()
    {
        if (! isset($_GET['product-slug'])) {
            return $this->respondUnprocessableEntity("The parameter 'product-slug' is missing.");
        }

        if (! $this->productService->findBySlug($_GET['product-slug'])) {
            return $this->respondUnprocessableEntity("The given product slug does not exist.");
        }

        return true;
    }
}