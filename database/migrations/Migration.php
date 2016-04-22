<?php
/**
 * @author Rizart Dokollar <r.dokollari@gmail.com
 * @since 4/17/16
 */

namespace Database\migrations;

interface Migration
{
    /**
     * Create table(s).
     *
     * @return mixed
     */
    public static function up();

    /**
     * Drop table(s).
     *
     * @return mixed
     */
    public static function down();

    /**
     * Drop and create table(s).
     *
     * @return mixed
     */
    public static function provision();
}