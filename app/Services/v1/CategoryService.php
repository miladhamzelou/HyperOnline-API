<?php
/**
 * Copyright (c) 2017 - All Rights Reserved - Arash Hatami
 */

namespace App\Services\v1;

use App\Category1;
use App\Category2;
use App\Category3;

class CategoryService
{
    public function getGroupCategories($request)
    {
        $index = $request['index'];
        $level = $request['level'];
        $parent = $request['parent'];

        $data = [];
        $categories = [];

        if ($level == 1) {
            $categories = Category1::orderBy('name', 'asc')->skip(($index - 1) * 10)->take(10)->get();
        } else if ($level == 2) {
            if ($parent != 'n')
                $categories = Category2::where("parent_id", $parent)->orderBy('name', 'asc')->skip(($index - 1) * 10)->take(10)->get();
            else
                $categories = Category2::orderBy('name', 'asc')->skip(($index - 1) * 10)->take(10)->get();
        } else if ($level == 3) {
            if ($parent != 'n')
                $categories = Category3::where("parent_id", $parent)->orderBy('name', 'asc')->skip(($index - 1) * 10)->take(10)->get();
            else
                $categories = Category3::orderBy('name', 'asc')->skip(($index - 1) * 10)->take(10)->get();
        }

        foreach ($categories as $category) {
            $entry = [
                'unique_id' => $category->unique_id,
                'name' => $category->name,
                'image' => $category->image,
                'point' => $category->point,
                'point_count' => $category->point_count,
                'off' => $category->off
            ];

            $data[] = $entry;
        }

        return $data;
    }
}