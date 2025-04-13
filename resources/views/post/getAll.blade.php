@extends('base')
@section('title')
    Get all post
@endsection

@section('content')
    <header class="mb-3 container-fluid" >
        <div class="row p-2 text-center border-bottom">
            <div class="col-4">
                <h3>Posts</h3>
            </div>
            <div class="col-4"></div>
            <div class="col-4">
                @include('../components/btnBack')
            </div>
        </div>
    </header>
    <main>
        @forelse ($posts as $post)
            <div style="width: 85%;" class="mt-2 mx-auto  p-2 border border-2 rounded-2">
                <div class="row">
                    <div class="col-12 text-center">
                        <h3>{{ $post['title'] }}</h3>
                    </div>
                    @include('../components.line')
                    <div class="mx-auto mt-1" style="width: 97%" >
                        <div class="d-flex justify-content-between">
                            <div>
                                <a href="{{ route('post.getPost', ['id' => $post['id']] ) }}" class="btn btn-outline-light">SEE POST</a>
                            </div>
                            <div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="d-flex justify-content-center align-items-center" style="height: 89vh;">
                <div class="w-50 border border-2 rounded-2 p-4 text-center">
                    <h1>No Posts</h1>
                </div>
            </div>
        @endforelse
        <div class="w-100 d-flex justify-content-between align-items-center mt-2">
            <div>
                {{ $posts->links() }}
            </div>
            <div class="text-end pe-3">
                Showing {{ $posts->firstItem() }} to {{ $posts->lastItem() }} of {{ $posts->total() }} posts
            </div>
        </div>
    </main>
    <footer>
    </footer>
@endsection
