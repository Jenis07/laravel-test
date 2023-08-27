<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }
    public function custom_register(Request $request){
        $validator=Validator::make($request->all(),[
            'name'=>'required|string',
            'email'=>'required|email|unique:users',
            'password'=>[
                'required',
                'min:8',
            ]
            ]);
            if($validator->fails()){
                return back()->withErrors($validator->errors())->withInput();
            }
            $user=new User();
            $user->name=$request->name;
            $user->email=$request->email;
            $user->password=Hash::make($request->password);
            $user->save();
            return redirect('/')->with('success','Registred Successfully');

    }
    public function custom_login(Request $request){
        $validator=Validator::make($request->all(),[
            'email'=>'required',
            'password'=>'required'
        ]);
        if($validator->fails()){
            return back()->withErrors($validator->errors())->withInput();
        }
        $cred=$request->only('email','password');
        if(Auth::attempt($cred)){
            return redirect()->route('home')->with('status','Login Successfully');
        }
    }
    public function logout(Request $request){
        Session::flush();
        Auth::logout();
        return redirect()->route('index');
    }
}
