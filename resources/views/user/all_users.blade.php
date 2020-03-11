@extends('layout.master')
@section('title','TechSolution - Connect, Learn and Share')
@section('content')



<main>
    <div class="mt-1 d-flex justify-content-center">
        @include('layout.leftpanel')
        <div class="col-sm-10">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                <h2>All Users</h2>
                <br/>
                <form action="">
                  <div class="form-group mb-4">
                    <input id="searchUsers" type="search" placeholder="Filter by user" aria-describedby="button-addon" class="form-control-lg border-primary">
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
                                    <div class="card-body">
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
                                                <div class="mb-0 text-muted">{{$user->questions->count()}} Questions</div>
                                                <div class="mb-0  text-muted">{{$user->answers->count()}} Answers</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                            <div class="row px-3 pt-3 justify-content-sm-center">{!! $users->links() !!}</
                            </div>

                        </div>
                    </div>
                    <hr>

                </div>
            </div>
        </div>

    </main>
    @endsection