@extends('layouts.admin')

@section('content')
    <div class="container d-flex flex-column">
        <h1>{{ $title }}</h1>

        @if ($errors->any())
            <div class="alert alert-danger" role="alert">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif


        <div class="container my-5">


            <form action="{{ $route }}" method="POST" enctype="multipart/form-data">
                {{-- @csrf : elemento da inserire in tutti i form in laravel per controllo di sicurezza --}}
                @csrf
                @method($method)
                <div class="mb-3">
                    <label for="title" class="form-label">TItolo progetto *</label>
                    <input type="text" class="form-control" id="title" name="title"
                        value="{{ old('title', $project?->title) }}">

                </div>

                @error('title')
                    <p class="text-danger">{{ $message }}</p>
                @enderror


                {{-- select per la tipologia di progetto --}}
                <div class="my-5">
                    <label for="type_id" class="form-label">Tipo di progetto</label>
                    <select name="type_id" id="type_id" class="form-select" aria-label="Default select example">
                        <option value="" selected>Seleziona una tipologia</option>
                        @foreach ($types as $type)
                            <option value="{{ $type->id }}"
                                {{ old('type_id', $project?->type_id) == $type->id ? 'selected' : '' }}>
                                {{ $type->name }}</option>
                        @endforeach

                    </select>
                </div>


                {{-- qui inserisco la selzione delle tecnologie --}}
                <div class="my-5">
                    <h2>Seleziona le tecnologie</h2>
                    <div class="btn-group" role="group" aria-label="Basic radio toggle button group">
                        @foreach ($tecnologies as $tecnology)
                            <input type="checkbox" class="btn-check" id="tecnology_{{ $tecnology->id }}" autocomplete="off"
                                name="tecnologies[]" value="{{ $tecnology->id }}"
                                @if ($errors->any() && in_array($tecnology->id, old('tecnologies', []))) checked
                                @elseif (!$errors->any() && $project?->tecnologies->contains($tecnology))
                                checked @endif>

                            <label class="btn btn-outline-primary"
                                for="tecnology_{{ $tecnology->id }}">{{ $tecnology->name }}</label>
                        @endforeach
                    </div>
                </div>







                <div class="mb-3">
                    <label for="image" class="form-label">Immagine</label>
                    <input type="file" class="form-control" id="image" name="image" onchange="showImage(event)"
                        value="{{ old('image', $project?->image) }}">

                </div>
                {{-- @error('image')
                    <p class="text-danger">{{ $message }}</p>
                @enderror --}}
                {{-- @if ($project)
                    <img width="120" src="{{ asset('storage/' . $project->image) }}">
                @endif --}}

                {{-- in caso di errore di caricamento dell'immagine carico il placeholder --}}
                <img id="thumb" width="120" onerror="this.src='/img/placeholder-png.png'"
                    src="{{ asset('storage/' . $project?->image) }}">
                <div class="form-floating my-5">
                    <textarea for="text" class="form-control" placeholder="Scrivi la descrizione" id="text" name="text"
                        style="height: 100px"> {{ old('text', $project?->text) }}</textarea>
                    <label>
                        Scrivi la descrizione del progetto *
                    </label>

                </div>



                <button type="submit" class="btn btn-success my-3 ">Invia</button>
                <button type="reset" class="btn btn-danger my-3 ">Cancella tutto</button>


            </form>


        </div>
    </div>

    <script>
        function showImage(event) {
            const thumb = document.getElementById('thumb');
            thumb.src = URL.createObjectURL(event.target.files[0]);
        }
    </script>

@endsection
