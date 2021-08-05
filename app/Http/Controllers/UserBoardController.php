<?php

namespace App\Http\Controllers;

use App\Models\Board;
use App\Models\Role;
use Illuminate\Http\Request;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use App\Models\UserBoard;
use Exception;

class UserBoardController extends Controller
{

    public function index()
    {

    }



    public function store(Request $request)
    {
        try{

        $user_id = User::where('email',$request->email)->get('id');
        $board = Board::find($request->board_id);
        $board->users()->attach($user_id,['role_id' => $request->role_id]);
        return response()->json([
            'message'=>'Thêm thành viên thành công'
        ]);
        }

        catch( Exception $e){
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getAll($id)
    {
        $userId = UserBoard::where('board_id', $id)->get('user_id');
        $user = User::find($userId);
        $email = $user->email;






        return response()->json($email);

    }

    //     $user_ids =[];
    //     $user_ids = $userBoard->get('user_id');


    //     foreach ($user_ids as $key => $user_id){
    //        $emails = User::where('user_id', $user_id)->get('email');
    //     }

    //     // $user_email = User::whereIn('id', $user_id);
    //     // $role = Role::whereIn('id',$role_id);






    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
