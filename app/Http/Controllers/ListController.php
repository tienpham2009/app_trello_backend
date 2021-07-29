<?php

namespace App\Http\Controllers;

use App\Models\ListModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ListController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string',
            'board_id' => 'required|integer',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }

        $list = ListModel::create(array_merge(
            $validator->validated()
        ));

        return response()->json([
            'message' => 'List create successfully',
            'list' => $list
        ], 201);
    }
}
