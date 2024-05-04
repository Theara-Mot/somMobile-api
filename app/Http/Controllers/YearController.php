<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Year;
use Illuminate\Validation\Rule;

class YearController extends Controller
{
    public function index()
    {
        $years = Year::all();

        return response()->json([
            'status' => true,
            'message' => 'Years retrieved successfully!',
            'data' => $years
        ], 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => [
                'required',
                'string',
                Rule::unique('years')->ignore($request->id),
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
        
        $year = Year::create([
            'name' => $request->name,
            'status' => $request->status
        ]);
        
        return response()->json([
            'status' => true,
            'message' => 'Year created successfully!',
            'data' => $year,
        ], 201);
    }

    public function show(Year $year)
    {
        return response()->json([
            'status' => true,
            'message' => 'Year retrieved successfully!',
            'data' => $year,
        ], 200);
    }

    public function update(Request $request, $id)
    {
        $day = Year::findOrFail($id);
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
            'message' => 'Year updated successfully!',
            'data' => [
                'name' => $day->name,
                'status' => $day->status
            ]
        ], 200);
    }

    public function destroy($id)
    {
        $data = Year::findOrFail($id);
        $data->delete();
        return response()->json([
            'status' => true,
            'message' => 'Year deleted successfully!',
            'data' => [
                'name' => $data -> name,
                'status' => $data -> status
            ]
        ], 202);
    }
}
