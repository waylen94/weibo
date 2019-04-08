<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Auth;
use Mail;

class UsersController extends Controller{
    public function __construct()
    {
        $this->middleware('auth', [
            'except' => ['show', 'create', 'store','index','confirmEmail']
        ]);
        
        $this->middleware('guest', [
            'only' => ['create']
        ]);
    }
    
    public function index()
    {
        $users = User::paginate(10);
        return view('users.index', compact('users'));
    }
    
    public function create()
    {
        return view('users.create');
    }
    public function show(User $user)
    {
        $statuses = $user->statuses()
        ->orderBy('created_at', 'desc')
        ->paginate(10);
        return view('users.show', compact('user', 'statuses'));
    }
    
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:50',
            'email' => 'required|email|unique:users|max:255',
            'password' => 'required|confirmed|min:6'
        ]);
        
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);
        
//         Auth::login($user);//login immediately when you successfully login in 
//         session()->flash('success', 'Welcome! Begining Your Exploration Journey');
//         return redirect()->route('users.show', [$user]);
        $this->sendEmailConfirmationTo($user);
        session()->flash('success', 'Confirmation code has been delivered to your email, please check your email account');
        return redirect('/');
        
        
    }
    
    public function edit(User $user)
    {
        $this->authorize('update', $user);
        return view('users.edit', compact('user'));
    }
    
    public function update(User $user, Request $request)
    {
        $this->authorize('update', $user);
        $this->validate($request, [
            'name' => 'required|max:50',
            'password' => 'nullable|confirmed|min:6'
        ]);
        
        $data = [];
        $data['name'] = $request->name;
        if ($request->password) {
            $data['password'] = bcrypt($request->password);
        }
        $user->update($data);
        
        session()->flash('success', 'personal info upadating succuss！');
        
        return redirect()->route('users.show', $user);
    }
    
    public function destroy(User $user)
    {
        $this->authorize('destroy', $user);
        $user->delete();
        session()->flash('success', 'You have successfully deleted the account！');
        return back();
    }
    
    protected function sendEmailConfirmationTo($user)
    {
        $view = 'emails.confirm';
        $data = compact('user');
        $from = 'summer@example.com';
        $name = 'Summer';
        $to = $user->email;
        $subject = "Thank your for your registration, Please complete the registration flow";
        
        Mail::send($view, $data, function ($message) use ($from, $name, $to, $subject) {
            $message->from($from, $name)->to($to)->subject($subject);
        });
    }
    
    public function confirmEmail($token)
    {
        $user = User::where('activation_token', $token)->firstOrFail();
        
        $user->activated = true;
        $user->activation_token = null;
        $user->save();
        
        Auth::login($user);
        session()->flash('success', 'Congratulation, you have actived the account successfully！');
        return redirect()->route('users.show', [$user]);
    }
    

}
