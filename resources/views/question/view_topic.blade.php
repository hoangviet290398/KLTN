@extends('layout.master')

@section('title','View topic')
@php
use App\LikeDislike;
@endphp

@section('js')
<script>
    $('#fileUpload').fileinput({
        allowedFileExtensions: ['zip', 'rar'],
        theme: 'fa',
        uploadAsync: false,
        showUpload: false,
        maxFileSize: 5120,
        removeClass: 'btn btn-warning'
    });

    var simplemde = new SimpleMDE({
        element: document.getElementById("markdown")
    });

    function checkContent() {
        if (simplemde.value() != "") {
            document.getElementById("addanswer").submit();
        }
    }

    $('#large_like').click('#like_button', function () {
            var question_id = $(this).data("value");
            var post_type = "Question";
          
            if (question_id != '') {
                $.ajax({
                    url: "{{ route('like') }}",
                    method: "GET",
                    data: {
                        question_id,
                        post_type
                    },
                    success: function (data) {
                        data = $.parseJSON(data);
                        
                        if(data.status == true){
                                                            
                            $("#large_like").load(location.href + " #large_like"); 
                            $("#large_dislike").load(location.href + " #large_dislike");                                                                                            
                        }
                        else{
                            
                        }
                    }
                })
            }
            else{
               alert('false');
            }
        });

    $('#large_dislike').click('#dislike_button', function () {
            var question_id = $(this).data("value");
            var post_type = "Question";
            console.log(question_id);
          
            if (question_id != '') {
                $.ajax({
                    url: "{{ route('dislike') }}",
                    method: "GET",
                    data: {
                        question_id,
                        post_type
                    },
                    success: function (data) {
                        data = $.parseJSON(data);
                        
                        if(data.status == true){
                                                            
                            $("#large_dislike").load(location.href + " #large_dislike");
                            $("#large_like").load(location.href + " #large_like");                                                                                              
                        }
                        else{
                            
                        }
                    }
                })
            }
            else{
               alert('false');
            }
        });

    $('#large_like_bestanswer').click('#like_bestanswer_button', function () {
            var question_id = $(this).data("value");
            var post_type = "Answer";
            
            if (question_id != '') {
                $.ajax({
                    url: "{{ route('like') }}",
                    method: "GET",
                    data: {
                        question_id,
                        post_type
                    },
                    success: function (data) {
                        data = $.parseJSON(data);
                        
                        if(data.status == true){
                                                            
                            $("#large_like_bestanswer").load(location.href + " #large_like_bestanswer"); 
                            $("#large_dislike_bestanswer").load(location.href + " #large_dislike_bestanswer");                                                                                            
                        }
                        else{
                            
                        }
                    }
                })
            }
            else{
               alert('false');
            }
        });

    $('#large_dislike_bestanswer').click('#dislike_bestanswer_button', function () {
            var question_id = $(this).data("value");
            var post_type = "Answer";
          
            if (question_id != '') {
                $.ajax({
                    url: "{{ route('dislike') }}",
                    method: "GET",
                    data: {
                        question_id,
                        post_type
                    },
                    success: function (data) {
                        data = $.parseJSON(data);
                        
                        if(data.status == true){
                                                            
                            $("#large_dislike_bestanswer").load(location.href + " #large_dislike_bestanswer"); 
                            $("#large_like_bestanswer").load(location.href + " #large_like_bestanswer");                                                                                            
                        }
                        else{
                            
                        }
                    }
                })
            }
            else{
               alert('false');
            }
        });


    $('#large_like_answer').click('#like_answer_button', function () {
            var question_id = $(this).data("value");
            var post_type = "Answer";
            console.log(question_id);
            if (question_id != '') {
                $.ajax({
                    url: "{{ route('like') }}",
                    method: "GET",
                    data: {
                        question_id,
                        post_type
                    },
                    success: function (data) {
                        data = $.parseJSON(data);
                        
                        if(data.status == true){
                                                            
                            $("#large_like_answer").load(location.href + " #large_like_answer"); 
                            $("#large_dislike_answer").load(location.href + " #large_dislike_answer");                                                                                            
                        }
                        else{
                            
                        }
                    }
                })
            }
            else{
               alert('false');
            }
        });

    $('#large_dislike_answer').click('#dislike_answer_button', function () {
            var question_id = $(this).data("value");
            var post_type = "Answer";
            console.log(question_id);
            if (question_id != '') {
                $.ajax({
                    url: "{{ route('dislike') }}",
                    method: "GET",
                    data: {
                        question_id,
                        post_type
                    },
                    success: function (data) {
                        data = $.parseJSON(data);
                        
                        if(data.status == true){
                                                            
                            $("#large_dislike_answer").load(location.href + " #large_dislike_answer"); 
                            $("#large_like_answer").load(location.href + " #large_like_answer");                                                                                            
                        }
                        else{
                            
                        }
                    }
                })
            }
            else{
               alert('false');
            }
        });

    // 




    var containers = document.getElementsByClassName("image-markdown");
    for (index_container = 0; index_container < containers.length; index_container++) {
        var imgs = containers[index_container].getElementsByTagName("IMG");
        for (index_img = 0; index_img < imgs.length; index_img++) {
            imgs[index_img].setAttribute("class", "h-100 w-100");
        }
    }

</script>
@endsection

@section('content')
<div class="mt-1 d-flex justify-content-center" >
@include('layout.leftpanel')
<div class="card col-7">

    <!-- Start Question Block -->
    <div class="">
        <div class="row px-3 pt-3">
            @if(is_file('storage/avatars/'.$question->user->avatar))

            <div class="col-sm-1"><a href="/personalinfomation/{{ $question->user->_id }}" class="text-decoration-none"><img src="{{ asset('storage/avatars')}}/{{$question->user->avatar}}"
                    class="user-avatar rounded-circle align-middle"></a></div>
            @else
             <div class="col-sm-1"><a href="/personalinfomation/{{ $question->user->_id }}" class="text-decoration-none"><img src="{{$question->user->avatar}}"
                    class="user-avatar rounded-circle align-middle"></a></div>
            @endif
            <!-- Start Username, Date, Edit, Delete Block -->
            <div class="col-sm-11">
                <div class="font-weight-bold">
                    <a href="/personalinfomation/{{ $question->user->_id }}" style="color:#787878; font-size: 20px">{{$question->user->fullname}}</a>
                    <!-- Button HTML (to Trigger Modal) -->
                    @if((Auth::check()) and ($question->user_id==Auth::user()->id))
                        <a href="#myModal" data-toggle="modal">
                            <i class="float-right fa fa-trash" aria-hidden="true"
                                style="margin-right:10px; font-size: 15px; "></i></a>
                        <!-- Modal HTML -->
                        <div id="myModal" class="modal fade" tabindex="-1">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Confirmation</h5>
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    </div>
                                    <div class="modal-body">
                                        <p>Are you sure you want to delete this topic?</p>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                        <form action="{{route('deleteTopic')}}" method="post">
                                            @csrf
                                            <input type="text" name="_id" value="{{$question->id}}" hidden>
                                            <button type="submit" class="btn btn-danger">Delete</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <a href="{{asset('edittopic')}}/{{ $question->id }}"><i class="float-right fa fa-pencil-square-o"
                                aria-hidden="true" style="margin-right:10px; font-size:15px"></i></a>
                    @endif

                </div>
                <div>
                    <small class="text-muted" style="color:#5488c7;" data-toggle="tooltip" title="{{$question->created_at->toDayDateTimeString()}}">
                        <i class="fa fa-clock-o" aria-hidden="true"> </i>
                        {{$question->created_at->diffForHumans()}}
                    </small>
                </div>
                <br>
            </div>
            <!-- End Username, Date, Edit, Delete Block -->

            <!-- Start Question Title Block -->
            <div class="col-sm-12">
                <h3 class="text-primary font-weight-bold d-flex justify-content-sm-between">
                    <div style="max-width:950px">{{$question->title}}</div>
                    <a href="{{ route('viewByCategory', ['id' => $question->category->id]) }}"><span class="badge badge-info d-flex" style="height: 32px">{{$question->category->name}}</span></a>
                </h3>
                   <hr style="border-width: 1px; border-style: solid; border-color: #b2bec3;">
            </div>
            <!-- End Question Title Block -->



            <!-- Start Question Content Block -->
            <div class="col-sm-12 px-3" id="big">
                <div class="image-markdown">{!! $question->content !!}</div>
                @if($question->attachment_path)
                <b class="badge badge-warning">Attachment:</b>
                <a
                    href="{{asset('storage/files/'.$question->attachment_path)}}"><i>{{$question->attachment_path}}</i></a>

                @endif
                <div class="row" id="large"
                    style="width: 500px; color:#787878; font-size: 20px; margin-bottom: 10px; margin-left: 5px;">
                    <div class="col-xs" style="width:70px" id="large_like" data-value="{{$question->id}}">
                        @if (Auth::check())
                            @if(LikeDislike::where('post_id',$question->id)->where('user_id',Auth::user()->id)->where('action','Like')->count()!= 0)
                           
                                {{-- <input type="text" id="question_id" value="{{$question->id}}" hidden> --}}
                               <i class="fa fa-thumbs-up" style="color: blue;" id="like_button"></i>
                                {{$question->total_like}}
                            @else
                                <i class="fa fa-thumbs-up" style="color: #787878;" id="like_button"></i>
                                {{$question->total_like}}
                            @endif

                        @else
                            <i class="fa fa-thumbs-up" style="color:#787878"></i>
                            {{$question->total_like}}
                        @endif
                    </div>
                    <div class="col-xs" style="width:70px" id="large_dislike" data-value="{{$question->id}}">
                        @if (Auth::check())

                            @if(LikeDislike::where('post_id',$question->id)->where('user_id',Auth::user()->id)->where('action','Dislike')->count()!= 0)
                             <i class="fa fa-thumbs-down" style="color: red;" id="dislike_button"></i>
                                {{$question->total_dislike}}
                            @else
                                <i class="fa fa-thumbs-down" style="color: #787878;" id="dislike_button"></i>
                                {{$question->total_dislike}}
                            @endif

                        @else
                            <i class="fa fa-thumbs-down" style="color:#787878"></i>
                            {{$question->total_dislike}}
                        @endif
                    </div>
                    <div class="col-xs" style="width:70px">
                        <i class="fa fa-comment"></i> {{$question->total_answer}}
                    </div>
                </div>
            </div>
            <!-- End Question Content Block -->
        </div>
    </div>
    <!-- End Question Block -->


    <!-- Start Insert Answer Block -->
    @if (Auth::check())
    <div class="" style="margin-top: 20px;">
        <div class="card-body">
            @foreach($errors->all() as $error)
                <div class="alert alert-danger">{{ $error }}</div>
            @endforeach
            @if(Session::has('errorUpload'))
                <div class="alert alert-danger">{{ Session::get('errorUpload') }}</div>
            @endif
            <form id="addanswer" method="post" action="{{route('addAnswer')}}" enctype="multipart/form-data">
                @csrf
                <input type="text" name="question_id" hidden value="{{$question->_id}}">
                <div class="form-group">
                   
                    <div class="row">
                       
                        <div class="col-sm-12">
                            <textarea id="markdown" name="content"></textarea>
                        </div>
                    </div>
                     <div class="row">
                         <div class="col-sm-12">
                            <div class="file-loading">
                                <input id="fileUpload" name="attachment" type="file">
                            </div>
                        </div>
                    </div>
                </div>
                <button onclick="checkContent()" type="button" class="btn btn-primary float-right">Answer</button>
            </form>
        </div>
    </div>
    @endif
    <!-- End Insert Answer Block -->

    <!-- Start Answer Block -->
    <div class="" style="margin-top: 20px; margin-bottom: 20px; " id="answer_block">
        <div class="card-header">
            <h3><i class="fa fa-angle-double-right"></i> Answers:</h3>
        </div>

        <!-- Start Best Answer Block -->
        @if ($bestAnswer!=null)
        <div class="row px-3 pt-3">
            <div class="col-1">
                @if(is_file('storage/avatars/'.$bestAnswer->user->avatar))
                <a href="/personalinfomation/{{ $bestAnswer->user->_id }}" class="text-decoration-none"><img src="{{ asset('storage/avatars')}}/{{$bestAnswer->user->avatar}}" class="user-avatar rounded-circle align-middle"></a>
                @else
                 <a href="/personalinfomation/{{ $bestAnswer->user->_id }}" class="text-decoration-none"><img src="{{$bestAnswer->user->avatar}}" class="user-avatar rounded-circle align-middle"></a>
                @endif
                <br>
                <br>
                <div class="d-flex" style="justify-content :center; align-items:center;  font-size:200%; color:#66ad1f">
                    <i class="fa fa-check" aria-hidden="true"></i>
                </div>
            </div>
            <div class="col-sm-11">
                <div class="float-left">
                <a href="/personalinfomation/{{ $bestAnswer->user->_id }}" style="color:#787878; font-size: 20px">{{$bestAnswer->user->fullname}}</a>
                <br>
                    <small class="text-muted" style="color:#5488c7;" data-toggle="tooltip" title="{{$bestAnswer->created_at->toDayDateTimeString()}}">
                        <i class="fa fa-clock-o" aria-hidden="true"> </i>
                        {{$bestAnswer->created_at->diffForHumans()}}
                    </small>
                </div>

                @if (Auth::check() and (Auth::user()->id==$bestAnswer->user_id))
                    <a href="{{asset('editanswer')}}/{{ $bestAnswer->id }}">
                        <i class="float-right fa fa-pencil-square-o ml-2" aria-hidden="true" style="font-size:15px"></i>
                    </a>
                @endif
                <br>
                <br>
                <br>
                <div class="image-markdown" style="padding-right: 58px;">{!! $bestAnswer->content !!}</div>
                @if($bestAnswer->attachment_path)
                    <b class="badge badge-warning">Attachments:</b>
                    <a href="{{asset('storage/files/'.$bestAnswer->attachment_path)}}"><i>{{$bestAnswer->attachment_path}}</i></a>
                @endif
                <div class="row" style=" color:#787878; font-size: 20px ; margin-bottom: 10px">
                    <div class="col-1"  id="large_like_bestanswer" data-value="{{$bestAnswer->id}}">
                        @if(Auth::check())
                            @if(LikeDislike::where('post_id',$bestAnswer->id)->where('user_id',Auth::user()->id)->where('action','Like')->count()!= 0)
                              
                                <i class="fa fa-thumbs-up" style="color: blue;" id="like_bestanswer_button"></i> {{$bestAnswer->total_like}}
                            @else
                                <input type="text" id="bestanswer_id" value="{{$bestAnswer->id}}" hidden>
                                <i class="fa fa-thumbs-up" style="color: #787878;" id="like_bestanswer_button"></i> {{$bestAnswer->total_like}}
                            @endif
                        @else
                            <i class="fa fa-thumbs-up" style="color:#787878"></i>
                            {{$bestAnswer->total_like}}
                        @endif
                    </div>
                    <div class="col-1" id="large_dislike_bestanswer" data-value="{{$bestAnswer->id}}">
                        @if(Auth::check())
                            @if(LikeDislike::where('post_id',$bestAnswer->id)->where('user_id',Auth::user()->id)->where('action','Dislike')->count()!= 0)
                               
                                <i class="fa fa-thumbs-down" style="color: red;" id="dislike_bestanswer_button"></i> {{$bestAnswer->total_dislike}}
                            @else
                              
                                <i class="fa fa-thumbs-down" style="color: #787878;" id="dislike_bestanswer_button"></i> {{$bestAnswer->total_dislike}}
                            @endif
                        @else
                            <i class="fa fa-thumbs-down" style="color:#787878"></i>
                            {{$bestAnswer->total_dislike}}
                        @endif
                    </div>
                    @if (Auth::check() and (Auth::user()->id==$question->user_id))
                        <div class="col-10 justify-content-sm-end">

                            <a href="{{asset('removebestanswer')}}/{{$bestAnswer->_id}}"><button type="button"
                                    class="float-right btn btn-warning">Remove Best Answer</button></a>
                                   {{--  <input type="text" id="remove_bestanswer_id" value="{{$bestAnswer->_id}}" hidden>
                                   <button type="button" id="remove_bestanswer_button" 
                                    class="float-right btn btn-warning">Remove Best Answer
                                   </button> --}}
                        </div>
                    @endif
                </div>
            </div>
        </div>
        <hr>
        @endif
        <!-- End Best Answer Block -->

        <!-- Start Other Answers Block -->
        @foreach($answers as $answer)

            @if (($bestAnswer==null) or (($bestAnswer!=null) and ($answer->_id!=$bestAnswer->_id)))
                <div class="row px-3 pt-3">
                    <div class="col-sm-1">
                        @if(is_file('storage/avatars/'.$answer->user->avatar))
                         <a href="/personalinfomation/{{ $answer->user->_id }}" class="text-decoration-none"><img src="{{asset('storage/avatars')}}/{{$answer->user->avatar}}"
                            class="user-avatar rounded-circle align-middle"></a>
                        @else
                        <a href="/personalinfomation/{{ $answer->user->_id }}" class="text-decoration-none"><img src="{{$answer->user->avatar}}"
                            class="user-avatar rounded-circle align-middle"></a>
                        @endif
                        <br>
                        <br>
                        @if ($question->bestAnswer_id == $answer->_id)
                            <div class="d-flex" style="justify-content :center; align-items:center;  font-size:200%; color:#66ad1f">
                                <i class="fa fa-check" aria-hidden="true"></i>
                            </div>
                        @endif
                    </div>
                    <div class="col-sm-11">
                        <div class="float-left">
                            <a href="/personalinfomation/{{ $answer->user->_id }}" style="color:#787878; font-size: 20px">{{$answer->user->fullname}}</a>
                            <br>
                            <small class="text-muted" style="color:#5488c7;" data-toggle="tooltip" title="{{$answer->created_at->toDayDateTimeString()}}">
                                <i class="fa fa-clock-o" aria-hidden="true"> </i>
                                {{$answer->created_at->diffForHumans()}}
                            </small>
                        </div>

                        @if (Auth::check() and (Auth::user()->id==$answer->user_id))
                       
                            <a href="{{asset('editanswer')}}/{{ $answer->id }}"><i class="float-right fa fa-pencil-square-o ml-2"
                                aria-hidden="true" style="font-size:15px"></i> </a>
                        
                        @endif
                        <br>
                        <br>
                        <br>
                        <div class="image-markdown" style="padding-right: 58px;">{!! $answer->content !!}</div>
                        @if($answer->attachment_path)
                            <b class="badge badge-warning">Attachments:</b>
                            <a
                                href="{{asset('storage/files/'.$answer->attachment_path)}}"><i>{{$answer->attachment_path}}</i></a>
                        @endif
                        <div class="row" style=" color:#787878; font-size: 20px ; margin-bottom: 10px">
                            <div class="col-1" id="large_like_answer" data-value="{{$answer->id}}">
                                @if(Auth::check())
                                    @if(LikeDislike::where('post_id',$answer->id)->where('user_id',Auth::user()->id)->where('action','Like')->count()!= 0)
                                       
                                        <i class="fa fa-thumbs-up" style="color: blue;" id="like_answer_button"></i> {{$answer->total_like}}
                                    @else
                                       
                                        <i class="fa fa-thumbs-up" style="color: #787878;" id="like_answer_button"></i> {{$answer->total_like}}
                                    @endif
                                @else
                                        <i class="fa fa-thumbs-up" style="color:#787878"></i>
                                        {{$answer->total_like}}
                                @endif
                            </div>
                            <div class="col-1" id="large_dislike_answer" data-value="{{$answer->id}}">
                                @if(Auth::check())
                                    @if(LikeDislike::where('post_id',$answer->id)->where('user_id',Auth::user()->id)->where('action','Dislike')->count()!= 0)
                                      
                                        <i class="fa fa-thumbs-down" style="color: red;" id="dislike_answer_button"></i> {{$answer->total_dislike}}
                                    @else
                                       
                                        <i class="fa fa-thumbs-down" style="color: #787878;" id="dislike_answer_button"></i> {{$answer->total_dislike}}
                                    @endif
                                @else
                                        <i class="fa fa-thumbs-down" style="color:#787878"></i>
                                        {{$answer->total_dislike}}
                                @endif
                            </div>
                            @if (Auth::check() and(Auth::user()->id==$question->user_id))                  
                                <div class='col-10 justify-content-sm-end'>
                                    <a href="{{asset('bestanswer')}}/{{$answer->_id}}"><button type="button"
                                            class="float-right btn btn-success">Best Answer</button></a>
                                    {{-- <input type="text" id="vote_bestanswer_id" value="{{$answer->id}}" hidden>
                                    <button type="button" id="vote_bestanswer_button" 
                                            class="float-right btn btn-success">Best Answer</button> --}}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                <hr>
            @endif
        @endforeach
        <div class="row px-3 pt-3 justify-content-sm-center">{!! $answers->links() !!}</div>
    </div>

</div>
@include('layout.rightpanel')
</div>
@endsection
