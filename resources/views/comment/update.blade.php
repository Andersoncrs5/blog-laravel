@extends('base')
@section('title')
    update Comment
@endsection

@section('content')
    <main>
        <div class="d-flex justify-content-center align-items-center" style="height: 100vh;">
            <div class="w-50 border border-2 rounded-2 p-4">
                <form action="{{ route('comment.updating', ['id' => $comment['id'] ] ) }}" method="post">
                    @csrf
                    <div class="mb-3">
                        <label for="content" class="form-label">Content</label>
                        <textarea class="form-control" name="content" id="content" rows="3" placeholder="Write your post here...">{{ old('content', $comment->content) }}</textarea>
                        @error('content')
                            <div class="alert alert-danger p-1 mt-1 text-center">
                                <small>{{ $message }}</small>
                            </div>
                        @enderror
                    </div>
                    <div class="d-flex justify-content-between">
                        @include('../components/btnSubmit')
                        @include('../components/btnBack')
                    </div>
                </form>
            </div>
        </div>
    </main>
    <footer>
    </footer>
@endsection
