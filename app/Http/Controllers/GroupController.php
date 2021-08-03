<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\User;
use Exception;
use App\Models\UserGroup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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


    function addUser(Request $request){
        try{
        $group = Group::find($request->group_id);
        $user_id = User::where('email',$request->email)->get('id');
        $group->users()->attach($user_id, $request->group_id);
        return response()->json([
            'message'=>'Thêm thành viên thành công'
        ]);
        }

        catch( Exception $e){
            return $e->getMessage();
        }
    }

    function getGroupById()
    {
        $userId = Auth::id();
        $groups = Group::whereHas('users', function ($q) use ($userId) {
            $q->whereIn('user_id', [$userId]);
        })->get();
        $data = [
            "status" => "success",
            "data" => $groups
        ];
        return response()->json($data);

    }
}
