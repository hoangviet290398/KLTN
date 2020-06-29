@extends('layout.master')
@section('title','TechSolution - Connect, Learn and Share')
@section('content')

<main>

    <img src="{{ asset('images/resource/slogan.png') }}" style="height:15%;width: 100%" alt="placeholder+image">



    <div class="mt-1 d-flex justify-content-center">
        @include('layout.leftpanel')
        <div class="card col-7">
            <div class="card-header text-center" style="background-color: white">
                <ul class="nav nav-pills font-weight-bold">
                    <li class="nav-item">
                        <a class="nav-link" href="/">Câu hỏi gần đây</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link " href="mostanswered">Nhiều câu trả lời nhất</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link " href="noanswers">Chưa có câu trả lời</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="week">Tuần</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="month">Tháng</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="year">Năm</a>
                    </li>
                </ul>
                <br />
                <h5 class="text-left">{{number_format($questions->count())}} câu hỏi</h5>
            </div>
            <div class="card-body p-0">
                @foreach($questions as $question)
                <div class="row px-3 pt-3">
                    @if(is_file('storage/avatars/'.$question->user->avatar))
                    <div class="col-sm-1"><a href="/personalinfomation/{{ $question->user->_id }}"
                            class="text-decoration-none"><img
                                src="{{ asset('storage/avatars')}}/{{$question->user->avatar}}"
                                class="img-fluid rounded-circle align-middle user-avatar"></a></div>
                    <div class="col-sm-11">
                        @else
                        <div class="col-sm-1"><a href="/personalinfomation/{{ $question->user->_id }}"
                                class="text-decoration-none"><img src="{{$question->user->avatar}}"
                                    class="img-fluid rounded-circle align-middle user-avatar"></a></div>
                        <div class="col-sm-11">
                            @endif
                            <a href="/personalinfomation/{{ $question->user->_id }}" class="text-decoration-none">
                                <small class="font-weight-bold"
                                    style="color:#5488c7;">{{$question->user->fullname}}</small>
                            </a>
                            <small class="text-muted pl-4" style="color:#5488c7;" data-toggle="tooltip"
                                title="{{$question->created_at->toDayDateTimeString()}}">đã hỏi:
                                {{$question->created_at->diffForHumans()}}
                            </small>
                            <br>
                            <div class="row">
                                <div class="col-12">
                                    <div class="word-wrap">
                                        <a href="topic/{{ $question->id }}" class="text-decoration-none">
                                            <h5>{{$question->title}}</h5>
                                        </a></div>


                                </div>
                                <!-- <div class="col-2">
                                <small
                                    class="float-right border rounded-pill text-primary bg-light p-2 font-weight-bold">{{$question->category->name}}</small>
                            </div> -->
                            </div>

                            <p class="pv-archiveText">{{$question->content}}</p>
                            <!-- QuyTran added -->
                            <div class="row">
                                <div class="pl-3 pt-1 pb-3">
                                    <a href="{{ route('viewByCategory', ['id' => $question->category->id]) }}"
                                        class="border text-muted p-1 rounded text-decoration-none">
                                        {{$question->category->name}}
                                    </a>

                                </div>
                            </div>
                            <!-- QuyTran end add -->
                            <div class="ml-3">
                                @include('layout.like_dislike')
                            </div>

                        </div>

                    </div>
                    <hr>
                    @endforeach
                    <div class="row px-3 pt-3 justify-content-sm-center">{!! $questions->links() !!}</div>
                </div>
            </div>
            @include('layout.rightpanel')

</main>
@endsection