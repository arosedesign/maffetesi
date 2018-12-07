@extends('layouts.app')

@section('content')
<div class="container pannello">

    @if(Auth::user()->role == 'admin')
        <div class="row gestioneutenti">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Gestione utenti</div>

                    <div class="panel-body">
                        <table class="table">
                            <thead>
                            <tr>
                                <th scope="col">Nome</th>
                                <th scope="col">Username</th>
                                <th scope="col">Ruolo</th>
                                <th scope="col"></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($users as $user)
                                <tr>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->role }}</td>
                                    <td>
                                        @if(Auth::user()->id != $user->id)

                                            {{ Form::open(array('route' => 'editUser')) }}
                                            {{ Form::hidden('id', $user->id)  }}
                                            {{ Form::select('azione', array('rendiadmin' => 'Rendi admin', 'elimina' => 'Elimina')) }}
                                            {{ Form::submit('Modifica', ['class' => 'btn btn-danger btn-esegui']) }}
                                            {{ Form::close() }}

                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
        </div>

        <div class="row gestionetabelle">

            <div class="col-md-12">


                <h2>Gestione tabelle</h2>

                @foreach ($tables as $table)

                    <div class="panel panel-default">

                        <div class="panel-heading">
                            <h3>Tabella:  {{$table['nome'] }}</h3>

                            <table class="table">
                                <thead>
                                <tr>
                                    <th scope="col">Nome tabella</th>
                                    <th scope="col">Descrizione tabella</th>
                                    <th scope="col">Tipo di tabella</th>
                                    <th scope="col"></th>
                                </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        {{ Form::open(array('route' => 'editTabella')) }}
                                            {{ Form::hidden('id', $table['id'])  }}
                                            {{ Form::hidden('azione', 'tabella')  }}
                                            <td>{{ Form::text('nome', $table['nome'], array('class' => 'form-control'))  }}</td>
                                            <td>{{ Form::text('descrizione', $table['descrizione'], array('class' => 'form-control'))  }}</td>
                                            <td><b>{!! str_replace('_', ' ', ucfirst($table['tipo'])) !!}</b></td>
                                            <td>{{ Form::submit('Salva', ['class' => 'btn btn-danger']) }}</td>
                                        {{ Form::close() }}
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <div class="panel-body">

                            <h4>OPZIONI</h4>
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col">Opzione</th>
                                        @if ($table['tipo'] != 'risposte_fisse')
                                            <th scope="col">Tipo di opzione</th>
                                        @endif
                                        <th scope="col">Valore opzione</th>
                                        <th scope="col"></th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @foreach ($table['opzioni'] as $option)

                                        <tr>
                                            {{ Form::open(array('route' => 'editTabella')) }}
                                            {{ Form::hidden('id', $option['id'])  }}
                                            {{ Form::hidden('azione', 'opzione')  }}
                                            <td>{{ Form::text('nome', $option['nome'], array('class' => 'form-control'))  }}</td>
                                            @if ($table['tipo'] != 'risposte_fisse')
                                                <td>{{ Form::text('tipo', $option['tipo'], array('class' => 'form-control'))  }}</td>
                                            @endif
                                            <td>{{ Form::text('valore', $option['valore'], array('class' => 'form-control'))  }}</td>
                                            <td>{{ Form::submit('Salva', ['class' => 'btn btn-danger']) }}</td>
                                            {{ Form::close() }}
                                        </tr>

                                    @endforeach


                                        <td>
                                            <br>
                                            <button type="button" class="btn btn-primary btn-md" data-toggle="modal" data-target="#aggiungiOpzione">
                                               Aggiungi un'opzione
                                            </button>
                                            <br><br>
                                            {{ Form::open(array('route' => 'editTabella')) }}
                                            {{ Form::hidden('id', $table['id'])  }}
                                            {{ Form::hidden('azione', 'cancella_tabella')  }}
                                            {{ Form::submit('Elimina tabella', ['class' => 'btn btn-danger']) }}
                                            {{ Form::close() }}
                                        </td>
                                        <td></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                    </div>


                    <!-- Modal -->
                    <div class="modal fade" id="aggiungiOpzione" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                {{ Form::open(array('route' => 'editTabella', 'class' => 'form-horizontal')) }}
                                {{ Form::hidden('azione', 'opzione')  }}
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    <h4 class="modal-title" id="myModalLabel">Aggiungi un'opzione alla tabella</h4>
                                </div>
                                <div class="modal-body">
                                    {{ Form::hidden('table_id', $table['id'])  }}
                                    <div class="form-group">
                                        <label for="nome" class="col-sm-2 control-label">Nome</label>
                                        <div class="col-sm-10">
                                            {{ Form::text('nome', "", array('class' => 'form-control'))  }}
                                        </div>
                                    </div>
                                    @if ($table['tipo'] != 'risposte_fisse')
                                        <div class="form-group">
                                            <label for="tipo" class="col-sm-2 control-label">Tipo</label>
                                            <div class="col-sm-10">
                                                {{ Form::select('tipo', array('punteggio' => 'Punteggio', 'integer' => 'Numero', 'select' => 'Scelta multipla', 'text' => 'Testo'), 'punteggio', array('class' => 'form-control'))  }}
                                            </div>
                                        </div>
                                    @else
                                        {{ Form::hidden('tipo', 'punteggio')  }}
                                    @endif
                                    <div class="form-group">
                                        <label for="valore" class="col-sm-2 control-label">Valore</label>
                                        <div class="col-sm-10">
                                            {{ Form::text('valore', '', array('class' => 'form-control', 'placeholder' => 'In scelta multipla separa con "_" (es. Valore 1_Valore 2_Valore 3)'))  }}
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    {{ Form::submit('Salva', ['class' => 'btn btn-primary']) }}
                                    {{ Form::close() }}
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Chiudi</button>
                                </div>
                            </div>
                        </div>
                    </div>

                @endforeach

                <button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#aggiungiTabella">
                    Aggiungi una tabella
                </button>

            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="aggiungiTabella" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    {{ Form::open(array('route' => 'editTabella', 'class' => 'form-horizontal')) }}
                    {{ Form::hidden('azione', 'tabella')  }}
                    {{ Form::hidden('id', null)  }}
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">Aggiungi una tabella</h4>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="nome" class="col-sm-2 control-label">Nome</label>
                            <div class="col-sm-10">
                                {{ Form::text('nome', "", array('class' => 'form-control'))  }}
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="descrizione" class="col-sm-2 control-label">Descrizione</label>
                            <div class="col-sm-10">
                                {{ Form::text('descrizione', "", array('class' => 'form-control'))  }}
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="tipo" class="col-sm-2 control-label">Tipo</label>
                            <div class="col-sm-10">
                                {{ Form::select('tipo', array('risposte_fisse' => 'Risposte fisse', 'risposte_variabili' => 'Risposte variabili'), 'risposte_fisse', array('class' => 'form-control'))  }}
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        {{ Form::submit('Salva', ['class' => 'btn btn-primary']) }}
                        {{ Form::close() }}
                        <button type="button" class="btn btn-default" data-dismiss="modal">Chiudi</button>
                    </div>
                </div>
            </div>
        </div>

        <br><br>




    @else
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">HAI CORRETTAMENTE EFFETTUATO LA LOGIN</div>

                    <div class="panel-body">
                        @if (session('status'))
                            <div class="alert alert-success">
                                {{ session('status') }}
                            </div>
                        @endif

                        L'amministratore deve ancora accettare la tua registrazione.<br>Per favore, riprova più tardi.
                    </div>
                </div>
            </div>
        </div>

     @endif
</div>
@endsection
