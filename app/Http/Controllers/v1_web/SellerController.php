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
use App\Seller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SellerController
{
    public function __construct()
    {
        require(app_path() . '/Common/jdf.php');
    }

    public function index()
    {
        if (!Auth::user()->isAdmin())
            return redirect()->route('profile');
        $sellers = Seller::orderBy("created_at", "desc")->get();
        return view('admin.sellers')
            ->withTitle("Sellers")
            ->withSellers($sellers);
    }

    public function show()
    {
        if (Auth::user()->isAdmin()) {
            $authors_list = array();
            $authors = Author::get();
            foreach ($authors as $author)
                array_push($authors_list, $author->name);

            return view('admin.seller_create')
                ->withTitle("Create New Seller")
                ->withAuthors($authors_list);
        } else
            return redirect('/')
                ->withErrors('دسترسی غیرمجاز');
    }

    public function store(Request $request)
    {
        if (Auth::user()->isAdmin()) {
            $seller = new Seller();

            $author = Author::where("name", $request->get('author'))->firstOrFail()->unique_id;

            $seller->unique_id = uniqid('', false);
            $seller->author_id = $author;
            $seller->name = $request->get('name');
            $seller->address = $request->get('address');
            $seller->phone = $request->get('phone');
            $seller->open_hour = $request->get('open_hour');
            $seller->close_hour = $request->get('close_hour');
            $seller->type = $request->get('type');
            $seller->state = "همدان";
            $seller->city = "همدان";
            $seller->create_date = $this->getDate($this->getCurrentTime()) . ' ' . $this->getTime($this->getCurrentTime());

            $seller->save();

            $message = "seller created";
            return redirect('/admin/sellers')->withMessage($message);
        } else
            return redirect('/')
                ->withErrors('دسترسی غیرمجاز');
    }

    public function edit($id)
    {
        if (Auth::user()->isAdmin()) {
            $seller = Seller::find($id);
            $author2 = Author::where("unique_id", $seller->author_id)->firstOrFail();
            $authors_list = array();
            $authors = Author::get();
            foreach ($authors as $author)
                array_push($authors_list, $author->name);
            return view('admin.seller_edit')
                ->withTitle("Edit Seller")
                ->withSeller($seller)
                ->withAuthors($authors_list)
                ->withAuthor_selected($author2->name);
        } else
            return redirect('/')
                ->withErrors('دسترسی غیرمجاز');
    }

    public function update(Request $request)
    {
        if (Auth::user()->isAdmin()) {
            $seller = Seller::where("unique_id", $request->get('unique_id'))->firstOrFail();

            $author = Author::where("name", $request->get('author'))->firstOrFail()->unique_id;

            $seller->author_id = $author;
            $seller->name = $request->get('name');
            $seller->address = $request->get('address');
            $seller->phone = $request->get('phone');
            $seller->open_hour = $request->get('open_hour');
            $seller->close_hour = $request->get('close_hour');
            $seller->type = $request->get('type');

            $seller->save();

            $message = "seller updated";
            return redirect('/admin/sellers')->withMessage($message);
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