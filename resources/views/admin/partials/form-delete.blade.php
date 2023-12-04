<form class="d-inline-block" action="{{ $route }}" method="POST" onsubmit="return confirm('{{ $message }}')">

    @csrf
    @method('delete')
    <button type="submit" class="btn btn-danger">Elimina dall'elenco</button>
</form>
