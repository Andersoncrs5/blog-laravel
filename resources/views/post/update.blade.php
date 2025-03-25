@extends('base')
@section('title')
    Create New Post
@endsection

@section('content')
    <main>
        <div class="d-flex justify-content-center align-items-center" style="height: 100vh;">
            <div class="w-50 border border-2 rounded-2 p-4">
                <form action="{{ route('post.updating') }}" method="post">
                    @csrf
                    <div class="mb-3">
                        <label for="title" class="form-label">Title</label>
                        <input
                            type="text"
                            class="form-control"
                            name="title"
                            id="title"
                            placeholder="Enter the post title"
                            value="{{ old('title', $post->title) }}"
                        />
                        @error('title')
                            <div class="alert alert-danger p-1 mt-1 text-center">
                                <small>{{ $message }}</small>
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="content" class="form-label">Content</label>
                        <textarea class="form-control" name="content" id="content" rows="3" placeholder="Write your post here...">{{ old('content', $post->content) }}</textarea>
                        @error('content')
                            <div class="alert alert-danger p-1 mt-1 text-center">
                                <small>{{ $message }}</small>
                            </div>
                        @enderror
                    </div>
                    <div class="d-flex justify-content-between">
                        <button type="submit" class="btn btn-success">Submit</button>
                        @include('../components/btnBack')
                    </div>
                    <input type="hidden" name="id" value="{{ $post->id }}" >
                </form>
            </div>
        </div>
    </main>
    <footer>
    </footer>
@endsection
