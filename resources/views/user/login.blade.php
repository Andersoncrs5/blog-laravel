@extends('base')
@section('title')
    Login
@endsection

@section('content')
    <main>
        <div class="d-flex justify-content-center align-items-center" style="height: 100vh;">
            <div class="w-50 border border-2 rounded-2 p-4">
                <form action="{{ route('logining') }}" method="post">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input
                            type="email"
                            class="form-control @error('email') is-invalid @enderror"
                            name="email"
                            placeholder="abc@mail.com"
                            value="{{ old('email') }}"
                        />
                        @error('email')
                            <div class="text-danger">
                                <small>{{ $message }}</small>
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Password</label>
                        <input
                            type="password"
                            class="form-control @error('password') is-invalid @enderror"
                            name="password"
                        />
                        @error('password')
                            <div class="text-danger">
                                <small>{{ $message }}</small>
                            </div>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-between">
                        @include('../components/btnSubmit')
                        <div>
                            <a href="{{ route('register') }}" class="btn btn-outline-light">register</a>
                            @include('../components/btnBack')
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </main>
    <footer>

    </footer>
@endsection
