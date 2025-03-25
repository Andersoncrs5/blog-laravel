@extends('base')
@section('title')
    Get all category
@endsection

@section('content')
    <header class="mb-3 container-fluid" >
        <div class="row p-2 text-center border-bottom">
            <div class="col-4">
                <h3>Categories</h3>
            </div>
            <div class="col-4"></div>
            <div class="col-4">
                <a class="btn btn-light" href="{{ route('index') }}">BACK</a>
            </div>
        </div>
    </header>
    <main>
        @forelse ($categories as $category)
            <div style="width: 85%;" class="mt-2 mx-auto text-center p-2 border border-2 rounded-2">
                <div class="row">
                    <div class="col-4">
                        <h5>{{ $category['name'] }}</h5>
                    </div>
                    <div class="col-2">
                        <h6>Data: {{ \Carbon\Carbon::parse($category['created_at'])->format('d/m/Y') }} </h6>
                    </div>
                    <div class="col-2">
                        @if ($category['is_active'])
                            true
                        @else
                            false
                        @endif
                    </div>
                    <div class="col-4">
                        <a href="{{ route('category.changeStatus', ['id' => $category['id']] ) }}" class="btn btn-sm btn-warning">CHANGE STATUS</a>
                        <a href="{{ route('category.seeCreater', ['id' => $category['id']]) }}" class="btn btn-sm btn-success">SEE CREATER</a>
                        <a href="{{ route('category.update', ['id' => $category['id']] ) }}" class="btn btn-sm btn-warning">UPDATE</a>
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
                                        <h3>Do you wish to delete this category?.</h3>
                                        <hr>
                                        <h3 class="text-warning" >Carefull!!!</h3>
                                        <p class="fs-5">after deleting that category. Posts associated with this category were left uncategorized</p>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Close</button>
                                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal" onclick="window.location.href='{{ route('category.confirmDelete', ['id' => $category['id']]) }}'">Confirm Delete</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="d-flex justify-content-center align-items-center" style="height: 100vh;">
                <div class="w-50 border border-2 rounded-2 p-4 text-center">
                    <h1>No Post</h1>
                </div>
            </div>
        @endforelse
    </main>
    <footer>
    </footer>
@endsection
