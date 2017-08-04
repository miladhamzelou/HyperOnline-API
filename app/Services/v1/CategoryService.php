<?php
/**
 * Copyright (c) 2017 - All Rights Reserved - Arash Hatami
 */

namespace App\Services\v1;

use App\Category2;
use App\Category3;

class CategoryService
{
    public function getGroupCategories($parameters)
    {
        $index = $parameters['index'];
        $level = $parameters['level'];
        $parent = $parameters['parent'];

        $data = [];

        if ($level == 2) {
            $categories = Category2::where("parent_id", $parent)->orderBy('name', 'asc')->skip(($index - 1) * 10)->take(10)->get();

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
        } else if ($level == 3) {
            $categories = Category3::where("parent_id", $parent)->orderBy('name', 'asc')->skip(($index - 1) * 10)->take(10)->get();

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
        }

        return $data;
    }
}