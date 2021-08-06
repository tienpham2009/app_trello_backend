<?php

namespace App\Http\Controllers;

use App\Models\Board;
use App\Models\Group;
use App\Models\User;
use App\Models\UserBoard;
use App\Models\UserGroup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use function Symfony\Component\String\s;

class BoardController extends Controller
{
    protected $boards;
    const DEFAULT_IMAGE = 1 ;
    const DEFAULT_ROLE = 1 ;

    function getBoardByUserID(Request $request): \Illuminate\Http\JsonResponse
    {
        $userId = Auth::id();
        $boards = Board::whereHas('users', function ($q) use ($userId) {
            $q->whereIn('user_id', [$userId]);
        })->get();
        $data = [
            "status" => "success",
            "data" => $boards
        ];
        return response()->json($data);
    }

    function addBoard(Request $request): \Illuminate\Http\JsonResponse
    {
        $board = new Board();
        $board->title = $request->title;
        $board->modifier = $request->modifier;
        $board->group_id = $request->group;
        if ($request->image == null)
        {
            $board->image_id = self::DEFAULT_IMAGE;
        } else {
            $board->image_id = $request->image;
        }
        $board->save();
        $board_id = $board->id;
        $user_id = Auth::id();

        $user_board = new UserBoard();
        $user_board->user_id = $user_id;
        $user_board->board_id = $board_id;
        $user_board->role_id = self::DEFAULT_ROLE;
        $user_board->save();

        $data = [
            "message" => "Tạo bảng thành công"
        ];
        return response()->json($data);
    }

    function getBoardByGroupId(Request $request): \Illuminate\Http\JsonResponse
    {
        $groupId = $request->groupId;
        $userId = 1;
        $groups = Group::whereHas('users', function ($q) use ($userId) {
            $q->whereIn('user_id', [$userId]);
        })->get();

        foreach ($groups as $group) {

            if ($group->id == $groupId) {
                $boards = Group::find($groupId)->boards;
                $data = [
                    'status' => 'thanh cong',
                    'data' => $boards
                ];
                return response()->json($data);
            }
        }
    }

    public function getBoard(Request $request): \Illuminate\Http\JsonResponse
    {
         $board_id = $request->board_id;
         $board = Board::find($board_id);

         return response()->json($board);
    }
}
