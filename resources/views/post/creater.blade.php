@extends('base')
@section('title')
    profile
@endsection

@section('content')
    <main>
        <div class="d-flex justify-content-center align-items-center" style="height: 100vh;">
            <div class="w-50 border border-2 rounded-2 p-4">
                <h2>Email : {{$user->email}}</h2>
                <h5>Name : {{$user->name}}</h5>
                <h5>created_at : {{$user->created_at}}</h5>
                <h5>Followers : {{ $totalFollowers }}</h5>
                <div class="d-flex justify-content-between mt-1 ">
                    <div>
                        <a class="btn btn-outline-light" href="{{ route('post.seePostOfUser', ['id' => $user->id ]) }}">SEE POSTS</a>
                        @if ($check)
                            <a class="btn btn-outline-warning" href="{{ route('follower.unfollow', ['id' => $user->id]) }}">UNFOLLOW</a>
                        @else
                            <a class="btn btn-outline-warning" href="{{ route('follower.follow', ['id' => $user->id]) }}">FOLLOW</a>
                        @endif
                    </div>
                    <div>
                        @include('../components/btnBack')
                    </div>
                </div>
            </div>
        </div>
    </main>
    <footer></footer>
@endsection
