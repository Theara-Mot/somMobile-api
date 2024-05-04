<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Time;
use Illuminate\Support\Facades\Validator;
class TimeController extends Controller
{
    public function index()
    {
        $data = Time::all();
        return response()->json([
            'status' => true,
            'message' => 'Data retrieved successfully!',
            'data' => $data
        ], 200);
    }


    public function store(Request $request)
    {
        // Validating the incoming request data
        $validateUser = Validator::make($request->all(),[
            'name' => 'required',
            'status' => 'required',
        ]);

        if($validateUser -> fails()){
            return response()->json([
                'status' =>false,
                'message' =>'validation error',
                'error' => $validateUser->errors()
            ],401);
        }

        $time = Time::create([
            'name' => $request -> name,
            'status' => $request -> status,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Data created successfully!',
            'data' => [
                'name' => $time -> name,
                'status' => $time -> status
            ]
        ], 201);
    }


    public function show(Time $time)
    {
        return $time;
    }

    public function update(Request $request, $id)
    {
        $time = Time::findOrFail($id);
        $validatedData = $request->validate([
            'name' => 'sometimes|required',
            'status' => 'sometimes|required',
        ]);

        if (isset($validatedData['name'])) {
            $time->name = $validatedData['name'];
        }

        if (isset($validatedData['status'])) {
            $time->status = $validatedData['status'];
        }

        $time->save();

        return response()->json([
            'status' => true,
            'message' => 'Data updated successfully!',
            'data' => [
                'name' => $time->name,
                'status' => $time->status
            ]
        ], 200);
    }

    public function destroy($id)
    {
        $data = Time::findOrFail($id);
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
