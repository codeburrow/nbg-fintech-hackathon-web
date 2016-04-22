<?php
/**
 * @author Rizart Dokollar <r.dokollari@gmail.com
 * @since 4/17/16
 */

namespace Database\migrations;

use App\Kernel\DbManager;
use App\Kernel\IoC;
use Colors\Color;

class ProductsTableMigration implements Migration
{
    const TABLE_NAME = 'products';

    /**
     * Drop and create table(s).
     *
     * @return mixed
     */
    public static function provision()
    {
        self::down();

        self::up();
    }

    /**
     * Drop table(s).
     *
     * @return mixed
     */
    public static function down()
    {
        $color = new Color();

        echo $color("Dropping '".self::TABLE_NAME."' table: ")->yellow();

        $dbManager = IoC::resolve(DbManager::class);

        $query = 'DROP TABLE `'.getenv('DB_NAME').'`.`'.self::TABLE_NAME.'`;';

        $tableCreated = $dbManager->getConnection()->prepare($query)->execute();

        if ($tableCreated) {
            echo $color("Done. \n")->green();
        } else {
            echo $color("Process failed. \n")->red();
        }
    }

    /**
     * Create table(s).
     *
     * @return mixed
     */
    public static function up()
    {
        echo "Creating '".self::TABLE_NAME."' table: ";

        $dbManager = IoC::resolve(DbManager::class);

        $query =
            'CREATE TABLE `'.getenv('DB_NAME').'`.`'.self::TABLE_NAME.'` (
              `id` INT NOT NULL AUTO_INCREMENT,
              `name` VARCHAR(255) NOT NULL,
              `slug` VARCHAR(255) NOT NULL,
              `price` VARCHAR(255) NOT NULL,
              `description` TEXT NOT NULL,
              `payed` TINYINT(1) NOT NULL DEFAULT 0,
            PRIMARY KEY (`id`),
            UNIQUE INDEX `name_UNIQUE` (`name` ASC),
            UNIQUE INDEX `slug_UNIQUE` (`slug` ASC));';


        $tableCreated = $dbManager->getConnection()->prepare($query)->execute();

        $color = new Color();

        if ($tableCreated) {
            echo $color("Done. \n")->green();
        } else {
            echo $color("Process failed.\n")->red();
        }
    }
}