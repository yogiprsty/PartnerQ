<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $id = Auth::user()->id;

        $user = User::where('id', $id)->with(['groups', 'owned_groups', 'my_groups'])->first();
        $usergroup = $this->user_groups_ids($user->groups);

        $groups = Group::where('type', 'like', "%$request->type%")
        ->where('name', 'like', "%$request->name%")->whereNotIn('id', $usergroup)->with('owners')->get();
        return view('home', compact('groups'), compact('user'));
    }

    public function user_groups_ids($userGroups){
        $ids = [];
        foreach ($userGroups as $group){
            array_push($ids, $group['id']);
        }

        return $ids;
    }
}
