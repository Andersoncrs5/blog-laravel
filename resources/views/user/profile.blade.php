@extends('base')
@section('title')
    profile
@endsection

@section('content')
    <main>

        <div class="d-flex justify-content-center align-items-center" style="height: 100vh;">
            <div style="width: 60%;" class=" border border-2 rounded-2 p-4">
                <h2>Email : {{$user->email}}</h2>
                <h5>Name : {{$user->name}}</h5>
                <h5>created_at : {{$user->created_at}}</h5>
                <div id="metric_div" class="row p-2 " >
                    <div class="col-6" >
                        <ul class="list-group">
                            <li style="background-color: transparent;" class=" text-light list-group-item d-flex justify-content-between align-items-center">
                                Followers count
                                <span class="badge text-bg-primary rounded-pill">{{ $metric->followers_count }}</span>
                            </li>
                            <li style="background-color: transparent;" class=" text-light list-group-item d-flex justify-content-between align-items-center">
                                Followeds count
                                <span class="badge text-bg-primary rounded-pill">{{ $metric->following_count }}</span>
                            </li>
                            <li style="background-color: transparent;" class=" text-light list-group-item d-flex justify-content-between align-items-center">
                                Total like in comment
                                <span class="badge text-bg-primary rounded-pill">{{ $metric->likes_given_count_in_comment }}</span>
                            </li>
                            <li style="background-color: transparent;" class=" text-light list-group-item d-flex justify-content-between align-items-center">
                                Total dislike in comment: 
                                <span class="badge text-bg-primary rounded-pill">{{ $metric->dislikes_given_count_in_comment }}</span>
                            </li>
                            <li style="background-color: transparent;" class=" text-light list-group-item d-flex justify-content-between align-items-center">
                                Total play list 
                                <span class="badge text-bg-primary rounded-pill">{{ $metric->play_list_count }}</span>
                            </li>
                            <li style="background-color: transparent;" class=" text-light list-group-item d-flex justify-content-between align-items-center">
                                Total post favorited
                                <span class="badge text-bg-primary rounded-pill">{{ $metric->saved_posts_count }}</span>
                            </li>

                            <li style="background-color: transparent;" class=" text-light list-group-item d-flex justify-content-between align-items-center">
                                Total comments favorited 
                                <span class="badge text-bg-primary rounded-pill">{{ $metric->saved_comments_count }}</span>
                            </li>
                        </ul>
                    </div>
                    <div class="col-6">
                        <ul class="list-group">
                            <li style="background-color: transparent;" class=" text-light list-group-item d-flex justify-content-between align-items-center">
                                Total like in post: 
                                <span class="badge text-bg-primary rounded-pill">{{ $metric->likes_given_count_in_post }} </span>
                            </li>
                            <li style="background-color: transparent;" class=" text-light list-group-item d-flex justify-content-between align-items-center">
                                Total dislike in post: 
                                <span class="badge text-bg-primary rounded-pill">{{ $metric->deslikes_given_count_in_post }}</span>
                            </li>
                            <li style="background-color: transparent;" class=" text-light list-group-item d-flex justify-content-between align-items-center">
                                Total of posts created 
                                <span class="badge text-bg-primary rounded-pill">{{ $metric->posts_count }}</span>
                            </li>
                            <li style="background-color: transparent;" class=" text-light list-group-item d-flex justify-content-between align-items-center">
                                Total of comments created 
                                <span class="badge text-bg-primary rounded-pill">{{ $metric->comments_count }}</span>
                            </li>

                            <li style="background-color: transparent;" class=" text-light list-group-item d-flex justify-content-between align-items-center">
                                Total shares 
                                <span class="badge text-bg-primary rounded-pill">{{ $metric->shares_count }}</span>
                            </li>
                            <li style="background-color: transparent;" class=" text-light list-group-item d-flex justify-content-between align-items-center">
                                Total reports  
                                <span class="badge text-bg-primary rounded-pill">{{ $metric->reports_received_count }}</span>
                            </li>
                            <li style="background-color: transparent;" class=" text-light list-group-item d-flex justify-content-between align-items-center">
                                Total media uploads 
                                <span class="badge text-bg-primary rounded-pill">{{ $metric->media_uploads_count }}</span>
                            </li>
                        </ul>
                    </div>                    
                </div>
                
                <div class="d-flex justify-content-between mt-1 ">
                    
                        <div>
                            <div class="btn-group dropup">
                                <button type="button" class="btn btn-secondary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fa-solid fa-bars"></i>
                                </button>
                                <ul class="dropdown-menu text-center bg-secondary p-1 ">
                                    <a class=" my-1 btn btn-sm btn-primary" href="{{ route('followers') }}">FOLLOWERS</a>
                                    <a class=" my-1 btn btn-sm btn-primary" href="{{ route('following') }}">FOLLOWEDS</a>
                                    @if ($user->id != session('id'))
                                        <a class=" my-1 btn btn-sm btn-primary" href="{{ route('post.getAllOfAnotherUser', ["id" => $user->id ]) }}">SEE POSTS</a>
                                        <a class=" my-1 btn btn-sm btn-primary" href="{{ route('favoritePost.PostFavoriteOfAnotherUser', ["id" => $user->id ]) }}">SEE POSTS FAVORITE</a>
                                        <a class=" my-1 btn btn-sm btn-primary" href="{{ route('comment.getAllCommentOfAnotherUser', ["id" => $user->id ]) }}" >SEE COMMENTS</a>                                    
                                        <a class=" my-1 btn btn-sm btn-primary" href="{{ route('commentLike.seeCommentLike', ["id" => $user->id ]) }}" >SEE COMMENT REACTION</a>
                                        <a class=" my-1 btn btn-sm btn-primary" href="{{ route('like.seePostLike', ["id" => $user->id ]) }}" >SEE POST REACTION</a>
                                    @endif
                                    <a class=" my-1 btn btn-sm btn-primary" href="">SEE COMMENTS FAVORITE</a>
                                </ul>
                            </div>
                            
                                @if ($user->id == session('id') )
                                    <a class=" my-2 btn btn-outline-warning" href="{{ route('updateUser') }}">UPDATE</a>
                                    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#exampleModal">
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
                                @endif
                                
                            </div>

                            <script>
                                var tooltipTriggerList = Array.prototype.slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
                                var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                                    return new bootstrap.Tooltip(tooltipTriggerEl);
                                });
                            </script>
                    <div>
                        
                        @include('../components/btnBack')
                    </div>
                </div>
            </div>
        </div>
    </main>
    <footer></footer>
@endsection
