@extends('layouts.admin')

@section('content')
    <h1>elenco progetti divisi per tipologia</h1>

    <table class="table">
        <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Tipologia</th>
                <th scope="col">Progetti in relazione</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($types as $type)
                <tr>
                    <td>{{ $type->id }}</td>
                    <td>{{ $type->name }}</td>
                    <td>
                        <ul class="list-group">
                            @foreach ($type->projects as $project)
                                <li class="list-group-item"><a
                                        href="{{ route('admin.projects.show', $project) }}">{{ $project->title }}</a></li>
                            @endforeach

                        </ul>
                    </td>
                </tr>
            @endforeach


        </tbody>
    </table>
@endsection
