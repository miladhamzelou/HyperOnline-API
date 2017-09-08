<?php

namespace App\Http\Controllers\v1\market;

use App\Category1;
use App\Category2;
use App\Category3;
use App\Http\Controllers\Controller;
use App\Product;
use Illuminate\Support\Facades\Log;

class MainController extends Controller
{
    public function index()
    {
        $new = $this->getNew();
        $cat = $this->getCategories();

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

    protected function getCategories()
    {
        $cat1 = Category1::get()->toArray();
        $array = array();
        foreach ($cat1 as $category1) {
            array_push($array, $category1);
            $cat2 = Category2::where("parent_id", $category1['unique_id'])->get()->toArray();
            foreach ($cat2 as $category2) {
                array_push($array, $category2);
                $cat3 = Category3::where("parent_id", $category2['unique_id'])->get()->toArray();
                foreach ($cat3 as $category3)
                    array_push($array, $category3);
            }
        }

        return $this->MakeTree($array);
    }

    function MakeTree($arr){
        $parents_arr=array();
        foreach ($arr as $key => $value) {
            $parents_arr[$value['parent_id']][$value['unique_id']]=$value;
        }
        $tree=$parents_arr['0'];
        $this->createTree($tree, $parents_arr);
        return $tree;
    }
    function createTree(&$tree, $parents_arr){
        foreach ($tree as $key => $value) {
            if(!isset($value['child'])) {
                $tree[$key]['child']=array();
            }
            if(array_key_exists($key, $parents_arr)){
                $tree[$key]['child']=$parents_arr[$key];
                $this->createTree($tree[$key]['child'], $parents_arr);
            }
        }
    }
}