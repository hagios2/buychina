<?php

namespace App\Http\Controllers;

use App\Merchandiser;
use App\Product;
use Illuminate\Http\Request;
use Spatie\Searchable\Search;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        $searchResults = (new Search())
        ->registerModel(Product::class, 'product_name', 'description')
        ->registerModel(Merchandiser::class, 'company_name', 'company_description')
        ->search($request->search);

        return $searchResults;
    }
 
}
