@extends('base')
@section('title')
    Update Category
@endsection

@section('content')
    <main>
        <div class="d-flex justify-content-center align-items-center" style="height: 100vh;">
            <div class="w-50 border border-2 rounded-2 p-4">
                <form action="{{ route('category.updating') }}" method="post">
                    @csrf
                    <div class="mb-3">
                        <label for="" class="form-label">Name</label>
                        <input type="hidden" name="id" value="{{ $category->id }}" >
                        <input
                            type="text"
                            class="form-control"
                            name="name"
                            id=""
                            aria-describedby="helpId"
                            placeholder=""
                            value="{{ old('name', $category->name) }}"
                        />
                        @error('name')
                            <div class="alert alert-danger p-1 mt-1 text-center">
                                <small>{{ $message }}</small>
                            </div>
                        @enderror
                    </div>
                    <div class="d-flex justify-content-between">
                        <button type="submit" class="btn btn-success">Submit</button>
                        <div>
                            <a class="btn btn-primary" href="{{ route('index') }}">BACK</a>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </main>
    <footer>
    </footer>
@endsection
