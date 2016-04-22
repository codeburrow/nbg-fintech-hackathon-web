<?php

use App\DbServices\Product\ProductProductService;

class ProductsCest
{
    public function _before(IntegrationTester $I)
    {
    }

    public function _after(IntegrationTester $I)
    {
    }

    /**
     * @test
     * @param IntegrationTester $I
     */
    public function it_creates_product(IntegrationTester $I)
    {
        $expectedData = [
            'slug'        => 'expected-slug',
            'name'        => 'expected-name',
            'price'       => 'expected-price',
            'description' => 'expected-description',
        ];

        $I->dontSeeInDatabase('products', $expectedData);

        $productsDbService = new ProductProductService();

        $I->assertNotSame(false, $actualProductId = $productsDbService->create($expectedData));

        $expectedData['payed'] = 0;

        $I->seeInDatabase('products', $expectedData);
    }

    /**
     * @test
     * @param IntegrationTester $I
     */
    public function it_finds_category_by_slug(IntegrationTester $I)
    {
        $expectedData = [
            'slug'        => 'expected-slug',
            'name'        => 'expected-name',
            'price'       => 'expected-price',
            'description' => 'expected-description',
            'payed'       => 1,
        ];

        $expectedProductId = $I->haveInDatabase('products', $expectedData);

        $productsDbService = new ProductProductService();
        $actualProduct = $productsDbService->findBySlug('expected-slug');

        $I->assertEquals($expectedProductId, $actualProduct['id']);

        $I->assertEquals($expectedData,
            array_intersect_key($actualProduct, array_flip(['slug', 'name', 'price', 'description', 'payed'])));
    }

    /**
     * @test
     * @param IntegrationTester $I
     */
    public function it_updates_product_if_slug_is_found(IntegrationTester $I)
    {
        $productDbService = new ProductProductService();

        $expectedData = [
            'old' =>
                [
                    'slug'        => 'expected-slug',
                    'name'        => 'expected-name-old',
                    'price'       => 'expected-price-old',
                    'description' => 'expected-description-old',
                    'payed'       => 1,
                ],
            'new' =>
                [
                    'slug'        => 'expected-slug',
                    'name'        => 'expected-name-new',
                    'price'       => 'expected-price-new',
                    'description' => 'expected-description-new',
                    'payed'       => 0,
                ],
        ];

        $I->haveInDatabase('products', $expectedData['old']);

        $I->assertNotSame(false, $actualProduct = $productDbService->updateOrCreate($expectedData['new']));

        $I->dontSeeInDatabase('products', $expectedData['old']);
        $I->seeInDatabase('products', $expectedData['new']);
    }

    /**
     * @test
     * @param IntegrationTester $I
     */
    public function it_creates_product_if_slug_is_not_found(IntegrationTester $I)
    {
        $productDbService = new ProductProductService();

        $expectedData = [
            'slug'        => 'expected-slug',
            'name'        => 'expected-name-old',
            'price'       => 'expected-price-old',
            'description' => 'expected-description-old',
            'payed'       => '1',
        ];

        $I->dontSeeInDatabase('products', $expectedData);

        $I->assertTrue(false !== $productDbService->updateOrCreate($expectedData));

        $I->seeInDatabase('products', $expectedData);
    }

    /**
     * @test
     * @param IntegrationTester $I
     */
    public function it_updates_a_product(IntegrationTester $I)
    {
        $productDbService = new ProductProductService();

        $expectedData = [
            'old' =>
                [
                    'slug'        => 'slug-old',
                    'name'        => 'name-old',
                    'price'       => 'price-old',
                    'description' => 'description-old',
                    'payed'       => 0,
                ],
            'new' =>
                [
                    'slug'        => 'slug-new',
                    'name'        => 'name-new',
                    'price'       => 'price-new',
                    'description' => 'description-new',
                    'payed'       => 1,
                ],
        ];

        $I->haveInDatabase('products', $expectedData['old']);

        $I->assertNotEquals(false,
            $productDbService->updateBySlug($expectedData['new'], $expectedData['old']['slug']));

        $I->dontSeeInDatabase('products', $expectedData['old']);

        $I->seeInDatabase('products', $expectedData['new']);
    }

    /**
     * @test
     * @param IntegrationTester $I
     */
    public function it_finds_category_by_id(IntegrationTester $I)
    {
        $expectedData = [
            'slug'        => 'expected-slug',
            'name'        => 'expected-name',
            'price'       => 'expected-price',
            'description' => 'expected-description',
            'payed'       => 1,
        ];

        $productId = $I->haveInDatabase('products', $expectedData);

        $productsDbService = new ProductProductService();

        $actualProduct = $productsDbService->findById($productId);

        $I->assertEquals($productId, $actualProduct['id']);

        $I->assertEquals($expectedData,
            array_intersect_key($actualProduct, array_flip(['slug', 'name', 'price', 'description', 'payed'])));
    }

    /**
     * @test
     * @param IntegrationTester $I
     */
    public function it_pays_a_product(IntegrationTester $I)
    {
        $productData = [
            'slug'        => 'expected-slug',
            'name'        => 'expected-name',
            'price'       => 'expected-price',
            'description' => 'expected-description',
        ];

        $I->haveInDatabase('products', $productData);
        $I->seeInDatabase('products', $productData + ['payed' => 0]);

        $productsDbService = new ProductProductService();

        $I->assertTrue($productsDbService->payBySlug($productData['slug']));

        $I->seeInDatabase('products', $productData + ['payed' => 1]);
    }

    /**
     * @test
     * @param IntegrationTester $I
     */
    public function it_gets_all_products(IntegrationTester $I)
    {
        $expectedData = [
            [
                'slug'        => 'expected-slug',
                'name'        => 'expected-name',
                'price'       => 'expected-price',
                'description' => 'expected-description',
                'payed'       => 1,
            ],
            [
                'slug'        => 'expected-slug-2',
                'name'        => 'expected-name-2',
                'price'       => 'expected-price-2',
                'description' => 'expected-description-2',
                'payed'       => 0,
            ]
        ];

        $I->haveInDatabase('products', $expectedData[0]);
        $I->haveInDatabase('products', $expectedData[1]);

        $productsDbService = new ProductProductService();

        $I->assertSame(2, count(
            $actualProducts = $productsDbService->get()
        ));

        $I->assertEquals($expectedData[0],
            array_intersect_key($actualProducts[0], array_flip(['slug', 'name', 'price', 'description', 'payed'])));

        $I->assertEquals($expectedData[1],
            array_intersect_key($actualProducts[1], array_flip(['slug', 'name', 'price', 'description', 'payed'])));
    }

    /**
     * @test
     * @param IntegrationTester $I
     */
    public function it_reset_product_payment(IntegrationTester $I)
    {
        $productData = [
            'slug'        => 'expected-slug',
            'name'        => 'expected-name',
            'price'       => 'expected-price',
            'description' => 'expected-description',
            'payed'       => 1,
        ];

        $expectedData = $productData;
        $expectedData['payed'] = 0;

        $I->haveInDatabase('products', $productData);
        $I->seeInDatabase('products', $productData);

        $productsDbService = new ProductProductService();

        $I->assertTrue($productsDbService->resetPaymentBySlug($productData['slug']));

        $I->seeInDatabase('products', $expectedData);
    }
}
