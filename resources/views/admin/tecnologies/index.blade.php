@extends('layouts.admin')

@section('content')
    <div class="container d-flex flex-column">
        <h1>Elenco tecnologie</h1>

        <form action="{{ route('admin.tecnologies.store') }}" method="POST">
            @csrf
            <div class="input-group mb-3">
                <input type="text" class="form-control" placeholder="Nuova tecnologia" name="name">
                <button class="btn btn-outline-secondary" type="submit" id="button-addon2">Aggiungi</button>
            </div>
        </form>

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

        {{-- messaggio di errore dato dalla validazione dei dati (validazione nell'update di tecnologies) --}}
        @if ($errors->any())
            <div class="alert alert-danger" role="alert">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif



        <table class="table">
            <thead>
                <tr>
                    <th scope="col">Id</th>
                    <th scope="col">Nome tecnologia</th>
                    <th scope="col">Azioni</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($tecnologies as $tecnology)
                    <tr>

                        <td>{{ $tecnology->id }}</td>
                        <td>
                            <form action="{{ route('admin.tecnologies.update', $tecnology) }}" method="POST"
                                id="form-edit-{{ $tecnology->id }}">
                                @csrf
                                @method('PUT')
                                <input type="text" class="form-hidden" name="name" value="{{ $tecnology->name }}">
                            </form>
                        </td>
                        <td>
                            @include('admin.partials.form-delete', [
                                'route' => route('admin.tecnologies.destroy', $tecnology),
                                'message' => 'Sei sicuro di voler eliminare questa tecnologia?',
                            ])

                            <button onclick="submitForm({{ $tecnology->id }})" class="btn btn-warning">Modifica</button>

                        </td>


                        </td>


                    </tr>
                @endforeach

            </tbody>
        </table>
    </div>

    <script>
        function submitForm(id) {
            const form = document.getElementById('form-edit-' + id);
            form.submit();
        }
    </script>
@endsection
