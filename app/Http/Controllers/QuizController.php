<?php

namespace App\Http\Controllers;

use App\Domande;
use App\Impostazioni;
use App\Options;
use App\Table;
use Illuminate\Http\Request;
use App\User;
use function Psy\debug;

class QuizController extends Controller
{
    public function index()
    {

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
            if($anagrafica->tipo != 'testo') {
                $profilazione[$anagrafica->id]['valore'] = explode('_', $anagrafica->valore);
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
}
