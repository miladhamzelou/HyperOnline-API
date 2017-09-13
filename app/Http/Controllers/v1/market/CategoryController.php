<?php

namespace App\Http\Controllers\v1\market;

use App\Http\Controllers\Controller;
use App\Services\v1\market\MainService;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    protected $mService;

    public function __construct(MainService $service)
    {
        $this->mService = $service;
    }

    public function index($level, $id)
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

        $products = $this->mService->getProducts($level, $id);

        $subCat = [];
        if ($level != 3)
            $subCat = $this->mService->getSubCategories($level, $id);

        $name = $this->mService->getCategoryName($level, $id);

        $most = $this->mService->getMostSell();

        return view('market.category')
            ->withNew($new)
            ->withProducts($products)
            ->withCategories($cat)
            ->withCart($cart)
            ->withAdmin($isAdmin)
            ->withLevel($level)
            ->withSub($subCat)
            ->withName($name)
            ->withMost($most);
    }

}