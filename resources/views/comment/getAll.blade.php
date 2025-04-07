@extends('base')
@section('title')
    get all Comments
@endsection

@section('content')
    @include('../components/headerComment')
    <main>
        <div class="w-75 mx-auto mt-4" >
            @forelse ($comments as $comment)
                <div class="row p-4 border border-1 rounded-1 mt-2">
                    <div class="col-12">
                        <p> {{ $comment['content'] }} </p>
                    </div>
                    @include('../components/line')

                    <div class="col-12">
                        <div class="d-flex justify-content-between">
                            <div class="">
                                <a class="btn btn-outline-light" href="{{ route('post.getPost', ['id' => $comment['post_id'] ] ) }}">SEE POST</a>
                                <a class="btn btn-outline-light" href="{{ route('comment.getComment', ['id' => $comment['id'] ] ) }}">SEE COMMENTS</a>
                            </div>
    
                            <div>
                                <h5 class="ms-3" > Created at: {{ \Carbon\Carbon::parse($comment['created_at'])->format('d/m/Y') }} </h5>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div style="margin-top: 19% ;" class="w-50 p-5 border border-2 mx-auto text-center">
                    <h1>NO COMMENTS</h1>
                </div>
            @endforelse
        </div>

    </main>
    <footer>
    </footer>
@endsection
