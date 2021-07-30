<?php

namespace App\Http\Controllers;

use App\Models\Board;
use App\Models\User;
use App\Models\UserBoard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BoardController extends Controller
{
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
        $board->save();
        $board_id = $board->id;
        $user_id = Auth::id();

        $user_board = new UserBoard();
        $user_board->user_id = $user_id;
        $user_board->board_id = $board_id;
        $user_board->save();

        return response()->json($user_board);

    }
}
