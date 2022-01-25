<?php

namespace App\Http\Controllers\API;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Http\Requests\ProductRequest;
use App\Http\Resources\ProductResource;
use App\Http\Resources\ProductCollection;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Product $product)
    {
        $products = $product->all();

        return response()->json([
            'data' => new ProductCollection($products), 
            'status' => getHttpStatusMessages(200),
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  App\Http\Requests\ProductRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductRequest $request, Product $product)
    {
        if ($request->fails()) {
            return response()->json([
                'errors' => $request->errors(), 
                'status' => getHttpStatusMessages(400),
            ], 400);
        }

        $input = $request->all();

        $input['slug'] = Str::slug($input['name']);
        $input['price'] = $product->formatPriceValue($input['price']);

        $product = $product->create($input);

        return response()->json([
            'data' => new ProductResource($product), 
            'status' =>getHttpStatusMessages(201),
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show($slug, Product $product)
    {
        $product = $product->where('slug', $slug)->first();

        if (!$product) {
            return response()->json([
                'data' => [],
                'status' => getHttpStatusMessages(404),
            ], 404);
        }

        return response()->json([
            'data' => new ProductResource($product), 
            'status' => getHttpStatusMessages(200)], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  App\Http\Requests\ProductRequest $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update($slug, ProductRequest $request, Product $product)
    {
        if ($request->fails()) {
            return response()->json([
                'errors' => $request->errors(), 
                'status' => getHttpStatusMessages(400),
            ], 400);
        }

        $product = $product->where('slug', $slug)->first();

        if (!$product) {
            return response()->json([
                'data' => [],
                'status' => getHttpStatusMessages(404),
            ], 404);
        }

        $info = $request->all();

        $info['slug'] = Str::slug($info['name']);
        $info['price'] = $product->formatPriceValue($info['price']);        
        $updated = $product->update($info);

        if (!$updated) {
            return response()->json([
                'data' => [],
                'status' => getHttpStatusMessages(500),
            ], 500);
        }

        return response()->json([
            'data' => new ProductResource($product),
            'status' => getHttpStatusMessages(200),
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy($slug, Product $product)
    {
        $product = $product->where('slug', $slug)->first();

        if (!$product) {
            return response()->json([
                'data' => [],
                'status' => getHttpStatusMessages(404),
            ], 404);
        }

        $product->delete();

        return response()->json([
            'data' => "$slug removido.",
            'status' => getHttpStatusMessages(200)
        ], 200);
    }
}
