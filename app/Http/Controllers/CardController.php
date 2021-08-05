<?php

namespace App\Http\Controllers;

use App\Models\Card;
use App\Models\ListModel;
use App\Models\UserCard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use PhpParser\Node\Stmt\Case_;

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

        $user_id = Auth::id();
        $user_card = new UserCard();
        $user_card->user_id = $user_id;
        $user_card->card_id = $card->id;
        $user_card->save();

        return response()->json([
            'message' => 'Thẻ đã được tạo mới thành công !',
            'card' => $card
        ], 201);
    }

    public function getCardOfListByBoardId($board_id)
    {
        $lists = DB::table('lists')
            ->select('lists.id','lists.title')
            ->join('boards','boards.id','=','lists.board_id')
            ->where('board_id',$board_id)
            ->get();
        $dataCard[] = [];
        $list = [];
        //lay card trong list
        foreach ($lists as $key => $list){
            $cards = DB::table('cards')->select('cards.id','cards.title','cards.content','cards.list_id','cards.location')
                    ->join('lists','cards.list_id','=','lists.id')
                    ->where('list_id',$list->id)
                    ->get();
            $dataCard[$list->id] = $cards;

        }
        return response()->json([
           'lists' => $lists,
           'cards' => $dataCard
        ]);
    }

    public function getCardById($cardId): \Illuminate\Http\JsonResponse
    {
        $card = Card::where('id',$cardId);
        return response()->json($card);
    }

    public function updateCardTitle(Request $request): \Illuminate\Http\JsonResponse
    {
        $card_id = $request->card_id;
        $title = $request->title;

        $card = Card::find($card_id);
        $card->title = $title;
        $card->save();
        $data = [
            'status' => 'success'
        ];
        return response()->json($data);
    }

    public function updateCardContent(Request $request): \Illuminate\Http\JsonResponse
    {
        $card_id = $request->card_id;
        $content = $request->card_content;

        $card = Card::find($card_id);
        $card->content = $content;
        $card->save();
        $data = [
            'status' => 'success'
        ];

        return response()->json($data);
    }
}
