<?php

namespace App\Http\Controllers\API;

use App\Employee;
use App\Http\Controllers\Controller;
use App\Product;
use App\RequestProduct;
use App\RequestProductItem;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class RequestProductController extends Controller
{
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $requests = RequestProduct::with('requestProductItems.product', 'user', 'employee')->latest()->get();
        return response()->json($requests);

        $requestProducts = RequestProduct::with(['requestProductItems', 'employee.departement', 'user'])
        ->whereNull('deleted_at')
        ->paginate(10);

        return response()->json($requestProducts);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $validator = Validator::make($request->all(), [
            'nik' => 'required|string|max:255',
            'request_date' => 'required|date|date_format:Y-m-d',
            'items' => 'required|array',
            'items.*.product_id' => 'required|uuid|exists:products,id', 
            'items.*.qty' => 'required|integer|min:1', 
            'items.*.remarks' => 'nullable|string',
            'items.*.product_status' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Data tidak valid',
                'errors' => $validator->errors(),
            ], 422);
        }

        $employee = Employee::where('nik', $request->input('nik'))->first();
        
        if (!$employee) {
            return response()->json([
                'message' => 'Employee tidak ditemukan dengan NIK tersebut.',
            ], 404);
        }

        $user = User::query()
        ->first();

        $statusRequest = 'pending';

        
        // $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
        foreach ($request->input('items') as $item) {
            if( $item['product_status'] === "Fullfill"){
                $statusRequest = 'approved'; 
            }else{
                $statusRequest = 'pending';
            }
        }

        $requestProduct = RequestProduct::create([
            'id' => Str::uuid(),
            'code' => $request->input('nik'),
            'user_id' => $user->id,
            'employee_id' => $employee->id,
            'request_date' => $request->input('request_date'),
            'status' => $statusRequest,
        ]);

        foreach ($request->input('items') as $item) {
            // $table->enum('status', ['fulfilled', 'partial', 'out_of_stock'])->default('fulfilled');
            $productStatus = 'fulfilled';

            if($item['product_status'] === 'Fullfill'){
                $productStatus = 'fulfilled';
            }elseif($item['product_status'] === 'Partial'){
                $productStatus = 'partial';
            }else{
                $productStatus = 'out_of_stock';
            }

            $requestProductItemData = RequestProductItem::create([
                'request_product_id' => $requestProduct->id,
                'product_id' => $item['product_id'],
                'qty' => $item['qty'],
                'remarks' => $item['remarks'],
                'status' => $productStatus, 
            ]);
            Product::where('id', $requestProductItemData->product_id)->decrement('stock', $requestProductItemData->qty);

        }

        return response()->json([
            'message' => 'Permintaan produk berhasil dikirim',
            'data' => $requestProduct,
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $requestProduct = RequestProduct::with('requestProductItems.product', 'user', 'employee')->findOrFail($id);
        return response()->json($requestProduct);
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
