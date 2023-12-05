@extends('layouts.admin')

@section('content')
    <div class="container d-flex flex-column">
        <h1>elenco progetti</h1>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">
                        <a href="{{ route('admin.order-by', ['direction' => $direction, 'column' => 'id']) }}">ID</a>
                    </th>
                    <th scope="col">
                        <a href="{{ route('admin.order-by', ['direction' => $direction, 'column' => 'title']) }}">Nome
                            Progetto</a>
                    </th>
                    <th scope="col">Descrizione progetto</th>
                    <th scope="col">Tipologia progetto</th>
                    <th scope="col">Tecnologie usate</th>
                    <th scope="col">
                        <a href="{{ route('admin.order-by', ['direction' => $direction, 'column' => 'date']) }}">Data di
                            creazione</a>
                    </th>
                    <th scope="col">Azioni</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($projects as $project)
                    <tr>

                        <td>{{ $project->id }}</td>
                        <td>{{ $project->title }}</td>
                        <td>{{ $project->text }}</td>
                        <td>{{ $project->type?->name ?? '-' }}</td>
                        <td>
                            @forelse ($project->tecnologies as $tecnology)
                                <a class="badge text-bg-info text-decoration-none"
                                    href="{{ route('admin.project-tecnology', $tecnology) }}">
                                    <span>{{ $tecnology->name }}</span>
                                </a>
                            @empty
                                -
                            @endforelse
                        </td>
                        <td>{{ $project->date }}</td>
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

        {{ $projects->links() }}
    </div>
@endsection
