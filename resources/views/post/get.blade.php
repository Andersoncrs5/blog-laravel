@extends('base')
@section('title')
    See post
@endsection

@section('content')

    <main>
        <div class="mt-5 mb-5">
            <div class="mx-auto w-75 border border-2 rounded-2 p-4">
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
                                    <a href="" class="btn btn-outline-light"><i class="fa-regular fa-bookmark"></i></a>
                                    <a href="" class="btn btn-outline-light"><i class="fa-solid fa-bookmark"></i></a>
                                    <a href="" class="btn btn-outline-light"><i class="fa-regular fa-comment"></i></a>
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
    </main>
    <footer>
    </footer>
@endsection
