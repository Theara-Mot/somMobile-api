<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Classes;
use Illuminate\Validation\Rule;
class ClassController extends Controller
{
    public function index()
    {
        $classes = Classes::all();

        return response()->json([
            'status' => true,
            'message' => 'Classes retrieved successfully!',
            'data' => $classes
        ], 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => [
                'required',
                'string',
                Rule::unique('classes')->ignore($request->id),
            ],
            'status' => 'required|string',
        ]);
        
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors(),
            ], 400);
        }
        
        $day = Classes::create([
            'name' => $request->name,
            'status' => $request->status
        ]);
        
        return response()->json([
            'status' => true,
            'message' => 'Day created successfully!',
            'data' => $day,
        ], 201);
    }

    public function show(Classes $day)
    {
        return response()->json([
            'status' => true,
            'message' => 'Day retrieved successfully!',
            'data' => $day,
        ], 200);
    }

    public function update(Request $request, $id)
    {
        $day = Classes::findOrFail($id);
        $validatedData = $request->validate([
            'name' => 'sometimes|required',
            'status' => 'sometimes|required',
        ]);

        if (isset($validatedData['name'])) {
            $day->name = $validatedData['name'];
        }

        if (isset($validatedData['status'])) {
            $day->status = $validatedData['status'];
        }

        $day->save();

        return response()->json([
            'status' => true,
            'message' => 'Data updated successfully!',
            'data' => [
                'name' => $day->name,
                'status' => $day->status
            ]
        ], 200);
    }

    public function destroy($id)
    {
        $data = Classes::findOrFail($id);
        $data->delete();
        return response()->json([
            'status' => true,
            'message' => 'Data deleted successfully!',
            'data' => [
                'name' => $data -> name,
                'status' => $data -> status
            ]
        ], 202);
    }
}