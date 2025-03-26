@extends('base')
@section('title')
    Comment of user
@endsection

@section('content')
    @include('../components/headerComment')
    <main>
    
        <div class="container-fluid  mt-4" >
            <div class="row mx-auto border border-1 rounded-1 w-75 p-2 " >
                <div class="col-12">
                    <p> {{ $comment['content'] }} </p>
                </div>
                @include('../components/line')
                
                <div class="d-flex justify-content-between">
                    <div class="">
                        <a class="btn btn-outline-light" href="{{ route('comment.commentOnComment', ['id' => $comment['id'] ]) }}">COMMENT</a>
                    </div>

                    <div>
                        <h5 class="ms-3" > Created at: {{ \Carbon\Carbon::parse($comment['created_at'])->format('d/m/Y') }} </h5>
                    </div>
                </div>
            </div>
            <div style="width: 70%;" class=" mx-auto p-2" >
                @forelse ($commentsOfComment as $c)
                    <div class="row p-4 border border-1 rounded-1 mt-2">
                        <div class="col-12">
                            <p> {{ $c['content'] }} </p>
                        </div>
                        @include('../components/line')

                        <div class="col-12">
                            <div class="d-flex justify-content-between">
                                <div class="">
                                    {{-- <a class="btn btn-outline-light" href="{{ route('comment.commentOnComment', ['id' => $comment['id'] ]) }}">COMMENT</a> --}}
                                    <a href="{{ route('comment.getComment', ['id' => $c['id'] ]) }}" class="btn btn-sm btn-outline-light">SEE COMMENT</a>
                                </div>
        
                                <div>
                                    <h5 class="ms-3" > Created at: {{ \Carbon\Carbon::parse($c['created_at'])->format('d/m/Y') }} </h5>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="w-50 mt-5 p-5 border border-2 mx-auto text-center">
                        <h1>NO COMMENTS</h1>
                    </div>
                @endforelse
            </div>
            
        </div>

    </main>
    <footer>
    </footer>
@endsection
