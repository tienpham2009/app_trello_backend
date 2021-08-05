<?php

namespace App\Http\Controllers;

use App\Models\Card;
use App\Models\Comment;
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

    public function getCardById(Request $request): \Illuminate\Http\JsonResponse
    {
        $card_id = $request->id;
        $card = Card::find($card_id);
        $labels = DB::table('labels')
                 ->join('cards' , 'cards.id'  , '=' , 'labels.card_id')
                 ->where('cards.id' , $card_id)
                 ->get();
        $users = DB::table('cards')
                 ->select('users.id' , 'users.name')
                 ->join('user_card' , 'cards.id' , '=' , 'user_card.card_id')
                 ->join('users' , 'users.id' , '=' , 'user_card.user_id' )
                 ->where('cards.id' , $card_id)
                 ->get();
        $comments = DB::table('comments')
                   ->select('comments.id' , 'comments.content' , 'comments.user_id' , 'comments.card_id' , 'users.name')
                   ->join('users' , 'users.id' , '=' , 'comments.user_id')
                   ->join('cards' , 'cards.id' , '=' , 'comments.card_id' )
                   ->where('comments.card_id' , $card_id)
                   ->get();
        $data = [
            'card' => $card,
            'labels' => $labels,
            'users' => $users ,
            'comments' => $comments
        ];


        return response()->json($data);
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

    public function addComment(Request $request): \Illuminate\Http\JsonResponse
    {
        $data = [
            'status' => ""
        ];
        if ($request->comment != null){
            $commentContent = $request->comment;
            $card_id = $request->card_id;
            $user_id = Auth::id();
            $comment = new Comment();
            $comment->content = $commentContent;
            $comment->card_id = $card_id;
            $comment->user_id = $user_id;
            $comment->save();

            $data["status"] = "them comment thanh cong";
            return response()->json($data);
        }
        $data["status"] = "khong co comment";
        return response()->json($data);
    }


}
