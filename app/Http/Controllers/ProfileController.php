<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function edit(){
        $id = Auth::user()->id;

        $user = User::where('id', $id)->with(['groups', 'owned_groups', 'my_groups'])->first();

        return view('profile', compact('user'));
    }

    public function update(Request $request){
        $id = Auth::user()->id;

        $validated = $request->validate([
            'fullname' => 'required|string|max:255',
            'phone' => 'string|min:10',
            'address' => 'string|max:255',
        ]);

        $user = User::find($id)->update($validated);

        return back()->with('success', 'Profil berhasil diubah!');
    }
}
