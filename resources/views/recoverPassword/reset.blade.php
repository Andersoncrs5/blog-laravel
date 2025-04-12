@extends('base')
@section('title')
    reset password
@endsection

@section('content')
    <main>
        <div class="d-flex justify-content-center align-items-center" style="height: 100vh;">
            <div class="w-50 border border-2 rounded-2 p-4">
                <form action="{{ route('password.reset' ) }}" method="post">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">new password</label>
                        <input
                            type="password"
                            class="form-control @error('password') is-invalid @enderror"
                            name="password"
                            placeholder="xxxxxxxxxxxxx"
                            value="{{ old('password') }}"
                        />
                        @error('password')
                            <div class="text-danger">
                                <small>{{ $message }}</small>
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">confirm password</label>
                        <input
                            type="password"
                            class="form-control @error('confirm-password') is-invalid @enderror"
                            name="confirm-password"
                            placeholder="xxxxxxxxxxxxx"
                            value="{{ old('confirm-password') }}"
                        />
                        @error('confirm-password')
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
