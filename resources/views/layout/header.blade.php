<nav class="navbar navbar-expand-lg navbar-light shadow sticky-top"
    style="background-color: rgb(39, 41, 48); height:80px">
    <div class="container">
        <div class="row">
            <div class="col-sm">
                <!-- start logo block -->
                <a class="navbar-brand" href="{{ route('homePage') }}"><b style="font-size:20px;color:white">
                        <img src="{{ asset('images/resource/logo2a.png') }}" width="40px"> TechSolution</b></a>
                <button class="navbar-toggler" type="button" data-toggle="collapse"
                    data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                    aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <!-- end logo block -->
            </div>



            <nav class="navbar navbar-expand-lg navbar-light" style="background-color: rgb(39, 41, 48)">

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav mr-auto">
                        <li class="nav-item active">
                            <a class="nav-link text-light header" href="{{ route('homePage') }}">Trang chủ <span
                                    class="sr-only">(current)</span></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-light header" href="{{route('aboutUs')}}">Về chúng tôi</a>
                        </li>


                        <!-- start collapse block -->
                        <div class="collapse navbar-collapse" id="navbarSupportedContent">
                            <div class="d-flex justify-content-start" style="width:100%">
                                <div class="col-12">

                                    <!-- start search block -->
                                    <form id="searchform" class="form-inline-xs" action="{{ route('searchIndex') }}"
                                        method="get">
                                        <div class="input-group form-control-sm">
                                            @if(isset($keyword))
                                            <input id="search" name="keyword" class="form-control form-control-sm"
                                                type="search" placeholder="Nhập từ khóa tìm kiếm..." title="enter your keyword"
                                                autocomplete="off" value="{{$keyword}}">
                                            @else
                                            <input id="search" name="keyword" class="form-control form-control-sm"
                                                type="search" placeholder="Nhập từ khóa tìm kiếm..." title="enter your keyword"
                                                autocomplete="off">
                                            @endif
                                            <div id="result_list" class="scrollbar scrollbar-lady-lips dropdown-menu">
                                            </div>
                                            {{--    <div class="input-group-prepend">
                                        <button class="btn bg-light font-weight-bold form-control-sm" type="button"
                                        onclick="submit_search()">
                                        <i class="fa fa-search"></i>
                                    </button>
                                </div> --}}
                                        </div>
                                    </form>
                                    <!-- end search block -->

                                </div>
                                @if(Auth::check())
                                {{--   <div class="col-0.5">
                        <!-- start add button block -->
                        <a href="{{route('addTopic')}}" class="btn btn-outline-secondary"><i
                                    class="fa fa-plus"></i></a>
                                <!-- end add button block -->
                            </div> --}}
                            <div class="col-0.5">

                                <!-- start notification block -->
                                <div class="nav-item dropdown no-arrow ">
                                    <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button"
                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                                        onclick="read_notification()">
                                        <i class="fa fa-bell" style="color: white"></i>
                                        @if(Auth::user()->notifications()->where('is_read',false)->count())
                                        <span
                                            class="badge badge-danger badge-counter">{{Auth::user()->notifications->where('is_read',false)->count()}}</span>

                                        @else

                                        @endif
                                        <!-- Counter - Alerts -->

                                    </a>

                                    <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                        aria-labelledby="">

                                        <h6 class="dropdown-header bg-primary" style="color:white">
                                            Notification
                                        </h6>
                                        <div class="scrollbar">
                                            @foreach(Auth::user()->notifications()->orderBy('created_at', 'DESC')->get()
                                            as $notification)
                                            <a class="dropdown-item d-flex align-items-center noti_item"
                                                href="/topic/{{ $notification->question_id }}"
                                                style="border-width: 1px; border-bottom-style: solid; border-color: #b2bec3;">
                                                @if(is_file('storage/avatars/'.$notification->actor()->first()->avatar))
                                                <img src="{{ asset('storage/avatars')}}/{{$notification->actor()->first()->avatar}}"
                                                    class="dot mr-4">
                                                @else
                                                <img src="{{$notification->actor()->first()->avatar}}" class="dot mr-4">
                                                @endif

                                                <div>



                                                    <div class="small text-gray-500" style="font-size: 10px">
                                                        {{ $notification->created_at->toDayDateTimeString() }}</div>
                                                    <span class="font-weight-bold"
                                                        style="color:#1e3799;font-size: 13px">
                                                        {{ $notification->actor()->first()->fullname.' '.$notification->action.' your '.$notification->target }}</span>

                                                </div>

                                            </a>

                                            @endforeach
                                        </div>

                                    </div>
                                    <!-- Message -->

                                </div>
                                <!-- end notification block -->
                            </div>

                            <ul class="navbar-nav mr-auto"></ul>

                            <div class="col-0.5 py-2">
                                <a href="/messages" style="color:white"><i class="fa fa-envelope"></i></a>
                            </div>
                            <!-- start user menu block -->

                            <div class="col-3 pt-2 ml-5">
                                <b class="text-light header">{{ Auth::user()->fullname }}</b>
                            </div>
                            <div class="col-0.5">
                                <div class="nav-item dropdown">
                                    @if(is_file('storage/avatars/'.Auth::user()->avatar))

                                    <a href="" class="nav-link dropdown-toggle text-light" id="setting" role="button"
                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <img
                                            class="dot"
                                            src="{{ asset('storage/avatars')}}/{{Auth::user()->avatar}}"></a>
                                    @else
                                    <a href="" class="nav-link dropdown-toggle text-light" id="setting" role="button"
                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <img
                                            class="dot" src="{{Auth::user()->avatar}}"></a>
                                    @endif
                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="setting">
                                        <a class="dropdown-item" href="{{ route('information') }}">
                                            <i class="fa fa-cog" style="width:20px"></i>
                                            Hồ sơ cá nhân
                                        </a>
                                        <a class="dropdown-item" href="{{ route('manageQuestion') }}">
                                            <i class="fa fa-comments-o" style="width:20px"></i>
                                            Câu hỏi của bạn
                                        </a>
                                        <a class="dropdown-item" href="{{ route('manageAnswer') }}">
                                            <i class="fa fa-lightbulb-o" style="width:20px"></i>
                                            Câu trả lời của bạn
                                        </a>
                                        <div class="dropdown-divider"></div>
                                        <form action="{{ route('logOut') }}" method="post">
                                            @csrf
                                            <button type="submit" class="dropdown-item">
                                                <i class="fa fa-sign-out" style="width:20px"></i>
                                                Đăng xuất
                                            </button>
                                        </form>

                                    </div>
                                </div>
                            </div>

                            <!-- end user menu block -->
                            @else
                            <div class="col-sm-6 mt-1 ml-4">
                                <!-- start sign in or sign up block -->
                                <ul class="navbar-nav mr-auto"></ul>
                                <a href="{{route('signInIndex')}}"
                                    class="btn btn-primary btn-sm font-weight-bold pl-3 pr-3">Sign in</a>
                                <a href="{{route('signUp')}}"
                                    class="btn btn-outline-secondary ml-3 btn-sm font-weight-bold pl-3 pr-3"
                                    style="color: white">Sign up</a>
                                <!-- end sign in or sign up block -->
                            </div>
                            @endif

                        </div>
                </div>
        </div>

        </ul>
    </div>
</nav>


</nav>