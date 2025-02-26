<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\User;

class UserController extends Controller
{
    public function update_role(Request $request, $id)
    {
        // dd($request->role, $id);
        User::where('id', $id)
            ->update(['role' => $request->role]);
            return redirect()->back();
    }


    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }
}
