<?php namespace App\DbServices\Product;

/**
 * @author Rizart Dokollar <r.dokollari@gmail.com
 * @since 4/22/16
 */
interface ProductService
{
    /**
     * Update a product if the given slug exists.
     * Create a product if the given slug does not exists.
     *
     * @param $data 'name' and 'slug' are required, and must been already been validate for uniqueness.
     * @param 'name' and 'slug' are required, and must been already been validate for uniqueness.
     *
     * @return mixed
     */
    public function updateOrCreate($data);

    /**
     * Find a product given its slug.
     *
     * @param $slug
     * @return mixed
     */
    public function findBySlug($slug);

    /**
     * Update a product given its slug.
     *
     * @param $data 'name', 'slug', 'payed' are required, and must been already validated as needed.
     * @param $oldSlug string Must be already validated for existence.
     * @return mixed
     */
    public function updateBySlug($data, $oldSlug);

    /**
     * Find a product given its id.
     *
     * @param $id
     * @return mixed
     */
    public function findById($id);

    /**
     * Create a product.
     *
     * @param $data 'name' and 'slug' keys are required, and must been already been validated as needed.
     *
     * @return mixed
     */
    public function create($data);

    /**
     * Change a product payed status to true.
     *
     * @param $slug string The slug of the product.
     * @return bool
     */
    public function payBySlug($slug);

    /**
     * Get all the products.
     *
     * @return mixed
     */
    public function get();

    /**
     * Change a product payed status to false.
     *
     * @param $slug string The slug of the product.
     * @return bool
     */
    public function resetPaymentBySlug($slug);
}