@extends('base')
@section('title')
    Get all category
@endsection

@section('content')
    <header class="mb-3 container-fluid" >
        <div class="row p-2 text-center border-bottom">
            <div class="col-4">
                <h3>Categories</h3>
            </div>
            <div class="col-4"></div>
            <div class="col-4">
                <a class="btn btn-light" href="{{ route('index') }}">BACK</a>
            </div>
        </div>
    </header>
    <main>
        @forelse ($categories as $category)
            <div style="width: 85%;" class="mt-2 mx-auto text-center p-2 border border-2 rounded-2">
                <div class="row">
                    <div class="col-4">
                        <h5>{{ $category['name'] }}</h5>
                    </div>
                    <div class="col-2">
                        <h6>Data: {{ \Carbon\Carbon::parse($category['created_at'])->format('d/m/Y') }} </h6>  
                    </div>
                    <div class="col-2">
                        @if ($category['is_active'])
                            true
                        @else
                            false
                        @endif
                    </div>
                    <div class="col-4">
                        <a href="{{ route('category.changeStatus', ['id' => $category['id']] ) }}" class="btn btn-sm btn-warning">CHANGE STATUS</a>
                        <a href="" class="btn btn-sm btn-success">SEE CREATER</a>
                        <a href="{{ route('category.update', ['id' => $category['id']] ) }}" class="btn btn-sm btn-warning">UPDATE</a>
                        <a href="" class="btn btn-sm btn-danger">DELETE</a>
                    </div>
                </div>
            </div>
        @empty
            <div class="d-flex justify-content-center align-items-center" style="height: 100vh;">
                <div class="w-50 border border-2 rounded-2 p-4 text-center">
                    <h1>No Categories</h1>
                </div>
            </div>
        @endforelse
    </main>
    <footer>
    </footer>
@endsection
