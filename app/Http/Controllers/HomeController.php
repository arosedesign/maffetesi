<?php

namespace App\Http\Controllers;

use App\Domande;
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
            $tabelle[$t->id]['id'] = $t->id;
            $tabelle[$t->id]['nome'] = $t->nome;
            $tabelle[$t->id]['descrizione'] = $t->descrizione;
            $tabelle[$t->id]['tipo'] = $t->tipo;
            $tabelle[$t->id]['opzioni'] = array();
            $tabelle[$t->id]['domande'] = array();

            foreach ($t->options as $option) {
                $tabelle[$t->id]['opzioni'][$option->id]['id'] = $option->id;
                $tabelle[$t->id]['opzioni'][$option->id]['nome'] = $option->nome;
                $tabelle[$t->id]['opzioni'][$option->id]['tipo'] = $option->tipo;
                $tabelle[$t->id]['opzioni'][$option->id]['valore'] = $option->valore;
            }

            foreach ($t->domande as $domanda) {
                $tabelle[$t->id]['domande'][$domanda->id]['id'] = $domanda->id;
                $tabelle[$t->id]['domande'][$domanda->id]['domanda'] = $domanda->domanda;
                $tabelle[$t->id]['domande'][$domanda->id]['valori'] = $domanda->valori;
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

        if($request->input('azione') == 'opzione') {
            $opzione = Options::updateOrCreate(
                ['id' => $request->input('id')],
                [
                    'nome' => $request->input('nome'),
                    'table_id' => $request->input('table_id'),
                    'valore' => $request->input('valore'),
                    'tipo' => $request->input('tipo')
                ]
            );
        }

        if($request->input('azione') == 'domanda') {
            $opzione = Domande::updateOrCreate(
                ['id' => $request->input('id')],
                [
                    'domanda' => $request->input('domanda'),
                    'table_id' => $request->input('table_id'),
                    'valori' => $request->input('valori')
                ]
            );
        }

        return redirect()->route('home');
    }

    public function delete(Request $request)

    {

        if($request->input('azione') == 'opzione') {
            $opzione = Options::find($request->input('id'));
            $opzione->delete();

        }

        if($request->input('azione') == 'domanda') {
            $domanda = Domande::find($request->input('id'));
            $domanda->delete();

        }

        if($request->input('azione') == 'tabella') {

            $tabella = Table::find($request->input('id'));

            foreach ($tabella->options as $opzione) {
                $opzione->delete();
            }

            foreach ($tabella->domande as $domanda) {
                $domanda->delete();
            }

            $tabella->delete();

        }

        return redirect()->route('home');
    }

}
