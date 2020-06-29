@extends('layout.master')
@section('title','TechSolution - Connect, Learn and Share')
@section('content')

<main>
    <div class="mt-1 d-flex justify-content-center">
        @include('layout.leftpanel')
        <div class="col-sm-10">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                <h2>Tất cả tags</h2>
                <br/>
                <form action="">
                  <div class="form-group mb-4">
                    <input id="searchTags" type="search" placeholder="Tìm trong tags" aria-describedby="button-addon" class="form-control-lg border-primary">
                </div>
                </form>
            </div>
            <div class="card-body">
                <div class="">
                    <div id="allUsers">
                        <div class="row" id="allTags">
                            @foreach($categories as $category)
                            <div class="col-sm-3 text-center py-2">
                                <div class="card border-left-success shadow h-100 py-2">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                           {{--  <div class="col-sm-4 pr-2">
                                                @if(is_file('storage/avatars/'.$user->avatar))
                                                <a href="#">
                                                    <img src="{{ asset('storage/avatars')}}/{{$user->avatar}}"
                                                    class="img-fluid rounded-circle align-middle user-avatar">
                                                </a>
                                                @else
                                                <a href="#">
                                                    <img src="{{$user->avatar}}"
                                                    class="img-fluid rounded-circle align-middle user-avatar">
                                                </a>
                                                @endif

                                            </div> --}}
                                            <div class="col-sm-7">
                                                <div class="h5 font-weight-bold text-primary text-uppercase mb-1">
                                                    <a href="{{ route('viewByCategory', ['id' => $category->id]) }}">
                                                        {{$category->name}}
                                                    </a>
                                                </div>
                                                <div class="mb-0 text-muted">{{$category->questions()->count()}} câu hỏi</div>
                                               
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                            <div class="row px-3 pt-3 justify-content-sm-center">{!! $categories->links() !!}</
                            </div>

                        </div>
                    </div>
                    <hr>

                </div>
            </div>
        </div>

    </main>
    @endsection