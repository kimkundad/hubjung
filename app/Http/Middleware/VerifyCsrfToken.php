<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as BaseVerifier;

class VerifyCsrfToken extends BaseVerifier
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        //
        'file/post',
         'admin/blog',
         'api/updatedata',
         'admin/event/',
         'admin/event/*',
         'admin/blog/*',
        'api/*',
        'add_video_course',
        'add_video_course_example',
        'admin/search_list_video*',
    ];
}
