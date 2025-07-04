<header class="w-100 headerMain " >
    <div class="container-fluid position-fixed top-0 end-0 row text-center border-bottom">
        <div class="col-3 mt-2 text-light">
            <h3>Blog</h3>
        </div>
        <div class="col-6 mt-2">
            <form action="{{ route('post.searchByTitle') }}" method="GET" class="">
                <div class="mb-3 input-group text-light">
                    <input
                        type="text"
                        class="form-control"
                        name="title"
                        value="{{ request('title') }}"
                        placeholder="Search"
                        style="background-color:transparent; "

                    />
                    <button type="submit" class="btn btn-outline-light">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </button>
                </div>
            </form>            
        </div>
        <div class="col-3 mt-2">
            @if (session('active') == true )
                <a class="btn btn-outline-light btn-lg"><i class="fa-solid fa-filter"></i></a>
                <a class="btn btn-outline-light btn-lg" href="{{ route('profile') }}"><i class="fa-solid fa-circle-user"></i></a>
                <a class="btn btn-lg btn-outline-light" href="{{ route('notification.getAll') }}"><i class="fa-solid fa-bell"></i></a>
                <a class="btn btn-lg btn-outline-light" href="{{ route('logout') }}"><i class="fa-solid fa-right-from-bracket"></i></a>
            @else
                <a class="btn btn-outline-light btn-lg" href="{{ route('login') }}">sign in</a>
            @endif
        </div>
    </div>
</header>
