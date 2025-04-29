<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::with(['unit', 'location', 'requestProductItems'])
        ->whereNull('deleted_at')
        ->latest()
        ->paginate(10);
        
        
        return response()->json($products);
    }

    public function getProducts()
    {
        $products = Product::with(['unit', 'location', 'requestProductItems'])
        ->whereNull('deleted_at')
        ->get();
        
        return response()->json($products);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'code' => 'required|unique:products',
            'name' => 'required',
            'unit_id' => 'required|exists:units,id',
            'location_id' => 'required|exists:locations,id',
            'stock' => 'required|integer|min:1', 
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $product = new Product([
            'code' => $request->code,
            'name' => $request->name,
            'stock' => $request->stock,
            'unit_id' => $request->unit_id,
            'location_id' => $request->location_id,
        ]);
        
        $product->save();

        return response()->json(['message' => 'Product created successfully!', 'product' => $product], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = Product::with(['location','unit','requestProductItems'])
        ->find($id);
     
        return response()->json($product);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'code' => 'required|string|unique:products,code,' . $id,
            'name' => 'required|string|max:255',
            'unit_id' => 'required|exists:units,id',
            'location_id' => 'required|exists:locations,id',
            'stock' => 'required|integer|min:1', 
        ]);
    
        $product = Product::findOrFail($id);
    
        $product->update([
            'code' => $request->code,
            'name' => $request->name,
            'unit_id' => $request->unit_id,
            'location_id' => $request->location_id,
            'stock' => $request->stock,
        ]);
    
        return response()->json([
            'message' => 'Products updated successfully!',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();
        
        return response()->json(['message' => 'Product has been deleted successfully.', 'product' => $product], 201);
        return response()->json([
            'message' => 'Product has been deleted successfully.'
        ]);
    }
}
