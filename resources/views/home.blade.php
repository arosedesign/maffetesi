@extends('layouts.app')

@section('content')
<div class="container">

    @if(Auth::user()->role == 'admin')
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Gestione utenti</div>

                    <div class="panel-body">
                        <tbody>
                        @foreach ($users as $user)
                            <tr>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>
                                    {{ Form::open(['method' => 'DELETE', 'route' => ['comics.destroy', $user->id]]) }}
                                    {{ Form::submit('Delete', ['class' => 'btn btn-danger']) }}
                                    {{ Form::close() }}
                                </td>
                            </tr>
                        @endforeach
                        </tbody>

                    </div>
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
