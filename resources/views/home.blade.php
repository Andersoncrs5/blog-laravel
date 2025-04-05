@extends('base')
@section('title')
    Home
@endsection

@section('content')
    @include('components.header')

    <main class="container-fluid">
        <!-- Sidebar esquerda fixa -->
        <div class="position-fixed start-0 border-end" style="top: 10%; height: calc(100vh - 70px); width: 16.66%; z-index: 1020;">
            <div class="mt-1 px-1 text-center">
                <h5>CATEGORIES</h5>
                @if (collect($categories)->isEmpty())
                    <h3>NO CATEGORIES</h3>
                @else
                    <select class="form-select" size="5" onchange="redirectToCategory(this)">
                        @foreach ($categories as $category)
                            <option value="{{ route('post.getByCategory', ['category' => $category['id']]) }}">
                                {{ $category['name'] }}
                            </option>
                        @endforeach
                    </select>
                @endif
            </div>
        </div>

        <!-- Sidebar direita fixa -->
        <div class="position-fixed px-1 end-0 border-start" style="top: 10%; height: calc(100vh - 70px); width: 16.66%; z-index: 820;">
            @if (session('active') == true )
                @if (session('is_adm') == true )
                    <a class="btn btn-outline-light d-block mt-1" href="{{ route('notification.senderAnNotification') }}">Send Notification</a>
                    <a class="btn btn-outline-light d-block mt-1" href="{{ route('seeSentNotificationsByMe') }}">See my Notifications</a>
                    <a class="btn btn-outline-light d-block mt-1" href="{{ route('category.save') }}">Create New Category</a>
                    <a class="btn btn-outline-light d-block mt-1" href="{{ route('category.getAllToAdm') }}">Get all Categories</a>
                @endif
                
                <a class="btn btn-outline-light d-block mt-1" href="{{ route('post.save') }}">Create new post</a>
                <a class="btn btn-outline-light d-block mt-1" href="{{ route('favoritePost.PostFavoriteOfUser') }}">See Post Favorite</a>
                <a class="btn btn-outline-light d-block mt-1" href="{{ route('post.getAllOfUser') }}">See my posts</a>
                <a class="btn btn-outline-light d-block mt-1" href="{{ route('comment.getAllCommentOfUser') }}">See my comments</a>
                <a class="btn btn-outline-light d-block mt-1" href="{{ route('like.seeMyPostLike') }}">see My Post Like</a>
                
                
            @endif
            
        </div>

        <!-- Conteúdo central com margem para não ficar por baixo das sidebars -->
        <div class="mx-auto wLenghtHome " style="margin-top: 5.5%; margin-left: 16.66%; margin-right: 16.66%;">
            @forelse ($posts as $post)
                <div class="row m-2 border border-1 rounded-2 ">
                    <div class="col-12 text-center p-2 ">
                        <h5>{{ $post['title'] }}</h5>
                    </div>
                    @include('components.line')
                    <div class="col-12 mb-2">
                        <a href="{{ route('post.getPost', ['id' => $post['id'] ]) }}" class="btn btn-outline-light">SEE POST</a>
                    </div>
                </div>
            @empty
                <div class="d-flex justify-content-center align-items-center" style="height: 90vh;">
                    <div class="w-50 border border-2 rounded-2 p-5 text-center">
                        <h2>NO POSTS</h2>
                    </div>
                </div>
            @endforelse
        </div>

    </main>

    <script>
        function redirectToCategory(select) {
            const url = select.value;
            if (url) {
                window.location.href = url;
            }
        }
    </script>
@endsection
