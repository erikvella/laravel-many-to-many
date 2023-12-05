<header class="bg-dark">
    <nav class="navbar navbar-dark">

        <div class="container-fluid">

            <a href="{{ route('home') }}" target="_blank" class="navbar-brand">Vai al sito</a>

            <div class="d-flex">
                <form action="{{ route('admin.projects.index') }}" method="GET">
                    <input type="search" class="form-control mr-sm-2" placeholder="Cerca" aria-label="search">
                </form>
                <a href="{{ route('profile.edit') }}"
                    class="text-decoration-none text-white mx-5">{{ Auth::user()->name }}</a>

                <form action="{{ route('logout') }}" method="POST" class="d-flex" role="search">
                    @csrf
                    <button class="btn btn-light" type="submit"><i class="fa-solid fa-right-from-bracket"></i></button>
                </form>
            </div>

        </div>
    </nav>
</header>
