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
    public function getGroupCategories($parameters)
    {
        $index = $parameters['index'];
        $level = $parameters['level'];

        $data = [];
        $categories = [];

        if ($level == 1) {
            $categories = Category1::orderBy('name', 'asc')->skip(($index - 1) * 10)->take(10)->get();
        } else if ($level == 2) {
            $parent = $parameters['parent'];
            $categories = Category2::where("parent_id", $parent)->orderBy('name', 'asc')->skip(($index - 1) * 10)->take(10)->get();
        } else if ($level == 3) {
            $parent = $parameters['parent'];
            $categories = Category3::where("parent_id", $parent)->orderBy('name', 'asc')->skip(($index - 1) * 10)->take(10)->get();
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