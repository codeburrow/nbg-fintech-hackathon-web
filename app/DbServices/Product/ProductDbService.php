<?php namespace App\DbServices\Product;

use App\DbServices\DbService;
use PDO;

/**
 * @author Rizart Dokollar <r.dokollari@gmail.com
 * @since 4/22/16
 */
class ProductDbService extends DbService implements ProductService
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
    public function updateOrCreate($data)
    {
        if (false !== ($fund = $this->findBySlug($data['slug']))) {
            return $this->updateBySlug($data, $data['slug']);
        }

        return $this->findById(
            $this->create($data)
        );
    }

    /**
     * Find a product given its slug.
     *
     * @param $slug
     * @return mixed
     */
    public function findBySlug($slug)
    {
        $query = 'SELECT * FROM `'.getenv('DB_NAME').'`.`'.ProductsTableMigration::TABLE_NAME.'` WHERE `slug` = :slug';

        $statement = $this->getConnection()->prepare($query);

        $statement->bindParam(':slug', $slug, PDO::PARAM_INT);

        $statement->execute();

        return $statement->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Update a product given its slug.
     *
     * @param $data 'name', 'slug', 'payed' are required, and must been already validated as needed.
     * @param $oldSlug string Must be already validated for existence.
     * @return mixed
     */
    public function updateBySlug($data, $oldSlug)
    {
        $query =
            'UPDATE `'.getenv('DB_NAME').'`.`'.ProductsTableMigration::TABLE_NAME.'` 
             SET `name`=:name, `slug`=:slug, `price`=:price, `description`=:description,
             `payed`=:payed 
             WHERE `slug`=:oldSlug;';

        $price = isset($data['price']) ? $data['price'] : null;
        $description = isset($data['description']) ? $data['description'] : null;

        $statement = $this->getConnection()->prepare($query);

        $statement->bindParam(':name', $data['name'], PDO::PARAM_STR);
        $statement->bindParam(':slug', $data['slug'], PDO::PARAM_STR);
        $statement->bindParam(':price', $price, PDO::PARAM_STR);
        $statement->bindParam(':description', $description, PDO::PARAM_STR);
        $statement->bindParam(':payed', $data['payed'], PDO::PARAM_STR);
        $statement->bindParam(':oldSlug', $oldSlug, PDO::PARAM_STR);

        return $statement->execute();
    }

    /**
     * Find a product given its id.
     *
     * @param $id
     * @return mixed
     */
    public function findById($id)
    {
        $query = 'SELECT * FROM `'.getenv('DB_NAME').'`.`'.ProductsTableMigration::TABLE_NAME.'` WHERE `id` = :id';

        $statement = $this->getConnection()->prepare($query);

        $statement->bindParam(':id', $id, PDO::PARAM_INT);

        $statement->execute();

        return $statement->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Create a product.
     *
     * @param $data 'name' and 'slug' keys are required, and must been already been validated as needed.
     *
     * @return mixed
     */
    public function create($data)
    {
        $query =
            'INSERT INTO `'.getenv('DB_NAME').'`.`products` (`name`, `slug`, `price`, `description`, `payed`) 
            VALUES (:name, :slug, :price, :description, :payed);';

        $name = $data['name'];
        $slug = $data['slug'];
        $price = isset($data['price']) ? $data['price'] : null;
        $description = isset($data['description']) ? $data['description'] : null;
        $payed = isset($data['payed']) ? $data['payed'] : 0;

        $statement = $this->getConnection()->prepare($query);

        $statement->bindParam(':name', $name, PDO::PARAM_STR);
        $statement->bindParam(':slug', $slug, PDO::PARAM_STR);
        $statement->bindParam(':price', $price, PDO::PARAM_STR);
        $statement->bindParam(':description', $description, PDO::PARAM_STR);
        $statement->bindParam(':payed', $payed, PDO::PARAM_INT);
        $statement->execute();

        return $this->getConnection()->lastInsertId();
    }

    /**
     * Change a product payed status to true.
     *
     * @param $slug string The slug of the product.
     * @return bool
     */
    public function payBySlug($slug)
    {
        return $this->updatePaymentStatusBySlug($slug, true);
    }

    /**
     * @param $slug
     * @param $paymentStatus bool True to pay, false to reset.
     * @return bool
     */
    private function updatePaymentStatusBySlug($slug, $paymentStatus)
    {
        $paymentStatus = true === $paymentStatus ? '1' : '0';

        $query =
            "UPDATE `".getenv('DB_NAME')."`.`".ProductsTableMigration::TABLE_NAME."` 
             SET `payed`={$paymentStatus} 
             WHERE `slug`=:slug;";

        $statement = $this->getConnection()->prepare($query);

        $statement->bindParam(':slug', $slug, PDO::PARAM_STR);

        return $statement->execute();
    }

    /**
     * Get all the products.
     *
     * @return mixed
     */
    public function get()
    {
        $query = 'SELECT * FROM `'.getenv('DB_NAME').'`.`'.ProductsTableMigration::TABLE_NAME.'`';

        $statement = $this->getConnection()->prepare($query);

        $statement->execute();

        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Change a product payed status to false.
     *
     * @param $slug string The slug of the product.
     * @return bool
     */
    public function resetPaymentBySlug($slug)
    {
        return $this->updatePaymentStatusBySlug($slug, false);
    }
}