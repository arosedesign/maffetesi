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
                                            {{ Form::submit('Esegui', ['class' => 'btn btn-danger btn-esegui']) }}
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

                <div class="panel panel-default">
                    {{ Form::open(array('route' => 'editTabella')) }}
                        {{ Form::hidden('id', $table->id)  }}

                        <div class="panel-heading">
                            <h4>Anagrafiche</h4>
                            <label for="descrizione">Descrizione</label>
                            {{ Form::text('tipo', $table->descrizione)  }}
                            <label for="tipo">Tipo</label>
                            {{ Form::text('tipo', $table->tipo)  }}
                        </div>

                        <div class="panel-body">

                        </div>
                    {{ Form::close() }}

                </div>

            </div>
        </div>














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
