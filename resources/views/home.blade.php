@extends('base')
@section('title', 'Home')

@section('content')
    @include('components.header')

    <main class="container-fluid">
        <div class="position-fixed start-0 border-end" style="top: 10%; height: calc(100vh - 70px); width: 16.66%; z-index: 1020;">
            <div class="mt-1 px-1 text-center bg-transparent" >
                <h5>CATEGORIES</h5>
                @if (collect($categories)->isEmpty())
                    <h3>NO CATEGORIES</h3>
                @else
                    <select class="form-select text-center bg-transparent " size="5" onchange="redirectToCategory(this)">
                        @foreach ($categories as $category)
                            <option id="optionsCategory" class="text-light" value="{{ route('post.getByCategory', ['category' => $category['id']]) }}">
                                {{ $category['name'] }}
                            </option>
                        @endforeach
                    </select>
                @endif
            </div>
        </div>

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
                <a class="btn btn-outline-light d-block mt-1" href="{{ route('like.seeMyPostLike') }}">See My Post Like</a>
                <a class="btn btn-outline-light d-block mt-1" href="{{ route('commentLike.seeMyCommentLike') }}">See My Comments Like</a>
                <a class="btn btn-outline-light d-block mt-1" href="{{ route('commentFavorite.getAllCommentFavorite', ["id" => session('id') ]) }}">See My Comments Favorite</a>
                
            @endif
            
        </div>

        <div class="mx-auto wLenghtHome " style="margin-top: 5.5%; margin-left: 16.66%; margin-right: 16.66%;">
            @forelse ($posts as $post)
                <div class="row m-2 border border-1 rounded-2 ">
                    <div class="col-12 text-center p-2 ">
                        <h5 class="text-light" >{{ $post->title }}</h5>
                    </div>
                    @include('components.line')
                    <div class="col-12 mb-2">
                        <a href="{{ route('post.getPost', ['id' => $post->id ]) }}" class="btn btn-outline-light">SEE POST</a>
                    </div>
                </div>
            @empty
                <div class="d-flex justify-content-center align-items-center" style="height: 90vh;">
                    <div class="w-50 border border-2 rounded-2 p-5 text-center">
                        <h2>NO POSTS</h2>
                    </div>
                </div>
            @endforelse

            <div class="w-100 d-flex justify-content-between align-items-center mt-2">
                <div>
                    {{ $posts->links() }}
                </div>
                <div class="text-end  pe-3">
                    Showing {{ $posts->firstItem() }} to {{ $posts->lastItem() }} of {{ $posts->total() }} posts
                </div>
            </div>
                        
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
