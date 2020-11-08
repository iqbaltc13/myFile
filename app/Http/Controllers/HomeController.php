<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Auth;

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
    public function index()
    {
        $user = Auth::user();
        if($user->status != 1 || is_null($user->status)){
            Auth::logout();
            return redirect()->route('login')->with('error', 'Akun belum diaktivasi');
        }
        $arrReturn=[
            'sidebar' =>'file',
        ];
        return view('home',$arrReturn);
    }
}
