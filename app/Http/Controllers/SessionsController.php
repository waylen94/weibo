<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;

class SessionsController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest', [
            'only' => ['create']
        ]);
    }
    public function create()
    {
        return view('sessions.create');
    }
    public function store(Request $request)
    {
        $credentials = $this->validate($request, [
            'email' => 'required|email|max:255',
            'password' => 'required'
        ]);
        
        
//         if login successful or
        if (Auth::attempt($credentials, $request->has('remember'))) {
            if(Auth::user()->activated) {
                session()->flash('success', 'Welcome back！');
                $fallback = route('users.show', Auth::user());
                return redirect()->intended($fallback);
            } else {
                Auth::logout();
                session()->flash('warning', 'Your account has not been activated, please check the email of your registered account');
                return redirect('/');
            }
        } else {
            session()->flash('danger', 'Sorry! The validation unaccessable');
            return redirect()->back()->withInput();
        }
    }
    
    public function destroy()
    {
        Auth::logout();
        session()->flash('success', 'You have successfully logout！');
        return redirect('login');
    }
}
