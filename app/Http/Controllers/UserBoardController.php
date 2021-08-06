<?php

namespace App\Http\Controllers;

use App\Models\Board;
use App\Models\Role;
use Illuminate\Http\Request;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\UserBoard;
use Exception;
use function PHPUnit\Framework\isEmpty;

class UserBoardController extends Controller
{

    public function index()
    {

    }


    public function store(Request $request)
    {
        try {
            $user_id = User::where('email', $request->email)->get('id');
            $board = Board::find($request->board_id);
            $board->users()->attach($user_id, ['role_id' => $request->role_id]);
            return response()->json([
                'message' => 'Thêm thành viên thành công'
            ]);
        } catch (Exception $e) {
            return $e->getMessage();
        }

    }


    public function create(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function getAll($id)
    {
        $userId = UserBoard::where('board_id', $id)->get('user_id');
        $user = User::find($userId);
        return response()->json($user);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function getRole(Request $request): \Illuminate\Http\JsonResponse
    {
        $board_id = $request->board_id;
        $userId = Auth::id();

        $user = DB::table('users')
            ->select('user_board.user_id', 'user_board.board_id', 'user_board.role_id')
            ->join('user_board', 'users.id', '=', 'user_board.user_id')
            ->join('roles', 'roles.id', '=', 'user_board.role_id')
            ->where([['user_board.user_id', '=', $userId], ['user_board.board_id', '=', $board_id]])
            ->get();

        return response()->json($user);
    }
}
