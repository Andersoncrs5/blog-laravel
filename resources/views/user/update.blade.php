@extends('base')
@section('title')
    update user
@endsection

@section('content')
    <main>
        <div class="d-flex justify-content-center align-items-center" style="height: 100vh;">
            <div class="w-50 border border-2 rounded-2 p-4">
                <form action="{{ route('updatingUser') }}" method="post">
                    @csrf
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input
                            type="text"
                            class="form-control @error('name') is-invalid @enderror"
                            name="name"
                            id="name"
                            placeholder="Enter your name"
                            value="{{ old('name', $user->name) }}"
                        />
                        @error('name')
                            <div class="alert alert-danger p-1 mt-1 text-center">
                                <small>{{ $message }}</small>
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input
                            type="password"
                            class="form-control @error('password') is-invalid @enderror"
                            name="password"
                            id="password"
                            placeholder="Enter your password"
                            value="{{ old('password') }}"
                        />
                        @error('password')
                            <div class="text-danger">
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