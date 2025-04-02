@extends('base')
@section('title')
    Home
@endsection

@section('content')
        @include('components.header')
        <main class="container-fluid" >
            <div class="row">
                <div class="col-2 border-end">
                    <div class="mt-1 text-center">
                        <h5>CATEGORIES</h5>
                        @if (collect($categories)->isEmpty())
                            <h3>NO CATEGORIES</h3>
                        @else
                            <select class="form-select" size="5" aria-label="size 3 select example" onchange="redirectToCategory(this)">
                                @foreach ($categories as $category)
                                    <option value="{{ route('post.getByCategory', ['category' => $category['id']]) }}">
                                        {{ $category['name'] }}
                                    </option>
                                @endforeach
                            </select>
                        @endif
                    </div>

                    <script>
                        function redirectToCategory(select) {
                            const url = select.value;
                            if (url) {
                                window.location.href = url;
                            }
                        }
                    </script>

                </div>
                <div class="col-8">
                    @forelse ($posts as $post)
                        <div class="row m-2 border border-1 rounded-2 ">
                            <div class="col-12 text-center p-2 ">
                                <h5>{{ $post['title'] }}</h5>
                            </div>
                            @include('components.line')
                            <div class="col-12 mb-2">
                                <a href="{{ route('post.getPost', ['id' => $post['id'] ]) }}" class="btn btn-outline-light" >SEE POST</a>
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
                <div class="col-2 border-start"></div>
            </div>
        </main>
        <footer>

        </footer>
@endsection
