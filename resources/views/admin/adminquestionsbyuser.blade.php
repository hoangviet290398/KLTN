 <div class="card-header text-center" style="background-color: white">
                <ul class="nav nav-pills font-weight-bold" >
                    <li class="nav-item">
                        <a class="nav-link active" href="{{ route('manageQuestionsByUser', ['id' => $created_by->id]) }}">Câu hỏi</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('manageAnswersByUser', ['id' => $created_by->id]) }}">Trả lời</a>
                    </li>
                   
                </ul>
                <br/>
                <h5 class="text-left">{{number_format($questions->count())}} câu hỏi</h5>
            </div>

<div class="py-2"></div>
<div class="row">

   
    <div class="col-sm-12">

        <div class="card text-center">
            <div class="card-header">
                <div class="row">
                               <div class="col-sm-1 pr-2">
                                            @if(is_file('storage/avatars/'.$created_by->avatar))
                                            <a href="#">
                                                <img src="{{ asset('storage/avatars')}}/{{$created_by->avatar}}"
                                                    class="img-fluid rounded-circle align-middle user-avatar">
                                            </a>
                                            @else
                                            <a href="">
                                                <img src="{{$created_by->avatar}}"
                                                    class="img-fluid rounded-circle align-middle user-avatar">
                                            </a>
                                            @endif

                                        </div>
                <div class="col-sm-11">
               <h3 class="text-center mt-3" style=" color:#777;letter-spacing: 10px; "><b>QUẢN LÝ CÂU HỎI</b></h3>
                <h5>Tạo bởi <b>{{$created_by->fullname}}</b></h5>
                </div>
                </div>
            </div>
            <div class="card-body">
               
                <div class="row">
                    <div class="col-sm-3">
                        <h5>Tiêu đề</h5>
                    </div>
                   
                   
                    <div class="col-sm-1">
                        <h5>Tag</h5>
                    </div>
                    <div class="col-sm-1">
                        <h5>Lượt thích</h5>
                    </div>
                    <div class="col-sm-1">
                        <h5>Lượt không thích</h5>
                    </div>
                    <div class="col-sm-1">
                        <h5>Tổng câu trả lời</h5>
                    </div>
                     <div class="col-sm-2">
                        <h5>Ngày tạo</h5>
                    </div>
                     <div class="col-sm-2">
                        <h5>Ngày chỉnh sửa</h5>
                    </div>
                     <div class="col-sm-1">
                        <h5>Hành động</h5>
                    </div>
                   

                </div>
                <hr style="height:1px;border:none;color:#333;background-color:#333;">

                <div class="card py-4">
                    @foreach($questions as $question)
                    <div class="row text-muted ">

                        <div class="col-sm-3">
                            <a target="_blank" href="{{route('viewTopic', ['id' => $question->id])}}" class="text-decoration-none"><p>{{$question->title}}</p></a>
                        </div>
                       
                        <div class="col-sm-1">
                            <p class="badge badge-info" >{{$question->category->name}}</p>
                        </div>
                        <div class="col-sm-1">
                            <p>{{$question->total_like}}</p>
                        </div>
                        <div class="col-sm-1">
                            <p>{{$question->total_dislike}}</p>
                        </div>
                        <div class="col-sm-1">
                            <p>{{$question->total_answer}}</p>
                        </div>
                        <div class="col-sm-2">
                            <p>{{$question->created_at->toDateTimeString()}}</p>
                        </div>
                        <div class="col-sm-2">
                            <p>{{$question->updated_at->toDateTimeString()}}</p>
                        </div>
                        <div class="col-sm-1">
                         
                                <!-- Edit-->
                              
                            
                                <!-- Delete-->
                                <span class="">

                                        <button type="button" href="#myModal" data-toggle="modal" class="btn btn-outline-danger"><i class="fa fa-trash" aria-hidden="true"></i></button>
                                          <div id="myModal" class="modal fade" tabindex="-1">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Xác nhận</h5>
                                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <p>Bạn có chắc muốn xóa bài viết này?</p>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Hủy</button>
                                                                <form action="{{route('adminDeleteTopic')}}" method="post">
                                                                    @csrf
                                                                    <input type="text" name="_id" value="{{$question->_id}}" hidden>
                                                                    <button type="submit" class="btn btn-danger">Xóa</button>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                </span>

                           
                        </div>
                    </div>
                    <hr/>
                    @endforeach
                    <div class="row px-3 pt-3 justify-content-sm-center">{!! $questions->links() !!}</
                </div>

            </div>
            <div class="card-footer text-muted">
                 <hr>
            Showing all questions in <code>Q&A System</code>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
