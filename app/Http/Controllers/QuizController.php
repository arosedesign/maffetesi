<?php

namespace App\Http\Controllers;

use Auth;
use App\Domande;
use App\Impostazioni;
use App\Options;
use App\Risposta;
use App\Table;
use Illuminate\Http\Request;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Redirect;

use function Psy\debug;

class QuizController extends Controller
{
    public function index(Request $request)
    {

        $finequestionario = $request->cookie('finequestionario');

        $user = Auth::user();

        if(!empty($user)) {
            if(!empty($finequestionario) and $user->role != 'admin') {
                return Redirect::to('thanks');
            }
        } else if(!empty($finequestionario)) {
            return Redirect::to('thanks');
        }

        $questions = Domande::orderBy('domanda', 'ASC')->get();
        $anagrafiche = Options::where('tipo', '!=', 'punteggio')->get();
        $impostazioni = Impostazioni::all();

        $testo = array();
        $testo['titolo'] = $impostazioni->where('nome', 'Titolo sito')->first();
        $testo['sottotitolo'] = $impostazioni->where('nome', 'Descrizione sito')->first();

        $profilazione = array();

        foreach ($anagrafiche as $anagrafica) {
            $profilazione[$anagrafica->id]['id'] = $anagrafica->id;
            $profilazione[$anagrafica->id]['nome'] = $anagrafica->nome;
            $profilazione[$anagrafica->id]['tipo'] = $anagrafica->tipo;
            if($anagrafica->tipo == 'integer') {
                $profilazione[$anagrafica->id]['valore'] = explode('_', $anagrafica->valore);
            } elseif($anagrafica->tipo == 'select') {
                $temp = explode('_', $anagrafica->valore);
                $profilazione[$anagrafica->id]['valore'] = array();
                foreach ($temp as $k) {
                    $profilazione[$anagrafica->id]['valore'][$k] = $k;
                }
            }
        }



        $domande = array();
        foreach ($questions as $domanda) {
            $domande[$domanda->id]['id'] = $domanda->id;
            $domande[$domanda->id]['domanda'] = $domanda->domanda;
            $domande[$domanda->id]['valori'] =  explode(',', $domanda->valori);
            $domande[$domanda->id]['opzioni'] = array();

            foreach ($domanda->table->options as $option) {
                $domande[$domanda->id]['opzioni'][$option->id]['id'] = $option->id;
                $domande[$domanda->id]['opzioni'][$option->id]['nome'] = $option->nome;
                $domande[$domanda->id]['opzioni'][$option->id]['tipo'] = $option->tipo;
                $domande[$domanda->id]['opzioni'][$option->id]['valore'] = $option->valore-1;
            }
        }

        return view('quiz')->with([
            'domande' => $domande,
            'testo' => $testo,
            'profilazione' => $profilazione
        ]);
    }

    public function salvaRisposta(Request $request)
    {
        $lastuser = Risposta::orderBy('utente','desc')->first();

        if (!empty($lastuser)) {
            $newuser = $lastuser->utente+1;
        } else {
            $newuser = 1;
        }

        foreach ($request->input() as $key => $value) {

            if($key !== '_token') {

                if (strpos($key, 'opzione') !== false) {
                    $risposte = Risposta::create([
                        'utente' => $newuser,
                        'id_opzione' => str_replace('opzione-', '', $key),
                        'risposta' => $value
                    ]);
                } else {
                    $risposte = Risposta::create([
                        'utente' => $newuser,
                        'id_domanda' => str_replace('domanda-', '', $key),
                        'risposta' => $value
                    ]);
                }
            }

        }

        $minutes = 525600;
        $current_time = Carbon::now()->toDateTimeString();
        return Redirect::to('thanks')->withCookie(cookie('finequestionario', $current_time, $minutes));

    }

    public function thanks()
    {
        $impostazioni = Impostazioni::all();

        $testo = array();
        $testo['grazie'] = $impostazioni->where('nome', 'Ringraziamento')->first();

        return view('thanks')->with([
            'testo' => $testo
        ]);
    }


}



