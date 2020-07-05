<div class="card ml-2 col-sm-3">

    <div class="card-header text-center" style="background-color: white">
        @if(Auth::check())
        <div class="col-sm-0.5">
            <!-- start add button block -->
            <a href="{{route('addTopic')}}" class="btn btn-primary btn-block font-weight-bold">Đặt câu hỏi</a>
            <!-- end add button block -->
        </div>
        @endif
    </div>

    {{-- <div class="col-12" style="background-color: #000000">
				<div class="col-1"></div>
				<div class="col-10" style="background-color: white">
					<div class="col">col</div>
					<div class="col">col</div>
					<div class="w-100"></div>
					<div class="col">col</div>
					<div class="col">col</div>
				</div>
				<div class="col-1"></div>

			</div> --}}
            <!-- QuyTran added 23/10/2019 -->
    {{-- <div class="container p-4">
        <div class="row text-center" style="font-size: 11px">
            <div class="col-sm-2"></div>
            <div class="col-sm-4 border border-primary p-4">
                <b class="text-primary">Questions</b>
                <br />
                <b style="font-size: 30px">69</b>
            </div>
            <div class="col-sm-4 border border-danger p-4">
                <b class="text-danger">Answers</b>
                <br />
                <b style="font-size: 30px">123</b>
            </div>

            <div class="col-sm-2"></div>
        </div>
        <div class="row text-center" style="font-size: 11px">
            <div class="col-sm-2"></div>
            <div class="col-sm-4 border border-success p-4">
                <b class="text-success">Best Answers</b>
                <br />
                <b style="font-size: 30px">69</b>
            </div>
            <div class="col-sm-4 border border-info p-4">
                <b class="text-info">Users</b>
                <br />
                <b style="font-size: 30px">123</b>
            </div>
            <div class="col-sm-2"></div>
        </div>
    </div> --}}
    <!-- QuyTran end add -->

    <!--QuyTran added 22/10/2019 -->
    <div>
        <h6 class="font-weight-bold ml-3 mt-4"><i class="fa fa-users mr-3"></i>Thành viên nổi bật</h6>
        <br />
        @foreach($topMembers as $topMember)
        <div class="row px-2 pt-1 pb-1">
            <br />
            @if(is_file('storage/avatars/'.$topMember->avatar))
            <div class="col-sm-3">

                <a href="/personalinfomation/{{ $topMember->_id }}" class="text-decoration-none"><img src="{{ asset('storage/avatars')}}/{{$topMember->avatar}}"
                class="img-fluid rounded-circle align-middle user-avatar"></a>
            </div>
            @else
            <div class="col-sm-3">

                 <a href="/personalinfomation/{{ $topMember->_id }}" class="text-decoration-none"><img src="{{$topMember->avatar}}"
                class="img-fluid rounded-circle align-middle user-avatar"></a>
            </div>
            @endif
            <br />

            <div class="col-sm-9">
                <div class="row">
                    <a class="" href="/personalinfomation/{{ $topMember->_id }}">
                        <small class="font-weight-bold" style="color:#5488c7;">{{$topMember->fullname}}</small>
                    </a>
                </div>

                <div class="row">
                    <small class="text-muted pr-2" style="color:#5488c7;">
                        {{$topMember->questions->count()}} câu hỏi
                    </small>
                    <small class="text-muted pr-2" style="color:#5488c7;">
                       -
                    </small>
                    <small class="text-muted pr-1" style="color:#5488c7;">
                        {{$topMember->answers->count()}} trả lời
                    </small>
                </div>
            </div>

        </div>
        <hr>
        @endforeach
        
    </div>

    <div>
        <h6 class="font-weight-bold ml-3 mt-4"><i class="fa fa-tags mr-3"></i>Tags nổi bật</h6>
        <div class="col-sm-12">
            @foreach($categories as $category)
            <div class="row">
                <div class="pl-2 py-2">
                    <a href="{{ route('viewByCategory', ['id' => $category->id]) }}" class="border text-primary p-1 bg-light rounded ">
                        {{$category->name}}
                    </a>
                    <small class="px-2">x </small>
                    <small>{{$category->questions()->count()}}</small>
                </div>
            </div>
            @endforeach

           {{--  <div class="row">
                <div class="pl-2 py-2">
                    <a href="#" class="border text-primary p-1 bg-light rounded ">
                        asp.net
                    </a>
                    <small class="px-2">x </small>
                    <small>12369</small>
                </div>
            </div>

            <div class="row">
                <div class="pl-2 py-2">
                    <a href="#" class="border text-primary p-1 bg-light rounded ">
                        Python
                    </a>
                    <small class="px-2">x </small>
                    <small>15246349</small>
                </div>
            </div>

            <div class="row">
                <div class="pl-2 py-2">
                    <a href="#" class="border text-primary p-1 bg-light rounded ">
                        Python
                    </a>
                    <small class="px-2">x </small>
                    <small>15246349</small>
                </div>
            </div>
            <div class="row">
                <div class="pl-2 py-2">
                    <a href="#" class="border text-primary p-1 bg-light rounded ">
                        Python
                    </a>
                    <small class="px-2">x </small>
                    <small>15246349</small>
                </div>
            </div>
            <div class="row">
                <div class="pl-2 py-2">
                    <a href="#" class="border text-primary p-1 bg-light rounded ">
                        Python
                    </a>
                    <small class="px-2">x </small>
                    <small>15246349</small>
                </div>
            </div> --}}
        </div>
    </div>
    <!--QuyTran end add-->
</div>