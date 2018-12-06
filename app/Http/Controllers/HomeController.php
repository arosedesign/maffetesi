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
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();

        return view('home')->with('users',$users);
    }

    public function editUser($params)
    {
        $users = App\User::findOrFail($params['id']);

        if($params['azione'] == 'elimina') {
            $users->delete();
        } elseif ($params['azione'] == 'rendiadmin') {
            $users->role = 'admin';
            $users->save();
        }

        return view('home');
    }


}
