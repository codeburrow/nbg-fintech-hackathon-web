<?php
/**
 * @author Rizart Dokollar <r.dokollari@gmail.com
 * @since 4/17/16
 */

namespace App\Controllers\Api\V1;

use App\DbServices\Product\ProductService;
use App\Kernel\IoC;
use App\Requests\Api\ProductsPayRequest;
use App\Responders\Api\ApiResponder;
use App\Transformers\Transformer;

/**
 * Class ProductsController.
 */
class ProductsController
{
    use ApiResponder;

    /**
     * @var ProductService
     */
    private $productService;
    /**
     * @var Transformer
     */
    private $transformer;

    /**
     * ProductsController constructor.
     * @param ProductService $productDbService
     * @param Transformer    $transformer
     */
    public function __construct(ProductService $productDbService, Transformer $transformer)
    {
        $this->productService = $productDbService;
        $this->transformer = $transformer;
    }

    /**
     * @api            {get} api/v1/products/payment/request?product-slug={product_slug} Pay
     * @apiPermission  none
     * @apiVersion     1.0.0
     * @apiName        PayProducts
     * @apiGroup       Products
     * @apiDescription Make a  payment give a product slug.
     * @apiExample {curl} Example usage:
     *
     * curl -i -H "Accept: application/json" -H "Content-Type: application/json" -X GET "http://zapit-web.herokuapp.com/api/v1/products/payment/request?product-slug=iot"
     *
     * @apiSuccess {String} status_code Request status.
     * @apiSuccess {String[]} data The updated product details info.
     * @apiSuccess {String} slug The unique identification of the product.
     * @apiSuccess {String} name The unique name the product
     * @apiSuccess {String} price Price of the product.
     * @apiSuccess {String} description Description of the product.
     * @apiSuccess {String} payed New payment status for the product.
     *
     * @apiSuccessExample {json} Success-Response:
     *      HTTP/1.1 200 OK
     *      {
     *          "status_code" : 200
     *          "data" :   {
     *             "slug": "iot",
     *             "name": "IoT",
     *             "price": "100",
     *             "description": "Description of an IoT",
     *             "payed": true,
     *          },
     *      }
     */

    /**
     * Expects a $_GET key of 'product-slug'. The ProductsPayRequest will make sure this exists.
     * Pay for a product.
     */
    public function requestPayment()
    {
        IoC::resolve(ProductsPayRequest::class)
            ->validate();

        $productSlug = $_GET['product-slug'];

        if ($this->productService->payBySlug($productSlug)) {
            $product = $this->productService->findBySlug($productSlug);

            return $this->respondWithSuccess($this->transformer->transform($product));
        }

        return $this->respondInternalServerError();
    }

    /**
     * @api            {get} api/v1/products Get products
     * @apiPermission  none
     * @apiVersion     1.0.0
     * @apiName        GetProducts
     * @apiGroup       Products
     * @apiDescription Fetch list, with products.
     * @apiExample {curl} Example usage:
     *
     * curl -i -H "Accept: application/json" -H "Content-Type: application/json" -X GET "http://zapit-web.herokuapp.com/api/v1/products"
     *
     * @apiSuccess {String} status_code Request status.
     * @apiSuccess {String[]} data The array with products.
     * @apiSuccess {String} slug The unique identification for each product.
     * @apiSuccess {String} name The unique name for each product.
     * @apiSuccess {String} price Price of the product.
     * @apiSuccess {String} description Description of the product.
     * @apiSuccess {String} payed Payment status for the product.
     *
     * @apiSuccessExample {json} Success-Response:
     *      HTTP/1.1 200 OK
     *      {
     *          "status_code" : 200
     *          "data" :  [
     *              {
     *                  "slug": "iot",
     *                  "name": "IoT",
     *                  "price": "100",
     *                  "description": "Description of an IoT",
     *                  "payed": false,
     *              },
     *              {
     *                  "slug": "cards-against-humanity",
     *                  "name": "Cards Against Humanity",
     *                  "price": "25",
     *                  "description": "Cards Against Humanity is a party game for horrible people. Unlike most of the party games you've played before, Cards Against Humanity is as despicable and awkward as you and your friends. ",
     *                  "payed": false,
     *              },
     *          ],
     *      }
     */

    /**
     * Get all products.
     */
    public function index()
    {
        $products = $this->productService->get();

        return $this->respondWithSuccess($this->transformer->transformCollection($products));
    }

    /**
     * @api            {get} api/v1/products/payment/reset?product-slug={product_slug} Reset payment
     * @apiPermission  none
     * @apiVersion     1.0.0
     * @apiName        ResetPaymentProducts
     * @apiGroup       Products
     * @apiDescription Reset the payment of a product. To be used for the android debugging.
     * @apiExample {curl} Example usage:
     *
     * curl -i -H "Accept: application/json" -H "Content-Type: application/json" -X GET "http://zapit-web.herokuapp.com/api/v1/products/payment/reset?product-slug=iot"
     *
     * @apiSuccess {String} status_code Request status.
     * @apiSuccess {String[]} data The updated product details info.
     * @apiSuccess {String} slug The unique identification of the product.
     * @apiSuccess {String} name The unique name the product
     * @apiSuccess {String} price Price of the product.
     * @apiSuccess {String} description Description of the product.
     * @apiSuccess {String} payed New payment status for the product.
     *
     * @apiSuccessExample {json} Success-Response:
     *      HTTP/1.1 200 OK
     *      {
     *          "status_code" : 200
     *          "data" :   {
     *             "slug": "iot",
     *             "name": "IoT",
     *             "price": "100",
     *             "description": "Description of an IoT",
     *             "payed": false,
     *          },
     *      }
     */

    /**
     * Expects a $_GET key of 'product-slug'. The ProductsPayRequest will make sure this exists.
     * Pay for a product.
     */
    public function resetPayment()
    {
        IoC::resolve(ProductsPayRequest::class)
            ->validate();

        $productSlug = $_GET['product-slug'];

        if ($this->productService->resetPaymentBySlug($productSlug)) {
            $product = $this->productService->findBySlug($productSlug);

            return $this->respondWithSuccess($this->transformer->transform($product));
        }

        return $this->respondInternalServerError();
    }

    /**
     * @api            {get} api/v1/products/payment/status?product-slug={product_slug} Check payment
     * @apiPermission  none
     * @apiVersion     1.0.0
     * @apiName        CheckPaymentStatusProducts
     * @apiGroup       Products
     * @apiDescription Check the payment status of a product.
     * @apiExample {curl} Example usage:
     *
     * curl -i -H "Accept: application/json" -H "Content-Type: application/json" -X GET "http://zapit-web.herokuapp.com/api/v1/products/payment/status?product-slug=iot"
     *
     * @apiSuccess {String} status_code Request status.
     * @apiSuccess {String[]} data The product details info.
     * @apiSuccess {String} slug The unique identification of the product.
     * @apiSuccess {String} name The unique name the product
     * @apiSuccess {String} price Price of the product.
     * @apiSuccess {String} description Description of the product.
     * @apiSuccess {String} payed Payment status for the product.
     *
     * @apiSuccessExample {json} Success-Response:
     *      HTTP/1.1 200 OK
     *      {
     *          "status_code" : 200
     *          "data" :   {
     *             "slug": "iot",
     *             "name": "IoT",
     *             "price": "100",
     *             "description": "Description of an IoT",
     *             "payed": false,
     *          },
     *      }
     */

    /**
     * Expects a $_GET key of 'product-slug'. The ProductsPayRequest will make sure this exists.
     * Pay for a product.
     */
    public function checkStatusPayment()
    {
        IoC::resolve(ProductsPayRequest::class)
            ->validate();

        $productSlug = $_GET['product-slug'];

        $product = $this->productService->findBySlug($productSlug);

        return $this->respondWithSuccess($this->transformer->transform($product));
    }
}