@extends('base')
@section('title')
    all notifications
@endsection

@section('content')
    <header class="mb-3 container-fluid" >
        <div class="row p-2 text-center border-bottom">
            <div class="col-4">
                <h3>notifications</h3>
            </div>
            <div class="col-4"></div>
            <div class="col-4">
                @include('../components/btnBack')
            </div>
        </div>
    </header>
    <main>
        @forelse ($nots as $note)
            <div style="width: 85%;" class="mt-2 mx-auto  p-2 border border-2 rounded-2">
                <div class="row">
                    <div class="col-12">
                        <h3 class="ms-1" >{{ $note->reason }}</h3>
                    </div>
                    @include('../components.line')
                    <div class="col-12">
                        <p class="ms-1" >{{ $note->message }}</p>
                    </div>
                    @include('../components.line')
                    <div class="col-12">
                        <div class="mx-auto mt-1 ms-1" >
                            <div class="d-flex justify-content-between">
                                <div>
                                    @if ($note->is_read == false )
                                    <a href="{{ route('notification.markWithVisa', ['id' => $note->id] ) }}" class="btn btn-outline-light">mark With Visa</a>
                                    @endif
                                    
                                </div>
                                <div>
                                    @if (session('is_adm') == true )
                                        @if ($note->is_read == true )
                                            <p>User readed the notification</p>
                                        @endif
                                    @endif
    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="d-flex justify-content-center align-items-center" style="height: 89vh;">
                <div class="w-50 border border-2 rounded-2 p-4 text-center">
                    <h1>No Notifications</h1>
                </div>
            </div>
        @endforelse
        <div class="w-100 d-flex justify-content-between align-items-center mt-2">
            <div>
                {{ $nots->links() }}
            </div>
            <div class="text-end pe-3">
                Showing {{ $nots->firstItem() }} to {{ $nots->lastItem() }} of {{ $nots->total() }} notifications
            </div>
        </div>
    </main>
    <footer>
    </footer>
@endsection
