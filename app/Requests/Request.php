<?php
/**
 * @author Rizart Dokollar <r.dokollari@gmail.com
 * @since 4/17/16
 */

namespace App\Requests;

interface Request
{
    /**
     * Validate request. If successful allows request flow to continue. Else redirects back with relative errors.
     * @return mixed
     */
    public function validate();
}