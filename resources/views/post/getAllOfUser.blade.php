@extends('base')
@section('title')
    Get all post of user
@endsection

@section('content')
    <header class="mb-3 container-fluid" >
        <div class="row p-2 text-center border-bottom">
            <div class="col-4">
                <h3>My Posts</h3>
            </div>
            <div class="col-4"></div>
            <div class="col-4">
                @include('../components/btnBack')
            </div>
        </div>
    </header>
    <main>
        @forelse ($posts as $post)
            <div style="width: 85%;" class="mt-2 mx-auto  p-2 border border-2 rounded-2">
                <div class="row">
                    <div class="col-12 text-center">
                        <h3>{{ $post['title'] }}</h3>
                    </div>
                    @include('../components.line')
                    <div class="mx-auto mt-1" style="width: 97%" >
                        <div class="d-flex justify-content-between">
                            <div>
                                <a href="{{ route('post.update', ['id' => $post['id']] ) }}" class="btn btn-outline-warning">UPDATE</a>
                                <a href="{{ route('post.getPost', ['id' => $post['id']] ) }}" class="btn btn-outline-light">SEE POST</a>
                                <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                    <i class="fa-solid fa-trash"></i>
                                </button>

                                <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content bg-secondary">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Confirm Delete</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <h2 class="fs-5"></h2>
                                                <h3>Do you wish to delete this post?</h3>
                                                <hr>
                                                <h3 class="text-warning" >Carefull!!!</h3>
                                                <p class="fs-5">After you delete this post. there will be no way to recover it! Do you want to continue?</p>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Close</button>
                                                <button type="button" class="btn btn-danger" data-bs-dismiss="modal" onclick="window.location.href='{{ route('post.delete', ['id' => $post['id']] ) }}'">Confirm Delete</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <script>
                                var tooltipTriggerList = Array.prototype.slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
                                var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                                    return new bootstrap.Tooltip(tooltipTriggerEl);
                                });
                            </script>
                            </div>
                            <div>

                            </div>
                        </div>
                    </div>
                    {{-- <div class="col-2">
                        <h6>Data: {{ \Carbon\Carbon::parse($post['created_at'])->format('d/m/Y') }} </h6>
                    </div> --}}
                    {{-- <div class="col-4">
                        <a href="{{ route('post.changeStatus', ['id' => $post['id']] ) }}" class="btn btn-sm btn-warning">CHANGE STATUS</a>
                        <a href="{{ route('post.seeCreater', ['id' => $post['id']]) }}" class="btn btn-sm btn-success">SEE CREATER</a>
                        <a href="{{ route('post.update', ['id' => $post['id']] ) }}" class="btn btn-sm btn-warning">UPDATE</a>
                        <!-- Botão para acionar o modal -->
                        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#exampleModal">
                            <i class="fa-solid fa-trash"></i>
                        </button>

                        <!-- Modal -->
                        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content bg-secondary">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Confirm Delete</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <h2 class="fs-5"></h2>
                                        <h3>Do you wish to delete this post?.</h3>
                                        <hr>
                                        <h3 class="text-warning" >Carefull!!!</h3>
                                        <p class="fs-5">after deleting that post. Posts associated with this post were left uncategorized</p>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Close</button>
                                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal" onclick="window.location.href='{{ route('post.confirmDelete', ['id' => $post['id']]) }}'">Confirm Delete</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> --}}
                </div>
            </div>
        @empty
            <div class="d-flex justify-content-center align-items-center" style="height: 89vh;">
                <div class="w-50 border border-2 rounded-2 p-4 text-center">
                    <h1>No Posts</h1>
                </div>
            </div>
        @endforelse
    </main>
    <footer>
    </footer>
@endsection
