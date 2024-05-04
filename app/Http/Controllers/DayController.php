<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Day;
use Illuminate\Support\Facades\Validator;

class DayController extends Controller
{
    public function index()
    {
        $days = Day::all();

        return response()->json([
            'status' => true,
            'message' => 'Days retrieved successfully!',
            'data' => $days
        ], 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|unique:days',
            'status' => 'required|string'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors(),
            ], 400);
        }

        $day = Day::create([
            'name' => $request->name,
            'status' => $request->status
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Day created successfully!',
            'data' => $day,
        ], 201);
    }

    public function show(Day $day)
    {
        return response()->json([
            'status' => true,
            'message' => 'Day retrieved successfully!',
            'data' => $day,
        ], 200);
    }

    public function update(Request $request, $id)
    {
        $day = Day::findOrFail($id);
        $validatedData = $request->validate([
            'name' => 'sometimes|required:days',
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
        $data = Day::findOrFail($id);
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
