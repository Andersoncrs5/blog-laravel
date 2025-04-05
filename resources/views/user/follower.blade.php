@extends('base')

@section('title', 'Followers')

@section('content')
    <header class="container-fluid border-bottom">
        <div class="row p-1">
            <div class="col-4">
                <h2>Followers</h2>
            </div>
            <div class="col-6"></div>
            <div class="col-2 text-center mt-1">
                @include('components.btnBack')
            </div>
        </div>
    </header>

    <main class="container my-4">
        @forelse ($followers as $follower)
            <div class="w-75 mt-2 mx-auto border border-2 rounded-2 p-3">
                <h5>Name: {{ $follower['name'] }}</h5>
                <a href="{{ route('post.creater', ['id' => $follower['id'] ]) }}" class="btn btn-outline-light" > <i class="fa-solid fa-circle-user"></i> </a>
            </div>
        @empty
            <div class="d-flex justify-content-center align-items-center" style="height: 50vh;">
                <div class="w-50 border border-2 rounded-2 p-4 text-center">
                    <h4 class="text-muted">Você ainda não tem seguidores.</h4>
                </div>
            </div>
        @endforelse
    </main>


@endsection
