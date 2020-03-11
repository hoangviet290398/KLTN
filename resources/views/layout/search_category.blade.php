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
                                                <div class="mb-0 text-muted">{{$category->questions()->count()}} Questions</div>
                                                
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>