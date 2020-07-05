@extends('layout.master')
@section('title','TechSolution - Connect, Learn and Share')
@section('content')



<main>
    <div class="mt-1 d-flex justify-content-center">
        @include('layout.leftpanel')
        <div class="col-sm-10">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h2>Tất cả người dùng</h2>
                    <br />
                    <form action="">
                        <div class="form-group mb-4">
                            <input id="searchUsers" type="search" placeholder="Tìm trong người dùng"
                                aria-describedby="button-addon" class="form-control-lg border-primary">
                        </div>
                    </form>
                </div>
                <div class="card-body">
                    <div class="">
                        <div id="allUsers">
                            <div class="row" id="allU">
                                @foreach($users as $user)
                                <div class="col-sm-3 text-center py-2">
                                    <div class="card border-left-success shadow h-100 py-2">
                                        <div id="{{$user->_id}}" class="forward-id card-body" data-receiverName="{{$user->fullname}}">
                                            <div class="row no-gutters align-items-center">
                                                <div class="col-sm-4 pr-2">
                                                    @if(is_file('storage/avatars/'.$user->avatar))
                                                    <a href="/personalinfomation/{{ $user->_id }}">
                                                        <img src="{{ asset('storage/avatars')}}/{{$user->avatar}}"
                                                            class="img-fluid rounded-circle align-middle user-avatar">
                                                    </a>
                                                    @else
                                                    <a href="/personalinfomation/{{ $user->_id }}">
                                                        <img src="{{$user->avatar}}"
                                                            class="img-fluid rounded-circle align-middle user-avatar">
                                                    </a>
                                                    @endif

                                                </div>
                                                <div class="col-sm-7">
                                                    <div class="h5 font-weight-bold text-primary text-uppercase mb-1">
                                                        <a href="/personalinfomation/{{ $user->_id }}">
                                                            {{$user->fullname}}
                                                        </a>
                                                    </div>
                                                    <div class="mb-0 text-muted">{{$user->questions->count()}} câu hỏi
                                                    </div>
                                                    <div class="mb-0  text-muted">{{$user->answers->count()}} trả lời
                                                    </div>
                                                    <a href="/messages" style="color:blue"><i
                                                            class="fa fa-envelope" onclick="sendMessage();"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                                <div class="row px-3 pt-3 justify-content-sm-center">{!! $users->links() !!}</ </div>

                                </div>
                            </div>
                            <hr>

                        </div>
                    </div>
                </div>
                <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
                <script>
                var receiver_id='';
                var receiver_name='';
                function sendMessage() {
                    $('.forward-id').click(function() {
                        
                        receiver_id = $(this).attr('id');
                        receiver_name=$(this).attr('data-receiverName');
                        localStorage.setItem('receiverID',receiver_id );
                        localStorage.setItem('receiverName',receiver_name);
                    });
                }
                </script>
</main>
@endsection