@extends('layouts.admin')

@section('content')
    <div class="container d-flex flex-column">
        <h1>Elenco tipologie</h1>

        <form action="{{ route('admin.types.store') }}" method="POST">
            @csrf
            <div class="input-group mb-3">
                <input type="text" class="form-control" placeholder="Nuova tipologia" name="name">
                <button class="btn btn-outline-secondary" type="submit" id="button-addon2">Aggiungi</button>
            </div>
        </form>

        <div class="container">
            @if (session('error'))
                <div class="alert alert-danger" role="alert">
                    {{ session('error') }}
                </div>
            @endif

            @if (session('success'))
                <div class="alert alert-success" role="alert">
                    {{ session('success') }}
                </div>
            @endif


            <form action="{{ route('admin.tecnologies.store') }}" method="POST">
                @csrf

                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">Id</th>
                            <th scope="col">Tipo di progetto</th>
                            <th scope="col">Azioni</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($types as $type)
                            <tr>

                                <td>{{ $type->id }}</td>
                                <td>{{ $type->name }}</td>
                                <td>
                                    @include('admin.partials.form-delete', [
                                        'route' => route('admin.types.destroy', $type),
                                        'message' => 'Sei sicuro di voler eliminare questa tipologia?',
                                    ])
                                </td>


                                </td>


                            </tr>
                        @endforeach

                    </tbody>
                </table>
            </form>
        </div>
    </div>
@endsection
