<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Location;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LocationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $locations = Location::latest()
        ->paginate(10);

        return response()->json($locations);
    }
    public function getLocations()
    {
        $locations = Location::whereNull('deleted_at')
        ->get();
        
        return response()->json($locations);
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
            'code' => 'required|unique:locations',
            'name' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $location = new Location([
            'code' => $request->code,
            'name' => $request->name,
        ]);
        
        $location->save();

        return response()->json(['message' => 'Location created successfully!', 'location' => $location], 201);
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
            'code' => 'required|string|unique:locations,code,' . $id,
            'name' => 'required|string|max:255',
        ]);
    
        $location = Location::findOrFail($id);
    
        $location->update([
            'code' => $request->code,
            'name' => $request->name,
        ]);
    
        return response()->json([
            'message' => 'Location updated successfully!',
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
        
        $location = Location::findOrFail($id);
        $location->delete();
        
        return response()->json(['message' => 'Location has been deleted successfully.', 'department' => $location], 201);
    }
}
