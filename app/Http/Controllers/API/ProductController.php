<?php

namespace App\Http\Controllers\API;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public $statusList = [
        'success' => 200,
        'unauthorized' => 401,
        'not-found' => 404,
        'internal-error' => 500,
    ];

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Product $product)
    {
        $products = $product->all();
        return response()->json(['data' => $products], $this->statusList['success']);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Product $product)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|min:3|max:80',
            'description' => 'max:255',
            'price' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], $this->statusList['unauthorized']);
        }

        $input = $request->all();

        $input['slug'] = Str::slug($input['name']);
        $input['price'] = $product->formatPriceValue($input['price']);

        $product = $product->create($input);

        return response()->json(['data' => $product], $this->statusList['success']);
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
            return response()->json([], $this->statusList['not-found']);
        }

        return response()->json(['data' => $product], $this->statusList['success']);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update($slug, Request $request, Product $product)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|min:3|max:80|unique:products',
            'description' => 'max:255',
            'price' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], $this->statusList['unauthorized']);
        }

        $product = $product->where('slug', $slug)->first();

        if (!$product) {
            return response()->json([], $this->statusList['not-found']);
        }

        $info = $request->all();

        $info['slug'] = Str::slug($info['name']);
        $info['price'] = $product->formatPriceValue($info['price']);        
        $updated = $product->update($info);

        if (!$updated) {
            return response()->json([], $this->statusList['internal-error']);
        }

        return response()->json(['data' => $product], $this->statusList['success']);
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
            return response()->json([], $this->statusList['not-found']);
        }

        $product->delete();

        return response()->json(['data' => "$slug removido."], $this->statusList['success']);
    }
}
