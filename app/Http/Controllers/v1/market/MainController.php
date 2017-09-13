<?php

namespace App\Http\Controllers\v1\market;

use App\Category1;
use App\Category2;
use App\Category3;
use App\Http\Controllers\Controller;
use App\Product;
use App\Services\v1\market\MainService;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\Auth;

class MainController extends Controller
{
    protected $mService;

    public function __construct(MainService $service)
    {
        $this->mService = $service;
    }

    public function index()
    {
        $new = $this->mService->getNew();
        $cat = $this->mService->getCategories();

        Cart::destroy();
        Cart::add([
            ['id' => '1', 'name' => 'محصول اول', 'qty' => 2, 'price' => 10000],
            ['id' => '2', 'name' => 'محصول دوم', 'qty' => 3, 'price' => 5500]
        ]);

        $cart = [
            'items' => Cart::content(),
            'count' => Cart::count(),
            'total' => Cart::total(0),
            'tax' => Cart::tax(0),
            'subtotal' => Cart::subtotal(0)
        ];

        if (Auth::check())
            $isAdmin = Auth::user()->isAdmin() ? 1 : 0;
        else
            $isAdmin = 0;

        $most = $this->mService->getMostSell();

        $cat1 = $this->mService->getRandomCategory();
        $cat2 = $this->mService->getRandomCategory();
        $cat3 = $this->mService->getRandomCategory2();
        $off = $this->mService->getOff();

        return view('market.home')
            ->withNew($new)
            ->withCategories($cat)
            ->withCart($cart)
            ->withMost($most)
            ->withRand1($cat1)
            ->withRand2($cat2)
            ->withRand3($cat3)
            ->withOff($off)
            ->withAdmin($isAdmin);
    }

    /*function MakeTree($arr)
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

    public function buildNested()
    {
        $cat1 = Category1::get();
        foreach ($cat1 as $item) {
            $root = Category::create(['name' => $item->name]);
            $cat2 = Category2::where("parent_id", $item->unique_id)->get();
            foreach ($cat2 as $cat2_item) {
                $child = $root->children()->create(['name' => $cat2_item->name]);

                $cat3 = Category3::where("parent_id", $cat2_item->unique_id)->get();
                foreach ($cat3 as $cat3_item) {
                    $child2 = $child->children()->create(['name' => $cat3_item->name]);
                    $child2->save();
                }
                $child->save();
            }
        }


        $root->save();
    }

    function buildTree(array $items)
    {
        $tree = [];

        foreach ($items as $item) {
            $pid = $item['parent_id'];
            $id = $item['unique_id'];
            $name = $item['name'];

            // Create or add child information to the parent node
            if (isset($tree[$pid]))
                // a node for the parent exists
                // add another child id to this parent
                $tree[$pid]["child"][] = $id;
            else
                // create the first child to this parent
                $tree[$pid] = array("child" => array($id));

            // Create or add name information for current node
            if (isset($tree[$id]))
                // a node for the id exists:
                // set the name of current node
                $tree[$id]["name"] = $name;
            else
                // create the current node and give it a name
                $tree[$id] = array("name" => $name);
        }

        return $tree;
    }*/
}