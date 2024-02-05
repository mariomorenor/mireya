<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use TCG\Voyager\Http\Controllers\VoyagerBaseController;

class ProductController extends VoyagerBaseController
{
    function getProducts(Request $request)
    {
        if ($request->ajax()) {

            $query = Product::query();
            if ($request->has("term") && $request->term != "") {
                $products = $query->where("name", "ilike", "$request->term%")->get();
            } else {
                $products = $query->get();
            }
            $products = $products->map(function (PRoduct $item) {
                return ["text" => $item->name, "id" => $item->id];
            });

            return response()->json([
                "results" => $products
            ]);
        }
    }
}
