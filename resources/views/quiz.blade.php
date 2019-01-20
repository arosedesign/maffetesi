@extends('layouts.quiz')

@section('content')

    <script>
        $( document ).ready(function() {
            $("[type=range]").on("input ", function() {
                var id = $(this).attr('data-class');
                $("#"+id).html($(this).val());
            });
        });
    </script>
    <div class="container frontend">
        <h1 class="text-center">{{ $testo['titolo']['descrizione'] }}</h1>
        <h4 class="text-center">{{ $testo['sottotitolo']['descrizione'] }}</h4>
        <br><br>

        <div class="row gestionedomande">
            <div class="col-md-8 col-md-offset-2">

                @if ($testo['sottotitolo']['descrizione'] == 'aperto')

                    {{ Form::open(array('route' => 'salvaRisposta')) }}


                    @foreach ($profilazione as $pr)

                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h4>{{ $pr['nome'] }}</h4>
                                </div>

                                <div class="panel-body">
                                    @if ($pr['tipo'] == 'text')
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                {{ Form::text('opzione-'.$pr['id'], '', array('class' => 'form-control', 'placeholder' => $pr['nome'],'required' => 'required'))  }}
                                            </div>
                                        </div>
                                    @elseif ($pr['tipo'] == 'integer')
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <input name="opzione-{{ $pr['id']}}" type="range" min="{{ $pr['valore'][0] }}" max="{{ $pr['valore'][1] }}" step="{{ $pr['valore'][2] }}" value="{{ $pr['valore'][0] }}" data-class="opzione-{{ $pr['id']}}" class="left">
                                                <div id="opzione-{{ $pr['id']}}" class="range-index-wrap"><span class="range-index">{{ $pr['valore'][0] }}</span></div>
                                            </div>
                                        </div>
                                    @elseif ($pr['tipo'] == 'select')
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                {{ Form::select('opzione-'.$pr['id'], $pr['valore'], false, array('class' => 'form-control', 'placeholder' => $pr['nome'],'required' => 'required'))  }}
                                            </div>
                                        </div>
                                    @endif


                                </div>
                            </div>
                        @endforeach

                    <hr><br>

                        @foreach ($domande as $domanda)

                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h4>{{ $domanda['domanda'] }}</h4>
                                </div>

                                <div class="panel-body">

                                    @foreach ($domanda['opzioni'] as $opzione)
                                        <label class="radio-inline">
                                            {{ Form::radio('domanda-'.$domanda['id'], $domanda['valori'][$opzione['valore']], false, ['required' => 'required'])  }}
                                            {{ $opzione['nome'] }}
                                        </label>
                                    @endforeach

                                </div>
                            </div>
                        @endforeach

                    {{ Form::submit('Completa il questionario', ['class' => 'btn btn-primary']) }}
                    {{ Form::close() }}

                @else
                    <h5 class="text-center">Il questionario al momento è chiuso per elaborare i risultati.<br> Grazie.</h5>
                @endif

                <br><br>
            </div>
        </div>
    </div>
@endsection

