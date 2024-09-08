<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array<int, string>
     */
    protected $except = [
        '/rg',
        '/lg',
        '/films/adminAddMovie/addM',
        '/films/adminAddMovie/addS',
        '/films/{movieID}/pay/{sessionID}/checkData',
        '/films/{movieID}/pay/{sessionID}/complate',
        '/films/{movieID}/comment',
        '/films/{movieID}/edit/save'
    ];
}
