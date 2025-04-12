@extends('base')
@section('title')
    check email
@endsection

@section('content')
    <main>
        <div class="d-flex justify-content-center align-items-center" style="height: 100vh;">
            <div class="w-50 border border-2 rounded-2 p-4">
                <form action="{{ route('password.checkEmail') }}" method="post">
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

                    <div class="d-flex justify-content-between">
                        @include('../components/btnSubmit')
                        <div>
                            @include('../components/btnBack')
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </main>
@endsection
