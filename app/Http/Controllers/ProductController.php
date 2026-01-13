<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    // GET /api/product
    // list all products
    public function index(){
        // fetch all records from the product table
        $product = Product::all();
        // return the product
        return response()->json([
            'success' => true,
            'data' => $product
        ], 200);    // return response code "success"
    }

    // GET /api/products/{id}
    // get single product
    public function show($id){
        // find product by id
        $product = Product::findOrFail($id);

        // return if product not found
        if (!$product){
            return response()->json([
                'success' => false,
                'message' => 'Product not found'
            ], 404);    // return response code "not found"
        }

        // return if product found
        return response()->json([
            'success' => true,
            'data' => $product
        ], 200);
    }

    // POST /api/products
    // create new product
    public function store(Request $request){
        // validate the data input
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'stock' => 'nullable|integer'
        ]);

        // save the data input into database
        $product = Product::create($validated);
        
        // return response
        return response()->json([
            'success' => true,
            'data' => $product
        ], 201);    // return response code "created"

    }

    //PUT /api/products/{id}
    public function update(Request $request, $id){
        // find the product by id
        $product = Product::findOrFail($id);

        // return if product not found
        if (!$product){
            return response()->json([
                'success' => false,
                'message' => 'Product not found'
            ], 404);    // return response code "not found"
        }

        // validate the request
        $validate = $request->validate([
            'name' => 'string|max:255',
            'description' => 'nullable|string',
            'price' => 'numeric',
            'stock' => 'integer'
        ]);

        //update the data
        $product->update($validate);

        return response()->json([
            'success' => true,
            'data' => $product
        ], 200);    // return response code "success"
    }

    //DELETE /api/products/{id}
    public function destroy($id){
        // find the product by id
        $product = Product::findOrFail($id);

        if(!$product){
            return response()->json([
                'success' => 'false',
                'message' => 'Product not found'
            ], 404);
        }

        // delete the product
        $product->delete();

        // return response
        return response()->json([
            'success' => true,
            'message' => 'product deleted successfully'
        ], 200);    // return response code "success"
    }
}
