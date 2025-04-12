@extends('base')
@section('title')
    check token
@endsection

@section('content')
    <main>
        <div class="d-flex justify-content-center align-items-center" style="height: 100vh;">
            <div class="w-50 border border-2 rounded-2 p-4">
                <form action="{{ route('password.checkToken', ['email' => $email ] ) }}" method="post">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">token</label>
                        <input
                            type="text"
                            class="form-control @error('token') is-invalid @enderror"
                            name="token"
                            placeholder="abc@mail.com"
                            value="{{ old('token') }}"
                        />
                        @error('token')
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
