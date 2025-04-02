@extends('base')
@section('title')
    Send a Notification
@endsection

@section('content')
    <main>
        <div class="d-flex justify-content-center align-items-center" style="height: 100vh;">
            <div class="w-50 border border-2 rounded-2 p-4">
                <form action="{{ route('notification.RequestsenderAnNotification') }}" method="post">
                    @csrf
                    <div class="mb-3">
                        <label for="reason" class="form-label">reason</label>
                        <input
                            type="text"
                            class="form-control"
                            name="reason"
                            id="reason"
                            placeholder="Enter the post reason"
                            value="{{ old('reason') }}"
                        />
                        @error('reason')
                            <div class="alert alert-danger p-1 mt-1 text-center">
                                <small>{{ $message }}</small>
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="message" class="form-label">message</label>
                        <textarea class="form-control" name="message" id="message" rows="3" placeholder="Write your post here...">{{ old('message') }}</textarea>
                        @error('message')
                            <div class="alert alert-danger p-1 mt-1 text-center">
                                <small>{{ $message }}</small>
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="user_id" class="form-label">User</label>
                        <select class="form-select" name="user_id" id="user_id">
                            <option selected disabled>Choose user</option>
                            @foreach ($users as $user)
                                <option value="{{ $user['id'] }}" {{ old('user_id') == $user['id'] ? 'selected' : '' }}>
                                    {{ $user['email'] }}
                                </option>
                            @endforeach
                        </select>
                        @error('user_id')
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
    <footer>
    </footer>
@endsection
