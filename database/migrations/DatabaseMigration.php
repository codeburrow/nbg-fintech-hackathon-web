<?php
/**
 * @author Rizart Dokollar <r.dokollari@gmail.com
 * @since 4/17/16
 */

namespace Database\migrations;

class DatabaseMigration implements Migration
{
    /**
     * Create table(s).
     *
     * @return mixed
     */
    public static function up()
    {
        ProductsTableMigration::up();
    }

    /**
     * Drop table(s).
     *
     * @return mixed
     */
    public static function down()
    {
        ProductsTableMigration::down();
    }

    /**
     * Drop and create table(s).
     *
     * @return mixed
     */
    public static function provision()
    {
        ProductsTableMigration::provision();
    }
}