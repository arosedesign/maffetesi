<?php

namespace App\Http\Controllers;

use App\Domande;
use App\Options;
use App\Table;
use Illuminate\Http\Request;
use App\User;

class QuizController extends Controller
{
    public function index()
    {

        $questions = Domande::all();

        $domande = array();

        foreach ($domande as $domanda) {
            $domanda[$domanda->id]['id'] = $domanda->id;
            $domanda[$domanda->id]['domanda'] = $domanda->domanda;
            $domanda[$domanda->id]['valori'] =  explode(',', $domanda->valori);
            $domanda[$domanda->id]['opzioni'] = array();

            $opzioni = $domanda->table->first()->options;

            foreach ($opzioni as $option) {
                $domanda[$domanda->id]['opzioni'][$option->id]['id'] = $option->id;
                $domanda[$domanda->id]['opzioni'][$option->id]['nome'] = $option->nome;
                $domanda[$domanda->id]['opzioni'][$option->id]['tipo'] = $option->tipo;
                $domanda[$domanda->id]['opzioni'][$option->id]['valore'] = $option->valore;
            }
        }


        return view('quiz')->with([
            'domande' => $domande
        ]);
    }
}
