<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use App\Models\Group;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class GroupController extends Controller
{
    public function __construct()
    {
        $this->middleware('verified');
    }

    public function index($slug){
        $id = Auth::user()->id;
        $user = User::where('id', $id)->with(['owned_groups', 'my_groups'])->first();

        $grp = Group::where('slug', $slug)->with(['owners'])->first();

        return view('group', compact('grp'), compact('user'));
    }

    public function isOwner($owner){
        return $owner->id == Auth::user()->id;
    }

    public function showCreate(){
        return view('create-group');
    }

    public function create(Request $request){
        $validated = $request->validate([
            'name' => 'required',
            'type' => 'required',
            'desc' => 'required|max:255'
        ]);

        $data = [
            'name' => $request['name'],
            'slug' => Str::slug($request['name']),
            'type' => $request['type'],
            'desc' => $request['desc']
        ];

        $user = Auth::user();
        $group = Group::create($data);

        $group->users()->attach($user, ['is_owner' => true, 'status' => true]);
        return redirect('/home')->with('status', 'Group Created Successfully');
    }

    public function update(Request $request){
        $validated = $request->validate([
            'name' => 'required',
            'type' => 'required',
            'desc' => 'required|max:255'
        ]);

        $data = [
            'name' => $request['name'],
            'slug' => Str::slug($request['name']),
            'type' => $request['type'],
            'desc' => $request['desc']
        ];

        $group = Group::find($request['id'])->update($data);
        return redirect()->route('settings', [$data['slug']])->with('status', 'Update Succesfully');
    }

    public function requestJoin(Request $request){
        $user = Auth::user();
        $group = Group::find($request['group_id']);

        $group->users()->attach($user);
        return redirect('/home')->with('status', 'Request sent successfully');
    }

    public function settings($slug){
        $group = Group::where('slug', $slug)->with(['users', 'pending_users', 'owners'])->first();
        if(!$this->isOwner($group->owners[0])){
            return redirect('/home')->with('status', 'Forbidden Content B*tch');
        }
        return view('group-settings', compact('group'));
    }

    public function acceptUser($slug, $user_id){
        $group = Group::where('slug', $slug)->with(['owners'])->first();
        if(!$this->isOwner($group->owners[0])){
            return redirect('/home')->with('status', 'Forbidden Content B*tch');
        }
        $user = User::find($user_id);

        $user->groups()->detach($group->id);
        $group->users()->attach($user_id, ['status' => true]);

        return redirect()->route('settings', [$group->slug])->with('status', 'User Accepted');
    }

    public function declineUser($slug, $user_id){
        $group = Group::where('slug', $slug)->with(['owners'])->first();
        if(!$this->isOwner($group->owners[0])){
            return redirect('/home')->with('status', 'Forbidden Content B*tch');
        }
        $user = User::find($user_id);

        $user->groups()->detach($group->id);
        return redirect()->route('settings', [$group->slug])->with('status', 'User Removed');
    }

    public function readChat($slug){
        $group = Group::where('slug', $slug)->with('chats')->first();

        return $group->chats;
    }
}
