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
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthorController
{

    public function __construct()
    {
        require(app_path() . '/Common/jdf.php');
    }

    public function index()
    {
        if (!Auth::user()->isAdmin())
            return redirect()->route('profile');
        $authors = Author::orderBy("created_at", "desc")->get();
        return view('admin.authors')
            ->withTitle("Authors")
            ->withAuthors($authors);
    }

    public function show()
    {
        if (Auth::user()->isAdmin()) {
            return view('admin.author_create')
                ->withTitle("Create New Author");
        } else
            return redirect('/')
                ->withErrors('دسترسی غیرمجاز');
    }

    public function store(Request $request)
    {
        if (Auth::user()->isAdmin()) {
            $author = new Author();

            $author->unique_id = uniqid('', false);
            $author->name = $request->get('name');
            $author->phone = $request->get('phone');
            $author->mobile = $request->get('mobile');
            $author->mCode = $request->get('mCode');
            $author->state = "همدان";
            $author->city = "همدان";
            $author->address = $request->get('address');
            $author->create_date = $this->getDate($this->getCurrentTime()) . ' ' . $this->getTime($this->getCurrentTime());

            $author->save();

            $message = "author created";
            return redirect('/admin/authors')->withMessage($message);
        } else
            return redirect('/')
                ->withErrors('دسترسی غیرمجاز');
    }

    public function edit($id)
    {
        if (Auth::user()->isAdmin()) {
            $author = Author::find($id);
            return view('admin.author_edit')
                ->withTitle("Edit author")
                ->withAuthor($author);
        } else
            return redirect('/')
                ->withErrors('دسترسی غیرمجاز');

    }

    public function update(Request $request)
    {
        if (Auth::user()->isAdmin()) {
            $author = Author::where("unique_id", $request->get('unique_id'))->firstOrFail();

            $author->name = $request->get('name');
            $author->phone = $request->get('phone');
            $author->mobile = $request->get('mobile');
            $author->mCode = $request->get('mCode');
            $author->address = $request->get('address');

            $author->save();

            $message = "author updated";
            return redirect('/admin/authors')->withMessage($message);
        } else
            return redirect('/')
                ->withErrors('دسترسی غیرمجاز');
    }

    protected function getCurrentTime()
    {
        $now = date("Y-m-d", time());
        $time = date("H:i:s", time());
        return $now . ' ' . $time;
    }

    protected function getDate($date)
    {
        $now = explode(' ', $date)[0];
        $time = explode(' ', $date)[1];
        list($year, $month, $day) = explode('-', $now);
        list($hour, $minute, $second) = explode(':', $time);
        $timestamp = mktime($hour, $minute, $second, $month, $day, $year);
        $date = jDate("Y/m/d", $timestamp);
        return $date;
    }

    protected function getTime($date)
    {
        $now = explode(' ', $date)[0];
        $time = explode(' ', $date)[1];
        list($year, $month, $day) = explode('-', $now);
        list($hour, $minute, $second) = explode(':', $time);
        $timestamp = mktime($hour, $minute, $second, $month, $day, $year);
        $date = jDate("H:i", $timestamp);
        return $date;
    }
}