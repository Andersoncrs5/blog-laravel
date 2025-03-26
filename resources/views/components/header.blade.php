<header class="w-100" >
    <div class="container-fluid row text-center border-bottom">
        <div class="col-3 mt-2">
            <h3>Blog</h3>
        </div>
        <div class="col-6 mt-2">
            <form action="" method="post" class="">
                @csrf
                <div class="mb-3 input-group">
                    <input
                        type="text"
                        class="form-control"
                        name="title"
                        id=""
                        aria-describedby="helpId"
                        placeholder="Search"
                    />
                    <button type="submit" class="btn btn-outline-light" ><i class="fa-solid fa-magnifying-glass"></i></button>
                </div>
            </form>
        </div>
        <div class="col-3 mt-2">
            @if (session('active') == true )

                <button class="btn btn-lg btn-outline-light" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight" aria-controls="offcanvasRight"><i class="fa-solid fa-circle-user"></i></button>

                <div class="offcanvas offcanvas-end bg-secondary" tabindex="-1" id="offcanvasRight" aria-labelledby="offcanvasRightLabel">
                    <div class="offcanvas-header ">
                        <h5 class="offcanvas-title" id="offcanvasRightLabel">PROFILE</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                    </div>
                    <div class="offcanvas-body">
                        @if (session('is_adm') == false )
                            <a class="btn btn-light d-block mt-1" href="{{ route('category.save') }}">Create New Category</a>
                            <a class="btn btn-light d-block mt-1" href="{{ route('category.getAllToAdm') }}">Get all Categories</a>
                        @endif
                        <a class="btn btn-light d-block mt-1" href="{{ route('profile') }}">profile</a>
                        <a class="btn btn-light d-block mt-1" href="{{ route('post.save') }}">Create new post</a>
                        <a class="btn btn-light d-block mt-1" href="{{ route('post.getAllOfUser') }}">See my posts</a>
                        <a class="btn btn-light d-block mt-1" href="{{ route('comment.getAllCommentOfUser') }}">See my comments</a>
                        <a class="btn btn-light d-block mt-1" href="{{ route('logout') }}">logout</a>
                    </div>
                </div>
                <a class="btn btn-lg btn-outline-light" href=""><i class="fa-solid fa-bell"></i></a>
            @else
                <a class="btn btn-light btn-sm mt-1" href="{{ route('login') }}">sign in</a>
            @endif
        </div>
    </div>
</header>
