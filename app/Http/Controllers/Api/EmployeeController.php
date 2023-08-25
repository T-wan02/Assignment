<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $employees = Employee::all();

        return response()->json([
            'status' => 'success',
            'data' => $employees
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $employee = Employee::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone_number' => $request->phone_number,
            'job_title' => $request->job_title
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Added new employee',
            'data' => $employee
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $employee = Employee::find($id);

        if (!$employee) {
            return response()->json([
                'status' => 'error',
                'message' => 'Employee not found',
            ]);
        }

        return response()->json([
            'status' => 'success',
            'data' => $employee
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $employee = Employee::where('id', $id)->first();
        if (!$employee) {
            return response()->json([
                'status' => 'error',
                'message' => 'Employee not found',
            ]);
        }

        $employee->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone_number' => $request->phone_number,
            'job_title' => $request->job_title,
        ]);

        $allEmployees = Employee::all();
        return response()->json([
            'status' => 'success',
            'message' => 'Updated successfully',
            'data' => $allEmployees
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $employee = Employee::find($id);

        if (!$employee) {
            return response()->json([
                'status' => 'error',
                'message' => 'Employee not found',
            ]);
        }

        $employee->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Deleted successfully',
        ]);
    }
}
