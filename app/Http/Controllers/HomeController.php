<?php

namespace App\Http\Controllers;

use App\Domande;
use App\Impostazioni;
use App\Options;
use App\Table;
use App\Risposta;
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
        $impostazioni = Impostazioni::all();

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
            'tables' => $tabelle,
            'impostazioni' => $impostazioni
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

		if($request->input('azione') == 'impostazioni') {
			$opzione = Impostazioni::updateOrCreate(
				['id' => $request->input('id')],
				[
					'descrizione' => $request->input('descrizione')
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

    public function risultati(Request $request)

    {

        $filtri = Options::where('table_id', 7)
            ->where('tipo', 'select')
            ->get();

        $filter=array();

        foreach ($filtri as $f) {
            $filter[$f->id]['nome'] = $f->nome;
            $filter[$f->id]['id'] = $f->id;
            $filter[$f->id]['valore'] = array_combine(explode("_",$f->valore), explode("_",$f->valore));
        }

        var_dump($filter);


        $gruppo1query = Domande::where('table_id', 8)->pluck('id')->toArray();
        $risposte1 = Risposta::whereIn('id_domanda', $gruppo1query)->get();
        $tempuser1 = 1;
        $tempsomma1 = 0;
        $risultati1=array();
        $risultati1[0]=0;
        $risultati1[1]=0;
        $risultati1[2]=0;
        foreach ($risposte1 as $r1) {
            if((int)$r1->utente != $tempuser1 ) {
                if($tempsomma1 > 40 ) {
                    $risultati1[2] = $risultati1[2]+1;
                } else if ($tempsomma1 > 35 ){
                    $risultati1[1] = $risultati1[1]+1;
                } else {
                    $risultati1[0] = $risultati1[0]+1;
                }
                $tempuser1 = $r1->utente;
                $tempsomma1 = 0;
            } else {
                if((int)$r1->utente == 1034 && (int)$r1->id_domanda == 23) {
                    $tempsomma1 = $tempsomma1 + (int)$r1->risposta;
                    if($tempsomma1 > 40 ) {
                        $risultati1[2] = $risultati1[2]+1;
                    } else if ($tempsomma1 > 35 ){
                        $risultati1[1] = $risultati1[1]+1;
                    } else {
                        $risultati1[0] = $risultati1[0]+1;
                    }
                    $tempuser1 = $r1->utente;
                    $tempsomma1 = 0;
                } else {
                    $tempsomma1 = $tempsomma1 + (int)$r1->risposta;
                }
            }

        }
        $risultati1['totale'] = $risultati1[0]+$risultati1[1]+$risultati1[2];

        $gruppo2query = Domande::where('table_id', 9)->pluck('id')->toArray();
        $risposte2 = Risposta::whereIn('id_domanda', $gruppo2query)->get();
        $tempuser2 = 1;
        $tempsomma2 = 0;
        $risultati2=array();
        $risultati2[0]=0;
        $risultati2[1]=0;
        $risultati2[2]=0;
        foreach ($risposte2 as $r2) {
            if((int)$r2->utente != $tempuser2 ) {
                if($tempsomma2 > 48 ) {
                    $risultati2[2] = $risultati2[2]+1;
                } else if ($tempsomma2 > 30 ){
                    $risultati2[1] = $risultati2[1]+1;
                } else {
                    $risultati2[0] = $risultati2[0]+1;
                }
                $tempuser2 = $r2->utente;
                $tempsomma2 = 0;
            } else {
                if((int)$r2->utente == 1034 && (int)$r2->id_domanda == 23) {
                    $tempsomma2 = $tempsomma2 + (int)$r2->risposta;
                    if($tempsomma2 > 48 ) {
                        $risultati2[2] = $risultati2[2]+1;
                    } else if ($tempsomma2 > 30 ){
                        $risultati2[1] = $risultati2[1]+1;
                    } else {
                        $risultati2[0] = $risultati2[0]+1;
                    }
                    $tempuser2 = $r2->utente;
                    $tempsomma2 = 0;
                } else {
                    $tempsomma2 = $tempsomma2 + (int)$r2->risposta;
                }
            }

        }
        $risultati2['totale'] = $risultati2[0]+$risultati2[1]+$risultati2[2];

        return view('risultati')->with([
            'risultati1' => $risultati1,
            'risultati2' => $risultati2,
            'filters' => $filter
        ]);
    }

    public function risultatiFiltrati(Request $request)
    {

        $filtri = Options::where('table_id', 7)
            ->where('tipo', 'select')
            ->get();

        $filter=array();

        foreach ($filtri as $f) {
            $filter[$f->id]['nome'] = $f->nome;
            $filter[$f->id]['id'] = $f->id;
            $filter[$f->id]['valore'] = array_combine(explode("_",$f->valore), explode("_",$f->valore));
        }

        var_dump($filter);


        $gruppo1query = Domande::where('table_id', 8)->pluck('id')->toArray();
        $risposte1 = Risposta::whereIn('id_domanda', $gruppo1query)->get();
        $tempuser1 = 1;
        $tempsomma1 = 0;
        $risultati1=array();
        $risultati1[0]=0;
        $risultati1[1]=0;
        $risultati1[2]=0;
        foreach ($risposte1 as $r1) {
            if((int)$r1->utente != $tempuser1 ) {
                if($tempsomma1 > 40 ) {
                    $risultati1[2] = $risultati1[2]+1;
                } else if ($tempsomma1 > 35 ){
                    $risultati1[1] = $risultati1[1]+1;
                } else {
                    $risultati1[0] = $risultati1[0]+1;
                }
                $tempuser1 = $r1->utente;
                $tempsomma1 = 0;
            } else {
                if((int)$r1->utente == 1034 && (int)$r1->id_domanda == 23) {
                    $tempsomma1 = $tempsomma1 + (int)$r1->risposta;
                    if($tempsomma1 > 40 ) {
                        $risultati1[2] = $risultati1[2]+1;
                    } else if ($tempsomma1 > 35 ){
                        $risultati1[1] = $risultati1[1]+1;
                    } else {
                        $risultati1[0] = $risultati1[0]+1;
                    }
                    $tempuser1 = $r1->utente;
                    $tempsomma1 = 0;
                } else {
                    $tempsomma1 = $tempsomma1 + (int)$r1->risposta;
                }
            }

        }
        $risultati1['totale'] = $risultati1[0]+$risultati1[1]+$risultati1[2];

        $gruppo2query = Domande::where('table_id', 9)->pluck('id')->toArray();
        $risposte2 = Risposta::whereIn('id_domanda', $gruppo2query)->get();
        $tempuser2 = 1;
        $tempsomma2 = 0;
        $risultati2=array();
        $risultati2[0]=0;
        $risultati2[1]=0;
        $risultati2[2]=0;
        foreach ($risposte2 as $r2) {
            if((int)$r2->utente != $tempuser2 ) {
                if($tempsomma2 > 48 ) {
                    $risultati2[2] = $risultati2[2]+1;
                } else if ($tempsomma2 > 30 ){
                    $risultati2[1] = $risultati2[1]+1;
                } else {
                    $risultati2[0] = $risultati2[0]+1;
                }
                $tempuser2 = $r2->utente;
                $tempsomma2 = 0;
            } else {
                if((int)$r2->utente == 1034 && (int)$r2->id_domanda == 23) {
                    $tempsomma2 = $tempsomma2 + (int)$r2->risposta;
                    if($tempsomma2 > 48 ) {
                        $risultati2[2] = $risultati2[2]+1;
                    } else if ($tempsomma2 > 30 ){
                        $risultati2[1] = $risultati2[1]+1;
                    } else {
                        $risultati2[0] = $risultati2[0]+1;
                    }
                    $tempuser2 = $r2->utente;
                    $tempsomma2 = 0;
                } else {
                    $tempsomma2 = $tempsomma2 + (int)$r2->risposta;
                }
            }

        }
        $risultati2['totale'] = $risultati2[0]+$risultati2[1]+$risultati2[2];

        return view('risultati')->with([
            'risultati1' => $risultati1,
            'risultati2' => $risultati2,
            'filters' => $filter
        ]);
    }

}
