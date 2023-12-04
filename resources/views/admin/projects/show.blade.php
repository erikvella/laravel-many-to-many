@extends('layouts.admin')

@section('content')
    <div class="container d-flex flex-column">
        <h1>Titolo del progetto: {{ $project->title }} <a class="btn btn-warning mx-3 "
                href="{{ route('admin.projects.edit', $project) }}">Modifica
                progetto</a></h1>

        @if ($project->type)
            <p>Tipologia : <strong>{{ $project->type->name }}</strong></p>
        @endif

        <h1>Tecnologie usate:

            @forelse ($project->tecnologies as $tecnology)
                <span class="badge text-bg-info">{{ $tecnology->name }}</span>
            @empty
                <span class="badge text-bg-warning">Non sono presenti tecnologie per questo progetto</span>
            @endforelse
        </h1>


        <div>
            <img class="show-img" src="{{ asset('storage/' . $project->image) }}" alt="{{ $project->title }}">
            <p> {{ $project->image_original_name }}</p>
        </div>
        {{-- rigiro la data nel formato italiano (giorno/mese/anno) --}}
        @php
            $date = date_create($project->date);
        @endphp
        <h4>Data di creazione: {{ date_format($date, 'd/m/Y') }}</h4>
        <p>Descrizione progetto: {{ $project->text }}</p>
    </div>
@endsection
