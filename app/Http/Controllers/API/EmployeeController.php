<?php

namespace App\Http\Controllers\API;

use App\Departement;
use App\Employee;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $employees = Employee::with('departement')
        ->latest()
        ->whereNull('deleted_at')
        ->paginate(10);

        return response()->json($employees);
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
            'nik' => 'required|unique:employees',
            'name' => 'required',
            'email' => 'required|email',
            'departement_id' => 'required|exists:departements,id',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $employee = new Employee([
            'nik' => $request->nik,
            'name' => $request->name,
            'email' => $request->email,
            'departement_id' => $request->departement_id,
            'status' => $request->status ?? true,
        ]);
        
        $employee->save();

        return response()->json(['message' => 'Employee created successfully!', 'employee' => $employee], 201);
    }
    public function getDepartements()
    {
        $departements = Departement::all(); 
        return response()->json($departements);
    }
    public function getEmployeeByNik($id)
    {
        $dataEmployee = Employee::query()
        ->with('departement')
        ->where('nik', $id)
        ->first();

        return response()->json($dataEmployee);
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
            'nik' => 'required|string|unique:employees,nik,' . $id,
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'departement_id' => 'required|exists:departements,id',
            'status' => 'required|boolean',
        ]);
    
        $employee = Employee::findOrFail($id);
    
        $employee->update([
            'nik' => $request->nik,
            'name' => $request->name,
            'email' => $request->email,
            'departement_id' => $request->departement_id,
            'status' => $request->status,
        ]);
    
        return response()->json([
            'message' => 'Employee updated successfully!',
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
        $employee = Employee::findOrFail($id);
        $employee->delete();
        
        return response()->json(['message' => 'Employee has been deleted successfully.', 'employee' => $employee], 201);
        return response()->json([
            'message' => 'Employee has been deleted successfully.'
        ]);
    }
}
