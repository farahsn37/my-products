<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Requests\ProductRequest;
use Illuminate\Support\Facades\Auth;

class ProductsController extends Controller
{
    // GET /api/product
    // list all products
    public function index(){

        //authenticate user
        abort_if(!Auth::user()->can('view-products'), 403, "You are not authorized to view products.");

        // fetch all records from the product table
        $product = Product::all();
        // return the product
        return response()->json([
            'success' => true,
            'data' => $product
        ], 200);
    }

    // GET /api/products/{id}
    // get single product
    public function show($id){

        //authenticate user
        abort_if(!Auth::user()->can('view-products'), 403, "You are not authorized to view products.");    

        // find product by id
        $product = Product::findOrFail($id);

        return response()->json([
            'success' => true,
            'data' => $product
        ], 200);
    }

    // POST /api/products
    // create new product
    public function store(ProductRequest $request){
        
        //authenticate user
        abort_if(!Auth::user()->can('create-products'), 403, "You are not authorized to create products.");

        // save the data input into database
        $product = Product::create([
        'name' => $request->name,
        'description' => $request->description,
        'price' => $request->price,
        'stock' => $request->stock,
        'user_id' => Auth::id(),
        ]);

        
        // return response
        return response()->json([
            'success' => true,
            'message' => 'Product created successfully',
            'data' => $product
        ], 201);

    }

    //PUT /api/products/{id}
    public function update(ProductRequest $request, $id){
        
        //authenticate user
        abort_if(!Auth::user()->can('edit-products'), 403, "You are not authorized to edit products.");
    
        // find the product by id
        $product = Product::findOrFail($id);

        //update the data
        $product->update($request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Product updated successfully',
            'data' => $product
        ], 200);
    }

    //DELETE /api/products/{id}
    public function destroy($id){

        //authenticate user
        abort_if(!Auth::user()->can('delete-products'), 403, "You are not authorized to delete products.");
        
        // find the product by id
        $product = Product::findOrFail($id);
        
        // delete the product
        $product->delete();

        return response()->json([
            'success' => true,
            'message' => 'product deleted successfully'
        ], 200); 
    }
}
