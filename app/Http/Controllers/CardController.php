<?php

namespace App\Http\Controllers;

use App\Models\Card;
use App\Models\ListModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class CardController extends Controller
{
    const FIST_LOCATION = 0;
    protected $lastRecord;
    const INCREMENT_LOCATION = 1;

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string',
            'list_id' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        }

        $card = new Card();
        $card->title = $request->title;
        $card->list_id = $request->list_id;


        $this->lastRecord = DB::table('cards')
            ->select('location')
            ->where('list_id', '=', $card->list_id)
            ->latest('location')->first();

        if ($this->lastRecord == null) {
            $card->location = self::FIST_LOCATION;
        } else {
            $card->location = $this->lastRecord->location + self::INCREMENT_LOCATION;
        }
        $card->save();

        return response()->json([
            'message' => 'Thẻ đã được tạo mới thành công !',
            'card' => $card
        ], 201);
    }

    public function moveCard(Request $request)
    {
        $data = $request->all();
        foreach ($data as $key => $item){
            $card = Card::find($item['id']);
            $card->location = $key;
            $card->list_id= $item['list_id'];
            $card->save();
        }
        return response()->json($data);
    }
}
