@extends('layouts.admin')

@section('content')
    <h1>Elenco dei progetti in relazione alla tecnologia: {{ $tecnology->name }}</h1>

    <table class="table">
        <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Nome del progetto</th>
                <th scope="col">Azioni</th>

            </tr>
        </thead>
        <tbody>
            @foreach ($tecnology->projects as $project)
                <tr>

                    <td>{{ $project->id }}</td>
                    <td>{{ $project->title }}</td>

                    <td class="d-flex">
                        <a class="btn btn-success mx-3" href="{{ route('admin.projects.show', $project) }}">Dettagli
                            progetto</a>
                        <a class="btn btn-warning mx-3 " href="{{ route('admin.projects.edit', $project) }}">Modifica
                            progetto</a>
                        @include('admin.partials.form-delete', [
                            'route' => route('admin.projects.destroy', $project),
                            'message' => 'Sei sicuro di voler eliminare questo progetto?',
                        ])
                    </td>

                </tr>
            @endforeach

        </tbody>
    </table>
@endsection
