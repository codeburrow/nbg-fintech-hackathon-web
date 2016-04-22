<?php
/**
 * @author Rizart Dokollar <r.dokollari@gmail.com
 * @since 4/17/16
 */

require __DIR__.'/../../vendor/autoload.php';
require __DIR__.'/../../bootstrap/bootstrap.php';

use Database\migrations\DatabaseMigration;

DatabaseMigration::up();
