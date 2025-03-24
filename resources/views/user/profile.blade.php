@extends('base')
@section('title')
    profile
@endsection

@section('content')
    <main>
        <div class="d-flex justify-content-center align-items-center" style="height: 100vh;">
            <div class="w-50 border border-2 rounded-2 p-4">
                <h2>Email : {{$user->email}}</h2>
                <h5>Name : {{$user->name}}</h5>
                <h5>created_at : {{$user->created_at}}</h5>
                <div class="d-flex justify-content-between mt-1 ">
                    <div>
                        <!-- Botão para abrir o modal -->
                        <a class="btn btn-warning" href="{{ route('updateUser') }}">UPDATE</a>
                    
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
                                        <h3>Do you wish to delete your profile? to confirm.</h3>
                                        <hr>
                                        <h3 class="text-warning" >Carefull!!!</h3>
                                        <p class="fs-5">All your  posts and comments will be deleted</p>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Close</button>
                                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal" onclick="window.location.href='{{ route('deleteUser') }}'">Confirm Delete</button>
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
                    
                    <div>
                        <a class="btn btn-primary" href="{{ route('index') }}">BACK</a>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <footer></footer>
@endsection
