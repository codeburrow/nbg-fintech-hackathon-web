<?php
/**
 * @author Rizart Dokollar <r.dokollari@gmail.com
 * @since 4/22/16
 */
use App\Controllers\Api\V1\ProductsController;
use App\Controllers\WelcomeController;
use App\DbServices\Product\ProductDbService;
use App\DbServices\Product\ProductService;
use App\Kernel\DbManager;
use App\Kernel\IoC;
use App\Requests\Api\ProductsPayRequest;
use App\Transformers\Api\ProductsApiTransformer;
use Cocur\Slugify\Slugify;

IoC::register(DbManager::class, function () {
    $dbManager = new DbManager();

    return $dbManager;
});

IoC::register(WelcomeController::class, function () {
    $welcomeController = new WelcomeController();

    return $welcomeController;
});

IoC::register(ProductsController::class, function () {
    $productsController = new ProductsController(new ProductDbService(), new ProductsApiTransformer());

    return $productsController;
});
IoC::register(ProductService::class, function () {
    $productService = new ProductDbService();

    return $productService;
});
IoC::register(Slugify::class, function () {
    $slugify = new Slugify();

    return $slugify;
});
IoC::register(ProductsPayRequest::class, function () {
    $productsPayRequest = new ProductsPayRequest(IoC::resolve(ProductService::class, new ProductsApiTransformer));

    return $productsPayRequest;
});
IoC::register(ProductsPayRequest::class, function () {
    $productsPayRequest = new ProductsPayRequest(IoC::resolve(ProductService::class, new ProductsApiTransformer));

    return $productsPayRequest;
});