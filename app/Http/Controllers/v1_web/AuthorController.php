<?php
/**
 * Copyright (c) 2017 - All Rights Reserved - Arash Hatami
 */

/**
 * Created by PhpStorm.
 * User: root
 * Date: 8/14/17
 * Time: 6:18 PM
 */

namespace app\Http\Controllers\v1_web;


use App\Author;

class AuthorController
{
    public function index()
    {
        $authors = Author::orderBy("created_at", "desc")->get();
        return view('admin.authors')
            ->withTitle("Authors")
            ->withAuthors($authors);
    }
}