<?php

namespace App\Http\Controllers\API;

use App\Departement;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $departements = Departement::latest()->paginate(10);

        return response()->json($departements);
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
            'code' => 'required|unique:departements',
            'name' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $department = new Departement([
            'code' => $request->code,
            'name' => $request->name,
        ]);
        
        $department->save();

        return response()->json(['message' => 'Department created successfully!', 'departmment' => $department], 201);
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
            'code' => 'required|string|unique:departements,code,' . $id,
            'name' => 'required|string|max:255',
        ]);
    
        $department = Departement::findOrFail($id);
    
        $department->update([
            'code' => $request->code,
            'name' => $request->name,
        ]);
    
        return response()->json([
            'message' => 'Department updated successfully!',
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
        $department = Departement::findOrFail($id);
        $department->delete();
        
        return response()->json(['message' => 'Department has been deleted successfully.', 'department' => $department], 201);
    }
}
