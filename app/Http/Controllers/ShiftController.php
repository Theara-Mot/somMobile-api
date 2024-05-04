<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Shift;
class ShiftController extends Controller
{
    public function index()
    {
        $shifts = Shift::all();

        return response()->json([
            'status' => true,
            'message' => 'Shifts retrieved successfully!',
            'data' => $shifts
        ], 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'status' => 'required|string'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors(),
            ], 400);
        }

        $shift = Shift::create([
            'name' => $request->name,
            'status' => $request->status
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Shift created successfully!',
            'data' => $shift,
        ], 201);
    }

    public function show(Shift $shift)
    {
        return response()->json([
            'status' => true,
            'message' => 'shift retrieved successfully!',
            'data' => $shift,
        ], 200);
    }

    public function update(Request $request, $id)
    {
        $shift = Shift::findOrFail($id);
        $validatedData = $request->validate([
            'name' => 'sometimes|required',
            'status' => 'sometimes|required',
        ]);

        if (isset($validatedData['name'])) {
            $shift->name = $validatedData['name'];
        }

        if (isset($validatedData['status'])) {
            $shift->status = $validatedData['status'];
        }

        $shift->save();

        return response()->json([
            'status' => true,
            'message' => 'Data updated successfully!',
            'data' => [
                'name' => $shift->name,
                'status' => $shift->status
            ]
        ], 200);
    }

    public function destroy($id)
    {
        $data = shift::findOrFail($id);
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
