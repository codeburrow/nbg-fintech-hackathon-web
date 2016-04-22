<?php
/**
 * @author Rizart Dokollar <r.dokollari@gmail.com
 * @since 4/22/16
 */

use App\Controllers\WelcomeController;

return [
    ['httpMethod' => 'GET', 'route' => '/', 'handler' => call_user_func([new WelcomeController, 'index'])]
];