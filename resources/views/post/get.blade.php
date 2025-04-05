@extends('base')
@section('title')
    See post
@endsection

@section('content')

    <main class="container-fluid" >
        <div class="row mt-5 mb-5">
            <div class="col-8">
                <div class="mx-auto border border-2 rounded-2 p-3">
                    <div class="mt-2 mx-auto">
                        <div class="row">
                            <div class="col-12 text-center">
                                <h3>{{ $post->title }}</h3>
                            </div>
                            @include('../components.line')
                            <div class="col-12 text-center">
                                <p>{{ $post->content }}</p>
                            </div>
                            @include('../components.line')
                            <div class="mx-auto mt-1 ms-1 " >
                                <div class="d-flex justify-content-between">
                                    <div>
                                        @if ($check == true)
                                            <a href="{{ route('favoritePost.remove', ['id' => $post->id ] ) }}" class="btn btn-outline-light"><i class="fa-solid fa-bookmark"></i></a>
                                        @else
                                            <a href="{{ route('favoritePost.save', ['id' => $post->id ] ) }}" class="btn btn-outline-light"><i class="fa-regular fa-bookmark"></i></a>
                                        @endif

                                        @if ($res == null)
                                            <a href="{{ route('like.like', ['id' => $post->id ] ) }}" class="btn btn-outline-light"><i class="fa-regular fa-thumbs-up"></i> {{ $like }} </i></a>
                                            <a href="{{ route('like.unlike', ['id' => $post->id ] ) }}" class="btn btn-outline-light"><i class="fa-regular fa-thumbs-down"></i>{{ $unlike }}</a>
                                        @else
                                            @if ($res->is_like== true)
                                                <a href="{{ route('like.remover', ['id' => $post->id ] ) }}" class="btn btn-outline-light"><i class="fa-solid fa-thumbs-up"></i>{{ $like }}</a>
                                                <a href="{{ route('like.unlike', ['id' => $post->id ] ) }}" class="btn btn-outline-light"><i class="fa-regular fa-thumbs-down"></i>{{ $unlike }}</a>
                                            @endif
                                            @if ($res->is_like == false)
                                                <a href="{{ route('like.like', ['id' => $post->id ] ) }}" class="btn btn-outline-light"><i class="fa-regular fa-thumbs-up"></i></i> {{ $like }} </a>
                                                <a href="{{ route('like.remover', ['id' => $post->id ] ) }}" class="btn btn-outline-light"><i class="fa-solid fa-thumbs-down"></i>{{ $unlike }}</a>
                                            @endif
                                        @endif
                                        
                                        <a href="{{ route('comment.create', ['id' => $post->id ]) }}" class="btn btn-outline-light"><i class="fa-regular fa-comment"></i></a>
                                        <a href="{{ route('post.creater', ['id' => $post->user_id ] ) }}" class="btn btn-outline-light"> <i class="fa-regular fa-circle-user"></i> </a>
                                        @include('../components/btnBack')
                                    </div>
                                    <div class="ms-1 d-flex">
                                        <h5>viewed {{ $post->viewed }}</h5>
                                        <h5 class="ms-3" > {{ \Carbon\Carbon::parse($post->created_at)->format('d/m/Y') }} </h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-4 ">
                <div class="row border border-1 rounded-2">
                    <div class="col-12 text-center">
                        <h3>Comments</h3>
                    </div>
                    <div class="col-12 pb-2 " >
                        @forelse ($comments as $comment)
                            <div class="row p-2 m-1 border border-1 rounded-1 mt-2">
                                <div class="col-12">
                                    <p> {{ $comment['content'] }} </p>
                                </div>
                                @include('../components/line')

                                <div class="col-12">
                                    <div class="d-flex justify-content-between">
                                        <div class="">
                                            <a href="{{ route('comment.getComment', ['id' => $comment['id'] ]) }}" class="btn btn-sm btn-outline-light">SEE COMMENT</a>
                                        </div>

                                        <div>
                                            <h5 class="ms-3" > Created at: {{ \Carbon\Carbon::parse($comment['created_at'])->format('d/m/Y') }} </h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="w-50 rounded-1 mx-auto p-3 text-center">
                                <h2>NO COMMENTS</h2>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

        </div>
    </main>
    <footer>
    </footer>
@endsection
