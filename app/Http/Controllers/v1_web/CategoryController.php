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


use App\Category1;
use App\Category2;
use App\Category3;
use App\Http\Controllers\Controller;
use App\Services\v1\CategoryService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    protected $Categories;

    /**
     * ProductController constructor.
     * @param CategoryService $service
     */
    public function __construct(CategoryService $service)
    {
        require(app_path() . '/Common/jdf.php');
        $this->Categories = $service;
    }

    public function index()
    {
        $categories = Category::orderBy('created_at', 'desc')->get();
        $title = "Categories";
        return view('admin.categories')
            ->withTitle($title)
            ->withProducts($categories);
    }

    public function show($level)
    {
        if (Auth::user()->Role() == "admin") {
            if ($level == "1") {
                return view('admin.category_create')
                    ->withTitle("Create New Category (1)")
                    ->withLevel("1");
            } elseif ($level == "2") {
                $categories_list = array();
                $categories = Category1::get();
                foreach ($categories as $category)
                    array_push($categories_list, $category->name);
                return view('admin.category_create')
                    ->withTitle("Create New Category (2)")
                    ->withCategories($categories_list)
                    ->withLevel("2");
            } elseif ($level == "3") {
                $categories_list = array();
                $categories = Category2::get();
                foreach ($categories as $category)
                    array_push($categories_list, $category->name);
                return view('admin.category_create')
                    ->withTitle("Create New Category (3)")
                    ->withCategories($categories_list)
                    ->withLevel("3");
            }
        } else
            return redirect('/')
                ->withErrors('Unauthorized Access');
    }

    public function store(Request $request, $level)
    {
        if ($level == "1") {
            $category = new Category1();
            $category->unique_id = uniqid('', false);
            $category->name = $request->get('name');
            $category->create_date = $this->getDate($this->getCurrentTime()) . ' ' . $this->getTime($this->getCurrentTime());
            $category->save();
        } elseif ($level == "2") {
            $category = new Category2();
            $parent = Category1::where("name", $request->get('parent'))->firstOrFail()->unique_id;
            $category->unique_id = uniqid('', false);
            $category->name = $request->get('name');
            $category->parent_id = $parent;
            $category->create_date = $this->getDate($this->getCurrentTime()) . ' ' . $this->getTime($this->getCurrentTime());
            $category->save();
        } elseif ($level == "3") {
            $category = new Category3();
            $parent = Category2::where("name", $request->get('parent'))->firstOrFail()->unique_id;
            $category->unique_id = uniqid('', false);
            $category->name = $request->get('name');
            $category->parent_id = $parent;
            $category->create_date = $this->getDate($this->getCurrentTime()) . ' ' . $this->getTime($this->getCurrentTime());
            $category->save();
        }
        $message = "Category Created";
        return redirect('/admin/categories')
            ->withMessage($message);
    }

    public function edit($level, $id)
    {
        if (Auth::user()->Role() == "admin") {
            if ($level == "1") {
                $category = Category1::where("unique_id", $id)->firstOrFail();
                return view('admin.category_edit')
                    ->withTitle("Edit Category (1)")
                    ->withCategory($category);
            } elseif ($level == "2") {
                $category = Category2::where("unique_id", $id)->firstOrFail();
                $parent = Category1::where("unique_id", $category->category_id)->firstOrFail();
                $categories_list = array();
                $categories = Category1::get();
                foreach ($categories as $category)
                    array_push($categories_list, $category->name);
                return view('admin.category_edit')
                    ->withTitle("Edit Category (2)")
                    ->withCategory($category)
                    ->withParent($parent)
                    ->withCategories($categories_list);
            } elseif ($level == "3") {
                $category = Category3::where("unique_id", $id)->firstOrFail();
                $parent = Category2::where("unique_id", $category->category_id)->firstOrFail();
                $categories_list = array();
                $categories = Category2::get();
                foreach ($categories as $category)
                    array_push($categories_list, $category->name);
                return view('admin.category_edit')
                    ->withTitle("Edit Category (3)")
                    ->withCategory($category)
                    ->withParent($parent)
                    ->withCategories($categories_list);
            }
        } else
            return redirect('/')
                ->withErrors('Unauthorized Access');
    }

    public function update(Request $request, $level)
    {
        if (Auth::user()->Role() == "admin") {
            if ($level == "1") {

            } elseif ($level == "2") {

            } elseif ($level == "3") {

            }
        } else
            return redirect('/')
                ->withErrors('Unauthorized Access');
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