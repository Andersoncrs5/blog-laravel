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
                        <select class="form-select" size="5" aria-label="size 3 select example" onchange="redirectToCategory(this)">
                            @foreach ($categories as $category)
                                <option value="{{ route('post.getByCategory', ['category' => $category['name']]) }}">
                                    {{ $category['name'] }}
                                </option>
                            @endforeach
                        </select>
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
                <div class="col-8"></div>
                <div class="col-2 border-start"></div>
            </div>
        </main>
        <footer>

        </footer>
@endsection
