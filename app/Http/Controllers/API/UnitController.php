<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UnitController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $units = Unit::latest()
        ->paginate(10);

        return response()->json($units);
    }
    public function getUnits()
    {
        $units = Unit::whereNull('deleted_at')
        ->get();
        
        return response()->json($units);
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
            'code' => 'required|unique:units',
            'name' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $unit = new Unit([
            'code' => $request->code,
            'name' => $request->name,
        ]);
        
        $unit->save();

        return response()->json(['message' => 'Unit created successfully!', 'unit' => $unit], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
            'code' => 'required|string|unique:units,code,' . $id,
            'name' => 'required|string|max:255',
        ]);
    
        $unit = Unit::findOrFail($id);
    
        $unit->update([
            'code' => $request->code,
            'name' => $request->name,
        ]);
    
        return response()->json([
            'message' => 'Unit updated successfully!',
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
        
        $unit = Unit::findOrFail($id);
        $unit->delete();
        
        return response()->json(['message' => 'Unit has been deleted successfully.', 'department' => $unit], 201);
    }
}
