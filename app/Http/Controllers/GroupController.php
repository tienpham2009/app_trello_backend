<?php

namespace App\Http\Controllers;

use App\Models\Group;
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
}
