<?php

namespace App\Http\Controllers\v1\market;

use App\Category;
use App\Category1;
use App\Category2;
use App\Category3;
use App\Http\Controllers\Controller;
use App\Product;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\View;

class MainController extends Controller
{
    public function index()
    {
        $new = $this->getNew();
        $cat = $this->getCategories();
        Log::info("finish");
        Log::info($cat);

        return view('market.layout.base')
            ->withNew($new)
            ->withCategories($cat);
    }

    protected function getNew()
    {
        $result = Product::where("confirmed", 1)
            ->orderBy("created_at", "desc")
            ->take(10)
            ->get();
        return $result;
    }

    function buildTree(array $items) {
        $tree = [];

        foreach($items as $item) {
            $pid  = $item['parent_id'];
            $id   = $item['unique_id'];
            $name = $item['name'];

            // Create or add child information to the parent node
            if (isset($tree[$pid]))
                // a node for the parent exists
                // add another child id to this parent
                $tree[$pid]["child"][] = $id;
            else
                // create the first child to this parent
                $tree[$pid] = array("child"=>array($id));

            // Create or add name information for current node
            if (isset($tree[$id]))
                // a node for the id exists:
                // set the name of current node
                $tree[$id]["name"] = $name;
            else
                // create the current node and give it a name
                $tree[$id] = array( "name"=>$name );
        }

        return $tree;
    }

    protected function getCategories()
    {
        $array = array();

        $cat1 = $this->filterCategory(Category1::get()->toArray());
        foreach ($cat1 as $category1) {
            array_push($array, $category1);
            $cat2 = $this->filterCategory(Category2::where("parent_id", $category1['unique_id'])->get()->toArray());
            foreach ($cat2 as $category2) {
                array_push($array, $category2);
                $cat3 = $this->filterCategory(Category3::where("parent_id", $category2['unique_id'])->get()->toArray());
                foreach ($cat3 as $category3)
                    array_push($array, $category3);
            }
        }

        Log::info("build tree ...");
        //Log::info($array);
        return $this->MakeTree($array);
        //return $this->buildTree($array);
    }

    function filterCategory($category){
        $data = [];
        foreach ($category as $item) {
            $entry = [
                'unique_id' => $item['unique_id'],
                'parent_id' => $item['parent_id'],
                'name' => $item['name'],
            ];
            $data[] = $entry;
        }
        return $data;
    }

    function filterCategory2($category){
        $data = [];
        foreach ($category as $item) {
            $entry = [
                'unique_id' => $item->unique_id,
                'parent_id' => $item->parent_id,
                'name' => $item->name,
            ];
            $data[] = $entry;
        }
        return $data;
    }

    function MakeTree($arr)
    {
        $parents_arr = array();
        foreach ($arr as $key => $value) {
            $parents_arr[$value['parent_id']][$value['unique_id']] = $value;
        }
        $tree = $parents_arr['0'];
        $this->createTree($tree, $parents_arr);
        return $tree;
    }

    function createTree(&$tree, $parents_arr)
    {
        foreach ($tree as $key => $value) {
            if (!isset($value['child'])) {
                $tree[$key]['child'] = array();
            }
            if (array_key_exists($key, $parents_arr)) {
                $tree[$key]['child'] = $parents_arr[$key];
                $this->createTree($tree[$key]['child'], $parents_arr);
            }
        }
    }
}