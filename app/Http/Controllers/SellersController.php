<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ProductRequest;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\UsersProductResource;
use App\Category;
use App\Product;
use Illuminate\Support\Facades\Log;

class SellersController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api,merchandiser');
    }


    public function createCategory(Request $request)
    {
        Category::create($request->validate(['category' => 'required|string|unique:categories,category']));

        return response()->json(['status' => 'category created'], 200);
    }


    public function getCategories(Request $request)
    {

        return CategoryResource::collection(Category::all());

    }


    public function storeProduct(Category $category, ProductRequest $request)
    {

        $product = $request->validated();

        if(auth()->guard('merchandiser')->user()) #check if shop payment status is paid
        {
            $shop = auth()->guard('merchandiser')->user();

            $shopType = $shop->shopType;

            if($shop->product->count() === $shopType->max_no_of_product)
            {
                return response()->json(['message' => 'max product reached']);
            }

            if($shop->payment_status === 'free')
            {
                $product['payment_status'] = 'free';

            }else if($shop->payment_status === 'paid'){

                $product['payment_status'] = 'paid';
            }
            else if($shop->payment_status === 'payment required' && !$shop->qualified_for_free_trial){

                return response()->json(['message' => 'payment required']);
            }

            $product['merchandiser_id'] = $shop->id;

        }else{

            $user = auth()->guard('api')->user();

            if(!$user->valid_id)
            {
                return response()->json(['status' => 'Valid ID required'],200);
            }

            $product['user_id'] = auth()->guard('api')->id();

            $product['payment_status'] = 'payment required';
        }

        $product_id = $category->addProduct($product);

        if(auth()->guard('api')->user())
        {
            $this->payingProduct($product_id);
        }

        return response()->json(['status' => 'success', 'product_id' => $product_id], 200);
    }

    public function toggleProductToFreeTrial(Product $product) #this is for only users
    {
        if(auth()->guard('api')->check())
        {
            if($product->payment_status === 'free')
            {
                return response()->json(['message' => 'free trial already activated']);
            }else{

                $product->update(['payment_status' => 'free']);

                return response()->json(['message' => 'free trial activated']);
            }

        }else{

            return response()->json(['message' => 'Access Denied!']);
        }

    }


    public function updateProduct(Product $product, ProductRequest $request)
    {
       if(auth()->guard('api')->id() !== $product->user_id && $product->merchandiser_id == null)
       {
            return response()->json(['status' => 'Forbidden'], 403);

       }else if(auth()->guard('merchandiser')->id() !== $product->merchandiser_id && $product->user_id == null){

            return response()->json(['status' => 'Forbidden'], 403);
       }

        $product->update($request->validated());


        return response()->json(['status' => 'success'], 200);
    }


    public function saveProductImages(Product $product, Request $request)
    {
        /*  if(auth()->guard('api')->id() !== $product->user_id && $product->merchandiser_id == null)
            {
                return response()->json(['status' => 'Forbidden'], 403);

            }else if(auth()->guard('merchandiser')->id() !== $product->merchandiser_id && $product->user_id == null){

                return response()->json(['status' => 'Forbidden'], 403);
            }
            */


//        $request->validate(['product_images' => 'required']);

       $files = $request->file(['product_images']);

       try{
           foreach($files as $file)
           {

//            if($request->hasFile('product_images'))
//            {

               $fileName = now().'_'.$file->getClientOriginalName();

               $file->storeAs('public/product images/'.$product->id, $fileName);

               $product->addProductImage(['path' => 'storage/product images/'.$product->id.'/'.$fileName]);

//            }
           }

       }catch (\Exception $exception){
           Log::error($exception->getMessage());
       }

        return response()->json(['status' => 'files saved'], 200);
    }


    public function deleteProduct(Product $product)
    {

        if($product->user && auth()->guard('api')->id() !== $product->user_id)
        {
            return response()->json(['message' => 'Forbidden'], 403);

        }elseif($product->merchandiser && auth()->guard('merchandiser')->id() !== $product->merchandiser_id){

            return response()->json(['message' => 'Forbidden'], 403);
        }

        $this->deleteProductReviews($product);

        $this->deleteProductImages($product);

        $product->delete();

        return response()->json(['status' => 'product deleted'], 200);
    }


    public function deleteProductReviews(Product $product)
    {

        if($product->review)
        {
            $product->review->map(function($review){

                $review->delete();
            });
        }
    }

    public function deleteProductImages(Product $product)
    {
        if($product->image)
        {
            $product->image->map(function($image){

                #delete file

                $image->delete();
            });
        }
    }

    public function getUserProduct()
    {
        $user = auth()->guard('api')->user();

        if($user->product)
        {
            return UsersProductResource::collection($user->product);
        }

        return response()->json(['message' => 'user has no data']);
    }


    public function payingProduct($product_id)
    {
        $product = Product::find($product_id);

        $price = (double) $product->price;

        if($price >= 0.10 && $price <= 20.00)
        {
            $product->update(['payment_status' => 'free']);

            return response()->json(['message' => 'free product']);

        }elseif($price >= 20.10 && $price <= 1000.00) {

            $product->update(['payment_status' => 'requires payment']);

            $product->addPaidProduct(['amount' => 0.01 * $price]);

        }elseif($price >= 1000.01 && $price <= 3000.00) {

            $product->update(['payment_status' => 'requires payment']);

            $product->addPaidProduct(['amount' => 12.00]);

        }elseif($price >= 3000.01){

            $product->update(['payment_status' => 'requires payment']);

            $product->addPaidProduct(['amount' => 15.00]);
        }

    }
}
