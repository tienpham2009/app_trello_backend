<?php

namespace App\Http\Controllers;

use App\Models\Board;
use App\Models\Group;
use App\Models\UserGroup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class GroupController extends Controller
{
    function addGroup(Request $request)
    {
        $name = $request->name;
        $modifier = $request->modifierGroup;
        $userId = Auth::id();

        $group = new Group();
        $group->name = $name;
        $group->modifier = $modifier;
        $group->save();

        $userGroup = new UserGroup();
        $userGroup->user_id = $userId;
        $userGroup->group_id = $group->id;
        $userGroup->save();

        $data = [
          'message' => 'them nhom thanh cong'
        ];

        return response()->json($data);

    }



    function getGroupAndBoard(): \Illuminate\Http\JsonResponse
    {
        $userId = Auth::id();

        $dataBoards[] = [];
        $groups = DB::table('users')
                  ->select('users.id' , 'groups.id' , 'groups.name' , 'groups.modifier' )
                  ->join('user_group' , 'users.id' , '=' , 'user_group.user_id')
                  ->join('groups' , 'groups.id' , '=' , 'user_group.group_id')
                  ->where('users.id' , $userId)->get();

        foreach ($groups as $key => $group){
            $boards = DB::table('boards')
                      ->select('boards.id' , 'boards.title' , 'boards.modifier' , 'boards.group_id' , 'boards.image_id' , 'images.name')
                      ->join('images' , 'images.id' , '=' , 'boards.image_id')
                      ->join('groups' , 'groups.id' , '=' , 'boards.group_id')
                      ->where('group_id'  , $group->id)
                      ->get();
            $dataBoards[$key] = $boards;
        }
        $images = DB::table('images')->get();
        $data = [
            'status' => 'thanh cong',
            'groups' => $groups,
            'dataBoards' => $dataBoards,
            'images' => $images
        ];

        return response()->json($data);
    }
}
