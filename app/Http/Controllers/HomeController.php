<?php

namespace App\Http\Controllers;

use App\Options;
use App\Table;
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
        $tables = Table::all();

        $tabelle = array();
        foreach ($tables as $t) {
            $tabelle[$t]['id'] = $t->id;
            $tabelle[$t]['nome'] = $t->nome;
            $tabelle[$t]['descrizione'] = $t->descrizione;
            $tabelle[$t]['tipo'] = $t->tipo;
            $tabelle[$t]['opzioni'] = array();

            $temp_options = $t->options;

            foreach ($temp_options as $option) {
                $tabelle[$t]['opzioni'][$option->id]['id'] = $option->id;
                $tabelle[$t]['opzioni'][$option->id]['nome'] = $option->nome;
                $tabelle[$t]['opzioni'][$option->id]['tipo'] = $option->tipo;
                $tabelle[$t]['opzioni'][$option->id]['valore'] = $option->valore;
            }

        }

        return view('home')->with([
            'users' => $users,
            'tables' => $tabelle
        ]);

    }

    public function editUser(Request $request)

    {
        $users = User::findOrFail($request->input('id'));

        if($request->input('azione') == 'elimina') {
            $users->delete();
        } elseif ($request->input('azione') == 'rendiadmin') {
            $users->role = 'admin';
            $users->save();
        }

        return redirect()->route('home');
    }

    public function editTabella(Request $request)

    {

        if($request->input('azione') == 'tabella') {
            $tabella = Table::updateOrCreate(
                ['id' => $request->input('id')],
                [
                    'nome' => $request->input('nome'),
                    'descrizione' => $request->input('descrizione'),
                    'tipo' => $request->input('tipo')
                ]
            );
        }

        return redirect()->route('home');
    }


}
