<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

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
        $lst_user = User::all();
        foreach ($lst_user as $user) {
            $user->email = '0' . $user->matk . '@caothang.edu.vn';
            $user->save();
        }
        return response()->json(['status' => 'OK']);
    }
}
