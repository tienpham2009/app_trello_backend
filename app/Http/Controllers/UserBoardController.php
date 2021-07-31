<?php

namespace App\Http\Controllers;

use App\Models\Board;
use Illuminate\Http\Request;

use App\Models\User;

use Exception;

class UserBoardController extends Controller
{

    public function index()
    {

    }



    public function store(Request $request)
    {
        try{
        $board = Board::find($request->board_id);
        $user_id = User::where('email',$request->email)->get('id');

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
    public function show($id)
    {
        //
    }

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
