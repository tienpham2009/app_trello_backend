<?php

namespace App\Http\Controllers;

use App\Models\Board;
use App\Models\ListModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use function Symfony\Component\String\s;

class ListController extends Controller
{
    const FIST_LOCATION = 0;
    protected $lastRecord;
    const INCREMENT_LOCATION = 1;

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string',
            'board_id' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        }

        $list = new ListModel();
        $list->title = $request->title;
        $list->board_id = $request->board_id;


        $this->lastRecord = DB::table('lists')
            ->select('location')
            ->where('board_id', '=', $list->board_id)
            ->latest('location')->first();

        if ($this->lastRecord == null) {
            $list->location = self::FIST_LOCATION;
        } else {
            $list->location = $this->lastRecord->location + self::INCREMENT_LOCATION;
        }
        $list->save();

        return response()->json([
            'message' => 'List create successfully',
            'list' => $list
        ], 201);
    }

    public function showListByBoardId($board_id): \Illuminate\Http\JsonResponse
    {
        $lists = ListModel::with('cards')
            ->orderBy('location')
            ->where('board_id',$board_id)
            ->get();
        return response()->json([
            'lists' => $lists,
        ]);
    }

    public function moveList(Request $request)
    {
        $data = $request->all();
        foreach ($data as $key => $list){
            $list = ListModel::find($list['id']);
            $list->location = $key;
            $list->save();
        }
        return response()->json($data);
    }

    public function changeTitle(Request $request): \Illuminate\Http\JsonResponse
    {
        $id = $request->listId;
        $list = ListModel::find($id);
        $list->title = $request->newTitle;
        $list->save();
        $data = [
            "message" => "Thay đổi tiêu đề thành công"
        ];

        return response()->json($data);
    }
}
